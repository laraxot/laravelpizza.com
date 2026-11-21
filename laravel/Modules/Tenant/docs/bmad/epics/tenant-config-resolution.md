---
title: "Epic 5.249 — Tenant: risoluzione config, morph map e isolamento DB verificabili"
type: epic
module: Tenant
status: active
tags:
  - bmad
  - epic
  - tenant
  - config
created: 2026-09-28
updated: 2026-09-28
qmd: "tenant epic config resolution morph map database isolation"
related:
  - ../architecture/tenant-config-resolution.md
  - ../brainstorming.md
  - ../quick-reference.md
---

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
|---|----|----------|
| 1 | Ogni chiave config letta dal provider e' tracciata a un'azione in `app/Actions/Config/` | `grep` tra `TenantServiceProvider.php` e le azioni |
| 2 | `ConfigResolverRegistry::findResolver()` ha fallback esplicito | `app/Services/Config/Resolvers/StandardConfigResolver.php` + test in `tests/Unit/Actions/Config/` |
| 3 | L'alias morph `user` e' coperto da un test che fallisce se la classe non e' `Model` | nessun test esistente dedicato: da creare in `tests/Unit/` |
| 4 | `TenantService::execute()` vuoto e' coperto da test o rimosso | `app/Services/TenantService.php` riga 163 |
| 5 | La provenienza della tabella `tenants` e' documentata in questo file o in una story | `database/migrations/` del modulo |
| 6 | `getRows()` di `Domain` resta delegato a `GetDomainsArrayAction` | `app/Models/Domain.php` riga 34 |

## Rischio

Modificare `TenantServiceProvider` in un ambiente con scritture concorrenti di altri agenti
richiede lock; il bootstrap del progetto non e' eseguibile in questa campagna, quindi ogni
cambio di codice va rimandato a una story dedicata con gate Pest.
