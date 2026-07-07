---
title: "Second Brain Local Discipline"
type: concept
tags: [second-brain, llm-wiki, on-demand, local-docs]
created: 2026-05-19
updated: 2026-07-01
qmd: "second brain local discipline module theme wiki on-demand xot canonical"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - ./ai-harness-xot-discipline.md
  - ../../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
---

# Second Brain Local Discipline

**Pagina canonica (moduli Laraxot):** unica copia con corpo lungo dei contratti sotto questa intestazione.

Negli altri moduli il file **`second-brain-local-discipline.md`** in **`docs/wiki/concepts/`** è uno **stub** che punta qui; modifiche al contratto vanno sempre applicate prima in **Xot**, poi eventualmente estratto contesto modulo-specifico in altre pagine locali — non nel corpo boilerplate ripetuto.

> Local module/theme wiki discipline. Keep durable knowledge close to the code it explains, and route cross-cutting behavior back to the root wiki.

## Local Contract

- This wiki documents only knowledge owned by this module/theme.
- Root rules stay in `docs/wiki/rules/00-TRIGGER_MAP.md` and are linked, not copied.
- Source docs are evidence; they are not assumed immutable or technically read-only.
- Use QMD with `--limit` before opening raw docs or broad file trees.
- Add reusable local decisions to this wiki and append the nearest `log.md`.

## What To Store Here

- Local business rules, UI behavior, model/resource caveats, migrations, integrations.
- Source summaries that remove future rediscovery work.
- Troubleshooting notes backed by commands, errors, tests, or code references.
- Links to root rules when local behavior depends on shared Laraxot/XotBase/wiki policy.

## What Not To Store Here

- Duplicated root policy bodies.
- Merge debris, backup files, or `_archive/` wiki folders.
- Large pasted external articles.
- Claims such as "read-only" or "always" unless verified in the current tree.

## AI harness (HackerNoon Tips 001–022)

Distillato Fixcity — **non** copiare i tip nel bootstrap:

| Fase | Tip | Azione agente |
|------|-----|----------------|
| Checkpoint | 001 | `git status`; patch forward-only; **mai** `git restore` — [git-forward-only-study-old-version.md](../../../../../../docs/wiki/concepts/git-forward-only-study-old-version.md) |
| Piano | 003/017 | QMD + wiki → piano breve → act |
| Contesto | 009/013 | `llm-wiki-qmd.sh search -n 5`; no dump cartelle intere |
| Spec | 008 | BMAD story + dev-story prima del codice |
| Memoria | 020 | Capture in `docs/wiki/` locale + `log.md` |
| Qualità | 006/021 | Self-review diff; no workslop; PHPStan L10 |
| Obbedienza | 015/022 | Trigger map + quality-gates + `.cursor/rules/` |

Mappa completa: [hackernoon-ai-coding-tips-fixcity-map.md](../../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)  
Prompt router: [llm-wiki.txt](../../../../../../bashscripts/tools/prompts/llm-wiki.txt)

## Quality Gate

Before closing a docs update in this module/theme:

1. Check root trigger map for relevant rules.
2. Search local wiki with `bashscripts/docs/llm-wiki-qmd.sh search "<module> <topic>" -n 5`.
3. Update or create the smallest local page that captures the durable decision.
4. Frontmatter: `issues` + `discussions` URL **numerati e pertinenti** — `validate-wiki-frontmatter.sh`.
5. Link it from `index.md` when it should be discoverable by future agents.
6. Append `log.md` for reusable decisions.
7. On bugfix/runtime errors: apply [bugfix-business-logic-before-type.md](../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md) before patching types.

## Root References

- [00-TRIGGER_MAP.md](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- [bmad/architecture.md](../../../../../../docs/wiki/bmad/architecture.md)
- [ai-harness-module-discipline.md](../../docs/wiki/concepts/ai-harness-module-discipline.md)
- [ai-harness-xot-discipline.md](./ai-harness-xot-discipline.md)
- [on-demand-pattern.md](../../../../../../docs/wiki/rules/on-demand-pattern.md)
- [git-forward-only-study-old-version.md](../../../../../../docs/wiki/concepts/git-forward-only-study-old-version.md)
