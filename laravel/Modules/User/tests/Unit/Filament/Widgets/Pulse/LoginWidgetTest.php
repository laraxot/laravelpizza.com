<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\Pulse\LoginWidget;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('pulse login widget exposes realtime and historical filters', function (): void {
    $widget = new LoginWidget;

    $method = new ReflectionMethod($widget, 'getFilters');
    $method->setAccessible(true);

    /** @var array<string, string> $filters */
    $filters = $method->invoke($widget);

    expect(array_keys($filters))->toBe([
        '1h',
        '6h',
        '24h',
        '7d',
        '30g',
        '1a',
        'all',
    ]);
});

test('pulse login widget defaults to a realtime pulse filter', function (): void {
    $widget = new LoginWidget;

    expect($widget->filter)->toBe('24h');
});
