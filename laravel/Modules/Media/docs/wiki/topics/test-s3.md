---
title: "Topic test-s3"
type: digest
status: active
qmd: "digest ceiling 100 test-s3"
---

# Topic test-s3

Sintesi automatica di 4 documenti (chiave `test-s3`).

## TestS3ConnectionAction

_Fonte: `contracts/test-s3-connection-action.md`_

# TestS3ConnectionAction

Verifica la raggiungibilità del bucket con `headBucket`. Codice: `app/Actions/Diagnostic/Aws/TestS3ConnectionAction.php:17-45`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Successo: `status=success`, `message` fisso, `details` con `Bucket` e `Region` (dalla config).
- `AwsException`: `status=error`, `message` = solo il codice AWS (non il prefisso usato dalle altre diagnostiche), `details` con `Error` e `Solution` (da `ResolveAwsS3ErrorSolutionAction`).

## Invarianti

- **TEST-S3-CONNECTION-INV-1** — Il successo dipende solo da `headBucket` riuscito.
  Test: nessuno.
- **TEST-S3-CONNECTION-INV-2** — `AwsException` diventa `status=error`; il messaggio è il solo codice (o `UnknownError`).
  Test: nessuno.

## Effetti collaterali

- Una richiesta HEAD di sola lettura.

## Errori

- `AwsException` convertito in array di errore.

## Non fa

## TestS3FileOperationsAction

_Fonte: `contracts/test-s3-file-operations-action.md`_

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

## TestS3PermissionsAction

_Fonte: `contracts/test-s3-permissions-action.md`_

# TestS3PermissionsAction

Verifica il permesso di listare il bucket con `listObjectsV2` (`MaxKeys=1`). Codice: `app/Actions/Diagnostic/Aws/TestS3PermissionsAction.php:17-45`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Successo: `status=success`, `details` con `ListObjects=OK` e `Bucket`.
- `AwsException`: `status=error`, `message` = `S3 permissions error: <codice>`, `Solution` da `ResolveAwsS3ErrorSolutionAction`.

## Invarianti

- **TEST-S3-PERMISSIONS-INV-1** — Il successo dipende solo da `listObjectsV2` riuscito.
  Test: nessuno.

## Effetti collaterali

- Una richiesta di sola lettura.

## Errori

- `AwsException` convertito in array di errore.

## Non fa

- Non prova scrittura né cancellazione (lo fa `TestS3FileOperationsAction`).

## Topic test-s3

_Fonte: `wiki/topics/test-s3.md`_

# Topic test-s3

Sintesi automatica di 4 documenti (chiave `test-s3`).

## TestS3ConnectionAction

_Fonte: `contracts/test-s3-connection-action.md`_

# TestS3ConnectionAction

Verifica la raggiungibilità del bucket con `headBucket`. Codice: `app/Actions/Diagnostic/Aws/TestS3ConnectionAction.php:17-45`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Successo: `status=success`, `message` fisso, `details` con `Bucket` e `Region` (dalla config).
- `AwsException`: `status=error`, `message` = solo il codice AWS (non il prefisso usato dalle altre diagnostiche), `details` con `Error` e `Solution` (da `ResolveAwsS3ErrorSolutionAction`).

## Invarianti

- **TEST-S3-CONNECTION-INV-1** — Il successo dipende solo da `headBucket` riuscito.
  Test: nessuno.
- **TEST-S3-CONNECTION-INV-2** — `AwsException` diventa `status=error`; il messaggio è il solo codice (o `UnknownError`).
  Test: nessuno.

## Effetti collaterali
