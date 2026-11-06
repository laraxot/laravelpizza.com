---
title: "Development record — localized Folio guest redirects"
type: implementation-record
status: verified
created: 2026-09-27
updated: 2026-09-27
tags: [bmad, folio, auth, locale, verification]
qmd: "localized auth redirects Folio bootstrap redirectGuestsTo implementation and tests"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ./STORY-CMS-FOLIO-LOCALE-AUTH-REDIRECT.md
---

# Development record

## Cause

The page metadata middleware authenticates Folio requests after `SetFolioLocale`
has resolved `en`, but Laravel's default guest redirect callback used the named
`login` route. That route generated the default `/it/auth/login` URL.

## Change

`bootstrap/app.php` overrides Laravel's `redirectGuestsTo` callback to build
`/auth/login` through `LaravelLocalization::getLocalizedURL()` using the current
resolved locale. The path fallback keeps that locale if route localization
cannot produce a URL. JSON requests continue through Laravel's 401 path.

## Verification plan / evidence

- Feature regression checks IT and EN route prefixes, app locale, facade locale,
  and redirect destination.
- JSON guest request returns 401 without a browser redirect.
- FixCity full suite, PHPStan Modules, Pint, wiki gate, Blade cache.
- Chromium follows guest wizard entry through the localized login at responsive
  viewports and checks the localized footer without overflow or JS errors.

Run tests with the disposable SQLite schema procedure documented in the FixCity
footer Second Brain handoff; do not replace secrets or edit `.env.testing`.
