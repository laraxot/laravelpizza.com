---
title: "GetTemporaryUploadResponsivePathAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\TemporaryUpload\\GetTemporaryUploadResponsivePathAction"
qmd: "GetTemporaryUploadResponsivePathAction percorso immagini responsive upload temporaneo tmp md5 chiave intera Assert"
---

# GetTemporaryUploadResponsivePathAction

Calcola il percorso `tmp/` delle immagini responsive di un upload temporaneo. Codice: `app/Actions/TemporaryUpload/GetTemporaryUploadResponsivePathAction.php:14-25`.

## Input

- `Media $media`: servono `uuid` e chiave.

## Output

- `string`: `tmp/<md5(uuid+id)>/<md5(id+uuid+'responsive')>`, senza slash finale.

## Invarianti

- **GET-TEMPORARY-UPLOAD-RESPONSIVE-PATH-INV-1** — Con chiave stringa il risultato è identico a `GenerateTemporaryUploadPathAction::execute($media, 'responsive')`.
  Test: nessuno esplicito.
- **GET-TEMPORARY-UPLOAD-RESPONSIVE-PATH-INV-2** — Con chiave intera fa fallire `Assert::string`.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- `Webmozart\Assert` per chiave non stringa.

## Non fa

- Duplica il calcolo di `GenerateTemporaryUploadPathAction`.
- `md5` è nel debito `security` di `tests/Arch/debt.php`.
