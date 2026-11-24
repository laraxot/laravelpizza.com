---
title: "spatie/laravel-activitylog — owner modulo Activity"
type: concept
tags: [activity, spatie, activitylog, composer, module-dependency, audit]
created: 2026-06-06
updated: 2026-06-06
qmd: "activity spatie laravel activitylog module composer dependency audit trail root never"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/11"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/12"
related:
  - ../../../../../../docs/wiki/rules/composer-module-dependency-go.md
  - ./activity-domain-focus.md
  - ./xotbase-resource-zen-pattern.md
  - ../../../Modules/Xot/docs/composer-module-dependency-management.md
---

# spatie/laravel-activitylog — owner Activity

## Regola

| Pacchetto | Owner | Vietato in |
|-----------|-------|------------|
| `spatie/laravel-activitylog` | `Modules/Activity/composer.json` | `laravel/composer.json` |

## Perché Activity

- Modulo dedicato ad audit trail, event sourcing, log utente
- Modelli `Activity`, `StoredEvent`, `Snapshot` estendono/consumano Spatie Activity Log
- Il dominio **è** il pacchetto — non appartiene alla shell Laravel

## Require canonico

```json
"require": {
    "spatie/laravel-activitylog": "*",
    "spatie/laravel-event-sourcing": "*"
}
```

File: `laravel/Modules/Activity/composer.json`

## Workflow fix

```bash
rm -rf laravel/Modules/Activity/vendor
cd laravel && php -d memory_limit=-1 composer.phar update -W
ls laravel/vendor/spatie/laravel-activitylog
```

## Anti-pattern

- Duplicare il require nel root `laravel/composer.json`
- Importare `Modules\Activity\` da moduli che dovrebbero restare disaccoppiati (User non dipende da Comment — stessa filosofia)

## GitHub (tracciamento)

| Tipo | URL |
|------|-----|
| Issue | https://github.com/laraxot/base_techplanner_fila5/issues/11 |
| Discussion | https://github.com/laraxot/base_techplanner_fila5/discussions/12 |

## Collegamenti

- Regola globale: [composer-module-dependency-go.md](../../../../../../docs/wiki/rules/composer-module-dependency-go.md)
- BMAD: [architecture-composer-module-dependency.md](../../../../../../docs/wiki/bmad/architecture-composer-module-dependency.md)
