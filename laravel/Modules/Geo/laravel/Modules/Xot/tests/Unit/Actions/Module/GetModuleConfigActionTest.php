<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Module\GetModuleConfigAction;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

it('returns config array from module config file', function (): void {
    $tempDir = sys_get_temp_dir().'/xot_modcfg_'.uniqid('', true);
    mkdir($tempDir, 0755, true);

    $file = $tempDir.'/mail.php';
    file_put_contents($file, "<?php\nreturn ['driver' => 'smtp', 'port' => 25];\n");

    $pathAction = Mockery::mock(GetModulePathByGeneratorAction::class);
    $pathAction->allows(['execute' => $tempDir]);

    app()->instance(GetModulePathByGeneratorAction::class, $pathAction);

    try {
        $result = app(GetModuleConfigAction::class)->execute('Xot', 'mail');
        Assert::assertSame(['driver' => 'smtp', 'port' => 25], $result);
    } finally {
        unlink($file);
        rmdir($tempDir);
    }
});

it('throws when config file is missing', function (): void {
    $pathAction = Mockery::mock(GetModulePathByGeneratorAction::class);
    $pathAction->allows(['execute' => sys_get_temp_dir().'/xot_modcfg_missing_'.uniqid('', true)]);

    app()->instance(GetModulePathByGeneratorAction::class, $pathAction);

    try {
        app(GetModuleConfigAction::class)->execute('Xot', 'mail');
        Assert::fail('Expected exception was not thrown');
    } catch (Exception $e) {
        Assert::assertStringContainsString('Config file', $e->getMessage());
    }
});

it('throws when config file does not return array', function (): void {
    $tempDir = sys_get_temp_dir().'/xot_modcfg_scalar_'.uniqid('', true);
    mkdir($tempDir, 0755, true);

    $file = $tempDir.'/mail.php';
    file_put_contents($file, "<?php\nreturn 'invalid';\n");

    $pathAction = Mockery::mock(GetModulePathByGeneratorAction::class);
    $pathAction->allows(['execute' => $tempDir]);

    app()->instance(GetModulePathByGeneratorAction::class, $pathAction);

    try {
        app(GetModuleConfigAction::class)->execute('Xot', 'mail');
        Assert::fail('Expected exception was not thrown');
    } finally {
        unlink($file);
        rmdir($tempDir);
    }
});
