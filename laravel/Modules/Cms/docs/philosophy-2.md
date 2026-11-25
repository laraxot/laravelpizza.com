---
title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
---

# CMS Module Philosophy

## Religione: Core Dogmas

The Cms module rests on three immutable pillars:

### 1. Pages
- Single-routable content documents with optional middleware guards
- Slug-based identity: `container.slug` or `container.view` fallback
- Multi-zone block composition: `content_blocks`, `sidebar_blocks`, `footer_blocks`
- Translatable fields: title, blocks, description (language switching at query time)
- Primary use: civic/structural pages (homepage, about, contact, FAQ)

### 2. Sections
- Reusable block containers without routing
- Single `blocks` zone (not subdivided into sidebar/footer)
- Slug-referenced from Pages or embedded in inline block data
- Primary use: shared content fragments (hero sections, testimonial grids, CTAs)

### 3. Blocks
- Atomic rendering units with type + data + view mapping
- Each block instance: `{type, data, view, slug?, side?, active?}`
- Data is heterogeneous JSON, validated only at render time
- Views are Blade or Volt components (auto-detection of Livewire reactivity)
- Single responsibility: render one piece of UI given structured input

**Why this matters**: The trinity ensures flexibility without collapse. Pages set structure, Sections enable reuse, Blocks enable composition. Each layer is independent—missing a section doesn't break the page; swapping a block type doesn't require migration.

---

title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
## Filosofia: Headless CMS Principles

### Content and Presentation are Divorced

The CMS owns **data structure and semantics**. The Theme owns **layout, CSS, and JavaScript**.

```
┌─────────────────────────────────────────┐
│ CMS (Cms Module)                        │
│ ├─ JSON schema (blocks, fields, zones)  │
│ ├─ Translation layers                   │
│ ├─ Database models (Page, Section)      │
│ └─ Admin UI (Filament)                  │
└──────────────────┬──────────────────────┘
                   │ JSON payload
                   ▼
┌─────────────────────────────────────────┐
│ Theme (e.g., Themes/Sixteen)            │
│ ├─ Blade/Volt components for blocks     │
│ ├─ Tailwind CSS for styling             │
│ ├─ Alpine/Livewire for interactivity    │
│ └─ Responsive grid, typography, UX      │
└─────────────────────────────────────────┘
```

This split means:
- Swap themes without touching content.
- Swap block implementations without migrating data.
- Multiple tenants, one CMS model.

### Block-Based Composition

Every page is an **array of blocks**, not a monolithic template.

Each block is a **form-like data object** describing: *what* it displays and *how* to fetch it.

```json
{
  "type": "hero",
  "data": {
    "heading": "Benvenuti a FixCity",
    "subheading": "Segnalate i problemi, risolvete la città",
    "image": "hero.jpg",
    "cta": { "text": "Inizia", "url": "/report" }
  },
  "view": "pub_theme::components.blocks.hero",
  "active": true
}
```

No Blade hardcoding. No controller logic polluting content. Data in, HTML out.

### Dynamic Query Resolution

Blocks can fetch **live data** at render time via a `query` key:

```json
{
  "type": "recent_events",
  "data": {
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "method": "published",
      "limit": 5
    }
  },
  "view": "pub_theme::components.blocks.event_list"
}
```

The `ResolveBlockQueryAction` executes the query and merges results into `data`. This keeps content static while binding to live database content. **Static structure, dynamic payload.**

### Translation and Localization

Pages, Sections, and PageContent use **Spatie Translatable** pattern:

- Fields marked `translatable = ['title', 'blocks', ...]` store JSON-per-locale.
- Reads auto-detect active locale via `XotData::primary_lang`.
- Blade rendering: `{{ $page->getTranslation('blocks', 'it') }}` or implicit via `getBlocks()`.
- Admin edits multi-language in a single Filament tab.

**Single source of truth per locale**, no duplication logic.

---

## Politica: Publishing, Drafting, Versioning

### Current State

**No native draft/published distinction exists yet.** All records in the database are treated as live.

- Soft deletes (`deleted_at`) provide removal history.
- `created_by`, `updated_by`, `deleted_by` track audit trail.
- Middleware can gate pages: `middleware: ['auth', 'verified']` stored in JSON.

### Future Road

1. **Draft/Published States**: Add `status` column (draft, published, archived) and filter on render.
2. **Versioning**: Store version snapshots in JSON history or separate `PageVersion` table.
3. **Scheduled Publishing**: Add `published_at` datetime for future releases.
4. **Rollback**: Version history enables revert to prior state.

For now, **assume all database records are live**. Use Filament policies to control who edits.

---

## Scopo: FixCity Content Governance

The Cms module enables **content-driven governance** for the FixCity platform, specifically for civic pages (Design Comuni parity).

**What it solves:**
- Avoid hardcoding 50+ municipal pages in Blade files.
- Allow non-developers to edit page content via Filament without touching code.
- Separate Design Comuni CSS/layout (Theme) from content structure (CMS).
- Route homepage, FAQs, and service pages without static controller code.

**What it doesn't do:**
- Provide a WYSIWYG page builder UI (admin uses structured Filament forms).
- Support media library management (relies on Theme for image paths).
- Handle comments or user-generated content (out of scope).

---

## Zen: The Essence of Content Freedom

**Zen is simplicity married to power.**

The CMS achieves zen through:

1. **Single Source of Truth**: JSON (local dev) or database (production). No dual-sync nightmare.
2. **Composability Without Constraint**: Blocks are just objects. No widget registry, no schema validation at DB layer. Freedom to experiment.
3. **Separation of Concerns**: CMS owns structure; Theme owns beauty. Neither bleeds into the other.
4. **Reversibility**: JSON-stored blocks can be read, modified, or regenerated by migrations or actions without losing intent.
5. **Clarity**: A page is literally just a list of blocks and some metadata. No magic, no hidden nesting.

The zen breaks when:
- Blocks are tightly coupled to views (type string + view reference = fragile).
- Middleware complexity grows without per-block guards.
- Query resolution is misused for business logic instead of data fetching.

---

## Librerie Da Installare

### Already Included

- **Spatie Translatable**: I18n for model fields.
- **Spatie Data**: Type-safe DTOs (`BlockData`, `ResolvePageData`).
- **Spatie QueueableAction**: Long-running operations (not yet used heavily; ready for future import of large datasets).
- **Sushi**: In-memory models from closures (used for virtual `Conf` model).
- **Filament**: Admin panel for Cms resource management.

### Recommended for Future Enhancement

1. **Spatie Ignition / Filament Debugbar**
   - Enhanced debug views in Filament.
   - Helps diagnose block resolution failures.

2. **Laravel Scout + Meilisearch / Algolia**
   - Full-text search across pages and sections.
   - Critical for municipal site search (e.g., finding service pages by keyword).

3. **Spatie Sluggable**
   - Auto-generate slug from title (currently manual).
   - Prevents slug collisions.

4. **Spatie MediaLibrary** (Optional)
   - Attach images/documents to Pages and Blocks.
   - Handles CDN proxying, resizing.
   - More complex than needed for static theme images; worth evaluating.

5. **TinyMCE / Markdown Editor in Filament**
   - Rich-text editing for block data (currently plain JSON input).
   - UX win for content teams.

6. **Laravel Horizon / Telescope**
   - Monitor QueueableAction jobs and block query resolution.
   - Essential in production.

---

## Future Implementazioni

### Multilingual Content (Scheduled)
- Extend `translatable` fields to all block zones.
- Admin UI: separate tab per language with full block builder.
- Runtime: route-based locale detection in Folio middleware.

### Content Scheduling
- Add `published_at` (datetime) to Pages and Sections.
- Filament action: "Schedule Publish".
- Middleware: `whereDate('published_at', '<=', now())` before render.
- Bonus: `expired_at` for archive.

### Block Revision History
- Store JSON snapshots in `page_revisions` table on each save.
- Filament modal: "View Changes" showing before/after diffs.
- Revert capability for accidental deletions.

### CDN Asset Pipeline
- Move block images to CDN (S3, Cloudinary).
- Query parameters in Filament: `?resize=400x300&quality=80`.
- Lazy-load images in Theme with Alpine.

### Permission-Based Block Visibility
- Add `visibility` field: public, authenticated, role-based.
- BlockData honors visibility at render time.
- Filament select: "Show to: Public / Staff / Admins".

### A/B Testing Blocks
- Variant field: `variant_id`, `variant_percentage`.
- HashId-based traffic split in Session/Cookie.
- Metrics: clicks, conversions per variant.

---

## Competitors & Inspirations

### Statamic
- **Philosophy match**: File-based content, field-driven forms.
- **Differs**: Statamic is monolithic; Cms is modular within Laravel.
- **Lesson**: Statamic's tag syntax is powerful; Cms uses Data objects instead.

### Filament
- **Philosophy match**: Admin UI as a first-class concern.
- **Differs**: Filament manages models; Cms is one use case of Filament.
- **Lesson**: Form field composition (repeaters, builders) informs block structure.

### Strapi
- **Philosophy match**: Headless CMS, JSON REST API, multi-tenant.
- **Differs**: Strapi is a standalone service; Cms is embedded in Laravel app.
- **Lesson**: Strapi's permission matrix (field-level, user-role) should inspire future Cms policies.

### Sanity
- **Philosophy match**: Portable text (nested blocks), single schema per type.
- **Lesson**: Schema as code (TS/JSON) beats UI-driven schema definition.

### WordPress with Gutenberg
- **Philosophy match**: Block-based content editing.
- **Differs**: Gutenberg is UI-first; Cms is data-first.
- **Lesson**: Gutenberg's nested blocks (columns > paragraphs) vs. Cms flat array. Evaluate nesting for future.

### Laravel Nova
- **Philosophy match**: Admin UI built on Laravel models.
- **Differs**: Nova resource-centric; Cms is content-centric.
- **Lesson**: Nova's field validation could replace current lenient JSON approach.

**Synthesis**: The Cms module is a **Laravel-native headless CMS** inspired by Statamic's content philosophy and Filament's admin UX, with a flat block model (not Gutenberg's nesting yet) and QueueableAction integration for data fetching.

---

## Best Practices

1. **Name slugs consistently**: Use kebab-case, namespace them (`container.slug`). Example: `comuni.homepage`, `comuni.faq`, `events.detail`.

2. **Store immutable data in blocks**: Prefer `query` over static copies. If an event date changes, fetch live. If branding changes, fetch live.

3. **Keep block data schemas small**: One responsibility per block. A `hero` block should only hold heading, subheading, image, CTA. Not a full page.

4. **Translate at the field level, not the block level**: Let Spatie Translatable handle i18n. Don't store duplicate blocks per language.

5. **Use Volt components for interactive blocks**: If a block needs state (filters, pagination), use Volt. Blade is for static rendering.

6. **Leverage Filament repeaters for block arrays**: Admin creates 10 blocks in one form; Filament serializes to JSON automatically.

7. **Test block resolution with factories**: Write Pest tests for Pages with various block configurations. Catch missing views early.

8. **Profile block queries**: Use `DB::listen()` in tests to ensure block queries don't N+1.

9. **Version your block schema**: If you change a block's data structure, document the migration (future: add to `page_versions`).

10. **Use middleware sparingly**: Guard pages with auth, not individual blocks. Blocks should be theme-agnostic; access control belongs to the Page.

---

## Bad Practices

1. **Storing logic in block data**
   - ❌ `{ "type": "filter", "data": { "query_builder_code": "...PHP..." } }`
   - ✅ `{ "type": "filter", "data": { "query": { "model": "Event", "method": "upcoming" } } }`

2. **Duplicating content across languages in the DB**
   - ❌ Creating separate Page records per language.
   - ✅ Using Spatie Translatable JSON columns (one record, multiple languages).

3. **Hardcoding block types in the controller**
   - ❌ `if ($block['type'] === 'hero') { ... }`
   - ✅ Delegating to `BlockData->view` and Blade/Volt dispatch.

4. **Storing HTML in block data**
   - ❌ `{ "data": { "content": "<p>Escaped HTML...</p>" } }`
   - ✅ `{ "data": { "content": "Plain text or Markdown", "view": "..." } }`

5. **Ignoring N+1 queries in block resolution**
   - ❌ `foreach ($blocks as $block) { $block->query(); }` (10 queries per page).
   - ✅ Batch-load via eager loading or single query with `take()` limits.

6. **Mixing CMS content with theme variables**
   - ❌ Passing `$tailwind_classes` from block data to Blade.
   - ✅ CSS classes in Blade/component context, not data.

7. **Creating "god blocks" that do everything**
   - ❌ A single block type for hero, features, testimonials.
   - ✅ One block type per UI pattern.

8. **Not validating block data in factories**
   - ❌ Creating factory records with invalid `view` references.
   - ✅ Assert view exists in factory and tests.

---

## False Friends: Common Pitfalls

### N+1 Queries in Block Rendering

**Trap**: `foreach ($page->getBlocks() as $block)` and inside loop, `$block->query()` fires separately.

```php
// ❌ N+1 disaster
$page = Page::first();
foreach ($page->getBlocks() as $block) {
    if ($block->data['query']) {
        app(ResolveBlockQueryAction::class)->execute($block->data['query']);
    }
}
```

**Fix**: Resolve all queries in bulk or cache them.

```php
// ✅ Eagerly resolved during BlockData construction
$blocks = $page->getBlocks(); // All queries resolved in constructor
```

### Nested Blocks Complexity

Current design is **flat arrays** of blocks. Adding nesting (columns > rows > blocks) will require:
- New schema validation.
- Recursive rendering in Blade.
- Filament builder UI becomes complex.

**Don't introduce nesting unless you have a clear use case.** It sounds elegant but compounds admin UX and query resolution.

### Middleware Per-Block

Pages store middleware at the page level; blocks don't have individual guards. Attempting to add per-block middleware:

```php
// ❌ Tempting but complicates resolution
$page->blocks = [
    { "type": "..." },
    { "type": "...", "middleware": ["verified"] } // Blocks can't gate themselves
];
```

**Keep it simple**: If a block should only appear for verified users, gate the page. If you need conditional visibility, use `BlockData->active` flag set by controller logic, not configuration.

### Dynamic Queries as Business Logic

The `query` system is for **data fetching**, not **computation**.

```php
// ❌ Misusing query for business logic
"query": {
    "code": "return Event::where('user_id', auth()->id())->get();"
}

// ✅ Query for simple model lookups
"query": {
    "model": "Event",
    "method": "published",
    "limit": 10
}
```

If you need conditional filtering (user-specific data), resolve it in the controller and pass to the block view, not in block JSON.

### Over-Translating

Spatie Translatable is powerful but don't translate every field:

```php
// ❌ Excessive translatable fields
translatable = [
    'title', 'description', 'blocks', 'sidebar_blocks', 'footer_blocks',
    'metadata', 'seo_title', 'seo_description', 'og_image'
];

// ✅ Translate user-visible content only
translatable = ['title', 'description', 'blocks'];
// Store SEO metadata separately in config or use XotData
```

Large translatable payloads bloat the JSON column. Keep it focused on content.

---

## Come Usarlo: Creating Pages and Blocks

### Step 1: Create a Page via Filament

1. Navigate to **Admin > CMS > Pages**.
2. Click **Create Page**.
3. Fill in:
   - **Title** (translatable): "Richieste di Intervento"
   - **Slug**: `comuni.richieste`
   - **Description**: "Segnalate le problematiche della città"
   - **Middleware** (JSON array): `["auth", "verified"]` (optional)
4. **Content Blocks** (repeater):
   - Add block 1: Type = `hero`, View = `pub_theme::components.blocks.hero`, Data = `{ "heading": "...", "subheading": "..." }`
   - Add block 2: Type = `cta`, View = `pub_theme::components.blocks.cta`, Data = `{ "text": "Inizia", "url": "/report" }`
5. **Sidebar Blocks** (repeater): (optional, same structure)
6. **Footer Blocks** (repeater): (optional, same structure)
7. Click **Save**.

### Step 2: Create a Block Component in Theme

In `Themes/Sixteen/resources/views/components/blocks/hero.blade.php`:

```blade
@props(['block'])

<section class="bg-gradient-to-r from-blue-600 to-blue-800 py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">
            {{ $block->data['heading'] ?? '' }}
        </h1>
        <p class="text-xl text-blue-100 mb-8">
            {{ $block->data['subheading'] ?? '' }}
        </p>
        @if(isset($block->data['cta']))
            <a href="{{ $block->data['cta']['url'] }}" class="btn btn-primary">
                {{ $block->data['cta']['text'] }}
            </a>
        @endif
    </div>
</section>
```

### Step 3: Render the Page in a Folio Template

In `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`:

```blade
<?php use function Laravel\Folio\{name, middleware};
use Modules\Cms\Actions\ResolvePageAction;

name('page');
middleware(\Modules\Cms\Http\Middleware\PageSlugMiddleware::class);
?>

<x-layouts.app>
    @php
        $page = app(ResolvePageAction::class)->execute(request()->route('container'), request()->route('slug'));
        // $page->pageSlug, $page->renderMode, $page->item
    @endphp

    @if ($page->renderMode === 'cms')
        <x-cms::page :slug="$page->pageSlug" />
    @else
        <!-- Handle model rendering -->
    @endif
</x-layouts.app>
```

The `x-cms::page` component iterates blocks and dispatches to their views.

### Step 4: Test Rendering

Visit `/it/comuni/richieste` in the browser. The middleware guards are applied, blocks are resolved, and the theme renders them.

---

## Come Installarlo

### Prerequisites

- Laravel 13+ application with Laraxot module structure.
- Filament 5+ installed.
- Database migrations run.
- Spatie packages already installed (Translatable, Data).

### Installation Steps

1. **Publish module config** (if needed):
   ```bash
   php artisan vendor:publish --tag=cms-config
   ```

2. **Run migrations**:
   ```bash
   php artisan migrate
   ```

3. **Publish Filament resources**:
   ```bash
   php artisan filament:install
   ```

4. **Register Filament resource** (should auto-register via service provider):
   - If not auto-registered, add to your Filament config:
   ```php
   'resources' => [
       Modules\Cms\Filament\Resources\PageResource::class,
       Modules\Cms\Filament\Resources\SectionResource::class,
   ],
   ```

5. **Seed sample data** (optional):
   ```bash
   php artisan db:seed --class=Modules\\Cms\\Database\\Seeders\\CmsSeeder
   ```

6. **Create a theme or use existing**:
   - Ensure block components exist in theme views.
   - Example: `Themes/Sixteen/resources/views/components/blocks/hero.blade.php`.

7. **Set up Folio routes**:
   - Create Folio page template: `Themes/Sixteen/resources/views/pages/[container]/[slug].blade.php`.
   - Use middleware: `PageSlugMiddleware`.

8. **Test**:
   ```bash
   php artisan tinker
   >>> $page = \Modules\Cms\Models\Page::first();
   >>> $page->getBlocks(); // Should return BlockData instances
   ```

### Configuration

- **Multi-tenancy**: If using tenants, seed per-tenant pages in seeder or migrate with `--tenant` flag.
- **Locales**: Configure primary language in `config('xot.primary_lang')` (default: 'it').
- **Asset URLs**: Update block view paths to match your theme structure.

---

## Coverage Analysis

### What's Well-Covered

- **Models**: Page, Section, PageContent, Conf, Menu, Module, Attachment—all defined with factories.
- **Actions**: 10+ actions for resolving pages, blocks, queries, and theme metadata.
- **Traits**: `HasBlocks` (core block interface), `SushiToJsons` (virtual JSON models), `BaseTreeModel` (hierarchical support).
- **Data Classes**: BlockData, ResolvePageData, BlockData, ThemeData—fully typed DTOs.
- **Filament Resources**: Page, Section, PageContent, Menu, Module, Conf—all have admin panels.

### What's Missing or Under-Implemented

1. **Draft/Published States**: No published_at or status enum. All DB records are live.
2. **Versioning**: No `page_revisions` table or rollback capability.
3. **API Endpoints**: No REST API for headless consumption (could use Filament API or Laravel API Resources).
4. **Full-Text Search**: No Scout integration; search across pages would require raw LIKE queries.
5. **Block Validation Schema**: No JSON schema validation; block data is accepted as-is.
6. **Audit Trail UI**: Audit fields (`created_by`, `updated_by`) exist but not exposed in Filament.
7. **Media Library**: No built-in media picker; image URLs stored as strings in block data.
8. **Test Coverage**: Story files mention 0% coverage; needs Pest test suite expansion.

### Recommended Coverage Priorities

1. Write Pest tests for `ResolvePageAction` with various slug fallback scenarios.
2. Add block resolution tests: missing views, malformed queries.
3. Test translatable field switching (locale detection).
4. Integration test: Folio render end-to-end.
5. Admin tests: Filament form submission, validation, and policy enforcement.

---

## Summary

The Cms module is a **lean, composable content management system** embedded in Laravel. It separates content (JSON data) from presentation (Theme components) and enables non-developers to compose pages from reusable blocks via Filament.

**Strength**: Simplicity. A page is a list of blocks; a block is type + data + view. No magical nesting, no rigid schema.

**Weakness**: Lacks versioning, drafting, and API layer for headless consumption. Future iterations should add these.

**Best suited for**: Municipal websites (Design Comuni), landing pages, and content-driven sites where SEO and multi-language are critical.

**Not suited for**: E-commerce product pages (use catalog models), user-generated content (no comment systems), or real-time collaborative editing (no CRDT or conflict resolution).

---

**Author**: CMS Module Analysis  
**Date**: 2026-09-06  
**Status**: Production-ready (draft/versioning pending)
