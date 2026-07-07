<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Activity\Database\Factories\SnapshotFactory;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('can create snapshot with basic information', function (): void {
    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['name' => 'Test Aggregate', 'status' => 'active'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    Assert::assertIsString($snapshot->aggregate_uuid);
    Assert::assertSame(1, $snapshot->aggregate_version);

    $state = $snapshot->state;
    Assert::assertIsArray($state);
    Assert::assertSame('Test Aggregate', $state['name']);
    Assert::assertSame('active', $state['status']);
});

test('can create snapshot with complex state', function (): void {
    $complexState = [
        'user_info' => [
            'id' => 123,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'profile' => [
                'avatar' => '/avatars/john.jpg',
                'bio' => 'Software Developer',
                'preferences' => [
                    'theme' => 'dark',
                    'language' => 'en',
                    'notifications' => true,
                ],
            ],
        ],
        'account_status' => [
            'is_active' => true,
            'last_login' => now()->subHours(2)->toISOString(),
            'login_count' => 45,
            'subscription' => [
                'plan' => 'premium',
                'expires_at' => now()->addYear()->toISOString(),
                'features' => ['api_access', 'priority_support', 'advanced_analytics'],
            ],
        ],
        'metadata' => [
            'created_by' => 'system',
            'source' => 'web_registration',
            'tags' => ['verified', 'premium_user'],
        ],
    ];

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 5,
        'state' => $complexState,
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    Assert::assertSame(5, $snapshot->aggregate_version);

    $state = $snapshot->state;
    Assert::assertIsArray($state);

    /** @var array<array-key, mixed> $userInfo */
    $userInfo = $state['user_info'];
    Assert::assertIsArray($userInfo);
    Assert::assertSame('John Doe', $userInfo['name']);

    /** @var array<array-key, mixed> $accountStatus */
    $accountStatus = $state['account_status'];
    Assert::assertIsArray($accountStatus);

    /** @var array<array-key, mixed> $subscription */
    $subscription = $accountStatus['subscription'];
    Assert::assertIsArray($subscription);
    Assert::assertSame('premium', $subscription['plan']);
    Assert::assertTrue($accountStatus['is_active']);

    /** @var array<array-key, mixed> $meta */
    $meta = $state['metadata'];
    Assert::assertIsArray($meta);
    Assert::assertIsArray($meta['tags']);
    Assert::assertContains('verified', $meta['tags']);
});

test('can manage snapshot versioning', function (): void {
    $aggregateUuid = Str::uuid()->toString();

    $snapshot1 = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'state' => ['version' => 1, 'data' => 'Initial state'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot1);

    $snapshot2 = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 2,
        'state' => ['version' => 2, 'data' => 'Updated state'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot2);

    $snapshot3 = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 3,
        'state' => ['version' => 3, 'data' => 'Final state'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot3);

    Assert::assertSame($snapshot1->aggregate_uuid, $aggregateUuid);
    Assert::assertSame($snapshot2->aggregate_uuid, $aggregateUuid);
    Assert::assertSame($snapshot3->aggregate_uuid, $aggregateUuid);

    Assert::assertSame($snapshot1->aggregate_version, 1);
    Assert::assertSame($snapshot2->aggregate_version, 2);
    Assert::assertSame($snapshot3->aggregate_version, 3);
});

test('can query snapshots by aggregate uuid', function (): void {
    $uuid1 = Str::uuid()->toString();
    $uuid2 = Str::uuid()->toString();

    SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid1,
        'aggregate_version' => 1,
        'state' => ['aggregate' => 'first', 'version' => 1],
    ]);

    SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid1,
        'aggregate_version' => 2,
        'state' => ['aggregate' => 'first', 'version' => 2],
    ]);

    SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid2,
        'aggregate_version' => 1,
        'state' => ['aggregate' => 'second', 'version' => 1],
    ]);

    $snapshots1 = Snapshot::where('aggregate_uuid', $uuid1)->get();
    $snapshots2 = Snapshot::where('aggregate_uuid', $uuid2)->get();

    Assert::assertCount(2, $snapshots1);
    Assert::assertCount(1, $snapshots2);

    $first1 = $snapshots1->first();
    $first2 = $snapshots2->first();
    Assert::assertNotNull($first1);
    Assert::assertNotNull($first2);
    Assert::assertSame($uuid1, $first1->aggregate_uuid);
    Assert::assertSame($uuid2, $first2->aggregate_uuid);
});

test('can query snapshots by version', function (): void {
    $uuid = Str::uuid()->toString();

    SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => ['version' => 1],
    ]);

    SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 5,
        'state' => ['version' => 5],
    ]);

    SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 10,
        'state' => ['version' => 10],
    ]);

    $version1Snapshot = Snapshot::where('aggregate_uuid', $uuid)
        ->where('aggregate_version', 1)
        ->first();

    $version5Snapshot = Snapshot::where('aggregate_uuid', $uuid)
        ->where('aggregate_version', 5)
        ->first();

    $version10Snapshot = Snapshot::where('aggregate_uuid', $uuid)
        ->where('aggregate_version', 10)
        ->first();

    Assert::assertNotNull($version1Snapshot);
    Assert::assertNotNull($version5Snapshot);
    Assert::assertNotNull($version10Snapshot);

    Assert::assertSame($version1Snapshot->aggregate_version, 1);
    Assert::assertSame($version5Snapshot->aggregate_version, 5);
    Assert::assertSame($version10Snapshot->aggregate_version, 10);
});

test('can handle snapshot with empty state', function (): void {
    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => [],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    $state = $snapshot->state;
    Assert::assertIsArray($state);
    Assert::assertEmpty($state);
});

test('can handle snapshot with empty array state', function (): void {
    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => [],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    $state = $snapshot->state;
    Assert::assertIsArray($state);
    Assert::assertEmpty($state);
});

test('can restore state from snapshot', function (): void {
    $originalState = [
        'user_id' => 456,
        'settings' => [
            'theme' => 'light',
            'language' => 'it',
            'notifications' => false,
        ],
        'preferences' => [
            'timezone' => 'Europe/Rome',
            'date_format' => 'd/m/Y',
            'currency' => 'EUR',
        ],
    ];

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 7,
        'state' => $originalState,
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    $restoredState = $snapshot->state;
    Assert::assertIsArray($restoredState);
    Assert::assertSame($restoredState, $originalState);
    Assert::assertSame(456, $restoredState['user_id']);

    /** @var array<array-key, mixed> $settings */
    $settings = $restoredState['settings'];
    Assert::assertIsArray($settings);
    Assert::assertSame('light', $settings['theme']);

    /** @var array<array-key, mixed> $preferences */
    $preferences = $restoredState['preferences'];
    Assert::assertIsArray($preferences);
    Assert::assertSame('Europe/Rome', $preferences['timezone']);
    Assert::assertSame('EUR', $preferences['currency']);
});

test('can compare snapshot versions', function (): void {
    $uuid = Str::uuid()->toString();

    $snapshot1 = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => ['value' => 100, 'status' => 'initial'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot1);

    $snapshot2 = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 2,
        'state' => ['value' => 200, 'status' => 'updated'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot2);

    $snapshot3 = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 3,
        'state' => ['value' => 300, 'status' => 'final'],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot3);

    Assert::assertLessThan($snapshot2->aggregate_version, $snapshot1->aggregate_version);
    Assert::assertLessThan($snapshot3->aggregate_version, $snapshot2->aggregate_version);

    /** @var array<array-key, mixed> $state1 */
    $state1 = $snapshot1->state;
    /** @var array<array-key, mixed> $state2 */
    $state2 = $snapshot2->state;
    /** @var array<array-key, mixed> $state3 */
    $state3 = $snapshot3->state;

    Assert::assertSame(100, $state1['value']);
    Assert::assertSame(200, $state2['value']);
    Assert::assertSame(300, $state3['value']);

    Assert::assertSame('initial', $state1['status']);
    Assert::assertSame('updated', $state2['status']);
    Assert::assertSame('final', $state3['status']);
});

test('can handle snapshot with timestamps', function (): void {
    $now = now();

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['created_at' => $now->toISOString()],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    Assert::assertIsString($snapshot->aggregate_uuid);
    Assert::assertSame(1, $snapshot->aggregate_version);
    Assert::assertInstanceOf(Carbon::class, $snapshot->created_at);
});

test('can query snapshots by date range', function (): void {
    $yesterday = now()->subDay();
    $today = now();
    $tomorrow = now()->addDay();

    $yesterdaySnapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['date' => 'yesterday'],
        'created_at' => $yesterday,
    ]);

    $todaySnapshotRecord = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['date' => 'today'],
        'created_at' => $today,
    ]);

    $tomorrowSnapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['date' => 'tomorrow'],
        'created_at' => $tomorrow,
    ]);
    $snapshotIds = [$yesterdaySnapshot->id, $todaySnapshotRecord->id, $tomorrowSnapshot->id];

    $todaySnapshots = Snapshot::whereKey($snapshotIds)->whereDate('created_at', today())->get();
    Assert::assertCount(1, $todaySnapshots);
    $todaySnapshot = $todaySnapshots->first();
    Assert::assertNotNull($todaySnapshot);

    /** @var array<array-key, mixed> $todayState */
    $todayState = $todaySnapshot->state;
    Assert::assertSame('today', $todayState['date']);

    $recentSnapshots = Snapshot::whereKey($snapshotIds)->where('created_at', '>=', $yesterday)->get();
    Assert::assertCount(3, $recentSnapshots);
});

test('can handle snapshot with metadata', function (): void {
    $metadata = [
        'source' => 'user_action',
        'user_id' => 789,
        'action' => 'profile_update',
        'timestamp' => now()->toISOString(),
        'ip_address' => '192.168.1.100',
        'user_agent' => 'Mozilla/5.0',
        'session_id' => Str::random(40),
    ];

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => [
            'profile' => [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
            ],
            'metadata' => $metadata,
        ],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    /** @var array<array-key, mixed> $state */
    $state = $snapshot->state;

    /** @var array<array-key, mixed> $profile */
    $profile = $state['profile'];
    Assert::assertIsArray($profile);
    Assert::assertSame('Alice Johnson', $profile['name']);
    Assert::assertSame('alice@example.com', $profile['email']);

    /** @var array<array-key, mixed> $meta */
    $meta = $state['metadata'];
    Assert::assertIsArray($meta);
    Assert::assertSame('user_action', $meta['source']);
    Assert::assertSame(789, $meta['user_id']);
    Assert::assertSame('profile_update', $meta['action']);
});
