---
title: "GroupColumn — rendering delle colonne figlie"
qmd: "ui groupcolumn child rendering md"
type: note
tags: [documentation]
---

# GroupColumn — rendering delle colonne figlie

## Sintomo

Una `IconColumn::make('ha_diritto')->boolean()` dentro un `GroupColumn` mostrava
`1` invece dell'icona. La stessa colonna, usata come colonna top-level, funzionava.

## Causa

La view `ui::filament.tables.columns.group` **stringificava lo state**:

```php
$value = $field->getState();          // boolean -> 1
$displayText = $labelText . ': ' . $value;
{{ $displayText }}
```

Il `->boolean()` di `IconColumn` agisce nel **suo** rendering
(`IconColumn::toEmbeddedHtml()`), che non veniva mai invocato. Lo stesso valeva
per `ColorColumn`, `ImageColumn`, i badge e i colori delle `TextColumn`.

## Fix

Delegare il rendering alla colonna figlia per le colonne "visuali":

```php
$field->table($getTable());   // obbligatorio
$field->record($record);      // obbligatorio
$field->clearCachedState();   // obbligatorio nei loop di riga
...
{!! $field->toEmbeddedHtml() !!}
```

### Perche' servono tutte e tre le chiamate

| Chiamata | Se manca |
|----------|----------|
| `table()` | `LogicException: The column [x] is not mounted to a table.` |
| `record()` | `getState()` torna `null`, la colonna appare vuota |
| `clearCachedState()` | lo state della riga precedente resta in cache: **stessa icona su tutte le righe** |

Le colonne figlie di `GroupColumn` vivono in `$schema` e **non** vengono montate
da Filament: il montaggio automatico (`$column->record($record)` in
`filament/tables/resources/views/index.blade.php`) avviene solo per le colonne
top-level. Il gruppo deve farlo a mano.

## Skip dei valori vuoti

`empty()` scarta anche `false` e `0`. Per una `IconColumn->boolean()` il valore
`false` e' informazione (icona rossa), non assenza. Quindi:

- colonne visuali: si salta **solo** `null`
- colonne testuali: si mantiene `empty()` con l'eccezione gia' presente su `0` / `'0'`

## Impatto

La view e' condivisa da tutte le colonne che estendono `GroupColumn`:
`LavoratoreColumn`, `QualificaColumn`, `RepartoColumn`, `PeriodoColumn`,
`WorkerColumn`, `QuaColumn`, `RepColumn`, `ValutatoreColumn` (moduli Ptv,
Incentivi, IndennitaResponsabilita, Progressioni). Verificare a vista una
tabella per modulo dopo la modifica.

## Verifica

```bash
php artisan view:clear
```

Poi ricaricare una lista schede: le colonne booleane nel gruppo devono mostrare
l'icona (spunta / croce), non `1` / `0`.

## Collegamenti

- [Analisi risoluzione relazioni GroupColumn](./groupcolumn-relationship-resolution-analysis.md)
- [Colonne custom e relazioni](./filament-custom-columns-relationship-resolution.md)
