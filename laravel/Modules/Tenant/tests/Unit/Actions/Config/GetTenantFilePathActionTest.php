<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

it('gets tenant file path', function (): void {
    $this->mock(GetTenantNameAction::class
        ->shouldReceive('execute')
        ->andReturn('test-tenant');

    $action = app(GetTenantFilePathAction::class);
    $result = $action->execute('database.php');

    $expected = base_path('config/test-tenant/database.php');
    $expected = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $expected);

    expect($result)->toBe($expected);
});
