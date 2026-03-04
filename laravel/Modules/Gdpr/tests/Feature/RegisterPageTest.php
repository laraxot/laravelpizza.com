<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\User\Models\User;

use function Pest\Laravel\get;

beforeEach(function (): void {
    app()->setLocale('en');
    config(['app.locale' => 'en']);
});

// ---------------------------------------------------------------------------
// Page rendering (GET) - Folio + Livewire widget
// ---------------------------------------------------------------------------

it('renders the registration page successfully', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee(trans('gdpr::register.form.cta_title'))
        ->assertSee(trans('gdpr::register.form.cta_subtitle'));
});

it('displays all required form fields', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee(trans('gdpr::register.fields.first_name.label'))
        ->assertSee(trans('gdpr::register.fields.last_name.label'))
        ->assertSee(trans('gdpr::register.fields.email.label'))
        ->assertSee(trans('gdpr::register.fields.password.label'))
        ->assertSee(trans('gdpr::register.fields.password_confirmation.label'))
        ->assertSee(trans('gdpr::register.sections.user_info'))
        ->assertSee(trans('gdpr::register.sections.required_consents'));
});

it('displays all required consent checkboxes', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee(trans('gdpr::register.consents.terms_label'));
});

it('displays optional marketing consent', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee(trans('gdpr::register.consents.marketing_label'));
});

it('displays login link on registration page', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('auth/login');
});

it('contains proper SEO meta tags', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('<title>', false)
        ->assertSee(trans('gdpr::register.title'));
});

it('has proper accessibility attributes', function (): void {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('aria-label');
});

it('prevents registration when already logged in', function (): void {
    $user = User::factory()->create();
    Auth::login($user);

    get('/en/auth/register')
        ->assertRedirect();
});

// ---------------------------------------------------------------------------
// Livewire widget validation and submission
// ---------------------------------------------------------------------------

it('requires first name to be filled', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['first_name']);
});

it('requires last name to be filled', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('email', 'john@example.com')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['last_name']);
});

it('requires email to be filled', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['email']);
});

it('requires email to be valid format', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'invalid-email')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['email']);
});

it('requires email to be unique', function (): void {
    $existingEmail = 'existing.'.uniqid().'@example.com';
    User::factory()->create(['email' => $existingEmail]);

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', $existingEmail)
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['email']);
});

it('requires password to be filled', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['password']);
});

it('requires password confirmation to match', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'DifferentPassword123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['password_confirmation']);
});

it('requires privacy policy consent to be accepted', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['privacy_accepted']);
});

it('requires terms consent to be accepted', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->call('submit')
        ->assertHasErrors(['terms_accepted']);
});

it('allows registration with all required fields and consents', function (): void {
    if (! Illuminate\Support\Facades\Schema::connection('gdpr')->hasTable('treatments')) {
        test()->markTestSkipped('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    $email = 'john.doe.'.uniqid().'@example.com';

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', $email)
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->set('marketing_consent', false)
        ->call('submit');

    expect(User::where('email', $email)->exists())->toBeTrue();
});

it('allows registration with optional marketing consent', function (): void {
    if (! Illuminate\Support\Facades\Schema::connection('gdpr')->hasTable('treatments')) {
        test()->markTestSkipped('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    $email = 'jane.smith.'.uniqid().'@example.com';

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Jane')
        ->set('last_name', 'Smith')
        ->set('email', $email)
        ->set('password', 'Password123!')
        ->set('password_confirmation', 'Password123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->set('marketing_consent', true)
        ->call('submit');

    expect(User::where('email', $email)->exists())->toBeTrue();
});

it('stores user data correctly after successful registration', function (): void {
    if (! Illuminate\Support\Facades\Schema::connection('gdpr')->hasTable('treatments')) {
        test()->markTestSkipped('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    $email = 'alice.'.uniqid().'@example.com';

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Alice')
        ->set('last_name', 'Johnson')
        ->set('email', $email)
        ->set('password', 'SecurePass123!')
        ->set('password_confirmation', 'SecurePass123!')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit');

    $user = User::where('email', $email)->first();

    expect($user)->not->toBeNull();
    expect($user->first_name)->toBe('Alice');
    expect($user->last_name)->toBe('Johnson');
    expect($user->email)->toBe($email);
    expect($user->is_active)->toBeTrue();
});

it('hashes the password after registration', function (): void {
    if (! Illuminate\Support\Facades\Schema::connection('gdpr')->hasTable('treatments')) {
        test()->markTestSkipped('GDPR treatments table not migrated. Run: php artisan migrate --env=testing');
    }

    $plainPassword = 'MySecurePassword123!';
    $email = 'bob.'.uniqid().'@example.com';

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Bob')
        ->set('last_name', 'Wilson')
        ->set('email', $email)
        ->set('password', $plainPassword)
        ->set('password_confirmation', $plainPassword)
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit');

    $user = User::where('email', $email)->first();

    expect($user->password)->not->toBe($plainPassword);
    expect($user->password)->not->toBeEmpty();
});
