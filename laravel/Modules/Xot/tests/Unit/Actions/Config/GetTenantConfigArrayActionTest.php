<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Config;

use Modules\Xot\Actions\Config\GetTenantConfigArrayAction;
use Modules\Xot\Actions\Config\GetTenantConfigPathAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class);

it('returns empty array when tenant config file does not exist', function (): void {
    $pathAction = $this->createUnitMock(GetTenantConfigPathAction::class);
    $pathAction->method('execute')
        ->with('missing-config')
        ->willReturn('/tmp/does-not-exist-config.php');

    app()->instance(GetTenantConfigPathAction::class, $pathAction);

    $result = app(GetTenantConfigArrayAction::class)->execute('missing-config');

    Assert::assertSame([], $result);
});

it('returns config array when file exists and contains array', function (): void {
    $path = sys_get_temp_dir().'/xot_tenant_config_'.uniqid('', true).'.php';
    file_put_contents($path, "<?php\nreturn ['driver' => 'smtp', 'port' => 25];\n");

    $pathAction = $this->createUnitMock(GetTenantConfigPathAction::class);
    $pathAction->method('execute')
        ->with('mail')
        ->willReturn($path);

    app()->instance(GetTenantConfigPathAction::class, $pathAction);

    try {
        $result = app(GetTenantConfigArrayAction::class)->execute('mail');
        Assert::assertSame(['driver' => 'smtp', 'port' => 25], $result);
    } finally {
        @unlink($path);
    }
});

it('returns empty array when required file does not return an array', function (): void {
    $path = sys_get_temp_dir().'/xot_tenant_config_scalar_'.uniqid('', true).'.php';
    file_put_contents($path, "<?php\nreturn 'not-array';\n");

    $pathAction = $this->createUnitMock(GetTenantConfigPathAction::class);
    $pathAction->method('execute')
        ->with('scalar')
        ->willReturn($path);

    app()->instance(GetTenantConfigPathAction::class, $pathAction);

    try {
        $result = app(GetTenantConfigArrayAction::class)->execute('scalar');
        Assert::assertSame([], $result);
    } finally {
        @unlink($path);
    }
});
