---
title: "AI Module Wiki Index"
type: index
module: AI
tags: [ai, wiki, index, ollama, mcp]
created: 2026-04-15
updated: 2026-07-24
qmd: "ai module wiki index ollama mcp second brain harness ownership actions"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/18"
discussions: []
related:
  - ../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../docs/wiki/bmad/architecture.md
  - ../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../../../docs/wiki/rules/domain-actions-belong-to-domain-module.md
  - ./concepts/ollama-actions-ownership.md
  - ./concepts/second-brain-local-discipline.md
---

# AI Module LLM Wiki

## Ownership Actions (2026-07-24)

- [ollama-actions-ownership](./concepts/ollama-actions-ownership.md) — Ollama/ContextCompressor in **AI**, non Xot
- Raw move note: [ollama-actions-moved-from-xot.md](../ollama-actions-moved-from-xot.md)
- Root rule: [domain-actions-belong-to-domain-module](../../../../docs/wiki/rules/domain-actions-belong-to-domain-module.md)

## AI / second brain

- [hackernoon-ai-coding-tips-fixcity-map](../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)
- [bmad/architecture](../../../../docs/wiki/bmad/architecture.md)
- [frontmatter + GitHub](../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md)
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) → canon Xot
- [local-first-ollama-strategy](./concepts/local-first-ollama-strategy.md)


Indice operativo del wiki AI.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie AI.
- [entities/](./entities/): Modelli e componenti chiave.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/): Documentazione legacy.
- [_templates/](./_templates/): Template standard.

## Regole collegate

- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.
- [laravel-boost-mcp-server](../../../../docs/wiki/concepts/laravel-boost-mcp-server.md): Server MCP Laravel Boost per AI.

## Scopo AI Module

Integrazione AI locale (Ollama) e cloud (OpenRouter) per generazione contenuti, predizioni e automazione.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [ai-mcp-governance](./concepts/ai-mcp-governance.md) | Concept | Governance MCP AI | 2026-04-21 |
| [local-first-ollama-strategy](./concepts/local-first-ollama-strategy.md) | Concept | Strategia Ollama locale | 2026-04-21 |
| [openrouter-context-compression](./concepts/openrouter-context-compression.md) | Concept | Compressione contesto OpenRouter | 2026-04-22 |
| [context-compression-plugin](./concepts/context-compression-plugin.md) | Concept | Plugin compressione contesto | 2026-04-22 |
| [bashscripts-agents-codex-skill-mirror](./comparisons/bashscripts-agents-codex-skill-mirror.md) | Comparison | Mirror skill `.agents` / `.codex` (252/252) e policy | 2026-05-04 |

## Best Practices

- Usare `handle()` non `execute()` in Spatie QueueableAction (vedi [phpstan-action-method-naming](../../../../docs/wiki/concepts/phpstan-action-method-naming.md))
- Preferire Ollama locale per token cost reduction (vedi [local-first-ollama-strategy](./concepts/local-first-ollama-strategy.md))
- Usare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))

## Bad Practices

- NUN usare `dehydrated(false)` nei trait - blocca salvataggio (vedi CoordinatePicker fix in Geo)
- NUN hardcodare API keys - usare `.env` e config (vedi [security-audit](../../../../docs/wiki/concepts/security-audit.md))
- NUN creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))

## False Friends

- `->live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))
- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [ai-mcp-governance](./concepts/ai-mcp-governance.md) | Concept | Connessione MCP AI, troubleshooting |

Aggiornato: 2026-05-11
## Composer / nwidart

- [composer-root-minimal-nwidart](concepts/composer-root-minimal-nwidart.md) — root skeleton nwidart (modello fixcity)
