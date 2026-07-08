---
title: "Modules Wiki Index"
type: index
tags: [modules, wiki, index, second-brain, bmad]
created: 2026-04-15
updated: 2026-06-05
qmd: "modules wiki index second brain ai harness bmad architecture parity"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./concepts/second-brain-operating-model.md
  - ./concepts/ai-harness-module-discipline.md
  - ../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../docs/wiki/bmad/architecture.md
---

# Modules Wiki Index

## Scopo

Wiki trasversale per tutti i moduli Laravel del progetto.

## AI / second brain

- [hackernoon-ai-coding-tips-fixcity-map](../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md) — Tips 001–022
- [bmad/architecture](../../../../docs/wiki/bmad/architecture.md) — 5 pilastri + harness
- [ai-harness-module-discipline](./concepts/ai-harness-module-discipline.md) — contratto agenti
- [second-brain-operating-model](./concepts/second-brain-operating-model.md) — PARA/CODE
- [Xot canon second-brain](../Xot/docs/wiki/concepts/second-brain-local-discipline.md)

## Documentazione (tutti i moduli)

- [Frontmatter YAML + GitHub](../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md)
- [frontmatter-github-links-standard](../../../../docs/wiki/memories/frontmatter-github-links-standard.md)

## Architettura DB

- [Parità N modelli = N migrate/factory/seeder](../../../../docs/wiki/bmad/architecture-module-model-artifact-parity.md)
- [updateTimestamps solo in tableUpdate](../../../../docs/wiki/rules/migration-update-timestamps-only.md) — no duplicati in `tableCreate`
- Audit: `bashscripts/tools/audit-module-artifact-parity.sh <Module>` · `audit-migration-timestamp-redundancy.sh`

## Harness per modulo (estensioni)

| Modulo | Pagina |
|--------|--------|
| Xot | [ai-harness-xot-discipline](../Xot/docs/wiki/concepts/ai-harness-xot-discipline.md) |
| Fixcity | [ai-harness-fixcity-discipline](../Fixcity/docs/wiki/concepts/ai-harness-fixcity-discipline.md) |
| User | [ai-harness-user-discipline](../User/docs/wiki/concepts/ai-harness-user-discipline.md) |
| Geo | [ai-harness-geo-discipline](../Geo/docs/wiki/concepts/ai-harness-geo-discipline.md) |

## Log

- [log](./log.md)
