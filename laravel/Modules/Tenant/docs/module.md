---
issues: []
discussions: []
title: "Tenant Module: Doctrine"
type: doctrine
tags: [tenant, multi-tenancy, module-doctrine]
created: 2026-09-05
updated: 2026-09-05
qmd: "Tenant module doctrine BMAD analysis purpose religion philosophy policy why zen gap enhancements split merge"
related:
  - "../../Xot/docs/module.md"
  - "../../Platform/docs/module.md"
status: draft
---

# Tenant Module: Doctrine

## Scope (Scopo)

Tenant gestisce l'isolamento multi-tenant del monorepo. Ogni tenant ha il proprio database (database isolation), configurazione JSON in `database/content/tenants/`, e feature flags propri. Il middleware tenant è applicato a ogni route che richiede contesto tenant.

## Religion (Religione)

**"Un tenant, un database, una configurazione, invisibile agli altri."** La convinzione non negoziabile è che i dati di un tenant NON devono mai essere accessibili da un altro tenant, nemmeno per errore. L'isolamento è a livello di database, non di `tenant_id` column: quest'ultimo è considerato un anti-pattern per rischio di data leak.

## Philosophy (Filosofia)

- **Database isolation**: ogni tenant ha il proprio database, non una colonna `tenant_id`
- **JSON config in version control**: `database/content/tenants/` con Sushi per dati statici
- **Tenant middleware on every route**: il contesto tenant è sempre presente, mai opzionale
- **Mai hardcoded tenant reference**: tutto passa per il tenant corrente

## Policy (Politica)

- Nessuna tabella condivisa tra tenant (tranne quelle esplicitamente globali)
- Configurazione tenant in JSON, mai in database (Sushi per seed)
- Migrazioni applicate a tutti i tenant, rollback coordinato
- Feature flags per tenant: un tenant può avere feature disabilitate che altri hanno abilitate

## Why (Perché)

Tenant esiste perché il modello multi-tenant richiede isolamento a livello di database per sicurezza e compliance. Usare `tenant_id` columns invece di database isolation espone a data leak catastrofici. Tenant è la garanzia che un cliente non vede mai i dati di un altro cliente.

## Zen

*"Un database, una configurazione, una verità. L'isolamento non è opzione, è legge."*

## Gap

- ARCHITECTURE.md mancante nella root del modulo
- Azioni per il lifecycle del tenant (create, update, delete, migrate, rollback) limitate
- Test suite multi-tenant incompleta
- Nessuno strumento di audit per isolamento tenant

## Add

- Azioni per lifecycle tenant: `CreateTenantAction`, `UpdateTenantConfigAction`, `DeleteTenantAction`, `MigrateTenantAction`, `RollbackTenantAction`
- Test suite multi-tenant con verifica di isolamento
- Tenant isolation audit tool: verifica che nessuna query泄漏 dati di altri tenant
- Dashboard Filament per gestione tenant (crea, configura, migra, elimina)

## Split/Merge

**Mantenere come-is, ma considerare estrazione Config/.** La configurazione tenant (JSON files, Sushi) potrebbe essere estratta in un sotto-modulo `TenantConfig` se cresce, ma l'isolamento database è troppo critico per essere separato dal resto.

## Future Enhancements

1. **Tenant-aware queue**: job che eseguono nel contesto del tenant corretto
2. **Tenant snapshot/restore**: backup e ripristino istantaneo di un tenant
3. **Tenant migration runner**: migrazioni automatiche su nuovi tenant al momento della creazione
4. **Tenant resource quotas**: limiti di storage, DB size, CPU per tenant
5. **Tenant analytics**: dashboard con metriche per tenant (attività, errori, performance)
6. **Tenant template**: configurazioni predefinite per diversi tipi di cliente
