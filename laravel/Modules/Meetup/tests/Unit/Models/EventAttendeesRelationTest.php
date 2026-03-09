<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('event attendees relation uses belongstomanyx contract', function (): void {
    $relation = (new Event())->attendees();

    expect($relation)->toBeInstanceOf(BelongsToMany::class)
        ->and(Str::endsWith($relation->getTable(), 'event_user'))->toBeTrue()
        ->and($relation->getPivotClass())->toBe(EventUser::class)
        ->and($relation->getPivotColumns())->toContain('event_id', 'user_id');
});
