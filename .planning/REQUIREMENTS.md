# Requirements: LaravelPizza Coverage Initiative

**Defined:** 2026-03-05
**Core Value:** Ship tested, type-safe code with 100% coverage — every line executable and verified, eliminating untested paths as a source of bugs.

## v1 Requirements

### Foundation - Test Infrastructure

- [ ] **FND-01**: Every test file must use `uses(TestCase::class, DatabaseTransactions::class)` at the top
- [ ] **FND-02**: All test files must declare `declare(strict_types=1);`
- [ ] **FND-03**: No `protected function` allowed in test files — use global functions only
- [ ] **FND-04**: No `mixed` type declarations allowed in test files
- [ ] **FND-05**: Use `DatabaseTransactions` trait for all tests (never `RefreshDatabase`)
- [ ] **FND-06**: All tests must pass verification via `php artisan test`
- [ ] **FND-07**: All tests must verify behavior with assertions (not just execute code)

### Foundation - Coverage Infrastructure

- [ ] **FND-08**: PCOV or Xdebug configured for code coverage collection
- [ ] **FND-09**: Run `php artisan test --coverage --min=100` returns 0 failures
- [ ] **FND-10**: PHPStan configured for type analysis (no level 10 errors for type safety)
- [ ] **FND-11**: Run `./vendor/bin/pest --type-coverage --min=100` returns 0 failures

### User Module (8,565 LOC)

- [ ] **USER-01**: 100% code coverage on User Actions (LoginUserAction, RegisterOauthUserAction, RevokeAllUserTokensAction, etc.)
- [ ] **USER-02**: 100% code coverage on User Models (including relationships)
- [ ] **USER-03**: 100% code coverage on User Controllers
- [ ] **USER-04**: 100% code coverage on User Middleware (IsUserAllowedAction)
- [ ] **USER-05**: 100% code coverage on User Providers (Socialite integration)
- [ ] **USER-06**: OAuth authentication flow fully tested (Google, GitHub)
- [ ] **USER-07**: Token-based authentication (Passport) fully tested

### Meetup Module (1,200 LOC)

- [ ] **MEET-01**: 100% code coverage on Meetup Models
- [ ] **MEET-02**: 100% code coverage on Meetup Actions
- [ ] **MEET-03**: 100% code coverage on Meetup Controllers
- [ ] **MEET-04**: Meetup CRUD operations fully tested

### Tenant Module (600 LOC)

- [ ] **TENA-01**: 100% code coverage on Tenant Models
- [ ] **TENA-02**: 100% code coverage on Tenant Actions
- [ ] **TENA-03**: Multi-tenancy isolation patterns tested
- [ ] **TENA-04**: Tenant context resolution fully tested

### Xot Module (10,209 LOC)

- [ ] **XOT-01**: 100% code coverage on Xot Models
- [ ] **XOT-02**: 100% code coverage on Xot Actions
- [ ] **XOT-03**: 100% code coverage on Xot Services
- [ ] **XOT-04**: 100% code coverage on Xot Controllers

### Other Modules

- [ ] **NOTI-01**: 100% code coverage on Notify module (4,676 LOC)
- [ ] **GEO-01**: 100% code coverage on Geo module (4,265 LOC)
- [ ] **JOB-01**: 100% code coverage on Job module (2,058 LOC)
- [ ] **MEDI-01**: 100% code coverage on Media module (2,372 LOC)
- [ ] **CMS-01**: 100% code coverage on Cms module (1,997 LOC)
- [ ] **UI-01**: 100% code coverage on UI module (1,975 LOC)
- [ ] **ACT-01**: 100% code coverage on Activity module (1,500 LOC)
- [ ] **LANG-01**: 100% code coverage on Lang module (800 LOC)
- [ ] **GDPR-01**: 100% code coverage on Gdpr module (600 LOC)
- [ ] **SEO-01**: 100% code coverage on Seo module (500 LOC)

### Type Coverage

- [ ] **TYPE-01**: 100% type coverage on User module
- [ ] **TYPE-02**: 100% type coverage on Meetup module
- [ ] **TYPE-03**: 100% type coverage on Tenant module
- [ ] **TYPE-04**: 100% type coverage on Xot module
- [ ] **TYPE-05**: 100% type coverage on all remaining modules
- [ ] **TYPE-06**: PHPStan Level 10 with 0 errors across all modules

## v2 Requirements

### Advanced Testing Patterns

- **[TYPE-07]**: Mutation testing (Infection) with score >80%
- **[TYPE-08]**: Parallel test execution configured
- **[TYPE-09]**: Architecture testing to enforce layer boundaries
- **[TYPE-10]**: Custom expectations for domain-specific assertions

### Documentation

- **[DOC-01]**: Test strategy documented per module
- **[DOC-02]**: README in tests/ directory explaining organization
- **[DOC-03]**: CI pipeline documented with coverage enforcement

## Out of Scope

| Feature | Reason |
|---------|--------|
| Adding new features | Coverage initiative focuses only on existing code |
| Refactoring production code to improve coverage | Test existing code as-is, don't change implementation |
| Performance optimization of production code | Focus is on test coverage, not runtime performance |
| Browser/E2E testing | Out of scope for unit/integration coverage goal |
| Visual regression testing | Not required for backend coverage |
| Real external API testing | Use mocks/fakes for external services |

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| FND-01 | Phase 1: Foundation | Pending |
| FND-02 | Phase 1: Foundation | Pending |
| FND-03 | Phase 1: Foundation | Pending |
| FND-04 | Phase 1: Foundation | Pending |
| FND-05 | Phase 1: Foundation | Pending |
| FND-06 | Phase 1: Foundation | Pending |
| FND-07 | Phase 1: Foundation | Pending |
| FND-08 | Phase 1: Foundation | Pending |
| FND-09 | Phase 1: Foundation | Pending |
| FND-10 | Phase 1: Foundation | Pending |
| FND-11 | Phase 1: Foundation | Pending |
| XOT-01 | Phase 2: Xot Module | Pending |
| XOT-02 | Phase 2: Xot Module | Pending |
| XOT-03 | Phase 2: Xot Module | Pending |
| XOT-04 | Phase 2: Xot Module | Pending |
| TENA-01 | Phase 3: Tenant Module | Pending |
| TENA-02 | Phase 3: Tenant Module | Pending |
| TENA-03 | Phase 3: Tenant Module | Pending |
| TENA-04 | Phase 3: Tenant Module | Pending |
| USER-01 | Phase 4: User Module | Pending |
| USER-02 | Phase 4: User Module | Pending |
| USER-03 | Phase 4: User Module | Pending |
| USER-04 | Phase 4: User Module | Pending |
| USER-05 | Phase 4: User Module | Pending |
| USER-06 | Phase 4: User Module | Pending |
| USER-07 | Phase 4: User Module | Pending |
| MEET-01 | Phase 5: Meetup Module | Pending |
| MEET-02 | Phase 5: Meetup Module | Pending |
| MEET-03 | Phase 5: Meetup Module | Pending |
| MEET-04 | Phase 5: Meetup Module | Pending |
| NOTI-01 | Phase 6: Feature Modules | Pending |
| GEO-01 | Phase 6: Feature Modules | Pending |
| JOB-01 | Phase 6: Feature Modules | Pending |
| MEDI-01 | Phase 7: Content Modules | Pending |
| CMS-01 | Phase 7: Content Modules | Pending |
| UI-01 | Phase 7: Content Modules | Pending |
| ACT-01 | Phase 7: Content Modules | Pending |
| LANG-01 | Phase 8: Compliance Modules | Pending |
| GDPR-01 | Phase 8: Compliance Modules | Pending |
| SEO-01 | Phase 8: Compliance Modules | Pending |
| TYPE-01 | Phase 9: Type Coverage | Pending |
| TYPE-02 | Phase 9: Type Coverage | Pending |
| TYPE-03 | Phase 9: Type Coverage | Pending |
| TYPE-04 | Phase 9: Type Coverage | Pending |
| TYPE-05 | Phase 9: Type Coverage | Pending |
| TYPE-06 | Phase 9: Type Coverage | Pending |

**Coverage:**
- v1 requirements: 47 total
- Mapped to phases: 47
- Unmapped: 0 ✓

---
*Requirements defined: 2026-03-05*
*Last updated: 2026-03-05 after initial definition*
