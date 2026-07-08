<?php

declare(strict_types=1);

/**
 * @name PdndClient
 *
 * @license MIT
 *
 * @file PdndClient.php
 *
 * @brief Classe per interagire con l'API PDND (Piattaforma Digitale Nazionale dei Dati).
 *
 * @author Francesco Loreti
 *
 * @mailto francesco.loreti@isprambiente.it
 *
 * @first_release 2025-07-13
 */

namespace Modules\Pdnd\Services\Client;

use DateTime;
use DateTimeZone;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use function Safe\curl_exec;
use function Safe\curl_getinfo;
use function Safe\curl_init;
use function Safe\curl_setopt;
use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Classe per interagire con l'API PDND (Piattaforma Digitale Nazionale dei Dati).
 * Questa classe gestisce la configurazione, la richiesta di token e le chiamate API.
 */
class PdndClient
{
    /**
     * @var string Il Key ID del client.
     * @var string L'issuer del client.
     * @var string L'ID del client.
     * @var string L'ID dello scopo per cui viene richiesto il token.
     * @var string Il percorso della chiave privata in formato PEM.
     * @var bool Abilita o disabilita la modalità di debug.
     * @var string L'URL dell'API da richiamare.
     * @var string|null L'URL dell'API da richiamare (opzionale).
     * @var string|null L'URL per verificare lo stato del token (opzionale).
     * @var int|null La data di scadenza del token (timestamp).
     * @var string L'ambiente dell'API PDND (default: "produzione").
     * @var string L'endpoint per la richiesta del token.
     * @var string L'audience per il token JWT.
     * @var string Il percorso del file in cui salvare il token.
     * @var bool Abilita o disabilita la verifica SSL (default: true).
     * @var string Il fuso orario da utilizzare per le date (default: 'Europe/Rome').
     * @var array Array per i filtri personalizzati da applicare alle chiamate API.
     */
    private ?string $kid = null;

    private ?string $issuer = null;

    private ?string $clientId = null;

    private ?string $purposeId = null;

    private ?string $privKeyPath = null;

    private bool $debug = false;

    private ?string $apiUrl = null;

    private ?string $statusUrl = null;

    private string $env = 'produzione';

    private string $endpoint = 'https://auth.interop.pagopa.it/token.oauth2';

    private string $aud = 'auth.interop.pagopa.it/client-assertion';

    private ?string $serviceAud = null;

    // private $tokenFile = "";
    private ?string $token = null;

    private bool $verifySSL = true; // Default verifica SSL abilitata

    /** @var array<string, mixed> */
    private array $filters = []; // Array per i filtri personalizzati

    public string $debugLog = '';

    private ?string $jwtTracking = null;

    // -- Setters --
    public function setApiUrl(?string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    public function setAud(string $aud): void
    {
        $this->aud = $aud;
    }

    public function setServiceAud(?string $serviceAud): void
    {
        $this->serviceAud = $serviceAud;
    }

    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Imposta l'ambiente dell'API PDND.
     *
     * @param  string  $env  L'ambiente da impostare (default: "produzione").
     *                       Se l'ambiente è "collaudo", imposta l'endpoint e l'aud specifici.
     *                       Altrimenti, usa i valori predefiniti per produzione.
     */
    public function setEnv(string $env = 'test'): void
    {
        $this->env = $env;
        if ($env === 'collaudo') {
            $this->endpoint = 'https://auth.uat.interop.pagopa.it/token.oauth2';
            $this->aud = 'auth.uat.interop.pagopa.it/client-assertion';
        }
    }

    /**
     * @param  array  $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function setKid(?string $kid): void
    {
        $this->kid = $kid;
    }

    public function setIssuer(?string $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function setPurposeId(?string $purposeId): void
    {
        $this->purposeId = $purposeId;
    }

    public function setPrivKeyPath(?string $privKeyPath): void
    {
        $this->privKeyPath = $privKeyPath;
    }

    public function setStatusUrl(?string $statusUrl): void
    {
        $this->statusUrl = $statusUrl;
    }

    public function setVerifySSL(bool $verifySSL): void
    {
        $this->verifySSL = $verifySSL;
    }

    // -- Getters --
    public function getApiUrl(): string
    {
        if ($this->apiUrl === null) {
            throw new Exception('ApiUrl is not set');
        }

        return $this->apiUrl;
    }

    public function getAud(): string
    {
        return $this->aud;
    }

    public function getServiceAud(): string
    {
        if ($this->serviceAud === null) {
            throw new Exception('ServiceAud is not set');
        }

        return $this->serviceAud;
    }

    public function getClientId(): string
    {
        if ($this->clientId === null) {
            throw new Exception('ClientId is not set');
        }

        return $this->clientId;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getEnv(): string
    {
        return $this->env;
    }

    /**
     * @return array<string, mixed>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getKid(): string
    {
        if ($this->kid === null) {
            throw new Exception('Kid is not set');
        }

        return $this->kid;
    }

    public function getIssuer(): string
    {
        if ($this->issuer === null) {
            throw new Exception('Issuer is not set');
        }

        return $this->issuer;
    }

    public function getPurposeId(): string
    {
        if ($this->purposeId === null) {
            throw new Exception('PurposeId is not set');
        }

        return $this->purposeId;
    }

    public function getPrivKeyPath(): string
    {
        if ($this->privKeyPath === null) {
            throw new Exception('PrivKeyPath is not set');
        }

        return $this->privKeyPath;
    }

    public function getStatusUrl(): string
    {
        if ($this->statusUrl === null) {
            throw new Exception('StatusUrl is not set');
        }

        return $this->statusUrl;
    }

    public function getVerifySSL(): bool
    {
        return $this->verifySSL;
    }

    /**
     * Carica la configurazione da un file JSON.
     *
     * @param  string|null  $configPath  Il percorso del file di configurazione. Se non specificato, usa le variabili di ambiente.
     *
     * @throws PdndException Se il file di configurazione non esiste o se l'ambiente non è trovato.
     */
    public function config(?string $configPath = null): void
    {
        /** @var array<string, mixed> $config */
        $config = [];

        // Se il percorso del file di configurazione è specificato, carica la configurazione da quel file
        if ($configPath && file_exists($configPath)) {
            $fileContent = file_get_contents($configPath);
            /** @var array<string, array<string, mixed>> $allEnvs */
            $allEnvs = json_decode($fileContent, true);
            if (! isset($allEnvs[$this->env])) {
                throw new PdndException("Errore: environment '$this->env' non trovato nel file di configurazione.");
            }
            $config = $allEnvs[$this->env];
        }

        // Carica i parametri dalle variabili di ambiente se non sono già impostati
        $kidVal = $config['kid'] ?? getenv('PDND_KID');
        $this->kid = is_string($kidVal) ? $kidVal : null;

        $issuerVal = $config['issuer'] ?? getenv('PDND_ISSUER');
        $this->issuer = is_string($issuerVal) ? $issuerVal : null;

        $clientIdVal = $config['clientId'] ?? getenv('PDND_CLIENT_ID');
        $this->clientId = is_string($clientIdVal) ? $clientIdVal : null;

        $purposeIdVal = $config['purposeId'] ?? getenv('PDND_PURPOSE_ID');
        $this->purposeId = is_string($purposeIdVal) ? $purposeIdVal : null;

        $privKeyPathVal = $config['privKeyPath'] ?? getenv('PDND_PRIVKEY_PATH');
        $this->privKeyPath = is_string($privKeyPathVal) ? $privKeyPathVal : null;

        // $this->tokenFile = sys_get_temp_dir() . "/pdnd_token_" . $this->purposeId . ".json";

        if ($this->apiUrl !== null) {
            $this->validateUrl($this->apiUrl);
        }
        if ($this->statusUrl !== null) {
            $this->validateUrl($this->statusUrl);
        }
        $this->validateConfig();
    }

    /**
     * Richiede un nuovo token utilizzando le credenziali fornite.
     *
     * @return string Il token ottenuto.
     *
     * @throws PdndException Se uno dei campi obbligatori non è impostato.
     * @throws PdndException Se l'URL non è raggiungibile o non valido.
     * @throws PdndException Se la generazione del token JWT fallisce.
     * @throws PdndException Se la risposta JSON non è valida o se non contiene un access token.
     * @throws PdndException Se si verifica un errore durante la richiesta del token.
     * @throws PdndException Se si verifica un errore durante la generazione del token.
     */
    public function requestToken(): string
    {
        // REFACTOR

        $kid = $this->getKid();
        $issuer = $this->getIssuer();
        $clientId = $this->getClientId();
        $purposeId = $this->getPurposeId();
        $endpoint = $this->getEndpoint();
        $serviceAud = $this->getServiceAud();
        $issuedAt = time();
        $expirationTime = $issuedAt + (43200 * 60); // 30 giorni
        $jti = (string) Str::uuid();

        $privateKeyPath = $this->getPrivKeyPath(); // Usa il percorso dalla configurazione
        $privateKey = file_get_contents($privateKeyPath);
        if (! $privateKey) {
            throw new Exception("Impossibile leggere la chiave privata da: $privateKeyPath");
        }

        // generazione AGID-JWT-TRACKINGEVIDENCE
        $generateToken = new PdndGenerateToken;
        $tokenTrackSign = $generateToken->getAgidTrackingSignature(
            $kid,
            $jti,
            $purposeId,
            $serviceAud,
            $clientId,
            $privateKey
        );

        $this->jwtTracking = $tokenTrackSign;

        $hashTrack = hash('sha256', $tokenTrackSign, false);
        $encodedTrack = $hashTrack;

        // generazione OAUTH2 ACCESS TOKEN
        $accessTokenPdnd = new PdndAccessToken;
        $token = $accessTokenPdnd->getRequestAccessToken(
            $encodedTrack,
            $clientId,
            $purposeId,
            $jti,
            $kid,
            $this->aud,
            $expirationTime,
            $issuedAt,
            $privateKey,
            $endpoint
        );

        $this->token = $token;

        return $token;

        // OLD

        //     $kid = $this->getKid();
        //     $issuer = $this->getIssuer();
        //     $clientId = $this->getClientId();
        //     $purposeId = $this->getPurposeId();
        //     $endpoint = $this->getEndpoint();
        //     $subject = $issuer;

        //     $issuedAt = time();
        //     $expirationTime = $issuedAt + (43200 * 60); // 30 giorni
        //     $jti = bin2hex(random_bytes(16));

        //     $privateKeyPath = $this->getPrivKeyPath(); // Usa il percorso dalla configurazione
        //     $privateKey = file_get_contents($privateKeyPath);
        //     if (!$privateKey) {
        //         throw new \Exception("❌ Impossibile leggere la chiave privata da: $privateKeyPath");
        //     }

        //     /////////////////////// CREAZIONE TOKEN AUDIT //////////////////////////////////////////
        //     // === . Agid-JWT-TrackingEvidence ===
        //     $trackId = (string) Str::uuid();
        //     $aud = 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C030-servizioAccertamentoIdUnicoNazionale/v1';
        //     $jwtHeaderTracking = [
        //         "typ" => "JWT",
        //         "alg" => "RS256",
        //         "kid" => $this->getKid()
        //     ];
        //     $payloadTracking = [
        //         "jti" => $trackId,
        //         "purposeId" => $this->getPurposeId(),
        //         "dnonce" => (string) Str::uuid(),
        //         "userID" => 'utente-test',
        //         "userLocation" => 'postazione-1',
        //         "LoA" => 'LoA2',
        //         "aud" => $aud,
        //         "iss" => $clientId,
        //         "sub" => $clientId,
        //         "iat" => time(),
        //         "exp" => time() + 300
        //     ];

        //     $jwtTracking = JWT::encode($payloadTracking, $privateKey, 'RS256', null, $jwtHeaderTracking);
        //     $this->jwtTracking = $jwtTracking;

        //     // dddx($jwtTracking);

        //     $hashTrack = hash('sha256', $jwtTracking, false);
        //     $encodedTrack = $hashTrack;

        //     /////////////////////// RICHIESTA VOUCHER PDND //////////////////////////////////////////

        //     $headers = [
        //       "typ" => "JWT",
        //       "alg" => "RS256",
        //       "kid" => $kid,
        //     ];

        //     $payload = [
        //       "jti" => $jti,
        //       "purposeId" => $purposeId,
        //       'digest' => [
        //               'alg' => 'SHA256',
        //               'value' => $encodedTrack
        //             ],
        //       "aud" => $this->aud,
        //       "iss" => $issuer,
        //       "sub" => $subject,
        //       "iat" => $issuedAt,
        //       "exp" => $expirationTime
        //     ];

        //     try {
        //       $clientAssertion = JWT::encode($payload, $privateKey, 'RS256', null, $headers);
        //       // dddx($clientAssertion);

        //     } catch (Exception $e) {
        //       throw new PdndException("Errore durante la generazione del client_assertion JWT:\n" . $e->getMessage());
        //     }

        //     $ch = curl_init($endpoint);

        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        //         "client_id" => $clientId,
        //         "client_assertion" => $clientAssertion,
        //         "client_assertion_type" => "urn:ietf:params:oauth:client-assertion-type:jwt-bearer",
        //         "grant_type" => "client_credentials"
        //     ]));
        // //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //         "Content-Type: application/x-www-form-urlencoded"
        //     ]);

        //     $response = curl_exec($ch);

        //     if ($response === false) {
        //       throw new \Exception('cURL error: ' . curl_error($ch));
        //     }

        //     $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //     curl_close($ch);

        //     if ($statusCode === 200) {
        //         $json = json_decode($response, true);
        //         $accessToken = $json["access_token"] ?? null;
        //         if ($accessToken) {
        //             // Decodifica il JWT per estrarre la scadenza
        //             $parts = explode('.', $accessToken);
        //             // if (count($parts) === 3) {
        //             //     $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        //             //     $this->tokenExp = $payload['exp'] ?? null;
        //             // }
        //             // if ($this->debug) {
        //             //     if (isset($this->tokenExp)) {
        //             //         $dt = new DateTime("@$this->tokenExp", new DateTimeZone($this->dateTimeZone));
        //             //         $dt->setTimezone(new DateTimeZone($this->dateTimeZone));
        //             //         $tokenExp = $dt->format('Y-m-d H:i:s');
        //             //     } else {
        //             //         $tokenExp = 'non disponibile';
        //             //     }
        //             // }
        //             return $accessToken;
        //         } else {
        //             throw new PdndException("⚠️ Nessun access token trovato:\n" . json_encode($json, JSON_PRETTY_PRINT));
        //         }
        //     } else {
        //         $errorResponse = $response;
        //         throw new PdndException("Errore nella richiesta token. Status: $statusCode\nRisposta: $errorResponse");
        //     }
    }

    /**
     * @param  array  $bodyArray
     * @return array<string, mixed>
     */
    public function postApi(string $token, array $bodyArray): array
    {
        $url = $this->apiUrl ?? $this->getApiUrl();

        $bodyJson = json_encode($bodyArray, JSON_UNESCAPED_UNICODE);
        $encodedBody = base64_encode(hash('sha256', $bodyJson, true));

        // === 2. Carica la chiave privata ===
        $privateKeyPath = $this->getPrivKeyPath(); // Usa il percorso dalla configurazione
        $privateKey = file_get_contents($privateKeyPath);
        if (! $privateKey) {
            throw new Exception("Impossibile leggere la chiave privata da: $privateKeyPath");
        }

        // === 3. Parametri comuni ===
        $kid = $this->getKid();
        $clientId = $this->getClientId();
        $jti = (string) Str::uuid();
        $serviceAud = $this->serviceAud; // O usa un getter
        $issuedAt = time();
        $expirationTime = $issuedAt + (43200 * 60); // 30 giorni

        // generazione AGID-JWT-SIGNATURE
        $generateToken = new PdndGenerateToken;
        $tokenAgidSign = $generateToken->getAgidJwtSignature(
            $kid,
            $jti,
            $serviceAud ?? '',
            $clientId,
            $encodedBody,
            $issuedAt,
            $expirationTime,
            $privateKey
        );

        // === 8. Header HTTP  ===
        $headers = [
            "Authorization: Bearer $token",
            "Agid-JWT-Signature: $tokenAgidSign",
            "Agid-JWT-TrackingEvidence: {$this->jwtTracking}",
            "Digest: SHA-256=$encodedBody",
            'Content-Type: application/json',
        ];

        // dddx($headers);

        // === 9. Esecuzione richiesta ===
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $responseStr = is_string($response) ? $response : '';
        if (! $responseStr) {
            throw new Exception("Errore nella chiamata API POST: $error");
        }

        if ($this->debug) {
            $decoded = json_decode($responseStr, true);
            if ($decoded) {
                $responseStr = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }

        return [
            'status' => $statusCode,
            'body' => $responseStr,
        ];
    }

    // public function postApiOld(string $token, array $bodyArray, string $endpoint = ''): array
    // {
    //     $url = $endpoint ?: ($this->apiUrl ?? $this->getApiUrl());

    //     $bodyJson = json_encode($bodyArray, JSON_UNESCAPED_UNICODE);
    //     $encodedBody = base64_encode(hash('sha256', $bodyJson, true));

    //     // === 2. Carica la chiave privata ===
    //     $privateKeyPath = $this->getPrivKeyPath(); // Usa il percorso dalla configurazione
    //     $privateKey = file_get_contents($privateKeyPath);
    //     if (!$privateKey) {
    //         throw new \Exception("❌ Impossibile leggere la chiave privata da: $privateKeyPath");
    //     }

    //     // === 3. Parametri comuni ===
    //     $clientId = $this->getClientId();
    //     $aud = 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR/C030-servizioAccertamentoIdUnicoNazionale/v1'; // O usa un getter

    //     // === 4. Carica il certificato per gli header JWT ===
    //     $certPath = str_replace('.priv', '.pem', $privateKeyPath); // Assumendo che il certificato abbia lo stesso nome
    //     $certContent = file_get_contents($certPath);
    //     if (!$certContent) {
    //         throw new \Exception("Impossibile leggere il certificato da: $certPath");
    //     }

    //     // Rimuovi header e footer PEM e ottieni solo il contenuto base64
    //     $certBase64 = preg_replace('/-----[^-]+-----/', '', $certContent);
    //     $certBase64 = preg_replace('/\s+/', '', $certBase64);

    //     // === 5. Header JWT con informazioni del certificato ===
    //     $jwtHeaderSignature = [
    //         "typ" => "JWT",
    //         "alg" => "RS256",
    //         "kid" => $this->getKid()
    //     ];

    //     // === 6. Agid-JWT-Signature ===
    //     $jwtId = (string) Str::uuid();
    //     $payloadSignature = [
    //         "jti" => $jwtId,
    //         "aud" => $aud,
    //         "iss" => $clientId,
    //         "sub" => $clientId,
    //         "digest" => $encodedBody,
    //         "iat" => time(),
    //         "exp" => time() + 300,
    //         "signed_headers" => [
    //             ["digest" => "SHA-256=" . $encodedBody],
    //             ["content-type" => "application/json"]
    //         ]
    //     ];
    //     // dddx($payloadSignature);
    //     $jwtSignature = JWT::encode($payloadSignature, $privateKey, 'RS256', null, $jwtHeaderSignature);

    //     // dddx($jwtSignature);

    //     // === 8. Header HTTP (stesso ordine del Java) ===
    //     $headers = [
    //         "Authorization: Bearer $token",
    //         "Agid-JWT-Signature: $jwtSignature",
    //         "Agid-JWT-TrackingEvidence: $this->jwtTracking",
    //         "Digest: SHA-256=$encodedBody",
    //         "Content-Type: application/json"
    //     ];

    //     // === 9. Esecuzione richiesta ===
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    //     $response = curl_exec($ch);
    //     $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     $error = curl_error($ch);
    //     curl_close($ch);

    //     if (!$response) {
    //         throw new \Exception("Errore nella chiamata API POST: $error");
    //     }

    //     if ($this->debug) {
    //         $decoded = json_decode($response, true);
    //         if ($decoded) {
    //             $response = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    //         }
    //     }

    //     return [
    //         'status' => $statusCode,
    //         'body' => $response
    //     ];
    // }

    /**
     * Verifica lo stato del token.
     *
     * @param  string  $token  Il token da verificare.
     * @return array<string, mixed> Il risultato della verifica dello stato del token.
     *
     * @throws PdndException Se la risposta JSON non è valida o se il token non è valido.
     */
    public function getStatus(string $token): array
    {
        $statusUrl = $this->statusUrl ?? $this->getStatusUrl();
        $ch = curl_init($statusUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            'Accept: */*',
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifySSL);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseStr = is_string($response) ? $response : '';
        $statusCodeInt = is_int($statusCode) ? $statusCode : 0;

        if ($statusCodeInt >= 200 && $statusCodeInt < 300) {
            /** @var array<string, mixed> $json */
            $json = json_decode($responseStr, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($json['status'])) {
                $statusVal = is_string($json['status']) ? $json['status'] : 'unknown';
                if ($this->debug) {
                    echo "\n✅ Token valido. Stato: {$statusVal}\n";
                }

                return $json;
            } else {
                if ($this->debug) {
                    echo "\n⚠️ Risposta JSON non valida o chiave 'status' mancante.\n";
                }
                throw new PdndException("⚠️ Risposta JSON non valida o chiave 'status' mancante.");
            }
        } else {
            if ($this->debug) {
                echo "\n❌ Errore nella chiamata. Codice: {$statusCodeInt}\nRisposta: $responseStr\n";
            }
            throw new PdndException("❌ Errore nella chiamata. Codice: {$statusCodeInt}\nRisposta: $responseStr\n");
        }
    }

    /**
     * Verifica se il token è ancora valido.
     *
     * @return bool True se il token è valido, altrimenti false.
     */
    // public function isTokenValid(): bool
    // {
    //   if (!$this->tokenExp) return false;
    //   return time() < $this->tokenExp;
    // }

    /**
     * Carica il token da un file.
     *
     * @param  string|null  $file  Il percorso del file da cui caricare il token. Se non specificato, usa il percorso predefinito.
     * @return string|null Il token se caricato con successo, altrimenti null.
     */
    // public function loadToken(string $file = null)
    // {
    //   $file = $file ?? $this->tokenFile;
    //   if (!file_exists($file)) return null;
    //   $data = json_decode(file_get_contents($file), true);
    //   if (!$data || !isset($data['token'], $data['exp'])) return null;
    //   $this->tokenExp = $data['exp'];
    //   return $data['token'];
    // }

    /**
     * Richiede un nuovo token, se il token corrente è scaduto o non esiste.
     *
     * @return string Il nuovo token.
     *
     * @throws PdndException Se si verifica un errore durante la richiesta del token.
     */
    // public function refreshToken()
    // {
    //   return $this->requestToken(); // Richiama la funzione per ottenere un nuovo token
    // }

    /**
     * Salva il token in un file.
     *
     * @param  string  $token  Il token da salvare.
     * @param  string|null  $file  Il percorso del file in cui salvare il token. Se non specificato, usa il percorso predefinito.
     */
    // public function saveToken(string $token, string $file = null)
    // {
    //   $file = $file ?? $this->tokenFile;
    //   $data = [
    //     'token' => $token,
    //     'exp' => $this->tokenExp
    //   ];
    //   file_put_contents($file, json_encode($data));
    // }

    /**
     * Verifica se l'URL è raggiungibile e valido.
     *
     * @param  string  $url  L'URL da validare.
     * @return bool True se l'URL è valido, altrimenti lancia un'eccezione.
     *
     * @throws PdndException Se l'URL non è raggiungibile o non valido.
     */
    public function validateUrl(string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true); // Evita di scaricare il contenuto
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout di 10 secondi
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 400) {
            throw new PdndException('Errore: URL non raggiungibile o non valida.', '1002');
        }

        return true;
    }

    // -- Private functions --

    /**
     * Verifica che tutti i campi obbligatori siano stati impostati.
     *
     * @throws PdndException Se uno dei campi obbligatori è mancante.
     */
    private function validateConfig(): void
    {
        $required = ['kid', 'issuer', 'clientId', 'purposeId', 'privKeyPath'];
        foreach ($required as $key) {
            if (empty($this->$key)) {
                throw new PdndException("Configurazione mancante: '$key' è obbligatorio.", '1001');
            }
        }
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
