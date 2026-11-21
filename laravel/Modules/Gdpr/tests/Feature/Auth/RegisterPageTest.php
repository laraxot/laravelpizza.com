<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature\Auth;

use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\Gdpr\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Gdpr\Tests\TestCase $this */
    LaravelLocalization::setLocale('en');
    app()->setLocale('en');
    config(['app.locale' => 'en']);
});

it('can render the registration page in English', function (): void {
    gdprGet('/en/auth/register')
        ->assertStatus(200)
        // Il titolo della pagina e' del tema ospite: del modulo e' il form, quindi si cerca la sua prima etichetta.
        ->assertSeeText(__('gdpr::register.fields.first_name.label'));

    Livewire::test(RegisterWidget::class)->assertStatus(200);
});

it('displays the registration form elements in English', function (): void {
    gdprGet('/en/auth/register')
        ->assertSeeInOrder([
            __('gdpr::register.fields.first_name.label'),
            __('gdpr::register.fields.last_name.label'),
            __('gdpr::register.fields.email.label'),
            __('gdpr::register.fields.password.label'),
            __('gdpr::register.fields.password_confirmation.label'),
        ]);
});

it('can register a new user', function (): void {
    $email = 'auth-register-'.uniqid().'@example.test';

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Test')
        ->set('last_name', 'User')
        ->set('email', $email)
        ->set('password', 'Str0ng-Passw0rd!2026')
        ->set('password_confirmation', 'Str0ng-Passw0rd!2026')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasNoErrors();

    // `users` sta sulla connessione `user`, non su quella di default.
    gdprTest()->assertDatabaseHasRow('users', [
        'email' => $email,
    ], 'user');
});

it('shows validation errors for invalid data', function (): void {
    Livewire::test(RegisterWidget::class)
        ->set('email', 'invalid-email')
        ->set('password', 'short')
        ->set('password_confirmation', 'mismatch')
        ->set('privacy_accepted', false)
        ->set('terms_accepted', false)
        ->call('submit')
        ->assertHasErrors([
            'first_name',
            'email',
            'password',
            'password_confirmation',
            'privacy_accepted',
            'terms_accepted',
        ]);
});

it('does not display duplicated phrases on the registration page', function (): void {
    $response = gdprGet('/en/auth/register');

    $response->assertDontSeeText('Informazioni Generali', false);
    $response->assertDontSeeText('Hai gia un account?', false);
});

it('shows the consents in English in the order privacy, terms, marketing', function (): void {
    gdprGet('/en/auth/register')
        ->assertSeeTextInOrder([
            __('gdpr::register.consents.privacy_policy_label'),
            __('gdpr::register.consents.terms_label'),
            __('gdpr::register.consents.marketing_label'),
        ]);
});
