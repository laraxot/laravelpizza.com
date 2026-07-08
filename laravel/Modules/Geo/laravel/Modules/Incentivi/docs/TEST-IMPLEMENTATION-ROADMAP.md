# Test Implementation Roadmap - Incentivi Module

**Status**: Study & Documentation Complete ✅  
**Next Phase**: Test Implementation  
**Target Completion**: Q2 2026  
**Coverage Goal**: 85%+ across all components  

---

## 📊 EXECUTIVE SUMMARY

The Incentivi module is a complex financial system managing employee incentives with:
- **13 Core Models** with intricate relationships
- **3 Critical Actions** performing financial calculations
- **10 Filament Resources** for UI management
- **13 Authorization Policies** controlling access

### Current Test Coverage
- Existing tests: ~5% (3 minimal tests)
- Gap: 95% of critical paths untested
- Risk: High (financial calculations unvalidated)

### Implementation Plan
| Phase | Component | Tests | Est. Duration | Priority |
|-------|-----------|-------|---------------|----------|
| **1** | Models (Unit) | 12 | 1-2 weeks | **P0 - Critical** |
| **2** | Actions (Unit) | 3 | 1 week | **P0 - Critical** |
| **3** | Filament (Feature) | 9 | 1-2 weeks | **P1 - Important** |
| **4** | Integration (E2E) | 3 | 1 week | **P2 - Enhancement** |
| **5** | DevOps/CI | - | 3-5 days | **P2 - Enhancement** |
| **TOTAL** | **27+ tests** | **26+ hours** | **4-6 weeks** | - |

---

## 📚 DOCUMENTATION DELIVERABLES

### ✅ Already Completed
1. **STUDY-NOTES.md** (16.9 KB)
   - Deep dive into all 13 models
   - Relationship maps and enums
   - Action algorithm explanations
   - Invariants and business rules to protect

2. **TESTING-STRATEGY.md** (19.6 KB)
   - Test patterns (AAA, Factories, Assertions)
   - Template code for all test types
   - Coverage targets and commands
   - CI/CD integration guide

3. **TEST-IMPLEMENTATION-ROADMAP.md** (This file)
   - Dependency graph
   - Implementation order
   - Success criteria

### 🔄 Docs In Progress (Phase 1)
- [ ] **Update PRD** (docs/prd.md)
  - Add test requirements and coverage targets
  - Document calculation algorithms with examples
  - Add success criteria

- [ ] **Create Architecture Doc** (docs/architecture.md)
  - Class diagrams of all 13 models
  - Relationship maps (Project → Activity → Employee)
  - Enum documentation
  - Policy architecture diagram

- [ ] **Create Models Doc** (docs/models/)
  - One file per model with properties, relationships, key methods
  - Example: `docs/models/Project.md`, `docs/models/Activity.md`, etc.

- [ ] **Complete Translations**
  - [ ] English (EN): Extend from 3 to 54 files
  - [ ] German (DE): Add all 54 files

---

## 🎯 TEST IMPLEMENTATION PHASES

### Phase 1: Model Unit Tests (P0 - Critical) - Weeks 1-2

**Tests to Implement** (12 files, ~80 test cases):

```
tests/Unit/Models/
├── ActivityTest.pest.php                    [8-10 tests]
├── ActivityEmployeeTest.pest.php            [6-8 tests]
├── EmployeeTest.pest.php                    [8-10 tests]
├── EmployeeProjectTest.pest.php             [6-8 tests]
├── EmployeeWorkgroupTest.pest.php           [4-6 tests]
├── ProjectTest.pest.php (enhance existing)  [10-12 tests]
├── PhaseTest.pest.php                       [6-8 tests]
├── SettlementTest.pest.php                  [6-8 tests]
├── StabiDirigenteTest.pest.php              [6-8 tests]
├── WorkgroupTest.pest.php                   [6-8 tests]
├── CapitalPercentageTest.pest.php           [6-8 tests]
└── DefaultActivityTest.pest.php             [4-6 tests]
```

**Test Categories per Model**:
- ✅ Object creation (factory, attributes)
- ✅ Relationships (HasMany, BelongsTo, BelongsToMany)
- ✅ Eager loading (prevent N+1)
- ✅ Enums (casting, validation)
- ✅ Accessors/Computed properties
- ✅ Scopes (if any)
- ✅ Mass assignment (fillable/guarded)

**Coverage Target**: 90%+

**Success Criteria**:
- [ ] All 12 test files created
- [ ] 80+ test cases all passing
- [ ] Coverage ≥90% for models
- [ ] PHPStan Level 10 compliance
- [ ] Database assertions validate state

---

### Phase 2: Action Unit Tests (P0 - Critical) - Week 3

**Tests to Implement** (3 files, ~25 test cases):

```
tests/Unit/Actions/
├── SpareImportoTotaleActionTest.pest.php         [8-10 tests]
├── UpdateActivitiesEmployeesActionTest.pest.php  [8-10 tests]
└── UpdateProjectActivitiesActionTest.pest.php    [6-8 tests]
```

**Test Categories per Action**:
- ✅ Valid inputs → correct outputs
- ✅ Boundary values (min/max amounts)
- ✅ Edge cases (no match, zero, negative)
- ✅ Floating point accuracy
- ✅ Type narrowing and null safety
- ✅ Multiple calculation scenarios

**Key Focus**:
- **SpareImportoTotaleAction**: Percentage bracket lookup, 80/20 split
- **UpdateActivitiesEmployeesAction**: Importo distribution, pivot updates, null handling
- **UpdateProjectActivitiesAction**: Activity lifecycle, relationship syncing

**Coverage Target**: 95%+

**Success Criteria**:
- [ ] All 3 test files created
- [ ] 25+ test cases all passing
- [ ] Financial calculations verified accurate
- [ ] Edge cases handled
- [ ] Coverage ≥95% for actions
- [ ] Mockery/mocking strategies working

---

### Phase 3: Filament Resource Tests (P1 - Important) - Weeks 4-5

**Tests to Implement** (9 files, ~70 test cases):

```
tests/Feature/Filament/
├── ActivityResourceTest.pest.php            [8-10 tests]
├── EmployeeResourceTest.pest.php            [8-10 tests]
├── ProjectResourceTest.pest.php             [8-10 tests]
├── SettlementResourceTest.pest.php          [6-8 tests]
├── StabiDirigenteResourceTest.pest.php      [6-8 tests]
├── WorkgroupResourceTest.pest.php           [6-8 tests]
├── PhaseResourceTest.pest.php               [6-8 tests]
├── DefaultActivityResourceTest.pest.php     [4-6 tests]
└── CapitalPercentageResourceTest.pest.php   [4-6 tests]
```

**Test Categories per Resource**:
- ✅ Load create/edit/list pages (Livewire)
- ✅ Form validation (required fields, types)
- ✅ CRUD operations (create, read, update, delete)
- ✅ Table display (columns, sorting, filtering)
- ✅ Authorization (policy enforcement)
- ✅ Relationship handling (modal forms, attach/detach)

**Key Focus**:
- Livewire component testing with `->test(ResourcePage::class)`
- Form filling and submission
- Authorization with `->actingAs($user)`
- Table filtering and sorting

**Coverage Target**: 80%+

**Success Criteria**:
- [ ] All 9 test files created
- [ ] 70+ test cases all passing
- [ ] CRUD flows validated
- [ ] Authorization enforced
- [ ] Form validation working
- [ ] Coverage ≥80% for resources

---

### Phase 4: Integration Tests (P2 - Enhancement) - Week 6

**Tests to Implement** (3 files, ~15 test cases):

```
tests/Feature/Integration/
├── IncentiveCalculationFlowTest.pest.php    [5-6 tests]
├── ApprovalWorkflowTest.pest.php            [4-5 tests]
└── DataConsistencyTest.pest.php             [4-5 tests]
```

**E2E Workflows to Test**:

1. **IncentiveCalculationFlowTest**
   - Project creation
   - Activity definition
   - Employee assignment
   - Incentive calculation
   - Settlement process

2. **ApprovalWorkflowTest**
   - Draft → Approved → Liquidated state transitions
   - RUP, DEC, Finance role-based approvals
   - Permission checks at each step

3. **DataConsistencyTest**
   - Cascade deletes (project → activities → employees)
   - Financial accuracy (totals == sums)
   - Relationship integrity

**Coverage Target**: 80%+

**Success Criteria**:
- [ ] All 3 test files created
- [ ] 15+ test cases all passing
- [ ] Full workflows validated E2E
- [ ] Data consistency guaranteed
- [ ] Coverage ≥80% for workflows

---

### Phase 5: DevOps & CI/CD - Week 6 (Parallel)

**Deliverables**:
- [ ] GitHub Actions integration
- [ ] Coverage report automation
- [ ] Badge generation
- [ ] Failure notifications
- [ ] Final documentation

**Configuration**:
```yaml
# .github/workflows/ci.yml
- name: Run Incentivi Tests
  run: ./vendor/bin/pest Modules/Incentivi/tests --coverage
```

---

## 🔗 DEPENDENCY GRAPH

```
┌─────────────────────────────────────┐
│ Documentation Improvements (P0)     │
│ - PRD, Architecture, Models Docs   │
│ - Translations (EN, DE)             │
└────────────┬────────────────────────┘
             │
┌────────────▼────────────────────────┐
│ Model Unit Tests (P0)               │
│ - 12 model files, ~80 tests         │
│ - Target: 90%+ coverage             │
└────────────┬────────────────────────┘
             │
             ├──────────────────────────┐
             │                          │
┌────────────▼────────┐   ┌────────────▼────────┐
│ Action Unit Tests   │   │ Filament Feature    │
│ (P0)                │   │ Tests (P1)          │
│ - 3 files, 25 tests │   │ - 9 files, 70 tests │
│ - Target: 95%       │   │ - Target: 80%       │
└────────────┬────────┘   └────────────┬────────┘
             │                         │
             └────────────┬────────────┘
                          │
                ┌─────────▼──────────┐
                │ Integration Tests  │
                │ (P2)               │
                │ - 3 files, 15 tests│
                │ - Target: 80%      │
                └─────────┬──────────┘
                          │
                ┌─────────▼──────────┐
                │ CI/CD & Reports    │
                │ - Auto-run on PR   │
                │ - Coverage badges  │
                └────────────────────┘
```

---

## ✅ SUCCESS CRITERIA

### Code Quality
- [ ] All tests pass locally (100% passing rate)
- [ ] All tests pass in CI/CD (GitHub Actions)
- [ ] PHPStan Level 10: All tests comply
- [ ] Code coverage ≥85% overall
  - Models: ≥90%
  - Actions: ≥95%
  - Resources: ≥80%
  - Workflows: ≥80%

### Testing Coverage
- [ ] 27+ tests implemented
- [ ] All model relationships tested
- [ ] All actions' calculations tested
- [ ] All CRUD operations tested
- [ ] Authorization enforced in tests
- [ ] Edge cases handled
- [ ] No flaky tests (100% deterministic)

### Documentation
- [ ] STUDY-NOTES.md ✅ (Complete)
- [ ] TESTING-STRATEGY.md ✅ (Complete)
- [ ] PRD updated with test requirements
- [ ] Architecture.md with diagrams
- [ ] Models/* docs complete
- [ ] Translations complete (IT, EN, DE)
- [ ] TESTING.md guide for developers

### DevOps
- [ ] Tests auto-run on PR
- [ ] Coverage reports generated
- [ ] Failure notifications sent
- [ ] Coverage badges in README
- [ ] CI workflow documented

---

## 🚀 QUICK START GUIDE

### For Developers Implementing Tests

1. **Setup Environment**
   ```bash
   cd laravel/Modules/Incentivi
   composer install
   php artisan migrate --path=./database/migrations
   ```

2. **Study Phase** (Read in order)
   ```bash
   # 1. Read study notes (15 min)
   less docs/STUDY-NOTES.md
   
   # 2. Read testing strategy (20 min)
   less docs/TESTING-STRATEGY.md
   
   # 3. Read this roadmap (10 min)
   less docs/TEST-IMPLEMENTATION-ROADMAP.md
   ```

3. **Implement Tests** (Follow phases in order)
   ```bash
   # Phase 1: Model tests
   ./vendor/bin/pest Modules/Incentivi/tests/Unit/Models --watch
   
   # Phase 2: Action tests
   ./vendor/bin/pest Modules/Incentivi/tests/Unit/Actions --watch
   
   # Phase 3: Filament tests
   ./vendor/bin/pest Modules/Incentivi/tests/Feature/Filament --watch
   
   # Phase 4: Integration tests
   ./vendor/bin/pest Modules/Incentivi/tests/Feature/Integration --watch
   ```

4. **Coverage & Quality**
   ```bash
   # Generate coverage report
   ./vendor/bin/pest Modules/Incentivi/tests --coverage
   
   # Check PHPStan
   php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Incentivi
   
   # Format code
   ./vendor/bin/pint Modules/Incentivi
   ```

5. **Submit Work**
   ```bash
   git add .
   git commit -m "test: add comprehensive test suite for Incentivi module

   - Added 12 model unit tests (90%+ coverage)
   - Added 3 action unit tests (95%+ coverage)
   - Added 9 Filament resource tests (80%+ coverage)
   - Added 3 integration tests (80%+ coverage)
   - Total: 27+ tests with 85%+ coverage
   - All PHPStan Level 10 compliant
   
   Co-authored-by: Copilot <223556219+Copilot@users.noreply.github.com>"
   
   git push origin feature/incentivi-tests
   ```

---

## 📋 CHECKLIST FOR TEST COMPLETION

### Phase 1 Models - Week 1-2
- [ ] ActivityTest.pest.php created & passing
- [ ] ActivityEmployeeTest.pest.php created & passing
- [ ] EmployeeTest.pest.php created & passing
- [ ] EmployeeProjectTest.pest.php created & passing
- [ ] EmployeeWorkgroupTest.pest.php created & passing
- [ ] ProjectTest.pest.php enhanced & passing
- [ ] PhaseTest.pest.php created & passing
- [ ] SettlementTest.pest.php created & passing
- [ ] StabiDirigenteTest.pest.php created & passing
- [ ] WorkgroupTest.pest.php created & passing
- [ ] CapitalPercentageTest.pest.php created & passing
- [ ] DefaultActivityTest.pest.php created & passing
- [ ] Model coverage ≥90% verified

### Phase 2 Actions - Week 3
- [ ] SpareImportoTotaleActionTest.pest.php created & passing
- [ ] UpdateActivitiesEmployeesActionTest.pest.php created & passing
- [ ] UpdateProjectActivitiesActionTest.pest.php created & passing
- [ ] Action coverage ≥95% verified
- [ ] Financial calculations validated

### Phase 3 Filament - Weeks 4-5
- [ ] ActivityResourceTest.pest.php created & passing
- [ ] EmployeeResourceTest.pest.php created & passing
- [ ] ProjectResourceTest.pest.php created & passing
- [ ] SettlementResourceTest.pest.php created & passing
- [ ] StabiDirigenteResourceTest.pest.php created & passing
- [ ] WorkgroupResourceTest.pest.php created & passing
- [ ] PhaseResourceTest.pest.php created & passing
- [ ] DefaultActivityResourceTest.pest.php created & passing
- [ ] CapitalPercentageResourceTest.pest.php created & passing
- [ ] Resource coverage ≥80% verified
- [ ] Authorization tests passing

### Phase 4 Integration - Week 6
- [ ] IncentiveCalculationFlowTest.pest.php created & passing
- [ ] ApprovalWorkflowTest.pest.php created & passing
- [ ] DataConsistencyTest.pest.php created & passing
- [ ] Integration coverage ≥80% verified
- [ ] E2E workflows validated

### Phase 5 DevOps - Week 6
- [ ] GitHub Actions configured
- [ ] Coverage reports generated
- [ ] Final documentation complete
- [ ] All translations complete
- [ ] PR ready for merge

---

## 📞 SUPPORT & QUESTIONS

**For questions about tests:**
- Refer to TESTING-STRATEGY.md for patterns and examples
- Check STUDY-NOTES.md for model/action details
- Look at existing ProjectTest.pest.php for reference implementation

**For technical issues:**
- Run tests with `-v` flag for verbose output
- Use `dd()` or `ray()` for debugging
- Check database state with `assertDatabaseHas()`

**For feature clarifications:**
- Read docs/prd.md for requirements
- Check docs/architecture.md for design decisions
- Review test-plan.md for original planning

---

**Document Version**: 1.0  
**Last Updated**: 2026-03-10  
**Status**: Ready for Implementation  
**Next Step**: Begin Phase 1 - Model Unit Tests  
**Estimated Completion**: Q2 2026
