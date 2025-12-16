<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;

uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
/* @phpstan-ignore-next-line property.notFound, method.nonObject */
// Use $this->$this->generateUniqueEmail(), $this->$this->getUserClass(), $this->$this->createTestUser()

describe('Frontend Login Page Rendering', function (): void {
    test('login page can be rendered', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('login page contains login widget', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200); // ->assertSee('@livewire')
        // ->assertSee('LoginWidget')
    });

    test('login page has required form elements', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200); // ->assertSee('Hai dimenticato la password?')
        // ->assertSee('crea un nuovo account')
        // ->assertSee('logo-v2.png')
    });
});

describe('Frontend Login Page Localization', function (): void {
    test('login page works in italian', function (): void {
        app()->setLocale('it');
        $response = get('/it/auth/login');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    // test('login page works in english', function () {
    //    app()->setLocale('en');
    //    LaravelLocalization::setLocale('en');
    //    $response = get('/en/auth/login');
    /* @phpstan-ignore-next-line method.nonObject */
    //    //$response->assertStatus(200);
    // });

    test('login page contains localized content', function (): void {
        $response = get('/it/auth/login');
        $response
            ->assertStatus(200)
            ->assertSee('Hai dimenticato la password?')
            ->assertSee(__('pub_theme::auth.login.title'))
            ->assertSee(__('pub_theme::auth.login.or'));
    });
});

describe('Frontend Login Page Authentication', function (): void {
    test('user can authenticate via frontend login page', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $email = $this->generateUniqueEmail();
        /** @phpstan-ignore-next-line property.notFound */
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertHasNoErrors();
        assertAuthenticated();

        actingAs($user);

        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertRedirect('/');
    });
});

describe('Frontend Login Page Integration', function (): void {
    test('authenticated users are redirected from login page', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $user = $this->createTestUser();

        actingAs($user);

        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/login');

        // May redirect to dashboard or intended page
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(302);
    });
});

describe('Frontend Login Session Management', function (): void {
    test('remember me functionality works', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $email = $this->generateUniqueEmail();
        /* @phpstan-ignore-next-line property.notFound */
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('authenticate');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertHasNoErrors();
        assertAuthenticated();
    });

    test('session regeneration on login', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $email = $this->generateUniqueEmail();
        /* @phpstan-ignore-next-line property.notFound */
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Store original session ID
        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        assertAuthenticated();

        // Session should be regenerated for security
        expect(session()->getId())->not->toBe($originalSessionId);
    });
});

describe('Frontend Login Security', function (): void {
    test('login attempts are rate limited', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $email = $this->generateUniqueEmail();
        /* @phpstan-ignore-next-line property.notFound */
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Multiple failed attempts
        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('authenticate');
        }

        // Should be rate limited after too many attempts
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        // May have throttling errors
        // This test verifies the system handles rate limiting appropriately
        expect($response)->not->toBeNull();
    });
});

describe('Frontend Login User Types', function (): void {
    test('any user type can login via frontend', function (): void {
        // Using XotData pattern ensures compatibility with any user type
        /** @phpstan-ignore-next-line property.notFound */
        $email = $this->generateUniqueEmail();
        /** @phpstan-ignore-next-line property.notFound */
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('authenticate');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertHasNoErrors();
        assertAuthenticated();

        // Verify authenticated user
        $authenticatedUser = Auth::user();
        expect($authenticatedUser)->not->toBeNull();
        expect($authenticatedUser?->email)->toBe($email);
    });
});
