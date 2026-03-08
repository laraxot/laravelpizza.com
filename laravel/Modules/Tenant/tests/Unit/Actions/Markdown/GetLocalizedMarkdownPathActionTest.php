<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Markdown;

use Illuminate\Support\Facades\App;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Markdown\GetLocalizedMarkdownPathAction;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

it('gets localized markdown path if it exists', function (): void {
    App::setLocale('it');

    // Create a temporary file to simulate existence
    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir.'/test.md';
    file_put_contents($tempFile, 'test');

    $this->mock(GetTenantFilePathAction::class
        ->shouldReceive('execute')
        ->with('lang/it/test.md')
        ->andReturn($tempFile)
        ->shouldReceive('execute')
        ->with('test.md')
        ->andReturn('/non/existent/path.md');

    $action = app(GetLocalizedMarkdownPathAction::class);
    $result = $action->execute('test.md');

    expect($result)->toBe($tempFile);

    unlink($tempFile);
});

it('gets fallback markdown path if localized does not exist', function (): void {
    App::setLocale('it');

    // Create a temporary file to simulate existence
    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir.'/fallback.md';
    file_put_contents($tempFile, 'test');

    $this->mock(GetTenantFilePathAction::class
        ->shouldReceive('execute')
        ->with('lang/it/fallback.md')
        ->andReturn('/non/existent/path.md')
        ->shouldReceive('execute')
        ->with('fallback.md')
        ->andReturn($tempFile);

    $action = app(GetLocalizedMarkdownPathAction::class);
    $result = $action->execute('fallback.md');

    expect($result)->toBe($tempFile);

    unlink($tempFile);
});

it('returns hash if no path exists', function (): void {
    $this->mock(GetTenantFilePathAction::class
        ->shouldReceive('execute')
        ->andReturn('/non/existent/path.md');

    $action = app(GetLocalizedMarkdownPathAction::class);
    $result = $action->execute('none.md');

    expect($result)->toBe('#');
});
