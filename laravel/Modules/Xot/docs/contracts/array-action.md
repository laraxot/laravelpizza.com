---
title: "ArrayAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ArrayAction"
qmd: "ArrayAction array rangeIntersect diff_assoc_recursive helper statici intervalli differenza ricorsiva"
---

# ArrayAction

Contenitore di due helper statici su array e intervalli, più un `execute()` vuoto. Codice: `app/Actions/ArrayAction.php` (classe a riga 13, `execute()` a riga 60).

## Input

- `rangeIntersect(int $a, int $b, int $c, int $d)`: due intervalli.
- `diff_assoc_recursive(array $array1, array $array2)`: due array.
- `execute()`: nessuno.

## Output

- `rangeIntersect`: `[max, min]` o `false`.
- `diff_assoc_recursive`: differenze ricorsive, come `Utilities/DiffAssocRecursiveAction`.
- `execute()`: `void`.

## Invarianti

- `ARRAY-ACTION-INV-1` — `rangeIntersect` ha gli stessi estremi inclusi e lo stesso esito di `Utilities/RangeIntersectAction`. Test: `tests/Unit/Actions/ArrayArrActionsTest.php`.
- `ARRAY-ACTION-INV-2` — `diff_assoc_recursive` produce lo stesso esito di `Utilities/DiffAssocRecursiveAction`. Test: `tests/Unit/Actions/ArrayArrActionsTest.php`.
- `ARRAY-ACTION-INV-3` — `execute()` non fa nulla. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non è un'Action con comportamento proprio: i due helper duplicano le Action in `Utilities/`. Da unificare.
- `execute()` è vuoto.
