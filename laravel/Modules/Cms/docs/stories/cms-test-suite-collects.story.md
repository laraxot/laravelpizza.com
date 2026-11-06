---
title: La suite Pest di Cms viene raccolta e gira
type: story
status: blocked
created: 2026-10-26
updated: 2026-10-26
module: Cms
related:
  - ../../../Xot/docs/stories/xot-test-harness-truth.story.md
  - cms-tests-truth-and-types.story.md
  - phpstan-cms-zero.story.md
tags: [pest, testing, binding, testcase]
---

# La suite Pest di Cms viene raccolta e gira

## Problema

La raccolta dei test si fermava con `Pest\Exceptions\TestCaseAlreadyInUse`:
`Feature/Auth/AuthenticationTest.php` dichiarava `uses(Modules\Xot\Tests\TestCase::class)`
ma la cartella e' gia' legata a `Modules\Cms\Tests\TestCase` da `tests/Pest.php`
(`uses(...)->in('Feature', 'Unit')`). Zero test Cms eseguiti.

## Correzioni

- Un solo binding: quello di `tests/Pest.php`, come dice gia' il suo commento e
  `phpstan-cms-zero.story.md`. Tolto `uses(...)` (e l'import inutile) da 16 file:
  15 in `Feature/Auth` e `Feature/Frontoffice/HomepageRoutingTest.php` (Xot `TestCase`),
  `Unit/Models/Traits/HasBlocksTest.php` (`XotBaseTestCase`). Anche i minuscoli non
  raccolti, per non rompere al futuro rename. Nessun rename.
- `tests/TestCase.php`: aggiunti `generateUniqueEmail()`, `getUserClass()`,
  `createTestUser()` (stessa firma di `XotBaseTestCase`), usati dai test Auth.
- `tests/TestCase.php`: ripristinati `setUp()`/`tearDown()` che valorizzano
  `$currentTest` (persi in un merge; modello `Gdpr/tests/TestCase.php`). Senza,
  `cmsTest()` in `PestHelpers.php` lanciava `LogicException` (failed da 191 a 149).

## Verifica

Dalla root: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/Cms/tests Modules/Cms/tests`

| Run | Esito |
|---|---|
| prima | `TestCaseAlreadyInUse`, 0 test |
| dopo binding | 191 failed, 400 passed, 22 skipped, 48 todo, 6 risky |
| dopo `$currentTest` | 149 failed, 421 passed, 50 skipped, 48 todo, 6 risky |

PHPStan sui 17 file toccati: 0 errori. Pint: ok.

## Aperto

- **Bloccante: i test scrivono il contenuto reale del tenant.** `Page`, `Section`,
  `PageContent` sono modelli JSON (Sushi). Test come `Unit/CmsModelsTest.php` e
  `Feature/PageManagementBusinessLogicTest.php` fanno `create`/`delete` e scrivono in
  `laravel/config/local/fixcity/database/content/`. Durante i run 2 e 3 (08:43-08:56)
  sono comparsi `pages/1.json`..`27.json` (due con slug `home` e `content_blocks` null)
  e `git status` mostra 121 file cancellati (111 pages, 8 sections, 1 menus,
  1 categories). Da ripristinare da git e da isolare (directory contenuti temporanea nel
  `TestCase`) prima di rilanciare la suite. Il run 3 e' quindi falsato.
- 29 `ComponentNotFoundException` `auth.login`/`auth.forgot-password` e 7
  `PublicPropertyNotFoundException` `$email`: componenti Volt del tema, fuori Cms.
- 22 `302` invece di `200` su `/` (redirect locale) e ~20 Folio route che danno `404`.
- 13 "Homepage JSON must have id": effetto della scrittura sopra.
- 2 `ContentIntegrityGuardTest`: file `Themes/Sixteen/scripts/design-comuni-pages.txt` mancante
  e collisione slug.
- 2 `FilamentBuilderBlocksTest`: `GetAllBlocksAction` torna array, il test legge `->module`.
