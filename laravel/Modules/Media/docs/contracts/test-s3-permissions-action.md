---
title: "TestS3PermissionsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\TestS3PermissionsAction"
qmd: "TestS3PermissionsAction diagnostica permessi S3 listObjectsV2 bucket soluzione"
---

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
- Duplica la logica di `Diagnostic/S3/TestBucketPermissionsAction` con un'altra forma di output.
