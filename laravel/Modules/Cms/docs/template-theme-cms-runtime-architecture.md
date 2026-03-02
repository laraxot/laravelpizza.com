# Template, Theme, and CMS Runtime Architecture

## Overview

This document describes the complete runtime architecture of the Template, Theme, and CMS systems in the LaravelPizza project. It covers the complete flow from configuration to rendered pages.

## Architecture Components

### 1. Configuration Layer

#### 1.1 XotData Configuration

**Location:** `laravel/config/local/laravelpizza/xra.php`

```php
return [
    'main_module' => 'Meetup',      // Primary business logic module
    'pub_theme' => 'Meetup',         // Active frontend theme
    'register_pub_theme' => true,    // Enable theme registration
    // ... other config
];
```

**Key Points:**
- `main_module`: Defines which module provides core functionality
- `pub_theme`: Defines which theme renders the frontend
- Both can point to the same module (e.g., Meetup)
- Theme registration is controlled by `register_pub_theme` flag

### 2. Theme Registration Layer

#### 2.1 ThemeServiceProvider

**Location:** `laravel/Themes/Meetup/app/Providers/ThemeServiceProvider.php`

```php
public function boot(): void
{
    // Register translations with 'pub_theme' namespace
    $this->loadTranslationsFrom(__DIR__.'/../../lang', 'pub_theme');
    
    // Register views with 'pub_theme' and 'meetup' namespaces
    $this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
    $this->loadViewsFrom(__DIR__.'/../../resources/views', 'meetup');
    
    // Register custom routes
    $this->registerRoutes();
}
```

**Key Points:**
- Translations loaded with `pub_theme` namespace (e.g., `__('pub_theme::home.title')`)
- Views loaded with both `pub_theme` and `meetup` namespaces
- Theme can register custom routes (e.g., event booking)

#### 2.2 CmsServiceProvider

**Location:** `laravel/Modules/Cms/app/Providers/CmsServiceProvider.php`

```php
public function registerNamespaces(string $theme_type): void
{
    // theme_type = 'pub_theme' for frontend themes
    $theme_path = 'Themes/'.$theme;
    $resource_path = $theme_path.'/resources';
    
    // Add theme views to Laravel's view paths
    $theme_dir = base_path($resource_path.'/views');
    $viewFactory = app('view');
    $viewFactory->addNamespace($theme_type, $theme_dir);
    
    // Register anonymous Blade components
    $componentViewPath = base_path($resource_path.'/views/components');
    Blade::anonymousComponentPath($componentViewPath);
    
    // Register component namespace
    Blade::anonymousComponentNamespace(
        $theme_type.'::',
        base_path($resource_path.'/views')
    );
}
```

**Key Points:**
- Theme views registered as Laravel namespace (e.g., `pub_theme::pages.index`)
- Anonymous Blade components auto-discovered
- Component namespace allows `x-pub_theme::component` syntax

### 3. Routing Layer

#### 3.1 FolioVoltServiceProvider

**Location:** `laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php`

```php
public function boot(): void
{
    // Get supported locales from LaravelLocalization
    $supportedLocales = array_keys(config('laravellocalization.supportedLocales'));
    
    // Register Folio paths for each locale WITHOUT locale-setting middleware
    foreach ($supportedLocales as $locale) {
        Folio::path($theme_path)
            ->uri($locale)  // e.g., /it, /en, /de
            ->middleware([
                '*' => $base_middleware,  // web, auth, etc. - NO locale middleware
            ]);
    }
    
    // Mount Volt components for dynamic Livewire functionality
    Volt::mount($paths);
}
```

**Key Points:**
- **NO locale-setting middleware** in Folio routes (prevents serialization issues)
- Locale is set in page templates instead
- Each locale gets its own URL prefix (e.g., `/it/events`, `/en/events`)
- Volt mounted for all view paths (theme + modules)

### 4. Page Resolution Layer

#### 4.1 Page Model

**Location:** `laravel/Modules/Cms/app/Models/Page.php`

```php
class Page extends BaseModelLang
{
    use HasBlocks;
    use SushiToJsons;
    
    public $translatable = [
        'title',
        'blocks',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];
    
    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'middleware' => 'json',
        'content' => 'string',
        'blocks' => 'json',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        // ...
    ];
    
    public static function getMiddlewareBySlug(string $slug): array
    {
        $page = self::where('slug', $slug)->first();
        return $page->middleware ?? [];
    }
}
```

**Key Points:**
- Pages use `SushiToJsons` trait for JSON file-based storage
- Translatable fields for multi-language content
- Multiple block arrays: `blocks`, `content_blocks`, `sidebar_blocks`, `footer_blocks`
- Middleware defined per-page (e.g., auth, doctor-only)

#### 4.2 PageSlugMiddleware

**Location:** `laravel/Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php`

```php
public function handle(Request $request, \Closure $next): Response
{
    $slug = $request->route('slug');
    
    // Get middleware from Page model
    $middlewares = Page::getMiddlewareBySlug($slug);
    
    // Execute middleware chain manually
    return $this->executeMiddlewareChain($request, $middlewares, $next);
}
```

**Key Points:**
- Dynamically loads middleware based on page slug
- Supports middleware with parameters (e.g., `auth:doctor`)
- Executes middleware chain in correct order

### 5. Page Template Layer

#### 5.1 Index Page (Home)

**Location:** `laravel/Themes/Meetup/resources/views/pages/index.blade.php`

```blade
<?php
use function Laravel\Folio\{middleware, name};
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('home');
middleware(PageSlugMiddleware::class);

new class extends Component {};
?>

<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" />
        </div>
    @endvolt
</x-layouts.app>
```

#### 5.2 Dynamic Slug Page

**Location:** `laravel/Themes/Meetup/resources/views/pages/[slug].blade.php`

```blade
<?php
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('pages.view');
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $slug;
};
?>

@php
// Handle locale redirects (e.g., /it -> render home in Italian)
$locales = array_keys(config('laravellocalization.supportedLocales'));
if (in_array($slug, $locales, true)) {
    $slug = 'home';
}

// Handle auth routes (login, register, etc.)
$authRoutes = ['login', 'register', 'password', 'verify'];
if (in_array($slug, $authRoutes)) {
    $authPage = 'auth.' . $slug;
    echo view($authPage);
    return;
}
@endphp

<x-layouts.app>
    @volt('pages.view')
    <div>
        <x-page side="content" :slug="$slug" />
    </div>
    @endvolt
</x-layouts.app>
```

**Key Points:**
- Volt components used for reactive functionality
- Locale redirects handled in template
- Auth routes redirected to auth views
- `<x-page>` component renders blocks

### 6. Block System Layer

#### 6.1 HasBlocks Trait

**Location:** `laravel/Modules/Cms/app/Models/Traits/HasBlocks.php`

```php
public function getBlocks(?string $side = null): array
{
    $field = $side ? $side.'_blocks' : 'blocks';
    $blocks = $this->{$field};
    
    // Get blocks in primary language if not array
    if (! is_array($blocks)) {
        $primary_lang = XotData::make()->primary_lang;
        $blocks = $this->getTranslation($field, $primary_lang);
    }
    
    // Compile Blade directives in blocks
    $blocks = $this->compile($blocks);
    
    // Create BlockData instances
    $blockDataInstances = [];
    foreach ($blocks as $key => $block) {
        $type = (string) ($block['type'] ?? 'unknown');
        $data = (array) ($block['data'] ?? []);
        $slug = isset($block['slug']) ? (string) $block['slug'] : null;
        
        $blockDataInstances[(string) $key] = new BlockData($type, $data, $slug);
    }
    
    return $blockDataInstances;
}

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

**Key Points:**
- Supports side-specific blocks (content, sidebar, footer)
- Compiles Blade directives in block data
- Creates `BlockData` instances for type safety
- Static `getBlocksBySlug()` for reusable blocks

#### 6.2 BlockData

**Location:** `laravel/Modules/Cms/app/Datas/BlockData.php`

```php
public function __construct(string $type, array $data, ?string $slug = null)
{
    $this->type = $type;
    $this->slug = $slug;
    
    // Resolve dynamic queries
    $query = Arr::get($data, 'query');
    if (is_array($query)) {
        $dynamicData = app(ResolveBlockQueryAction::class)->execute($query);
        $data = array_merge($data, $dynamicData);
    }
    
    $this->data = $data;
    $this->view = Arr::get($data, 'view', 'ui::empty');
    
    // Validate view exists
    if (! view()->exists($this->view)) {
        throw new \Exception('view not found: '.$this->view);
    }
    
    // Detect Livewire/Volt components
    $this->livewire = $this->detectLivewire($this->view);
    if ($this->livewire) {
        $this->livewireComponentName = $this->normalizeComponentName($this->view);
    }
}
```

**Key Points:**
- Resolves dynamic queries via `ResolveBlockQueryAction`
- Validates view existence
- Detects Livewire/Volt components automatically
- Normalizes component names for Volt

#### 6.3 ResolveBlockQueryAction

**Location:** `laravel/Modules/Cms/app/Actions/ResolveBlockQueryAction.php`

```php
public function execute(array $queryConfig): array
{
    $modelClass = data_get($queryConfig, 'model');
    $query = (new $modelClass())->newQuery();
    
    // Apply scopes
    $scopes = (array) data_get($queryConfig, 'scopes', []);
    foreach ($scopes as $scope) {
        try {
            $query->{$scope}();
        } catch (\BadMethodCallException $e) {
            // Skip non-existent scopes
        }
    }
    
    // Apply ordering and limit
    $orderBy = (string) data_get($queryConfig, 'orderBy', 'created_at');
    $direction = (string) data_get($queryConfig, 'direction', 'desc');
    $limit = (int) data_get($queryConfig, 'limit', 10);
    
    $query->orderBy($orderBy, $direction)->limit($limit);
    
    $results = $query->get();
    
    // Transform results
    $transformedItems = $results->map(function (Model $item): array {
        return method_exists($item, 'toBlockArray') 
            ? $item->toBlockArray() 
            : $item->toArray();
    })->toArray();
    
    $wrapIn = data_get($queryConfig, 'wrap_in', 'items');
    return [$wrapIn => $transformedItems];
}
```

**Key Points:**
- Queries models dynamically
- Applies scopes, ordering, and limits
- Transforms results using `toBlockArray()` if available
- Wraps results in specified key (default: 'items')

### 7. Block Rendering Layer

#### 7.1 Page Component

**Location:** `laravel/Modules/Cms/resources/views/components/page.blade.php`

```blade
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            {{-- BlockData has already handled view resolution, data, and fallback --}}
            @include($block->view, $block->data)
        @endforeach
    </div>
@endif
```

**Key Points:**
- Receives `BlockData` instances
- Includes each block's view with its data
- No additional processing needed (all in BlockData)

## Complete Runtime Flow

### Home Page Request (`/it`)

1. **Request:** User visits `https://example.com/it`
2. **Folio Routing:** Matches `index.blade.php` with URI `it`
3. **Middleware:** `PageSlugMiddleware` executes
4. **Template Rendering:**
   ```blade
   <x-page side="content" slug="home" />
   ```
5. **Page Component:** Receives `side="content"`, `slug="home"`
6. **Block Retrieval:** `Page::where('slug', 'home')->first()->getBlocks('content')`
7. **Block Processing:**
   - For each block in JSON:
     - Compile Blade directives
     - Create `BlockData` instance
     - Resolve dynamic queries
     - Validate view exists
8. **Rendering:**
   ```blade
   @foreach($blocks as $block)
       @include($block->view, $block->data)
   @endforeach
   ```
9. **Output:** Fully rendered HTML page

### Dynamic Page Request (`/it/events`)

1. **Request:** User visits `https://example.com/it/events`
2. **Folio Routing:** Matches `[slug].blade.php` with URI `it/events`
3. **Middleware:** `PageSlugMiddleware` loads middleware from Page with slug="events"
4. **Template Rendering:**
   ```blade
   <x-page side="content" slug="events" />
   ```
5. **Page Component:** Same flow as home page
6. **Block Retrieval:** `Page::where('slug', 'events')->first()->getBlocks('content')`
7. **Block Processing:** Same flow as home page
8. **Rendering:** Same flow as home page
9. **Output:** Fully rendered HTML page

## Dynamic Query Example

### Block JSON Definition

```json
{
  "type": "events-list",
  "data": {
    "title": "Upcoming Events",
    "view": "pub_theme::components.blocks.events.list",
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "scopes": ["published", "upcoming"],
      "orderBy": "date",
      "direction": "asc",
      "limit": 6,
      "wrap_in": "events"
    }
  }
}
```

### Execution Flow

1. **BlockData Constructor:**
   ```php
   $query = [
       'model' => 'Modules\\Meetup\\Models\\Event',
       'scopes' => ['published', 'upcoming'],
       'orderBy' => 'date',
       'direction' => 'asc',
       'limit' => 6,
       'wrap_in' => 'events'
   ];
   ```

2. **ResolveBlockQueryAction:**
   ```php
   $model = new \Modules\Meetup\Models\Event();
   $query = $model->newQuery()
       ->published()      // Scope method
       ->upcoming()       // Scope method
       ->orderBy('date', 'asc')
       ->limit(6);
   ```

3. **Results Transformation:**
   ```php
   $results = $query->get();  // Collection of Event models
   $transformed = $results->map(fn($event) => $event->toBlockArray());
   ```

4. **Final Data:**
   ```php
   $this->data = [
       'title' => 'Upcoming Events',
       'view' => 'pub_theme::components.blocks.events.list',
       'events' => [  // <-- wrapped in 'events' key
           ['id' => 1, 'title' => 'Laravel Meetup', 'date' => '2024-03-15', ...],
           ['id' => 2, 'title' => 'PHP Conference', 'date' => '2024-04-20', ...],
           // ...
       ]
   ];
   ```

5. **Template Rendering:**
   ```blade
   {{-- pub_theme/components/blocks/events/list.blade.php --}}
   <h2>{{ $title }}</h2>
   <div class="events-grid">
       @foreach($events as $event)
           <div class="event-card">
               <h3>{{ $event['title'] }}</h3>
               <p>{{ $event['date'] }}</p>
           </div>
       @endforeach
   </div>
   ```

## Theme Customization Points

### 1. Override CMS Components

```blade
{{-- Create in: laravel/Themes/Meetup/resources/views/components/page.blade.php --}}
@props(['blocks', 'side', 'slug', 'page'])

<div class="custom-page-wrapper">
    @if(!empty($blocks))
        @foreach($blocks as $block)
            {{-- Custom rendering --}}
            @if($block->type === 'hero')
                <x-hero :data="$block->data" />
            @else
                @include($block->view, $block->data)
            @endif
        @endforeach
    @endif
</div>
```

### 2. Add Custom Block Components

```blade
{{-- Create in: laravel/Themes/Meetup/resources/views/components/blocks/hero.blade.php --}}
@props(['data'])

<div class="hero-section" style="background: {{ $data['background'] ?? '#000' }}">
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['subtitle'] }}</p>
</div>
```

### 3. Add Custom Page Templates

```blade
{{-- Create in: laravel/Themes/Meetup/resources/views/pages/events.blade.php --}}
<?php
use function Laravel\Folio\name;
name('events.list');
?>

<x-layouts.app>
    @volt('events.list')
        <div class="events-page">
            <h1>Events</h1>
            <x-page side="content" slug="events-list" />
        </div>
    @endvolt
</x-layouts.app>
```

## Integration Points

### 1. Module to Theme

- Modules can provide view components in `resources/views/`
- Themes can override module components by creating same path
- Example: `Modules/Meetup/resources/views/components/blocks/event.blade.php`
  - Theme override: `Themes/Meetup/resources/views/components/blocks/event.blade.php`

### 2. CMS to Theme

- CMS provides base page component
- Themes can override for custom layouts
- Blocks can reference theme components via namespace

### 3. Theme to Module

- Themes can use module models in dynamic queries
- Theme components can call module actions
- Example block query:
  ```json
  {
    "query": {
      "model": "Modules\\Meetup\\Models\\Event"
    }
  }
  ```

## Performance Considerations

### 1. Block Compilation

- Blade directives compiled once per block
- Results cached in `BlockData` instances
- No re-compilation on subsequent renders

### 2. Query Resolution

- Dynamic queries executed during `BlockData` construction
- Results wrapped and stored in `$this->data`
- No additional queries during rendering

### 3. View Resolution

- View existence validated once during construction
- No repeated filesystem checks
- Livewire detection via file header (not full read)

### 4. Middleware Chain

- Page middleware loaded once per request
- Chain execution optimized
- No middleware re-registration

## Security Considerations

### 1. Dynamic Query Resolution

- Only executes queries from trusted JSON files
- Model class existence validated
- Scope failures caught and ignored

### 2. View Validation

- View existence validated before inclusion
- Prevents directory traversal via `..` in paths
- Namespace isolation via Laravel view finder

### 3. Middleware Execution

- Middleware class resolution via HTTP kernel aliases
- Only registered middleware can be executed
- Parameters validated and sanitized

## Multi-Language Support

### 1. Page Translations

```php
// Page model
public $translatable = [
    'title',
    'blocks',
    'content_blocks',
    'sidebar_blocks',
    'footer_blocks',
];
```

### 2. Locale Detection

- Locale extracted from URL prefix (e.g., `/it/events`)
- No middleware-based locale setting (prevents serialization)
- Locale set in page templates if needed

### 3. Block Translations

- Block data can contain translatable strings
- Use `__('pub_theme::key')` for translations
- Dynamic query results can be model-specific translations

## Testing Considerations

### 1. Unit Tests

- Test `BlockData` construction
- Test `ResolveBlockQueryAction` execution
- Test `HasBlocks` trait methods

### 2. Feature Tests

- Test page rendering with blocks
- Test dynamic query resolution
- Test middleware execution

### 3. Integration Tests

- Test complete flow from request to output
- Test theme overrides
- Test multi-language rendering

## Common Patterns

### 1. Reusable Page Content

```php
// Create PageContent with blocks
$content = PageContent::create([
    'name' => 'Event Call to Action',
    'slug' => 'event-cta',
    'blocks' => [
        [
            'type' => 'cta',
            'data' => [
                'title' => 'Join Us',
                'button_text' => 'Register',
                'button_url' => '/events/register'
            ]
        ]
    ]
]);

// Use in any page
$page->blocks = [
    [
        'type' => 'page_content',
        'data' => [
            'slug' => 'event-cta'
        ]
    ]
];
```

### 2. Conditional Block Rendering

```json
{
  "type": "conditional",
  "data": {
    "view": "ui::conditional",
    "condition": "{{ auth()->check() }}",
    "true_block": {
      "type": "welcome",
      "data": {"title": "Welcome back!"}
    },
    "false_block": {
      "type": "login_cta",
      "data": {"title": "Please login"}
    }
  }
}
```

### 3. Nested Blocks

```json
{
  "type": "container",
  "data": {
    "view": "ui::container",
    "title": "Featured Content",
    "blocks": [
      {
        "type": "hero",
        "data": {"title": "Main Feature"}
      },
      {
        "type": "grid",
        "data": {
          "columns": 3,
          "blocks": [
            {"type": "card", "data": {"title": "Card 1"}},
            {"type": "card", "data": {"title": "Card 2"}},
            {"type": "card", "data": {"title": "Card 3"}}
          ]
        }
      }
    ]
  }
}
```

## Troubleshooting

### 1. View Not Found

**Error:** `view not found: pub_theme::components.blocks.unknown`

**Solution:**
- Check view path is correct
- Verify theme is registered
- Check namespace spelling

### 2. Query Execution Failed

**Error:** `Class "Modules\Unknown\Model" not found`

**Solution:**
- Verify model class exists
- Check namespace spelling
- Ensure module is enabled

### 3. Middleware Not Executing

**Error:** Page accessible without authentication

**Solution:**
- Check Page model has correct middleware
- Verify middleware is registered in HTTP kernel
- Check `PageSlugMiddleware` is applied

### 4. Blocks Not Rendering

**Error:** Empty page content

**Solution:**
- Check Page model has blocks in correct field
- Verify `BlockData` construction succeeds
- Check view exists and is valid

## Future Enhancements

### 1. Block Caching

- Cache compiled blocks
- Cache query results
- Cache view rendering

### 2. Block Inheritance

- Define base block templates
- Extend and override in child blocks
- Mixin common block functionality

### 3. Block Preview

- Preview blocks in admin panel
- Live edit blocks
- Visual block builder

### 4. Block Versioning

- Track block changes
- Rollback to previous versions
- A/B testing for blocks

## Conclusion

The Template, Theme, and CMS systems in LaravelPizza provide a flexible, powerful architecture for building dynamic, multi-language websites. The separation of concerns between configuration, routing, models, and rendering allows for easy customization and extension while maintaining performance and security.

The block-based content system enables developers to create reusable, composable content components that can be dynamically queried and rendered across multiple pages and themes.