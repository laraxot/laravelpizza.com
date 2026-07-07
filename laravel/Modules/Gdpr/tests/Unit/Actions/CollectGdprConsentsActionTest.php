<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Tests\TestCase;
=======
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
>>>>>>> 40b96bcd6 (.)

test('CollectGdprConsentsAction returns correct array', function () {
    $action = new CollectGdprConsentsAction();
    $result = $action->execute(true, true, false);

    Assert::assertArrayHasKey('privacy_accepted', $result);
    Assert::assertArrayHasKey('terms_accepted', $result);
    Assert::assertArrayHasKey('marketing_consent', $result);
    Assert::assertTrue($result['privacy_accepted']);
    Assert::assertTrue($result['terms_accepted']);
    Assert::assertFalse($result['marketing_consent']);
});

test('CollectGdprConsentsAction handles all false', function () {
    $action = new CollectGdprConsentsAction();
    $result = $action->execute(false, false, false);

    Assert::assertFalse($result['privacy_accepted']);
    Assert::assertFalse($result['terms_accepted']);
    Assert::assertFalse($result['marketing_consent']);
});

test('CollectGdprConsentsAction handles all true', function () {
    $action = new CollectGdprConsentsAction();
    $result = $action->execute(true, true, true);

    Assert::assertTrue($result['privacy_accepted']);
    Assert::assertTrue($result['terms_accepted']);
    Assert::assertTrue($result['marketing_consent']);
});
