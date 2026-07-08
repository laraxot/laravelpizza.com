---
description: Divieto di creare cartelle o file probe per PHPStan in questo modulo.
---

# No PHPStan probe files in Lang

## Regola

Nel modulo `Lang` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Applicazione pratica

Il trait `Modules\Lang\Models\Traits\HasStrictTranslations` è condiviso e può non avere consumer diretti nel modulo. Invece di creare un modello probe, si usa `@phpstan-ignore trait.unused` nel docblock del trait.

## Riferimento

Vedi anche:

- `@/var/www/_bases/base_ptvx_fila5/.windsurf/rules/no-phpstan-probe-models.md`
- `@/var/www/_bases/base_ptvx_fila5/laravel/Modules/Xot/docs/phpstan-modules-fix-log.md`
