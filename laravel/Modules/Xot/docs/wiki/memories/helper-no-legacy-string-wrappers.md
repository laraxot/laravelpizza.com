---
title: "Helper legacy string wrappers rimossi"
type: memory
module: Xot
tags: [xot, helper, ponytail, stdlib, str]
created: 2026-06-30
updated: 2026-06-30
qmd: "Helper snake_case str_slug starts_with legacy wrapper Str ponytail"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - ../log.md
---

# Helper — niente wrapper Laravel 5

Rimossi da `helpers/Helper.php` (2026-06-30): `snake_case`, `str_slug`, `str_singular`, `starts_with`, `ends_with`, `str_contains` globali.

Usare `Illuminate\Support\Str` o funzioni PHP 8 (`str_contains`, `str_starts_with`, `str_ends_with`).
