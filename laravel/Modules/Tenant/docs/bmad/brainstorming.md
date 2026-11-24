---
title: "Tenant — Brainstorming BMAD (indice e decisioni)"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - brainstorming
  - decisioni
created: 2026-09-28
updated: 2026-11-16
qmd: "tenant brainstorming decisioni aperte scartate tenants migration trusthosts"
related:
  - architecture.md
  - architecture/tenant-config-resolution.md
  - brainstorming/module-opportunities.md
  - epics/tenant-config-resolution.md
bmad: true
status: active
---

# Tenant — Brainstorming

> **SUMMARY** — Decisioni prese, questioni aperte e opzioni scartate del modulo `Tenant`,
<<<<<<< .merge_file_CTEWss
=======
<<<<<<< .merge_file_OHCtfh
>>>>>>> .merge_file_bDpRgB
> ancorate a file e simboli reali. Il brainstorming di dettaglio per area è negli shard.
> ancorate a file e simboli reali (riverificate il 2026-11-16: le voci su
> `ConfigResolverRegistry`, `StandardConfigResolver` e `TenantService` erano obsolete e
> sono state rimosse — `app/Services` non esiste, la logica è in Action).
<<<<<<< .merge_file_CTEWss
=======
=======
> ancorate a file e simboli reali (riverificate il 2026-11-16: le voci su
> `ConfigResolverRegistry`, `StandardConfigResolver` e `TenantService` erano obsolete e
> sono state rimosse — `app/Services` non esiste, la logica è in Action).
> Il brainstorming di dettaglio per area è negli shard.
>>>>>>> .merge_file_n0zUrL
>>>>>>> .merge_file_bDpRgB

## Shard

| Shard | Path |
|-------|------|
| Opportunita di modulo | [brainstorming/module-opportunities.md](brainstorming/module-opportunities.md) |

## Decisioni prese (verificate nel codice)

| Decisione | Dove e verificata |
|----------|-------------------|
| Solo chiavi stringa entrano in config/morph map | `app/Actions/Config/FilterConfigStringKeysAction.php`, usato in `TenantServiceProvider::loadTenantDatabaseConfig()` e `registerMorphMap()` |
| La config per-tenant si legge via Action | `app/Actions/Config/ResolveTenantConfigValueAction.php`, `GetTenantConfigArrayAction.php` |
| Alias morph che punta a classe inesistente vengono scartati, non fanno crash del boot | `TenantServiceProvider::buildMorphMap()` con `@class_exists` |
| La connessione DB non viene riconnessa in ambiente di test | `TenantServiceProvider::reconnectDatabaseUnlessTesting()` |
| Le connessioni di modulo sono alias della default (una transazione) | `TenantServiceProvider::aliasModuleConnectionsToDefault()` |

Registro completo: [decision-log.md](./decision-log.md).

## Questioni aperte

| Questione | Evidenza |
|-----------|----------|
| Chi crea la tabella `tenants`? | `app/Models/Tenant.php:68` (`extends BaseModel`) + `database/factories/TenantFactory.php`; `database/migrations/` ha solo `tenant_settings`, `tenant_subscriptions`, `database_configs`; nessuna `create('tenants')` nel repo (TEN-P2-08) |
| Host sconosciuto: fallire o ripiegare sul default? | `app/Actions/GetTenantNameAction.php:114-148`; `TrustHosts` non attivo (TEN-P1-01) |
| Cosa deve poter fare `tenant::admin` (delete/forceDelete inclusi)? | `app/Models/Policies/TenantBasePolicy.php:14-22` (TEN-P1-02) |
| `DatabaseConfig.password` va cifrata ora o quando nascerà la UI? | `app/Models/DatabaseConfig.php` (TEN-P1-03) |
| `Tenant::users()` risolve la classe utente a runtime | `app/Models/Tenant.php:100`; `patients()`/`appointments()` commentate (`:112`, `:120`) |
| `SushiToJson` e `SushiToJsons`: fondere? | TEN-P2-01 |

## Opzioni scartate

| Opzione | Motivo dello scarto (dal codice) |
|---------|----------------------------------|
| Riconnessione DB sempre attiva al boot | spegnerebbe l'isolamento nei test; il provider la salta sotto testing |
| Morph map dichiarata a mano in un array statico | il provider la compone dalla config e la valida classe per classe |
| `base_path()` per i file per-tenant | ignora il tenant: errore muto; si usa `GetTenantFilePathAction` |
