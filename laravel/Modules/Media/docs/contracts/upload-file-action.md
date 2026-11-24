---
title: "UploadFileAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\S3\\UploadFileAction"
qmd: "UploadFileAction S3 upload file locale ObjectUploader ACL private content type multipart"
---

# UploadFileAction

Carica un file locale su S3 con `ObjectUploader` (multipart automatico per i file grandi). Codice: `app/Actions/S3/UploadFileAction.php:26-112`.

## Input

- `string $localFilePath`: file locale leggibile.
- `string $destinationFilePath`: chiave S3 di destinazione.
- `array<string, mixed> $options`: opzioni AWS, unite a un default (`ACL=private`, `ContentType` da `mime_content_type` o `application/octet-stream`); i valori passati vincono.

## Output

- Successo: `['success' => true, 'objectUrl', 'etag', 'key', 'bucket']`.
- Errore: `['success' => false, 'error' => messaggio]` (con `errorTrace` per le eccezioni in upload).

## Invarianti

- **UPLOAD-FILE-INV-1** — Un file inesistente o non leggibile non produce eccezione: restituisce `success=false` e registra un errore; nessuna richiesta a S3.
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:49` (file mancante); `tests/Unit/Actions/MediaActionsCoverageTest.php:176` (solo struttura).
- **UPLOAD-FILE-INV-2** — L'ACL inviata è `private` salvo override esplicito in `$options`.
  Test: nessuno.
- **UPLOAD-FILE-INV-3** — Il file sorgente è chiuso sia in successo sia in eccezione.
  Test: nessuno.

## Effetti collaterali

- Scrittura su S3 (oggetto con ACL `private` di default). Log `info` a inizio e fine, `error` in caso di errore.
- Nessuna cancellazione del file locale.

## Errori

- Eccezioni dell'upload o di `Safe` convertite in `success=false` con `errorTrace` (stack trace restituito al chiamante).

## Non fa

- Non verifica il checksum dopo il caricamento.
- Restituisce lo stack trace al chiamante: se il valore raggiunge l'interfaccia, espone dettagli interni (dubbio sull'uso reale, non verificato).
