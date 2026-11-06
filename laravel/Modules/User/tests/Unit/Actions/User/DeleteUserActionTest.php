<?php

declare(strict_types=1);
use Modules\User\Actions\User\DeleteUserAction;
use Modules\User\Contracts\UserContract;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('returns failure when password is incorrect', function (): void {
    // Create a mock user with a hashed password
    $userClass = XotData::make()->getUserClass();
    $user = new $userClass(['password' => bcrypt('correct-password')]);
    Assert::assertInstanceOf(UserContract::class, $user);

    $action = app(DeleteUserAction::class);
    $result = $action->execute($user, 'wrong-password');

    Assert::assertFalse($result['success']);
    Assert::assertStringContainsString((string) 'password', (string) $result['message']);
});
