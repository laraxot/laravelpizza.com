---
title: "ConvertVideoByConvertDataAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Video\\ConvertVideoByConvertDataAction"
qmd: "ConvertVideoByConvertDataAction conversione video ConvertData formato preset ultrafast percorso"
---

# ConvertVideoByConvertDataAction

Converte un video secondo un `ConvertData` (formato e nome di uscita) e restituisce il percorso del file prodotto. Codice: `app/Actions/Video/ConvertVideoByConvertDataAction.php:19-52`.

## Input

- `ConvertData $data`: fornisce `exists()`, `getFFMpegFormat()`, `getConvertedFilename()`, `disk`, `file`.

## Output

- `string`: il nome del file convertito (percorso, non URL).

## Invarianti

- **CONVERT-VIDEO-BY-CONVERT-DATA-INV-1** — Sorgente inesistente → `Exception('Il file non esiste')` prima di ogni elaborazione.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:86-92` (solo struttura).
- **CONVERT-VIDEO-BY-CONVERT-DATA-INV-2** — Nome di uscita vuoto → `Exception`.
  Test: nessuno.

## Effetti collaterali

- Esegue FFmpeg in modo sincrono con preset `ultrafast` e scrive l'output sul disco. Nessun aggiornamento del database.

## Errori

- `Exception` generiche per sorgente mancante o nome di uscita vuoto. Le eccezioni di FFmpeg si propagano.

## Non fa

- Non registra il progresso né lo stato.
- Il preset `ultrafast` è fisso.
