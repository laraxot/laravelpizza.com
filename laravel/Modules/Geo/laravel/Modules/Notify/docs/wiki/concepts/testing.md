---
title: "Testing in Notify"
type: concept
tags: [notify, testing, pest, phpstan]
created: 2026-06-05
updated: 2026-06-13
qmd: "Notify testing Pest notificationManager test doubles PHPStan"
issues:
  - "https://github.com/laraxot/module_fixcity_fila5/issues/52"
discussions:
  - "https://github.com/laraxot/module_fixcity_fila5/discussions/53"
related:
  - ./phpstan-pest-test-doubles.md
  - ../../phpstan-compliance-status.md
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
---

# Testing in Notify

## Pest PHP

Pest only. `uses(\Modules\Notify\Tests\TestCase::class)` dopo gli `import use`.

## TestCase

- Estende `XotBaseTestCase`
- `DatabaseTransactions` su `sqlite`, `notify`, `user`
- Helper: `notificationManager()`, `freshModel()`, `firstModel()`

## PHPStan (2026-06-13)

- Trait coverage: classi in `NotifyTraitTestDoubles.php`
- Mock action: `createStub` / `createUnitMock` + `expectsOnce()` — vedi [phpstan-pest-test-doubles.md](./phpstan-pest-test-doubles.md)

## Quality gate

```bash
cd laravel
./vendor/bin/pest Modules/Notify/tests
./vendor/bin/phpstan analyse Modules/Notify
```

## Completamento

- PHPStan: ✅ (gate chef 2026-06-13)
- Hub: [platform-completion-roadmap](../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md)
