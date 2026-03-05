# Roadmap: LaravelPizza

## Overview

LaravelPizza is a modernized meetup platform for the Italian Laravel community. This roadmap covers the end-to-end development of the v1 MVP, starting from the foundational data layer and modular architecture, through the CMS-driven front office, to the final quality and accessibility audits. Each phase is designed to deliver a specific, testable component of the platform, following Laraxot's strict architectural discipline.

## Phases

- [ ] **Phase 1: Foundation & Models** - Establish core Eloquent models and migrations for the Meetup module.
- [ ] **Phase 2: Core Domain Actions** - Implement business logic for event registration and management via Spatie Actions.
- [ ] **Phase 3: Admin Panel - Core** - Build Filament resources for Events and Venues using XotBase.
- [ ] **Phase 4: Admin Panel - Support** - Build Filament resources for Performers and Sponsors.
- [ ] **Phase 5: CMS Infrastructure** - Implement JSON-based page resolution and content block rendering.
- [ ] **Phase 6: Front Office - Discovery** - Build localized event listing and search pages using Folio and Volt.
- [ ] **Phase 7: Front Office - Detail & Registration** - Build interactive event detail pages and registration forms.
- [ ] **Phase 8: Localization (IT/EN)** - Implement full translation support for all UI strings and routes.
- [ ] **Phase 9: SEO & Social Metadata** - Integrate dynamic meta tags, sitemaps, and JSON-LD structured data.
- [ ] **Phase 10: Notifications & Emails** - Implement email dispatching for registration confirmations.
- [ ] **Phase 11: GDPR & Compliance** - Build cookie consent and privacy management features.
- [ ] **Phase 12: Quality Audit & Coverage** - Achieve 100% Pest coverage and pass WCAG 2.1 AA audit.

## Phase Details

### Phase 1: Foundation & Models
**Goal**: Establish the core data structure for the Meetup module.
**Depends on**: Nothing
**Requirements**: REGS-03
**Success Criteria**:
  1. Models for Event, Venue, Performer, Sponsor exist with proper types.
  2. Migrations for all core entities are completed and tested.
  3. Factories and Seeders generate realistic meetup data.
**Plans**: 4 plans
- [ ] 01-01: Create core migrations and models for Meetup module.
- [ ] 01-04: Consolidate and verify migration set for entities and pivots.
- [ ] 01-02: Implement factories and seeders for realistic data generation.
- [ ] 01-03: Verify foundation artifacts and REGS-03 readiness with focused tests.

### Phase 2: Core Domain Actions
**Goal**: Implement the business logic for event operations.
**Depends on**: Phase 1
**Requirements**: REGS-01, REGS-03
**Success Criteria**:
  1. `RegisterUserToEventAction` correctly handles registration and capacity limits.
  2. All core actions are covered by Pest tests with 100% coverage.
**Plans**: 2 plans
- [ ] 02-01: Implement `RegisterUserToEventAction` with capacity validation.
- [ ] 02-02: Implement supporting actions for event management.

### Phase 3: Admin Panel - Core
**Goal**: Provide administrative control over primary meetup data.
**Depends on**: Phase 1
**Requirements**: ADMN-01, ADMN-02
**Success Criteria**:
  1. Admins can create and edit Events and Venues via Filament.
  2. Resources extend `XotBaseResource` and follow project standards.
**Plans**: 2 plans
- [ ] 03-01: Create `EventResource` with full schema and relations.
- [ ] 03-02: Create `VenueResource` with geographic data integration.

### Phase 4: Admin Panel - Support
**Goal**: Manage supporting entities like performers and sponsors.
**Depends on**: Phase 3
**Requirements**: ADMN-02
**Success Criteria**:
  1. Admins can manage Performers and Sponsors via Filament.
  2. Relations between events and performers/sponsors are manageable.
**Plans**: 2 plans
- [ ] 04-01: Create `PerformerResource` and `SponsorResource`.
- [ ] 04-02: Implement pivot management for Event-Performer and Event-Sponsor.

### Phase 5: CMS Infrastructure
**Goal**: Enable data-driven page rendering.
**Depends on**: Phase 1
**Requirements**: CMSP-01, CMSP-02, CMSP-03
**Success Criteria**:
  1. `ResolvePageContentAction` correctly parses JSON files into content blocks.
  2. A generic Folio page renders content based on the slug.
**Plans**: 2 plans
- [ ] 05-01: Implement JSON page resolution logic in Cms module.
- [ ] 05-02: Build the base `x-page` component and block renderer.

### Phase 6: Front Office - Discovery
**Goal**: Enable users to find upcoming and past events.
**Depends on**: Phase 5
**Requirements**: EVNT-01, EVNT-02, EVNT-04
**Success Criteria**:
  1. Users can view a list of upcoming events on the homepage.
  2. Search and filter functionality works for city and date.
**Plans**: 2 plans
- [ ] 06-01: Build the event listing Volt component.
- [ ] 06-02: Implement search and filtering logic for events.

### Phase 7: Front Office - Detail & Registration
**Goal**: Provide full event information and allow registration.
**Depends on**: Phase 2, Phase 6
**Requirements**: EVNT-03, REGS-01, QUAL-02
**Success Criteria**:
  1. Event detail pages render correctly with all metadata.
  2. The registration form is interactive, accessible, and functional.
**Plans**: 2 plans
- [ ] 07-01: Build the event detail Volt component.
- [ ] 07-02: Build the interactive registration form with Volt.

### Phase 8: Localization (IT/EN)
**Goal**: Ensure the platform is fully accessible in Italian and English.
**Depends on**: Phase 7
**Requirements**: LOCL-01, LOCL-02, LOCL-03
**Success Criteria**:
  1. All UI strings are translated and managed via module lang files.
  2. URL locale switching works seamlessly across all pages.
**Plans**: 2 plans
- [ ] 08-01: Implement translation keys for all UI components.
- [ ] 08-02: Configure and test `mcamara/laravel-localization` for all routes.

### Phase 9: SEO & Social Metadata
**Goal**: Optimize the platform for discovery and sharing.
**Depends on**: Phase 8
**Requirements**: QUAL-03, QUAL-04
**Success Criteria**:
  1. Every page has unique meta tags and canonical URLs.
  2. JSON-LD structured data is present on event pages.
**Plans**: 2 plans
- [ ] 09-01: Implement SEO meta tag generation for CMS pages.
- [ ] 09-02: Implement JSON-LD generation for events.

### Phase 10: Notifications & Emails
**Goal**: Finalize user communication for registrations.
**Depends on**: Phase 7
**Requirements**: REGS-02
**Success Criteria**:
  1. Registration confirmation emails are sent upon successful registration.
  2. Emails are queued and use localized templates.
**Plans**: 2 plans
- [ ] 10-01: Create registration confirmation Mailable and templates.
- [ ] 10-02: Integrate email dispatching into `RegisterUserToEventAction`.

### Phase 11: GDPR & Compliance
**Goal**: Ensure legal compliance for user data and tracking.
**Depends on**: Phase 9
**Requirements**: QUAL-01
**Success Criteria**:
  1. Cookie consent banner correctly manages non-essential script loading.
  2. Privacy policy and terms pages are accessible and localized.
**Plans**: 2 plans
- [ ] 11-01: Build the cookie consent Volt component.
- [ ] 11-02: Create and configure compliance pages via CMS.

### Phase 12: Quality Audit & Coverage
**Goal**: Finalize the platform according to strict Laraxot standards.
**Depends on**: Phase 11
**Requirements**: QUAL-02
**Success Criteria**:
  1. 100% Pest coverage for all business-critical logic.
  2. Zero PHPStan level 10 errors across all modules.
  3. WCAG 2.1 AA audit passed with no critical violations.
**Plans**: 2 plans
- [ ] 12-01: Finalize test coverage and type safety audits.
- [ ] 12-02: Conduct accessibility audit and remediation.

## Progress

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Foundation | 0/2 | Not started | - |
| 2. Core Actions | 0/2 | Not started | - |
| 3. Admin Core | 0/2 | Not started | - |
| 4. Admin Support | 0/2 | Not started | - |
| 5. CMS Infra | 0/2 | Not started | - |
| 6. FO Discovery | 0/2 | Not started | - |
| 7. FO Detail | 0/2 | Not started | - |
| 8. Localization | 0/2 | Not started | - |
| 9. SEO & Social | 0/2 | Not started | - |
| 10. Notifications | 0/2 | Not started | - |
| 11. GDPR | 0/2 | Not started | - |
| 12. Quality Audit | 0/2 | Not started | - |
