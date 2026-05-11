<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

uses(TestCase::class);

use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;

test('LogUserLoginAction can be instantiated', function () {
    $user = User::factory()->make();

    $action = new LogUserLoginAction($user);

    expect($action)->toBeObject()
        ->and($action->user)->toBe($user);
});
