<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Client;

use Exception;
use Modules\Pdnd\Datas\PdndData;

use function Safe\curl_exec;
use function Safe\curl_getinfo;
use function Safe\curl_init;
use function Safe\curl_setopt;
use function Safe\json_decode;
use function Safe\json_encode;

class PdndAccessToken
{
    protected PdndData $config;

    public function __construct()
    {
        $this->config = PdndData::make();
    }

    public function getRequestAccessToken(
        string $encodedTrack,
        string $clientId,
        string $purposeId,
        string $jti,
        string $kid,
        string $aud,
        int $expirationTime,
        int $issuedAt,
        string $privateKey,
        string $endpoint
    ): string {
        $generateToken = new PdndGenerateToken;
        $jwtToken = $generateToken->getTokenReqAccess(
            $kid,
            $jti,
            $purposeId,
            $encodedTrack,
            $aud,
            $clientId,
            $issuedAt,
            $expirationTime,
            $privateKey
        );

        $ch = curl_init($endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'client_id' => $clientId,
            'client_assertion' => $jwtToken,
            'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
            'grant_type' => 'client_credentials',
        ]));
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception('cURL error: '.curl_error($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseStr = is_string($response) ? $response : '';
        $statusCodeInt = is_int($statusCode) ? $statusCode : 0;

        if ($statusCodeInt === 200) {
            /** @var array<string, mixed> $json */
            $json = json_decode($responseStr, true);
            $accessToken = is_string($json['access_token'] ?? null) ? $json['access_token'] : null;
            if ($accessToken) {
                return $accessToken;
            } else {
                throw new PdndException("⚠️ Nessun access token trovato:\n".json_encode($json, JSON_PRETTY_PRINT));
            }
        } else {
            throw new PdndException("❌ Errore nella richiesta token. Status: $statusCodeInt\nRisposta: $responseStr");
        }
    }
}
