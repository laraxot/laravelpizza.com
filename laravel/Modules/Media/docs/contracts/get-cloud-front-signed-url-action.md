---
title: "GetCloudFrontSignedUrlAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\CloudFront\\GetCloudFrontSignedUrlAction"
qmd: "GetCloudFrontSignedUrlAction URL firmato CloudFront chiave privata scadenza minuti media"
---

# GetCloudFrontSignedUrlAction

Genera un URL CloudFront firmato per una chiave S3. Codice: `app/Actions/CloudFront/GetCloudFrontSignedUrlAction.php:14-33`.

## Input

- `string $key`: chiave dell'oggetto; gli slash iniziali sono rimossi (`ltrim`).
- `int $expiry = 30`: durata in **minuti** (moltiplicata per 60 alla riga 29).

## Output

- `string`: URL firmato restituito da `CloudFrontClient::getSignedUrl()`.

## Invarianti

- **GET-CLOUD-FRONT-SIGNED-URL-INV-1** — L'URL è `base_url` + `/` + chiave senza slash iniziali; la scadenza è `time() + expiry * 60`.
  Test: nessuno sul comportamento; `tests/Unit/Actions/MediaActionsCoverageTest.php:258-264` verifica solo classe e metodo `execute`.
- **GET-CLOUD-FRONT-SIGNED-URL-INV-2** — Configurazione letta da `CloudFrontData::make()` (namespace `services.cloudfront`: `base_url`, `key_pair_id`, chiave privata, `region`).
  Test: nessuno.

## Effetti collaterali

- Nessuna scrittura. Crea un `CloudFrontClient` a ogni chiamata; la firma è calcolata localmente con la chiave privata.

## Errori

- Le eccezioni del SDK AWS (chiave privata non valida, configurazione mancante) si propagano; l'Action non le gestisce.

## Non fa

- Non verifica che la chiave esista nel bucket.
- Non valida `$expiry`: valori zero o negativi producono URL senza controllo.
- Il tipo di chiave privata è gestito da `CloudFrontData::getPrivateKey()`, non qui.
