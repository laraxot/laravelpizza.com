<?php

declare(strict_types=1);

use Modules\Xot\Actions\Debug\MeasureAction;
use Tests\TestCase;

uses(TestCase::class);

it('returns closure result and stores notification with label', function (): void {
    session()->forget('filament.notifications');

    $result = app(MeasureAction::class)->execute(fn (): int => 42, 'Calc');

    expect($result)->toBe(42);

    $notifications = session('filament.notifications', []);
    expect($notifications)->toBeArray()->toHaveCount(1)
        ->and($notifications[0]['title'])->toContain('Performance Metrics Calc')
        ->and($notifications[0]['body'])->toContain('ms')
        ->and($notifications[0]['body'])->toContain('KB');
});

it('uses unnamed label when empty label is provided', function (): void {
    session()->forget('filament.notifications');

    app(MeasureAction::class)->execute(fn (): string => 'ok');

    $notifications = session('filament.notifications', []);
    expect($notifications)->toHaveCount(1)
        ->and($notifications[0]['title'])->toContain('Performance Metrics Unnamed');
});
