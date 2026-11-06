---
title: "Tenant: Brainstorming BMAD (indice e decisioni)"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - brainstorming
  - decisioni
created: 2026-09-28
updated: 2026-10-07
qmd: "tenant brainstorming decisioni aperte scartate"
related:
  - architecture.md
  - architecture/tenant-config-resolution.md
  - brainstorming/module-opportunities.md
  - epics/tenant-config-resolution.md
bmad: true
status: active
---

# Tenant: Brainstorming

> **SUMMARY**: Decisioni prese, questioni aperte e opzioni scartate del modulo `Tenant`,
> ancorate a file e simboli reali. Il brainstorming di dettaglio per area è negli shard.

## Shard

| Shard | Path |
|-------|------|
| Opportunita di modulo | [brainstorming/module-opportunities.md](brainstorming/module-opportunities.md) |

## Decisioni prese (verificate nel codice)

| Decisione | Dove e verificata |
|----------|-------------------|
| La risoluzione della config passa da un registry, non da `config()` sparse | `app/Services/Config/ConfigResolverRegistry.php` con `register()` / `findResolver()` |
| Solo chiavi stringa entrano in config/morph map | `app/Actions/Config/FilterConfigStringKeysAction.php`, usato in `TenantServiceProvider::loadTenantDatabaseConfig()` e `registerMorphMap()` |
| L'alias morph `user` non è negoziabile: punta sempre alla classe utente canonica | commento in `app/Providers/TenantServiceProvider.php` (blocco `buildMorphMap`) |
| Alias morph che punta a classe inesistente vengono scartati, non fanno crash del boot | `TenantServiceProvider::buildMorphMap()` con `@class_exists` |
| La connessione DB non viene riconnessa in ambiente di test | `TenantServiceProvider::reconnectDatabaseUnlessTesting()` |
| Un resolver senza match cade sul resolver standard | presenza di `StandardConfigResolver` in `app/Services/Config/Resolvers/` |

## Questioni aperte

| Questione | Evidenza |
|-----------|----------|
| Chi crea la tabella `tenants`? | `app/Models/Tenant.php` + `database/factories/TenantFactory.php` esistono, ma `database/migrations/` contiene solo `tenant_settings`, `tenant_subscriptions`, `database_configs` |
| `TenantService` ha ancora `public function execute(): void {}` vuoto | `app/Services/TenantService.php` riga 163 |
| `Tenant::users()` risolve la classe utente a runtime invece di un import fisico | `app/Models/Tenant.php` riga 80 con `class-string<Model&UserContract>` |
| Relazioni `patients()` / `appointments()` commentate nel modello Tenant | `app/Models/Tenant.php` righe 95-105, con moduli non disponibili |

## Opzioni scartate

| Opzione | Motivo dello scarto (dal codice) |
|---------|----------------------------------|
| Config per tenant hardcoded in `config/*.php` del modulo | il provider già la risolve a runtime via `ResolveTenantConfigValueAction` su chiavi `database` e `morph_map` |
| Riconnessione DB sempre attiva al boot | spegnerebbe l'isolamento nei test; il provider la salta sotto testing |
| Morph map dichiarata a mano in un array statico | il provider la compone dalla config e la valida classe per classe |
