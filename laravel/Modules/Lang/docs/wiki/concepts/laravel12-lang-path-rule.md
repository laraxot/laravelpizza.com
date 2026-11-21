---
issues: []
discussions: []
title: "Laravel 13 lang path rule"
module: "Lang"
type: rule
tags: [migration, filament]
created: 2026-07-14
updated: 2026-07-14
qmd: "migration filament"
related:
  - "./italian-text-refined-audit-report.md"
---
# Laravel 13 lang path rule

## Sintesi

Per il modulo `Lang`, il riferimento valido e sempre `lang/` e non `resources/lang/`.

## Regola modulo

- modulo: `laravel/Modules/Lang/lang/{locale}/...`
- host app: `laravel/lang/{locale}/...`
- vietato documentare come standard: `resources/lang/...`

## Backlink

- [Regola globale Laravel 13 lang root](../../../../../docs/wiki/concepts/laravel12-lang-root-rule.md)
