<<<<<<< HEAD
# Lang Wiki Log

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-21] governance | laravel12-lang-path-rule
- Corretto standard documentale: in Laravel 12 i percorsi traduzioni di riferimento sono `lang/` e non `resources/lang/`.
- Aggiunta pagina: `concepts/laravel12-lang-path-rule.md`.
- Collegata alla regola globale: `docs/wiki/concepts/laravel12-lang-root-rule.md`.
=======
---
title: "Lang Wiki Activity Log"
type: log
module: Lang
tags: [lang, wiki, pest, factory, qmd]
created: 2026-05-11
updated: 2026-06-12
qmd: "Lang wiki activity log pest factory auto increment id translation factory sqlite"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/345"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
---

# Lang - Wiki Activity Log

## [2026-06-12] testing | TranslationFactory auto-increment id

- Pest coverage STORY-345 ha evidenziato `UNIQUE constraint failed: translations.id`.
- Fix: `TranslationFactory` non valorizza piu' `id`; la migration usa `$table->id()` e l'id resta al database.
- Nuova regola: [translation-factory-auto-increment-id](rules/translation-factory-auto-increment-id.md).

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-05-12] docs | lang wiki routing-first indicization

- riscritti `rules/INDEX.md` e `skills/INDEX.md` per esporre regole e skill realmente caricabili on-demand.
- aggiunte `rules/translation-key-governance.md` e `skills/translation-key-audit.md`.
- aggiornato `index.md` con focus operativo su chiavi, path e ownership delle traduzioni.
>>>>>>> 40b96bcd6 (.)
