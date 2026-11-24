---
title: "TestBucketPermissionsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\TestBucketPermissionsAction"
qmd: "TestBucketPermissionsAction diagnostica permessi bucket S3 list put get delete oggetto test"
---

# TestBucketPermissionsAction

Prova in sequenza i permessi del bucket: list, put, get, delete di un oggetto di prova. Codice: `app/Actions/Diagnostic/S3/TestBucketPermissionsAction.php:22-112`.

## Input

- `string $testKeyPrefix = 'test-permissions-'`: prefisso della chiave di prova (aggiunge `time()` e `.txt`).

## Output

- `array`: `title` (`🔒 S3 Permissions`), `status`, `data` con `ListBucket`, `PutObject`, `GetObject`, `DeleteObject` (✅ OK o ❌ codice). Se la put fallisce, get e delete sono `Skipped`.

## Invarianti

- **TEST-BUCKET-PERMISSIONS-INV-1** — Se nessuna eccezione esce, lo `status` è sempre `success`, anche quando una probe fallisce: `success` indica solo che la diagnostica è stata completata.
  Test: nessuno.
- **TEST-BUCKET-PERMISSIONS-INV-2** — Se la put fallisce, get e delete non vengono provate.
  Test: nessuno.

## Effetti collaterali

- Scrive un oggetto reale (`ACL private`) nel bucket, poi prova get e delete. Se la delete fallisce l'oggetto resta.

## Errori

- Qualsiasi `Exception` è catturata e restituita come `status=error` con il messaggio in `data.Error`.

## Non fa

- Non legge policy o IAM: prova solo le operazioni.
- Duplica la logica di `Aws/TestS3PermissionsAction` e `Aws/TestS3FileOperationsAction` con un'altra forma di output.
