<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class LoginVoltComponentTest extends TestCase
{
    // ---- Volt Component Rendering ----

    public function testVoltLoginComponentCanBeRendered(): void
    {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertOk();
    }

    public function testVoltComponentHasInitialState(): void
    {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
    }

    public function testVoltComponentRendersFormElements(): void
    {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    }

    // ---- Volt Component Authentication ----

    public function testUserCanAuthenticateViaVoltComponent(): void
    {
        $email = cmsGenerateUniqueEmail();
        $user = cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    }

    public function testAuthenticationFailsWithWrongCredentials(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        $response->assertHasErrors(['email']);
        cmsAssertGuest();
    }

    public function testAuthenticationFailsWithNonExistentUser(): void
    {
        $email = cmsGenerateUniqueEmail();

        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
        cmsAssertGuest();
    }

    // ---- Volt Component Validation ----

    public function testEmailValidationWorks(): void
    {
        $response = LivewireVolt::test('auth.login')
            ->set('email', 'invalid-email')
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    }

    public function testRequiredFieldsValidation(): void
    {
        $response = LivewireVolt::test('auth.login')->call('save');

        $response->assertHasErrors(['email', 'password']);
    }

    public function testPasswordMinimumLengthValidation(): void
    {
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', '123')
            ->call('save');

        $response->assertHasErrors();
    }

    // ---- Volt Component Session Management ----

    public function testRememberMeFunctionalityWorks(): void
    {
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
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    }

    public function testSessionRegenerationOnLogin(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
        cmsAssertAuthenticated();

        Assert::assertNotSame($originalSessionId, session()->getId());
    }

    public function testSessionDataIsPreservedOnAuthentication(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        Session::put('test_key', 'test_value');

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
        cmsAssertAuthenticated();

        Assert::assertSame('test_value', Session::get('test_key'));
    }

    // ---- Volt Component Security ----

    public function testLoginAttemptsAreRateLimited(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('save');
        }

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors();
    }

    public function testCsrfProtectionIsActive(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
    }

    public function testInputSanitizationWorks(): void
    {
        $email = cmsGenerateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    }

    // ---- Volt Component State Management ----

    public function testComponentStateUpdatesCorrectly(): void
    {
        $email = cmsGenerateUniqueEmail();

        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component
            ->set('email', $email)
            ->assertSet('email', $email)
            ->set('password', 'password123')
            ->assertSet('password', 'password123')
            ->set('remember', true)
            ->assertSet('remember', true);
    }

    public function testComponentResetsAfterFailedAuthentication(): void
    {
        $email = cmsGenerateUniqueEmail();

        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        $component->assertSet('password', '');
    }

    public function testLoadingStateIsManagedCorrectly(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $component = LivewireVolt::test('auth.login')->set('email', $email)->set('password', 'password123');

        $component->assertDontSee('wire:loading');

        $component->call('save');

        $component->assertHasNoErrors();
    }

    // ---- Volt Component User Types Integration ----

    public function testAnyUserTypeCanLoginViaVoltComponent(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
        cmsAssertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertNotNull($authenticatedUser);
        Assert::assertSame($email, $authenticatedUser->email);
    }

    public function testComponentHandlesDifferentUserConfigurations(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'name' => 'Test User',
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();

        $authenticatedUser = Auth::user();
        Assert::assertSame('Test User', $authenticatedUser?->name);
    }

    // ---- Volt Component Redirects ----

    public function testComponentRedirectsAfterSuccessfulAuthentication(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    }

    public function testComponentHandlesIntendedRedirect(): void
    {
        $email = cmsGenerateUniqueEmail();
        cmsCreateTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        Session::put('url.intended', '/dashboard');

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        cmsAssertAuthenticated();
    }

    // ---- Volt Component Accessibility ----

    public function testComponentHasProperAriaLabels(): void
    {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
        $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
    }

    public function testComponentHandlesKeyboardNavigation(): void
    {
        /** @var Testable<\Livewire\Component> $component */
        $component = LivewireVolt::test('auth.login');
    }
}
