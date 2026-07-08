<?php

declare(strict_types=1);

use Modules\User\Actions\User\DeleteUserAction;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

it('returns failure when password is incorrect', function (): void {
    // Create a mock user with a hashed password
    $user = new User(['password' => bcrypt('correct-password')]);

    $action = app(DeleteUserAction::class);
    $result = $action->execute($user, 'wrong-password');

    Assert::assertFalse($result['success']);
    Assert::assertStringContainsString((string) 'password', (string) $result['message']);
});
