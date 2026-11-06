---
title: "QueueableAction Migration for Xot Services"
type: note
status: unverified
created: 2026-10-20
updated: 2026-10-20
module: Xot
tags: [xot, services]
qmd: "QueueableAction Migration for Xot Services"
---
# QueueableAction Migration for Xot Services

## Overview
This document describes the migration of core Xot Services to use Spatie QueueableAction for queue-capable execution where appropriate.

## Migration Strategy

### Static-only Services
For services with only static methods (`ThemeService`, `RouteService`, `RouteDynService`, `HtmlService`, `ArtisanService`):
- **Kept**: All existing static methods intact for backward compatibility
- **Added**: `use Spatie\QueueableAction\QueueableAction;` trait
- **Added**: `execute()` instance method that delegates to the primary operation
- **Pattern**: `public function execute(...): ... { return $this->original_method(...); }`

### Instance-based Services
For services with instance state (`ModuleService`, `UrlService`):
- **Kept**: All existing instance methods (`getInstance()`, `make()`, etc.)
- **Added**: `use Spatie\QueueableAction\QueueableAction;` trait
- **Added**: `execute()` instance method that accepts the same parameters as the primary operation
- **Pattern**: `public function execute(string $name): array { return $this->setName($name)->getModels(); }`

### Trend Adapters (AbstractAdapter + PgsqlAdapter, MySqlAdapter, SqliteAdapter)
- **AbstractAdapter**: Added `use QueueableAction;` trait and `execute(string $column, string $interval): string`
- **Concrete Adapters**: Added `use QueueableAction;` trait (inherit queue capability)
- **Pattern**: Simple delegation pattern - adapters don't override execute() as they inherit from AbstractAdapter

### Translators (BaseTranslator + MyMemory, Apertium, Google, DeepL, Systran)
- **BaseTranslator**: Added `use QueueableAction;` trait and `execute(string $text = '', string $from = '', string $to = ''): string`
- **Concrete Translators**: Added `use QueueableAction;` trait (inherit queue capability)
- **Note**: Translator classes are mostly stubs/empty; they inherit the execute() method from BaseTranslator

## Decision Rationale

### Why not convert entirely to Action classes?
1. **Backward Compatibility**: Maintaining static methods is crucial for existing code
2. **Pattern Consistency**: Some services have static state that's tricky to translate to Actions
3. **Existing Actions**: Some operations already have dedicated Action classes (`RegisterDynamicRoutesAction` corresponds to `RouteDynService::dynamic_route()`)

### Why use QueueableAction trait on services?
1. **Minimal Changes**: Adding the trait is the least invasive way to enable queue execution
2. **Graceful Migration**: Developers can gradually move operations to queues without breaking changes
3. **Consistent API**: Using the same QueueableAction pattern across all services provides a unified interface

## Usage Examples

### ThemeService Queue Execution
```php
// Static call (existing)
ThemeService::setTheme('dark');

// Queueable call
$service = new ThemeService();
$service->onQueue('high')->execute('light'); // Sets theme to 'light' when processed
```

### ModuleService Queue Execution
```php
// Static call (existing)
$models = ModuleService::getInstance()->setName('blog')->getModels();

// Queueable call
$service = new ModuleService();
$service->onQueue('default')->execute('blog'); // Returns blog models when processed
```

### RouteDynService Queue Execution
```php
// Static call (existing)
RouteDynService::dynamic_route($routes);

// Queueable call
$service = new RouteDynService();
$service->onQueue('route-builder')->execute($routes); // Processes routes when executed
```

## Files Modified

### Core Services
- `app/Services/ModuleService.php`
- `app/Services/XotService.php`
- `app/Services/ThemeService.php`
- `app/Services/RouteDynService.php`
- `app/Services/RouteService.php`
- `app/Services/HtmlService.php`
- `app/Services/ArtisanService.php`
- `app/Services/UrlService.php`

### Trend Adapters
- `app/Services/Trend/Adapters/AbstractAdapter.php`
- `app/Services/Trend/Adapters/PgsqlAdapter.php`
- `app/Services/Trend/Adapters/MySqlAdapter.php`
- `app/Services/Trend/Adapters/SqliteAdapter.php`

### Translators
- `app/Services/Translators/BaseTranslator.php`
- `app/Services/Translators/MyMemory.php`
- `app/Services/Translators/Apertium.php`
- `app/Services/Translators/Google.php`
- `app/Services/Translators/DeepL.php`
- `app/Services/Translators/Systran.php`

## Testing Considerations

1. **Static Methods**: Ensure all existing static method calls continue to work
2. **Queue Jobs**: Test that queue execution properly dispatches jobs
3. **Dependencies**: Verify that any Laravel services or dependencies work in queue context
4. **Error Handling**: Ensure errors during queue execution are handled appropriately

## Future Migration Path

These changes provide a foundation for gradually moving operations to queues. Future improvements could include:

1. **Full Action Conversion**: Convert static-heavy services to Action classes
2. **Action-per-Method**: Create separate Actions for each service operation (like `RegisterDynamicRoutesAction`)
3. **Queue Configuration**: Fine-tune queue settings for different types of operations

## Security and Performance

1. **Queue Security**: Sensitive operations can be moved to queues with proper permissions
2. **Error Isolation**: Queue failures don't affect request processing
3. **Resource Management**: CPU-intensive operations can be moved out of request context

---

*This migration maintains full backward compatibility while enabling queue execution capabilities across all core Xot services.*

Last Updated: 2026-10-20