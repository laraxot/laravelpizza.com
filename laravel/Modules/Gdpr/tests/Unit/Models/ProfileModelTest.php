<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Gdpr\Models\Profile;
use Modules\Gdpr\Tests\TestCase;
=======
use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Models\Profile;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\BaseProfile;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

test('profile_extends_base_profile', function (): void {
    $profile = new Profile();

    Assert::assertInstanceOf(BaseProfile::class, $profile);
});

test('profile_has_gdpr_connection', function (): void {
    $profile = new Profile();

    Assert::assertSame('gdpr', $profile->getConnectionName());
});

test('profile_is_model', function (): void {
    $profile = new Profile();

    Assert::assertInstanceOf(Model::class, $profile);
});

test('profile_has_standard_attributes', function (): void {
    $profile = new Profile();

    Assert::assertTrue((new \ReflectionClass($profile))->hasMethod('user'));
});
