<?php

declare(strict_types=1);
use Modules\User\Models\Authentication;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Device;
use Modules\User\Models\DeviceProfile;
use Modules\User\Models\DeviceUser;
use Modules\User\Models\Extra;
use Modules\User\Models\Feature;
use Modules\User\Models\Notification;
use Modules\User\Models\OauthAccessToken;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthPersonalAccessClient;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Modules\User\Models\PasswordReset;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\SocialProvider;
use Modules\User\Models\SsoProvider;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamPermission;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('Notification model can be instantiated', function () {
    expect(new Notification)->toEqual(new Notification);
});

test('OauthAccessToken model can be instantiated', function () {
    expect(new OauthAccessToken)->toEqual(new OauthAccessToken);
});

test('OauthClient model can be instantiated', function () {
    expect(new OauthClient)->toEqual(new OauthClient);
});

test('OauthAuthCode model can be instantiated', function () {
    expect(new OauthAuthCode)->toEqual(new OauthAuthCode);
});

test('OauthRefreshToken model can be instantiated', function () {
    expect(new OauthRefreshToken)->toEqual(new OauthRefreshToken);
});

test('OauthPersonalAccessClient model can be instantiated', function () {
    expect(new OauthPersonalAccessClient)->toEqual(new OauthPersonalAccessClient);
});

test('OauthToken model can be instantiated', function () {
    expect(new OauthToken)->toEqual(new OauthToken);
});

test('OauthDeviceCode model can be instantiated', function () {
    expect(new OauthDeviceCode)->toEqual(new OauthDeviceCode);
});

test('TeamPermission model can be instantiated', function () {
    expect(new TeamPermission)->toEqual(new TeamPermission);
});

test('TeamInvitation model can be instantiated', function () {
    expect(new TeamInvitation)->toEqual(new TeamInvitation);
});

test('AuthenticationLog model can be instantiated', function () {
    expect(new AuthenticationLog)->toEqual(new AuthenticationLog);
});

test('Authentication model can be instantiated', function () {
    expect(new Authentication)->toEqual(new Authentication);
});

test('SocialiteUser model can be instantiated', function () {
    expect(new SocialiteUser)->toEqual(new SocialiteUser);
});

test('SocialProvider model can be instantiated', function () {
    expect(new SocialProvider)->toEqual(new SocialProvider);
});

test('SsoProvider model can be instantiated', function () {
    expect(new SsoProvider)->toEqual(new SsoProvider);
});

test('Feature model can be instantiated', function () {
    expect(new Feature)->toEqual(new Feature);
});

test('Extra model can be instantiated', function () {
    expect(new Extra)->toEqual(new Extra);
});

test('Device model can be instantiated', function () {
    expect(new Device)->toEqual(new Device);
});

test('DeviceProfile model can be instantiated', function () {
    expect(new DeviceProfile)->toEqual(new DeviceProfile);
});

test('DeviceUser model can be instantiated', function () {
    expect(new DeviceUser)->toEqual(new DeviceUser);
});

test('PasswordReset model can be instantiated', function () {
    expect(new PasswordReset)->toEqual(new PasswordReset);
});
