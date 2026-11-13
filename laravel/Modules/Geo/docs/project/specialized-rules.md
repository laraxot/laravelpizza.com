---
title: "specialized rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "specialized rules"
issues: []
discussions: []
status: draft
---

# Specialized Rules & Configurations

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

This document contains niche but critical rules for specific domains of the project.

## Regional Admin Levels (Italy)
When dealing with Google Maps or administrative data in Italy:
- `administrative_area_level_1`: Regione
- `administrative_area_level_2`: Provincia
- `administrative_area_level_3`: Comune / Città Metropolitana

## Layouts Hierarchy
Avoid ad-hoc layouts. Use the following structure:
- `x-layouts.main`: The core HTML structure (metatags, body wrapper).
- `x-layouts.app`: Main application layout (Header, Nav, Footer). Extensions of `main`.
- `x-layouts.guest`: Authentication layout (Login/Register). Extensions of `main`.

## Seasonal Email Templates
- **Base**: `base.html` contains the overarching layout with `{{{ body }}}`.
- **Fragments**: Templates like `christmas-content.blade.php` are HTML fragments (Blade views) injected into the base.
- **Mailable**: The Mailable class controls the layout and view via `DetermineSeasonalContentViewPathAction`.

## Content Management (JSON-Driven)
- Create `.json` files in `config/local/<nome progetto>/database/content/pages/` to define new content pages.
- Avoid creating new Blade files for simple content; use the generic `[slug].blade.php` with the `x-page` component.

## Frontend Assets
- To see changes: `npm run build` inside the theme directory.
- Assets are served from `public_html/themes/{ThemeName}`.
- `@vite` requires the theme's base path (e.g., `'themes/Meetup'`).
