# Best Practices Testing Globali - <nome progetto>

## Panoramica

Questo documento descrive le best practices globali per il testing del progetto <nome progetto>, basate sull'esperienza reale e sulla risoluzione sistematica di errori. Queste pratiche garantiscono test affidabili, veloci e manutenibili.
# Best Practices Testing Globali - <nome progetto>

## Panoramica

Questo documento descrive le best practices globali per il testing del progetto <nome progetto>, basate sull'esperienza reale e sulla risoluzione sistematica di errori. Queste pratiche garantiscono test affidabili, veloci e manutenibili.

## Principi Fondamentali

### 1. **Selezione Tipo Test**

Scegli il tipo di test appropriato in base a cosa stai testando:

#### Business Logic Tests (Raccomandato per Regole)
- **Usa quando**: Test di validazione, regole aziendali, algoritmi
- **Pattern**: Oggetti plain, no database, no modelli Eloquent
- **Performance**: 1-10ms per test
- **Esempio**: Vincoli temporali appuntamenti, transizioni di stato

#### Database Integration Tests
- **Usa quando**: Test di persistenza, relazioni, workflow completi
- **Pattern**: Factory, trait RefreshDatabase, modelli Eloquent
- **Performance**: 100-500ms per test
- **Esempio**: Operazioni CRUD, relazioni modello

#### Unit Tests
- **Usa quando**: Test di metodi individuali, servizi, utility
- **Pattern**: Istanziazione diretta, no dipendenze esterne
- **Performance**: 1-5ms per test
- **Esempio**: Metodi servizio, funzioni utility

### 2. **Struttura Test**

#### Template Standard File Test
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests\Feature;

use Modules\ModuleName\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Scegli trait appropriati
uses(TestCase::class); // Per business logic
// OPPURE
uses(TestCase::class, RefreshDatabase::class); // Per test database

describe('Nome Suite Test', function () {
    beforeEach(function () {
        // Setup dati test
    });

    it('esegue test specifico', function () {
        // Implementazione test
    });
});
```

#### Organizzazione Test
```php
describe('Gestione Appuntamenti', function () {
    describe('Creazione', function () {
        it('crea appuntamento con dati validi', function () {
            // Implementazione test
        });

        it('rifiuta appuntamento con dati non validi', function () {
            // Implementazione test
        });
    });

    describe('Validazione', function () {
        it('valida vincoli temporali', function () {
            // Implementazione test
        });
    });
});
```

## Best Practices per Categoria

### 1. **Business Logic Testing**

#### Usa Oggetti Plain
```php
// ✅ Buono - Veloce, isolato, no dipendenze
beforeEach(function () {
    $this->patient = (object) ['id' => 1001, 'type' => 'patient'];
    $this->doctor = (object) ['id' => 2001, 'type' => 'doctor'];
});

it('valida vincoli appuntamento', function () {
    $appointment = (object) [
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'status' => 'scheduled',
    ];

    expect($appointment->patient_id)->toBe($this->patient->id);
});
```

#### Test Comportamento Enum
```php
it('restituisce durata corretta per tipi appuntamento', function () {
    expect(AppointmentTypeEnum::CONSULTATION->getDuration())->toBe(20);
    expect(AppointmentTypeEnum::TREATMENT->getDuration())->toBe(30);
    expect(AppointmentTypeEnum::EMERGENCY->getDuration())->toBe(30);
});
```

#### Valida Regole Aziendali
```php
it('applica vincoli temporali appuntamento', function () {
    $startTime = Carbon::now()->addDay();
    $endTime = $startTime->copy()->addMinutes(30);

    expect($startTime->isBefore($endTime))->toBeTrue();
    expect($endTime->diffInMinutes($startTime))->toBe(30);
});
```

### 2. **Database Testing**

#### Usa Factory Efficientemente
```php
it('crea appuntamento con relazioni', function () {
    // Crea modelli correlati prima
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    $studio = Studio::factory()->create();

    // Crea modello principale con relazioni
    $appointment = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
    ]);

    expect($appointment->patient->id)->toBe($patient->id);
    expect($appointment->doctor->id)->toBe($doctor->id);
});
```

#### Test Relazioni Modello
```php
it('mantiene integrità referenziale', function () {
    $appointment = Appointment::factory()->create();

    expect($appointment->patient)->toBeInstanceOf(Patient::class);
    expect($appointment->doctor)->toBeInstanceOf(Doctor::class);
    expect($appointment->studio)->toBeInstanceOf(Studio::class);
});
```

### 3. **Error Handling Testing**

#### Test Errori Validazione
```php
it('restituisce errori validazione per dati non validi', function () {
    $response = $this->postJson('/api/appointments', [
        'patient_id' => '', // Non valido
        'doctor_id' => '',  // Non valido
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['patient_id', 'doctor_id']);
});
```

#### Test Violazioni Regole Aziendali
```php
it('previene appuntamenti sovrapposti', function () {
    // Crea appuntamento esistente
    Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'starts_at' => '[DATE] 10:00:00',
        'ends_at' => '[DATE] 10:30:00',
    ]);

    // Prova a creare appuntamento sovrapposto
    $response = $this->postJson('/api/appointments', [
        'doctor_id' => $doctor->id,
        'starts_at' => '[DATE] 10:15:00', // Sovrappone
        'ends_at' => '[DATE] 10:45:00',
    ]);

    $response->assertStatus(422)
        ->assertJson(['message' => 'Appointment time overlaps with existing appointment']);
});
```

## Ottimizzazione Performance

### 1. **Strategia Esecuzione Test**

#### Esecuzione Parallela
```bash
# Esegui test in parallelo per esecuzione più veloce
./vendor/bin/pest Modules/ModuleName --parallel
```

#### Testing Selettivo
```bash
# Esegui solo test modificati
./vendor/bin/pest Modules/ModuleName --filter="Appointment"

# Esegui suite test specifica
./vendor/bin/pest Modules/ModuleName/tests/Feature/
```

### 2. **Ottimizzazione Database**

#### Usa Database In-Memory
```php
// In phpunit.xml o .env.testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

#### Uso Efficiente Factory
```php
// Crea multiple istanze efficientemente
$appointments = Appointment::factory()
    ->count(10)
    ->for(Patient::factory())
    ->for(Doctor::factory())
    ->create();
```

## Best Practices Assertion

### 1. **Usa Pest Expectations**

#### Assertion Base
```php
expect($result)->toBe('expected');
expect($value)->not->toBeNull();
expect($array)->toHaveCount(3);
```

#### Assertion Complesse
```php
expect($appointment)
    ->patient_id->toBe($patient->id)
    ->doctor_id->toBe($doctor->id)
    ->status->toBe(AppointmentStatusEnum::SCHEDULED);
```

#### Test Metodi e Proprietà
```php
expect($enum)->toHaveMethod('getLabel');
expect($object)->toHaveProperty('id');
```

### 2. **Assertion Personalizzate**

#### Crea Expectation Riutilizzabili
```php
expect()->extend('toBeValidAppointment', function ($appointment) {
    return $this->toBeInstanceOf(Appointment::class)
        ->and($appointment->patient_id)->toBeGreaterThan(0)
        ->and($appointment->doctor_id)->toBeGreaterThan(0)
        ->and($appointment->starts_at)->toBeInstanceOf(Carbon::class);
});

// Utilizzo
expect($appointment)->toBeValidAppointment();
```

## Gestione Dati Test

### 1. **Definizioni Factory**

#### Dati Consistenti
```php
// In factory
public function definition(): array
{
    return [
        'name' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'is_active' => $this->faker->boolean(), // Sintassi corretta
        'created_at' => now(),
    ];
}
```

#### Variazioni Stato
```php
public function active(): static
{
    return $this->state(fn (array $attributes) => [
        'is_active' => true,
    ]);
}

public function inactive(): static
{
    return $this->state(fn (array $attributes) => [
        'is_active' => false,
    ]);
}

// Utilizzo
$activeUser = User::factory()->active()->create();
$inactiveUser = User::factory()->inactive()->create();
```

### 2. **Setup Dati Test**

#### Setup Condiviso
```php
beforeEach(function () {
    $this->patient = Patient::factory()->create();
    $this->doctor = Doctor::factory()->create();
    $this->studio = Studio::factory()->create();
});

it('crea appuntamento con dati setup', function () {
    $appointment = Appointment::factory()->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'studio_id' => $this->studio->id,
    ]);

    expect($appointment->patient_id)->toBe($this->patient->id);
});
```

## Continuous Integration

### 1. **Configurazione GitHub Actions**

#### Setup Base
```yaml
name: Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: testing

    steps:
      - uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql
          coverage: xdebug

      - name: Copy .env
        run: cp .env.example .env

      - name: Install dependencies
        run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

      - name: Generate key
        run: php artisan key:generate

      - name: Set Directory Permissions
        run: chmod -R 777 storage bootstrap/cache

      - name: Create Database
        run: |
          mysql --host 127.0.0.1 --port 3306 -u root -ppassword -e "CREATE DATABASE IF NOT EXISTS testing;"

      - name: Execute tests
        run: ./vendor/bin/pest Modules/ModuleName --coverage
```

#### Setup Avanzato con Caching
```yaml
      - name: Cache Composer dependencies
        uses: actions/cache@v3
        with:
          path: vendor
          key: ${{ runner.os }}-php-${{ hashFiles('**/composer.lock') }}
          restore-keys: |
            ${{ runner.os }}-php-

      - name: Cache npm dependencies
        uses: actions/cache@v3
        with:
          path: node_modules
          key: ${{ runner.os }}-node-${{ hashFiles('**/package-lock.json') }}
          restore-keys: |
            ${{ runner.os }}-node-
```

### 2. **CI Best Practices**

#### Esecuzione Test
1. **Esegui su ogni PR**: Cattura errori presto
2. **Usa matrix testing**: Testa multiple versioni PHP
3. **Cache dipendenze**: Velocizza esecuzione
4. **Esecuzione parallela**: Esegui suite test concorrentemente

#### Quality Gates
```yaml
      - name: Run tests with coverage
        run: |
          ./vendor/bin/pest Modules/ModuleName --coverage --min=80
          ./vendor/bin/phpstan analyse Modules/ModuleName --level=9
```

## Troubleshooting

### 1. **Problemi Comuni**

#### Isolamento Test
```php
// Usa sempre RefreshDatabase per test database
uses(TestCase::class, RefreshDatabase::class);

// O usa DatabaseTransactions per test più veloci
uses(TestCase::class, DatabaseTransactions::class);
```

#### Errori Factory
```bash
# Controlla sintassi factory
./vendor/bin/pest --filter="FactoryTest"

# Verifica relazioni modello
php artisan tinker --execute="Patient::factory()->create()"
```

#### Problemi Performance
```bash
# Profila esecuzione test
./vendor/bin/pest Modules/ModuleName --verbose

# Esegui test lenti specifici
./vendor/bin/pest Modules/ModuleName --filter="DatabaseTest"
```

### 2. **Comandi Debug**

#### Debug Test
```bash
# Esegui singolo test con output verbose
./vendor/bin/pest Modules/ModuleName/tests/Feature/AppointmentBusinessLogicTest.php --verbose

# Esegui test specifico per nome
./vendor/bin/pest Modules/ModuleName --filter="it validates appointment time constraints"

# Esegui con coverage
./vendor/bin/pest Modules/ModuleName --coverage
```

#### Debug Database
```bash
# Controlla connessione database
php artisan tinker --execute="DB::connection()->getPdo()"

# Verifica migrazioni
php artisan migrate:status

# Reset database test
php artisan migrate:fresh --seed --env=testing
```

## Strategie Prevenzione

### 1. **Checklist Code Review**

- [ ] Dichiarazione namespace appropriata
- [ ] Import TestCase e statement uses()
- [ ] Selezione tipo test appropriato
- [ ] Sintassi Faker corretta in factory
- [ ] Verifica metodi enum
- [ ] No uso database non necessario
- [ ] Organizzazione test appropriata con describe/it
- [ ] Nomi test significativi e descrizioni

### 2. **Controlli Automatici**

- **PHPStan**: Analisi statica per type safety
- **Pest**: Validazione test integrata
- **CI/CD**: Esecuzione test automatica
- **Pre-commit hooks**: Validazione locale

### 3. **Documentazione**

- **Mantieni guide aggiornate** con nuovi pattern
- **Condividi soluzioni** con membri team
- **Crea template** per tipi test comuni
- **Documenta valori enum** e metodi

## Pattern di Testing Specifici

### 1. **Testing Enum**
```php
describe('UserTypeEnum', function () {
    it('has correct values', function () {
        expect(UserTypeEnum::PATIENT->value)->toBe('patient');
        expect(UserTypeEnum::DOCTOR->value)->toBe('doctor');
        expect(UserTypeEnum::ADMIN->value)->toBe('admin');
    });

    it('has getLabel method', function () {
        expect(UserTypeEnum::PATIENT)->toHaveMethod('getLabel');
        expect(UserTypeEnum::PATIENT->getLabel())->toBe('Paziente');
    });
});
```

### 2. **Testing Business Rules**
```php
describe('Appointment Business Rules', function () {
    it('prevents overlapping appointments for same doctor', function () {
        $existing = (object) [
            'doctor_id' => 1,
            'start_time' => '[DATE] 10:00:00',
            'end_time' => '[DATE] 10:30:00'
        ];

        $new = (object) [
            'doctor_id' => 1,
            'start_time' => '[DATE] 10:15:00',
            'end_time' => '[DATE] 10:45:00'
        ];

        // Business rule: no overlap
        $overlaps = $this->checkOverlap($existing, $new);
        expect($overlaps)->toBeTrue();
    });
});
```

### 3. **Testing Edge Cases**
```php
describe('Edge Cases', function () {
    it('handles year boundary dates', function () {
        $appointment = (object) [
            'start_time' => '[DATE] 23:00:00',
            'end_time' => '[DATE] 01:00:00'
        ];

        $start = new DateTime($appointment->start_time);
        $end = new DateTime($appointment->end_time);

        expect($start->format('Y'))->toBe('2024');
        expect($end->format('Y'))->toBe('2025');
        expect($end->diff($start)->h)->toBe(2);
    });
});
```

## Monitoraggio e Metriche

### 1. **Test Coverage**
```bash
# Genera report coverage
./vendor/bin/pest --coverage

# Verifica coverage minimo
./vendor/bin/pest --coverage --min=80
```

### 2. **Performance Metrics**
```bash
# Test con timing
./vendor/bin/pest --verbose

# Benchmark specifici
./vendor/bin/pest --filter="BusinessLogicTest"
```

### 3. **Quality Metrics**
```bash
# Analisi statica
./vendor/bin/phpstan analyse --level=9

# Coding standards
./vendor/bin/pint --test
```

## Collegamenti

- [Architettura Testing Principale](testing-architecture-overview.md)
- [Guida Risoluzione Conflitti](git-conflicts-resolution-guide.md)
- [Best Practices Modulo <nome modulo>](../../laravel/modules/<nome modulo>/docs/testing-best-practices.md)
- [Best Practices Modulo <nome progetto>](../../laravel/modules/<nome progetto>/docs/testing-best-practices.md)
- [Testing Modulo Geo](../../laravel/modules/geo/docs/testing.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 1.0
**Compatibilità**: Pest 2.x+, Laravel 12.x, PHP 8.3+
