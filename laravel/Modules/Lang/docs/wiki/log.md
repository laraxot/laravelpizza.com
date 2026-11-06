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
status: draft
---

# Lang - Wiki Activity Log

## [2026-10-14] docs | Studio del codice e correzione degli ingressi

- Verificato: `__()` non scrive; il writer e' `SaveTransAction` via `AutoLabelAction` (acceso fuori dai test perche' `config('lang.save_missing_translations')` e' NULL a runtime); `TranslatorAdapter` non agganciato. README sostituito, `index.md` con 41 link ripuntati a `best-practices.md`/`api-reference.md`.
- Story: [2026-10-14-docs-lang-studio](../stories/docs-lang-studio.story.md). Memoria: [nota di memoria](../../../../../bashscripts/ai/wiki/memories/docs-cms-lang-tenant-seo-studio.md)

## [2026-06-12] testing | TranslationFactory auto-increment id

- Pest coverage STORY-345 ha evidenziato `UNIQUE constraint failed: translations.id`.
- Fix: `TranslationFactory` non valorizza piu' `id`; la migration usa `$table->id()` e l'id resta al database.
- Nuova regola: [translation-factory-auto-increment-id](rules/translation-factory-auto-increment-id.md).

## [2026-06-05] docs | HackerNoon harness: tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-progetto corrente-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt) _(target mancante, verificato 2026-10-14)_
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
