---
title: "RunS3SaveTestAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\RunS3SaveTestAction"
qmd: "RunS3SaveTestAction diagnostica salvataggio S3 file test URL CloudFront temporaneo allegato"
---

# RunS3SaveTestAction

Salva un file di prova sul disco `s3`, genera URL CloudFront e temporanei, poi cancella il file di prova. Codice: `app/Actions/Diagnostic/S3/RunS3SaveTestAction.php:19-50`.

## Input

- `?string $attachmentPath`: percorso di un allegato da includere nel test; `null` o vuoto lo salta.
- `string $testFilePrefix = 'test-upload-'`: prefisso del file di prova (il nome aggiunge `time()` e `.txt`).

## Output

- `array`: `test_file` con `path`, `cloudfront_url` (5 min), `temporary_url` (5 min); `uploaded_file` a `null` oppure con gli stessi campi per l'allegato (30 min).

## Invarianti

- **RUN-S3-SAVE-TEST-INV-1** — Il file di prova è cancellato al termine del flusso normale.
  Test: nessuno.
- **RUN-S3-SAVE-TEST-INV-2** — `uploaded_file` è valorizzato solo se `$attachmentPath` non è vuoto.
  Test: nessuno.

## Effetti collaterali

- Scrittura S3 (`put`) del file di prova, poi `delete`. L'esito di `put` e `delete` non viene verificato.
- Nessuna transazione. Se un'eccezione cade tra `put` e `delete`, il file di prova resta nel bucket.

## Errori

- Nessuno gestito: le eccezioni di S3 e della firma CloudFront si propagano.

## Non fa

- Non verifica che gli URL siano raggiungibili (nessuna richiesta HTTP).
- Non controlla che l'allegato esista sul disco.
