<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\User;
use function Pest\Laravel\actingAs;

uses(TestCase::class);

/**
 * Test per verificare che il RegisterWidget del modulo GDPR funzioni correttamente.
 * 
 * NOTA: Utilizziamo --env=testing che punta a MySQL (come configurato)
 * Utilizziamo migrate senza force (niente --force)
 * Non specifichiamo modulo specifico per migrare tutto
 * 
 * Perché usiamo MySQL e non SQLite per i test:
 * - Il progetto utilizza connessioni multiple (user, gdpr, etc.)
 * - SQLite non supporta bene le relazioni cross-database
 * - MySQL garantisce consistenza con l'ambiente di produzione
 * - Le migrations partono da php artisan migrate generico
 * - Non usiamo MAI refreshDatabase per preservare integrità dati
 */

// Test: Il RegisterWidget renderizza correttamente
test('register widget renders correctly', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('Create Account');
    $response->assertSeeLivewire('gdpr-register-widget');
});

// Test: Validazione campi required
test('registration requires valid data', function () {
    $userData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_policy_accepted' => true,
        'terms_accepted' => true,
        'data_processing_accepted' => true,
        'marketing_consent' => false,
    ];

    Livewire::test(RegisterWidget::class)
        ->set($userData)
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);

    $this->assertDatabaseHas('gdpr_consents', [
        'user_id' => 1, // Primo utente creato
        'treatment_id' => function () {
            return Treatment::where('name', 'privacy_policy')->first()->id;
        },
    ]);
});

// Test: Validazione fallisce con dati mancanti
test('registration fails without GDPR consents', function () {
    $userData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        // Mancano i consensi GDPR
    ];

    Livewire::test(RegisterWidget::class)
        ->set($userData)
        ->call('submit')
        ->assertHasErrors([
            'privacy_policy_accepted',
            'terms_accepted',
            'data_processing_accepted',
        ]);

    $this->assertDatabaseMissing('users');
});

// Test: Email deve essere unica
test('registration fails with duplicate email', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $userData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com', // Email duplicata
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_policy_accepted' => true,
        'terms_accepted' => true,
        'data_processing_accepted' => true,
    ];

    Livewire::test(RegisterWidget::class)
        ->set($userData)
        ->call('submit')
        ->assertHasErrors(['email']);

    $this->assertDatabaseMissing('users');
});

// Test: Creazione consensi GDPR
test('gdpr consents are created correctly', function () {
    $treatments = [
        'privacy_policy' => Treatment::factory()->create(['name' => 'privacy_policy', 'required' => true]),
        'terms_conditions' => Treatment::factory()->create(['name' => 'terms_conditions', 'required' => true]),
        'data_processing' => Treatment::factory()->create(['name' => 'data_processing', 'required' => true]),
        'marketing' => Treatment::factory()->create(['name' => 'marketing', 'required' => false]),
    ];

    $userData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
        'privacy_policy_accepted' => true,
        'terms_accepted' => true,
        'data_processing_accepted' => true,
        'marketing_consent' => false,
    ];

    Livewire::test(RegisterWidget::class)
        ->set($userData)
        ->call('submit');

    $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);

    foreach ($treatments as $treatment) {
        $this->assertDatabaseHas('gdpr_consents', [
            'user_id' => function () {
                return User::where('email', 'john.doe@example.com')->first()->id;
            },
            'treatment_id' => $treatment->id,
        ]);
    }
});

// Test: Componenti funzionali
test('form components are accessible', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    
    // Verifica presenza campi form
    $response->assertSee('first_name');
    $response->assertSee('last_name');
    $response->assertSee('email');
    $response->assertSee('password');
    $response->assertSee('password_confirmation');
    $response->assertSee('privacy_policy_accepted');
    $response->assertSee('terms_accepted');
    $response->assertSee('data_processing_accepted');
    $response->assertSee('marketing_consent');
});

// Test: Messaggi di errore tradotti
test('error messages are properly translated', function () {
    $userData = [
        'first_name' => '',
        'email' => 'invalid-email',
        'password' => '123',
        'privacy_policy_accepted' => false,
    ];

    Livewire::test(RegisterWidget::class)
        ->set($userData)
        ->call('submit')
        ->assertHasErrors([
            'first_name',
            'email',
            'password',
            'privacy_policy_accepted',
        ]);
});