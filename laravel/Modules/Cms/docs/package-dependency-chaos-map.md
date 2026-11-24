---
title: "package dependency chaos map"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "package dependency chaos map"
issues: []
discussions: []
---

# Package Dependency Chaos Map (Cms)

## Catalogo completo
- [Composer Packages Full Catalog (2026-03-02)](../../Xot/docs/composer-packages-full-catalog-2026-03-02.md)

## Pacchetti studiati rilevanti
- `laravel/framework`
- `laravel/folio`
- `livewire/volt`
- `calebporzio/sushi`
- `spatie/laravel-data`
- `mcamara/laravel-localization`

## Rischi principali
1. Rendering page/block rotto per regressioni su Folio/Volt.
2. Contratto blocchi JSON alterato nel layer Sushi/Data.
3. Fallback locale incoerente su localizzazione URL/contenuti.

## Test operativo minimo
```bash
php artisan test --filter=Cms --compact
./vendor/bin/phpstan analyze Modules/Cms --level=10
```
