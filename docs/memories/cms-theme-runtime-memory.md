# CMS Theme Runtime Memory

## Core Architecture Understanding

### 1. **Configuration-Driven Theme System**

The entire theme system is configuration-driven through `xra.php`:

```php
'main_module' => 'Meetup',
'pub_theme' => 'Meetup',
'register_pub_theme' => true,
```

**Key Insight:** Both main module and pub theme can be the same (Meetup), meaning the same module provides both business logic and frontend rendering.

### 2. **Multi-Layer Namespace Registration**

Views are registered with multiple namespaces for flexibility:

- **`pub_theme`** - Primary theme namespace (e.g., `pub_theme::components.hero`)
- **`cms`** - CMS module namespace (e.g., `cms::components.page`)
- **Module-specific** - Each module gets its own namespace

**Why?** Allows themes to override module components while maintaining clean separation.

### 3. **No Locale Middleware in Folio Routes**

**Critical Pattern:** Folio routes do NOT include locale-setting middleware to prevent serialization issues:

```php
// WRONG - Causes serialization issues
Folio::path($theme_path)
    ->uri($locale)
    ->middleware([
        '*' => [\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class]
    ]);

// CORRECT - No locale middleware
Folio::path($theme_path)
    ->uri($locale)
    ->middleware([
        '*' => $base_middleware  // web, auth, etc. only
    ]);
```

**Why?** Livewire/Volt components can't serialize middleware with dependencies.

### 4. **Locale Handled in Templates**

Locale is extracted from URL prefix in page templates:

```blade
@php
$locales = array_keys(config('laravellocalization.supportedLocales'));
if (in_array($slug, $locales, true)) {
    $slug = 'home';  // /it -> render home in Italian
}
@endphp
```

### 5. **Block-Based Content System**

Content is structured as blocks with JSON storage:

```json
{
  "type": "events-list",
  "data": {
    "title": "Upcoming Events",
    "view": "pub_theme::components.blocks.events.list",
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "scopes": ["published", "upcoming"],
      "limit": 6
    }
  }
}
```

**Key Components:**
- **Type** - Block identifier
- **Data** - Block configuration including query and view
- **View** - Blade template to render
- **Query** - Dynamic database query configuration

### 6. **Dynamic Query Resolution**

Blocks can query models dynamically:

```php
// In BlockData constructor
$query = Arr::get($data, 'query');
if (is_array($query)) {
    $dynamicData = app(ResolveBlockQueryAction::class)->execute($query);
    $data = array_merge($data, $dynamicData);
}
```

**Supported Query Options:**
- `model` - Eloquent model class
- `scopes` - Array of scope methods
- `orderBy` - Sort column
- `direction` - Sort direction (asc/desc)
- `limit` - Maximum results
- `wrap_in` - Key to wrap results in

### 7. **Page-Side Block Management**

Pages can have blocks in multiple areas:

```php
// Page model
protected array $schema = [
    'blocks' => 'json',           // Default blocks
    'content_blocks' => 'json',  // Main content area
    'sidebar_blocks' => 'json',  // Sidebar
    'footer_blocks' => 'json',   // Footer
];
```

**Usage:**
```blade
<x-page side="content" slug="home" />
<x-page side="sidebar" slug="home" />
<x-page side="footer" slug="home" />
```

### 8. **Middleware Per Page**

Each page can define custom middleware:

```json
{
  "slug": "admin-dashboard",
  "middleware": ["auth", "Modules\\User\\Http\\Middleware\\EnsureUserHasType:admin"]
}
```

**Execution:**
- `PageSlugMiddleware` loads middleware from page
- Executes middleware chain manually
- Supports middleware with parameters

### 9. **Blade Compilation in Blocks**

Blocks can contain Blade directives that get compiled:

```json
{
  "type": "dynamic",
  "data": {
    "content": "{{ auth()->user()->name ?? 'Guest' }}"
  }
}
```

**Compilation:**
```php
public function compile(array $blocks): array
{
    foreach ($blocks as $key => $value) {
        if (is_string($value) && Str::containsAll($value, ['{{', '}}'])) {
            $result[$key] = Blade::render($value);
        }
    }
    return $result;
}
```

### 10. **Livewire/Volt Auto-Detection**

`BlockData` automatically detects Livewire/Volt components:

```php
private function detectLivewire(string $view): bool
{
    $path = view()->getFinder()->find($view);
    $header = fread(fopen($path, 'r'), 1024);
    
    return str_contains($header, 'new class extends Component')
           || str_contains($header, 'Livewire\Volt\Component')
           || str_contains($header, 'volt(');
}
```

**Why?** Allows blocks to use reactive components without manual configuration.

## Critical Patterns to Remember

### Pattern 1: **Never Use Locale Middleware in Folio**

```php
// ❌ WRONG
Folio::path($theme_path)
    ->middleware([
        '*' => [LaravelLocalizationRoutes::class]
    ]);

// ✅ CORRECT
Folio::path($theme_path)
    ->middleware([
        '*' => ['web', 'auth']  // No locale middleware
    ]);
```

### Pattern 2: **Always Use pub_theme Namespace for Theme Components**

```blade
{{-- ❌ WRONG --}}
@include('meetup::components.hero')

{{-- ✅ CORRECT --}}
@include('pub_theme::components.hero')
```

### Pattern 3: **BlockData Handles Everything**

```blade
{{-- ❌ WRONG - Don't process blocks in template --}}
@foreach($blocks as $block)
    @php
        $view = $block['view'];
        $data = $block['data'];
    @endphp
    @include($view, $data)
@endforeach

{{-- ✅ CORRECT - BlockData already processed --}}
@foreach($blocks as $block)
    @include($block->view, $block->data)
@endforeach
```

### Pattern 4: **Use SushiToJsons for JSON Storage**

```php
// ❌ WRONG - Using database
protected $connection = 'mysql';

// ✅ CORRECT - Using JSON files
use SushiToJsons;
```

### Pattern 5: **Define Model Schemas Explicitly**

```php
protected array $schema = [
    'id' => 'integer',
    'title' => 'json',
    'slug' => 'string',
    'blocks' => 'json',
    'created_at' => 'datetime',
];
```

### Pattern 6: **Use Translatable for Multi-Language**

```php
public $translatable = [
    'title',
    'blocks',
    'content_blocks',
];
```

### Pattern 7: **Create BlockData Instances Manually**

```php
// ❌ WRONG - Laravel Data's collect() doesn't call constructor
$blocks = BlockData::collect($rawBlocks);

// ✅ CORRECT - Manual construction ensures constructor is called
foreach ($blocks as $key => $block) {
    $blockDataInstances[$key] = new BlockData(
        $block['type'],
        $block['data'],
        $block['slug']
    );
}
```

### Pattern 8: **Validate View Existence in Constructor**

```php
// ❌ WRONG - Validate only when rendering
public function render() {
    if (! view()->exists($this->view)) {
        throw new Exception('View not found');
    }
}

// ✅ CORRECT - Validate in constructor
public function __construct(string $type, array $data, ?string $slug = null) {
    // ...
    if (! view()->exists($this->view)) {
        throw new \Exception('view not found: '.$this->view);
    }
}
```

### Pattern 9: **Use Actions for Business Logic**

```php
// ❌ WRONG - Direct query in BlockData
$results = Event::query()->where('published', true)->get();

// ✅ CORRECT - Use Action
$action = app(ResolveBlockQueryAction::class);
$results = $action->execute($queryConfig);
```

### Pattern 10: **Wrap Query Results in Specified Key**

```php
// Query config
"wrap_in": "events"

// Result
['events' => [...]]  // Results wrapped in 'events' key
```

## Common Pitfalls

### Pitfall 1: **Forgetting to Compile Blade Directives**

```json
{
  "data": {
    "content": "{{ auth()->user()->name }}"
  }
}
```

**Without compilation:** Renders as `{{ auth()->user()->name }}`
**With compilation:** Renders as actual user name

### Pitfall 2: **Using Wrong Namespace**

```blade
{{-- ❌ WRONG - Namespace doesn't match config --}}
@include('meetup::components.hero')

{{-- ✅ CORRECT - Matches config('xra.pub_theme') --}}
@include('pub_theme::components.hero')
```

### Pitfall 3: **Not Defining Schema**

```php
// ❌ WRONG - No schema defined
class Page extends BaseModelLang {
    // ...
}

// ✅ CORRECT - Schema defined
class Page extends BaseModelLang {
    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        // ...
    ];
}
```

### Pitfall 4: **Using Database Instead of JSON**

```php
// ❌ WRONG - Uses database migration
Schema::create('pages', function (Blueprint $table) {
    $table->id();
    $table->json('blocks');
});

// ✅ CORRECT - Uses JSON file
use SushiToJsons;
// Data stored in config/local/laravelpizza/database/content/pages/
```

### Pitfall 5: **Adding Locale Middleware to Folio**

```php
// ❌ WRONG - Causes serialization issues
Folio::path($theme_path)
    ->middleware([
        '*' => [LaravelLocalizationRoutes::class]
    ]);

// ✅ CORRECT - No locale middleware
Folio::path($theme_path)
    ->middleware([
        '*' => ['web', 'auth']
    ]);
```

## Performance Optimization Patterns

### Pattern 1: **Eager Load Relationships**

```json
{
  "query": {
    "model": "Modules\\Meetup\\Models\\Event",
    "scopes": ["withVenue", "withSpeakers"]
  }
}
```

```php
// In Event model
public function scopeWithVenue($query)
{
    return $query->with('venue');
}

public function scopeWithSpeakers($query)
{
    return $query->with('speakers');
}
```

### Pattern 2: **Limit Query Results**

```json
{
  "query": {
    "limit": 10
  }
}
```

### Pattern 3: **Use Database Indexes**

```php
// In migration
$table->index('slug');
$table->index('published_at');
$table->index('date');
```

### Pattern 4: **Cache Block Results**

```php
// In BlockData constructor
$cacheKey = 'block:' . $type . ':' . md5(json_encode($data));
$cached = cache($cacheKey);

if ($cached) {
    $this->data = $cached;
    return;
}

// ... resolve query ...

cache([$cacheKey => $this->data], now()->addHours(1));
```

## Security Patterns

### Pattern 1: **Validate User Input**

```php
// In PageSlugMiddleware
if (! preg_match('/^[a-z0-9-]+$/', $slug)) {
    abort(404);
}
```

### Pattern 2: **Use Auth Middleware**

```json
{
  "middleware": ["auth"],
  "slug": "admin-dashboard"
}
```

### Pattern 3: **Sanitize Block Data**

```php
// In BlockData constructor
$this->data = array_map(function ($value) {
    return is_string($value) ? strip_tags($value) : $value;
}, $data);
```

### Pattern 4: **Escape Output**

```blade
{{-- Safe escaping --}}
{{ $content }}

{{-- Only for trusted content --}}
{!! $content !!}
```

## Testing Patterns

### Pattern 1: **Test BlockData Construction**

```php
test('BlockData resolves dynamic query', function () {
    $action = app(ResolveBlockQueryAction::class);
    
    $result = $action->execute([
        'model' => Page::class,
        'limit' => 5
    ]);
    
    expect($result)->toHaveKey('items');
    expect($result['items'])->toHaveCount(5);
});
```

### Pattern 2: **Test Page Rendering**

```php
test('page renders with blocks', function () {
    $response = $this->get('/it/home');
    
    $response->assertStatus(200);
    $response->assertSee('Welcome');
});
```

### Pattern 3: **Test Middleware Execution**

```php
test('admin page requires auth', function () {
    $response = $this->get('/it/admin');
    
    $response->assertRedirect('/login');
});
```

## Debugging Patterns

### Pattern 1: **Enable Debug Logging**

```php
// In BlockData constructor
Log::debug('BlockData construction:', [
    'type' => $type,
    'data' => $data,
    'view' => $view,
    'exists' => view()->exists($view)
]);
```

### Pattern 2: **Dump Block Data**

```blade
@php
dd($blocks);
@endphp
```

### Pattern 3: **Check Query Results**

```php
// In ResolveBlockQueryAction
Log::debug('Query results:', $results->toArray());
```

## Migration Patterns

### Pattern 1: **From Static Pages**

1. Create Page model with slug
2. Define blocks in JSON
3. Update Folio route

### Pattern 2: **From Database Content**

1. Export content from database
2. Create Page models
3. Define blocks
4. Update references

### Pattern 3: **Theme Migration**

1. Create new theme directory
2. Register in `xra.php`
3. Copy/modify components
4. Test all pages

## Integration Patterns

### Pattern 1: **Module Provides Components**

```
Modules/Meetup/resources/views/components/
└── blocks/
    └── event.blade.php
```

Usage: `meetup::components.blocks.event`

### Pattern 2: **Theme Overrides Module**

```
Themes/Meetup/resources/views/components/
└── blocks/
    └── event.blade.php
```

Usage: `pub_theme::components.blocks.event`

### Pattern 3: **Theme Provides Custom Blocks**

```
Themes/Meetup/resources/views/components/
└── blocks/
    └── hero.blade.php
```

Usage: `pub_theme::components.blocks.hero`

## Error Resolution Patterns

### Error 1: **View Not Found**

```
view not found: pub_theme::components.blocks.unknown
```

**Solution:**
1. Check view path is correct
2. Verify theme is registered
3. Check namespace spelling

### Error 2: **Class Not Found**

```
Class "Modules\Unknown\Model" not found
```

**Solution:**
1. Verify model exists
2. Check namespace spelling
3. Ensure module is enabled

### Error 3: **Undefined Method**

```
Call to undefined method getBlocks()
```

**Solution:**
1. Add `use HasBlocks` trait to model
2. Verify trait is imported

### Error 4: **Middleware Not Executing**

```
Page accessible without authentication
```

**Solution:**
1. Check Page model has middleware
2. Verify middleware is registered
3. Check `PageSlugMiddleware` is applied

## Best Practices Summary

1. **Always use `pub_theme` namespace for theme components**
2. **Never add locale middleware to Folio routes**
3. **Define explicit model schemas**
4. **Use SushiToJsons for JSON storage**
5. **Use actions for business logic**
6. **Validate view existence in constructor**
7. **Eager load relationships**
8. **Limit query results**
9. **Cache block results**
10. **Use auth middleware for protected pages**

## File Location Quick Reference

```
Configuration:
└── laravel/config/local/laravelpizza/xra.php

Service Providers:
├── laravel/Themes/{theme}/app/Providers/ThemeServiceProvider.php
├── laravel/Modules/Cms/app/Providers/CmsServiceProvider.php
└── laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php

Models:
├── laravel/Modules/Cms/app/Models/Page.php
├── laravel/Modules/Cms/app/Models/PageContent.php
└── laravel/Modules/Cms/app/Models/Traits/HasBlocks.php

Actions:
└── laravel/Modules/Cms/app/Actions/ResolveBlockQueryAction.php

Datas:
└── laravel/Modules/Cms/app/Datas/BlockData.php

Middleware:
└── laravel/Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php

Views:
├── laravel/Themes/{theme}/resources/views/
│   ├── pages/
│   │   ├── index.blade.php
│   │   └── [slug].blade.php
│   └── components/
│       └── blocks/
└── laravel/Modules/Cms/resources/views/components/
    └── page.blade.php

Page Data:
└── laravel/config/local/laravelpizza/database/content/pages/
    └── {page-slug}.json
```

## Key Takeaways

1. **Configuration-Driven:** Everything starts with `xra.php`
2. **Namespace Isolation:** Multiple namespaces prevent conflicts
3. **No Locale Middleware:** Handle locale in templates, not middleware
4. **Block-Based:** Content is structured as reusable blocks
5. **Dynamic Queries:** Blocks can query models dynamically
6. **JSON Storage:** Page data stored in JSON files via SushiToJsons
7. **Auto-Detection:** Livewire/Volt components detected automatically
8. **Blade Compilation:** Blade directives in blocks get compiled
9. **Page Middleware:** Each page can have custom middleware
10. **Multi-Language:** Built-in translation support

This memory document should help you quickly recall the core architecture and patterns of the CMS Theme Template system when working on chaos monkey scenarios or troubleshooting issues.