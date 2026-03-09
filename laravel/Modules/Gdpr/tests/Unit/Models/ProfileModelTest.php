<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Profile;

test('profile_extends_base_profile', function () {
    $profile = new Profile();

    expect($profile)->toBeInstanceOf(Modules\User\Models\BaseProfile::class);
});

test('profile_has_gdpr_connection', function () {
    $profile = new Profile();

    expect($profile->getConnectionName())->toBe('gdpr');
});

test('profile_is_model', function () {
    $profile = new Profile();

    expect($profile)->toBeInstanceOf(Illuminate\Database\Eloquent\Model::class);
});

test('profile_has_standard_attributes', function () {
    $profile = new Profile();

    expect(method_exists($profile, 'user'))->toBeTrue();
});
