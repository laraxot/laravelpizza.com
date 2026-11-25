---
title: "RelationX: belongsToManyX, morphToManyX, tableMorphMany"
type: reference
status: active
module: Xot
qmd: "RelationX belongsToManyX morphToManyX tableMorphMany pivot cross-database guessPivot many-to-many"
updated: 2026-11-25
---

# RelationX (`Modules\Xot\Models\Traits\RelationX`)

Trait gia' incluso in `XotBaseModel`: ogni modello del progetto lo eredita (vedi [models.md](../models.md)).

## Regola

**Per le many-to-many non si usa `$this->belongsToMany()`: si usa `$this->belongsToManyX()`** (per le polimorfiche `morphToManyX()`).
Il metodo sceglie la classe pivot, la tabella (anche su un altro database) e i campi pivot al posto dello sviluppatore, cosi' ogni modulo si comporta allo stesso modo.

```php
public function tags(): BelongsToMany
{
    return $this->belongsToManyX(Tag::class);                    // pivot dedotto dai nomi dei due modelli
}
```

## Metodi

| Metodo | Cosa fa |
|---|---|
| `belongsToManyX(string $related, ?string $_table = null, ...)` | chiama `belongsToMany` con tabella qualificata, `->using($pivot::class)`, `->withPivot(<fillable del pivot>)`, `->withTimestamps()`. I parametri chiave (`foreignPivotKey`, `relatedPivotKey`, `parentKey`, `relatedKey`, `relation`) sono passati tali e quali. |
| `morphToManyX(string $related, string $name, ..., ?string $pivotClass = null)` | come sopra per `morphToMany`; la classe pivot e' `$pivotClass` oppure `<Related>Morph` per convenzione. |
| `tableMorphMany(string $related, string $typeColumn = 'tbl', string $idColumn = 'id_tbl')` | `hasMany` filtrato sul nome della tabella del padre (`where tbl = $this->getTable()`): il padre sta in una tabella condivisa (es. log) e le righe sono riconosciute da due colonne. Non e' un morph di Laravel: non usa il morph map, quindi non dipende dal morph class del tenant. |
| `guessPivot()`, `guessMorphPivot()`, `guessPivotFullClass()` | risoluzione della classe pivot, pubblici per i test e per i casi speciali. |

## Come si trova il pivot

1. Nome pivot = nomi base dei due modelli in ordine alfabetico, concatenati (`Event` + `Performer` = `EventPerformer`); per i morph = `<Related>Morph`.
2. Si cerca la classe nel namespace del modello padre, poi in quello del correlato, poi risalendo ai parent del padre (se un parent finisce per `Morph` si usa il suo namespace).
3. La classe pivot **deve esistere** (estende `XotBasePivot` o `XotBaseMorphPivot`); `Assert` fallisce se il risultato non e' un `Pivot`/`MorphPivot`.
4. Il secondo argomento `$_table` esiste per compatibilita' con la firma di Laravel: la tabella viene sempre dal pivot (`$pivot->getTable()`).

## Cross-database

Se pivot, modello padre e correlato non stanno nello stesso database, la tabella diventa `database.tabella`. Con SQLite (test) la tabella resta invariata,
perche' SQLite non supporta la sintassi `database.table`.

## Guardie

- `tests/Unit/Models/Traits/TableMorphManyTest.php` (filtro su `tbl`, colonne personalizzate).
- `tests/Unit/XotRelationManageStatesCoverageTest.php` usa `belongsToManyX`.
- Revisione: `grep -rn "belongsToMany(" laravel/Modules --include=*.php` non deve trovare relazioni nuove nei moduli.
