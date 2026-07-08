# Incentivi Module - Test Implementation Plan

**Status**: In Planning
**Created**: 2026-03-06
**Target Completion**: Q2 2026

## Overview

This document outlines the comprehensive test development strategy for the Incentivi module. The plan follows a priority-based approach with clear dependencies and acceptance criteria.

## Test Categories & Priority

### P0 - Critical (Unit Tests)
These tests establish the foundation for all other tests and are required before feature/integration tests.

| ID | Category | Task | Status | Est. Time | Link |
|---|----------|------|--------|-----------|------|
| T001 | Models | Activity Model Unit Tests | completed | 4h | #58 |
| T002 | Models | Employee Model Unit Tests | completed | 4h | #58 |
| T003 | Models | Project Model Unit Tests | completed | 3h | #58 |
| T004 | Models | Settlement Model Unit Tests | pending | 3h | #58 |
| T005 | Actions | SpareImportoTotaleAction Tests | completed | 3h | #59 |
| T006 | Actions | UpdateActivitiesEmployeesAction Tests | completed | 4h | #59 |
| T007 | Actions | UpdateProjectActivitiesAction Tests | completed | 4h | #59 |

**Dependencies**: None (foundational layer)
**Total Est. Time**: 29 hours

### P1 - Important (Feature Tests)
Filament UI and custom validation tests depend on Model tests.

| ID | Category | Task | Status | Est. Time | Link |
|---|----------|------|--------|-----------|------|
| T008 | Filament | ActivityResource Tests | pending | 3h | #60 |
| T009 | Filament | EmployeeResource Tests | pending | 4h | #60 |
| T010 | Filament | ProjectResource Tests | pending | 3h | #60 |
| T011 | Filament | SettlementResource Tests | pending | 3h | #60 |
| T012 | Filament | StabiDirigenteResource Tests | pending | 2h | #60 |
| T013 | Filament | Additional Resources Tests | pending | 3h | #60 |
| T014 | Rules | Validation Rules Tests | pending | 2h | #59 |

**Dependencies**: All P0 tests
**Total Est. Time**: 20 hours

### P2 - Enhancement (Integration Tests)
End-to-end workflow tests depend on both Model and Filament tests.

| ID | Category | Task | Status | Est. Time | Link |
|---|----------|------|--------|-----------|------|
| T015 | Integration | Incentive Calculation Flow | pending | 5h | #61 |
| T016 | Integration | Approval Workflow | pending | 4h | #61 |
| T017 | Integration | Data Consistency & Integrity | pending | 3h | #61 |

**Dependencies**: All P0 and P1 tests
**Total Est. Time**: 12 hours

### Documentation & DevOps

| ID | Category | Task | Status | Est. Time | Link |
|---|----------|------|--------|-----------|------|
| T018 | Docs | Test Strategy Documentation | pending | 2h | #62 |
| T019 | Docs | CI/CD Integration | pending | 3h | #62 |
| T020 | Docs | Coverage Report Setup | pending | 2h | #62 |

**Dependencies**: All test implementation
**Total Est. Time**: 7 hours

## Dependency Graph

```
┌─ Models Tests (P0) ─────────────┐
│  - Activity                      │
│  - Employee                      │
│  - Project                       │
│  - Settlement                    │
│  - StabiDirigente               │
└──────────────┬────────────────────┘
               │
        ┌──────▼──────┐
        │ Actions (P0)│
        │ - Spare     │
        │ - Update    │
        └──────┬──────┘
               │
        ┌──────▼────────────┐
        │ Filament (P1)     │
        │ - Resources       │
        │ - Validation      │
        └──────┬────────────┘
               │
        ┌──────▼──────────────┐
        │ Integration (P2)    │
        │ - Workflows        │
        │ - Data Integrity   │
        └─────────────────────┘
```

## Test Structure (Directory Layout)

```
Modules/Incentivi/tests/
├── Feature/
│   ├── Filament/
│   │   ├── ActivityResourceTest.pest.php
│   │   ├── EmployeeResourceTest.pest.php
│   │   ├── ProjectResourceTest.pest.php
│   │   ├── SettlementResourceTest.pest.php
│   │   ├── StabiDirigenteResourceTest.pest.php
│   │   ├── WorkgroupResourceTest.pest.php
│   │   ├── PhaseResourceTest.pest.php
│   │   ├── DefaultActivityResourceTest.pest.php
│   │   └── CapitalPercentageResourceTest.pest.php
│   ├── Integration/
│   │   ├── IncentiveCalculationFlowTest.pest.php
│   │   ├── ApprovalWorkflowTest.pest.php
│   │   └── DataConsistencyTest.pest.php
│   └── Rules/
│       └── ValidationRulesTest.pest.php
├── Unit/
│   ├── Actions/
│   │   ├── SpareImportoTotaleActionTest.pest.php
│   │   ├── UpdateActivitiesEmployeesActionTest.pest.php
│   │   └── UpdateProjectActivitiesActionTest.pest.php
│   └── Models/
│       ├── ActivityTest.pest.php
│       ├── ActivityEmployeeTest.pest.php
│       ├── EmployeeTest.pest.php
│       ├── EmployeeProjectTest.pest.php
│       ├── EmployeeWorkgroupTest.pest.php
│       ├── ProjectTest.pest.php
│       ├── PhaseTest.pest.php
│       ├── SettlementTest.pest.php
│       ├── StabiDirigenteTest.pest.php
│       ├── WorkgroupTest.pest.php
│       ├── CapitalPercentageTest.pest.php
│       └── DefaultActivityTest.pest.php
├── Pest.php (setup)
└── TestCase.php (base)
```

## Execution Phases

### Phase 1: Foundation (Models) - Week 1-2
- Implement all P0 model tests
- Set up factory fixtures
- Achieve 80%+ coverage for models

### Phase 2: Business Logic (Actions) - Week 2-3
- Implement all P0 action tests
- Validate calculation accuracy
- Test error scenarios

### Phase 3: UI Layer (Filament) - Week 3-4
- Implement all P1 resource tests
- Validate form interactions
- Test permissions & authorization

### Phase 4: Integration - Week 4-5
- Implement all P2 integration tests
- Validate end-to-end workflows
- Cross-module dependency testing

### Phase 5: Documentation & DevOps - Week 5-6
- Write comprehensive documentation
- Set up CI/CD pipeline
- Generate coverage reports

## Coverage Targets

| Component | Target | Current | Gap |
|-----------|--------|---------|-----|
| Models | 90% | 0% | 90% |
| Actions | 95% | 0% | 95% |
| Filament Resources | 80% | 0% | 80% |
| Rules/Validation | 85% | 0% | 85% |
| Overall | 85% | 0% | 85% |

## Quality Assurance

✓ All tests must pass locally before PR submission
✓ PHPStan Level 10 compliance required
✓ No test flakiness (deterministic results)
✓ Tests complete in < 30 seconds total
✓ Coverage reports generated for each PR
✓ Code review by module maintainer

## Success Criteria

1. ✓ All 5 GitHub issues created and linked
2. ✓ Test plan documented in this file
3. ✓ Dependency graph clearly defined
4. ✓ Directory structure prepared
5. ✓ Team aligned on strategy and timeline

## Team Assignments

- **Test Lead**: [Assign team member]
- **Models Tests**: [Assign team member]
- **Actions Tests**: [Assign team member]
- **Filament Tests**: [Assign team member]
- **Integration Tests**: [Assign team member]

## GitHub Issues References

| Issue | Link | Priority |
|-------|------|----------|
| Models Tests | #58 | P0 |
| Actions Tests | #59 | P0 |
| Filament Tests | #60 | P1 |
| Integration Tests | #61 | P2 |
| Documentation & CI/CD | #62 | P2 |

## Related Documentation

- [Module PRD](./prd.md)
- [Test Strategy Wiki](https://github.com/provtv/base_ptv_fila5_mono/wiki/Incentivi-Test-Strategy)
- [Architecture Guide](../../Xot/docs/architecture.md)
- [PHP Quality Standards](../../Xot/docs/php_quality_guide.md)

---

**Last Updated**: 2026-03-06
**Author**: Incentivi Development Team
**Next Review**: Weekly during sprints
