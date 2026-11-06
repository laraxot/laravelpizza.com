---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "xotbaseresourcetable model audit batch geo.story"
issues: []
discussions: []
title: "Geo — XotBaseResourceTable $model audit (batch-geo)"
status: done
module: Geo
date: 2026-09-11
---

# Story: Geo — audit `$model` + colonne su XotBaseResourceTable (batch-geo)

**Fase BMAD**: Audit / qualità (verifica tipizzazione e schema, nessuna modifica
funzionale distruttiva).

**Contesto**: audit cross-modulo su tutte le classi `XotBaseResourceTable` per
confermare che dichiarino `protected static string $model = X::class;` con il
model corretto (autorevole = quello dichiarato sulla Resource sorella), e che
`getTableColumns()` referenzi solo colonne realmente esistenti sullo schema DB.

**Owned scope** (file toccati in questo batch, repo `module_geo_fila5`):
- `app/Filament/Resources/AddressResource/Tables/AddressesTable.php`
- `app/Filament/Resources/AddressResource/Tables/AddresssTable.php`
- `app/Filament/Resources/LocationResource/Tables/LocationsTable.php`

## Task 1 — `$model`

Tutti e tre i file avevano **già** (working tree, non committato prima di
questo batch) `protected static string $model = X::class;` presente e
corretto, verificato contro la Resource sorella:

- `AddressesTable::$model = Address::class` — confermato contro
  `AddressResource::$model = Address::class`
  (`app/Filament/Resources/AddressResource.php:31`).
- `AddresssTable::$model = Address::class` — stesso model, stessa conferma
  (vedi sezione "Collisioni / dead code" sotto: questa classe non è
  raggiungibile a runtime).
- `LocationsTable::$model = Location::class` — confermato contro
  `LocationResource::$model = Location::class`
  (`app/Filament/Resources/LocationResource.php:28`).

Nessuna modifica necessaria a Task 1 (era già presente nel working tree).

## Task 2 — verifica colonne contro schema reale

Schema letto in sola lettura via tinker:

```
php artisan tinker --execute="echo implode(',', Illuminate\Support\Facades\Schema::getColumnListing((new \Modules\Geo\Models\Address())->getTable()));"
php artisan tinker --execute="echo implode(',', Illuminate\Support\Facades\Schema::getColumnListing((new \Modules\Geo\Models\Location())->getTable()));"
```

**`addresses`** (tabella di `Address`): `id, model_type, model_id, name,
description, phone, route, street_number, locality,
administrative_area_level_3, administrative_area_level_2,
administrative_area_level_1, country, postal_code, formatted_address,
place_id, latitude, longitude, type, is_primary, extra_data, created_at,
updated_at, updated_by, created_by, deleted_at, deleted_by`.

`AddressesTable::getTableColumns()` / `AddresssTable::getTableColumns()`
(identiche) usano: `name, route, street_number, locality,
administrative_area_level_3, administrative_area_level_2, postal_code, type,
is_primary` — **tutte presenti**, nessuna colonna sospetta, nessuna chiave
con `.` (relazione).

**`locations`** (tabella di `Location`): `id, model_type, model_id, name,
lat, lng, street, city, state, zip, formatted_address, description,
processed, created_at, updated_at, updated_by, created_by, deleted_at,
deleted_by`.

`LocationsTable::getTableColumns()` usa: `name, street, city, zip, processed,
lat, lng, created_at` — **tutte presenti**, nessuna colonna sospetta.

Esito: **nessuna colonna sospetta in nessuno dei tre file**.

## Task 3 — miglioria UX (additiva, basso rischio)

`AddressesTable.php` e `AddresssTable.php` (stessa modifica su entrambi, sono
identici):
- `route`: aggiunto `->sortable()` (colonna di testo, era solo
  `searchable()->wrap()`).
- `street_number`: aggiunto `->sortable()`.
- `administrative_area_level_2`: aggiunto `->sortable()` per coerenza con la
  colonna gemella `administrative_area_level_3` che aveva già
  `searchable()->sortable()`.
- `postal_code`: aggiunto `->sortable()`.
- `type` (badge, enum `AddressTypeEnum`) e `is_primary` (icon boolean già
  sortable): nessuna modifica, già corretti.

`LocationsTable.php`:
- `street`: aggiunto `->sortable()` (era solo `searchable()->wrap()`).
- `zip`: aggiunto `->sortable()`.
- `lat`/`lng`: nessuna modifica — coordinate numeriche già `toggleable`
  nascoste di default, sort a basso valore pratico, lasciate come sono.
- `created_at`: nessuna modifica — già `->dateTime()->sortable()`, coerente
  con schema.org `dateCreated`.

Nessuna colonna rimossa. Nessun campo anagrafico multi-campo in questi tre
file, quindi nessun uso di `PersonColumn`.

## Verifica

- `php -l` su tutti e tre i file: OK, nessun errore di sintassi.
- `vendor/bin/phpstan analyse app/Filament/Resources/AddressResource/Tables/AddressesTable.php app/Filament/Resources/AddressResource/Tables/AddresssTable.php app/Filament/Resources/LocationResource/Tables/LocationsTable.php --no-progress` (da `laravel/`): **0 errori**.
- Nessun comando di scrittura sul DB eseguito (solo `Schema::getColumnListing` in tinker).

## Lock

Lock acquisito/rilasciato per i tre file via `bashscripts/lock/lock.sh` /
`unlock.sh` con owner `xotbaseresourcetable-model-audit` / batch
`geo-batch`, nessuna collisione rilevata (nessun lock preesistente).

## Collisioni / dead code

`AddresssTable.php` (tre "s") è **dead code**: `XotBaseResource::getTableClass()`
(`Modules/Xot/app/Filament/Resources/XotBaseResource.php:185-200`) risolve la
classe tabella come `Str::plural(class_basename(static::getModel())) . 'Table'`,
cioè per `Address::class` produce `AddressesTable` (plurale corretto
"Addresses"), mai `AddresssTable`. Verificato con:

```
grep -rn "AddresssTable" app/Filament/Resources/   # nessun riferimento fuori dal file stesso
```

`AddresssTable.php` e `AddressesTable.php` hanno contenuto identico (stesso
model, stesse colonne) a parte il nome classe — confermato con `diff`. Non
cancellato per rispetto della regola "mai cancellare di propria iniziativa";
segnalato qui come raccomandazione: valutare la rimozione di
`AddresssTable.php` in un ticket dedicato (fuori scope di questo batch), dato
che non è mai risolto a runtime.

## Addendum 2026-09-11 — cancellazione confermata (follow-up dead-code)

Rif. `docs/stories/xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`
(root del monorepo, riga Geo), item `AddressResource/Tables/AddresssTable.php`.

Verifica pre-cancellazione ripetuta in questa sessione, indipendente dal
batch sopra:

- `git log -S"AddresssTable" --oneline -- .` (repo `module_geo_fila5`): due
  commit, entrambi introducono/toccano il file insieme al suo gemello
  `AddressesTable.php` nello stesso audit (`96551cc audit(tables): add $model
  to XotBaseResourceTable classes...`, `ac66f37 .`) — nessun refactor a metà
  in corso, nessun commit che sposta logica da `AddresssTable` verso
  `AddressesTable` in modo incompleto.
- `git log --follow --oneline -- app/Filament/Resources/AddressResource/Tables/AddresssTable.php`:
  stessa storia, il file è sempre stato un doppione mai referenziato.
- `grep -rn "AddresssTable" laravel/ --include="*.php"`: solo la propria
  dichiarazione di classe, zero `use`/riferimenti da `AddressResource.php`,
  pagine, o altrove nel monorepo.
- Confronto contenuto con `AddressesTable.php`: identico riga per riga a
  parte il nome della classe (nessuna differenza non migrata da salvare).

Esito: cancellato `app/Filament/Resources/AddressResource/Tables/AddresssTable.php`
via `git rm`. Nessuna modifica a `AddressesTable.php` (resta l'unica classe
tabella per `AddressResource`, risolta per convenzione da
`XotBaseResource::getTableClass()`).
