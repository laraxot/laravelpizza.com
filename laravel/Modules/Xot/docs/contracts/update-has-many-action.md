---
title: "HasManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\HasManyAction"
qmd: "Update HasManyAction hasMany figli chiave esterna to from scollega orfani azzera foreign key"
---

# HasManyAction

Aggiorna i figli di una `hasMany` e ne gestisce il collegamento al padre. Codice: `app/Actions/Model/Update/HasManyAction.php` (classe a riga 20, `execute()` a riga 25).

## Input

- `Model $model`: il padre.
- `RelationData $relationDTO`: `rows` è `HasMany`; `data` è un array con `to`/`from` oppure una lista di figli con chiave primaria.

## Output

- `void`.

## Invarianti

- `UPDATE-HAS-MANY-INV-1` — Con `to` o `from` (ramo diretto): tutti i figli del padre perdono la chiave esterna, poi quelli in `to` la ricevono. Test: nessuno.
- `UPDATE-HAS-MANY-INV-2` — Nel ramo batch, ogni figlio con chiave è aggiornato con `UpdateAction` e la chiave esterna del padre; i figli del padre non presenti nel payload perdono la chiave esterna, ma non sono cancellati. Il cleanup avviene solo se almeno un figlio è stato aggiornato. Test: `tests/Unit/XotHasManyWidgetCoverageTest.php` (menzione non verificata).
- `UPDATE-HAS-MANY-INV-3` — Gli elementi del batch senza chiave sono saltati in silenzio. Test: nessuno.

## Effetti collaterali

`UPDATE` in massa sulle righe figlie (azzeramento e reimpostazione della chiave esterna), `UPDATE` per riga tramite `UpdateAction`. Nessuna transazione.

## Errori

- `InvalidArgumentException` se `rows` non è `HasMany` o un elemento non è un array.

## Non fa

- Non crea figli nuovi nel ramo batch (gli elementi senza chiave sono ignorati).
- Non cancella figli.
- Bug probabile nel ramo diretto (`handleDirectUpdate`): lo stesso builder `$query` riceve prima `where(fk = padre)->update(fk = null)` e poi `whereIn(to)->update(fk = padre)`. Il builder Eloquent conserva il primo `where`, quindi la seconda `UPDATE` non trova righe con `fk = padre` e i `to` non vengono ricollegati. Ragionamento sul codice, non ancora provato con test: va verificato.
