---
title: "CreateFilesystemStsClientAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\CreateFilesystemStsClientAction"
qmd: "CreateFilesystemStsClientAction diagnostica AWS STS client credenziali filesystems config"
---

# CreateFilesystemStsClientAction

Costruisce il client STS con le stesse credenziali e region del disco `s3`. Codice: `app/Actions/Diagnostic/Aws/CreateFilesystemStsClientAction.php:16-26`.

## Input

- Nessuno. Legge `filesystems.disks.s3.{region,key,secret}`.

## Output

- `StsClient` (versione `latest`, region default `eu-west-1`).

## Invarianti

- **CREATE-FILESYSTEM-STS-CLIENT-INV-1** — Il client usa le stesse credenziali e la stessa region del client S3 costruito da `CreateFilesystemS3ClientAction`.
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:29` (solo tipo di ritorno).

## Effetti collaterali

- Nessuno: nessuna chiamata di rete alla costruzione.

## Errori

- Nessuno gestito.

## Non fa

- Non chiama `getCallerIdentity()`: lo fanno `Diagnostic/Aws/TestIamCredentialsAction` e `Diagnostic/S3/TestCredentialsAction`.
