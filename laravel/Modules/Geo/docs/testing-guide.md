# <nome progetto> Testing Guide
# <nome progetto> Testing Guide

## Overview

Questo progetto utilizza **Pest PHP** come framework di testing principale per garantire una copertura completa del codice e la qualità del software.

## Struttura Test

### Directory Structure
```
laravel/
├── tests/                          # Test globali
│   ├── Feature/
│   ├── Unit/
│   └── Browser/
├── Modules/
│   ├── Chart/tests/
│   │   ├── Unit/
│   │   ├── Feature/
│   │   ├── Pest.php
│   │   └── TestCase.php
│   ├── <nome progetto>/tests/
│   ├── <nome modulo>/tests/
│   ├── <nome progetto>/tests/
│   ├── <nome progetto>/tests/
│   ├── User/tests/
│   └── Geo/tests/
└── scripts/run-tests.sh            # Script per esecuzione test
```

### Moduli Testati

#### ✅ Chart Module
- **Unit Tests**: ChartModelTest.php
- **Feature Tests**: ChartFactoryTest.php, ChartIntegrationTest.php
- **Coverage**: Modello Chart, Factory, Accessors, Metodi business logic

#### ✅ <nome progetto> Module (Core)
#### ✅ <nome progetto> Module (Core)
- **Unit Tests**: PatientModelTest.php, AppointmentModelTest.php
- **Feature Tests**: AppointmentIntegrationTest.php
- **Coverage**: Modelli core, Relazioni, Enums, State management

#### ✅ <nome modulo> Module
#### ✅ <nome progetto> Module
- **Unit Tests**: BaseModelTest.php
- **Coverage**: BaseModel traits, Configurazioni, Media handling

#### ✅ User Module
- **Unit Tests**: UserModelTest.php
- **Feature Tests**: UserAuthenticationTest.php
- **Coverage**: Autenticazione, Autorizzazione, Relazioni team

#### ✅ Geo Module
- **Unit Tests**: AddressModelTest.php
- **Feature Tests**: AddressIntegrationTest.php
- **Coverage**: Indirizzi, Geolocalizzazione, Google Places integration

## Esecuzione Test

### Script Automatico
```bash
# Esegui tutti i test con coverage
./scripts/run-tests.sh

# Solo test senza coverage
./scripts/run-tests.sh --skip-coverage

# Solo test specifici
./scripts/run-tests.sh --filter="Chart"

# Salta PHPStan
./scripts/run-tests.sh --skip-phpstan
```

### Comandi Manuali
```bash
# Tutti i test
vendor/bin/pest

# Con coverage
vendor/bin/pest --coverage --coverage-html=coverage

# Test specifico modulo
vendor/bin/pest Modules/Chart/tests

# Test specifico
vendor/bin/pest --filter="ChartModelTest"
```

## Configurazione Coverage

### PHPUnit Configuration
Il file `phpunit.xml` è configurato per:
- **Source Directories**: `app/` e `Modules/*/app/`
- **Test Suites**: Unit, Feature, Browser
- **Coverage Formats**: HTML, Clover, Cobertura
- **Thresholds**: Low 50%, High 80%

### Coverage Reports
- **HTML**: `coverage-html/index.html`
- **Clover**: `coverage-clover.xml`
- **Text**: `coverage-text.txt`

## Helper Functions

### Chart Module
```php
createChart($attributes = [])    // Crea Chart in database
makeChart($attributes = [])      // Crea Chart in memoria
```

### <nome progetto> Module
### <nome progetto> Module
```php
createAppointment($attributes = [])
createPatient($attributes = [])
createDoctor($attributes = [])
```

### User Module
```php
createUser($attributes = [])
createTeam($attributes = [])
createProfile($attributes = [])
```

### Geo Module
```php
createCountry($attributes = [])
createRegion($attributes = [])
createCity($attributes = [])
```

## Custom Expectations

```php
expect($chart)->toBeChart()
expect($user)->toBeUser()
expect($address)->toBeCountry()
// ... e altri
```

## CI/CD Integration

### GitHub Actions
Il workflow `.github/workflows/tests.yml` esegue:
- Test su PHP 8.2 e 8.3
- PHPStan analysis level 9
- Test completi con coverage
- Upload coverage a Codecov

### Requisiti CI
- MySQL 8.0 service
- PHP extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, bcmath, soap, intl, gd, exif, iconv
- Xdebug per coverage

## Best Practices

### Naming Conventions
- Test files: `*Test.php`
- Test methods: `it('should do something', function() {})`
- Describe blocks: `describe('Model Name', function() {})`

### Test Structure
```php
describe('Model Name', function () {
    it('can be created with factory', function () {
        $model = createModel();

        expect($model)->toBeInstanceOf(Model::class)
            ->and($model->exists)->toBeTrue();
    });

    describe('Relationships', function () {
        // Test delle relazioni
    });

    describe('Business Logic', function () {
        // Test della logica di business
    });
});
```

### Coverage Goals
- **Minimum**: 70% overall coverage
- **Target**: 85% overall coverage
- **Critical paths**: 95% coverage
- **Models**: 90% coverage
- **Controllers**: 80% coverage

## Troubleshooting

### Common Issues
1. **Memory Limit**: Aumentare memory_limit in php.ini
2. **Database**: Verificare configurazione database testing
3. **Permissions**: Controllare permessi directory storage/

### Debug Tests
```bash
# Verbose output
vendor/bin/pest --verbose

# Stop on first failure
vendor/bin/pest --stop-on-failure

# Debug specifico test
vendor/bin/pest --filter="test_name" --verbose
```

## Metriche Attuali

### Moduli Completati
- ✅ Chart: Unit + Feature tests
- ✅ <nome progetto>: Core models + Integration
- ✅ <nome modulo>: Base functionality
- ✅ <nome progetto>: Core models + Integration
- ✅ <nome progetto>: Base functionality
- ✅ User: Authentication + Authorization
- ✅ Geo: Address + Geolocation

### Coverage Target
- **Current**: ~75% (stimato)
- **Target**: 85%
- **Critical**: 95% per core business logic

## Prossimi Passi

1. **Espandere test esistenti**
   - Aggiungere edge cases
   - Test di performance
   - Test di sicurezza

2. **Nuovi moduli**
   - Cms module
   - Notify module
   - Altri moduli custom

3. **Integration tests**
   - API endpoints
   - Filament resources
   - Workflow completi

4. **Browser tests**
   - Laravel Dusk
   - E2E testing
   - UI testing

---

**Versione Pest**: 3.8
**Versione PHPUnit**: 11.x
