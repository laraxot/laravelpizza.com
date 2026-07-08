<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models\Policies;

use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Policies\ActivityPolicy;
use Modules\Incentivi\Enums\ProjectStatus;
use Modules\User\Models\User;
use Modules\Incentivi\Tests\TestCase;

uses(TestCase::class);

test('any user can view any activities', function () {
    $user = User::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->viewAny($user))->toBeTrue();
});

test('incentivi admin can view activity', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->view($admin, $activity))->toBeTrue();
});

test('employee assigned to activity can view it', function () {
    $employee = Employee::factory()->create();
    $activity = Activity::factory()->create();

    $activity->employees()->attach($employee->id);

    $policy = new ActivityPolicy;

    expect($policy->view($employee, $activity))->toBeTrue();
});

test('unassigned employee cannot view activity', function () {
    $employee = Employee::factory()->create();
    $activity = Activity::factory()->create();

    $policy = new ActivityPolicy;

    expect($policy->view($employee, $activity))->toBeFalse();
});

test('only admin can create activities', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $user = User::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->create($admin))->toBeTrue();
    expect($policy->create($user))->toBeFalse();
});

test('any user can update activity', function () {
    $user = User::factory()->create();
    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->update($user, $activity))->toBeTrue();
});

test('admin or hr can delete activity', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $hrManager = User::factory()->create();
    $hrManager->addRole('hr-manager');

    $user = User::factory()->create();
    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->delete($admin, $activity))->toBeTrue();
    expect($policy->delete($hrManager, $activity))->toBeTrue();
    expect($policy->delete($user, $activity))->toBeFalse();
});

test('admin or workgroup manager can assign employees to activity', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->assignEmployees($admin, $activity))->toBeTrue();
    expect($policy->assignEmployees($manager, $activity))->toBeTrue();
});

test('cannot assign employees to activity of concluded project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::CONCLUSO,
    ]);

    $activity = Activity::factory()->create([
        'project_id' => $project->id,
    ]);

    $policy = new ActivityPolicy;

    expect($policy->assignEmployees($admin, $activity))->toBeFalse();
});

test('cannot assign employees to activity of cancelled project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::CANCELLATO,
    ]);

    $activity = Activity::factory()->create([
        'project_id' => $project->id,
    ]);

    $policy = new ActivityPolicy;

    expect($policy->assignEmployees($admin, $activity))->toBeFalse();
});

test('only admin can calculate activity amount', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $user = User::factory()->create();
    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->calculateAmount($admin, $activity))->toBeTrue();
    expect($policy->calculateAmount($user, $activity))->toBeFalse();
});

test('admin or workgroup manager can validate percentages', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->validatePercentages($admin, $activity))->toBeTrue();
    expect($policy->validatePercentages($manager, $activity))->toBeTrue();
});

test('admin or workgroup manager can duplicate activity', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $activity = Activity::factory()->create();
    $policy = new ActivityPolicy;

    expect($policy->replicate($admin, $activity))->toBeTrue();
    expect($policy->replicate($manager, $activity))->toBeTrue();
});
