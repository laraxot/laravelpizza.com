<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Services;

use Illuminate\Support\Facades\Config;
use Modules\Xot\Services\ThemeService;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('sets and gets theme', function (): void {
    ThemeService::setTheme('test-theme');
    expect(ThemeService::getTheme())->toBe('test-theme')
        ->and(Config::get('theme.active'))->toBe('test-theme');
});

it('checks if theme is active', function (): void {
    ThemeService::setTheme('active-theme');
    expect(ThemeService::isTheme('active-theme'))->toBeTrue()
        ->and(ThemeService::isTheme('other-theme'))->toBeFalse();
});

it('gets theme path', function (): void {
    ThemeService::setTheme('my-path-theme');
    $path = ThemeService::getThemePath();
    expect($path)->toBe(resource_path('themes/my-path-theme'));
});
