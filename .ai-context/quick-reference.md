# Quick Reference - Critical Patterns

## ServiceProvider Pattern

```php
// ✅ CORRECT - Minimal
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Module';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}

// ❌ WRONG - Unnecessary methods
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public function boot(): void { parent::boot(); } // DON'T DO THIS
}
```

## XotBase Extensions

```php
// ✅ ALWAYS extend XotBase, NEVER Filament directly
class MyResource extends XotBaseResource { }
class MyWidget extends XotBaseWidget { }
class MyPage extends XotBasePage { }
class AdminPanelProvider extends XotBasePanelProvider { }
```

## Front Office Architecture

```php
// ✅ CORRECT - JSON content + Folio
config/local/laravelpizza/database/content/pages/home.json

// ❌ WRONG - Controllers/Routes
Route::get('/home', [HomeController::class, 'index']); // NEVER DO THIS
```

## Remember

1. Project is ENHANCEMENT of laravelpizza.com (not replica)
2. ServiceProviders: MINIMAL structure
3. Front office: Folio + Volt only
4. Always extend XotBase classes
5. PHPStan level 10 required

See full docs in CLAUDE.md and laravel/CLAUDE.md
