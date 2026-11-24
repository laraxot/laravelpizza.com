# Chaos Monkey Debugging Skills

## Overview

This document provides debugging skills and patterns for fixing the LaravelPizza project when "chaos monkey" scenarios occur. These skills are essential for reasoning through and resolving issues in the Template, Theme, and CMS systems.

## Core Debugging Philosophy

1. **Understand Before Fixing** - Always understand the architecture before making changes
2. **Follow the Flow** - Trace the complete request lifecycle
3. **Check Configuration First** - Many issues stem from misconfiguration
4. **Validate Assumptions** - Don't assume something works without testing
5. **Use Systematic Approach** - Start with the most likely cause

## Common Chaos Monkey Scenarios

### Scenario 1: Page Returns 404

**Symptoms:**
- Visiting `/it/events` returns 404
- Page exists in JSON but not accessible

**Debugging Steps:**

1. **Check Folio Route Registration:**
   ```bash
   php artisan route:list --path=it/events
   ```

2. **Verify Page Exists:**
   ```php
   $page = Page::where('slug', 'events')->first();
   dump($page);  // Should return Page instance
   ```

3. **Check Page Template:**
   ```bash
   ls -la laravel/Themes/Meetup/resources/views/pages/[slug].blade.php
   ```

4. **Verify Middleware:**
   ```php
   $middleware = Page::getMiddlewareBySlug('events');
   dump($middleware);  // Should return array
   ```

5. **Check Folio Configuration:**
   ```php
   $theme_path = XotData::make()->getPubThemeViewPath('pages');
   dump($theme_path);  // Should point to theme pages directory
   ```

**Common Causes:**
- Page slug doesn't match URL
- Folio not registered for locale
- Page template missing
- Middleware blocking access

**Fixes:**
```php
// Fix 1: Update page slug
Page::where('slug', 'old-slug')->update(['slug' => 'events']);

// Fix 2: Ensure Folio is registered
// Check FolioVoltServiceProvider is registered

// Fix 3: Fix middleware
// Remove or update blocking middleware in page JSON
```

### Scenario 2: Blocks Not Rendering

**Symptoms:**
- Page loads but content area is empty
- No error messages in logs

**Debugging Steps:**

1. **Check Page Has Blocks:**
   ```php
   $page = Page::where('slug', 'home')->first();
   dump($page->blocks);  // Should return array
   ```

2. **Check BlockData Construction:**
   ```php
   $blocks = $page->getBlocks('content');
   foreach ($blocks as $block) {
       dump([
           'type' => $block->type,
           'view' => $block->view,
           'exists' => view()->exists($block->view),
           'data' => $block->data
       ]);
   }
   ```

3. **Check View Path:**
   ```bash
   # Find view file
   find laravel -name "hero.blade.php"
   ```

4. **Check View Namespace:**
   ```php
   $view = 'pub_theme::components.blocks.hero';
   dump(view()->exists($view));  // Should be true
   ```

5. **Check for View Errors:**
   ```blade
   @php
   try {
       echo view($block->view, $block->data);
   } catch (\Exception $e) {
       dump($e->getMessage());
   }
   @endphp
   ```

**Common Causes:**
- Blocks array is empty
- View path is incorrect
- View namespace is wrong
- View has syntax errors
- BlockData construction failed

**Fixes:**
```php
// Fix 1: Add blocks to page
Page::where('slug', 'home')->update([
    'blocks' => [
        [
            'type' => 'hero',
            'data' => [
                'title' => 'Welcome',
                'view' => 'pub_theme::components.blocks.hero'
            ]
        ]
    ]
]);

// Fix 2: Fix view path
// Update view in block data to correct path

// Fix 3: Fix namespace
// Change 'meetup::' to 'pub_theme::'
```

### Scenario 3: Dynamic Query Fails

**Symptoms:**
- Block renders but no data
- Query returns empty array

**Debugging Steps:**

1. **Check Query Config:**
   ```php
   $blockData = new BlockData('events-list', [
       'query' => [
           'model' => 'Modules\\Meetup\\Models\\Event',
           'scopes' => ['published'],
           'limit' => 6
       ]
   ]);
   dump($blockData->data);  // Check if 'items' key exists
   ```

2. **Test Query Directly:**
   ```php
   $model = new \Modules\Meetup\Models\Event();
   $query = $model->newQuery()
       ->published()
       ->limit(6);
   dump($query->get()->toArray());  // Should return results
   ```

3. **Check Scope Methods:**
   ```php
   $model = new \Modules\Meetup\Models\Event();
   dump(method_exists($model, 'scopePublished'));  // Should be true
   ```

4. **Check Model Exists:**
   ```php
   dump(class_exists('Modules\\Meetup\\Models\\Event'));  // Should be true
   ```

5. **Enable Query Logging:**
   ```php
   \DB::enableQueryLog();
   $results = $query->get();
   dump(\DB::getQueryLog());  // See actual SQL
   ```

**Common Causes:**
- Model class doesn't exist
- Scope method doesn't exist
- No matching records in database
- Query conditions too restrictive
- Model disabled/missing

**Fixes:**
```php
// Fix 1: Fix model class
'query' => [
    'model' => 'Modules\\Meetup\\Models\\Event'  // Correct namespace
]

// Fix 2: Fix scope names
'query' => [
    'scopes' => ['published']  // Ensure scope exists
]

// Fix 3: Remove restrictive scopes
'query' => [
    'scopes' => []  // Remove scopes for testing
]
```

### Scenario 4: Middleware Not Executing

**Symptoms:**
- Protected page accessible without authentication
- Middleware defined but not working

**Debugging Steps:**

1. **Check Page Middleware:**
   ```php
   $middleware = Page::getMiddlewareBySlug('admin-dashboard');
   dump($middleware);  // Should return array
   ```

2. **Check Middleware Registration:**
   ```php
   $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
   dump($kernel->getRouteMiddleware());  // Should include middleware
   ```

3. **Check PageSlugMiddleware:**
   ```bash
   # Verify middleware is registered
   grep -r "PageSlugMiddleware" laravel/app/Http/Kernel.php
   ```

4. **Test Middleware Directly:**
   ```php
   $middleware = new PageSlugMiddleware();
   $request = Request::create('/it/admin-dashboard');
   $response = $middleware->handle($request, function ($req) {
       return response('OK');
   });
   dump($response->getStatusCode());  // Should be 200 or 401
   ```

5. **Check Auth Middleware:**
   ```php
   dump(auth()->check());  // Should be false for guest
   ```

**Common Causes:**
- PageSlugMiddleware not registered
- Middleware not in HTTP kernel
- Middleware alias incorrect
- Auth not configured

**Fixes:**
```php
// Fix 1: Register PageSlugMiddleware
// Add to Folio routes
middleware(PageSlugMiddleware::class);

// Fix 2: Register auth middleware
// Add to HTTP kernel route middleware

// Fix 3: Fix middleware alias
'auth' => \App\Http\Middleware\Authenticate::class
```

### Scenario 5: Translation Not Working

**Symptoms:**
- English text showing on Italian page
- Translations not loading

**Debugging Steps:**

1. **Check Locale:**
   ```php
   dump(app()->getLocale());  // Should be 'it'
   dump(config('app.locale'));  // Should be 'it'
   ```

2. **Check Translation Files:**
   ```bash
   ls -la laravel/Themes/Meetup/lang/it/
   ls -la laravel/Themes/Meetup/lang/en/
   ```

3. **Check Translation Key:**
   ```php
   $key = 'pub_theme::home.title';
   dump(__($key));  // Should return Italian text
   ```

4. **Check Theme Registration:**
   ```php
   $provider = app(\Themes\Meetup\Providers\ThemeServiceProvider::class);
   dump($provider);  // Should be registered
   ```

5. **Check Translatable Fields:**
   ```php
   $page = Page::where('slug', 'home')->first();
   dump($page->title);  // Should return array with translations
   dump($page->getTranslation('title', 'it'));  // Should return Italian
   ```

**Common Causes:**
- Locale not set correctly
- Translation file missing
- Translation key incorrect
- Theme not registered
- Translatable field not set

**Fixes:**
```php
// Fix 1: Set locale
app()->setLocale('it');

// Fix 2: Create translation file
// Create laravel/Themes/Meetup/lang/it/home.php

// Fix 3: Fix translation key
// Use correct namespace and file name
__('pub_theme::home.title')
```

### Scenario 6: Livewire Component Not Working

**Symptoms:**
- Component doesn't respond to user interaction
- JavaScript errors in console

**Debugging Steps:**

1. **Check Livewire Detection:**
   ```php
   $view = 'pub_theme::livewire.event-form';
   $finder = view()->getFinder();
   $path = $finder->find($view);
   $header = fread(fopen($path, 'r'), 1024);
   dump(str_contains($header, 'new class extends Component'));  // Should be true
   ```

2. **Check Component Name:**
   ```php
   $block = new BlockData('event-form', [
       'view' => 'pub_theme::livewire.event-form'
   ]);
   dump($block->livewireComponentName);  // Should be normalized name
   ```

3. **Check Livewire Routes:**
   ```bash
   php artisan route:list --path=livewire
   ```

4. **Check Component Class:**
   ```bash
   find laravel -name "EventForm.php"
   ```

5. **Check for JavaScript Errors:**
   ```javascript
   // In browser console
   Livewire.dispatch('some-event', { data: 'test' });
   ```

**Common Causes:**
- Component not detected as Livewire
- Component name not normalized
- Component class missing
- Livewire routes not registered
- JavaScript errors

**Fixes:**
```php
// Fix 1: Add Volt directive
@volt('event-form')
// Component code here
@endvolt

// Fix 2: Use correct namespace
'view' => 'pub_theme::livewire.event-form'

// Fix 3: Create component class
// Create livewire component file
```

### Scenario 7: Theme Components Not Found

**Symptoms:**
- `view not found: pub_theme::components.blocks.hero`
- Component exists but not accessible

**Debugging Steps:**

1. **Check Theme Path:**
   ```php
   $theme = config('xra.pub_theme');
   dump($theme);  // Should be 'Meetup'
   ```

2. **Check View Paths:**
   ```php
   dump(config('view.paths'));  // Should include theme views
   ```

3. **Check View Finder:**
   ```php
   $finder = view()->getFinder();
   dump($finder->getPaths());  // Should include theme path
   ```

4. **Check Namespace Registration:**
   ```php
   $factory = app('view');
   dump($factory->getFinder()->getHints());  // Should include 'pub_theme'
   ```

5. **Check File Exists:**
   ```bash
   ls -la laravel/Themes/Meetup/resources/views/components/blocks/hero.blade.php
   ```

**Common Causes:**
- Theme not registered
- View paths not configured
- Namespace not registered
- File path incorrect
- Permission issues

**Fixes:**
```php
// Fix 1: Register theme
// Ensure ThemeServiceProvider is registered

// Fix 2: Configure view paths
// CmsServiceProvider should add theme to view.paths

// Fix 3: Register namespace
// CmsServiceProvider should register 'pub_theme' namespace
```

## Systematic Debugging Approach

### Step 1: Identify the Layer

Ask: "Which layer is the problem in?"

| Layer | Symptoms | Tools |
|-------|----------|-------|
| Configuration | Wrong theme, wrong locale | `config()`, `.env` |
| Routing | 404, wrong page | `route:list`, Folio |
| Model | No data, wrong data | `Page::find()`, dump() |
| Block | Empty content, wrong view | `BlockData`, view() |
| Template | Rendering errors, wrong output | `view()->exists()`, Blade |
| Middleware | Access issues, no auth | `getMiddlewareBySlug()` |
| Theme | Component not found | `view()->getFinder()` |

### Step 2: Check Configuration

```php
// Always check configuration first
dump([
    'pub_theme' => config('xra.pub_theme'),
    'main_module' => config('xra.main_module'),
    'register_pub_theme' => config('xra.register_pub_theme'),
    'locale' => app()->getLocale(),
    'view_paths' => config('view.paths'),
]);
```

### Step 3: Trace the Flow

```php
// Trace complete request lifecycle
dump([
    '1. Route matched' => request()->route(),
    '2. Slug extracted' => request()->route('slug'),
    '3. Page found' => Page::where('slug', request()->route('slug'))->first(),
    '4. Middleware loaded' => Page::getMiddlewareBySlug(request()->route('slug')),
    '5. Blocks retrieved' => Page::where('slug', request()->route('slug'))->first()->getBlocks(),
    '6. View rendered' => view()->exists('pub_theme::components.blocks.hero'),
]);
```

### Step 4: Validate Assumptions

```php
// Don't assume - test
$assumptions = [
    'Theme registered' => class_exists('Themes\\Meetup\\Providers\\ThemeServiceProvider'),
    'Page exists' => Page::where('slug', 'home')->exists(),
    'View exists' => view()->exists('pub_theme::components.blocks.hero'),
    'Model exists' => class_exists('Modules\\Meetup\\Models\\Event'),
];

foreach ($assumptions as $name => $result) {
    dump([$name => $result ? '✓' : '✗']);
}
```

### Step 5: Use Debug Tools

```php
// Enable query logging
\DB::enableQueryLog();

// Enable error reporting
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Log everything
\Log::debug('Debug info:', [
    'request' => request()->all(),
    'page' => Page::where('slug', request()->route('slug'))->first(),
    'blocks' => Page::where('slug', request()->route('slug'))->first()->getBlocks(),
]);

// Dump and die (quick debugging)
dd($variable);
```

## Quick Reference Commands

### Check Configuration

```bash
# Check theme configuration
php artisan config:show xra

# Check locale configuration
php artisan config:show app

# Check view paths
php artisan config:show view
```

### Check Routes

```bash
# List all routes
php artisan route:list

# List routes for specific path
php artisan route:list --path=it/events

# Clear route cache
php artisan route:clear
```

### Check Views

```bash
# Clear view cache
php artisan view:clear

# Compile views
php artisan view:cache

# Find view files
find laravel -name "*.blade.php"
```

### Check Cache

```bash
# Clear all cache
php artisan optimize:clear

# Clear config cache
php artisan config:clear

# Clear application cache
php artisan cache:clear
```

### Check Database

```bash
# Check page data
php artisan tinker
>>> Page::where('slug', 'home')->first()

# Check model relationships
php artisan tinker
>>> Event::with('venue')->first()
```

## Prevention Strategies

### 1. Write Tests

```php
test('home page renders correctly', function () {
    $response = $this->get('/it/home');
    $response->assertStatus(200);
    $response->assertSee('Welcome');
});

test('blocks render correctly', function () {
    $page = Page::where('slug', 'home')->first();
    $blocks = $page->getBlocks('content');
    expect($blocks)->not->toBeEmpty();
});
```

### 2. Use Type Safety

```php
// Always use return types
public function getBlocks(?string $side = null): array
{
    // ...
}

// Use strict types
declare(strict_types=1);
```

### 3. Validate Configuration

```php
// Validate configuration early
if (! config('xra.pub_theme')) {
    throw new \Exception('pub_theme not configured');
}
```

### 4. Log Key Events

```php
// Log important events
Log::info('Page rendered', [
    'slug' => $page->slug,
    'blocks_count' => count($blocks),
]);
```

### 5. Use Try-Catch

```php
try {
    $blocks = $page->getBlocks('content');
} catch (\Exception $e) {
    Log::error('Failed to get blocks', [
        'page' => $page->slug,
        'error' => $e->getMessage(),
    ]);
    $blocks = [];
}
```

## Emergency Fixes

### Fix 1: Clear All Cache

```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Fix 2: Rebuild Assets

```bash
cd laravel/Themes/Meetup
npm run build
npm run copy
```

### Fix 3: Restart Services

```bash
php artisan serve
npm run dev
```

### Fix 4: Check Database Connection

```bash
php artisan db:show
php artisan migrate:status
```

### Fix 5: Verify Module Status

```bash
php artisan module:list
php artisan module:enable Cms
```

## Conclusion

The key to fixing chaos monkey scenarios is:

1. **Understand the architecture** before making changes
2. **Use systematic debugging** to isolate the problem
3. **Check configuration first** - many issues are configuration-related
4. **Trace the flow** from request to response
5. **Validate assumptions** - don't assume, test
6. **Use debug tools** - dump, log, query logging
7. **Write tests** to prevent regressions
8. **Document solutions** for future reference

With these skills and patterns, you should be able to reason through and fix most issues in the LaravelPizza Template, Theme, and CMS systems.