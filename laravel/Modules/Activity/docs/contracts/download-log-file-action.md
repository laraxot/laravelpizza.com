---
title: "Contratto — DownloadLogFileAction"
type: contract
action: "Modules\Activity\Actions\Log\DownloadLogFileAction"
tags: [contract, action, log-viewer, download, filesystem]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/log-viewer-single-path-resolver.md
  - resolve-log-file-path-action.md
  - ../../app/Actions/Log/DownloadLogFileAction.php
  - ../../tests/Unit/Actions/Log/DownloadLogFileActionTest.php
---

# DownloadLogFileAction

Risposta di download per un file di log scelto dall'utente nella pagina `LogViewer` (azione Filament di download).
Sorgente: `app/Actions/Log/DownloadLogFileAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/Log/DownloadLogFileActionTest.php`.

## Input

- `string $file`: percorso relativo alla cartella dei log, come lo tiene la pagina.

## Output

- `BinaryFileResponse` con `Content-Type: text/plain; charset=UTF-8` e nome file = percorso relativo con `/` sostituiti da
  `_` (`reports/252/daily.log` → `reports_252_daily.log`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGDOWNLOAD-INV-1 | Il file completo arriva come `BinaryFileResponse` (letto a blocchi dal disco), `text/plain`, con nome senza barre. | `ACTIVITY-LOGDOWNLOAD-INV-1` |
| ACTIVITY-LOGDOWNLOAD-INV-2 | Il percorso passa da `ResolveLogFilePathAction`: file fuori dalla cartella dei log, inesistenti, non `.log`, vuoti o assoluti sono rifiutati. | `ACTIVITY-LOGDOWNLOAD-INV-2` |

## Effetti collaterali

- Apre il file in lettura quando la risposta viene inviata; nessuna scrittura.

## Errori

- `InvalidLogFileException` dal risolutore, non catturata: la pagina la trasforma in 404.

## Non fa

- Non controlla i permessi: la pagina chiama `AuthorizeLogAccessAction` in `canAccess()` e di nuovo, con
  `abort_unless(…, 403)`, nel corpo dell'azione di download.
- Non usa il download di Livewire (`response()->streamDownload` dentro un componente): quello legge tutto il file in
  memoria e lo codifica in base64.
- Non comprime e non taglia il file: il download è sempre il file intero (la pagina mostra solo la coda).
