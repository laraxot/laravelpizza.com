<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Listeners;

uses(TestCase::class);

use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;

test('LoginListener can be instantiated', function () {
    $listener = new LoginListener;

    expect($listener)->toBeObject();
});

test('LogoutListener can be instantiated', function () {
    $listener = new LogoutListener;

    expect($listener)->toBeObject();
});
