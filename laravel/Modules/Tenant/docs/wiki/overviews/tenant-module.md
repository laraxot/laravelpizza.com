---
type: overview
module: Tenant
sources:
  - ../../../module.md
  - ../../../philosophy.md
  - ../../../configuration.md
  - ../../../structure.md
confidence: high
updated: 2026-04-15
---

# Tenant Module — Overview

> **Ruolo**: Multi-tenancy per monolite Laraxot — isolamento completo dati, DB-per-tenant, domain routing, configurazione per-tenant.

## Responsabilità del Modulo

Il modulo Tenant fornisce il layer di **multi-tenancy**:

- Isolamento dati tra tenant (database-per-tenant pattern)
- Tenant identification: subdomain, domain, header, API key
- Dynamic database connection switching per HTTP request
- Configurazione e feature toggle per-tenant
- Resource management e usage tracking per-tenant
- Tenant lifecycle: bootstrap, migration, migration sync

## Filosofia Core

**Sovranità digitale distribuita**:
1. **Isolamento Sovrano** — ogni tenant è entità autonoma con piena sovranità sui propri dati
2. **Segregazione Assoluta** — dati di un tenant non contaminano MAI quelli di un altro
3. **Blast Radius** — ogni errore impatta SOLO il tenant coinvolto
4. **Privacy by Architecture** — isolamento strutturale, non procedurale

**Governance multi-livello**: Super Admin → Tenant Owner → Tenant Users → Sistema (enforcement automatico)

## Architettura

```
HTTP Request → TenantResolver → TenantManager → Database Switch → Application
     ↓
Tenant Detection → Configuration Load → Bootstrap → Response
```

### Layer Stack

| Layer | Componenti |
|-------|-----------|
| Identification | TenantResolver, TenantMiddleware, TenantRouteManager, ApiTenantDetector |
| Management | TenantManager, TenantRepository, TenantConfigService, TenantLifecycleService |
| Database | TenantDatabaseManager, ConnectionManager, MigrationManager, SchemaIsolationService |
| Resource | ResourceManager, UsageTracker, LimitEnforcer, BillingIntegration |

## Modelli Core

| Modello | Scopo | Note |
|---------|-------|------|
| `Tenant` | Entità tenant principale | Con domain, config, stato |
| `Domain` | Dominio/subdomain del tenant | Routing e identification |
| `XraData` | Configurazione XRA per tenant | Sushi → JSON models |

**3 tabelle core**: Tenant, Domain, TenantUser (relazione) — minimalismo zen.

## Tenant Identification

```php
// Subdomain-based detection (priorità 1)
// tenant1.app.com → Tenant::where('subdomain', 'tenant1')

// Domain-based (priorità 2)
// tenant.com → Tenant::where('domain', 'tenant.com')

// API key (priorità 3)
// Header: X-Tenant-Key: <key>
```

## Database Isolation

```php
// Connection switching automatico via Middleware
// Ogni tenant ha la propria connessione DB configurata dinamicamente
// config/database.php viene modificato runtime per il tenant corrente

// In Xot: tutti i model usano connection scoping automatico
// via XotData → getTenantConnection()
```

## Sushi → JSON Models

Il modulo Tenant usa il trait `SushiToJson` per modelli configurazione:
- Invece di DB, i dati risiedono in file JSON (`resources/json/`)
- Modificabile senza migrazioni (es. elenco moduli abilitati, morph map)
- PHPStan-safe: no suppress, type-safe JSON reading

## Utilizzo Cross-Module

Tutti gli altri moduli del progetto sono automaticamente multi-tenant via Xot:
- `XotData::getTenantId()` — recupero tenant corrente
- Model scoping automatico via `Updater` trait (created_by, updated_by)
- Connection switching trasparente per query Eloquent

## Cross-References

- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotData, XotBaseModel, connection scoping
- [[../../../../../../laravel/Modules/User/docs/wiki/overviews/user-module|User Module]] — utenti per tenant

## Raw Sources Prioritari

- `module.md` — funzionalità implementate, architettura stack
- `philosophy.md` — sovranità, isolamento, etica, zen
- `configuration.md` — configurazione base, dipendenze
- `traits/sushi-to-json.md` — pattern JSON models
- `it/config/` — file configurazione per tenant
