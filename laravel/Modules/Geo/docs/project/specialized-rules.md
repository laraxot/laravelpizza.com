# Specialized Rules & Configurations

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
- To see changes: `npm run build && npm run copy` inside the theme directory.
- Assets are served from `public_html/themes/{ThemeName}`.
- `@vite` requires the theme's base path (e.g., `'themes/Meetup'`).
