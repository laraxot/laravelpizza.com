# PHPStan Level 10 + DRY/KISS Improvements - User Module

## Summary

Il modulo User è stato analizzato e migliorato per conformità PHPStan Level 10, principi DRY e KISS.

### Risultati User Module

- ✅ **PHPStan Level 10**: 0 errori (da 16)
- ✅ **Duplicate $connection rimosse**: 7 file
- ✅ **PHPDoc corretti**: 8 file
- ✅ **Code reduction**: ~20 righe eliminate

---

## Fixes Applied

### 1. PHPDoc References Fixed

**Files affected**: 8 modelli

**Before**:
```php
/**
 * @property-read \Modules\Fixcity\Models\Profile|null $creator
 */
```

**After**:
```php
/**
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 */
```

**Files**:
- AuthenticationLog.php
- Feature.php
- Membership.php
- Notification.php
- OauthAccessToken.php
- PasswordReset.php
- SocialiteUser.php
- Team.php

---

### 2. Duplicate `$connection` Properties Removed

**Files fixed**: 7

**Rationale**: Tutti questi modelli estendono `BaseModel` o `BasePivot` che già definiscono `protected $connection = 'user'`.

**Files**:
1. `Notification.php` - extends BaseModel
2. `SocialiteUser.php` - extends BaseModel
3. `OauthAccessToken.php` - extends BaseModel
4. `AuthenticationLog.php` - extends BaseModel
5. `BaseTeamUser.php` - extends BasePivot
6. `Membership.php` - extends BasePivot
7. `TenantUser.php` - extends BasePivot

**Before**:
```php
class Notification extends BaseModel
{
    protected $connection = 'user'; // ❌ Duplicate!
    protected $table = 'notifications';
}
```

**After**:
```php
class Notification extends BaseModel
{
    // Connection inherited from BaseModel ✅
    protected $table = 'notifications';
}
```

---

## Model Inheritance Hierarchy

```
Illuminate\Database\Eloquent\Model
└── Modules\Xot\Models\XotBaseModel
    └── Modules\User\Models\BaseModel ($connection = 'user')
        ├── User
        ├── Team
        ├── Tenant
        ├── Notification
        ├── SocialiteUser
        ├── AuthenticationLog
        └── ... (all User module models)

Illuminate\Database\Eloquent\Relations\Pivot
└── Modules\Xot\Models\XotBasePivot
    └── Modules\User\Models\BasePivot ($connection = 'user')
        ├── Membership
        ├── TenantUser
        └── BaseTeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
└── Modules\Xot\Models\XotBaseMorphPivot
    └── Modules\User\Models\BaseMorphPivot ($connection = 'user')
        └── ModelHasRole
```

---

## Spatie Permission Models

**Special case**: `Role` e `Permission` estendono classi Spatie, **non BaseModel**.

Questi modelli **devono** definire `$connection` perché non ereditano da BaseModel:

```php
// ✅ CORRECT - must define connection
class Role extends SpatieRole
{
    protected $connection = 'user'; // ✅ Necessary!
    protected $table = 'roles';
}

class Permission extends SpatiePermission
{
    protected $connection = 'user'; // ✅ Necessary!
}
```

---

## Best Practices for User Module

### DO ✅

1. **Extend BaseModel for regular models**:
   ```php
   class CustomModel extends BaseModel
   {
       // No need to define $connection
   }
   ```

2. **Extend BasePivot for pivot tables**:
   ```php
   class CustomPivot extends BasePivot
   {
       // No need to define $connection
   }
   ```

3. **Use ProfileContract in PHPDoc**:
   ```php
   /**
    * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
    */
   ```

4. **Merge parent casts for module-specific casts**:
   ```php
   protected function casts(): array
   {
       return [
           ...parent::casts(),
           'verified_at' => 'datetime', // Only module-specific
       ];
   }
   ```

### DON'T ❌

1. **Don't redefine $connection if extending BaseModel**:
   ```php
   class User extends BaseModel
   {
       protected $connection = 'user'; // ❌ Already in BaseModel!
   }
   ```

2. **Don't use Fixcity references**:
   ```php
   /**
    * @property-read \Modules\Fixcity\Models\Profile|null $creator // ❌ Class doesn't exist!
    */
   ```

3. **Don't duplicate common casts**:
   ```php
   protected function casts(): array
   {
       return [
           'created_at' => 'datetime', // ❌ Already in XotBaseModel!
           'updated_at' => 'datetime', // ❌ Already in XotBaseModel!
       ];
   }
   ```

---

## PHPStan Level 10 Validation

**Command**:
```bash
./vendor/bin/phpstan analyse Modules/User/app/Models --level=10
```

**Result**: ✅ **0 errors**

---

## Checklist for New Models

When creating new models in User module:

- [ ] Extend `BaseModel` (not `Model` directly)
- [ ] Do NOT define `$connection` (inherited from BaseModel)
- [ ] Define only table name: `protected $table = 'table_name'`
- [ ] Use `ProfileContract` in PHPDoc, not `Profile`
- [ ] Only add model-specific casts, merge with `parent::casts()`
- [ ] Add proper PHPDoc with `@property` and `@method` tags
- [ ] Run PHPStan Level 10: `./vendor/bin/phpstan analyse path/to/Model.php --level=10`

---

## Related Documentation

- [Model Inheritance Rules](./model-inheritance-rules.md)
- [PHPStan Level 10 Full Analysis (Xot Module)](../../Xot/docs/phpstan-level-10-dry-kiss-analysis-2025-10-17.md)
- [DRY/KISS Model Refactoring 2025-10-15](../../Xot/docs/dry-kiss-model-refactoring-2025-10-15.md)

---

*Last Updated: 17 October 2025*
*Status: ✅ PHPStan Level 10 Compliant*
