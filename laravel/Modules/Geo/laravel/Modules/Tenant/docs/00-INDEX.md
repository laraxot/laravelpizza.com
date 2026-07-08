# Tenant Module — Documentation Index

**Path**: `laravel/Modules/Tenant/docs/`  
**Updated**: 2026-07-01  
**Status**: Multi-tenant core module

---

## 🎯 Quick Start

**Multi-tenancy 101**: [TenantIdentification.md](./wiki/TenantIdentification.md) — How tenants are identified and isolated  
**Architecture**: [Architecture.md](./wiki/Architecture.md) — System design and data flow  
**Configuration**: See **Multi-Tenant Config** section below ⬇️

---

## 📋 Hub Canonici (Core Files)

### Wiki (Sacred — Do Not Delete)
- **[wiki/index.md](./wiki/index.md)** — Operating manual for LLM agents
- **[wiki/Architecture.md](./wiki/Architecture.md)** — Multi-tenant system design
- **[wiki/TenantIdentification.md](./wiki/TenantIdentification.md)** — How tenants are identified
- **[wiki/ConfigurationDistribution.md](./wiki/ConfigurationDistribution.md)** — Config per tenant
- **[wiki/SCHEMA.md](./wiki/SCHEMA.md)** — Database schema reference

### Roadmap
- **[roadmap/00-INDEX.md](./roadmap/00-INDEX.md)** — Q4 2025 roadmap and phases
- **[roadmap/vision.md](./roadmap/vision.md)** — Long-term vision
- **[roadmap/tenant-isolation.md](./roadmap/tenant-isolation.md)** — Data isolation strategy

### Product & Strategy
- **[PRD.md](./PRD.md)** — Product requirements document
- **[philosophy.md](./philosophy.md)** — Core principles
- **[README.md](./README.md)** — Module overview and local knowledge map

---

## 🏗️ Multi-Tenant Configuration

### How Tenant Config Works

This project uses **environment-specific tenant configuration**:

```
laravel/config/
├── localhost/              # Local dev (all tenants, single DB)
├── com/geekpiu/            # GeeKPIU tenant (production)
├── eu/fixcity/             # FixCity EU tenant
└── net/futurely/           # Futurely tenant
```

**Each tenant context includes**:
- `app.php` — Locale, timezone, app name per tenant
- `database.php` — Separate DB connection per tenant
- `services.php` — API credentials per tenant
- `modules.php` — Active modules per tenant
- `modules_statuses.json` — Module status overrides
- `morph_map.php` — Model registry (CRITICAL — never delete)

### Why This Architecture

1. **Data Isolation** — Each tenant has own database or schema
2. **Environment Separation** — Different APIs/credentials per deployment
3. **Module Availability** — Different features per tenant
4. **Local Development** — `localhost/` provides isolated dev environment

### Related Memory Files

For deep understanding of multi-tenant configuration:
- **[config-architecture-multi-tenant](../../../../.claude/config_architecture_documentation.md)** — Detailed architecture guide
- **[error_config_deletion_2026_07_01](../../../../.claude/error_config_deletion_2026_07_01.md)** — Critical lessons learned

> **CRITICAL RULE**: Never delete files under `laravel/config/`. These are KNOWN tenant configurations, not speculative code. Always grep before deleting any config file.

---

## 🧠 Core Concepts

**Tenant Scoping**: All queries are scoped to current tenant automatically  
**Tenant Resolution**: Determined by domain/header/request context (see TenantIdentification.md)  
**Data Boundaries**: Foreign keys enforce tenant isolation at DB level  
**Config Hierarchy**: Environment-specific overrides per tenant

---

## 🛠️ Development Rules

| Rule | Source |
|------|--------|
| No Services — use Actions | [wiki/concepts/](./wiki/concepts/) |
| Tenant scoping automatic | [TenantIdentification.md](./wiki/TenantIdentification.md) |
| Config per tenant required | [ConfigurationDistribution.md](./wiki/ConfigurationDistribution.md) |
| No hardcoded credentials | Via `laravel/config/{tenant}/` |

---

## 📁 Archive & Legacy

**Note**: This module has ~360 documentation files accumulated over years. Only the canonical files above (wiki/, roadmap/, PRD, README) are actively maintained. Other files are:
- **Legacy**: Historical decisions no longer active
- **Duplicates**: Multiple versions of same content (ponytail cleanup deferred)
- **Task-specific**: Archived from past sprints

**Rule**: When documenting Tenant module features:
1. Update [wiki/](./wiki/) first (canonical source)
2. Link from 00-INDEX.md (this file)
3. Archive old duplicates if found

---

## 🔗 Related Modules

- **[User Module](../../User/docs/00-INDEX.md)** — Authentication per tenant
- **[Xot Module](../../Xot/docs/00-INDEX.md)** — Base classes for tenant awareness
- **[Theme System](../../../Themes/)** — Theme per tenant support

---

**Next Step**: Read [wiki/TenantIdentification.md](./wiki/TenantIdentification.md) to understand how the current request is associated with a tenant.
