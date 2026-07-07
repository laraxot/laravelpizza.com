<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use Modules\Gdpr\Tests\TestCase;
=======
use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

test('HandleRegistrationErrorAction can be instantiated', function (): void {
    $action = new HandleRegistrationErrorAction();
    Assert::assertInstanceOf(HandleRegistrationErrorAction::class, $action);
});

test('HandleRegistrationErrorAction execute method exists', function (): void {
    $action = new HandleRegistrationErrorAction();
    Assert::assertTrue((new \ReflectionClass($action))->hasMethod('execute'));
});
