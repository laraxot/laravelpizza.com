<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C003;

use Exception;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Common\TipoGeneralita;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Request\RichiestaE002;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Request\TipoCriteriRicercaE002;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Request\TipoDatiRichiestaE002;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Request\TipoVerificaE002;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Response\RispostaE002OK;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Response\RispostaKO;
use Modules\Pdnd\Services\Anpr\Services\C003\Models\Response\TipoListaSoggetti;
use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoDatiNascitaE000;
use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasPdndClient;
use Modules\Pdnd\Services\PdndClientService;

use function Safe\json_decode;

class C003Service
{
    use HasPdndClient;

    public function __construct(
        PdndClientService $pdndClient
    ) {
        $this->pdndClient = $pdndClient;
    }

    /**
     * Endpoint principale E002 - Verifica dichiarazione generalità
     * Implementa: POST /anpr-service-e002
     */
    public function verificaDichiarazioneE002(RichiestaE002 $richiesta): array
    {
        try {
            $response = $this->pdndClient->callApiService($richiesta->toArray());

            // dddx($response);

            return $this->processE002Response($response, $richiesta);
        } catch (Exception $e) {
            return [
                'successo' => false,
                'errore' => $e->getMessage(),
                'richiesta' => $richiesta->toArray(),
                'debug_log' => $this->pdndClient->getDebugLog(),
                'timestamp' => now()->toISOString(),
            ];
        }
    }

    /**
     * Verifica per codice fiscale - metodo di convenienza
     */
    public function verificaPerCodiceFiscale(
        string $cf,
        ?TipoGeneralita $generalitaDaVerificare = null,
        ?string $motivoRichiesta = null
    ): array {
        $richiesta = RichiestaE002::perCodiceFiscale(
            codiceFiscale: $cf,
            generalitaDaVerificare: $generalitaDaVerificare,
            motivoRichiesta: $motivoRichiesta ?? 'Verifica dichiarazione generalità',
            dataRiferimento: now()->format('Y-m-d')
        );

        return $this->verificaDichiarazioneE002($richiesta);
    }

    /**
     * Verifica per ID ANPR
     */
    public function verificaPerIdAnpr(
        string $idAnpr,
        ?TipoGeneralita $generalitaDaVerificare = null,
        ?string $motivoRichiesta = null
    ): array {
        $criteriRicerca = new TipoCriteriRicercaE002(idANPR: $idAnpr);

        $verifica = null;
        if ($generalitaDaVerificare) {
            $verifica = new TipoVerificaE002(generalita: $generalitaDaVerificare);
        }

        $richiesta = new RichiestaE002(
            idOperazioneClient: $this->generateOperationId(),
            criteriRicerca: $criteriRicerca,
            verifica: $verifica,
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: now()->format('Y-m-d'),
                casoUso: 'C003',
                motivoRichiesta: $motivoRichiesta ?? 'Verifica per ID ANPR'
            )
        );

        // dddx($richiesta);

        return $this->verificaDichiarazioneE002($richiesta);
    }

    /**
     * Verifica con dati anagrafici completi
     */
    public function verificaPerDatiAnagrafici(
        array $datiPersona,
        ?TipoGeneralita $generalitaDaVerificare = null
    ): array {
        $criteriRicerca = TipoCriteriRicercaE002::fromArray($datiPersona);

        $verifica = null;
        if ($generalitaDaVerificare) {
            $verifica = new TipoVerificaE002(generalita: $generalitaDaVerificare);
        }

        $richiesta = new RichiestaE002(
            idOperazioneClient: $this->generateOperationId(),
            criteriRicerca: $criteriRicerca,
            verifica: $verifica,
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: now()->format('Y-m-d'),
                casoUso: 'C003',
                motivoRichiesta: (string) ($datiPersona['motivo_richiesta'] ?? 'Verifica dichiarazione generalità')
            )
        );

        return $this->verificaDichiarazioneE002($richiesta);
    }

    /**
     * Verifica con criteri di ricerca avanzati
     */
    public function verificaConCriteriAvanzati(
        ?string $codiceFiscale = null,
        ?string $idAnpr = null,
        ?string $cognome = null,
        ?string $nome = null,
        ?string $sesso = null,
        ?TipoDatiNascitaE000 $datiNascita = null,
        ?TipoGeneralita $generalitaDaVerificare = null,
        ?string $motivoRichiesta = null
    ): array {
        $criteriRicerca = new TipoCriteriRicercaE002(
            codiceFiscale: $codiceFiscale,
            idANPR: $idAnpr,
            cognome: $cognome,
            nome: $nome,
            sesso: $sesso,
            datiNascita: $datiNascita
        );

        $verifica = null;
        if ($generalitaDaVerificare) {
            $verifica = new TipoVerificaE002(generalita: $generalitaDaVerificare);
        }

        $richiesta = new RichiestaE002(
            idOperazioneClient: $this->generateOperationId(),
            criteriRicerca: $criteriRicerca,
            verifica: $verifica,
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: now()->format('Y-m-d'),
                casoUso: 'C003',
                motivoRichiesta: $motivoRichiesta ?? 'Verifica avanzata dichiarazione'
            )
        );

        return $this->verificaDichiarazioneE002($richiesta);
    }

    /**
     * Verifica dichiarazione completa di generalità
     */
    public function verificaDichiarazioneCompleta(
        string $codiceFiscale,
        string $cognome,
        string $nome,
        string $sesso,
        string $dataNascita,
        array $luogoNascita = [],
        ?string $motivoRichiesta = null
    ): array {
        // Crea la generalità da verificare
        $generalita = TipoGeneralita::createFromBasicData(
            codiceFiscale: $codiceFiscale,
            cognome: $cognome,
            nome: $nome,
            sesso: $sesso,
            dataNascita: $dataNascita,
            luogoNascita: $luogoNascita
        );

        return $this->verificaPerCodiceFiscale(
            $codiceFiscale,
            $generalita,
            $motivoRichiesta ?? 'Verifica dichiarazione completa'
        );
    }

    /**
     * Test di stato del servizio
     * Implementa: GET /status
     */
    public function getStatus(): array
    {
        try {
            $response = $this->pdndClient->callApi([], 'status');

            return [
                'servizio' => 'C003',
                'stato' => 'attivo',
                'response' => $response,
                'timestamp' => now()->toISOString(),
            ];
        } catch (Exception $e) {
            return [
                'servizio' => 'C003',
                'stato' => 'errore',
                'errore' => $e->getMessage(),
                'timestamp' => now()->toISOString(),
            ];
        }
    }

    /**
     * Processa la risposta E002 secondo la specifica OpenAPI.
     *
     * @param  array  $response
     * @return array<string, mixed>
     */
    private function processE002Response(array $response, RichiestaE002 $richiesta): array
    {
        $bodyRaw = $response['body'] ?? '{}';
        assert(is_string($bodyRaw));
        /** @var array<string, mixed> $responseArray */
        $responseArray = json_decode($bodyRaw, true);

        if ($this->isSuccessResponse($responseArray)) {
            return $this->processSuccessResponse($responseArray, $richiesta);
        }

        return $this->processErrorResponse($responseArray, $richiesta);
    }

    /**
     * Processa risposta di successo (RispostaE002OK)
     *
     * @return array<string, mixed>
     */
    private function processSuccessResponse(array $response, RichiestaE002 $richiesta): array
    {
        $rispostaOK = RispostaE002OK::fromArray($response);

        return [
            'successo' => true,
            'id_operazione_anpr' => $rispostaOK->idOperazioneANPR,
            'lista_soggetti' => $this->extractSoggettiData($rispostaOK->listaSoggetti),
            'risultato_verifica' => $this->extractVerificationResult($rispostaOK->listaSoggetti),
            'anomalie' => $this->extractAnomalieData($rispostaOK->listaAnomalie ?? []),
            'richiesta_originale' => $richiesta->toArray(),
            'raw_response' => $response,
            'debug_log' => $this->pdndClient->getDebugLog(),
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * Processa risposta di errore (RispostaKO)
     *
     * @return array<string, mixed>
     */
    private function processErrorResponse(array $response, RichiestaE002 $richiesta): array
    {
        $rispostaKO = RispostaKO::fromArray($response);

        return [
            'successo' => false,
            'id_operazione_anpr' => $rispostaKO->idOperazioneANPR ?? null,
            'errori' => $this->extractErroriData($rispostaKO->listaErrori ?? []),
            'richiesta_originale' => $richiesta->toArray(),
            'raw_response' => $response,
            'debug_log' => $this->pdndClient->getDebugLog(),
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * Determina se la risposta è di successo
     */
    private function isSuccessResponse(array $response): bool
    {
        if (isset($response['listaSoggetti'])) {
            return true;
        }

        if (isset($response['listaErrori']) && ! empty($response['listaErrori'])) {
            return false;
        }

        return isset($response['idOperazioneANPR']) && ! isset($response['error']);
    }

    /**
     * Estrae i dati dei soggetti dalla risposta
     *
     * @return array<int, array<string, mixed>>
     */
    private function extractSoggettiData(?TipoListaSoggetti $listaSoggetti): array
    {
        if (! $listaSoggetti || ! isset($listaSoggetti->datiSoggetto)) {
            return [];
        }

        $soggetti = [];
        foreach ($listaSoggetti->datiSoggetto as $soggetto) {
            $soggetti[] = [
                'info_soggetto_ente' => $this->extractInfoSoggettoEnte($soggetto->infoSoggettoEnte ?? []),
                'dati_completi' => (array) $soggetto,
            ];
        }

        return $soggetti;
    }

    /**
     * Estrae le informazioni del soggetto ente
     */
    private function extractInfoSoggettoEnte(array $infoSoggettoEnte): array
    {
        $info = [];

        foreach ($infoSoggettoEnte as $item) {
            /** @var \Modules\Pdnd\Services\Anpr\Services\C003\Models\Response\TipoInfoSoggettoEnte $item */
            $info[] = [
                'id' => $item->id ?? null,
                'chiave' => $item->chiave ?? null,
                'valore' => $item->valore ?? null,
                'valore_testo' => $item->valoreTesto ?? null,
                'valore_data' => $item->valoreData ?? null,
                'dettaglio' => $item->dettaglio ?? null,
            ];
        }

        return $info;
    }

    /**
     * Estrae il risultato della verifica
     *
     * @return array<string, mixed>
     */
    private function extractVerificationResult(?TipoListaSoggetti $listaSoggetti): array
    {
        if (! $listaSoggetti || ! isset($listaSoggetti->datiSoggetto)) {
            return [
                'verifica_superata' => false,
                'motivo' => 'Nessun soggetto trovato',
            ];
        }

        // Analizza i dati per determinare l'esito della verifica
        $soggettiTrovati = count($listaSoggetti->datiSoggetto);

        if ($soggettiTrovati === 0) {
            return [
                'verifica_superata' => false,
                'motivo' => 'Nessun soggetto corrispondente trovato',
            ];
        }

        if ($soggettiTrovati === 1) {
            return [
                'verifica_superata' => true,
                'motivo' => 'Soggetto univoco trovato e verificato',
                'soggetti_trovati' => $soggettiTrovati,
            ];
        }

        return [
            'verifica_superata' => false,
            'motivo' => 'Trovati multipli soggetti corrispondenti',
            'soggetti_trovati' => $soggettiTrovati,
        ];
    }

    /**
     * Estrae i dati delle anomalie
     */
    private function extractAnomalieData(array $listaAnomalie): array
    {
        return array_map(static fn ($anomalia) => TipoErroriAnomalia::fromArray((array) $anomalia)->toArray(), $listaAnomalie);
    }

    /**
     * Estrae i dati degli errori
     */
    private function extractErroriData(array $listaErrori): array
    {
        return array_map(static fn ($errore) => TipoErroriAnomalia::fromArray((array) $errore)->toArray(), $listaErrori);
    }

    /**
     * Genera ID operazione client univoco
     */
    private function generateOperationId(): string
    {
        return 'C003_'.now()->format('YmdHis').'_'.substr(uniqid(), -6);
    }

    /**
     * Factory method per creare richiesta rapida di verifica
     */
    public static function creaRichiestaVerificaRapida(
        string $codiceFiscale,
        TipoGeneralita $generalita,
        string $motivoRichiesta = 'Verifica dichiarazione standard'
    ): RichiestaE002 {
        return RichiestaE002::perCodiceFiscale(
            codiceFiscale: $codiceFiscale,
            generalitaDaVerificare: $generalita,
            motivoRichiesta: $motivoRichiesta,
            dataRiferimento: now()->format('Y-m-d')
        );
    }

    /**
     * Ottieni statistiche del servizio
     */
    public function getStatistiche(): array
    {
        return [
            'servizio' => 'C003',
            'nome_completo' => 'Servizio Verifica Dichiarazione Generalità',
            'versione_api' => '1.0.0',
            'endpoint_base' => '/anpr-service-e002',
            'endpoint_status' => '/status',
            'ultimo_utilizzo' => now()->toISOString(),
            'debug_disponibile' => true,
            'supporta_verifica_generalita' => true,
        ];
    }

    /**
     * Test di connettività completo
     */
    public function testConnettivita(): array
    {
        $risultati = [];

        // Test status endpoint
        $risultati['status'] = $this->getStatus();

        // Test con dati di prova (se abilitato)
        try {
            $testCf = 'RSSMRA80A01H501Z';
            $testGeneralita = TipoGeneralita::createFromBasicData(
                codiceFiscale: $testCf,
                cognome: 'Rossi',
                nome: 'Mario',
                sesso: 'M',
                dataNascita: '1980-01-01'
            );

            $risultatiVerifica = $this->verificaPerCodiceFiscale(
                $testCf,
                $testGeneralita,
                'Test connettività'
            );

            $risultati['test_verifica'] = [
                'eseguito' => true,
                'successo' => $risultatiVerifica['successo'],
                'ha_risposta' => ! empty($risultatiVerifica),
            ];
        } catch (Exception $e) {
            $risultati['test_verifica'] = [
                'eseguito' => false,
                'errore' => $e->getMessage(),
            ];
        }

        $risultati['timestamp'] = now()->toISOString();
        $risultati['debug_log'] = $this->pdndClient->getDebugLog();

        return $risultati;
    }

    /**
     * Metodo per backward compatibility
     */
    public function consultazioneE002(RichiestaE002 $richiesta): array
    {
        return $this->verificaDichiarazioneE002($richiesta);
    }

    public function getPdndClient(): PdndClientService
    {
        return $this->pdndClient;
    }
}
