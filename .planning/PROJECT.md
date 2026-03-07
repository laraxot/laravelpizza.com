# LaravelPizza Delivery Program (Dual-Track)

## What This Is

Operational program that runs two coordinated tracks in parallel:

1. **Track A - Product Delivery**: meetup platform capabilities (admin, public events, registrations, CMS, localization, compliance).
2. **Track B - Quality Delivery**: 100% Pest code coverage + 100% type coverage across modular runtime code.

## Core Value

Ship user-facing value continuously while hardening quality gates, so product progress and test integrity move together instead of competing.

## Decision (2026-03-06)

Program mode set to **Dual-Track** with explicit governance and shared reporting.

## Capacity Policy

- Default weekly split: **60% Track B (coverage/type)**, **40% Track A (product requirements)**.
- If a critical production bug is open with priority:critical, Track A can temporarily pre-empt split.
- Any split change must be logged in the weekly governance thread (#214 + Discussion #213).

## Active Requirements

### Track A - Product

- [ ] Deliver v1 requirements defined in `.planning/REQUIREMENTS.md` (ADMN, EVNT, REGS, CMSP, LOCL, QUAL groups).
- [ ] Maintain traceability: `Requirement -> GitHub issue -> implementation/tests`.

### Track B - Quality

- [ ] Achieve 100% code coverage on User, Meetup, Tenant, Xot modules.
- [ ] Achieve 100% code coverage on Notify, Geo, Job, Media, Cms, UI, Activity, Lang, Gdpr, Seo modules.
- [ ] Achieve 100% type coverage across all modules.
- [ ] Keep reproducible global + per-module measurement policy.

## Constraints

- Test framework: Pest.
- Runtime coverage source must include all module app directories (`./Modules/*/app`) and avoid non-runtime paths.
- Database tests use `DatabaseTransactions` (no `RefreshDatabase` unless explicitly justified).
- Strict typing required in new/updated files.

## Governance Channels

- Program governance issue: #211
- Product/Coverage alignment issue: #219
- Strategic decision discussion: #229
- Weekly checkpoint issue: #214
- Weekly decisions discussion: #213

---

*Last updated: 2026-03-06 (dual-track alignment)*
