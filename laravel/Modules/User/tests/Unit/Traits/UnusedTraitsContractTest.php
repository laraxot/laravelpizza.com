<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Modules\User\Tests\TestCase;
use Modules\User\Tests\Unit\Traits\Fixtures\HasPassportConfigurationFixture;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('phpstan fixtures reference dormant traits', function (): void {
    Assert::assertTrue(class_exists(HasPassportConfigurationFixture::class));
});
