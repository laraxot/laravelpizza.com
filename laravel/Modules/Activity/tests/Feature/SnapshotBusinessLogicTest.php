<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

it('can create snapshot with basic information', function (): void {
    $snapshot = Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['name' => 'Test Aggregate', 'status' => 'active'],
    ]);

    expect($snapshot->aggregate_uuid)->toBeString();
    expect($snapshot->aggregate_version)->toBe(1);
    expect($snapshot->state)->toBeArray();
    expect($snapshot->state['name'])->toBe('Test Aggregate');
    expect($snapshot->state['status'])->toBe('active');
});

it('can create snapshot with complex state', function (): void {
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

    $snapshot = Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 5,
        'state' => $complexState,
    ]);

    expect($snapshot->aggregate_version)->toBe(5);
    expect($snapshot->state)->toBeArray();
    expect($snapshot->state['user_info']['name'])->toBe('John Doe');
    expect($snapshot->state['account_status']['subscription']['plan'])->toBe('premium');
    expect($snapshot->state['account_status']['is_active'])->toBeTrue();
    expect($snapshot->state['metadata']['tags'])->toContain('verified');
});

it('can manage snapshot versioning', function (): void {
    $aggregateUuid = Str::uuid()->toString();

    // Crea snapshot con versioni progressive
    $snapshot1 = Snapshot::factory()->create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 1,
        'state' => ['version' => 1, 'data' => 'Initial state'],
    ]);

    $snapshot2 = Snapshot::factory()->create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 2,
        'state' => ['version' => 2, 'data' => 'Updated state'],
    ]);

    $snapshot3 = Snapshot::factory()->create([
        'aggregate_uuid' => $aggregateUuid,
        'aggregate_version' => 3,
        'state' => ['version' => 3, 'data' => 'Final state'],
    ]);

    // Verifica che tutti gli snapshot abbiano lo stesso UUID ma versioni diverse
    expect($aggregateUuid)->toBe($snapshot1->aggregate_uuid);
    expect($aggregateUuid)->toBe($snapshot2->aggregate_uuid);
    expect($aggregateUuid)->toBe($snapshot3->aggregate_uuid);

    expect(1)->toBe($snapshot1->aggregate_version);
    expect(2)->toBe($snapshot2->aggregate_version);
    expect(3)->toBe($snapshot3->aggregate_version);
});

it('can query snapshots by aggregate uuid', function (): void {
    $uuid1 = Str::uuid()->toString();
    $uuid2 = Str::uuid()->toString();

    // Crea snapshot per il primo aggregate
    Snapshot::factory()->create([
        'aggregate_uuid' => $uuid1,
        'aggregate_version' => 1,
        'state' => ['aggregate' => 'first', 'version' => 1],
    ]);

    Snapshot::factory()->create([
        'aggregate_uuid' => $uuid1,
        'aggregate_version' => 2,
        'state' => ['aggregate' => 'first', 'version' => 2],
    ]);

    // Crea snapshot per il secondo aggregate
    Snapshot::factory()->create([
        'aggregate_uuid' => $uuid2,
        'aggregate_version' => 1,
        'state' => ['aggregate' => 'second', 'version' => 1],
    ]);

    // Query per UUID specifico
    $snapshots1 = Snapshot::where('aggregate_uuid', $uuid1)->get();
    $snapshots2 = Snapshot::where('aggregate_uuid', $uuid2)->get();

    expect($snapshots1)->toHaveCount(2);
    expect($snapshots2)->toHaveCount(1);

    expect($uuid1)->toBe($snapshots1->first()->aggregate_uuid);
    expect($uuid2)->toBe($snapshots2->first()->aggregate_uuid);
});

it('can query snapshots by version', function (): void {
    $uuid = Str::uuid()->toString();

    Snapshot::factory()->create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => ['version' => 1],
    ]);

    Snapshot::factory()->create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 5,
        'state' => ['version' => 5],
    ]);

    Snapshot::factory()->create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 10,
        'state' => ['version' => 10],
    ]);

    // Query per versione specifica
    $version1Snapshot = Snapshot::where('aggregate_uuid', $uuid)
        ->where('aggregate_version', 1)
        ->first();

    $version5Snapshot = Snapshot::where('aggregate_uuid', $uuid)
        ->where('aggregate_version', 5)
        ->first();

    $version10Snapshot = Snapshot::where('aggregate_uuid', $uuid)
        ->where('aggregate_version', 10)
        ->first();

    expect($version1Snapshot)->not->toBeNull();
    expect($version5Snapshot)->not->toBeNull();
    expect($version10Snapshot)->not->toBeNull();

    expect(1)->toBe($version1Snapshot->aggregate_version);
    expect(5)->toBe($version5Snapshot->aggregate_version);
    expect(10)->toBe($version10Snapshot->aggregate_version);
});

it('can handle snapshot with empty state', function (): void {
    $snapshot = Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => [],
    ]);

    expect($snapshot->state)->toBeArray();
    expect($snapshot->state)->toBeEmpty();
});

it('can handle snapshot with empty array state', function (): void {
    $snapshot = Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => [],
    ]);

    expect($snapshot->state)->toBeArray();
    expect($snapshot->state)->toBeEmpty();
});

it('can restore state from snapshot', function (): void {
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

    $snapshot = Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 7,
        'state' => $originalState,
    ]);

    // Simula il ripristino dello stato
    $restoredState = $snapshot->state;

    expect($originalState)->toBe($restoredState);
    expect(456)->toBe($restoredState['user_id']);
    expect('light')->toBe($restoredState['settings']['theme']);
    expect('Europe/Rome')->toBe($restoredState['preferences']['timezone']);
    expect('EUR')->toBe($restoredState['preferences']['currency']);
});

it('can compare snapshot versions', function (): void {
    $uuid = Str::uuid()->toString();

    $snapshot1 = Snapshot::factory()->create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => ['value' => 100, 'status' => 'initial'],
    ]);

    $snapshot2 = Snapshot::factory()->create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 2,
        'state' => ['value' => 200, 'status' => 'updated'],
    ]);

    $snapshot3 = Snapshot::factory()->create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 3,
        'state' => ['value' => 300, 'status' => 'final'],
    ]);

    // Verifica che le versioni siano progressive
    expect($snapshot1->aggregate_version)->toBeLessThan($snapshot2->aggregate_version);
    expect($snapshot2->aggregate_version)->toBeLessThan($snapshot3->aggregate_version);

    // Verifica che i valori cambino tra le versioni
    expect(100)->toBe($snapshot1->state['value']);
    expect(200)->toBe($snapshot2->state['value']);
    expect(300)->toBe($snapshot3->state['value']);

    expect('initial')->toBe($snapshot1->state['status']);
    expect('updated')->toBe($snapshot2->state['status']);
    expect('final')->toBe($snapshot3->state['status']);
});

it('can handle snapshot with timestamps', function (): void {
    $now = now();

    $snapshot = Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['created_at' => $now->toISOString()],
    ]);

    expect($snapshot->aggregate_uuid)->toBeString();
    expect($snapshot->aggregate_version)->toBe(1);
    expect($snapshot->state)->toBeArray();
    expect($snapshot->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

it('can query snapshots by date range', function (): void {
    $yesterday = now()->subDay();
    $today = now();
    $tomorrow = now()->addDay();

    Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['date' => 'yesterday'],
        'created_at' => $yesterday,
    ]);

    Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['date' => 'today'],
        'created_at' => $today,
    ]);

    Snapshot::factory()->create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => ['date' => 'tomorrow'],
        'created_at' => $tomorrow,
    ]);

    $todaySnapshots = Snapshot::whereDate('created_at', today())->get();
    expect($todaySnapshots)->toHaveCount(1);
    expect($todaySnapshots->first()->state['date'])->toBe('today');

    $recentSnapshots = Snapshot::where('created_at', '>=', $yesterday)->get();
    expect($recentSnapshots)->toHaveCount(3);
});

it('can handle snapshot with metadata', function (): void {
    $metadata = [
        'source' => 'user_action',
        'user_id' => 789,
        'action' => 'profile_update',
        'timestamp' => now()->toISOString(),
        'ip_address' => '192.168.1.100',
        'user_agent' => 'Mozilla/5.0',
        'session_id' => Str::random(40),
    ];

    $snapshot = Snapshot::factory()->create([
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

    expect('Alice Johnson')->toBe($snapshot->state['profile']['name']);
    expect('alice@example.com')->toBe($snapshot->state['profile']['email']);
    expect('user_action')->toBe($snapshot->state['metadata']['source']);
    expect(789)->toBe($snapshot->state['metadata']['user_id']);
    expect('profile_update')->toBe($snapshot->state['metadata']['action']);
});
