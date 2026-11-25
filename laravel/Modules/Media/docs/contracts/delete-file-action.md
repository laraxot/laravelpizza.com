---
title: "DeleteFileAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\S3\\DeleteFileAction"
qmd: "DeleteFileAction S3 deleteObject cancellazione file errore array success delete marker"
---

# DeleteFileAction

Cancella un oggetto dal bucket e restituisce un array di esito. Non lancia. Codice: `app/Actions/S3/DeleteFileAction.php:10-53`.

## Input

- `string $key`: chiave dell'oggetto.

## Output

- Successo: `['success' => true, 'key', 'deleteMarker', 'versionId']`.
- Errore S3: `['success' => false, 'key', 'error' => messaggio, 'errorCode' => status HTTP]`.

## Invarianti

- **DELETE-FILE-INV-1** — Ogni `S3Exception` diventa `success=false`: il chiamante deve leggere `success`.
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:64` (cancellazione di una chiave mancante); `tests/Unit/Actions/MediaActionsCoverageTest.php:190` (solo struttura).
- **DELETE-FILE-INV-2** — `deleteMarker` e `versionId` sono `false` e `null` quando il bucket non ha versioning.
  Test: nessuno.

## Effetti collaterali

- Una richiesta DELETE su S3; sui bucket versionati aggiunge un delete marker. Log `info` o `error`.

## Errori

- `S3Exception` convertito nell'array di errore. Altre eccezioni si propagano.

## Non fa

- Non verifica che la chiave esista prima di cancellare.
- `errorCode` è lo status HTTP (intero), non il codice AWS.
