---
title: "CreateDirectoryForFilenameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\CreateDirectoryForFilenameAction"
qmd: "CreateDirectoryForFilenameAction crea cartella del file ricorsiva makeDirectory dirname"
---

# CreateDirectoryForFilenameAction

Crea la cartella che contiene un file, se manca. Codice: `app/Actions/File/CreateDirectoryForFilenameAction.php:10-20`.

## Input

- `string $filename`: percorso del file, il cui `dirname` va creato (`execute`, riga 14).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-MKDIR-INV-1` | Se `dirname($filename)` non esiste, la crea ricorsivamente con modo `0755`. | righe 16-18 | `tests/Unit/Actions/File/CreateDirectoryForFilenameActionTest.php:37,46,54` |
| `FILE-MKDIR-INV-2` | Con `force = true`, un errore di `mkdir` non viene lanciato: il fallimento non è segnalato. | riga 17 | come sopra (copertura del fallimento non verificata) |

## Effetti collaterali

Creazione di una cartella. Il file non viene creato.

## Errori

- Nessuna eccezione propria. Il fallimento di `mkdir` è silenzioso.

## Non fa

- Non verifica i permessi.
- Marker `@contract` aggiunto nel docblock della classe.
