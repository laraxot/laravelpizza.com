# Feature Test per Funzionalità Critiche

> [Torna alla Roadmap Principale](../../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

L'implementazione di feature test per le funzionalità critiche della piattaforma il progetto è attualmente in fase di pianificazione (0%). Questa componente è fondamentale per garantire la corretta funzionalità delle parti più importanti dell'applicazione attraverso test automatici che verificano il comportamento di interi moduli e flussi di lavoro.

## Obiettivi dell'Implementazione

L'implementazione dei feature test mira a:

1. Verificare il corretto funzionamento delle funzionalità critiche end-to-end
2. Garantire che i diversi moduli interagiscano correttamente tra loro
3. Prevenire regressioni durante lo sviluppo di nuove funzionalità
4. Validare i flussi di lavoro completi da una prospettiva funzionale
5. Stabilire una base di test solida per facilitare il refactoring futuro

## Componenti da Implementare (100%)

- 📅 Infrastruttura per feature test (0%)
  - 📅 Configurazione ambiente di test isolato
  - 📅 Factories per generazione dati di test
  - 📅 Helpers e traits per semplificare la scrittura dei test
- 📅 Test funzionalità modulo Patient (0%)
  - 📅 Test workflow registrazione paziente
  - 📅 Test gestione dati anagrafici
  - 📅 Test verifica idoneità ISEE
- 📅 Test funzionalità modulo Dental (0%)
  - 📅 Test workflow appuntamenti
  - 📅 Test gestione trattamenti
  - 📅 Test pianificazione agenda medici
- 📅 Test funzionalità API (0%)
  - 📅 Test endpoint autenticazione
  - 📅 Test endpoint principali per ogni modulo
  - 📅 Test permessi e autorizzazioni
- 📅 Test funzionalità Multi-tenant (0%)
  - 📅 Test isolamento dati tra tenant
  - 📅 Test configurazioni specifiche per tenant

## Approccio Metodologico

Il nostro approccio ai feature test seguirà questi principi:

1. **Focus sulla Business Logic**: i test verificheranno che i requisiti di business siano soddisfatti
2. **Indipendenza**: ogni test sarà indipendente dagli altri
3. **Database Reale**: utilizzeremo un database di test reale per verificare le interazioni con il database
4. **End-to-End**: simuleremo le azioni dell'utente dall'inizio alla fine di ogni flusso
5. **Automatizzazione**: i test saranno eseguiti automaticamente nella pipeline CI/CD

## Struttura dei Test

```php
// tests/Feature/Patient/RegistrationWorkflowTest.php
namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class RegistrationWorkflowTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_new_patient_can_be_registered_and_validated()
    {
        // Arrange
        $admin = User::factory()->create(['role' => 'admin']);
        $patientData = [
            'first_name' => 'Maria',
            'last_name' => 'Rossi',
            'fiscal_code' => 'RSSMRA80A01H501U',
            'birth_date' => '1980-01-01',
            'email' => 'maria.rossi@example.com',
            'phone' => '3331234567',
            'pregnancy_status' => true,
            'privacy_consent' => true,
        ];
        
        // Act - Simula l'autenticazione e la richiesta di creazione del paziente
        $response = $this->actingAs($admin)
                         ->post(route('patients.store'), $patientData);
                         
        // Assert - Verifica che il paziente sia stato creato correttamente
        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseHas('patients', [
            'first_name' => 'Maria',
            'last_name' => 'Rossi',
            'fiscal_code' => 'RSSMRA80A01H501U',
        ]);
        
        // Act - Simula la verifica di idoneità
        $patient = Patient::where('fiscal_code', 'RSSMRA80A01H501U')->first();
        $response = $this->actingAs($admin)
                         ->post(route('patients.verify_eligibility', $patient->id), [
                             'isee_value' => 18000,
                             'isee_date' => now()->format('Y-m-d'),
                             'has_valid_documents' => true,
                         ]);
                         
        // Assert - Verifica che lo stato di idoneità sia stato aggiornato
        $response->assertRedirect();
        $this->assertDatabaseHas('patient_eligibilities', [
            'patient_id' => $patient->id,
            'is_eligible' => true,
        ]);
    }
    
    public function test_patient_with_invalid_isee_is_marked_ineligible()
    {
        // Arrange
        $admin = User::factory()->create(['role' => 'admin']);
        $patient = Patient::factory()->create([
            'pregnancy_status' => true,
        ]);
        
        // Act - Simula la verifica di idoneità con ISEE non valido
        $response = $this->actingAs($admin)
                         ->post(route('patients.verify_eligibility', $patient->id), [
                             'isee_value' => 25000, // Sopra la soglia
                             'isee_date' => now()->format('Y-m-d'),
                             'has_valid_documents' => true,
                         ]);
                         
        // Assert - Verifica che il paziente sia segnato come non idoneo
        $response->assertRedirect();
        $this->assertDatabaseHas('patient_eligibilities', [
            'patient_id' => $patient->id,
            'is_eligible' => false,
            'denial_reason' => 'isee_too_high',
        ]);
    }
}
```

## Test Modulo Dental - Workflow Appuntamenti

```php
// tests/Feature/Dental/AppointmentWorkflowTest.php
namespace Tests\Feature\Dental;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Dental\Models\Dentist;
use Modules\Dental\Models\Appointment;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class AppointmentWorkflowTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_complete_appointment_workflow()
    {
        // Arrange
        $operator = User::factory()->create(['role' => 'operator']);
        $patient = Patient::factory()->create([
            'pregnancy_status' => true,
        ]);
        $patient->eligibility()->create([
            'is_eligible' => true,
            'isee_value' => 18000,
            'evaluation_date' => now(),
        ]);
        $dentist = Dentist::factory()->create();
        
        // Act - Inizia workflow appuntamento
        $response = $this->actingAs($operator)
                         ->post(route('dental.appointments.start_workflow'), [
                             'patient_id' => $patient->id,
                         ]);
        
        // Assert - Verifica creazione workflow
        $response->assertRedirect();
        $workflowId = session('appointment_workflow_id');
        $this->assertDatabaseHas('appointment_workflows', [
            'id' => $workflowId,
            'patient_id' => $patient->id,
            'status' => 'patient_info',
        ]);
        
        // Act - Seleziona dentista
        $response = $this->actingAs($operator)
                         ->post(route('dental.appointments.workflow.dentist', $workflowId), [
                             'dentist_id' => $dentist->id,
                         ]);
        
        // Assert - Verifica aggiornamento workflow
        $response->assertRedirect();
        $this->assertDatabaseHas('appointment_workflows', [
            'id' => $workflowId,
            'dentist_id' => $dentist->id,
            'status' => 'dentist_selection',
        ]);
        
        // Act - Seleziona data
        $appointmentDate = now()->addDays(5)->setTime(10, 0);
        $response = $this->actingAs($operator)
                         ->post(route('dental.appointments.workflow.date', $workflowId), [
                             'appointment_date' => $appointmentDate->format('Y-m-d'),
                             'appointment_time' => $appointmentDate->format('H:i'),
                         ]);
        
        // Assert - Verifica aggiornamento workflow
        $response->assertRedirect();
        $this->assertDatabaseHas('appointment_workflows', [
            'id' => $workflowId,
            'status' => 'date_selection',
        ]);
        
        // Act - Completa e conferma appuntamento
        $response = $this->actingAs($operator)
                         ->post(route('dental.appointments.workflow.confirm', $workflowId), [
                             'notes' => 'Prima visita',
                             'treatment_type' => 'check_up',
                         ]);
        
        // Assert - Verifica creazione appuntamento
        $response->assertRedirect(route('dental.appointments.index'));
        $appointment = Appointment::where('workflow_id', $workflowId)->first();
        $this->assertNotNull($appointment);
        $this->assertEquals($patient->id, $appointment->patient_id);
        $this->assertEquals($dentist->id, $appointment->dentist_id);
        $this->assertEquals($appointmentDate->format('Y-m-d H:i'), $appointment->start_time->format('Y-m-d H:i'));
    }
}
```

## Test API Endpoints

```php
// tests/Feature/Api/PatientApiTest.php
namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class PatientApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_authenticated_user_can_get_patient_list()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'doctor']);
        Passport::actingAs($user);
        $patients = Patient::factory()->count(3)->create();
        
        // Act
        $response = $this->getJson('/api/v1/patients');
        
        // Assert
        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data')
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'first_name',
                             'last_name',
                             'fiscal_code',
                             'birth_date',
                             'pregnancy_status',
                         ]
                     ],
                     'links',
                     'meta'
                 ]);
    }
    
    public function test_can_get_single_patient()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'doctor']);
        Passport::actingAs($user);
        $patient = Patient::factory()->create();
        
        // Act
        $response = $this->getJson("/api/v1/patients/{$patient->id}");
        
        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $patient->id,
                         'first_name' => $patient->first_name,
                         'last_name' => $patient->last_name,
                         'fiscal_code' => $patient->fiscal_code,
                     ]
                 ]);
    }
    
    public function test_unauthorized_user_cannot_access_api()
    {
        // Act
        $response = $this->getJson('/api/v1/patients');
        
        // Assert
        $response->assertStatus(401);
    }
    
    public function test_can_create_patient_via_api()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'admin']);
        Passport::actingAs($user);
        $patientData = [
            'first_name' => 'Giulia',
            'last_name' => 'Bianchi',
            'fiscal_code' => 'BNCGLI85M41H501T',
            'birth_date' => '1985-08-01',
            'email' => 'giulia.bianchi@example.com',
            'phone' => '3339876543',
            'pregnancy_status' => true,
        ];
        
        // Act
        $response = $this->postJson('/api/v1/patients', $patientData);
        
        // Assert
        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'first_name' => 'Giulia',
                         'last_name' => 'Bianchi',
                         'fiscal_code' => 'BNCGLI85M41H501T',
                     ]
                 ]);
        
        $this->assertDatabaseHas('patients', [
            'fiscal_code' => 'BNCGLI85M41H501T',
        ]);
    }
}
```

## Test Multi-tenant

```php
// tests/Feature/Tenant/TenantIsolationTest.php
namespace Tests\Feature\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Tenant\Models\Tenant;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_patients_are_isolated_between_tenants()
    {
        // Arrange
        $tenant1 = Tenant::factory()->create(['name' => 'Clinica Roma']);
        $tenant2 = Tenant::factory()->create(['name' => 'Clinica Milano']);
        
        $userTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);
        
        $userTenant2 = User::factory()->create([
            'tenant_id' => $tenant2->id,
            'role' => 'admin',
        ]);
        
        // Crea pazienti per tenant 1
        Patient::factory()->count(3)->create([
            'tenant_id' => $tenant1->id,
        ]);
        
        // Crea pazienti per tenant 2
        Patient::factory()->count(2)->create([
            'tenant_id' => $tenant2->id,
        ]);
        
        // Act e Assert per tenant 1
        $response1 = $this->actingAs($userTenant1)
                          ->get(route('patients.index'));
        
        $response1->assertSuccessful();
        $response1->assertViewHas('patients', function ($patients) {
            return $patients->count() === 3;
        });
        
        // Act e Assert per tenant 2
        $response2 = $this->actingAs($userTenant2)
                          ->get(route('patients.index'));
        
        $response2->assertSuccessful();
        $response2->assertViewHas('patients', function ($patients) {
            return $patients->count() === 2;
        });
    }
    
    public function test_user_cannot_access_other_tenant_data()
    {
        // Arrange
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();
        
        $userTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);
        
        $patientTenant2 = Patient::factory()->create([
            'tenant_id' => $tenant2->id,
        ]);
        
        // Act - Tenta di accedere a un paziente di un altro tenant
        $response = $this->actingAs($userTenant1)
                         ->get(route('patients.show', $patientTenant2->id));
        
        // Assert - Verifica che l'accesso sia negato
        $response->assertStatus(403);
    }
    
    public function test_tenant_specific_configurations_are_applied()
    {
        // Arrange
        $tenant1 = Tenant::factory()->create([
            'settings' => [
                'max_daily_appointments' => 10,
                'working_hours' => [
                    'start' => '09:00',
                    'end' => '18:00',
                ],
            ],
        ]);
        
        $tenant2 = Tenant::factory()->create([
            'settings' => [
                'max_daily_appointments' => 15,
                'working_hours' => [
                    'start' => '08:00',
                    'end' => '20:00',
                ],
            ],
        ]);
        
        $userTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);
        
        $userTenant2 = User::factory()->create([
            'tenant_id' => $tenant2->id,
            'role' => 'admin',
        ]);
        
        // Act e Assert per tenant 1
        $response1 = $this->actingAs($userTenant1)
                          ->get(route('dental.settings.index'));
        
        $response1->assertSuccessful();
        $response1->assertSee('10'); // max_daily_appointments
        $response1->assertSee('09:00'); // working_hours.start
        
        // Act e Assert per tenant 2
        $response2 = $this->actingAs($userTenant2)
                          ->get(route('dental.settings.index'));
        
        $response2->assertSuccessful();
        $response2->assertSee('15'); // max_daily_appointments
        $response2->assertSee('08:00'); // working_hours.start
    }
}
```

## Integrazione con CI/CD

I feature test saranno integrati nella pipeline CI/CD per essere eseguiti automaticamente ad ogni commit o pull request, garantendo così che le modifiche al codice non introducano regressioni nelle funzionalità critiche.

```yaml

# .github/workflows/feature-tests.yml
name: Feature Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  feature-tests:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: <nome progetto>_test
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, dom, fileinfo, mysql
        coverage: none
    
    - name: Copy .env
      run: cp .env.example .env.testing
    
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
    
    - name: Generate key
      run: php artisan key:generate --env=testing
    
    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache
    
    - name: Configure Database
      run: |
        php artisan config:clear
        php artisan migrate --env=testing --force
    
    - name: Run Feature Tests
      run: php artisan test --testsuite=Feature
```

## Calendario di Implementazione

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Configurazione ambiente test | Agosto 2024 | Alta |
| Test workflow Patient | Agosto 2024 | Alta |
| Test workflow Dental | Agosto 2024 | Alta |
| Test API | Settembre 2024 | Media |
| Test Multi-tenant | Settembre 2024 | Media |
| Integrazione CI/CD | Settembre 2024 | Alta |

## Metriche di Successo

- Copertura dei test feature > 80% per le funzionalità critiche
- Tempo di esecuzione suite di test < 5 minuti
- Riduzione dei bug in produzione > 60%
- Velocità di individuazione e correzione bug aumentata del 40%
- Zero regressioni non identificate nelle funzionalità principali
