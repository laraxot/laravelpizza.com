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
    expect($user)->not->toBeNull();

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
    expect($activity)->not->toBeNull();

    expect($activity)
        ->toBeInstanceOf(Activity::class);

    expect($activity->log_name)->toBe('user_actions')
        ->and($activity->description)->toBe('User performed test action')
        ->and($activity->subject_type)->toBe(User::class)
        ->and($activity->subject_id)->toBe($user->id)
        ->and($activity->causer_type)->toBe(User::class)
        ->and($activity->causer_id)->toBe($user->id)
        ->and($activity->event)->toBe('created');

    $properties = $activity->properties;
    expect($properties)->toHaveKey('action', 'test')
        ->and($properties)->toHaveKey('result', 'success');
});

test('activity can be queried with complex scopes', function () {
    $user1 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user1 instanceof User);
    expect($user1)->not->toBeNull();

    $user2 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user2 instanceof User);
    expect($user2)->not->toBeNull();

    $activity1 = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'security',
        'event' => 'login',
        'causer_type' => User::class,
        'causer_id' => $user1->id
    ]);
    \assert($activity1 instanceof Activity);
    expect($activity1)->not->toBeNull();

    $activity2 = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'security',
        'event' => 'logout',
        'causer_type' => User::class,
        'causer_id' => $user2->id
    ]);
    \assert($activity2 instanceof Activity);
    expect($activity2)->not->toBeNull();

    $activity3 = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'audit',
        'event' => 'update',
        'causer_type' => User::class,
        'causer_id' => $user1->id
    ]);
    \assert($activity3 instanceof Activity);

    $securityActivities = Activity::inLog('security')->get();
    $user1Activities = Activity::query()
        ->where('causer_type', User::class)
        ->where('causer_id', $user1->id)
        ->get();
    $loginActivities = Activity::forEvent('login')->get();

    expect($securityActivities)->toHaveCount(2);
    expect($user1Activities)->toHaveCount(2);

    /** @var Activity|null $firstLoginActivity */
    $firstLoginActivity = $loginActivities->first();
    expect($loginActivities)->toHaveCount(1)
        ->and($firstLoginActivity)->not->toBeNull();

    // Type narrowing assertion
    expect($firstLoginActivity)->toBeInstanceOf(Activity::class);
    expect($firstLoginActivity->id)->toBe($activity1->id);
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
    expect($snapshot)->not->toBeNull();

    expect($snapshot->aggregate_uuid)->toBe($aggregateUuid)
        ->and($snapshot->aggregate_version)->toBe(5);

    $state = $snapshot->state;
    expect($state)->toBeArray()
        ->toHaveKey('balance', 1000)
        ->toHaveKey('status', 'active');

    $transactions = $state['transactions'] ?? null;
    expect($transactions)->toBeArray()->toHaveCount(2);

    /** @var Snapshot|null $retrievedSnapshot */
    $retrievedSnapshot = Snapshot::uuid($aggregateUuid)->first();
    \assert($retrievedSnapshot instanceof Snapshot);
    expect($retrievedSnapshot)->not->toBeNull()
        ->and($retrievedSnapshot->id)->toBe($snapshot->id);
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
    expect($storedEvent)->not->toBeNull();

    expect($storedEvent->event_class)->toBe($eventClass);
    expect($storedEvent->aggregate_uuid)->toBe($aggregateUuid);
    expect($storedEvent->event_properties)->toHaveKey('user_id', 1);
    expect($storedEvent->event_properties)->toHaveKey('action', 'test_action');

    $metaData = $storedEvent->meta_data;
    expect($metaData)->toBeInstanceOf(\Spatie\SchemalessAttributes\SchemalessAttributes::class);

    $metaDataArray = $metaData->toArray();
    expect($metaDataArray)->toBeArray()
        ->toHaveKey('processed', true)
        ->toHaveKey('retry_count', 0);
});

test('activity batch operations work correctly', function () {
    $batchUuid = Str::uuid()->toString();

    $activities = Activity::factory()->count(3)->create([ // @phpstan-ignore-line method.nonObject
        'batch_uuid' => $batchUuid,
        'log_name' => 'batch_operation'
    ]);
    \assert($activities instanceof \Illuminate\Database\Eloquent\Collection);
    expect($activities)->toHaveCount(3);

    $batchActivities = Activity::forBatch($batchUuid)->get();

    expect($batchActivities)->toHaveCount(3);
    
    foreach ($batchActivities as $activity) {
        \assert($activity instanceof Activity);
        expect($activity->batch_uuid)->toBe($batchUuid)
            ->and($activity->log_name)->toBe('batch_operation');
    }
});

test('activity with batch scope returns correct results', function () {
    $withBatch = Activity::factory()->create(['batch_uuid' => Str::uuid()->toString()]); // @phpstan-ignore-line method.nonObject
    \assert($withBatch instanceof Activity);
    expect($withBatch)->not->toBeNull();

    Activity::factory()->create(['batch_uuid' => null]); // @phpstan-ignore-line method.nonObject

    $activitiesWithBatch = Activity::hasBatch()->get();

    $firstActivity = $activitiesWithBatch->first();
    expect($activitiesWithBatch)->toHaveCount(1);
    \assert($firstActivity instanceof Activity);
    expect($firstActivity)->not->toBeNull();
    expect($firstActivity->id)->toBe($withBatch->id);
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
    expect($activity)->not->toBeNull();

    $freshActivity = $activity->fresh();
    \assert($freshActivity instanceof Activity);
    expect($freshActivity)->not->toBeNull();

    $properties = $freshActivity->properties;
    expect($properties)
        ->toBeInstanceOf(Collection::class)
        ->toHaveKey('user')
        ->toHaveKey('action')
        ->toHaveKey('context')
        ->toHaveKey('timestamps');

    $userData = $properties->get('user');
    $contextData = $properties->get('context');
    $timestampsData = $properties->get('timestamps');

    expect($userData)->toBeArray()->toHaveKeys(['id', 'name', 'roles', 'permissions'])
        ->and($contextData)->toBeArray()->toHaveKeys(['request', 'response'])
        ->and($timestampsData)->toBeArray()->toHaveKeys(['started_at', 'completed_at', 'duration']);
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
    expect($snapshot)->not->toBeNull();

    $freshSnapshot = $snapshot->fresh();
    \assert($freshSnapshot instanceof Snapshot);
    expect($freshSnapshot)->not->toBeNull();

    $state = $freshSnapshot->state;
    expect($state)
        ->toBeArray()
        ->toHaveKey('users')
        ->toHaveKey('metadata');

    $users = $state['users'] ?? null;
    $metadata = $state['metadata'] ?? null;

    expect($users)->toBeArray()->toHaveCount(100)
        ->and($metadata)->toBeArray()->toHaveKeys(['generated_at', 'version', 'checksum']);
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
    expect($storedEvent)->not->toBeNull();

    $freshStoredEvent = $storedEvent->fresh();
    \assert($freshStoredEvent instanceof StoredEvent);
    expect($freshStoredEvent)->not->toBeNull();

    $eventProperties = $freshStoredEvent->event_properties;
    expect($eventProperties)
        ->toBeArray()
        ->toHaveKey('order')
        ->toHaveKey('customer')
        ->toHaveKey('payment');

    $order = $eventProperties['order'] ?? null;
    $customer = $eventProperties['customer'] ?? null;
    $payment = $eventProperties['payment'] ?? null;

    expect($order)->toBeArray()->toHaveKeys(['id', 'items', 'totals'])
        ->and($customer)->toBeArray()->toHaveKeys(['id', 'name', 'email', 'address'])
        ->and($payment)->toBeArray()->toHaveKeys(['method', 'transaction_id', 'status', 'amount']);

    $items = $order['items'] ?? null;
    expect($items)->toBeArray()->toHaveCount(50);
});
