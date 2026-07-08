<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models\Policies;

use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Policies\ProjectPolicy;
use Modules\Incentivi\Enums\ProjectStatus;
use Modules\User\Models\User;
use Modules\Incentivi\Tests\TestCase;

uses(TestCase::class);

test('user can view any projects', function () {
    $user = User::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->viewAny($user))->toBeTrue();
});

test('incentivi admin can view project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->view($admin, $project))->toBeTrue();
});

test('super admin can view project', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->addRole('super-admin');

    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->view($superAdmin, $project))->toBeTrue();
});

test('workgroup manager can view project', function () {
    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->view($manager, $project))->toBeTrue();
});

test('regular user cannot view project without proper role', function () {
    $user = User::factory()->create();

    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->view($user, $project))->toBeFalse();
});

test('any user can create projects', function () {
    $user = User::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->create($user))->toBeTrue();
});

test('user can update project in compilazione state', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->update($user, $project))->toBeTrue();
});

test('user cannot update project in concluso state', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create([
        'stato' => ProjectStatus::CONCLUSO,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->update($user, $project))->toBeFalse();
});

test('user cannot update project in cancellato state', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create([
        'stato' => ProjectStatus::CANCELLATO,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->update($user, $project))->toBeFalse();
});

test('only incentivi admin can delete project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->delete($admin, $project))->toBeTrue();
});

test('non admin cannot delete project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->delete($user, $project))->toBeFalse();
});

test('only admin can delete projects in compilazione state', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->delete($admin, $project))->toBeTrue();
});

test('admin cannot delete project in aggiudicazione state', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::AGGIUDICAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->delete($admin, $project))->toBeFalse();
});

test('deleteAny requires incentivi admin role', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $user = User::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->deleteAny($admin))->toBeTrue();
    expect($policy->deleteAny($user))->toBeFalse();
});

test('only admin can approve project in compilazione state', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->approve($admin, $project))->toBeTrue();
});

test('admin cannot approve project not in compilazione state', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::AGGIUDICAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->approve($admin, $project))->toBeFalse();
});

test('only admin can finalize project in aggiudicazione state', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::AGGIUDICAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->finalize($admin, $project))->toBeTrue();
});

test('admin cannot finalize project not in aggiudicazione state', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->finalize($admin, $project))->toBeFalse();
});

test('only admin can assign workgroup to project in compilazione', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->assignWorkgroup($admin, $project))->toBeTrue();
});

test('admin cannot assign workgroup to project not in compilazione', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::AGGIUDICAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->assignWorkgroup($admin, $project))->toBeFalse();
});

test('admin or workgroup manager can calculate incentives', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::COMPILAZIONE,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->calculateIncentives($admin, $project))->toBeTrue();
    expect($policy->calculateIncentives($manager, $project))->toBeTrue();
});

test('cannot calculate incentives for cancelled project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create([
        'stato' => ProjectStatus::CANCELLATO,
    ]);
    $policy = new ProjectPolicy;

    expect($policy->calculateIncentives($admin, $project))->toBeFalse();
});

test('user who can view can export project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->view($admin, $project))->toBeTrue();
    expect($policy->export($admin, $project))->toBeTrue();
});

test('only admin can duplicate project', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $user = User::factory()->create();
    $project = Project::factory()->create();
    $policy = new ProjectPolicy;

    expect($policy->replicate($admin, $project))->toBeTrue();
    expect($policy->replicate($user, $project))->toBeFalse();
});
