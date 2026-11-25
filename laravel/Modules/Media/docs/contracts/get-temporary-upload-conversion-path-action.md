---
title: "GetTemporaryUploadConversionPathAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\TemporaryUpload\\GetTemporaryUploadConversionPathAction"
qmd: "GetTemporaryUploadConversionPathAction percorso conversioni upload temporaneo tmp md5 chiave intera Assert"
---

# GetTemporaryUploadConversionPathAction

Calcola il percorso `tmp/` delle conversioni di un upload temporaneo. Codice: `app/Actions/TemporaryUpload/GetTemporaryUploadConversionPathAction.php:14-25`.

## Input

- `Media $media`: servono `uuid` e chiave.

## Output

- `string`: `tmp/<md5(uuid+id)>/<md5(id+uuid+'conversion')>`, senza slash finale.

## Invarianti

- **GET-TEMPORARY-UPLOAD-CONVERSION-PATH-INV-1** — Con chiave stringa il risultato è identico a `GenerateTemporaryUploadPathAction::execute($media, 'conversion')`.
  Test: nessuno esplicito.
- **GET-TEMPORARY-UPLOAD-CONVERSION-PATH-INV-2** — Con chiave intera fa fallire `Assert::string`: diverso dal fratello `GenerateTemporaryUploadPathAction`, che usa `Assert::scalar`.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- `Webmozart\Assert` per chiave non stringa.

## Non fa

- Duplica il calcolo di `GenerateTemporaryUploadPathAction`; la versione corretta è quella.
- `md5` è nel debito `security` di `tests/Arch/debt.php`.
