---
title: ConvertWidget - commento phpstan-ignore che non copre piu' nessun errore
status: review
owner: Media
created: 2026-10-29
related:
  - ../../../Geo/docs/stories/geo-exposed-attribute-filament-511.story.md
---

# ConvertWidget: commento phpstan-ignore che non copre piu' nessun errore

## Fase BMAD

Dev, correzione di errori PHPStan dopo il pull dei sottomoduli e il `composer update -W` (2026-10-29).

## Problema

`app/Filament/Resources/MediaResource/Widgets/ConvertWidget.php:33`: PHPStan segnala
`ignore.unmatchedIdentifier`. Sulla proprieta' `$view` c'e' `/** @phpstan-ignore property.defaultValue */`,
ma quell'errore non viene piu' riportato.

## Analisi

- Il commento arriva dal commit upstream `af9cc1b0` (2026-10-28, messaggio ".").
- Sopra c'e' anche `/** @var view-string */`. PHP legge solo l'ultimo docblock prima della proprieta',
  quindi finora valeva il commento di ignore e il `@var` restava senza effetto.
- `property.defaultValue` nasce dal controllo di Larastan sui `view-string`. Dopo l'aggiornamento
  (Larastan da 3.13.0 a 3.13.2) il valore `media::filament.widgets.convert` e' accettato. La vista
  esiste: `resources/views/filament/widgets/convert.blade.php`.
- Le regole del progetto non ammettono `@phpstan-ignore` (`phpstan.neon` con `ignoreErrors` vuoto).

## Decisione

Si toglie la riga `/** @phpstan-ignore property.defaultValue */`. Resta `/** @var view-string */`, che
torna a valere ed e' lo stesso tipo della proprieta' `$view` in `Filament\Widgets\Widget`.

Nello stesso file Pint segnalava `ordered_imports` (gia' su HEAD): l'`use` di
`ResolveMediaExporterAction` e' tornato in ordine alfabetico. Nessun altro cambiamento.

## Verifica (2026-10-29)

- `php -l` pulito, Pint passed.
- PHPStan sull'intero progetto: **0 errori**. Togliere il commento non fa riapparire `property.defaultValue`.
- Pest `tests/Unit/MediaGapAttackCoverageTest.php` (l'unico che usa `ConvertWidget`): 3/3.
- PHPMD non eseguibile dopo il `composer update -W` del 2026-10-29 (vedi
  `Quaeris/docs/stories/quaeris-tests-filament-511-islazyloaded.story.md`).

## PHPMD dopo il ripristino del PHAR (2026-10-29)

PHPMD 2.15.0 da `laravel/tools/phpmd.phar` (story `docs/stories/phpmd-phar-wrapper-restore.story.md`) sui file
toccati qui, confrontati con la versione HEAD: nessun finding nuovo, nessun fatal. I finding presenti c'erano gia'.
