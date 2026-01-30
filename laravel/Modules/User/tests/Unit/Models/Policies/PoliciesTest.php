<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Models\Policies\AuthenticationLogPolicy;
use Modules\User\Models\Policies\AuthenticationPolicy;
use Modules\User\Models\Policies\DevicePolicy;
use Modules\User\Models\Policies\DeviceProfilePolicy;
use Modules\User\Models\Policies\ExtraPolicy;
use Modules\User\Models\Policies\FeaturePolicy;
use Modules\User\Models\Policies\NotificationPolicy;
use Modules\User\Models\Policies\OauthAccessTokenPolicy;
use Modules\User\Models\Policies\OauthAuthCodePolicy;
use Modules\User\Models\Policies\OauthClientPolicy;
use Modules\User\Models\Policies\OauthPersonalAccessClientPolicy;
use Modules\User\Models\Policies\OauthRefreshTokenPolicy;
use Modules\User\Models\Policies\SocialiteUserPolicy;
use Modules\User\Models\Policies\SocialProviderPolicy;
use Modules\User\Models\Policies\TeamInvitationPolicy;
use Modules\User\Models\Policies\TeamPermissionPolicy;

test('OauthClientPolicy can be instantiated', function () {
    $policy = new OauthClientPolicy();
    expect($policy)->toBeInstanceOf(OauthClientPolicy::class);
});

test('OauthAccessTokenPolicy can be instantiated', function () {
    $policy = new OauthAccessTokenPolicy();
    expect($policy)->toBeInstanceOf(OauthAccessTokenPolicy::class);
});

test('OauthAuthCodePolicy can be instantiated', function () {
    $policy = new OauthAuthCodePolicy();
    expect($policy)->toBeInstanceOf(OauthAuthCodePolicy::class);
});

test('OauthRefreshTokenPolicy can be instantiated', function () {
    $policy = new OauthRefreshTokenPolicy();
    expect($policy)->toBeInstanceOf(OauthRefreshTokenPolicy::class);
});

test('OauthPersonalAccessClientPolicy can be instantiated', function () {
    $policy = new OauthPersonalAccessClientPolicy();
    expect($policy)->toBeInstanceOf(OauthPersonalAccessClientPolicy::class);
});

test('SocialiteUserPolicy can be instantiated', function () {
    $policy = new SocialiteUserPolicy();
    expect($policy)->toBeInstanceOf(SocialiteUserPolicy::class);
});

test('SocialProviderPolicy can be instantiated', function () {
    $policy = new SocialProviderPolicy();
    expect($policy)->toBeInstanceOf(SocialProviderPolicy::class);
});

test('AuthenticationLogPolicy can be instantiated', function () {
    $policy = new AuthenticationLogPolicy();
    expect($policy)->toBeInstanceOf(AuthenticationLogPolicy::class);
});

test('AuthenticationPolicy can be instantiated', function () {
    $policy = new AuthenticationPolicy();
    expect($policy)->toBeInstanceOf(AuthenticationPolicy::class);
});

test('DevicePolicy can be instantiated', function () {
    $policy = new DevicePolicy();
    expect($policy)->toBeInstanceOf(DevicePolicy::class);
});

test('DeviceProfilePolicy can be instantiated', function () {
    $policy = new DeviceProfilePolicy();
    expect($policy)->toBeInstanceOf(DeviceProfilePolicy::class);
});

test('TeamInvitationPolicy can be instantiated', function () {
    $policy = new TeamInvitationPolicy();
    expect($policy)->toBeInstanceOf(TeamInvitationPolicy::class);
});

test('TeamPermissionPolicy can be instantiated', function () {
    $policy = new TeamPermissionPolicy();
    expect($policy)->toBeInstanceOf(TeamPermissionPolicy::class);
});

test('FeaturePolicy can be instantiated', function () {
    $policy = new FeaturePolicy();
    expect($policy)->toBeInstanceOf(FeaturePolicy::class);
});

test('ExtraPolicy can be instantiated', function () {
    $policy = new ExtraPolicy();
    expect($policy)->toBeInstanceOf(ExtraPolicy::class);
});

test('NotificationPolicy can be instantiated', function () {
    $policy = new NotificationPolicy();
    expect($policy)->toBeInstanceOf(NotificationPolicy::class);
});
