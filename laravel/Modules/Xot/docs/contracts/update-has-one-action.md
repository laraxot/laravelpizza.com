---
title: "HasOneAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\HasOneAction"
qmd: "Update HasOneAction hasOne aggiorna correlato crea dati vuoti eccezione exists"
---

# HasOneAction

Aggiorna il correlato di una `hasOne` o ne crea uno nuovo. Codice: `app/Actions/Model/Update/HasOneAction.php` (classe a riga 22, `execute()` a riga 33).

## Input

- `Model $model`: il padre.
- `RelationDTO $relationDTO`: `rows` è `HasOne`; `data` sono gli attributi non vuoti.

## Output

- `void`.

## Invarianti

- `UPDATE-HAS-ONE-INV-1` — `rows` deve essere `HasOne`. Test: nessuno.
- `UPDATE-HAS-ONE-INV-2` — `data` vuoto lancia `RuntimeException`. Test: nessuno.
- `UPDATE-HAS-ONE-INV-3` — Se la relazione ha già un correlato e `$model->{name}` è un `Model`, si chiama `update(data)` su di esso. Test: nessuno.
- `UPDATE-HAS-ONE-INV-4` — Negli altri casi si crea un nuovo correlato con `create(data)`. Test: nessuno.

## Effetti collaterali

`UPDATE` o `INSERT` del correlato. Nessuna transazione.

## Errori

- `InvalidArgumentException` se `rows` non è `HasOne`; `RuntimeException` se i dati sono vuoti.

## Non fa

- Se la relazione dice che il correlato esiste ma `$model->{name}` non è un `Model`, si crea un nuovo correlato: possibile duplicato. Non verificato.
