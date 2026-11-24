---
title: "Cms — test e .env.testing"
type: concept
tags: [cms, testing, env, xot]
created: 2026-06-12
updated: 2026-06-12
qmd: "Cms module pest env testing CreatesApplication PageSlugMiddleware"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/364"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/365"
related:
  - ../../../../Xot/docs/wiki/concepts/env-testing-parity-copy-env.md
  - ../../../../../../docs/wiki/bmad/architecture-env-testing-parity.md
---

# Modulo Cms e `.env.testing`

## Bootstrap

`Modules\Cms\tests\TestCase` estende `Modules\Xot\Tests\XotBaseTestCase` → trait `CreatesApplication` carica `laravel/.env.testing` quando `APP_ENV=testing`.

## Contratto

1. `laravel/.env.testing` deve esistere e essere sync da `.env` (`./bashscripts/tools/sync-env-testing.sh`)
2. `phpunit.xml` non sovrascrive `DB_*`
3. Test Feature usano `DatabaseTransactions` — mai `RefreshDatabase`

## Perché per Cms

Le pagine CMS (Sushi/JSON) e i test Folio (`PageSlugMiddleware`, `ResolvePageAction`) girano sullo stesso stack DB del progetto. Parità MySQL evita falsi verdi su SQLite.

## Canon

- Xot: [env-testing-parity-copy-env.md](../../../../Xot/docs/wiki/concepts/env-testing-parity-copy-env.md)
- Moduli: [TESTING-ARCHITECTURE.md](../../../../docs/TESTING-ARCHITECTURE.md)
