# Modules Integration Reference

## Overview

This document provides a comprehensive reference for how all modules in the LaravelPizza project integrate with each other and with the theme system.

## Core Architecture

### Module Hierarchy

```
Xot (Core Engine)
├── Base classes for all modules
├── XotBaseServiceProvider
├── XotData (configuration)
└── Shared utilities

Cms (Content Management)
├── Page system
├── Block system
├── Content resolution
└── Theme integration

Lang (Localization)
├── Translation system
├── LaravelLocalization integration
├── Translation files
└── Multi-language support

Tenant (Multi-tenancy)
├── Tenant isolation
├── Config management
├── Model resolution
└── Module registration

Meetup (Main Module)
├── Event management
├── Registration
├── Business logic
└── Theme-specific features

User (User Management)
├── Authentication
├── User types
├── Profiles
└── Teams

Other Modules
├── Activity (logging)
├── Gdpr (compliance)
├── Geo (geolocation)
├── Media (file management)
├── Notify (notifications)
├── Seo (SEO optimization)
└── UI (shared components)
```

## Module Integration Points

### 1. Xot Module (Core Engine)

**Purpose:** Provides base classes and shared functionality for all modules.

**Key Components:**

#### XotBaseServiceProvider
```php
// Base class for all module service providers
class XotBaseServiceProvider extends ServiceProvider
{
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    // Auto-registers module
    // Loads migrations
    // Loads routes
    // Loads views
}
```

#### XotData
```php
// Central configuration data object
class XotData extends Data implements Wireable
{
    public string $main_module = 'Meetup';
    public string $pub_theme = 'Meetup';
    public string $primary_lang = 'it';
    public bool $register_pub_theme = false;
    // ... more config
    
    // Methods
    public function getUserClass(): string;
    public function getTeamClass(): string;
    public function getProfileClass(): string;
    public function getPubThemeViewPath(string $key): string;
}
```

#### Base Classes
- `XotBaseModel` - Base for all models
- `XotBaseResource` - Base for Filament resources
- `XotBaseWidget` - Base for Filament widgets
- `XotBasePage` - Base for Filament pages

**Integration Pattern:**
All modules extend Xot base classes:
```php
// In any module
class Page extends BaseModelLang  // Lang module extends Xot
{
    // Inherits from XotBaseModel via BaseModelLang
}
```

### 2. Cms Module (Content Management)

**Purpose:** Manages pages, blocks, and content resolution.

**Key Integration Points:**

#### With Xot
```php
// Extends Xot base classes
class CmsServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Cms';
}

class Page extends BaseModelLang  // From Lang module
{
    use HasBlocks;  // Cms trait
    use SushiToJsons;  // Tenant module
}
```

#### With Tenant
```php
// Config storage via TenantService
class FooterData extends Data
{
    public static function make(): self
    {
        $data = TenantService::getConfig('appearance');
        return self::from($data);
    }
}
```

#### With Theme
```php
// Theme registration
public function registerNamespaces(string $theme_type): void
{
    $theme = $xot->{$theme_type};  // 'pub_theme'
    $theme_path = 'Themes/'.$theme;
    
    // Register view namespace
    view()->addNamespace($theme_type, $theme_path.'/resources/views');
    
    // Load translations
    $this->loadTranslationsFrom($theme_path.'/lang', $theme_type);
}
```

#### With Lang
```php
// Translation support
class Page extends BaseModelLang
{
    public $translatable = [
        'title',
        'blocks',
        'content_blocks',
    ];
}
```

**Content Resolution Flow:**
```
Request → Folio Route → [slug].blade.php
    ↓
ResolvePageAction
    ├→ Try dynamic model (Event, etc.)
    ├→ Try CMS page (container.slug)
    └→ Fallback to container.view
    ↓
content-resolver.blade.php
    ├→ Render model view
    ├→ Render CMS blocks
    └→ Show 404
```

### 3. Lang Module (Localization)

**Purpose:** Provides translation infrastructure.

**Key Components:**

#### Translation System
```php
// Base model for translatable models
class BaseModelLang extends BaseModel
{
    use HasTranslations;  // Spatie Translatable
    
    public $translatable = [];
    
    public function getTranslation(string $key, string $locale)
    {
        // Returns translated value
    }
}
```

#### LaravelLocalization Integration
```php
// Locale detection
$locale = LaravelLocalization::getCurrentLocale();
$supportedLocales = config('laravellocalization.supportedLocales');
```

#### Translation Files
```
Modules/{Module}/lang/{locale}/{file}.php
Themes/{Theme}/lang/{locale}/{file}.php
```

**Integration Pattern:**
```php
// Model with translations
class Page extends BaseModelLang
{
    public $translatable = ['title', 'blocks'];
    
    // Usage
    $page->getTranslation('title', 'it');  // Italian
    $page->getTranslation('title', 'en');  // English
}
```

### 4. Tenant Module (Multi-tenancy)

**Purpose:** Provides tenant isolation and config management.

**Key Components:**

#### TenantService
```php
class TenantService
{
    public static function getName(): string;
    public static function config(string $key, $default = null);
    public static function saveConfig(string $name, array $data);
    public static function modelClass(string $name): ?string;
    public static function model(string $name): Model;
    public static function trans(string $key): string;
}
```

#### Config Resolution
```
Request → TenantService::getName()
    ↓
Tenant: laravelpizza
    ↓
Config: config/local/laravelpizza/{config}.php
```

#### SushiToJsons Trait
```php
// JSON file storage instead of database
trait SushiToJsons
{
    protected function getJsonFile(): string
    {
        return database_path('data/' . static::class . '.json');
    }
    
    protected function loadExistingData(): array
    {
        return json_decode(file_get_contents($this->getJsonFile()), true);
    }
}
```

**Integration Pattern:**
```php
// Config storage
$config = ['appearance' => ['footer' => $data]];
TenantService::saveConfig('appearance', $config);

// Config retrieval
$config = TenantService::getConfig('appearance');
$footer = $config['footer'];
```

### 5. Meetup Module (Main Module)

**Purpose:** Contains business logic for meetup functionality.

**Key Integration Points:**

#### With Cms
```php
// Event model can be resolved dynamically
class ResolvePageAction
{
    private function loadDynamicModel(string $container0, string $slug0): ?object
    {
        $knownMappings = [
            'events' => 'Modules\\Meetup\\Models\\Event',
        ];
        
        return $this->queryModel($knownMappings[$container0], $slug0);
    }
}
```

#### With Xot
```php
// Extends base classes
class Event extends BaseModelLang
{
    use SushiToJsons;
    
    // Inherits XotBaseModel functionality
}
```

#### With Lang
```php
// Translatable fields
class Event extends BaseModelLang
{
    public $translatable = [
        'title',
        'description',
        'location',
    ];
}
```

#### With Theme
```php
// Theme provides views for Event
pub_theme::components.blocks.events.detail
```

### 6. User Module (User Management)

**Purpose:** Authentication and user management.

**Key Integration Points:**

#### With Xot
```php
// User contracts
interface UserContract
{
    public function hasRole(string $role): bool;
    public function hasPermission(string $permission): bool;
}
```

#### With Tenant
```php
// Tenant-aware user types
class User extends BaseModelLang
{
    public function getChildTypes(): array
    {
        return [
            'admin' => Modules\User\Models\Admin::class,
            'organizer' => Modules\User\Models\Organizer::class,
            'attendee' => Modules\User\Models\Attendee::class,
        ];
    }
}
```

#### With Cms
```php
// Page middleware based on user type
'events.edit' => [
    'auth',
    'Modules\\User\\Http\\Middleware\\EnsureUserHasType:organizer'
]
```

## Theme Integration

### Theme Registration Flow

```
1. ThemeServiceProvider registers
   ↓
2. CmsServiceProvider detects pub_theme
   ↓
3. Registers namespaces:
   - pub_theme:: (theme views)
   - cms:: (CMS views)
   - {module}:: (module views)
   ↓
4. Loads translations:
   - Themes/{theme}/lang/
   - Modules/{module}/lang/
   ↓
5. Registers anonymous components
```

### View Resolution Priority

```
1. Theme specific (pub_theme::components.hero)
2. CMS default (cms::components.blocks.hero)
3. Module specific (meetup::components.blocks.hero)
4. Fallback to default
```

### Asset Management

```
Vite Build Process:
1. npm run build (in theme directory)
2. Compiles resources/css/app.css
3. Compiles resources/js/app.js
4. Outputs to public/
5. npm run copy (copies to public_html/themes/Meetup)
```

## Common Integration Patterns

### Pattern 1: Extending Base Classes

```php
// ALWAYS extend from module's BaseModel
class Page extends BaseModelLang  // From Lang module
{
    // BaseModelLang extends XotBaseModel
}

// NEVER extend XotBaseModel directly
class Page extends XotBaseModel  // ❌ WRONG
```

### Pattern 2: Using TenantService

```php
// Always use TenantService for tenant-aware operations
$config = TenantService::getConfig('xra');
$tenant = TenantService::getName();
$model = TenantService::model('user');
```

### Pattern 3: Translation Usage

```php
// Use translation functions
__('pub_theme::home.title')
__('meetup::events.list.title')

// Get translated model property
$page->getTranslation('title', 'it')
```

### Pattern 4: Dynamic Model Resolution

```php
// Via ResolvePageAction
$resolvePageAction = app(ResolvePageAction::class);
$pageData = $resolvePageAction->execute('events', 'event-slug');

// Via container0_model_map config
'events' => 'Modules\\Meetup\\Models\\Event'
```

### Pattern 5: Block System

```php
// In page JSON
{
  "blocks": [
    {
      "type": "events-list",
      "data": {
        "view": "pub_theme::components.blocks.events.list",
        "query": {
          "model": "Modules\\Meetup\\Models\\Event",
          "scopes": ["published"],
          "limit": 6
        }
      }
    }
  ]
}

// Rendered via BlockData
@include($block->view, $block->data)
```

## Module Dependencies

### Xot
- **Depends on:** Nothing (core module)
- **Used by:** All modules

### Cms
- **Depends on:** Xot, Lang, Tenant
- **Used by:** All modules (for pages/blocks)

### Lang
- **Depends on:** Xot
- **Used by:** All modules (for translations)

### Tenant
- **Depends on:** Xot
- **Used by:** All modules (for config/storage)

### Meetup
- **Depends on:** Xot, Lang, Tenant, Cms
- **Used by:** Theme (for business logic)

### User
- **Depends on:** Xot, Lang, Tenant
- **Used by:** All modules (for auth)

### Other Modules
- **Depends on:** Xot, Lang, Tenant, (Cms if needed)
- **Used by:** As needed

## Service Provider Load Order

```
1. XotServiceProvider (core)
2. TenantServiceProvider (infrastructure)
3. LangServiceProvider (infrastructure)
4. CmsServiceProvider (content)
5. Module ServiceProviders (business logic)
6. ThemeServiceProvider (frontend)
```

## Configuration Flow

```
Request
  ↓
XotData::make()
  ↓
TenantService::getConfig('xra')
  ↓
config/local/{tenant}/xra.php
  ↓
Module configurations
  ↓
Theme registration
```

## Key Files Reference

### Configuration
- `config/local/{tenant}/xra.php` - Main configuration
- `config/local/{tenant}/database.php` - Database connections
- `config/laravellocalization.php` - Localization config

### Module Providers
- `Modules/Xot/app/Providers/XotServiceProvider.php`
- `Modules/Cms/app/Providers/CmsServiceProvider.php`
- `Modules/Cms/app/Providers/FolioVoltServiceProvider.php`
- `Modules/Lang/app/Providers/LangServiceProvider.php`
- `Modules/Tenant/app/Providers/TenantServiceProvider.php`
- `Themes/{theme}/app/Providers/ThemeServiceProvider.php`

### Core Classes
- `Modules/Xot/app/Datas/XotData.php`
- `Modules/Tenant/app/Services/TenantService.php`
- `Modules/Cms/app/Actions/ResolvePageAction.php`
- `Modules/Cms/app/Datas/BlockData.php`
- `Modules/Lang/app/Models/BaseModelLang.php`
- `Modules/Cms/app/Models/Traits/HasBlocks.php`

### Theme Files
- `Themes/{theme}/vite.config.js`
- `Themes/{theme}/package.json`
- `Themes/{theme}/resources/views/layouts/app.blade.php`
- `Themes/{theme}/resources/views/layouts/main.blade.php`
- `Themes/{theme}/resources/views/components/blocks/content-resolver.blade.php`

## Debugging Integration Issues

### Issue 1: Module Not Loading

**Symptoms:** Module not available, classes not found

**Debug:**
```bash
php artisan module:list
```

**Fix:**
```bash
php artisan module:enable {ModuleName}
```

### Issue 2: Theme Not Registered

**Symptoms:** Views not found, namespace errors

**Debug:**
```php
dump(config('xra.pub_theme'));
dump(XotData::make()->pub_theme);
```

**Fix:**
- Check ThemeServiceProvider is registered
- Check `register_pub_theme` is true in xra.php
- Clear config cache

### Issue 3: Config Not Loading

**Symptoms:** Config returns defaults, not tenant values

**Debug:**
```php
dump(TenantService::getName());
dump(TenantService::getConfig('xra'));
```

**Fix:**
- Verify tenant config file exists
- Check server name matches tenant name
- Clear config cache

### Issue 4: Translations Not Working

**Symptoms:** English text on Italian page

**Debug:**
```php
dump(app()->getLocale());
dump(__('pub_theme::home.title'));
```

**Fix:**
- Verify translation file exists
- Check locale is set correctly
- Clear cache

### Issue 5: Block Query Fails

**Symptoms:** Dynamic query returns empty

**Debug:**
```php
$queryConfig = [
    'model' => 'Modules\\Meetup\\Models\\Event',
    'scopes' => ['published'],
];
$action = app(ResolveBlockQueryAction::class);
$result = $action->execute($queryConfig);
dump($result);
```

**Fix:**
- Verify model class exists
- Check scope methods exist
- Remove restrictive scopes for testing

## Performance Optimization

### 1. Eager Load Relationships
```php
// In block query
'scopes' => ['withVenue', 'withSpeakers']
```

### 2. Cache Tenant Config
```php
// XotData::make() already caches instance
private static ?self $instance = null;
```

### 3. Cache Block Results
```php
// Cache query results
$cacheKey = 'block:' . $type . ':' . md5(json_encode($data));
$cached = cache($cacheKey);
```

### 4. Optimize View Loading
```php
// Use anonymous components
Blade::anonymousComponentPath($path);
Blade::anonymousComponentNamespace($namespace, $path);
```

## Security Considerations

### 1. Tenant Isolation
- Each tenant has separate config
- Database connections are tenant-specific
- Models are tenant-aware

### 2. Middleware Protection
- Page-specific middleware
- User type checking
- Auth verification

### 3. Input Validation
- Block data validation
- Query parameter sanitization
- View path validation

### 4. Access Control
- User roles and permissions
- Model policies
- Resource policies

## Migration Patterns

### Adding New Module

1. Create module structure
2. Extend Xot base classes
3. Register service provider
4. Add configuration
5. Create models (extending BaseModelLang)
6. Add routes
7. Create tests

### Adding New Theme

1. Create theme directory
2. Create ThemeServiceProvider
3. Configure in xra.php
4. Create layout components
5. Create block components
6. Add translations
7. Test all modules

### Converting Database to JSON

1. Export existing data
2. Create JSON files
3. Add SushiToJsons trait
4. Remove database tables
5. Update models
6. Test functionality

This reference provides a comprehensive understanding of how all modules integrate with each other and with the theme system in the LaravelPizza project.