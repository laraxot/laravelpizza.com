---
title: "censimento omonimi metodi — modulo Tenant"
type: analysis
module: Tenant
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Tenant

> **41** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Tenant)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 17 |
| `E_scheda_stack` | 1 |
| `F_trait_name_collision` | 1 |
| `G_module_local` | 5 |
| `H_cross_module_homonym` | 17 |

## Dettaglio

### `A_filament_framework` (17 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Tenant` · `TenantBasePolicy` · `Modules/Tenant/app/Models/Policies/TenantBasePolicy.php`

### `F_trait_name_collision`

#### `getSushiRows` — 4 classi

- `Tenant` · `trait:SushiToCsv` · `Modules/Tenant/app/Models/Traits/SushiToCsv.php`
- `Tenant` · `trait:SushiToJson` · `Modules/Tenant/app/Models/Traits/SushiToJson.php`
- `Tenant` · `trait:SushiToJsons` · `Modules/Tenant/app/Models/Traits/SushiToJsons.php`
- `Tenant` · `trait:SushiToPhpArray` · `Modules/Tenant/app/Models/Traits/SushiToPhpArray.php`

### `G_module_local`

#### `canResolve` — 3 classi

- `Tenant` · `DatabaseConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/DatabaseConfigResolver.php`
- `Tenant` · `MorphMapConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `Tenant` · `StandardConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

#### `getJsonFile` — 3 classi

- `Tenant` · `TestSushiModel` · `Modules/Tenant/app/Models/TestSushiModel.php`
- `Tenant` · `trait:SushiToJson` · `Modules/Tenant/app/Models/Traits/SushiToJson.php`
- `Tenant` · `trait:SushiToJsons` · `Modules/Tenant/app/Models/Traits/SushiToJsons.php`

#### `resolve` — 3 classi

- `Tenant` · `DatabaseConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/DatabaseConfigResolver.php`
- `Tenant` · `MorphMapConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `Tenant` · `StandardConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

#### `getOriginalConfig` — 2 classi

- `Tenant` · `MorphMapConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `Tenant` · `StandardConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

#### `getTenantConfig` — 2 classi

- `Tenant` · `MorphMapConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `Tenant` · `StandardConfigResolver` · `Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

### `H_cross_module_homonym`

#### `getRows` — 11 classi

- `Tenant` · `Domain` · `Modules/Tenant/app/Models/Domain.php`
- `Tenant` · `TenantDomain` · `Modules/Tenant/app/Models/TenantDomain.php`
- `Tenant` · `TestSushiModel` · `Modules/Tenant/app/Models/TestSushiModel.php`
- `Tenant` · `trait:SushiToJson` · `Modules/Tenant/app/Models/Traits/SushiToJson.php`

#### `active` — 6 classi

- `Tenant` · `DomainFactory` · `Modules/Tenant/database/factories/DomainFactory.php`
- `Tenant` · `TenantFactory` · `Modules/Tenant/database/factories/TenantFactory.php`
- `Tenant` · `TestSushiModelFactory` · `Modules/Tenant/database/factories/TestSushiModelFactory.php`

#### `inactive` — 4 classi

- `Tenant` · `TenantFactory` · `Modules/Tenant/database/factories/TenantFactory.php`
- `Tenant` · `TestSushiModelFactory` · `Modules/Tenant/database/factories/TestSushiModelFactory.php`

#### `trans` — 6 classi

- `Tenant` · `TenantService` · `Modules/Tenant/app/Services/TenantService.php`

#### `users` — 6 classi

- `Tenant` · `Tenant` · `Modules/Tenant/app/Models/Tenant.php`

#### `getConnectionName` — 5 classi

- `Tenant` · `trait:SushiToJsons` · `Modules/Tenant/app/Models/Traits/SushiToJsons.php`

#### `getConfig` — 4 classi

- `Tenant` · `TenantService` · `Modules/Tenant/app/Services/TenantService.php`

#### `isActive` — 4 classi

- `Tenant` · `Tenant` · `Modules/Tenant/app/Models/Tenant.php`

#### `panel` — 4 classi

- `Tenant` · `AdminPanelProvider` · `Modules/Tenant/app/Providers/Filament/AdminPanelProvider.php`

#### `pending` — 2 classi

- `Tenant` · `TestSushiModelFactory` · `Modules/Tenant/database/factories/TestSushiModelFactory.php`

#### `getName` — 3 classi

- `Tenant` · `TenantService` · `Modules/Tenant/app/Services/TenantService.php`

#### `tenant` — 3 classi

- `Tenant` · `TenantSetting` · `Modules/Tenant/app/Models/TenantSetting.php`
- `Tenant` · `TenantSubscription` · `Modules/Tenant/app/Models/TenantSubscription.php`

_… +5 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
