<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Profile;
use Modules\Meetup\Tests\TestCase;
use Illuminate\Support\Str;

uses(TestCase::class, DatabaseTransactions::class);

test('profile model uses meetup connection', function () {
    $profile = new Profile();
    expect($profile->getConnectionName())->toBe('meetup');
});

test('profile model has correct key configuration', function () {
    $profile = new Profile();
    expect($profile->getIncrementing())->toBeFalse()
        ->and($profile->getKeyType())->toBe('string');
});

test('profile has expected fillable fields', function () {
    $profile = new Profile();
    $expected = [
        'user_id',
        'first_name',
        'last_name',
        'fiscal_code',
        'phone',
        'email',
        'notes',
    ];
    
    foreach ($expected as $field) {
        expect(in_array($field, $profile->getFillable()))->toBeTrue();
    }
});

test('profile casts attributes correctly', function () {
    $profile = Profile::factory()->create();
    
    expect($profile->id)->toBeString()
        ->and($profile->user_id)->toBeString()
        ->and($profile->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($profile->updated_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

test('profile unsets uuid attribute during saving and creating', function () {
    // We pass 'uuid' to the factory but it should be unset by the booted logic
    $profile = Profile::factory()->make(['uuid' => 'some-uuid']);
    
    // Simulating the save which triggers saving and creating
    $profile->save();
    
    // Check that it's not in the attributes (though it might be in the raw array if not careful)
    // The boot logic specifically calls offsetUnset('uuid')
    expect(isset($profile->uuid))->toBeFalse();
});

test('profile auto-generates uuid id if missing on creation', function () {
    $profile = Profile::factory()->create(['id' => null]);
    
    expect($profile->id)->not->toBeNull()
        ->and(Str::isUuid($profile->id))->toBeTrue();
});

test('profile preserves existing id if provided on creation', function () {
    $customId = (string) Str::uuid();
    $profile = Profile::factory()->create(['id' => $customId]);
    
    expect($profile->id)->toBe($customId);
});
