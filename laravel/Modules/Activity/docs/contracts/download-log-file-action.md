---
title: "Contratto: DownloadLogFileAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-25
action: "Modules\\Activity\\Actions\\Log\\DownloadLogFileAction"
qmd: "contract DownloadLogFileAction activity log download file BinaryFileResponse streaming storage logs"
related:
  - ../log-viewer.md
  - ../adr/0003-log-viewer-single-path-resolver.md
  - get-log-file-path-action.md
  - ../../app/Actions/Log/DownloadLogFileAction.php
  - ../../tests/Unit/Actions/Log/DownloadLogFileActionTest.php
---

# DownloadLogFileAction

Risposta HTTP di download per un file di log scelto dall'utente. Il percorso passa da `GetLogFilePathAction`.

## Input

- `string $file`: percorso relativo alla cartella dei log (`storage/logs`).

## Output

- `BinaryFileResponse`: nome file = percorso relativo con `/` sostituito da `_` (`reports/daily.log` diventa `reports_daily.log`), `Content-Type: text/plain; charset=UTF-8`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| ACT-LOGDL-INV-1 | Un file fuori dalla cartella dei log, non `.log`, vuoto, assoluto o inesistente non produce risposta: viene rilanciata `InvalidLogFileException`. | `DownloadLogFileActionTest.php` |
| ACT-LOGDL-INV-2 | La risposta e' `BinaryFileResponse`: il file e' letto a blocchi dal disco, non caricato in memoria ne' codificato in base64. | `DownloadLogFileActionTest.php` |
| ACT-LOGDL-INV-3 | Il nome del download non contiene `/`. | nessuno |

## Effetti collaterali

- Nessuna scrittura. Il file viene letto quando la risposta e' inviata, non in questa Action.

## Errori

- `InvalidLogFileException`, propagata da `GetLogFilePathAction` e non catturata: la pagina e la pagina Folio rispondono 404.

## Non fa

- Non verifica l'autorizzazione: la verificano i chiamanti con `AuthorizeLogAccessAction` (la pagina la ripete anche dentro l'azione di download).
- Non comprime e non taglia il file: il download e' sempre il file intero (la pagina ne mostra solo la coda).
- Se il file sparisce tra la risoluzione e l'invio vale il comportamento di Symfony (non verificato).
