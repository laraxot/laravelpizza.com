# Incentivi Module - Test Implementation Guide

**Last Updated**: 2026-03-10  
**Status**: 🚀 Ready for Implementation  
**Scope**: 27+ comprehensive tests across Unit, Feature, and Integration layers  

---

## 📚 Documentation Index

### Core Study Documents (START HERE)

1. **STUDY-NOTES.md** (16.9 KB)
   - Complete analysis of 13 models and their relationships
   - 3 core actions with algorithm explanations
   - Authorization policies and enums
   - Financial calculation flow with examples
   - **Reading time**: 15-20 minutes
   - **Purpose**: Understand what you're testing

2. **TESTING-STRATEGY.md** (19.6 KB)
   - Test patterns and naming conventions (AAA pattern)
   - Factory and database assertion examples
   - Complete template code for all 4 test layers
   - Coverage targets and commands
   - Debugging tips and CI/CD setup
   - **Reading time**: 20-25 minutes
   - **Purpose**: Learn HOW to write tests

3. **TEST-IMPLEMENTATION-ROADMAP.md** (14.8 KB)
   - 5 implementation phases with timeline
   - Dependency graph (visual)
   - Success criteria and checklists
   - Quick start for developers
   - **Reading time**: 10-15 minutes
   - **Purpose**: See the complete plan and timeline

### Supporting Documents

4. **test-plan.md**
   - Original testing roadmap (reference)
   - GitHub issue references
   - Coverage target matrix

5. **prd.md**
   - Product requirements (updated with test goals)
   - Business logic and use cases
   - Non-functional requirements

---

## 🎯 Quick Start (5 Minutes)

### For Managers / Leads
```
1. Read: TEST-IMPLEMENTATION-ROADMAP.md (Executive Summary section)
2. Check: Success Criteria checklist
3. Timeline: 4-6 weeks, 27+ tests, 85%+ coverage
4. Risk: Currently only 5% test coverage (financial calculations untested)
```

### For Developers
```
1. Read: STUDY-NOTES.md (understand the models)
2. Read: TESTING-STRATEGY.md (learn the patterns)
3. Start: Phase 1 with ProjectTest.pest.php
4. Run: ./vendor/bin/pest tests --watch
5. Verify: ./vendor/bin/pest tests --coverage
```

### For QA/Testers
```
1. Review: TEST-IMPLEMENTATION-ROADMAP.md (test plan)
2. Check: Coverage targets (90% models, 95% actions, 80% UI/E2E)
3. Validate: All 27+ tests pass locally before PR approval
4. Measure: Coverage report generation
```

---

## 📊 Test Implementation Phases

### Phase 1: Model Unit Tests (P0) ⭐ START HERE
**12 test files, ~80 tests, 90%+ coverage**
- ActivityTest.pest.php
- EmployeeTest.pest.php
- ProjectTest.pest.php
- Settlement, Phase, Workgroup, etc.

**Duration**: 1-2 weeks  
**Why First**: Foundation for all other tests

### Phase 2: Action Unit Tests (P0) 
**3 test files, ~25 tests, 95%+ coverage**
- SpareImportoTotaleActionTest.pest.php
- UpdateActivitiesEmployeesActionTest.pest.php
- UpdateProjectActivitiesActionTest.pest.php

**Duration**: 1 week  
**Why Critical**: Business logic accuracy

### Phase 3: Filament Resource Tests (P1)
**9 test files, ~70 tests, 80%+ coverage**
- ActivityResourceTest.pest.php
- ProjectResourceTest.pest.php
- EmployeeResourceTest.pest.php
- And 6 more...

**Duration**: 1-2 weeks  
**Why Important**: UI layer validation

### Phase 4: Integration Tests (P2)
**3 test files, ~15 tests, 80%+ coverage**
- IncentiveCalculationFlowTest.pest.php
- ApprovalWorkflowTest.pest.php
- DataConsistencyTest.pest.php

**Duration**: 1 week  
**Why Enhancement**: E2E workflow validation

### Phase 5: DevOps & CI (P2)
**Configuration & automation**
- GitHub Actions integration
- Coverage reports
- Failure notifications

**Duration**: 3-5 days  
**Why Final**: Sustain test execution

---

## 🔧 Getting Started

### Setup
```bash
cd laravel/Modules/Incentivi

# Install dependencies (if needed)
composer install

# Run migrations
php artisan migrate --path=./database/migrations
```

### Run Tests
```bash
# All Incentivi tests
./vendor/bin/pest tests

# Watch mode (auto-rerun on save)
./vendor/bin/pest tests --watch

# With coverage
./vendor/bin/pest tests --coverage

# Specific file
./vendor/bin/pest tests/Unit/Models/ProjectTest.php

# Specific test by name
./vendor/bin/pest --filter="test_name" tests
```

### Quality Checks
```bash
# PHPStan (must be Level 10 compliant)
php -d memory_limit=2G ../../vendor/bin/phpstan analyse . --level=10

# Code formatting
../../vendor/bin/pint .

# All quality gates
./vendor/bin/pest tests && \
  php -d memory_limit=2G ../../vendor/bin/phpstan analyse . && \
  ../../vendor/bin/pint --check .
```

---

## 📋 Test Template Reference

### Model Test Template
```php
it('has many relationships', function () {
    $project = Project::factory()
        ->has(Activity::factory()->count(3))
        ->create();
    
    expect($project->activities)->toHaveCount(3);
});
```

See **TESTING-STRATEGY.md** for complete examples.

### Action Test Template
```php
it('calculates incentive correctly', function () {
    CapitalPercentage::factory()->create(['valore' => 20]);
    
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(10000, $get, $set);
    
    expect($set->called('percentuale_fondo', 20))->toBeTrue();
});
```

### Filament Test Template
```php
it('creates project with form', function () {
    $user = User::factory()->create(['role' => 'rup']);
    
    Livewire::actingAs($user)
        ->test(CreateProject::class)
        ->fillForm(['nome' => 'Project'])
        ->call('create')
        ->assertHasNoFormErrors();
});
```

---

## ✅ Success Criteria

### Coverage Targets
| Component | Target | Priority |
|-----------|--------|----------|
| Models | 90%+ | P0 |
| Actions | 95%+ | P0 |
| Resources | 80%+ | P1 |
| Workflows | 80%+ | P2 |
| **Overall** | **85%+** | - |

### Quality Gates
- [ ] All tests pass (100%)
- [ ] PHPStan Level 10 compliant
- [ ] Code formatting correct (Pint)
- [ ] Coverage targets met
- [ ] No flaky tests
- [ ] CI/CD passing

---

## 🐛 Debugging Tests

### When Tests Fail
```bash
# Verbose output
./vendor/bin/pest tests -v

# Stop on first failure
./vendor/bin/pest tests --stop-on-failure

# Run with xdebug
XDEBUG_MODE=debug ./vendor/bin/pest tests
```

### Inspect Database
```php
// In test
$this->assertDatabaseHas('projects', ['id' => $project->id], 'incentivi');
dump($project->fresh());
```

### Use Ray for Debugging
```php
ray($project)->dump();
```

---

## 📞 Support

### Questions About Models?
→ See STUDY-NOTES.md (sections 2-3)

### Questions About Testing Patterns?
→ See TESTING-STRATEGY.md (section 2-6)

### Questions About Timeline?
→ See TEST-IMPLEMENTATION-ROADMAP.md (section 2-4)

### Questions About Business Logic?
→ See prd.md and docs/architecture.md

---

## 🎓 Key Concepts

### Financial Calculation Flow
```
Project.importo_totale (50,000)
  ↓ Lookup percentage bracket (20%)
Project.importo_effettivo_fondo = 50,000 * 20% = 10,000
  ├─ 80% Incentive = 8,000
  └─ 20% Innovation = 2,000
  ↓ Distribute to activities (60%, 40%)
Activity.importo = 10,000 * 60% = 6,000
  ↓ Distribute to employees (30%, 35%, 35%)
Employee[0].pivot.importo = 6,000 * 30% = 1,800
```

### Authorization Model
- **RUP** (Project Manager): Create projects, activities
- **DEC** (Execution Director): Approve projects, edit percentages
- **Finance**: Liquidate (settle) and payout
- **Employee**: View own incentives

### State Transitions
```
Draft → Approved → Liquidated
        (RUP)     (DEC)     (Finance)
```

---

## 📝 Useful Commands Cheat Sheet

```bash
# Testing
./vendor/bin/pest tests --watch           # Watch mode
./vendor/bin/pest tests --coverage        # Coverage report
./vendor/bin/pest --filter="name" tests   # Run specific test

# Quality
php -d memory_limit=2G ../../vendor/bin/phpstan analyse . --level=10
../../vendor/bin/pint .                   # Format code

# Database
php artisan migrate --path=./database/migrations
php artisan db:seed                       # Run seeders

# Utilities
php artisan tinker                        # Interactive shell
php artisan list artisan                  # All commands
```

---

## 🚀 Ready to Start?

**Step 1**: Read STUDY-NOTES.md (15 min)  
**Step 2**: Read TESTING-STRATEGY.md (20 min)  
**Step 3**: Create ProjectTest.pest.php using template  
**Step 4**: Run `./vendor/bin/pest tests --watch`  
**Step 5**: Write tests following AAA pattern  

**Questions?** Refer to the docs - answers are there!

---

**Created by**: Copilot + Development Team  
**Version**: 1.0  
**Last Updated**: 2026-03-10  
**Status**: ✅ Ready for Implementation
