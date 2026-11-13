<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;

uses(TestCase::class)->group('no-user-db');

function interactsWithTenantModel(): InteractsWithTenantFixtureModel
{
    return new InteractsWithTenantFixtureModel;
}

function interactsWithTenantTenant(string $id): \Illuminate\Database\Eloquent\Model
{
    $tenantClass = XotData::make()->getTenantClass();
    $tenant = new $tenantClass;
    $tenant->forceFill(['id' => $id]);

    return $tenant;
}

afterEach(function (): void {
    Filament::setTenant(null, isQuiet: true);
});

describe('InteractsWithTenant', function (): void {
    test('without a current tenant the scope does not filter (management panels see everything)', function (): void {
        Filament::setTenant(null, isQuiet: true);

        expect(interactsWithTenantModel()->newQuery()->toSql())->not->toContain('tenant_id');
    });

    test('with a current tenant the scope filters on the qualified column', function (): void {
        Filament::setTenant(interactsWithTenantTenant('9b1c6f4e-tenant-uuid'), isQuiet: true);

        $query = interactsWithTenantModel()->newQuery();

        expect(str_replace(['"', '`'], '', $query->toSql()))->toContain('worksites.tenant_id')
            ->and($query->getBindings())->toBe(['9b1c6f4e-tenant-uuid']);
    });

    test('creating assigns the string key of the current tenant', function (): void {
        Filament::setTenant(interactsWithTenantTenant('9b1c6f4e-tenant-uuid'), isQuiet: true);
        $model = interactsWithTenantModel();

        Model::getEventDispatcher()?->until('eloquent.creating: '.$model::class, $model);

        expect($model->getAttribute('tenant_id'))->toBe('9b1c6f4e-tenant-uuid');
    });

    test('creating keeps an explicit tenant_id', function (): void {
        Filament::setTenant(interactsWithTenantTenant('current-tenant'), isQuiet: true);
        $model = interactsWithTenantModel();
        $model->setAttribute('tenant_id', 'explicit-tenant');

        Model::getEventDispatcher()?->until('eloquent.creating: '.$model::class, $model);

        expect($model->getAttribute('tenant_id'))->toBe('explicit-tenant');
    });

    test('tenant relation points to the configured tenant class', function (): void {
        expect(interactsWithTenantModel()->tenant()->getRelated()::class)
            ->toBe(XotData::make()->getTenantClass());
    });
});
