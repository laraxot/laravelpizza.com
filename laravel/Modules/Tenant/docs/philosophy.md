---
title: "philosophy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-25
qmd: "tenant philosophy isolamento multi tenancy"
issues: []
discussions: []
status: draft
---

# Tenant Module: Multi-Tenancy Architecture

> **Data Isolation & Routing**: Tenant context, domain-to-database mapping, query scoping.

---

## Zen

**"One app, many tenants. Data isolation is non-negotiable."**

---

## Quick

### Models (9)
- **Tenant**: Organization (name, slug, database config, domain list)
- **Domain**: Route URL to tenant (domain, tenant_id)
- **DatabaseConfig**: Custom DB per tenant (host, port, database, user)
- **BaseModelJsons**: Tenant-scoped model with JSON attrs

### Pattern
```
HTTP Request (domain=acme.app.com)
  ↓
Middleware: resolve tenant from Domain table
  ↓
Set auth()->tenant() context
  ↓
DB connection switch (if tenant has custom DB)
  ↓
All queries auto-scoped: where('tenant_id', ...)
  ↓
Response
```

### Actions (1)
- `GetTenantNameAction`: Resolve tenant name from context

---

## Routing Strategy

**Three modes**:
1. **Multi-domain**: acme.app.com, beta.app.com (different tenants)
2. **Sub-domain**: acme.example.com, beta.example.com (one host)
3. **Path-based**: /acme, /beta (shared host)

All map to Tenant via Domain table.

---

## Integration

- **User** → currentTeam → Tenant scoping
- **Middleware** → Sets tenant context
- **Policies** → Enforce tenant isolation
- **All models** → inherit tenant_id scope

---

## Best/Bad

✓ Centralized Domain→Tenant mapping
✓ Database-level isolation (separate DB per tenant possible)
✓ Query auto-scoping (middleware, not manual)
❌ Manual `where('tenant_id', ...)` (use query scope)

---

## Roadmap

- Tenant metadata (logo, theme, feature flags)
- Shared vs isolated databases (config per tenant)
- Tenant switchover (user can context-switch)
- Audit trail (who switched when)

---

```
┌──────────────────────────┐
│ Tenant (Multi-Tenancy)   │
├──────────────────────────┤
│ Models: 9                │
│ Migrations: 3            │
│ Status: Stable           │
│ Pattern: SaaS routing    │
└──────────────────────────┘
```

---

- **Generated**: 2026-09-06

