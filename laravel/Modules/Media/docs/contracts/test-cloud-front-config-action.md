---
title: "TestCloudFrontConfigAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\TestCloudFrontConfigAction"
qmd: "TestCloudFrontConfigAction diagnostica configurazione CloudFront base url key pair"
---

# TestCloudFrontConfigAction

Mostra i valori CloudFront letti dalla config, senza verificarli. Codice: `app/Actions/Diagnostic/Aws/TestCloudFrontConfigAction.php:17-38`.

## Input

- Nessuno. Legge `filesystems.cloudfront.url` e `filesystems.cloudfront.key_pair_id`.

## Output

- `array`: `status` (`success` o `error`), `message`, `details` con `Base URL` e `Key Pair ID`.

## Invarianti

- **TEST-CLOUD-FRONT-CONFIG-INV-1** — Il percorso `success` è l'unico eseguito: nessun controllo sui valori, quindi risponde `success` anche con valori `null`.
  Test: nessuno.
- **TEST-CLOUD-FRONT-CONFIG-INV-2** — Il ramo `error` (`catch Exception`) è irraggiungibile: `config()` non lancia eccezioni.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno dichiarato. Il ramo di errore non è raggiungibile.

## Non fa

- Non verifica che le chiavi siano valorizzate: con la config attuale (`filesystems.cloudfront` non definito) risponde `success` con valori `null`.
