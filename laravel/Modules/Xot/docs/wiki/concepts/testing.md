---
title: "Testing in Xot"
type: concept
tags: [xot, testing, pest, phpstan, testcase]
created: 2026-06-13
updated: 2026-06-13
qmd: "Xot testing Pest PHPStan XotBaseTestCase bridge platform"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/43"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - phpstan-pest-bridge-discipline.md
  - ../PHPSTAN-BEST-PRACTICES.md
  - ../overviews/platform-completion-roadmap.md
  - module-testcase-xotbase-hierarchy.md
---

# Testing in Xot

Foundation: **ogni modulo** estende `XotBaseTestCase` (non `Nwidart\Modules\Tests\BaseTestCase`).

## Helper TestCase

| Metodo | Uso |
|--------|-----|
| `mockService()` | Mock in closure Pest |
| `rrmdir()` | Cleanup directory (`FixStructureTest`) |
| `expectsOnce()` | Expectation PHPUnit tipizzate |

## Quality gate

```bash
cd laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules
./vendor/bin/pest Modules/Xot/tests
```

## Completamento

- PHPStan piattaforma: ✅ (hub owner documentazione)
- [platform-completion-roadmap](../overviews/platform-completion-roadmap.md)
- [PHPSTAN-BEST-PRACTICES](../PHPSTAN-BEST-PRACTICES.md)
