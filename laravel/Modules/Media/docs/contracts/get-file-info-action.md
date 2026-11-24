---
title: "GetFileInfoAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\S3\\GetFileInfoAction"
qmd: "GetFileInfoAction S3 headObject metadati dimensione content type etag esistenza"
---

# GetFileInfoAction

Legge i metadati di un oggetto con `headObject`, senza scaricarlo. Codice: `app/Actions/S3/GetFileInfoAction.php:10-66`.

## Input

- `string $key`: chiave dell'oggetto.

## Output

- Successo: `exists=true` con `key`, `effectiveUri`, `contentLength`, `contentType`, `lastModified`, `etag`, `metadata` (valori `null` o `[]` se assenti).
- Errore S3: `exists=false` con `error` e `errorCode` (status HTTP).

## Invarianti

- **GET-FILE-INFO-INV-1** — Il successo non scarica il corpo dell'oggetto.
  Test: nessuno.
- **GET-FILE-INFO-INV-2** — Ogni `S3Exception` diventa `exists=false`: anche un 403 risulta come «non esiste».
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:57` (chiave mancante); `tests/Unit/Actions/MediaActionsCoverageTest.php:204` (solo struttura).

## Effetti collaterali

- Una richiesta HEAD di sola lettura e una riga di log.

## Errori

- `S3Exception` convertito nell'array di esito.

## Non fa

- Non distingue «assente» da «negato» (vedi INV-2).
