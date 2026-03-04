<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User; // Added

uses(TestCase::class); // Use the custom TestCase

beforeEach(function () {
    // Skip if database not available
    try {
        \DB::connection()->getPdo();
    } catch (\Exception $e) {
        $this->markTestSkipped('Database not available: '.$e->getMessage());
    }
});

it('can create activity with basic information', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);

    $activity = Activity::create([
        'log_name' => 'default',
        'description' => 'User logged in',
        'subject_type' => $user::class,
        'subject_id' => $user->id,
        'causer_type' => $user::class,
        'causer_id' => $user->id,
        'event' => 'logged_in',
        'properties' => ['ip_address' => '127.0.0.1'],
    ]);
    \assert($activity instanceof Activity);

    $properties = $activity->properties;
    \assert($properties instanceof Collection);
    $propertiesArray = $properties->toArray();

    expect($activity->log_name)->toBe('default')
        ->and($activity->description)->toBe('User logged in')
        ->and($activity->subject_type)->toBe($user::class)
        ->and($activity->subject_id)->toBe($user->id)
        ->and($activity->causer_type)->toBe($user::class)
        ->and($activity->causer_id)->toBe($user->id)
        ->and($activity->event)->toBe('logged_in')
        ->and($propertiesArray)->toBe(['ip_address' => '127.0.0.1']);
});
