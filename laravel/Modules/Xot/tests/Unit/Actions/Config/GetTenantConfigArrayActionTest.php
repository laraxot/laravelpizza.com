<?php

declare(strict_types=1);

use Modules\Xot\Actions\Config\GetTenantConfigArrayAction;
use Modules\Xot\Actions\Config\GetTenantConfigPathAction;

it('returns empty array when tenant config file does not exist', function (): void {
    $pathAction = Mockery::mock(GetTenantConfigPathAction::class);
    $pathAction->shouldReceive('execute')
        ->once()
        ->with('missing-config')
        ->andReturn('/tmp/does-not-exist-config.php');

    app()->instance(GetTenantConfigPathAction::class, $pathAction);

    $result = app(GetTenantConfigArrayAction::class)->execute('missing-config');

    expect($result)->toBe([]);
});

it('returns config array when file exists and contains array', function (): void {
    $path = sys_get_temp_dir().'/xot_tenant_config_'.uniqid('', true).'.php';
    file_put_contents($path, "<?php\nreturn ['driver' => 'smtp', 'port' => 25];\n");

    $pathAction = Mockery::mock(GetTenantConfigPathAction::class);
    $pathAction->shouldReceive('execute')
        ->once()
        ->with('mail')
        ->andReturn($path);

    app()->instance(GetTenantConfigPathAction::class, $pathAction);

    try {
        $result = app(GetTenantConfigArrayAction::class)->execute('mail');
        expect($result)->toBe(['driver' => 'smtp', 'port' => 25]);
    } finally {
        @unlink($path);
    }
});

it('returns empty array when required file does not return an array', function (): void {
    $path = sys_get_temp_dir().'/xot_tenant_config_scalar_'.uniqid('', true).'.php';
    file_put_contents($path, "<?php\nreturn 'not-array';\n");

    $pathAction = Mockery::mock(GetTenantConfigPathAction::class);
    $pathAction->shouldReceive('execute')
        ->once()
        ->with('scalar')
        ->andReturn($path);

    app()->instance(GetTenantConfigPathAction::class, $pathAction);

    try {
        $result = app(GetTenantConfigArrayAction::class)->execute('scalar');
        expect($result)->toBe([]);
    } finally {
        @unlink($path);
    }
});
