---
title: "Tenant — risoluzione della configurazione (config resolver + morph map + DB)"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - config
  - morph-map
  - database
created: 2026-09-28
updated: 2026-09-28
qmd: "tenant config resolver morph map database isolation connection"
related:
  - ../architecture.md
  - module-boundary.md
  - ../quick-reference.md
---

# Tenant — risoluzione della configurazione

> **SUMMARY** — Il provider `TenantServiceProvider` è l'unico punto del modulo che decide
> connessione DB di default e morph map. Tutte le decisioni passano dai resolver in
> `app/Services/Config/Resolvers/`; nessuna decisione è hardcoded nel provider.

## Flusso di boot

1. `TenantServiceProvider::registerDB()` (riga 61) risolve la connessione di default.
2. `loadTenantDatabaseConfig()` (riga 117) legge la chiave `database` con
   `ResolveTenantConfigValueAction` e la filtra con `FilterConfigStringKeysAction`.
3. `mergeModuleConnections()` (riga 138) produce la configurazione di connessione finale.
4. `registerMorphMap()` (riga 51) legge la chiave `morph_map`, la filtra e chiama
   `Relation::morphMap(self::buildMorphMap(...))`.
5. `mergeConfigs()` (riga 83) itera `GetTenantConfigNamesAction` e carica ogni config con
   `ResolveTenantConfigValueAction`.

## Registry dei resolver

`app/Services/Config/ConfigResolverRegistry.php`:

| Simbolo | Ruolo |
|---------|-------|
| `register(ConfigResolverInterface $resolver): self` | registra un resolver |
| `findResolver(string $key): ConfigResolverInterface` | trova il resolver per chiave |

Implementazioni in `app/Services/Config/Resolvers/`:

| Resolver | Path |
|----------|------|
| `DatabaseConfigResolver` | `app/Services/Config/Resolvers/DatabaseConfigResolver.php` |
| `MorphMapConfigResolver` | `app/Services/Config/Resolvers/MorphMapConfigResolver.php` |
| `StandardConfigResolver` | `app/Services/Config/Resolvers/StandardConfigResolver.php` |

Contratto: `app/Services/Config/Contracts/ConfigResolverInterface.php`.

## Vincoli espliciti nel codice

- `buildMorphMap()` (riga 179) scarta gli alias non-stringa e le classi che non esistono
  (`@class_exists`) invece di far fallire il boot.
- L'alias morph `user` viene forzato sulla classe utente canonica: nel provider è
  documentato che un alias errato rende invisibili i role.

## Azioni di supporto

| Azione | Path |
|--------|------|
| `ResolveTenantConfigValueAction` | `app/Actions/Config/ResolveTenantConfigValueAction.php` |
| `GetTenantConfigArrayAction` | `app/Actions/Config/GetTenantConfigArrayAction.php` |
| `GetTenantConfigNamesAction` | `app/Actions/Config/GetTenantConfigNamesAction.php` |
| `GetTenantConfigPathAction` | `app/Actions/Config/GetTenantConfigPathAction.php` |
| `GetTenantFilePathAction` | `app/Actions/Config/GetTenantFilePathAction.php` |
| `FilterConfigStringKeysAction` | `app/Actions/Config/FilterConfigStringKeysAction.php` |
| `MergeRecursiveStringKeyConfigAction` | `app/Actions/Config/MergeRecursiveStringKeyConfigAction.php` |
| `SaveTenantConfigAction` | `app/Actions/Config/SaveTenantConfigAction.php` |

## Copertura test esistente

- `tests/Unit/Actions/Config/ResolveTenantConfigValueActionTest.php`
- `tests/Unit/Actions/Config/GetTenantConfigArrayActionTest.php`
- `tests/Unit/Actions/Config/GetTenantConfigNamesActionTest.php`
- `tests/Unit/Actions/Config/GetTenantConfigPathActionTest.php`
- `tests/Unit/Actions/Config/GetTenantFilePathActionTest.php`
- `tests/Unit/Actions/Config/FilterConfigStringKeysActionTest.php`
- `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php`
- `tests/Feature/TenantConfigIsolationTest.php`
