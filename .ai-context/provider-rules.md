# Service Provider Rules - CRITICAL

## 🚨 ALWAYS Remember

### ServiceProvider Pattern

**MINIMAL STRUCTURE IS MANDATORY:**

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class {Module}ServiceProvider extends XotBaseServiceProvider
{
    public string $name = '{Module}';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

## ❌ NEVER Do This

1. Add `boot()` or `register()` methods that only call parent
2. Duplicate methods already in XotBase (registerViews, etc.)
3. Forget required properties (`$module_dir`, `$module_ns`)
4. Extend wrong classes (BaseEventServiceProvider instead of XotBaseEventServiceProvider)
5. Skip calling `parent::boot()` FIRST when overriding

## ✅ ALWAYS Do This

1. Extend correct XotBase class
2. Include ALL required properties
3. Use minimal structure
4. Call parent FIRST if overriding
5. Use `#[Override]` attribute

## Quick Check

Before committing a Provider:
- [ ] Extends XotBase* class?
- [ ] Has all required properties?
- [ ] No unnecessary methods?
- [ ] Calls parent first if override?
- [ ] Uses `#[Override]`?

## References

- `laravel/Modules/Xot/docs/serviceprovider-minimal-structure.md`
- `laravel/Modules/Meetup/docs/provider-errors-lessons-learned.md`

**REMEMBER: Less code = fewer bugs. Trust XotBase to do its job.**
