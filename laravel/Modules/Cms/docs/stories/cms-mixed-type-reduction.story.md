---
tags: [documentation]
qmd: "cms mixed type reduction.story"
issues: []
discussions: []
title: "Cms: riduzione uso del tipo mixed dove il tipo reale e' noto"
type: story
module: Cms
story_id: cms-mixed-type-reduction
slug: cms-mixed-type-reduction
status: done
created: 2026-09-04
updated: 2026-09-04
---

# Cms — Riduzione uso di `mixed`

## Contesto

Convenzione di progetto (root `CLAUDE.md`): "cerchiamo di non usare mixed, quando lo
troviamo cerchiamo di sostituirlo con qualcosa di adeguato". Il modulo Cms aveva ~71 file
con `mixed` (native type-hint o docblock). Task best-effort ("dove possibile"), non 100%
di copertura.

## Cosa e' stato trovato

`grep -rnE '\bmixed\b' Modules/Cms --include="*.php"` -> 71 file. Di questi, solo un
sottoinsieme aveva `mixed` come **native type-hint reale** (parametro/return type di
funzione, non dentro un commento `@property`/`@method`); il resto sono docblock
`@property`/`@method static` auto-generati da ide-helper che rispecchiano le firme di
`Illuminate\Database\Eloquent\Builder` o colonne JSON traducibili — fuori scope per
narrowing (romperebbero la corrispondenza con la vera firma vendor).

## Cosa e' stato fatto

7 file modificati, tutti native type-hint con tipo reale desumibile dal chiamante:

1. `app/Providers/RouteServiceProvider.php` — `mixed $item` -> `int|string $item`
   (proviene da `array_keys()` su un array di config).
2. `tests/TestCase.php` — `getPackageProviders(mixed $app)` -> `getPackageProviders(Application $app)`,
   allineato al parent `Modules\Xot\tests\XotBaseTestCase` che gia' usa `Illuminate\Foundation\Application`.
3. `tests/TestHelper.php` — un `map()` su `GetModulesNavigationItems::execute()`
   (`array<int, NavigationItem>` dichiarato) tipizzato `Filament\Navigation\NavigationItem`.
4. `tests/Feature/FilamentBuilderBlocksTest.php` — closure su
   `GetAllBlocksAction::execute()` (`DataCollection<int, ComponentFileData>`) tipizzata
   `ComponentFileData`; rimosso un guard `method_exists()` diventato ridondante.
5. `tests/Feature/HomepageFilamentBlocksArchitectureTest.php` — stesso pattern, 2 occorrenze.
6. `tests/Feature/CmsContentManagementTest.php` — `fn (mixed $i)` su `range(1, 12)` ->
   `fn (int $i)`; `fn (mixed $page)` su `Page::query()->get()->filter()` -> `fn (Page $page)`.

Dettaglio completo per file, incluse le occorrenze lasciate `mixed` con motivazione, in
`docs/coverage.md`, sezione "2026-09-04 — Riduzione uso di `mixed`".

## Verifica

- PHPStan: `./vendor/bin/phpstan analyse Modules/Cms --no-progress --error-format=table`
  -> 0 errori prima, 0 errori dopo (baseline gia' pulita, diff non ha introdotto regressioni).
- PHPMD: crash noto/flaky su tutto il modulo (`No node to visit provided for
  visitAnonymousClass`), non causato da questo diff; rieseguito sui soli file modificati,
  solo debito pre-esistente non correlato (naming convention, parametro non usato su
  override di metodo contratto framework).
- Pest: nessun `Modules/Cms/phpunit.xml` nel modulo, comando canonico
  (`./vendor/bin/pest Modules/Cms/tests -c Modules/Cms/phpunit.xml`) non eseguibile per
  questo modulo — nessuna suite dedicata.

## Cosa resta da fare

Le decine di occorrenze `mixed` nei docblock ide-helper di `app/Models/Page.php` e degli
altri model (`Attachment`, `Menu`, `PageContent`, `Section`) restano intoccate: sono
generate meccanicamente e rispecchiano firme vendor (`Builder::whereJsonContains`,
`pluck`, ecc.) — un narrowing manuale li disallineerebbe dal vero contratto e verrebbe
sovrascritto al prossimo giro di ide-helper generate. Fuori scope per questo task.
