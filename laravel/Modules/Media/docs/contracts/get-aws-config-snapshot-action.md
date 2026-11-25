---
title: "GetAwsConfigSnapshotAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\GetAwsConfigSnapshotAction"
qmd: "GetAwsConfigSnapshotAction snapshot configurazione AWS diagnostica chiave mascherata CloudFront"
---

# GetAwsConfigSnapshotAction

Restituisce uno snapshot delle variabili AWS e CloudFront, con la chiave di accesso troncata. Codice: `app/Actions/Diagnostic/Aws/GetAwsConfigSnapshotAction.php:18-31`.

## Input

- Nessuno. Legge `filesystems.disks.s3.{key,region,bucket}` e `filesystems.cloudfront.{url,key_pair_id}`.

## Output

- `array<string, mixed>` con le chiavi `AWS_ACCESS_KEY_ID`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `CLOUDFRONT_URL`, `CLOUDFRONT_KEY_PAIR_ID`.

## Invarianti

- **GET-AWS-CONFIG-SNAPSHOT-INV-1** — `AWS_ACCESS_KEY_ID` mostra i primi 8 caratteri seguiti da `...`; il segreto non compare mai nell'output.
  Test: nessuno.
- **GET-AWS-CONFIG-SNAPSHOT-INV-2** — Se la chiave non è una stringa il valore è `''`.
  Test: nessuno.

## Effetti collaterali

- Nessuno: sola lettura di configurazione, nessuna I/O.

## Errori

- Nessuno.

## Non fa

- Una chiave con meno di 8 caratteri viene mostrata intera, seguita da `...`.
- `filesystems.cloudfront` non esiste in `config/filesystems.php`: i due valori CloudFront sono sempre `null`. Le credenziali CloudFront reali sono in `config/services.php` (`services.cloudfront`), letta da `CloudFrontData`.
