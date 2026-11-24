---
title: "Contratto — ResolveLogFilePathAction"
type: contract
action: "Modules\Activity\Actions\Log\ResolveLogFilePathAction"
tags: [contract, action, log-viewer, security, filesystem]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/log-viewer-single-path-resolver.md
  - ../../app/Actions/Log/ResolveLogFilePathAction.php
  - ../../tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php
---

# ResolveLogFilePathAction

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
