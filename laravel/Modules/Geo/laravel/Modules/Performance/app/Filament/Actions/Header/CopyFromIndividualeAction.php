<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Performance\Filament\Resources\OrganizzativaResource\Pages\ListOrganizzativas;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Organizzativa;

/**
 * HeaderAction per copiare i dati da performance_individuale a performance_organizzativa.
 *
 * Scopo: sincronizzare le schede organizzative con i dati individuali quando:
 * - non esiste già una scheda organizzativa per quel dipendente
 * - oppure ne esiste una sola, e quindi viene aggiornata
 *
 * Logica:
 * 1. Recupera tutte le righe di Individuale per l'anno selezionato
 * 2. Per ogni riga, cerca la corrispondente in Organizzativa tramite ente, matr, dal, al
 * 3. Se non esiste, crea una nuova scheda organizzativa
 * 4. Se esiste una sola scheda, la aggiorna
 * 5. Se ne esistono multiple, salta la riga
 *
 * @see ListOrganizzativas
 */
class CopyFromIndividualeAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('performance::individuale.actions.copy_from_individuale.label'))
            ->tooltip(__('performance::individuale.actions.copy_from_individuale.tooltip'))
            ->icon('heroicon-o-arrow-path')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading(__('performance::individuale.actions.copy_from_individuale.label'))
            ->modalDescription(__('performance::individuale.actions.copy_from_individuale.confirm'))
            ->action(static::copyFromIndividuale(...))
            ->visible(fn (): bool => $this->isVisible());
    }

    /**
     * Copia i dati da Individuale a Organizzativa per l'anno selezionato.
     */
    public static function copyFromIndividuale(ListRecords $livewire): int
    {
        $tableFilters = is_array($livewire->tableFilters) ? $livewire->tableFilters : [];
        $anno = Arr::get($tableFilters, 'anno.value');

        if (! is_numeric($anno) || (int) $anno < 2023) {
            Notification::make()
                ->title('Anno non valido')
                ->body('Selezionare un anno >= 2023')
                ->danger()
                ->send();

            return 0;
        }

        $updated = 0;
        $rows = Individuale::query()
            ->where('anno', (int) $anno)
            ->get();

        foreach ($rows as $row) {
            $data = $row->toArray();
            $where = Arr::only($data, ['ente', 'matr', 'dal', 'al']);

            $organizzative = Organizzativa::query()
                ->where($where)
                ->get();

            if ($organizzative->count() > 1) {
                continue;
            }

            if ($organizzative->count() === 0) {
                /** @var array<string, mixed> $data */
                Organizzativa::create($data);
                $updated++;

                continue;
            }

            /** @var array<string, mixed> $data */
            $organizzative->first()?->update($data);
            $updated++;
        }

        Notification::make()
            ->title('Operazione completata')
            ->body(__(':count record elaborati', ['count' => $updated]))
            ->success()
            ->send();

        return $updated;
    }

    public function isVisible(): bool
    {
        return Auth::user()?->isSuperAdmin() ?? false;
    }

    public static function getDefaultName(): ?string
    {
        return 'CopyFromIndividuale';
    }
}
