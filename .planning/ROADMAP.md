# Roadmap: LaravelPizza Coverage Initiative

**Created:** 2026-03-05
**Granularity:** Fine (8-12 phases)
**Core Value:** Ship tested, type-safe code with 100% coverage — every line executable and verified, eliminating untested paths as a source of bugs.

---

## Phases

- [x] **Phase 1: Foundation** - Test and coverage infrastructure setup
- [ ] **Phase 2: Xot Module** - Core framework 100% coverage (10,209 LOC)
- [ ] **Phase 3: Tenant Module** - Multi-tenancy 100% coverage (600 LOC)
- [ ] **Phase 4: User Module** - Authentication 100% coverage (8,565 LOC)
- [ ] **Phase 5: Meetup Module** - Events 100% coverage (1,200 LOC)
- [ ] **Phase 6: Feature Modules** - Notify, Geo, Job 100% coverage
- [ ] **Phase 7: Content Modules** - Media, Cms, UI, Activity 100% coverage
- [ ] **Phase 8: Compliance Modules** - Lang, Gdpr, Seo 100% coverage
- [ ] **Phase 9: Type Coverage** - PHPStan Level 10 + type safety verification

---

## Phase Details

### Phase 1: Foundation
**Goal:** Establish test infrastructure, coverage tools, and quality gates before writing module tests.

**Depends on:** Nothing (first phase)

**Requirements:** FND-01, FND-02, FND-03, FND-04, FND-05, FND-06, FND-07, FND-08, FND-09, FND-10, FND-11

**Success Criteria** (what must be TRUE):
1. Every new test file uses `uses(TestCase::class, DatabaseTransactions::class)` at the top
2. All test files declare `declare(strict_types=1);`
3. No `protected function` exists in test files — all use global functions
4. No `mixed` type declarations in test files
5. PCOV or Xdebug is configured and collecting coverage data
6. Running `php artisan test --coverage --min=100` returns 0 failures
7. Running `php artisan test --type-coverage --min=100` returns 0 failures
8. Running `./vendor/bin/phpstan analyse` returns 0 errors at Level 10

**Plans:** TBD

---

### Phase 2: Xot Module
**Goal:** Achieve 100% code coverage on Xot module (core framework, 10,209 LOC).

**Depends on:** Phase 1 (Foundation)

**Requirements:** XOT-01, XOT-02, XOT-03, XOT-04

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for Xot module
2. All Xot Models have test coverage (100% on Models)
3. All Xot Actions have test coverage (100% on Actions)
4. All Xot Services have test coverage (100% on Services)
5. All Xot Controllers have test coverage (100% on Controllers)

**Plans:** TBD

---

### Phase 3: Tenant Module
**Goal:** Achieve 100% code coverage on Tenant module (multi-tenancy, 600 LOC).

**Depends on:** Phase 2 (Xot Module)

**Requirements:** TENA-01, TENA-02, TENA-03, TENA-04

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for Tenant module
2. All Tenant Models have test coverage including relationships
3. All Tenant Actions have test coverage
4. Multi-tenancy isolation patterns are tested and verified
5. Tenant context resolution is fully tested

**Plans:** TBD

---

### Phase 4: User Module
**Goal:** Achieve 100% code coverage on User module (authentication, 8,565 LOC).

**Depends on:** Phase 3 (Tenant Module)

**Requirements:** USER-01, USER-02, USER-03, USER-04, USER-05, USER-06, USER-07

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for User module
2. All User Actions tested (LoginUserAction, RegisterOauthUserAction, RevokeAllUserTokensAction, etc.)
3. All User Models and relationships tested
4. All User Controllers tested
5. All User Middleware tested (IsUserAllowedAction)
6. OAuth authentication flow fully tested (Google, GitHub)
7. Token-based authentication (Passport) fully tested

**Plans:** TBD

---

### Phase 5: Meetup Module
**Goal:** Achieve 100% code coverage on Meetup module (events, 1,200 LOC).

**Depends on:** Phase 4 (User Module)

**Requirements:** MEET-01, MEET-02, MEET-03, MEET-04

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for Meetup module
2. All Meetup Models tested including relationships
3. All Meetup Actions tested
4. All Meetup Controllers tested
5. Meetup CRUD operations fully tested

**Plans:** TBD

---

### Phase 6: Feature Modules
**Goal:** Achieve 100% code coverage on Notify, Geo, and Job modules.

**Depends on:** Phase 5 (Meetup Module)

**Requirements:** NOTI-01, GEO-01, JOB-01

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for Notify module
2. `php artisan test --coverage` reports 100% line coverage for Geo module
3. `php artisan test --coverage` reports 100% line coverage for Job module
4. Queue fakes tested for notification dispatch
5. Location/geographic features tested
6. Queue job dispatch and handling tested

**Plans:** TBD

---

### Phase 7: Content Modules
**Goal:** Achieve 100% code coverage on Media, Cms, UI, and Activity modules.

**Depends on:** Phase 6 (Feature Modules)

**Requirements:** MEDI-01, CMS-01, UI-01, ACT-01

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for Media module
2. `php artisan test --coverage` reports 100% line coverage for Cms module
3. `php artisan test --coverage` reports 100% line coverage for UI module
4. `php artisan test --coverage` reports 100% line coverage for Activity module
5. File handling and conversions tested
6. Component testing for UI module

**Plans:** TBD

---

### Phase 8: Compliance Modules
**Goal:** Achieve 100% code coverage on Lang, Gdpr, and Seo modules.

**Depends on:** Phase 7 (Content Modules)

**Requirements:** LANG-01, GDPR-01, SEO-01

**Success Criteria** (what must be TRUE):
1. `php artisan test --coverage` reports 100% line coverage for Lang module
2. `php artisan test --coverage` reports 100% line coverage for Gdpr module
3. `php artisan test --coverage` reports 100% line coverage for Seo module
4. Multi-language edge cases tested
5. GDPR compliance testing verified
6. Metadata and sitemap generation tested

**Plans:** TBD

---

### Phase 9: Type Coverage
**Goal:** Achieve 100% type coverage across all modules + PHPStan Level 10.

**Depends on:** Phase 8 (Compliance Modules)

**Requirements:** TYPE-01, TYPE-02, TYPE-03, TYPE-04, TYPE-05, TYPE-06

**Success Criteria** (what must be TRUE):
1. `./vendor/bin/pest --type-coverage --min=100` reports 100% type coverage for User module
2. `./vendor/bin/pest --type-coverage --min=100` reports 100% type coverage for Meetup module
3. `./vendor/bin/pest --type-coverage --min=100` reports 100% type coverage for Tenant module
4. `./vendor/bin/pest --type-coverage --min=100` reports 100% type coverage for Xot module
5. `./vendor/bin/pest --type-coverage --min=100` reports 100% type coverage for all remaining modules
6. `./vendor/bin/phpstan analyse` returns 0 errors at Level 10 across all modules

**Plans:** TBD

---

## Progress Table

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Foundation | 1/1 | Complete | 2026-03-05 |
| 2. Xot Module | 0/1 | Not started | - |
| 3. Tenant Module | 0/1 | Not started | - |
| 4. User Module | 0/1 | Not started | - |
| 5. Meetup Module | 0/1 | Not started | - |
| 6. Feature Modules | 0/1 | Not started | - |
| 7. Content Modules | 0/1 | Not started | - |
| 8. Compliance Modules | 0/1 | Not started | - |
| 9. Type Coverage | 0/1 | Not started | - |

---

*Roadmap created: 2026-03-05*
*Ready for planning: Yes*
