<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015;

use Exception;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Request\RichiestaE002;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Request\TipoCriteriRicercaE002;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Request\TipoDatiRichiestaE002;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Response\RispostaE002OK;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Response\RispostaKO;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Response\TipoInfoSoggettoEnte;
use Modules\Pdnd\Services\Anpr\Services\C015\Models\Response\TipoListaSoggetti;
use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasPdndClient;
use Modules\Pdnd\Services\PdndClientService;

use function Safe\json_decode;

class C015Service
{
    use HasPdndClient;

    public function __construct(
        PdndClientService $pdndClient
    ) {
        $this->pdndClient = $pdndClient;
    }

    /**
     * Endpoint principale E002 - Accertamento Generalità (C015)
     */
    public function accertamentoGeneralita(RichiestaE002 $richiesta): array
    {
        try {
            $response = $this->pdndClient->callApiService($richiesta->toArray());

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
     * Metodo di convenienza - Accertamento per Codice Fiscale
     */
    public function accertamentoPerCodiceFiscale(
        string $cf,
        ?string $motivoRichiesta = null
    ): array {
        $richiesta = RichiestaE002::perCodiceFiscale(
            codiceFiscale: $cf,
            motivoRichiesta: $motivoRichiesta ?? 'Accertamento generalità',
            dataRiferimento: now()->format('Y-m-d')
        );

        return $this->accertamentoGeneralita($richiesta);
    }

    /**
     * Accertamento Generalità per ID ANPR - metodo di convenienza
     * (Utilizzato dal flusso CF → C030 → idANPR → C015)
     */
    public function accertamentoPerIdAnpr(
        string $idAnpr,
        ?string $motivoRichiesta = null
    ): array {
        $richiesta = RichiestaE002::perIdAnpr(
            idAnpr: $idAnpr,
            motivoRichiesta: $motivoRichiesta ?? 'Accertamento generalità tramite ID ANPR',
            dataRiferimento: now()->format('Y-m-d')
        );

        return $this->accertamentoGeneralita($richiesta);
    }

    /**
     * Metodo di convenienza - Accertamento con dati anagrafici
     */
    public function accertamentoPerDatiAnagrafici(array $datiPersona, ?string $motivoRichiesta = null): array
    {
        $criteri = TipoCriteriRicercaE002::fromArray($datiPersona);

        $richiesta = new RichiestaE002(
            idOperazioneClient: $this->generateOperationId(),
            criteriRicerca: $criteri,
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: now()->format('Y-m-d'),
                casoUso: 'C015',
                motivoRichiesta: $motivoRichiesta ?? 'Accertamento generalità cittadino'
            )
        );

        return $this->accertamentoGeneralita($richiesta);
    }

    public function getStatus(): array
    {
        try {
            $response = $this->pdndClient->callApi([], 'status');
            return [
                'servizio' => 'C015',
                'stato' => 'attivo',
                'response' => $response,
                'timestamp' => now()->toISOString(),
            ];
        } catch (Exception $e) {
            return [
                'servizio' => 'C015',
                'stato' => 'errore',
                'errore' => $e->getMessage(),
                'timestamp' => now()->toISOString(),
            ];
        }
    }

    // ==================== PROCESSAMENTO RISPOSTA ====================

    private function processE002Response(array $response, RichiestaE002 $richiesta): array
    {
        $bodyRaw = $response['body'] ?? '{}';
        if (! is_string($bodyRaw)) {
            $bodyRaw = '{}';
        }

        /** @var array<string, mixed> $responseArray */
        $responseArray = json_decode($bodyRaw, true);

        if ($this->isSuccessResponse($responseArray)) {
            return $this->processSuccessResponse($responseArray, $richiesta);
        }

        return $this->processErrorResponse($responseArray, $richiesta);
    }

    private function isSuccessResponse(array $response): bool
    {
        return isset($response['listaSoggetti']);
    }

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
     * @return array<int, array<string, mixed>>
     */
    private function extractSoggettiData(?TipoListaSoggetti $listaSoggetti): array
    {
        if ($listaSoggetti === null || $listaSoggetti->datiSoggetto === null || $listaSoggetti->datiSoggetto === []) {
            return [];
        }

        $soggetti = [];
        foreach ($listaSoggetti->datiSoggetto as $soggetto) {
            $soggetti[] = [
                'generalita' => $soggetto->generalita?->toArray() ?? [],
                'stato_civile' => $soggetto->statoCivile?->toArray() ?? [],
                'identificativi' => $soggetto->identificativi?->toArray() ?? [],
                'info_soggetto_ente' => $this->extractInfoSoggettoEnte($soggetto->infoSoggettoEnte ?? []),
            ];
        }

        return $soggetti;
    }

    /**
     * @param  array  $items
     * @return array<int, array<string, string|null>>
     */
    private function extractInfoSoggettoEnte(array $items): array
    {
        return array_map(static fn (TipoInfoSoggettoEnte $item): array => [
            'chiave' => $item->chiave,
            'valore' => $item->valore?->value,
            'valore_testo' => $item->valoreTesto,
            'valore_data' => $item->valoreData,
        ], $items);
    }

    private function extractAnomalieData(array $lista): array
    {
        return array_map(
            static fn($a) => $a instanceof TipoErroriAnomalia 
                ? $a->toArray() 
                : TipoErroriAnomalia::fromArray((array)$a)->toArray(),
            $lista
        );
    }

    private function extractErroriData(array $lista): array
    {
        return $this->extractAnomalieData($lista);
    }

    private function generateOperationId(): string
    {
        return 'C015_' . now()->format('YmdHis') . '_' . substr(uniqid(), -6);
    }
}