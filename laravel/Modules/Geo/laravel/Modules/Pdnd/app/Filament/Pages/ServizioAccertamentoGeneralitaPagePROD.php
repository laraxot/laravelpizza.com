<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Services\Anpr\Services\C015\C015Service;
use Modules\Pdnd\Services\Anpr\Services\C030\C030Service;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\PdndClientService;
use Modules\Xot\Filament\Pages\XotBasePage;
use Throwable;

/**
 * @property Schema $pdndForm
 */
class ServizioAccertamentoGeneralitaPagePROD extends XotBasePage
{
    /** @var array<string, mixed> */
    public array $pdndData = [];

    public string $idAnpr = '';
    public array $datiCittadino = [];
    public bool $esitoPositivo = false;

    public string $erroreMessaggio = '';
    public string $messaggioInfo = '';

    protected string $view = 'pdnd::filament.pages.C015-servizioAccertamentoGeneralita-approvazione_autom';

    private const CODICE_FISCALE_REGEX = '/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/';
    private const CODICE_FISCALE_LENGTH = 16;
    private const AMBIENTE_ANPR = 'prod';

    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codiceFiscale')
                    ->regex(self::CODICE_FISCALE_REGEX)
                    ->maxLength(self::CODICE_FISCALE_LENGTH)
                    ->minLength(self::CODICE_FISCALE_LENGTH)
                    ->rule('size:' . self::CODICE_FISCALE_LENGTH)
                    ->autocapitalize()
                    ->alphaNum()
                    ->required()
                    ->helperText('Inserire un codice fiscale italiano valido (16 caratteri)'),
            ])
            ->statePath('pdndData');
    }


public function send(): void
{
    $this->resetRisultato();
    $this->validate();

    try {
        $state = $this->pdndForm->getState();
        $codiceFiscale = $this->validateCodiceFiscale($state);

        $risultato = $this->accertamentoGeneralita($codiceFiscale);

        if (!empty($this->messaggioInfo)) {
            // Caso "Cittadino non trovato"
            Notification::make()
                ->title('Cittadino non trovato')
                ->body($this->messaggioInfo)
                ->warning()
                ->persistent()
                ->send();
            return;
        }

        if ($this->isAccertamentoSuccessful($risultato)) {
            $this->handleAccertamentoSuccessful($risultato);
        } else {
            $this->handleAccertamentoFailed($risultato);
        }
    } catch (Exception $e) {
        $this->erroreMessaggio = $e->getMessage();

        $this->notifyError('Errore durante l\'accertamento', $e->getMessage());
    }
}


    // ====================== FLUSSO C030 → C015 ======================
private function accertamentoGeneralita(string $codiceFiscale): array
{

    $idAnpr = $this->recuperaIdAnprDaC030($codiceFiscale);

    if (!empty($this->messaggioInfo)) {
        return ['successo' => false];   // forza fallimento pulito
    }

    if (empty($idAnpr)) {
        throw new Exception('Impossibile ottenere ID ANPR tramite C030');
    }

    $this->idAnpr = $idAnpr;

    $c015Service = $this->createC015Service();
    return $c015Service->accertamentoPerIdAnpr($idAnpr);
}


private function recuperaIdAnprDaC030(string $codiceFiscale): ?string
{
    $c030Service = new C030Service(app()->make(PdndClientService::class, [
        'servizio' => ServizioAnprEnum::C030,
        'ambiente' => self::AMBIENTE_ANPR,
    ]));

    $risultato = $c030Service->cercaPerCodiceFiscale($codiceFiscale);

    // Cittadino non registrato in ANPR
    $errori = $risultato['errori'] ?? null;
    if (is_array($errori)) {
        foreach ($errori as $err) {
            if (! is_array($err)) {
                continue;
            }

            $codiceErrore = $err['codiceErroreAnomalia'] ?? '';
            if (is_string($codiceErrore) && $codiceErrore === 'EN122') {
                $this->messaggioInfo = 'Il codice fiscale inserito non risulta registrato in ANPR.';
                return null;
            }
        }
    }

    // Altri errori reali di C030
    if (empty($risultato['successo']) || $risultato['successo'] !== true) {
        throw new Exception('Errore di sistema durante la ricerca su C030');
    }

    return $this->extractIdAnprFromC030Risultato($risultato);
}

private function extractIdAnprFromC030Risultato(array $risultato): ?string
{
    $listaSoggetti = $risultato['lista_soggetti'] ?? null;
    if (! is_array($listaSoggetti) || ! isset($listaSoggetti[0]) || ! is_array($listaSoggetti[0])) {
        return null;
    }

    $primoSoggetto = $listaSoggetti[0];
    $identificativi = $primoSoggetto['identificativi'] ?? null;
    if (is_array($identificativi)) {
        $idAnpr = $identificativi['idANPR'] ?? null;
        if (is_string($idAnpr) && $idAnpr !== '') {
            return $idAnpr;
        }
    }

    $idAnprDiretto = $primoSoggetto['idANPR'] ?? $primoSoggetto['id_anpr'] ?? null;

    return is_string($idAnprDiretto) && $idAnprDiretto !== '' ? $idAnprDiretto : null;
}


    private function createC015Service(): C015Service
    {
        $pdndClient = app()->make(PdndClientService::class, [
            'servizio' => ServizioAnprEnum::C015,
            'ambiente' => self::AMBIENTE_ANPR,
        ]);
        return new C015Service($pdndClient);
    }

    // ====================== METODI DI SUPPORTO ======================
    private function isAccertamentoSuccessful(array $risultato): bool
    {
        return isset($risultato['successo']) && $risultato['successo'] === true;
    }

    private function handleAccertamentoSuccessful(array $risultato): void
    {
        $listaSoggetti = $risultato['lista_soggetti'] ?? [];

        if (! is_array($listaSoggetti) || $listaSoggetti === []) {
            $this->esitoPositivo = false;
            $this->notifyWarning('Nessun soggetto trovato');
            return;
        }

        $primoSoggetto = $listaSoggetti[0];
        if (! is_array($primoSoggetto)) {
            $this->esitoPositivo = false;
            $this->notifyWarning('Nessun soggetto trovato');
            return;
        }

        $this->datiCittadino = [
            'generalita'     => is_array($primoSoggetto['generalita'] ?? null) ? $primoSoggetto['generalita'] : [],
            'stato_civile'   => is_array($primoSoggetto['stato_civile'] ?? null) ? $primoSoggetto['stato_civile'] : [],
            'identificativi' => is_array($primoSoggetto['identificativi'] ?? null) ? $primoSoggetto['identificativi'] : [],
            'info_ente'      => is_array($primoSoggetto['info_soggetto_ente'] ?? null) ? $primoSoggetto['info_soggetto_ente'] : [],
        ];

        $this->esitoPositivo = true;
        $this->notifySuccess();
    }


    private function handleAccertamentoFailed(array $risultato): void
{
    $messaggio = $this->formatErrorBody($risultato);

    $this->erroreMessaggio = $messaggio;
    $this->messaggioInfo   = '';

    $this->notifyError('Errore durante l\'accertamento', $messaggio);
}

    private function notifySuccess(): void
    {
        Notification::make()
            ->title('Accertamento completato')
            ->body('I dati di generalità del cittadino sono stati recuperati.')
            ->success()
            ->send();
    }

    private function notifyWarning(string $message): void
    {
        Notification::make()->title('Attenzione')->body($message)->warning()->send();
    }

    private function notifyError(string $title, string $body): void
    {
        Notification::make()->title($title)->body($body)->danger()->persistent()->send();
    }

    private function resetRisultato(): void
    {
        $this->idAnpr = '';
        $this->datiCittadino = [];
        $this->esitoPositivo = false;
        $this->erroreMessaggio = '';
        $this->messaggioInfo = '';
    }

    private function validateCodiceFiscale(array $state): string
    {
        $cf = $state['codiceFiscale'] ?? '';
        if (!is_string($cf) || empty($cf)) {
            throw new Exception('Codice fiscale obbligatorio');
        }
        return strtoupper(trim($cf));
    }

    protected function formatErrorBody(array $risultato): string
    {
        $errori = $risultato['errori'] ?? [];
        if (! is_array($errori) || $errori === []) {
            return 'Errore sconosciuto';
        }

        $lines = [];
        foreach ($errori as $errore) {
            if (! is_array($errore)) {
                continue;
            }

            $lines[] = sprintf(
                'Codice: %s | Messaggio: %s',
                (string) ($errore['codiceErroreAnomalia'] ?? 'N/A'),
                (string) ($errore['testoErroreAnomalia'] ?? 'N/A')
            );
        }

        return $lines === [] ? 'Errore sconosciuto' : implode("\n", $lines);
    }

    protected function getForms(): array { return ['pdndForm']; }

    protected function getPdndFormActions(): array
    {
        return [Action::make('pdndFormActions')->submit('pdndFormActions')];
    }
}