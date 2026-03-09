# Page component context data

The `Page` View Component (`Modules\Cms\View\Components\Page`) renders a CMS-driven page by looking up its blocks from a JSON file and rendering each block with a merged data context.

## Refactored pattern

Before the refactor the component accepted `container0` and `slug0` as separate constructor parameters. This was redundant because callers already passed those values inside the `$data` array.

After the refactor the constructor is:

```php
public function __construct(
    string $side,
    string $slug,
    ?string $type = null,
    array $data = []
)
```

All contextual values (including `container0`, `slug0`, or any future keys such as `container1`, `slug1`) travel exclusively inside the `$data` array.

## How to pass context

Pass an associative array as the `:data` attribute:

```blade
{{-- correct: context via $data --}}
<x-page
    side="content"
    :slug="$this->pageSlug"
    :data="['container0' => $container0, 'slug0' => $slug0]"
/>
```

The Blade component spreads `$data` into `$view_params` using the splat operator (`...$this->data`), so every key inside `$data` becomes an independent variable inside the rendered view as well:

```php
$viewParams = [
    ...$this->data,      // e.g. container0, slug0 become top-level variables
    'blocks' => $this->blocks,
    'side'   => $this->side,
    'slug'   => $this->slug,
    'data'   => $this->data,  // also kept as the full array for block merging
];
```

This design means adding a new context key in the future (e.g. `container1`) requires no change to the component signature.

## Call patterns

### No context (most pages)

```blade
<x-page side="content" :slug="$slug" />
```

### With slug context (nested routes)

```blade
<x-page
    side="content"
    :slug="$this->pageSlug"
    :data="$this->data"
/>
```

where `$this->data` already contains `['container0' => '...', 'slug0' => '...']`.

### With inline data (content-resolver)

```blade
<x-page
    side="content"
    :slug="$pageSlug"
    :data="['container0' => $container0, 'slug0' => $slug0]"
/>
```

## Incorrect patterns

```blade
{{-- wrong: container0/slug0 are no longer accepted as explicit attributes --}}
<x-page side="content" :slug="$slug" :container0="$c0" :slug0="$s0" />
```

Blade would silently ignore unknown attributes, so this would not crash but the values would be lost.

## Why `...$this->data` in view_params

Each block template receives its variables via `array_merge($data, $block->data)`. Having `$data` as both a full array and as individual spread keys gives block views maximum flexibility:

- Use `$data['container0']` (array access) or `$container0` (spread) — both work.
- Future context keys (e.g. `container1`, `slug1`) are automatically available without touching this component.

## Public property `$data`

`$data` is declared as a public property. Laravel Blade components automatically inject public properties into the component's view, so `$data` is available in `cms::components.page` even without being listed explicitly in `$view_params`. The explicit entry is kept for clarity and for use in `array_merge` within the block loop.
