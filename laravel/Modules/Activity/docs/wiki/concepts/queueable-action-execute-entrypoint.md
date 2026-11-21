---
title: "QueueableAction — unico ingresso execute"
type: concept
module: Activity
tags: [activity, queueable-action, spatie, execute, architecture]
created: 2026-07-12
updated: 2026-07-12
qmd: "Activity QueueableAction execute entrypoint religion spatie laravel-queueable-action"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../docs/QUEUEABLE-ACTION-RULE.md
  - ../../../Xot/docs/queueable-actions.md
  - ./activity-domain-focus.md
  - ../../../../../../docs/wiki/rules/no-services-rule.md
---

# QueueableAction — unico ingresso `execute`

## Religione (perché)

[spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) incapsula **un’unità di business** in una classe con trait `QueueableAction`. Il contratto Laraxot fissa **un solo punto di ingresso pubblico**: `execute()`.

| Zen | Significato |
|-----|-------------|
| **Un verbo** | Ogni Action = un’intenzione; `execute` = «fallo ora» (sync o queued via `->onQueue()`) |
| **No Services** | Vietato `*Service`; la logica vive in `app/Actions/*Action.php` |
| **No metodi domain su Action aliasing** | Vietato `recordSubject()`, `cleanOld()`, `handle()` come API pubblica alternativa |
| **Trait obbligatorio** | Ogni file in `app/Actions/` usa `use QueueableAction` — audit: `bash bashscripts/tools/audit-queueable-action-trait.sh` |
| **Facade sì, duplicazione no** | Coordinatori in `app/Adapters/` — **senza** trait; delegano a `*Action->execute()` (`app/Support/` eliminato 2026-07-12) |

### Filosofia

- **DRY:** un percorso di scrittura/lettura per ogni use case → meno divergenze (es. `ActivityLogger::recordSubject` vs `Activity::create` duplicati).
- **KISS:** `app(FooAction::class)->execute($args)` è grep-able e uniforme in tutto il monorepo.
- **Coda:** Spatie serializza la stessa `execute()`; metodi custom non entrano nel pipeline queueable.

## Politica nel modulo Activity

### Scrittura audit cross-modulo

`ActivityRecorderInterface` (altri moduli) → implementazione sottile:

```php
app(RecordSubjectActivityAction::class)->execute($modelClass, $modelId, $action, $changes);
```

**Vietato:** `app(ActivityLogger::class)->recordSubject(...)` — `ActivityLogger` non è l’Action; è un coordinator legacy.

### Mappa Actions (canon)

| Action | `execute()` |
|--------|-------------|
| `RecordSubjectActivityAction` | subject class/id + event + properties |
| `LogActivityAction` | log generico con Model opzionali |
| `LogModelCreatedAction` / `Updated` / `Deleted` | lifecycle modello |
| `RestoreActivityAction` | ripristino da properties filtrate |
| `ActivityMaintenanceAction` | purge chunked per età |
| `Query/GetSubjectActivityLogAction` | lettura log per subject |
| `Query/GetUserActivitiesAction` | … altre query in `Actions/Query/` |

### Coordinator `ActivityLogger`

Metodi pubblici (`log`, `created`, `getRecent`, `cleanOld`) **non** reimplementano SQL: chiamano `app(*Action::class)->execute(...)` o `new *Action(...)->execute()`.

## Esempi

```php
// ✅ Cross-modulo — contract ActivityRecorder
app(RecordSubjectActivityAction::class)->execute(Ticket::class, $id, 'update', $changes);

// ✅ Query
app(GetSubjectActivityLogAction::class)->execute(Ticket::class, $id);

// ✅ Async (stesso ingresso)
app(RecordSubjectActivityAction::class)->onQueue('default')->execute(...);

// ❌ Metodo domain su classe non-Action
app(ActivityLogger::class)->recordSubject(...);

// ❌ handle() al posto di execute() (non è la convenzione Laraxot)
```

## Riferimenti progetto

- [QUEUEABLE-ACTION-RULE](../../../../docs/QUEUEABLE-ACTION-RULE.md) — regola moduli
- [Xot queueable-actions](../../../Xot/docs/queueable-actions.md) — pattern DI + queue
- [no-services-rule](../../../../../../docs/wiki/rules/no-services-rule.md) — vietati Services

## Backlink

- [wiki index Activity](../index.md)
- [architecture.md](../../architecture.md) — overview (in aggiornamento verso Actions-only)
