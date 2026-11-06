---
title: "[DEV] PHPStan zero errori — Seo (namespace Datas)"
type: dev
module: Seo
story: "./phpstan-zero-errors-seo.story.md"
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, namespace, psr-4, bmad, seo, swarm]
---

# [DEV] PHPStan zero errori — Seo

## Technical Plan

- `namespace Modules\Seo\Datas;` in `app/Datas/MetatagData.php` e `app/Datas/SocialShareData.php`.
- `Modules\Seo\Data\` -> `Modules\Seo\Datas\` in 8 file di `app/` e `tests/` (Contract, Facade, Actions, `MetatagState`, widget, test).
- `SitemapDetailTemplatesTest`: modello Blog risolto da stringa + `instanceof Model`, skip se assente.

## Files to Modify

- `app/Datas/{MetatagData,SocialShareData}.php`, `app/Contracts/MetatagDataContract.php`, `app/Facades/Metatag.php`, `app/Adapters/MetatagState.php`, `app/Actions/GenerateSocialShareLinksAction.php`, `app/Actions/Metatag/{Merge,Replace}MetatagDataAction.php`, `app/Filament/Widgets/SocialShareWidget.php`
- `tests/Unit/Datas/*`, `tests/Unit/Actions/GenerateSocialShareLinksActionTest.php`, `tests/Feature/SitemapDetailTemplatesTest.php`
- docs: `README.md`, `04-datas.md`, `social-sharing-component.md`

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Seo --memory-limit=-1 --no-progress --error-format=raw
php -r 'require "vendor/autoload.php"; var_dump(class_exists("Modules\Seo\Datas\MetatagData"));'
```

Esito: 0 errori; autoload `Datas` = true, `Data` = false.

## Lessons Learned

- **Il namespace segue la cartella** (PSR-4 `Modules\Seo\ => app/`): `app/Datas/` => `Modules\Seo\Datas`. Rinominare solo l'una o l'altra rompe l'autoload e, a catena, ogni tipo che la usa (`mixed` che si propaga: 128 errori da una dichiarazione).
- Un riferimento a un modulo opzionale (Blog) non va scritto come `use`/`new` letterale: PHPStan lo vede anche in un ramo morto. Risolvere da stringa e restringere con `instanceof`.
- Restano `tests/Unit/Data/` e `tests/Unit/Datas/` con test gemelli (namespace test diversi, `Tests\Modules\Seo\Unit\Data` non PSR-4): da unire in una passata dedicata, senza cancellare qui.
