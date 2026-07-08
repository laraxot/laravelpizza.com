<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets tenant config path', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    $result = app(GetTenantConfigPathAction::class)->execute('database');

    Assert::assertSame('test-tenant.database', $result);
});

it('gets tenant config path with forward slashes replaced', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'tenants/test']);
    });

    $result = app(GetTenantConfigPathAction::class)->execute('app');

    Assert::assertSame('tenants.test.app', $result);
});
