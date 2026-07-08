<?php

declare(strict_types=1);

/**
 * This is the module namespace. It can be different from the application namespace.
use Modules\User\Models\User;
 */

namespace Modules\Pdnd\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Services\Anpr\Services\C030\C030Service;
use Modules\Pdnd\Services\PdndClientService;
use Modules\User\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;
use function Safe\preg_replace;

/**
 * Class ServizioAccertamentoIdUnicoNazionalePagePROD.
 *
 * @property Schema $pdndForm
 */
class ServizioAccertamentoIdUnicoNazionalePagePROD extends XotBasePage
{

    /** @var array<string, mixed> */
    public array $pdndData = [];

    public string $idAnpr = '';

    protected string $view = 'pdnd::filament.pages.C030-servizioAccertamentoIdUnicoNazionale-approvazione_autom';

    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codiceFiscale')
                    ->required(),
            ])
            ->statePath('pdndData');
    }

    /**
     * @throws Exception
     */
    public function send(): void
    {
        try {
            $state = $this->pdndForm->getState();

            // PROD
            $c030Service = new C030Service(app()->make(PdndClientService::class, [
                'ambiente' => 'prod',
            ]));

            // dddx($c030Service);

            $cfRaw = $state['codiceFiscale'] ?? '';
            assert(is_string($cfRaw));
            $risultatoC030Service = $c030Service->cercaPerCodiceFiscale($cfRaw);

            // dddx($risultatoC030Service);

            // Soluzione drastica: NON salvare il risultato come proprietà Livewire
            // Estrarre solo i dati necessari come stringhe semplici

            if (isset($risultatoC030Service['successo']) && $risultatoC030Service['successo']) {
                $listaSoggetti = $risultatoC030Service['lista_soggetti'] ?? [];
                $idAnprValue = 'N/A';
                if (is_array($listaSoggetti) && isset($listaSoggetti[0])) {
                    $primoSoggetto = $listaSoggetti[0];
                    if (is_array($primoSoggetto)) {
                        $idAnprValue = $primoSoggetto['id_anpr'] ?? 'N/A';
                    }
                }

                // Assicurati che sia una stringa semplice
                $cleanedValue = preg_replace('/[^\w\s-]/', '', (string) $idAnprValue);
                $this->idAnpr = $cleanedValue;

                Notification::make()
                    ->title('Ricerca completata')
                    ->success()
                    ->send();
            } else {
                $this->idAnpr = 'Errore nella ricerca';
            }
        } catch (Exception $e) {
            Log::error('Errore in send(): '.$e->getMessage());
            $this->idAnpr = 'Errore imprevisto';
        }
    }

    protected function getForms(): array
    {
        return [
            'pdndForm',
        ];
    }

    protected function getPdndFormActions(): array
    {
        return [
            Action::make('pdndFormActions')
                ->submit('pdndFormActions'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            return false;
        }

        return $user->hasRole('super-admin');
    }
}
