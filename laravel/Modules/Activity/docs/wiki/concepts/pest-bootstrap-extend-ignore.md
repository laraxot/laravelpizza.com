---
title: pest bootstrap extend con phpstan-ignore inline
description: Eccezione Activity — pest()->extend(TestCase) al posto di require_once PestStubs.php.
document_type: concept
module: Activity
status: active
language: it-IT
updated_at: 2026-08-19
related:
  - ./phpstan-pest-discipline.md
  - ../../stories/3.10.activity-pest-extend-bootstrap.story.md
  - ../../../../Xot/docs/wiki/concepts/pest5-configuring-tests.md
  - ../../../../../../bmad-output/architecture.md
tags: [activity, pest, phpstan, bootstrap, extend]
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/48"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/16"
type: note
updated: 2026-10-23
qmd: "pest bootstrap   `pest()->extend()` con ignore inline (activity) activity"
---

# Pest bootstrap — `pest()->extend()` con ignore inline (Activity)

## Perché

`require_once __DIR__.'/PestStubs.php'` caricava stub manuali per `actingAs`/`livewire` solo per
PHPStan. Con **Pest 5** e i plugin ufficiali (`pest-plugin-laravel`, `pest-plugin-livewire`
installati via modulo Xot), gli stub non servono più a runtime né nel bootstrap.

La doc Pest 5 raccomanda [`pest()->extend(TestCase::class)`](https://pestphp.com/docs/configuring-tests).

## Soluzione Activity (story 3.10)

```php
/** @phpstan-ignore method.internalClass */
pest()->extend(\Modules\Activity\Tests\TestCase::class)->in('Unit/Bootstrap');
```

- **Non** modificare `laravel/phpstan.neon` — ignore **solo inline** su `tests/Pest.php`.
- **Non** bindare `XotBaseTestCase` abstract — sempre il `TestCase` concreto del modulo.
- Scope pilota `Unit/Bootstrap`: evita conflitto con i file legacy che dichiarano ancora `uses(TestCase::class)`.

## Caricamento Pest.php modulo (nwidart)

Pest legge `{rootPath}/{testDirectory}/Pest.php`. Da monorepo `laravel/`:

```bash
cd laravel
./vendor/bin/pest -c Modules/Activity/phpunit.xml \
  --test-directory=Modules/Activity/tests \
  --filter=PestExtendBootstrap --no-coverage
```

Senza `--test-directory=Modules/Activity/tests`, Pest carica solo `laravel/tests/Pest.php` e
`pest()->extend` del modulo **non** viene applicato.

## Test di verifica

- `tests/Unit/Bootstrap/PestExtendBootstrapTest.php` — meta-contratto file + binding TestCase + factory

## Quando non replicare

Regola generale (ADR-017): provare prima gate PHPStan **senza** ignore. Activity documenta
l'eccezione esplicita: `extend` + ignore inline preferito a qualsiasi `require_once`.

## Collegamenti

- [phpstan-pest-discipline](./phpstan-pest-discipline.md)
- [Story 3.10](../../stories/3.10.activity-pest-extend-bootstrap.story.md)
- [Xot pest5 configuring-tests](../../../../Xot/docs/wiki/concepts/pest5-configuring-tests.md)
