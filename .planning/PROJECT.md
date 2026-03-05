# LaravelPizza

## What This Is

LaravelPizza is a modernized conversion of laravelpizza.com, the Italian Laravel developer meetup platform. It is a community hub designed to be engaging, share-worthy, and conversion-optimized, built with a modular architecture (Laraxot) using Laravel 12, Folio, Volt, and Filament.

## Core Value

Providing a robust, accessible, and community-driven platform for Italian Laravel developers to discover, register for, and manage meetup events.

## Requirements

### Validated

- ✓ Modular architecture (Laraxot) — established
- ✓ Core modules (Xot, Tenant, User, Cms, etc.) — established
- ✓ Folio + Volt for front office — established
- ✓ Filament for admin panel — established
- ✓ Italian and English localization support — established

### Active

- [ ] FR-001: Admins must be able to create, edit, and delete events via Filament
- [ ] FR-002: Visitors must be able to browse upcoming events without authentication
- [ ] FR-003: Each event must have a public detail page: title, description, date, venue, speakers, sponsors
- [ ] FR-004: Visitors must be able to register for an event with a valid email address
- [ ] FR-005: All public pages must render in Italian and English via URL locale prefix
- [ ] FR-006: All public pages must be rendered from JSON content files
- [ ] FR-007: Cookie consent must be collected before analytics or marketing cookies are set
- [ ] FR-008: All public pages must meet WCAG 2.1 AA requirements
- [ ] FR-009: Each public page must have title, meta description, canonical URL, and JSON-LD structured data
- [ ] FR-010: Admins must have a Filament dashboard showing event count, registration count, recent activity

### Out of Scope

- Paid ticket / e-commerce flows — Phase 2
- Live streaming integration — Future release
- Mobile native apps — Future release
- Real-time chat during events — Future release
- A/B testing infrastructure — Future release
- External OAuth for event providers (Eventbrite, Meetup.com) — Future release
- CDN configuration — Infrastructure concern

## Context

- The project is an elevation of the original laravelpizza.com, addressing its lack of event discovery, registration, and profile tracking.
- It uses the "Laraxot" modular architecture, which emphasizes strict architectural discipline, type safety (PHPStan level 10), and separation of concerns.
- Content is CMS-driven, utilizing JSON files for page structure and content blocks.

## Constraints

- **Tech Stack**: Laravel 12, Folio, Volt, Filament, Laraxot — Project standards
- **Architecture**: Modular Monolith — Must follow Laraxot conventions
- **Front Office**: Folio + Volt only — No traditional controllers for public pages
- **Admin**: Filament via XotBase — Custom wrappers for consistency
- **Quality**: PHPStan Level 10 + Zero Errors — Mandatory static analysis
- **Accessibility**: WCAG 2.1 AA — Compliance requirement
- **Database**: Single connection for modules — Dynamic routing via Tenant module

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Modular Architecture | Laraxot pattern for scalability and isolation | ✓ Good |
| Folio + Volt | Modern, file-based routing and reactive UI for front office | ✓ Good |
| JSON-based CMS | Decouples content management from code deployments | ✓ Good |
| XotBase Wrappers | Standardizes Filament implementation across modules | ✓ Good |

---
*Last updated: 2026-03-05 after initialization*
