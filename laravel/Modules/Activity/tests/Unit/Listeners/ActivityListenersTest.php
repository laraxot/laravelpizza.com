<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Listeners;

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;

test('LoginListener can be instantiated', function () {
    $listener = new LoginListener;

    expect($listener)->toBeObject();
});

test('LogoutListener can be instantiated', function () {
    $listener = new LogoutListener;

    expect($listener)->toBeObject();
});
