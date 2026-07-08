<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Feature\Filament;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Filament\Resources\ActivityResource;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource;
use Modules\Incentivi\Filament\Resources\EmployeeResource;
use Modules\Incentivi\Filament\Resources\PhaseResource;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\SettlementResource;
use Modules\Incentivi\Filament\Resources\StabiDirigenteResource;
use Modules\Incentivi\Filament\Resources\WorkgroupResource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Enums\ProjectStatus;
use Modules\Incentivi\Enums\AmbitoIncentivo;

uses(TestCase::class);

it('all key incentive resources extend xot base resource', function (string $resourceClass): void {
    expect(is_subclass_of($resourceClass, XotBaseResource::class))->toBeTrue();
})->with([
    ActivityResource::class,
    CapitalPercentageResource::class,
    DefaultActivityResource::class,
    EmployeeResource::class,
    PhaseResource::class,
    ProjectResource::class,
    SettlementResource::class,
    StabiDirigenteResource::class,
    WorkgroupResource::class,
]);

it('core incentive resources expose expected page map keys', function (): void {
    expect(ActivityResource::getPages())->toHaveKeys(['index', 'create', 'edit'])
        ->and(ProjectResource::getPages())->toHaveKeys(['index', 'create', 'edit'])
        ->and(SettlementResource::getPages())->toHaveKeys(['index', 'create', 'edit']);
});

it('project resource has correct model', function (): void {
    expect(ProjectResource::getModel())->toBe(Project::class);
});

it('activity resource has correct model', function (): void {
    expect(ActivityResource::getModel())->toBe(Activity::class);
});

it('project resource has form schema', function (): void {
    $schema = ProjectResource::getFormSchema();
    expect($schema)->toBeArray()->not->toBeEmpty();
});

it('activity resource has form schema', function (): void {
    $schema = ActivityResource::getFormSchema();
    expect($schema)->toBeArray()->not->toBeEmpty();
});

it('project resource can be instantiated', function (): void {
    $resource = new ProjectResource();
    expect($resource)->toBeInstanceOf(ProjectResource::class);
});

it('activity resource can be instantiated', function (): void {
    $resource = new ActivityResource();
    expect($resource)->toBeInstanceOf(ActivityResource::class);
});

it('project has navigation sort order', function (): void {
    expect(ProjectResource::getNavigationSort())->toBeInt();
});

it('employee resource has correct model', function (): void {
    expect(EmployeeResource::getModel())->toBe(Employee::class);
});
