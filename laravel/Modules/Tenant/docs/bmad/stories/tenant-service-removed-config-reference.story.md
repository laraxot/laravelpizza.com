---
title: "Config tenant che referenziava TenantService rimosso: bootstrap rotto"
status: done
module: Tenant (owner), root (config/local/trade)
type: story
qmd: "TenantService rimosso GetTenantFilePathAction config modules statuses-file bootstrap artisan"
related:
  - ../../stories/tenant-services-to-actions.story.md
  - ../../../../Xot/docs/bmad/stories/setting-page-moduli-trade.story.md
---

# Config tenant che referenziava TenantService rimosso

## Fase BMAD

Bugfix bloccante. Trovato mentre si preparava il gate di verifica della story SettingPage.

## Sintomo

`php artisan --version` e qualsiasi test Pest (anche quelli gia' esistenti, es. Activity) cadevano con
`Class "Modules\Tenant\Services\TenantService" not found` in `config/local/trade/modules.php:8`.
Larastan avvia l'app, quindi anche PHPStan era bloccato.

## Causa radice

`Modules\Tenant\Services\TenantService` (classe statica) e' stata eliminata dal modulo Tenant quando la
logica e' passata alle Actions (regola del progetto: niente `app/Services`, vedi
`tenant-services-to-actions.story.md`). Il file di config del tenant `config/local/trade/modules.php`,
caricato in `LoadConfiguration`, usava ancora `TenantService::filePath()`.

## Scopo di quella riga

`modules.php` dice a nwidart/laravel-modules dove sta `modules_statuses.json` (elenco dei moduli attivi) del
tenant. Il file giusto e' `config/<tenant>/modules_statuses.json`.

## Fix

`TenantService::filePath($f)` ha come sostituto diretto `GetTenantFilePathAction::execute($f)`: stesso calcolo
(`base_path('config/'.$tenant.'/'.$f)`), con in piu' il rifiuto dei path traversal. `GetTenantNameAction` e'
gia' scritta per girare durante `LoadConfiguration` (usa `getenv`, non le facade).

## Altri riferimenti

Cercati in `config`, `Modules`, `app`, `bootstrap`: restano solo commenti storici ("Was: TenantService::...")
in `Notify/app/Datas/*`, `Cms/.../Breadcrumb.php` e un blade commentato in `User`. Nessun codice vivo.

## Verifica

- `php -l` ok.
- `php artisan --version`: Laravel Framework 13.40.0.
- `config('modules.activators.file.statuses-file')` = `config/local/trade/modules_statuses.json`, lo stesso
  file di prima.
