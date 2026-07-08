<?php

declare(strict_types=1);

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Mockery\MockInterface;
use Modules\User\Actions\Socialite\CreateSocialiteUserAction;
use Modules\User\Actions\Socialite\GetUserModelAttributesFromSocialiteAction;
use Modules\User\Actions\Socialite\RetrieveOauthUserAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Datas\SocialiteUserAttributesData;
use Modules\User\Events\InvalidState;
use Modules\User\Models\SocialiteUser;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('builds user attributes from oauth user', function (): void {
    $oauthUser = configureMock(SocialiteUserContract::class, function (MockInterface $mock): void {
        $mock->allows(['getName' => 'Mario Rossi']);
        $mock->allows(['getEmail' => 'mario.rossi@example.com']);
    });

    $data = app(GetUserModelAttributesFromSocialiteAction::class)->execute('github', $oauthUser);

    Assert::assertInstanceOf(SocialiteUserAttributesData::class, $data);
    Assert::assertSame('github', $data->provider);
    Assert::assertSame('mario.rossi@example.com', $data->email);
    Assert::assertSame('Mario', $data->firstName);
    Assert::assertSame('Rossi', $data->lastName);
});

test('throws when provider is empty while building attributes', function (): void {
    $oauthUser = configureMock(SocialiteUserContract::class, function (MockInterface $mock): void {
        $mock->allows(['getName' => 'Mario Rossi']);
        $mock->allows(['getEmail' => 'mario.rossi@example.com']);
    });

    try {
        app(GetUserModelAttributesFromSocialiteAction::class)->execute('', $oauthUser);
        Assert::fail('Expected InvalidArgumentException');
    } catch (InvalidArgumentException $exception) {
        Assert::assertSame('Il provider non può essere vuoto', $exception->getMessage());
    }
});

test('throws when oauth email is invalid while building attributes', function (): void {
    $oauthUser = configureMock(SocialiteUserContract::class, function (MockInterface $mock): void {
        $mock->allows(['getName' => 'Mario Rossi']);
        $mock->allows(['getEmail' => null]);
    });

    try {
        app(GetUserModelAttributesFromSocialiteAction::class)->execute('github', $oauthUser);
        Assert::fail('Expected RuntimeException');
    } catch (RuntimeException $exception) {
        Assert::assertSame('L\'email deve essere una stringa non vuota', $exception->getMessage());
    }
});

test('retrieves oauth user from socialite driver', function (): void {
    $oauthUser = configureMock(SocialiteUserContract::class, function (MockInterface $mock): void {
        $mock->allows(['getEmail' => 'user@example.com']);
    });

    $driver = Mockery::mock();
    /* @phpstan-ignore-next-line */
    $driver->shouldReceive('user')->once()->andReturn($oauthUser);

    Socialite::shouldReceive('driver')->with('github')->andReturn($driver);

    $dispatcher = configureMock(Dispatcher::class, function (MockInterface $mock): void {
        $mock->allows(['dispatch' => null]);
    });

    $result = (new RetrieveOauthUserAction($dispatcher))->execute('github');

    Assert::assertSame($oauthUser, $result);
});

test('returns null and dispatches invalid state event when socialite state is invalid', function (): void {
    $exception = new InvalidStateException();

    $driver = Mockery::mock();
    /* @phpstan-ignore-next-line */
    $driver->shouldReceive('user')->once()->andThrow($exception);

    Socialite::shouldReceive('driver')->with('github')->andReturn($driver);

    $dispatcher = configureMock(Dispatcher::class, function (MockInterface $mock) use ($exception): void {
        $mock->allows([
            'dispatch' => function (mixed $event) use ($exception): void {
                Assert::assertInstanceOf(InvalidState::class, $event);
                Assert::assertSame($exception, $event->exception);
            },
        ]);
    });

    $result = (new RetrieveOauthUserAction($dispatcher))->execute('github');

    Assert::assertNull($result);
});

test('creates socialite user model with normalized attributes', function (): void {
    /** @var Modules\Xot\Contracts\UserContract $user */
    $user = UserFactory::new()->createOne();

    $oauthUser = configureMock(SocialiteUserContract::class, function (MockInterface $mock): void {
        $mock->allows([
            'getId' => 'provider-user-1',
            'getName' => 'Mario Rossi',
            'getEmail' => 'mario.rossi@example.com',
            'getAvatar' => 'https://example.com/avatar.jpg',
        ]);
    });

    $result = app(CreateSocialiteUserAction::class)->execute('github', $oauthUser, $user);

    Assert::assertInstanceOf(SocialiteUser::class, $result);
    Assert::assertSame((string) $result->user_id, (string) $user->getKey());
    Assert::assertSame('github', $result->provider);
    Assert::assertSame('provider-user-1', $result->provider_id);
});
