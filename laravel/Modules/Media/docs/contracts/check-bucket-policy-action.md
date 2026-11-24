---
title: "CheckBucketPolicyAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\CheckBucketPolicyAction"
qmd: "CheckBucketPolicyAction diagnostica policy bucket S3 NoSuchBucketPolicy JSON"
---

# CheckBucketPolicyAction

Legge la policy del bucket e la mostra formattata. Codice: `app/Actions/Diagnostic/S3/CheckBucketPolicyAction.php:21-57`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Policy presente: `status=info`, `data` con `Policy Exists` e la policy in JSON indentato.
- `NoSuchBucketPolicy`: `status=info`, `Policy Exists = ℹ️ No (This is usually OK)`.
- Altro `AwsException`: `status=error`, `Error` (codice) e `Message`.

## Invarianti

- **CHECK-BUCKET-POLICY-INV-1** — L'assenza di policy (`NoSuchBucketPolicy`) non è un errore.
  Test: nessuno.
- **CHECK-BUCKET-POLICY-INV-2** — Il JSON della policy viene decodificato e ricodificato con indentazione.
  Test: nessuno.

## Effetti collaterali

- Una richiesta di sola lettura (`getBucketPolicy`).

## Errori

- `AwsException` convertito in `status=error`.
- JSON non valido: `Safe\json_decode` lancia un'eccezione che non viene catturata e si propaga.

## Non fa

- Non valuta la policy (nessun controllo di permessi effettivi).
