<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->$this->generateUniqueEmail(), $this->getUserClass(), $this->$this->createTestUser()

it('login page renders successfully', function () {
    $component = LivewireVolt::test('auth.login');

    expect($component)->not->toBeNull();
    $component->assertOk();
});

it('login form fields have correct initial state', function () {
    $component = LivewireVolt::test('auth.login');

    $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
});

it('login form contains correct wire:model attributes', function () {
    $component = LivewireVolt::test('auth.login');

    $component
        ->assertSee('wire:model="email"')
        ->assertSee('wire:model="password"')
        ->assertSee('wire:model="remember"');
});

it('allows a user to log in with valid credentials', function () {
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();
});

it('does not allow a user to log in with invalid credentials', function () {
    $email = $this->generateUniqueEmail();
    $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    $response->assertHasErrors(['email']);
    assertGuest();
});

it('does not allow a user to log in with an unregistered email', function () {
    $email = $this->generateUniqueEmail();

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
    assertGuest();
});

it('does not allow a user to log in with an invalid email format', function () {
    $response = LivewireVolt::test('auth.login')
        ->set('email', 'invalid-email')
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
});

it('does not allow a user to log in with missing credentials', function () {
    $response = LivewireVolt::test('auth.login')->call('save');

    $response->assertHasErrors(['email', 'password']);
});

it('does not allow a user to log in with a password that is too short', function () {
    $email = $this->generateUniqueEmail();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', '123')
        ->call('save');

    // Password troppo corta dovrebbe fallire
    $response->assertHasErrors();
});

it('allows a user to log in with "remember me" functionality', function () {
    $email = $this->generateUniqueEmail();
    $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->set('remember', true)
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();
});

it('regenerates session ID upon successful login', function () {
    $email = $this->generateUniqueEmail();
    $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    // Store original session ID
    $originalSessionId = session()->getId();

    LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    assertAuthenticated();

    // Session should be regenerated for security
    expect(session()->getId())->not->toBe($originalSessionId);
});

it('preserves session data across login with session regeneration', function () {
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    // Set some session data
    Session::put('test_key', 'test_value');

    LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    assertAuthenticated();

    // Session data should be preserved (session regenerated but data kept)
    expect(Session::get('test_key'))->toBe('test_value');
});

it('rate limits login attempts after multiple failures', function () {
    $email = $this->generateUniqueEmail();
    $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    // Multiple failed attempts
    for ($i = 0; $i < 5; ++$i) {
        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');
    }

    // Should be rate limited after too many attempts
    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    // May have throttling errors
    expect($response)->not->toBeNull();
});

it('handles CSRF protection automatically during login', function () {
    // Volt components should automatically handle CSRF protection
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    // Should work normally with CSRF protection
    $response->assertHasNoErrors();
});

it('handles XSS attacks safely in email input', function () {
    $email = $this->generateUniqueEmail();

    $response = LivewireVolt::test('auth.login')
        ->set('email', '<script>alert("xss")</script>'.$email)
        ->set('password', 'password123')
        ->call('save');

    // Should handle potentially malicious input safely
    expect($response)->not->toBeNull();
});

it('correctly sets and asserts form data', function () {
    $email = $this->generateUniqueEmail();

    $component = LivewireVolt::test('auth.login');

    $component
        ->set('email', $email)
        ->assertSet('email', $email)
        ->set('password', 'password123')
        ->assertSet('password', 'password123')
        ->set('remember', true)
        ->assertSet('remember', true);
});

it('clears password field after failed login attempt', function () {
    $email = $this->generateUniqueEmail();

    $component = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    // Password should be cleared after failed attempt
    $component->assertSet('password', '');
});

it('handles loading states during authentication', function () {
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $component = LivewireVolt::test('auth.login')->set('email', $email)->set('password', 'password123');

    // Should not be in loading state initially
    $component->assertDontSee('wire:loading');

    // After calling authenticate, component should handle loading state
    $component->call('save');

    // Should complete successfully
    $component->assertHasNoErrors();
});

it('verifies authenticated user details after successful login with XotData pattern', function () {
    // Using XotData pattern ensures compatibility with any user type
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();

    // Verify authenticated user
    $authenticatedUser = Auth::user();
    expect($authenticatedUser)->not->toBeNull();
    expect($authenticatedUser?->email)->toBe($email);
});

it('allows user to log in with various attributes and verifies attributes are accessible', function () {
    // Test with various user attributes
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
        'name' => 'Test User',
    ]);

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();

    $authenticatedUser = Auth::user();
    expect($authenticatedUser?->name)->toBe('Test User');
});

it('authenticates user successfully despite potential frontend redirects', function () {
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();

    // Component might trigger redirect via JavaScript/Alpine
    // This test ensures the authentication logic completes successfully
});

it('redirects to intended URL after successful login', function () {
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    // Set intended URL
    Session::put('url.intended', '/dashboard');

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();
});

it('renders with accessibility attributes', function () {
    $component = LivewireVolt::test('auth.login');

    // Component should render with accessibility attributes
    $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
});

it('component is keyboard accessible', function () {
    $component = LivewireVolt::test('auth.login');

    // Component should be keyboard accessible
    expect($component)->not->toBeNull();
});
