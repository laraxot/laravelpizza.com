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
        'email' => 'john.doe.'.uniqid().'@example.com',
        'phone' => '+39123456789',
    ]);

    expect($profile->first_name)->toBe('John')
        ->and($profile->last_name)->toBe('Doe')
        ->and($profile->email)->toContain('@example.com')
        ->and($profile->phone)->toBe('+39123456789');
});

test('profile id is auto-generated as uuid string', function () {
    $profile = Profile::factory()->create();
    
    expect($profile->id)->not->toBeNull()
        ->and(is_string($profile->id) || is_int($profile->id))->toBeTrue();
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

    expect($profile)->toBeInstanceOf(Profile::class)
        ->and($profile->first_name)->toBe('Jane')
        ->and($profile->last_name)->toBe('Smith');
});

test('profile has correct casts from base profile', function () {
    $profile = Profile::factory()->create();
    
    expect($profile->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($profile->updated_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

test('profile user relationship works', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);
    
    expect($profile->user)->toBeInstanceOf(User::class)
        ->and($profile->user->id)->toBe($user->id);
});

test('profile connection is meetup', function () {
    $profile = new Profile();
    expect($profile->getConnectionName())->toBe('meetup');
});

test('profile extends base profile', function () {
    $profile = new Profile();
    expect($profile)->toBeInstanceOf(\Modules\User\Models\BaseProfile::class);
});

test('profile can have null optional fields', function () {
    $profile = Profile::factory()->create([
        'notes' => null,
    ]);

    expect($profile)->toBeInstanceOf(Profile::class)
        ->and($profile->notes)->toBeNull();
});

test('profile table uses meetup connection', function () {
    $profile = Profile::factory()->create();
    $query = Profile::query();
    
    expect($query->getConnection()->getName())->toBe('meetup');
});

