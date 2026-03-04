# Chaos Monkey Recovery Playbook (Meetup Theme)

## Objective

Recover UI rendering and navigation behavior in the active frontoffice theme after randomized breakages.

## Theme Critical Surfaces

1. Layout stack: `main` -> `app` -> page content.
2. Section rendering: `<x-section slug=\"header\"/>`, `<x-section slug=\"footer\"/>`.
3. Page blocks loaded through CMS `data.view` paths.
4. Theme translations under `pub_theme::`.
5. Event pages relying on localized `event.url` values.

## First Response Sequence

1. Open layout files and verify syntax and includes.
2. Validate section templates exist (`components/sections/header|footer/v1.blade.php`).
3. Validate JSON section block views point to existing files.
4. Validate event list/detail blocks still resolve their data source.
5. Validate language-prefixed links in UI still include locale.

## Known Sensitive Points

- Header/footer JSON may contain stale or invalid view namespaces.
- Legacy layout files can point to old theme asset build targets.
- Detail page can fail if `slug0` flow breaks in Folio route file.
- Some blocks implement fallback DB queries; this can mask upstream failures and create inconsistent behavior.

## Hard Rules Under Incident

1. Do not replace `pub_theme::` with theme-specific namespace.
2. Do not bypass `<x-page>` with ad-hoc resolvers in Folio page files.
3. Do not use `route()` for frontoffice navigation links.
4. Keep localized URLs via `LaravelLocalization::localizeUrl()` or precomputed model URLs.

## Recovery Recipes

## Recipe 1: Broken Header or Footer

- Check `config/local/{tenant}/database/content/sections/{header,footer}.json`.
- Fix invalid `data.view` values to existing `pub_theme::components.blocks...` paths.
- Verify related section template in `components/sections/...` can include those blocks.

## Recipe 2: Event Detail Route Works but Content Missing

- Check `[container0]/[slug0]/index.blade.php` and computed `pageSlug`.
- Ensure `events.view` page exists in tenant JSON pages.
- Ensure `events.detail` block receives `slug0` through `x-page` data merge.

## Recipe 3: Locale Links Broken

- For Alpine lists, enforce `:href=\"event.url\"`.
- Avoid `'/events/' + event.slug` patterns.

## Recipe 4: Theme Translation Missing

- Verify key path in `Themes/Meetup/lang/{locale}/*.php`.
- Keep structured translation arrays; avoid flat key regressions.

## Quick Validation URLs

1. `/it`
2. `/it/about`
3. `/it/events`
4. `/it/events/{known-slug}`
5. `/en/events`

## Related Docs

- `chaos-monkey-debug-skills.md`
- `memories/cms-theme-runtime-memory.md`
- `../../../Modules/Cms/docs/chaos-monkey-recovery-playbook.md`
