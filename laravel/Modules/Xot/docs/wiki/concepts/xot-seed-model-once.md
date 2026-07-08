---
title: "xotSeedModelOnce — seed entity idempotente"
type: concept
module: Xot
tags: [phpstan, seeders, factory, xot, dry]
created: 2026-06-30
updated: 2026-06-30
qmd: "xotSeedModelOnce GetFactoryAction entity seeder phpstan factory"
related:
  - ../troubleshooting/phpstan-modules-fix.md
---

# xotSeedModelOnce

## Scopo

Entity seeders Laraxot creano **un record** per tabella canonica. PHPStan non risolve `Model::factory()->count(1)->create()` quando la factory è generica o la catena è opaca.

## API

```php
xotSeedModelOnce(Article::class);
```

Definita in `Modules/Xot/helpers/Helper.php`. Delega a `GetFactoryAction` per ottenere la factory corretta del modello.

## Quando usarla

| Scenario | Pattern |
|----------|---------|
| Entity seeder standard (1 record) | `xotSeedModelOnce(Model::class)` |
| Seeder con attributi custom | Factory esplicita + PHPDoc `@var` se necessario |
| Bulk demo data | Factory `count(n)` con n > 1 — tipizzare il modello |

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
```
