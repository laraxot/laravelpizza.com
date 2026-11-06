<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

test('HandleSuccessfulRegistrationAction exposes execute for post-registration login redirect', function (): void {
    $action = new HandleSuccessfulRegistrationAction;
    $method = new ReflectionMethod($action, 'execute');

    Assert::assertSame(HandleSuccessfulRegistrationAction::class, $action::class);
    Assert::assertTrue($method->isPublic());
    Assert::assertSame(2, $method->getNumberOfParameters());
});
