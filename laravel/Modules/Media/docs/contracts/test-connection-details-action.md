---
title: "TestConnectionDetailsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\TestConnectionDetailsAction"
qmd: "TestConnectionDetailsAction diagnostica connessione S3 region bucket getBucketLocation mismatch"
---

# TestConnectionDetailsAction

Verifica il bucket con `headBucket`, legge la sua region con `getBucketLocation` e la confronta con la config. Codice: `app/Actions/Diagnostic/S3/TestConnectionDetailsAction.php:19-53`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Successo: `status=success`, `data` con `Bucket Accessible`, `Bucket Region`, `Config Region`, `Region Match` (✅ o ⚠️).
- `AwsException`: `status=error` con `Error Code`, `Message`, `Solution`.

## Invarianti

- **TEST-CONNECTION-DETAILS-INV-1** — Una `LocationConstraint` vuota è letta come `us-east-1`.
  Test: nessuno.
- **TEST-CONNECTION-DETAILS-INV-2** — Un mismatch di region non cambia lo `status`: resta `success` con l'avviso nel `Region Match`.
  Test: nessuno.

## Effetti collaterali

- Due richieste di sola lettura (`headBucket`, `getBucketLocation`).

## Errori

- `AwsException` convertito in `status=error`.

## Non fa

- Non confronta le credenziali né le policy.
