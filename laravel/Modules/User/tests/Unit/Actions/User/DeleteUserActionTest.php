<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\User;

use Modules\User\Actions\User\DeleteUserAction;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

it('returns failure when password is incorrect', function (): void {
    // Create a mock user with a hashed password
    $user = new User(['password' => bcrypt('correct-password')]);

    $action = app(DeleteUserAction::class);
    $result = $action->execute($user, 'wrong-password');

    expect($result['success'])->toBeFalse();
    expect($result['message'])->toContain('password');
});
