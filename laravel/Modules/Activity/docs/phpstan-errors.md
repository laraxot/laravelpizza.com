# PHPStan Errors - Activity Module

**Date**: [DATE]
**PHPStan Level**: 10
**Total Errors in Module**: 2

## File: app/Traits/HasEvents.php

**Context**: Used in `Modules\Meetup\Models\Event`

### Error 1: Missing Return Type on storedEvents()

**Line**: 12

**Error Message:**
```
Method Modules\Meetup\Models\Event::storedEvents() has no return type specified.
```

**Current Code (Inferred):**
```php
trait HasEvents
{
    public function storedEvents() // ❌ No return type
    {
        return $this->hasMany(StoredEvent::class);
    }
}
```

**Fix:**
```php
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Activity\Models\StoredEvent;

trait HasEvents
{
    /**
     * Get all stored events for this model.
     *
     * @return HasMany<StoredEvent>
     */
    public function storedEvents(): HasMany
    {
        return $this->hasMany(StoredEvent::class);
    }
}
```

---

### Error 2: Missing Return Type on snapshots()

**Line**: 17

**Error Message:**
```
Method Modules\Meetup\Models\Event::snapshots() has no return type specified.
```

**Current Code (Inferred):**
```php
trait HasEvents
{
    public function snapshots() // ❌ No return type
    {
        return $this->hasMany(Snapshot::class);
    }
}
```

**Fix:**
```php
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Activity\Models\Snapshot;

trait HasEvents
{
    /**
     * Get all snapshots for this model.
     *
     * @return HasMany<Snapshot>
     */
    public function snapshots(): HasMany
    {
        return $this->hasMany(Snapshot::class);
    }
}
```

---

## Complete Fixed Trait

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;

trait HasEvents
{
    /**
     * Get all stored events for this model.
     *
     * @return HasMany<StoredEvent>
     */
    public function storedEvents(): HasMany
    {
        return $this->hasMany(StoredEvent::class);
    }

    /**
     * Get all snapshots for this model.
     *
     * @return HasMany<Snapshot>
     */
    public function snapshots(): HasMany
    {
        return $this->hasMany(Snapshot::class);
    }
}
```

---

## Why This Matters

### Type Safety
- Without return types, PHPStan cannot verify correct usage
- IDE auto-completion is degraded
- Refactoring is more error-prone

### Laravel Best Practices
- Laravel relationship methods should ALWAYS have return types
- Helps with static analysis and IDE support
- Standard practice since Laravel 8+

### Impact
- **Medium Priority** - Affects all models using this trait
- **Easy Fix** - Just add return type declarations
- **No Breaking Changes** - Return types are covariant

---

## Testing After Fix

```bash
# Run PHPStan on Activity module
./vendor/bin/phpstan analyse Modules/Activity

# Expected: 0 errors from HasEvents.php
```

---

## Status

**Current**: 🟡 **2 errors** - Missing return types
**Priority**: Medium - Easy fix, affects multiple models
**Owner**: Activity Module Team

**Fix Complexity**: ⭐ (Very Easy - Just add return types)
