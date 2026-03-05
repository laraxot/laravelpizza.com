<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\EventPerformer;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('event user model works', function () {
    $eventUser = new EventUser([
        'user_id' => 'user-id',
        'event_id' => 123,
    ]);

    expect($eventUser->getTable())->toBe('event_user')
        ->and($eventUser->user_id)->toBe('user-id')
        ->and($eventUser->event_id)->toBe(123);
});

test('event performer model works', function () {
    $performer = new EventPerformer([
        'event_id' => 456,
        'user_id' => 'performer-user-id',
    ]);

    expect($performer->getTable())->toBe('event_performer')
        ->and($performer->event_id)->toBe(456);
});

test('event sponsor model works', function () {
    $sponsor = new EventSponsor([
        'event_id' => 789,
        'user_id' => 'sponsor-user-id',
    ]);

    expect($sponsor->getTable())->toBe('event_sponsor')
        ->and($sponsor->event_id)->toBe(789);
});
