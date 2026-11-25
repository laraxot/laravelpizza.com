---
title: "TestCloudFrontConnectionAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\TestCloudFrontConnectionAction"
qmd: "TestCloudFrontConnectionAction diagnostica connessione CloudFront URL firmato configurazione incompleta"
---

# TestCloudFrontConnectionAction

Controlla che la config CloudFront sia completa e genera un URL firmato di prova. Codice: `app/Actions/Diagnostic/S3/TestCloudFrontConnectionAction.php:20-76`.

## Input

- `string $testFile = 'test-file.txt'`: chiave usata per il URL di prova.

## Output

- Config incompleta: `status=error`, `Configuration = ❌ Incomplete`, `Missing` con i nomi dei valori assenti.
- Config completa e firma riuscita: `status=success`, `Sample URL` (primi 100 caratteri + `...`).
- Eccezione: `status=error` con `Error`.

## Invarianti

- **TEST-CLOUD-FRONT-CONNECTION-INV-1** — Senza `base_url`, `key_pair_id` o chiave privata non viene tentata nessuna firma.
  Test: nessuno.
- **TEST-CLOUD-FRONT-CONNECTION-INV-2** — Con config completa l'URL di prova è generato da `GetCloudFrontSignedUrlAction` con scadenza 5 minuti.
  Test: nessuno.

## Effetti collaterali

- Nessuno: la firma è locale, nessuna richiesta HTTP a CloudFront.

## Errori

- Eccezioni catturate e restituite come `status=error`.

## Non fa

- Non apre alcuna connessione a CloudFront: l'URL non viene richiesto.
