---
title: "ConvertVideoByMediaConvertAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Video\\ConvertVideoByMediaConvertAction"
qmd: "ConvertVideoByMediaConvertAction conversione video MediaConvert progresso percentuale stato completed record"
---

# ConvertVideoByMediaConvertAction

Converte un video secondo `ConvertData` e aggiorna il record `MediaConvert` con il progresso, fino allo stato `completed`. Codice: `app/Actions/Video/ConvertVideoByMediaConvertAction.php:21-64`.

## Input

- `ConvertData $data`: come in `ConvertVideoByConvertDataAction`.
- `MediaConvert $record`: il record da aggiornare; `converted_file` è il percorso di uscita.

## Output

- `string`: `converted_file` del record.

## Invarianti

- **CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-1** — Ad ogni avanzamento di FFmpeg il record riceve `percentage`, `remaining`, `rate`.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:104-110` (solo struttura).
- **CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-2** — Lo stato `completed` è scritto solo dopo un `save()` riuscito.
  Test: nessuno.
- **CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-3** — Sorgente inesistente o `converted_file` vuoto → `Exception`.
  Test: nessuno.

## Effetti collaterali

- Un `UPDATE` sul record per ogni tick di progresso, più un `UPDATE` finale di `status`.
- FFmpeg eseguito in modo sincrono, file scritto sul disco.

## Errori

- `Exception` per sorgente o nome mancante; le eccezioni di FFmpeg si propagano.

## Non fa

- In caso di errore lo stato non passa a un valore di errore: resta quello precedente (ultimo progresso salvato).
- Non usa transazioni.
