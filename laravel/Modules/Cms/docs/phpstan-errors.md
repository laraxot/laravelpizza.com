# PHPStan Errors - Cms Module

**Date**: [DATE]
**PHPStan Level**: 10
**Total Errors in Module**: ~15

## Summary of Errors

| File | Error Count | Severity |
|------|-------------|----------|
| app/Http/View/Composers/XotComposer.php | 1 | Medium |
| app/Http/Volt/VerifyComponent.php | 2 | High |
| app/Models/Conf.php | 1 | Medium |
| app/Models/Traits/HasBlocks.php | 4 | High |
| app/View/Components/Section.php | 2 | High |

---

## File: app/Http/View/Composers/XotComposer.php

### Error: Class Not Found

**Line**: 29

**Error Message:**
```
Call to method profile() on an unknown class App\Models\User.
```

**Root Cause:**
Code is calling `App\Models\User` but this class doesn't exist in this codebase. Users are likely handled through module system (`Modules\User\Models\User` or `UserContract`).

**Fix:**
```php
// ❌ WRONG
use App\Models\User;

// ✅ CORRECT - Option 1: Use module User
use Modules\User\Models\User;

// ✅ CORRECT - Option 2: Use contract
use Modules\Xot\Contracts\UserContract;
```

**Priority**: Medium - May cause runtime errors if `App\Models\User` is ever accessed

---

## File: app/Http/Volt/VerifyComponent.php

### Error 1: Undefined Method hasVerifiedEmail()

**Line**: 34

**Error Message:**
```
Call to an undefined method Modules\Xot\Contracts\UserContract::hasVerifiedEmail().
```

**Root Cause:**
`UserContract` interface doesn't define `hasVerifiedEmail()` method, but code assumes it exists.

**Fix Options:**

**Option 1: Add method to contract**
```php
// Modules/Xot/Contracts/UserContract.php
interface UserContract
{
    public function hasVerifiedEmail(): bool;
    // ... other methods
}
```

**Option 2: Use Laravel's MustVerifyEmail contract**
```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

public function verify()
{
    $user = auth()->user();

    if ($user instanceof MustVerifyEmail && $user->hasVerifiedEmail()) {
        // ...
    }
}
```

### Error 2: Undefined Method sendEmailVerificationNotification()

**Line**: 38

**Error Message:**
```
Call to an undefined method Modules\Xot\Contracts\UserContract::sendEmailVerificationNotification().
```

**Root Cause:**
Similar to Error 1 - method not defined on `UserContract`.

**Fix Options:**

**Option 1: Add to contract**
```php
interface UserContract
{
    public function sendEmailVerificationNotification(): void;
}
```

**Option 2: Use Laravel interface**
```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

if ($user instanceof MustVerifyEmail) {
    $user->sendEmailVerificationNotification();
}
```

**Priority**: High - Email verification is critical functionality

---

## File: app/Models/Conf.php

### Error: Static Method Not Found

**Line**: 49

**Error Message:**
```
Call to an undefined static method Modules\Tenant\Services\TenantService::getConfigNames().
```

**Root Cause:**
Method `getConfigNames()` doesn't exist on `TenantService` class or PHPStan cannot find it.

**Investigation Required:**
1. Check if `TenantService` exists
2. Verify if `getConfigNames()` method exists
3. Check if it's static or instance method

**Temporary Fix:**
```php
// Add PHPDoc hint if method exists but PHPStan can't find it
/** @phpstan-ignore-next-line */
$configNames = TenantService::getConfigNames();
```

**Proper Fix:**
1. Ensure method exists and is public static
2. Or refactor to use instance method if appropriate

**Priority**: Medium - Depends on how critical config names are

---

## File: app/Models/Traits/HasBlocks.php

### Error Pattern: DataCollection::make() Not Found

**Lines**: 81, 86, 91

**Error Message (repeated 3 times):**
```
Call to an undefined static method Spatie\LaravelData\DataCollection::make().
```

**Root Cause:**
`DataCollection` class from Spatie Laravel Data package doesn't have a static `make()` method.

**Current Code (Wrong):**
```php
// Line 81, 86, 91
return DataCollection::make(BlockData::class, $blocks);
```

**Correct Usage:**
```php
// ✅ Option 1: Use collect() helper with DataCollection
use Spatie\LaravelData\DataCollection;

return BlockData::collect($blocks, DataCollection::class);

// ✅ Option 2: Use the Data class collection method
return BlockData::collection($blocks);

// ✅ Option 3: Manual instantiation (if needed)
return new DataCollection(BlockData::class, $blocks);
```

**Additional Errors on Same Lines:**
```
Method getBlocksBySlug() should return iterable<BlockData>&DataCollection
but returns mixed.
```

**Fix:**
```php
/**
 * @return DataCollection<int, BlockData>
 */
public function getBlocksBySlug(string $slug): DataCollection
{
    $blocks = // ... get blocks logic

    return BlockData::collection($blocks);
}
```

### Error: PHPDoc Variable Mismatch

**Line**: 95

**Error Message:**
```
Variable $collection in PHPDoc tag @var does not match assigned variable $blocks.
```

**Current Code:**
```php
/** @var DataCollection $collection */
$blocks = BlockData::collection($data);
```

**Fix:**
```php
/** @var DataCollection<int, BlockData> $blocks */
$blocks = BlockData::collection($data);
```

**Priority**: High - Core CMS functionality depends on blocks system

---

## File: app/View/Components/Section.php

### Error 1: Class Not Found in Property Type

**Line**: 27

**Error Message:**
```
Property $blocks has unknown class Modules\Cms\View\Components\BlockData as its type.
```

**Root Cause:**
Property type is declared as `Modules\Cms\View\Components\BlockData` but the actual class is `Modules\Cms\Datas\BlockData`.

**Current Code (Wrong):**
```php
use Modules\Cms\View\Components\BlockData; // ❌ Wrong namespace

class Section extends Component
{
    public DataCollection $blocks; // Type is inferred from use statement
}
```

**Fix:**
```php
use Modules\Cms\Datas\BlockData; // ✅ Correct namespace
use Spatie\LaravelData\DataCollection;

class Section extends Component
{
    /** @var DataCollection<int, BlockData> */
    public DataCollection $blocks;
}
```

### Error 2: Type Mismatch Assignment

**Line**: 54

**Error Message:**
```
Property $blocks (iterable<Modules\Cms\View\Components\BlockData>&DataCollection)
does not accept iterable<Modules\Cms\Datas\BlockData>&DataCollection.
```

**Root Cause:**
Same as Error 1 - wrong namespace in use statement causes type mismatch.

**Fix:**
Same as Error 1 - correct the import and add proper type hint.

**Priority**: High - Affects rendering of all CMS sections

---

## Recommended Actions

### Immediate (Critical)

1. **HasBlocks.php**:
   - Replace `DataCollection::make()` with `BlockData::collection()` (3 occurrences)
   - Fix PHPDoc types

2. **Section.php**:
   - Fix import: `use Modules\Cms\Datas\BlockData;` (not View\Components)
   - Add proper type hint to $blocks property

3. **VerifyComponent.php**:
   - Add missing methods to `UserContract` OR use Laravel's `MustVerifyEmail` contract

### Short-term (Important)

4. **XotComposer.php**:
   - Replace `App\Models\User` with correct User class reference

5. **Conf.php**:
   - Verify `TenantService::getConfigNames()` exists and is accessible

### Testing After Fixes

```bash
# Run PHPStan on Cms module only
./vendor/bin/phpstan analyse Modules/Cms

# Expected result after fixes: 0 errors
```

---

##Status

**Current**: 🔴 **15 errors** requiring fixes
**Priority**: 🔥 **HIGH** - Core CMS functionality affected
**Owner**: Cms Module Team


---

## Related Documentation

- [Spatie Laravel Data Documentation](https://spatie.be/docs/laravel-data)
- [DataCollection Usage](https://spatie.be/docs/laravel-data/v3/as-a-data-transfer-object/collections)
- [UserContract Interface](../../Xot/Contracts/UserContract.php)
