<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\User\Models\User;

uses(\Modules\Activity\Tests\TestCase::class);

test('activity event sourcing lifecycle works correctly', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    $this->assertNotNull($user);

    $activityData = [
        'log_name' => 'user_actions',
        'description' => 'User performed test action',
        'subject_type' => User::class,
        'subject_id' => $user->id,
        'causer_type' => User::class,
        'causer_id' => $user->id,
        'properties' => ['action' => 'test', 'result' => 'success'],
        'event' => 'created'
    ];

    $activity = Activity::query()->create($activityData);
    \assert($activity instanceof Activity);
    $this->assertNotNull($activity);
    $this->assertInstanceOf(Activity::class, $activity);
    $this->assertSame('user_actions', $activity->log_name);
    $this->assertSame('User performed test action', $activity->description);
    $this->assertSame(User::class, $activity->subject_type);
    $this->assertSame($user->id, $activity->subject_id);
    $this->assertSame(User::class, $activity->causer_type);
    $this->assertSame($user->id, $activity->causer_id);
    $this->assertSame('created', $activity->event);

    $properties = $activity->properties;
    $this->assertInstanceOf(Collection::class, $properties);
    $this->assertSame('test', $properties->get('action'));
    $this->assertSame('success', $properties->get('result'));
});

test('activity can be queried with complex scopes', function () {
    $user1 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user1 instanceof User);
    $this->assertNotNull($user1);

    $user2 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user2 instanceof User);
    $this->assertNotNull($user2);

    $activity1 = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'security',
        'event' => 'login',
        'causer_type' => User::class,
        'causer_id' => $user1->id
    ]);
    \assert($activity1 instanceof Activity);
    $this->assertNotNull($activity1);

    $activity2 = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'security',
        'event' => 'logout',
        'causer_type' => User::class,
        'causer_id' => $user2->id
    ]);
    \assert($activity2 instanceof Activity);
    $this->assertNotNull($activity2);

    $activity3 = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'audit',
        'event' => 'update',
        'causer_type' => User::class,
        'causer_id' => $user1->id
    ]);
    \assert($activity3 instanceof Activity);

    $securityActivities = Activity::inLog('security')
        ->whereKey([$activity1->id, $activity2->id])
        ->get();

    $user1Activities = Activity::query()
        ->where('causer_type', User::class)
        ->where('causer_id', $user1->id)
        ->whereKey([$activity1->id, $activity3->id])
        ->get();

    $loginActivities = Activity::forEvent('login')
        ->whereKey([$activity1->id])
        ->get();

    $this->assertCount(2, $securityActivities);
    $this->assertCount(2, $user1Activities);

    /** @var Activity|null $firstLoginActivity */
    $firstLoginActivity = $loginActivities->first();
    $this->assertCount(1, $loginActivities);
    $this->assertNotNull($firstLoginActivity);

    \assert($firstLoginActivity instanceof Activity);
    $this->assertInstanceOf(Activity::class, $firstLoginActivity);
    $this->assertSame($activity1->id, $firstLoginActivity->id);
});

test('snapshot creation and retrieval works correctly', function () {
    $aggregateUuid = Str::uuid()->toString();

    $snapshotData = [
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 5,
        'state' => [
            'balance' => 1000,
            'transactions' => [
                ['id' => 1, 'amount' => 100, 'type' => 'credit'],
                ['id' => 2, 'amount' => 50, 'type' => 'debit']
            ],
            'status' => 'active'
        ]
    ];

    $snapshot = Snapshot::create($snapshotData);
    \assert($snapshot instanceof Snapshot);
    $this->assertNotNull($snapshot);
    $this->assertSame($aggregateUuid, $snapshot->aggregate_uuid);
    $this->assertSame(5, $snapshot->aggregate_version);

    $state = $snapshot->state;
    $this->assertIsArray($state);
    $this->assertArrayHasKey('balance', $state);
    $this->assertSame(1000, $state['balance']);
    $this->assertArrayHasKey('status', $state);
    $this->assertSame('active', $state['status']);

    $transactions = $state['transactions'] ?? null;
    $this->assertIsArray($transactions);
    $this->assertCount(2, $transactions);

    /** @var Snapshot|null $retrievedSnapshot */
    $retrievedSnapshot = Snapshot::uuid($aggregateUuid)->first();
    \assert($retrievedSnapshot instanceof Snapshot);
    $this->assertNotNull($retrievedSnapshot);
    $this->assertSame($snapshot->id, $retrievedSnapshot->id);
});

test('stored event creation and event reconstruction works', function () {
    $eventClass = 'App\\Events\\TestEvent';
    $aggregateUuid = Str::uuid()->toString();

    $eventProperties = [
        'user_id' => 1,
        'action' => 'test_action',
        'metadata' => [
            'ip' => '127.0.0.1',
            'user_agent' => 'Test Browser'
        ]
    ];

    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => $eventClass,
        'event_properties' => $eventProperties,
        'meta_data' => ['processed' => true, 'retry_count' => 0],
        'created_at' => now(),
    ]);
    \assert($storedEvent instanceof StoredEvent);
    $this->assertNotNull($storedEvent);
    $this->assertSame($eventClass, $storedEvent->event_class);
    $this->assertSame($aggregateUuid, $storedEvent->aggregate_uuid);
    $eventProps = $storedEvent->event_properties;
    $this->assertIsArray($eventProps);
    $this->assertArrayHasKey('user_id', $eventProps);
    $this->assertSame(1, $eventProps['user_id']);
    $this->assertArrayHasKey('action', $eventProps);
    $this->assertSame('test_action', $eventProps['action']);

    $metaData = $storedEvent->meta_data;
    $this->assertInstanceOf(\Spatie\SchemalessAttributes\SchemalessAttributes::class, $metaData);

    $metaDataArray = $metaData->toArray();
    $this->assertIsArray($metaDataArray);
    $this->assertArrayHasKey('processed', $metaDataArray);
    $this->assertTrue((bool) $metaDataArray['processed']);
    $this->assertArrayHasKey('retry_count', $metaDataArray);
    $this->assertSame(0, (int) $metaDataArray['retry_count']);
});

test('activity batch operations work correctly', function () {
    $batchUuid = Str::uuid()->toString();

    $activities = Activity::factory()->count(3)->create([ // @phpstan-ignore-line method.nonObject
        'batch_uuid' => $batchUuid,
        'log_name' => 'batch_operation'
    ]);
    \assert($activities instanceof \Illuminate\Database\Eloquent\Collection);
    $this->assertCount(3, $activities);

    $batchActivities = Activity::forBatch($batchUuid)->get();

    $this->assertCount(3, $batchActivities);
    
    foreach ($batchActivities as $activity) {
        \assert($activity instanceof Activity);
        $this->assertSame($batchUuid, $activity->batch_uuid);
        $this->assertSame('batch_operation', $activity->log_name);
    }
});

test('activity with batch scope returns correct results', function () {
    $withBatch = Activity::factory()->create(['batch_uuid' => Str::uuid()->toString()]); // @phpstan-ignore-line method.nonObject
    \assert($withBatch instanceof Activity);
    $this->assertNotNull($withBatch);

    Activity::factory()->create(['batch_uuid' => null]); // @phpstan-ignore-line method.nonObject

    $activitiesWithBatch = Activity::hasBatch()->get();

    $firstActivity = $activitiesWithBatch->first();
    $this->assertCount(1, $activitiesWithBatch);
    \assert($firstActivity instanceof Activity);
    $this->assertNotNull($firstActivity);
    $this->assertSame($withBatch->id, $firstActivity->id);
});

test('activity properties support complex nested structures', function () {
    $complexProperties = [
        'user' => [
            'id' => 1,
            'name' => 'Test User',
            'roles' => ['admin', 'user'],
            'permissions' => ['read', 'write', 'delete']
        ],
        'action' => 'complex_operation',
        'context' => [
            'request' => [
                'method' => 'POST',
                'url' => '/api/test',
                'headers' => ['Content-Type' => 'application/json']
            ],
            'response' => [
                'status' => 200,
                'data' => ['success' => true, 'message' => 'Operation completed']
            ]
        ],
        'timestamps' => [
            'started_at' => now()->subMinutes(5)->toISOString(),
            'completed_at' => now()->toISOString(),
            'duration' => 300
        ]
    ];

    $activity = Activity::create([
        'log_name' => 'default',
        'description' => 'Complex properties activity',
        'properties' => $complexProperties,
        'event' => 'created',
    ]);
    \assert($activity instanceof Activity);
    $this->assertNotNull($activity);

    $freshActivity = $activity->fresh();
    \assert($freshActivity instanceof Activity);
    $this->assertNotNull($freshActivity);

    $properties = $freshActivity->properties;
    $this->assertInstanceOf(Collection::class, $properties);
    $this->assertTrue($properties->has('user'));
    $this->assertTrue($properties->has('action'));
    $this->assertTrue($properties->has('context'));
    $this->assertTrue($properties->has('timestamps'));

    $userData = $properties->get('user');
    $contextData = $properties->get('context');
    $timestampsData = $properties->get('timestamps');

    $this->assertIsArray($userData);
    $this->assertArrayHasKey('id', $userData);
    $this->assertArrayHasKey('name', $userData);
    $this->assertArrayHasKey('roles', $userData);
    $this->assertArrayHasKey('permissions', $userData);

    $this->assertIsArray($contextData);
    $this->assertArrayHasKey('request', $contextData);
    $this->assertArrayHasKey('response', $contextData);

    $this->assertIsArray($timestampsData);
    $this->assertArrayHasKey('started_at', $timestampsData);
    $this->assertArrayHasKey('completed_at', $timestampsData);
    $this->assertArrayHasKey('duration', $timestampsData);
});

test('snapshot state maintains data integrity with large datasets', function () {
    $largeState = [
        'users' => array_map(fn($i) => [
            'id' => $i,
            'name' => "User {$i}",
            'email' => "user{$i}@example.com",
            'active' => $i % 2 === 0,
            'preferences' => [
                'theme' => $i % 2 === 0 ? 'dark' : 'light',
                'notifications' => true,
                'language' => 'en'
            ]
        ], range(1, 100)),
        'metadata' => [
            'generated_at' => now()->toISOString(),
            'version' => '1.0.0',
            'checksum' => md5('test')
        ]
    ];

    $snapshot = Snapshot::create([
        'aggregate_uuid' => (string) Str::uuid(),
        'aggregate_version' => 1,
        'state' => $largeState,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    \assert($snapshot instanceof Snapshot);
    $this->assertNotNull($snapshot);

    $freshSnapshot = $snapshot->fresh();
    \assert($freshSnapshot instanceof Snapshot);
    $this->assertNotNull($freshSnapshot);

    $state = $freshSnapshot->state;
    $this->assertIsArray($state);
    $this->assertArrayHasKey('users', $state);
    $this->assertArrayHasKey('metadata', $state);

    $users = $state['users'] ?? null;
    $metadata = $state['metadata'] ?? null;

    $this->assertIsArray($users);
    $this->assertCount(100, $users);
    $this->assertIsArray($metadata);
    $this->assertArrayHasKey('generated_at', $metadata);
    $this->assertArrayHasKey('version', $metadata);
    $this->assertArrayHasKey('checksum', $metadata);
});

test('stored event handles complex event properties with nested arrays', function () {
    $complexEvent = [
        'order' => [
            'id' => 12345,
            'items' => array_map(fn($i) => [
                'product_id' => $i,
                'name' => "Product {$i}",
                'quantity' => rand(1, 5),
                'price' => rand(1000, 5000) / 100,
                'attributes' => ['color' => 'red', 'size' => 'M']
            ], range(1, 50)),
            'totals' => [
                'subtotal' => 1234.56,
                'tax' => 123.46,
                'shipping' => 15.00,
                'total' => 1373.02
            ]
        ],
        'customer' => [
            'id' => 67890,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'address' => [
                'street' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'zip' => '12345',
                'country' => 'US'
            ]
        ],
        'payment' => [
            'method' => 'credit_card',
            'transaction_id' => 'txn_123456789',
            'status' => 'completed',
            'amount' => 1373.02
        ]
    ];

    $storedEvent = StoredEvent::query()->create([
        'aggregate_uuid' => \Illuminate\Support\Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\\Events\\ComplexEvent',
        'event_properties' => $complexEvent,
        'meta_data' => [],
        'created_at' => now(),
    ]);
    \assert($storedEvent instanceof StoredEvent);
    $this->assertNotNull($storedEvent);

    $freshStoredEvent = $storedEvent->fresh();
    \assert($freshStoredEvent instanceof StoredEvent);
    $this->assertNotNull($freshStoredEvent);

    $eventProperties = $freshStoredEvent->event_properties;
    $this->assertIsArray($eventProperties);
    $this->assertArrayHasKey('order', $eventProperties);
    $this->assertArrayHasKey('customer', $eventProperties);
    $this->assertArrayHasKey('payment', $eventProperties);

    $order = $eventProperties['order'] ?? null;
    $customer = $eventProperties['customer'] ?? null;
    $payment = $eventProperties['payment'] ?? null;

    $this->assertIsArray($order);
    $this->assertArrayHasKey('id', $order);
    $this->assertArrayHasKey('items', $order);
    $this->assertArrayHasKey('totals', $order);

    $this->assertIsArray($customer);
    $this->assertArrayHasKey('id', $customer);
    $this->assertArrayHasKey('name', $customer);
    $this->assertArrayHasKey('email', $customer);
    $this->assertArrayHasKey('address', $customer);

    $this->assertIsArray($payment);
    $this->assertArrayHasKey('method', $payment);
    $this->assertArrayHasKey('transaction_id', $payment);
    $this->assertArrayHasKey('status', $payment);
    $this->assertArrayHasKey('amount', $payment);

    $items = $order['items'] ?? null;
    $this->assertIsArray($items);
    $this->assertCount(50, $items);
});
