---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "patterns"
issues: []
discussions: []
title: Tenant Module Design Patterns
module: Tenant
status: production
last_updated: 2026-07-28
---

# Tenant Module Design Patterns

**Last updated: 2026-07-28**

This document describes the core architectural patterns used in the Tenant module to ensure isolation, security, and maintainability.

---

## 1. Tenant Isolation Pattern

### Purpose
Ensure complete data separation between tenants with no cross-tenant data leakage.

### Strategy
- **Database-Level**: Each tenant uses separate database or schema
- **Query Scoping**: Automatic query filters on tenant context
- **Connection Resolution**: Smart routing to correct database connection

### Implementation Checklist

- [ ] Use `Tenant::currentTenant()` to get active tenant context
- [ ] Apply automatic query scopes via model traits
- [ ] Never hardcode database connections
- [ ] Validate tenant context in controllers/actions
- [ ] Use middleware to establish tenant context

### Code Example

```php
// ✅ Correct: Uses automatic tenant scoping
$users = User::where('active', true)->get();

// ❌ Incorrect: Bypasses tenant isolation
$users = DB::table('users')->where('active', true)->get();

// ✅ Correct: Explicit tenant check
$user = User::whereTenantId($tenantId)->find($userId);
```

---

## 2. Database Strategy Pattern

### Purpose
Select and maintain the appropriate multi-tenancy database architecture.

### Strategies

#### Option A: Separate Database per Tenant
- Each tenant has own database
- Best isolation, higher operational overhead
- Good for compliance/regulatory requirements

#### Option B: Shared Database with Schema per Tenant
- Single database, separate schemas
- Moderate isolation, reduced overhead
- Good balance between security and simplicity

#### Option C: Shared Database with Row-Level Scoping
- Single database, single schema, tenant_id column
- Lowest operational overhead, requires rigorous scoping
- Suitable for homogeneous tenants

### Implementation Checklist

- [ ] Define strategy in `config/database.php`
- [ ] Configure connection factory
- [ ] Create base models with correct table references
- [ ] Test isolation with multi-tenant data
- [ ] Document strategy in bmad/architecture-tenant.md
- [ ] Implement backup/restore per strategy

---

## 3. Middleware Pattern

### Purpose
Establish and validate tenant context at request boundary.

### Implementation Checklist

- [ ] Use middleware in `Http/Middleware/` folder
- [ ] Resolve tenant from domain/header/request
- [ ] Validate tenant is active
- [ ] Store in request container
- [ ] Clear context on response
- [ ] Log context switches for audit

### Code Example

```php
namespace Modules\Tenant\Http\Middleware;

class ResolveTenant
{
    public function handle($request, $next)
    {
        $domain = $request->getHost();
        $tenant = Tenant::whereDomain($domain)
            ->orWhereHas('domains', function($q) {
                $q->where('domain', $domain);
            })
            ->first();

        if (! $tenant || ! $tenant->is_active) {
            abort(404, 'Tenant not found');
        }

        app()->instance('tenant', $tenant);
        
        return $next($request);
    }
}
```

---

## 4. Query Scoping Pattern

### Purpose
Automatically constrain queries to current tenant without manual filtering.

### Implementation Checklist

- [ ] Create `Traits/HasTenant` trait
- [ ] Apply trait to all multi-tenant models
- [ ] Use `boot` method to add global scope
- [ ] Provide `whereTenantId()` method
- [ ] Test with explicit `without()` scope removal
- [ ] Document scope behavior in model

### Code Example

```php
namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Scope;

trait HasTenant
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('tenant', function ($query) {
            $tenant = app('tenant');
            if ($tenant) {
                $query->where('tenant_id', $tenant->id);
            }
        });
    }

    public function scopeWithoutTenant($query)
    {
        return $query->withoutGlobalScope('tenant');
    }

    public function scopeWhereTenantId($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
```

---

## 5. Context Switching Pattern

### Purpose
Safely switch tenant context for background jobs, testing, or admin operations.

### Implementation Checklist

- [ ] Create context manager class
- [ ] Provide `asUser()` or `asTenant()` methods
- [ ] Use exception-safe scope restoration
- [ ] Log context switches
- [ ] Test with nested context switches
- [ ] Clean up in finally block

### Code Example

```php
namespace Modules\Tenant\Services;

class TenantContext
{
    public static function asTenant($tenant, callable $callback)
    {
        $previousTenant = app('tenant');
        
        try {
            app()->instance('tenant', $tenant);
            return call_user_func($callback);
        } finally {
            if ($previousTenant) {
                app()->instance('tenant', $previousTenant);
            } else {
                app()->forgetInstance('tenant');
            }
        }
    }
}

// Usage
TenantContext::asTenant($tenant, function() {
    $users = User::all(); // Scoped to $tenant
});
```

---

## Anti-Patterns

### ❌ Anti-Pattern 1: Hardcoded Tenant References

**Problem**: Embedded assumptions about tenant structure

```php
// ❌ Wrong
$users = DB::connection('tenant_' . $id)->table('users')->get();
$users = User::where('client_id', $clientId)->get(); // Bypasses automatic scoping
```

**Solution**: Always use application context

```php
// ✅ Correct
$users = User::all(); // Uses automatic scoping
$users = Tenant::find($id)->users()->get(); // Explicit relationship
```

---

### ❌ Anti-Pattern 2: Lost Context in Async Operations

**Problem**: Background jobs lose tenant context

```php
// ❌ Wrong
UserNotification::dispatch($user);
// Job runs without tenant context, queries leak across tenants
```

**Solution**: Pass context explicitly

```php
// ✅ Correct
UserNotification::dispatch($user)
    ->onConnection('sync')
    ->asTenant($tenant);
    
// Or in job constructor
public function __construct(User $user, Tenant $tenant)
{
    $this->user = $user;
    $this->tenant = $tenant;
}
```

---

### ❌ Anti-Pattern 3: Caching Without Tenant Key

**Problem**: Cache collision across tenants

```php
// ❌ Wrong
Cache::remember('settings', 3600, function() {
    return Settings::first(); // Cache shared across all tenants
});
```

**Solution**: Include tenant in cache key

```php
// ✅ Correct
$tenantId = app('tenant')->id;
Cache::remember("settings:tenant:{$tenantId}", 3600, function() {
    return Settings::first(); // Scoped to current tenant
});
```

---

## Testing Patterns

### Testing with Multiple Tenants

```php
public function test_users_isolated_by_tenant()
{
    $tenant1 = TenantFactory::new()->create();
    $tenant2 = TenantFactory::new()->create();
    
    // Create users in different tenants
    TenantContext::asTenant($tenant1, function() {
        User::factory()->create(['name' => 'Alice']);
    });
    
    TenantContext::asTenant($tenant2, function() {
        User::factory()->create(['name' => 'Bob']);
    });
    
    // Verify isolation
    TenantContext::asTenant($tenant1, function() {
        $this->assertCount(1, User::all());
        $this->assertTrue(User::where('name', 'Alice')->exists());
    });
}
```

---

## References

- [Architecture](bmad/architecture-tenant.md): Detailed system design
- [Troubleshooting](troubleshooting.md): Common issues
- [API Reference](api.md): Model and service signatures
- [Contributing Guide](../../docs/wiki/how-to/contributing.md): Development guidelines

---

Navigation: [Documentation Index](index.md) | [README](README.md) | [Troubleshooting](troubleshooting.md)
