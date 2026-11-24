---
title: "RelationX trait"
type: note
status: active
tags: [docs, xot, traits, relations]
qmd: "relationx trait belongstomanyx morphtomanyx pivot"
---
# RelationX trait

`Modules\Xot\Models\Traits\RelationX` (in `XotBaseModel`) e' il punto unico per le relazioni N:M del progetto.
Regola di progetto: mai `$this->belongsToMany()`, sempre `belongsToManyX()`.

## Cosa fa

- **Auto-pivot**: la classe pivot e' dedotta per convenzione (`guessPivot()`: i basename dei due modelli in ordine
  alfabetico, es. `Permission` + `Role` -> `PermissionRole`), cercandola nel namespace del modello, poi in quello del
  correlato, poi risalendo le classi padre.
- **Cross-database**: `qualifyPivotTable()` prefissa la tabella col nome del database quando pivot, modello e correlato
  stanno su database diversi (SQLite escluso: non supporta `database.table`).
- **Campi pivot**: `withPivot($pivot->getFillable())` e `withTimestamps()` sempre attivi.

## Metodi

### `belongsToManyX(related, ...)`

Il parametro `$_table` e' un suggerimento ignorato: il nome tabella viene dalla classe pivot dedotta
(la classe pivot deve quindi esistere, es. `event_performer` -> `EventPerformer`).

### `morphToManyX(related, name, ..., pivotClass: ?string = null)`

Stessa logica per le relazioni polimorfiche.

- `pivotClass === null`: il pivot e' dedotto da `guessMorphPivot()` (basename del correlato + `Morph`).
- `pivotClass` valorizzato: si usa quella `MorphPivot` concreta (es. `RatingMorph`, che ha colonne proprie come
  `user_id` / `points`), poi `Assert::isInstanceOf($pivot, MorphPivot::class)`.
- Tipo di ritorno: `MorphToMany<TRelatedModel, $this, ($pivotClass is null ? MorphPivot : TPivot), 'pivot'>`.

Nota di manutenzione: la riga `$pivot = null !== $pivotClass ? app($pivotClass) : $this->guessMorphPivot($related);`
e' l'unica assegnazione di `$pivot`. Un merge tra storie aveva lasciato anche la vecchia
`$pivot = $this->guessMorphPivot($related);` subito sopra: istruzione stantia, sempre sovrascritta dalla successiva
(`assign.overwritten`, riportato 4 volte da PHPStan, una per modello che usa il trait). Il comportamento non cambiava
(`pivotClass` era gia' rispettato); la correzione e' togliere la riga morta.

## Test

`Modules/Xot/tests/Unit/XotRelationManageStatesCoverageTest.php` copre `belongsToManyX` e `morphToManyX` con pivot stub.
