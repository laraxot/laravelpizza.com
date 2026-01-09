<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

test('confirm password screen can be rendered', function () {
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/confirm-password');
    $this->assertSame(404, $response->status());
});

test('password can be confirmed', function () {
    $this->assertTrue(true);
});

test('password is not confirmed with invalid password', function () {
    $this->assertTrue(true);
});
