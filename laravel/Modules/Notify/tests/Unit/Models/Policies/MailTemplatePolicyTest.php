<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models\Policies;

use Modules\Notify\Models\Policies\MailTemplatePolicy;
use Modules\Notify\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

test('mail template policy denies view any', function () {
    $policy = new MailTemplatePolicy;
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(UserContract::class, $user);

    Assert::assertFalse($policy->viewAny($user));
});
