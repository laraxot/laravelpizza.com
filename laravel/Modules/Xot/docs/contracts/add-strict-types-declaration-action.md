---
title: "AddStrictTypesDeclarationAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\AddStrictTypesDeclarationAction"
qmd: "AddStrictTypesDeclarationAction aggiunge declare strict_types file PHP riga vuota tag php bug file solo tag"
---

# AddStrictTypesDeclarationAction

Aggiunge `declare(strict_types=1);` a un file PHP che non lo ha. Codice: `app/Actions/File/AddStrictTypesDeclarationAction.php:13-59`.

## Input

- `string $filePath`: percorso del file PHP (`execute`, riga 20).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-STRICT-INV-1` | Se il file non esiste: `\InvalidArgumentException`. | righe 22-24 | `tests/Unit/Actions/File/AddStrictTypesDeclarationActionTest.php:36` |
| `FILE-STRICT-INV-2` | Se il contenuto contiene già il testo `declare(strict_types=1)`, il file non viene toccato. | righe 28-31 | `tests/Unit/Actions/File/AddStrictTypesDeclarationActionTest.php:47` |
| `FILE-STRICT-INV-3` | Se manca il tag `<?php`: `\RuntimeException`. | righe 34-37 | `tests/Unit/Actions/File/AddStrictTypesDeclarationActionTest.php:58` (copertura del ramo non verificata) |
| `FILE-STRICT-INV-4` | Altrimenti la direttiva e una riga vuota sono inseriti prima della prima riga non vuota dopo la riga `<?php`. Scrittura con `\n`. | righe 39-57 | come sopra |
| `FILE-STRICT-INV-5` | Se dopo `<?php` non c'è nessuna riga non vuota, l'inserimento avviene all'indice 0, cioè prima del tag. | righe 41, 54 | Test: nessuno. Verificato con PHP: il file diventa testo seguito dal tag, e la direttiva non ha effetto |

## Effetti collaterali

Riscrittura del file con `File::put`. Nessuna transazione, nessun evento.

## Errori

- `\InvalidArgumentException` per file assente.
- `\RuntimeException` per file senza tag `<?php`.

## Non fa

- Non riconosce varianti come `declare(strict_types = 1)`: possono generare una seconda dichiarazione.
- Non valida la sintassi PHP risultante.
- **Bug** (`INV-5`, righe 41, 54): un file che contiene solo `<?php` viene corrotto. Il fix è fuori dal perimetro di questa task: segnalato nel report.
- Marker `@contract` aggiunto nel docblock della classe.
