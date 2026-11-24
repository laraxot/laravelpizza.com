---
title: "00 INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "00 INDEX"
issues: []
discussions: []
---

# AI Module - Documentation Index

**Path**: `laravel/Modules/AI/docs/`
**Modulo**: `Modules/AI`
**Last updated**: 2026-03-26

## Documenti canonici del modulo

### Product
| File | Scopo |
|---|---|
| [PRD.md](./PRD.md) | Product requirements |
| [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) | Roadmap |
| [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) | Strategy |
| [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) | Launch plan |

### Funzionalità
| File | Scopo |
|---|---|
| [assistant.md](./assistant.md) | Assistente clienti: base di conoscenza, passaggio a una persona, report |
| [agents.md](./agents.md) | Agenti neuron-ai con tool, endpoint AG-UI, approvazioni |

### Development
| File | Scopo |
|---|---|
| [GSD_WORKFLOW.md](./GSD_WORKFLOW.md) | Workflow GSD locale al modulo |
| [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) | Sprint planning |
| [USER_RESEARCH.md](./USER_RESEARCH.md) | User research |

### Stories
| File | Scopo |
|---|---|
| [2026-10-08-services-to-actions-ai.story.md](./stories/2026-10-08-services-to-actions-ai.story.md) | Services eliminati, const a enum (2026-10-08) |
| [assistant-knowledge-base.story.md](./stories/assistant-knowledge-base.story.md) | Assistente clienti agnostico (2026-11-16) |
| [assistant-anonymous-and-per-call-keywords.story.md](./stories/assistant-anonymous-and-per-call-keywords.story.md) | Visitatori anonimi e parole sensibili per chiamata (2026-11-17) |
| [assistant-provider-cascade.story.md](./stories/assistant-provider-cascade.story.md) | Fornitori in cascata: Groq, OpenRouter, OpenAI (2026-11-17) |
| [user-ids-as-strings.story.md](./stories/user-ids-as-strings.story.md) | Id utente come stringa (UUID) (2026-11-17) |
| [assistant-widget-support.story.md](./stories/assistant-widget-support.story.md) | CreateAiThreadAction e AppendAiMessageAction (2026-11-17) |
| [assistant-quality-audit.story.md](./stories/assistant-quality-audit.story.md) | Report filtrato nel database, duplicato rimosso (2026-11-17) |

## Riferimenti canonici esterni al modulo

- [Ralph + GSD + BMAD orchestration](../../../../bashscripts/ai/.agents/docs/architecture/ralph-gsd-bmad-orchestration.md)
- [AI agents docs index](../../../../bashscripts/ai/.agents/docs/00-INDEX.md)
- [AGENTS.md](../../../../AGENTS.md)

## Nota anti-ridondanza

La governance di Ralph, BMAD e GSD non va duplicata qui: questo indice deve solo rimandare al documento canonico centrale.
