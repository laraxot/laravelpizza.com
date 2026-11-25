---
title: "Topic get-temporary"
type: digest
status: active
qmd: "digest ceiling 100 get-temporary"
---

# Topic get-temporary

Sintesi automatica di 4 documenti (chiave `get-temporary`).

## GetTemporaryUploadConversionPathAction

_Fonte: `contracts/get-temporary-upload-conversion-path-action.md`_

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

## GetTemporaryUploadPathAction

_Fonte: `contracts/get-temporary-upload-path-action.md`_

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

## GetTemporaryUploadResponsivePathAction

_Fonte: `contracts/get-temporary-upload-responsive-path-action.md`_

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

## Topic get-temporary

_Fonte: `wiki/topics/get-temporary.md`_

# Topic get-temporary

Sintesi automatica di 4 documenti (chiave `get-temporary`).

## GetTemporaryUploadConversionPathAction

_Fonte: `contracts/get-temporary-upload-conversion-path-action.md`_

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
