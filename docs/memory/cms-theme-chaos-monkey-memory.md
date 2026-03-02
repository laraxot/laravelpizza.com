# CMS Theme Chaos Monkey Memory

## Critical Architecture Patterns

### 1. Configuration-Driven Theme System

**Pattern**: All theme configuration centralized in `xra.php`

**Key Points**:
- `pub_theme` setting determines active theme
- Theme namespace is ALWAYS `pub_theme::`, never theme name
- Multiple theme namespaces can be registered
- View paths are configured in ThemeServiceProvider

**Debugging**: When theme components not found:
1. Check `config('xra.pub_theme')` value
2. Verify ThemeServiceProvider registration
3. Check view paths in ThemeServiceProvider
4. Verify namespace registration

**Fix**: Ensure theme namespace is registered in ThemeServiceProvider:
```php
$this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
```

### 2. Multi-Layer Namespace Registration

**Pattern**: Namespaces are registered in layers

**Layers**:
1. Module namespaces (e.g., `cms::`, `meetup::`)
2. Theme namespace (`pub_theme::`)
3. Component namespaces (e.g., `x-layouts::`, `x-section::`)

**Debugging**: When view not found:
1. Check which namespace is being used
2. Verify namespace is registered
3. Check view path in namespace
4. Verify file exists at path

**Fix**: Register namespace in appropriate ServiceProvider:
```php
$this->loadViewsFrom($path, 'namespace');
```

### 3. Folio Routing WITHOUT Locale Middleware

**Pattern**: Folio routes do NOT set locale (prevents Livewire serialization)

**Critical**: Never add locale-setting middleware to Folio routes!

**Code**: `FolioVoltServiceProvider.php`
```php
foreach ($supportedLocales as $locale) {
    Folio::path($theme_path)
        ->uri($locale)
        ->middleware([
            '*' => $base_middleware, // NO locale middleware
        ]);
}
```

**Debugging**: When Livewire components fail to serialize:
1. Check Folio middleware
2. Remove locale-setting middleware
3. Clear all caches
4. Test again

**Fix**: Remove locale-setting middleware from Folio routes

### 4. Block-Based Content System

**Pattern**: Content is organized in blocks with JSON storage

**Block Structure**:
```json
{
  "type": "content-resolver",
  "container0": "events",
  "slug0": "events-list",
  "blocks": [...]
}
```

**Debugging**: When blocks not rendering:
1. Check blocks array in page JSON
2. Verify block type exists
3. Check block view exists
4. Trace block execution flow

**Fix**: Add missing blocks or fix block configuration

### 5. Dynamic Query Resolution

**Pattern**: Block queries are resolved via `ResolveBlockQueryAction`

**Query Structure**:
```json
{
  "query": {
    "model": "\\Modules\\Meetup\\Models\\Event",
    "scope": "published",
    "orderBy": "date",
    "direction": "asc",
    "limit": 10
  }
}
```

**Debugging**: When queries fail:
1. Check model class exists
2. Verify scope method exists
3. Check model relationship definitions
4. Verify query parameters

**Fix**: Fix model class name, add scope method, or adjust query parameters

### 6. SushiToJsons JSON Storage

**Pattern**: Models store data in JSON files using `SushiToJsons` trait

**Critical Methods**:
- `getJsonFile()` - Path to JSON file
- `loadExistingData()` - Load data from JSON
- `saveToJson()` - Save data to JSON

**Debugging**: When JSON data not loading:
1. Check JSON file path
2. Verify JSON file exists
3. Check JSON file format
4. Verify trait implementation

**Fix**: Implement trait methods correctly, ensure JSON file exists

### 7. Module Hierarchy

**Pattern**: Modules extend Xot base classes

**Hierarchy**:
```
XotBaseModel → Module BaseModel → Module Model
XotBaseServiceProvider → Module ServiceProvider
XotBaseResource → Module Resource
```

**Debugging**: When module functionality missing:
1. Check module inheritance
2. Verify Xot module is loaded
3. Check service provider registration
4. Verify module is enabled

**Fix**: Ensure module extends correct base class, register service provider

### 8. Tenant-Aware Operations

**Pattern**: Use `TenantService` for tenant-aware operations

**Usage**:
```php
$config = TenantService::config('key');
$model = TenantService::model('ModelClass');
```

**Debugging**: When tenant operations fail:
1. Check tenant is set
2. Verify tenant configuration
3. Check tenant database connection
4. Verify TenantService is registered

**Fix**: Ensure tenant is properly configured and set

### 9. Livewire/Volt Auto-Detection

**Pattern**: `BlockData` auto-detects Livewire/Volt components

**Detection Logic**:
```php
if (class_exists($componentClass)) {
    // Use Livewire component
}
```

**Debugging**: When components not detected:
1. Check component class exists
2. Verify component namespace
3. Check component is registered
4. Verify component extends correct base

**Fix**: Ensure component class exists and extends correct base class

### 10. Translation System

**Pattern**: Translations use module/theme namespaces

**Translation Keys**:
- Module: `module::file.key`
- Theme: `pub_theme::file.key`

**Debugging**: When translations not working:
1. Check locale is set
2. Verify translation file exists
3. Check translation key format
4. Verify namespace is registered

**Fix**: Create translation file, fix translation key, register namespace

## Common Fix Patterns

### Fix 1: View Not Found Error

**Symptom**: `View [pub_theme::path] not found`

**Steps**:
1. Check view path
2. Verify namespace is registered
3. Check file exists at path
4. Clear view cache

**Command**: `php artisan view:clear`

### Fix 2: Block Not Rendering

**Symptom**: Page loads but content area empty

**Steps**:
1. Check blocks array in page JSON
2. Verify block type exists
3. Check block view exists
4. Trace block execution with dump()

**Debug**: Add `{{ dump($blocks) }}` to template

### Fix 3: Query Returns No Data

**Symptom**: Block renders but empty

**Steps**:
1. Check model class exists
2. Verify scope method exists
3. Check database connection
4. Verify query parameters

**Debug**: Add query logging to see actual SQL

### Fix 4: Middleware Not Executing

**Symptom**: Protected page accessible without auth

**Steps**:
1. Check middleware registration
2. Verify middleware alias
3. Check middleware order
4. Clear route cache

**Command**: `php artisan route:clear`

### Fix 5: Translation Not Working

**Symptom**: English text on Italian page

**Steps**:
1. Check locale is set
2. Verify translation file exists
3. Check translation key format
4. Clear translation cache

**Command**: `php artisan cache:clear`

### Fix 6: Livewire Component Not Working

**Symptom**: Component doesn't respond to interaction

**Steps**:
1. Check component class exists
2. Verify component namespace
3. Check component is registered
4. Clear component cache

**Command**: `php artisan view:clear`

### Fix 7: Module Not Loading

**Symptom**: Module functionality missing

**Steps**:
1. Check module is enabled
2. Verify service provider registered
3. Check module dependencies
4. Clear application cache

**Command**: `php artisan optimize:clear`

## Emergency Recovery Procedures

### Procedure 1: Clear All Caches

```bash
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

### Procedure 2: Rebuild Theme Assets

```bash
cd laravel/Themes/Meetup
npm run build
npm run copy
```

### Procedure 3: Restart Services

```bash
# Stop services
pkill -f "php artisan serve"
pkill -f "npm run dev"

# Start services
cd laravel
php artisan serve &
npm run dev &
```

### Procedure 4: Check Database

```bash
php artisan db:show
php artisan migrate:status
```

### Procedure 5: Verify Module Status

```bash
php artisan module:list
```

## Prevention Strategies

### Strategy 1: Write Tests

- Write integration tests for critical functionality
- Test configuration loading
- Test routing
- Test block rendering
- Test translations

### Strategy 2: Use Type Safety

- Use PHPStan Level 10
- Add type hints to all methods
- Use strict types
- Validate input data

### Strategy 3: Validate Configuration

- Validate configuration early
- Use configuration validators
- Provide helpful error messages
- Document configuration options

### Strategy 4: Log Key Events

- Log configuration changes
- Log route registration
- Log model queries
- Log component rendering

### Strategy 5: Use Try-Catch

- Wrap critical operations in try-catch
- Provide helpful error messages
- Log exceptions
- Provide fallback behavior

This memory document provides the critical knowledge needed to handle chaos monkey scenarios in the CMS theme system.