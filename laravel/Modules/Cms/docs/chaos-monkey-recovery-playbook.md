# Chaos Monkey Recovery Playbook (CMS)

## Goal

Restore frontoffice rendering quickly when random failures hit template/theme/CMS boundaries.

## System Boundary

- Routing: Folio pages in active theme
- Rendering: `<x-page>` component (`Modules\\Cms\\View\\Components\\Page`)
- Content source: tenant JSON files via `SushiToJsons`
- Block hydration: `BlockData` + `ResolveBlockQueryAction`
- Theme namespace: `pub_theme::`

## Fast Triage (3 minutes)

1. Confirm active theme from tenant config (`xra.pub_theme`).
2. Confirm failing URL maps to Folio page (`index`, `[slug]`, `[container0]`, `[container0]/[slug0]`).
3. Confirm target page slug exists in JSON pages.
4. Confirm every block has valid `data.view`.
5. Confirm view namespace resolves (`pub_theme::...`).

## Canonical Runtime Chain

Request -> Folio page -> `PageSlugMiddleware` -> `<x-layouts.app>` -> `<x-page>` -> `Page::getBlocksBySlug()` -> `HasBlocks::compile()` -> `new BlockData(...)` -> `@include($block->view, $block->data)`.

If this chain breaks, prioritize fixing the earliest broken node.

## High-Probability Failure Modes

1. Missing or renamed Blade file referenced by `data.view`.
2. Broken namespace mapping (`pub_theme` not resolving).
3. Invalid block query model or scope in JSON.
4. Missing fallback slug page (for example `events.view`).
5. Invalid JSON syntax in content files.

## Recovery Procedures

## A) View Not Found

- Locate failing `data.view` in page/section JSON.
- Verify file exists under `Themes/{Theme}/resources/views/...`.
- If temporary mitigation needed, repoint `data.view` to a safe block template.
- Re-run page and verify no block-level exceptions.

## B) Namespace Resolution Failure

- Verify `register_pub_theme=true` in tenant config.
- Verify `CmsServiceProvider::registerNamespaces('pub_theme')` is active.
- Verify theme provider does not override with inconsistent namespace usage.
- Validate one reference: `pub_theme::components.blocks.hero.main`.

## C) Dynamic Query Failure

- Check `data.query.model` class exists.
- Check optional scopes are valid.
- Validate `orderBy` field exists.
- If needed, remove `query` temporarily and render static fallback content.

## D) Slug/Fallback Failure (`/container/slug`)

- Verify `[container0]/[slug0]/index.blade.php` computes `container0.view`.
- Ensure matching JSON page exists (for example `events.view`).
- If missing, create/restore fallback JSON page with one safe block.

## E) Locale URL Regressions

- Verify block data uses localized URLs (`event.url` from `toBlockArray()`).
- Avoid string-concatenated paths in Alpine templates.

## Minimal Safe Rollback Strategy

When failure is broad:
1. Keep layout and `<x-page>` intact.
2. Reduce page JSON to one known-safe block (`hero` or static text block).
3. Restore complex blocks incrementally.

## Verification Checklist

1. `/it` renders home blocks.
2. `/it/events` renders list blocks.
3. `/it/events/{slug}` resolves via `events.view` fallback.
4. Header/footer sections render without namespace errors.
5. No `view not found` exceptions in logs for block includes.

## Related Docs

- `cms-theme-template-runtime-architecture.md`
- `template-theme-cms-reference.md`
- `../../../Themes/Meetup/docs/chaos-monkey-theme-recovery-playbook.md`
