---
created: 2026-09-26
qmd: "tenant service to actions migration"
issues: []
discussions: []
title: migrazione tenantservice ad actions
type: concept
module: Tenant
tags: [tenant, queueable-action, migration]
updated: "2026-10-08"
related:
  - ../README.md
  - ../../../docs/wiki/rules/no-services-rule.md
---

# TenantService → Actions

## Cosa è successo

`app/Services/TenantService.php` (facade statica 1:1) è stato **eliminato**. I caller usano le Actions già presenti in `app/Actions/`.

## Mappa sostituzioni

| Vecchio | Nuovo |
|---------|-------|
| `TenantService::getConfig($name)` | `app(GetTenantConfigArrayAction::class)->execute($name)` |
| `TenantService::saveConfig($name, $data)` | `app(SaveTenantConfigAction::class)->execute($name, $data)` |
| `TenantService::trans($key)` | `app(TranslateTenantKeyAction::class)->execute($key)` |
| `TenantService::allModules()` | `app(GetTenantModulesAction::class)->execute()` |
| `TenantService::config($key)` | `app(ResolveTenantConfigValueAction::class)->execute($key)` |
| `TenantService::getName()` | `app(GetTenantNameAction::class)->execute()` |
| `TenantService::filePath($filename)` | `app(GetTenantFilePathAction::class)->execute($filename)` |
| `TenantService::getConfigPath($key)` | `app(GetTenantConfigPathAction::class)->execute($key)` |
| `TenantService::getConfigNames()` | `app(GetTenantConfigNamesAction::class)->execute()` |
| `TenantService::modelClass($name)` | `app(ResolveTenantModelClassAction::class)->execute($name)` |
| `TenantService::model($name)` | `app(ResolveTenantModelInstanceAction::class)->execute($name)` |

## Perché

Config e moduli tenant sono use case distinti: un Action = un ingresso `execute()`, composizione via `app()`, niente facade statica.

## Aggiornamento 2026-10-08

I file eliminati erano tornati nel working tree (HEAD `6b31874` e' una squash che li contiene). Ritirati di nuovo, con la stessa mappa
sostituzioni sopra, piu':

- `app/Services/Config/**` (`ConfigResolverRegistry`, i tre resolver, `ConfigResolverInterface`, `ConfigStringKeyFilter`): catena mai collegata
  e con semantica diversa da `ResolveTenantConfigValueAction` (con `database` perde le connessioni). Non convertita in Action: eliminata.
- `app/Actions/TenantAction.php`: copia della facade, zero chiamanti.
- Unico chiamante vivo, `Geo/app/Services/HereService.php`, passato a `ResolveTenantConfigValueAction`.

La modifica Tenant non aggiorna quel caller esterno: Geo resta fuori ownership. La compatibilità è preservata
per il comportamento effettivo perché l'Action sostitutiva è già il percorso usato dal modulo Tenant e dal
caller Geo; non esiste più una classe pubblica `Modules\Tenant\Services\TenantService` da risolvere.

## Stato verificabile

- `app/Services/` non contiene più file PHP dopo la migrazione.
- Le undici operazioni della vecchia facciata hanno un'Action esistente e testata.
- La catena `ConfigResolverRegistry` non è stata spostata: era codice morto e la sua semantica avrebbe perso
  connessioni database e fallback quando collegata al percorso reale.

Dettaglio, prove e probe prima/dopo: [stories/2026-10-08-services-to-actions-tenant.story.md](../stories/2026-10-08-services-to-actions-tenant.story.md).
