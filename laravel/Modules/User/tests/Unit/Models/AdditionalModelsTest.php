<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

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

test('Notification model can be instantiated', function () {
    $model = new Notification();
    expect($model)->toBeInstanceOf(Notification::class);
});

test('OauthAccessToken model can be instantiated', function () {
    $model = new OauthAccessToken();
    expect($model)->toBeInstanceOf(OauthAccessToken::class);
});

test('OauthClient model can be instantiated', function () {
    $model = new OauthClient();
    expect($model)->toBeInstanceOf(OauthClient::class);
});

test('OauthAuthCode model can be instantiated', function () {
    $model = new OauthAuthCode();
    expect($model)->toBeInstanceOf(OauthAuthCode::class);
});

test('OauthRefreshToken model can be instantiated', function () {
    $model = new OauthRefreshToken();
    expect($model)->toBeInstanceOf(OauthRefreshToken::class);
});

test('OauthPersonalAccessClient model can be instantiated', function () {
    $model = new OauthPersonalAccessClient();
    expect($model)->toBeInstanceOf(OauthPersonalAccessClient::class);
});

test('OauthToken model can be instantiated', function () {
    $model = new OauthToken();
    expect($model)->toBeInstanceOf(OauthToken::class);
});

test('OauthDeviceCode model can be instantiated', function () {
    $model = new OauthDeviceCode();
    expect($model)->toBeInstanceOf(OauthDeviceCode::class);
});

test('TeamPermission model can be instantiated', function () {
    $model = new TeamPermission();
    expect($model)->toBeInstanceOf(TeamPermission::class);
});

test('TeamInvitation model can be instantiated', function () {
    $model = new TeamInvitation();
    expect($model)->toBeInstanceOf(TeamInvitation::class);
});

test('AuthenticationLog model can be instantiated', function () {
    $model = new AuthenticationLog();
    expect($model)->toBeInstanceOf(AuthenticationLog::class);
});

test('Authentication model can be instantiated', function () {
    $model = new Authentication();
    expect($model)->toBeInstanceOf(Authentication::class);
});

test('SocialiteUser model can be instantiated', function () {
    $model = new SocialiteUser();
    expect($model)->toBeInstanceOf(SocialiteUser::class);
});

test('SocialProvider model can be instantiated', function () {
    $model = new SocialProvider();
    expect($model)->toBeInstanceOf(SocialProvider::class);
});

test('SsoProvider model can be instantiated', function () {
    $model = new SsoProvider();
    expect($model)->toBeInstanceOf(SsoProvider::class);
});

test('Feature model can be instantiated', function () {
    $model = new Feature();
    expect($model)->toBeInstanceOf(Feature::class);
});

test('Extra model can be instantiated', function () {
    $model = new Extra();
    expect($model)->toBeInstanceOf(Extra::class);
});

test('Device model can be instantiated', function () {
    $model = new Device();
    expect($model)->toBeInstanceOf(Device::class);
});

test('DeviceProfile model can be instantiated', function () {
    $model = new DeviceProfile();
    expect($model)->toBeInstanceOf(DeviceProfile::class);
});

test('DeviceUser model can be instantiated', function () {
    $model = new DeviceUser();
    expect($model)->toBeInstanceOf(DeviceUser::class);
});

test('PasswordReset model can be instantiated', function () {
    $model = new PasswordReset();
    expect($model)->toBeInstanceOf(PasswordReset::class);
});
