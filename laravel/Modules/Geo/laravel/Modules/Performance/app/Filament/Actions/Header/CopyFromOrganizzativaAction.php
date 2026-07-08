<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Organizzativa;

/**
 * HeaderAction per copiare i dati da performance_organizzativa a performance_individuale.
 *
 * Scopo: Sincronizzare le schede individuali con i dati organizzativi quando:
 * - Non esiste già una scheda individuale per quel dipendente
 * - Oppure ne esiste una sola (in tal caso la aggiorna)
 *
 * Logica:
 * 1. Recupera tutte le righe di Organizzativa per l'anno selezionato
 * 2. Per ogni riga, cerca corrispondente in Individuale (match su ente, matr, dal, al)
 * 3. Se non esiste → crea nuova scheda individuale
 * 4. Se esiste già (1 record) → aggiorna con dati organizzativa
 * 5. Se ne esistono multiple → errore (non dovrebbe succedere)
 *
 * @see ListIndividuales
 */
class CopyFromOrganizzativaAction extends Action
{
    /**
     * Crea una nuova HeaderAction per copiare dati da Organizzativa.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('performance::organizzativa.actions.copy_from_organizzativa.label'))
            ->tooltip(__('performance::organizzativa.actions.copy_from_organizzativa.tooltip'))
            ->icon('heroicon-o-arrow-down-tray')
            ->requiresConfirmation()
            ->modalHeading(__('performance::organizzativa.actions.copy_from_organizzativa.label'))
            ->modalDescription(__('performance::organizzativa.actions.copy_from_organizzativa.confirm'))
            ->action(static::copyFromOrganizzativa(...))
            ->visible(static::isVisible(...));
    }

    /**
     * Copia i dati da Organizzativa a Individuale per l'anno selezionato.
     *
     * @param  ListRecords  $livewire  Pagina Filament corrente
     * @return int Numero di record creati o aggiornati
     */
    public static function copyFromOrganizzativa(ListRecords $livewire): int
    {
        $tableFilters = is_array($livewire->tableFilters) ? $livewire->tableFilters : [];
        $anno = Arr::get($tableFilters, 'anno.value');

        if ($anno === null || $anno < 2023) {
            Notification::make()
                ->title('Anno non valido')
                ->body('Selezionare un anno >= 2023')
                ->danger()
                ->send();

            return 0;
        }

        $updated = 0;
        $rows = Organizzativa::where('anno', $anno)->get();

        foreach ($rows as $row) {
            $data = $row->toArray();
            $where = Arr::only($data, ['ente', 'matr', 'dal', 'al']);

            $individuali = Individuale::where($where)->get();

            if ($individuali->count() > 1) {
                // Multiple records found - this shouldn't happen
                continue;
            }

            if ($individuali->count() === 0) {
                // Create new individuale record
                /** @var array<string, mixed> $data */
                Individuale::create($data);
                $updated++;
            }

            if ($individuali->count() === 1) {
                // Update existing individuale record
                /** @var array<string, mixed> $data */
                $individuali->first()?->update($data);
                $updated++;
            }
        }

        Notification::make()
            ->title('Operazione completata')
            ->body(__(':count record elaborati', ['count' => $updated]))
            ->success()
            ->send();

        return $updated;
    }

    /**
     * Determina se l'azione deve essere visibile.
     *
     * Determina visibilità basata sui permessi dell'utente.
     */
    public function isVisible(): bool
    {
        // Visible solo per utenti autorizzati
        return Auth::user()?->isSuperAdmin() ?? false;
    }

    /**
     * ---.
     */
    public static function getDefaultName(): ?string
    {
        return 'CopyFromOrganizzativa';
    }

}
