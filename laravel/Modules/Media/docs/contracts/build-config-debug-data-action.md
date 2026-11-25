---
title: "BuildConfigDebugDataAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\BuildConfigDebugDataAction"
qmd: "BuildConfigDebugDataAction diagnostica S3 configurazione debug segreto mascherato presenza CloudFront"
---

# BuildConfigDebugDataAction

Compone il blocco «Configurazione» della diagnostica S3, mostrando i valori senza esporre i segreti. Codice: `app/Actions/Diagnostic/S3/BuildConfigDebugDataAction.php:16-38`.

## Input

- Nessuno. Legge `filesystems.disks.s3.*` e `services.cloudfront.*`.

## Output

- `array<string, mixed>`: `title` (`📋 Configuration`), `status=info`, `data` con chiave AWS troncata, presenza (✅/❌) di secret e chiave privata CloudFront, region, bucket, `AWS_USE_PATH_STYLE_ENDPOINT` (default `'false'`), URL e key pair CloudFront.

## Invarianti

- **BUILD-CONFIG-DEBUG-DATA-INV-1** — Il segreto AWS e la chiave privata CloudFront compaiono solo come presenza, mai come valore.
  Test: nessuno.
- **BUILD-CONFIG-DEBUG-DATA-INV-2** — La chiave di accesso è troncata a 8 caratteri più `...`.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno.

## Non fa

- Non valida la configurazione.
- Legge CloudFront da `services.cloudfront`, mentre `Aws/GetAwsConfigSnapshotAction` e `Aws/TestCloudFrontConfigAction` leggono `filesystems.cloudfront` (non definito): le due diagnostiche danno risultati diversi.
