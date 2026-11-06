---
title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
---

# Tenant Module Philosophy

Multi-tenancy data isolation, feature toggling, and runtime configuration for each tenant independently.

## First Principle

> **Activate a feature, tenant sees it immediately. No code redeploy. Migrate data, tenant moves unharmed.**

Each tenant is isolated: own database or schema, own config, own feature flags. Changes to one tenant don't touch others.

## The Rules

### 1. Spatie Multitenancy with Database Isolation

Each tenant owns a database or schema:
```php
config('tenancy.database') === 'tenant_acme_2024'
// or
config('tenancy.schema') === 'tenant_acme'
```

**Never** use `tenant_id` column to isolate data. Use database-level isolation.

**Why:** Database-level isolation = impossible to accidentally query across tenants. SQL-level guarantee.

### 2. JSON Config Per Tenant

Tenant settings live in JSON, not DB columns:
```
database/content/tenants/{tenant-id}/xra.json
{
  "company_name": "Acme Corp",
  "timezone": "Europe/Rome",
  "features": { "workflow_approval": true }
}
```

**Never** add columns to `tenants` table for settings.

**Why:** Config is portable, version-controllable, and migrates with tenant data. JSON scales.

### 3. Feature Flags via AccountFeatures

Features are toggled per tenant:
```php
$tenant->features()->is('workflow_approval', 'enabled')
```

**Never** hardcode feature logic in code. Always gate behind flag.

**Why:** Rolling out features = tenant by tenant. Rollback = flip flag. No code redeploy.

### 4. SushiToJsons for Static Data

Lookup tables (status types, role names) stored as JSON:
```php
class Status extends \Spatie\Sushi\Sushi
{
    protected $filePath = 'database/content/statuses.json';
}
```

**Never** create full Eloquent tables for enumerable data.

**Why:** Statuses don't change per request. JSON read once, cached. No migrations per status type.

### 5. Tenant Middleware on Every Route

All routes discover tenant from domain/header:
```php
middleware('tenancy:domain_identification')
```

**Never** pass tenant context as parameter. Let middleware resolve it.

**Why:** Every code path sees the same tenant. No passing context around. Impossible to mix tenants.

### 6. Config Cache Per Tenant

Tenant config is cached separately:
```php
config('tenant.features') === $tenant->features()->fresh()
```

Invalidate when config changes. Don't stale-check manually.

**Why:** Thousands of requests per minute; config reads from cache, not DB/disk.

### 7. Soft Delete + Cascade Restore for Tenant Data

When tenant is deleted, all data (with soft delete) is deleted. Restore tenant = restore all data:
```php
$tenant->delete() // soft delete + cascade
$tenant->restore() // restore + all child records
```

**Why:** Accidental deletes are reversible. Audit trail intact.

## The Zen of Tenant

> **One tenant, one config, one feature set, invisible to other tenants.**

- Feature flags = no redeploy, just flip
- JSON config = portable, migrated with tenant
- Database isolation = SQL-level guarantee
- Middleware = transparent context
- Soft delete = reversible tenant removal

## Breaking the Rules

If you think a rule is wrong:
1. **Document the exception** in your module's README
2. **Flag sensitive features** if crossed tenant boundary
3. **Add integration tests** if isolation is critical
4. **Notify maintainers** of any tenant context bypass
5. **Never silently mix tenants** — audit trail depends on it

## See Also

- `ARCHITECTURE.md` — database isolation patterns
- `TESTING.md` — tenant testing strategies
- `docs/feature-flags.md` — AccountFeatures workflow
- `docs/json-config.md` — JSON configuration format
- `docs/tenant-migration.md` — moving tenants between hosts
- `docs/multi-database.md` — managing multiple tenant databases
