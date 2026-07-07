<?php

declare(strict_types=1);

use Illuminate\Support\Str;

uses(Modules\Cms\Tests\TestCase::class);
function cmsProfileGenerateUniqueEmail(): string
{
    return 'test+'.Str::uuid()->toString().'@example.com';
}

test('profile settings page can be rendered', function (): void {
    cmsSkipTest('Route /it/settings/profile not available in this install.');
});

test('profile information can be updated', function (): void {
    cmsSkipTest('Profile update flow requires full Volt/page setup.');
});

test('email verification status is reset if email changes', function (): void {
    cmsSkipTest('Email verification profile flow requires full setup.');
});

test('email verification status is not reset if email does not change', function (): void {
    cmsSkipTest('Email verification profile flow requires full setup.');
});

test('user account can be deleted', function (): void {
    cmsSkipTest('Account deletion flow requires full Volt/page setup.');
});

test('user account deletion fails with wrong password', function (): void {
    cmsSkipTest('Account deletion flow requires full Volt/page setup.');
});
