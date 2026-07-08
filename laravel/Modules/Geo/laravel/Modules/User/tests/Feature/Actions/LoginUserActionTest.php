<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Modules\User\Actions\Socialite\LoginUserAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Models\SocialiteUser;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Login User Action', function (): void {
    test('authenticates connected socialite user and dispatches event', function (): void {
        /* @var \Modules\User\Tests\TestCase $this */
        /* @var TestCase $this */
        Event::fake([SocialiteUserConnected::class]);

        $user = UserFactory::new()->createOne();

        $socialiteUser = new SocialiteUser([
            'provider' => 'test-provider',
            'provider_id' => 'provider-id-1',
            'email' => (string) $user->email,
        ]);
        $socialiteUser->setRelation('user', $user);

        $response = app(LoginUserAction::class)->execute($socialiteUser);

        Assert::assertInstanceOf(RedirectResponse::class, $response);
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(SocialiteUserConnected::class);
    });

    test('throws when related user is not authenticatable', function (): void {
        /** @var TestCase $this */
        $socialiteUser = new SocialiteUser([
            'provider' => 'test-provider',
            'provider_id' => 'provider-id-2',
            'email' => 'not-authenticatable@example.com',
        ]);

        $socialiteUser->setRelation('user', new \stdClass());

        try {
            app(LoginUserAction::class)->execute($socialiteUser);
            $this->fail('Expected LogicException was not thrown');
        } catch (\LogicException $exception) {
            Assert::assertSame('User instance must implement Authenticatable.', $exception->getMessage());
        }
    });
});
