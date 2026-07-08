---
description: Divieto di creare cartelle o file probe per PHPStan in questo modulo.
---

# No PHPStan probe files in Job

## Regola

Nel modulo `Job` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Perché

Questi file sono modelli o classi artificiali create solo per far passare PHPStan. Se un trait risulta non usato nel modulo, si aggiunge `@phpstan-ignore trait.unused` nel docblock del trait. Se un test deve esercitare un trait, si usa una classe anonima all'interno del test.

## Riferimento

Vedi anche:

- `@/var/www/_bases/base_ptvx_fila5/.windsurf/rules/no-phpstan-probe-models.md`
- `@/var/www/_bases/base_ptvx_fila5/laravel/Modules/Xot/docs/phpstan-modules-fix-log.md`
