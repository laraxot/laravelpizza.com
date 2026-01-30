# Testing il progetto

## Strategia di Testing

### Livelli
- Unit Testing
- Feature Testing
- Integration Testing
- Browser Testing
- Performance Testing

### Coverage
- Minimo 80% coverage
- Critical paths: 100%
- Edge cases: 100%
- Error handling: 100%
- Security: 100%

## Unit Testing

### Models
```php
class PatientTest extends TestCase
{
    /** @test */
    public function it_calculates_isee_correctly()
    {
        $patient = Patient::factory()->create([
            'income' => 15000,
            'family_size' => 3
        ]);

        $this->assertEquals(5000, $patient->calculateIsee());
    }
}
```

### Services
```php
class DentalServiceTest extends TestCase
{
    /** @test */
    public function it_schedules_appointment()
    {
        $service = new DentalService();
        $appointment = $service->schedule(
            patient: $patient,
            date: $date,
            type: $type
        );

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'date' => $date,
            'type' => $type
        ]);
    }
}
```

## Feature Testing

### Controllers
```php
class PatientControllerTest extends TestCase
{
    /** @test */
    public function it_stores_patient_data()
    {
        $response = $this->postJson('/api/patients', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'id',
                    'name',
                    'email'
                ]);
    }
}
```

### Forms
```php
class PatientFormTest extends TestCase
{
    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->post('/patients', []);

        $response->assertSessionHasErrors(['name', 'email']);
    }
}
```

## Integration Testing

### API
```php
class PatientApiTest extends TestCase
{
    /** @test */
    public function it_handles_patient_workflow()
    {
        // Create patient
        $patient = $this->postJson('/api/patients', [
            'name' => 'John Doe'
        ]);

        // Schedule appointment
        $appointment = $this->postJson("/api/patients/{$patient->id}/appointments", [
            'date' => now()->addDay()
        ]);

        // Verify workflow
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'date' => now()->addDay()
        ]);
    }
}
```

### Events
```php
class PatientEventsTest extends TestCase
{
    /** @test */
    public function it_emits_events()
    {
        Event::fake();

        $patient = Patient::factory()->create();
        $patient->update(['status' => 'active']);

        Event::assertDispatched(PatientStatusChanged::class);
    }
}
```

## Browser Testing

### Laravel Dusk
```php
class PatientWorkflowTest extends DuskTestCase
{
    /** @test */
    public function it_completes_patient_registration()
    {
        $this->browse(function ($browser) {
            $browser->visit('/patients/create')
                   ->type('name', 'John Doe')
                   ->type('email', 'john@example.com')
                   ->press('Register')
                   ->assertSee('Patient registered successfully');
        });
    }
}
```

### Visual Testing
```php
class PatientPageTest extends DuskTestCase
{
    /** @test */
    public function it_renders_patient_page_correctly()
    {
        $this->browse(function ($browser) {
            $browser->visit('/patients/1')
                   ->assertSee('Patient Details')
                   ->assertSee('Appointments')
                   ->assertSee('Documents');
        });
    }
}
```

## Performance Testing

### Load Testing
```php
class PatientApiPerformanceTest extends TestCase
{
    /** @test */
    public function it_handles_concurrent_requests()
    {
        $response = Http::pool(fn ($pool) => [
            $pool->get('/api/patients'),
            $pool->get('/api/patients'),
            $pool->get('/api/patients'),
        ]);

        $this->assertTrue($response->successful());
    }
}
```

### Query Testing
```php
class PatientQueryTest extends TestCase
{
    /** @test */
    public function it_optimizes_queries()
    {
        DB::enableQueryLog();

        $patients = Patient::with(['appointments', 'documents'])->get();

        $this->assertCount(2, DB::getQueryLog());
    }
}
```

## CI/CD

### GitHub Actions
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
      - name: Install Dependencies
        run: composer install
      - name: Execute Tests
        run: php artisan test
```

### Test Environment
```env
TESTING_DATABASE_URL=mysql://user:password@localhost/<nome progetto>_testing
TESTING_REDIS_URL=redis://localhost:6379/1
TESTING_QUEUE_CONNECTION=sync
``` 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

