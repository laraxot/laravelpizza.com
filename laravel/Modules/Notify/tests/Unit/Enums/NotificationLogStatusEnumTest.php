<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\NotificationLogStatusEnum;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('it exposes all expected statuses', function () {
    $values = array_map(static fn (NotificationLogStatusEnum $case): string => $case->value, NotificationLogStatusEnum::cases());

    expect($values)->toBe([
        'pending',
        'sent',
        'delivered',
        'failed',
        'opened',
        'clicked',
    ]);
});

test('it returns expected label color and icon', function () {
    expect(NotificationLogStatusEnum::PENDING->label())->toBe('In attesa')
        ->and(NotificationLogStatusEnum::PENDING->color())->toBe('gray')
        ->and(NotificationLogStatusEnum::PENDING->icon())->toBe('heroicon-o-clock')
        ->and(NotificationLogStatusEnum::FAILED->label())->toBe('Fallito')
        ->and(NotificationLogStatusEnum::FAILED->color())->toBe('red')
        ->and(NotificationLogStatusEnum::FAILED->icon())->toBe('heroicon-o-x-circle');
});

test('it reports completed pending and failed states correctly', function () {
    expect(NotificationLogStatusEnum::DELIVERED->isCompleted())->toBeTrue()
        ->and(NotificationLogStatusEnum::OPENED->isCompleted())->toBeTrue()
        ->and(NotificationLogStatusEnum::CLICKED->isCompleted())->toBeTrue()
        ->and(NotificationLogStatusEnum::SENT->isCompleted())->toBeFalse()
        ->and(NotificationLogStatusEnum::PENDING->isPending())->toBeTrue()
        ->and(NotificationLogStatusEnum::FAILED->isFailed())->toBeTrue();
});
