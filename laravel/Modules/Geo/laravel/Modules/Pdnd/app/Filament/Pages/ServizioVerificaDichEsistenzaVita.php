<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Services\Anpr\Services\C007\C007Service;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\PdndClientService;
use Modules\User\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;

use function Safe\preg_replace;

/**
 * @property Schema $pdndForm
 */
class ServizioVerificaDichEsistenzaVita extends XotBasePage
{

    /** @var array<string, mixed> */
    public array $pdndData = [];

    public string $idAnpr = '';

    public string $risultatoVerifica = '';

    protected string $view = 'pdnd::filament.pages.C007-servizioVerificaDichEsistenzaVita-approvazione_autom';

    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codiceFiscale')
                    ->required(),
            ])
            ->statePath('pdndData');
    }

    public function send(): void
    {
        try {
            $state = $this->pdndForm->getState();

            dddx('La finalità di questo e-service non è ancora stata approvata in ambiente di TEST.');

            // PROD
            $c007Service = new C007Service(app()->make(PdndClientService::class, [
                'servizio' => ServizioAnprEnum::C007,
            ]));

            // dddx($c007Service);

            $cfRaw = $state['codiceFiscale'] ?? '';
            assert(is_string($cfRaw));
            $risultatoC007Service = $c007Service->cercaPerCodiceFiscale($cfRaw);

            // dddx($risultatoC030Service);

            // Soluzione drastica: NON salvare il risultato come proprietà Livewire
            // Estrarre solo i dati necessari come stringhe semplici

            if (isset($risultatoC007Service['successo']) && $risultatoC007Service['successo']) {
                $listaSoggetti = $risultatoC007Service['lista_soggetti'] ?? [];
                $risultatoVerificaValue = 'N/A';
                if (is_array($listaSoggetti) && isset($listaSoggetti[0])) {
                    $primoSoggetto = $listaSoggetti[0];
                    if (is_array($primoSoggetto)) {
                        $infoSoggettoEnte = $primoSoggetto['info_soggetto_ente'] ?? [];
                        if (is_array($infoSoggettoEnte) && isset($infoSoggettoEnte[0])) {
                            $info = $infoSoggettoEnte[0];
                            if (is_array($info)) {
                                $valore = $info['valore'] ?? null;
                                if (is_object($valore) && isset($valore->value)) {
                                    $risultatoVerificaValue = (string) $valore->value;
                                } elseif (is_scalar($valore)) {
                                    $risultatoVerificaValue = (string) $valore;
                                }
                            }
                        }
                    }
                }

                // Assicurati che sia una stringa semplice
                $cleaned = preg_replace('/[^\w\s-]/', '', (string) $risultatoVerificaValue);
                $this->risultatoVerifica = $cleaned;

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
