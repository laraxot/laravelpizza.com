<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Markdown;

use Illuminate\Support\Facades\App;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Markdown\GetLocalizedMarkdownPathAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class);

it('gets localized markdown path if it exists', function (): void {
    App::setLocale('it');

    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir.'/test.md';
    file_put_contents($tempFile, 'test');

    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($tempFile): void {
        TestCase::expectMockery($mock, 'execute')
            ->andReturnUsing(static function (string $path) use ($tempFile): string {
                return $path === 'lang/it/test.md' ? $tempFile : '/non/existent/path.md';
            });
    });

    $result = app(GetLocalizedMarkdownPathAction::class)->execute('test.md');

    Assert::assertSame($tempFile, $result);

    unlink($tempFile);
});

it('gets fallback markdown path if localized does not exist', function (): void {
    App::setLocale('it');

    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir.'/fallback.md';
    file_put_contents($tempFile, 'test');

    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($tempFile): void {
        TestCase::expectMockery($mock, 'execute')
            ->andReturnUsing(static function (string $path) use ($tempFile): string {
                return $path === 'fallback.md' ? $tempFile : '/non/existent/path.md';
            });
    });

    $result = app(GetLocalizedMarkdownPathAction::class)->execute('fallback.md');

    Assert::assertSame($tempFile, $result);

    unlink($tempFile);
});

it('returns hash if no path exists', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/non/existent/path.md']);
    });

    $result = app(GetLocalizedMarkdownPathAction::class)->execute('none.md');

    Assert::assertSame('#', $result);
});
