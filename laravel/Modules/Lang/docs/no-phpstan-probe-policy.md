---
title: "no phpstan probe policy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no phpstan probe policy"
issues: []
discussions: []
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

Il ragionamento completo (logica/politica/filosofia/religione/zen di questo divieto) è
in `Modules/Xot/docs/wiki/concepts/phpstan-trait-probes.md`.

## Riferimento

Vedi anche:

- `bashscripts/ai/wiki/rules/no-phpstan-probe-models.md`
- `Modules/Xot/docs/phpstan-modules-fix-log.md`
