---
title: "Activity — stato completamento modulo"
type: overview
tags: [activity, completion, phpstan, pest, audit-log]
created: 2026-06-13
updated: 2026-06-13
qmd: "Activity modulo completamento audit log PHPStan Pest expect Assert"
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/18"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/16"
related:
  - ../concepts/phpstan-pest-discipline.md
  - ../concepts/activity-log-single-migration-contract.md
  - ../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md
---

# Activity — stato completamento

## Scopo modulo

Tracciamento eventi utente/modello (audit log) per Fixcity e piattaforma. Business: **sapere chi ha fatto cosa e quando** senza duplicare logica in ogni modulo.

## Qualità (2026-06-13)

| Gate | Stato |
|------|-------|
| PHPStan `Modules/Activity` | ✅ 0 errori |
| Pest | 🔄 verificare dopo fix DB test (`forge_mysql_25_1`) |
| Migrazione `activity_log` | ✅ 1 file `create_*` owner |

## Migliorie applicate (sessione gate)

Convertiti **7 file** in `tests/Unit/Actions/`:

- `ActivityLoggerTest.php` — massivo: tutte le `expect()` → `Assert::assert*()`
- `LogActionsTest.php`, `LogModelCreatedActionTest.php`, `LogModelUpdatedActionTest.php`, `LogModelDeletedActionTest.php`
- `LogUserLoginActionTest.php`, `LogUserLogoutActionTest.php`

Pattern:

```php
use PHPUnit\Framework\Assert;

// Factory: createOne() non make() — evita argument.type Collection|User
$user = UserFactory::new()->createOne();
Assert::assertInstanceOf(User::class, $user);

// Eccezioni: try/catch, non test()->throws() (PHPStan function.void)
```

Dettaglio: [phpstan-pest-discipline](../concepts/phpstan-pest-discipline.md).

## Da completare

### P1 — Test runtime
- [ ] Pest green su `Modules/Activity/tests` con DB test configurato
- [ ] Issue [#18](https://github.com/laraxot/module_activity_fila5/issues/18) coverage

### P2 — Pulizia legacy
- [ ] Audit test duplicati `BaseModelBusinessLogic*` in `tests/` (se ancora presenti)
- [ ] Rimuovere file obsoleti in `docs/archive/` solo dopo ingest wiki

### P3 — Integrazione Fixcity
- [ ] Verificare `LogUserLoginAction` / logout su flusso auth User
- [ ] Activity su CRUD ticket (created/updated/deleted) via listener o Action

## Non fare

- Convertire Pest in classi PHPUnit
- `RefreshDatabase` / `migrate:fresh`
- Modificare `phpstan.neon`

## Hub piattaforma

[Roadmap completamento piattaforma](../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md)
