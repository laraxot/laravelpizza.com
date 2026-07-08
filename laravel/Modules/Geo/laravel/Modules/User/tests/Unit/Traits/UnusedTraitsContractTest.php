<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Modules\User\Tests\TestCase;
use Modules\User\Tests\Unit\Traits\Fixtures\CreatesApplicationFixture;
use Modules\User\Tests\Unit\Traits\Fixtures\HasPassportConfigurationFixture;
use Modules\User\Tests\Unit\Traits\Fixtures\HasPasswordExpiryFixture;
use Modules\User\Tests\Unit\Traits\Fixtures\HasRolesTraitFixture;
use Modules\User\Tests\Unit\Traits\Fixtures\HasUserTestCaseFixture;
use Modules\User\Tests\Unit\Traits\Fixtures\PasswordValidationRulesMockableFixture;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('phpstan fixtures reference dormant traits', function (): void {
    Assert::assertInstanceOf(PasswordValidationRulesMockableFixture::class, new PasswordValidationRulesMockableFixture());
    Assert::assertInstanceOf(HasRolesTraitFixture::class, new HasRolesTraitFixture());
    Assert::assertInstanceOf(HasPasswordExpiryFixture::class, new HasPasswordExpiryFixture());
    Assert::assertTrue(class_exists(HasPassportConfigurationFixture::class));
    Assert::assertInstanceOf(CreatesApplicationFixture::class, new CreatesApplicationFixture());
    Assert::assertInstanceOf(HasUserTestCaseFixture::class, new HasUserTestCaseFixture());
});
