# No Bootstrap Italia Rule

## Rule
**NEVER** include Bootstrap Italia CSS or JS in this project.

This project replicates the Design Comuni design system using **Tailwind CSS + Alpine.js** ONLY.

## Prohibited Patterns
- `<link href="...bootstrap-italia..." rel="stylesheet">`
- `<script src="...bootstrap-italia.bundle.min.js"></script>`
- `@extends('pub_theme::layouts.bootstrap-italia')`
- `<x-layouts.design-comuni>` (use `<x-layouts.app>`)
- Manual block fetching with `Page::where('slug', ...)->first()` (use Volt Component pattern)

## Allowed Patterns
- `@vite(['resources/css/app.css'], 'themes/Sixteen')`
- `<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>`
- `<x-layouts.app>` for ALL pages
- SVG icons from `themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg` (these are icon files, not Bootstrap)
- Tailwind `@apply` for replicating Bootstrap classes

## Why
The project's core purpose is to **replicate Bootstrap Italia's visual design using Tailwind CSS**, not to use Bootstrap itself. This keeps the bundle size small, avoids CSS conflicts, and maintains full control over the design system.

## Exceptions
- SVG sprite paths containing `bootstrap-italia/dist/svg/sprites.svg` — these are icon files only
- CSS class names that match Bootstrap Italia conventions (e.g., `btn-primary`, `container`, `row`) — these are replicated via Tailwind `@apply`

## Related
- See: `docs/html-structure-comparison.md` for project bridge docs
- See: `bashscripts/docs/html/html-structure-compare.md` for comparison tool docs
- See: `laravel/Themes/Sixteen/docs/architecture/README.md` for theme architecture
- See: `QWEN.md` for project memories and conventions
