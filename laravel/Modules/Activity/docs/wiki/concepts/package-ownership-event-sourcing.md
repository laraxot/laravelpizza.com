---
title: "Package ownership — event sourcing e activity log"
type: concept
module: Activity
tags: [activity, composer, spatie, event-sourcing, activitylog, nwidart]
created: 2026-07-09
updated: 2026-07-09
qmd: "Activity owner spatie laravel-event-sourcing activitylog composer modulo nwidart"
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/1"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/1"
related:
  - ./composer-root-minimal-nwidart.md
  - ./activity-domain-focus.md
  - ../../../../Xot/docs/wiki/concepts/composer-root-skeleton-modular.md
  - ../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md
  - ../../composer.json
---

# Package ownership — Activity

## Scopo modulo

Activity è il layer **audit + storia eventi**: chi ha fatto cosa, append-only, event store, snapshot per replay.

## Pacchetti owner (require in questo modulo)

| Pacchetto | Ruolo |
|-----------|--------|
| `spatie/laravel-activitylog` | Activity log su modelli, causer/subject |
| `spatie/laravel-event-sourcing` | Stored events, snapshot, projector/reactor |

Entrambi in `Modules/Activity/composer.json` — **mai** nel root `laravel/composer.json`.

## Perché non Xot?

Xot = infrastruttura condivisa (Filament base, Folio, QueueableAction).  
Event sourcing è **dominio** Activity: migrazioni `stored_events`, modelli `StoredEvent`/`Snapshot`, test Pest, config `event-sourcing.php` pubblicata dal modulo.

Mettere il pacchetto in Xot accoppierebbe tutte le basi Laraxot all'event store anche dove non serve (YAGNI).

## Workflow Composer (religione)

```bash
# 1. Edit solo Modules/Activity/composer.json
# 2. Elimina vendor locale del modulo se presente
rm -rf laravel/Modules/Activity/vendor

# 3. Risolvi dal root (merge-plugin)
cd laravel && composer update -W spatie/laravel-event-sourcing spatie/laravel-activitylog
```

**Vendor canonico:** `laravel/vendor/` — `Modules/Activity/vendor/` non va committato né usato per PHPStan/Artisan.

## Pin versione

`spatie/laravel-event-sourcing`: `^7.15` (allineato a `config/event-sourcing.php` e `EloquentStoredEventRepository`).

Dopo bump: `composer update -W` + `php artisan migrate` (forward-only) se migrazioni package cambiano.

## Anti-pattern

- `composer require spatie/laravel-event-sourcing` in `laravel/` root
- `vendor/` dentro `Modules/Activity/` lasciato dopo sviluppo isolato del modulo
- Duplicare il pacchetto in Blog/Notify «per comodità»

## Verifica

```bash
cd laravel && composer why spatie/laravel-event-sourcing
# deve risalire a laraxot/module_activity_fila5
```
