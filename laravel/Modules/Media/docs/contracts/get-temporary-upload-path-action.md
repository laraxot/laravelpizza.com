---
title: "GetTemporaryUploadPathAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\TemporaryUpload\\GetTemporaryUploadPathAction"
qmd: "GetTemporaryUploadPathAction percorso upload temporaneo originale tmp md5 chiave intera Assert"
---

# GetTemporaryUploadPathAction

Calcola il percorso `tmp/` dell'upload originale di un media. Codice: `app/Actions/TemporaryUpload/GetTemporaryUploadPathAction.php:14-25`.

## Input

- `Media $media`: servono `uuid`, `id` (chiave) e `uuid`.

## Output

- `string`: `tmp/<md5(uuid+id)>/<md5(id+uuid+'original')>/`, con slash finale.

## Invarianti

- **GET-TEMPORARY-UPLOAD-PATH-INV-1** — Per una chiave stringa il risultato è identico a `GenerateTemporaryUploadPathAction::execute($media, 'original')`.
  Test: nessuno esplicito.
- **GET-TEMPORARY-UPLOAD-PATH-INV-2** — Una chiave intera fa fallire `Assert::string` (`InvalidArgumentException`).
  Test: nessuno. Divergenza documentata in `generate-temporary-upload-path-action.md`.

## Effetti collaterali

- Nessuno.

## Errori

- `Webmozart\Assert` per chiave non stringa (vedi INV-2).

## Non fa

- Non crea cartelle né pulisce i temporanei.
- `md5` non è una funzione di sicurezza: l'Action è nel debito `security` di `tests/Arch/debt.php`.
