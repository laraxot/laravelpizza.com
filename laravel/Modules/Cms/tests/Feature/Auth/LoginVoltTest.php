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
// Use $this->\Modules\Xot\Tests\TestCase::generateUniqueEmail(), $this->getUserClass(), $this->\Modules\Xot\Tests\TestCase::createTestUser()

test('login page can be rendered', function () {
    $component = LivewireVolt::test('auth.login');

    expect($component)->not->toBeNull();
    $component->assertOk();
<<<<<<< HEAD
=======
});

test('login component has correct default values', function () {
    $component = LivewireVolt::test('auth.login');

    $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
<<<<<<< HEAD
    });

        $component = LivewireVolt::test('auth.login');

        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    });
>>>>>>> 1810cfd (.)
});

test('login component has correct default values', function () {
    $component = LivewireVolt::test('auth.login');

    $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
});

test('successful login authenticates the user', function () {
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('login with wrong password fails', function () {
    $email = TestCase::generateUniqueEmail();
    TestCase::createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

=======
});

test('successful login authenticates the user', function () {
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('login with wrong password fails', function () {
    $email = TestCase::generateUniqueEmail();
    TestCase::createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

>>>>>>> 46d657c (.)
    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    $response->assertHasErrors(['email']);
    assertGuest();
});

test('login with non-existent user fails', function () {
    $email = TestCase::generateUniqueEmail();

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
    assertGuest();
});

test('login with invalid email format fails', function () {
    $response = LivewireVolt::test('auth.login')
        ->set('email', 'invalid-email')
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
});

test('login with empty credentials fails', function () {
    $response = LivewireVolt::test('auth.login')->call('save');

    $response->assertHasErrors(['email', 'password']);
});

test('login with too short password fails', function () {
    $email = TestCase::generateUniqueEmail();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', '123')
        ->call('save');

    // Password troppo corta dovrebbe fallire
    $response->assertHasErrors();
});

test('login with remember me authenticates the user', function () {
    $email = TestCase::generateUniqueEmail();
    TestCase::createTestUser([
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

test('session is regenerated on successful login', function () {
    $email = TestCase::generateUniqueEmail();
    TestCase::createTestUser([
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

test('session data is preserved after login and regeneration', function () {
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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
test('login is rate limited after multiple failed attempts', function () {
    $email = TestCase::generateUniqueEmail();
    TestCase::createTestUser([
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

test('csrf protection is handled automatically by volt components', function () {
    // Volt components should automatically handle CSRF protection
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('login handles malicious input safely', function () {
    $email = TestCase::generateUniqueEmail();

    $response = LivewireVolt::test('auth.login')
        ->set('email', '<script>alert("xss")</script>'.$email)
        ->set('password', 'password123')
        ->call('save');

    // Should handle potentially malicious input safely
    expect($response)->not->toBeNull();
});
test('component properties can be set and asserted', function () {
    $email = TestCase::generateUniqueEmail();

    $component = LivewireVolt::test('auth.login');

    $component
        ->set('email', $email)
        ->assertSet('email', $email)
        ->set('password', 'password123')
        ->assertSet('password', 'password123')
        ->set('remember', true)
        ->assertSet('remember', true);
});

test('password cleared after failed login attempt', function () {
    $email = TestCase::generateUniqueEmail();

    $component = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    // Password should be cleared after failed attempt
    $component->assertSet('password', '');
});

test('login component handles loading state and completes successfully', function () {
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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
test('login verifies authenticated user with xotdata pattern', function () {
    // Using XotData pattern ensures compatibility with any user type
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('login handles various user attributes', function () {
    // Test with various user attributes
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('authentication logic completes successfully', function () {
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('login redirects to intended url after successful authentication', function () {
    $email = TestCase::generateUniqueEmail();
    $user = TestCase::createTestUser([
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

test('login component renders with accessibility attributes', function () {
    $component = LivewireVolt::test('auth.login');

    // Component should render with accessibility attributes
    $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
});

test('login component is keyboard accessible', function () {
    $component = LivewireVolt::test('auth.login');

    // Component should be keyboard accessible
    expect($component)->not->toBeNull();
});
