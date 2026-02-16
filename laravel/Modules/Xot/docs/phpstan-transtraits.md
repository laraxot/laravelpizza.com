# PHPStan Errors - TransTrait.php

**Date**: [DATE]
**File**: `Modules/Xot/app/Filament/Traits/TransTrait.php`
**PHPStan Level**: 10
**Total Errors**: ~10 (across multiple contexts)

---

## Overview

TransTrait provides translation functionality for Filament components. The trait is used by multiple base classes (Pages, Resources, Blocks, Clusters) but has a design issue: it calls `static::getModuleName()` which is not available in all using classes.

---

## Error Details

### Error 1: Undefined Static Method `getModuleName()`

**Severity**: 🔴 Critical
**Identifier**: `staticMethod.notFound`
**Location**: Line 223

**Error Message:**
```
Call to an undefined static method ::getModuleName()
```

**Occurs in 3+ contexts:**
1. `Modules\Xot\Filament\Blocks\XotBaseBlock` (uses TransTrait directly)
2. `Modules\Xot\Filament\Clusters\XotBaseCluster` (uses NavigationLabelTrait → TransTrait)
3. `Modules\Xot\Filament\Pages\EnvPage` (extends XotBasePage)

**Code Location (Line 223):**
```php
public static function getTranslatedString(
    string $key,
    array $replace = [],
    ?string $locale = null,
    bool $useFallback = true,
): string {
    $moduleNameLow = Str::lower(static::getModuleName()); // ❌ ERROR: Method not defined
    $p = Str::after(static::class, 'Filament\\Pages\\');
    $p_arr = explode('\\', $p);
    $slug = collect($p_arr)->map(Str::kebab(...))->implode('.');

    $translationKey = $moduleNameLow.'::'.$slug.'.'.$key;
    // ...
}
```

**Root Cause:**
- TransTrait assumes all using classes have `getModuleName()` method
- But only some base classes define it:
  - ✅ `XotBasePage::getModuleName()` exists (line 79)
  - ✅ `XotBaseResource::getModuleName()` exists (line 49)
  - ❌ `XotBaseBlock` does NOT have it
  - ❌ `XotBaseCluster` does NOT have it

---

### Error 2: Type Mismatch - Mixed Given to `Str::lower()`

**Severity**: 🔴 Critical
**Identifier**: `argument.type`
**Location**: Line 223

**Error Message:**
```
Parameter #1 $value of static method Illuminate\Support\Str::lower()
expects string, mixed given.
```

**Code:**
```php
$moduleNameLow = Str::lower(static::getModuleName()); // ❌ ERROR
```

**Root Cause:**
- `getModuleName()` doesn't exist in some contexts
- PHPStan infers return type as `mixed`
- `Str::lower()` expects `string`, not `mixed`

---

## Impact Analysis

### Affected Components

**1. XotBaseBlock**
```php
// File: Modules/Xot/app/Filament/Blocks/XotBaseBlock.php
abstract class XotBaseBlock
{
    use TransTrait; // ❌ Calls getModuleName() but doesn't define it

    // Missing:
    // public static function getModuleName(): string { ... }
}
```

**Impact**: Block components cannot use `getTranslatedString()` method safely.

---

**2. XotBaseCluster**
```php
// File: Modules/Xot/app/Filament/Clusters/XotBaseCluster.php
class XotBaseCluster extends FilamentCluster
{
    use NavigationLabelTrait; // → TransTrait

    // Missing:
    // public static function getModuleName(): string { ... }
}
```

**Impact**: Cluster navigation labels may fail in some scenarios.

---

**3. Other Classes Using TransTrait Indirectly**
- Any class using `NavigationLabelTrait` (which uses TransTrait)
- Custom pages extending XotBasePage
- Custom blocks extending XotBaseBlock

---

## Recommended Fixes

### Option 1: Add `getModuleName()` to Missing Classes ⭐ **Recommended**

**Complexity**: ⭐⭐ (Medium)
**Files to Modify**: 2

**1. Add to XotBaseBlock.php:**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;
use Modules\Xot\Filament\Traits\TransTrait;

abstract class XotBaseBlock
{
    use TransTrait;

    // ✅ ADD THIS METHOD
    public static function getModuleName(): string
    {
        $class = static::class;
        $parts = explode('\\', $class);

        // Extract module name from namespace
        // Format: Modules\{ModuleName}\Filament\Blocks\...
        if (isset($parts[1]) && $parts[0] === 'Modules') {
            return $parts[1];
        }

        return 'Xot'; // Fallback
    }

    public static function make(string $name = 'article_list', string $context = 'form'): Block
    {
        /** @var array<Component> $schema */
        $schema = array_merge(static::getBlockSchema(), static::getBlockVarSchema());

        return Block::make($name)->schema($schema)->columns($context === 'form' ? 3 : 1);
    }

    // ... rest of the class
}
```

**2. Add to XotBaseCluster.php:**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Clusters;

use Filament\Clusters\Cluster as FilamentCluster;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

class XotBaseCluster extends FilamentCluster
{
    use NavigationLabelTrait;

    // ✅ ADD THIS METHOD
    public static function getModuleName(): string
    {
        $class = static::class;
        $parts = explode('\\', $class);

        // Extract module name from namespace
        // Format: Modules\{ModuleName}\Filament\Clusters\...
        if (isset($parts[1]) && $parts[0] === 'Modules') {
            return $parts[1];
        }

        return 'Xot'; // Fallback
    }

    public function getTitle(): Htmlable|string
    {
        $key = static::getKeyTransFunc(__FUNCTION__);
        $res = static::transFunc(__FUNCTION__);
        dddx([
            'key' => $key,
            'res' => $res,
        ]);

        return 'AAAAAAAAA';
    }

    // ... rest of the class
}
```

**Expected Error Reduction**: ~10 errors (all TransTrait-related)

---

### Option 2: Make TransTrait Method Defensive

**Complexity**: ⭐⭐⭐ (Higher Risk - Changes core trait)
**Files to Modify**: 1

**Modify TransTrait.php line 223:**
```php
public static function getTranslatedString(
    string $key,
    array $replace = [],
    ?string $locale = null,
    bool $useFallback = true,
): string {
    // ✅ ADD DEFENSIVE CHECK
    if (method_exists(static::class, 'getModuleName')) {
        $moduleNameLow = Str::lower(static::getModuleName());
    } else {
        // Extract module name from class namespace
        $class = static::class;
        $parts = explode('\\', $class);
        $moduleNameLow = isset($parts[1]) && $parts[0] === 'Modules'
            ? Str::lower($parts[1])
            : 'xot';
    }

    $p = Str::after(static::class, 'Filament\\Pages\\');
    $p_arr = explode('\\', $p);
    $slug = collect($p_arr)->map(Str::kebab(...))->implode('.');

    $translationKey = $moduleNameLow.'::'.$slug.'.'.$key;
    $translation = __($translationKey, $replace, $locale);

    // ... rest of the method
}
```

**Pros**: Single file change, works for all future classes
**Cons**: Runtime check overhead, less explicit contract

---

### Option 3: Add Abstract Method Declaration

**Complexity**: ⭐⭐⭐ (Requires interface or breaking change)
**Files to Modify**: Multiple

**Create new HasModuleName interface:**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

interface HasModuleName
{
    public static function getModuleName(): string;
}
```

**Update TransTrait to require it:**
```php
trait TransTrait
{
    // Document requirement
    /**
     * Classes using this trait MUST implement getModuleName()
     * @see HasModuleName
     */
    abstract public static function getModuleName(): string;

    // ... rest of trait
}
```

**Pros**: Enforces contract at compile time
**Cons**: Breaks existing code until all classes are updated

---

## Testing After Fix

```bash
# Test TransTrait specifically
./vendor/bin/phpstan analyse Modules/Xot/app/Filament/Traits/TransTrait.php

# Test affected classes
./vendor/bin/phpstan analyse Modules/Xot/app/Filament/Blocks/XotBaseBlock.php
./vendor/bin/phpstan analyse Modules/Xot/app/Filament/Clusters/XotBaseCluster.php

# Test all Xot module
./vendor/bin/phpstan analyse Modules/Xot
```

---

## Additional Context

### Where `getModuleName()` IS Defined

**XotBasePage.php (Line 79):**
```php
public static function getModuleName(): string
{
    $reflectionClass = new \ReflectionClass(static::class);
    $namespace = $reflectionClass->getNamespaceName();
    $parts = explode('\\', $namespace);

    return $parts[1] ?? 'Unknown';
}
```

**XotBaseResource.php (Line 49):**
```php
public static function getModuleName(): string
{
    $class = static::class;
    $parts = explode('\\', $class);

    if (isset($parts[1]) && $parts[0] === 'Modules') {
        return $parts[1];
    }

    return 'Unknown';
}
```

**Pattern**: Extract module name from namespace `Modules\{ModuleName}\...`

---

## Related Errors

This fix may also resolve related errors in:
- NavigationLabelTrait (uses TransTrait)
- Any custom blocks/clusters in other modules
- Translation functionality across the application

---

## Priority Recommendation

**Priority**: P2 - Soon (Medium Priority)
**Reason**:
- Affects translation functionality but doesn't completely break the system
- More critical errors exist in Geo and Cms modules
- Should be fixed after P0 critical issues

**Recommended Approach**: Option 1 (Add getModuleName() to missing classes)
**Why**:
- Explicit and clear
- Low risk (only adds methods, doesn't change existing behavior)
- Consistent with existing pattern
- Easy to test and verify

---

## Related Documentation

- [PHPStan Analysis Summary](phpstan-analysis-[DATE].md)
- [XotBase Extension Rules](xotbase-extension-rules.md)
- [Filament Integration](filament-integration.md)

---

**Status**: 🟡 Documented - Awaiting Fix
**Assigned To**: Module Owner

