<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

test('HandleRegistrationErrorAction exposes execute for registration failure handling', function (): void {
    $action = new HandleRegistrationErrorAction;
    $method = new ReflectionMethod($action, 'execute');

    Assert::assertSame(HandleRegistrationErrorAction::class, $action::class);
    Assert::assertTrue($method->isPublic());
    Assert::assertSame(2, $method->getNumberOfParameters());
});
