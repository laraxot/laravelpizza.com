# AI agents docs index

**Path**: `bashscripts/ai/.agents/docs/`
**Last updated**: 2026-03-26
**Principio**: un argomento, un documento canonico, molti link, zero cloni.

## Hub canonici

| File | Scopo |
|---|---|
| [agents-overview.md](./agents-overview.md) | Preferenze utente stabili e orientamento generale |
| [architecture/00-INDEX.md](./architecture/00-INDEX.md) | Decisioni architetturali canoniche |
| [architecture/filament-table-vs-blade-component.md](./architecture/filament-table-vs-blade-component.md) | Regola su Blade bridge-only e `XotBaseTableWidget` |
| [../ralph/00-INDEX.md](../ralph/00-INDEX.md) | Albero canonico Ralph locale: template, prompt e governance del loop |
| [../../../../docs/project/gsd-and-bmad-workflow.md](../../../../docs/project/gsd-and-bmad-workflow.md) | Workflow canonico BMAD + GSD + Ralph a livello progetto |
| [frontend/semantic-css.md](./frontend/semantic-css.md) | Semantic CSS principles da MaintainableCSS |
| [../../../../docs/project/migration-philosophy-rule.md](../../../../docs/project/migration-philosophy-rule.md) | Regola canonica migrazioni: 1 modello = 1 migrazione |
| [openviking-setup.md](./openviking-setup.md) | OpenViking context database: runtime globale, workspace progetto, comandi, MCP |
| [09-NOTEBOOKLM-SKILL.md](./09-NOTEBOOKLM-SKILL.md) | NotebookLM skill: query notebook Google con browser automation, zero allucinazioni |

## Regole vive di questa fase

- riuso prima di invenzione;
- liste e collezioni strutturate su Filament table widget;
- i table widget del progetto estendono `XotBaseTableWidget`;
- gli indici sono il punto di ingresso, non i cloni documentali;
- una migrazione canonica per modello/tabella;
- Ralph resta nel suo albero dedicato; evitare nuove guide Ralph sparse in `docs/project/`, moduli o temi.

## Regole condivise agenti

| File | Scopo |
|------|-------|
| [accessor-auto-persistence.md](./accessor-auto-persistence.md) | Pattern SACRO Accessor con Auto-Persistenza |
| [ai-agents/index.md](./ai-agents/index.md) | Master index regole condivise Claude/Gemini/Qwen |
| [ai-agents/shared/accessor-mutator.md](./ai-agents/shared/accessor-mutator.md) | Pattern Accessor/Mutator — Livelli 1–4, auto-persistenza |
| [ai-agents/shared/critical-rules.md](./ai-agents/shared/critical-rules.md) | PHPStan L10, array syntax, DI, MCP |
| [ai-agents/shared/translation-rules.md](./ai-agents/shared/translation-rules.md) | Struttura obbligatoria 5 chiavi per campo |

## Riferimenti bidirezionali

- [Architecture index](./architecture/00-INDEX.md)
- [Agents overview](./agents-overview.md)
- [AGENTS.md](../../../AGENTS.md)
- [CLAUDE.md](../../../CLAUDE.md)
- [GEMINI.md](../../../GEMINI.md)
- [QWEN.md](../../../QWEN.md)
- [Predict docs index](../../../laravel/Modules/Predict/docs/00-INDEX.md)
- [TwentyOne docs index](../../../laravel/Themes/TwentyOne/docs/00-INDEX.md)
- [Frontend rules index](../rules/frontend/00-INDEX.md)
- [Semantic CSS Rule](../rules/frontend/semantic-css-rule.md)
