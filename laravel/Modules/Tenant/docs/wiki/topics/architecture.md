---
title: "Topic architecture"
type: digest
status: active
qmd: "digest ceiling 100 architecture"
---

# Topic architecture

Sintesi automatica di 3 documenti (chiave `architecture`).

## Tenant Module Architecture

_Fonte: `architecture.md`_

# Tenant Module Architecture

## Core Principles

### 1. Complete Data Isolation
- **Database-level**: Each tenant routes through its own database connection
- **Schema-level**: Optional schema separation within same database
- **Query-level**: Automatic scoping via tenant context (middleware, resolver)

### 2. Multi-Domain Routing
- Single tenant → Multiple domains/subdomains
- Domain routing via Tenant middleware
- Automatic tenant resolution from request

### 3. Configuration Hierarchy
- Global defaults in `config/config.php`
- Per-tenant overrides in `TenantSetting` model
- Runtime resolution via `ConfigurationResolver`

---

## Directory Structure

```
Tenant/
├── app/
│   ├── Models/                   # 15+ core models
│   │   ├── Tenant.php            # Root multi-tenant entity
│   │   ├── Domain.php            # Domain/subdomain routing

## Tenant — Architettura

_Fonte: `bmad/architecture.md`_

# Tenant — Architettura

## Scopo

## Milestones Domani
1. Verificare conformità con XotBase
2. Aggiornare `docs/bmad/stories/continuazione-domani.md` se chiuso
3. Indicare stato concluso in `docs/sprint-status.yaml`
Scopo e perché: [purpose.md](./purpose.md). Dettaglio risoluzione: [architecture/tenant-config-resolution.md](./architecture/tenant-config-resolution.md), confini: [architecture/module-boundary.md](./architecture/module-boundary.md). Finding: [audits/tenant-audit.md](./audits/tenant-audit.md).
=======
Multi-tenant: più enti da una sola installazione. Scopo e perché: [purpose.md](./purpose.md). Dettaglio risoluzione: [architecture/tenant-config-resolution.md](./architecture/tenant-config-resolution.md), confini: [architecture/module-boundary.md](./architecture/module-boundary.md). Finding: [audits/tenant-audit.md](./audits/tenant-audit.md).

## Flusso (verificato sul codice, 2026-11-16)

1. `GetTenantNameAction` ricava il nome ente dall'host (slug per parte; fallback default).
2. `GetTenantConfigPathAction` / `GetTenantFilePathAction` mappano nome → `config/<tenant>/…` (guardia anti-traversal).
3. `TenantServiceProvider::boot()`: `mergeConfigs()` → `registerDB()` (config `database` del tenant, alias delle connessioni di modulo sulla default, riconnessione tranne in test) → `registerMorphMap()` (solo chiavi stringa, classi esistenti).
4. I model Sushi (`SushiToJson`, `SushiToCsv`, `SushiToPhpArray`) leggono la config del tenant come tabella.

## Componenti

| Area 

## Tenant Module Architecture

_Fonte: `wiki/architecture.md`_

# Tenant Module Architecture

The **Tenant** module is the foundational layer for multi-tenancy in PTVX. It manages data isolation, distributed configuration, and automatic tenant identification.

## 1. Core Goal
The primary objective is to provide **Connection-Based Isolation**. This means each tenant's data is stored in a separate database or schema, and the application switches connections dynamically based on the request.

## 2. The Multi-Tenancy Flow

```text
Request → Domain Analysis → Tenant Identification → Connection Setup → Business Logic
```

1. **Identification**: The system identifies the tenant from the URL (subdomain or custom domain).
2. **Setup**: The `TenantServiceProvider` configures the database connection for the identified tenant.
3. **Execution**: Business modules (like User or Incentivi) execute their logic without being aware of multi-tenancy, as the database layer handles the isolation automatically.

## 3. Key Components

- **[[Tenant Identification]]**: Strategies for resolving the tenant from the environment.
- **[[Configuration Distribution]]**: Merging global and tenant-specific settings.
- **[[Sushi Models]]**: Handling static configuration data (like domains) without database overhead.

## 4. Sacred Rule: Connection Isolation
All models in business modules MUST extend their module's `BaseModel`, which in turn ensures the correct `tenant` connection is used. This prevents cross-tenant data leaks at the architectural level.

---
**Related Pages:
