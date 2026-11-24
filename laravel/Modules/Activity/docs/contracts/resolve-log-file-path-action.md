---
title: "Contratto — ResolveLogFilePathAction"
type: contract
<<<<<<< .merge_file_JNNYWY
<<<<<<< .merge_file_7vIxHQ
<<<<<<< .merge_file_8LMiqh
<<<<<<< .merge_file_R9cwav
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\ResolveLogFilePathAction"
qmd: "contract ResolveLogFilePathAction activity log viewer path traversal ACT-LOGPATH-INV"
=======
=======
>>>>>>> .merge_file_sIylQJ
=======
>>>>>>> .merge_file_nDKDNS
=======
>>>>>>> .merge_file_6n6DOA
action: "Modules\Activity\Actions\Log\ResolveLogFilePathAction"
tags: [contract, action, log-viewer, security, filesystem]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/log-viewer-single-path-resolver.md
  - ../../app/Actions/Log/ResolveLogFilePathAction.php
  - ../../tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php
<<<<<<< .merge_file_JNNYWY
<<<<<<< .merge_file_7vIxHQ
<<<<<<< .merge_file_8LMiqh
>>>>>>> .merge_file_a8cJtC
=======
>>>>>>> .merge_file_sIylQJ
=======
>>>>>>> .merge_file_nDKDNS
=======
>>>>>>> .merge_file_6n6DOA
---

# ResolveLogFilePathAction

<<<<<<< .merge_file_JNNYWY
<<<<<<< .merge_file_7vIxHQ
<<<<<<< .merge_file_8LMiqh
<<<<<<< .merge_file_R9cwav
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
=======
=======
>>>>>>> .merge_file_sIylQJ
=======
>>>>>>> .merge_file_nDKDNS
=======
>>>>>>> .merge_file_6n6DOA
L'unico punto del visualizzatore dei log che trasforma un input dell'utente (il file scelto) in un percorso su disco.
Lettura (`BuildLogViewerStateAction`) e download (`DownloadLogFileAction`) passano tutti da qui. Perché uno solo:
[ADR un solo risolutore di percorsi](../adr/log-viewer-single-path-resolver.md). Sorgente:
`app/Actions/Log/ResolveLogFilePathAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php`.

## Input

| Parametro | Tipo | Note |
|---|---|---|
| `$relativePath` | `string` | percorso scelto nella pagina, relativo alla cartella dei log (`reports/rejected/daily.log`) |
| `$baseDirectory` | `?string` | cartella base; `null` = `storage_path('logs')` (risolta da `ResolveLogDirectoryAction` con `realpath`) |

## Output

- `ResolvedLogFileData{absolutePath, relativePath}`: percorso reale e percorso relativo normalizzato con `/`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGFILE-INV-1 | Il file risolto sta **dentro** la cartella base: `..` e percorsi assoluti che ne escono sono rifiutati, anche se puntano a un `.log` reale. | `ACTIVITY-LOGFILE-INV-1` |
| ACTIVITY-LOGFILE-INV-2 | Solo estensione `.log`, controllata sia sull'input sia sul file risolto (un link `x.log` verso un file non `.log` è rifiutato); percorsi vuoti, con byte nullo o inesistenti sono rifiutati. | `ACTIVITY-LOGFILE-INV-2` |
| ACTIVITY-LOGFILE-INV-3 | `realpath()` risolve i link simbolici: un link dentro la cartella che punta fuori è rifiutato. | `ACTIVITY-LOGFILE-INV-3` |
| ACTIVITY-LOGFILE-INV-4 | Un file valido, anche in sottocartelle, è risolto con il suo percorso relativo normalizzato. | `ACTIVITY-LOGFILE-INV-4` |
| ACTIVITY-LOGFILE-INV-5 | Cartella base mancante = errore esplicito (`baseDirectoryMissing`), non un percorso vuoto. | `ACTIVITY-LOGFILE-INV-5` |

## Effetti collaterali

- Nessuno: solo `realpath()` e `is_file()` sul filesystem.

## Errori

- `InvalidLogFileException` con fabbriche distinte: `invalidPath`, `notALogFile`, `notFound`, `outsideLogDirectory`,
  `baseDirectoryMissing`. I chiamanti mostrano all'utente un messaggio generico, senza ripetere il percorso.

## Non fa

- Non verifica i permessi dell'utente: lo fa `AuthorizeLogAccessAction`, prima.
- Non legge né apre il file: lettura a coda in `ReadLogTailAction`, download in `DownloadLogFileAction`.
- Non elenca i file: `ListLogFilesAction`.
- Non accetta estensioni diverse da `.log` "per comodità" (`.txt`, `.gz`): allargare la lista è una decisione di sicurezza.
<<<<<<< .merge_file_JNNYWY
<<<<<<< .merge_file_7vIxHQ
<<<<<<< .merge_file_8LMiqh
>>>>>>> .merge_file_a8cJtC
=======
>>>>>>> .merge_file_sIylQJ
=======
>>>>>>> .merge_file_nDKDNS
=======
>>>>>>> .merge_file_6n6DOA
