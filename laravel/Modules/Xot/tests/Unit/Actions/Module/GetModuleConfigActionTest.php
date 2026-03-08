<?php

declare(strict_types=1);

use Modules\Xot\Actions\Module\GetModuleConfigAction;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;

it('returns config array from module config file', function (): void {
    $tempDir = sys_get_temp_dir().'/xot_modcfg_'.uniqid('', true);
    mkdir($tempDir, 0755, true);

    $file = $tempDir.'/mail.php';
    file_put_contents($file, "<?php\nreturn ['driver' => 'smtp', 'port' => 25];\n");

    $pathAction = Mockery::mock(GetModulePathByGeneratorAction::class);
    $pathAction->shouldReceive('execute')
        ->once()
        ->with('Xot', 'config')
        ->andReturn($tempDir);

    app()->instance(GetModulePathByGeneratorAction::class, $pathAction);

    try {
        $result = app(GetModuleConfigAction::class)->execute('Xot', 'mail');
        expect($result)->toBe(['driver' => 'smtp', 'port' => 25]);
    } finally {
        @unlink($file);
        @rmdir($tempDir);
    }
});

it('throws when config file is missing', function (): void {
    $pathAction = Mockery::mock(GetModulePathByGeneratorAction::class);
    $pathAction->shouldReceive('execute')
        ->once()
        ->with('Xot', 'config')
        ->andReturn(sys_get_temp_dir().'/xot_modcfg_missing_'.uniqid('', true));

    app()->instance(GetModulePathByGeneratorAction::class, $pathAction);

    expect(fn (): array => app(GetModuleConfigAction::class)->execute('Xot', 'mail'))
        ->toThrow(Exception::class, 'Config file not found');
});

it('throws when config file does not return array', function (): void {
    $tempDir = sys_get_temp_dir().'/xot_modcfg_scalar_'.uniqid('', true);
    mkdir($tempDir, 0755, true);

    $file = $tempDir.'/mail.php';
    file_put_contents($file, "<?php\nreturn 'invalid';\n");

    $pathAction = Mockery::mock(GetModulePathByGeneratorAction::class);
    $pathAction->shouldReceive('execute')
        ->once()
        ->with('Xot', 'config')
        ->andReturn($tempDir);

    app()->instance(GetModulePathByGeneratorAction::class, $pathAction);

    try {
        expect(fn (): array => app(GetModuleConfigAction::class)->execute('Xot', 'mail'))
            ->toThrow(Exception::class, 'Config file must return an array');
    } finally {
        @unlink($file);
        @rmdir($tempDir);
    }
});
