<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models\Policies;

use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Policies\EmployeePolicy;
use Modules\User\Models\User;
use Modules\Incentivi\Tests\TestCase;

uses(TestCase::class);

test('any user can view any employees', function () {
    $user = User::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->viewAny($user))->toBeTrue();
});

test('incentivi admin can view employee', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->view($admin, $employee))->toBeTrue();
});

test('hr manager can view employee', function () {
    $hrManager = User::factory()->create();
    $hrManager->addRole('hr-manager');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->view($hrManager, $employee))->toBeTrue();
});

test('super admin can view employee', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->addRole('super-admin');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->view($superAdmin, $employee))->toBeTrue();
});

test('employee can view their own data', function () {
    $employee = Employee::factory()->create();

    $policy = new EmployeePolicy;

    expect($policy->view($employee, $employee))->toBeTrue();
});

test('regular user cannot view other employee data', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();

    $policy = new EmployeePolicy;

    expect($policy->view($user, $employee))->toBeFalse();
});

test('admin or hr can create employees', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $hrManager = User::factory()->create();
    $hrManager->addRole('hr-manager');

    $policy = new EmployeePolicy;

    expect($policy->create($admin))->toBeTrue();
    expect($policy->create($hrManager))->toBeTrue();
});

test('regular user cannot create employees', function () {
    $user = User::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->create($user))->toBeFalse();
});

test('any user can update employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->update($user, $employee))->toBeTrue();
});

test('only admin can delete employee', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->delete($admin, $employee))->toBeTrue();
    expect($policy->delete($user, $employee))->toBeFalse();
});

test('admin or hr can view employee incentives', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $hrManager = User::factory()->create();
    $hrManager->addRole('hr-manager');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->viewIncentives($admin, $employee))->toBeTrue();
    expect($policy->viewIncentives($hrManager, $employee))->toBeTrue();
});

test('employee can view their own incentives', function () {
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->viewIncentives($employee, $employee))->toBeTrue();
});

test('regular user cannot view other employee incentives', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->viewIncentives($user, $employee))->toBeFalse();
});

test('admin or workgroup manager can assign employee to activity', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $manager = User::factory()->create();
    $manager->addRole('workgroup-manager');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->assignToActivity($admin, $employee))->toBeTrue();
    expect($policy->assignToActivity($manager, $employee))->toBeTrue();
});

test('regular user cannot assign employee to activity', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->assignToActivity($user, $employee))->toBeFalse();
});

test('admin or hr can deactivate employee', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $hrManager = User::factory()->create();
    $hrManager->addRole('hr-manager');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->deactivate($admin, $employee))->toBeTrue();
    expect($policy->deactivate($hrManager, $employee))->toBeTrue();
});

test('regular user cannot deactivate employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->deactivate($user, $employee))->toBeFalse();
});

test('admin or hr can activate employee', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $hrManager = User::factory()->create();
    $hrManager->addRole('hr-manager');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->activate($admin, $employee))->toBeTrue();
    expect($policy->activate($hrManager, $employee))->toBeTrue();
});

test('regular user cannot activate employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->activate($user, $employee))->toBeFalse();
});

test('export permission follows view permission', function () {
    $admin = User::factory()->create();
    $admin->addRole('incentivi-admin');

    $employee = Employee::factory()->create();
    $policy = new EmployeePolicy;

    expect($policy->view($admin, $employee))->toBeTrue();
    expect($policy->export($admin, $employee))->toBeTrue();
});
