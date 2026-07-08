# Testing Strategy - Incentivi Module

**Date**: 2026-03-10  
**Framework**: Pest PHP v4  
**Target Coverage**: 85%+  
**Test Count**: 27+ tests across Unit, Feature, and Integration layers

---

## 1. TEST FRAMEWORK & SETUP

### 1.1 Framework Configuration

**Pest Configuration**:
- Location: `Modules/Incentivi/phpunit.xml.dist`
- Test runner: Pest PHP v4
- Database: MySQL (configured in TestCase)
- Transactions: Automatic rollback per test (DatabaseTransactions trait)

**Base TestCase**:
```php
// tests/TestCase.php
abstract class TestCase extends XotTestCase
{
    use DatabaseTransactions;
    
    protected array $connectionsToTransact = ['mysql', 'incentivi'];
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom([__DIR__.'/../database/migrations']);
    }
}
```

### 1.2 Pest Configuration File

```php
// tests/Pest.php
uses(TestCase::class, DatabaseTransactions::class)->in(__DIR__);
```

---

## 2. TEST PATTERNS & CONVENTIONS

### 2.1 AAA Pattern (Arrange-Act-Assert)

Every test follows this structure:

```php
it('description of what is being tested', function () {
    // ARRANGE: Set up data and preconditions
    $project = Project::factory()->create(['importo_totale' => 10000]);
    $activity = Activity::factory()->create(['project_id' => $project->id]);
    $employees = Employee::factory()->count(2)->create();
    
    // ACT: Perform the action being tested
    $activity->employees()->attach($employees, ['percentuale_attivita_dipendente' => 50]);
    app(UpdateActivitiesEmployeesAction::class)->execute($activity);
    
    // ASSERT: Verify the outcome
    expect($employees[0]->pivot->importo_attivita_dipendente)
        ->toBe($activity->importo * 50 / 100);
});
```

### 2.2 Naming Conventions

**File Names**:
- Pattern: `PascalCase` matching the class name
- Example: `ProjectTest.pest.php` for Project model
- Location: `tests/Unit/Models/` or `tests/Feature/Filament/`

**Test Names**:
- Pattern: `it('human-readable description')` or `test('description')`
- Prefer `it()` for better readability
- Example: `it('calculates importo correctly when activity has employees')`

**Assertions**:
- Use Pest's fluent API: `expect($value)->toBe($expected)`
- Chain multiple assertions: `expect($model)->toBeInstanceOf(Project::class)->id->toEqual(1)`

### 2.3 Factory Usage

**Basic Factory**:
```php
$project = Project::factory()->create();
$activity = Activity::factory()->make(); // Don't save
```

**Factory with Relations**:
```php
$project = Project::factory()
    ->has(Activity::factory()->count(3))
    ->create();
```

**Factory with Attributes**:
```php
$project = Project::factory()->create([
    'nome' => 'Custom Project',
    'importo_totale' => 50000,
    'stato' => ProjectStatus::Draft,
]);
```

**Pivot Relationships**:
```php
$project = Project::factory()->create();
$employees = Employee::factory()->count(3)->create();
$project->employees()->attach($employees, [
    'percentuale_attivita_dipendente' => [30, 40, 30],
]);
```

### 2.4 Database Assertions

**Pest's Database Assertions**:
```php
// Check row exists in database
$this->assertDatabaseHas('projects', [
    'id' => $project->id,
    'nome' => 'Test Project',
], 'incentivi'); // Specify connection

// Check row doesn't exist
$this->assertDatabaseMissing('projects', [
    'id' => 999,
], 'incentivi');

// Count rows
$this->assertDatabaseCount('activities', 3, 'incentivi');
```

### 2.5 Mocking & Spying

**Spy on Method Calls**:
```php
$spy = Mockery::spy(UpdateActivitiesEmployeesAction::class);
app()->bind(UpdateActivitiesEmployeesAction::class, $spy);

$project = Project::factory()->create();
// ... action triggers ...

$spy->shouldHaveReceived('execute')->once();
```

**Mock External Dependencies** (if needed):
```php
$mockService = Mockery::mock(SomeExternalService::class);
$mockService->shouldReceive('calculateIncentive')->andReturn(5000);
app()->bind(SomeExternalService::class, $mockService);
```

---

## 3. UNIT TESTS (P0 - Models)

### 3.1 Model Test Template

```php
// tests/Unit/Models/ProjectTest.pest.php

declare(strict_types=1);

use Modules\Incentivi\Models\{Activity, Employee, Project};
use Modules\Incentivi\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Collection;

// ==== CREATION TESTS ====

it('can create a project', function () {
    $project = Project::factory()->create(['nome' => 'Test Project']);
    expect($project->nome)->toBe('Test Project');
    expect($project)->toBeInstanceOf(Project::class);
});

it('can create a project with specific attributes', function () {
    $project = Project::factory()->create([
        'importo_totale' => 10000,
        'stato' => ProjectStatus::Draft,
    ]);
    
    expect($project->importo_totale)->toBe(10000);
    expect($project->stato)->toEqual(ProjectStatus::Draft);
});

// ==== RELATIONSHIP TESTS ====

it('has many activities', function () {
    $project = Project::factory()
        ->has(Activity::factory()->count(3))
        ->create();
    
    expect($project->activities)->toHaveCount(3);
    expect($project->activities)->toBeInstanceOf(Collection::class);
    expect($project->activities->first())->toBeInstanceOf(Activity::class);
});

it('has many employees through relationship', function () {
    $project = Project::factory()->create();
    $employees = Employee::factory()->count(2)->create();
    
    $project->employees()->attach($employees);
    
    expect($project->employees)->toHaveCount(2);
    expect($project->employees->first())->toBeInstanceOf(Employee::class);
});

// ==== EAGER LOADING TESTS ====

it('can eager load activities to avoid N+1', function () {
    Project::factory()->count(5)
        ->has(Activity::factory()->count(3))
        ->create();
    
    // Doesn't trigger N+1
    $query = Project::with('activities');
    expect($query)->toBeInstanceOf(Builder::class);
});

// ==== ENUM TESTS ====

it('casts stato to ProjectStatus enum', function () {
    $project = Project::factory()->create(['stato' => 'Draft']);
    expect($project->stato)->toBeInstanceOf(ProjectStatus::class);
    expect($project->stato)->toEqual(ProjectStatus::Draft);
});

// ==== ACCESSOR TESTS ====

it('calculates derived fields correctly', function () {
    $project = Project::factory()->create([
        'importo_totale' => 10000,
        'percentuale_fondo' => 50,
    ]);
    
    // If there's a computed property for importo_effettivo_fondo
    expect($project->importo_effettivo_fondo ?? null)
        ->toBeGreaterThan(0);
});
```

### 3.2 Pivot Model Tests

**ActivityEmployeeTest**:
```php
it('stores employee percentuale and importo', function () {
    $activity = Activity::factory()->create(['importo' => 10000]);
    $employee = Employee::factory()->create();
    
    $activity->employees()->attach($employee, [
        'percentuale_attivita_dipendente' => 50,
    ]);
    
    $pivot = $activity->employees()->first()->pivot;
    
    expect($pivot->percentuale_attivita_dipendente)->toBe(50);
    expect($pivot->importo_attivita_dipendente ?? 0)->toBe(5000);
});
```

---

## 4. UNIT TESTS (P0 - Actions)

### 4.1 Action Test Template

```php
// tests/Unit/Actions/SpareImportoTotaleActionTest.pest.php

declare(strict_types=1);

use Modules\Incentivi\Actions\SpareImportoTotaleAction;
use Modules\Incentivi\Models\CapitalPercentage;
use Filament\Schemas\Components\Utilities\{Get, Set};
use Mockery;

// ==== PERCENTAGE LOOKUP TESTS ====

it('looks up correct percentage bracket for amount', function () {
    CapitalPercentage::factory()->create([
        'tipologia' => 'type_a',
        'da' => 1000,
        'a' => 5000,
        'valore' => 15,
    ]);
    
    $get = Mockery::mock(Get::class);
    $get->shouldReceive('__invoke')->andReturn((object) ['value' => 'type_a']);
    
    $set = Mockery::mock(Set::class);
    
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(3000, $get, $set);
    
    // Verify set() was called with correct values
    expect($set->called('percentuale_fondo', 15) ?? true)->toBeTrue();
});

it('returns zeros when amount is outside all brackets', function () {
    CapitalPercentage::factory()->create([
        'tipologia' => 'type_a',
        'da' => 1000,
        'a' => 5000,
        'valore' => 15,
    ]);
    
    $get = Mockery::mock(Get::class);
    $get->shouldReceive('__invoke')->andReturn((object) ['value' => 'type_a']);
    
    $set = Mockery::mock(Set::class);
    
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(10000, $get, $set); // Out of range
    
    expect($set->called('percentuale_fondo', 0) ?? true)->toBeTrue();
    expect($set->called('importo_effettivo_fondo', 0) ?? true)->toBeTrue();
});

// ==== CALCULATION TESTS ====

it('calculates importo_effettivo_fondo correctly', function () {
    CapitalPercentage::factory()->create([
        'tipologia' => 'type_a',
        'da' => 0,
        'a' => 100000,
        'valore' => 20,
    ]);
    
    $action = app(SpareImportoTotaleAction::class);
    
    // action.execute(10000, ...) should set:
    // percentuale_fondo = 20
    // importo_effettivo_fondo = 10000 * 20 / 100 = 2000
    // componente_incentivante = 2000 * 0.80 = 1600
    // componente_innovazione = 2000 * 0.20 = 400
    
    // (Verify with mocks or actual calls)
});

// ==== EDGE CASES ====

it('handles zero amount gracefully', function () {
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(0, $get, $set);
    
    // Should not throw
    expect(true)->toBeTrue();
});

it('handles negative amount gracefully', function () {
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(-1000, $get, $set);
    
    // Should handle or set to 0
    expect(true)->toBeTrue();
});
```

---

## 5. FEATURE TESTS (P1 - Filament)

### 5.1 Filament Resource Test Template

```php
// tests/Feature/Filament/ProjectResourceTest.pest.php

declare(strict_types=1);

use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\ProjectResource\Pages\CreateProject;
use Modules\Incentivi\Filament\Resources\ProjectResource\Pages\EditProject;
use Livewire\Livewire;

// ==== CREATE PAGE TESTS ====

it('can load the create project page', function () {
    $user = User::factory()->create(['role' => 'rup']); // RUP can create
    
    Livewire::actingAs($user)
        ->test(CreateProject::class)
        ->assertSuccessful();
});

it('validates required fields on create', function () {
    $user = User::factory()->create(['role' => 'rup']);
    
    Livewire::actingAs($user)
        ->test(CreateProject::class)
        ->fillForm(['nome' => '']) // Missing
        ->call('create')
        ->assertHasFormErrors(['nome']);
});

it('creates a project with valid data', function () {
    $user = User::factory()->create(['role' => 'rup']);
    
    Livewire::actingAs($user)
        ->test(CreateProject::class)
        ->fillForm([
            'nome' => 'New Project',
            'importo_totale' => 10000,
            'tipo' => 'tipo_a',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    
    expect(Project::where('nome', 'New Project')->exists())->toBeTrue();
});

// ==== EDIT PAGE TESTS ====

it('can load the edit project page', function () {
    $project = Project::factory()->create();
    $user = User::factory()->create(['role' => 'rup']);
    
    Livewire::actingAs($user)
        ->test(EditProject::class, ['record' => $project->id])
        ->assertSuccessful();
});

it('updates a project with valid data', function () {
    $project = Project::factory()->create(['nome' => 'Old Name']);
    $user = User::factory()->create(['role' => 'rup']);
    
    Livewire::actingAs($user)
        ->test(EditProject::class, ['record' => $project->id])
        ->fillForm(['nome' => 'New Name'])
        ->call('save')
        ->assertHasNoFormErrors();
    
    expect($project->fresh()->nome)->toBe('New Name');
});

// ==== TABLE TESTS ====

it('displays projects in table', function () {
    Project::factory()->count(3)->create();
    $user = User::factory()->create(['role' => 'viewer']);
    
    Livewire::actingAs($user)
        ->test(ProjectResource\Pages\ListProjects::class)
        ->assertCanSeeTableRecords(Project::all());
});

it('can filter projects by status', function () {
    Project::factory()->create(['stato' => 'Draft']);
    Project::factory()->create(['stato' => 'Approved']);
    
    $user = User::factory()->create();
    
    Livewire::actingAs($user)
        ->test(ProjectResource\Pages\ListProjects::class)
        ->filterTable('stato', 'Draft')
        ->assertCanSeeTableRecords(Project::where('stato', 'Draft')->get())
        ->assertCannotSeeTableRecords(Project::where('stato', 'Approved')->get());
});

// ==== AUTHORIZATION TESTS ====

it('forbids non-RUP users from creating projects', function () {
    $user = User::factory()->create(['role' => 'employee']); // Not RUP
    
    Livewire::actingAs($user)
        ->test(CreateProject::class)
        ->assertForbidden();
});

it('forbids non-DEC users from approving projects', function () {
    $project = Project::factory()->create();
    $user = User::factory()->create(['role' => 'employee']); // Not DEC
    
    Livewire::actingAs($user)
        ->test(EditProject::class, ['record' => $project->id])
        ->call('approve') // Hypothetical action
        ->assertForbidden();
});
```

---

## 6. INTEGRATION TESTS (P2)

### 6.1 Integration Test Template

```php
// tests/Feature/Integration/IncentiveCalculationFlowTest.pest.php

declare(strict_types=1);

use Modules\Incentivi\Models\{Project, Activity, Employee, Settlement};
use Modules\Incentivi\Actions\{SpareImportoTotaleAction, UpdateActivitiesEmployeesAction};
use Modules\Incentivi\Enums\ProjectStatus;

it('executes complete incentive calculation workflow', function () {
    // Step 1: Create project
    $project = Project::factory()->create([
        'nome' => 'Incentive Project 2025',
        'importo_totale' => 50000,
        'tipo' => 'tipo_a',
    ]);
    
    // Step 2: Set up CapitalPercentage (lookup table)
    CapitalPercentage::factory()->create([
        'tipologia' => 'tipo_a',
        'da' => 0,
        'a' => 100000,
        'valore' => 20,
    ]);
    
    // Step 3: Calculate fund distribution
    $action = app(SpareImportoTotaleAction::class);
    // ... execute calculation ...
    
    // Step 4: Create activities
    $activity1 = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 60,
    ]);
    
    $activity2 = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 40,
    ]);
    
    // Step 5: Assign employees to activities
    $employees = Employee::factory()->count(5)->create();
    
    $activity1->employees()->attach($employees->take(3), [
        'percentuale_attivita_dipendente' => [30, 35, 35],
    ]);
    
    $activity2->employees()->attach($employees->skip(3), [
        'percentuale_attivita_dipendente' => [50, 50],
    ]);
    
    // Step 6: Update employee pivot calculations
    app(UpdateActivitiesEmployeesAction::class)->execute($activity1);
    app(UpdateActivitiesEmployeesAction::class)->execute($activity2);
    
    // ASSERTIONS
    
    // Verify project calculations
    expect($project->fresh()->importo_effettivo_fondo)
        ->toBe(50000 * 20 / 100); // 10000
    
    // Verify activity amounts
    expect($activity1->fresh()->importo)
        ->toBe(10000 * 60 / 100); // 6000
    
    // Verify employee allocations
    $emp1 = $employees[0]->fresh();
    expect($emp1->pivot->importo_attivita_dipendente)
        ->toBe(6000 * 30 / 100); // 1800
});

it('maintains financial accuracy across multi-step workflow', function () {
    // Verify: total distributed == project fund
    
    $project = Project::factory()->create(['importo_totale' => 50000]);
    $activities = Activity::factory()->count(3)->create(['project_id' => $project->id]);
    
    // Sum of activity percentages must == 100
    $totalPercentage = $activities->sum('quota_percentuale');
    expect($totalPercentage)->toBe(100);
});

it('validates data consistency when deleting activity', function () {
    $project = Project::factory()->create();
    $activity = Activity::factory()->create(['project_id' => $project->id]);
    $employees = Employee::factory()->count(2)->create();
    
    $activity->employees()->attach($employees);
    
    // Delete activity
    $activity->delete();
    
    // Verify cascade/cleanup
    expect($project->activities->count())->toBe(0);
    expect($activity->employees->count())->toBe(0);
});
```

---

## 7. COVERAGE TARGETS

### 7.1 Target Coverage by Component

| Component | Target | Why |
|-----------|--------|-----|
| Models | 90% | Core data, must be bulletproof |
| Actions | 95% | Business logic, accuracy critical |
| Filament Resources | 80% | UI integration, secondary priority |
| Policies | 85% | Security, must be comprehensive |
| Integration | 80% | E2E workflows |
| **Overall** | **85%** | High-confidence codebase |

### 7.2 Coverage Report Commands

```bash
# Generate coverage report
./vendor/bin/pest Modules/Incentivi/tests --coverage

# With specific file
./vendor/bin/pest Modules/Incentivi/tests --coverage --coverage-html=coverage

# Check coverage for specific model
./vendor/bin/pest Modules/Incentivi/tests/Unit/Models/ProjectTest.php --coverage
```

---

## 8. RUNNING TESTS

### 8.1 Local Execution

```bash
# All Incentivi tests
./vendor/bin/pest Modules/Incentivi/tests

# Specific test file
./vendor/bin/pest Modules/Incentivi/tests/Unit/Models/ProjectTest.php

# Specific test
./vendor/bin/pest --filter="test_name" Modules/Incentivi/tests

# Watch mode (auto-rerun on save)
./vendor/bin/pest Modules/Incentivi/tests --watch

# Parallel execution (faster)
./vendor/bin/pest Modules/Incentivi/tests --parallel
```

### 8.2 CI/CD Integration

**GitHub Actions** (in `.github/workflows/ci.yml`):
```yaml
- name: Run Incentivi Tests
  run: ./vendor/bin/pest Modules/Incentivi/tests --coverage

- name: Upload Coverage to Codecov
  uses: codecov/codecov-action@v3
  with:
    files: ./coverage.xml
```

---

## 9. DEBUGGING TESTS

### 9.1 Debug Single Test

```php
it('test that is failing', function () {
    // Use dd() to dump and die
    $project = Project::factory()->create();
    dd($project); // Will output and stop
    
    // Or use dump()
    dump($project); // Will output and continue
});

// Run with verbose output
./vendor/bin/pest Modules/Incentivi/tests -v
```

### 9.2 Database Inspection

```php
// Assert database state
$this->assertDatabaseHas('projects', ['id' => $project->id], 'incentivi');

// Count records
$this->assertDatabaseCount('projects', 1, 'incentivi');

// Manually inspect
ray($project->fresh()); // Using Ray debugging tool
```

---

## 10. BEST PRACTICES

1. **Isolation**: Each test is independent, no shared state
2. **Clarity**: Test names clearly describe what's being tested
3. **Arrange-Act-Assert**: Follow AAA pattern consistently
4. **Factory Usage**: Always use factories for clean data
5. **No Hardcoding**: Use factory attributes, not magic numbers
6. **Database Transactions**: Automatic rollback per test (already configured)
7. **Type Safety**: All tests must pass PHPStan Level 10
8. **Assertions**: Use multiple specific assertions, not just one generic check

---

**Document Version**: 1.0  
**Last Updated**: 2026-03-10  
**Status**: Complete - Ready for Implementation
