---
title: "[DEV] PHPStan Cms a zero - ripasso swarm 2026-10-28"
type: dev
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [cms, phpstan, tests, swarm]
related:
  - ./phpstan-cms-zero.story.md
  - ./phpstan-cleanup-cms.dev.md
---

# [DEV] PHPStan Cms a zero - ripasso swarm 2026-10-28

## Metodo

1. `phpstan analyse Modules/Cms` sul working tree (144 errori; l'elenco del brief ne aveva 168, gli altri erano `typeCoverage`, visibili solo a progetto intero).
2. Cause radice cercate con `git log -S` e `git show` (sola lettura): `PestHelpers.php` e `app/docs/config.php` avevano perso correzioni gia' fatte (918dc27e, ce5d0208) per risoluzione di conflitti "un lato solo".
3. Nessun `@phpstan-ignore`, baseline, `assert()`/`@var` di comodo; `phpstan.neon` non toccato; nessun file cancellato.

## File toccati

- `app/`: `Actions/BuildPageSchemaAction.php`, `Http/Middleware/{PageSlugMiddleware,SetFolioLocale}.php`, `Models/{Menu,BaseTreeModel,Page}.php`, `Providers/RouteServiceProvider.php`, `Filament/Resources/SectionResource/Pages/ViewSection.php`, `docs/config.php`.
- `tests/`: `PestHelpers.php`, `TestCase.php`, `TestHelper.php`, `pest.php`, `Feature/{ResolvePageModelExposureTest,HomepageFilamentBlocksArchitectureTest,FilamentBuilderBlocksTest}.php`, `Feature/Frontoffice/*` (rimossi `return;`/`continue;` dopo `cmsSkipTest`), `Unit/Filament/ResourceExtensionTest.php`, `Unit/Models/MenuBusinessLogicTest.php`, `Unit/Http/Controllers/Admin/XotPanelControllerTest.php`.
- `docs/`: `testing.md` (regole su `cmsSkipTest`/utenti di test), questa storia.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Cms --memory-limit=-1 --no-progress --error-format=raw   # exit 0, nessun errore
php -l <file toccati>
```

Pest **non eseguito**: `.env.testing` punta a MySQL (regola DB sacri).

## Decisioni aperte

- `XotPanelControllerTest.php` mantiene il nome ma testa "nessun Controller HTTP nel Cms"; il nome del file e' fuorviante, rinominarlo richiede un `git mv` fuori dal brief.
- `ResolvePageModelExposureTest` usa la `Tests\TestCase` della radice: li' `cmsSkipTest()` lancerebbe `LogicException` (serve `Modules\Cms\Tests\TestCase`), quindi lo skip e' dichiarativo (`->skip(...)`). Il file dichiara anche `uses(TestCase::class)` mentre `tests/pest.php` lega `Modules\Cms\Tests\TestCase` a `Feature`/`Unit`: da verificare con Pest in CI.
- `app/docs/config.php` e' un config Jigsaw dentro `app/` (PSR-4): fuori posto, non spostato (nessuna cancellazione/spostamento).
- `Page.php` tiene ancora `@method static ... getBlocksBySlug` duplicato; `PageSchemaBuilder` duplicato orfano (nota aperta 2026-10-06, non toccato).
- `docs/testing.md` e `docs/phpstan-compliance.md` contengono ancora marker `<<<<<<< HEAD` del rebase aperto: non risolti (stato git dell'utente).
- Durante il lavoro un altro processo ha modificato gli stessi file `app/` e alcuni test del Cms (stesso elenco errori): lo stato finale e' quello misurato sopra.