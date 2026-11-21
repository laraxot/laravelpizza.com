---
title: "FolioVoltServiceProvider è l'unico owner Folio"
type: rule
module: Cms
status: active
qmd: "folio volt service provider sole owner no app FolioServiceProvider cms modules pages"
related:
  - ../folio-runtime-governance.md
  - ../laravel-folio-governance.md
  - ../wiki/concepts/folio-filesystem-routing-no-web-php.md
  - ./README.md
  - ../../../Activity/docs/bmad/stories/folio-routing-centralization.story.md
  - ../../../Activity/docs/prompts/01.md
  - ../../../../../docs/chat/INDEX.md
---

# FolioVolt = unico owner del mount Folio

Sostituisce le doc stale che citavano `App\Providers\FolioServiceProvider`.
Link da: `folio-runtime-governance.md`, story Activity centralizzazione, prompt Activity 01.
Istruzione utente: scomodare `laravel/app/Providers/FolioServiceProvider.php` quando esiste
`FolioVoltServiceProvider` è sbagliato — basta Cms.

## Scopo e perché

In Laraxot il FO/API Folio non vive in `laravel/app/Providers`. L'unico owner è:

`Modules\Cms\Providers\FolioVoltServiceProvider`

(registrato da `Modules/Cms/module.json` / `composer.json` extra).

**Non** creare né registrare `App\Providers\FolioServiceProvider`.

## Cosa fa FolioVolt (KISS)

- tema `pub_theme` pages per ogni locale
- `resources/views/pages` di ogni modulo abilitato (`uri($locale)`)
- `pages/api` → `uri('/api')` + middleware `web`
- mount in `booted()`; Volt::mount sugli stessi path

## Anti-pattern

| Sbagliato | Perché |
|---|---|
| `laravel/app/Providers/FolioServiceProvider.php` | Secondo cervello di routing; Cms basta |
| `Folio::path` nei provider di modulo | Anti-DRY |
| Doc con `App\Providers\FolioServiceProvider` | Stale |

## ECC (engineering change contract)

| Check | Atteso |
|---|---|
| File App Folio | assente |
| Registrazione | solo `Cms/module.json` + `composer.json` extra → `FolioVoltServiceProvider` |
| Mount moduli | path `resources/views/pages` se esiste (Activity incluso) |
| Pest | `Cms/tests/Unit/Providers/FolioVoltSoleOwnerTest.php` |
| Second brain | questo file + [folio-runtime-governance.md](../folio-runtime-governance.md) |

## Verifica

```bash
test ! -f laravel/app/Providers/FolioServiceProvider.php
rg -n 'App\\\\Providers\\\\FolioServiceProvider' laravel --glob '*.php'  # vuoto
php artisan folio:list --path=api/log-download
cd laravel && php artisan test Modules/Cms/tests/Unit/Providers/FolioVoltSoleOwnerTest.php
```
