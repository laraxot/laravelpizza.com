---
title: "PTVX Wiki Entry Point"
type: index
tags: [wiki, second-brain, index, qmd]
created: 2026-05-26
updated: 2026-06-18
qmd: "ptvx-project, wiki, second brain, Karpathy pattern, QMD search, architecture, modules, themes"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - "./rules/00-TRIGGER_MAP.md"
  - "./concepts/markdown-note-minimum-standard.md"
---

# PTVX Wiki Entry Point

> Master catalog — on-demand knowledge pattern. Each section routes via INDEX files.

## Rules

- [Trigger Map](./rules/00-TRIGGER_MAP.md) — unified trigger → resource routing
- [module-root-php-folders-forbidden](./rules/module-root-php-folders-forbidden.md) — PHP solo sotto `app/` nei moduli
- [phpstan-single-neon-config](./rules/phpstan-single-neon-config.md) — solo `laravel/phpstan.neon`, mai altri `.neon`
- [On-Demand Pattern](./rules/on-demand-pattern.md) — Karpathy LLM Wiki pattern
- [Rules INDEX](./rules/INDEX.md) — rule triggers

## BMAD

- [architecture](./bmad/architecture.md) — indice decisioni architetturali (ADR)
- [workflow](./bmad/workflow.md) — fasi BMAD on-demand

## Skills

- [Skills INDEX](./skills/INDEX.md) — available agent skills

## Commands

- [Commands INDEX](./commands/INDEX.md) — CLI reference

## Memories

- [Memories INDEX](./memories/INDEX.md) — reusable decisions and patterns

## Agents

- [Agents INDEX](./agents/INDEX.md) — agent coordination

## Concepts

- [second-brain](./concepts/second-brain.md)
- [schema](./concepts/schema.md)
- [module-structure](./concepts/module-structure.md)
- [actions-over-services](./concepts/actions-over-services.md)
- [accessor-auto-persistence](./concepts/accessor-auto-persistence.md)
- [architecture-guardrails](./concepts/architecture-guardrails.md)
- [ai-tooling-workflow](./concepts/ai-tooling-workflow.md)
- [bmad-operating-model](./concepts/bmad-operating-model.md)
- [second-brain-operating-model](./concepts/second-brain-operating-model.md)
- [second-brain-continuous-improvement](./concepts/second-brain-continuous-improvement.md)
- [second-brain-audit-checks](./concepts/second-brain-audit-checks.md)
- [second-brain-maintenance-cadence](./concepts/second-brain-maintenance-cadence.md)
- [context-mode-plugin](./concepts/context-mode-plugin.md)
- [context-mode-cli-reference](./concepts/context-mode-cli-reference.md)
- [spatie-permission-teams-laravel-13](./concepts/spatie-permission-teams-laravel-13.md)
- [laravel-13-upgrade-analysis](./concepts/laravel-13-upgrade-analysis.md)
- [markdown-note-minimum-standard](./concepts/markdown-note-minimum-standard.md)
- [context-mode-usage](./concepts/context-mode-usage.md)

## Patterns

- [XotBaseResourceTable configure pattern](./patterns/xotbase-resource-table-configure.md)
- [PHPStan optional contracts](./patterns/phpstan-optional-contracts.md)
- [Bugfix business logic before type](./patterns/bugfix-business-logic-before-type.md)

## PHPStan

- [filament-tablefilters-nullable](./phpstan/filament-tablefilters-nullable.md) — Filament `tableFilters` `array|null` e action PHPStan-safe
- [journey-summary](./phpstan/journey-summary.md) — riepilogo campagna PHPStan

## Analysis

- [method-name-homonym-census](./method-name-homonym-census.md) — omonimi metodi PHP cross-class (689), JSON + schede modulo/tema
- [elenco-relazioni-metodi-duplicate](../elenco-relazioni-metodi-duplicate.md) — 69 metodi che restituiscono relazioni Eloquent duplicate

## How-To Guides

### Search and Discovery
- [wiki-search-guide](./how-to/wiki-search-guide.md)
- [semantic-search-and-related-pages](./how-to/semantic-search-and-related-pages.md)
- [qmd-search-guide](./how-to/qmd-search-guide.md)
- [qmd-indexing-manifest](./how-to/qmd-indexing-manifest.md)

### Documentation Development
- [module-wiki-documentation](./how-to/module-wiki-documentation.md)
- [theme-wiki-documentation](./how-to/theme-wiki-documentation.md)
- [github-issue-agent-discipline](./how-to/github-issue-agent-discipline.md)
- [indexing-module-documentation](./how-to/indexing-module-documentation.md)
- [using-wiki-templates](./how-to/using-wiki-templates.md)

### Development Tools and Patterns
- [kilo-code-setup](./how-to/kilo-code-setup.md)
- [context-mode-setup](./how-to/context-mode-setup.md)
- [API limite contesto 131072](./how-to/api-context-length-exceeded-131072.md)
- [context-mode-overflow-prevention](./how-to/context-mode-overflow-prevention.md)
- [autocompact-thrashing-recovery](./how-to/autocompact-thrashing-recovery.md)
- [wiki-search-performance](./how-to/wiki-search-performance.md)
- [wiki-search-accessibility](./how-to/wiki-search-accessibility.md)
- [wiki-search-troubleshooting](./how-to/wiki-search-troubleshooting.md)

## Federated Pilots

- [user-module-operating-focus](../../laravel/Modules/User/docs/wiki/concepts/user-module-operating-focus.md)
- [theme-one-operating-focus](../../laravel/Themes/One/docs/wiki/concepts/theme-one-operating-focus.md)

## Sources

- [docs-landscape-modules-and-themes](./sources/docs-landscape-modules-and-themes.md)
- [root-architecture-docs](./sources/root-architecture-docs.md)
- [root-ai-docs](./sources/root-ai-docs.md)
- [root-bmad-docs](./sources/root-bmad-docs.md)
- [ingest-backlog](./sources/ingest-backlog.md)
- [second-brain-external-benchmarks](./sources/second-brain-external-benchmarks.md)
- [context-compression-mcp-setup](./sources/context-compression-mcp-setup.md)
- [kilo-code-context-and-large-projects](./sources/kilo-code-context-and-large-projects.md)
- [kilo-local-indexing-prerequisites](./sources/kilo-local-indexing-prerequisites.md)
