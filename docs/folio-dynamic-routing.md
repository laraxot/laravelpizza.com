# Folio Dynamic Routing with [container0]

## Philosophy

Using `[container0]` is a **dynamic, generic routing pattern** that follows the same philosophy as the CMS catch-all `[slug].blade.php`.

### Why [container0]?

1. **DRY**: One blade file handles ALL sections
2. **Consistency**: Same pattern as root-level `[slug]` for CMS pages
3. **Flexibility**: Add new sections without creating new directories
4. **Simplicity**: Single routing structure for all dynamic content
5. **Agnostic**: No hardcoded model references - auto-detects from config or naming conventions

## Pattern

```
pages/
├── [slug].blade.php              → /{slug} (CMS)
├── [container0]/
│   ├── index.blade.php          → /{container0} (list page)
│   └── [slug0]/
│       └── index.blade.php      → /{container0}/{slug0} (detail page)
```

## Routes

```
GET /it/{container0}          → [container0]/index.blade.php
GET /it/{container0}/{slug0} → [container0]/[slug0]/index.blade.php
```

## Implementation

### name() Convention

Use semantic names for different page types:

| Page Type | name() | Example |
|-----------|--------|---------|
| List/Index | `container0.index` or just `container0` | `name('events.index')` or `name('events')` |
| Detail/View | `container0.view` | `name('events.view')` |

```php
// [container0]/index.blade.php
name('container0.index');

// [container0]/[slug0]/index.blade.php  
name('container0.view');  // ✅ Semantic name for detail pages
```

### Content Resolution

The agnostic pattern tries in order:
1. **CMS Page** - Check if `{container0}.{slug0}` exists in pages DB
2. **Dynamic Model** - Auto-detect model by naming convention or config

### Block Component Naming

When rendering a model, it looks for:
```
pub_theme::components.blocks.{container0}.detail
```

Examples:
- `events` → `pub_theme::components.blocks.events.detail`
- `blog` → `pub_theme::components.blocks.blog.detail`

This replaces hardcoded directories like `pages/events/`.
