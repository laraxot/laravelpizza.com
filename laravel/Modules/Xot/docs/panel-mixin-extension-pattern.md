---
title: "Panel Mixin Extension Pattern"
module: "Xot"
type: "Architecture Pattern"
created: 2026-07-07
updated: 2026-07-07
---

# Panel Mixin Extension Pattern

## Overview

The `PanelMixin` pattern extends Filament's `Panel` class with module-aware metadata and configuration methods. This allows dynamic panel configuration based on the underlying module structure without using static resolvers.

**Location**: `Modules/Xot/app/Mixins/PanelMixin.php`  
**Registered in**: `Modules/Xot/app/Providers/XotServiceProvider.php`

---

## Problem Statement

Filament panels require metadata (labels, icons, sort order) that varies per module. Initially, this was solved with a static `PanelModuleResolver` utility class. However:

1. **Coupling**: Code using the resolver imported an additional static dependency
2. **Indirection**: Logic lived in both the mixin AND the resolver, duplicating knowledge
3. **Discoverability**: Developers wouldn't naturally look for `Panel::mixin()` to understand panel capabilities

**Solution**: Implement panel capabilities directly on the `Panel` class via a mixin, making metadata queryable through the panel instance itself.

---

## Architecture

### Core Methods (Closure-Based Mixin)

The mixin adds these methods to `Panel` instances:

#### Module Resolution

**`getName(): string`**
- Extracts the module name from panel ID (prefix before `::`)
- Example: `"User::admin"` → `"User"`

**`getModule(): NwidartModule`**
- Returns the underlying Nwidart module instance
- Throws assertion error if module not found

**`getConfig(): array`**
- Returns Laravel `config(moduleName)` array
- Filters to string keys only

**`getModuleConfig(): array`**
- Reads `Module/config/config.php` file directly
- Returns raw config array with schema assertions

#### Navigation Metadata

**`getNavigationLabel(): string`**
- Reads `name` from module config
- Used for panel switching UI labels

**`getNavigationIcon(): string`**
- Reads `icon` from module config
- Expected format: Filament icon class (e.g., `"heroicon-o-cog"`)

**`getNavigationSort(): int`**
- Reads `navigation.sort` from module config (default: 0)
- Controls panel order in navigation

---

## Usage Pattern

### Before: Static Resolver Approach ❌

```php
class GetPanelsNavigationItems {
    public function execute(): array {
        $navs = [];
        
        foreach (Filament::getPanels() as $panel) {
            $navs[] = NavigationItem::make($panel->getId())
                ->icon(PanelModuleResolver::navigationIcon($panel))  // Static call
                ->label(PanelModuleResolver::navigationLabel($panel))
                ->sort(PanelModuleResolver::navigationSort($panel));
        }
        
        return $navs;
    }
}
```

**Issues**:
- `PanelModuleResolver` is a static utility, not OOP
- Knowledge lives in two places (mixin + resolver)
- Violates encapsulation: resolver duplicates mixin logic

### After: Mixin-Based Approach ✅

```php
class GetPanelsNavigationItems {
    public function execute(): array {
        $navs = [];
        
        foreach (Filament::getPanels() as $panel) {
            $navs[] = NavigationItem::make($panel->getId())
                ->icon($panel->getNavigationIcon())  // Direct method call
                ->label($panel->getNavigationLabel())
                ->sort($panel->getNavigationSort());
        }
        
        return $navs;
    }
}
```

**Benefits**:
- No static dependencies
- Single source of truth (the mixin)
- OOP: capabilities are methods on the object
- Discoverable: IDE autocomplete shows available panel methods

---

## Implementation Details

### Mixin Registration

In `XotServiceProvider`:

```php
use Filament\Panel;
use Modules\Xot\Mixins\PanelMixin;

public function register(): void {
    Panel::mixin(new PanelMixin());
}
```

This happens during service provider boot, making methods available on all `Panel` instances.

### Closure-Based Method Definition

Each mixin method returns a closure:

```php
public function getName() {
    return function (): string {
        $id = $this->getId();  // `$this` is the Panel instance
        $name = Str::before($id, '::');
        return $name;
    };
}
```

The closure receives the Panel instance as `$this`, allowing access to panel properties and methods.

---

## Configuration Requirements

Each module must define `config/config.php` with required fields:

```php
return [
    'name' => 'User Module',                    // Navigation label
    'icon' => 'heroicon-o-users',              // Navigation icon
    'navigation' => [
        'sort' => 10,                          // Panel order (optional, default: 0)
    ],
];
```

### Assert Behavior

Mixin methods use `Webmozart\Assert` to enforce configuration contracts:

```php
Assert::string($name, '['.__LINE__.']['.class_basename($this).']');
Assert::string($icon, '['.__LINE__.']['.class_basename($this).']');
Assert::integer($sort, '['.__LINE__.']['.class_basename($this).']');
```

This ensures configuration is valid at runtime with clear error messages including line numbers.

---

## Testing Pattern

### Unit Test Example

```php
class PanelMixinTest extends TestCase {
    public function test_panel_returns_module_name() {
        $panel = new Panel('User::admin');  // Filament Panel instance
        $name = $panel->getName();          // Via mixin
        
        $this->assertSame('User', $name);
    }
    
    public function test_panel_reads_navigation_label_from_config() {
        // Given a module config
        Config::set('user.name', 'User Management');
        
        $panel = new Panel('User::admin');
        
        // When calling navigation label
        $label = $panel->getNavigationLabel();
        
        // Then it reads from config
        $this->assertSame('User Management', $label);
    }
}
```

---

## Deprecation Note: PanelModuleResolver

The static `PanelModuleResolver` class in `Modules/Xot/app/Support/PanelModuleResolver.php` is **no longer necessary** and should be removed:

- All resolver methods are now available via the mixin
- Static utilities violate OOP principles
- Removing it eliminates code duplication

**Migration Path**:
1. Update all usages to call mixin methods directly (example: `$panel->getNavigationIcon()` instead of `PanelModuleResolver::navigationIcon($panel)`)
2. Remove `PanelModuleResolver` class
3. Remove import from usages

---

## When to Use This Pattern

**✅ Use mixins when**:
- Extending a framework class with consistent, reusable methods
- All methods logically belong to the extended object
- Methods should be discoverable via the object instance

**❌ Don't use mixins for**:
- One-off utilities (use static helpers or services)
- Cross-domain concerns (use dedicated service classes)
- Complex logic that needs testing in isolation (extract to a service, then mixin as a delegate)

---

## Related Patterns

- **Service Layer**: For complex business logic, extract to a service and inject it
- **Repository Pattern**: For data access, use repositories instead of direct model queries
- **Action Classes**: For domain operations, use `Spatie\QueueableAction`

---

## See Also

- [Filament Panel Documentation](https://filamentphp.com/docs/3.x/panels)
- [Laravel Mixins](https://laravel.com/docs/11.x/macros#method-stubs)
- `Modules/Xot/app/Providers/XotServiceProvider.php` (mixin registration)
- `Modules/Xot/app/Actions/Filament/GetPanelsNavigationItems.php` (usage example)
