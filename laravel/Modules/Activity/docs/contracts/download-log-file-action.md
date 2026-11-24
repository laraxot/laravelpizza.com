---
title: "Contratto — DownloadLogFileAction"
type: contract
<<<<<<< .merge_file_KNlbi6
<<<<<<< .merge_file_buweCp
<<<<<<< .merge_file_hu8OVZ
<<<<<<< .merge_file_D81Iwc
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\DownloadLogFileAction"
qmd: "contract DownloadLogFileAction activity log download file BinaryFileResponse streaming storage logs ACT-LOGDL"
=======
=======
>>>>>>> .merge_file_BXSE7g
=======
>>>>>>> .merge_file_2sep6r
=======
>>>>>>> .merge_file_QGpZKN
action: "Modules\Activity\Actions\Log\DownloadLogFileAction"
tags: [contract, action, log-viewer, download, filesystem]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/log-viewer-single-path-resolver.md
  - resolve-log-file-path-action.md
  - ../../app/Actions/Log/DownloadLogFileAction.php
  - ../../tests/Unit/Actions/Log/DownloadLogFileActionTest.php
<<<<<<< .merge_file_KNlbi6
<<<<<<< .merge_file_buweCp
<<<<<<< .merge_file_hu8OVZ
>>>>>>> .merge_file_TUBgGy
=======
>>>>>>> .merge_file_BXSE7g
=======
>>>>>>> .merge_file_2sep6r
=======
>>>>>>> .merge_file_QGpZKN
---

# DownloadLogFileAction

<<<<<<< .merge_file_KNlbi6
<<<<<<< .merge_file_buweCp
<<<<<<< .merge_file_hu8OVZ
<<<<<<< .merge_file_D81Iwc
Risposta HTTP di download per un file di log scelto dall'utente. Il percorso passa da `ResolveLogFilePathAction`.

## Input

- `string $file`: percorso relativo a `storage/logs`, come da `ResolveLogFilePathAction`.

## Output

- `BinaryFileResponse`: download con nome file = percorso relativo con `/` sostituito da `_`, `Content-Type: text/plain; charset=UTF-8`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGDL-INV-1` | Un file fuori da `storage/logs`, non `.log` o inesistente non produce risposta: viene rilanciata `InvalidLogFileException`. | `DownloadLogFileActionTest.php` («refuses files outside the log directory…») |
| `ACT-LOGDL-INV-2` | La risposta è `BinaryFileResponse`: il file è letto a blocchi dal disco, non caricato in memoria. | `DownloadLogFileActionTest.php` («returns a streamed download…») verifica il tipo di risposta |
| `ACT-LOGDL-INV-3` | Il nome del download non contiene `/`. | Test: nessuno |

## Effetti collaterali

- Nessuna scrittura. Il file viene letto quando la risposta è inviata, non in questa Action.

## Errori

- `InvalidLogFileException`, propagata da `ResolveLogFilePathAction`.

## Non fa

- Non verifica l'autorizzazione: il chiamante (`LogViewer`, riga 128) usa `AuthorizeLogAccessAction`.
- Se il file sparisce tra la risoluzione e l'invio, il comportamento è quello di Symfony (non verificato).

=======
=======
>>>>>>> .merge_file_BXSE7g
=======
>>>>>>> .merge_file_2sep6r
=======
>>>>>>> .merge_file_QGpZKN
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
<<<<<<< .merge_file_KNlbi6
<<<<<<< .merge_file_buweCp
<<<<<<< .merge_file_hu8OVZ
>>>>>>> .merge_file_TUBgGy
=======
>>>>>>> .merge_file_BXSE7g
=======
>>>>>>> .merge_file_2sep6r
=======
>>>>>>> .merge_file_QGpZKN
