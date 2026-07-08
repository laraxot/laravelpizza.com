---
title: "Testing in AI"
type: concept
tags: [ai, testing, pest, phpstan, openai]
created: 2026-06-13
updated: 2026-06-13
qmd: "AI modulo testing Pest PHPStan SentimentAction CompletionAction"
issues:
  - "https://github.com/laraxot/module_ai_fila5/issues/12"
discussions:
  - "https://github.com/laraxot/module_ai_fila5/discussions/13"
related:
  - ../overviews/ai-module.md
  - ../troubleshooting/pest-test-suite-fixes.md
  - ../../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md
  - ../../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
---

# Testing in AI

Modulo **AI**: Actions OpenAI/sentiment, provider `AIServiceProvider`, test in `tests/Unit/Actions/`.

## Convenzioni

- Pest (`test()`, `describe()`, `uses(TestCase::class)`)
- `Modules\AI\Tests\TestCase` → `XotBaseTestCase`
- Assertion: `PHPUnit\Framework\Assert::assert*` (no `expect()` per PHPStan L10)
- `DatabaseTransactions` vietato `RefreshDatabase`

## Quality gate

```bash
cd laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules/AI
./vendor/bin/pest Modules/AI/tests
```

## Stato (2026-06-13)

| Area | Stato |
|------|-------|
| PHPStan | ✅ 0 errori |
| Worktree | 🔄 `SentimentActionTest.php`, `CompletionActionTest.php` modificati — allineare e Pest green |
| `.pest.php` | ✅ vietato |

## Prossimi passi

1. Chiudere refactor `SentimentActionTest` con pattern Assert (come Activity)
2. Issue [#12](https://github.com/laraxot/module_ai_fila5/issues/12) — coverage Actions
3. Mock OpenAI in `TestCase::setUp()` — config `services.openai.*` già presente

## Hub piattaforma

[platform-completion-roadmap](../../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md)
