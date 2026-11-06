---
title: "[STORY] PHPStan zero errori — Seo (namespace Datas)"
type: story
module: Seo
status: done
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, namespace, psr-4, bmad, seo, swarm]
---

# [STORY] PHPStan zero errori — Seo

## User Request

Swarm PHPStan sui Modules (baseline 1600 errori): zero errori nel modulo Seo risolvendo la causa, non l'errore (131 errori in 4 file).

## Analysis

**Una sola causa per 128 errori su 131.** `Modules\Seo\Datas\MetatagData` e `SocialShareData` risultavano "class not found" perche' i due file in `app/Datas/` dichiaravano `namespace Modules\Seo\Data;` (commit `0e5c581`, che aveva rinominato il namespace lasciando la cartella `Datas/`). Con l'autoload PSR-4 `Modules\Seo\ => app/` la classe `Modules\Seo\Data\MetatagData` non esiste su disco; `Adapters\MetatagManager` e i test in `tests/Unit/Data` importavano ancora `Datas\...`, mentre Actions, Facade, Contract, `MetatagState`, widget e `tests/Unit/Datas` importavano `Data\...`. A runtime `class_exists('Modules\Seo\Data\MetatagData')` era `false` fuori dal solo scan di PHPStan.

**Scopo.** `MetatagData` e' il DTO (Spatie Data + `Wireable`) con lo stato dei metatag della richiesta; `SocialShareData` alimenta `GenerateSocialShareLinksAction` e il widget. Namespace canonico scelto: `Modules\Seo\Datas` (cartella `app/Datas/`, stessa convenzione di `Modules\Xot\Datas`, `docs/04-datas.md`); il verso opposto avrebbe richiesto di spostare i file.

**Causa 2 (3 errori).** `tests/Feature/SitemapDetailTemplatesTest.php` importava `Modules\Blog\Models\Article`; il modulo Blog non e' in questo repo (Seo e' un modulo riusabile, Blog ne e' un consumatore opzionale via `SitemapPathsContract`). Il test ora risolve il modello dal container solo se la classe esiste e altrimenti salta con `Assert::markTestSkipped`.

## Result (PHPStan verificato 2026-10-28)

`./vendor/bin/phpstan analyse Modules/Seo` : **131 -> 0 errori**. `php -l` pulito sui file toccati. Autoload verificato: `Modules\Seo\Datas\{MetatagData,SocialShareData}` caricabili, `Modules\Seo\Data\MetatagData` no. Pest **non eseguito** (`.env.testing` = MySQL).

## Acceptance Criteria

- [x] Un solo namespace per i DTO, uguale alla cartella (`Modules\Seo\Datas`)
- [x] Nessun `use Modules\Seo\Data\...` residuo in `app/` e `tests/`
- [x] Test Blog-dipendente salta se Blog non e' installato, senza classi inesistenti nel codice
- [x] PHPStan: 0 errori sul modulo Seo
- [ ] Pest in sqlite (non eseguito)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [phpstan-zero-errors-seo.dev.md](./phpstan-zero-errors-seo.dev.md)
