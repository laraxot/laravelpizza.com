---
title: "Relazioni uno-a-molti con discriminatore di tabella"
type: rule
module: Xot
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [eloquent, relationships, polymorphism, mylog]
qmd: "tableMorphMany MyLog id_tbl tbl getTable relazione uno molti discriminatore tabella morphToManyX pivot"
related:
  - ../../stories/table-discriminator-relations.story.md
  - ../../../../Xot/app/Models/Traits/RelationX.php
  - ../../../../Xot/tests/Unit/Models/Traits/TableMorphManyTest.php
  - ../../../../Performance/app/Models/Traits/RelationshipTrait.php
  - ../../../../IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php
---

# Relazioni uno-a-molti con discriminatore di tabella

## Regola

Una relazione legacy ai log condivisi con chiavi `id_tbl` e `tbl` rappresenta
un uno-a-molti: ogni record proprietario può avere più righe `MyLog`, e ogni riga
di log punta a un solo record tramite l'id e il nome della tabella.
Dichiararla con l'helper Xot:

```php
return $this->tableMorphMany(MyLog::class);
```

L'helper applica `id_tbl = owner.id` e `tbl = owner.getTable()`. Se la relazione
ha un filtro ulteriore, concatenarlo dopo l'helper:

```php
return $this->tableMorphMany(MyLog::class)
    ->where('note', 'sendMail');
```

## Distinguere le tre forme

| Schema delle chiavi | Cardinalità | Relazione corretta |
|---|---:|---|
| `id_tbl` + `tbl` su ciascuna riga log | uno-a-molti | `tableMorphMany(MyLog::class)` |
| `model_id` + `model_type` sul modello correlato | uno-a-molti | `$this->morphMany(...)` |
| tabella pivot con colonne morph e chiavi dei due lati | molti-a-molti | `$this->morphToMany(...)` o `morphToManyX(..., $name)` |

`morphToManyX()` non sostituisce `tableMorphMany()`: richiede il nome della
relazione morph, risolve un modello pivot e costruisce una relazione many-to-many.
Usarlo per `MyLog` cambia cardinalità, schema atteso e valori delle chiavi.
La chiamata `morphToManyX(MyLog::class)` inoltre non è compatibile con la firma
attuale, che richiede `$name`.

Non cambiare un `hasMany()` in `morphMany()` soltanto per rendere il codice più
simile a un altro modulo: prima confrontare la migrazione della tabella correlata,
le chiavi effettive e il comportamento multi-tenant/morph-map.

## Inventario e verifica

La scansione del codice applicativo non ha trovato chiamate attive alla forma
inline `hasMany(MyLog::class, 'id_tbl', 'id')->where('tbl', $this->getTable())`.
Le relazioni MyLog censite usano `tableMorphMany()`. La regola e il test
`TableMorphManyTest` verificano sia il discriminatore predefinito sia le colonne
personalizzate.

Per ulteriori dettagli sulle decisioni e sui consumer, vedere la story
[relazioni con discriminatore di tabella](../../stories/table-discriminator-relations.story.md).
