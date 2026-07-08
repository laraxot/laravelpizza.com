# Ponytail-audit: SentimentAction driver selection moved to config

## Finding

`Modules/AI/app/Actions/SentimentAction.php` hand-rolled a runtime
`class_exists()` check to decide between `BasicSentimentAnalyzer` and
`TransformersSentimentAnalyzer`:

```php
$analyzer = class_exists('Codewithkyrian\Transformers\Transformers')
    ? new TransformersSentimentAnalyzer
    : new BasicSentimentAnalyzer;
```

This makes analyzer selection an implicit side effect of what's installed in
`vendor/`, instead of an explicit, testable, environment-controllable choice.

## Interface/contract situation

Both analyzers already implement the same contract,
`Modules\AI\Contracts\SentimentAnalyzer` (`analyze(string $text): array`).
No new interface was needed — it already existed and was reused as-is.

## Change

- `Modules/AI/config/ai.php`: added a new `sentiment_driver` key, sourced
  from `env('AI_SENTIMENT_DRIVER', 'basic')`. Allowed values: `'basic'`
  (default) or `'transformers'`.
- `Modules/AI/app/Actions/SentimentAction.php`: replaced the `class_exists()`
  ternary with a private `resolveAnalyzer(): SentimentAnalyzer` method that
  reads `config('ai.sentiment_driver', 'basic')` via a `match` expression:

```php
private function resolveAnalyzer(): SentimentAnalyzer
{
    return match (config('ai.sentiment_driver', 'basic')) {
        'transformers' => new TransformersSentimentAnalyzer,
        default => new BasicSentimentAnalyzer,
    };
}
```

A plain `match`/config read was chosen over a container conditional binding
(in `AIServiceProvider`) because `SentimentAction` is instantiated directly
in tests (`new SentimentAction`) rather than resolved from the container —
adding constructor injection there would have forced either a container
resolution rewrite of every call site or a default-parameter workaround for
no real benefit. This keeps the diff minimal and matches the existing
convention in the module (no constructor DI is used elsewhere in
`Modules/AI/app/Actions`).

## New config key

| Key | Default | Values |
|---|---|---|
| `ai.sentiment_driver` | `'basic'` | `'basic'`, `'transformers'` |

Override via `AI_SENTIMENT_DRIVER` env var.

## Verification

- `./vendor/bin/phpstan analyse Modules/AI` — fails to bootstrap in this
  environment due to a pre-existing, unrelated missing file
  (`Modules/Xot/app/Contracts/ModelContract.php`); confirmed by stashing
  this change and re-running — identical failure occurs on `dev` HEAD
  without the change, so it is not a regression introduced here.
- `php tools/phpmd.phar Modules/AI/app/Actions/SentimentAction.php text cleancode,codesize,controversial,design,naming,unusedcode`
  — 2 pre-existing `StaticAccess` notices on `SentimentData::from()` calls,
  unrelated to the analyzer-selection change.
- `./vendor/bin/phpinsights analyse Modules/AI --no-interaction` — one style
  note on `new BasicSentimentAnalyzer`/`new TransformersSentimentAnalyzer`
  lacking parentheses, consistent with the pre-existing style already used
  for these same expressions elsewhere in the module; no new
  code/complexity/architecture regressions.
- Pest tests were not run: the test database is unreachable in this
  environment. `Modules/AI/tests/Unit/Actions/SentimentActionTest.php` was
  read and used as a behavioral spec; it instantiates `SentimentAction`
  directly and exercises `BasicSentimentAnalyzer` behavior only, which is
  unaffected by this change (default driver is still `'basic'`).
- Puppeteer/Playwright browser verification was skipped: this is
  backend-only PHP logic with no UI surface to drive.
