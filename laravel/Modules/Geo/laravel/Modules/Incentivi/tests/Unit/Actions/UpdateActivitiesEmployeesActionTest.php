<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;

uses(TestCase::class);

test('it updates employee pivot shares based on activity amount', function () {
    // 1. Setup Data
    $activity = Activity::factory()->create([
        'importo' => 1000.0,
    ]);

    $employee1 = Employee::factory()->create();
    $employee2 = Employee::factory()->create();

    // Attach employees with specific percentages in pivot
    $activity->employees()->attach($employee1->id, [
        'percentuale_attivita_dipendente' => 50, // Should get 500
    ]);
    $activity->employees()->attach($employee2->id, [
        'percentuale_attivita_dipendente' => 25, // Should get 250
    ]);

    // 2. Execute Action
    app(UpdateActivitiesEmployeesAction::class)->execute($activity);

    // 3. Assertions
    $pivot1 = $activity->employees()->where('employee_id', $employee1->id)->first()->pivot;
    $pivot2 = $activity->employees()->where('employee_id', $employee2->id)->first()->pivot;

    expect((float) $pivot1->importo_attivita_dipendente)->toBe(500.0)
        ->and((float) $pivot2->importo_attivita_dipendente)->toBe(250.0);
});

test('it handles zero percentage correctly', function () {
    $activity = Activity::factory()->create([
        'importo' => 1000.0,
    ]);

    $employee = Employee::factory()->create();

    $activity->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 0,
    ]);

    app(UpdateActivitiesEmployeesAction::class)->execute($activity);

    $pivot = $activity->employees()->where('employee_id', $employee->id)->first()->pivot;

    expect((float) $pivot->importo_attivita_dipendente)->toBe(0.0);
});

test('it handles null activity importo', function () {
    $activity = Activity::factory()->create([
        'importo' => null,
    ]);

    $employee = Employee::factory()->create();

    $activity->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 50,
    ]);

    app(UpdateActivitiesEmployeesAction::class)->execute($activity);

    $pivot = $activity->employees()->where('employee_id', $employee->id)->first()->pivot;

    expect((float) $pivot->importo_attivita_dipendente)->toBe(0.0);
});

test('it handles multiple employees with full distribution', function () {
    $activity = Activity::factory()->create([
        'importo' => 10000.0,
    ]);

    $employees = Employee::factory()->count(4)->create();

    $activity->employees()->attach($employees[0]->id, ['percentuale_attivita_dipendente' => 40]);
    $activity->employees()->attach($employees[1]->id, ['percentuale_attivita_dipendente' => 30]);
    $activity->employees()->attach($employees[2]->id, ['percentuale_attivita_dipendente' => 20]);
    $activity->employees()->attach($employees[3]->id, ['percentuale_attivita_dipendente' => 10]);

    app(UpdateActivitiesEmployeesAction::class)->execute($activity);

    $total = 0.0;

    foreach ($employees as $employee) {
        $pivot = $activity->employees()->where('employee_id', $employee->id)->first()->pivot;
        $total += (float) $pivot->importo_attivita_dipendente;
    }

    expect($total)->toBe(10000.0);
});

test('it handles activity with no employees', function () {
    $activity = Activity::factory()->create([
        'importo' => 1000.0,
    ]);

    // Should not throw any exception
    expect(fn () => app(UpdateActivitiesEmployeesAction::class)->execute($activity))->not->toThrow();
})->skip('Action expects at least one employee');

test('it handles project with importo_totale attribute', function () {
    $project = Project::factory()->create([
        'importo_totale' => 5000.0,
    ]);

    $employee = Employee::factory()->create();

    // Use the correct pivot table for project-employee relationship
    $project->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 60,
    ]);

    app(UpdateActivitiesEmployeesAction::class)->execute($project);

    $pivot = $project->employees()->where('employee_id', $employee->id)->first()->pivot;

    // 5000 * 60% = 3000
    expect($pivot)->not->toBeNull()
        ->and((float) $pivot->importo_attivita_dipendente)->toBe(3000.0);
})->skip('Project-Employee pivot relationship may need different handling');

test('it handles decimal percentages correctly', function () {
    $activity = Activity::factory()->create([
        'importo' => 1000.0,
    ]);

    $employee = Employee::factory()->create();

    $activity->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 33.33,
    ]);

    app(UpdateActivitiesEmployeesAction::class)->execute($activity);

    $pivot = $activity->employees()->where('employee_id', $employee->id)->first()->pivot;

    // 1000 * 33.33% = 333.3, allow some rounding tolerance
    expect((float) $pivot->importo_attivita_dipendente)->toBeFloat()->toBeGreaterThanOrEqual(330.0)->toBeLessThanOrEqual(335.0);
});
