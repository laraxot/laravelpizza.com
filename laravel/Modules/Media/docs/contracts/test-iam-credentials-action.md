---
title: "TestIamCredentialsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\TestIamCredentialsAction"
qmd: "TestIamCredentialsAction diagnostica credenziali IAM STS getCallerIdentity account ARN"
---

# TestIamCredentialsAction

Verifica le credenziali chiamando STS `GetCallerIdentity`. Codice: `app/Actions/Diagnostic/Aws/TestIamCredentialsAction.php:17-43`.

## Input

- Nessuno. Usa `CreateFilesystemStsClientAction`.

## Output

- Successo: `status=success`, `details` con `Account`, `ARN`, `User ID` (`Unknown` se assenti).
- `AwsException`: `status=error`, `message` = `IAM credentials error: <codice>`, `details` con `Error` e `Solution` fissa.

## Invarianti

- **TEST-IAM-CREDENTIALS-INV-1** — Una risposta STS valida produce `success` con i tre campi identità.
  Test: nessuno.
- **TEST-IAM-CREDENTIALS-INV-2** — `AwsException` non esce dall'Action: diventa `status=error`.
  Test: nessuno.

## Effetti collaterali

- Una chiamata di rete STS `GetCallerIdentity` (sola lettura).

## Errori

- `AwsException` convertito in array di errore. Altre eccezioni si propagano.

## Non fa

- Non verifica le policy IAM (lo fa `TestIamPoliciesAction`, con S3).
- Duplica la chiamata STS di `Diagnostic/S3/TestCredentialsAction` con una forma di output diversa.
