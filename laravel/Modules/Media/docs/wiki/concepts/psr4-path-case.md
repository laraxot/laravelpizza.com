---
title: "PSR-4 e casing dei path Media"
type: concept
tags: [psr-4, composer, autoload, filesystem]
created: 2026-07-16
updated: 2026-07-16
qmd: "media psr-4 casing conversions imagegenerators videogenerators"
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/38"
discussions:
  - "https://github.com/laraxot/base_workorder_fila5/discussions/12"
related:
  - "../../../../Xot/docs/wiki/concepts/psr4-one-class-one-file.md"
---

# PSR-4 e casing dei path Media

Su filesystem case-sensitive, `Modules\\Media\\Conversions\\VideoGenerators\\Webm` deve vivere in `app/Conversions/VideoGenerators/Webm.php`; directory minuscole parallele non sono equivalenti.

Quando il file canonico esiste già, eliminare la copia con casing errato invece di modificare namespace o autoload. Verifica sempre con `composer dump-autoload -o`.
