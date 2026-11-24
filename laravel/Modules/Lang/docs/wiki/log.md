---
title: "Lang Wiki Activity Log"
type: log
module: Lang
tags: [lang, wiki, pest, factory, qmd]
created: 2026-05-11
updated: 2026-06-12
qmd: "Lang wiki activity log pest factory auto increment id translation factory sqlite"
issues:
  - "https://github.com/laraxot/platform/issues/345"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
---

# Lang - Wiki Activity Log

## [2026-06-12] testing | TranslationFactory auto-increment id

- Pest coverage STORY-345 ha evidenziato `UNIQUE constraint failed: translations.id`.
- Fix: `TranslationFactory` non valorizza piu' `id`; la migration usa `$table->id()` e l'id resta al database.
- Nuova regola: [translation-factory-auto-increment-id](rules/translation-factory-auto-increment-id.md).

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-progetto corrente-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/platform/issues/272) / [D#273](https://github.com/laraxot/platform/discussions/273)

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created index.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-05-12] docs | lang wiki routing-first indicization

- riscritti `rules/index.md` e `skills/index.md` per esporre regole e skill realmente caricabili on-demand.
- aggiunte `rules/translation-key-governance.md` e `skills/translation-key-audit.md`.
- aggiornato `index.md` con focus operativo su chiavi, path e ownership delle traduzioni.
