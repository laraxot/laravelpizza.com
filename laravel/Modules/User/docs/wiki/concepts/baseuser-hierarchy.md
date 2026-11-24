---
title: "BaseUser Hierarchy and Extension Pattern"
type: concept
tags: [user, baseuser, hierarchy, extension, architecture, inheritance]
created: 2026-06-18
updated: 2026-06-18
qmd: "baseuser hierarchy extension pattern user model inheritance"
related:
  - "./ai-harness-user-discipline.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
  - "./folio-pages-owner-pattern.md"
---

# BaseUser Hierarchy and Extension Pattern

## Overview

The User module provides a two-level hierarchy for user models:

1. **BaseUser** (abstract) - Core authentication and authorization
2. **User** (concrete) - Default user implementation

This design allows downstream modules to extend BaseUser while adding their own capabilities.

## Class Hierarchy

```
Illuminate\Foundation\Auth\User (Laravel)
    ↑
Modules\User\Models\BaseUser (abstract - this module)
    ↑
Modules\User\Models\User (concrete - default)
    ↑ (modules can extend)
Modules\Fixcity\Models\User (concrete with comments)
```

## BaseUser Responsibilities

### Core Authentication
- Laravel Authenticatable integration
- Passport OAuth support (`HasApiTokens`)
- MustVerifyEmail contract

### Authorization
- Spatie Permission integration (`HasSpatiePermission`)
- Role-based access control
- Filament panel access (`canAccessPanel()`)

### Multi-Tenancy
- Team support (`HasTeams`)
- Tenant awareness (`HasTenants` trait)

### Media
- Spatie Media Library (`InteractsWithMedia`)
- Profile photo handling

### Utilities
- UUID primary keys (`HasUuids`)
- Authentication logging (`HasAuthenticationLogTrait`)
- Socialite integration (`HasSocialite`)
- Device tracking (`HasDevices`)

## Extension Pattern

### Why Extend BaseUser?

Downstream modules may need to:
- Add module-specific relationships
- Implement contracts from other modules
- Override behavior for domain-specific needs

### Example: Fixcity Extension

```php
namespace Modules\Fixcity\Models;

use Modules\User\Models\BaseUser;
use Modules\Comment\Models\Contracts\CanComment;
use Modules\Comment\Models\Concerns\InteractsWithComments;

class User extends BaseUser implements CanComment
{
    use InteractsWithComments;
    
    // Fixcity-specific configuration
    protected $childTypes = [
        'master_admin' => self::class,
        'backoffice_user' => self::class,
        'customer_user' => self::class,
        'system' => self::class,
        'technician' => self::class,
    ];
}
```

## Critical Design Decision

### User Module Must NOT Depend on Comment Module

The User module is upstream and must remain clean:

```bash
# Verification - should return NO results
grep -r "use Modules\\Comment" laravel/Modules/User/app/
```

This ensures:
1. **No circular dependencies** - Comment can use User, not vice versa
2. **Testability** - User tests don't need Comment module
3. **Deployment flexibility** - User can be deployed without Comment

## Factory Support

BaseUser uses `HasXotFactory` trait for factory resolution:

```php
use Modules\User\Database\Factories\UserFactory;

// In downstream module, override factory
public static function newFactory(): UserFactory
{
    return UserFactory::new();
}
```

## Configuration

### Database Connection

BaseUser defaults to `'user'` connection:

```php
protected $connection = 'user';
```

### Primary Key

UUID-based primary keys:

```php
public $incrementing = false;
protected $primaryKey = 'id';
protected $keyType = 'string';
```

## Related Documentation

- Fixcity User Architecture: `laravel/Modules/Fixcity/docs/wiki/concepts/user-model-architecture.md`
- Comment Contract: `laravel/Modules/Comment/docs/wiki/concepts/can-comment-contract-owner.md`
- Xot Patterns: `laravel/Modules/Xot/docs/wiki/concepts/`
