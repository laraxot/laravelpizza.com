---
title: "User Module Patterns & Best Practices"
type: guide
tags: [user, patterns, best-practices]
created: 2026-07-28
updated: 2026-07-28
---

# User Module — Patterns & Best Practices

## Authorization Pattern

✅ **Always use policies + gates, never hardcode checks:**
```php
// ✅ GOOD: Policy-based
Gate::authorize('edit-user', $targetUser);
$this->authorize('edit', $targetUser);

// ❌ BAD: Hardcoded
if ($user->id === Auth::id()) { ... }
```

**Where:** app/Policies/UserPolicy.php

## Role Assignment Pattern

✅ **Use role constants, never magic strings:**
```php
const ROLE_ADMIN = 'admin';
const ROLE_EDITOR = 'editor';
const ROLE_VIEWER = 'viewer';

$user->assignRole(self::ROLE_ADMIN);
```

**Why:** Prevents typos, centralizes naming, enables refactoring.

## Multi-Tenancy Pattern

✅ **Use middleware + traits to enforce isolation:**
```php
// Middleware checks X-Tenant-ID or Auth::user()->current_tenant
Route::middleware(['auth', 'tenant'])->group(function () {
    // Queries auto-scoped to tenant
});

// Queries automatically filtered
$users = User::all();  // only current tenant's users
```

## Soft Delete Pattern

✅ **Use soft deletes for audit trail:**
```php
$user->delete();        // soft delete (sets deleted_at)
$user->restore();       // restore from soft delete
$user->forceDelete();   // permanent delete (rare)
```

## Authentication Log Pattern

✅ **Track logins for audit/security:**
```php
use Modules\User\Traits\HasAuthenticationLogTrait;

class User extends BaseModel {
    use HasAuthenticationLogTrait;
}

// Automatically logs login/logout via events
$user->authenticationLogs()->latest()->first();
```

## Action Pattern (Reusable Business Logic)

✅ **Encapsulate logic in Actions, not controllers:**
```php
class CreateUserAction {
    public function execute(array $data): User {
        $user = User::create($data);
        $user->assignRole('viewer');  // default role
        event(new UserCreated($user));
        return $user;
    }
}

// Usage
(new CreateUserAction)->execute($data);
```

## Testing Pattern

✅ **Use factories with states for test data:**
```php
User::factory()
    ->hasTeams(2)
    ->state(['email_verified_at' => now()])
    ->withRole('admin')
    ->count(10)
    ->create();
```

## Common Pitfalls

❌ **Hardcoding table names:**
- Spatie Permission manages table names via `config/permission.php`
- Never: `DB::table('model_has_roles')` → Violates RACI

❌ **Assigning multiple roles via loop:**
```php
// ❌ BAD: N queries
foreach ($roles as $role) {
    $user->assignRole($role);
}

// ✅ GOOD: 1 query
$user->syncRoles($roles);
```

❌ **Checking permissions without context:**
```php
// ❌ BAD: No team/tenant isolation
if ($user->hasPermissionTo('edit-post')) { ... }

// ✅ GOOD: With tenant isolation
Gate::authorize('edit', [$targetUser, $currentTenant]);
```
