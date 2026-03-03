# LaravelPizza - Product Requirements Document

## Metadata

| Field | Value |
|-------|-------|
| Status | In Development |
| Owner | Engineering Lead |
| Repository | base_laravelpizza |
| Target Release | Q2 2026 |
| Version | 2.0 |

## Overview

LaravelPizza is an improved, modernized conversion of laravelpizza.com — the Italian Laravel developer meetup platform. The goal is not a replica but an elevation: a more engaging, share-worthy, conversion-optimized community hub for Laravel developers, built on Laravel 12 with modular architecture, Folio + Volt for front office, Filament for admin, and strict architectural discipline.

## Problem statement

The original laravelpizza.com is a static, minimal site. It lacks:
- Event discovery and registration flows
- Community profile and attendance tracking
- Multi-language support for Italian and international audiences
- A CMS-driven content strategy that allows non-developer content updates
- Modern, accessible design that encourages sharing and repeat visits

The cost of inaction is a community platform that fails to grow, where events have low visibility and registration is handled externally.

## Goals

- Enable event creation, discovery, and registration entirely within the platform
- Support Italian and English locales out of the box, extensible to others
- Allow content managers to update pages without deploying code (CMS-driven JSON pages)
- Achieve WCAG 2.1 AA accessibility across all public pages
- Pass PHPStan level 10 with zero errors across all modules
- Achieve 80%+ test coverage for business-critical logic

## Non-goals (this release)

- Paid ticket / e-commerce flows (Phase 2)
- Live streaming integration
- Mobile native apps
- Real-time chat during events
- A/B testing infrastructure
- External OAuth for event providers (Eventbrite, Meetup.com)
- CDN configuration (infrastructure concern, not product)

## Target users

| User | Role | Needs |
|------|------|-------|
| Attendee | Laravel developer discovering events | Browse events, register, receive confirmations |
| Organizer | Creates and manages meetup events | Create events, manage registrations, view attendance |
| Content manager | Updates site copy and pages | Edit page content without code deployments |
| Admin | Platform operator | Full Filament admin access to all modules |
| AI coding agent | Automated code generation | Predictable patterns, explicit constraints, strict types |

## Modules

| Module | Purpose |
|--------|---------|
| Meetup | Core domain: events, performers, sponsors, registrations |
| Cms | CMS-driven page rendering via JSON content files |
| User | Authentication, profiles, roles |
| Tenant | Multi-tenancy configuration and per-tenant database routing |
| Lang | Localization, locale switching, mcamara integration |
| Activity | Audit trail, event sourcing, user action logging |
| Notify | Email and notification dispatching |
| Geo | Geographic data: comuni, province, regioni |
| Media | File uploads and media library (spatie) |
| Gdpr | Cookie consent, privacy settings, GDPR compliance |
| Seo | Meta tags, structured data, sitemap generation |
| Job | Background job monitoring and queue management |
| UI | Shared UI components and Filament widget base classes |
| Xot | Core Laraxot framework: base classes, conventions, utilities |

## Architecture constraints (critical for AI agents)

These constraints are non-negotiable. Any generated code that violates them must be rejected.

### Front office (public pages)
- Folio + Volt only. No traditional controllers.
- No routes in `web.php` or `api.php` for public pages.
- Pages are defined as JSON files in `config/local/laravelpizza/database/content/pages/`.
- Block components live in `Themes/Meetup/resources/views/components/blocks/`.
- Blade namespace for all theme views: `pub_theme::` (never the theme name directly).

### Admin panel
- Filament only, via XotBase abstracts.
- Never extend `Filament\Resources\Resource` directly: always extend `XotBaseResource`.
- Never extend `Filament\Pages\Page` directly: always extend `XotBasePage`.
- No `->label()`, `->placeholder()`, `->helperText()` in Filament components; auto-labeling handles this.

### Database and models
- No per-module database connections in `config/database.php` or tenant config files.
- `TenantServiceProvider::registerDB()` adds module connections dynamically.
- Many-to-many: always `$this->belongsToManyX()`, never `$this->belongsToMany()`.
- One table, one create migration. Schema changes use `add_{column}_to_{table}` migrations.
- Use `XotBaseMigration` with `tableCreate()` and `tableUpdate()` methods.

### Routing and URLs
- All localized links: `LaravelLocalization::localizeUrl('/path')`.
- Current locale: `LaravelLocalization::getCurrentLocale()`.
- Language selector: `LaravelLocalization::getLocalizedURL($code, null, [], true)`.
- Never build locale-prefixed URLs manually.

### SVG icons
- No inline SVG in Blade files.
- Create `.svg` in `Modules/Meetup/resources/svg/`.
- Reference with `<x-filament::icon icon="meetup-{name}" class="..." />`.

### Code quality
- Every PHP file: `declare(strict_types=1);` at the top.
- PHPStan level 10: zero errors required before any commit.
- Laravel Pint for formatting.
- Return types on every method.

### Packages
- Module-specific packages go in the module's own `composer.json`, not `laravel/composer.json`.
- Theme-specific packages go in the theme's `composer.json`.
- Root `laravel/composer.json` uses `wikimedia/composer-merge-plugin` to aggregate.

### Translations
- Keys follow the structure: `{module}::{resource}.fields.{name}.label`.
- Never flat top-level keys like `'date' => 'Data'`.
- All strings go through the translation system; never hardcode UI strings.

## Functional requirements

| ID | Requirement |
|----|-------------|
| FR-001 | Admins must be able to create, edit, and delete events via Filament |
| FR-002 | Visitors must be able to browse upcoming events without authentication |
| FR-003 | Each event must have a public detail page: title, description, date, venue, speakers, sponsors |
| FR-004 | Visitors must be able to register for an event with a valid email address |
| FR-005 | All public pages must render in Italian and English via URL locale prefix |
| FR-006 | All public pages must be rendered from JSON content files (no per-page Blade files) |
| FR-007 | Cookie consent must be collected before analytics or marketing cookies are set |
| FR-008 | All public pages must meet WCAG 2.1 AA requirements |
| FR-009 | Each public page must have title, meta description, canonical URL, and JSON-LD structured data |
| FR-010 | Admins must have a Filament dashboard showing event count, registration count, recent activity |

## Non-functional requirements

| Category | Requirement |
|----------|-------------|
| Performance | Public pages load in under 2 seconds on a 4G connection |
| Security | HTTPS only, CSRF on all forms, input sanitization |
| Accessibility | WCAG 2.1 AA on all public pages |
| PHP version | PHP 8.2+ |
| Laravel version | Laravel 12 |
| Static analysis | PHPStan level 10, zero errors |
| Code style | PSR-12 via Laravel Pint |
| Test coverage | 80% minimum for business logic |
| Localization | Italian and English at minimum |
| Multi-tenancy | Single codebase, tenant-isolated data via Tenant module |

## Data model overview

| Entity | Module | Key fields |
|--------|--------|------------|
| Event | Meetup | id, slug, title, description, start_at, end_at, venue_id, published_at |
| User | User | id, name, email, password, locale |
| Profile | Meetup | id, user_id, bio, avatar, github_url |
| Venue | Meetup | id, name, address, city, geo_comune_id |
| Performer | Meetup | id, name, bio, role |
| Sponsor | Meetup | id, name, logo, url |
| EventUser | Meetup | event_id, user_id (pivot: registration) |
| EventPerformer | Meetup | event_id, performer_id (pivot: speaker/organizer) |
| EventSponsor | Meetup | event_id, sponsor_id (pivot: sponsorship) |
| Page | Cms | id, slug, title, content_blocks (JSON) |

## Success metrics

| Metric | Target | Measurement window |
|--------|--------|-------------------|
| PHPStan errors | 0 | Per commit |
| Test coverage | 80%+ | Per release |
| Public page load time | < 2s | Monthly audit |
| Accessibility score | 100 (Lighthouse) | Per release |
| Event registration conversion | > 50% | 30 days post-launch |

## Implementation phases

| Phase | Scope |
|-------|-------|
| Phase 1 | Data layer: migrations, models, factories, seeders |
| Phase 2 | Admin panel: Filament resources for all entities |
| Phase 3 | Public front office: CMS JSON pages, Folio routing, Volt components |
| Phase 4 | Localization and SEO: full `it`/`en` translations, meta tags, sitemap |
| Phase 5 | Notifications and GDPR: confirmation emails, cookie consent |
| Phase 6 | Quality gates: PHPStan zero errors, 80%+ coverage, WCAG AA audit |

## Dependencies

| Dependency | Type | Required by |
|------------|------|-------------|
| Xot module | Module | All modules (base classes) |
| Tenant module | Module | All modules (DB routing, theme resolution) |
| Lang module | Module | All modules (translations, locale) |
| User module | Module | Meetup (registrations), Gdpr (consent records) |
| Cms module | Module | Theme (page rendering) |
| mcamara/laravel-localization | Package | Lang module |
| spatie/laravel-medialibrary | Package | Media module |
| spatie/laravel-activity-log | Package | Activity module |
| spatie/laravel-data | Package | All modules (DTOs) |
| spatie/queueable-action | Package | All modules (Actions) |

## Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| PHPStan level 10 failures in generated code | High | Medium | PHPStan in CI; fix before merge |
| Duplicate migrations across modules | Medium | High | One-table-one-migration rule; code review |
| Locale routing breaking form submissions | Medium | High | localizeUrl() on all form actions; feature tests |
| AI agent violating architecture constraints | High | High | Architecture Constraints section in every PRD |
| Tenant DB config drift | Low | High | database-config-standard rule; test per tenant |

## Testing strategy

- Unit tests: all Action classes (`execute()` method), all Data DTOs (validation)
- Feature tests: Folio routes (`GET /it/events`, `GET /en/events/{slug}`), registration flow
- Admin tests: Filament resource create/edit/delete for Event, User, Performer, Sponsor
- PHPStan: runs in CI on every push; zero errors required
- Pint: runs in pre-commit hook; zero formatting errors
- Coverage: `php artisan test --coverage --min=80`

## Open questions

| Question | Owner | Status |
|----------|-------|--------|
| Which email driver for production (Mailgun vs SES vs Postmark)? | DevOps | Open |
| Waitlist feature for sold-out events: Phase 2 or Phase 1? | PM | Open |
| Social share preview images: generated or static? | Design | Open |
| Should performers have their own public profile pages? | PM | Open |
