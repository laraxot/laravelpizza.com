---
title: "FixPathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\FixPathAction"
qmd: "FixPathAction normalizza separatori percorso directory separator slash backslash"
---

# FixPathAction

Sostituisce `/` e `\` con il separatore di directory del sistema. Codice: `app/Actions/File/FixPathAction.php:12-20`.

## Input

- `string $path` (`execute`, riga 16).

## Output

- `string`: percorso con separatori di sistema (riga 18).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-FIXPATH-INV-1` | Ogni `/` e ogni `\` è sostituito da `DIRECTORY_SEPARATOR`. Nessun'altra modifica. | riga 18 | `tests/Unit/Actions/File/FileActionsTest.php:16`; `tests/Unit/Actions/File/ViewPathActionTest.php:9,26` (mock) |

## Effetti collaterali

Nessuno. Funzione pura.

## Errori

- Nessuna eccezione.

## Non fa

- Non risolve `..`, non rimuove segmenti doppi, non usa `realpath`.
- Marker `@contract` aggiunto nel docblock della classe.
