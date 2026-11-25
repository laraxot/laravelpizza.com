---
title: "Topic tenant-config"
type: digest
status: active
qmd: "digest ceiling 100 tenant-config"
---

# Topic tenant-config

Sintesi automatica di 4 documenti (chiave `tenant-config`).

## Tenant — risoluzione della configurazione

_Fonte: `bmad/architecture/tenant-config-resolution.md`_

# Tenant — risoluzione della configurazione

> **SUMMARY** — Il provider `TenantServiceProvider` è l'unico punto del modulo che decide
> connessione DB di default e morph map. Tutte le decisioni passano dai resolver in
> `app/Services/Config/Resolvers/`; nessuna decisione è hardcoded nel provider.

## Flusso di boot

1. `TenantServiceProvider::registerDB()` (riga 61) risolve la connessione di default.
2. `loadTenantDatabaseConfig()` (riga 117) legge la chiave `database` con
<<<<<<< HEAD
   `ResolveTenantConfigValueAction` e la filtra con `FilterConfigStringKeysAction`.
=======
   `GetTenantConfigValueAction` e la filtra con `FilterConfigStringKeysAction`.
>>>>>>> laraxot/dev
3. `mergeModuleConnections()` (riga 138) produce la configurazione di connessione finale.
4. `registerMorphMap()` (riga 51) legge la chiave `morph_map`, la filtra e chiama
   `Relation::morphMap(self::buildMorphMap(...))`.
5. `mergeConfigs()` (riga 83) itera `GetTenantConfigNamesAction` e carica ogni config con
<<<<<<< HEAD
   `ResolveTenantConfigValueAction`.
=======
   `GetTenantConfigValueAction`.
>>>>>>> laraxot/dev

## Registry dei resolver

`app/Services/Config/ConfigResolverRegistry.php`:

| Simbolo | Ruolo |
|---------|-------|
| `register(ConfigResolverInterface $resolver): self` | registra un resolver |
| `findResolver(string $key): ConfigResolverInterface` | trova il resolver per chiave |

Implementazioni in `app/Services/Config/Resolvers/`:

| Resolver | Path |

## Epic 5.249 — Tenant: risoluzione config, morph map e isolamento DB verificabili

_Fonte: `bmad/epics/tenant-config-resolution.md`_

# Epic 5.249 — Tenant: risoluzione config, morph map e isolamento DB verificabili

> **SUMMARY** — Epic di completamento del modulo `Tenant`: rendere la catena
> config → resolver → connessione DB → morph map interamente tracciata a file e simboli,
> e chiudere il buco sulla provenienza della tabella `tenants`.

## Perche ora

Il provider `app/Providers/TenantServiceProvider.php` concentra le decisioni piu delicate del
modulo (connessione di default, morph map, merge config) ma non esiste un documento che le
rappresenti; inoltre `app/Models/Tenant.php` ha factory e seeder (`database/factories/TenantFactory.php`,
`database/seeders/TenantSeeder.php`) senza alcuna migrazione della tabella `tenants` nel modulo.

## Scope

In scope:
- documentazione della catena di risoluzione config e morph map;
- test mirati sulle azioni `app/Actions/Config/`;
- chiarimento della provenienza della tabella `tenants`;
- rimozione/copertura del metodo vuoto `TenantService::execute()` (`app/Services/TenantService.php`).

Out of scope:
- modifiche a `app/Providers/` di altri moduli;
- introduzione di un nuovo meccanismo di isolamento (RLS, schema per tenant);
- package Filament e stringhe hardcoded nelle label.

## Acceptance criteria

| # | AC | Verifica |

## Tenant Config Path Philosophy - THE FURIOUS DEBATE

_Fonte: `tenant-config-path-philosophy-debate.md`_

# Tenant Config Path Philosophy - THE FURIOUS DEBATE

**Status**: 🔥 FURIOUS INTERNAL DEBATE
**Issue**: Quale è la struttura path CORRETTA per i config tenant?
**Filosofia**: DRY + KISS + SOLID + Domain-Driven Design

---

## 🔴 IL PROBLEMA CRITICO

Esistono DUE strutture directory per config tenant:

1. **Pattern A**: `config/<nome progetto>.local/` (tenant.environment)
2. **Pattern B**: `config/local/<nome progetto>/` (environment/tenant)

**Quale è CORRETTO e PERCHÉ?**

---

## ⚔️ IL DIBATTITO FURIOSO

### 👹 VOCE A: "Tenant.Environment Pattern"

**Argomento**: `config/<nome progetto>.local/` è più leggibile

**Reasoning**:
> "Il tenant è l'entità PRINCIPALE! <nome progetto>.local è il dominio completo.
> Mettere il tenant prima significa: questo è IL SITO <nome progetto>.local,
> non 'local con sotto <nome progetto>'. È più intuitivo!"

## Ripristino config tenant — incidente 2026-07-01

_Fonte: `wiki/concepts/tenant-config-restoration-incident.md`_

# Ripristino config tenant — incidente 2026-07-01

## Cosa è successo

Commit `8a3fdd530` ha rimosso gli alberi config per dominio in `laravel/config/`:
`com/geekpiu`, `eu/progetto corrente`, `net/futurely`, `localhost`, file in `local/forecast/`.

Classificazione errata: «obsolete» durante cleanup ponytail.

## Perché sono necessari

`GetTenantNameAction` risolve il path `config/{tenant}/` da hostname invertito.
`GetTenantFilePathAction` e `TenantService::config()` leggono file da lì.

Senza questi file il tenant non ha override DB, moduli, metatag, contenuti Orbit.

## Ripristino

Commit `6b83dfdb2` — contenuto identico a pre-delete (`git diff 8a3fdd530^..HEAD` su `laravel/config/` = 0 righe di contenuto).

## Prevenzione

```bash
bash bashscripts/tools/guard-tenant-config-delete.sh
bash bashscripts/tools/audit-tenant-config-inventory.sh
```

<<<<<<< HEAD
Hub progetto: [tenant-config-directory-sacred.md](../../../../../../docs/wiki/concepts/tenant-config-directory-sacred.md)
=======
Hub progetto: [modules-structure-rules.md#tenant-config-directory-sacred](../../../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#tenant-config-directory-sacred)
>>>>>>> laraxot/dev
