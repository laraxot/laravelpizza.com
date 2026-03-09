<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Enums;

use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Enums\RepeatFrequency;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// EventStatus
// ---------------------------------------------------------------------------

describe('EventStatus enum', function () {
    test('has all expected cases', function () {
        $values = array_map(fn ($c) => $c->value, EventStatus::cases());

        expect($values)->toContain('draft')
            ->toContain('EventScheduled')
            ->toContain('EventScheduled_confirmed')
            ->toContain('EventCancelled')
            ->toContain('EventPostponed')
            ->toContain('EventRescheduled')
            ->toContain('EventMovedOnline')
            ->toContain('completed');
    });

    test('can be created from string value', function () {
        expect(EventStatus::from('draft'))->toBe(EventStatus::DRAFT)
            ->and(EventStatus::from('EventScheduled'))->toBe(EventStatus::SCHEDULED)
            ->and(EventStatus::from('EventCancelled'))->toBe(EventStatus::CANCELLED)
            ->and(EventStatus::from('EventPostponed'))->toBe(EventStatus::POSTPONED)
            ->and(EventStatus::from('EventRescheduled'))->toBe(EventStatus::RESCHEDULED)
            ->and(EventStatus::from('EventMovedOnline'))->toBe(EventStatus::MOVED_ONLINE)
            ->and(EventStatus::from('completed'))->toBe(EventStatus::COMPLETED);
    });

    test('tryFrom returns null for unknown value', function () {
        expect(EventStatus::tryFrom('nonexistent'))->toBeNull();
    });

    test('getLabel returns a string', function () {
        foreach (EventStatus::cases() as $case) {
            expect($case->getLabel())->toBeString();
        }
    });

    test('getColor returns a string', function () {
        foreach (EventStatus::cases() as $case) {
            expect($case->getColor())->toBeString();
        }
    });

    test('toSchemaOrgUri for DRAFT returns EventScheduled URI', function () {
        expect(EventStatus::DRAFT->toSchemaOrgUri())
            ->toBe('https://schema.org/EventScheduled');
    });

    test('toSchemaOrgUri for CONFIRMED maps to EventScheduled URI', function () {
        expect(EventStatus::CONFIRMED->toSchemaOrgUri())
            ->toBe('https://schema.org/EventScheduled');
    });

    test('toSchemaOrgUri for SCHEDULED returns correct URI', function () {
        expect(EventStatus::SCHEDULED->toSchemaOrgUri())
            ->toBe('https://schema.org/EventScheduled');
    });

    test('toSchemaOrgUri for CANCELLED returns correct URI', function () {
        expect(EventStatus::CANCELLED->toSchemaOrgUri())
            ->toBe('https://schema.org/EventCancelled');
    });

    test('toSchemaOrgUri for POSTPONED returns correct URI', function () {
        expect(EventStatus::POSTPONED->toSchemaOrgUri())
            ->toBe('https://schema.org/EventPostponed');
    });

    test('toSchemaOrgUri for RESCHEDULED returns correct URI', function () {
        expect(EventStatus::RESCHEDULED->toSchemaOrgUri())
            ->toBe('https://schema.org/EventRescheduled');
    });

    test('toSchemaOrgUri for MOVED_ONLINE returns correct URI', function () {
        expect(EventStatus::MOVED_ONLINE->toSchemaOrgUri())
            ->toBe('https://schema.org/EventMovedOnline');
    });

    test('toSchemaOrgUri always starts with https://schema.org/', function () {
        foreach (EventStatus::cases() as $case) {
            expect($case->toSchemaOrgUri())->toStartWith('https://schema.org/');
        }
    });

    test('getSearchable returns array of string values', function () {
        $searchable = EventStatus::getSearchable();

        expect($searchable)->toBeArray()
            ->and($searchable)->toContain('draft')
            ->and($searchable)->toContain('EventScheduled')
            ->and($searchable)->toContain('EventCancelled');
    });

    test('cases() returns all 8 cases', function () {
        expect(EventStatus::cases())->toHaveCount(8);
    });
});

// ---------------------------------------------------------------------------
// EventAttendanceMode
// ---------------------------------------------------------------------------

describe('EventAttendanceMode enum', function () {
    test('has all expected cases', function () {
        $values = array_map(fn ($c) => $c->value, EventAttendanceMode::cases());

        expect($values)->toContain('OfflineEventAttendanceMode')
            ->toContain('OnlineEventAttendanceMode')
            ->toContain('MixedEventAttendanceMode');
    });

    test('can be created from string value', function () {
        expect(EventAttendanceMode::from('OfflineEventAttendanceMode'))->toBe(EventAttendanceMode::OFFLINE)
            ->and(EventAttendanceMode::from('OnlineEventAttendanceMode'))->toBe(EventAttendanceMode::ONLINE)
            ->and(EventAttendanceMode::from('MixedEventAttendanceMode'))->toBe(EventAttendanceMode::MIXED);
    });

    test('tryFrom returns null for unknown value', function () {
        expect(EventAttendanceMode::tryFrom('Unknown'))->toBeNull();
    });

    test('label method returns human-readable string for OFFLINE', function () {
        expect(EventAttendanceMode::OFFLINE->label())->toBe('In Person');
    });

    test('label method returns human-readable string for ONLINE', function () {
        expect(EventAttendanceMode::ONLINE->label())->toBe('Online');
    });

    test('label method returns human-readable string for MIXED', function () {
        expect(EventAttendanceMode::MIXED->label())->toBe('Hybrid');
    });

    test('getLabel returns a string for all cases', function () {
        foreach (EventAttendanceMode::cases() as $case) {
            expect($case->getLabel())->toBeString();
        }
    });

    test('getColor returns a string for all cases', function () {
        foreach (EventAttendanceMode::cases() as $case) {
            expect($case->getColor())->toBeString();
        }
    });

    test('getIcon returns a string for all cases', function () {
        foreach (EventAttendanceMode::cases() as $case) {
            expect($case->getIcon())->toBeString();
        }
    });

    test('toSchemaOrgUri returns correct URI for OFFLINE', function () {
        expect(EventAttendanceMode::OFFLINE->toSchemaOrgUri())
            ->toBe('https://schema.org/OfflineEventAttendanceMode');
    });

    test('toSchemaOrgUri returns correct URI for ONLINE', function () {
        expect(EventAttendanceMode::ONLINE->toSchemaOrgUri())
            ->toBe('https://schema.org/OnlineEventAttendanceMode');
    });

    test('toSchemaOrgUri returns correct URI for MIXED', function () {
        expect(EventAttendanceMode::MIXED->toSchemaOrgUri())
            ->toBe('https://schema.org/MixedEventAttendanceMode');
    });

    test('toSchemaOrgUri always starts with https://schema.org/', function () {
        foreach (EventAttendanceMode::cases() as $case) {
            expect($case->toSchemaOrgUri())->toStartWith('https://schema.org/');
        }
    });

    test('getSearchable returns array of all values', function () {
        $searchable = EventAttendanceMode::getSearchable();

        expect($searchable)->toBeArray()->toHaveCount(3)
            ->toContain('OfflineEventAttendanceMode')
            ->toContain('OnlineEventAttendanceMode')
            ->toContain('MixedEventAttendanceMode');
    });

    test('cases() returns exactly 3 cases', function () {
        expect(EventAttendanceMode::cases())->toHaveCount(3);
    });
});

// ---------------------------------------------------------------------------
// RepeatFrequency
// ---------------------------------------------------------------------------

describe('RepeatFrequency enum', function () {
    test('has all expected cases', function () {
        $values = array_map(fn ($c) => $c->value, RepeatFrequency::cases());

        expect($values)->toContain('P1D')
            ->toContain('P1W')
            ->toContain('P2W')
            ->toContain('P1M')
            ->toContain('P1Y');
    });

    test('can be created from string value', function () {
        expect(RepeatFrequency::from('P1D'))->toBe(RepeatFrequency::DAILY)
            ->and(RepeatFrequency::from('P1W'))->toBe(RepeatFrequency::WEEKLY)
            ->and(RepeatFrequency::from('P2W'))->toBe(RepeatFrequency::BIWEEKLY)
            ->and(RepeatFrequency::from('P1M'))->toBe(RepeatFrequency::MONTHLY)
            ->and(RepeatFrequency::from('P1Y'))->toBe(RepeatFrequency::YEARLY);
    });

    test('tryFrom returns null for unknown value', function () {
        expect(RepeatFrequency::tryFrom('P99Z'))->toBeNull();
    });

    test('toSchemaOrg returns ISO 8601 duration string for DAILY', function () {
        expect(RepeatFrequency::DAILY->toSchemaOrg())->toBe('P1D');
    });

    test('toSchemaOrg returns ISO 8601 duration string for WEEKLY', function () {
        expect(RepeatFrequency::WEEKLY->toSchemaOrg())->toBe('P1W');
    });

    test('toSchemaOrg returns ISO 8601 duration string for BIWEEKLY', function () {
        expect(RepeatFrequency::BIWEEKLY->toSchemaOrg())->toBe('P2W');
    });

    test('toSchemaOrg returns ISO 8601 duration string for MONTHLY', function () {
        expect(RepeatFrequency::MONTHLY->toSchemaOrg())->toBe('P1M');
    });

    test('toSchemaOrg returns ISO 8601 duration string for YEARLY', function () {
        expect(RepeatFrequency::YEARLY->toSchemaOrg())->toBe('P1Y');
    });

    test('toSchemaOrg returns the enum value itself', function () {
        foreach (RepeatFrequency::cases() as $case) {
            expect($case->toSchemaOrg())->toBe($case->value);
        }
    });

    test('getLabel returns a string for all cases', function () {
        foreach (RepeatFrequency::cases() as $case) {
            expect($case->getLabel())->toBeString();
        }
    });

    test('getColor returns a string for all cases', function () {
        foreach (RepeatFrequency::cases() as $case) {
            expect($case->getColor())->toBeString();
        }
    });

    test('getSearchable returns all ISO 8601 values', function () {
        $searchable = RepeatFrequency::getSearchable();

        expect($searchable)->toBeArray()->toHaveCount(5)
            ->toContain('P1D')
            ->toContain('P1W')
            ->toContain('P2W')
            ->toContain('P1M')
            ->toContain('P1Y');
    });

    test('cases() returns exactly 5 cases', function () {
        expect(RepeatFrequency::cases())->toHaveCount(5);
    });
});
