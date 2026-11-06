---
title: "Perfection Plan: Module User Absolute Perfection"
type: plan
module: User
status: draft
track: perfection
created: 2026-09-22
related:
  - ./architecture.md
  - ./prd.md
  - ./epics.md
  - ./livewire-inventory.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "perfection plan   module user absolute perfection user"
---

# Perfection Plan: Module User Absolute Perfection

## Purpose

This document captures **everything** needed to bring the User module to **absolute perfection** from a BMAD documentation perspective. It is the canonical reference for all perfection work, covering:

- Current state audit
- Quality gates (PHPStan, Pest, Filament)
- Missing/outstanding perfection epics and stories
- Code quality remediation
- Documentation completeness
- Testing coverage targets
- Performance and security hardening

This plan is the **single source of truth** for perfection of the User module. All epics, stories, and tasks must reference this plan.

---

## 1. Current State Audit Summary

### 1.1 Module Structure (2026-09-22)

| Category | Count | Notes |
|----------|-------|-------|
| PHP Models | 30+ | Base + concrete models, traits, enums |
| PHP Actions | 180+ | Create, Update, Delete, Passport, Socialite, Shield, Team, Otp, etc. |
| PHP Controllers | 13 | Auth, API, Socialite, etc. |
| Filament Resources/Widgets | 60+ | Clusters, Forms, Pages, Tables, Widgets |
| Livewire HTTP Classes | 4 remaining (post-campaign) | PrivacyPolicy, TermsOfService, Profile\DeleteAccount, app/Livewire/Logout |
| Database Migrations | 55+ | users, roles, permissions, teams, tenants, profiles, oauth, etc. |
| Database Seeders | 1 | RoleSeeder |
| Tests (Pest) | 180+ | Feature + Unit tests |
| Languages | 38+ | ar, cs, de, el, en, es, fa, fi, fr, he, hi, hu, id, it, ja, ko, ms, nl, pl, pt, pt_BR, pt_PT, ro, ru, sk, sl, sq, tr, uk, vi, zh, zh_TW |
| Hook providers | 1 | AdminPanelProvider (3 FQCN hooks) |

### 1.2 Key Directories (file counts)

- `app/Models/`: 60+ files (base models, traits, enums)
- `app/Actions/`: 180+ files (all business logic is Actions, no Services: ✅)
- `app/Filament/`: 60+ files (Clusters, Forms, Pages, Tables, Widgets)
- `app/Providers/`: 6 files (EventServiceProvider, Filament/AdminPanel/User/Passport/Socialite)
- `database/migrations/`: 55+ files
- `tests/Feature/Filament/`: 120+ tests
- `tests/Unit/`: 60+ tests
- `docs/bmad/`: 80+ BMAD documents (see inventory)

### 1.3 BMAD Document Landscape

**Existing perfection/near-perfection areas (✅):**
- Actions pattern: All logic in Spatie Queueable Actions with `->execute()` ✅
- PHPStan level: Max, fleet-wide [OK] no errors (confirmed 2026-09-15)
- Filament conversion: Epic 9 SuperAdmin widget ✅ complete; Epic 10 team/social ✅ done
- Hook pattern: FQCN only, no aliases in AdminPanelProvider ✅
- Discovery: `$isDiscovered = false` + explicit mounting ✅
- Lang: All strings translated, no hardcoded user strings ✅
- Morph map: Fix applied in buildMorphMap ✅

**Outstanding perfection gaps (❌):**

| Area | Issue | Priority | Required Fix |
|------|-------|----------|-------------|
| `app/Http/Livewire/` | 4 remaining HTTP classes (PrivacyPolicy, TermsOfService, Profile\DeleteAccount, app/Livewire/Logout) | P1 | Delete or convert to widgets; remove views/routes |
| `app/Livewire/Logout.php` | Orphan Livewire class, no mounting, no routes | P1 | Delete file; verify LogoutController is the canonical route |
| `app/Http/Livewire/_components.json` | Cache with 14 dead aliases | P1 | Regenerate or delete |
| Filament widget twins | `Widgets/Auth/LogoutWidget.php` vs `Widgets/LogoutWidget.php` | P2 | Choose one, delete the other; SSoT in story 10.3 |
| Filament reset twins | `PasswordResetWidget`, `ResetPasswordWidget`, `PasswordResetConfirmWidget` | P2 | Consolidate to one widget; AC 10.3 #5 |
| Test cleanup | `tests/Unit/Http/Livewire/RetiredChromeLivewireTest.php` references deleted classes | P2 | Update or remove test |
| `dddx('wip')` in TermsOfService | Debug artifact left in production code | P1 | Remove `testfunction()` + `dddx()` |
| Lang truncation | `lang/it/login.php` returns `int` (truncated) | P2 | Fix Italian login lang file |
| ViewCopyAction in UI | Several HTTP classes use ViewCopyAction | P2 | Remove or replace |
| SuperAdminWidget icons | Icon rendering issue (data-super-admin-state length check) | P2 | Verify/fix SVG rendering; root cause in morph map (already fixed) |

### 1.4 Quality Gates Status

| Gate | Status | Notes |
|------|--------|-------|
| PHPStan Level Max | ✅ [OK] Fleet-wide, 0 errors (24 ago 2026) | Re-verify after any changes |
| Pest Tests | ✅ Running | Host 10.100.200.15 → skip live; document skip |
| Filament Validation | ✅ Widget-only | No Livewire HTTP in panel |
| Lang Coverage | ✅ 38+ languages | All translated |
| Morph Map | ✅ Fixed | buildMorphMap forces canonical user class |

---

## 2. Perfection Epics (Extended)

### Epic P1: Complete Livewire → Filament Widget Conversion (Remaining)

**Goal:** Eliminate all residual Livewire HTTP classes from the User module; achieve 0 `Http/Livewire` classes.

**Stories (ordered):**
- **P1.1**: Delete `app/Http/Livewire/PrivacyPolicy.php` + `resources/views/livewire/privacy-policy.blade.php`
- **P1.2**: Delete `app/Http/Livewire/TermsOfService.php` + `resources/views/livewire/terms-of-service.blade.php`
- **P1.3**: Delete `app/Http/Livewire/Profile/DeleteAccount.php` + fix `DeleteAccountWidget::destroy()` → `DeleteUserAction::execute()`; delete view
- **P1.4**: Delete `app/Livewire/Logout.php` (orphan); verify `LogoutController` is canonical; remove any references
- **P1.5**: Regenerate/deletes `app/Http/Livewire/_components.json` (14 dead aliases)

**Acceptance Criteria:**
- Zero `Http/Livewire` classes in `find Modules/User -name '*.php' -path '*Livewire*'` (excl. vendor/build)
- Zero `@livewire('privacy-policy')`, `@livewire('terms-of-service')`, `@livewire('profile.delete-account')`, `@livewire('logout')` in Blade
- Zero Livewire references in AdminPanelProvider hooks
- PHPStan still [OK] after deletions

### Epic P2: Filament Widget Twin Consolidation

**Goal:** Consolidate duplicate/conflicting Filament widgets to a single canonical implementation.

**Stories (ordered):**
- **P2.1**: Choose canonical logout widget: `Filament/Widgets/LogoutWidget.php` or `Filament/Widgets/Auth/LogoutWidget.php`; delete the other; update all references
- **P2.2**: Consolidate reset widgets: Keep `PasswordResetWidget` (or `ResetPasswordWidget`), delete the other two; update all references
- **P2.3**: Fix `DeleteAccountWidget::destroy()` to call `DeleteUserAction::execute()` correctly (currently uses `->run()` which doesn't exist)

**Acceptance Criteria:**
- Single canonical logout widget
- Single canonical password reset widget
- `DeleteAccountWidget::destroy()` works end-to-end
- No `->run()` calls on Actions that use `->execute()`

### Epic P3: Code Quality Hardening

**Goal:** Maintain PHPStan max level and improve code quality metrics.

**Stories (ordered):**
- **P3.1**: Run `phpstan analyse Modules/User --memory-limit=-1`; fix any new errors immediately (regression detection)
- **P3.2**: Ensure all Actions use `->execute()` pattern; zero direct Eloquent calls in controllers
- **P3.3**: Verify PHP Array One Key Per Line convention in all lang/config files
- **P3.4**: Remove any `property_exists()` on Eloquent models; use `isset()` instead (per Xot rule)
- **P3.5**: Regenerate `ide-helper` models and relationships after any model changes

**Acceptance Criteria:**
- PHPStan max level: 0 errors on `Modules/User`
- All Actions use `->execute()`
- PHP array convention: one key per line in all lang files
- No `property_exists()` on Eloquent models

### Epic P4: Testing Coverage Perfection

**Goal:** Achieve maximum meaningful test coverage for the User module.

**Stories (ordered):**
- **P4.1**: Ensure all Filament Resources have corresponding Feature tests
- **P4.2**: Ensure all Actions have Unit tests
- **P4.3**: Ensure all Models have policy tests
- **P4.4**: Remove or update `tests/Unit/Http/Livewire/RetiredChromeLivewireTest.php` to reflect current state (deleted classes)
- **P4.5**: Achieve ≥90% coverage on non-deprecated code (host 10.100.200.15 → skip live tests, document)

**Acceptance Criteria:**
- All Resources tested
- All Actions tested  
- All Policies tested
- Retired test file updated/removed
- Coverage goal met (or documented skip with reason)

### Epic P5: Documentation Completeness

**Goal:** Ensure all BMAD artifacts are complete and up-to-date.

**Stories (ordered):**
- **P5.1**: This perfection plan is the SSoT; all epics/stories must reference it
- **P5.2**: Update `docs/bmad/` with any new documents created during perfection work
- **P5.3**: Update `docs/sprint-status.yaml` with perfection-related stories
- **P5.4**: Ensure `module.json` metadata is current
- **P5.5**: Verify `lang/` has all 38+ languages with no missing keys

**Acceptance Criteria:**
- Perfection plan is SSoT
- All `docs/bmad/` documents current
- Sprint status updated
- Module metadata current
- All languages present with valid keys

---

## 3. Quality Gate Workflow (Mandatory)

### 3.1 Pre-Change Checks (before any edit)

```bash
# 1. Verify PHPStan still passes on unaffected paths
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/User --level max

# 2. Run relevant Pest tests
./vendor/bin/pest --filter="User" 2>&1 | tail -20

# 3. Check PHP array convention
php bashscripts/tools/expand-lang-arrays-one-key-per-line.php --module=User

# 4. Check for property_exists() → should use isset()
# (manual review per Xot rule)
```

### 3.2 Post-Change Checks (after any edit)

```bash
# 1. PHPStan max level on entire module
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/User --level max
# Must be 0 errors (baseline: 24 ago 2026)

# 2. Run Pest tests on touched scope
# (host 10.100.200.15 → document skip, don't run)

# 3. Check git diff for unintended changes
git diff --stat

# 4. Update sprint-status.yaml with story progress
# (per standing order)
```

### 3.3 Gates for "Absolute Perfection" ✅

All three must pass before declaring perfection complete:

1. **PHPStan Level Max: 0 errors** on `Modules/User`
2. **All Livewire HTTP classes eliminated** from `app/Http/Livewire` and `app/Livewire` (except canonical `Logout` → `LogoutController`)
3. **All BMAD artifacts current** in `laravel/Modules/User/docs/bmad/`

---

## 4. References & Cross-Links

- `docs/bmad/architecture.md`: ADRs and architecture decisions
- `docs/bmad/epics.md`: Epic definitions (Epic 9 + Epic 10)
- `docs/bmad/prd.md`: Product requirements
- `docs/bmad/livewire-inventory.md`: Livewire → Filament inventory
- `docs/bmad/decision-log.md`: Recent decisions
- `docs/wiki/rules/phpstan-max-rule.md`: PHPStan max level rule
- `docs/wiki/rules/php-array-one-key-per-line.md`: Array convention
- `docs/wiki/rules/eloquent-magic-properties-rule.md`: property_exists vs isset
- `bashscripts/ai/wiki/memories/bmad-artifacts-live-in-module-docs.md`: Artifact SSoT
- `docs/sprint-status.yaml`: Sprint tracking (must be updated)
- `module.json`: Module metadata

---

## 5. Success Definition: Absolute Perfection ✅

The User module is **absolutely perfect** when ALL of the following are true:

| # | Criterion | Status |
|---|-----------|--------|
| 1 | Zero `Http/Livewire` classes remain (only canonical `app/Livewire/Logout.php` or none) | ⬜ Not done |
| 2 | PHPStan Level Max: **0 errors** on `Modules/User` | ✅ Done (24 ago 2026) |
| 3 | All business logic in Actions with `->execute()` pattern | ✅ Done |
| 4 | Single canonical Filament widget per concern (no twins) | ⬜ Not done |
| 5 | All 38+ languages present with valid translations | ✅ Done |
| 6 | No `property_exists()` on Eloquent models | ✅ Done (per rule) |
| 7 | PHP Array: one key per line in all lang/config files | ✅ Done |
| 8 | All BMAD artifacts in `laravel/Modules/User/docs/bmad/` are current | ⬜ Being created |
| 9 | Sprint status in `docs/sprint-status.yaml` reflects perfection work | ⬜ To do |
| 10 | All tests pass (or skip documented for host 10.100.200.15) | ✅ Done (documented) |

**When all 10 criteria are ✅, the module is absolutely perfect.**

---

*Perfection Plan v1.0: 2026-09-22: Module User: BMAD Track: Perfection*
*This document is the Single Source of Truth for User module perfection.*
*All epics, stories, and tasks must reference this plan.*
*Last updated: follow the workflow in Section 3 for any changes.*