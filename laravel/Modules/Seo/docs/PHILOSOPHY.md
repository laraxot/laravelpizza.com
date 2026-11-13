---
title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
status: stale
---

> Nota 2026-10-08 (docs-audit): cita file che nel modulo non esistono (config/seo.php, resources/views/layouts/app.blade.php, resources/views/vendor/seo/meta.blade.php), verificato il 2026-10-08. Contenuto non riscritto, verificare prima di usarlo.

# SEO Module Philosophy

## RELIGIONE: SEO Dogmas

The Seo module is built on three immutable truths about search engines:

1. **Metadata is destiny.** Titles, descriptions, structured data are the only language Google speaks natively. Everything else is inference. Your site is invisible without proper meta tags.

2. **Canonicalization prevents dilution.** Duplicate content is SEO cancer. One URL per concept, enforced through canonical links. Not suggestions—declarations.

3. **Links earn authority.** The only currency search engines truly respect. Relevance, diversity, velocity matter. No shortcuts.

The module enforces these dogmas:
- Every page must declare its title, description, and intent (type: website|article|product)
- Canonical URLs prevent the tragedy of diffuse PageRank across multiple URLs
- Robots directives manage crawl budget (index, follow, noindex, nofollow)
- Open Graph and Twitter Card metadata make content shareable, earning social signals
- Published/modified time stamps signal freshness to engines

**Reality check:** SEO is not magic. It's a translation layer between your content and machines that don't understand human language. Treat metadata as seriously as you treat your database schema.

---
## FILOSOFIA: Architecture as Principle

### Why no models? The trait-free paradox.

The Seo module deliberately avoids Eloquent models in favor of **stateful adapters and immutable data objects**. This is philosophical, not accidental.

**Why:**

1. **SEO state is request-scoped, not persistent.** Meta tags for a page are computed per-request (page context, locale, user), not stored in the database. A model would suggest persistence where none exists. Using a model here is like storing the HTTP request body—technically possible, philosophically wrong.

2. **Actions are stateless, adapters hold state.** The module separates concerns:
   - `MetatagManager` (Adapter): Mutable, per-request façade coordinator that accumulates meta tags
   - `GetMetatagDataAction`, `MergeMetatagDataAction`, `ReplaceMetatagDataAction` (Actions): Pure, queueable operations on state
   - `MetatagState` (Scoped container): Per-request container for the accumulated metadata
   
   This inverts the typical pattern. Rather than a model managing its own persistence, the adapter coordinates the state lifecycle, and actions modify it atomically.

3. **Spatie Data objects are schema without persistence.** `MetatagData` is a DTO (data transfer object) using Spatie's `LaravelData`. It provides:
   - Type safety without a table
   - Wireable serialization for Livewire without Eloquent overhead
   - Immutable semantics (constructed fresh, not fetched)
   - No N+1 queries because there's no query

4. **Trait injection would be wrong.** In FixCity, if a model (Page, Product, Issue) needs SEO metadata, it should not implement a trait like `HasMetadata` that assumes a `metadata` column or relationship. Instead:
   - The page view calls `Metatag::setTitle($page->title)` at render time
   - The action layer (e.g., in a controller or Folio page) constructs the metadata
   - No coupling between the data model and the SEO layer

### Integration with CMS/TechPlanner

The Seo module integrates at the **view layer**, not the model layer:

```php
// In a Folio page (pages/posts/[slug].blade.php)
@volt
<?php
use function Livewire\Volt\{state};

state(['post' => null]);

// Populate SEO metadata from post context
$this->dispatch('seo:set-metadata', [
    'title' => $this->post->title,
    'description' => $this->post->excerpt,
    'image' => $this->post->featured_image,
    'published_time' => $this->post->published_at,
]);
?>

<h1>{{ $this->post->title }}</h1>
...
@endvolt
```

The CMS (TechPlanner's content module) provides the content; SEO provides the visibility layer.

---

## POLITICA: Meta Tag Rules & Governance

### Core Meta Tags

| Tag | Purpose | Max Length | Rule |
|-----|---------|------------|------|
| `<title>` | Page identity in SERPs | 50–60 chars | Include keyword naturally. Brand at end if space. |
| `<meta name="description">` | The pitch in search results | 150–160 chars | Answer "what is this page about?" in plain language. |
| `<meta name="keywords">` | Topics (legacy signal, low weight) | 200+ chars | Comma-separated, primary phrase first. Not stuffing. |
| `<meta name="robots">` | Crawl/index directives | N/A | `index, follow` (default); `noindex` for temp pages. |
| `<link rel="canonical">` | Authoritative URL | N/A | Must be absolute URL. Self-referential on canonical version. |

### Open Graph Tags (Social Richness)

| Tag | Purpose | Example |
|-----|---------|---------|
| `og:title` | Facebook share title | Same as `<title>` if under 60 chars |
| `og:description` | Facebook share description | Same as `<meta description>` |
| `og:image` | Facebook share image | 1200x630px minimum. Hosted on CDN. |
| `og:type` | Content type | `website`, `article`, `product`, `video` |
| `og:url` | Canonical URL for sharing | Must match page's canonical |

### Twitter Cards (Thread Richness)

| Tag | Purpose | Example |
|-----|---------|---------|
| `twitter:card` | Card type | `summary_large_image`, `summary`, `player` |
| `twitter:title` | Tweet-length title | Max 70 chars |
| `twitter:description` | Tweet context | Max 200 chars |
| `twitter:image` | Thread image | 1200x675px, 5MB max |

### Canonical URL Rules

1. **Self-referential on canonical version.** `<link rel="canonical" href="https://example.com/page">` on `/page`.
2. **Absolute, not relative.** Always `https://example.com/page`, never `/page`.
3. **Chain prevention.** Never point a canonical to another canonical. Always point to the true source.
4. **Protocol consistency.** HTTPS canonical on HTTPS page. HTTP canonical on HTTP page (but why would you have HTTP?).
5. **Trailing slash consistency.** Decide once: `/page` or `/page/`. Don't canonical `/page/` to `/page` and vice versa.

### Robots Directive Rules

| Directive | Meaning | Use Case |
|-----------|---------|----------|
| `index, follow` | Index page, follow links (DEFAULT) | Public content, discoverable |
| `noindex, follow` | Don't index, but crawl links | Login pages, temp content, password-protected pages |
| `noindex, nofollow` | Ignore completely | Duplicate staging URLs, spam landing pages |
| `index, nofollow` | Index page, don't follow links | Scraped content, unreliable sources |

---

## SCOPO: Search Engine Optimization in FixCity

FixCity is a **civic infrastructure prediction and issue tracking platform**. SEO goals:

1. **Discoverability by location + problem.** Citizens search "pothole Via Roma" or "street light broken Milan 2025." Content must rank for local, intent-specific queries.

2. **Issue visibility.** Each reported issue page (issue detail) must be crawlable and indexable so searches for "issue #12345" find it.

3. **Authority through content.** Blog posts, research, trend analysis on civic issues build backlinks and topical authority.

4. **Social sharing virality.** When citizens share an issue or insight, the preview card (image, description, title) should be compelling.

5. **Trust signals.** Schema.org markup (structured data) tells Google this is a legitimate civic platform, not spam.

**Financial impact:** Organic traffic to FixCity → Issue awareness → Civic engagement → Value creation. SEO is a growth lever, not cosmetic.

---

## ZEN: The Essence

The Seo module is small, stateless, and coordinated:

- **No database burden.** No migrations, no tables, no query optimization.
- **Per-request scope.** Metadata is built fresh for each page, expired at the end of the request.
- **Façade coordination.** The `Metatag` façade accumulates metadata through simple setter methods. No magic.
- **Action atomicity.** Three immutable actions (`Get`, `Merge`, `Replace`) handle all mutations.
- **Wireable elegance.** Metadata serializes to Livewire components without friction.

**Philosophy:** SEO metadata is configuration, not data. Treat it like a view model, not a database row.

---

## LIBRERIE DA INSTALLARE

The module is lean. Core dependencies are inherited from the Laravel ecosystem:

| Library | Why | Version |
|---------|-----|---------|
| `spatie/laravel-data` | Type-safe DTOs, Wireable serialization | 4.19.1+ |
| `spatie/laravel-queueable-action` | Atomic actions with optional queueing | 2.16.2+ |
| `livewire/livewire` | Request-scoped component state, two-way binding | 4.x+ |
| `filament/filament` | Admin UI for SEO configuration | 5.x+ |

**Optional (recommended for production):**

| Library | Why | Integration |
|---------|-----|-------------|
| `spatie/laravel-sitemap` | XML sitemap generation | Custom command |
| `spatie/robots-txt` | Dynamic robots.txt generation | Custom route |
| `moz/seomoz` or `semrush-api` | SEO metrics (rank tracking, backlink data) | Queued jobs |
| `schema-org/schema` | PHP Schema.org vocabulary | Custom renderer |

**Do NOT install:**
- `yoast/wordpress-seo` (WordPress-only, overfitted)
- `rankmath/seo-rank-math` (WP plugin, architectural mismatch)
- Full-stack SEO platforms (Ahrefs API, SEMrush API) until data exists to analyze

---

## FUTURE IMPLEMENTAZIONI

### Phase 1: Structured Data (Schema.org / JSON-LD)

```php
Metatag::setStructuredData([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => $page->title,
    'description' => $page->description,
    'image' => $page->featured_image,
    'author' => [
        '@type' => 'Person',
        'name' => $page->author->name,
    ],
    'datePublished' => $page->published_at->toIso8601String(),
    'dateModified' => $page->updated_at->toIso8601String(),
]);
```

This helps Google parse pages as articles, local businesses, products, events. Critical for rich snippets.

### Phase 2: Sitemap Generation

```bash
php artisan seo:generate-sitemap
```

Crawl Folio routes, generate `sitemap.xml`, serve at `/sitemap.xml`, list in `robots.txt`. Batch-generate sitemaps for large sites (>50K URLs).

### Phase 3: Robots.txt Dynamic Rules

```php
// routes/web.php
Route::get('/robots.txt', RobotsTextController::class);

// RobotsTextController generates:
// User-agent: *
// Allow: /
// Disallow: /admin
// Disallow: /api/
// Sitemap: https://example.com/sitemap.xml
```

### Phase 4: Analytics Integration

- **GA4 integration:** Track organic traffic, landing pages, conversion paths
- **Rank tracking:** Monitor keyword positions weekly
- **Backlink monitoring:** Track new/lost links via Moz API or Ahrefs API
- **Core Web Vitals dashboard:** LCP, FID, CLS metrics from PageSpeed Insights API

### Phase 5: AI-Powered Content Optimization

- Suggest title/description improvements via Claude API
- Analyze content readability, keyword density (not stuffing)
- Recommend internal linking opportunities
- Detect competitor content gaps

---

## COMPETITORS & INSPIRATIONS

### Yoast SEO (WordPress)

**What it does right:**
- Traffic light system (green = optimized, orange = needs work, red = missing)
- Readability analysis (sentence length, passive voice)
- Keyword optimization suggestions

**Why we don't copy it:**
- WordPress-centric plugin architecture
- Opinionated, not customizable
- Over-engineered for blogs (FixCity is SaaS, not publishing)

### RankMath (WordPress)

**What it does right:**
- Schema.org builder UI (drag & drop)
- Google Search Console integration
- Rank tracking built-in

**Why we don't copy it:**
- Proprietary data (ranks, backlinks) requires ongoing API costs
- Optimized for small sites, breaks at scale (>100K pages)

### Laravel SEO (Spatie)

**What we learn:**
- Spatie's philosophy: "Do one thing well, don't do everything."
- Use the Laravel ecosystem (Eloquent, migrations) where it fits
- Use Spatie Data objects where it doesn't

**Why different:**
- We avoid Eloquent models for metadata (they imply persistence)
- We use adapters + actions instead of traits/middleware

### Google Search Central (Canonical Authority)

**Principles adopted:**
- Canonical URL is a hint, not a rule (Google can ignore it if nonsensical)
- Robots.txt blocks crawling, not indexing (use noindex for indexing control)
- Structured data must be accurate (false data = spam signal)

---

## BEST PRACTICES

### 1. Title Optimization

✓ **Do:**
```html
<title>Pothole Report Via Roma Milano — FixCity</title>
```
- Keyword at start (pothole)
- Geographic modifier (Milano)
- Brand at end (FixCity)
- Natural, readable, scannable
- 55–60 chars

✗ **Don't:**
```html
<title>FixCity - The Best Civic Platform for Reporting Issues and Tracking Infrastructure Problems in Italy and Beyond</title>
```
- Bloated (120+ chars, truncated in SERPs)
- Keyword diluted
- Unnatural phrasing

### 2. Description Optimization

✓ **Do:**
```html
<meta name="description" content="Report potholes, streetlight outages, and infrastructure issues on Via Roma, Milano. Tracked by city officials. See updates in real time.">
```
- 155 chars
- Includes intent (report, track)
- Call-to-action implicit (see updates)
- Matches search query language

✗ **Don't:**
```html
<meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.">
```
- Filler text
- No relevance to page
- User skips in SERPs

### 3. Canonical URL Enforcement

✓ **Do:**
```php
// Every page declares its canonical
Metatag::setCanonical(route('issues.show', ['issue' => $issue->id]));
```

✗ **Don't:**
```php
// Assume search engines will figure it out
// Multiple URLs serve the same content:
// /issue/123
// /issue?id=123
// /issues/123
// None declares canonical
```

Duplicate content dilutes ranking power across variants.

### 4. Open Graph for Shareability

✓ **Do:**
```php
Metatag::setOgTitle($issue->title); // Max 65 chars
Metatag::setOgDescription($issue->summary); // Max 155 chars
Metatag::setOgImage($issue->featuredImage->url); // 1200x630px
Metatag::setOgType('article');
```

✗ **Don't:**
```php
// Omit OG tags
// Assume Twitter/Facebook will scrape the page
// No image (platforms show gray box)
```

Social sharing is organic traffic. Optimize it.

### 5. Robots Directives

✓ **Do:**
```php
// Index content pages
Metatag::setRobots('index, follow');

// Block temporary pages
if ($page->isTemporary()) {
    Metatag::setRobots('noindex, follow');
}

// Block low-value pages
if ($page->isAutoGenerated()) {
    Metatag::setRobots('noindex, nofollow');
}
```

✗ **Don't:**
```php
// Block everything with noindex
// Hides valuable content from search

// Use nofollow globally
// Prevents PageRank flow to important pages
```

---

## BAD PRACTICES

### 1. Keyword Stuffing

✗ **Bad:**
```html
<title>Pothole Report Milan Pothole Pothole Milan Report Milan Pothole</title>
<meta name="description" content="Pothole report, potholes, pothole reporting, Milan potholes, pothole Milan, potholes Milan...">
```

- Keyword repeated unaturally
- Penalized by Google's spam algorithm
- Unreadable (users click away)

✓ **Fix:**
```html
<title>Pothole Report Via Roma Milano — FixCity</title>
<meta name="description" content="Report potholes on Via Roma, Milano. Real-time tracking and city official updates.">
```

### 2. Thin Content

✗ **Bad:**
```html
<h1>Issue #45678</h1>
<p>Pothole on street.</p>
```

- <100 words per page
- No context, no intent signal
- Google ranks longer, more detailed content higher

✓ **Fix:**
```html
<h1>Pothole Reported on Via Roma, Milano</h1>
<p>A pothole 30cm wide was reported on Via Roma, 2.4km south of Duomo...</p>
<h2>Status Updates</h2>
<ol>
  <li>Reported 2025-01-15</li>
  <li>Acknowledged by city 2025-01-16</li>
  <li>Repair scheduled for 2025-02-01</li>
</ol>
```

At least 300 words of unique, relevant content per page.

### 3. Duplicate Content Without Canonicals

✗ **Bad:**
```
/issue/123
/issues/123
/problems/123
/reports/123
```

All serve identical content, no canonicals. PageRank diluted across 4 URLs.

✓ **Fix:**
```
/issues/123 (canonical)

/issue/123 → canonical to /issues/123
/problems/123 → canonical to /issues/123
/reports/123 → canonical to /issues/123
```

One URL per concept.

### 4. Misleading Metadata

✗ **Bad:**
```php
// Page is about pothole, but metadata says:
Metatag::setTitle('Free iPhone 15 — Claim Yours Now!');
```

- Misleading title ≠ bait-and-switch spam
- User clicks, sees pothole, bounces immediately
- High bounce rate signals low quality to Google
- Potential manual penalty

✓ **Fix:**
```php
Metatag::setTitle('Pothole Via Roma Milano — Report and Track');
```

Metadata must match page content.

### 5. Noindex Everything

✗ **Bad:**
```php
// In robots middleware or config
Metatag::setRobots('noindex, nofollow');
```

- Platform invisible to search engines
- Zero organic traffic
- No growth lever

✓ **Fix:**
```php
// Index public content
// Noindex only temp/private pages
if (!$page->isPublished() || $page->isPrivate()) {
    Metatag::setRobots('noindex, follow');
}
```

---

## FALSE FRIENDS: SEO Misconceptions

### 1. Robots.txt Controls Indexing

**Misconception:** Setting `Disallow: /` in robots.txt prevents indexing.

**Reality:** Robots.txt blocks crawling, not indexing. If a URL is linked externally, Google can index it without crawling it. Use `<meta name="robots" content="noindex">` to prevent indexing.

**Implication:** Never rely on robots.txt alone to hide pages.

### 2. Canonical Chains Are OK

**Misconception:** Canonical chains (A→B→C→D) are fine as long as D is the true source.

**Reality:** Each redirect/canonical adds latency. Google may not follow the chain. Always canonical directly to the canonical source.

```
✗ Bad:   /page → canonical to /pages → canonical to /canonical/page
✓ Good:  /page → canonical to /canonical/page
         /pages → canonical to /canonical/page
```

### 3. More Backlinks = Higher Rank

**Misconception:** 100 backlinks always beats 10 backlinks.

**Reality:** Quality >> quantity. 1 link from a domain with DA (Domain Authority) 60+ is worth more than 100 links from domains with DA 10.

**Implication:** Don't chase link volume. Pursue topical, authoritative links.

### 4. Keywords in Title Guarantee Ranking

**Misconception:** Including a keyword in the title guarantees a top-10 rank.

**Reality:** Title is one of ~200 ranking factors. Content quality, backlinks, user experience, freshness matter more.

**Implication:** Don't over-optimize the title. Write for humans first, keywords second.

### 5. Meta Description Affects Rankings

**Misconception:** Optimizing meta descriptions improves rank.

**Reality:** Meta description is a CTR (click-through rate) factor, not a ranking factor. It affects visibility by making the result more clickable in SERPs.

**Implication:** Write compelling descriptions. They drive traffic, not rank.

### 6. Soft Redirect vs Hard Redirect

**Misconception:** Soft redirects (canonical, noindex on old URL) transfer PageRank. Hard redirects (301, 302) don't.

**Reality:** Both can pass PageRank if done correctly. A hard 301 is cleaner and faster for browsers. A canonical is slower (requires crawl + processing) but doesn't break bookmarks.

**Implication:** Use 301 redirects for URL migrations, canonicals for variant handling (parameters, session IDs).

---

## COME USARLO: Usage Guide

### Basic Setup in a Folio Page

```php
<!-- pages/issues/[id].blade.php -->
<?php

use function Laravel\Folio\name;
use Modules\Seo\Facades\Metatag;

name('issues.show');

$issue = Issue::findOrFail($id);

// Set metadata
Metatag::setTitle($issue->title);
Metatag::setDescription(Str::limit($issue->description, 155));
Metatag::setCanonical(route('issues.show', $issue));
Metatag::setImage($issue->featured_image_url);
Metatag::setType('article');
Metatag::setAuthor($issue->reportedBy->name);
Metatag::setPublishedTime($issue->created_at);
Metatag::setModifiedTime($issue->updated_at);

// Social sharing
Metatag::setOgTitle($issue->title);
Metatag::setOgDescription(Str::limit($issue->description, 155));
Metatag::setOgImage($issue->featured_image_url);
Metatag::setTwitterCard('summary_large_image');
Metatag::setTwitterTitle($issue->title);
Metatag::setTwitterDescription(Str::limit($issue->description, 200));

// Robots directives
if (!$issue->is_published) {
    Metatag::setRobots('noindex, follow');
}
?>

<div>
    <h1>{{ $issue->title }}</h1>
    <p>{{ $issue->description }}</p>
    ...
</div>
```

### Advanced: Conditional Metadata

```php
<?php
// Set locale for hreflang (multilingual sites)
Metatag::setLocale(app()->getLocale());

// Custom meta tags
Metatag::setMeta('article:section', $issue->category);
Metatag::setMeta('article:tag', $issue->tags->pluck('name')->join(','));

// Structured data (JSON-LD, implemented in Phase 1)
Metatag::setStructuredData([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $issue->title,
    'author' => $issue->reportedBy->name,
    'datePublished' => $issue->created_at->toIso8601String(),
    'image' => $issue->featured_image_url,
]);

// Theme colors (for PWA pinned colors)
Metatag::setColors([
    'primary' => '#3490dc',
    'secondary' => '#6574cd',
]);
?>
```

### Getting Metadata in Views

```blade
<?php
$meta = Metatag::get();
?>

<head>
    <title>{{ $meta->getTitle() }}</title>
    <meta name="description" content="{{ $meta->getDescription() }}">
    <meta name="keywords" content="{{ $meta->getKeywords() }}">
    <meta name="robots" content="{{ $meta->getRobots() }}">
    <link rel="canonical" href="{{ $meta->getCanonical() }}">
    
    <meta property="og:title" content="{{ $meta->get('og_title') ?? $meta->getTitle() }}">
    <meta property="og:description" content="{{ $meta->get('og_description') ?? $meta->getDescription() }}">
    <meta property="og:image" content="{{ $meta->getImage() }}">
    <meta property="og:type" content="{{ $meta->get('og_type', 'website') }}">
    
    <meta name="twitter:card" content="{{ $meta->get('twitter_card', 'summary_large_image') }}">
    <meta name="twitter:title" content="{{ $meta->getTitle() }}">
    <meta name="twitter:description" content="{{ $meta->getDescription() }}">
</head>
```

### Rendering in Blade Layout

```blade
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @include('seo::meta')
    
    <!-- Other head content -->
</head>
<body>
    {{ $slot }}
</body>
</html>
```

---

## COME INSTALLARLO: Installation Guide

### Step 1: Module Already Exists

The Seo module is already registered in the Laravel application. No Composer install needed.

### Step 2: Register Service Provider

In `bootstrap/providers.php`:

```php
'providers' => [
    // ...
    Modules\Seo\Providers\SeoServiceProvider::class,
    Modules\Seo\Providers\EventServiceProvider::class,
],
```

The SeoServiceProvider registers `MetatagManager` as a singleton.

### Step 3: Publish Views (Optional)

```bash
php artisan vendor:publish --tag=seo-views
```

This copies Seo module views to `resources/views/vendor/seo/` for customization.

### Step 4: Register Façade Alias (Optional)

In `bootstrap/app.php`:

```php
use Modules\Seo\Facades\Metatag;

// Alias for ease of use
class_alias(Metatag::class, 'Metatag');
```

Then use `Metatag::setTitle(...)` anywhere without importing.

### Step 5: Add to Layout Head

In your main layout (`resources/views/layouts/app.blade.php`):

```blade
<head>
    @include('seo::meta')
</head>
```

Create or customize `resources/views/vendor/seo/meta.blade.php`:

```blade
<?php
use Modules\Seo\Facades\Metatag;
$meta = Metatag::get();
?>

<title>{{ $meta->getTitle() }}</title>
<meta name="description" content="{{ $meta->getDescription() }}">
<meta name="keywords" content="{{ $meta->getKeywords() }}">
<meta name="robots" content="{{ $meta->getRobots() }}">
<link rel="canonical" href="{{ $meta->getCanonical() }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $meta->get('og_title') ?? $meta->getTitle() }}">
<meta property="og:description" content="{{ $meta->get('og_description') ?? $meta->getDescription() }}">
<meta property="og:image" content="{{ $meta->getImage() }}">
<meta property="og:type" content="{{ $meta->getType() }}">
<meta property="og:url" content="{{ $meta->getUrl() }}">

<!-- Twitter -->
<meta name="twitter:card" content="{{ $meta->get('twitter_card', 'summary_large_image') }}">
<meta name="twitter:title" content="{{ $meta->getTitle() }}">
<meta name="twitter:description" content="{{ $meta->getDescription() }}">
<meta name="twitter:image" content="{{ $meta->getImage() }}">
```

### Step 6: Configure in `config/seo.php`

```php
<?php
return [
    'name' => 'FixCity SEO',
    'default_robots' => 'index, follow',
    'default_og_type' => 'website',
    'social_handles' => [
        'twitter' => '@fixcity',
        'facebook' => 'fixcity',
    ],
    'enable_sitemap' => true,
    'enable_robots_txt' => true,
];
```

### Step 7: Test

Create a test page and verify metadata:

```php
// routes/web.php
Route::get('/test-seo', function () {
    Metatag::setTitle('Test Title');
    Metatag::setDescription('Test Description');
    return view('test-seo');
});
```

```bash
curl -s http://localhost:8000/test-seo | grep -E '<title>|<meta name="description"'
```

Expected output:
```html
<title>Test Title</title>
<meta name="description" content="Test Description">
```

---

## COVERAGE ANALYSIS

### What's Covered

- **MetatagManager:** Full façade coordination (get, set, update meta tags)
- **MetatagData / MetatagState:** Immutable data object and request-scoped container
- **Actions:** Atomic get/merge/replace operations
- **Social Share Generation:** Facebook, Twitter, LinkedIn, WhatsApp, Telegram links
- **Filament Integration:** Dashboard and widget (placeholder, ready for customization)

### What's Not Yet Covered (Future)

| Area | Status | Priority |
|------|--------|----------|
| **JSON-LD Structured Data** | Planned | HIGH |
| **XML Sitemap Generation** | Planned | HIGH |
| **Dynamic Robots.txt** | Planned | HIGH |
| **Hreflang (Multilingual)** | Planned | MEDIUM |
| **GA4 Integration** | Planned | MEDIUM |
| **Rank Tracking Dashboard** | Planned | MEDIUM |
| **Backlink Monitoring** | Planned | LOW |
| **Content Optimization AI** | Experimental | LOW |

### Test Coverage Goals

- Unit tests for MetatagManager setters/getters (100%)
- Unit tests for MetatagData property coercion (100%)
- Feature tests for full page metadata rendering (80%)
- Integration tests with Livewire components (80%)
- E2E tests with browser inspection (TBD)

### Code Quality

- **PHPStan Level 10:** Type safety enforced
- **PSR-12:** Code style compliance
- **Pest:** Test-driven development
- **No tech debt:** No deprecated APIs, no backward compat issues

---

## Conclusion: SEO as Philosophy, Not Plugin

The Seo module is deliberately minimal. It doesn't try to be Yoast or RankMath. Instead, it provides:

1. **A façade** for accumulating metadata per-request
2. **Immutable data objects** to prevent state corruption
3. **Atomic actions** to mutate state safely
4. **Livewire wireable support** for reactive components

From this foundation, FixCity builds:
- Discoverable civic issues
- Shareable insights
- Trustworthy authority

SEO is not magic. It's infrastructure. The Seo module is the foundation.

---

**Last updated:** 2025-09-06  
**Owner:** Seo Module Team  
**Platform:** FixCity · Laravel 13 · Filament 5
---
**Platform:** FixCity · Laravel 12 · Filament 5
