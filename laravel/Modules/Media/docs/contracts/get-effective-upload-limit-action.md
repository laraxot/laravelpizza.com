---
title: "GetEffectiveUploadLimitAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Upload\\GetEffectiveUploadLimitAction"
qmd: "GetEffectiveUploadLimitAction limite upload effettivo byte PHP upload_max_filesize Livewire max campo"
---

# GetEffectiveUploadLimitAction

Calcola il numero massimo di byte che un upload temporaneo Livewire può davvero portare nella richiesta web. Codice: `app/Actions/Upload/GetEffectiveUploadLimitAction.php:20-57`.

## Input

- `?int $fieldMaxKb = null`: limite del campo, in kilobyte; `null` non lo applica.

## Output

- `int`: il minimo tra tre limiti in byte: 90% di `UploadedFile::getMaxFilesize()` (PHP), `livewire.temporary_file_upload.rules` (regola `max:` in kilobyte, default 12288) e il limite del campo.

## Invarianti

- **GET-EFFECTIVE-UPLOAD-LIMIT-INV-1** — Il risultato non supera mai il limite PHP ridotto del 10% per il multipart.
  Test: `tests/Unit/Actions/Upload/GetEffectiveUploadLimitActionTest.php:22` e `:26` (confronto con soglie).
- **GET-EFFECTIVE-UPLOAD-LIMIT-INV-2** — Senza regola `max:` in Livewire il default è 12288 KB.
  Test: nessuno esplicito.

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno.

## Non fa

- Non legge il limite di nginx (`client_max_body_size`): PHP non lo vede.
- Una regola `max:` con valore non numerico diventa `0` e il limite risultante è `0` (dubbio: nessun test lo copre).
- Va valutato dentro la richiesta web: la CLI può leggere un `php.ini` diverso.
