<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Actions\Socialite;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\RegisterOauthUserAction;
use Modules\User\Events\Registered;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('RegisterOauthUserAction', function (): void {
    $getMockUser = static function (array $attributes = []): SocialiteUserContract {
        $unique = uniqid();
        $data = array_merge([
            'id' => 'id-'.$unique,
            'name' => 'Mario Rossi',
            'email' => 'user'.$unique.'@example.com',
            'avatar' => 'https://example.com/avatar.jpg',
            'nickname' => 'user'.$unique,
        ], $attributes);

        $mock = \Mockery::mock(SocialiteUserContract::class);
        $mock->shouldReceive('getId')->andReturn($data['id']);
        $mock->shouldReceive('getName')->andReturn($data['name']);
        $mock->shouldReceive('getEmail')->andReturn($data['email']);
        $mock->shouldReceive('getAvatar')->andReturn($data['avatar']);
        $mock->shouldReceive('getNickname')->andReturn($data['nickname']);

        return $mock;
    };

    test('registers oauth user successfully', function () use ($getMockUser): void {
        $oauthUser = $getMockUser(['name' => 'Mario Rossi']);
        $email = $oauthUser->getEmail();
        $action = app(RegisterOauthUserAction::class);

        expect(User::where('email', $email)->exists())->toBeFalse();

        $socialiteUser = $action->execute('google', $oauthUser);

        expect($socialiteUser)->toBeInstanceOf(SocialiteUser::class);
        expect($socialiteUser->email)->toBe($email);

        $user = User::where('email', $email)->first();
        expect($user)->not->toBeNull();
        expect($user->name)->toBe('Mario');
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

        expect($dispatchedEvents)->toHaveCount(1);
        expect($dispatchedEvents[0]->socialiteUser->id)->toBe($socialiteUser->id);
    });

    test('registers users with different emails successfully', function () use ($getMockUser): void {
        $email1 = 'user1-'.uniqid().'@example.com';
        $email2 = 'user2-'.uniqid().'@example.com';
        $googleUser = $getMockUser(['id' => 'g-'.uniqid(), 'email' => $email1, 'name' => 'Google User']);
        $githubUser = $getMockUser(['id' => 'gh-'.uniqid(), 'email' => $email2, 'name' => 'Github User']);

        $action = app(RegisterOauthUserAction::class);

        $googleSocialite = $action->execute('google', $googleUser);
        $githubSocialite = $action->execute('github', $githubUser);

        expect(User::where('email', $email1)->exists())->toBeTrue();
        expect(User::where('email', $email2)->exists())->toBeTrue();
        expect($googleSocialite->user_id)->not->toBe($githubSocialite->user_id);
    });

    test('creates socialite user with correct provider', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('github', $oauthUser);

        expect($socialiteUser->provider)->toBe('github');
        expect($socialiteUser->provider_id)->toBe($oauthUser->getId());
    });

    test('stores avatar url from oauth user', function () use ($getMockUser): void {
        $avatarUrl = 'https://example.com/custom-avatar.jpg';
        $oauthUser = $getMockUser(['avatar' => $avatarUrl]);
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('google', $oauthUser);

        expect($socialiteUser->avatar)->toBe($avatarUrl);
    });

    test('uses correct oauth provider name', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $action = app(RegisterOauthUserAction::class);

        $linkedinSocialite = $action->execute('linkedin', $oauthUser);
        expect($linkedinSocialite->provider)->toBe('linkedin');

        $oauthUser2 = $getMockUser(['id' => 'id-'.uniqid(), 'email' => 'test-'.uniqid().'@example.com']);
        $facebookSocialite = $action->execute('facebook', $oauthUser2);
        expect($facebookSocialite->provider)->toBe('facebook');
    });

    test('creates user with name from oauth user', function () use ($getMockUser): void {
        $oauthUser = $getMockUser(['name' => 'John Doe']);
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('google', $oauthUser);
        $user = $socialiteUser->user;

        expect($user->name)->toContain('John');
        expect($user->email)->toBe($oauthUser->getEmail());
    });

    test('returns socialite user with user relationship loaded', function () use ($getMockUser): void {
        $oauthUser = $getMockUser();
        $action = app(RegisterOauthUserAction::class);

        $socialiteUser = $action->execute('google', $oauthUser);

        expect($socialiteUser->user)->toBeInstanceOf(User::class);
        expect($socialiteUser->user->email)->toBe($oauthUser->getEmail());
    });

    test('handles multiple registrations with same provider', function () use ($getMockUser): void {
        $action = app(RegisterOauthUserAction::class);

        $user1 = $getMockUser(['id' => 'google-1', 'email' => 'user1-'.uniqid().'@example.com']);
        $user2 = $getMockUser(['id' => 'google-2', 'email' => 'user2-'.uniqid().'@example.com']);

        $social1 = $action->execute('google', $user1);
        $social2 = $action->execute('google', $user2);

        expect($social1->provider)->toBe('google');
        expect($social2->provider)->toBe('google');
        expect($social1->provider_id)->not->toBe($social2->provider_id);
        expect($social1->user_id)->not->toBe($social2->user_id);
    });
});
