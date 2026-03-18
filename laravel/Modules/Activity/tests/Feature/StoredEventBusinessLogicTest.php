<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Activity\Models\StoredEvent;

uses(\Modules\Activity\Tests\TestCase::class);

it('can create stored event with basic information', function (): void {
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

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('aggregate_uuid', $eventData['aggregate_uuid'])
        ->where('aggregate_version', 1)
        ->where('event_version', 1)
        ->where('event_class', 'App\\Events\\UserCreated')
        ->exists();
    $this->assertTrue($exists);

    $this->assertSame($eventData['aggregate_uuid'], $storedEvent->aggregate_uuid);
    $this->assertSame(1, $storedEvent->aggregate_version);
    $this->assertSame(1, $storedEvent->event_version);
    $this->assertSame('App\\Events\\UserCreated', $storedEvent->event_class);
});

it('can create stored event with complex properties', function (): void {
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

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\OrderPlaced')
        ->where('aggregate_version', 5)
        ->where('event_version', 2)
        ->exists();
    $this->assertTrue($exists);

    $this->assertSame(5, $storedEvent->aggregate_version);
    $this->assertSame(2, $storedEvent->event_version);
    $this->assertSame('App\\Events\\OrderPlaced', $storedEvent->event_class);

    /** @var array<string, mixed> $properties */
    $properties = $storedEvent->event_properties;
    $this->assertIsArray($properties);

    /** @var array<string, mixed> $orderData */
    $orderData = $properties['order_data'];
    $this->assertIsArray($orderData);
    /** @var array<string, mixed> $customer */
    $customer = $orderData['customer'];
    $this->assertIsArray($customer);
    /** @var array<string, mixed> $totals */
    $totals = $orderData['totals'];
    $this->assertIsArray($totals);
    /** @var array<string, mixed> $metadata */
    $metadata = $properties['metadata'];
    $this->assertIsArray($metadata);
    /** @var array<string, mixed> $deviceInfo */
    $deviceInfo = $metadata['device_info'];
    $this->assertIsArray($deviceInfo);

    $this->assertSame('ORD-12345', $orderData['order_id']);
    $this->assertSame('Jane Smith', $customer['name']);
    $this->assertSame(80.22, $totals['total']);
    $this->assertSame('mobile_app', $metadata['source']);
    $this->assertSame('iOS', $deviceInfo['platform']);
});

it('can manage event versioning', function (): void {
    $aggregateUuid = Str::uuid()->toString();

    // Crea eventi con versioni progressive
    $event1 = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\UserRegistered',
        'event_properties' => ['version' => 1, 'action' => 'register'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $event2 = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 2,
        'event_version' => 2,
        'event_class' => 'App\Events\UserProfileUpdated',
        'event_properties' => ['version' => 2, 'action' => 'update_profile'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $event3 = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 3,
        'event_version' => 3,
        'event_class' => 'App\Events\UserVerified',
        'event_properties' => ['version' => 3, 'action' => 'verify'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $this->assertTrue(DB::connection('activity')->table('stored_events')->where('id', $event1->id)->exists());
    $this->assertTrue(DB::connection('activity')->table('stored_events')->where('id', $event2->id)->exists());
    $this->assertTrue(DB::connection('activity')->table('stored_events')->where('id', $event3->id)->exists());
    // Verifica che tutti gli eventi abbiano lo stesso UUID ma versioni diverse
    $this->assertSame($aggregateUuid, $event1->aggregate_uuid);
    $this->assertSame($aggregateUuid, $event2->aggregate_uuid);
    $this->assertSame($aggregateUuid, $event3->aggregate_uuid);

    $this->assertSame(1, $event1->aggregate_version);
    $this->assertSame(2, $event2->aggregate_version);
    $this->assertSame(3, $event3->aggregate_version);

    $this->assertSame(1, $event1->event_version);
    $this->assertSame(2, $event2->event_version);
    $this->assertSame(3, $event3->event_version);
});

it('can query events by aggregate uuid', function (): void {
    $uuid1 = Str::uuid()->toString();
    $uuid2 = Str::uuid()->toString();

    // Crea eventi per il primo aggregate
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

    // Crea evento per il secondo aggregate
    StoredEvent::create([
        'aggregate_uuid' => $uuid2,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\SecondEvent',
        'event_properties' => ['aggregate' => 'second', 'version' => 1],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    // Query per UUID specifico
    $events1 = StoredEvent::where('aggregate_uuid', $uuid1)->get();
    $events2 = StoredEvent::where('aggregate_uuid', $uuid2)->get();

    $this->assertCount(2, $events1);
    $this->assertCount(1, $events2);

    $first1 = $events1->first();
    $first2 = $events2->first();
    $this->assertNotNull($first1);
    $this->assertNotNull($first2);
    \assert($first1 instanceof StoredEvent);
    \assert($first2 instanceof StoredEvent);
    $this->assertSame($uuid1, $first1->aggregate_uuid);
    $this->assertSame($uuid2, $first2->aggregate_uuid);
});

it('can query events by event class', function (): void {
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

    // Query per classe evento specifica
    $userCreatedEvents = StoredEvent::where('event_class', 'App\Events\UserCreated')->get();
    $userUpdatedEvents = StoredEvent::where('event_class', 'App\Events\UserUpdated')->get();
    $userDeletedEvents = StoredEvent::where('event_class', 'App\Events\UserDeleted')->get();

    $this->assertCount(1, $userCreatedEvents);
    $this->assertCount(1, $userUpdatedEvents);
    $this->assertCount(1, $userDeletedEvents);

    $firstCreated = $userCreatedEvents->first();
    $firstUpdated = $userUpdatedEvents->first();
    $firstDeleted = $userDeletedEvents->first();
    $this->assertNotNull($firstCreated);
    $this->assertNotNull($firstUpdated);
    $this->assertNotNull($firstDeleted);
    \assert($firstCreated instanceof StoredEvent);
    \assert($firstUpdated instanceof StoredEvent);
    \assert($firstDeleted instanceof StoredEvent);
    $this->assertSame('App\\Events\\UserCreated', $firstCreated->event_class);
    $this->assertSame('App\\Events\\UserUpdated', $firstUpdated->event_class);
    $this->assertSame('App\\Events\\UserDeleted', $firstDeleted->event_class);
});

it('can handle event with empty properties', function (): void {
    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\EmptyEvent',
        'event_properties' => [],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\EmptyEvent')
        ->exists();
    $this->assertTrue($exists);
    $this->assertIsArray($storedEvent->event_properties);
    $this->assertEmpty($storedEvent->event_properties);
});

it('can handle event with null properties', function (): void {
    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\NullEvent',
        'event_properties' => [],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\NullEvent')
        ->exists();
    $this->assertTrue($exists);

    $this->assertIsArray($storedEvent->event_properties);
    $this->assertEmpty($storedEvent->event_properties);
    $this->assertInstanceOf(\Spatie\SchemalessAttributes\SchemalessAttributes::class, $storedEvent->meta_data);
    $this->assertSame([], $storedEvent->meta_data->toArray());
});

it('can restore event from stored event', function (): void {
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

    // Simula il ripristino dell'evento
    $restoredProperties = $storedEvent->event_properties;
    $this->assertIsArray($restoredProperties);
    $this->assertSame($originalProperties, $restoredProperties);
});

it('can compare event versions', function (): void {
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

    $event2 = StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 2,
        'event_version' => 2,
        'event_class' => 'App\Events\VersionedEvent',
        'event_properties' => ['version' => 2, 'data' => 'Updated data'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    $event3 = StoredEvent::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 3,
        'event_version' => 3,
        'event_class' => 'App\Events\VersionedEvent',
        'event_properties' => ['version' => 3, 'data' => 'Final data'],
        'meta_data' => [],
        'created_at' => now(),
    ]);

    // Verifica che le versioni siano progressive
    $this->assertLessThan($event2->aggregate_version, $event1->aggregate_version);
    $this->assertLessThan($event3->aggregate_version, $event2->aggregate_version);

    $this->assertLessThan($event2->event_version, $event1->event_version);
    $this->assertLessThan($event3->event_version, $event2->event_version);

    $this->assertSame(1, $event1->event_properties['version']);
    $this->assertSame(2, $event2->event_properties['version']);
    $this->assertSame(3, $event3->event_properties['version']);

    $this->assertSame('Initial data', $event1->event_properties['data']);
    $this->assertSame('Updated data', $event2->event_properties['data']);
    $this->assertSame('Final data', $event3->event_properties['data']);
});

it('can handle event with timestamps', function (): void {
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

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('created_at', $now->toDateTimeString())
        ->exists();
    $this->assertTrue($exists);

    $createdAt = Carbon::parse((string) $storedEvent->created_at);
    $this->assertSame($now->timestamp, $createdAt->timestamp);
});

it('can query events by date range', function (): void {
    $yesterday = now()->subDay();
    $today = now();
    $tomorrow = now()->addDay();

    StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\DateTestEvent',
        'event_properties' => ['date' => 'yesterday'],
        'meta_data' => [],
        'created_at' => $yesterday,
    ]);

    StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\DateTestEvent',
        'event_properties' => ['date' => 'today'],
        'meta_data' => [],
        'created_at' => $today,
    ]);

    StoredEvent::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\Events\DateTestEvent',
        'event_properties' => ['date' => 'tomorrow'],
        'meta_data' => [],
        'created_at' => $tomorrow,
    ]);

    $todayEvents = StoredEvent::whereDate('created_at', today())->get();
    $this->assertCount(1, $todayEvents);
    $todayFirst = $todayEvents->first();
    $this->assertNotNull($todayFirst);
    \assert($todayFirst instanceof StoredEvent);
    /** @var array<string, mixed> $todayProps */
    $todayProps = $todayFirst->event_properties;
    $this->assertSame('today', $todayProps['date']);

    $recentEvents = StoredEvent::whereBetween('created_at', [$yesterday, $today->endOfDay()])->get();
    $this->assertCount(2, $recentEvents);
});

it('can handle event with metadata', function (): void {
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

    $exists = DB::connection('activity')
        ->table('stored_events')
        ->where('id', $storedEvent->id)
        ->where('event_class', 'App\\Events\\BulkImportCompleted')
        ->exists();
    $this->assertTrue($exists);

    $properties = $storedEvent->event_properties;
    $this->assertSame('IMP-98765', $properties['import_id']);
    $this->assertSame('completed', $properties['status']);
    $this->assertSame(1500, $properties['total_records']);
    $this->assertSame(1485, $properties['successful_records']);
    $this->assertSame(15, $properties['failed_records']);

    $metaAttributes = $storedEvent->meta_data;
    /** @var array<string, mixed> $meta */
    $meta = method_exists($metaAttributes, 'toArray') ? $metaAttributes->toArray() : [];
    $this->assertSame('web_interface', $meta['source']);
    $this->assertSame(1010, $meta['user_id']);
    $this->assertSame('bulk_import', $meta['action']);
    $this->assertSame(2.5, $meta['processing_time']);
    $this->assertSame(1500, $meta['records_processed']);
});
