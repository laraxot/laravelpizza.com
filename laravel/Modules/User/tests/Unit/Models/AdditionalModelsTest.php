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
    new Notification;
});

test('OauthAccessToken model can be instantiated', function () {
    new OauthAccessToken;
});

test('OauthClient model can be instantiated', function () {
    new OauthClient;
});

test('OauthAuthCode model can be instantiated', function () {
    new OauthAuthCode;
});

test('OauthRefreshToken model can be instantiated', function () {
    new OauthRefreshToken;
});

test('OauthPersonalAccessClient model can be instantiated', function () {
    new OauthPersonalAccessClient;
});

test('OauthToken model can be instantiated', function () {
    new OauthToken;
});

test('OauthDeviceCode model can be instantiated', function () {
    new OauthDeviceCode;
});

test('TeamPermission model can be instantiated', function () {
    new TeamPermission;
});

test('TeamInvitation model can be instantiated', function () {
    new TeamInvitation;
});

test('AuthenticationLog model can be instantiated', function () {
    new AuthenticationLog;
});

test('Authentication model can be instantiated', function () {
    new Authentication;
});

test('SocialiteUser model can be instantiated', function () {
    new SocialiteUser;
});

test('SocialProvider model can be instantiated', function () {
    new SocialProvider;
});

test('SsoProvider model can be instantiated', function () {
    new SsoProvider;
});

test('Feature model can be instantiated', function () {
    new Feature;
});

test('Extra model can be instantiated', function () {
    new Extra;
});

test('Device model can be instantiated', function () {
    new Device;
});

test('DeviceProfile model can be instantiated', function () {
    new DeviceProfile;
});

test('DeviceUser model can be instantiated', function () {
    new DeviceUser;
});

test('PasswordReset model can be instantiated', function () {
    new PasswordReset;
});
