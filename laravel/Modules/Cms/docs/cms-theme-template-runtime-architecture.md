# CMS Theme Template Runtime Architecture

## Scope

This document describes the **actual runtime path** used today by LaravelPizza for frontoffice page rendering (Folio + Theme + CMS JSON blocks), based on source inspection.

Reference date: 2026-03-02.

## Runtime Pipeline (Request -> HTML)

1. Request enters Laravel and is matched by **Folio** pages.
2. `Modules\Cms\Providers\FolioVoltServiceProvider` registers Folio paths:
   - `Themes/{xra.pub_theme}/resources/views/pages` (theme pages)
   - `Modules/*/resources/views/pages` (module pages)
   - Per ogni locale supportato: `Folio::path($theme_path)->uri($locale)`
3. Theme Folio page files (Volt) call `<x-layouts.app>` and `<x-page ...>`.
4. `<x-page>` resolves to `Modules\Cms\View\Components\Page`.
5. `Page` component loads blocks using `Page::getBlocksBySlug($slug, $side)`.
6. `Page` model uses `HasBlocks` + `SushiToJsons`:
   - pages are read from `config/local/{tenant}/database/content/pages/*.json`
7. `HasBlocks::compile()` renders inline Blade placeholders in JSON data (for example `{{ trans(...) }}`) and builds `BlockData` instances.
8. `BlockData` validates view path existence and resolves dynamic query data through `ResolveBlockQueryAction` when `data.query` exists.
9. `cms::components.page` iterates blocks and includes each block view with `@include($block->view, $block->data)`.
10. Final rendering is done by theme block views under `pub_theme::components.blocks.*`.

## Key Providers and Registrations

## Folio

File: `Modules/Cms/app/Providers/FolioVoltServiceProvider.php`

- Uses `XotData::make()->getPubThemeViewPath('pages')` for theme path
- Registers Folio per locale: `Folio::path($theme_path)->uri($locale)`
- Mounts Volt on theme pages + module pages
- Keeps frontoffice page discovery theme-driven

## Theme View/Translation Namespace

Main runtime registration is in:
- `Modules/Cms/app/Providers/CmsServiceProvider.php`

Behavior:
- Adds theme path to `view.paths`
- Registers namespace `pub_theme`
- Registers translation namespace `pub_theme`
- Configures Livewire namespace/path for theme

Theme-level registration also exists in:
- `Themes/Meetup/app/Providers/ThemeServiceProvider.php`

This is partially overlapping (it also calls `loadViewsFrom` and `loadTranslationsFrom`).

## Routing and Folio Page Files

Theme Folio files:
- `Themes/Meetup/resources/views/pages/index.blade.php`
- `Themes/Meetup/resources/views/pages/[slug].blade.php`
- `Themes/Meetup/resources/views/pages/[container0]/index.blade.php`
- `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`

All core routes use `PageSlugMiddleware`.

Important runtime behavior:
- `index.blade.php` hardcodes `slug="home"`
- `[slug].blade.php` maps locale/auth shortcuts and then delegates to `<x-page>`
- `[container0]/[slug0]/index.blade.php` resolves to `container0.view`

## CMS Content Source of Truth

Tenant JSON content paths:
- `config/local/laravelpizza/database/content/pages/*.json`
- `config/local/laravelpizza/database/content/sections/*.json`

Example slugs:
- `home`
- `events`
- `events.view`

Block schema pattern:
- `type`
- `slug`
- `data.view` (must point to an existing Blade view)
- optional `data.query` for dynamic hydration

## Block Query Resolution

File: `Modules/Cms/app/Actions/ResolveBlockQueryAction.php`

Supported config keys:
- `model`
- `scope` or `scopes`
- `orderBy`
- `direction`
- `limit`
- `wrap_in`

Result is merged into block `data` before include.

## Current Strengths

- Theme switch is config-driven (`xra.pub_theme`).
- Frontoffice routes are file-based (Folio), no controller dependency.
- CMS blocks are tenant-local JSON and can be versioned.
- Query-based blocks support data hydration with clear schema.

## Current Risks and Drift

1. Namespace registration overlap between `CmsServiceProvider` and `ThemeServiceProvider`.
2. Documentation drift: many historical docs conflict with actual runtime path.
3. `Themes/Meetup/resources/views/components/blocks/events/list.blade.php` includes a fallback DB query path even though block queries are already resolved in `BlockData`; this duplicates logic and can diverge behavior.
4. `SetFolioLocale` middleware exists but is not wired in Folio provider middleware map.
5. `ThemeComposer` remains present and route-name based in parts (`route('page_slug.view')`), while current frontoffice policy is Folio-first without route() dependency.

## Hard Rules for Upcoming Chaos Testing

1. Never break `pub_theme::` namespace resolution.
2. Never bypass `x-page` -> `Page::getBlocksBySlug()` path for CMS pages.
3. Any new block must ship with:
   - valid `data.view`
   - translation keys in `pub_theme::`
   - deterministic behavior when `data.query` returns empty sets.
4. Keep route behavior Folio-based; avoid adding controller routes for frontoffice pages.
5. Keep JSON schema backward-compatible for existing pages (`home`, `events`, `events.view`).

## Recommended Chaos Targets

1. Remove or rename one block view and verify graceful failure path.
2. Corrupt one `data.query` model class and verify block isolation.
3. Remove one slug JSON page and verify fallback behavior in `[container0]/[slug0]`.
4. Toggle theme name in config and verify `pub_theme` resolution chain.

## Canonical Files for Incident Debugging

- `Modules/Cms/app/Providers/FolioVoltServiceProvider.php`
- `Modules/Cms/app/Providers/CmsServiceProvider.php`
- `Themes/Meetup/app/Providers/ThemeServiceProvider.php`
- `Modules/Cms/app/View/Components/Page.php`
- `Modules/Cms/app/Models/Page.php`
- `Modules/Cms/app/Models/Traits/HasBlocks.php`
- `Modules/Cms/app/Datas/BlockData.php`
- `Modules/Cms/app/Actions/ResolveBlockQueryAction.php`
- `Themes/Meetup/resources/views/pages/*.blade.php`
- `config/local/laravelpizza/database/content/pages/*.json`
