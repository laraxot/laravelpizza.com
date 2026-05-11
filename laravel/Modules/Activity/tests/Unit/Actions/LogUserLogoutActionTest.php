<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

uses(TestCase::class);

use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;

test('LogUserLogoutAction can be instantiated', function () {
    $user = User::factory()->make();

    $action = new LogUserLogoutAction($user);

    expect($action)->toBeObject()
        ->and($action->user)->toBe($user);
});
