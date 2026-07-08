<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Services\Anpr\Services\C007\C007Service;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\PdndClientService;
use Modules\Xot\Filament\Pages\XotBasePage;
use Throwable;

/**
 * @property Schema $pdndForm
 */
class ServizioVerificaDichEsistenzaVitaPROD extends XotBasePage
{

    /** @var array<string, mixed> */
    public array $pdndData = [];

    public string $idAnpr = '';

    public string $risultatoVerifica = '';

    protected string $view = 'pdnd::filament.pages.C007-servizioVerificaDichEsistenzaVita-approvazione_autom';

    /**
     * Pattern regex per validazione codice fiscale italiano.
     */
    private const CODICE_FISCALE_REGEX = '/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/';

    /**
     * Lunghezza standard del codice fiscale italiano.
     */
    private const CODICE_FISCALE_LENGTH = 16;

    /**
     * Ambiente ANPR da utilizzare.
     */
    private const AMBIENTE_ANPR = 'prod';

    /**
     * Costruisce lo schema del form per l'inserimento del codice fiscale.
     */
    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codiceFiscale')
                    ->regex(self::CODICE_FISCALE_REGEX)
                    ->maxLength(self::CODICE_FISCALE_LENGTH)
                    ->minLength(self::CODICE_FISCALE_LENGTH)
                    ->rule('size:'.self::CODICE_FISCALE_LENGTH)
                    ->autocapitalize()
                    ->alphaNum()
                    ->validationMessages([
                        'regex' => 'Il codice fiscale non è valido. Formato atteso: 6 lettere, 2 numeri, 1 lettera, 2 numeri, 1 lettera, 3 numeri, 1 lettera.',
                        'size' => 'Il codice fiscale deve essere lungo esattamente 16 caratteri.',
                    ])
                    ->required()
                    ->helperText('Inserire un codice fiscale italiano valido (16 caratteri)'),
            ])
            ->statePath('pdndData');
    }

    /**
     * Gestisce l'invio del form ed esegue la verifica dell'esistenza in vita.
     */
    public function send(): void
    {
        $this->resetRisultato();
        $this->validate();

        try {
            $state = $this->pdndForm->getState();

            $codiceFiscale = $this->validateCodiceFiscale($state);

            $risultatoC007Service = $this->verificaEsistenzaInVita($codiceFiscale);

            if ($this->isVerificaSuccessful($risultatoC007Service)) {
                $this->handleVerificaSuccessful($risultatoC007Service);
            } else {
                $this->handleVerificaFailed($risultatoC007Service);
            }
        } catch (Exception $e) {
            Log::error('Errore in send(): '.$e->getMessage());
            Notification::make()
                ->title('Errore imprevisto')
                ->danger()
                ->persistent()
                ->send();
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

    /**
     * Crea un'istanza del servizio C007 configurato per l'ambiente di produzione.
     */
    private function createC007Service(): C007Service
    {
        $pdndClient = app()->make(PdndClientService::class, [
            'servizio' => ServizioAnprEnum::C007,
            'ambiente' => self::AMBIENTE_ANPR,
        ]);

        return new C007Service($pdndClient);
    }

    /**
     * Verifica l'esistenza in vita tramite il servizio C007.
     */
    private function verificaEsistenzaInVita(string $codiceFiscale): array
    {
        try {
            $c007Service = $this->createC007Service();

            $risultato = $c007Service->cercaPerCodiceFiscale($codiceFiscale);
            
            return $risultato;
        } catch (Throwable $e) {
            Log::error('Errore nel servizio C007', [
                'codice_fiscale' => $codiceFiscale,
                'ambiente' => self::AMBIENTE_ANPR,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Verifica se la risposta del servizio C007 indica un successo.
     */
    private function isVerificaSuccessful(array $risultato): bool
    {
        // dd($risultato);
        return isset($risultato['successo']) && $risultato['successo'] === true;
    }

    /**
     * Gestisce il caso di verifica completata con successo.
     */
    private function handleVerificaSuccessful(array $risultatoC007Service): void
    {
        $risultatoVerificaValue = 'N/A';
        $listaSoggetti = $risultatoC007Service['lista_soggetti'] ?? [];
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

        if ($risultatoVerificaValue === 'S') {
            $this->risultatoVerifica = 'S';
            $this->notifySuccess();
        } elseif ($risultatoVerificaValue === 'N') {
            $this->risultatoVerifica = 'N';
            $this->notifySuccess();
        } else {
            $this->risultatoVerifica = 'N/A';
        }
    }

    /**
     * Gestisce il caso di verifica fallita.
     */
    private function handleVerificaFailed(array $risultatoC007Service): void
    {
        $errorMessage = $this->formatErrorBody($risultatoC007Service);

        $this->notifyError('Errore nella ricerca', $errorMessage);
    }

    /**
     * Invia una notifica di successo.
     */
    private function notifySuccess(): void
    {
        Notification::make()
            ->title('Ricerca completata')
            ->body('La verifica dell\'esistenza in vita è stata completata con successo.')
            ->success()
            ->send();
    }

    /**
     * Invia una notifica di errore.
     */
    private function notifyError(string $title, string $body): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->danger()
            ->persistent()
            ->send();
    }

    /**
     * Resetta il risultato della verifica.
     */
    private function resetRisultato(): void
    {
        $this->risultatoVerifica = '';
    }

    /**
     * Estrae e valida il codice fiscale dallo state del form.
     */
    private function validateCodiceFiscale(array $state): string
    {
        $codiceFiscale = $state['codiceFiscale'] ?? '';

        if (! is_string($codiceFiscale)) {
            throw new Exception('Codice fiscale non valido: deve essere una stringa');
        }

        if (empty($codiceFiscale)) {
            throw new Exception('Codice fiscale obbligatorio');
        }

        return strtoupper(trim($codiceFiscale));
    }

    protected function formatErrorBody(array $risultatoC007Service): string
    {
        $errori = $risultatoC007Service['errori'] ?? [];
        if (! is_array($errori)) {
            return 'Errore sconosciuto';
        }

        $filteredErrors = array_filter($errori, static function ($error) {
            return is_array($error) && isset($error['tipoErroreAnomalia']) && $error['tipoErroreAnomalia'] === 'E';
        });

        $errorLines = array_map(static function (array $error) {
            return sprintf(
                'Codice errore: %s, Tipo errore: %s, Messaggio: %s',
                (string) ($error['codiceErroreAnomalia'] ?? 'N/A'),
                (string) $error['tipoErroreAnomalia'],
                (string) ($error['testoErroreAnomalia'] ?? 'N/A')
            );
        }, $filteredErrors);

        return implode("\n", $errorLines);
    }
}
