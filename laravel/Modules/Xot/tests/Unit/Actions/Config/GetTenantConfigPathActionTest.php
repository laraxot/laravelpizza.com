<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Config;

use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Xot\Actions\Config\GetTenantConfigPathAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Get Tenant Config Path Action', function (): void {
    test('delegates to tenant file path action with php filename', function (): void {
        /** @var GetTenantFilePathAction&MockInterface $tenantPathAction */
        $tenantPathAction = Mockery::mock(GetTenantFilePathAction::class);
        $tenantPathAction->shouldReceive('execute')
            ->with('mail.php')
            ->andReturn('/tmp/tenant/mail.php');

        app()->instance(GetTenantFilePathAction::class, $tenantPathAction);

        $result = app(GetTenantConfigPathAction::class)->execute('mail');

        Assert::assertSame('/tmp/tenant/mail.php', $result);
    });
});
