---
qmd: "ARCHITECTURE"
issues: []
discussions: []
title: "Architecture: Tenant Module"
type: architecture
tags: [tenant, multi-tenancy, architecture, core]
created: 2026-07-09
updated: 2026-07-09
status: draft
---

# Architecture: Tenant Module

## Overview

The **Tenant** module provides multi-tenancy infrastructure for Laraxot, enabling data isolation, per-tenant configuration, and flexible deployment models. It handles tenant resolution, context management, and database/filesystem isolation.

## Core Concepts

### Tenant
A logical application instance with its own data, configuration, and context. Each tenant operates as an isolated namespace within the shared infrastructure.

### Tenant Context
Thread-local/request-scoped state tracking the current active tenant. Critical for routing, queries, and configuration resolution.

### Domain-based Routing
Multi-domain support where subdomains or complete domains identify the active tenant (e.g., `tenant1.app.com`, `tenant2.app.com`, `app.com/tenant1`).

### Configuration Isolation
Per-tenant configuration files override system defaults, enabling customization without code changes.

## High-Level Design

```
┌─────────────────────────────────────────────────────┐
│             Request Entry Point                     │
│  (TenantMiddleware / TenantServiceProvider)         │
└────────────────┬────────────────────────────────────┘
                 │
        ┌────────▼────────┐
        │  Domain/URL     │
        │  Resolution     │
        └────────┬────────┘
                 │
        ┌────────▼─────────────────┐
        │  Load Tenant Context      │
        │  - Database selection     │
        │  - Config loading         │
        │  - Scope setup            │
        └────────┬──────────────────┘
                 │
    ┌────────────┴──────────────┐
    │                           │
┌───▼──────┐          ┌───────▼───┐
│ Query    │          │ Config    │
│ Scoping  │          │ Override  │
└──────────┘          └───────────┘
```

## Component Breakdown

### Models

#### `Tenant`
- **Location:** `app/Models/Tenant.php`
- **Purpose:** Represents a single tenant/account
- **Key Attributes:**
  - `id`: Unique identifier
  - `name`: Display name
  - `slug`: URL-safe identifier
  - `domain`: Primary domain
  - `database_name`: Dedicated or shared database identifier
  - `is_active`: Active/inactive status
  - `config`: JSON store for custom settings

#### `Domain`
- **Location:** `app/Models/Domain.php`
- **Purpose:** Maps domains to tenants
- **Relationships:**
  - `belongsTo(Tenant)`
- **Usage:** Reverse DNS lookup on request

### Traits

#### `BelongsToTenant`
- **Applied To:** Application models needing tenant isolation
- **Methods:**
  - `scopeForTenant()` - Filter by current tenant
  - `getTenant()` - Retrieve associated tenant
- **Important:** Applied automatically via `BelongsToTenantsScope`

#### `SushiToJson`, `SushiToCsv`, `SushiToJsons`
- **Purpose:** Convert Sushi (CSV-based) models to JSON/arrays for storage
- **Usage:** In `phpstan` probe fixtures and test helpers

### Services & Actions

#### `TenantService`
- **Location:** `app/Services/TenantService.php`
- **Responsibilities:**
  - Retrieve current tenant from context
  - Validate tenant access
  - Switch tenant context
  - Load tenant configuration

#### `GetTenantNameAction`
- **Invokable:** QueueableAction
- **Purpose:** Resolve tenant name from domain/slug
- **Parameters:** `string $domain`
- **Returns:** `?string`

#### `SaveTenantConfigAction`
- **Purpose:** Persist tenant-specific config to disk
- **Parameters:** `Tenant $tenant`, `array $config`
- **Storage:** `storage/tenants/{tenant_id}/config.php`

#### `GetTenantConfigArrayAction`
- **Purpose:** Load all tenant configuration
- **Caching:** Applied (via Laravel cache)
- **Returns:** Complete merged config array

#### `ResolveTenantConfigValueAction`
- **Purpose:** Get single config value with fallback to system default
- **Parameters:** `string $key`, `mixed $default = null`
- **Returns:** Resolved value

### Providers

#### `TenantServiceProvider`
- **Registration:** Auto-registered
- **Responsibilities:**
  - Register Tenant model binding
  - Register domain-to-tenant resolver
  - Register tenant-scoped queries middleware
  - Register config service provider

#### `TenantBootServiceProvider`
- **Purpose:** Boot tenant-specific modules on request
- **Triggered:** After TenantMiddleware resolves tenant

### Middleware

#### `TenantMiddleware`
- **Location:** `app/Http/Middleware/TenantMiddleware.php`
- **Order:** Early in stack (after URL verification)
- **Actions:**
  1. Extract tenant identifier from domain/URL
  2. Resolve to Tenant model
  3. Set tenant context
  4. Boot tenant-specific config

#### `VerifyTenantAccess`
- **Purpose:** Authorize user access to current tenant
- **Usage:** Protect admin/sensitive routes

### Data Flow

```
1. HTTP Request arrives
   ├─ URL/Domain contains tenant identifier
   └─ Authentication (if any) established

2. TenantMiddleware
   ├─ Parse domain → tenant slug
   ├─ Query: Tenant::whereSlug($slug)
   ├─ Set context (RequestContext::setTenant())
   └─ Load config

3. Request processing
   ├─ Queries automatically scoped to tenant
   ├─ Config accessed via tenant resolver
   └─ Context available via context helper

4. Response
   └─ Context cleaned up at request end
```

## Integration Points

### Depends On
- **Xot Module**: Base models, traits, service providers
- **Laravel Core**: Middleware, service container, config

### Depended On By
- **User Module**: Tenant-aware user/permission scoping
- **All Domain Modules**: Auto-apply `BelongsToTenant` trait

### External Services
- **Database**: Multiple databases or shared with tenant prefix
- **Filesystem**: Per-tenant storage paths

### Events

#### `TenantResolvedEvent`
- **Fired:** When tenant identified and loaded
- **Payload:**
  ```php
  public function __construct(public Tenant $tenant) {}
  ```
- **Usage:** Initialize tenant-specific services

#### `TenantCreatedEvent`
- **Fired:** After new tenant saved
- **Usage:** Provision databases, filesystems

## Design Decisions

| Decision | Rationale | Alternatives |
|----------|-----------|--------------|
| Domain-based routing | Simple, intuitive for users; clear subdomain strategy | Path-based (less clear), header-based (invisible) |
| Middleware-early approach | Ensures all queries inherit tenant scope automatically | Middleware-late requires manual scoping |
| JSON config storage in model | Flexible, schema-less; avoids migration churn | Separate config table (joins overhead) |
| Trait-based scope application | DRY; automatic for all future models | Manual scoping per query (error-prone) |

## Critical Paths

### 1. Tenant Resolution on Request
```php
// TenantMiddleware → RequestContext::setTenant()
// Every query automatically includes: whereTenanantId(current())
```

### 2. Configuration Override
```php
// config('app.name') → checks Tenant config first
// Falls back to system default if not set
```

### 3. Isolation Verification
```php
// Model query for Tenant A never returns data from Tenant B
// Enforced at middleware level, not model level (more reliable)
```

## Performance Considerations

### Query Scoping Overhead
- Automatic filtering on every query (negligible if indexed)
- **Optimization:** Ensure `tenant_id` columns have indexes

### Configuration Loading
- Per-request, cached in memory
- **Optimization:** Use `GetTenantConfigArrayAction::cache()`

### Domain Resolution
- DNS/domain lookup on each request
- **Optimization:** Cache domain→tenant mapping (Redis recommended)

## Related Files

- [API Reference](./api.md)
- [Setup Guide](./SETUP.md)
- [Troubleshooting](./troubleshooting.md)
- [Best Practices](./BEST_PRACTICES.md)
- Module Tests: `tests/Feature/TenantBusinessLogicTest.php`, `tests/Unit/Actions/`
