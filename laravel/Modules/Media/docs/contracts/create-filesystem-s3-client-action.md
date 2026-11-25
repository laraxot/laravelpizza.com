---
title: "CreateFilesystemS3ClientAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\CreateFilesystemS3ClientAction"
qmd: "CreateFilesystemS3ClientAction diagnostica AWS client S3 bucket filesystems config credenziali"
---

# CreateFilesystemS3ClientAction

Costruisce il client S3 e legge il nome del bucket dalla configurazione del disco `s3`. Codice: `app/Actions/Diagnostic/Aws/CreateFilesystemS3ClientAction.php:16-33`.

## Input

- Nessuno. Legge `filesystems.disks.s3.{region,key,secret,bucket}`.

## Output

- `execute()`: `S3Client` (versione `latest`, region con default `eu-west-1` se la chiave non esiste).
- `bucket()`: `string`, oppure `''` se il valore non è una stringa.

## Invarianti

- **CREATE-FILESYSTEM-S3-CLIENT-INV-1** — Il client usa le credenziali del disco `s3` e la region di config, con default `eu-west-1` solo quando la chiave manca.
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:28` (verifica il tipo di ritorno, nient'altro).
- **CREATE-FILESYSTEM-S3-CLIENT-INV-2** — `bucket()` non lancia mai: un valore non stringa diventa `''`.
  Test: nessuno.

## Effetti collaterali

- Nessuno: il client è costruito in memoria, nessuna chiamata di rete.

## Errori

- Nessuno gestito. Un valore `null` esplicito nella config non attiva il default della region.

## Non fa

- Non verifica le credenziali: quello è compito dei consumer (`Test*Action`).
- Non è un `BaseS3Action`: legge la config `filesystems.disks.s3`, mentre `S3/BaseS3Action` legge `media.aws.*`.
