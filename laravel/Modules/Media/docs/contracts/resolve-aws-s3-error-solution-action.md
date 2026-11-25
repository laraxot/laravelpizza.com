---
title: "ResolveAwsS3ErrorSolutionAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\ResolveAwsS3ErrorSolutionAction"
qmd: "ResolveAwsS3ErrorSolutionAction codice errore AWS S3 soluzione suggerita diagnostica"
---

# ResolveAwsS3ErrorSolutionAction

Traduce un codice di errore AWS S3 in un suggerimento testuale. Codice: `app/Actions/Diagnostic/Aws/ResolveAwsS3ErrorSolutionAction.php:13-28`.

## Input

- `?string $errorCode`: codice AWS, oppure `null`.

## Output

- `string`: suggerimento. Mappa fissa di cinque codici (`SignatureDoesNotMatch`, `AccessDenied`, `NoSuchBucket`, `InvalidAccessKeyId`, `BucketRegionError`).

## Invarianti

- **RESOLVE-AWS-S3-ERROR-SOLUTION-INV-1** — `null` restituisce il messaggio fisso «Unknown error - check AWS credentials and configuration».
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:33` (verifica il messaggio).
- **RESOLVE-AWS-S3-ERROR-SOLUTION-INV-2** — Un codice fuori mappa produce «Consult AWS documentation for error: <codice>».
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:33` (solo per i casi verificati nel test).

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno.

## Non fa

- Non chiama AWS e non verifica che il codice sia reale.
