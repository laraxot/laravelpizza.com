---
issues: []
discussions: []
title: "Services/Config retired: usare Actions"
module: "Tenant"
type: concept
tags: [services, config, dead, code]
created: 2026-07-14
updated: 2026-10-20
qmd: "services config dead code retired"
related:
  - "./phpstan-corrections-january.md"
status: draft
---
# Services/Config retired: usare Actions

`Modules/Tenant/app/Services/Config/` (4 file: `ConfigStringKeyFilter.php` + 3 resolver in `Resolvers/`) e' stato archiviato in `Modules/Tenant/docs/archive/Services.old/` (2026-07-14). Era layer Services vietato dalla regola non negoziabile del progetto (Services → Actions), e referenziava anche 3 classi già cancellate da un agente precedente senza `git rm` (`TenantService.php`, `Config/ConfigResolverRegistry.php`, `Config/Contracts/ConfigResolverInterface.php`), causando `Internal error: Could not read file` in PHPStan.

## Sostituzione

| Vecchio (rimosso) | Nuovo (Action, `execute()`) |
|---|---|
| `Tenant\Services\TenantService::getConfig($key)` | `app(\Modules\Tenant\Actions\Config\GetTenantConfigArrayAction::class)->execute($key)` |
| `Tenant\Services\TenantService::saveConfig($key, $data)` | `app(\Modules\Tenant\Actions\Config\SaveTenantConfigAction::class)->execute($key, $data)` |
| `Tenant\Services\Config\ConfigStringKeyFilter::onlyStringKeys($arr)` | `app(\Modules\Tenant\Actions\Config\FilterConfigStringKeysAction::class)->execute($arr)` |

Consumer aggiornati: `Modules/User/app/Datas/{PasswordData,SocialProviderData}.php`, `Modules/User/app/Filament/Pages/Password.php`, `Modules/Notify/app/Providers/NotifyServiceProvider.php` (import morto rimosso), `Modules/User/resources/views/pages/index.blade.php` (import morto rimosso).

Dettagli investigazione completa: `docs/chat/xot-merge-conflicts-coordination.md`.

## Aggiornamento 2026-10-20: i file sono tornati

Il pull del 2026-10-20 ha riportato `app/Services/TenantService.php`,
`app/Services/Config/ConfigResolverRegistry.php`, `Contracts/ConfigResolverInterface.php` e i tre
resolver. Non e' una scelta: e' la quarta volta che un sync li ripristina (vedi anche
[stories/tenant-services-to-actions.story.md](stories/tenant-services-to-actions.story.md)).
Per ora sono stati corretti sul posto per PHPStan, senza toccare il comportamento, perche'
`HereService` e i caller live sono spariti; Services/Config e TenantService eliminati di nuovo il 2026-10-20.
Dettagli: [stories/services-to-actions-tenant.story.md](stories/services-to-actions-tenant.story.md).

## Verifica 2026-10-20: eliminati di nuovo

Dopo `rg` produzione (escluse docs/tests): zero chiamanti vivi a `TenantService` (commenti in Notify SMS Data / SmtpData; Cms Breadcrumb gia' su Action).
Eliminati di nuovo: `TenantService.php`, `ConfigResolverRegistry`, `ConfigResolverInterface`, tre resolver.
`HereService` (unico ex-chiamante) era gia' sparito con il cluster Geo.
