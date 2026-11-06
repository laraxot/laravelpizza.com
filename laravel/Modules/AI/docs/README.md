---
qmd: "README"
issues: []
discussions: []
title: "AI Module Documentation"
type: documentation
tags: [module, documentation]
created: 2026-06-05
updated: 2026-10-14
status: active
module: AI
---

# AI Module

Ingresso della documentazione del modulo. Ogni affermazione e' stata confrontata con il codice il 2026-10-14. Le versioni precedenti di questo README presentavano il modulo come "Integrazione MCP": nel codice del modulo non c'e' nulla di MCP (vedi i limiti).

## Identita' e ownership

- Namespace `Modules\AI`, alias `ai`, repository git separato.
- Provider in `module.json`: `AIServiceProvider`, `Providers\Filament\AdminPanelProvider`; il primo e' anche in `laravel/config/app.php`. `AI: true` in `laravel/modules_statuses.json` e nello stato del tenant Fixcity.
- Le Actions di dominio AI vivono in `app/Actions/` di questo modulo. Regola: [wiki/concepts/ollama-actions-ownership.md](wiki/concepts/ollama-actions-ownership.md). Stato reale: copie quasi identiche di `ChatOllamaAction` e `GenerateOllamaAction` esistono ancora in `Modules/Xot/app/Actions/AI/Ollama/` (ultimo commit 2026-10-09), quindi [ollama-actions-moved-from-xot.md](./ollama-actions-moved-from-xot.md) descrive una copia, non uno spostamento.

## Cosa contiene davvero

| Area | Contenuto verificato | Percorso |
|---|---|---|
| Client LLM | Ollama (`ChatOllamaAction`, `GenerateOllamaAction`), DS4 (`ChatDs4Action`, `GenerateDs4Action`), OpenAI (`CompletionAction`, `ContextCompressorAction`), `MakeAIRequestAction` | `app/Actions/` |
| Dominio ticket | `ClassifyTicketAction`, `SuggestSolutionsAction`, prompt `BuildTicketClassificationPromptAction` e `BuildTicketSolutionsPromptAction`, `SentimentAction` (driver base o Transformers) | `app/Actions/` |
| Dominio previsioni | `GeneratePredictionsAction`, `Predict/GeneratePredictionDraftsAction`, template di ripiego, `OpenAiPredictionMapper`: dominio di un altro progetto (il modulo `Predict` non esiste qui) | `app/Actions/`, `app/Datas/` |
| Proposte di azione | `CreateAiActionProposalAction`, `ConfirmAiActionProposalAction`, `CancelAiActionProposalAction`, registro `Adapters\AiActionHandlerRegistry`, contratto `AiActionHandlerContract` | `app/Actions/`, `app/Adapters/`, `app/Contracts/` |
| Dati | modelli `AiThread`, `AiMessage`, `AiActionProposal`, `AiToolLog` e 4 migrazioni del 2026-07-24 | `app/Models/`, `database/migrations/` |
| Filament | `AiActionProposalResource`, pagine `Completion`, `FineTuning`, `Dashboard` | `app/Filament/` |
| Fine tuning | script Python `bin/fine_tuning.py` e `bin/test_fine_tuning.py` | `bin/` |
| Configurazione | `config/ai.php` (modello, temperatura, token, limiti: legge `services.openai.*`); gli endpoint `services.ollama.url` e `services.ds4.url` hanno default `localhost:11434` e `127.0.0.1:8000` e non sono definiti in `laravel/config/` | `config/` |
| Test | 11 file, 77 chiamate `it()`/`test()` | `tests/` |

## Chi lo usa davvero in questo repository

Nessuno. Un grep di `Modules\AI\` su `Modules/*/app`, `config` e `routes` degli altri moduli e su `Themes/*/resources` non trova alcun consumatore: `Fixcity` non chiama `ClassifyTicketAction` ne' `SuggestSolutionsAction`. Il modulo e' attivo ma non ancora agganciato a nessun flusso.

## Limiti

1. Nessun codice MCP: `grep -ri mcp` su `app/`, `config/`, `routes/` e `composer.json` del modulo non trova nulla. Il progetto ha il pacchetto `laravel/mcp` e `laravel/config/mcp.php`, ma `laravel/routes/ai.php` ha i server MCP solo come commento: nessun server MCP e' definito. Le guide in [mcp/](./mcp/) sono documentazione di riferimento, non descrizione del modulo.
2. Rotte: `routes/web.php` e `routes/api.php` sono vuoti; le 11 rotte del modulo (`php artisan route:list --json`) sono del pannello Filament `ai/admin`. Non esiste un'interfaccia di chat: ci sono i modelli `AiThread` e `AiMessage` e le Actions Ollama/DS4, ma nessuna pagina di chat.
3. Quasi tutta la cartella docs e' pianificazione (PRD, strategia, roadmap, sprint, lancio): vedi la sezione "Piani" di [00-INDEX.md](./00-index.md).
4. Suite Pest: il 2026-10-14 su DB usa-e-getta si ferma con `Cannot redeclare class OpenAI` (un test dichiara la classe `OpenAI`, che collide con il client `openai-php`).

## Quick start

Da `laravel/`:

```bash
# rotte del modulo (verificato il 2026-10-14: 11, tutte del pannello Filament ai/admin)
php artisan route:list --name=ai
# test su database usa-e-getta (la variabile vuota evita `unbound variable` dello script)
DB_DATABASE_LIMESURVEY= bash ../bashscripts/tools/pest-scratch-db.sh Modules/AI/tests
```

## Mappa della documentazione

Indice operativo: [00-INDEX.md](./00-index.md). Indice per argomento: [index.md](./index.md). Guide MCP: [mcp/](./mcp/). Decisioni: [decision-log.md](./decision-log.md). Registro: [wiki/log.md](./wiki/log.md). Story: [stories/](./stories/).

## AI Workflows
- [AI Methodologies](./ai-methodologies.md)
- [OpenViking Integration Guide](../../../../docs/openviking-integration.md)

## LLM Wiki Workflow

- Local compiled wiki: [./wiki/README.md](./wiki/README.md)
- Local compiled index: [./wiki/index.md](./wiki/index.md)
- Project wiki layer: [../../../../docs/wiki/README.md](../../../../docs/wiki/README.md)
- Project compiled index: [../../../../docs/wiki/index.md](../../../../docs/wiki/index.md)
- Adoption notes and QMD: [../../../../docs/project/karpathy-llm-wiki-adoption.md](../../../../docs/project/karpathy-llm-wiki-adoption.md), [../../../../docs/project/qmd-local-docs-search.md](../../../../docs/project/qmd-local-docs-search.md)
- [AI LLM Wiki](./llm-wiki.md)


## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

## Documentation

- [On-Demand Pattern](on-demand-pattern.md): Pattern per caricamento efficiente
- [QMD Setup](qmd-setup.md): Configurazione ricerca locale
- [Performance](performance-optimization.md): Metriche e best practice
- [Project Structure](project-structure.md): Directory layout
