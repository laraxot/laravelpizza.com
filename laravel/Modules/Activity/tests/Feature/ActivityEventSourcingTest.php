<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Database\Factories\StoredEventFactory;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use Spatie\SchemalessAttributes\SchemalessAttributes;

uses(TestCase::class);

test('activity event sourcing lifecycle works correctly', function () {
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user);

    $activityData = [
        'log_name' => 'user_actions',
        'description' => 'User performed test action',
        'subject_type' => User::class,
        'subject_id' => $user->id,
        'causer_type' => User::class,
        'causer_id' => $user->id,
        'properties' => ['action' => 'test', 'result' => 'success'],
        'event' => 'created',
    ];

    $activity = Activity::query()->create($activityData);
    Assert::assertNotNull($activity);
    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('user_actions', $activity->log_name);
    Assert::assertSame('User performed test action', $activity->description);
    Assert::assertSame(User::class, $activity->subject_type);
    Assert::assertSame($user->id, $activity->subject_id);
    Assert::assertSame(User::class, $activity->causer_type);
    Assert::assertSame($user->id, $activity->causer_id);
    Assert::assertSame('created', $activity->event);

    $properties = $activity->properties;
    Assert::assertInstanceOf(SchemalessAttributes::class, $properties);
    Assert::assertSame('test', $properties->get('action'));
    Assert::assertSame('success', $properties->get('result'));
});

test('activity can be queried with complex scopes', function () {
    $user1 = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user1);

    $user2 = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user2);

    $activity1 = ActivityFactory::new()->createOne([
        'log_name' => 'security',
        'event' => 'login',
        'causer_type' => User::class,
        'causer_id' => $user1->id,
    ]);
    Assert::assertInstanceOf(Activity::class, $activity1);

    $activity2 = ActivityFactory::new()->createOne([
        'log_name' => 'security',
        'event' => 'logout',
        'causer_type' => User::class,
        'causer_id' => $user2->id,
    ]);
    Assert::assertInstanceOf(Activity::class, $activity2);

    $activity3 = ActivityFactory::new()->createOne([
        'log_name' => 'audit',
        'event' => 'update',
        'causer_type' => User::class,
        'causer_id' => $user1->id,
    ]);
    Assert::assertInstanceOf(Activity::class, $activity3);

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

    Assert::assertCount(2, $securityActivities);
    Assert::assertCount(2, $user1Activities);

    /** @var Activity|null $firstLoginActivity */
    $firstLoginActivity = $loginActivities->first();
    Assert::assertCount(1, $loginActivities);
    Assert::assertNotNull($firstLoginActivity);

    Assert::assertInstanceOf(Activity::class, $firstLoginActivity);
    Assert::assertSame($activity1->id, $firstLoginActivity->id);
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
                ['id' => 2, 'amount' => 50, 'type' => 'debit'],
            ],
            'status' => 'active',
        ],
    ];

    $snapshot = Snapshot::create($snapshotData);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);
    Assert::assertSame($aggregateUuid, $snapshot->aggregate_uuid);
    Assert::assertSame(5, $snapshot->aggregate_version);

    $state = $snapshot->state;
    Assert::assertIsArray($state);
    Assert::assertArrayHasKey('balance', $state);
    Assert::assertSame(1000, $state['balance']);
    Assert::assertArrayHasKey('status', $state);
    Assert::assertSame('active', $state['status']);

    $transactions = $state['transactions'] ?? null;
    Assert::assertIsArray($transactions);
    Assert::assertCount(2, $transactions);

    /** @var Snapshot|null $retrievedSnapshot */
    $retrievedSnapshot = Snapshot::uuid($aggregateUuid)->first();
    Assert::assertNotNull($retrievedSnapshot);
    Assert::assertSame($snapshot->id, $retrievedSnapshot->id);
});

test('stored event creation and event reconstruction works', function () {
    $eventClass = 'App\\Events\\TestEvent';
    $aggregateUuid = Str::uuid()->toString();

    $eventProperties = [
        'user_id' => 1,
        'action' => 'test_action',
        'metadata' => [
            'ip' => '127.0.0.1',
            'user_agent' => 'Test Browser',
        ],
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
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);
    Assert::assertSame($eventClass, $storedEvent->event_class);
    Assert::assertSame($aggregateUuid, $storedEvent->aggregate_uuid);

    /** @var array<string, mixed> $eventProps */
    $eventProps = $storedEvent->event_properties;
    Assert::assertIsArray($eventProps);
    Assert::assertArrayHasKey('user_id', $eventProps);
    Assert::assertSame(1, $eventProps['user_id']);
    Assert::assertArrayHasKey('action', $eventProps);
    Assert::assertSame('test_action', $eventProps['action']);

    $metaData = $storedEvent->meta_data;
    Assert::assertInstanceOf(SchemalessAttributes::class, $metaData);

    $metaDataArray = $metaData->toArray();
    Assert::assertArrayHasKey('processed', $metaDataArray);
    Assert::assertTrue((bool) $metaDataArray['processed']);
    Assert::assertArrayHasKey('retry_count', $metaDataArray);
    $retryCount = $metaDataArray['retry_count'];
    Assert::assertSame(0, is_numeric($retryCount) ? (int) $retryCount : 0);
});

test('activity batch operations work correctly', function () {
    $batchUuid = Str::uuid()->toString();

    $activities = ActivityFactory::new()->count(3)->create([
        'batch_uuid' => $batchUuid,
        'log_name' => 'batch_operation',
    ]);
    Assert::assertInstanceOf(Collection::class, $activities);
    Assert::assertCount(3, $activities);

    $batchActivities = Activity::forBatch($batchUuid)->get();

    Assert::assertCount(3, $batchActivities);

    foreach ($batchActivities as $activity) {
        Assert::assertSame($batchUuid, $activity->batch_uuid);
        Assert::assertSame('batch_operation', $activity->log_name);
    }
});

test('activity with batch scope returns correct results', function () {
    $withBatch = ActivityFactory::new()->createOne(['batch_uuid' => Str::uuid()->toString()]);
    Assert::assertInstanceOf(Activity::class, $withBatch);

    ActivityFactory::new()->createOne(['batch_uuid' => null]);

    $activitiesWithBatch = Activity::hasBatch()->whereKey([$withBatch->id])->get();

    $firstActivity = $activitiesWithBatch->first();
    Assert::assertCount(1, $activitiesWithBatch);
    Assert::assertNotNull($firstActivity);
    Assert::assertSame($withBatch->id, $firstActivity->id);
});

test('activity properties support complex nested structures', function () {
    $complexProperties = [
        'user' => [
            'id' => 1,
            'name' => 'Test User',
            'roles' => ['admin', 'user'],
            'permissions' => ['read', 'write', 'delete'],
        ],
        'action' => 'complex_operation',
        'context' => [
            'request' => [
                'method' => 'POST',
                'url' => '/api/test',
                'headers' => ['Content-Type' => 'application/json'],
            ],
            'response' => [
                'status' => 200,
                'data' => ['success' => true, 'message' => 'Operation completed'],
            ],
        ],
        'timestamps' => [
            'started_at' => now()->subMinutes(5)->toISOString(),
            'completed_at' => now()->toISOString(),
            'duration' => 300,
        ],
    ];

    $activity = Activity::create([
        'log_name' => 'default',
        'description' => 'Complex properties activity',
        'properties' => $complexProperties,
        'event' => 'created',
    ]);
    Assert::assertNotNull($activity);

    $freshActivity = $activity->fresh();
    Assert::assertNotNull($freshActivity);

    $properties = $freshActivity->properties;
    Assert::assertInstanceOf(SchemalessAttributes::class, $properties);
    Assert::assertTrue($properties->has('user'));
    Assert::assertTrue($properties->has('action'));
    Assert::assertTrue($properties->has('context'));
    Assert::assertTrue($properties->has('timestamps'));

    $userData = $properties->get('user');
    $contextData = $properties->get('context');
    $timestampsData = $properties->get('timestamps');

    Assert::assertIsArray($userData);
    Assert::assertArrayHasKey('id', $userData);
    Assert::assertArrayHasKey('name', $userData);
    Assert::assertArrayHasKey('roles', $userData);
    Assert::assertArrayHasKey('permissions', $userData);

    Assert::assertIsArray($contextData);
    Assert::assertArrayHasKey('request', $contextData);
    Assert::assertArrayHasKey('response', $contextData);

    Assert::assertIsArray($timestampsData);
    Assert::assertArrayHasKey('started_at', $timestampsData);
    Assert::assertArrayHasKey('completed_at', $timestampsData);
    Assert::assertArrayHasKey('duration', $timestampsData);
});

test('snapshot state maintains data integrity with large datasets', function () {
    $largeState = [
        'users' => array_map(fn ($i) => [
            'id' => $i,
            'name' => "User {$i}",
            'email' => "user{$i}@example.com",
            'active' => $i % 2 === 0,
            'preferences' => [
                'theme' => $i % 2 === 0 ? 'dark' : 'light',
                'notifications' => true,
                'language' => 'en',
            ],
        ], range(1, 100)),
        'metadata' => [
            'generated_at' => now()->toISOString(),
            'version' => '1.0.0',
            'checksum' => md5('test'),
        ],
    ];

    $snapshot = Snapshot::create([
        'aggregate_uuid' => (string) Str::uuid(),
        'aggregate_version' => 1,
        'state' => $largeState,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    $freshSnapshot = $snapshot->fresh();
    Assert::assertNotNull($freshSnapshot);

    $state = $freshSnapshot->state;
    Assert::assertArrayHasKey('users', $state);
    Assert::assertArrayHasKey('metadata', $state);

    $users = $state['users'] ?? null;
    $metadata = $state['metadata'] ?? null;

    Assert::assertIsArray($users);
    Assert::assertCount(100, $users);
    Assert::assertIsArray($metadata);
    Assert::assertArrayHasKey('generated_at', $metadata);
    Assert::assertArrayHasKey('version', $metadata);
    Assert::assertArrayHasKey('checksum', $metadata);
});

test('stored event handles complex event properties with nested arrays', function () {
    $complexEvent = [
        'order' => [
            'id' => 12345,
            'items' => array_map(fn ($i) => [
                'product_id' => $i,
                'name' => "Product {$i}",
                'quantity' => rand(1, 5),
                'price' => rand(1000, 5000) / 100,
                'attributes' => ['color' => 'red', 'size' => 'M'],
            ], range(1, 50)),
            'totals' => [
                'subtotal' => 1234.56,
                'tax' => 123.46,
                'shipping' => 15.00,
                'total' => 1373.02,
            ],
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
                'country' => 'US',
            ],
        ],
        'payment' => [
            'method' => 'credit_card',
            'transaction_id' => 'txn_123456789',
            'status' => 'completed',
            'amount' => 1373.02,
        ],
    ];

    $storedEvent = StoredEventFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\\Events\\ComplexEvent',
        'event_properties' => $complexEvent,
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $freshStoredEvent = $storedEvent->fresh();
    Assert::assertNotNull($freshStoredEvent);

    /** @var array<string, mixed> $eventProperties */
    $eventProperties = $freshStoredEvent->event_properties;
    Assert::assertIsArray($eventProperties);
    Assert::assertArrayHasKey('order', $eventProperties);
    Assert::assertArrayHasKey('customer', $eventProperties);
    Assert::assertArrayHasKey('payment', $eventProperties);

    $order = $eventProperties['order'] ?? null;
    $customer = $eventProperties['customer'] ?? null;
    $payment = $eventProperties['payment'] ?? null;

    Assert::assertIsArray($order);
    Assert::assertArrayHasKey('id', $order);
    Assert::assertArrayHasKey('items', $order);
    Assert::assertArrayHasKey('totals', $order);

    Assert::assertIsArray($customer);
    Assert::assertArrayHasKey('id', $customer);
    Assert::assertArrayHasKey('name', $customer);
    Assert::assertArrayHasKey('email', $customer);
    Assert::assertArrayHasKey('address', $customer);

    Assert::assertIsArray($payment);
    Assert::assertArrayHasKey('method', $payment);
    Assert::assertArrayHasKey('transaction_id', $payment);
    Assert::assertArrayHasKey('status', $payment);
    Assert::assertArrayHasKey('amount', $payment);

    $items = $order['items'] ?? null;
    Assert::assertIsArray($items);
    Assert::assertCount(50, $items);
});
