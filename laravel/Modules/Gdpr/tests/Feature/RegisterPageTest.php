<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\User\Models\User;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('renders the registration page successfully', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Create Your FREE Account')
        ->assertSee('No credit card required - 100% FREE forever!');
});

it('displays all required form fields', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('First Name')
        ->assertSee('Last Name')
        ->assertSee('Your Best Email')
        ->assertSee('Secure password')
        ->assertSee('Confirm Password')
        ->assertSee('Personal Information')
        ->assertSee('Required Consents');
});

it('displays all required consent checkboxes', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('I have read and understood the Privacy Policy')
        ->assertSee('I have read and accept the Terms and Conditions');
});

it('displays optional marketing consent', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('I want to receive pizza tips and meetup invitations (optional)');
});

it('requires first name to be filled', function () {
    post('/en/auth/register', [
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['first_name']);
});

it('requires last name to be filled', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['last_name']);
});

it('requires email to be filled', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);
});

it('requires email to be valid format', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'invalid-email',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);
});

it('requires email to be unique', function () {
    User::factory()->create(['email' => 'john@example.com']);

    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);
});

it('requires password to be filled', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires password confirmation to match', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'DifferentPassword123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires password to be at least 12 characters', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'Short1!',
        'password_confirmation' => 'Short1!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires password to contain uppercase letter', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'lowercase123!',
        'password_confirmation' => 'lowercase123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires password to contain lowercase letter', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'UPPERCASE123!',
        'password_confirmation' => 'UPPERCASE123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires password to contain number', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'NoNumbers!',
        'password_confirmation' => 'NoNumbers!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires password to contain special character', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'NoSpecialChar123',
        'password_confirmation' => 'NoSpecialChar123',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['password']);
});

it('requires privacy policy consent to be accepted', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['privacy_accepted']);
});

it('requires terms consent to be accepted', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['terms_accepted']);
});

it('allows registration with all required fields and consents', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
        'marketing_consent' => '0',
    ])
        ->assertStatus(302);

    // Verify user was created
    expect(User::where('email', 'john.doe@example.com')->exists())->toBeTrue();
});

it('allows registration with optional marketing consent', function () {
    post('/en/auth/register', [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
        'marketing_consent' => '1',
    ])
        ->assertStatus(302);

    // Verify user was created
    expect(User::where('email', 'jane.smith@example.com')->exists())->toBeTrue();
});

it('stores user data correctly after successful registration', function () {
    post('/en/auth/register', [
        'first_name' => 'Alice',
        'last_name' => 'Johnson',
        'email' => 'alice@example.com',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302);

    $user = User::where('email', 'alice@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->first_name)->toBe('Alice');
    expect($user->last_name)->toBe('Johnson');
    expect($user->email)->toBe('alice@example.com');
    expect($user->is_active)->toBeTrue();
});

it('hashes the password after registration', function () {
    $plainPassword = 'MySecurePassword123!';

    post('/en/auth/register', [
        'first_name' => 'Bob',
        'last_name' => 'Wilson',
        'email' => 'bob@example.com',
        'password' => $plainPassword,
        'password_confirmation' => $plainPassword,
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302);

    $user = User::where('email', 'bob@example.com')->first();

    expect($user->password)->not->toBe($plainPassword);
    expect($user->password)->not->toBeEmpty();
});

it('redirects after successful registration', function () {
    post('/en/auth/register', [
        'first_name' => 'Charlie',
        'last_name' => 'Brown',
        'email' => 'charlie@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertRedirect();
});

it('trims whitespace from input fields', function () {
    post('/en/auth/register', [
        'first_name' => '  John  ',
        'last_name' => '  Doe  ',
        'email' => '  john@example.com  ',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302);

    $user = User::where('email', 'john@example.com')->first();

    expect($user->first_name)->toBe('John');
    expect($user->last_name)->toBe('Doe');
    expect($user->email)->toBe('john@example.com');
});

it('prevents registration when already logged in', function () {
    $user = User::factory()->create();

    Auth::login($user);

    get('/en/auth/register')
        ->assertRedirect();
});

it('handles very long input names correctly', function () {
    $longName = Str::random(250);

    post('/en/auth/register', [
        'first_name' => $longName,
        'last_name' => 'Doe',
        'email' => 'longname@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['first_name']);
});

it('handles very long email correctly', function () {
    $longEmail = Str::random(200).'@example.com';

    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $longEmail,
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);
});

it('prevents SQL injection attempts in email', function () {
    $maliciousEmail = "john@example.com'; DROP TABLE users; --";

    post('/en/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $maliciousEmail,
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);
});

it('displays login link on registration page', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Already have an account?')
        ->assertSee('Login now');
});

it('contains proper SEO meta tags', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('<title>', false)
        ->assertSee('LaravelPizza Community');
});

it('has proper accessibility attributes', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('aria-label');
});
