---
title: "TestS3FileOperationsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\TestS3FileOperationsAction"
qmd: "TestS3FileOperationsAction diagnostica upload download delete oggetto test S3 bucket"
---

# TestS3FileOperationsAction

Prova su S3 un ciclo completo: scrittura di un file di test, lettura, cancellazione. Codice: `app/Actions/Diagnostic/Aws/TestS3FileOperationsAction.php:17-57`.

## Input

- Nessuno. Il nome del file è `test-file-<timestamp>.txt`, il contenuto una stringa fissa.

## Output

- Successo: `status=success` con `Upload`, `Download`, `Delete` sempre `OK` e il nome del file di test.
- `AwsException`: `status=error`, `message` = `S3 file operations error: <codice>`.

## Invarianti

- **TEST-S3-FILE-OPERATIONS-INV-1** — Il successo richiede `putObject`, `getObject` e `deleteObject` senza eccezioni.
  Test: nessuno.
- **TEST-S3-FILE-OPERATIONS-INV-2** — Il contenuto letto non viene confrontato con quello scritto.
  Test: nessuno.

## Effetti collaterali

- Scrive, legge ed elimina un oggetto nel bucket configurato. Nessun `try/finally`: se `getObject` o `deleteObject` falliscono dopo la scrittura, l'oggetto di test resta nel bucket.

## Errori

- `AwsException` convertito in array di errore.

## Non fa

- Non pulisce il file residuo in caso di errore parziale.
- Non valida il contenuto letto.
