---
title: "GetVideoDurationAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Video\\GetVideoDurationAction"
qmd: "GetVideoDurationAction durata video secondi FFprobe disco file mancante null"
---

# GetVideoDurationAction

Restituisce la durata in secondi di un video sul disco. Codice: `app/Actions/Video/GetVideoDurationAction.php:14-25`.

## Input

- `string $disk`, `string $file`.

## Output

- `?int`: `null` se il file non esiste; altrimenti la durata restituita da `getDurationInSeconds()`.

## Invarianti

- **GET-VIDEO-DURATION-INV-1** — File assente → `null`, senza avviare FFmpeg.
  Test: nessuno sul comportamento; `tests/Unit/Actions/MediaActionsCoverageTest.php:158-164` verifica solo classe e metodo.

## Effetti collaterali

- Lettura del file tramite FFprobe. Nessuna scrittura.

## Errori

- Le eccezioni di FFmpeg su file corrotto si propagano.

## Non fa

- Non cachea il risultato.
