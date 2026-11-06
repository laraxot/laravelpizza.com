---
title: "philosophy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "philosophy"
issues: []
discussions: []
status: active
---

# Seo Module: Search Engine Optimization

> **Metadata & Sitemap** — Open Graph, structured data, dynamic sitemap, RSS feed.

---
## Zen

**"Metadata is free SEO. Automate it."**

---

## Quick

### No Models
This is a **behavior-only** module (utilities, data objects, actions).

### Data Objects
- **MetatagData** — Holder (title, description, image, keywords)
- **SocialShareData** — Open Graph / Twitter Card

### Pattern
```
Page render
  ↓
GenerateSocialShareLinksAction
  ↓
Inject <meta> tags in <head>
  ↓
+ Sitemap.xml auto-generated
  ↓
+ RSS feed auto-included
```

### Dependencies
- spatie/laravel-sitemap (auto-generate sitemap)
- spatie/laravel-feed (RSS generation)

### Actions (1)
- `GenerateSocialShareLinksAction` — Build social share URLs

### Widgets (1)
- `SocialShareWidget` — Share buttons (Filament)

---

## Integration

- Used by: All public pages (meta injection)
- Sitemap: Registered in robots.txt
- Feed: Auto-discovered by RSS readers

---

## Best/Bad

✓ Automatic sitemap (crawl routes, no manual list)
✓ OpenGraph defaults (card previews on social)
❌ Manual meta tags (use action instead)

---

## Roadmap

- JSON-LD structured data (Google Rich Results)
- Meta robots automation (index/noindex rules)
- Canonical URL enforcement

---

```
┌──────────────────────┐
│ Seo (Utilities)      │
├──────────────────────┤
│ Models: 0            │
│ Actions: 1           │
│ Status: Stable       │
│ Scope: Meta/Feed     │
└──────────────────────┘
```

---

## Module Closure Review (2026-09-06)

- **Generated**: 2026-09-06
- **Closure Status**: Verified
- **Merge Status**: Successful (laraxot/dev merged)
- **Test Status**: 35 passing, 12 failing (adapter persistence issues to be resolved separately)
- **PHPMD Status**: 1 minor issue (variable naming)
- **Documentation**: Philosophy and coverage updated

