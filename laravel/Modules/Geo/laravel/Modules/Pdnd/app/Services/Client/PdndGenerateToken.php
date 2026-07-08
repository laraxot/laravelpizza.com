<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Client;

use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use Modules\Pdnd\Datas\PdndData;

class PdndGenerateToken
{
    protected PdndData $config;

    public function __construct()
    {
        $this->config = PdndData::make();
    }

    public function getAgidTrackingSignature(
        string $kid,
        string $jti,
        string $purposeId,
        string $serviceAud,
        string $clientId,
        string $privateKey
    ): string {
        // ///////////////////// CREAZIONE TOKEN AUDIT //////////////////////////////////////////
        // === . Agid-JWT-TrackingEvidence ===
        $jwtHeaderTracking = [
            'typ' => 'JWT',
            'alg' => 'RS256',
            'kid' => $kid,
        ];

        $payloadTracking = [
            'jti' => $jti,
            'purposeId' => $purposeId,
            'dnonce' => (string) Str::uuid(),
            'userID' => 'utente-test',
            'userLocation' => 'postazione-1',
            'LoA' => 'LoA2',
            'aud' => $serviceAud,
            'iss' => $clientId,
            'sub' => $clientId,
            'iat' => time(),
            'exp' => time() + 300,
        ];

        return JWT::encode($payloadTracking, $privateKey, 'RS256', null, $jwtHeaderTracking);
    }

    public function getTokenReqAccess(
        string $kid,
        string $jti,
        string $purposeId,
        string $encodedTrack,
        string $aud,
        string $clientId,
        int $issuedAt,
        int $expirationTime,
        string $privateKey
    ): string {
        $headers = [
            'typ' => 'JWT',
            'alg' => 'RS256',
            'kid' => $kid,
        ];

        $payload = [
            'jti' => $jti,
            'purposeId' => $purposeId,
            'digest' => [
                'alg' => 'SHA256',
                'value' => $encodedTrack,
            ],
            'aud' => $aud,
            'iss' => $clientId,
            'sub' => $clientId,
            'iat' => $issuedAt,
            'exp' => $expirationTime,
        ];

        try {
            return JWT::encode($payload, $privateKey, 'RS256', null, $headers);
        } catch (Exception $e) {
            throw new PdndException("Errore durante la generazione del client_assertion JWT:\n".$e->getMessage());
        }
    }

    public function getAgidJwtSignature(
        string $kid,
        string $jti,
        string $serviceAud,
        string $clientId,
        string $digest,
        int $issuedAt,
        int $expirationTime,
        string $privateKey
    ): string {
        // === 5. Header JWT con informazioni del certificato ===
        $jwtHeaderSignature = [
            'typ' => 'JWT',
            'alg' => 'RS256',
            'kid' => $kid,
        ];

        // === 6. Agid-JWT-Signature ===
        $payloadSignature = [
            'jti' => $jti,
            'aud' => $serviceAud,
            'iss' => $clientId,
            'sub' => $clientId,
            'digest' => $digest,
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'signed_headers' => [
                ['digest' => 'SHA-256='.$digest],
                ['content-type' => 'application/json'],
            ],
        ];

        $tokenAgidSign = JWT::encode($payloadSignature, $privateKey, 'RS256', null, $jwtHeaderSignature);

        return $tokenAgidSign;
    }
}
