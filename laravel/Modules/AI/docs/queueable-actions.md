---
qmd: "queueable actions"
issues: []
discussions: []
title: "Queueable Actions — AI Module"
type: concept
created: 2026-07-12
updated: 2026-07-13
confidence: high
tags: [queueable-action, spatie, architecture, laraxot, ai]
related:
  - Modules/Xot/docs/queueable-actions.md
---

# Queueable Actions — AI Module Doctrine

> The full doctrine lives in `Modules/Xot/docs/queueable-actions.md`.
> This module follows the same rules.

## Rules

1. Every class under `app/Actions/` is a [Spatie Laravel Queueable Action](https://github.com/spatie/laravel-queueable-action).
2. The only public entry point is `execute()`.
3. No repository pattern — no `*Repository` classes, no repository injection.
4. No inline `new ...Action` or `new ...Repository` in constructor default parameters.
5. Retire files by renaming with `.old` suffix; do not `rm` and do not create `archive/` directories.
6. YAGNI: reuse existing code, prefer stdlib/native Laravel, keep it minimal.

## Example

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Spatie\QueueableAction\QueueableAction;

class DoSomethingAction
{
    use QueueableAction;

    public function execute(): void
    {
        // business logic
    }
}
```

## Calling Convention

```php
app(DoSomethingAction::class)->execute();
```

## Verification

After every change:

```bash
cd laravel
php -d memory_limit=2048M vendor/bin/phpstan analyse Modules/AI --no-progress
vendor/bin/pint Modules/AI/app/Actions
```

## Note di manutenzione

- `GeneratePredictionDraftsAction::fallbackDrafts()` riusa i template da
  `Actions/Prediction/GetPredictionDraftFallbackTemplatesAction` invece di
  duplicarli inline: evita drift tra le due liste di template italiani
  (quality pass PHPMD/PHPInsights).

## Layout Actions (post-migrazione Services)

| Path | Ruolo |
|------|-------|
| `Actions/Prompt/BuildAIPromptAction` | Dispatcher prompt per tipo (`classification`, `solutions`, …) |
| `Actions/Prompt/AIPromptTemplates` | Costanti JSON schema (routing, pattern, improvements) |
| `Actions/MakeAIRequestAction` | HTTP chat/completions OpenAI + retry, prompt di sistema opzionale (`Actions/Support/MakeAIRequestAction` e' la variante interna) |
| `Actions/Vision/*` | Immagini via OpenRouter o Groq: estrazione JSON strutturata, modifica (vedi [vision-openrouter.md](vision-openrouter.md)) |
| `Actions/AiJsonResponseDecoderAction` | Decode JSON risposta AI (sostituisce `AIServiceJsonDecoder`) |
| `Actions/ClassifyTicketAction` | Classificazione ticket (cache + prompt + request + decode) |
| `Actions/SuggestSolutionsAction` | Suggerimenti soluzioni ticket |

**Eliminato:** `app/Services/` — niente layer `*Service`; logica in Actions queueable.

### Esempio prompt + request

```php
$prompt = app(BuildAIPromptAction::class)->execute('classification', [
    'title' => $title,
    'description' => $description,
]);

$raw = app(MakeAIRequestAction::class, [
    'prompt' => $prompt,
    'type' => 'classification',
])->execute();

$data = AiJsonResponseDecoderAction::decodeObject($raw);
```
