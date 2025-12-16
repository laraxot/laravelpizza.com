<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\Activity\Models\StoredEvent;
use Tests\TestCase;

class StoredEventBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_stored_event_with_basic_information(): void
    {
        $eventData = [
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\UserCreated',
            'event_properties' => json_encode([
                'user_id' => 123,
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ]),
            'meta_data' => json_encode([
                'source' => 'web_registration',
                'ip_address' => '192.168.1.1',
            ]),
        ];

        $storedEvent = StoredEvent::create($eventData);

        $this->assertDatabaseHas('stored_events', [
            'id' => $storedEvent->id,
            'aggregate_uuid' => $eventData['aggregate_uuid'],
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\UserCreated',
        ]);

        $this->assertEquals($eventData['aggregate_uuid'], $storedEvent->aggregate_uuid);
        $this->assertEquals(1, $storedEvent->aggregate_version);
        $this->assertEquals(1, $storedEvent->event_version);
        $this->assertEquals('App\Events\UserCreated', $storedEvent->event_class);
    }

    /** @test */
    public function it_can_create_stored_event_with_complex_properties(): void
    {
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
            'event_properties' => json_encode($complexProperties),
            'meta_data' => json_encode([
                'timestamp' => now()->toISOString(),
                'user_id' => 456,
                'session_id' => Str::random(40),
            ]),
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $storedEvent->id,
            'event_class' => 'App\Events\OrderPlaced',
            'aggregate_version' => 5,
            'event_version' => 2,
        ]);

        $this->assertEquals(5, $storedEvent->aggregate_version);
        $this->assertEquals(2, $storedEvent->event_version);
        $this->assertEquals('App\Events\OrderPlaced', $storedEvent->event_class);

        $properties = json_decode($storedEvent->event_properties, true);
        $this->assertEquals('ORD-12345', $properties['order_data']['order_id']);
        $this->assertEquals('Jane Smith', $properties['order_data']['customer']['name']);
        $this->assertEquals(80.22, $properties['order_data']['totals']['total']);
        $this->assertEquals('mobile_app', $properties['metadata']['source']);
        $this->assertEquals('iOS', $properties['metadata']['device_info']['platform']);
    }

    /** @test */
    public function it_can_manage_event_versioning(): void
    {
        $aggregateUuid = Str::uuid()->toString();

        // Crea eventi con versioni progressive
        $event1 = StoredEvent::create([
            'aggregate_uuid' => $aggregateUuid,
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\UserRegistered',
            'event_properties' => json_encode(['version' => 1, 'action' => 'register']),
            'meta_data' => json_encode([]),
        ]);

        $event2 = StoredEvent::create([
            'aggregate_uuid' => $aggregateUuid,
            'aggregate_version' => 2,
            'event_version' => 2,
            'event_class' => 'App\Events\UserProfileUpdated',
            'event_properties' => json_encode(['version' => 2, 'action' => 'update_profile']),
            'meta_data' => json_encode([]),
        ]);

        $event3 = StoredEvent::create([
            'aggregate_uuid' => $aggregateUuid,
            'aggregate_version' => 3,
            'event_version' => 3,
            'event_class' => 'App\Events\UserVerified',
            'event_properties' => json_encode(['version' => 3, 'action' => 'verify']),
            'meta_data' => json_encode([]),
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $event1->id,
            'aggregate_version' => 1,
            'event_version' => 1,
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $event2->id,
            'aggregate_version' => 2,
            'event_version' => 2,
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $event3->id,
            'aggregate_version' => 3,
            'event_version' => 3,
        ]);

        // Verifica che tutti gli eventi abbiano lo stesso UUID ma versioni diverse
        $this->assertEquals($aggregateUuid, $event1->aggregate_uuid);
        $this->assertEquals($aggregateUuid, $event2->aggregate_uuid);
        $this->assertEquals($aggregateUuid, $event3->aggregate_uuid);

        $this->assertEquals(1, $event1->aggregate_version);
        $this->assertEquals(2, $event2->aggregate_version);
        $this->assertEquals(3, $event3->aggregate_version);

        $this->assertEquals(1, $event1->event_version);
        $this->assertEquals(2, $event2->event_version);
        $this->assertEquals(3, $event3->event_version);
    }

    /** @test */
    public function it_can_query_events_by_aggregate_uuid(): void
    {
        $uuid1 = Str::uuid()->toString();
        $uuid2 = Str::uuid()->toString();

        // Crea eventi per il primo aggregate
        StoredEvent::create([
            'aggregate_uuid' => $uuid1,
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\FirstEvent',
            'event_properties' => json_encode(['aggregate' => 'first', 'version' => 1]),
            'meta_data' => json_encode([]),
        ]);

        StoredEvent::create([
            'aggregate_uuid' => $uuid1,
            'aggregate_version' => 2,
            'event_version' => 2,
            'event_class' => 'App\Events\FirstEvent',
            'event_properties' => json_encode(['aggregate' => 'first', 'version' => 2]),
            'meta_data' => json_encode([]),
        ]);

        // Crea evento per il secondo aggregate
        StoredEvent::create([
            'aggregate_uuid' => $uuid2,
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\SecondEvent',
            'event_properties' => json_encode(['aggregate' => 'second', 'version' => 1]),
            'meta_data' => json_encode([]),
        ]);

        // Query per UUID specifico
        $events1 = StoredEvent::where('aggregate_uuid', $uuid1)->get();
        $events2 = StoredEvent::where('aggregate_uuid', $uuid2)->get();

        $this->assertCount(2, $events1);
        $this->assertCount(1, $events2);

        $this->assertEquals($uuid1, $events1->first()->aggregate_uuid);
        $this->assertEquals($uuid2, $events2->first()->aggregate_uuid);
    }

    /** @test */
    public function it_can_query_events_by_event_class(): void
    {
        $uuid = Str::uuid()->toString();

        StoredEvent::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\UserCreated',
            'event_properties' => json_encode(['action' => 'create']),
            'meta_data' => json_encode([]),
        ]);

        StoredEvent::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => 2,
            'event_version' => 2,
            'event_class' => 'App\Events\UserUpdated',
            'event_properties' => json_encode(['action' => 'update']),
            'meta_data' => json_encode([]),
        ]);

        StoredEvent::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => 3,
            'event_version' => 3,
            'event_class' => 'App\Events\UserDeleted',
            'event_properties' => json_encode(['action' => 'delete']),
            'meta_data' => json_encode([]),
        ]);

        // Query per classe evento specifica
        $userCreatedEvents = StoredEvent::where('event_class', 'App\Events\UserCreated')->get();
        $userUpdatedEvents = StoredEvent::where('event_class', 'App\Events\UserUpdated')->get();
        $userDeletedEvents = StoredEvent::where('event_class', 'App\Events\UserDeleted')->get();

        $this->assertCount(1, $userCreatedEvents);
        $this->assertCount(1, $userUpdatedEvents);
        $this->assertCount(1, $userDeletedEvents);

        $this->assertEquals('App\Events\UserCreated', $userCreatedEvents->first()->event_class);
        $this->assertEquals('App\Events\UserUpdated', $userUpdatedEvents->first()->event_class);
        $this->assertEquals('App\Events\UserDeleted', $userDeletedEvents->first()->event_class);
    }

    /** @test */
    public function it_can_handle_event_with_empty_properties(): void
    {
        $storedEvent = StoredEvent::create([
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\EmptyEvent',
            'event_properties' => json_encode([]),
            'meta_data' => json_encode([]),
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $storedEvent->id,
            'event_class' => 'App\Events\EmptyEvent',
        ]);

        $this->assertIsArray($storedEvent->event_properties);
        $this->assertEmpty($storedEvent->event_properties);
    }

    /** @test */
    public function it_can_handle_event_with_null_properties(): void
    {
        $storedEvent = StoredEvent::create([
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\NullEvent',
            'event_properties' => null,
            'meta_data' => null,
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $storedEvent->id,
            'event_class' => 'App\Events\NullEvent',
        ]);

        $this->assertNull($storedEvent->event_properties);
        $this->assertNull($storedEvent->meta_data);
    }

    /** @test */
    public function it_can_restore_event_from_stored_event(): void
    {
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
            'event_properties' => json_encode($originalProperties),
            'meta_data' => json_encode([
                'source' => 'api',
                'request_id' => Str::uuid()->toString(),
            ]),
        ]);

        // Simula il ripristino dell'evento
        $restoredProperties = $storedEvent->event_properties;

        $this->assertEquals($originalProperties, $restoredProperties);
        $this->assertEquals(789, $restoredProperties['user_id']);
        $this->assertEquals('profile_update', $restoredProperties['action']);
        $this->assertEquals('Bob Johnson', $restoredProperties['changes']['name']);
        $this->assertEquals('bob@example.com', $restoredProperties['changes']['email']);
        $this->assertEquals('+1987654321', $restoredProperties['changes']['phone']);
    }

    /** @test */
    public function it_can_compare_event_versions(): void
    {
        $uuid = Str::uuid()->toString();

        $event1 = StoredEvent::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\VersionedEvent',
            'event_properties' => json_encode(['version' => 1, 'data' => 'Initial data']),
            'meta_data' => json_encode([]),
        ]);

        $event2 = StoredEvent::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => 2,
            'event_version' => 2,
            'event_class' => 'App\Events\VersionedEvent',
            'event_properties' => json_encode(['version' => 2, 'data' => 'Updated data']),
            'meta_data' => json_encode([]),
        ]);

        $event3 = StoredEvent::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => 3,
            'event_version' => 3,
            'event_class' => 'App\Events\VersionedEvent',
            'event_properties' => json_encode(['version' => 3, 'data' => 'Final data']),
            'meta_data' => json_encode([]),
        ]);

        // Verifica che le versioni siano progressive
        $this->assertLessThan($event2->aggregate_version, $event1->aggregate_version);
        $this->assertLessThan($event3->aggregate_version, $event2->aggregate_version);

        $this->assertLessThan($event2->event_version, $event1->event_version);
        $this->assertLessThan($event3->event_version, $event2->event_version);

        // Verifica che i dati cambino tra le versioni
        $this->assertEquals(1, $event1->event_properties['version']);
        $this->assertEquals(2, $event2->event_properties['version']);
        $this->assertEquals(3, $event3->event_properties['version']);

        $this->assertEquals('Initial data', $event1->event_properties['data']);
        $this->assertEquals('Updated data', $event2->event_properties['data']);
        $this->assertEquals('Final data', $event3->event_properties['data']);
    }

    /** @test */
    public function it_can_handle_event_with_timestamps(): void
    {
        $now = now();

        $storedEvent = StoredEvent::create([
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\TimestampedEvent',
            'event_properties' => json_encode(['created_at' => $now->toISOString()]),
            'meta_data' => json_encode([]),
            'created_at' => $now,
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $storedEvent->id,
            'created_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($now->timestamp, $storedEvent->created_at->timestamp);
    }

    /** @test */
    public function it_can_query_events_by_date_range(): void
    {
        $yesterday = now()->subDay();
        $today = now();
        $tomorrow = now()->addDay();

        StoredEvent::create([
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\DateTestEvent',
            'event_properties' => json_encode(['date' => 'yesterday']),
            'meta_data' => json_encode([]),
            'created_at' => $yesterday,
        ]);

        StoredEvent::create([
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\DateTestEvent',
            'event_properties' => json_encode(['date' => 'today']),
            'meta_data' => json_encode([]),
            'created_at' => $today,
        ]);

        StoredEvent::create([
            'aggregate_uuid' => Str::uuid()->toString(),
            'aggregate_version' => 1,
            'event_version' => 1,
            'event_class' => 'App\Events\DateTestEvent',
            'event_properties' => json_encode(['date' => 'tomorrow']),
            'meta_data' => json_encode([]),
            'created_at' => $tomorrow,
        ]);

        $todayEvents = StoredEvent::whereDate('created_at', today())->get();
        $this->assertCount(1, $todayEvents);
        $this->assertEquals('today', $todayEvents->first()->event_properties['date']);

        $recentEvents = StoredEvent::where('created_at', '>=', $yesterday)->get();
        $this->assertCount(2, $recentEvents);
    }

    /** @test */
    public function it_can_handle_event_with_metadata(): void
    {
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
            'event_properties' => json_encode([
                'import_id' => 'IMP-98765',
                'status' => 'completed',
                'total_records' => 1500,
                'successful_records' => 1485,
                'failed_records' => 15,
                'errors' => [
                    'duplicate_emails' => 10,
                    'invalid_format' => 5,
                ],
            ]),
            'meta_data' => json_encode($metadata),
        ]);

        $this->assertDatabaseHas('stored_events', [
            'id' => $storedEvent->id,
            'event_class' => 'App\Events\BulkImportCompleted',
        ]);

        $properties = json_decode($storedEvent->event_properties, true);
        $this->assertEquals('IMP-98765', $properties['import_id']);
        $this->assertEquals('completed', $properties['status']);
        $this->assertEquals(1500, $properties['total_records']);
        $this->assertEquals(1485, $properties['successful_records']);
        $this->assertEquals(15, $properties['failed_records']);

        $meta = json_decode($storedEvent->meta_data, true);
        $this->assertEquals('web_interface', $meta['source']);
        $this->assertEquals(1010, $meta['user_id']);
        $this->assertEquals('bulk_import', $meta['action']);
        $this->assertEquals(2.5, $meta['processing_time']);
        $this->assertEquals(1500, $meta['records_processed']);
    }
}
