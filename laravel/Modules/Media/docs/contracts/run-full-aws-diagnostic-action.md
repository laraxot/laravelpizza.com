---
title: "RunFullAwsDiagnosticAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\Aws\\RunFullAwsDiagnosticAction"
qmd: "RunFullAwsDiagnosticAction diagnostica completa AWS S3 CloudFront IAM esegue tutti i test"
---

# RunFullAwsDiagnosticAction

Esegue in sequenza sette diagnostiche AWS e raccoglie i risultati per chiave. Codice: `app/Actions/Diagnostic/Aws/RunFullAwsDiagnosticAction.php:16-27`.

## Input

- Nessuno. Le diagnostiche leggono la configurazione `filesystems`.

## Output

- `array<string, mixed>` con le chiavi `s3`, `s3_permissions`, `s3_operations`, `cloudfront`, `cloudfront_signed`, `iam_credentials`, `iam_policies`. Ogni valore è l'array restituito dalla singola `Test*Action`.

## Invarianti

- **RUN-FULL-AWS-DIAGNOSTIC-INV-1** — Le chiavi sono sempre queste sette, nello stesso ordine, e ognuna contiene il risultato della propria Action.
  Test: nessuno.

## Effetti collaterali

- Chiamate AWS reali in sequenza: `TestS3FileOperationsAction` scrive, legge ed elimina un oggetto `test-file-<timestamp>.txt` nel bucket configurato; `TestIamCredentialsAction` chiama STS; le altre fanno solo letture (HEAD, list).
- Nessuna transazione, nessun evento, nessuna coda.

## Errori

- Gli `AwsException` sono assorbiti dalle singole Action. Altre eccezioni (es. errori di configurazione del client) si propagano e interrompono l'intera diagnostica.

## Non fa

- Non ha guardie: esegue la scrittura di test anche sul bucket di produzione se la configurazione lo punta lì.
- Non ha cache né timeout proprio.
