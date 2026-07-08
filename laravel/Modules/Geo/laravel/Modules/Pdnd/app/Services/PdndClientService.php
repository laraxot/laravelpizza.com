<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Datas\PdndData;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\Client\PdndClient;
// use Spipu\Html2Pdf\Tag\Html\S;

class PdndClientService
{
    protected PdndClient $client;

    protected PdndData $config;

    public function __construct(string $ambiente = 'test', ServizioAnprEnum $servizio = ServizioAnprEnum::C030)
    {
        if ($ambiente == 'test') {
            $this->config = PdndData::make('test');
            $this->initializeClientTest($servizio);
        } elseif ($ambiente == 'prod') {
            $this->config = PdndData::make('prod');
            $this->initializeClientProd($servizio);
        }
    }

    // Metodo per inizializzare client con servizio specifico
    private function initializeClientTest(ServizioAnprEnum $servizio): void
    {
        $serviceAud = match ($servizio) {
            ServizioAnprEnum::C030 => 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C030-servizioAccertamentoIdUnicoNazionale/v1',
            ServizioAnprEnum::C003 => 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C003-servizioVerificaDichGeneralita/v1',
            ServizioAnprEnum::C007 => 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C007-servizioVerificaDichEsistenzaVita/v1',
            ServizioAnprEnum::C015 => 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C015-servizioAccertamentoGeneralita/v1',
        };

        $servicePath = match ($servizio) {
            ServizioAnprEnum::C030 => 'C030-servizioAccertamentoIdUnicoNazionale/v1/anpr-service-e002',
            ServizioAnprEnum::C003 => 'C003-servizioVerificaDichGeneralita/v1/anpr-service-e002',
            ServizioAnprEnum::C007 => 'C007-servizioVerificaDichEsistenzaVita/v1/anpr-service-e002',
            ServizioAnprEnum::C015 => 'C015-servizioAccertamentoGeneralita/v1/anpr-service-e002',
        };

        $purposeId = match ($servizio) {
            ServizioAnprEnum::C030 => 'f67eb971-f8be-4ea5-8c29-f251e83af926',
            ServizioAnprEnum::C003 => '8e69eb1e-a937-4713-8abd-38335a36a045',
            ServizioAnprEnum::C007 => '',
            ServizioAnprEnum::C015 => '78a58eda-327f-4a28-bb42-d320f7df736d',
        };

        $this->client = new PdndClient;
        $this->client->setKid($this->config->kid);
        $this->client->setIssuer($this->config->issuer);
        $this->client->setClientId($this->config->clientId);
        $this->client->setPurposeId($purposeId);
        $this->client->setPrivKeyPath($this->config->privKeyPath);
        $this->client->setEndpoint($this->config->authUrl);
        $this->client->setAud($this->config->audience);
        $this->client->setServiceAud($serviceAud);
        $this->client->setApiUrl($this->config->apiBaseUrlTest.$servicePath);
        $this->client->setEnv('collaudo');
        $this->client->setDebug(true);
        $this->client->setVerifySSL(false);
    }

    private function initializeClientProd(ServizioAnprEnum $servizio): void
    {
        $serviceAud = match ($servizio) {
            ServizioAnprEnum::C030 => 'https://modipa.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C030-servizioAccertamentoIdUnicoNazionale/v1',
            ServizioAnprEnum::C003 => 'https://modipa.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C003-servizioVerificaDichGeneralita/v1',
            ServizioAnprEnum::C007 => 'https://modipa.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C007-servizioVerificaDichEsistenzaVita/v1',
            ServizioAnprEnum::C015 => 'https://modipa.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C015-servizioAccertamentoGeneralita/v1',
        };

        $servicePath = match ($servizio) {
            ServizioAnprEnum::C030 => 'C030-servizioAccertamentoIdUnicoNazionale/v1/anpr-service-e002',
            ServizioAnprEnum::C003 => 'C003-servizioVerificaDichGeneralita/v1/anpr-service-e002',
            ServizioAnprEnum::C007 => 'C007-servizioVerificaDichEsistenzaVita/v1/anpr-service-e002',
            ServizioAnprEnum::C015 => 'C015-servizioAccertamentoGeneralita/v1/anpr-service-e002',
        };

        $purposeId = match ($servizio) {
            ServizioAnprEnum::C030 => '3ab3e801-01bd-4e4b-a6e8-e7951ba9ebad',
            ServizioAnprEnum::C003 => 'bfe97db9-e1f6-4616-9421-84b2e6d8303b',
            ServizioAnprEnum::C007 => '39647c26-5f1f-49c7-8606-2b9e8586bd24',
            ServizioAnprEnum::C015 => '4be3854f-80b9-4563-91f7-9bdf11fa3ce2',
        };

        $this->client = new PdndClient;
        $this->client->setKid($this->config->kid);
        $this->client->setIssuer($this->config->issuer);
        $this->client->setClientId($this->config->clientId);
        $this->client->setPurposeId($purposeId);
        $this->client->setPrivKeyPath($this->config->privKeyPath);
        $this->client->setEndpoint($this->config->authUrl);
        $this->client->setAud($this->config->audience);
        $this->client->setServiceAud($serviceAud);
        $this->client->setApiUrl($this->config->apiBaseUrlTest.$servicePath);
        $this->client->setEnv('produzione');
        $this->client->setDebug(true);
        $this->client->setVerifySSL(false);
    }

    /**
     * Funzione per creazione token e chiamata alla prima API per ottenere l'idAnpr
     *
     * @return array<string, mixed>
     */
    public function callApi(array $bodyArray = [], string $endpoint = ''): array
    {
        try {
            // ottenimento nuovo ACCESS TOKEN
            $token = $this->client->requestToken();

            // dddx($token);

            // chaimata API E-SERVICE
            /** @var array<string, mixed> $bodyArrayTyped */
            $bodyArrayTyped = $bodyArray;

            $previousApiUrl = null;
            if ($endpoint !== '') {
                $previousApiUrl = $this->client->getApiUrl();
                $this->client->setApiUrl($endpoint);
            }

            try {
                $response = $this->client->postApi($token, $bodyArrayTyped);
            } finally {
                if ($previousApiUrl !== null) {
                    $this->client->setApiUrl($previousApiUrl);
                }
            }

            return $response;
        } catch (Exception $e) {
            // Log the error
            Log::error('Error calling API', ['exception' => $e]);

            // Return a default error response
            return [
                'success' => false,
                'error' => 'Error calling API',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Funzione per creazione token e chiamata alla prima API per ottenere l'idAnpr
     *
     * @return array<string, mixed>
     */
    public function callApiService(array $bodyArray = []): array
    {
        try {
            // ottenimento nuovo ACCESS TOKEN
            $token = $this->client->requestToken();

            // dddx($token);

            // chaimata API E-SERVICE
            /** @var array<string, mixed> $bodyArrayTyped */
            $bodyArrayTyped = $bodyArray;
            $response = $this->client->postApi($token, $bodyArrayTyped);

            // dddx($response);

            return $response;
        } catch (Exception $e) {
            // Log the error
            Log::error('Error calling API', ['exception' => $e]);

            // Return a default error response
            return [
                'success' => false,
                'error' => 'Error calling API',
                'message' => $e->getMessage(),
            ];
        }
    }

    // Funzione per chiamare API sucessive per ottenere i dati richiesti (cercando di riutilizzare il token creato in precedenza)
    // public function callApiServiceOld(array $bodyArray = [], string $endpoint = ''): array
    // {
    //     try {

    //         // recupero del ACCESS TOKEN già creato e salvato nel client
    //         $token = $this->client->getToken();

    //         // chiamata API E-SERVICE
    //         $response = $this->client->postApi($token, $bodyArray, $endpoint);

    //         dddx($response);

    //         return $response;

    //     } catch (\Exception $e) {
    //         // Log the error
    //         Log::error('Error calling API', ['exception' => $e]);

    //         // Return a default error response
    //         return [
    //             'success' => false,
    //             'error' => 'Error calling API',
    //             'message' => $e->getMessage(),
    //         ];
    //     }
    // }

    // Factory method per creare client per servizio specifico
    public static function forService(ServizioAnprEnum $servizio): self
    {
        return new self(servizio: $servizio);
    }

    public function getDebugLog(): string
    {
        return $this->client->debugLog;
    }

    // Getter per client (per servizi specializzati)
    public function getClient(): PdndClient
    {
        return $this->client;
    }

    public function getApiUrl(): string
    {
        return $this->config->apiBaseUrlTest;
    }
}
