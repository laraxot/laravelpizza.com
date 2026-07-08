---
title: "Pest test suite AI — fix comuni"
type: troubleshooting
tags: [pest, testing, ai, refresh-database, openai-fake]
created: 2026-06-11
updated: 2026-06-11
qmd: "AI module pest tests RefreshDatabase OpenAI fake XotBaseTestCase PHPUnit 12"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../concepts/second-brain-local-discipline.md
  - ../../../../Xot/docs/wiki/concepts/module-testcase-xotbase-hierarchy.md
  - ../../../../Xot/docs/wiki/memories/data-sacred-no-destructive-db.md
---

# Pest test suite AI — fix comuni

## Comando canonico

```bash
cd laravel
./vendor/bin/pest Modules/AI/tests/ \
  --configuration phpunit.xml \
  --coverage --coverage-filter=Modules/AI/app \
  --only-summary-for-coverage-text --colors=never --compact
```

## Regole

| Problema | Causa | Fix |
|----------|-------|-----|
| `migrate:fresh` / fatal su `Menu::ancestors()` | `RefreshDatabase` nel test o `Tests\TestCase` root | `Modules\AI\Tests\TestCase` extends `XotBaseTestCase` — **no** DB trait |
| `No tests found` (PHPUnit 12) | Annotazione `@test` rimossa | Prefisso metodo `test_*` |
| `CreateResponseChoice` final + Mockery | SDK OpenAI v0.8+ | `OpenAI::fake()` + `CreateResponse::fake()` via `Modules\AI\Tests\Support\OpenAiHttpFake` |
| HTTP reale in `GeneratePredictionsAction` | Nessun fake | `OpenAiHttpFake::fakeCompletions()` |

## Bootstrap

- `Modules/AI/tests/TestCase.php` — provider `AIServiceProvider`, config OpenAI di test
- `Modules/AI/tests/Pest.php` — solo commenti (no `uses()->in()`)
- `Modules/AI/tests/Support/OpenAiHttpFake.php` — fake HTTP completions + facade OpenAI

## Sentiment fallback

`BasicSentimentAnalyzer` usa word boundary (`Safe\preg_match`) per evitare falsi positivi (`happy` in `unhappy`). Le negazioni (`not happy`) non sono gestite — i test documentano il limite.
