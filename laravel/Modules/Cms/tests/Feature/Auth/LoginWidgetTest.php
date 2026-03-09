<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

uses(TestCase::class);

// LOGIN WIDGET TESTS - Filament Component
// ✅ Test del WIDGET Filament, non della pagina
// ✅ Focus su: rendering, form interaction, authentication logic
// ✅ Architettura: Filament Widget + XotData + dynamic resolution

// WIDGET STRUCTURE TESTS

test('widget can be rendered', function (): void {
    $component = Livewire::test(LoginWidget::class);

    $component->assertStatus(200);
});

test('widget has correct view', function (): void {
    expect(LoginWidget::getView())->toBe('user::filament.widgets.login');
});

test('widget initializes correctly', function (): void {
    $component = Livewire::test(LoginWidget::class);

    // Widget dovrebbe inizializzare la proprietà data
    $component->assertSet('data', []);
});

// WIDGET DATA BINDING TESTS

test('can set form data', function (): void {
    $component = Livewire::test(LoginWidget::class);

    // Set form data
    $component->set('data.email', 'test@example.com')->set('data.password', 'password123');

    // Verifica che i dati siano stati impostati
    $component->assertSet('data.email', 'test@example.com')->assertSet('data.password', 'password123');
});

// WIDGET AUTHENTICATION LOGIC TESTS

test('authenticates user with valid credentials', function (): void {
    // ✅ Utilizzo funzione centralizzata dal TestCase
    $email = static::generateUniqueEmail();
    $user = static::createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $component = Livewire::test(LoginWidget::class);

    $component->set('data.email', $email)->set('data.password', 'password123')->call('save');

    // Verifica che l'utente sia autenticato
    assertAuthenticated();

    // Verifica che sia l'utente corretto
    $authenticatedUser = Auth::user();
    expect($authenticatedUser)->not->toBeNull();
    expect($authenticatedUser?->email)->toBe($email);
});

test('handles invalid credentials gracefully', function (): void {
    // ✅ Utilizzo funzioni centralizzate dal TestCase
    $email = static::generateUniqueEmail();
    static::createTestUser([
        'email' => $email,
        'password' => Hash::make('correct_password'),
    ]);

    assertGuest();

    $component = Livewire::test(LoginWidget::class);

    // Tenta login con password sbagliata
    $component->set('data.email', $email)->set('data.password', 'wrong_password')->call('save');

    // L'utente dovrebbe rimanere guest
    assertGuest();
});

// WIDGET XOTDATA INTEGRATION TESTS

test('authentication works regardless of user type', function (): void {
    // ✅ Utilizzo funzioni centralizzate dal TestCase
    $email = static::generateUniqueEmail();
    $user = static::createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $component = Livewire::test(LoginWidget::class);

    $component->set('data.email', $email)->set('data.password', 'password123')->call('save');

    assertAuthenticated();

    // Verifica che l'utente autenticato sia del tipo corretto
    $authenticatedUser = Auth::user();
    expect($authenticatedUser)->toBeInstanceOf(static::getUserClass());
    expect($authenticatedUser?->email)->toBe($email);
});

test('getUserClass returns valid class', function (): void {
    // ✅ Utilizzo funzione centralizzata dal TestCase
    $userClass = static::getUserClass();

    expect($userClass)->toBeString();
    expect(class_exists($userClass))->toBeTrue();

    // Verifica che il class implementi UserContract
    $interfaces = class_implements($userClass);
    expect($interfaces)->toContain(UserContract::class);
});

test('createTestUser creates valid instances', function (): void {
    // ✅ Utilizzo funzione centralizzata dal TestCase
    $user = static::createTestUser();

    // Verifica proprietà richieste per autenticazione
    expect($user->email)->toBeString();
    expect($user->password)->toBeString();

    // Verifica che l'utente sia nel database
    $userClass = static::getUserClass();
    $foundUser = $userClass::where('email', $user->email)->first();
    expect($foundUser)->not->toBeNull();
    expect($foundUser->email)->toBe($user->email);
});
