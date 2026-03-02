# Architettura di Testing - <nome progetto>

## Panoramica

Questo documento descrive l'architettura di testing del progetto <nome progetto>, basata su Pest PHP e organizzata in moduli Laravel indipendenti.
# Architettura di Testing - <nome progetto>

## Panoramica

Questo documento descrive l'architettura di testing del progetto <nome progetto>, basata su Pest PHP e organizzata in moduli Laravel indipendenti.

## Principi Fondamentali

### 1. **Separazione Architetturale**
- **Unit Tests**: Test di logica di business isolata, senza dipendenze esterne
- **Feature Tests**: Test di integrazione che verificano il comportamento end-to-end
- **Module Tests**: Test specifici per ogni modulo Laravel

### 2. **Approccio In-Memory per Unit Tests**
- Utilizzo di oggetti plain PHP per evitare dipendenze da database
- Test di logica di business senza toccare il codice dell'applicazione
- Validazione di regole aziendali in isolamento

### 3. **Enum-Based Validation**
- Utilizzo di enum per garantire type safety nei test
- Validazione di stati e transizioni attraverso enum
- Coerenza con l'architettura dell'applicazione

## Struttura dei Test

### Modulo Geo
```
Modules/Geo/tests/Feature/AddressIntegrationTest.php
```
- **Scopo**: Test di integrazione per gestione indirizzi
- **Approccio**: In-memory con oggetti plain PHP
- **Focus**: Relazioni polimorfiche, geolocalizzazione, Google Places API

### Modulo <nome modulo>
```
Modules/<nome modulo>/tests/Feature/AppointmentValidationTest.php
Modules/<nome modulo>/tests/Feature/DashboardBusinessLogicTest.php
### Modulo <nome progetto>
```
Modules/<nome progetto>/tests/Feature/AppointmentValidationTest.php
Modules/<nome progetto>/tests/Feature/DashboardBusinessLogicTest.php
```
- **Scopo**: Validazione appuntamenti e logica dashboard
- **Approccio**: Test di business logic con oggetti mock
- **Focus**: Regole di scheduling, permessi utente, integrità dati

### Configurazione Pest
```
tests/Pest.php
```
- **Scopo**: Configurazione globale per tutti i test
- **Funzionalità**: Helper functions, configurazione database, factory resolution
- **Integrazione**: Supporto per moduli multipli e connessioni database

## Pattern di Testing

### 1. **Test In-Memory**
```php
// Utilizzo di oggetti plain PHP per test isolati
$patient = (object) ['id' => 1001, 'type' => 'patient'];
$address = makeAddress([
    'model_type' => 'patient',
    'model_id' => $patient->id,
]);
```

### 2. **Validazione Enum**
```php
// Utilizzo di enum per type safety
expect($user->type)->toBe(UserTypeEnum::DOCTOR->value);
expect($address->type)->toBe(AddressTypeEnum::HOME->value);
```

### 3. **Test di Business Logic**
```php
// Validazione di regole aziendali
$startTime = strtotime($appointment->start_time);
$endTime = strtotime($appointment->end_time);
$calculatedDuration = ($endTime - $startTime) / 60;

expect($calculatedDuration)->toBe($appointment->duration);
```

## Best Practices

### 1. **Isolamento dei Test**
- Ogni test deve essere indipendente
- Utilizzo di oggetti mock per dipendenze esterne
- Evitare accesso al database nei unit test

### 2. **Naming Convention**
- Nomi descrittivi per test e describe blocks
- Organizzazione logica per gruppi di test
- Documentazione chiara del comportamento testato

### 3. **Gestione Errori**
- Test di edge cases e scenari di errore
- Validazione di messaggi di errore appropriati
- Test di fallback e comportamenti di default

## Configurazione Database

### Connessioni Multiple
- **sqlite**: Database principale per test
- **user**: Connessione specifica per modulo User
- **<slogan progetto>**: Connessione per modulo <nome progetto>
- **<slogan progetto>**: Connessione per modulo <nome progetto>
- **geo**: Connessione per modulo Geo

### Migrazioni
- Esecuzione automatica di migrazioni per tutti i moduli
- Rollback automatico dopo ogni test
- Isolamento completo tra test

## Helper Functions

### 1. **User Management**
```php
createUser(array $attributes = []): User
makeUser(array $attributes = []): User
createUserOfType(UserTypeEnum $type, array $attributes = []): User
```

### 2. **Module Management**
```php
moduleEnabled(string $module): bool
skipIfModuleDisabled(string $module): void
```

### 3. **Translation Testing**
```php
assertTranslationsExist(string $translationKey, array $locales = ['it', 'en', 'de']): void
```

## Esecuzione dei Test

### Comandi Principali
```bash
# Esegui tutti i test
php artisan test

# Test specifici per modulo
php artisan test --filter=Geo
php artisan test --filter=<nome modulo>
php artisan test --filter=<nome progetto>

# Test specifici per file
php artisan test tests/Feature/AddressIntegrationTest.php
```

### Filtri Pest
```bash
# Test con pattern specifico
php artisan test --filter="can attach address"
php artisan test --filter="validates user types"
```

## Monitoraggio e Qualità

### 1. **Coverage Analysis**
- Test di tutti i percorsi critici
- Validazione di business logic complessa
- Test di integrazione tra moduli

### 2. **Performance Testing**
- Benchmark di operazioni critiche
- Test di scalabilità per operazioni batch
- Validazione di timeout e limiti

### 3. **Regression Testing**
- Test automatici per bugfix
- Validazione di modifiche architetturali
- Test di compatibilità all'indietro

## Collegamenti

- [Modulo Geo Testing](../../laravel/modules/geo/docs/testing.md)
- [Modulo <nome modulo> Testing](../../laravel/modules/<nome modulo>/docs/testing.md)
- [Best Practices Testing](../../laravel/modules/<nome modulo>/docs/testing-best-practices.md)
- [Common Testing Errors](../../laravel/modules/<nome modulo>/docs/common-testing-errors.md)
- [Modulo <nome progetto> Testing](../../laravel/modules/<nome progetto>/docs/testing.md)
- [Best Practices Testing](../../laravel/modules/<nome progetto>/docs/testing-best-practices.md)
- [Common Testing Errors](../../laravel/modules/<nome progetto>/docs/common-testing-errors.md)

---

**Versione**: 1.0
**Compatibilità**: Pest 3.x, Laravel 12.x, PHP 8.3+
