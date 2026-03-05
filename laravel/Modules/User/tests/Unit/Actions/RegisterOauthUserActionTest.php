<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\RegisterOauthUserAction;
use Modules\User\Events\Registered;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('RegisterOauthUserAction', function (): void {
    $getMockUser = function (array $attributes = []): SocialiteUserContract {
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

    it('registers oauth user successfully', function () use ($getMockUser): void {
        $oauthUser = $getMockUser(['name' => 'Mario Rossi']);
        $email = $oauthUser->getEmail();
        $action = app(RegisterOauthUserAction::class);

        expect(User::where('email', $email)->exists())->toBeFalse();

        $socialiteUser = $action->execute('google', $oauthUser);

        expect($socialiteUser)->toBeInstanceOf(SocialiteUser::class);
        expect($socialiteUser->email)->toBe($email);

        $user = User::where('email', $email)->first();
        expect($user)->not->toBeNull();
        expect($user->name)->toBe('Mario'); // App splits name
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

        expect($dispatchedEvents)->toHaveCount(1);
        expect($dispatchedEvents[0]->socialiteUser->id)->toBe($socialiteUser->id);
    });

    it('registers users with different emails successfully', function () use ($getMockUser): void {
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
});
