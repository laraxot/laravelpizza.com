<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Meetup\Actions\Event\ImportEventsFromJsonAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

test('it can import events from single json file', function () {
    $tempFile = tempnam(sys_get_temp_dir(), 'import_test') . '.json';
    $data = [
        'events' => [
            [
                'title' => 'Import Single File',
                'date' => '2026-12-25',
                'time' => '10:00 - 12:00',
                'location' => 'Single Location',
            ]
        ]
    ];
    File::put($tempFile, json_encode($data));

    $count = app(ImportEventsFromJsonAction::class)->execute($tempFile);

    expect($count)->toBe(1);
    $this->assertDatabaseHas('events', ['title' => 'Import Single File'], 'meetup');

    unlink($tempFile);
});

test('it can import events from directory', function () {
    $tempDir = sys_get_temp_dir() . '/import_dir_' . uniqid();
    mkdir($tempDir);
    
    $eventData = [
        'title' => 'Import From Dir',
        'start_date' => '2026-06-01T10:00:00Z',
        'location' => 'Dir Location',
    ];
    File::put($tempDir . '/event1.json', json_encode($eventData));

    // We need to pass the directory as the single path because of how the action logic is structured
    // Actually, if $path is a file it imports file, if it doesn't exist it tries default module paths.
    // To test importFromDirectory, I'll mock module_path or just rely on the logic check.
    
    // Let's modify the test to simulate the directory existence check
    $action = new class extends ImportEventsFromJsonAction {
        public function testDirectory(string $dir) {
            $files = app('files');
            $log = app('log');
            return $this->importFromDirectory($dir, 'it', $files, $log);
        }
    };

    $count = $action->testDirectory($tempDir);

    expect($count)->toBe(1);
    $this->assertDatabaseHas('events', ['title' => 'Import From Dir'], 'meetup');

    File::deleteDirectory($tempDir);
});

test('it falls back to module data path when file is missing', function () {
    $count = app(ImportEventsFromJsonAction::class)->execute('/non/existent/path');
    expect($count)->toBeGreaterThan(0);
});

test('it correctly parses duration', function() {
    $action = new ImportEventsFromJsonAction();
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('duration');
    $method->setAccessible(true);

    $start = \Carbon\Carbon::parse('2026-01-01 10:00:00');
    $end = \Carbon\Carbon::parse('2026-01-01 11:30:00');

    $duration = $method->invoke($action, $start, $end);
    expect($duration)->toBe('PT90M');
});
