<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogUserLoginAction can execute for a user', function (): void {
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user);

    $action = new LogUserLoginAction;
    $activity = $action->execute($user);

    Assert::assertSame($user->getKey(), $activity->causer_id);
});
