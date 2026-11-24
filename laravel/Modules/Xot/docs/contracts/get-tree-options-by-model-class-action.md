---
title: "GetTreeOptionsByModelClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Tree\\GetTreeOptionsByModelClassAction"
qmd: "GetTreeOptionsByModelClassAction opzioni albero modello gerarchico toTree etichetta profondità options stato"
---

# GetTreeOptionsByModelClassAction

Produce le opzioni per un select ad albero da un modello gerarchico. Codice: `app/Actions/Tree/GetTreeOptionsByModelClassAction.php` (classe a riga 19, `execute()` a riga 26). È usata anche da `Rating/app/Models/BaseRating.php`.

## Input

- `string $class`: FQCN di un modello con relazioni ricorsive (`HasRecursiveRelationshipsContract`).
- `Model|callable|null $_where`: non usato.

## Output

- `array<int|string, string>`: chiave = id, valore = etichetta; i figli hanno un prefisso `---` ripetuto per profondità.

## Invarianti

- `TREE-OPTIONS-INV-1` — Legge tutte le righe del modello e le converte in albero con `toTree()`. Test: nessuno.
- `TREE-OPTIONS-INV-2` — Le radici hanno la sola etichetta; i figli hanno `---` per profondità più l'etichetta. Test: nessuno.
- `TREE-OPTIONS-INV-3` — La proprietà `$options` non viene azzerata tra le chiamate sullo stesso oggetto: più chiamate sulla stessa istanza accumulano voci. Test: nessuno.

## Effetti collaterali

Un `SELECT` di tutte le righe della tabella. Nessuna scrittura.

## Errori

- `InvalidArgumentException` se la collezione non è `TreeCollection`.

## Non fa

- Ignora `$_where`: nessun filtro.
- Non pagina: su tabelle grandi carica tutto in memoria.
