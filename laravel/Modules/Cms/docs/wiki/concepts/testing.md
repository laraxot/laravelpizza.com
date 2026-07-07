---
title: "Testing in Cms"
type: concept
tags: [cms, testing, pest, phpstan, volt]
created: 2026-06-05
updated: 2026-06-13
qmd: "Cms testing Pest Volt RegisterComponent PHPStan reflection"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/52"
discussions:
  - "https://github.com/laraxot/module_fixcity_fila5/discussions/53"
related:
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
  - ../../../../docs/wiki/rules/cms-x-page-data-bag-only.md
---

# Testing in Cms

## Pest PHP

Test auth FO separati per scope: `LoginTest`, `LoginVoltComponentTest`, `LoginWidgetTest`, … — non duplicare con naming inconsistente.

## PHPStan (2026-06-13)

| Fix | Dettaglio |
|-----|-----------|
| `RegisterTest` | Rimosso PHPDoc `@var $this` orfano in placeholder |
| `RegisterComponentTest` | `ReflectionClass::hasMethod('register')` al posto di `method_exists` (già narrowed) |

## Quality gate

```bash
cd laravel
./vendor/bin/pest Modules/Cms/tests
./vendor/bin/phpstan analyse Modules/Cms
```

## Completamento

- [ ] Implementare test Register FO reali (placeholder attuale)
- [ ] Feature test header navigation JSON ([STORY hub](../../../../docs/chat/2026-06-11-st351-phpstan-pest-hub.md))
- [ ] Verificare `<x-page>` solo data bag su pagine CMS-driven
