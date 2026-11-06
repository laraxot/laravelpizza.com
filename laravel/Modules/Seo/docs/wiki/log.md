---
title: "log"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
status: active
---

## [2026-10-28] phpstan | Seo 131 -> 0 errori

- Causa: `app/Datas/*Data.php` dichiaravano `namespace Modules\Seo\Data` (cartella `Datas`): autoload PSR-4 rotto, 128 errori `class.notFound`/`mixed`. Namespace canonico ora `Modules\Seo\Datas`; test Blog-dipendente con skip. Story: [phpstan-zero-errors-seo](../stories/phpstan-zero-errors-seo.story.md)

## [2026-10-14] docs | Studio del codice e correzione degli ingressi

- Verificato: il modulo ha solo la facade `Metatag` (3 Actions + `MetatagState`) e i link di condivisione social; niente Model, migration, rotte, comandi, sitemap; nessun altro modulo lo importa. README riscritto in testa, `index.md` con mappa delle directory, 9 file `stale` (5 template Jigsaw), 5 blocchi frontmatter spurii sistemati a mano.
- Story: [2026-10-14-docs-seo-studio](../stories/docs-seo-studio.story.md). Memoria: [nota di memoria](../../../../../bashscripts/ai/wiki/memories/docs-cms-lang-tenant-seo-studio.md)

## [2026-06-10] phpstan | Modulo Seo zero errori codice

- `./vendor/bin/phpstan analyse Modules/Seo` → 0 errori codice (79 fix: expect→Assert, Pest.php, TestCase)
- Campagna: [docs/chat/2026-06-10-phpstan-modules-second-brain.md](../../../../../docs/chat/2026-06-10-phpstan-modules-second-brain.md) _(target mancante, verificato 2026-10-08)_

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt) _(target mancante, verificato 2026-10-08)_
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

# Seo Wiki Log

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`
