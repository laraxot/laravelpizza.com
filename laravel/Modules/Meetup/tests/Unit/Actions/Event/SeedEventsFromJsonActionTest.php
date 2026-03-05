<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Meetup\Actions\Event\SeedEventsFromJsonAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Mockery;

uses(TestCase::class, DatabaseTransactions::class);

test('it can seed events from json file', function () {
    $tempFile = tempnam(sys_get_temp_dir(), 'events_test') . '.json';
    $data = [
        [
            'title' => 'Test Seeded Event',
            'date' => 'December 15, 2026',
            'time' => '6:00 PM - 9:00 PM',
            'location' => 'Test Location',
            'description' => 'Test Description',
            'status' => 'upcoming',
            'attendees_current' => 10,
            'attendees_max' => 50,
        ]
    ];
    File::put($tempFile, json_encode($data));

    app(SeedEventsFromJsonAction::class)->execute($tempFile);

    $this->assertDatabaseHas('events', [
        'title' => 'Test Seeded Event',
        'location' => 'Test Location',
    ], 'meetup');

    unlink($tempFile);
});

test('it logs error if file does not exist', function () {
    $log = \Mockery::mock(\Psr\Log\LoggerInterface::class);
    $log->shouldReceive('error')->once()->with(\Mockery::pattern('/Event seeding failed: File not found/'));
    app()->instance('log', $log);


    app(SeedEventsFromJsonAction::class)->execute('/non/existent/file.json');
});

test('it logs warning for invalid date format', function () {
    $tempFile = tempnam(sys_get_temp_dir(), 'events_test_invalid') . '.json';
    $data = [
        [
            'title' => 'Invalid Date Event',
            'date' => 'not-a-date',
            'time' => 'not-a-time',
        ]
    ];
    File::put($tempFile, json_encode($data));

    $log = Mockery::mock(\Psr\Log\LoggerInterface::class);
    $log->shouldReceive('warning')->once()->with(Mockery::pattern('/Skipping event/'));
    app()->instance('log', $log);

    app(SeedEventsFromJsonAction::class)->execute($tempFile);

    unlink($tempFile);
});
