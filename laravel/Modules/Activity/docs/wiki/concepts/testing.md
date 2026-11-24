---
title: "Testing in Activity"
type: concept
tags: [activity, testing, pest, phpstan, audit-log]
created: 2026-06-13
updated: 2026-06-13
qmd: "Activity testing Pest PHPStan Assert audit log Actions"
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/18"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/16"
related:
  - phpstan-pest-discipline.md
  - ../overviews/completion-status.md
  - ../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md
---

# Testing in Activity

## Pest + PHPStan L10

- `uses(Modules\Activity\Tests\TestCase::class)`
- Assertion: `PHPUnit\Framework\Assert::assert*` — **no** `expect()` ([phpstan-pest-discipline](phpstan-pest-discipline.md))
- `UserFactory::new()->createOne()` per tipi non-null

## Quality gate

```bash
cd laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules/Activity
./vendor/bin/pest Modules/Activity/tests
```

## Completamento modulo

| Voce | Stato |
|------|-------|
| PHPStan | ✅ |
| Pest runtime | 🔄 DB test |
| Roadmap | [completion-status](../overviews/completion-status.md) |

Hub: [platform-completion-roadmap](../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md)
