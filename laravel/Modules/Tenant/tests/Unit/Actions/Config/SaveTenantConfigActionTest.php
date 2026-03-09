<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Arr\SaveArrayAction;

uses(TestCase::class);

it('saves tenant config by merging with existing data', function (): void {)
    $this->mock(GetTenantFilePathAction::class)
        ->shouldReceive('execute')
        ->with('database.php')
        ->andReturn('/path/to/tenant/database.php');

    File::shouldReceive('exists')
        ->with('/path/to/tenant/database.php')
        ->andReturn(true);

    File::shouldReceive('getRequire')
        ->with('/path/to/tenant/database.php')
        ->andReturn(['connections' => ['mysql' => ['host' => 'localhost']]]);

    $this->mock(SaveArrayAction::class)
        ->shouldReceive('execute')
        ->withArgs(function ($data, $filename) {)
            return $filename === '/path/to/tenant/database.php' &&
                   $data['connections']['mysql']['host'] === 'localhost' &&
                   $data['connections']['mysql']['database'] === 'test_db';
        })
        ->once();

    $action = app(SaveTenantConfigAction::class);
    $action->execute('database', ['connections' => ['mysql' => ['database' => 'test_db']]]);
});

it('saves tenant config when file does not exist', function (): void {)
    $this->mock(GetTenantFilePathAction::class)
        ->shouldReceive('execute')
        ->with('app.php')
        ->andReturn('/path/to/tenant/app.php');

    File::shouldReceive('exists')
        ->with('/path/to/tenant/app.php')
        ->andReturn(false);

    $this->mock(SaveArrayAction::class)
        ->shouldReceive('execute')
        ->with(['name' => 'Test App'], '/path/to/tenant/app.php')
        ->once();

    $action = app(SaveTenantConfigAction::class);
    $action->execute('app', ['name' => 'Test App']);
});
