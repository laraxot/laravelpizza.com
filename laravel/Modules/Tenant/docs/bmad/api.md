---
title: "API Reference: Tenant Module"
type: reference
tags: [tenant, api, contracts, services]
created: 2026-07-09
updated: 2026-07-09
qmd: "api reference: tenant module tenant"
status: superseded
superseded_by: ../api.md
---

# API Reference: Tenant Module

## Overview

This document describes all public APIs, contracts, and services exposed by the Tenant module for managing multi-tenancy, tenant context, and configuration.

## Public Contracts

### `TenantContract`
**Location:** `app/Contracts/TenantContract.php`

```php
interface TenantContract {
    public function getId(): int|string;
    public function getName(): string;
    public function getSlug(): string;
    public function getDomain(): ?string;
    public function getDatabaseName(): ?string;
    public function isActive(): bool;
    public function getConfig(string $key, mixed $default = null): mixed;
}
```

**Usage:**
```php
// Type-hint for tenant-aware services
public function __construct(
    protected TenantContract $tenant
) {}
```

---

## Core Services

### `TenantService`
**Location:** `app/Services/TenantService.php`

**Responsibility:** Central service for tenant context management.

#### Public Methods

| Method | Parameters | Returns | Description |
|--------|-----------|---------|-------------|
| `current()` |: | `?Tenant` | Get currently active tenant |
| `setCurrentTenant()` | `Tenant\|int` | `void` | Set active tenant (request scope) |
| `forTenant()` | `Tenant\|int` | `Tenant` | Switch context to tenant |
| `isMultiTenant()` |: | `bool` | Check if app is multi-tenant |
| `allTenants()` |: | `Collection\|Tenant[]` | Get all active tenants |

**Example Usage:**
```php
// Get current tenant
$tenant = app(TenantService::class)->current();

// Switch context
$service->setCurrentTenant($tenantId);

// Process for all tenants
foreach (app(TenantService::class)->allTenants() as $tenant) {
    $service->setCurrentTenant($tenant);
    // Process tenant-specific data
}
```

---

## Action Classes (QueueableAction)

### `GetTenantNameAction`
**Location:** `app/Actions/GetTenantNameAction.php`
**Purpose:** Resolve tenant name from domain or slug
**Queueable:** Yes

#### `__invoke()` Method
- **Parameters:** 
  - `string $domainOrSlug` - Domain name or tenant slug
- **Returns:** `?string` - Tenant name or null if not found
- **Throws:** None (graceful fallback)

**Example:**
```php
$name = GetTenantNameAction::dispatch('tenant1.app.com'); // 'Tenant 1'
// Or inline:
$name = (new GetTenantNameAction())('example.com');
```

---

### `SaveTenantConfigAction`
**Location:** `app/Actions/Config/SaveTenantConfigAction.php`
**Purpose:** Persist tenant-specific configuration
**Queueable:** Yes

#### `__invoke()` Method
- **Parameters:**
  - `Tenant $tenant` - The tenant to configure
  - `array $config` - Configuration array to save
  - `?string $namespace = null` - Optional config namespace
- **Returns:** `bool` - Success indicator
- **Side Effects:** Writes to `storage/tenants/{id}/config.php`

**Example:**
```php
(new SaveTenantConfigAction())(
    $tenant,
    [
        'app.name' => 'Custom Brand',
        'features.enabled' => ['feature_1', 'feature_2'],
    ]
);
```

---

### `GetTenantConfigArrayAction`
**Location:** `app/Actions/Config/GetTenantConfigArrayAction.php`
**Purpose:** Load all tenant configuration
**Queueable:** Yes

#### `__invoke()` Method
- **Parameters:**
  - `Tenant $tenant` - The tenant to load config for
  - `?bool $withSystem = true` - Include system defaults
- **Returns:** `array` - Complete merged configuration
- **Caching:** Cached per tenant (5 minute TTL)

**Example:**
```php
$config = (new GetTenantConfigArrayAction())(
    $tenant,
    withSystem: true
); // ['app.name' => 'Tenant Custom', 'app.debug' => false, ...]
```

---

### `ResolveTenantConfigValueAction`
**Location:** `app/Actions/Config/ResolveTenantConfigValueAction.php`
**Purpose:** Get single config value with system fallback
**Queueable:** Yes

#### `__invoke()` Method
- **Parameters:**
  - `string $key` - Config key (dot notation)
  - `mixed $default = null` - Fallback value
- **Returns:** `mixed` - Resolved config value
- **Lookup Order:**
  1. Tenant-specific config
  2. System config
  3. Default parameter

**Example:**
```php
$name = (new ResolveTenantConfigValueAction())('app.name', 'Default App');
// Returns 'Tenant Custom' if set, else system 'app.name', else 'Default App'
```

---

### `GetTenantConfigNamesAction`
**Location:** `app/Actions/Config/GetTenantConfigNamesAction.php`
**Purpose:** List all configurable keys for a tenant
**Queueable:** Yes

#### `__invoke()` Method
- **Parameters:**
  - `Tenant $tenant` - The tenant
- **Returns:** `array` - List of config key names

**Example:**
```php
$keys = (new GetTenantConfigNamesAction())($tenant);
// ['app.name', 'app.debug', 'features.enabled', ...]
```

---

## Traits

### `BelongsToTenant`
**Purpose:** Automatically scope models to current tenant
**Applied To:** Any model requiring tenant isolation
**Namespace:** `Modules\Tenant\Models\Traits`

#### Methods Added

```php
public function scopeForTenant(Builder $query, ?Tenant $tenant = null): Builder
// Filter by tenant (uses current if not specified)

public function getTenant(): ?Tenant
// Get associated tenant

public function scopeCurrentTenant(Builder $query): Builder
// Shortcut for scopeForTenant() with current tenant
```

**Usage:**
```php
class User extends Model {
    use BelongsToTenant;
}

// Automatic scoping in queries:
User::query()         // Only returns users for current tenant
    ->where('active', true)
    ->get();

// Manual tenant:
User::forTenant($otherTenant)->get();

// In relationships:
$tenant = $user->getTenant();
```

**Important:** This trait is automatically applied via `BelongsToTenantsScope`: models don't need explicit inclusion in most cases.

---

### `HasTenantConfig`
**Purpose:** Make model act as config store
**Applied To:** Tenant model and any config repositories

#### Methods Added

```php
public function getConfig(string $key, mixed $default = null): mixed
// Get config value

public function setConfig(string $key, mixed $value): self
// Set config value

public function saveConfig(): bool
// Persist to storage
```

**Example:**
```php
$tenant->setConfig('features.enabled', ['feature1', 'feature2'])
    ->saveConfig();

$features = $tenant->getConfig('features.enabled', []);
```

---

## Global Helpers

### `tenant()` Helper
**Returns:** `?Tenant` - Currently active tenant
**Usage:**
```php
if (tenant()) {
    $tenantId = tenant()->id;
}
```

### `tenant_id()` Helper
**Returns:** `?int|string` - Current tenant ID or null
**Usage:**
```php
$query->whereTenantId(tenant_id());
```

### `is_tenant_mode()` Helper
**Returns:** `bool` - Whether app is in multi-tenant mode
**Usage:**
```php
if (is_tenant_mode()) {
    // Multi-tenant specific logic
}
```

---

## Middleware

### `TenantMiddleware`
**Location:** `app/Http/Middleware/TenantMiddleware.php`
**Namespace:** `Modules\Tenant\Http\Middleware`

**Responsibility:** Resolve and set tenant context

**Usage in Routes:**
```php
Route::middleware('tenant')->group(function () {
    // Routes in this group require valid tenant
});
```

**Behavior:**
1. Extracts tenant from domain/URL
2. Validates tenant exists and is active
3. Sets context
4. Loads configuration
5. Fires `TenantResolvedEvent`

---

### `VerifyTenantAccess`
**Location:** `app/Http/Middleware/VerifyTenantAccess.php`

**Responsibility:** Authorize user for current tenant

**Usage:**
```php
Route::middleware(['auth', 'verify-tenant-access'])->group(function () {
    // Only authenticated users with tenant access
});
```

---

## Models & Relationships

### `Tenant` Model
**Location:** `app/Models/Tenant.php`

#### Attributes
| Attribute | Type | Description |
|-----------|------|-------------|
| `id` | int/uuid | Unique identifier |
| `name` | string | Display name |
| `slug` | string | URL-safe identifier (unique) |
| `domain` | ?string | Primary domain |
| `database_name` | ?string | Database identifier |
| `is_active` | bool | Active status |
| `config` | json | Custom configuration |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

#### Relationships
```php
$tenant->domains();         // HasMany → Domain
$tenant->users();           // HasMany → Users
```

#### Scopes
```php
$query->active();           // whereIsActive(true)
$query->whereSlug('slug');  // Find by slug
```

---

### `Domain` Model
**Location:** `app/Models/Domain.php`

#### Attributes
| Attribute | Type | Description |
|-----------|------|-------------|
| `id` | int | Unique ID |
| `tenant_id` | int/uuid | Tenant reference |
| `domain` | string | Domain name |
| `is_primary` | bool | Primary domain flag |

#### Relationships
```php
$domain->tenant();          // BelongsTo → Tenant
```

---

## Events

### `TenantResolvedEvent`
**Fired:** When tenant identified and loaded on request
**Namespace:** `Modules\Tenant\Events`

```php
class TenantResolvedEvent {
    public function __construct(public Tenant $tenant) {}
}
```

**Usage in Listeners:**
```php
class BootTenantServices {
    public function handle(TenantResolvedEvent $event) {
        $tenant = $event->tenant;
        // Initialize tenant-specific services
    }
}
```

---

### `TenantCreatedEvent`
**Fired:** After new tenant saved to database
**Namespace:** `Modules\Tenant\Events`

```php
class TenantCreatedEvent {
    public function __construct(public Tenant $tenant) {}
}
```

---

## Database Scopes (Automatic)

### Query Auto-Scoping
All queries on models using `BelongsToTenant` trait are **automatically scoped** to the current tenant:

```php
// Implicit:
User::all();              // SELECT * FROM users WHERE tenant_id = :current

// Explicit override (when needed):
User::withoutGlobalScopes()->all();  // Requires permission
```

**Critical:** This is enforced at the middleware level, making it difficult to accidentally cross tenant boundaries.

---

## Related Documentation
- [Architecture Overview](./ARCHITECTURE.md)
- [Setup & Configuration](./SETUP.md)
- [Troubleshooting](troubleshooting.md)
- [Best Practices](./BEST_PRACTICES.md)
