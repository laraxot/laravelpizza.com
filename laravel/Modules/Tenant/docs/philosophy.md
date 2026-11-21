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

# Tenant Module: Philosophy, Religion, and The Art of Safe Isolation

**Version:** 2.0  
**Date:** September 2026  
**Status:** Living Document  
**Audience:** Architects, Senior Developers, DevOps, Product Owners

---

title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
## RELIGIONE: The Sacred Dogmas of Multi-Tenancy

Multi-tenancy is not a technical feature—it is a **religious commitment** to certain immutable truths.

### The Four Sacred Covenants

1. **Data Sovereignty is Inviolable**
   - A tenant's data belongs ONLY to that tenant, period.
   - No exceptions. No "small leak for debugging." No "temporary admin access."
   - The moment you break this, you've broken the social contract with your customers.

2. **Isolation Must Be Structural, Not Procedural**
   - Isolation achieved through discipline and code review = fragile
   - Isolation achieved through architecture (connections, databases, schemas) = **rock-solid**
   - We trust the database layer, not the PHP layer, to enforce tenant boundaries

3. **The Tenant Context Must Be Immutable Within a Request**
   - Once a request is routed to a tenant, that binding is permanent
   - No "context switching" during request processing
   - A background job that loses tenant context is a **critical bug**, not a minor issue

4. **Cross-Tenant Data Leakage is a Security Incident**
   - Not a "bug," not a "weird edge case"
   - We treat it like a data breach because it **is** one
   - Every test suite must include cross-tenant isolation verification

### The Heresy

What we **reject** as heresy:

- ❌ Global scopes that "should always be applied" (they won't be)
- ❌ Row-level security via `tenant_id` columns as the primary isolation (too many escape hatches)
- ❌ Caching without tenant keys (cache poisoning across tenants)
- ❌ Shared session/cookie state determining tenant identity (can be hijacked)
- ❌ "The admin should be able to impersonate any tenant" (security theater)

---

## FILOSOFIA: The Conceptual Worldview

### The Architectural Paradigm: Digital Federalism

The Tenant module is built on the principle of **digital federalism**:

- Each tenant is an **autonomous republic** within a larger union
- Central government (the platform) handles infrastructure
- State governments (tenants) manage their own affairs
- Union laws (shared code) apply everywhere, but states have sovereignty over local laws (config)

### Core Philosophical Tenets

**1. Invisibility Through Inevitability**

The best tenant architecture is one you don't notice. When you write business logic:

```php
// This query is ALWAYS tenant-scoped.
// The developer doesn't need to think about it.
User::where('active', true)->get();
```

If the developer has to ask "will this leak data?", the architecture has failed.

**2. Simplicity at Scale**

Multi-tenancy should not make your codebase harder to understand:

- Same models for all tenants (no `TenantAUser`, `TenantBUser`)
- One migration strategy for all (no per-tenant migrations)
- Configuration inheritance, not duplication (default + override)
- Stateless identification (no tenant "session" pollution)

**3. Blast Radius Minimization**

Every architectural decision asks: **"If this fails, does it take down other tenants?"**

- Tenant A's database is down → Tenants B, C, D still work
- Tenant A's configuration is corrupted → Tenants B, C, D unaffected
- Tenant A's background job hangs → Doesn't block other tenants' jobs
- Tenant A hits rate limits → Other tenants have normal speed

**4. Trust the Database, Question the Code**

The primary isolation mechanism is **connection-based**, not code-based:

```php
// Architecture principle:
protected $connection = 'tenant';  // ← This is where isolation lives

// NOT:
// $query->where('tenant_id', auth()->user()->tenant_id);  ← This is mistake-prone
```

The PHP layer *augments* isolation, but the database layer *enforces* it.

### The Three Layers of Isolation

```
┌─────────────────────────────────────────────────┐
│ Layer 1: Domain-Based Routing                   │  ← Where are you coming from?
│ (tenant identified by domain/subdomain)         │
└─────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────┐
│ Layer 2: Connection Resolution                  │  ← Which database?
│ (tenant → database connection mapping)          │
└─────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────┐
│ Layer 3: Model Configuration                    │  ← Which connection?
│ (model uses tenant connection by default)       │
└─────────────────────────────────────────────────┘
```

Each layer is independent. If one fails, the next catches it.

---

## POLITICA: Strategic Decisions and Governance

### The Multi-Tenancy Strategy Decision Tree

We have made explicit choices about HOW to implement multi-tenancy:

#### **Strategy: Separate Database per Tenant (Primary)**

```
Tenant A  →  Database A (isolated host/file)
Tenant B  →  Database B (isolated host/file)
Tenant C  →  Database C (isolated host/file)
```

**Chosen for FixCity because:**
- Maximum isolation (regulatory compliance for healthcare data)
- Compliance with data residency laws
- Independent backup/restore per tenant
- Ability to clone/snapshot individual tenants
- Scaling: add tenants indefinitely without schema changes

**Trade-offs we accept:**
- Higher operational complexity (managing 100 databases)
- Connection pool overhead
- Cross-tenant analytics harder (must federate queries)

**Fallback strategy:** Schema-based separation (multiple schemas in one DB) for lower-volume deployments.

#### **Why NOT Row-Level Security via `tenant_id` column?**

Row-level security (shared DB, tenant_id column filtering) is **theoretically sound but practically dangerous**:

```php
// Looks innocent:
User::where('tenant_id', auth()->user()->tenant_id)->get();

// But escapes are EASY:
DB::statement("SELECT * FROM users WHERE active = true");  // Oops, no tenant filter!

// Cached query can leak:
Cache::remember('active_users', 3600, fn() => User::where('active')->get());  // Wrong tenant!

// Background jobs lose context:
MailNotification::dispatch($user);  // What tenant context does this have?
```

We reject RLS because it requires **discipline and code review on every single query**, forever. Humans will mess up. **Architecture should make the right thing automatic.**

### The Configuration Inheritance Model

```
┌─ config/app.php (global default)
│  └─ name: 'FixCity'
│     locale: 'en'
│     timezone: 'UTC'
│
├─ config/tenant_acme/app.php (tenant override)
│  └─ name: 'ACME Corp'  ← overrides global
│
↓ RESULT FOR TENANT ACME:
{
  name: 'ACME Corp',      ← from tenant config
  locale: 'en',           ← from global (no override)
  timezone: 'UTC'         ← from global (no override)
}
```

**Not a database**, not in Redis—this is **file-system based config**.

Why? Because:
- ✅ Survives restarts (not ephemeral)
- ✅ Version-controllable (track config history)
- ✅ No database dependency for platform config
- ✅ Fast (file I/O, not network)

### Access Control Governance

```
┌─ Super Admin (Platform Owner)
│  └─ Can: create/delete tenants, global config, audit logs, emergency access
│
├─ Tenant Owner (Tenant Admin)
│  └─ Can: manage tenant users, customize tenant config, view own audit logs
│  └─ Cannot: access other tenants, see other tenant configs
│
└─ Tenant User (Regular User)
   └─ Can: perform business logic within their tenant
   └─ Cannot: access admin features, see other users from other tenants
```

**Critical principle:** Tenant isolation is **automatic**, not policy-based. Even if a user somehow got super-admin credentials, the connection layer still isolates them to their tenant context.

---

## SCOPO: What This Module Does (and Doesn't Do)

### In Scope: Core Responsibilities

1. **Multi-Tenant Identification & Routing**
   - Identify tenant from domain/subdomain
   - Route connection to correct database
   - Resolve tenant context for request

2. **Tenant Data Management**
   - Create/update/delete tenants
   - Manage tenant metadata (name, domain, logo, contact info)
   - Track last activity, subscription status

3. **Domain Management**
   - Map domains to tenants
   - Support multi-domain per tenant (one tenant, many domains)
   - Sushi-based in-memory model (no database required)

4. **Subscription Tracking**
   - Track plan name, status, max users, storage quotas
   - Billing information
   - Expiration/renewal dates

5. **Configuration Segregation**
   - Per-tenant config files
   - Config inheritance and override
   - TenantService facade for accessing config

### Out of Scope: What This Module Does NOT Handle

1. ❌ **User Management**
   - User module handles authentication
   - Tenant module only provides isolation context

2. ❌ **Business Logic**
   - Patient models, Appointment scheduling, etc.
   - Tenant module is infrastructure, not domain logic

3. ❌ **Payment Processing**
   - We track subscription data, but don't process payments
   - Integrate Stripe/PayPal at the Business layer

4. ❌ **Per-Tenant Feature Flags**
   - Use Laravel Pennant for this (separate module)
   - Tenant module provides only data storage

5. ❌ **Data Migration Between Tenants**
   - Tenant A can't "merge" with Tenant B at the framework level
   - Would require custom business logic (if allowed at all)

6. ❌ **Compliance/Audit Trail Storage**
   - Activity Log module handles that
   - Tenant module helps route audit events to correct DB

---

## ZEN: The Art of Effortless Isolation

Zen is about **doing the right thing automatically**, without the developer thinking about it.

### The Three Principles of Zen

**1. Silence is Golden**

The best code is code you don't have to write:

```php
// ✨ PERFECT (requires no thought about tenants)
class UserController {
    public function index() {
        return User::all();  // Automatically tenant-scoped
    }
}

// ❌ WRONG (constantly thinking about tenant_id)
class UserController {
    public function index() {
        return User::where('tenant_id', auth()->user()->tenant_id)->get();
    }
}
```

**2. The Invisible Handmaid**

Isolation should work like gravity—always present, never noticed:

```php
// These all work correctly WITHOUT any tenant awareness:

Task::create(['title' => 'New task']);           // saved to tenant's DB
Task::where('status', 'open')->count();         // counts only tenant's tasks
Cache::remember('stats', 3600, fn() => ...);    // would need manual tenant key (one leak point)
Event::dispatch(new TaskCreated($task));        // background job still in tenant context
```

**3. The Paradox of Control**

Maximum isolation with minimum friction:

- You can't accidentally leak data (architecture prevents it)
- You can't accidentally switch tenants mid-request (connection binds it)
- You CAN'T "just bypass" the isolation (would have to explicitly change connection)

### Practical Zen: The Checklist

Does your Tenant implementation embody zen? Check:

- [ ] A developer writing business code never types `tenant_id`
- [ ] Tests pass for multiple tenants without extra setup
- [ ] Changing tenant is impossible mid-request (not just "discouraged")
- [ ] Configuration changes don't require code deployment
- [ ] New modules automatically tenant-scoped without modification
- [ ] Failed requests in one tenant don't crash others
- [ ] No "tenant switching" UI or manual context management needed

---

## LIBRERIE DA INSTALLARE: Required and Recommended Packages

### Already Included (We Don't Use These)

The FixCity stack **explicitly does NOT use**:

- ❌ **`stancil/tenancy`** - Too opinionated, assumes shared database
- ❌ **`spatie/laravel-tenancy`** - Excellent but adds abstractions we don't need
- ❌ **`laravel-tenancy/*`** - Good but overlaps with our connection-based approach

### Why We Use Our Own

We built a **custom connection-based isolation** because:

1. **Spatie Tenancy** assumes shared database + global scopes
2. **Stancil** is oriented toward SaaS with row-level scoping
3. Both add abstraction layers we don't need
4. Our approach is simpler and auditable for healthcare compliance

### Required Packages (Already in composer.json)

```
laravel/framework      ^12  ← routing, eloquent, config
sushi/sushi           *     ← in-memory models (Domain)
laravel/passport      ^12   ← authentication (optional)
nwidart/laravel-modules   ← modular architecture
filament/filament     ^5    ← admin panel
```

### Recommended Additions (If You Want Them)

```json
{
  "require": {
    "spatie/laravel-activitylog": "^4",  // for audit trails
    "laravel/pennant": "^1",             // for feature flags per tenant
    "predis/predis": "^2",               // for Redis caching (tenant-aware keys)
    "maatwebsite/excel": "^3"            // for tenant data export
  }
}
```

### NOT Recommended (We Avoid These)

```json
{
  "spatie/laravel-tenancy": "NOT USED - we use connections instead",
  "stancil/tenancy": "NOT USED - too opinionated for our needs",
  "laravel/fortify": "Use Filament instead for admin auth"
}
```

---

## FUTURE IMPLEMENTAZIONI: The Roadmap

### Phase 1: Foundation (COMPLETE ✓)
- [x] Tenant CRUD operations
- [x] Domain management
- [x] Database connection routing
- [x] Configuration inheritance
- [x] Filament admin resources
- [x] TenantService facade

### Phase 2: Enterprise Features (IN PROGRESS)

**2.1 Subscription & Billing**
- [ ] Usage tracking (API calls, storage, users)
- [ ] Quota enforcement (max users, storage limits)
- [ ] Graceful degradation when quotas exceeded
- [ ] Stripe/Paddle integration for billing

**2.2 Advanced Isolation**
- [ ] Per-tenant Redis isolation
- [ ] Per-tenant queue isolation
- [ ] Per-tenant cache segregation
- [ ] Per-tenant session management

**2.3 Compliance & Audit**
- [ ] Immutable audit logs per tenant
- [ ] GDPR data export endpoint
- [ ] Right to be forgotten implementation
- [ ] SOC2 compliance tracking

**2.4 Migration & Portability**
- [ ] Tenant data export (full DB dump)
- [ ] Tenant data import (restore from dump)
- [ ] Cross-server tenant migration
- [ ] Schema versioning per tenant

### Phase 3: Advanced Scaling (FUTURE)

- [ ] Geographic distribution (tenant data in specific regions)
- [ ] Database sharding across multiple hosts
- [ ] Tenant clustering (group related tenants)
- [ ] Real-time replication for disaster recovery
- [ ] Cross-datacenter failover

### Phase 4: AI & Automation (SPECULATIVE)

- [ ] ML-based anomaly detection (unusual tenant behavior)
- [ ] Auto-scaling based on tenant load
- [ ] Smart database optimization per tenant
- [ ] Predictive quota management

---

## COMPETITORS & INSPIRATIONS: The Landscape

### Academic Competitors

#### Spatie Tenancy (`spatie/laravel-tenancy`)
**What they do well:**
- Comprehensive middleware-based tenant identification
- Support for multiple databases AND schemas
- Excellent documentation
- Handles sub-domain routing elegantly

**Why we didn't choose it:**
- Adds an abstraction layer (Tenant resolver) we don't need
- Assumes global scopes for row-level isolation (not our model)
- Heavier than our connection-based approach
- Fine-grained control over middleware makes debugging harder

**When to use instead of us:**
- You need shared database with row-level security
- You want an off-the-shelf, battle-tested solution
- You don't want to build custom infrastructure

#### Stancil (`stancil/tenancy`)
**What they do well:**
- Purpose-built for SaaS
- Clean API for tenant management
- Good documentation

**Why we didn't choose it:**
- Assumes shared schema (database/schema, not separate databases)
- Oriented toward consumer SaaS, not healthcare
- Less control over connection routing

**When to use instead of us:**
- You need a managed SaaS solution
- You don't care about per-tenant databases
- You want vendor support

#### Landlord (`hootlex/laravel-landlord`)
**What they do well:**
- Lightweight tenant identification
- Uses Eloquent global scopes (simple)

**Why we didn't choose it:**
- Global scopes are fragile (can be bypassed)
- No connection-level isolation
- Minimal active development

**When to use instead of us:**
- You have 5-10 tenants max
- You can trust your team to never make mistakes
- You need the lightest possible overhead

### Inspirations We Draw From

1. **Shopify's Platform Architecture**
   - Lesson: "Isolated stores" model scales infinitely
   - We borrowed: blast radius containment

2. **AWS Account Isolation Model**
   - Lesson: isolation at the infrastructure level is unbreakable
   - We borrowed: connection-based boundaries (analogous to AWS networking)

3. **GitLab's Multi-Tenancy Approach**
   - Lesson: you can mix single-tenant and multi-tenant in same codebase
   - We borrowed: optional per-tenant databases

4. **Healthcare Data Compliance (HIPAA/GDPR)**
   - Lesson: isolation is a compliance requirement, not a feature
   - We borrowed: immutable audit logs, data residency options

---

## BEST PRACTICES: How to Do It Right

### 1. Query Safety

```php
// ✅ GOOD: Automatic tenant scoping via connection
class Task extends BaseModel {
    // inherits protected $connection = 'tenant' from BaseModel
}

// Result: Task::all() is automatically tenant-scoped
```

**Rules:**
- [ ] All multi-tenant models inherit from `BaseModel`
- [ ] Never override connection unless you have a reason
- [ ] Never use `DB::statement()` directly
- [ ] Always use Eloquent for multi-tenant queries

### 2. Cache Invalidation

```php
// ✅ GOOD: Tenant-aware cache keys
$cacheKey = "tenant:{$tenantId}:dashboard_stats";
Cache::remember($cacheKey, 3600, function() {
    return DashboardStats::calculate();
});

// ❌ BAD: Generic key (cache collision)
Cache::remember('dashboard_stats', 3600, function() {
    return DashboardStats::calculate();  // WRONG!
});
```

**Rules:**
- [ ] All cache keys include tenant identifier
- [ ] Use `TenantService::getName()` to get current tenant
- [ ] Clear cache on tenant config changes
- [ ] Test cache isolation in test suite

### 3. Background Jobs

```php
// ✅ GOOD: Pass tenant explicitly
public function handle() {
    TenantContext::asTenant($this->tenant, function() {
        $user = User::find($this->userId);  // Scoped to correct tenant
        Mail::send(...);
    });
}

// ❌ BAD: Lose tenant context
public function handle() {
    $user = User::find($this->userId);  // Which tenant?
    Mail::send(...);
}
```

**Rules:**
- [ ] Jobs must accept and store tenant explicitly
- [ ] Use `TenantContext::asTenant()` wrapper
- [ ] Test jobs with multiple tenants
- [ ] Never assume current tenant in async context

### 4. Authentication

```php
// ✅ GOOD: Tenant from domain, not session
public function middleware() {
    return [
        'web',
        \Illuminate\Session\Middleware\StartSession::class,
        \Modules\Tenant\Http\Middleware\ResolveTenantFromDomain::class,  // Tenant from domain
    ];
}

// ❌ BAD: Tenant from session (can be hijacked)
$tenant = session('tenant_id');  // What if session is wrong?
```

**Rules:**
- [ ] Identify tenant from domain, headers, or routing—NOT session
- [ ] Verify user's tenant matches request tenant
- [ ] Use route model binding for tenant scoping
- [ ] Test with wrong session/wrong domain combinations

### 5. Testing Isolation

```php
// ✅ GOOD: Multi-tenant test
test('users are isolated by tenant', function() {
    $tenant1 = Tenant::factory()->create();
    $tenant2 = Tenant::factory()->create();
    
    $user1 = TenantContext::asTenant($tenant1, fn() => User::factory()->create());
    $user2 = TenantContext::asTenant($tenant2, fn() => User::factory()->create());
    
    // Verify isolation
    TenantContext::asTenant($tenant1, function() {
        expect(User::count())->toBe(1);  // Only one user in tenant1
        expect(User::first()->id)->toBe($user1->id);
    });
});
```

**Rules:**
- [ ] Write tests with 2+ tenants
- [ ] Verify data doesn't leak
- [ ] Test query scoping explicitly
- [ ] Test cache isolation
- [ ] Test async job tenant context

---

## BAD PRACTICES: How to Break It (And Why)

### Anti-Pattern 1: The Global Scope Trap

```php
// ❌ WRONG: Thinking a global scope is "enough"
class User extends BaseModel {
    protected static function booted() {
        static::addGlobalScope('tenant', function ($query) {
            $query->where('tenant_id', auth()->user()->tenant_id);
        });
    }
}

// This will FAIL when:
$users = DB::table('users')->get();  // Bypasses Eloquent, no scope applied!
$users = User::withoutGlobalScopes()->get();  // Oops, leaked all users
$users = User::on('default')->get();  // Changed connection, lost scope
```

**Why it breaks:**
- Global scopes are PHP-level, not database-level
- Can be bypassed intentionally or accidentally
- Testing becomes false-positive (passes in test, fails in prod)

**Solution:** Use connection-level isolation, not query-level.

### Anti-Pattern 2: The Cache Collision

```php
// ❌ WRONG: Shared cache key
$settings = Cache::remember('settings', 3600, fn() => 
    Setting::first()
);

// Tenant A caches settings, Tenant B reads same cache
// Tenant B gets Tenant A's settings. DISASTER.
```

**Why it breaks:**
- Cache is global, not tenant-aware
- Different databases don't help (cache layer is shared)
- Hard to debug (works in dev, breaks in production with 2+ tenants)

**Solution:**
```php
// ✅ GOOD: Tenant-aware cache key
$cacheKey = "tenant:" . TenantService::getName() . ":settings";
$settings = Cache::remember($cacheKey, 3600, fn() => Setting::first());
```

### Anti-Pattern 3: The Async Context Loss

```php
// ❌ WRONG: Background job loses tenant
public class SendNotificationJob {
    public function __construct(public Notification $notification) {}
    
    public function handle() {
        // What tenant are we in? Nobody knows!
        Notification::send($this->notification);
    }
}

// Queue picks up job, no tenant context set
// User model queries in default connection
// Might fetch user from wrong tenant
```

**Why it breaks:**
- Background jobs run outside request context
- No request domain to identify tenant
- Silent failures (wrong user data, no error)

**Solution:**
```php
// ✅ GOOD: Pass tenant explicitly
public class SendNotificationJob {
    public function __construct(
        public Notification $notification,
        public Tenant $tenant  // ← explicit
    ) {}
    
    public function handle() {
        TenantContext::asTenant($this->tenant, function() {
            Notification::send($this->notification);
        });
    }
}
```

### Anti-Pattern 4: The Configuration Hardcoding

```php
// ❌ WRONG: Configuration from environment
$logo = env('APP_LOGO');  // All tenants get same logo!

// ✅ GOOD: Configuration from tenant settings
$logo = TenantService::config('app.logo', 'default.png');
```

**Why it breaks:**
- Environment variables are global
- Can't customize per tenant
- Defeats purpose of multi-tenancy

### Anti-Pattern 5: The Shared Session State

```php
// ❌ WRONG: Storing tenant in session
session(['tenant_id' => $tenantId]);  // Can be hijacked!

// Attack scenario:
// 1. Attacker logs in as user in Tenant A
// 2. Attacker guesses/forges session cookie for Tenant B
// 3. Attacker now sees Tenant B's data
```

**Why it breaks:**
- Sessions can be tampered with
- No cryptographic binding to domain
- Violates "identify tenant from domain" principle

**Solution:** Always identify tenant from domain/headers, verify it matches auth user's tenant.

---

## FALSE FRIENDS: Subtle Gotchas

### False Friend 1: "The Database.connection = 'tenant' Setting"

```php
protected $connection = 'tenant';

// This looks like it isolates... but does it?
// Only if the 'tenant' connection is correctly routed to the right DB.
// If connection resolution fails, you're suddenly using 'default' connection!
```

**Watch out for:**
- Connection caching returning wrong DB
- Middleware not setting up connection before queries
- Testing with same database for all tenants (hides bugs)

**Safety check:**
```php
public function test_connection_isolation() {
    expect(DB::connection('tenant')->getDatabaseName())
        ->toBe('tenant_acme_db');  // Not default!
}
```

### False Friend 2: "The Tenant::factory() Call"

```php
// Looks safe:
Tenant::factory()->create();

// But creates it in which database?
// If you don't have a 'system' connection for Tenant table itself,
// it might create in the 'tenant' connection!
```

**Watch out for:**
- Tenant model using 'tenant' connection (infinite loop)
- Tenant model needs to use 'default'/'system' connection
- Factory assumptions about which DB to use

**Safety check:**
```php
class Tenant extends BaseModel {
    protected $connection = 'default';  // NOT 'tenant'!
}
```

### False Friend 3: "The TenantService::config() Cache"

```php
// This caches config per-request:
TenantService::config('app.name');

// But what if you call it in a queue job?
// The tenant context might be different
// Config might be cached from wrong tenant!
```

**Watch out for:**
- Configuration caching across contexts
- Clearing cache when tenant config changes
- Testing with cache enabled vs disabled

### False Friend 4: "The test() Helper with Migrations"

```php
test('...', function() {
    // This runs migrations in 'testing' database
    // But if your models use 'tenant' connection,
    // where do the tables live?
})->with('sqlite:memory:');  // This is 'default', not 'tenant'!
```

**Watch out for:**
- Testing creates data in default DB
- Models query from tenant connection
- Test passes (data in right connection) but assertions fail

**Solution:**
```php
// Create multiple in-memory databases for testing
beforeEach(function() {
    migrate(['database' => 'default']);    // Tenant.php table
    migrate(['database' => 'tenant']);     // User, Task tables
});
```

### False Friend 5: "The Domain::query() Sushi Model"

```php
class Domain extends BaseModel {
    use Sushi;  // ← In-memory, no database
    
    public function getRows() {
        return app(GetDomainsArrayAction::class)->execute();
    }
}

// This doesn't persist. If you do:
Domain::create(['name' => 'new.com']);  // ← Where does this go?
// Answer: Nowhere. Sushi models are read-only.
```

**Watch out for:**
- Trying to persist changes to Sushi models
- Forgetting that Domain is configuration, not data
- Tests that expect Domain::factory()->create() to persist

---

## COME USARLO: Practical Usage Patterns

### Creating a New Tenant

```php
// ✅ Step 1: Create tenant record
$tenant = Tenant::create([
    'name' => 'ACME Corporation',
    'domain' => 'acme.fixcity.local',
    'slug' => 'acme',
    'email' => 'admin@acme.com',
    'is_active' => true,
]);

// ✅ Step 2: Create database (if using separate DB strategy)
$dbName = "fixcity_acme_{$tenant->id}";
DB::statement("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// ✅ Step 3: Run migrations for tenant
TenantContext::asTenant($tenant, function() {
    Artisan::call('migrate', ['--database' => 'tenant']);
});

// ✅ Step 4: Seed initial data (if needed)
TenantContext::asTenant($tenant, function() {
    Artisan::call('db:seed', ['--class' => 'TenantSeeder']);
});

// ✅ Step 5: Create tenant admin user
TenantContext::asTenant($tenant, function() {
    $admin = User::create([
        'name' => 'ACME Admin',
        'email' => 'admin@acme.com',
        'password' => Hash::make('temporary-password'),
        'tenant_id' => $tenant->id,
    ]);
    
    // Assign admin role
    $admin->assignRole('admin');
});
```

### Accessing Tenant Data

```php
// ✅ From HTTP request (tenant identified by domain)
Route::get('/users', function() {
    // Middleware already set up TenantContext
    // All queries automatically scoped
    $users = User::all();  // Only this tenant's users
});

// ✅ In console command (manually set context)
Artisan::command('tenant:sync {tenantId}', function() {
    $tenant = Tenant::find($this->argument('tenantId'));
    
    TenantContext::asTenant($tenant, function() {
        $users = User::all();  // Synced for this tenant only
    });
});

// ✅ In queue job (pass tenant explicitly)
class ProcessTenantData implements ShouldQueue {
    public function __construct(public Tenant $tenant) {}
    
    public function handle() {
        TenantContext::asTenant($this->tenant, function() {
            $data = Task::all();  // Processed for this tenant only
        });
    }
}
```

### Switching Tenant Context (Dangerous!)

```php
// ⚠️ ONLY in console commands or admin operations
// NEVER in user-facing requests

$currentTenant = app('tenant');  // Get current
$otherTenant = Tenant::find(2);

try {
    TenantContext::asTenant($otherTenant, function() {
        // Operations here are in $otherTenant context
        User::create(['name' => 'New User']);  // Created in otherTenant
    });
} finally {
    // Context restored automatically
    expect(app('tenant')->id)->toBe($currentTenant->id);
}
```

### Testing with Multiple Tenants

```php
test('users are isolated by tenant', function() {
    // Create two independent tenants
    $tenant1 = Tenant::factory()->create(['name' => 'Tenant 1']);
    $tenant2 = Tenant::factory()->create(['name' => 'Tenant 2']);
    
    // Create user in tenant1
    $user1 = TenantContext::asTenant($tenant1, fn() => 
        User::factory()->create(['name' => 'Alice'])
    );
    
    // Create user in tenant2
    $user2 = TenantContext::asTenant($tenant2, fn() => 
        User::factory()->create(['name' => 'Bob'])
    );
    
    // Verify isolation: tenant1 sees only Alice
    TenantContext::asTenant($tenant1, function() {
        expect(User::count())->toBe(1);
        expect(User::first()->name)->toBe('Alice');
    });
    
    // Verify isolation: tenant2 sees only Bob
    TenantContext::asTenant($tenant2, function() {
        expect(User::count())->toBe(1);
        expect(User::first()->name)->toBe('Bob');
    });
});
```

---

## COME INSTALLARLO: Setup and Configuration

### 1. Prerequisites

```bash
# Ensure you have Laravel 13+ and the Modular architecture
composer require laravel/framework:"^12"
composer require nwidart/laravel-modules

# For database connections
composer require predis/predis  # For Redis (optional but recommended)
```

### 2. Database Setup (Separate Database per Tenant)

```php
// config/database.php
return [
    'default' => 'mysql',
    
    'connections' => [
        // System database (Tenant table lives here)
        'default' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'fixcity_system'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD'),
        ],
        
        // Tenant databases (dynamically resolved at runtime)
        'tenant' => [
            'driver' => 'mysql',
            'host' => env('TENANT_DB_HOST', 'localhost'),
            'database' => env('TENANT_DB_NAME', 'fixcity_tenant'),
            'username' => env('TENANT_DB_USERNAME', 'root'),
            'password' => env('TENANT_DB_PASSWORD'),
        ],
    ],
];
```

### 3. Create Tenant Table

```bash
# Create migration
php artisan make:migration create_tenants_table --create=tenants

# In migration:
Schema::create('tenants', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('domain')->unique();
    $table->string('database')->nullable();
    $table->json('settings')->nullable();
    $table->boolean('is_active')->default(true);
    $table->dateTime('last_activity_at')->nullable();
    $table->string('logo')->nullable();
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->string('city')->nullable();
    $table->string('postal_code')->nullable();
    $table->string('province')->nullable();
    $table->string('country')->nullable();
    $table->string('tax_code')->nullable();
    $table->string('vat_number')->nullable();
    $table->timestamps();
    
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
});

php artisan migrate
```

### 4. Middleware Setup

```php
// bootstrap/app.php
return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \Modules\Tenant\Http\Middleware\ResolveTenantFromDomain::class,
        ]);
    });
```

### 5. Configure Models

```php
// Modules/Tenant/app/Models/BaseModel.php
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    protected $connection = 'tenant';  // ← All tenant models use this
}

// Ensure Tenant model uses 'default' connection
class Tenant extends Model {
    protected $connection = 'default';  // ← NOT 'tenant'
}
```

### 6. Environment Configuration

```env
# .env
DB_HOST=localhost
DB_DATABASE=fixcity_system
DB_USERNAME=root
DB_PASSWORD=secret

TENANT_DB_HOST=localhost
TENANT_DB_NAME=fixcity_tenant  # Placeholder, actual DB per tenant
TENANT_DB_USERNAME=root
TENANT_DB_PASSWORD=secret

# For separate databases per tenant:
TENANT_DB_STRATEGY=separate  # or 'schema' for multiple schemas
```

### 7. Test Configuration

```php
// phpunit.xml or tests/TestCase.php
protected function setUp(): void {
    parent::setUp();
    
    // Create separate testing database for tenant data
    config(['database.connections.tenant.database' => 'fixcity_test_tenant']);
    
    // Run migrations on both databases
    $this->artisan('migrate', [
        '--database' => 'default',
        '--env' => 'testing',
    ])->run();
    
    $this->artisan('migrate', [
        '--database' => 'tenant',
        '--env' => 'testing',
    ])->run();
}
```

### 8. Filament Admin Setup (Optional)

```bash
# Generate Filament resources
php artisan make:filament-resource Tenant
php artisan make:filament-resource Domain
php artisan make:filament-resource TenantSubscription
```

---

## COVERAGE ANALYSIS: Testing the Isolation

### What To Test

#### 1. Data Isolation Tests (CRITICAL)

```php
test('tenant A cannot see tenant B data', function() {
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();
    
    // Create user in tenant A
    TenantContext::asTenant($tenantA, fn() => 
        User::factory()->create(['name' => 'Alice'])
    );
    
    // Create user in tenant B  
    TenantContext::asTenant($tenantB, fn() => 
        User::factory()->create(['name' => 'Bob'])
    );
    
    // Verify: tenant A sees only Alice
    TenantContext::asTenant($tenantA, function() {
        $users = User::all();
        expect($users->count())->toBe(1);
        expect($users->first()->name)->toBe('Alice');
    });
    
    // Verify: tenant B sees only Bob
    TenantContext::asTenant($tenantB, function() {
        $users = User::all();
        expect($users->count())->toBe(1);
        expect($users->first()->name)->toBe('Bob');
    });
});
```

#### 2. Cache Isolation Tests

```php
test('cache is isolated per tenant', function() {
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();
    
    TenantContext::asTenant($tenantA, function() {
        Cache::put('key', 'value_A');
    });
    
    TenantContext::asTenant($tenantB, function() {
        Cache::put('key', 'value_B');
    });
    
    TenantContext::asTenant($tenantA, function() {
        expect(Cache::get('key'))->toBe('value_A');  // Not value_B!
    });
});
```

#### 3. Query Bypass Tests

```php
test('raw queries are not isolation-enforced (expected failure)', function() {
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();
    
    TenantContext::asTenant($tenantA, fn() => 
        User::factory()->create(['name' => 'Alice'])
    );
    
    TenantContext::asTenant($tenantB, function() {
        // ⚠️ Raw query can escape isolation
        $users = DB::select('SELECT * FROM users');
        
        // This will see Alice! Raw queries bypass Eloquent
        expect(count($users))->toBeGreaterThan(1);
    });
})->todo('Raw queries bypass isolation—use Eloquent always');
```

#### 4. Background Job Tests

```php
test('background jobs maintain tenant context', function() {
    $tenantA = Tenant::factory()->create();
    $user = TenantContext::asTenant($tenantA, fn() => 
        User::factory()->create()
    );
    
    // Dispatch job
    SendNotification::dispatch($user, $tenantA);
    
    // Job processes in correct tenant
    Bus::assertDispatched(SendNotification::class);
    
    // Verify job ran with correct tenant context
    Queue::fake();
    SendNotification::dispatch($user, $tenantA)->onQueue('default');
    
    // When job runs:
    $job = new SendNotification($user, $tenantA);
    $job->handle();  // Should use tenantA connection
});
```

#### 5. Authentication Tests

```php
test('user cannot access other tenant via URL', function() {
    $tenantA = Tenant::factory()->create(['domain' => 'a.local']);
    $tenantB = Tenant::factory()->create(['domain' => 'b.local']);
    
    $userA = TenantContext::asTenant($tenantA, fn() => 
        User::factory()->create()
    );
    
    $userB = TenantContext::asTenant($tenantB, fn() => 
        User::factory()->create()
    );
    
    // User A logs in to a.local
    $this->actingAs($userA)->get('http://a.local/dashboard')
        ->assertSuccessful();
    
    // User A tries to access b.local (should fail or see their own data)
    $this->actingAs($userA)->get('http://b.local/dashboard')
        ->assertForbidden();  // or redirect to login
});
```

### Coverage Checklist

- [ ] Data isolation (2+ tenants, verify no leakage)
- [ ] Cache isolation (separate keys per tenant)
- [ ] Database connection routing (correct DB for each tenant)
- [ ] Configuration inheritance (override + merge)
- [ ] Background jobs (maintain tenant context)
- [ ] Authentication (user can't access other tenant)
- [ ] Query scoping (Eloquent models auto-scoped)
- [ ] Async context loss (detect if job loses context)
- [ ] Cache poisoning (multi-tenant cache keying)
- [ ] Raw query bypasses (document, don't use)

### Recommended Test Coverage Threshold

- Overall: **≥90%** (including edge cases)
- Isolation-specific: **100%** (no isolation bugs)
- Cache/async: **100%** (these are subtle)

---

## CONCLUSION: The Philosophy in Practice

The Tenant module is a **philosophical stance** on how multi-tenancy should work:

1. **Simple**: 3 tables, 1 service facade, connection-based isolation
2. **Safe**: Isolation at the database layer, not the code layer
3. **Scalable**: From 1 tenant to infinite tenants, no architectural changes
4. **Transparent**: Developers write code once, it works for all tenants
5. **Auditable**: Every operation is traceable to a tenant

This is **not** a library you install and forget. This is **infrastructure you must understand**, test thoroughly, and monitor constantly. A multi-tenancy breach is a data breach affecting all your customers.

**When implemented correctly, the Tenant module is invisible.** The developer doesn't think about tenants. The queries are isolated. The caches are separate. The data is safe.

That is the **Zen** of multi-tenancy.

---

**Status:** Production-Ready Foundation  
**Last Updated:** September 2026  
**Maintainer:** FixCity Engineering Team  
**Version:** 2.0
