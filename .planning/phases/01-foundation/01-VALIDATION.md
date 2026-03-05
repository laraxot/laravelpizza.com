---
phase: 1
slug: foundation
status: draft
nyquist_compliant: true
wave_0_complete: false
created: 2026-03-05
---

# Phase 1 — Validation Strategy

> Per-phase validation contract for feedback sampling during execution.

---

## Test Infrastructure

| Property | Value |
|----------|-------|
| **Framework** | Pest 3 |
| **Config file** | phpunit.xml |
| **Quick run command** | `php artisan test --compact` |
| **Full suite command** | `php artisan test --compact` |
| **Estimated runtime** | ~10 seconds |

---

## Sampling Rate

- **After every task commit:** Run `php artisan test --compact`
- **After every plan wave:** Run `php artisan test --compact`
- **Before `/gsd:verify-work`:** Full suite must be green
- **Max feedback latency:** 15 seconds

---

## Per-Task Verification Map

| Task ID | Plan | Wave | Requirement | Test Type | Automated Command | File Exists | Status |
|---------|------|------|-------------|-----------|-------------------|-------------|--------|
| 01-01-01 | 01 | 1 | FR-001 | Unit | `php artisan test Modules/Meetup/tests/Unit/Models` | ❌ W0 | ⬜ pending |
| 01-01-02 | 01 | 1 | FR-001 | Schema | `php artisan migrate:status` | ✅ | ⬜ pending |
| 01-02-01 | 02 | 2 | FR-001 | Unit | `php artisan test Modules/Meetup/tests/Unit/Factories` | ❌ W0 | ⬜ pending |
| 01-02-02 | 02 | 2 | FR-001 | Integration | `php artisan db:seed --class=MeetupDatabaseSeeder` | ❌ W0 | ⬜ pending |

*Status: ⬜ pending · ✅ green · ❌ red · ⚠️ flaky*

---

## Wave 0 Requirements

- [ ] `Modules/Meetup/tests/Unit/Models/VenueTest.php` — stubs for Venue model
- [ ] `Modules/Meetup/tests/Unit/Models/PerformerTest.php` — stubs for Performer model
- [ ] `Modules/Meetup/tests/Unit/Models/SponsorTest.php` — stubs for Sponsor model
- [ ] `Modules/Meetup/tests/Unit/Factories/MeetupFactoryTest.php` — test for all factories

---

## Manual-Only Verifications

| Behavior | Requirement | Why Manual | Test Instructions |
|----------|-------------|------------|-------------------|
| DB Table Audit | FR-001 | Schema verification | Check database directly to ensure column types match research. |

---

## Validation Sign-Off

- [x] All tasks have `<automated>` verify or Wave 0 dependencies
- [x] Sampling continuity: no 3 consecutive tasks without automated verify
- [x] Wave 0 covers all MISSING references
- [x] No watch-mode flags
- [x] Feedback latency < 15s
- [x] `nyquist_compliant: true` set in frontmatter

**Approval:** pending
