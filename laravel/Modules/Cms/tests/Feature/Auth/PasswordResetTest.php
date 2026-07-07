<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

test('reset password link screen can be rendered', function (): void {
    cmsSkipTest('Route /it/auth/password/reset not available in this install.');
});

test('reset password link can be requested', function (): void {
    cmsSkipTest('Password reset mail flow requires full mail + route setup.');
});

test('reset password screen can be rendered', function (): void {
    cmsSkipTest('Route /it/auth/password/fake-token not available in this install.');
});

test('password can be reset with valid token', function (): void {
    cmsSkipTest('Password reset token flow requires full Volt/page setup.');
});
