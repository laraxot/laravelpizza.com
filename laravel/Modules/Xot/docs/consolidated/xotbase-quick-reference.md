# 🚀 XotBase Quick Reference

## ⚡ Immediate Action Required

**NEVER DO THIS:** ❌
```php
class MyResource extends \Filament\Resources\Resource
class MyWidget extends \Filament\Widgets\Widget
```

**ALWAYS DO THIS:** ✅
```php
class MyResource extends \Modules\Xot\Filament\Resources\XotBaseResource
class MyWidget extends \Modules\Xot\Filament\Widgets\XotBaseWidget
```

## 🔧 Critical Methods to Implement

### For XotBaseWidget
```php
public function getFormSchema(): array
{
    return [
        // REQUIRED: Form components here
        // NEVER return empty array []
    ];
}
```

### Method must be PUBLIC (not protected)

## 📁 Correct Namespace Structure

```php
namespace Modules\YourModule\Filament\Resources;      // ✅ Correct
namespace Modules\YourModule\Filament\Widgets;       // ✅ Correct

namespace Modules\YourModule\App\Filament\Resources; // ❌ Wrong (contains App)
```

## 🚨 Common Error Fixes

### Error: "contains 1 abstract method"
**Fix:** Implement `getFormSchema()` method returning form components

### Error: "Access level must be public"
**Fix:** Change `protected` to `public` for the method

### Error: "Cannot override final method"
**Fix:** Use hook methods instead of overriding

## 📞 Emergency Help

1. Check: `/Modules/Xot/project_docs/XOTBASE_EXTENSION_RULES.md`
2. Check: `/Modules/Xot/project_docs/filament_extension_pattern.md`
3. Run: `php artisan optimize:clear && ./vendor/bin/phpstan analyse`

---

*Keep this file visible during development!*
