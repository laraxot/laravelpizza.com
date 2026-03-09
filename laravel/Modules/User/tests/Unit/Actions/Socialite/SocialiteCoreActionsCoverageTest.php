<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Socialite;

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Modules\User\Actions\Socialite\CreateSocialiteUserAction;
use Modules\User\Actions\Socialite\GetUserModelAttributesFromSocialiteAction;
use Modules\User\Actions\Socialite\RetrieveOauthUserAction;
use Modules\User\Datas\SocialiteUserAttributesData;
use Modules\User\Events\InvalidState;
use Modules\User\Models\SocialiteUser;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

describe('Socialite core actions coverage', function (): void {
    it('builds user attributes from oauth user', function (): void {
        $oauthUser = Mockery::mock(SocialiteUserContract::class);
        $oauthUser->shouldReceive('getName')->andReturn('Mario Rossi');
        $oauthUser->shouldReceive('getEmail')->andReturn('mario.rossi@example.com');

        $data = app(GetUserModelAttributesFromSocialiteAction::class)->execute('github', $oauthUser);

        expect($data)->toBeInstanceOf(SocialiteUserAttributesData::class)
            ->and($data->provider)->toBe('github')
            ->and($data->email)->toBe('mario.rossi@example.com')
            ->and($data->firstName)->toBe('Mario')
            ->and($data->lastName)->toBe('Rossi');
    });

    it('throws when provider is empty while building attributes', function (): void {
        $oauthUser = Mockery::mock(SocialiteUserContract::class);
        $oauthUser->shouldReceive('getName')->andReturn('Mario Rossi');
        $oauthUser->shouldReceive('getEmail')->andReturn('mario.rossi@example.com');

        app(GetUserModelAttributesFromSocialiteAction::class)->execute('', $oauthUser);
    })->throws(InvalidArgumentException::class, 'provider non può essere vuoto');

    it('throws when oauth email is invalid while building attributes', function (): void {
        $oauthUser = Mockery::mock(SocialiteUserContract::class);
        $oauthUser->shouldReceive('getName')->andReturn('Mario Rossi');
        $oauthUser->shouldReceive('getEmail')->andReturn(null);

        app(GetUserModelAttributesFromSocialiteAction::class)->execute('github', $oauthUser);
    })->throws(RuntimeException::class, 'email deve essere una stringa non vuota');

    it('retrieves oauth user from socialite driver', function (): void {
        $oauthUser = Mockery::mock(SocialiteUserContract::class);
        $driver = Mockery::mock();
        $driver->shouldReceive('user')->once()->andReturn($oauthUser);

        Socialite::shouldReceive('driver')->once()->with('github')->andReturn($driver);

        $dispatcher = Mockery::mock(Dispatcher::class);
        $dispatcher->shouldNotReceive('dispatch');

        $result = (new RetrieveOauthUserAction($dispatcher))->execute('github');

        expect($result)->toBe($oauthUser);
    });

    it('returns null and dispatches invalid state event when socialite state is invalid', function (): void {
        $exception = new InvalidStateException();

        $driver = Mockery::mock();
        $driver->shouldReceive('user')->once()->andThrow($exception);

        Socialite::shouldReceive('driver')->once()->with('github')->andReturn($driver);

        $dispatcher = Mockery::mock(Dispatcher::class);
        $dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(fn (mixed $event): bool => $event instanceof InvalidState && $event->exception === $exception));

        $result = (new RetrieveOauthUserAction($dispatcher))->execute('github');

        expect($result)->toBeNull();
    });

    it('creates socialite user model with normalized attributes', function (): void {
        $oauthUser = Mockery::mock(SocialiteUserContract::class);
        $oauthUser->shouldReceive('getId')->once()->andReturn('provider-user-1');
        $oauthUser->shouldReceive('getName')->once()->andReturn('Mario Rossi');
        $oauthUser->shouldReceive('getEmail')->once()->andReturn('mario.rossi@example.com');
        $oauthUser->shouldReceive('getAvatar')->once()->andReturn('https://example.com/avatar.jpg');

        $user = Mockery::mock(UserContract::class);
        $user->shouldReceive('getKey')->once()->andReturn('user-1');

        $created = new SocialiteUser();

        $socialiteUserModel = Mockery::mock(SocialiteUser::class);
        $socialiteUserModel->shouldReceive('create')
            ->once()
            ->andReturn($created);

        $result = (new CreateSocialiteUserAction($socialiteUserModel))->execute('github', $oauthUser, $user);

        expect($result)->toBe($created);
    });
});
