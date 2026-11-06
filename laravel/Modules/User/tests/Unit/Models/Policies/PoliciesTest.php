<?php

declare(strict_types=1);
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
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('OauthClientPolicy can be instantiated', function () {
    Assert::assertSame(OauthClientPolicy::class, get_class(new OauthClientPolicy));
});

test('OauthAccessTokenPolicy can be instantiated', function () {
    Assert::assertSame(OauthAccessTokenPolicy::class, get_class(new OauthAccessTokenPolicy));
});

test('OauthAuthCodePolicy can be instantiated', function () {
    Assert::assertSame(OauthAuthCodePolicy::class, get_class(new OauthAuthCodePolicy));
});

test('OauthRefreshTokenPolicy can be instantiated', function () {
    Assert::assertSame(OauthRefreshTokenPolicy::class, get_class(new OauthRefreshTokenPolicy));
});

test('OauthPersonalAccessClientPolicy can be instantiated', function () {
    Assert::assertSame(OauthPersonalAccessClientPolicy::class, get_class(new OauthPersonalAccessClientPolicy));
});

test('SocialiteUserPolicy can be instantiated', function () {
    Assert::assertSame(SocialiteUserPolicy::class, get_class(new SocialiteUserPolicy));
});

test('SocialProviderPolicy can be instantiated', function () {
    Assert::assertSame(SocialProviderPolicy::class, get_class(new SocialProviderPolicy));
});

test('AuthenticationLogPolicy can be instantiated', function () {
    Assert::assertSame(AuthenticationLogPolicy::class, get_class(new AuthenticationLogPolicy));
});

test('AuthenticationPolicy can be instantiated', function () {
    Assert::assertSame(AuthenticationPolicy::class, get_class(new AuthenticationPolicy));
});

test('DevicePolicy can be instantiated', function () {
    Assert::assertSame(DevicePolicy::class, get_class(new DevicePolicy));
});

test('DeviceProfilePolicy can be instantiated', function () {
    Assert::assertSame(DeviceProfilePolicy::class, get_class(new DeviceProfilePolicy));
});

test('TeamInvitationPolicy can be instantiated', function () {
    Assert::assertSame(TeamInvitationPolicy::class, get_class(new TeamInvitationPolicy));
});

test('TeamPermissionPolicy can be instantiated', function () {
    Assert::assertSame(TeamPermissionPolicy::class, get_class(new TeamPermissionPolicy));
});

test('FeaturePolicy can be instantiated', function () {
    Assert::assertSame(FeaturePolicy::class, get_class(new FeaturePolicy));
});

test('ExtraPolicy can be instantiated', function () {
    Assert::assertSame(ExtraPolicy::class, get_class(new ExtraPolicy));
});

test('NotificationPolicy can be instantiated', function () {
    Assert::assertSame(NotificationPolicy::class, get_class(new NotificationPolicy));
});
