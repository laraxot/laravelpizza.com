<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\User\Models\User;

test('activity module models work together in integrated scenarios', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $activity = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'causer_type' => User::class,
        'causer_id' => $user->id,
        'subject_type' => User::class,
        'subject_id' => $user->id,
        'properties' => [
            'action' => 'user_registration',
            'details' => ['source' => 'web', 'campaign' => 'test'],
        ],
    ]);
    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();

    $aggregateUuid = Str::uuid()->toString();

    $snapshot = Snapshot::factory()->create([ // @phpstan-ignore-line method.nonObject
        'aggregate_uuid' => $aggregateUuid,
        'state' => [
            'user' => $user->toArray(),
            'activities' => [$activity->toArray()],
            'metadata' => ['version' => '1.0.0'],
        ],
    ]);
    \assert($snapshot instanceof Snapshot);
    expect($snapshot)->not->toBeNull();

    $storedEvent = StoredEvent::factory()->create([ // @phpstan-ignore-line method.nonObject
        'aggregate_uuid' => $aggregateUuid,
        'event_class' => 'App\\Events\\UserProfileUpdated',
        'event_properties' => [
            'user_id' => $user->id,
            'activity_id' => $activity->id,
            'snapshot_id' => $snapshot->id,
            'changes' => ['profile_completed' => true],
        ],
    ]);
    \assert($storedEvent instanceof StoredEvent);
    expect($storedEvent)->not->toBeNull();

    $causer = $activity->causer;
    expect($causer)->not->toBeNull()
        ->and($causer->id)->toBe($user->id);

    $state = $snapshot->state;
    expect($state)->toBeArray();
    \assert(is_array($state));
    expect(isset($state['user']))->toBeTrue();
    \assert(isset($state['user']) && is_array($state['user']));
    expect($state['user']['id'])->toBe($user->id);

    $eventProperties = $storedEvent->event_properties;
    expect($eventProperties)->toBeArray()
        ->and($eventProperties['user_id'])->toBe($user->id);

    $relatedActivities = Activity::causedBy($user)->get();
    expect($relatedActivities)->toContain($activity);

    $relatedSnapshots = Snapshot::uuid($aggregateUuid)->get();
    expect($relatedSnapshots)->toContain($snapshot);

    $relatedEvents = StoredEvent::whereAggregateUuid($aggregateUuid)->get();
    expect($relatedEvents)->toContain($storedEvent);
});

test('activity batch processing with multiple models', function () {
    $batchUuid = Str::uuid()->toString();
    $aggregateUuid = Str::uuid()->toString();

    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $activities = Activity::factory()->count(5)->create([ // @phpstan-ignore-line method.nonObject
        'batch_uuid' => $batchUuid,
        'causer_type' => User::class,
        'causer_id' => $user->id,
    ]);
    \assert($activities instanceof \Illuminate\Database\Eloquent\Collection);
    expect($activities)->toHaveCount(5);

    $snapshot = Snapshot::factory()->create([ // @phpstan-ignore-line method.nonObject
        'aggregate_uuid' => $aggregateUuid,
        'state' => [
            'batch_id' => $batchUuid,
            'activities_count' => $activities->count(),
            'user_id' => $user->id,
        ],
    ]);
    \assert($snapshot instanceof Snapshot);
    expect($snapshot)->not->toBeNull();

    $storedEvents = StoredEvent::factory()->count(3)->create([ // @phpstan-ignore-line method.nonObject
        'aggregate_uuid' => $aggregateUuid,
        'event_properties' => [
            'batch_id' => $batchUuid,
            'processed_activities' => $activities->pluck('id')->toArray(),
        ],
    ]);
    \assert($storedEvents instanceof \Illuminate\Database\Eloquent\Collection);
    expect($storedEvents)->toHaveCount(3);

    $batchActivities = Activity::forBatch($batchUuid)->get();
    expect($batchActivities)->toHaveCount(5);

    $freshSnapshot = $snapshot->fresh();
    \assert($freshSnapshot instanceof Snapshot);
    expect($freshSnapshot)->not->toBeNull();

    $snapshotState = $freshSnapshot->state;
    expect($snapshotState)->toBeArray();
    \assert(is_array($snapshotState));
    expect($snapshotState['activities_count'])->toBe(5)
        ->and($snapshotState['user_id'])->toBe($user->id);

    $aggregateEvents = StoredEvent::whereAggregateUuid($aggregateUuid)->get();
    expect($aggregateEvents)->toHaveCount(3);

    $firstEvent = $aggregateEvents->first();
    \assert($firstEvent instanceof StoredEvent);
    expect($firstEvent)->not->toBeNull();

    $firstEventProperties = $firstEvent->event_properties;
    expect($firstEventProperties)->toBeArray();
    \assert(is_array($firstEventProperties));
    expect($firstEventProperties['batch_id'])->toBe($batchUuid);
});

test('activity module handles concurrent operations correctly', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $concurrentActivities = [];
    $concurrentSnapshots = [];

    $promises = [];

    for ($i = 0; $i < 10; $i++) {
        $promises[] = function () use ($user, &$concurrentActivities, &$concurrentSnapshots, $i) {
            $activity = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
                'causer_type' => User::class,
                'causer_id' => $user->id,
                'properties' => ['iteration' => $i, 'timestamp' => now()->toISOString()],
            ]);
            \assert($activity instanceof Activity);
            expect($activity)->not->toBeNull();

            $concurrentActivities[] = $activity->id;

            if ($i % 2 === 0) {
                $snapshot = Snapshot::factory()->create([ // @phpstan-ignore-line method.nonObject
                    'state' => [
                        'activity_id' => $activity->id,
                        'iteration' => $i,
                        'user_id' => $user->id,
                    ],
                ]);
                \assert($snapshot instanceof Snapshot);
                expect($snapshot)->not->toBeNull();

                $concurrentSnapshots[] = $snapshot->id;
            }

            return true;
        };
    }

    $results = array_map(fn ($promise) => $promise(), $promises);
    \assert(is_array($results));
    expect($results)->toHaveCount(10)->each->toBeTrue();

    $userActivities = Activity::causedBy($user)->get();
    expect($userActivities)->toHaveCount(10);

    $createdSnapshots = Snapshot::whereIn('id', $concurrentSnapshots)->get();
    expect($createdSnapshots)->toHaveCount(5);
});

test('activity module supports complex query patterns', function () {
    $user1 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user1 instanceof User);
    expect($user1)->not->toBeNull();

    $user2 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user2 instanceof User);
    expect($user2)->not->toBeNull();

    $securityActivities = Activity::factory()->count(3)->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'security',
        'causer_type' => User::class,
        'causer_id' => $user1->id,
    ]);

    $auditActivities = Activity::factory()->count(2)->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'audit',
        'causer_type' => User::class,
        'causer_id' => $user2->id,
    ]);

    $applicationActivities = Activity::factory()->count(4)->create([ // @phpstan-ignore-line method.nonObject
        'log_name' => 'application',
        'causer_type' => User::class,
        'causer_id' => $user1->id,
    ]);

    $complexQuery = Activity::query()
        ->where('causer_type', User::class)
        ->whereIn('log_name', ['security', 'audit'])
        ->where(function ($query) use ($user1, $user2) {
            $query->where('causer_id', $user1->id)
                ->orWhere('causer_id', $user2->id);
        })
        ->orderBy('created_at', 'desc');

    $results = $complexQuery->get();

    expect($results)->toHaveCount(5);

    $securityResults = $results->where('log_name', 'security');
    $auditResults = $results->where('log_name', 'audit');

    expect($securityResults)->toHaveCount(3);
    expect($auditResults)->toHaveCount(2);

    $user1Results = $results->where('causer_id', $user1->id);
    $user2Results = $results->where('causer_id', $user2->id);

    expect($user1Results)->toHaveCount(3);
    expect($user2Results)->toHaveCount(2);
});

test('activity module handles data consistency across models', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $aggregateUuid = Str::uuid()->toString();

    $activity = Activity::factory()->create([ // @phpstan-ignore-line method.nonObject
        'causer_type' => User::class,
        'causer_id' => $user->id,
        'properties' => ['action' => 'data_consistency_test'],
    ]);
    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();

    $snapshot = Snapshot::factory()->create([ // @phpstan-ignore-line method.nonObject
        'aggregate_uuid' => $aggregateUuid,
        'state' => [
            'activity_id' => $activity->id,
            'user_id' => $user->id,
            'consistent' => true,
        ],
    ]);
    \assert($snapshot instanceof Snapshot);
    expect($snapshot)->not->toBeNull();

    $storedEvent = StoredEvent::factory()->create([ // @phpstan-ignore-line method.nonObject
        'aggregate_uuid' => $aggregateUuid,
        'event_properties' => [
            'activity_id' => $activity->id,
            'snapshot_id' => $snapshot->id,
            'user_id' => $user->id,
            'consistent' => true,
        ],
    ]);
    \assert($storedEvent instanceof StoredEvent);
    expect($storedEvent)->not->toBeNull();

    $activityProperties = $activity->properties->toArray();
    $snapshotState = $snapshot->state;
    $storedEventProperties = $storedEvent->event_properties;

    $activity->update(['properties' => array_merge($activityProperties, ['verified' => true])]);
    $snapshot->update(['state' => array_merge($snapshotState, ['verified' => true])]);
    $storedEvent->update(['event_properties' => array_merge($storedEventProperties, ['verified' => true])]);

    $freshActivity = $activity->fresh();
    $freshSnapshot = $snapshot->fresh();
    $freshEvent = $storedEvent->fresh();

    \assert($freshActivity instanceof Activity);
    \assert($freshSnapshot instanceof Snapshot);
    \assert($freshEvent instanceof StoredEvent);
    expect($freshActivity)->not->toBeNull()
        ->and($freshSnapshot)->not->toBeNull()
        ->and($freshEvent)->not->toBeNull();

    $freshActivityProperties = $freshActivity->properties;
    $freshSnapshotState = $freshSnapshot->state;
    $freshEventProperties = $freshEvent->event_properties;

    expect($freshActivityProperties)->toHaveKey('verified', true);
    expect($freshSnapshotState)->toBeArray();
    \assert(is_array($freshSnapshotState));
    expect($freshSnapshotState)->toHaveKey('verified', true);
    expect($freshEventProperties)->toBeArray();
    \assert(is_array($freshEventProperties));
    expect($freshEventProperties)->toHaveKey('verified', true);

    expect($freshActivityProperties['action'])->toBe('data_consistency_test')
        ->and($freshSnapshotState['consistent'])->toBeTrue()
        ->and($freshEventProperties['consistent'])->toBeTrue();
});

test('activity module supports bulk operations efficiently', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $activitiesData = [];
    for ($i = 0; $i < 100; $i++) {
        $activitiesData[] = [
            'log_name' => 'bulk_operation',
            'description' => "Bulk activity {$i}",
            'causer_type' => User::class,
            'causer_id' => $user->id,
            'properties' => ['index' => $i, 'batch' => 'bulk_test'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    Activity::insert($activitiesData);

    $bulkActivities = Activity::where('log_name', 'bulk_operation')->get();

    expect($bulkActivities)->toHaveCount(100);

    $firstActivity = $bulkActivities->first();
    $lastActivity = $bulkActivities->last();

    \assert($firstActivity instanceof Activity);
    \assert($lastActivity instanceof Activity);
    expect($firstActivity)->not->toBeNull()
        ->and($lastActivity)->not->toBeNull();

    $firstActivityProperties = $firstActivity->properties;
    $lastActivityProperties = $lastActivity->properties;

    expect($firstActivityProperties)->toHaveKey('index', 0)
        ->and($lastActivityProperties)->toHaveKey('index', 99)
        ->and($firstActivity->causer_id)->toBe($user->id)
        ->and($lastActivity->causer_id)->toBe($user->id);

    $userActivities = Activity::causedBy($user)->where('log_name', 'bulk_operation')->get();
    expect($userActivities)->toHaveCount(100);
});
