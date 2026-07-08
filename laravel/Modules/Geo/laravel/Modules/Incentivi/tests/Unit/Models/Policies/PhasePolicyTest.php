<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models\Policies;

use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\Policies\PhasePolicy;
use Modules\User\Models\User;
use Modules\Incentivi\Tests\TestCase;

uses(TestCase::class);

test('admin or workgroup manager can view any phases', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $user = User::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->viewAny($admin))->toBeTrue();
    expect($policy->viewAny($manager))->toBeTrue();
    expect($policy->viewAny($user))->toBeFalse();
});

test('admin can view phase', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $phase = Phase::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->view($admin, $phase))->toBeTrue();
});

test('workgroup manager can view phase', function () {
    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $phase = Phase::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->view($manager, $phase))->toBeTrue();
});

test('employee assigned to project can view phase', function () {
    $employee = Employee::factory()->create();

    $project = Project::factory()->create();
    $phase = Phase::factory()->create([
        'project_id' => $project->id,
    ]);

    $project->employees()->attach($employee->id);

    $policy = new PhasePolicy;

    expect($policy->view($employee, $phase))->toBeTrue();
});

test('unauthorized user cannot view phase', function () {
    $user = User::factory()->create();

    $phase = Phase::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->view($user, $phase))->toBeFalse();
});

test('admin or workgroup manager can create phases', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $user = User::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->create($admin))->toBeTrue();
    expect($policy->create($manager))->toBeTrue();
    expect($policy->create($user))->toBeFalse();
});

test('admin or workgroup manager can update phase', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $phase = Phase::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->update($admin, $phase))->toBeTrue();
    expect($policy->update($manager, $phase))->toBeTrue();
});

test('cannot update phase with settlements', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $phase = Phase::factory()->create();
    $settlement = Settlement::factory()->create([
        'phase_id' => $phase->id,
    ]);

    $policy = new PhasePolicy;

    expect($policy->update($admin, $phase))->toBeFalse();
});

test('only admin can delete phase', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $user = User::factory()->create();
    $phase = Phase::factory()->create();
    $policy = new PhasePolicy;

    expect($policy->delete($admin, $phase))->toBeTrue();
    expect($policy->delete($user, $phase))->toBeFalse();
});

test('cannot delete phase with settlements', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $phase = Phase::factory()->create();
    $settlement = Settlement::factory()->create([
        'phase_id' => $phase->id,
    ]);

    $policy = new PhasePolicy;

    expect($policy->delete($admin, $phase))->toBeFalse();
});
