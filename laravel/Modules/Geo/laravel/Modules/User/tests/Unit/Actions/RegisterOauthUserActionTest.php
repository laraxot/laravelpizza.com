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
    $getMockUser = function (array $attributes = []): SocialiteUserContract {
        /** @var array<string, mixed> $normalizedAttributes */
        $normalizedAttributes = $attributes;

        return mockSocialiteOauthUser($normalizedAttributes);
    };

    it('registers oauth user successfully', function () use ($getMockUser): void {
        $oauthUser = $getMockUser(['name' => 'Mario Rossi']);
        $email = $oauthUser->getEmail();
        $action = app(RegisterOauthUserAction::class);

        Assert::assertFalse(User::where('email', $email)->exists());
        $socialiteUser = $action->execute('google', $oauthUser);

        Assert::assertInstanceOf(SocialiteUser::class, $socialiteUser);
        Assert::assertSame($email, $socialiteUser->email);
        $user = User::where('email', $email)->first();
        Assert::assertNotNull($user);
        Assert::assertSame('Mario', $user->name); // App splits name
    });

    it('dispatches registered event', function () use ($getMockUser): void {
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

    it('registers users with different emails successfully', function () use ($getMockUser): void {
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
});
