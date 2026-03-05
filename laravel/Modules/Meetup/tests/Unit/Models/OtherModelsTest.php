<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\EventPerformer;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Sponsor;
use Modules\Meetup\Models\Venue;
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
        'performer_id' => 'performer-user-id',
    ]);

    expect($performer->getTable())->toBe('event_performer')
        ->and($performer->event_id)->toBe(456)
        ->and($performer->getFillable())->toContain('performer_id')
        ->and($performer->getCasts())->toHaveKey('sort_order');
});

test('event sponsor model works', function () {
    $sponsor = new EventSponsor([
        'event_id' => 789,
        'sponsor_id' => 'sponsor-user-id',
    ]);

    expect($sponsor->getTable())->toBe('event_sponsor')
        ->and($sponsor->event_id)->toBe(789)
        ->and($sponsor->getFillable())->toContain('sponsor_id');
});

test('event user model status constants and casts are defined', function () {
    $eventUser = new EventUser();

    expect(EventUser::STATUS_ATTENDING)->toBe('attending')
        ->and(EventUser::STATUS_WAITLISTED)->toBe('waitlisted')
        ->and(EventUser::STATUS_CANCELLED)->toBe('cancelled')
        ->and($eventUser->getCasts())->toHaveKey('status')
        ->and($eventUser->getCasts()['status'])->toBe('string');
});

test('performer model exposes relation and scope', function () {
    $performer = new Performer();
    $relation = $performer->events();
    $query = Performer::query();

    expect($performer->getConnectionName())->toBe('meetup')
        ->and($performer->getCasts())->toHaveKey('meta_data')
        ->and($relation->getTable())->toBe('event_performer')
        ->and($performer->scopeByType($query, 'speaker')->toSql())->toContain('where');
});

test('sponsor model exposes events relation', function () {
    $sponsor = new Sponsor();
    $relation = $sponsor->events();

    expect($sponsor->getConnectionName())->toBe('meetup')
        ->and($sponsor->getCasts())->toHaveKey('meta_data')
        ->and($relation->getTable())->toBe('event_sponsor');
});

test('venue model casts and events relation are configured', function () {
    $venue = new Venue();
    $relation = $venue->events();

    expect($venue->getConnectionName())->toBe('meetup')
        ->and($venue->getCasts())->toHaveKey('latitude')
        ->and($venue->getCasts())->toHaveKey('longitude')
        ->and($venue->getCasts())->toHaveKey('capacity')
        ->and($relation->getRelated()::class)->toBe(\Modules\Meetup\Models\Event::class);
});
