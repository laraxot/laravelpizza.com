---
title: "TestS3ConnectionAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\TestS3ConnectionAction"
qmd: "TestS3ConnectionAction diagnostica connessione S3 headBucket bucket soluzione errore"
---

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

- Non verifica permessi di lista o scrittura, né la region reale del bucket (lo fa `Diagnostic/S3/TestConnectionDetailsAction`).
