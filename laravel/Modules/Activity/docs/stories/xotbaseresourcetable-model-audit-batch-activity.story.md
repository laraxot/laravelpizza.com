---
title: XotBaseResourceTable model audit — batch-activity
slug: xotbaseresourcetable-model-audit-batch-activity
status: done
scope: module:Activity
github_issue: https://github.com/laraxot/module_activity_fila5/issues/49
date: 2026-09-11
---

# Story: XotBaseResourceTable model audit (batch-activity)

## Status: Done

## Context

Audit cross-modulo (batch parallelo, nome batch `batch-activity`) su tutte le classi
`XotBaseResourceTable` del modulo Activity: verifica della property `$model`, verifica
delle colonne di `getTableColumns()` contro lo schema reale, migliorie UX additive a
basso rischio. Nessuna operazione distruttiva, nessun file fuori scopo toccato.

## File in scope

- `app/Filament/Resources/ActivityResource/Tables/ActivitiesTable.php`
- `app/Filament/Resources/ActivityResource/Tables/ActivitysTable.php`
- `app/Filament/Resources/SnapshotResource/Tables/SnapshotsTable.php`
- `app/Filament/Resources/StoredEventResource/Tables/StoredEventsTable.php`

## Task 1 — `protected static string $model`

Verificato contro le Resource sorelle (fonte autorevole):

| File | Model dichiarato | Resource sorella | Model in Resource | Esito |
|---|---|---|---|---|
| `ActivitiesTable` | `Modules\Activity\Models\Activity` | `ActivityResource` | `Activity::class` | gia' corretto, nessuna modifica |
| `ActivitysTable` | `Modules\Activity\Models\Activity` | `ActivityResource` | `Activity::class` | gia' corretto, nessuna modifica |
| `SnapshotsTable` | `Modules\Activity\Models\Snapshot` | `SnapshotResource` | `Snapshot::class` | gia' corretto, nessuna modifica |
| `StoredEventsTable` | `Modules\Activity\Models\StoredEvent` | `StoredEventResource` | `StoredEvent::class` | gia' corretto, nessuna modifica |

Tutti e 4 i file avevano gia' `protected static string $model = X::class;` con il
valore corretto (con tanto di `@var class-string<X>` phpdoc). Nessuna azione richiesta
per il Task 1.

## Task 2 — verifica colonne vs schema reale

Colonne lette in sola lettura via tinker (`Schema::getColumnListing()`), nessuna
scrittura sul DB:

- `Activity` → tabella `activity_log` (connessione `activity`): `id, log_name,
  description, subject_type, subject_id, causer_type, causer_id, properties,
  batch_uuid, event, created_at, updated_at, updated_by, created_by, deleted_at,
  deleted_by, attribute_changes`.
- `Snapshot` → tabella `snapshots`: `id, aggregate_uuid, aggregate_version, state,
  created_at, updated_at, updated_by, created_by`.
- `StoredEvent` → tabella `stored_events`: `id, aggregate_uuid, aggregate_version,
  event_version, event_class, event_properties, meta_data, created_at, updated_by,
  created_by` (nota: **niente `updated_at`** su questa tabella).

Tutte le chiavi dirette (senza punto, quindi non relazioni) usate nei 4
`getTableColumns()` esistono nello schema reale corrispondente. Nessuna colonna
sospetta/rimossa trovata. Nessuna relazione (chiave con punto) presente in questi 4
file, quindi nessun salto da segnalare.

## Task 3 — migliorie UX additive (basso rischio)

- `ActivitiesTable.php`:
  - `log_name` → aggiunto `->sortable()` (era solo `searchable()`).
  - `event` → aggiunto `->sortable()` (era solo `searchable()`).
  - `batch_uuid` → aggiunto `->copyable()` (e' un UUID, stesso pattern gia' usato per
    `aggregate_uuid` in `SnapshotsTable`/`StoredEventsTable`).
  - `updated_at` → aggiunto `->sortable()` (simmetria con `created_at`, che gia' lo
    aveva).
- `ActivitysTable.php`:
  - `log_name` → aggiunto `->sortable()`, per coerenza con `ActivitiesTable` (vedi
    nota dead-code sotto: file toccato ma verosimilmente non renderizzato mai).
- `SnapshotsTable.php`:
  - `id` → aggiunto `->searchable()` (aveva gia' `sortable()`+`toggleable()`), per
    coerenza con `ActivitiesTable.id`.
- `StoredEventsTable.php`:
  - `id` → aggiunto `->searchable()` (stesso motivo).

Nessuna colonna rimossa. Nessuna nuova classe Column condivisa creata (regola del
batch: non introdurre `PersonColumn`-like nuove in questo giro).
Una chiave per riga rispettata in tutti gli array toccati (gia' cosi' nei file
originali).

## Dead code — followup: `ActivitysTable.php` RIMOSSA (2026-09-11, seconda passata)

`Modules\Xot\Filament\Resources\XotBaseResource::getTableClass()` risolve la classe
table per convenzione:

```php
$name = Str::plural(class_basename(static::getModel()));
$class = static::class.'\Tables\\'.$name.'Table';
```

Per `Activity`, `Str::plural('Activity')` restituisce `'Activities'` (verificato con
`php artisan tinker`), quindi la classe realmente risolta e usata da
`ActivityResource::table()` e' **`ActivitiesTable`**. `ActivitysTable` (con il typo
singolare "Activitys") non e' risolta da nessuna convenzione.

Nel primo giro (vedi sopra) era stata solo segnalata come dead code, non cancellata,
perche' fuori scopo del batch. Questo followup (tracciato in
`docs/stories/xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`
alla root del monorepo) ha completato la verifica e rimosso il file:

- `git log -S"ActivitysTable"` mostra che il file era gia' stato cancellato una volta
  (commit `3e81f97f` "fix: remove legacy ActivityLogger duplicate and orphan
  ActivitysTable", 2026-07-20) e poi ricomparso nella history (probabile riporto da
  merge/squash — la history del repo ha molti commit `.` senza messaggio). Nello stato
  attuale (2026-09-11) il file esisteva di nuovo, quindi la verifica e' stata rifatta
  da zero invece di fidarsi del commit storico.
- Confronto contenuto: `ActivitiesTable.php` (la classe viva) e' un superset esatto
  delle colonne di `ActivitysTable.php` (`id, log_name, description, created_at`, tutte
  presenti identiche in `ActivitiesTable`, che ne ha altre 8 in piu': `event,
  subject_type, subject_id, causer_type, causer_id, batch_uuid, properties,
  updated_at`). Nessuna differenza non migrata: `ActivitysTable` non ha nulla che
  `ActivitiesTable` non abbia gia'.
- `grep -rn "ActivitysTable" .` (intero modulo, non solo `app/`) ha trovato un
  riferimento in piu' rispetto al primo giro: `tests/Unit/Filament/
  ActivityFilamentExtendedTest.php` importava `ActivitysTable` e la istanziava in un
  test dedicato (`'ActivitysTable espone colonne compatte'`). Questo test verificava
  solo che la classe morta esistesse e avesse quelle 4 colonne — non prova che sia mai
  wired in un pannello Filament (nessuna Resource la risolve). Rimosso l'import e il
  test insieme al file, altrimenti la suite pest sarebbe andata in errore fatale
  (classe non trovata) dopo la cancellazione.

**Azione presa**: cancellato `app/Filament/Resources/ActivityResource/Tables/
ActivitysTable.php` e il test/import corrispondente in
`tests/Unit/Filament/ActivityFilamentExtendedTest.php`. Nessuna Resource risolveva il
file, nessun contenuto andato perso (tutto gia' presente in `ActivitiesTable`).

## Verifica eseguita

- `php -l` su tutti e 4 i file: nessun errore di sintassi.
- `cd laravel && vendor/bin/phpstan analyse <4 file> --no-progress`: `[OK] No errors`.
- Nessun comando di scrittura sul DB eseguito (solo `Schema::getColumnListing`
  in tinker, sola lettura).

## GitHub

Issue di tracking: laraxot/module_activity_fila5#49 (creata con questo stesso
riepilogo, nessuna issue preesistente trovata con `gh search issues
"xotbaseresourcetable-model-audit" --owner laraxot`).

## File Toccati

- `app/Filament/Resources/ActivityResource/Tables/ActivitiesTable.php`
- `app/Filament/Resources/ActivityResource/Tables/ActivitysTable.php` (cancellato nel
  followup 2026-09-11)
- `app/Filament/Resources/SnapshotResource/Tables/SnapshotsTable.php`
- `app/Filament/Resources/StoredEventResource/Tables/StoredEventsTable.php`
- `tests/Unit/Filament/ActivityFilamentExtendedTest.php` (rimosso test/import
  `ActivitysTable`, followup 2026-09-11)
