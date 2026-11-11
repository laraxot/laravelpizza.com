<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Meetup\Models\Profile;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('profile model uses meetup connection', function () {
    $profile = new Profile;
    expect($profile->getConnectionName())->toBe('meetup');
});

test('profile model has correct key configuration', function () {
    $profile = new Profile;
    // La migrazione 2026_02_13_163329 porta profiles.id a varchar(36): la chiave è un UUID generato dall'app.
    expect($profile->getIncrementing())->toBeFalse()
        ->and($profile->getKeyType())->toBe('string');
});

test('profile has expected fillable fields', function () {
    $profile = new Profile;
    $expected = [
        'uuid',
        'user_id',
        'first_name',
        'last_name',
        'email',
    ];

    foreach ($expected as $field) {
        expect(in_array($field, $profile->getFillable()))->toBeTrue();
    }
});

test('profile casts attributes correctly', function () {
    $profile = Profile::factory()->create();

    expect($profile->id)->toBeInt()
        ->and($profile->created_at)->toBeInstanceOf(Carbon::class)
        ->and($profile->updated_at)->toBeInstanceOf(Carbon::class);
});

test('profile auto-generates uuid if missing on creation', function () {
    $profile = Profile::factory()->create(['uuid' => null]);

    expect($profile->uuid)->not->toBeNull()
        ->and(Str::isUuid($profile->uuid))->toBeTrue();
});

test('profile preserves existing uuid if provided on creation', function () {
    $customUuid = (string) Str::uuid();
    $profile = Profile::factory()->create(['uuid' => $customUuid]);

    expect($profile->uuid)->toBe($customUuid);
});
