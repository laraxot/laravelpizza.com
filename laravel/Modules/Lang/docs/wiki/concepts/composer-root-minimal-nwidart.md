---
title: "Composer root minimale — modulo Lang"
type: concept
tags: [composer, lang, nwidart, merge-plugin]
created: 2026-06-29
updated: 2026-06-29
qmd: "Lang composer dependencies root minimal nwidart merge-plugin"
issues:
  - "https://github.com/laraxot/base_ptvx_fila5/issues/214"
discussions:
  - "https://github.com/laraxot/base_ptvx_fila5/discussions/215"
related:
  - ../../../Xot/docs/wiki/concepts/composer-root-skeleton-modular.md
  - ../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md
  - ../../composer.json
---

# Lang e composer root minimale

## Regola

Dipendenze del dominio **Lang** in `Modules/Lang/composer.json`. Il root `laravel/composer.json` resta skeleton come [base_project_fila5](https://github.com/laraxot/platform/blob/dev/laravel/composer.json).




## Merge root — solo moduli

`laravel/composer.json` → merge **solo** `Modules/*/composer.json`. **Vietato** `Themes/*/composer.json` (nwidart owner = modulo; tema = vestito Blade/assets).

Perché: [composer-merge-plugin-modules-only](../../../Xot/docs/wiki/concepts/composer-merge-plugin-modules-only.md).

## Riferimento

[Composer root minimale nwidart](../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md)
