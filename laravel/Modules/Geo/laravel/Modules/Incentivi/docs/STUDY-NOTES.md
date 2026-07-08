# Incentivi Module - Study Notes & Analysis
**Date**: 2026-03-10  
**Focus**: Architecture, testing strategy, and comprehensive test implementation

---

## 1. MODULE OVERVIEW

### Purpose
The **Incentivi** module manages employee incentives, bonuses, and performance-based rewards across the PTVX platform. It automates complex calculations, reduces manual errors, and streamlines approval and payout processes for provincial incentives.

### Key Statistics
- **13 Models** (Eloquent ORM)
- **9 Database Factories** (for testing)
- **3 Core Actions** (Spatie Queueable)
- **10 Filament Resources** (admin UI)
- **13 Authorization Policies**
- **Italian translations: 54 files** ✅ Complete
- **English translations: 3 files** ⚠️ Partial
- **German translations: 0 files** ❌ Missing

---

## 2. DATA MODEL & RELATIONSHIPS

### 2.1 Core Models

#### **Project** (Aggregate Root)
```
Project
├── has_many: Activity[]
├── has_many: Employee[] (via EmployeeProject pivot)
├── has_many: Settlement[]
├── has_many: Phase[]
├── belongs_to: Workgroup
├── has_one: StabiDirigente (RUP - manager)
└── has_one: StabiDirigente (DEC - manager)
```

**Key Attributes**:
- `nome`: Project name
- `tipo`: Type (enum-like)
- `stato`: Status (ProjectStatus enum) - Draft, Approved, Liquidated
- `importo_totale`: Total project amount
- `importo_effettivo_fondo`: Effective fund amount (after percentage applied)
- `percentuale_fondo`: Fund percentage from CapitalPercentage lookup
- `componente_incentivante`: 80% of effective fund (incentive component)
- `componente_innovazione`: 20% of effective fund (innovation component)
- `data_aggiudicazione`: Adjudication date
- `data_inizio_esecuzione`: Execution start date
- `data_fine_esecuzione`: Execution end date
- `ente_finanziatore`: Financing entity
- `settore`: Sector
- `tipo_liquidazione`: Settlement type
- `rup`: User ID of RUP (Responsabile Unico del Procedimento)
- `dec`: User ID of DEC (Direttore Esecuzione Contratto)

**Enums**:
- `ProjectStatus`: `Draft`, `Approved`, `Liquidated`

---

#### **Activity** (Belongs to Project)
```
Activity
├── belongs_to: Project
├── has_many: Employee[] (via ActivityEmployee pivot)
├── belongs_to: Phase (optional)
└── has_many: Workgroup (implied through project)
```

**Key Attributes**:
- `nome`: Activity name
- `tipo`: Activity type
- `quota_percentuale`: Percentage allocation (e.g., 30%, 70%)
- `importo`: Calculated amount (project importo * quota_percentuale / 100)
- `anno_competenza`: Competence year
- `appartiene_a_liquidazione_a_fasi`: Boolean - is phase-based settlement
- `liquidazione_fasi`: Phase settlement details
- `project_id`: Foreign key to Project
- `phase_id`: Optional phase for multi-phase projects

**Purpose**: Breaks down project budget into activities, each with a percentage allocation.

---

#### **Employee** (Multi-project, Multi-activity)
```
Employee
├── has_many: Project[] (via EmployeeProject pivot)
├── has_many: Activity[] (via ActivityEmployee pivot)
├── has_many: Workgroup (implied)
└── belongs_to: StabiDirigente (manager relation)
```

**Key Attributes**:
- Standard employee info (name, department, etc.)
- Role-based access (policies control what they can do)

---

#### **Pivot Models** (Critical for calculations)

##### **EmployeeProject**
```
EmployeeProject
├── employee_id
├── project_id
└── [percentuale_attivita_dipendente, importo_attivita_dipendente]
```

##### **ActivityEmployee**
```
ActivityEmployee
├── activity_id
├── employee_id
├── percentuale_attivita_dipendente: Float (e.g., 50.0)
└── importo_attivita_dipendente: Float (calculated from activity importo * percentuale)
```

**Calculation Flow**:
```
Project.importo_totale
  ↓ (lookup via SpareImportoTotaleAction)
Project.importo_effettivo_fondo = importo_totale * percentuale_fondo / 100
  ↓
Project.componente_incentivante = importo_effettivo_fondo * 0.80
Project.componente_innovazione = importo_effettivo_fondo * 0.20
  ↓ (distribute to activities)
Activity.importo = Project.importo_effettivo_fondo * Activity.quota_percentuale / 100
  ↓ (distribute to employees)
ActivityEmployee.importo_attivita_dipendente = Activity.importo * ActivityEmployee.percentuale_attivita_dipendente / 100
```

---

#### **Other Models**

| Model | Purpose | Key Relations |
|-------|---------|----------------|
| **Settlement** | Tracks liquidation/payout records | Project, Employee |
| **Phase** | Multi-phase project support | Project, Activity |
| **Workgroup** | Organizational grouping | Project, Employee |
| **StabiDirigente** | Manager/responsible person | Project (RUP/DEC) |
| **CapitalPercentage** | Lookup table for percentage ranges | (static, no relations) |
| **DefaultActivity** | Template activities | ? |

---

### 2.2 Enum Usage

```php
// ProjectStatus
ProjectStatus::Draft       // Initial state
ProjectStatus::Approved    // After authorization
ProjectStatus::Liquidated  // After payout
```

**Tests should**:
- ✓ Test state transitions (Draft → Approved → Liquidated)
- ✓ Test that only authorized users can transition
- ✓ Test business rules per state

---

## 3. CORE ACTIONS (BUSINESS LOGIC)

### 3.1 SpareImportoTotaleAction

**Location**: `app/Actions/SpareImportoTotaleAction.php`

**Purpose**: Distributes total project funds across components based on percentage brackets.

**Algorithm**:
1. Input: `float $amount` (importo_totale)
2. Lookup: Find `CapitalPercentage` row where:
   - `tipologia` matches project type
   - `da <= amount <= a` (range match)
3. Calculate:
   - `percentuale_fondo = percentage->valore`
   - `importo_effettivo_fondo = importo_totale * percentuale_fondo / 100`
   - `componente_incentivante = importo_effettivo_fondo * 0.80`
   - `componente_innovazione = importo_effettivo_fondo * 0.20`

**Edge Cases**:
- ❌ No matching percentage range → Set all values to 0
- ❌ Invalid amount (negative, non-numeric) → Handle gracefully
- ✓ Boundary values (exact match, min, max)

**Testing Strategy**:
```php
it('looks up percentage bracket correctly', function () {
    CapitalPercentage::factory()->create(['da' => 1000, 'a' => 5000, 'valore' => 15]);
    
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(3000, $get, $set); // Should match 15%
    
    expect($set->called('percentuale_fondo', 15))->toBeTrue();
});

it('returns zeros when no bracket matches', function () {
    CapitalPercentage::factory()->create(['da' => 1000, 'a' => 5000, 'valore' => 15]);
    
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(10000, $get, $set); // Out of range
    
    expect($set->called('percentuale_fondo', 0))->toBeTrue();
});
```

---

### 3.2 UpdateActivitiesEmployeesAction

**Location**: `app/Actions/UpdateActivitiesEmployeesAction.php`

**Purpose**: Syncs employee pivot data when importo changes.

**Algorithm**:
1. Input: `Model $record` (Project or Activity)
2. Get `importo` from record:
   - Project: `importo_totale`
   - Activity: `importo`
3. For each employee in relation:
   - Get `percentuale_attivita_dipendente` from pivot
   - Update pivot `importo_attivita_dipendente = importo * percentuale / 100`

**Safety Checks**:
- ✓ Null record handling
- ✓ Type narrowing (ensure model is object)
- ✓ Pivot object existence check
- ✓ Model instance check before update()

**Testing Strategy**:
```php
it('distributes importo to employee pivots correctly', function () {
    $project = Project::factory()->create(['importo_totale' => 10000]);
    $employees = Employee::factory()->count(2)->create();
    
    $project->employees()->attach($employees, [
        'percentuale_attivita_dipendente' => [50, 50]
    ]);
    
    app(UpdateActivitiesEmployeesAction::class)->execute($project);
    
    // Each pivot should now have importo_attivita_dipendente = 10000 * 50 / 100 = 5000
    expect($project->employees()->first()->pivot->importo_attivita_dipendente)->toBe(5000);
});

it('handles null record gracefully', function () {
    app(UpdateActivitiesEmployeesAction::class)->execute(null);
    
    // Should not throw, just return
    expect(true)->toBeTrue();
});
```

---

### 3.3 UpdateProjectActivitiesAction

**Location**: `app/Actions/UpdateProjectActivitiesAction.php`

**Purpose**: Manages activity creation and lifecycle within projects.

**Algorithm**: (Infer from code later)

**Testing Strategy**: (Define after code review)

---

## 4. AUTHORIZATION & POLICIES

### 4.1 Policy Architecture

The module defines **13 Authorization Policies**:

1. **ActivityPolicy**: Control who can CRUD activities
2. **ActivityEmployeePolicy**: Control employee-activity assignments
3. **EmployeePolicy**: Control employee visibility/management
4. **EmployeeProjectPolicy**: Control project employee assignments
5. **EmployeeWorkgroupPolicy**: Control workgroup employee assignments
6. **ProjectPolicy**: Control project CRUD and state transitions
7. **SettlementPolicy**: Control settlement access
8. **StabiDirigentePolicy**: Control manager assignments
9. **WorkgroupPolicy**: Control workgroup CRUD
10. **PhasePolicy**: Control phase management
11. **DefaultActivityPolicy**: Control default activity templates
12. **CapitalPercentagePolicy**: Control percentage lookup data
13. (One more policy)

### 4.2 Key Rules (Examples)

**Project Policy**:
- Only RUP can create projects
- Only DEC can approve projects
- Only Finance can liquidate (settle) projects
- Anyone can view (with org restrictions)

**Activity Policy**:
- RUP can create activities
- DEC can edit activity percentages
- Activities inherit project permissions

### 4.3 Testing Authorization

In Filament tests, verify:
```php
// Test unauthorized access
Livewire::actingAs($unauthorizedEmployee)
    ->test(ProjectResource\Pages\CreateProject::class)
    ->assertForbidden();

// Test authorized access
Livewire::actingAs($rupUser)
    ->test(ProjectResource\Pages\CreateProject::class)
    ->assertSuccessful()
    ->fillForm(['nome' => 'New Project'])
    ->call('create');
```

---

## 5. FILAMENT RESOURCES (UI LAYER)

### 5.1 Resource List

1. **ActivityResource** - Manage activities
2. **EmployeeResource** - Manage employees
3. **ProjectResource** - Manage projects
4. **SettlementResource** - View settlements
5. **StabiDirigenteResource** - Assign managers
6. **WorkgroupResource** - Manage workgroups
7. **PhaseResource** - Manage phases
8. **DefaultActivityResource** - Manage activity templates
9. **CapitalPercentageResource** - Manage percentage brackets

### 5.2 Expected UI Patterns

**ProjectResource**:
- List page: sortable, filterable (status, ente_finanziatore, etc.)
- Create/Edit: Multi-step form
  - Step 1: Basic info (nome, tipo, importo_totale)
  - Step 2: Assign RUP/DEC (StabiDirigente)
  - Step 3: Create activities
- View page: Summary, activities, employees, settlement status

**ActivityResource**:
- Modal form: Quick create activity
- Modal form: Attach employees with percentuale

**EmployeeResource**:
- Modal: Assign to project (with percentuale_attivita_dipendente)
- Modal: Assign to activity (with percentuale_attivita_dipendente)

---

## 6. DATABASE FACTORIES

### 6.1 Existing Factories

```
database/factories/
├── ActivityFactory.php
├── ActivityEmployeeFactory.php (if exists)
├── CapitalPercentageFactory.php
├── DefaultActivityFactory.php
├── EmployeeFactory.php
├── EmployeeProjectFactory.php (if exists)
├── EmployeeWorkgroupFactory.php (if exists)
├── PhaseFactory.php
├── ProjectFactory.php
├── SettlementFactory.php
├── StabiDirigenteFactory.php
└── WorkgroupFactory.php
```

### 6.2 Usage in Tests

```php
// Simple creation
$project = Project::factory()->create();

// With relations
$project = Project::factory()
    ->has(Activity::factory()->count(3))
    ->create();

// With specific attributes
$project = Project::factory()->create([
    'importo_totale' => 10000,
    'stato' => ProjectStatus::Draft,
]);

// Multiple employees
$employees = Employee::factory()->count(5)->create();
$project->employees()->attach($employees, ['percentuale_attivita_dipendente' => 50]);
```

---

## 7. TRANSLATION STRUCTURE

### 7.1 Italian (Complete ✅)

```
lang/it/
├── activity.php (Activity labels, messages)
├── attivita.php (Alternative? consolidate)
├── capital_percentage.php
├── dipendente.php (Employee-related)
├── (50+ more files)
```

**Content Pattern**:
```php
// lang/it/activity.php
return [
    'name' => 'Attività',
    'singular' => 'Attività',
    'plural' => 'Attività',
    'section.title' => 'Gestione Attività',
    'field.nome' => 'Nome Attività',
    'field.quota_percentuale' => 'Quota Percentuale',
    'field.importo' => 'Importo',
    // ...
];
```

### 7.2 English (Partial ⚠️)

Only 3 files - need to complete:
- [ ] Complete activity.php
- [ ] Create/complete project.php
- [ ] Create/complete employee.php
- [ ] Create/complete all 54 files

### 7.3 German (Missing ❌)

- [ ] Create all 54 lang/de/ files (copy IT structure, translate)

---

## 8. KEY INVARIANTS TO PROTECT

### 8.1 Financial Calculations

1. **Accuracy**: All calculations must be bit-perfect
   - No rounding errors on percentage calculations
   - Consistent decimal places (test with specific amounts)

2. **Consistency**: Totals must equal sums of parts
   - `importo_effettivo_fondo == Activity.importo.sum()`
   - `Activity.importo == sum(employee_allocations)`

3. **Non-negative**: No negative importo values
   - Test constraint validation

### 8.2 Relationships

1. **Referential Integrity**:
   - Activity.project_id must exist
   - Employee must exist before assign to project
   - Settlement must reference valid project

2. **Cascade Behavior**:
   - Delete project → Delete activities ✓
   - Delete activity → Remove employee assignments ✓
   - Delete employee → ? (test this)

### 8.3 State Transitions

1. **ProjectStatus** follows sequence:
   - Draft → Approved (only)
   - Approved → Liquidated (only)
   - Cannot revert backwards

2. **Permissions per State**:
   - Draft: RUP can edit
   - Approved: DEC readonly, Finance prepares settlement
   - Liquidated: No edits, readonly

---

## 9. TEST COVERAGE TARGETS

| Component | Target | Rationale |
|-----------|--------|-----------|
| Models | 90% | Core data structures, must be rock-solid |
| Actions | 95% | Business logic, accuracy critical |
| Filament Resources | 80% | UI layer, integration with framework |
| Policies | 85% | Authorization, security-critical |
| Integration | 80% | E2E workflows |
| **Overall** | **85%** | High-quality codebase |

---

## 10. TESTING CHECKLIST (PER MODEL)

Use this for each model test file:

- [ ] **Creation**
  - [ ] Factory creates with defaults
  - [ ] `create()` with custom attributes
  - [ ] `make()` without saving
  - [ ] `createMany()` if multi-record

- [ ] **Attributes**
  - [ ] All fillable attributes accessible
  - [ ] Guarded attributes protected
  - [ ] Type casting (dates, decimals, etc.)
  - [ ] Computed properties work

- [ ] **Relationships**
  - [ ] HasMany: count, first, iterate
  - [ ] BelongsTo: access parent, lazy vs eager
  - [ ] BelongsToMany: access pivot
  - [ ] Eager load doesn't N+1

- [ ] **Enums**
  - [ ] Enum cases accessible
  - [ ] Enum casting works
  - [ ] Scopes by enum value (if exist)

- [ ] **Scopes** (if any)
  - [ ] Scope returns builder
  - [ ] Scope filters correctly
  - [ ] Multiple scopes composable

- [ ] **Methods**
  - [ ] Public methods callable
  - [ ] Methods handle null inputs
  - [ ] Methods return correct types

---

## 11. NEXT STEPS

### Phase 1: Docs Improvement (In Progress)
- [ ] Update docs/prd.md with test requirements
- [ ] Create docs/architecture.md with diagrams
- [ ] Create docs/testing-strategy.md
- [ ] Create docs/models/ with per-model docs
- [ ] Complete translations (EN, DE)

### Phase 2: Model Tests (High Priority)
- [ ] ActivityTest.pest.php
- [ ] EmployeeTest.pest.php
- [ ] ProjectTest.pest.php (enhance existing)
- [ ] SettlementTest.pest.php
- [ ] (9 more model tests)

### Phase 3: Action Tests (High Priority)
- [ ] SpareImportoTotaleActionTest.pest.php
- [ ] UpdateActivitiesEmployeesActionTest.pest.php
- [ ] UpdateProjectActivitiesActionTest.pest.php

### Phase 4: Filament Tests (Medium Priority)
- [ ] 9 Filament Resource tests

### Phase 5: Integration Tests (Medium Priority)
- [ ] IncentiveCalculationFlowTest.pest.php
- [ ] ApprovalWorkflowTest.pest.php
- [ ] DataConsistencyTest.pest.php

---

## 12. USEFUL COMMANDS

```bash
# Run all Incentivi tests
./vendor/bin/pest Modules/Incentivi/tests

# Run single test file
./vendor/bin/pest Modules/Incentivi/tests/Unit/Models/ProjectTest.php

# Run with coverage
./vendor/bin/pest Modules/Incentivi/tests --coverage

# PHPStan check (Level 10)
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Incentivi

# Format code
./vendor/bin/pint Modules/Incentivi
```

---

**Document Version**: 1.0  
**Last Updated**: 2026-03-10  
**Author**: Copilot + Development Team  
**Status**: Complete (Study + Planning phase)
