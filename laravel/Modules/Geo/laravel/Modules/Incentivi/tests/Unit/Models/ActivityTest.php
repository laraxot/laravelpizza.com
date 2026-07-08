<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

uses(TestCase::class);

test('it can create an activity', function () {
    $activity = Activity::factory()->create([
        'nome' => 'Test Activity',
    ]);

    expect($activity->nome)->toBe('Test Activity');
    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'nome' => 'Test Activity',
    ], 'incentivi');
});

test('an activity belongs to a project', function () {
    $project = Project::factory()->create();
    $activity = Activity::factory()->create([
        'project_id' => $project->id,
    ]);

    expect($activity->project)->toBeInstanceOf(Project::class);
    expect($activity->project->id)->toBe($project->id);
});

test('an activity can have many employees', function () {
    $activity = Activity::factory()->create();
    $employees = Employee::factory()->count(3)->create();

    $activity->employees()->attach($employees);

    expect($activity->employees)->toHaveCount(3);
    expect($activity->employees)->toBeInstanceOf(Collection::class);
    expect($activity->employees->first())->toBeInstanceOf(Employee::class);
});

test('an activity has numeric attributes', function () {
    $activity = Activity::factory()->create([
        'quota_percentuale' => 25,
        'importo' => 1500.50,
    ]);

    expect((int) $activity->quota_percentuale)->toBe(25)
        ->and((float) $activity->importo)->toBe(1500.50);
});

test('an activity workgroup_id accessor returns project workgroup_id', function () {
    $project = Project::factory()->create();
    $activity = Activity::factory()->create(['project_id' => $project->id]);

    // Set the relation manually since workgroup_id is not a DB column
    $project->workgroup_id = 42;
    $activity->setRelation('project', $project);

    expect($activity->workgroup_id)->toBe(42);
});
