---
title: "Struttura dei metodi dei modelli Tenant"
type: architecture
module: Tenant
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [tenant, eloquent, model, traits, architecture]
qmd: "Tenant model mutators accessors users setting subscription relations traits"
related:
  - ../index.md
---

# Struttura dei metodi dei modelli Tenant

I metodi Eloquent estratti dalle classi rimangono pubblici e conservano nome,
firma, risoluzione della relazione e comportamento degli attributi.

| Trait | Modello e metodi |
|---|---|
| [TenantMutators](../../../app/Models/Traits/TenantMutators.php) | `Tenant`: `setNameAttribute`, `getNameAttribute`/`getName`, `getUrlAttribute`/`getUrl` |
| [TenantRelations](../../../app/Models/Traits/TenantRelations.php) | `Tenant`: `users` |
| [TenantSettingRelations](../../../app/Models/Traits/TenantSettingRelations.php) | `TenantSetting`: `tenant` |
| [TenantSubscriptionRelations](../../../app/Models/Traits/TenantSubscriptionRelations.php) | `TenantSubscription`: `tenant` |

La relazione `Tenant::users()` risolve ancora la classe utente con `XotData`; il
mutator del nome continua a generare lo slug solo quando non è già impostato.
