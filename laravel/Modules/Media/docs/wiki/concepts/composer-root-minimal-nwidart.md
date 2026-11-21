---
title: "Composer root minimale — modulo Media"
type: concept
tags: [composer, media, nwidart, merge-plugin]
created: 2026-06-29
updated: 2026-06-29
qmd: "Media composer dependencies root minimal nwidart merge-plugin"
issues:
  - "https://github.com/laraxot/base_ptvx_fila5/issues/214"
discussions:
  - "https://github.com/laraxot/base_ptvx_fila5/discussions/215"
related:
  - ../../../Xot/docs/wiki/concepts/composer-root-skeleton-modular.md
  - ../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md
  - ../../composer.json
---

# Media e composer root minimale

## Regola

Dipendenze del dominio **Media** in `Modules/Media/composer.json`. Il root `laravel/composer.json` resta skeleton; riferimento progetto legacy con debito noto — canonico per domini applicativi esterni in [composer-root-minimal-nwidart](../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md).




## Merge root — solo moduli

`laravel/composer.json` → merge **solo** `Modules/*/composer.json`. **Vietato** `Themes/*/composer.json` (nwidart owner = modulo; tema = vestito Blade/assets).

Perché: [composer-merge-plugin-modules-only](../../../Xot/docs/wiki/concepts/composer-merge-plugin-modules-only.md).

## Riferimento

[Composer root minimale nwidart](../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md)
