<?php

declare(strict_types=1);

// Modules/Pdnd/Services/Anpr/Services/C030/C030Service.php

namespace Modules\Pdnd\Services\Anpr\Services\C030;

use Exception;
use Modules\Pdnd\Services\Anpr\Contracts\AnprServiceInterface;
use Modules\Pdnd\Services\Anpr\Services\C030\Models\Request\RichiestaE002;
use Modules\Pdnd\Services\Anpr\Services\C030\Models\Request\TipoCriteriRicercaE002;
use Modules\Pdnd\Services\Anpr\Services\C030\Models\Request\TipoDatiRichiestaE002;
use Modules\Pdnd\Services\Anpr\Services\C030\Models\Response\RispostaE002OK;
use Modules\Pdnd\Services\Anpr\Services\C030\Models\Response\RispostaKO;
use Modules\Pdnd\Services\Anpr\Services\C030\Models\Response\TipoListaSoggetti;
use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoDatiNascitaE000;
use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasPdndClient;
use Modules\Pdnd\Services\PdndClientService;
use Override;

use function Safe\json_decode;

class C030Service implements AnprServiceInterface
{
    use HasPdndClient;

    public function __construct(
        PdndClientService $pdndClient
    ) {
        $this->pdndClient = $pdndClient;
    }

    /**
     * Endpoint principale E002 - Consultazione caso d'uso
     * Implementa: POST /anpr-service-e002
     */
    public function consultazioneE002(RichiestaE002 $richiesta): array
    {
        try {
            $response = $this->pdndClient->callApi(
                $richiesta->toArray(),
                $this->pdndClient->getApiUrl()
            );

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
     * Cerca per codice fiscale - metodo di convenienza
     * Mantiene compatibilità con implementazione esistente
     */
    #[Override]
    public function cercaPerCodiceFiscale(string $cf, ?string $motivoRichiesta = null): array
    {
        $richiesta = RichiestaE002::perCodiceFiscale(
            codiceFiscale: $cf,
            motivoRichiesta: $motivoRichiesta ?? 'Verifica identità univoca',
            dataRiferimento: now()->format('Y-m-d')
        );

        return $this->consultazioneE002($richiesta);
    }

    /**
     * Cerca per dati anagrafici completi
     */
    #[Override]
    public function cercaPerDatiAnagrafici(array $datiPersona): array
    {
        $criteriRicerca = TipoCriteriRicercaE002::fromArray($datiPersona);
        $richiesta = new RichiestaE002(
            idOperazioneClient: $this->generateOperationId(),
            criteriRicerca: $criteriRicerca,
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: now()->format('Y-m-d'),
                casoUso: 'C030',
                motivoRichiesta: (string) ($datiPersona['motivo_richiesta'] ?? 'Consultazione anagrafica')
            )
        );

        return $this->consultazioneE002($richiesta);
    }

    /**
     * Cerca con criteri di ricerca avanzati
     */
    public function cercaConCriteriAvanzati(
        ?string $codiceFiscale = null,
        ?string $cognome = null,
        ?string $nome = null,
        ?string $sesso = null,
        ?TipoDatiNascitaE000 $datiNascita = null,
        ?string $motivoRichiesta = null
    ): array {
        $criteriRicerca = new TipoCriteriRicercaE002(
            codiceFiscale: $codiceFiscale,
            cognome: $cognome,
            nome: $nome,
            sesso: $sesso,
            datiNascita: $datiNascita
        );

        $richiesta = new RichiestaE002(
            idOperazioneClient: $this->generateOperationId(),
            criteriRicerca: $criteriRicerca,
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: now()->format('Y-m-d'),
                casoUso: 'C030',
                motivoRichiesta: $motivoRichiesta ?? 'Ricerca avanzata'
            )
        );

        return $this->consultazioneE002($richiesta);
    }

    /**
     * Verifica esistenza soggetto tramite codice fiscale
     */
    public function verificaEsistenzaSoggetto(string $cf): bool
    {
        $risultato = $this->cercaPerCodiceFiscale($cf, 'Verifica esistenza');

        return $risultato['successo'] &&
               isset($risultato['lista_soggetti']) &&
               ! empty($risultato['lista_soggetti']);
    }

    /**
     * Ottieni ID ANPR di un soggetto
     */
    public function getIdAnpr(string $cf): ?string
    {
        $risultato = $this->cercaPerCodiceFiscale($cf, 'Recupero ID ANPR');

        if (! $risultato['successo'] || empty($risultato['lista_soggetti'])) {
            return null;
        }

        // Prende il primo soggetto trovato
        $listaSoggetti = $risultato['lista_soggetti'] ?? [];
        if (! is_array($listaSoggetti)) {
            return null;
        }

        $primoSoggetto = $listaSoggetti[0] ?? null;

        if (is_array($primoSoggetto) && isset($primoSoggetto['identificativi']) && is_array($primoSoggetto['identificativi']) && isset($primoSoggetto['identificativi']['idANPR']) && is_string($primoSoggetto['identificativi']['idANPR'])) {
            return $primoSoggetto['identificativi']['idANPR'];
        }

        return null;
    }

    /**
     * Test di stato del servizio
     * Implementa: GET /status
     */
    public function getStatus(): array
    {
        try {
            // Chiama l'endpoint /status invece dell'endpoint principale
            $response = $this->pdndClient->callApi([], 'status');

            return [
                'servizio' => 'C030',
                'stato' => 'attivo',
                'response' => $response,
                'timestamp' => now()->toISOString(),
            ];
        } catch (Exception $e) {
            return [
                'servizio' => 'C030',
                'stato' => 'errore',
                'errore' => $e->getMessage(),
                'timestamp' => now()->toISOString(),
            ];
        }
    }

    /**
     * Processa la risposta E002 secondo la specifica OpenAPI
     *
     * @param  array  $response
     * @return array<string, mixed>
     */
    private function processE002Response(array $response, RichiestaE002 $richiesta): array
    {
        // dddx($response);
        if ($response['body'] === null) {
            throw new Exception('Campo "body" non presente nella risposta. Contrallare la presenza della privateKey.');
        }
        $bodyRaw = $response['body'] ?? '{}';
        assert(is_string($bodyRaw));
        /** @var array<string, mixed> $responseArray */
        $responseArray = json_decode($bodyRaw, true);
        // Determina il tipo di risposta basandosi sulla struttura
        if ($this->isSuccessResponse($responseArray)) {
            return $this->processSuccessResponse($responseArray, $richiesta);
        } else {
            return $this->processErrorResponse($responseArray, $richiesta);
        }
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
        // Presenza di listaSoggetti indica successo
        if (isset($response['listaSoggetti'])) {
            return true;
        }

        // Presenza di listaErrori indica errore
        if (isset($response['listaErrori']) && ! empty($response['listaErrori'])) {
            return false;
        }

        // Presenza di idOperazioneANPR senza errori indica successo
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
                'id_anpr' => $soggetto->identificativi->idANPR ?? null,
                'identificativi' => (array) $soggetto->identificativi,
                'dati_completi' => (array) $soggetto,
            ];
        }

        return $soggetti;
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
        return array_map(static function ($errore) {
            if ($errore instanceof TipoErroriAnomalia) {
                return $errore->toArray();
            }

            return TipoErroriAnomalia::fromArray((array) $errore)->toArray();
        }, $listaErrori);
    }

    /**
     * Genera ID operazione client univoco
     */
    private function generateOperationId(): string
    {
        return 'C030_'.now()->format('YmdHis');
    }

    /**
     * Factory method per creare richiesta rapida
     */
    public static function creaRichiestaRapida(
        string $codiceFiscale,
        string $motivoRichiesta = 'Consultazione standard'
    ): RichiestaE002 {
        return RichiestaE002::perCodiceFiscale(
            codiceFiscale: $codiceFiscale,
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
            'servizio' => 'C030',
            'nome_completo' => 'Servizio Accertamento ID Univoco Nazionale',
            'versione_api' => '1.0.0',
            'endpoint_base' => '/anpr-service-e002',
            'endpoint_status' => '/status',
            'ultimo_utilizzo' => now()->toISOString(),
            'debug_disponibile' => true,
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

        // Test con codice fiscale di prova (se abilitato)
        try {
            $testCf = 'RSSMRA80A01H501Z'; // CF di test standard
            $risultatiRicerca = $this->cercaPerCodiceFiscale($testCf, 'Test connettività');

            $risultati['test_ricerca'] = [
                'eseguito' => true,
                'successo' => $risultatiRicerca['successo'],
                'ha_risposta' => ! empty($risultatiRicerca),
            ];
        } catch (Exception $e) {
            $risultati['test_ricerca'] = [
                'eseguito' => false,
                'errore' => $e->getMessage(),
            ];
        }

        $risultati['timestamp'] = now()->toISOString();
        $risultati['debug_log'] = $this->pdndClient->getDebugLog();

        return $risultati;
    }

    /**
     * Metodo per backward compatibility con il tuo codice esistente
     */
    // public function avviaRichiesta(array $filters = []): array
    // {
    //     // Mappa i filtri al nuovo formato
    //     if (isset($filters['codiceFiscale'])) {
    //         return $this->cercaPerCodiceFiscale(
    //             $filters['codiceFiscale'],
    //             $filters['motivoRichiesta'] ?? 'Richiesta legacy'
    //         );
    //     }

    //     // Se non c'è codice fiscale, prova con dati anagrafici
    //     return $this->cercaPerDatiAnagrafici($filters);
    // }

    public function getPdndClient(): PdndClientService
    {
        return $this->pdndClient;
    }
}
