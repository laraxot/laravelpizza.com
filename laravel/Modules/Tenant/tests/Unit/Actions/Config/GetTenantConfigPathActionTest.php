<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

it('gets tenant config path', function (): void {
    $this->mock(GetTenantNameAction::class
        ->shouldReceive('execute')
        ->andReturn('test-tenant');

    $action = app(GetTenantConfigPathAction::class);
    $result = $action->execute('database');

    expect($result)->toBe('test-tenant.database');
});

it('gets tenant config path with forward slashes replaced', function (): void {
    $this->mock(GetTenantNameAction::class
        ->shouldReceive('execute')
        ->andReturn('tenants/test');

    $action = app(GetTenantConfigPathAction::class);
    $result = $action->execute('app');

    expect($result)->toBe('tenants.test.app');
});
