<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Models\User;
use Modules\User\Actions\Socialite\LoginUserAction;
use Modules\User\Models\SocialiteUser;
use Modules\User\Tests\TestCase;
use Illuminate\Http\RedirectResponse;

uses(TestCase::class, DatabaseTransactions::class);

describe('LoginUserAction', function (): void {
    test('authenticates connected socialite user and dispatches event', function (): void {
        Event::fake([SocialiteUserConnected::class]);

        $user = User::factory()->create();

        $socialiteUser = new SocialiteUser([
            'provider' => 'test-provider',
            'provider_id' => 'provider-id-1',
            'email' => (string) $user->email,
        ]);
        $socialiteUser->setRelation('user', $user);

        $response = app(LoginUserAction::class)->execute($socialiteUser);

        expect($response)->toBeInstanceOf(RedirectResponse::class);
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(SocialiteUserConnected::class);
    });

    test('throws when related user is not authenticatable', function (): void {
        $socialiteUser = new SocialiteUser([
            'provider' => 'test-provider',
            'provider_id' => 'provider-id-2',
            'email' => 'not-authenticatable@example.com',
        ]);

        $socialiteUser->setRelation('user', new stdClass());

        app(LoginUserAction::class)->execute($socialiteUser);
    })->throws(LogicException::class, 'User instance must implement Authenticatable.');
});
