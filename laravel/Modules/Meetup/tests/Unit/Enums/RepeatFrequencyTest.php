<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Enums;

use Modules\Meetup\Enums\RepeatFrequency;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it has all expected cases', function () {
    expect(RepeatFrequency::DAILY->value)->toBe('P1D')
        ->and(RepeatFrequency::WEEKLY->value)->toBe('P1W')
        ->and(RepeatFrequency::BIWEEKLY->value)->toBe('P2W')
        ->and(RepeatFrequency::MONTHLY->value)->toBe('P1M')
        ->and(RepeatFrequency::YEARLY->value)->toBe('P1Y');
});

test('it can return schema org value', function () {
    expect(RepeatFrequency::WEEKLY->toSchemaOrg())->toBe('P1W');
});
