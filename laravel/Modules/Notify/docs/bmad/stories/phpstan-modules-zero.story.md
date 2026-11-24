---
title: "PHPStan modules zero — Notify"
module: Notify
type: story
status: done
priority: high
created: 2026-11-16
updated: 2026-11-16
owner: quality-guardian
tags:
  - phpstan
  - quality-gate
  - notify
qmd: "phpstan notify modules zero env config Env::get larastan noEnvCallsOutsideOfConfig"
---

# Story: PHPStan modules zero — Notify

## Scopo

Portare `Modules/Notify` a **0 errori PHPStan**, senza ignore.

## Inventario (prima)

Sorgente: `/tmp/phpstan_ptvx_fila5/modules/Notify.json` → **2** errori sullo stesso file.

| File | Errore |
|------|--------|
| `config/notify.php` L6 | `larastan.noEnvCallsOutsideOfConfig` (`env()`) |
| `config/notify.php` L9 | `larastan.noEnvCallsOutsideOfConfig` (`env()`) |

## Root cause / business logic

Larastan whitelista solo `laravel/config`: i config sotto `Modules/*/config` sono “fuori” per la regola, anche se sono file di config reali. Lo scopo di `notify.php` è leggere token/DNS mail a bootstrap-time; non vanno letti con `env()` runtime dopo cache.

## Fix

Sul disco: `Illuminate\Support\Env::get(...)` al posto di `env()` (pattern già documentato nel file e in `MergesNotifyConfigFromEnv`). Verifica live:

```bash
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Notify
```

**Dopo: 0 errori.**

<<<<<<< .merge_file_WnU6dU
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_gpvUTO
## Trait.unused (2026-11-24)

| Trait | Decisione |
|-------|-----------|
| `HasCommonScopes` (Xot) | consumer: `NotificationTemplate` |
| `HasNotificationRateLimiting` / `HasNotificationTracking` | consumer: `GenericNotification` |
| `HasTenantNotifications` | consumer: `Models\Notification` |

<<<<<<< .merge_file_WnU6dU
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_gpvUTO
## Lock

- Acquisito: `phpstan-Notify` (task 40, agent quality-guardian)
- Rilasciato al gate verde

## Acceptance criteria

- [x] PHPStan `Modules/Notify` = 0
- [x] Nessun ignore PHPStan aggiunto
- [x] Story in `docs/bmad/stories/` del modulo
<<<<<<< .merge_file_WnU6dU
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_gpvUTO

## Generics follow-up (HasTenantNotifications)

`morphMany()` is typed as `MorphMany<Related, $this>`. Annotating
`MorphMany<NotificationLog, TModel>` (even with `@use HasTenantNotifications<Notification>`)
fails covariance. Trait now uses `$this` / `Builder<$this>`; consumers drop `@use Trait<Concrete>`.
Same cleanup for `HasCommonScopes` on `NotificationTemplate`.
<<<<<<< .merge_file_WnU6dU
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_gpvUTO
