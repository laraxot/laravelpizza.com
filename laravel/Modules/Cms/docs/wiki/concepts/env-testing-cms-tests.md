---
title: "Cms — test e .env.testing"
type: concept
tags: [cms, testing, env, xot]
created: 2026-06-12
updated: 2026-10-20
qmd: "Cms module pest env testing CreatesApplication PageSlugMiddleware"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/364"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/365"
related:
  - ../../../../Xot/docs/wiki/concepts/env-testing-parity-copy-env.md
  - ../../../../../../docs/wiki/bmad/architecture-env-testing-parity.md
status: draft
---

# Modulo Cms e `.env.testing`

## Bootstrap

`Modules\Cms\Tests\TestCase` estende `Tests\TestCase` (`laravel/tests/TestCase.php`) dal merge `c0a06773` del 2026-10-20; fino al 2026-10-08 estendeva `Modules\Xot\Tests\XotBaseTestCase`, il cui trait `CreatesApplication` carica `laravel/.env.testing` quando `APP_ENV=testing` (vale ancora per i test Auth che dichiarano `uses(Modules\Xot\Tests\TestCase::class)`). Decisione aperta: tornare a `XotBaseTestCase` come base di modulo (vedi [phpstan-test-wave-cms](../../stories/phpstan-test-wave-cms.story.md)).

## Contratto

1. `laravel/.env.testing` deve esistere e essere sync da `.env` (`./bashscripts/tools/sync-env-testing.sh`)
2. `phpunit.xml` non sovrascrive `DB_*`
3. Test Feature usano `DatabaseTransactions` — mai `RefreshDatabase`

## Perché per Cms

Le pagine CMS (Sushi/JSON) e i test Folio (`PageSlugMiddleware`, `ResolvePageAction`) girano sullo stesso stack DB del progetto. Parità MySQL evita falsi verdi su SQLite.

## Canon

- Xot: [env-testing-parity-copy-env.md](../../../../Xot/docs/wiki/concepts/env-testing-parity-copy-env.md)
- Moduli: [TESTING-ARCHITECTURE.md](../../../../docs/TESTING-ARCHITECTURE.md)
