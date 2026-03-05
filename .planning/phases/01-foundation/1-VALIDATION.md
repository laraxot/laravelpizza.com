---
phase: 1
slug: foundation
status: draft
nyquist_compliant: false
wave_0_complete: false
created: 2026-03-05
---

# Phase 1 — Validation Strategy

> Per-phase validation contract for feedback sampling during execution.

---

## Test Infrastructure

| Property | Value |
|----------|-------|
| **Framework** | Pest 4 |
| **Config file** | `laravel/phpunit.xml`, `laravel/tests/Pest.php` |
| **Quick run command** | `cd laravel && ./vendor/bin/pest tests/Feature --stop-on-failure` |
| **Full suite command** | `cd laravel && ./vendor/bin/pest --coverage --min=100 && ./vendor/bin/pest --type-coverage --min=100 && ./vendor/bin/phpstan analyse` |
| **Estimated runtime** | ~300-900 seconds |

---

## Sampling Rate

- **After every task commit:** Run `cd laravel && ./vendor/bin/pest tests/Feature --stop-on-failure`
- **After every plan wave:** Run `cd laravel && ./vendor/bin/pest --coverage --min=100`
- **Before `$gsd-verify-work`:** Full suite must be green
- **Max feedback latency:** 120 seconds for quick checks

---

## Per-Task Verification Map

| Task ID | Plan | Wave | Requirement | Test Type | Automated Command | File Exists | Status |
|---------|------|------|-------------|-----------|-------------------|-------------|--------|
| 1-01-01 | 01 | 1 | FND-01 | integration | `cd laravel && ./vendor/bin/pest tests --filter=Foundation` | ❌ W0 | ⬜ pending |
| 1-01-02 | 01 | 1 | FND-05 | tooling | `cd laravel && php -m | rg -i 'xdebug|pcov'` | ✅ | ⬜ pending |
| 1-02-01 | 02 | 2 | FND-06 | coverage | `cd laravel && ./vendor/bin/pest --coverage --min=100` | ✅ | ⬜ pending |
| 1-03-01 | 03 | 3 | FND-08 | static-analysis | `cd laravel && ./vendor/bin/phpstan analyse` | ✅ | ⬜ pending |

*Status: ⬜ pending · ✅ green · ❌ red · ⚠️ flaky*

---

## Wave 0 Requirements

- [ ] `laravel/tests/Pest.php` — enforce `uses(TestCase::class, DatabaseTransactions::class)` baseline
- [ ] `laravel/phpunit.xml` — coverage and execution settings aligned with 100% goal
- [ ] `laravel/tests/Feature/Foundation/` — baseline validation tests for phase gates

---

## Manual-Only Verifications

| Behavior | Requirement | Why Manual | Test Instructions |
|----------|-------------|------------|-------------------|
| CI environment has coverage driver enabled | FND-05 | Depends on runtime/extension config | Run `php -m` in CI image and confirm xdebug/pcov present |
| Coverage pipeline gates fail hard below threshold | FND-06/FND-07 | CI wiring can differ from local | Trigger pipeline with failing threshold and verify non-zero exit |

---

## Validation Sign-Off

- [ ] All tasks have `<automated>` verify or Wave 0 dependencies
- [ ] Sampling continuity: no 3 consecutive tasks without automated verify
- [ ] Wave 0 covers all MISSING references
- [ ] No watch-mode flags
- [ ] Feedback latency < 120s for quick checks
- [ ] `nyquist_compliant: true` set in frontmatter

**Approval:** pending
