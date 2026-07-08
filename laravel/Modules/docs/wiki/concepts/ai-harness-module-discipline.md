---
title: "AI harness — disciplina agenti (tutti i moduli)"
type: concept
tags: [modules, ai, harness, second-brain, bmad, frontmatter]
created: 2026-06-05
updated: 2026-06-05
qmd: "modules ai harness agent discipline second brain bmad frontmatter hackernoon all modules"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./second-brain-operating-model.md
  - ../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../../docs/wiki/bmad/architecture.md
  - ../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../Xot/docs/wiki/concepts/second-brain-local-discipline.md
---

# AI harness — moduli Laraxot

Contratto **trasversale** per ogni `laravel/Modules/<Nome>/docs/`.

## Canon (non duplicare)

| Argomento | Fonte |
|-----------|--------|
| Tips 001–022 | [hackernoon-ai-coding-tips-fixcity-map.md](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md) |
| Second brain locale | [Xot second-brain-local-discipline.md](../../Xot/docs/wiki/concepts/second-brain-local-discipline.md) |
| Schema DB / migrate | [bmad/architecture.md](../../../../../docs/wiki/bmad/architecture.md) |
| Frontmatter + GitHub | [wiki-markdown-frontmatter-mandatory.md](../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md) |

## Checklist agente (da `llm-wiki.txt`)

| # | Gate | Verifica |
|---|------|----------|
| 0 | Bootstrap | `docs/chat/INDEX.md`, trigger map, QMD `-n 5` |
| 1 | Git | Forward-only; scope isolato (Tip 001) |
| 2 | Piano | Story/dev-story se task non banale (Tip 003/008) |
| 3 | GitHub | Issue+discussion owner modulo nel frontmatter |
| 4 | Frontmatter | `validate-wiki-frontmatter.sh` — URL con `/issues/N` |
| 5 | Second brain | Pagina locale + `log.md` (Tip 020) |
| 6 | Architecture | 5 pilastri se tocca DB/migrate |
| 7 | Anti-workslop | Capisco ogni riga; no package inventati (313/300) |
| 8 | Lock | `touch`/`rm` `.lock` su file editati |
| 9 | Chiusura | `verify-llm-wiki.sh`, `llm-wiki-qmd.sh update` |

Prompt: [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)

## Obblighi per modulo owner

1. **Capture** — bugfix/decisione → pagina in `docs/wiki/concepts/` o `troubleshooting/`
2. **Frontmatter** — `issues` + `discussions` URL **completi e pertinenti** al file; se mancano → `gh issue create` + discussion
3. **BMAD** — story base + issue owner modulo (`git remote -v` in `Modules/<M>/`)
4. **QMD** — `bashscripts/docs/llm-wiki-qmd.sh search "<Modulo> <topic>" -n 5` prima di edit massivi
5. **Quality** — PHPStan L10 post-edit PHP; no workslop (Tip 006/021)
6. **Stub** — `second-brain-local-discipline.md` punta a canon Xot; estensioni in `ai-harness-<modulo>-discipline.md` solo se serve

## Estensioni locali (solo se serve)

Pagina `ai-harness-<modulo>-discipline.md` **solo** per regole non coperte dal canon (es. Fixcity ticket, User R1, Geo map-lit).

## Script audit

```bash
bashscripts/tools/audit-module-artifact-parity.sh <ModuleName>
bashscripts/tools/validate-wiki-frontmatter.sh laravel/Modules/<Module>/docs/wiki/index.md
```

## Collegamenti

- [second-brain-operating-model.md](./second-brain-operating-model.md)
- [Modules wiki index](../index.md)
