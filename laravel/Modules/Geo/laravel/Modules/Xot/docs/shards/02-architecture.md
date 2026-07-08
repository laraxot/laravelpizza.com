---
title: "Laraxot - Core Architecture"
type: shard
confidence: high
created: 2026-05-11
parent: laraxot.md
lines: 100
tokens: ~130K
related:
  - ./INDEX.md
  - ./01-overview.md
  - ./03-data-management.md
---

# Core Architecture

## Modules

| Module | Purpose |
|--------|---------|
| **Xot** | Core services, providers, utilities, interfaces |
| **Geo** | Location, mapping, coordinates, addresses |
| **Activity** | User tracking, audit logging, monitoring |
| **UI** | Frontend components, themes, layouts |

## Base Classes (CRITICAL - Always Extend These)

### XotBaseResource
Foundation for all Filament resources.

```php
class YourResource extends XotBaseResource
{
    public function getFormSchema(): array  // REQUIRED
    public function getListTableColumns(): array
    public function getRelations(): array
    public function getPages(): array
}
```

**Why**: Provides hooks, lifecycle methods, consistency across modules.

### XotBaseServiceProvider
Core service provider for module registration.

```php
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerTranslations();
    }
}
```

**Never extend directly**: `ServiceProvider`, `RouteServiceProvider`

### Other Base Classes
- `XotBaseField` - Form components
- `XotBaseRouteServiceProvider` - Routing
- `XotBaseThemeServiceProvider` - Themes

## Architecture Violations = Critical

### ❌ FORBIDDEN
```php
// Never do this
class MyResource extends Resource  // Wrong!
class MyController extends Controller  // Wrong!
```

### ✅ REQUIRED
```php
// Always do this
class MyResource extends XotBaseResource  // Correct!
class MyController extends BaseController  // From your module
```

## Module Communication

### Cross-Module Patterns
1. **Actions**: Call via `app(Action::class)->execute()`
2. **Events**: Laravel events for loose coupling
3. **Contracts**: Interfaces in shared modules
4. **Data Objects**: Spatie Data for type-safe transfer

### Anti-Pattern: Direct Model Access
```php
// ❌ Bad
$user = \Modules\User\Models\User::find(1);

// ✅ Good
$user = app(GetUserAction::class)->execute($id);
```

## References
- Overview: [01-overview](./01-overview.md)
- Data management: [03-data-management](./03-data-management.md)
- Base classes deep dive: [xotbase-extension-rules.md](../consolidated/xotbase-extension-rules.md)

---
*Shard 2/18 of laraxot.md | Load: 03-data-management.md or 04-best-practices.md*
