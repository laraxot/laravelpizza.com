<?php

declare(strict_types=1);
use Modules\Activity\Enums\LogLevelEnum;
use Tests\TestCase;

uses(TestCase::class);

it('lists the Monolog levels from the most to the least severe', function (): void {
    expect(array_map(fn (LogLevelEnum $level): string => $level->value, LogLevelEnum::cases()))
        ->toBe(['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'NOTICE', 'INFO', 'DEBUG']);
});

it('gives every level a label and a badge color from the lang file', function (): void {
    $colors = [];
    foreach (LogLevelEnum::cases() as $level) {
        expect($level->getLabel())->toBe($level->value);
        $colors[$level->value] = $level->getColor();
    }

    expect($colors)->toBe([
        'EMERGENCY' => 'danger',
        'ALERT' => 'danger',
        'CRITICAL' => 'danger',
        'ERROR' => 'danger',
        'WARNING' => 'warning',
        'NOTICE' => 'info',
        'INFO' => 'info',
        'DEBUG' => 'gray',
    ]);
});

it('does not know a level that Monolog does not write', function (string $name): void {
    expect(LogLevelEnum::tryFrom($name))->toBeNull();
})->with(['INVENTATO', 'error', '']);
