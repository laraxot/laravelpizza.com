# Project Research Summary

**Project:** LaravelPizza
**Domain:** Laravel Meetup Platform (Modular Laraxot)
**Researched:** 2026-03-05
**Confidence:** HIGH

## Executive Summary

LaravelPizza is a specialized meetup platform for the Italian Laravel community, built using the Laraxot modular architecture. Research confirms that a modern, reactive, and localized approach using Laravel 12, Folio, Volt, and Filament is the optimal path for 2025. This stack minimizes complexity by avoiding separate JS frameworks while providing a robust, type-safe environment (PHPStan Level 10) suitable for complex event registration and content management.

The platform distinguishes itself through a CMS-driven JSON content strategy and deep commitment to accessibility (WCAG 2.1 AA). Key risks include potential logic leakage into Blade/Volt components and the complexity of managing multi-tenant database routing, both of which are mitigated by strict adherence to Laraxot's Spatie Action and XotBase patterns.

## Key Findings

### Recommended Stack

Summary from [STACK.md](./STACK.md): A full-stack Laravel 12 ecosystem optimized for performance and type safety.

**Core technologies:**
- **Laravel 12 + PHP 8.3:** Backend foundation for modern features and strict typing.
- **Folio + Volt:** File-based routing and reactive UI without separate JS builds.
- **Filament 4:** Standardized back-office management via XotBase.
- **Tailwind CSS v4:** High-performance, mobile-first utility styling.

### Expected Features

Summary from [FEATURES.md](./FEATURES.md): Focused MVP on event discovery and registration.

**Must have (table stakes):**
- Event Browsing & Detail Pages — Core meetup discovery.
- Registration Flow — Essential attendee interaction.
- IT/EN Localization — Targeted community support.

**Should have (competitive):**
- CMS-driven JSON Pages — Differentiator for content flexibility.
- WCAG 2.1 AA Accessibility — Differentiator for inclusivity.
- QR Code Check-in — Enhanced event-day experience.

**Defer (v2+):**
- Paid Ticketing — Adds significant financial/legal complexity.
- Social Networking — High maintenance and moderation burden.

### Architecture Approach

Summary from [ARCHITECTURE.md](./ARCHITECTURE.md): Modular Monolith (Laraxot) with clear layer separation.

**Major components:**
1. **Cms Module:** Page resolution and rendering logic.
2. **Meetup Module:** Event domain models and actions.
3. **Tenant Module:** Dynamic DB and theme routing.
4. **UI Module:** Shared components and Filament standards.

### Critical Pitfalls

Top 3 from [PITFALLS.md](./PITFALLS.md):

1. **Logic in Blade/Volt:** Avoid by enforcing Spatie Actions for all business logic.
2. **Hardcoded Translations:** Prevent by requiring `lang/` keys for all UI strings.
3. **Accessibility Gaps:** Mitigate by integrating WCAG 2.1 AA checks into Phase 3 & 6.

## Implications for Roadmap

Based on research, suggested phase structure:

### Phase 1: Data Layer & Core Logic
**Rationale:** Foundations must be solid before UI is built.
**Delivers:** Migrations, Models, Factories, and core Spatie Actions.
**Addresses:** FR-001 (Event CRUD) and FR-004 (Registration logic).
**Avoids:** Logic leakage into UI by establishing Actions first.

### Phase 2: Admin Panel (Filament)
**Rationale:** Allows immediate content entry and management.
**Delivers:** Filament Resources for all domain entities.
**Uses:** XotBase wrappers for project-wide consistency.

### Phase 3: Public Front Office (Folio/Volt)
**Rationale:** Builds the primary user-facing experience.
**Delivers:** Event browsing, Detail pages, and Registration forms.
**Implements:** CMS-driven page resolution and WCAG 2.1 AA components.

### Phase 4: Localization & SEO
**Rationale:** Ensures the platform reaches its target audience effectively.
**Delivers:** Full IT/EN translations and optimized meta tags/structured data.

### Phase 5: Notifications & Compliance
**Rationale:** Finalizes the user experience and legal requirements.
**Delivers:** Confirmation emails and GDPR/Cookie consent.

### Phase 6: Quality Gates & Audit
**Rationale:** Ensures the platform meets the strict Laraxot standards.
**Delivers:** Zero PHPStan errors, 80%+ coverage, and WCAG AA audit report.

### Phase Ordering Rationale

- **Data First:** Ensures domain integrity before UI dependencies.
- **Admin Second:** Enables early content entry for testing.
- **UI Third:** Builds on established domain and admin layers.
- **Localization/SEO Late:** Best done once UI is stable.

### Research Flags

Phases likely needing deeper research during planning:
- **Phase 3 (Front Office):** Complex JSON-to-component mapping for CMS blocks.
- **Phase 6 (Audit):** WCAG 2.1 AA specific patterns for complex registration states.

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH | Based on Laravel 12/Laraxot standards. |
| Features | HIGH | Well-defined for meetup platforms. |
| Architecture | HIGH | Established Laraxot modular pattern. |
| Pitfalls | HIGH | Common in this specific ecosystem. |

**Overall confidence:** HIGH

### Gaps to Address

- **Real-time Reverb Scale:** Needs validation during Phase 5 for concurrent registrations.
- **JSON Content Structure:** Needs final schema definition for Cms blocks in Phase 3.

## Sources

### Primary (HIGH confidence)
- Laravel 12 Official Docs.
- FilamentPHP v4 Documentation.
- Laraxot Super Mucca Methodology.

### Secondary (MEDIUM confidence)
- Spatie Queueable Action Patterns.
- WCAG 2.1 AA Compliance Checklist.

---
*Research completed: 2026-03-05*
*Ready for roadmap: yes*
