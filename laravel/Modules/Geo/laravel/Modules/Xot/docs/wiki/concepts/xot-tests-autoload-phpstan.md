---
title: "Xot Tests autoload e PHPStan"
type: concept
module: Xot
tags: [xot, phpstan, autoload, tests, testcase]
created: 2026-06-13
updated: 2026-06-13
qmd: "Xot Tests autoload XotBaseTestCase class not found phpstan composer psr-4"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/330"
related:
  - ../../../../../../docs/wiki/PHPSTAN-INDEX.md
  - ../../../../../../docs/wiki/memories/phpstan-neon-immutable-agents.md
  - ./phpstan-pest-bridge-discipline.md
---

# Xot Tests autoload e PHPStan

## Problema

PHPStan segnala a cascata:

- `Class Modules\Xot\Tests\XotBaseTestCase not found`
- `method.notFound` su `assertSame`, `markTestSkipped`, `seed`
- `function.resultUnused` su `uses()`, `it()`, `test()` Pest

## Causa radice

In `Modules/Xot/composer.json` l'autoload PSR-4 era incoerente:

- `autoload` conteneva `Modules\Xot\tests\` (minuscolo) via chiave commentata
- `autoload-dev` conteneva `Modules\Xot\Tests\` (ma non risolveva per PHPStan/composer merge)
- I file test usavano `namespace Modules\{Mod}\Tests\...` mentre Activity/Fixcity/User/Xot avevano ancora `tests` minuscolo

`class_exists('Modules\Xot\Tests\XotBaseTestCase')` restituiva **false** → catena TestCase rotta su tutti i moduli.

## Fix (codice, non neon)

1. **`Modules/Xot/composer.json`**: registrare `Modules\Xot\Tests\` in `autoload.psr-4` (produzione), rimuovere mapping minuscolo.
2. **`composer dump-autoload`**
3. **Normalizzare namespace** `Modules\{Mod}\tests` → `Modules\{Mod}\Tests` in Activity, Fixcity, User, Xot.
4. **`PestFunctionBridge.php`**: `uses|test|it|describe` → `void`; `expect()` → `PestExpectation` (catene tipizzate).
5. **Pest in file namespaced**: `uses(\Modules\Geo\Tests\TestCase::class)` sempre FQCN; `uses()` **dopo** gli `import use`.

## Verifica

```bash
cd laravel
php -r "require 'vendor/autoload.php'; var_dump(class_exists('Modules\\Xot\\Tests\\XotBaseTestCase'));"
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules
# atteso: [OK] No errors
```

## Regola sacra

**Solo l'utente modifica `laravel/phpstan.neon`.** Gli agenti correggono codice, autoload composer dei moduli, bridge Pest e PHPDoc.

## Collegamenti

- [phpstan-neon-immutable.md](../../phpstan-neon-immutable.md)
- [Chat sessione 2026-06-13](../../../../../../docs/chat/2026-06-13-phpstan-modules-zero-errors.md)
