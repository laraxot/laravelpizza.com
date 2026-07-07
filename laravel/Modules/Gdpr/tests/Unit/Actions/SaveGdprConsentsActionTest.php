<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Tests\TestCase;
=======
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

test('SaveGdprConsentsAction can be instantiated', function (): void {
    $action = new SaveGdprConsentsAction();
    Assert::assertInstanceOf(SaveGdprConsentsAction::class, $action);
});

test('SaveGdprConsentsAction execute method exists', function (): void {
    $action = new SaveGdprConsentsAction();
    Assert::assertTrue((new \ReflectionClass($action))->hasMethod('execute'));
});
