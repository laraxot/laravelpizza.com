<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('renders the registration page successfully', function () {
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Create Your FREE Account')
        ->assertSee('No credit card required - 100% FREE forever!');
});

it('displays all required form fields', function () {
    gdprGet('/en/auth/register')
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
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('I have read and understood the Privacy Policy')
        ->assertSee('I have read and accept the Terms and Conditions');
});

it('displays optional marketing consent', function () {
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('I want to receive pizza tips and meetup invitations (optional)');
});

it('requires first name to be filled', function () {
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    UserFactory::new()->createOne(['email' => 'john@example.com']);

    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    Assert::assertTrue(User::where('email', 'john.doe@example.com')->exists());
});

it('allows registration with optional marketing consent', function () {
    gdprPost('/en/auth/register', [
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
    Assert::assertTrue(User::where('email', 'jane.smith@example.com')->exists());
});

it('stores user data correctly after successful registration', function () {
    gdprPost('/en/auth/register', [
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

    Assert::assertNotNull($user);
    Assert::assertSame('Alice', $user->first_name);
    Assert::assertSame('Johnson', $user->last_name);
    Assert::assertSame('alice@example.com', $user->email);
    Assert::assertTrue($user->is_active);
});

it('hashes the password after registration', function () {
    $plainPassword = 'MySecurePassword123!';

    gdprPost('/en/auth/register', [
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
    Assert::assertNotNull($user);

    Assert::assertNotSame($plainPassword, $user->password);
    Assert::assertNotEmpty($user->password);
});

it('redirects after successful registration', function () {
    gdprPost('/en/auth/register', [
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
    gdprPost('/en/auth/register', [
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
    Assert::assertNotNull($user);

    Assert::assertSame('John', $user->first_name);
    Assert::assertSame('Doe', $user->last_name);
    Assert::assertSame('john@example.com', $user->email);
});

it('prevents registration when already logged in', function () {
    $user = UserFactory::new()->createOne();

    Auth::login($user);

    gdprGet('/en/auth/register')
        ->assertRedirect();
});

it('handles very long input names correctly', function () {
    $longName = Str::random(250);

    gdprPost('/en/auth/register', [
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

    gdprPost('/en/auth/register', [
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

    gdprPost('/en/auth/register', [
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
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Already have an account?')
        ->assertSee('Login now');
});

it('contains proper SEO meta tags', function () {
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('<title>', false)
        ->assertSee('<nome progetto> Community');
});

it('has proper accessibility attributes', function () {
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('aria-label');
});
