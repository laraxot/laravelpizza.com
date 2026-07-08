<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\ActivityEmployee;
use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Incentivi\Models\DefaultActivity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\EmployeeProject;
use Modules\Incentivi\Models\EmployeeWorkgroup;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\StabiDirigente;
use Modules\Incentivi\Models\Workgroup;

uses(TestCase::class);

it('can instantiate all target incentive models', function (string $class): void {
    $model = new $class();

    expect($model)->toBeInstanceOf($class);
})->with([
    Activity::class,
    ActivityEmployee::class,
    CapitalPercentage::class,
    DefaultActivity::class,
    Employee::class,
    EmployeeProject::class,
    EmployeeWorkgroup::class,
    Phase::class,
    Project::class,
    Settlement::class,
    StabiDirigente::class,
    Workgroup::class,
]);

it('keeps model classes compatible with eloquent inheritance', function (): void {
    expect(is_subclass_of(Activity::class, Model::class))->toBeTrue()
        ->and(is_subclass_of(Project::class, Model::class))->toBeTrue()
        ->and(is_subclass_of(Employee::class, Model::class))->toBeTrue()
        ->and(is_subclass_of(Settlement::class, Model::class))->toBeTrue();
});

it('computes full name accessor on employee', function (): void {
    $employee = new Employee();
    $employee->cognome = 'Rossi';
    $employee->nome = 'Mario';

    expect($employee->full_name)->toBe('Rossi Mario');
});

it('resolves workgroup id accessor from related project in activity', function (): void {
    $project = new Project();
    $project->workgroup_id = 42;

    $activity = new Activity();
    $activity->setRelation('project', $project);

    expect($activity->workgroup_id)->toBe(42);
});
