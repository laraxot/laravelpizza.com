# Policy Hierarchy in Laraxot

> Documentation of the policy inheritance architecture and usage guidelines

---

## Overview

Laraxot uses a two-tier policy architecture:

```
XotBasePolicy (Modules/Xot)           ← Foundation
    ↑
UserBasePolicy (Modules/User)         ← Application Layer
    ↑
ActivityPolicy, CmsPolicy, etc.       ← Domain Specific
```

---

## Base Policy Classes

### 1. XotBasePolicy (Foundation)

**Location**: `laravel/Modules/Xot/app/Models/Policies/XotBasePolicy.php`

**Purpose**: 
- Provides framework-level authorization primitives
- Defines common policy methods (viewAny, view, create, update, delete, restore, forceDelete)
- Contains no user-specific logic
- Can be used for non-user entities (system processes, API keys, etc.)

**When to Extend**:
- Policies for entities without user authentication context
- System-level policies (cron jobs, queue workers)
- API token-based authorization
- When you need minimal policy structure without User module coupling

### 2. UserBasePolicy (Application Layer)

**Location**: `laravel/Modules/User/app/Models/Policies/UserBasePolicy.php`

**Purpose**:
- Extends XotBasePolicy
- Integrates with `spatie/laravel-permission`
- Uses `UserContract` for type-safe user resolution
- Provides permission-based authorization via `hasPermissionTo()`

**When to Extend**:
- Most domain policies (default choice)
- User-authenticated resource access
- Permission-based authorization required
- When you need Spatie permission integration

---

## Decision Matrix

| Scenario | Extend | Rationale |
|----------|--------|-----------|
| Standard user resource | `UserBasePolicy` | Spatie permissions + user context |
| System/internal entity | `XotBasePolicy` | No user dependency |
| API-only resource | `XotBasePolicy` | Token-based, no user model |
| Multi-tenant with roles | `UserBasePolicy` | Permissions + tenant scoping |
| Queue/Job policy | `XotBasePolicy` | System context, no user |

---

## Usage Patterns

### Standard Pattern (UserBasePolicy)

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Models\Policies;

use Modules\User\Models\Policies\UserBasePolicy;
use Modules\Xot\Contracts\UserContract;

class ActivityPolicy extends UserBasePolicy
{
    public function view(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.view');
    }

    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.create');
    }

    public function update(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.update');
    }

    public function delete(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.delete');
    }
}
```

### System Process Pattern (XotBasePolicy)

```php
<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;

class JobSchedulePolicy extends XotBasePolicy
{
    // No user context - system-level authorization
    public function execute(?UserContract $user = null): bool
    {
        // System cron - no user required
        return $user === null || $user->hasRole('system');
    }
}
```

---

## Separation of Concerns

### Why Keep Both?

**UserBasePolicy ≠ XotBasePolicy** for these reasons:

1. **Dependency Isolation**
   - `UserBasePolicy` depends on `spatie/laravel-permission`
   - `XotBasePolicy` has zero external dependencies
   - Xot module remains lightweight

2. **Contract Clarity**
   - `UserContract` in UserBasePolicy implies user context required
   - XotBasePolicy allows null/optional user for system processes

3. **Module Boundaries**
   - Xot = Foundation (no business logic)
   - User = Application layer (business rules, permissions)

4. **Testing Flexibility**
   - XotBasePolicy tests don't need User module loaded
   - UserBasePolicy tests require full permission setup

---

## Improvements & Additions

### Suggested Enhancements

1. **XotBasePolicy Additions**
   - Add `before()` hook for global authorization checks
   - Add `after()` hook for audit logging
   - Add `scope()` method for query scoping

2. **UserBasePolicy Additions**
   - Add `canAny()` for multiple permission check
   - Add `canAll()` for all-permissions-required check
   - Add `withTenant()` for multi-tenant scoping

3. **Documentation**
   - Add PHPDoc examples for each method
   - Document permission naming conventions
   - Add policy testing examples

### Best Practices

1. **Always type-hint UserContract**
   ```php
   public function view(UserContract $user): bool
   ```

2. **Use permission dot notation**
   ```php
   'activity.view'      // resource.action
   'activity.viewAny'   // resource.actionAny
   ```

3. **Comment out unused methods**
   ```php
   // public function viewAny(UserContract $user): bool
   // {
   //     return $user->hasPermissionTo('activity.viewAny');
   // }
   ```

4. **Test with real permissions**
   ```php
   // In tests
   $user->givePermissionTo('activity.view');
   $this->assertTrue($policy->view($user));
   ```

---

## Related Documentation

- [Spatie Permission Integration](./spatie-permission-integration.md)
- [UserContract Type Safety](./user-contract-type-safety.md)
- [Multi-Tenant Authorization](./multi-tenant-authorization.md)
- [Testing Policies](./testing-policies.md)

---

**Status**: Discussion Document  
**Created**: 2026-04-27  
**Module**: User / Xot  
**Tags**: authorization, policies, architecture, spatie-permission
