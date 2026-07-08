---
title: "Pest tests — global class imports"
type: rule
module: Xot
tags: [pest, testing, php-warning, reflection, modules]
created: 2026-06-12
updated: 2026-06-12
qmd: "pest tests ReflectionClass non compound use statement warning remove global class import"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/345"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../docs/wiki/rules/testing-modules-pest.md
  - ./module-testcase-xotbase-hierarchy.md
---

# Pest tests — global class imports

## Regola

Nei test Pest/PHPUnit senza namespace non importare classi globali PHP come `ReflectionClass`:

```php
use ReflectionClass; // vietato nei file senza namespace
```

Il file e' gia' nel namespace globale, quindi l'import e' inutile e PHP emette il warning:

```text
The use statement with non-compound name 'ReflectionClass' has no effect
```

## Pattern corretto

Rimuovere la riga `use ReflectionClass;` e mantenere l'uso diretto:

```php
$reflection = new ReflectionClass($object);
```

Se un test viene spostato dentro un namespace esplicito, usare invece `new \ReflectionClass($object)` o un import composto realmente utile.

## Perche'

- riduce rumore nei log Pest coverage;
- evita warning durante bootstrap suite;
- mantiene i test KISS, senza alias inutili;
- non cambia semantica: nei test senza namespace `ReflectionClass` era gia' globale.

## Audit rapido

```bash
rg -n '^use ReflectionClass;$' laravel/Modules/*/tests
```