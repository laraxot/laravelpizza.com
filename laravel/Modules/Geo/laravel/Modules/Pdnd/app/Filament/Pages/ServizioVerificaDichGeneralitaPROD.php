<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Services\Anpr\Services\C003\C003Service;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Common\TipoCodiceFiscale;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Common\TipoGeneralita;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Common\TipoLuogoEvento;
use Modules\Pdnd\Services\Anpr\Services\C030\C030Service;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\PdndClientService;
use Modules\User\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;
use function Safe\preg_replace;

/**
 * @property Schema $pdndForm
 */
class ServizioVerificaDichGeneralitaPROD extends XotBasePage
{

    /** @var array<string, mixed> */
    public array $pdndData = [];

    public string $idAnpr = '';

    public string $risultatoVerifica = '';

    protected string $view = 'pdnd::filament.pages.C003-servizioVerificaDichGeneralita-approvazione_autom';

    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components(
                [
                    Section::make()
                        ->columns(4)
                        ->schema(
                            [
                                TextInput::make('codiceFiscale')
                                    ->required(),
                                TextInput::make('cognome')
                                    ->required(),
                                TextInput::make('nome')
                                    ->required(),
                                TextInput::make('sesso')
                                    ->required(),
                                TextInput::make('dataNascita')
                                    ->required(),
                            ]
                        ),
                    Section::make()
                        ->columns(4)
                        ->schema(
                            [
                                TextInput::make('nomeComune')
                                    ->required(),
                                TextInput::make('codiceIstat')
                                    ->required(),
                                TextInput::make('siglaProvinciaIstat')
                                    ->required(),
                                TextInput::make('descrizioneLocalita')
                                    ->required(),
                            ]
                        ),
                ]
            )
            ->statePath('pdndData');
    }

    public function send(): void
    {
        try {
            $state = $this->pdndForm->getState();

            $c030Service = new C030Service(app()->make(PdndClientService::class, [
                'ambiente' => 'prod',
            ]));

            // dddx($c030Service);
            $cfRaw = $state['codiceFiscale'] ?? '';
            assert(is_string($cfRaw));
            $risultatoC030Service = $c030Service->cercaPerCodiceFiscale($cfRaw);

            // dddx($risultatoC030Service);

            if (isset($risultatoC030Service['successo']) && $risultatoC030Service['successo'] === true) {
                $listaSoggetti = $risultatoC030Service['lista_soggetti'] ?? [];
                $idAnprValue = 'N/A';
                if (is_array($listaSoggetti) && isset($listaSoggetti[0]) && is_array($listaSoggetti[0])) {
                    $idAnprValue = $listaSoggetti[0]['id_anpr'] ?? 'N/A';
                }

                $cleaned = preg_replace('/[^\w\s-]/', '', (string) $idAnprValue);
                $this->idAnpr = $cleaned;

                // dddx($c030Service);

                $c003Service = new C003Service(app()->make(PdndClientService::class, [
                    'servizio' => ServizioAnprEnum::C003,
                    'ambiente' => 'prod',
                ]));

                $generalita = $this->createGeneralitaObject();

                if ($this->idAnpr !== '') {
                    $risultatoC003Service = $c003Service->verificaPerIdAnpr($this->idAnpr, $generalita);

                    // dddx($risultatoC003Service);

                    if (isset($risultatoC003Service['successo']) && $risultatoC003Service['successo'] === true) {
                        $listaSoggettiC003 = $risultatoC003Service['lista_soggetti'] ?? [];
                        $risultatoVerificaValue = 'N/A';
                        if (is_array($listaSoggettiC003) && isset($listaSoggettiC003[0]) && is_array($listaSoggettiC003[0])) {
                            $infoSoggettoEnte = $listaSoggettiC003[0]['info_soggetto_ente'] ?? [];
                            if (is_array($infoSoggettoEnte) && isset($infoSoggettoEnte[0]) && is_array($infoSoggettoEnte[0])) {
                                $valore = $infoSoggettoEnte[0]['valore'] ?? 'N/A';
                                $risultatoVerificaValue = is_object($valore) && isset($valore->value) ? (string) $valore->value : (string) $valore;
                            }
                        }

                        $risultatoVerifica = $risultatoVerificaValue;

                        // Assicurati che sia una stringa semplice
                        $cleaned = preg_replace('/[^\w\s-]/', '', (string) $risultatoVerifica);
                        $this->risultatoVerifica = $cleaned;

                        Notification::make()
                            ->title('Ricerca completata')
                            ->success()
                            ->send();
                    } else {
                        $this->idAnpr = 'Errore nella ricerca';
                    }
                }
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

    private function createGeneralitaObject(): TipoGeneralita
    {
        $luogoNascita = [
            'luogoEccezionale' => '',
            'comune' => [
                'nomeComune' => $this->pdndData['nomeComune'],           // 'Roma'
                'codiceIstat' => $this->pdndData['codiceIstat'],          // 058091
                'siglaProvinciaIstat' => $this->pdndData['siglaProvinciaIstat'],  // 'RM'
                'descrizioneLocalita' => $this->pdndData['descrizioneLocalita'],  // 'Lazio'
            ],
            'localita' => [
                'descrizioneLocalita' => '',
                'descrizioneStato' => '',
                'codiceStato' => '',
                'provinciaContea' => '',
            ],
        ];

        $luogoNascitaObj = TipoLuogoEvento::fromArray($luogoNascita);

        $cfRaw2 = $this->pdndData['codiceFiscale'] ?? '';
        assert(is_string($cfRaw2));
        $codiceFiscaleObj = new TipoCodiceFiscale($cfRaw2);

        $cognomeVal = is_string($this->pdndData['cognome'] ?? null) ? $this->pdndData['cognome'] : null;
        $nomeVal = is_string($this->pdndData['nome'] ?? null) ? $this->pdndData['nome'] : null;
        $sessoVal = is_string($this->pdndData['sesso'] ?? null) ? $this->pdndData['sesso'] : null;
        $dataNascitaVal = is_string($this->pdndData['dataNascita'] ?? null) ? $this->pdndData['dataNascita'] : null;

        return new TipoGeneralita(
            codiceFiscale: $codiceFiscaleObj,
            cognome: $cognomeVal,
            nome: $nomeVal,
            sesso: $sessoVal,
            dataNascita: $dataNascitaVal,
            luogoNascita: $luogoNascitaObj
        );
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
