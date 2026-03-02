# CMS Theme Template Runtime Reference

## Quick Reference

### Configuration Keys

| Key | Type | Description | Example |
|-----|------|-------------|---------|
| `main_module` | string | Primary business logic module | `'Meetup'` |
| `pub_theme` | string | Active frontend theme | `'Meetup'` |
| `register_pub_theme` | bool | Enable theme registration | `true` |

### View Namespaces

| Namespace | Source | Usage |
|-----------|--------|-------|
| `pub_theme` | `Themes/{theme}/resources/views` | Theme components |
| `cms` | `Modules/Cms/resources/views` | CMS components |
| `{module}` | `Modules/{module}/resources/views` | Module components |

### Page Model Fields

| Field | Type | Translatable | Description |
|-------|------|--------------|-------------|
| `id` | string | No | Unique identifier |
| `slug` | string | No | URL slug |
| `title` | json | Yes | Page title |
| `blocks` | json | Yes | Main content blocks |
| `content_blocks` | json | Yes | Content area blocks |
| `sidebar_blocks` | json | Yes | Sidebar blocks |
| `footer_blocks` | json | Yes | Footer blocks |
| `middleware` | json | No | Page middleware |

### BlockData Properties

| Property | Type | Description |
|----------|------|-------------|
| `type` | string | Block type identifier |
| `slug` | string\|null | Block slug for reuse |
| `data` | array | Block data (including query results) |
| `view` | string | View path to render |
| `livewire` | bool | Is Livewire/Volt component |
| `livewireComponentName` | string | Normalized component name |

## Common Patterns

### Pattern 1: Simple Block

```json
{
  "type": "text",
  "data": {
    "title": "Welcome",
    "content": "Lorem ipsum dolor sit amet",
    "view": "pub_theme::components.blocks.text"
  }
}
```

**Template:**
```blade
{{-- pub_theme/components/blocks/text.blade.php --}}
<div class="text-block">
    <h2>{{ $title }}</h2>
    <p>{{ $content }}</p>
</div>
```

### Pattern 2: Dynamic Query Block

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

**Template:**
```blade
{{-- pub_theme/components/blocks/events/list.blade.php --}}
<div class="events-list">
    <h2>{{ $title }}</h2>
    <div class="events-grid">
        @foreach($events as $event)
            <div class="event-card">
                <h3>{{ $event['title'] }}</h3>
                <p>{{ $event['date'] }}</p>
                <a href="{{ $event['url'] }}">Details</a>
            </div>
        @endforeach
    </div>
</div>
```

### Pattern 3: Conditional Block

```json
{
  "type": "conditional",
  "data": {
    "view": "pub_theme::components.blocks.conditional",
    "condition": "{{ auth()->check() }}",
    "true_view": "pub_theme::components.blocks.welcome",
    "false_view": "pub_theme::components.blocks.login_cta"
  }
}
```

**Template:**
```blade
{{-- pub_theme/components/blocks/conditional.blade.php --}}
@php
$condition = Blade::render($condition);
@endphp

@if($condition)
    @include($true_view, $data)
@else
    @include($false_view, $data)
@endif
```

### Pattern 4: Nested Blocks

```json
{
  "type": "container",
  "data": {
    "view": "pub_theme::components.blocks.container",
    "title": "Featured Content",
    "class": "featured-section"
  }
}
```

**Template:**
```blade
{{-- pub_theme/components/blocks/container.blade.php --}}
<div class="{{ $class ?? 'container' }}">
    <h2>{{ $title }}</h2>
    <x-page side="content" :slug="$slug" />
</div>
```

## API Reference

### Page Model

```php
// Get page by slug
$page = Page::where('slug', 'home')->first();

// Get blocks for a specific side
$blocks = $page->getBlocks('content');

// Get middleware for a slug
$middleware = Page::getMiddlewareBySlug('home');

// Create page
Page::create([
    'slug' => 'about',
    'title' => ['en' => 'About', 'it' => 'Chi Siamo'],
    'blocks' => [
        [
            'type' => 'text',
            'data' => ['content' => 'About us']
        ]
    ]
]);
```

### HasBlocks Trait

```php
// Get all blocks
$blocks = $model->getBlocks();

// Get content blocks
$blocks = $model->getBlocks('content');

// Get sidebar blocks
$blocks = $model->getBlocks('sidebar');

// Get blocks by slug (static)
$blocks = Page::getBlocksBySlug('home', 'content');
```

### BlockData Class

```php
// Create BlockData
$block = new BlockData(
    'hero',  // type
    [        // data
        'title' => 'Welcome',
        'subtitle' => 'To our site',
        'view' => 'pub_theme::components.blocks.hero'
    ],
    'hero-1' // slug (optional)
);

// Access properties
$view = $block->view;           // 'pub_theme::components.blocks.hero'
$data = $block->data;           // ['title' => 'Welcome', ...]
$isLivewire = $block->livewire; // false
```

### ResolveBlockQueryAction

```php
$action = app(ResolveBlockQueryAction::class);

$result = $action->execute([
    'model' => 'Modules\\Meetup\\Models\\Event',
    'scopes' => ['published', 'upcoming'],
    'orderBy' => 'date',
    'direction' => 'asc',
    'limit' => 10,
    'wrap_in' => 'events'
]);

// Result: ['events' => [...]]
```

## Component Props

### Page Component

```blade
<x-page 
    :blocks="$blocks" 
    side="content" 
    slug="home" 
    :page="$page" 
/>
```

| Prop | Type | Required | Default |
|------|------|----------|---------|
| `blocks` | array | No | `[]` |
| `side` | string | No | `'content'` |
| `slug` | string | No | `''` |
| `page` | Page\|null | No | `null` |

## File Locations

### Configuration

```
laravel/config/local/laravelpizza/xra.php
```

### Service Providers

```
laravel/Themes/{theme}/app/Providers/ThemeServiceProvider.php
laravel/Modules/Cms/app/Providers/CmsServiceProvider.php
laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php
```

### Models

```
laravel/Modules/Cms/app/Models/Page.php
laravel/Modules/Cms/app/Models/PageContent.php
laravel/Modules/Cms/app/Models/Traits/HasBlocks.php
```

### Actions

```
laravel/Modules/Cms/app/Actions/ResolveBlockQueryAction.php
```

### Datas

```
laravel/Modules/Cms/app/Datas/BlockData.php
```

### Middleware

```
laravel/Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php
```

### Views

```
laravel/Themes/{theme}/resources/views/
├── pages/
│   ├── index.blade.php
│   └── [slug].blade.php
└── components/
    └── blocks/
        └── {block-name}.blade.php

laravel/Modules/Cms/resources/views/components/
└── page.blade.php
```

### Page Data

```
laravel/config/local/laravelpizza/database/content/pages/
└── {page-slug}.json
```

## Error Messages

### Common Errors

| Error | Cause | Solution |
|-------|-------|----------|
| `view not found: pub_theme::components.blocks.unknown` | View path incorrect | Check view path and namespace |
| `Class "Modules\Unknown\Model" not found` | Model class invalid | Verify model exists and namespace |
| `Call to undefined method getBlocks()` | Model doesn't use HasBlocks | Add `use HasBlocks` trait |
| `Page middleware not executing` | PageSlugMiddleware not applied | Add middleware to page route |

## Debugging

### Enable Debug Mode

```php
// In .env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Check Block Data

```php
// In page template
@php
dd($blocks);
@endphp
```

### Check Query Results

```php
// In BlockData constructor
\Illuminate\Support\Facades\Log::debug('Query results:', $dynamicData);
```

### Check View Path

```php
// In BlockData constructor
\Illuminate\Support\Facades\Log::debug('View path:', [
    'view' => $view,
    'exists' => view()->exists($view)
]);
```

## Performance Tips

### 1. Cache Block Results

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

### 2. Eager Load Relationships

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

### 3. Use Database Indexes

```php
// In Event migration
$table->index('date');
$table->index('published_at');
$table->index('slug');
```

### 4. Limit Query Results

```json
{
  "query": {
    "limit": 10
  }
}
```

## Security Best Practices

### 1. Validate User Input

```php
// In page slug middleware
if (! preg_match('/^[a-z0-9-]+$/', $slug)) {
    abort(404);
}
```

### 2. Sanitize Block Data

```php
// In BlockData constructor
$this->data = array_map(function ($value) {
    return is_string($value) ? strip_tags($value) : $value;
}, $data);
```

### 3. Use Auth Middleware

```php
// In page JSON
{
  "middleware": ["auth"],
  "slug": "admin-dashboard"
}
```

### 4. Escape Output

```blade
{{-- In templates --}}
{!! $content !!}  {{-- Only for trusted content --}}
{{ $content }}    {{-- Safe escaping --}}
```

## Testing

### Unit Test Example

```php
test('BlockData resolves dynamic query', function () {
    $action = app(ResolveBlockQueryAction::class);
    
    $result = $action->execute([
        'model' => \Modules\Cms\Models\Page::class,
        'limit' => 5
    ]);
    
    expect($result)->toHaveKey('items');
    expect($result['items'])->toHaveCount(5);
});
```

### Feature Test Example

```php
test('page renders with blocks', function () {
    $response = $this->get('/it/home');
    
    $response->assertStatus(200);
    $response->assertSee('Welcome');
});
```

## Migration Guide

### From Static Pages

1. **Create Page Model:**
   ```php
   Page::create([
       'slug' => 'about',
       'title' => ['en' => 'About', 'it' => 'Chi Siamo']
   ]);
   ```

2. **Define Blocks:**
   ```json
   {
     "blocks": [
       {
         "type": "text",
         "data": {
           "content": "About us",
           "view": "pub_theme::components.blocks.text"
         }
       }
     ]
   }
   ```

3. **Update Route:**
   ```php
   // Remove old route
   // Route::get('/about', AboutController::class);
   
   // Use Folio route instead
   // /it/about automatically resolves to [slug].blade.php
   ```

### From Database Content

1. **Export Content:**
   ```php
   $pages = \App\Models\OldPage::all();
   
   foreach ($pages as $oldPage) {
       Page::create([
           'slug' => $oldPage->slug,
           'title' => ['en' => $oldPage->title],
           'blocks' => [
               [
                   'type' => 'html',
                   'data' => [
                       'content' => $oldPage->content,
                       'view' => 'pub_theme::components.blocks.html'
                   ]
               ]
           ]
       ]);
   }
   ```

2. **Update References:**
   ```php
   // Update links in content
   $content = str_replace('/old-path', '/new-path', $content);
   ```

## Additional Resources

### Documentation

- [CMS Module Docs](./00-index.md)
- [Runtime Architecture](./template-theme-cms-runtime-architecture.md)
- [Content Blocks System](./content-blocks-system.md)

### Code Examples

- [Page Examples](../database/content/pages/)
- [Block Components](../resources/views/components/blocks/)
- [Test Examples](../tests/)

### External Links

- [Laravel Documentation](https://laravel.com/docs)
- [Folio Documentation](https://laravel.com/docs/folio)
- [Volt Documentation](https://laravel.com/docs/volt)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)