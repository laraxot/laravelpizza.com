<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Config;

use Modules\Xot\Actions\Config\GetTenantConfigArrayAction;
use Modules\Xot\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Mockery;

uses(TestCase::class);

it('gets tenant config array correctly', function (): void {
    $configName = 'test_config';
    $tempPath = tempnam(sys_get_temp_dir(), 'test_config_') . '.php';
    $configData = ['key' => 'value'];
    
    File::put($tempPath, '<?php return ' . var_export($configData, true) . ';');

    $this->mock(GetTenantFilePathAction::class)
        ->shouldReceive('execute')
        ->once()
        ->with($configName . '.php')
        ->andReturn($tempPath);

    $action = app(GetTenantConfigArrayAction::class);
    $result = $action->execute($configName);

    expect($result)->toBe($configData);

    File::delete($tempPath);
});

it('returns empty array if tenant config file does not exist', function (): void {
    $configName = 'non_existent';
    
    $this->mock(GetTenantFilePathAction::class)
        ->shouldReceive('execute')
        ->once()
        ->andReturn('/path/to/nothing.php');

    $action = app(GetTenantConfigArrayAction::class);
    $result = $action->execute($configName);

    expect($result)->toBe([]);
});
