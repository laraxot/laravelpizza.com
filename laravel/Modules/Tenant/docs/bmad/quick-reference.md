---
title: "Tenant — Quick Reference"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - quick-reference
created: 2026-09-28
updated: 2026-09-28
qmd: "tenant quick reference comandi path classi"
related:
  - README.md
  - architecture.md
  - setup-guide.md
---

# Tenant — Quick Reference

> **SUMMARY** — Riferimento rapido del modulo `Tenant`: dove sta cosa, quali classi usare,
> quali test guardare. Paths relativi a `laravel/Modules/Tenant`.

## Punti di ingresso

| Cosa | Path |
|------|------|
| Facade di dominio | `app/Services/TenantService.php` |
| Bootstrap | `app/Providers/TenantServiceProvider.php` |
| Config statica del modulo | `config/config.php` |
| Config DB | `config/database.php` |
| Moduli abilitati | `config/modules.php` |

## Azioni per uso frequente

| Azione | Path |
|--------|------|
| Risolvere un valore config | `app/Actions/Config/ResolveTenantConfigValueAction.php` |
| Elenco chiavi config | `app/Actions/Config/GetTenantConfigNamesAction.php` |
| Config come array | `app/Actions/Config/GetTenantConfigArrayAction.php` |
| Salvare config | `app/Actions/Config/SaveTenantConfigAction.php` |
| Classi modello tenant-aware | `app/Actions/Models/ResolveTenantModelClassAction.php` |
| Istanza modello tenant-aware | `app/Actions/Models/ResolveTenantModelInstanceAction.php` |
| Domini come array | `app/Actions/Domains/GetDomainsArrayAction.php` |
| Moduli del tenant | `app/Actions/Modules/GetTenantModulesAction.php` |
| Traduzione tenant | `app/Actions/Translations/TranslateTenantKeyAction.php` |
| Path markdown localizzato | `app/Actions/Markdown/GetLocalizedMarkdownPathAction.php` |

## Modelli

| Modello | Path |
|---------|------|
| `Tenant` | `app/Models/Tenant.php` |
| `Domain` | `app/Models/Domain.php` |
| `DatabaseConfig` | `app/Models/DatabaseConfig.php` |
| `TenantSetting` | `app/Models/TenantSetting.php` |
| `TenantSubscription` | `app/Models/TenantSubscription.php` |
| `TenantDomain` | `app/Models/TenantDomain.php` |
| Base Sushi | `app/Models/BaseModelJsons.php` |

## Trait Sushi (dataset statici)

| Trait | Metodi chiave |
|-------|---------------|
| `app/Models/Traits/SushiToJson.php` | `getJsonFile()`, `getRows()`, `getSushiRows()`, `loadExistingData()`, `saveToJson()` |
| `app/Models/Traits/SushiToCsv.php` | conversione CSV |
| `app/Models/Traits/SushiToJsons.php` | varianti plurali |
| `app/Models/Traits/SushiToPhpArray.php` | array PHP |

Contratti: `app/Contracts/SushiToJsonContract.php`, `app/Contracts/SushiToJsonsContract.php`.

## Filament

| Risorsa | Path |
|---------|------|
| `DomainResource` | `app/Filament/Resources/DomainResource.php` |
| Pagine | `app/Filament/Resources/DomainResource/Pages/` (`CreateDomain.php`, `EditDomain.php`, `ListDomains.php`) |
| Schemas | `app/Filament/Resources/DomainResource/Schemas/DomainForm.php`, `DomainInfolist.php` |
| Tables | `app/Filament/Resources/DomainResource/Tables/DomainsTable.php` |
| Dashboard | `app/Filament/Pages/Dashboard.php` |

## Traduzioni

`lang/it/tenant.php` (navigazione), `lang/it/domain.php`, `lang/it/domains.php`,
`lang/it/domain_form.php`, `lang/it/domain_infolist.php`; `lang/en/` e `lang/de/` per tenant e domain.

## Test da leggere prima di toccare il codice

| Test | Path |
|------|------|
| Isolamento config | `tests/Feature/TenantConfigIsolationTest.php` |
| Logica business | `tests/Feature/TenantBusinessLogicTest.php` |
| Modelli | `tests/Unit/TenantModelsTest.php` |
| Dominio | `tests/Unit/DomainTest.php` |
| Azioni config | `tests/Unit/Actions/Config/` |
| Sushi JSON | `tests/Unit/Traits/SushiToJsonTest.php` |
| Integrazione Sushi | `tests/Integration/SushiToJsonIntegrationTest.php` |
| Prestazioni Sushi | `tests/Performance/SushiToJsonPerformanceTest.php` |
