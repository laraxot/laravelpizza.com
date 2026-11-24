---
issues: []
discussions: []
title: "Services/Config retired — usare Actions"
module: "Tenant"
type: concept
tags: [services, config, dead, code]
created: 2026-07-14
updated: 2026-07-14
qmd: "services config dead code retired"
related:
  - "./phpstan-corrections-january.md"
---
# Services/Config retired — usare Actions

`Modules/Tenant/app/Services/Config/` (4 file: `ConfigStringKeyFilter.php` + 3 resolver in `Resolvers/`) e' stato archiviato in `Modules/Tenant/docs/archive/Services.old/` (2026-07-14). Era layer Services vietato dalla regola non negoziabile del progetto (Services → Actions), e referenziava anche 3 classi già cancellate da un agente precedente senza `git rm` (`TenantService.php`, `Config/ConfigResolverRegistry.php`, `Config/Contracts/ConfigResolverInterface.php`), causando `Internal error: Could not read file` in PHPStan.

## Sostituzione

| Vecchio (rimosso) | Nuovo (Action, `execute()`) |
|---|---|
| `Tenant\Services\TenantService::getConfig($key)` | `app(\Modules\Tenant\Actions\Config\GetTenantConfigArrayAction::class)->execute($key)` |
| `Tenant\Services\TenantService::saveConfig($key, $data)` | `app(\Modules\Tenant\Actions\Config\SaveTenantConfigAction::class)->execute($key, $data)` |
| `Tenant\Services\Config\ConfigStringKeyFilter::onlyStringKeys($arr)` | `app(\Modules\Tenant\Actions\Config\FilterConfigStringKeysAction::class)->execute($arr)` |

Consumer aggiornati: `Modules/User/app/Datas/{PasswordData,SocialProviderData}.php`, `Modules/User/app/Filament/Pages/Password.php`, `Modules/Notify/app/Providers/NotifyServiceProvider.php` (import morto rimosso), `Modules/User/resources/views/pages/index.blade.php` (import morto rimosso).

Dettagli investigazione completa: `docs/chat/xot-merge-conflicts-coordination.md`.
