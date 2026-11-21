---
title: "Ollama Actions — ownership nel modulo AI"
type: concept
module: AI
tags: [ai, ollama, actions, module-boundaries, ownership]
created: 2026-07-24
updated: 2026-07-24
qmd: "AI Ollama ChatOllamaAction GenerateOllamaAction ownership module boundary not Xot"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/18"
discussions: []
related:
  - ./local-first-ollama-strategy.md
  - ../../ollama-actions-moved-from-xot.md
  - ../../../../../../docs/wiki/rules/domain-actions-belong-to-domain-module.md
  - ../../../../../../docs/wiki/concepts/xot-is-framework-base-not-domain-owner.md
  - ../../../../../../docs/wiki/skills/xot-is-framework-base.md
---

# Ollama Actions — vivono in AI, non in Xot

## Perché

Il modulo **AI** è l’owner di chat/generate Ollama, compression LLM e predizioni.
`Modules/Xot` è solo framework/base: non deve ospitare `Actions/AI/`.

## Canon path

| Classe | Path | Namespace |
|--------|------|-----------|
| `ChatOllamaAction` | `app/Actions/Ollama/ChatOllamaAction.php` | `Modules\AI\Actions\Ollama` |
| `GenerateOllamaAction` | `app/Actions/Ollama/GenerateOllamaAction.php` | `Modules\AI\Actions\Ollama` |
| `ContextCompressorAction` | `app/Actions/ContextCompressorAction.php` | `Modules\AI\Actions` |

```php
use Modules\AI\Actions\Ollama\ChatOllamaAction;

$result = app(ChatOllamaAction::class)->execute('domanda', [
    'options' => ['num_predict' => 128],
    'think' => 'low',
]);
```

## Storia

Spostate da `Modules/Xot/app/Actions/AI/Ollama/` il 2026-07-24.
Dettaglio: [ollama-actions-moved-from-xot.md](../../ollama-actions-moved-from-xot.md).

Root rule: [domain-actions-belong-to-domain-module](../../../../../../docs/wiki/rules/domain-actions-belong-to-domain-module.md).
