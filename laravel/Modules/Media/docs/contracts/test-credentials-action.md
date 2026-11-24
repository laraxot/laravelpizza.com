---
title: "TestCredentialsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\TestCredentialsAction"
qmd: "TestCredentialsAction diagnostica credenziali AWS STS account ARN valide"
---

# TestCredentialsAction

Verifica le credenziali con STS `GetCallerIdentity` e restituisce account e ARN. Codice: `app/Actions/Diagnostic/S3/TestCredentialsAction.php:18-43`.

## Input

- Nessuno. Usa `CreateFilesystemStsClientAction`.

## Output

- Successo: `status=success`, `data` con `Valid = ✅ Yes`, `Account ID`, `User ARN`.
- `AwsException`: `status=error`, `data` con `Valid = ❌ No`, `Error` (codice), `Message`.

## Invarianti

- **TEST-CREDENTIALS-INV-1** — Una risposta valida produce `success` con account e ARN.
  Test: nessuno.
- **TEST-CREDENTIALS-INV-2** — `AwsException` diventa `status=error`.
  Test: nessuno.

## Effetti collaterali

- Una chiamata STS di sola lettura.

## Errori

- `AwsException` convertito in array di errore. Altre eccezioni si propagano.

## Non fa

- Non verifica le policy.
- Accede a `$result['Account']` e `$result['Arn']` senza fallback (a differenza di `Aws/TestIamCredentialsAction`): una risposta senza quelle chiavi produce un avviso PHP.
