---
title: "GetFilenameByClassnameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Class\\GetFilenameByClassnameAction"
qmd: "GetFilenameByClassnameAction percorso file da classe reflection base_path duplicato Classes"
---

# GetFilenameByClassnameAction

Ritorna il percorso del file sorgente di una classe. Codice: `app/Actions/Class/GetFilenameByClassnameAction.php` (classe a riga 13, `execute()` a riga 13). Copia identica di `Classes/GetFilenameByClassnameAction`: vedi Non fa.

## Input

- `string $class_name`: FQCN.

## Output

- `string`: percorso del file.

## Invarianti

- `CLASS-FILENAME-INV-1` — Se la classe esiste, il percorso è quello di reflection. Test: `tests/Unit/Actions/Class/GetFilenameByClassnameActionTest.php`.
- `CLASS-FILENAME-INV-2` — Se la reflection fallisce, il percorso è ricostruito con `base_path(FQCN come path).php`, senza verificare che esista. Test: come sopra.
- `CLASS-FILENAME-INV-3` — Se il risultato non è stringa, lancia `\Exception`. Test: nessuno.

## Effetti collaterali

Autoload della classe tramite reflection. Nessuna scrittura.

## Errori

- `\Exception` nel caso di risultato non stringa.

## Non fa

- Non verifica l'esistenza del file ricostruito.
- Duplicato di `Classes/GetFilenameByClassnameAction`.
