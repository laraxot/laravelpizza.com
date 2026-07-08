<?php

declare(strict_types=1);

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\RegisterOauthUserAction;
use Modules\User\Events\Registered;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('RegisterOauthUserAction', function (): void {
    /**
     * @param array<string, mixed> $attributes
     */
    $getMockUser = static function (array $attributes = []): SocialiteUserContract {
        /** @var array<string, mixed> $normalizedAttributes */
        $normalizedAttributes = $attributes;

        return mockSocialiteOauthUser($normalizedAttributes);
    };

    test('registers oauth user successfully', function () use ($getMockUser): void {
        $oauthUser = $getMockUser(['name' => 'Mario Rossi']);
        $email = $oauthUser->getEmail();
        $action = app(RegisterOauthUserAction::class);

        Assert::assertFalse(User::where('email', $email)->exists());
        $socialiteUser = $action->execute('google', $oauthUser);

        Assert::assertInstanceOf(SocialiteUser::class, $socialiteUser);
        Assert::assertSame($email, $socialiteUser->email);
        $user = User::where('email', $email)->first();
        Assert::assertNotNull($user);
        Assert::assertSame('Mario', $user->name);
    });

    test('dispatches registered event', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $dispatcher = app(Dispatcher::class);
        $dispatchedEvents = [];

        $dispatcher->listen(Registered::class, static function (Registered $event) use (&$dispatchedEvents): void {
            $dispatchedEvents[] = $event;
        });

        $action = app(RegisterOauthUserAction::class);
        $socialiteUser = $action->execute('github', $oauthUser);

        Assert::assertCount(1, $dispatchedEvents);
        Assert::assertSame($socialiteUser->id, $dispatchedEvents[0]->socialiteUser->id);
    });

    test('registers users with different emails successfully', function () use ($getMockUser): void {
        $email1 = 'user1-'.uniqid().'@example.com';
        $email2 = 'user2-'.uniqid().'@example.com';
        $googleUser = $getMockUser(['id' => 'g-'.uniqid(), 'email' => $email1, 'name' => 'Google User']);
        $githubUser = $getMockUser(['id' => 'gh-'.uniqid(), 'email' => $email2, 'name' => 'Github User']);

        $action = app(RegisterOauthUserAction::class);

        $googleSocialite = $action->execute('google', $googleUser);
        $githubSocialite = $action->execute('github', $githubUser);

        Assert::assertTrue(User::where('email', $email1)->exists());
        Assert::assertTrue(User::where('email', $email2)->exists());
        Assert::assertNotSame($githubSocialite->user_id, $googleSocialite->user_id);
    });

    test('creates socialite user with correct provider', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('github', $oauthUser);

        Assert::assertSame('github', $socialiteUser->provider);
        Assert::assertSame($oauthUser->getId(), $socialiteUser->provider_id);
    });

    test('stores avatar url from oauth user', function () use ($getMockUser): void {
        $avatarUrl = 'https://example.com/custom-avatar.jpg';
        $oauthUser = $getMockUser(['avatar' => $avatarUrl]);
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('google', $oauthUser);

        Assert::assertSame($avatarUrl, $socialiteUser->avatar);
    });

    test('uses correct oauth provider name', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $action = app(RegisterOauthUserAction::class);

        $linkedinSocialite = $action->execute('linkedin', $oauthUser);
        Assert::assertSame('linkedin', $linkedinSocialite->provider);
        $oauthUser2 = $getMockUser(['id' => 'id-'.uniqid(), 'email' => 'test-'.uniqid().'@example.com']);
        $facebookSocialite = $action->execute('facebook', $oauthUser2);
        Assert::assertSame('facebook', $facebookSocialite->provider);
    });

    test('creates user with name from oauth user', function () use ($getMockUser): void {
        $oauthUser = $getMockUser(['name' => 'John Doe']);
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('google', $oauthUser);
        $user = $socialiteUser->user;
        Assert::assertNotNull($user);

        Assert::assertStringContainsString('John', (string) $user->name);
        Assert::assertSame($oauthUser->getEmail(), $user->email);
    });

    test('returns socialite user with user relationship loaded', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('google', $oauthUser);

        Assert::assertInstanceOf(User::class, $socialiteUser->user);
        Assert::assertSame($oauthUser->getEmail(), $socialiteUser->user->email);
    });

    test('handles multiple registrations with same provider', function () use ($getMockUser): void {
        $action = app(RegisterOauthUserAction::class);

        $user1 = $getMockUser(['id' => 'google-1', 'email' => 'user1-'.uniqid().'@example.com']);
        $user2 = $getMockUser(['id' => 'google-2', 'email' => 'user2-'.uniqid().'@example.com']);

        $social1 = $action->execute('google', $user1);
        $social2 = $action->execute('google', $user2);

        Assert::assertSame('google', $social1->provider);
        Assert::assertSame('google', $social2->provider);
        Assert::assertNotSame($social2->provider_id, $social1->provider_id);
        Assert::assertNotSame($social2->user_id, $social1->user_id);
    });
});
