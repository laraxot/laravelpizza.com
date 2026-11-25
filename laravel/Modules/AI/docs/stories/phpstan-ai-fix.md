---
title: "phpstan ai fix"
type: note
tags: [documentation, phpstan, ai]
updated: 2026-11-17
qmd: "phpstan ai fix wave builder pest expect cache"
issues: []
discussions: []
id: phpstan-ai-fix
slug: phpstan-ai
scope: [module:AI]
status: Done
priority: High
created: 2026-09-06
---

## Problema

PHPStan su `Modules/AI` non a zero: unione PHPDoc `Builder|Model`, `Cache::remember` tipizzato `mixed`, `preg_replace` non-string, Pest `expect()` → `method.internalClass`.

## Inventario wave (2026-11-17)

- Partenza: **36** errori (`/tmp/phpstan-wave/AI.tsv`)
- Arrivo: **0** (`./vendor/bin/phpstan analyse Modules/AI --memory-limit=-1`)

## Cause radice e fix

| Causa | Fix |
|-------|-----|
| `@method static Builder\|Model query()` sui model AI | Solo `Builder<static>` (come `AiThread`) |
| Larastan tipizza `lazyById()` come `stdClass` | Annotazione `LazyCollection<int, AiMessage>` + materializzazione `list` |
| `Cache::remember` → `mixed` | `Assert::string($result)` prima del decode/return |
| `preg_replace` → `string\|array\|null` | Guard `is_string` in `stripFence` |
| Pest `expect()` / `->with()` / `$this->fail()` | `PHPUnit\Framework\Assert` + foreach al posto di `->with()` |
| `Request` ArrayAccess → `mixed` | Helper `requestPayload()` + check `is_array` |

## File toccati

- `app/Models/{AiMessage,AiKnowledgeEntry,AiActionProposal,AiToolLog}.php`
- `app/Actions/Assistant/BuildAssistantReportAction.php`
- `app/Actions/Vision/ExtractStructuredDataFromImagesAction.php`
- `app/Services/AIService.php`
- `tests/Feature/UserIdColumnsAcceptUuidTest.php`
- `tests/Unit/Assistant/{AssistantDataTest,RequestAssistantCompletionActionTest}.php`
- `tests/Unit/Vision/VisionActionsTest.php`

## Gate

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/AI --memory-limit=-1 --error-format=raw
```

## Collegamenti

- Canonical story aggiornata (supersede inventari precedenti nella stessa story)
- Concetto: [phpstan-compliance](../wiki/concepts/phpstan-compliance.md)
