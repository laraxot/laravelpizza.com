<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

test('SaveGdprConsentsAction exposes execute for persisting registration consents', function (): void {
    $action = new SaveGdprConsentsAction;
    $method = new ReflectionMethod($action, 'execute');

    Assert::assertSame(SaveGdprConsentsAction::class, $action::class);
    Assert::assertTrue($method->isPublic());
    Assert::assertGreaterThanOrEqual(2, $method->getNumberOfParameters());
});
