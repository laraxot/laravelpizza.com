---
issues: []
discussions: []
title: "corpi metodo duplicati — Tenant"
type: analysis
module: Tenant
tags: [dry, duplication, census, refactoring, tenant]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Tenant identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — Tenant

> **11** gruppi con corpo identico coinvolgono Tenant (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Tenant)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 2 | 40 |
| `B_business_duplicate` | 2 | 6 |
| `C_cross_name` | 1 | 12 |
| `M_database_layer` | 2 | 8 |
| `S_trivial_stub` | 4 | 19635 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `getRows` — 2 classi · 3 righe · ~3 righe duplicate

- `Tenant` · `Domain::getRows` · `Modules/Tenant/app/Models/Domain.php:41`
- `Tenant` · `TenantDomain::getRows` · `Modules/Tenant/app/Models/TenantDomain.php:62`

#### `tenant` — 2 classi · 3 righe · ~3 righe duplicate

- `Tenant` · `TenantSetting::tenant` · `Modules/Tenant/app/Models/TenantSetting.php:48`
- `Tenant` · `TenantSubscription::tenant` · `Modules/Tenant/app/Models/TenantSubscription.php:70`

### C — Corpo identico, nomi diversi (copy-paste con rename)

#### `execute` / `onlyStringKeys` — 2 classi · 12 righe · ~12 righe duplicate

- `Tenant` · `FilterConfigStringKeysAction::execute` · `Modules/Tenant/app/Actions/Config/FilterConfigStringKeysAction.php:17`
- `Tenant` · `ConfigStringKeyFilter::onlyStringKeys` · `Modules/Tenant/app/Services/Config/ConfigStringKeyFilter.php:13`

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getFormSchema` — 2 classi · 26 righe · ~26 righe duplicate

- `Tenant` · `DomainResource::getFormSchema` · `Modules/Tenant/app/Filament/Resources/DomainResource.php:21`
- `Tenant` · `DomainForm::getFormSchema` · `Modules/Tenant/app/Filament/Resources/DomainResource/Schemas/DomainForm.php:16`

#### `casts` — 2 classi · 14 righe · ~14 righe duplicate

- `Tenant` · `BaseModel::casts` · `Modules/Tenant/app/Models/BaseModel.php:21`
- `Xot` · `XotBaseModel::casts` · `Modules/Xot/app/Models/XotBaseModel.php:50`

### M — Layer database (migrations/factories/seeders)

#### `active` — 2 classi · 5 righe · ~5 righe duplicate

- `Tenant` · `DomainFactory::active` · `Modules/Tenant/database/Factories/DomainFactory.php:52`
- `Tenant` · `TenantFactory::active` · `Modules/Tenant/database/Factories/TenantFactory.php:47`
- `Tenant` · `DomainFactory::active` · `Modules/Tenant/database/factories/DomainFactory.php:52`
- `Tenant` · `TenantFactory::active` · `Modules/Tenant/database/factories/TenantFactory.php:51`

#### `run` — 2 classi · 3 righe · ~3 righe duplicate

- `Tenant` · `TenantSeeder::run` · `Modules/Tenant/database/Seeders/TenantSeeder.php:12`
- `Tenant` · `TenantSeeder::run` · `Modules/Tenant/database/seeders/TenantSeeder.php:12`
- `User` · `TenantSeeder::run` · `Modules/User/database/seeders/TenantSeeder.php:12`

### S — Stub banali (≤30 char) — rumore, non debito

4 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
