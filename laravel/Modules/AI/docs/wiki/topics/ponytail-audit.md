---
title: "Topic ponytail-audit"
type: digest
status: active
qmd: "digest ceiling 100 ponytail-audit"
---

# Topic ponytail-audit

Sintesi automatica di 5 documenti (chiave `ponytail-audit`).

## Ponytail-audit: SentimentAction driver selection moved to config

_Fonte: `ponytail-audit-2.md`_

> Date (from original filename): 2026-07-02

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

## Ponytail audit — AI (over-engineering)

_Fonte: `ponytail-audit-over-engineering.md`_

# Ponytail audit — AI (over-engineering)

**Ultimo run:** 2026-06-30  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Esito run 2026-06-30

Lean già sul perimetro codice principale. Nessun finding P0–P1 nel run repo-wide.

Eventuali voci storiche (ActivityLogger, contratti Geo) sono in [docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md).

## Collegamenti

- [wiki/concepts/ponytail-audit.md](./wiki/concepts/ponytail-audit.md)

## Ponytail-audit: SentimentAction driver selection moved to config

_Fonte: `ponytail-audit.md`_

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

## Ponytail audit — AI

_Fonte: `wiki/concepts/ponytail-audit.md`_

# Ponytail audit — AI

**Delta modulo only here.** Ranked list, gate e remediation globale negli hub progetto.

- [Hub audit](../../../../../../docs/audit/ponytail-audit.md)
- [Remediation](../../../../../../docs/project/ponytail-audit-remediation.md)
- [Findings AI](../../ponytail-audit-over-engineering.md)

Aggiornare solo finding e stato specifici di questo modulo.

## Topic ponytail-audit

_Fonte: `wiki/topics/ponytail-audit.md`_

# Topic ponytail-audit

Sintesi automatica di 4 documenti (chiave `ponytail-audit`).

## Ponytail-audit: SentimentAction driver selection moved to config

_Fonte: `ponytail-audit-2.md`_

> Date (from original filename): 2026-07-02

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
