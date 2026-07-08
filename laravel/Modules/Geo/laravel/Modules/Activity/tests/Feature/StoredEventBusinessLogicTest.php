<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\SchemalessAttributes\SchemalessAttributes;

uses(\Modules\Activity\Tests\TestCase::class);

test('can create stored event with basic information', function (): void {
    $eventData = [
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\UserCreated',
        'event_properties' => [
            'user_id' => 123,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ],
        'meta_data' => [
            'source' => 'web_registration',
            'ip_address' => '192.168.1.1',
        ],
        'created_at' => now(),
    ];

    $storedEvent = StoredEvent::create($eventData);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('aggregate_uuid', $eventData['aggregate_uuid'])
        ->where('aggregate_version', 1)
        ->where('event_version', 1)
        ->where('event_class', 'App\\Events\\UserCreated')
        ->exists();
    Assert::assertTrue($exists);

    Assert::assertSame(1, $storedEvent->aggregate_version);
    Assert::assertSame(1, $storedEvent->event_version);
    Assert::assertSame('App\\Events\\UserCreated', $storedEvent->event_class);
});

test('can create stored event with complex properties', function (): void {
    $complexProperties = [
        'order_data' => [
            'order_id' => 'ORD-12345',
            'customer' => [
                'id' => 456,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567890',
            ],
            'items' => [
                [
                    'product_id' => 789,
                    'name' => 'Product A',
                    'quantity' => 2,
                    'unit_price' => 25.99,
                    'total_price' => 51.98,
                ],
                [
                    'product_id' => 790,
                    'name' => 'Product B',
                    'quantity' => 1,
                    'unit_price' => 15.50,
                    'total_price' => 15.50,
                ],
            ],
            'totals' => [
                'subtotal' => 67.48,
                'tax' => 6.75,
                'shipping' => 5.99,
                'total' => 80.22,
            ],
            'payment' => [
                'method' => 'credit_card',
                'status' => 'authorized',
                'transaction_id' => 'TXN-98765',
            ],
        ],
        'metadata' => [
            'source' => 'mobile_app',
            'version' => '2.1.0',
            'device_info' => [
                'platform' => 'iOS',
                'version' => '15.0',
                'model' => 'iPhone 13',
            ],
            'user_agent' => 'MobileApp/2.1.0 (iOS; 15.0; iPhone 13)',
        ],
    ];

    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 5,
        'event_version' => 2,
        'event_class' => 'App\Events\OrderPlaced',
        'event_properties' => $complexProperties,
        'meta_data' => [
            'timestamp' => now()->toISOString(),
            'user_id' => 456,
            'session_id' => Str::random(40),
        ],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\OrderPlaced')
        ->where('aggregate_version', 5)
        ->where('event_version', 2)
        ->exists();
    Assert::assertTrue($exists);

    Assert::assertSame(5, $storedEvent->aggregate_version);
    Assert::assertSame(2, $storedEvent->event_version);
    Assert::assertSame('App\\Events\\OrderPlaced', $storedEvent->event_class);

    /** @var array<string, mixed> $properties */
    $properties = $storedEvent->event_properties;
    Assert::assertIsArray($properties);

    /** @var array<string, mixed> $orderData */
    $orderData = $properties['order_data'];
    Assert::assertIsArray($orderData);
    /** @var array<string, mixed> $customer */
    $customer = $orderData['customer'];
    Assert::assertIsArray($customer);
    /** @var array<string, mixed> $totals */
    $totals = $orderData['totals'];
    Assert::assertIsArray($totals);
    /** @var array<string, mixed> $metadata */
    $metadata = $properties['metadata'];
    Assert::assertIsArray($metadata);
    /** @var array<string, mixed> $deviceInfo */
    $deviceInfo = $metadata['device_info'];
    Assert::assertIsArray($deviceInfo);

    Assert::assertSame('ORD-12345', $orderData['order_id']);
    Assert::assertSame('Jane Smith', $customer['name']);
    Assert::assertSame(80.22, $totals['total']);
    Assert::assertSame('mobile_app', $metadata['source']);
    Assert::assertSame('iOS', $deviceInfo['platform']);
});

test('can manage event versioning', function (): void {
    $aggregateUuid = Str::uuid()->toString();

    $event1 = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\UserRegistered',
        'event_properties' => ['version' => 1, 'action' => 'register'],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $event1);

    $event2 = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 2,
        'event_version' => 2,
        'event_class' => 'App\Events\UserProfileUpdated',
        'event_properties' => ['version' => 2, 'action' => 'update_profile'],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $event2);

    $event3 = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 3,
        'event_version' => 3,
        'event_class' => 'App\Events\UserVerified',
        'event_properties' => ['version' => 3, 'action' => 'verify'],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $event3);

    Assert::assertTrue(DB::connection('activity')->table('stored_events')->where('id', $event1->id)->exists());
    Assert::assertTrue(DB::connection('activity')->table('stored_events')->where('id', $event2->id)->exists());
    Assert::assertTrue(DB::connection('activity')->table('stored_events')->where('id', $event3->id)->exists());

    Assert::assertSame($aggregateUuid, $event1->aggregate_uuid);
    Assert::assertSame($aggregateUuid, $event2->aggregate_uuid);
    Assert::assertSame($aggregateUuid, $event3->aggregate_uuid);

    Assert::assertSame(1, $event1->aggregate_version);
    Assert::assertSame(2, $event2->aggregate_version);
    Assert::assertSame(3, $event3->aggregate_version);

    Assert::assertSame(1, $event1->event_version);
    Assert::assertSame(2, $event2->event_version);
    Assert::assertSame(3, $event3->event_version);
});

test('can query events by aggregate uuid', function (): void {
    $uuid1 = Str::uuid()->toString();
    $uuid2 = Str::uuid()->toString();

    StoredEvent::create([
        'aggregate_uuid' => $uuid1,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\FirstEvent',
        'event_properties' => ['aggregate' => 'first', 'version' => 1],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    StoredEvent::create([
        'aggregate_uuid' => $uuid1,
        'aggregate_version' => 2,
        'event_version' => 2,
        'event_class' => 'App\Events\FirstEvent',
        'event_properties' => ['aggregate' => 'first', 'version' => 2],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    StoredEvent::create([
        'aggregate_uuid' => $uuid2,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\SecondEvent',
        'event_properties' => ['aggregate' => 'second', 'version' => 1],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $events1 = StoredEvent::where('aggregate_uuid', $uuid1)->get();
    $events2 = StoredEvent::where('aggregate_uuid', $uuid2)->get();

    Assert::assertCount(2, $events1);
    Assert::assertCount(1, $events2);

    $first1 = $events1->first();
    $first2 = $events2->first();
    Assert::assertNotNull($first1);
    Assert::assertNotNull($first2);
    Assert::assertInstanceOf(StoredEvent::class, $first1);
    Assert::assertInstanceOf(StoredEvent::class, $first2);
    Assert::assertSame($uuid1, $first1->aggregate_uuid);
    Assert::assertSame($uuid2, $first2->aggregate_uuid);
});

test('can query events by event class', function (): void {
    $uuid = Str::uuid()->toString();

    StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\UserCreated',
        'event_properties' => ['action' => 'create'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 2,
        'event_version' => 2,
        'event_class' => 'App\Events\UserUpdated',
        'event_properties' => ['action' => 'update'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 3,
        'event_version' => 3,
        'event_class' => 'App\Events\UserDeleted',
        'event_properties' => ['action' => 'delete'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $userCreatedEvents = StoredEvent::where('event_class', 'App\Events\UserCreated')->get();
    $userUpdatedEvents = StoredEvent::where('event_class', 'App\Events\UserUpdated')->get();
    $userDeletedEvents = StoredEvent::where('event_class', 'App\Events\UserDeleted')->get();

    Assert::assertCount(1, $userCreatedEvents);
    Assert::assertCount(1, $userUpdatedEvents);
    Assert::assertCount(1, $userDeletedEvents);

    $firstCreated = $userCreatedEvents->first();
    $firstUpdated = $userUpdatedEvents->first();
    $firstDeleted = $userDeletedEvents->first();
    Assert::assertNotNull($firstCreated);
    Assert::assertNotNull($firstUpdated);
    Assert::assertNotNull($firstDeleted);
    Assert::assertInstanceOf(StoredEvent::class, $firstCreated);
    Assert::assertInstanceOf(StoredEvent::class, $firstUpdated);
    Assert::assertInstanceOf(StoredEvent::class, $firstDeleted);
    Assert::assertSame('App\\Events\\UserCreated', $firstCreated->event_class);
    Assert::assertSame('App\\Events\\UserUpdated', $firstUpdated->event_class);
    Assert::assertSame('App\\Events\\UserDeleted', $firstDeleted->event_class);
});

test('can handle event with empty properties', function (): void {
    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\EmptyEvent',
        'event_properties' => [],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\EmptyEvent')
        ->exists();
    Assert::assertTrue($exists);

    /** @var array<string, mixed> $props */
    $props = $storedEvent->event_properties;
    Assert::assertIsArray($props);
    Assert::assertEmpty($props);
});

test('can handle event with null properties', function (): void {
    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\NullEvent',
        'event_properties' => [],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\NullEvent')
        ->exists();
    Assert::assertTrue($exists);

    /** @var array<string, mixed> $props */
    $props = $storedEvent->event_properties;
    Assert::assertIsArray($props);
    Assert::assertEmpty($props);
    Assert::assertInstanceOf(SchemalessAttributes::class, $storedEvent->meta_data);
    Assert::assertSame([], $storedEvent->meta_data->toArray());
});

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
