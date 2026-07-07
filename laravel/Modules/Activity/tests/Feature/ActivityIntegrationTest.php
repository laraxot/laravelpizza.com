<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Database\Factories\SnapshotFactory;
use Modules\Activity\Database\Factories\StoredEventFactory;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

test('activity module models work together in integrated scenarios', function () {
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user);

    $activity = ActivityFactory::new()->createOne([
        'causer_type' => User::class,
        'causer_id' => $user->id,
        'subject_type' => User::class,
        'subject_id' => $user->id,
        'properties' => [
            'action' => 'user_registration',
            'details' => ['source' => 'web', 'campaign' => 'test'],
        ],
    ]);
    Assert::assertInstanceOf(Activity::class, $activity);

    $aggregateUuid = Str::uuid()->toString();

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'state' => [
            'user' => $user->toArray(),
            'activities' => [$activity->toArray()],
            'metadata' => ['version' => '1.0.0'],
        ],
    ]);
    Assert::assertInstanceOf(Snapshot::class, $snapshot);

    $storedEvent = StoredEvent::create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\\Events\\UserProfileUpdated',
        'event_properties' => [
            'user_id' => $user->id,
            'activity_id' => $activity->id,
            'snapshot_id' => $snapshot->id,
            'changes' => ['profile_completed' => true],
        ],
        'meta_data' => ['source' => 'test'],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $causer = $activity->causer;
    Assert::assertInstanceOf(User::class, $causer);
    Assert::assertSame($user->id, $causer->id);

    $state = $snapshot->state;
    Assert::assertIsArray($state);
    Assert::assertArrayHasKey('user', $state);
    /** @var array<string, mixed> $stateUser */
    $stateUser = $state['user'];
    Assert::assertIsArray($stateUser);
    Assert::assertSame($user->id, $stateUser['id']);

    $eventProperties = $storedEvent->event_properties;
    Assert::assertIsArray($eventProperties);
    Assert::assertSame($user->id, $eventProperties['user_id']);

    $relatedActivities = Activity::query()
        ->where('causer_type', User::class)
        ->where('causer_id', (string) $user->id)
        ->get();
    Assert::assertContains($activity->id, $relatedActivities->pluck('id')->all());

    $relatedSnapshots = Snapshot::uuid($aggregateUuid)->get();
    Assert::assertContains($snapshot->id, $relatedSnapshots->pluck('id')->all());

    $relatedEvents = StoredEvent::whereAggregateUuid($aggregateUuid)->get();
    Assert::assertContains($storedEvent->id, $relatedEvents->pluck('id')->all());
});

test('activity batch processing with multiple models', function () {
    $batchUuid = Str::uuid()->toString();
    $aggregateUuid = Str::uuid()->toString();

    $user = UserFactory::new()->createOne();
    Assert::assertNotNull($user);

    /** @var Collection<int, Activity> $activities */
    $activities = ActivityFactory::new()->count(5)->create([
        'batch_uuid' => $batchUuid,
        'causer_type' => User::class,
        'causer_id' => $user->id,
    ]);
    Assert::assertCount(5, $activities);

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'state' => [
            'batch_id' => $batchUuid,
            'activities_count' => $activities->count(),
            'user_id' => $user->id,
        ],
    ]);
    Assert::assertNotNull($snapshot);

    $storedEventIds = [];
    for ($i = 0; $i < 3; $i++) {
        $stored = StoredEvent::create([
            'aggregate_uuid' => $aggregateUuid,
            'aggregate_version' => $i + 1,
            'event_version' => 1,
            'event_class' => 'App\\Events\\UserLoggedOut',
            'event_properties' => [
                'batch_id' => $batchUuid,
                'processed_activities' => $activities->pluck('id')->toArray(),
            ],
            'meta_data' => ['source' => 'test'],
            'created_at' => now(),
        ]);
        $storedEventIds[] = $stored->id;
    }
    Assert::assertCount(3, $storedEventIds);

    $batchActivities = Activity::forBatch($batchUuid)->get();
    Assert::assertCount(5, $batchActivities);

    $freshSnapshot = $snapshot->fresh();
    Assert::assertNotNull($freshSnapshot);

    $snapshotState = $freshSnapshot->state;
    Assert::assertIsArray($snapshotState);
    Assert::assertSame(5, $snapshotState['activities_count']);
    Assert::assertSame($user->id, $snapshotState['user_id']);

    $aggregateEvents = StoredEvent::whereAggregateUuid($aggregateUuid)->get();
    Assert::assertCount(3, $aggregateEvents);

    $firstEvent = $aggregateEvents->first();
    Assert::assertInstanceOf(StoredEvent::class, $firstEvent);

    $firstEventProperties = $firstEvent->event_properties;
    Assert::assertIsArray($firstEventProperties);
    Assert::assertSame($batchUuid, $firstEventProperties['batch_id']);
});

test('activity module handles concurrent operations correctly', function () {
    $user = UserFactory::new()->createOne();
    Assert::assertNotNull($user);

    $concurrentActivities = [];
    $concurrentSnapshots = [];

    $promises = [];

    for ($i = 0; $i < 10; $i++) {
        $promises[] = function () use ($user, &$concurrentActivities, &$concurrentSnapshots, $i) {
            $activity = ActivityFactory::new()->createOne([
                'causer_type' => User::class,
                'causer_id' => $user->id,
                'properties' => ['iteration' => $i, 'timestamp' => now()->toISOString()],
            ]);
            Assert::assertNotNull($activity);

            $concurrentActivities[] = $activity->id;

            if ($i % 2 === 0) {
                $snapshot = SnapshotFactory::new()->createOne([
                    'state' => [
                        'activity_id' => $activity->id,
                        'iteration' => $i,
                        'user_id' => $user->id,
                    ],
                ]);
                Assert::assertNotNull($snapshot);

                $concurrentSnapshots[] = $snapshot->id;
            }

            return true;
        };
    }

    $results = array_map(fn ($promise) => $promise(), $promises);
    Assert::assertCount(10, $results);
    foreach ($results as $result) {
        Assert::assertTrue($result);
    }

    $userActivities = Activity::query()
        ->where('causer_type', User::class)
        ->where('causer_id', (string) $user->id)
        ->get();
    Assert::assertCount(10, $userActivities);

    $createdSnapshots = Snapshot::whereIn('id', $concurrentSnapshots)->get();
    Assert::assertCount(5, $createdSnapshots);
});

test('activity module supports complex query patterns', function () {
    $user1 = UserFactory::new()->createOne();
    Assert::assertNotNull($user1);

    $user2 = UserFactory::new()->createOne();
    Assert::assertNotNull($user2);

    $securityActivities = ActivityFactory::new()->createOne([
        'log_name' => 'security',
        'causer_type' => User::class,
        'causer_id' => $user1->id,
    ]);
    Assert::assertInstanceOf(Activity::class, $securityActivities);
    $auditActivities = ActivityFactory::new()->createOne([
        'log_name' => 'audit',
        'causer_type' => User::class,
        'causer_id' => $user2->id,
    ]);
    Assert::assertInstanceOf(Activity::class, $auditActivities);
    $applicationActivities = ActivityFactory::new()->createOne([
        'log_name' => 'application',
        'causer_type' => User::class,
        'causer_id' => $user1->id,
    ]);
    Assert::assertInstanceOf(Activity::class, $applicationActivities);
    $complexQuery = Activity::query()
        ->where('causer_type', User::class)
        ->whereIn('log_name', ['security', 'audit'])
        ->where(function ($query) use ($user1, $user2) {
            $query->where('causer_id', $user1->id)
                ->orWhere('causer_id', $user2->id);
        })
        ->orderBy('created_at', 'desc');

    $results = $complexQuery->get();

    Assert::assertCount(2, $results);

    $securityResults = $results->where('log_name', 'security');
    $auditResults = $results->where('log_name', 'audit');

    Assert::assertCount(1, $securityResults);
    Assert::assertCount(1, $auditResults);

    $user1Results = $results->where('causer_id', $user1->id);
    $user2Results = $results->where('causer_id', $user2->id);

    Assert::assertCount(1, $user1Results);
    Assert::assertCount(1, $user2Results);
});

test('activity module handles data consistency across models', function () {
    $user = UserFactory::new()->createOne();
    Assert::assertNotNull($user);

    $aggregateUuid = Str::uuid()->toString();

    $activity = ActivityFactory::new()->createOne([
        'causer_type' => User::class,
        'causer_id' => $user->id,
        'properties' => ['action' => 'data_consistency_test'],
    ]);
    Assert::assertNotNull($activity);

    $snapshot = SnapshotFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'state' => [
            'activity_id' => $activity->id,
            'user_id' => $user->id,
            'consistent' => true,
        ],
    ]);
    Assert::assertNotNull($snapshot);

    $storedEvent = StoredEventFactory::new()->createOne([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'event_version' => 1,
        'event_class' => 'App\\Events\\UserProfileUpdated',
        'event_properties' => [
            'user_id' => $user->id,
            'activity_id' => $activity->id,
            'snapshot_id' => $snapshot->id,
            'changes' => ['profile_completed' => true],
        ],
        'meta_data' => [],
        'created_at' => now(),
    ]);
    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);

    $activityPropertiesValue = $activity->properties;
    Assert::assertNotNull($activityPropertiesValue);
    $activityProperties = is_array($activityPropertiesValue)
        ? $activityPropertiesValue
        : $activityPropertiesValue->all();
    $snapshotStateValue = $snapshot->state;
    Assert::assertNotNull($snapshotStateValue);
    $snapshotState = is_array($snapshotStateValue)
        ? $snapshotStateValue
        : $snapshotStateValue->all();
    $storedEventPropertiesValue = $storedEvent->event_properties;
    Assert::assertIsArray($storedEventPropertiesValue);
    $storedEventProperties = $storedEventPropertiesValue;

    $activity->update(['properties' => array_merge($activityProperties, ['verified' => true])]);
    $snapshot->update(['state' => array_merge($snapshotState, ['verified' => true])]);
    $storedEvent->update(['event_properties' => array_merge($storedEventProperties, ['verified' => true])]);

    $freshActivity = $activity->fresh();
    $freshSnapshot = $snapshot->fresh();
    $freshEvent = $storedEvent->fresh();

    Assert::assertNotNull($freshActivity);
    Assert::assertNotNull($freshSnapshot);
    Assert::assertNotNull($freshEvent);

    $freshActivityPropertiesValue = $freshActivity->properties;
    Assert::assertNotNull($freshActivityPropertiesValue);
    $freshActivityProperties = is_array($freshActivityPropertiesValue)
        ? $freshActivityPropertiesValue
        : $freshActivityPropertiesValue->all();
    $freshSnapshotState = $freshSnapshot->state;
    $freshEventProperties = $freshEvent->event_properties;

    Assert::assertArrayHasKey('verified', $freshActivityProperties);
    Assert::assertIsArray($freshSnapshotState);
    Assert::assertArrayHasKey('verified', $freshSnapshotState);
    Assert::assertIsArray($freshEventProperties);
    Assert::assertArrayHasKey('verified', $freshEventProperties);
    Assert::assertSame('data_consistency_test', $freshActivityProperties['action']);
    Assert::assertTrue($freshSnapshotState['consistent']);
    Assert::assertArrayHasKey('changes', $freshEventProperties);
    /** @var array<string, mixed> $changes */
    $changes = $freshEventProperties['changes'];
    Assert::assertIsArray($changes);
    Assert::assertArrayHasKey('profile_completed', $changes);
});

test('activity module supports bulk operations efficiently', function () {
    $user = UserFactory::new()->createOne();
    Assert::assertNotNull($user);

    $activitiesData = [];
    for ($i = 0; $i < 100; $i++) {
        $activitiesData[] = [
            'log_name' => 'bulk_operation',
            'description' => "Bulk activity {$i}",
            'causer_type' => User::class,
            'causer_id' => (string) $user->id,
            'properties' => json_encode(['index' => $i, 'batch' => 'bulk_test']),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ];
    }

    Activity::insert($activitiesData);

    $bulkActivities = Activity::where('log_name', 'bulk_operation')->get();

    Assert::assertCount(100, $bulkActivities);

    $firstActivity = $bulkActivities->first();
    $lastActivity = $bulkActivities->last();

    Assert::assertNotNull($firstActivity);
    Assert::assertNotNull($lastActivity);

    $firstActivityPropertiesValue = $firstActivity->properties;
    Assert::assertNotNull($firstActivityPropertiesValue);
    $firstActivityProperties = is_array($firstActivityPropertiesValue)
        ? $firstActivityPropertiesValue
        : $firstActivityPropertiesValue->all();
    $lastActivityPropertiesValue = $lastActivity->properties;
    Assert::assertNotNull($lastActivityPropertiesValue);
    $lastActivityProperties = is_array($lastActivityPropertiesValue)
        ? $lastActivityPropertiesValue
        : $lastActivityPropertiesValue->all();

    Assert::assertSame($user->id, $firstActivity->causer_id);
    Assert::assertSame($user->id, $lastActivity->causer_id);
    Assert::assertArrayHasKey('index', $firstActivityProperties);
    Assert::assertSame(0, $firstActivityProperties['index']);
    Assert::assertArrayHasKey('index', $lastActivityProperties);
    Assert::assertSame(99, $lastActivityProperties['index']);
    $userActivities = Activity::query()
        ->where('causer_type', User::class)
        ->where('causer_id', (string) $user->id)
        ->where('log_name', 'bulk_operation')
        ->get();
    Assert::assertCount(100, $userActivities);
});
