---
issues: []
discussions: []
title: "Package Dependency Chaos Map (Lang)"
module: "Lang"
type: concept
tags: [ottimizzazioni, correzioni]
created: 2026-07-14
updated: 2026-07-14
qmd: "ottimizzazioni correzioni"
related:
  - "./italian-text-refined-audit-report.md"
---
# Package Dependency Chaos Map (Lang)

## Catalogo completo
- [Composer Packages Full Catalog (2026-03-02)](../../Xot/docs/composer-packages-full-catalog-2026-03-02.md)

## Pacchetti studiati rilevanti
- `mcamara/laravel-localization`
- `spatie/laravel-translatable`
- `lara-zeus/spatie-translatable`
- `laravel/framework`

## Rischi principali
1. Namespace traduzioni errato (`pub_theme::` vs namespace modulo).
2. Strutture traduzione flattenate o incomplete.
3. Fallback locale non coerente su frontoffice.

## Test operativo minimo
```bash
php artisan test --filter=Lang --compact
./vendor/bin/phpstan analyze Modules/Lang --level=10
```
