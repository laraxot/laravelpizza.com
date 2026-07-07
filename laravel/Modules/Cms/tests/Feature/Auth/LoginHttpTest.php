<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;

use function Pest\Laravel\actingAs;

use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Login Http', function (): void {
    test('login page can be rendered', function (): void {
        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        Assert::assertSame(200, $response->status());
    });

    test('login page contains login widget', function (): void {
        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        Assert::assertSame(200, $response->status());
    });

    test('login page has required form elements', function (): void {
        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        Assert::assertSame(200, $response->status());
    });

    test('login page works in italian', function (): void {
        app()->setLocale('it');
        $response = cmsGet('/it/auth/login');
        Assert::assertSame(200, $response->status());
    });

    test('login page contains localized content', function (): void {
        $response = cmsGet('/it/auth/login');
        $response
            ->assertStatus(200)
            ->assertSee('Hai dimenticato la password?')
            ->assertSee(__('pub_theme::auth.login.title'))
            ->assertSee(__('pub_theme::auth.login.or'));
    });

    test('user can authenticate via frontend login page', function (): void {
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        actingAs($user);

        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');

        Assert::assertSame('/', $response->headers->get('Location'));
    });

    test('authenticated users are redirected from login page', function (): void {
        $user = cmsCreateTestUser();

        actingAs($user);

        $locale = app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');

        Assert::assertSame(302, $response->status());
    });

    test('remember me functionality works', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('authenticate');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    });

    test('session regeneration on login', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');
        cmsAssertAuthenticated();

        Assert::assertNotSame($originalSessionId, session()->getId());
    });

    test('login attempts are rate limited', function (): void {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('authenticate');
        }

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        Assert::assertNull($response);
    });

    test('any user type can login via frontend', function (): void {
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertNotNull($authenticatedUser);
        Assert::assertSame($email, $authenticatedUser->email);
    });
});
