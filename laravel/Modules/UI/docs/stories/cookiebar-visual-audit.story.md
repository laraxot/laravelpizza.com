---
type: ui-audit-story
title: Cookiebar visual audit and accessibility compliance
status: todo
links:
  github_issue: 0
  module: UI
  related_stories:
    - ui-module-bmad-setup.story.md
    - phpstan-cleanup-ui.story.md
created: 2026-10-14T13:36:00Z
updated: 2026-10-14T13:36:00Z
---

# Cookiebar Visual Audit

## Objective

Audit the `ui/cookiebar.blade.php` component for visual quality, accessibility, and compliance with cookie consent regulations (GDPR/LDMA).

## Current State

File: `laravel/Modules/UI/resources/views/components/ui/cookiebar.blade.php`

Issues identified:
- Inline `<script>` and `<style>` tags violate Livewire/Blade component isolation
- No `prefers-reduced-motion` media query support
- Auto-hide on scroll is jarring and may confuse users with motor impairments
- No focus management for keyboard navigation
- The `acceptText`, `rejectText`, `customizeText` props use `__()` but the default strings are hardcoded Italian
- Missing `role="dialog"` and `aria-live` for screen readers
- Cookie preference state not persisted in a testable way (`$wire.acceptAllCookies()` called but the Livewire method may not exist)
- No test coverage for the component (see `ComponentFilesExistTest` only checks existence)

## Actors Affected

- **All visitors**: First thing seen on the front-of-house web properties (customer QR menu, waiter portal, public pages)
- **Privacy officers**: Must verify GDPR/LDMA compliance before go-live

## Acceptance Criteria

- [ ] Remove inline `<script>`: move to a dedicated JS module or Livewire `wire:ignore`
- [ ] Remove inline `<style>`: use Tailwind classes (already mostly done) with `@layer components`
- [ ] Add `prefers-reduced-motion: reduce` to the scroll hide/show animation
- [ ] Add `role="dialog" aria-live="polite"` and `aria-label` for screen readers
- [ ] Ensure all buttons are reachable via Tab and have visible focus rings (`focus:ring-2`)
- [ ] Verify `$wire.acceptAllCookies()`, `$wire.rejectAllCookies()`, `$wire.showCookiePreferences()` methods exist on the parent Livewire component
- [ ] Add a Pest feature test that renders the cookiebar and asserts the presence of accept/reject buttons
- [ ] Default strings should use translation keys consistently, not hardcoded Italian

## Implementation Notes

- The cookiebar is rendered on FO web pages (Folio routes). No Filament admin usage.
- Related: the cookie policy URL should be configurable from `CompanyConfig` or the Cms module's settings.
- Consider using the `a11y-accessibility` MCP server for automated accessibility checking.

## Related Links

- Component: `Modules/UI/resources/views/components/ui/cookiebar.blade.php`
- Test: `Modules/UI/tests/Feature/ComponentFilesExistTest.php`
- Convention: `bashscripts/docs/prompts/55-md-conventions.md`
