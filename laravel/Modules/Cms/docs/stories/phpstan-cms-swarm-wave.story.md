---
title: PHPStan Cms swarm wave (tests) — verify gate
type: story
module: Cms
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [cms, phpstan, tests, swarm]
related:
  - ./phpstan-test-wave-cms.story.md
  - ../00-INDEX.md
  - ../testing.md
---

# PHPStan Cms swarm wave (tests)

## Scopo

I test Cms devono riflettere la business logic reale: pagine/contenuti/sezioni/blocchi
e rotte Folio su JSON tenant (`SushiToJsons`), non un Cms SQL inventato (`status`,
`contents()`, `page_id`). PHPStan sui test deve restare a zero senza `@phpstan-ignore`
ne' modifiche a `phpstan.neon`.

## Baseline wave

| Artefatto | Valore |
|-----------|--------|
| TSV | `.cursor-scratch/phpstan-wave/Cms.tsv` — **359** errori (tutti in `tests/`) |
| Files | `.cursor-scratch/phpstan-wave/Cms.files` — 16 path |
| Tipi dominanti | `offsetAccess.nonOffsetAccessible`, `argument.type`, `property.nonObject`, Safe JSON, Pest redundant |

## Cosa e' gia' stato fatto (prima di questo verify)

Il lavoro correttivo e' documentato in [phpstan-test-wave-cms.story.md](./phpstan-test-wave-cms.story.md):

- Helper tipizzati in `tests/PestHelpers.php` (`cmsJsonDecodeFile`, `cmsHomepageBlocks`, …)
- Narrowing `assertInstanceOf` / `fresh()` su `Page`/`PageContent`/`Section`
- Feature business logic allineata ai modelli JSON; skip dove manca DB/tenant homepage
- Unit / duplicati case-variant portati allo stesso contenuto

## Verify (questo agente)

1. Lock: `bashscripts/lock/lock.sh laravel/Modules/Cms/tests` + `.cursor-scratch/phpstan-wave/Cms.lock`
2. HOT: `TestHelper.php` raffreddato (`age > 120s`) — **non skippato**; nessun file HOT
3. Un solo `phpstan analyse` sui path di `Cms.files`
4. Output: `.cursor-scratch/phpstan-wave/Cms.verify.txt`

| Metrica | Valore |
|---------|--------|
| Errori baseline TSV | 359 |
| Errori dopo verify | **0** |
| Exit PHPStan | 0 |
| File codice modificati da questo agente | 0 (gia' green) |
| File skippati HOT | nessuno |

## Collegamenti

- [phpstan-test-wave-cms.story.md](./phpstan-test-wave-cms.story.md) — dettaglio cause e file toccati
- [testing.md](../testing.md) — contratto PestHelpers / TestCase
- [00-INDEX.md](../00-INDEX.md) — indice docs modulo
