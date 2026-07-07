---
title: "Archivio cartelle root maiuscole — modulo Xot"
type: concept
module: Xot
status: active
tags: [module-structure, helpers, xotdata, metatagdata, archive]
updated: "2026-06-30"
related:
  - ../../../../../../docs/project/module-root-structure-analysis.md
  - ../../helper-autoload-compatibility.md
  - ../reference/xotdata-metatagdata-not-simple-dto.md
---

# Archivio cartelle root maiuscole — Xot

## Regola

Cartelle standard alla root: **lowercase**. Eccezione operativa: `helpers/Helper.php` (minuscolo) è il path **canonico** registrato in `composer.json` → `files`; non va archiviato in `.bak`.

## Cartelle archiviate `.bak`

| Archivio | Note | Canonico |
|----------|------|----------|
| `Datas.bak/` | stub legacy | `app/Datas/XotData.php` |
| `Filament.bak/` | form component | `app/Filament/Forms/Components/` |
| `Helpers.bak/` | copia maiuscola helper | `helpers/Helper.php` + `app/Helpers/` |
| `Services.bak/` | ArrayService legacy | `app/Services/` |
| `View.bak/` | `_components.json` | `app/View/` o `resources/views/` |

## XotData e MetatagData — non sono DTO semplici

- **XotData** (`app/Datas/XotData.php`): oggetto di configurazione globale, `Wireable`, risoluzione tenant/moduli, decine di proprietà operative.
- **MetatagData** (`app/Datas/MetatagData.php`): SEO + asset + colori tema, transformer, integrazione Filament/Livewire.

Qualsiasi modifica richiede PHPStan, PHPMD (`/phpmd` root progetto), PHPInsights e smoke `php artisan serve` sul perimetro toccato.

## spatie/laravel-permission

Presente in `Modules/Xot/composer.json` → `"spatie/laravel-permission": "*"`. Non rimuovere: base RBAC Laraxot.

## PHPStan

`laravel/phpstan.neon` → `scanFiles`: `./Modules/Xot/helpers/Helper.php` (path minuscolo).
