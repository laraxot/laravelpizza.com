<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Profile;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('profile model can be instantiated', function () {
    $profile = Profile::factory()->create();
    expect($profile)->toBeInstanceOf(Profile::class)
        ->and($profile->id)->not->toBeNull();
});

test('profile has correct fillable fields', function () {
    $profile = new Profile();
    $fillable = ['user_id', 'first_name', 'last_name', 'fiscal_code', 'phone', 'email', 'notes'];
    
    foreach ($fillable as $field) {
        expect(in_array($field, $profile->getFillable()))->toBeTrue();
    }
});

test('profile can be created with attributes', function () {
    $profile = Profile::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '+39123456789',
    ]);

    expect($profile->first_name)->toBe('John')
        ->and($profile->last_name)->toBe('Doe')
        ->and($profile->email)->toBe('john@example.com')
        ->and($profile->phone)->toBe('+39123456789');
});

test('profile uses uuid as primary key', function () {
    $profile = Profile::factory()->create();
    
    expect($profile->id)->not->toBeNull()
        ->and(strlen($profile->id))->toBeGreaterThan(30);
});

test('profile belongs to user', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);
    
    expect($profile->user)->toBeInstanceOf(User::class)
        ->and($profile->user->id)->toBe($user->id);
});

test('profile has incremented as false', function () {
    $profile = new Profile();
    expect($profile->incrementing)->toBeFalse();
});

test('profile has key type as string', function () {
    $profile = new Profile();
    expect($profile->getKeyType())->toBe('string');
});

test('profile can be created without uuid attribute in database', function () {
    $profile = Profile::factory()->create([
        'first_name' => 'Jane',
        'last_name' => 'Smith',
    ]);

    // Verify the profile was created successfully (uuid should not be saved)
    expect($profile)->toBeInstanceOf(Profile::class)
        ->and($profile->first_name)->toBe('Jane')
        ->and($profile->last_name)->toBe('Smith');
});

test('profile has correct casts from base profile', function () {
    $profile = Profile::factory()->create();
    
    expect($profile->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($profile->updated_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

test('profile can access user relationship', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);
    
    $result = $profile->with('user')->first();
    expect($result)->not->toBeNull();
});
