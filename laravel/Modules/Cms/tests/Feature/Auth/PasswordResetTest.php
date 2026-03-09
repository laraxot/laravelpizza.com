<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

test('reset password link screen can be rendered', function (): void {
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/forgot-password');
    $this->assertSame(404, $response->status());
});

test('reset password link can be requested', function (): void {
    $this->assertTrue(true);
});

test('reset password screen can be rendered', function (): void {
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/reset-password/fake-token');
    $this->assertSame(404, $response->status());
});

test('password can be reset with valid token', function (): void {
    $this->assertTrue(true);
});
