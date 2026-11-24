---
title: "laravel/folio — owner modulo Cms"
type: concept
tags: [cms, folio, composer, module-dependency, frontoffice]
created: 2026-06-06
updated: 2026-06-06
qmd: "cms laravel folio module composer dependency FolioVoltServiceProvider merge plugin root never"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/11"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/12"
related:
  - ../../../../../../docs/wiki/rules/composer-module-dependency-go.md
  - ./folio-volt-static-mount-contract.md
  - ./folio-page-shell-pattern.md
  - ../../../Modules/Xot/docs/composer-module-dependency-management.md
---

# laravel/folio — owner Cms

## Regola

| Pacchetto | Owner | Vietato in |
|-----------|-------|------------|
| `laravel/folio` | `Modules/Cms/composer.json` | `laravel/composer.json`, `Modules/Xot/composer.json` |

## Perché Cms

- `FolioVoltServiceProvider` registra `Folio::path()` sui temi
- `SetFolioLocale`, rotte FO, `ResolvePageAction` vivono in Cms
- Folio è **contratto frontoffice CMS**, non infrastruttura Xot

## Evidenza codice

- `Modules/Cms/app/Providers/FolioVoltServiceProvider.php` — bootstrap Folio
- `Modules/Cms/app/Http/Middleware/SetFolioLocale.php` — locale FO

## Workflow fix

```bash
# require in Modules/Cms/composer.json → "laravel/folio": "^1.2"
rm -rf laravel/Modules/Cms/vendor
cd laravel && php -d memory_limit=-1 composer.phar update -W
ls laravel/vendor/laravel/folio
```

## Anti-pattern

- `composer require laravel/folio` nella root Laravel
- Tenere folio in Xot “per comodità” — duplica owner e confonde audit dipendenze

## GitHub (tracciamento)

| Tipo | URL |
|------|-----|
| Issue | https://github.com/laraxot/base_techplanner_fila5/issues/11 |
| Discussion | https://github.com/laraxot/base_techplanner_fila5/discussions/12 |

## Collegamenti

- Regola globale: [composer-module-dependency-go.md](../../../../../../docs/wiki/rules/composer-module-dependency-go.md)
- BMAD: [architecture-composer-module-dependency.md](../../../../../../docs/wiki/bmad/architecture-composer-module-dependency.md)
