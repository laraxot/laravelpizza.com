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

| ID | Regola | Test |
|---|---|---|
| ACT-LOGPATH-INV-1 | Percorso vuoto o con byte nullo rifiutato (`InvalidLogFileException::invalidPath`). | `GetLogFilePathActionTest.php` |
| ACT-LOGPATH-INV-2 | Solo estensione `.log`, controllata sull'input e sul file risolto (un link `x.log` verso un file non `.log` e' rifiutato). | `GetLogFilePathActionTest.php` |
| ACT-LOGPATH-INV-3 | Il file risolto con `realpath()` sta dentro la cartella base, confronto con il separatore finale: `..`, percorsi assoluti e link simbolici verso l'esterno sono rifiutati (`outsideLogDirectory` o `notFound`). | `GetLogFilePathActionTest.php` |
| ACT-LOGPATH-INV-4 | Cartella base mancante: errore esplicito (`baseDirectoryMissing`). | `GetLogFilePathActionTest.php` |

## Effetti collaterali

- Solo lettura del filesystem (`realpath`, `is_file`); non apre ne' legge il contenuto del file.

## Errori

- `InvalidLogFileException`: `invalidPath`, `notALogFile`, `notFound`, `outsideLogDirectory`, `baseDirectoryMissing`. I chiamanti mostrano un messaggio generico che non ripete il percorso.

## Non fa

- Non verifica i permessi: li verifica [AuthorizeLogAccessAction](authorize-log-access-action.md).
- Non legge il file (coda in `ReadLogTailAction`, download in `DownloadLogFileAction`) e non elenca i file (`ListLogFilesAction`).
- Non accetta altre estensioni (`.txt`, `.gz`): allargare la lista e' una decisione di sicurezza.
- Non limita la dimensione del file.
