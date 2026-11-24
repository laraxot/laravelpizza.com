---
title: "svg asset location"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "svg asset location"
issues: []
discussions: []
---

# SVG Asset Location Rule

## Enforced Policy
- ALL SVGs must be in `laravel/Modules/Geo/resources/svg/`
- NO external sources (unpkg/cdn)

## Exceptions
- SVG inline via `divIcon` in `map-picker-marker-config.js`
- If separate SVG needed, use `resources/svg/` within module

## Validation
```bash
find laravel/Modules/Geo -name "*.svg" | grep -v "/resources/svg/"
# Should return 0 results```