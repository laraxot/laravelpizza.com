---
title: "Topic test-cloud"
type: digest
status: active
qmd: "digest ceiling 100 test-cloud"
---

# Topic test-cloud

Sintesi automatica di 4 documenti (chiave `test-cloud`).

## TestCloudFrontConfigAction

_Fonte: `contracts/test-cloud-front-config-action.md`_

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

## TestCloudFrontConnectionAction

_Fonte: `contracts/test-cloud-front-connection-action.md`_

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

## TestCloudFrontSignedUrlsAction

_Fonte: `contracts/test-cloud-front-signed-urls-action.md`_

# TestCloudFrontSignedUrlsAction

Controlla che siano presenti URL base, key pair e chiave privata CloudFront. Non firma alcun URL. Codice: `app/Actions/Diagnostic/Aws/TestCloudFrontSignedUrlsAction.php:17-47`.

## Input

- Nessuno. Legge `filesystems.cloudfront.{private_key,key_pair_id,url}`.

## Output

- `array`: `status`, `message`, `details`.

## Invarianti

- **TEST-CLOUD-FRONT-SIGNED-URLS-INV-1** — `success` solo se i tre valori sono truthy; altrimenti `error` con messaggio «Missing CloudFront configuration» (eccezione interna, catturata).
  Test: nessuno.
- **TEST-CLOUD-FRONT-SIGNED-URLS-INV-2** — La chiave privata non viene letta né validata: il dettaglio è la stringa fissa `Configured`.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- Eccezioni catturate e restituite come `status=error`.

## Non fa

## Topic test-cloud

_Fonte: `wiki/topics/test-cloud.md`_

# Topic test-cloud

Sintesi automatica di 4 documenti (chiave `test-cloud`).

## TestCloudFrontConfigAction

_Fonte: `contracts/test-cloud-front-config-action.md`_

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
