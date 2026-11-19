---
title: "ollama actions moved from xot"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ollama actions moved from xot"
issues: []
discussions: []
---

# Ollama actions moved from Modules/Xot to Modules/AI

**Date**: 2026-07-24

## What changed

`GenerateOllamaAction` and `ChatOllamaAction` were relocated:

- **Before**: `Modules/Xot/app/Actions/AI/Ollama/{GenerateOllamaAction,ChatOllamaAction}.php`
  (namespace `Modules\Xot\Actions\AI\Ollama`)
- **After**: `Modules/AI/app/Actions/Ollama/{GenerateOllamaAction,ChatOllamaAction}.php`
  (namespace `Modules\AI\Actions\Ollama`)

## Why

`Modules/Xot` is the framework/base module: XotBase* Filament mirrors, safe-cast
Actions, cross-module traits/providers. It must not host domain-specific logic
for a domain that already owns a dedicated module. `Modules/AI` already existed
with its own `app/Actions/{Prediction,Prompt,Sentiment,Predict,...}` structure —
Ollama chat/generate actions belong there, not in Xot.

See the general rule: [`xot-is-framework-base-not-domain-owner`](../../../bashscripts/ai/wiki/concepts/xot-is-framework-base-not-domain-owner.md)
(wiki concept) and skill `xot-is-framework-base`.

## Verification performed

- `grep -rln "GenerateOllamaAction\|ChatOllamaAction\|Xot\\\\Actions\\\\AI"` across
  `Modules/` → zero external callers before the move (dead code in the wrong place).
- `php -l` on both moved files.
- `./vendor/bin/phpstan analyse Modules/AI --memory-limit=-1` → 0 errors (had to
  clear a stale PHPStan result cache first — a multi-agent artifact, not a real
  regression; see `feedback_phpstan_stale_cache_multiagent` memory).
- `./vendor/bin/phpstan analyse Modules/Xot --memory-limit=-1` → 0 errors after removal.
- Both `Modules/Xot` and `Modules/AI` module repos committed separately (each
  module is its own git repository).

## Pitfall encountered

The `@param array{...}` / `@return array{...}` PHPDoc shapes must be preserved
verbatim across the move — a manual `mv`/rewrite can easily drop them, which
triggers PHPStan's `missingType.iterableValue` at `level: max`.
