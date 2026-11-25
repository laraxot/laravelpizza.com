---
title: "Contratto: GetLogFilePathAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-25
action: "Modules\\Activity\\Actions\\Log\\GetLogFilePathAction"
qmd: "contract GetLogFilePathAction activity log viewer path traversal realpath estensione log ex ResolveLogFilePathAction"
related:
  - ../log-viewer.md
  - ../adr/0003-log-viewer-single-path-resolver.md
  - authorize-log-access-action.md
  - ../../app/Actions/Log/GetLogFilePathAction.php
  - ../../tests/Unit/Actions/Log/GetLogFilePathActionTest.php
---

# GetLogFilePathAction

Unico punto in cui l'input dell'utente del visualizzatore di log (`LogViewer`) diventa un percorso su disco; lettura (`BuildLogViewerStateAction`) e download (`DownloadLogFileAction`) passano da qui. Si chiamava `ResolveLogFilePathAction`, rinominata per la regola "get, non resolve" (ADR Xot 0016). Perche' uno solo: [ADR 0003](../adr/0003-log-viewer-single-path-resolver.md).

## Input

- `string $relativePath`: percorso relativo scelto dall'utente.
- `?string $baseDirectory`: cartella dei log; se `null` e' `storage/logs` (`GetLogDirectoryAction`, che applica `realpath`).

## Output

- `ResolvedLogFileData(absolutePath, relativePath)`: percorso reale e percorso relativo normalizzato con `/`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGFILE-INV-1 | Il file risolto sta dentro la cartella base (confronto con il separatore finale): `..` e percorsi assoluti che ne escono sono rifiutati, anche se puntano a un `.log` reale. | `ACTIVITY-LOGFILE-INV-1` |
| ACTIVITY-LOGFILE-INV-2 | Solo estensione `.log`, controllata sull'input e sul file risolto (un link `x.log` verso un file non `.log` e' rifiutato); percorsi vuoti, con byte nullo o inesistenti sono rifiutati. | `ACTIVITY-LOGFILE-INV-2` |
| ACTIVITY-LOGFILE-INV-3 | `realpath()` risolve i link simbolici: un link dentro la cartella che punta fuori e' rifiutato. | `ACTIVITY-LOGFILE-INV-3` |
| ACTIVITY-LOGFILE-INV-4 | Un file valido, anche in sottocartelle, e' risolto con il suo percorso relativo normalizzato con `/`. | `ACTIVITY-LOGFILE-INV-4` |
| ACTIVITY-LOGFILE-INV-5 | Cartella base mancante: errore esplicito (`baseDirectoryMissing`), non un percorso vuoto. | `ACTIVITY-LOGFILE-INV-5` |

## Effetti collaterali

- Solo lettura del filesystem (`realpath`, `is_file`); non apre ne' legge il contenuto del file.

## Errori

- `InvalidLogFileException`: `invalidPath`, `notALogFile`, `notFound`, `outsideLogDirectory`, `baseDirectoryMissing`. I chiamanti mostrano un messaggio generico che non ripete il percorso.

## Non fa

- Non verifica i permessi: li verifica [AuthorizeLogAccessAction](authorize-log-access-action.md).
- Non legge il file (coda in `ReadLogTailAction`, download in `DownloadLogFileAction`) e non elenca i file (`ListLogFilesAction`).
- Non accetta altre estensioni (`.txt`, `.gz`): allargare la lista e' una decisione di sicurezza.
- Non limita la dimensione del file.
