---
title: "Bad Practices – Media Module"
module: "Media"
type: concept
tags: [BAD, PRACTICES]
created: 2026-07-14
updated: 2026-07-14
qmd: "bad practices"
related:
  - "./webm.md"
---
# Bad Practices – Media Module

- ❌ **VIOLATE** SVG asset location rule (see `svg-asset-location.md`) using invalid paths
- ❌ **USE** `img/svg` instead of proper `resources/svg/` directory
- ❌ **DUPLICATE** SVG files across modules (violates DRY)
- ❌ **IGNORING** size attributes in SVG markup
- ❌ **RELY** on inline SVG without proper sanitization

## Critical Violation
```php
// ❌ WRONG: SVG in wrong location
<img src="public/images/markers/default.svg">

// ✅ CORRECT: SVG in standard location
@svg('map-marker.svg')
```
