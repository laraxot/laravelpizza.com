<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

// Activity stored-event business tests (part 2) — claude-audit doc ratio.

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('can restore event from stored event', function (): void {
    $originalProperties = [
        'user_id' => 789,
        'action' => 'profile_update',
        'changes' => [
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'phone' => '+1987654321',
        ],
        'timestamp' => now()->toISOString(),
    ];

    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 8,
        'event_version' => 4,
        'event_class' => 'App\Events\ProfileUpdated',
        'event_properties' => $originalProperties,
        'meta_data' => [
            'source' => 'api',
            'request_id' => Str::uuid()->toString(),
        ],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $restoredProperties = $storedEvent->event_properties;
    Assert::assertIsArray($restoredProperties);
    Assert::assertSame($originalProperties, $restoredProperties);
});

test('can compare event versions', function (): void {
    $uuid = Str::uuid()->toString();

    $event1 = StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\VersionedEvent',
        'event_properties' => ['version' => 1, 'data' => 'Initial data'],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $event1);

    $event2 = StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 2,
        'event_version' => 2,
        'event_class' => 'App\Events\VersionedEvent',
        'event_properties' => ['version' => 2, 'data' => 'Updated data'],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $event2);

    $event3 = StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 3,
        'event_version' => 3,
        'event_class' => 'App\Events\VersionedEvent',
        'event_properties' => ['version' => 3, 'data' => 'Final data'],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $event3);

    Assert::assertLessThan($event2->aggregate_version, $event1->aggregate_version);
    Assert::assertLessThan($event3->aggregate_version, $event2->aggregate_version);

    Assert::assertLessThan($event2->event_version, $event1->event_version);
    Assert::assertLessThan($event3->event_version, $event2->event_version);

    /** @var array<string, mixed> $e1Props */
    $e1Props = $event1->event_properties;
    /** @var array<string, mixed> $e2Props */
    $e2Props = $event2->event_properties;
    /** @var array<string, mixed> $e3Props */
    $e3Props = $event3->event_properties;

    Assert::assertSame(1, $e1Props['version']);
    Assert::assertSame(2, $e2Props['version']);
    Assert::assertSame(3, $e3Props['version']);

    Assert::assertSame('Initial data', $e1Props['data']);
    Assert::assertSame('Updated data', $e2Props['data']);
    Assert::assertSame('Final data', $e3Props['data']);
});

test('can handle event with timestamps', function (): void {
    $now = now();

    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\TimestampedEvent',
        'event_properties' => ['created_at' => $now->toISOString()],
        'meta_data' => [],
        'created_at' => $now,
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('created_at', $now->toDateTimeString())
        ->exists();
    Assert::assertTrue($exists);

    $createdAt = Carbon::parse((string) $storedEvent->created_at);
    Assert::assertSame($now->timestamp, $createdAt->timestamp);
});

test('can query events by date range', function (): void {
    $yesterday = now()->subDay();
    $today = now();
    $tomorrow = now()->addDay();

    $yesterdayEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\DateTestEvent',
        'event_properties' => ['date' => 'yesterday'],
        'meta_data' => [],
        'created_at' => $yesterday,
    ]);

    $todayEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\DateTestEvent',
        'event_properties' => ['date' => 'today'],
        'meta_data' => [],
        'created_at' => $today,
    ]);

    $tomorrowEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\DateTestEvent',
        'event_properties' => ['date' => 'tomorrow'],
        'meta_data' => [],
        'created_at' => $tomorrow,
    ]);

    $eventIds = [$yesterdayEvent->id, $todayEvent->id, $tomorrowEvent->id];
    $todayEvents = StoredEvent::whereKey($eventIds)->whereDate('created_at', today())->get();
    Assert::assertCount(1, $todayEvents);
    $todayFirst = $todayEvents->first();
    Assert::assertNotNull($todayFirst);
    Assert::assertInstanceOf(StoredEvent::class, $todayFirst);
    /** @var array<string, mixed> $todayProps */
    $todayProps = $todayFirst->event_properties;
    Assert::assertIsArray($todayProps);
    Assert::assertSame('today', $todayProps['date']);

    $recentEvents = StoredEvent::whereKey($eventIds)->whereBetween('created_at', [$yesterday, $today->endOfDay()])->get();
    Assert::assertCount(2, $recentEvents);
});

test('can handle event with metadata', function (): void {
    $metadata = [
        'source' => 'web_interface',
        'user_id' => 1010,
        'action' => 'bulk_import',
        'timestamp' => now()->toISOString(),
        'ip_address' => '192.168.1.150',
        'user_agent' => 'Chrome/91.0.4472.124',
        'session_id' => Str::random(40),
        'request_id' => Str::uuid()->toString(),
        'processing_time' => 2.5,
        'records_processed' => 1500,
    ];

    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\BulkImportCompleted',
        'event_properties' => [
            'import_id' => 'IMP-98765',
            'status' => 'completed',
            'total_records' => 1500,
            'successful_records' => 1485,
            'failed_records' => 15,
            'errors' => [
                'duplicate_emails' => 10,
                'invalid_format' => 5,
            ],
        ],
        'meta_data' => $metadata,
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\BulkImportCompleted')
        ->exists();
    Assert::assertTrue($exists);

    /** @var array<string, mixed> $properties */
    $properties = $storedEvent->event_properties;
    Assert::assertSame('IMP-98765', $properties['import_id']);
    Assert::assertSame('completed', $properties['status']);
    Assert::assertSame(1500, $properties['total_records']);
    Assert::assertSame(1485, $properties['successful_records']);
    Assert::assertSame(15, $properties['failed_records']);

    $metaAttributes = $storedEvent->meta_data;
    /** @var array<string, mixed> $meta */
    $meta = method_exists($metaAttributes, 'toArray') ? $metaAttributes->toArray() : [];
    Assert::assertIsArray($meta);
    Assert::assertSame('web_interface', $meta['source']);
    Assert::assertSame(1010, $meta['user_id']);
    Assert::assertSame('bulk_import', $meta['action']);
    Assert::assertSame(2.5, $meta['processing_time']);
    Assert::assertSame(1500, $meta['records_processed']);
});
