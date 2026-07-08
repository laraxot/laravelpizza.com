---
title: "User Module Quality Status"
type: "quality-report"
date: 2026-07-08
version: 1.2
---

# Modulo User — Stato Qualità

## Status Summary

| Aspetto | Status | Ultimo Aggiornamento |
|---------|--------|----------------------|
| **Merge Conflicts** | ✅ Risolti | 2026-07-08 |
| **PHPStan `app/` lvl10** | ✅ OK | 2026-07-08 |
| **PHP Insights `app/`** | ✅ OK | 2026-07-08 |
| **PHPMD** | ⚠️ Warning noti (StaticAccess, complexity) | 2026-07-08 |
| **Pest** | ✅ Unit HasTeams + DebugConfig su MySQL | 2026-07-08 |
| **Git push** | ⚠️ Richiede `pull --rebase` prima di push | 2026-07-08 |
| **Documentazione** | ✅ Aggiornata | 2026-07-08 |

## PHPStan

```bash
cd laravel
XDEBUG_MODE=off ./vendor/bin/phpstan analyse Modules/User/app --level=10
```

Nessun errore su `app/`. Dettaglio storico: [phpstan-syntax-blockers.md](phpstan-syntax-blockers.md).

## Test (Pest)

- `TestCase` usa `DatabaseTransactions` su connessioni `mysql` e `user` (no SQLite, no `RefreshDatabase`).
- Database da `laravel/.env.testing`; migrazioni eseguite esternamente con `--env=testing`.

```bash
cd laravel
./vendor/bin/pest Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php --no-coverage
```

## Git workflow modulo

Regola: [wiki/rules/module-commit-push-after-change.md](wiki/rules/module-commit-push-after-change.md)

```bash
cd laravel/Modules/User
git fetch laraxot dev
git pull --rebase laraxot dev
git push -u laraxot dev
```

## PHPMD

Warning attesi su pattern Laravel (facades, Assert static). Non bloccanti per push; eventuali suppress mirati con commento `// phpmd:` sul metodo.

## Session Log

- **2026-07-08**: PHPStan lvl10 su `app/` verde; TestCase allineato a MySQL; docs aggiornate; push in attesa di rebase su `laraxot/dev`.
