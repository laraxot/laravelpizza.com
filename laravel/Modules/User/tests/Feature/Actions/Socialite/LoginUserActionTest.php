<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Modules\User\Actions\Socialite\LoginUserAction;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

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

    test('redirects to intended page when available', function (): void {
        $user = User::factory()->create();

        $socialiteUser = new SocialiteUser([
            'provider' => 'google',
            'provider_id' => 'google-123',
            'email' => (string) $user->email,
        ]);
        $socialiteUser->setRelation('user', $user);

        $response = app(LoginUserAction::class)->execute($socialiteUser);

        expect($response)->toBeInstanceOf(RedirectResponse::class);
        $this->assertAuthenticatedAs($user);
    });

    test('dispatches event with correct socialite user instance', function (): void {
        Event::fake();

        $user = User::factory()->create();

        $socialiteUser = new SocialiteUser([
            'provider' => 'github',
            'provider_id' => 'github-456',
            'email' => (string) $user->email,
        ]);
        $socialiteUser->setRelation('user', $user);

        app(LoginUserAction::class)->execute($socialiteUser);

        Event::assertDispatched(SocialiteUserConnected::class, function (SocialiteUserConnected $event) use ($socialiteUser): bool {
            return $event->socialiteUser->provider === $socialiteUser->provider
                && $event->socialiteUser->provider_id === $socialiteUser->provider_id;
        });
    });

    test('authenticates different users independently', function (): void {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $socialiteUser1 = new SocialiteUser([
            'provider' => 'google',
            'provider_id' => 'google-1',
            'email' => (string) $user1->email,
        ]);
        $socialiteUser1->setRelation('user', $user1);

        $socialiteUser2 = new SocialiteUser([
            'provider' => 'google',
            'provider_id' => 'google-2',
            'email' => (string) $user2->email,
        ]);
        $socialiteUser2->setRelation('user', $user2);

        app(LoginUserAction::class)->execute($socialiteUser1);
        $this->assertAuthenticatedAs($user1);

        app(LoginUserAction::class)->execute($socialiteUser2);
        $this->assertAuthenticatedAs($user2);
    });

    test('returns redirect response instance', function (): void {
        $user = User::factory()->create();

        $socialiteUser = new SocialiteUser([
            'provider' => 'test',
            'provider_id' => 'test-789',
            'email' => (string) $user->email,
        ]);
        $socialiteUser->setRelation('user', $user);

        $response = app(LoginUserAction::class)->execute($socialiteUser);

        expect($response)->toBeInstanceOf(RedirectResponse::class);
        expect($response->getTargetUrl())->toContain('laravelpizza');
    });

    test('handles null user assertion gracefully', function (): void {
        $socialiteUser = new SocialiteUser([
            'provider' => 'test',
            'provider_id' => 'test-null',
            'email' => 'test-null-'.uniqid().'@example.com',
        ]);
        $socialiteUser->setRelation('user', null);

        app(LoginUserAction::class)->execute($socialiteUser);
    })->throws(InvalidArgumentException::class);

    test('preserves user attributes after login', function (): void {
        $user = User::factory()->create([
            'email' => 'preserve-'.uniqid().'@example.com',
            'name' => 'John Doe',
            'is_active' => true,
        ]);

        $socialiteUser = new SocialiteUser([
            'provider' => 'oauth',
            'provider_id' => 'oauth-'.uniqid(),
            'email' => (string) $user->email,
        ]);
        $socialiteUser->setRelation('user', $user);

        app(LoginUserAction::class)->execute($socialiteUser);

        $authenticatedUser = auth()->user();
        expect($authenticatedUser->email)->toBe($user->email);
        expect($authenticatedUser->name)->toBe($user->name);
        expect($authenticatedUser->is_active)->toBeTrue();
    });
});
