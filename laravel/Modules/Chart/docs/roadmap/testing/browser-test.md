# Browser Test per UI/UX

> [Torna alla Roadmap Principale](../../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

L'implementazione dei browser test per l'interfaccia utente e l'esperienza utente della piattaforma il progetto è attualmente in fase di pianificazione (0%). Questa componente è fondamentale per garantire che tutti gli elementi dell'interfaccia funzionino correttamente e che i flussi di interazione utente siano fluidi e intuitivi.

## Obiettivi dell'Implementazione

L'implementazione dei browser test mira a:

1. Verificare il corretto funzionamento dell'interfaccia utente in vari browser
2. Testare i flussi di interazione utente completi
3. Prevenire regressioni negli elementi UI critici
4. Validare l'accessibilità dell'interfaccia
5. Garantire la responsività su diversi dispositivi

## Componenti da Implementare (100%)

- 📅 Infrastruttura per browser test (0%)
  - 📅 Configurazione ambiente per test browser automatizzati
  - 📅 Integrazione Laravel Dusk
  - 📅 Setup browser headless per CI/CD
- 📅 Test interfaccia backoffice Filament (0%)
  - 📅 Test navigazione e dashboard
  - 📅 Test form e validazione dati
  - 📅 Test tabelle e filtri
  - 📅 Test responsive design pannello amministrazione
- 📅 Test flussi utente completi (0%)
  - 📅 Test creazione e gestione pazienti
  - 📅 Test workflow appuntamenti
  - 📅 Test generazione report
- 📅 Test accessibilità (0%)
  - 📅 Test conformità WCAG 2.1 AA
  - 📅 Test funzionamento screen reader
  - 📅 Test navigazione da tastiera
- 📅 Test cross-browser e dispositivi (0%)
  - 📅 Test su Chrome, Firefox, Safari
  - 📅 Test responsive su desktop, tablet, mobile
  - 📅 Test performance UI

## Approccio Metodologico

Il nostro approccio ai browser test seguirà questi principi:

1. **Automazione**: utilizzeremo Laravel Dusk per automatizzare i test UI
2. **Page Objects**: implementeremo il pattern Page Object per mantenere i test organizzati e facili da mantenere
3. **Snapshot Testing**: utilizzeremo screenshot comparison per verificare la stabilità visiva dell'interfaccia
4. **Accessibilità First**: integreremo strumenti per il test dell'accessibilità in ogni suite di test
5. **CI/CD**: eseguiremo i test automaticamente nella pipeline CI/CD

## Struttura dei Test

```php
// tests/Browser/Pages/DashboardPage.php
namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class DashboardPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/dashboard';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
                ->assertSee('Dashboard')
                ->assertPresent('#dashboard-content');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@patients-widget' => '#patients-stats-widget',
            '@appointments-widget' => '#appointments-stats-widget',
            '@navigation' => '.navigation-menu',
            '@user-menu' => '.user-menu',
        ];
    }
    
    /**
     * Naviga al modulo pazienti.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function navigateToPatients(Browser $browser)
    {
        $browser->click('@navigation')
                ->waitFor('#navigation-patients')
                ->click('#navigation-patients');
    }
}
```

## Test Navigazione Dashboard

```php
// tests/Browser/DashboardTest.php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\DashboardPage;
use Tests\Browser\Pages\PatientsPage;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test navigazione dashboard.
     *
     * @return void
     */
    public function testNavigationDashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit(new DashboardPage)
                    ->assertSee('Riepilogo Attività')
                    ->assertPresent('@patients-widget')
                    ->assertPresent('@appointments-widget')
                    ->assertSee('Appuntamenti di Oggi')
                    ->navigateToPatients()
                    ->on(new PatientsPage)
                    ->assertSee('Gestione Pazienti');
        });
    }
    
    /**
     * Test widgets dashboard mostrano dati corretti.
     *
     * @return void
     */
    public function testDashboardWidgetsShowCorrectData()
    {
        // Arrange: crea un admin, 5 pazienti e 3 appuntamenti per oggi
        $admin = User::factory()->create(['role' => 'admin']);
        $patients = \Modules\Patient\Models\Patient::factory()->count(5)->create();
        $today = now()->format('Y-m-d');
        
        foreach ($patients->take(3) as $patient) {
            \Modules\Dental\Models\Appointment::factory()->create([
                'patient_id' => $patient->id,
                'start_time' => now()->setTime(rand(9, 17), 0),
                'status' => 'confirmed',
            ]);
        }

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit(new DashboardPage)
                    ->assertSee('5') // Numero totale pazienti
                    ->assertSee('3') // Numero appuntamenti oggi
                    ->click('@appointments-widget')
                    ->waitForText('Dettaglio Appuntamenti')
                    ->assertSee('3 appuntamenti confermati');
        });
    }
}
```

## Test Form Creazione Paziente

```php
// tests/Browser/PatientFormTest.php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\PatientsPage;
use Tests\Browser\Pages\CreatePatientPage;

class PatientFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test creazione nuovo paziente.
     *
     * @return void
     */
    public function testCreateNewPatient()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit(new PatientsPage)
                    ->clickLink('Nuovo Paziente')
                    ->on(new CreatePatientPage)
                    ->type('@first-name', 'Maria')
                    ->type('@last-name', 'Rossi')
                    ->type('@fiscal-code', 'RSSMRA80A01H501U')
                    ->type('@email', 'maria.rossi@example.com')
                    ->type('@phone', '3331234567')
                    ->select('@gender', 'F')
                    ->type('@birth-date', '1980-01-01')
                    ->check('@pregnancy-status')
                    ->check('@privacy-consent')
                    ->check('@marketing-consent')
                    ->press('Salva')
                    ->waitForText('Paziente creato con successo')
                    ->assertSee('Maria Rossi');
                    
            // Verifica che il paziente sia stato creato nel database
            $this->assertDatabaseHas('patients', [
                'first_name' => 'Maria',
                'last_name' => 'Rossi',
                'fiscal_code' => 'RSSMRA80A01H501U',
            ]);
        });
    }
    
    /**
     * Test validazione form paziente.
     *
     * @return void
     */
    public function testPatientFormValidation()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit(new CreatePatientPage)
                    // Tenta di inviare form vuoto
                    ->press('Salva')
                    // Verifica messaggi di errore validazione
                    ->assertSee('Il campo Nome è obbligatorio')
                    ->assertSee('Il campo Cognome è obbligatorio')
                    ->assertSee('Il campo Codice Fiscale è obbligatorio')
                    
                    // Compila solo alcuni campi
                    ->type('@first-name', 'Maria')
                    ->type('@last-name', 'Rossi')
                    ->type('@fiscal-code', 'CODICE-NON-VALIDO')
                    ->press('Salva')
                    
                    // Verifica errore formato codice fiscale
                    ->assertSee('Il formato del Codice Fiscale non è valido')
                    
                    // Completa con valori corretti
                    ->type('@fiscal-code', 'RSSMRA80A01H501U')
                    ->type('@email', 'maria.rossi@example.com')
                    ->type('@phone', '3331234567')
                    ->type('@birth-date', '1980-01-01')
                    ->check('@privacy-consent')
                    ->press('Salva')
                    
                    // Verifica successo
                    ->waitForText('Paziente creato con successo');
        });
    }
}
```

## Test Workflow Appuntamenti

```php
// tests/Browser/AppointmentWorkflowTest.php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Modules\Patient\Models\Patient;
use Modules\Dental\Models\Dentist;
use Tests\Browser\Pages\AppointmentWizardPage;

class AppointmentWorkflowTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test completo wizard appuntamento.
     *
     * @return void
     */
    public function testCompleteAppointmentWizard()
    {
        // Arrange
        $operator = User::factory()->create(['role' => 'operator']);
        $patient = Patient::factory()->create([
            'first_name' => 'Giulia',
            'last_name' => 'Bianchi',
            'pregnancy_status' => true,
        ]);
        $patient->eligibility()->create([
            'is_eligible' => true,
            'isee_value' => 18000,
            'evaluation_date' => now(),
        ]);
        
        $dentist = Dentist::factory()->create([
            'first_name' => 'Marco',
            'last_name' => 'Verdi',
        ]);

        $this->browse(function (Browser $browser) use ($operator, $patient, $dentist) {
            $browser->loginAs($operator)
                    ->visit('/admin/dental/appointments/create')
                    ->on(new AppointmentWizardPage)
                    
                    // Step 1: Selezione paziente
                    ->assertSee('Step 1: Selezione Paziente')
                    ->select('@patient-select', (string)$patient->id)
                    ->assertSee('Giulia Bianchi')
                    ->assertSee('Paziente idoneo')
                    ->press('@next-button')
                    
                    // Step 2: Selezione dentista
                    ->waitForText('Step 2: Selezione Dentista')
                    ->select('@dentist-select', (string)$dentist->id)
                    ->assertSee('Marco Verdi')
                    ->press('@next-button')
                    
                    // Step 3: Selezione data e ora
                    ->waitForText('Step 3: Data e Ora')
                    // Seleziona una data disponibile (questo dipende dall'implementazione del calendario)
                    ->click('@date-picker')
                    ->click('@date-picker-day-15') // Assumiamo di cliccare sul giorno 15
                    ->waitFor('@time-select')
                    ->select('@time-select', '10:00')
                    ->press('@next-button')
                    
                    // Step 4: Dettagli appuntamento
                    ->waitForText('Step 4: Dettagli Appuntamento')
                    ->select('@treatment-type', 'check_up')
                    ->type('@notes', 'Prima visita')
                    ->press('@next-button')
                    
                    // Step 5: Conferma
                    ->waitForText('Step 5: Conferma')
                    ->assertSee('Giulia Bianchi')
                    ->assertSee('Marco Verdi')
                    ->assertSee('10:00')
                    ->press('@confirm-button')
                    
                    // Verifica completamento
                    ->waitForText('Appuntamento creato con successo')
                    ->assertPathIs('/admin/dental/appointments');
                    
            // Verifica che l'appuntamento sia stato creato nel database
            $this->assertDatabaseHas('appointments', [
                'patient_id' => $patient->id,
                'dentist_id' => $dentist->id,
                'status' => 'confirmed',
            ]);
        });
    }
}
```

## Test Accessibilità

```php
// tests/Browser/AccessibilityTest.php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AccessibilityTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test accessibilità dashboard admin.
     *
     * @return void
     */
    public function testDashboardAccessibility()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertAttribute('html', 'lang', 'it') // Verifica attributo lingua
                    ->assertPresent('header[role="banner"]') // Header con role semantico
                    ->assertPresent('nav[role="navigation"]') // Nav con role semantico
                    ->assertPresent('main[role="main"]') // Main con role semantico
                    ->assertPresent('h1') // Presenza di h1
                    ->assertSeeIn('h1', 'Dashboard') // H1 con testo corretto
                    ->assertMissing('.filament-widget img:not([alt])') // Nessuna immagine senza alt
                    
                    // Test contrasto colori (attraverso script che verifica classi con contrasto adeguato)
                    ->assertScript('
                        const poorContrastElements = document.querySelectorAll(".poor-contrast"); 
                        return poorContrastElements.length === 0;
                    ', true)
                    
                    // Test navigazione da tastiera
                    ->keys('', [Browser::TAB]) // Primo tab
                    ->assertHasFocus('.main-navigation-item') // Focus sul primo elemento di navigazione
                    ->keys('', [Browser::TAB]) // Secondo tab
                    ->assertHasFocus('.dashboard-filter'); // Focus sul campo filtro
        });
    }
    
    /**
     * Test accessibilità form pazienti.
     *
     * @return void
     */
    public function testPatientFormAccessibility()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/patients/create')
                    
                    // Verifica presenza di label associate correttamente
                    ->assertPresent('label[for="first_name"]')
                    ->assertSeeIn('label[for="first_name"]', 'Nome')
                    ->assertPresent('input#first_name[aria-required="true"]')
                    
                    // Verifica accessibilità messaggi di errore
                    ->press('Salva')
                    ->waitForText('Il campo Nome è obbligatorio')
                    ->assertPresent('#first_name-error[role="alert"]')
                    ->assertAttribute('#first_name', 'aria-invalid', 'true')
                    ->assertAttribute('#first_name', 'aria-describedby', 'first_name-error')
                    
                    // Verifica che sia possibile navigare tra i campi con Tab
                    ->focusOnField('first_name')
                    ->keys('#first_name', [Browser::TAB])
                    ->assertHasFocus('#last_name')
                    ->keys('#last_name', [Browser::TAB])
                    ->assertHasFocus('#fiscal_code')
                    
                    // Verifica che elementi interattivi siano raggiungibili da tastiera
                    ->keysDown(document, [Browser::SHIFT, Browser::TAB, Browser::TAB]) // Torna indietro
                    ->assertHasFocus('#first_name')
                    
                    // Verifica colori di stato (errore, successo, ecc.)
                    ->assertAttribute('.filament-forms-field-wrapper-error', 'role', 'alert')
                    ->assertAttribute('.filament-forms-field-wrapper-error', 'aria-live', 'assertive');
        });
    }
}
```

## Test Responsive Design

```php
// tests/Browser/ResponsiveTest.php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResponsiveTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test responsività dashboard su dispositivi mobili.
     *
     * @return void
     */
    public function testDashboardResponsive()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            // Test su dispositivo mobile
            $browser->loginAs($admin)
                    ->resize(375, 812) // Dimensioni iPhone X
                    ->visit('/admin/dashboard')
                    ->assertPresent('.mobile-menu-button') // Pulsante menu mobile visibile
                    ->assertMissing('.desktop-menu') // Menu desktop nascosto
                    ->click('.mobile-menu-button') // Apri menu mobile
                    ->waitFor('.mobile-menu.opened') // Aspetta apertura menu
                    ->assertVisible('.mobile-menu-item') // Voci menu mobile visibili
                    
                    // Verifica adattamento layout su mobile
                    ->assertPresent('.responsive-grid-1-col') // Grid a singola colonna su mobile
                    ->assertPresent('.responsive-stack') // Elementi in stack su mobile
                    
                    // Verifica screenshot per confronto visivo
                    ->screenshot('dashboard-mobile');
                    
            // Test su tablet
            $browser->resize(768, 1024) // Dimensioni iPad
                    ->refresh()
                    ->assertPresent('.tablet-menu') // Menu tablet visibile
                    ->assertMissing('.mobile-menu-button') // Pulsante menu mobile nascosto
                    ->assertPresent('.responsive-grid-2-col') // Grid a due colonne su tablet
                    ->screenshot('dashboard-tablet');
                    
            // Test su desktop
            $browser->resize(1920, 1080) // Dimensioni desktop
                    ->refresh()
                    ->assertPresent('.desktop-menu') // Menu desktop visibile
                    ->assertMissing('.mobile-menu-button') // Pulsante menu mobile nascosto
                    ->assertMissing('.tablet-menu') // Menu tablet nascosto
                    ->assertPresent('.responsive-grid-3-col') // Grid a tre colonne su desktop
                    ->screenshot('dashboard-desktop');
        });
    }
    
    /**
     * Test form paziente responsive.
     *
     * @return void
     */
    public function testPatientFormResponsive()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            // Test su dispositivo mobile
            $browser->loginAs($admin)
                    ->resize(375, 812) // Dimensioni iPhone X
                    ->visit('/admin/patients/create')
                    ->assertPresent('.form-mobile-layout') // Layout form mobile
                    ->assertPresent('.form-field-full-width') // Campi a larghezza completa
                    ->assertMissing('.form-field-inline') // No campi inline
                    
                    // Verifica funzionalità touch-friendly
                    ->assertPresent('input[type="date"].date-picker-mobile') // Date picker touch-friendly
                    ->assertPresent('select.mobile-select') // Select touch-friendly
                    
                    // Verifica screenshot per confronto visivo
                    ->screenshot('patient-form-mobile');
                    
            // Test su desktop
            $browser->resize(1920, 1080) // Dimensioni desktop
                    ->refresh()
                    ->assertPresent('.form-desktop-layout') // Layout form desktop
                    ->assertPresent('.form-field-inline') // Campi inline presenti
                    ->assertPresent('.form-2-column-grid') // Layout a due colonne
                    
                    // Verifica screenshot per confronto visivo
                    ->screenshot('patient-form-desktop');
        });
    }
}
```

## Integrazione con CI/CD

I browser test saranno integrati nella pipeline CI/CD per essere eseguiti automaticamente, garantendo la stabilità dell'interfaccia utente:

```yaml

# .github/workflows/browser-tests.yml
name: Browser Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  browser-tests:
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
        extensions: mbstring, dom, fileinfo, mysql, gd
        coverage: none
    
    - name: Copy .env
      run: cp .env.example .env.testing
    
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
    
    - name: Generate key
      run: php artisan key:generate --env=testing
    
    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache
    
    - name: Start Chrome Driver
      run: ./vendor/laravel/dusk/bin/chromedriver-linux &
    
    - name: Configure Database
      run: |
        php artisan config:clear
        php artisan migrate --env=testing --force
    
    - name: Run Dusk Tests
      run: php artisan dusk --env=testing
    
    - name: Upload Screenshots
      if: failure()
      uses: actions/upload-artifact@v2
      with:
        name: screenshots
        path: tests/Browser/screenshots
    
    - name: Upload Console Logs
      if: failure()
      uses: actions/upload-artifact@v2
      with:
        name: console-logs
        path: tests/Browser/console
```

## Calendario di Implementazione

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Configurazione Laravel Dusk | Agosto 2024 | Alta |
| Test navigazione backoffice | Agosto 2024 | Alta |
| Test form e validazione | Agosto 2024 | Alta |
| Test flussi utente completi | Settembre 2024 | Alta |
| Test accessibilità | Settembre 2024 | Media |
| Test responsive | Settembre 2024 | Media |
| Integrazione CI/CD | Settembre 2024 | Alta |

## Metriche di Successo

- 100% delle funzionalità critiche coperte da browser test
- Compliance WCAG 2.1 AA per tutte le interfacce
- Zero regressioni UI non identificate dai test
- Tempo medio esecuzione test < 10 minuti
- Funzionamento consistente su tutti i browser target
- Esperienza utente ottimizzata su tutti i dispositivi
