---
description: Divieto di creare cartelle o file probe per PHPStan anche nei temi.
---

# No PHPStan probe files in themes

## Regola

Nei temi (a partire da `Themes/Zero`) non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Motivazione

I file probe sono scorciatoie artificiali per silenziare PHPStan. La regola del progetto richiede di risolvere il problema a monte: correggere i docblock, usare `@phpstan-ignore` giustificato o scrivere test reali con `XotBaseTestCase`.

## Riferimento

Vedi anche:

- `@/var/www/_bases/base_ptvx_fila5/.windsurf/rules/no-phpstan-probe-models.md`
- `@/var/www/_bases/base_ptvx_fila5/laravel/Modules/Xot/docs/phpstan-modules-fix-log.md`
