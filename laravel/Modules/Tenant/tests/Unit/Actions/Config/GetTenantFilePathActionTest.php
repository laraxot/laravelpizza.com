<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

it('gets tenant file path', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    $result = app(GetTenantFilePathAction::class)->execute('database.php');

    $expected = base_path('config/test-tenant/database.php');
    $expected = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $expected);

    Assert::assertSame($expected, $result);
});

it('keeps JSON content written by tests out of the versioned tenant config', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    $result = app(GetTenantFilePathAction::class)->execute('database/content/pages/1.json');

    Assert::assertSame(storage_path('framework/testing/tenant-content/test-tenant/database/content/pages/1.json'), $result);
});

it('rejects traversal and absolute paths', function (): void {
    $action = app(GetTenantFilePathAction::class);

    expect(fn () => $action->execute('../secrets.php'))->toThrow(\InvalidArgumentException::class)
        ->and(fn () => $action->execute('/etc/passwd'))->toThrow(\InvalidArgumentException::class);
});
