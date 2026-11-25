---
title: "ADR — Visualizzatore dei log: un solo risolutore di percorsi, una sola regola di accesso, download a blocchi"
type: decision
status: accepted
module: Activity
tags: [adr, activity, log-viewer, security, filesystem, filament]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Filament/Pages/LogViewer.php
  - ../contracts/resolve-log-file-path-action.md
  - ../contracts/authorize-log-access-action.md
  - ../contracts/download-log-file-action.md
qmd: "log viewer single path resolver visualizzatore"
---

# ADR: visualizzatore dei log con un solo risolutore di percorsi

## Contesto

- La pagina `app/Filament/Pages/LogViewer.php` mostra i file di `storage/logs` (anche in sottocartelle) dove non c'è
  accesso SSH/FTP. Il file da leggere o scaricare lo sceglie l'utente: è un input che diventa un percorso su disco.
- I file di log possono superare centinaia di MB; un download Livewire legge tutto il file in memoria e lo codifica in base64.
- I log contengono dati personali e segreti (stack trace, query): l'accesso va ristretto.

Domanda: come si legge e si scarica un file scelto dall'utente senza aprire la strada a path traversal o a esaurimento
di memoria?

## Decisione

- Ogni percorso passa da `ResolveLogFilePathAction`: solo `.log` (su input e file risolto), `realpath()` che risolve `..`
  e link simbolici, file obbligatoriamente dentro la cartella base. Lettura (`BuildLogViewerStateAction`) e download
  (`DownloadLogFileAction`) lo chiamano; la pagina tiene solo lo stato della scelta.
- Una sola regola di accesso, `AuthorizeLogAccessAction` (`super-admin` o `log.viewAny`), usata da `canAccess()` e
  ripetuta nel corpo dell'azione di download.
- La pagina legge solo la coda del file (`ReadLogTailAction`, con limite rigido); il download restituisce il file intero
  come `BinaryFileResponse`, letto a blocchi.
- Sola lettura: nessuna cancellazione o modifica dei file dal pannello.

## Alternative scartate

- Pacchetti log-viewer di terze parti: rotte e permessi propri da allineare al pannello, e una superficie in più da
  aggiornare.
- Validare il percorso in ogni punto che lo usa: è il modo in cui un punto se ne dimentica.
- Download con `Livewire` / `streamDownload` nel componente: file intero in memoria.
- Leggere il file intero e paginare in PHP: tempi e memoria proporzionali alla dimensione del log.

## Conseguenze

- Pro: un solo punto da rivedere per la sicurezza dei percorsi, coperto da test su traversal, percorsi assoluti, link
  simbolici e estensioni.
- Contro: ricerca e filtro valgono solo sulla parte letta (la coda), non sull'intero file.
- Debito: il permesso `log.viewAny` va creato e assegnato a mano; senza, vedono i log solo i super-admin.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/Log`: in particolare i group
  `ACTIVITY-LOGFILE-INV-1` … `-5`, `ACTIVITY-LOGACCESS-INV-1` … `-3`, `ACTIVITY-LOGDOWNLOAD-INV-1` e `-2`, e
  `BuildLogViewerStateActionTest` («returns a generic error and no entries for paths that try to leave…»).
- Solo revisione: che nessun nuovo punto del modulo apra un file di log senza passare dal risolutore.
