---
title: "GetVideoScreenshotAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Video\\GetVideoScreenshotAction"
qmd: "GetVideoScreenshotAction screenshot video stub backoff nessun execute non implementata"
---

# GetVideoScreenshotAction

Classe senza logica: dichiara solo la proprietà `$backoff = 3` e usa il trait `QueueableAction`. Codice: `app/Actions/Video/GetVideoScreenshotAction.php:12-21`.

## Input

- Nessuno.

## Output

- Nessuno.

## Invarianti

- **GET-VIDEO-SCREENSHOT-INV-1** — La classe non espone `execute()`: una chiamata diretta fallisce con `Call to undefined method`.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:122-128` verifica solo la proprietà `backoff`.

## Effetti collaterali

- Nessuno.

## Errori

- `Error` di PHP alla chiamata di `execute()`.

## Non fa

- Non genera screenshot. Nessun chiamante in `app/`, `Modules/` o `config/` (verificato con grep): è uno stub.
