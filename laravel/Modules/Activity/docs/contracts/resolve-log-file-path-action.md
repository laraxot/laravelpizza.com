---
title: "Contratto — ResolveLogFilePathAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\ResolveLogFilePathAction"
qmd: "contract ResolveLogFilePathAction activity log viewer path traversal ACT-LOGPATH-INV"
---

# ResolveLogFilePathAction

Unico punto in cui l'input dell'utente del visualizzatore di log (`Filament/Pages/LogViewer.php`) diventa un percorso su disco; lettura (`BuildLogViewerStateAction`) e download (`DownloadLogFileAction`) passano da qui.


## Input

- `string $relativePath`: percorso relativo scelto dall'utente.
- `?string $baseDirectory`: cartella dei log; se `null` e' `storage/logs` (`ResolveLogDirectoryAction`).

## Output

- `ResolvedLogFileData(absolutePath, relativePath)` con percorso reale e percorso relativo normalizzato con `/`.

## Invarianti

- **ACT-LOGPATH-INV-1** — Percorso vuoto o con byte nullo e' rifiutato (`InvalidLogFileException::invalidPath`).
  Verifica non marcata: `Modules/Activity/tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php` («rejects files that are not .log, missing files, empty paths and null bytes»); nessun `->group('ACT-LOGPATH-INV-1')`.
- **ACT-LOGPATH-INV-2** — Sono ammessi solo file con estensione `.log`, controllata sull'input e sul file risolto.
  Stessa verifica non marcata (stesso test e «rejects a symlink named .log whose target is not a .log file»).
- **ACT-LOGPATH-INV-3** — Il file risolto con `realpath()` deve stare dentro la cartella base: `..`, percorsi assoluti e link simbolici verso l'esterno sono rifiutati (`outsideLogDirectory` / `notFound`).
  Stessa verifica non marcata («rejects path traversal…», «rejects an absolute path…», «rejects a symlink inside the log directory that points outside of it»).
- **ACT-LOGPATH-INV-4** — Se la cartella base non esiste l'errore e' esplicito (`baseDirectoryMissing`).
  Stessa verifica non marcata («fails clearly when the base directory does not exist»).

## Effetti collaterali

- Solo lettura del filesystem (`realpath`, `is_file`); non apre ne' legge il contenuto del file.

## Errori

- `InvalidLogFileException`: `invalidPath`, `notALogFile`, `notFound`, `outsideLogDirectory`, `baseDirectoryMissing` (`app/Exceptions/InvalidLogFileException.php`).

## Non fa

- Non verifica i permessi dell'utente: li verifica `AuthorizeLogAccessAction` ([contratto](authorize-log-access-action.md)).
- Non filtra il contenuto dei log, che puo' contenere dati personali.
- Non limita la dimensione del file.
