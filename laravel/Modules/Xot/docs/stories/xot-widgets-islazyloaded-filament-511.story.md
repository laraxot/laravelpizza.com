---
title: Widget e $isLazy deprecato in Filament 5.11 - passaggio a $isLazyLoaded
status: review
owner: Xot
created: 2026-10-29
related:
  - ../../../Quaeris/docs/stories/quaeris-tests-filament-511-islazyloaded.story.md
  - ../../../Geo/docs/stories/geo-exposed-attribute-filament-511.story.md
  - ../../../../../bashscripts/ai/wiki/rules/base-class-contract-preservation.md
---

# Widget e $isLazy deprecato in Filament 5.11

## Fase BMAD

Dev, dopo l'aggiornamento di Filament da 5.10.1 a 5.11.0 (2026-10-29). Richiesta dell'utente: la proprieta'
deprecata va sostituita.

## Problema

In Filament 5.11 (`vendor/filament/support/src/Concerns/CanBeLazy.php`):

- `protected static ?bool $isLazyLoaded = null;` e' la proprieta' nuova;
- `protected static bool $isLazy = true;` e' deprecata;
- `isLazyLoaded()` restituisce `static::$isLazyLoaded ?? static::isLazy()`.

12 classi del monorepo dichiarano ancora `$isLazy`: 3 in Xot, 7 in Quaeris, 2 in User.

## Trappole

1. **Tipo:** `$isLazyLoaded` va ridichiarata `?bool`, come nel trait. Con `bool` PHP da' fatal error.
   La regola del modulo Chart diceva "SEMPRE bool, mai ?bool": valeva per `$isLazy`, non per la nuova.
2. **Classi base:** se una base dichiara `$isLazyLoaded` non null, il `$isLazy` delle sottoclassi viene
   ignorato senza errori, perche' `isLazyLoaded()` legge prima `$isLazyLoaded`. Xot e' condiviso con altri
   progetti, dove possono esserci sottoclassi con `$isLazy = false`.

## Sottotipi (regola base-class-contract-preservation)

- `XotBaseChartWidget` (astratta): 42 sottoclassi nel monorepo. 5 dichiarano `$isLazy`, tutte nella lista dei 12.
- `ModelTrendChartWidget` e `StatesChartWidget` (concrete): 0 sottoclassi nel monorepo.
- Nessun altro riferimento a `isLazy` nel codice o nelle viste dei moduli e dei temi.

## Decisione

- **Xot (3 file):** il valore e' `true`, uguale al default di Filament. Si toglie la dichiarazione
  senza introdurre `$isLazyLoaded`, cosi' nessuna sottoclasse cambia comportamento, ne' qui ne' in altri
  progetti. Un commento nella base spiega il perche'.
- **Quaeris (7) e User (2):** widget finali. `protected static bool $isLazy = X;` diventa
  `protected static ?bool $isLazyLoaded = X;`, con lo stesso valore.
- **Documentazione:** si aggiornano le regole e le guide che prescrivono `$isLazy`.

## Verifica (2026-10-29)

- **Comportamento:** `isLazyLoaded()` di tutti i 139 widget concreti di `Modules/` e `Themes/`, fotografato
  prima e dopo con lo stesso script tinker: **identico** (5 `false`, 134 `true`).
- `php -l` sui 12 file: pulito. Pint `--test`: passed. PHPStan sull'intero progetto: **0 errori**.
- Pest sui test che toccano questi widget (`XotChartWidgetsResourcePageCoverageTest`,
  `XotExecuteCoverage50Test`, `UserGapAttackCoverageTest`): 4 passati, 23 falliti per l'ambiente, non per
  la modifica. 22 per `SQLiteDatabaseDoesNotExistException` (il DB di test cerca un file SQLite con il nome
  del database MySQL) e 1 per `mockeryExpect()` non definita.
- PHPMD non eseguibile dopo il `composer update -W` (vedi story Quaeris collegata).

## Documentazione aggiornata

`protected static [?]bool $isLazy = X;` diventa `protected static ?bool $isLazyLoaded = X;` in 28 file:

- regole, guide, skill e documenti agenti in `bashscripts/ai/wiki/`, `bashscripts/ai/.agents/`,
  `bashscripts/ai/.agent/`, `bashscripts/ai/.ai/`, `bashscripts/ai/.cline/`;
- docs dei moduli Chart, Geo, Notify, UI, User, Xot.

Riscritte a mano: la regola Chart (diceva "SEMPRE bool, mai ?bool": ora il tipo giusto e' `?bool`),
`User/docs/filament-filters-and-widgets.md` e `Xot/docs/filament/xotbase-stats-overview-widget.md`.
Nella regola canonica `bashscripts/ai/wiki/rules/02-filament-ui/filament-widgets-rules.md` aggiunte le due
trappole (tipo `?bool`, niente `$isLazyLoaded` nelle basi).

Non toccati: story e riepiloghi storici, archivi (`bashscripts/ai/.agents/archive/`,
`Modules/UI/docs-archive/`) e la copia annidata `bashscripts/ai/ai/` (19 file, ruolo da chiarire).

Nota: `grep` qui e' `ugrep` e, lanciato dalla root, salta le cartelle nascoste (`.ai`, `.agent`, `.cline`).
Per censimenti completi usare `find ... | xargs grep`.

## Da valutare

I moduli usano ormai API di Filament 5.11 (`#[Exposed]` in Geo, `$isLazyLoaded` qui), ma i loro
`composer.json` chiedono ancora `filament/filament: ^5.0`. Alzarlo a `^5.11` renderebbe esplicito il requisito.

## PHPMD dopo il ripristino del PHAR (2026-10-29)

PHPMD 2.15.0 da `laravel/tools/phpmd.phar` (story `docs/stories/phpmd-phar-wrapper-restore.story.md`) sui file
toccati qui, confrontati con la versione HEAD: nessun finding nuovo, nessun fatal. I finding presenti c'erano gia'.
