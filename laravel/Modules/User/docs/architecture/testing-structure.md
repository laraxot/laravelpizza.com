# Struttura dei Tests del Modulo User

## Panoramica
Questo documento descrive la struttura dei tests per il modulo User, seguendo le best practice Laraxot e le convenzioni di testing moderne.

## Architettura dei Tests

### Separazione per Responsabilità
- **LoginTest.php**: Testa SOLO la pagina `/it/auth/login` (rendering, layout, middleware, localizzazione)
- **LoginVoltTest.php**: Testa SOLO il componente Volt `auth.login` (state management, validation, authentication)
- **LoginWidgetTest.php**: Testa SOLO il widget Filament (form logic, validation)

### Pattern Implementato
```php
// LoginTest.php - Test della pagina
class LoginTest extends TestCase
{
    public function test_login_page_renders_correctly()
    {
        $response = $this->get('/it/auth/login');
        $response->assertStatus(200);
        $response->assertSeeLivewire('auth.login');
    }
}

// LoginVoltTest.php - Test del componente Volt
class LoginVoltTest extends TestCase
{
    public function test_volt_component_authentication()
    {
        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');
    }
}

// LoginWidgetTest.php - Test del widget Filament
class LoginWidgetTest extends TestCase
{
    public function test_filament_widget_form_schema()
    {
        $widget = new LoginWidget();
        $schema = $widget->getFormSchema();
        expect($schema)->toBeArray();
    }
}
```

## Struttura Directory

```
laravel/tests/Feature/Modules/User/
├── Feature/
│   ├── Filament/
│   │   └── Widgets/
│   │       ├── LoginWidgetTest.php      # Test widget Filament
│   │       ├── RegisterWidgetTest.php   # Test widget registrazione
│   │       └── LogoutWidgetTest.php     # Test widget logout
│   └── Auth/
│       ├── LoginTest.php                # Test pagina login
│       ├── LoginVoltTest.php            # Test componente Volt login
│       ├── RegisterTest.php             # Test pagina registrazione
│       └── LogoutTest.php               # Test logout
├── Unit/
│   ├── Models/
│   │   ├── UserTest.php                 # Test modello User
│   │   ├── TeamTest.php                 # Test modello Team
│   │   └── ProfileTest.php              # Test modello Profile
│   └── Traits/
│       ├── HasTeamsTest.php             # Test trait HasTeams
│       └── HasTenantsTest.php           # Test trait HasTenants
└── Integration/
    ├── AuthenticationFlowTest.php        # Test flusso completo auth
    └── UserManagementTest.php            # Test gestione utenti
```

## Convenzioni di Testing

### Naming dei Test
- **Feature Tests**: `{Functionality}Test.php` (es. `LoginTest.php`)
- **Unit Tests**: `{Model/Trait}Test.php` (es. `UserTest.php`)
- **Integration Tests**: `{Feature}FlowTest.php` (es. `AuthenticationFlowTest.php`)

### Metodi di Test
- **Feature**: `test_{action}_works_correctly()` (es. `test_login_works_correctly()`)
- **Unit**: `test_{method}_returns_expected_result()` (es. `test_get_full_name_returns_concatenated_names()`)
- **Integration**: `test_{feature}_flow_completes_successfully()` (es. `test_user_registration_flow_completes_successfully()`)

### Assertions
- Utilizzare sempre `expect()` per assertions più leggibili
- Preferire assertions specifiche (`assertSee()`, `assertRedirect()`) invece di generiche
- Testare sia happy path che edge cases

## Best Practices

### 1. Isolamento dei Test
- Ogni test deve essere indipendente
- Utilizzare `beforeEach()` per setup comune
- Pulire il database dopo ogni test

### 2. Factory e Seeder
- Utilizzare sempre `XotData::make()->getUserClass()` invece di import diretti
- Creare factory per tutti i modelli
- Utilizzare stati delle factory per scenari diversi

### 3. Autenticazione
- Utilizzare `actingAs()` per testare funzionalità autenticate
- Testare middleware di autenticazione
- Verificare redirect per utenti non autenticati

### 4. Localizzazione
- Testare tutte le lingue supportate (it, en, de)
- Verificare che le traduzioni non contengano chiavi raw
- Testare fallback delle traduzioni

### 5. Performance
- Test di rendering sotto 500ms
- Test di autenticazione sotto 1 secondo
- Utilizzare database in-memory per test veloci

## Esempi di Test

### Test Feature - Pagina Login
```php
<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\User\Auth;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_page_renders_correctly(): void
    {
        $response = $this->get('/it/auth/login');
        
        $response->assertStatus(200);
        $response->assertSeeLivewire('auth.login');
        $response->assertSee(__('user::auth.login.title'));
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/it/auth/login');
    }
}
```

### Test Unit - Modello User
```php
<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User\Models;

use Tests\TestCase;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;

class UserTest extends TestCase
{
    public function test_user_can_be_created(): void
    {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create();
        
        expect($user)->toBeInstanceOf($userClass);
        expect($user->id)->toBeGreaterThan(0);
    }

    public function test_user_has_teams_relationship(): void
    {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create();
        
        expect($user->teams)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
    }
}
```

### Test Integration - Flusso Autenticazione
```php
<?php

declare(strict_types=1);

namespace Tests\Integration\Modules\User;

use Tests\TestCase;
use Modules\Xot\Datas\XotData;
use Livewire\Livewire;

class AuthenticationFlowTest extends TestCase
{
    public function test_complete_authentication_flow(): void
    {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Test login
        $response = $this->post('/it/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        // Test accesso dashboard
        $dashboardResponse = $this->actingAs($user)->get('/dashboard');
        $dashboardResponse->assertStatus(200);

        // Test logout
        $logoutResponse = $this->actingAs($user)->post('/it/auth/logout');
        $logoutResponse->assertRedirect('/it/auth/login');
        $this->assertGuest();
    }
}
```

## Configurazione

### Pest Configuration
```php
// tests/Pest.php
uses(Tests\TestCase::class)->in('Feature');
uses(Tests\TestCase::class)->in('Unit');
uses(Tests\TestCase::class)->in('Integration');

beforeEach(function () {
    // Setup comune per tutti i test
    $this->withoutExceptionHandling();
});
```

### Database Testing
```php
// config/database.php
'testing' => [
    'driver' => 'sqlite',
    'database' => ':memory:',
    'prefix' => '',
],
```

## Coverage e Metriche

### Target di Coverage
- **Feature Tests**: 90%+
- **Unit Tests**: 95%+
- **Integration Tests**: 85%+

### Metriche di Qualità
- Tempo di esecuzione: < 30 secondi per suite completa
- Test isolati: 100%
- Assertions per test: 3-5 (non troppo poche, non troppe)

## Troubleshooting

### Problemi Comuni
1. **Test che falliscono intermittente**: Verificare isolamento e cleanup
2. **Lentezza**: Utilizzare database in-memory e mock per servizi esterni
3. **Conflitti di stato**: Verificare che `beforeEach()` pulisca correttamente

### Debug
```php
// Abilitare debug per test specifici
$this->withoutExceptionHandling();

// Log per debug
\Log::info('Test debug info', ['data' => $data]);

// Dump per debug
dump($variable);
```

## Collegamenti

- [README Modulo User](../README.md)
- [Best Practices Testing](../../../project_docs/testing-best-practices.md)
- [Architettura Modulo User](../architecture/README.md)
- [Factory e Seeder](../models/factory-seeder-status.md)

---

*Ultimo aggiornamento: 2025-01-06*






