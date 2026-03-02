# Template, Theme, CMS - Runtime Reference

Consolidated reference for real runtime behavior of the frontoffice rendering system.

## Rendering Pipeline (Request -> HTML)

```text
HTTP GET /it/... 
  -> Laravel app kernel
  -> Folio page in active theme (index, [slug], [container0], [container0]/[slug0])
  -> PageSlugMiddleware
  -> <x-layouts.app>
  -> <x-page side="content" ... />
  -> Page::getBlocksBySlug(slug, side)
  -> SushiToJsons reads tenant JSON pages
  -> HasBlocks::compile() + BlockData
  -> optional ResolveBlockQueryAction (data.query)
  -> @include($block->view, $block->data)
  -> pub_theme::components.blocks.*
```

## Canonical Files by Layer

| Layer | File | Role |
|------|------|------|
| Folio | `app/Providers/FolioServiceProvider.php` | Registers pages path for active theme |
| Theme | `Themes/Meetup/resources/views/pages/*.blade.php` | Route-entry templates with Volt + x-page |
| CMS | `Modules/Cms/app/View/Components/Page.php` | Core page renderer |
| CMS | `Modules/Cms/app/Models/Page.php` | Page model with JSON-backed content |
| CMS | `Modules/Cms/app/Models/Traits/HasBlocks.php` | Block compile and conversion to BlockData |
| CMS | `Modules/Cms/app/Datas/BlockData.php` | View validation + dynamic query hydration |
| CMS | `Modules/Cms/app/Actions/ResolveBlockQueryAction.php` | Query execution for block data |
| Namespace | `Modules/Cms/app/Providers/CmsServiceProvider.php` | Registers `pub_theme` namespace |
| Theme Provider | `Themes/Meetup/app/Providers/ThemeServiceProvider.php` | Additional theme views/translations registration |

## Namespace Rules

| Namespace | Usage |
|-----------|------|
| `pub_theme::` | Required for theme views and translations |
| `cms::` | CMS module views/components |
| `meetup::` | Avoid for runtime templates (use `pub_theme::`) |

## JSON Content Source

Tenant path:
- `config/local/{tenant}/database/content/pages/*.json`
- `config/local/{tenant}/database/content/sections/*.json`

Required block structure:

```json
{
  "type": "events",
  "slug": "events-list",
  "data": {
    "view": "pub_theme::components.blocks.events.list",
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "orderBy": "start_date",
      "direction": "asc",
      "limit": 50,
      "wrap_in": "events"
    }
  }
}
```

## Fallback Behavior (`/container/slug`)

For routes such as `/it/events/{slug}`:
1. Folio route file computes page slug as `container0.view`.
2. CMS loads `events.view` JSON page.
3. Detail block receives route context via `x-page` data merge.

## Chaos Validation Checklist

1. `view()->exists('pub_theme::components.blocks.hero.main')` is true.
2. `home`, `events`, `events.view` pages exist in tenant JSON.
3. Each block has valid `data.view`.
4. Query blocks use valid model classes.
5. Event cards use localized `event.url` (not manual string concat).

## Related Docs

- [chaos-monkey-deep-dive](chaos-monkey-deep-dive.md) - Deep dive tecnico tenant path, wrap_in, container0/slug0
- `cms-theme-template-runtime-architecture.md`
- `chaos-monkey-recovery-playbook.md`
- `../../../Themes/Meetup/docs/chaos-monkey-theme-recovery-playbook.md`
- `../../Meetup/docs/chaos-monkey-event-rendering-playbook.md`
