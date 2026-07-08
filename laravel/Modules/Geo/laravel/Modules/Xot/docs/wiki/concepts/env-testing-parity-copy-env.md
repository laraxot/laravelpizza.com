---
title: ".env.testing — copia .env con suffisso _test su DB_DATABASE"
type: concept
tags: [testing, env, xot, database, mysql]
created: 2026-06-12
updated: 2026-06-12
qmd: "Xot env testing parity CreatesApplication sync-env-testing DB_DATABASE _test"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/364"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/365"
related:
  - ../../testing/mysql-only-testing-rule.md
  - ../../../../docs/TESTING-ARCHITECTURE.md
  - ../../../../../../docs/wiki/bmad/architecture-env-testing-parity.md
---

# `.env.testing` nel modulo Xot

## Ruolo di Xot

`Modules\Xot\Tests\CreatesApplication` è il trait condiviso da tutti i `TestCase` dei moduli. Qui si applica la **guardia** e il caricamento esplicito di `.env.testing`.

## Contratto

1. `laravel/.env.testing` esiste, è **tracciato in git**, generato da `./bashscripts/tools/sync-env-testing.sh`
2. Identico a `.env` salvo `DB_DATABASE*` → `valore_test`
3. `phpunit.xml` non imposta `DB_CONNECTION` / `DB_DATABASE`
4. Test usano `DatabaseTransactions` — mai `RefreshDatabase`

## CreatesApplication

Se `APP_ENV=testing` e il file manca → `RuntimeException` con istruzione per lo script sync.

Dopo `bootstrap/app.php`, se il file esiste → `loadEnvironmentFrom('.env.testing')` prima del bootstrap del kernel.

**Non** forzare connessioni DB nel trait: `TenantServiceProvider` configura le connessioni modulo da `DB_DATABASE*`.

## Workflow sviluppatore

```bash
cd laravel
# modifica .env ...
cd ..
./bashscripts/tools/sync-env-testing.sh
APP_ENV=testing ./vendor/bin/pest Modules/Geo/tests/Unit/Enums/EnumsTest.php
```

## Filosofia (religione Laraxot)

| Principio | Effetto |
|-----------|---------|
| **Dati sacri** | I test non scrivono mai su `fixcity_data` — solo su `fixcity_data_test` |
| **Parità engine** | Stesso MySQL/MariaDB del dev — niente SQLite che maschera bug SQL |
| **DRY** | Un `.env` da curare; `.env.testing` è derivato, non seconda fonte di verità |
| **Tenant dinamico** | `TenantServiceProvider` legge `DB_DATABASE*` dall'env — copia totale tranne nomi DB |

## Backlink moduli/temi

- Cms: [env-testing-cms-tests.md](../../../../Cms/docs/wiki/concepts/env-testing-cms-tests.md)
- Sixteen: [env-testing-pest-fo.md](../../../../../Themes/Sixteen/docs/wiki/concepts/env-testing-pest-fo.md)
- Script: [sync-env-testing.md](../../../../../../bashscripts/docs/tools/sync-env-testing.md)

## Canon storico

Regola dettagliata (esempi vietati): [mysql-only-testing-rule.md](../../testing/mysql-only-testing-rule.md)

Indice BMAD: [architecture-env-testing-parity.md](../../../../../../docs/wiki/bmad/architecture-env-testing-parity.md)
