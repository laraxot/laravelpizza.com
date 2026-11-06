<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Modules\Gdpr\Models\Profile;
use Modules\User\Models\BaseProfile;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

test('profile_extends_base_profile', function (): void {
    $parents = class_parents(Profile::class);
    Assert::assertArrayHasKey(BaseProfile::class, $parents);
});

test('profile_has_gdpr_connection', function (): void {
    $profile = new Profile;

    Assert::assertSame('gdpr', $profile->getConnectionName());
});

test('profile_is_model', function (): void {
    $profile = new Profile;
    Assert::assertSame(Profile::class, $profile::class);
});

test('profile_has_standard_attributes', function (): void {
    $profile = new Profile;

    Assert::assertTrue((new \ReflectionClass($profile))->hasMethod('user'));
});
