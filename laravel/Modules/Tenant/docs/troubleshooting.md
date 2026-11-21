---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "TROUBLESHOOTING"
issues: []
discussions: []
title: Tenant Module Troubleshooting Guide
module: Tenant
status: production
last_updated: 2026-07-28
---

# Tenant Module Troubleshooting Guide

**Last updated: 2026-07-28**

This guide addresses common issues, errors, and scenarios in the Tenant module.

---

## 1. Isolation Failures

### Error Pattern
Data from different tenants appearing in queries, or users accessing data from other tenants.

### Possible Causes
- Missing global scope on model
- Middleware not established tenant context
- Query uses `withoutGlobalScopes()`
- Direct database query bypassing Eloquent
- Trait not applied to model

### Solution (Step-by-Step)

1. **Verify Global Scope Applied**
   ```php
   // In your model
   use Modules\Tenant\Models\Traits\HasTenant;

   class User extends Model
   {
       use HasTenant; // Must be present
   }
   ```

2. **Check Middleware Registration**
   ```php
   // In RouteServiceProvider or route definition
   Route::middleware(['web', 'auth', 'resolve.tenant'])
       ->group(function () {
           // Your routes
       });
   ```

3. **Verify Tenant Context Established**
   ```php
   // In controller/action
   $tenant = app('tenant');
   if (! $tenant) {
       throw new \Exception('Tenant context not established');
   }
   ```

4. **Audit Query Logging**
   ```php
   // Enable query logging in .env
   DB_LOG_QUERIES=true
   
   // Review logs for WHERE tenant_id clause
   ```

5. **Test with Explicit Scope Removal**
   ```php
   // Verify scoping works
   $withScope = User::count();      // Should be <N
   $noScope = User::withoutGlobalScopes()->count(); // Should be >N
   ```

### Prevention
- Always use traits on multi-tenant models
- Test isolation with factory-created data
- Audit model definitions regularly
- Log data access for compliance

### Reference
- See [Query Scoping Pattern](patterns.md#4-query-scoping-pattern)
- See [Isolation Pattern](patterns.md#1-tenant-isolation-pattern)

---

## 2. Context Leaks

### Error Pattern
Background jobs, queued notifications, or scheduled tasks process data from wrong tenant.

### Possible Causes
- Job dispatched without tenant context
- Scheduled command assumes tenant context
- Broadcasting without context
- Cache cleared between requests
- Event listener runs in different context

### Solution (Step-by-Step)

1. **Identify Context Loss Point**
   ```php
   // Add logging to determine where context is lost
   Log::debug('Tenant context', ['tenant' => app('tenant')?->id]);
   ```

2. **Pass Tenant to Job**
   ```php
   // ✅ Correct
   public function __construct(User $user, Tenant $tenant)
   {
       $this->user = $user;
       $this->tenant = $tenant;
   }

   public function handle()
   {
       TenantContext::asTenant($this->tenant, function() {
           // Your job logic
       });
   }
   ```

3. **Use TenantContext Wrapper**
   ```php
   // In scheduled command
   $this->call('custom:command', [
       'tenant_id' => $tenant->id,
   ]);
   
   // In command
   public function handle()
   {
       $tenant = Tenant::find($this->argument('tenant_id'));
       TenantContext::asTenant($tenant, function() {
           // Your logic
       });
   }
   ```

4. **Verify Queue Middleware**
   ```php
   // In job class
   public function middleware()
   {
       return [
           new TenantMiddleware($this->tenant),
       ];
   }
   ```

### Prevention
- Always pass tenant to async operations
- Test queued jobs with multi-tenant data
- Use explicit context wrappers
- Log tenant in job handlers

### Reference
- See [Context Switching Pattern](patterns.md#5-context-switching-pattern)
- Laravel Queue documentation: https://laravel.com/docs/queue

---

## 3. Routing Errors

### Error Pattern
"Tenant not found", 404 errors on valid domains, or requests routing to wrong tenant.

### Possible Causes
- Domain not registered in Domain model
- Primary domain not set correctly
- Domain middleware order incorrect
- Cache contains stale domain mapping
- Subdomain wildcard not configured in DNS

### Solution (Step-by-Step)

1. **Verify Domain Registration**
   ```php
   // Check if domain exists
   $domain = Domain::where('domain', request()->getHost())->first();
   if (! $domain) {
       // Domain not in database
       Domain::create([
           'tenant_id' => $tenant->id,
           'domain' => request()->getHost(),
           'is_primary' => true,
       ]);
   }
   ```

2. **Check Middleware Order**
   ```php
   // Ensure domain resolution happens before auth
   Route::middleware([
       'resolve.tenant',  // Must be early
       'web',
       'auth',
   ])->group(function () {
       // Your routes
   });
   ```

3. **Clear Domain Cache**
   ```bash
   php artisan cache:forget tenant_domains
   php artisan route:cache
   ```

4. **Verify Middleware Implementation**
   ```php
   // Check ResolveTenant middleware
   $domain = request()->getHost();
   $tenant = Tenant::whereDomain($domain)
       ->orWhereHas('domains', function($q) use ($domain) {
           $q->where('domain', $domain);
       })
       ->active()
       ->first();
   ```

5. **Test with Direct URL**
   ```bash
   curl -H "Host: tenant1.example.com" http://localhost
   curl -H "Host: tenant2.example.com" http://localhost
   ```

### Prevention
- Use Filament admin to manage domains
- Test routing with `artisan tinker`
- Implement domain validation webhook
- Monitor 404 errors for new domains

### Reference
- See [Middleware Pattern](patterns.md#3-middleware-pattern)

---

## 4. Database Connection Errors

### Error Pattern
"Connection not found", authentication errors, or wrong database accessed.

### Possible Causes
- Database configuration not defined for tenant
- Connection name format incorrect
- Database server unreachable
- Wrong credentials in connection config
- Schema not migrated

### Solution (Step-by-Step)

1. **Verify Connection Configuration**
   ```php
   // In config/database.php or config/tenant.php
   'connections' => [
       'tenant_' . $tenantId => [
           'driver' => 'mysql',
           'host' => env('TENANT_DB_HOST'),
           'database' => 'tenant_' . $tenantId,
           'username' => env('TENANT_DB_USER'),
           'password' => env('TENANT_DB_PASSWORD'),
       ],
   ];
   ```

2. **Check Tenant Database Config**
   ```php
   $tenant = Tenant::find($tenantId);
   dd($tenant->database); // Should show database name
   
   // Verify connection exists
   dd(config('database.connections.tenant_' . $tenantId));
   ```

3. **Test Connection**
   ```bash
   php artisan tinker
   >>> DB::connection('tenant_123')->select('SELECT 1')
   ```

4. **Run Migrations**
   ```bash
   php artisan migrate --database=tenant_123
   ```

5. **Check Database Permissions**
   ```bash
   # Verify database exists
   mysql -u root -p -e "SHOW DATABASES LIKE 'tenant_%'"
   ```

### Prevention
- Use provisioning scripts to create databases
- Test connections in provisioning
- Monitor failed connection attempts
- Keep connection credentials in .env

### Reference
- Laravel Database Configuration: https://laravel.com/docs/database

---

## 5. Permission Issues

### Error Pattern
"Unauthorized", "Access denied", permission checks failing or passing incorrectly.

### Possible Causes
- Policy not scoped to tenant
- User doesn't have tenant relationship
- Authorization policy checking wrong tenant
- Cache contains stale permissions
- Middleware not setting current tenant

### Solution (Step-by-Step)

1. **Verify Policy Implementation**
   ```php
   // In app/Models/Policies/TenantPolicy.php
   public function view(User $user, Tenant $tenant)
   {
       // Ensure user belongs to same tenant
       return $user->tenant_id === $tenant->id;
   }
   ```

2. **Check User-Tenant Relationship**
   ```php
   $user = User::find($userId);
   dump($user->tenant); // Should be the current tenant
   ```

3. **Test Authorization**
   ```php
   // In controller
   $this->authorize('view', $tenant);
   
   // Or explicit check
   if ($user->cannot('view', $tenant)) {
       abort(403);
   }
   ```

4. **Clear Permission Cache**
   ```bash
   php artisan cache:forget roles_permissions
   php artisan route:cache
   ```

5. **Audit Permission Log**
   ```php
   // Enable authorization logging
   Log::info('Authorization', [
       'user_id' => auth()->id(),
       'tenant_id' => app('tenant')->id,
       'action' => 'view',
       'resource' => 'Tenant',
   ]);
   ```

### Prevention
- Always include tenant in policy checks
- Test with non-admin users
- Audit policy definitions regularly
- Log authorization failures

### Reference
- Laravel Authorization: https://laravel.com/docs/authorization

---

## 6. Sync & Data Integrity Problems

### Error Pattern
"Data mismatch", incomplete migrations, orphaned records, or inconsistent state across tenants.

### Possible Causes
- Migrations failed on specific tenant
- Seed data incomplete
- Database constraints violated
- Concurrent modifications
- Rollback didn't complete

### Solution (Step-by-Step)

1. **Verify Migration Status**
   ```bash
   php artisan migrate:status --database=tenant_123
   # Check which migrations failed
   ```

2. **Rollback and Re-migrate**
   ```bash
   php artisan migrate:rollback --database=tenant_123
   php artisan migrate --database=tenant_123
   ```

3. **Verify Data Integrity**
   ```php
   // Check for orphaned records
   $orphaned = Model::whereNotIn('tenant_id', 
       Tenant::pluck('id')
   )->count();
   
   if ($orphaned > 0) {
       // Handle orphaned records
   }
   ```

4. **Re-seed Tenant**
   ```bash
   php artisan db:seed --class=TenantSeeder
   ```

5. **Backup and Restore**
   ```bash
   # Backup current state
   mysqldump tenant_123 > tenant_123_backup.sql
   
   # Drop and recreate
   mysql -e "DROP DATABASE tenant_123; CREATE DATABASE tenant_123;"
   
   # Re-run migrations
   php artisan migrate --database=tenant_123
   ```

### Prevention
- Test migrations with all tenants
- Use database transactions
- Validate data after bulk operations
- Monitor migration logs

### Reference
- Laravel Migrations: https://laravel.com/docs/migrations

---

## Quick Reference: Common Commands

```bash
# Check current tenant context
php artisan tinker
>>> app('tenant')?->id

# List all tenants and domains
php artisan tinker
>>> Tenant::with('domains')->get()

# Test tenant isolation
php artisan tinker
>>> User::count()  # Scoped to current tenant
>>> User::withoutGlobalScopes()->count() # All users

# Clear tenant caches
php artisan cache:clear
php artisan route:cache
php artisan config:cache

# Run migrations for specific tenant
php artisan migrate --database=tenant_123

# Test email in tenant context
>>> TenantContext::asTenant($tenant, function() { Mail::raw('test', fn($m) => $m->to('user@example.com')); })
```

---

## Getting Help

1. **Check logs**: `storage/logs/laravel.log`
2. **Enable query logging**: Set `DB_LOG_QUERIES=true`
3. **Review policies**: Check `app/Models/Policies/`
4. **Test isolation**: Use `artisan tinker` with `TenantContext`
5. **Wiki search**: `qmd search "tenant isolation"` for related guides

---

## Related Documentation

- [Patterns](patterns.md) — Design patterns to follow
- [Architecture](architecture.md) — System design
- [README](README.md) — Overview and usage
- [API Reference](api.md) — Model and service signatures

---

Navigation: [Documentation Index](index.md) | [README](README.md) | [Patterns](patterns.md)
---
Navigation: [Documentation Index](index.md) | [README](README.md) | [Patterns](patterns.md)
