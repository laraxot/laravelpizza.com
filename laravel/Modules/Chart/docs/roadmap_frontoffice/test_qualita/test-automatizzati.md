# Test Automatizzati

## Panoramica

I test automatizzati sono una componente essenziale per garantire la qualità del software. Questo documento descrive le strategie e le linee guida per l'implementazione dei test automatizzati nel progetto <nome progetto>.

## Tipologie di Test

### 1. Unit Test

**Scopo**: Verificare il corretto funzionamento delle singole unità di codice in isolamento.

**Linee Guida**:
- Un test per ogni metodo pubblico
- Testare tutti i percorsi condizionali
- Mockare le dipendenze esterne
- Nome del test: `it_[verbo]_[condizione]_[risultato_atteso]`

**Esempio**:
```php
public function it_returns_false_when_user_is_not_admin()
{
    $user = User::factory()->create(['is_admin' => false]);
    $this->assertFalse($user->isAdmin());
}
```

### 2. Test di Integrazione

**Scopo**: Verificare l'interazione tra diversi componenti del sistema.

**Aree di Test**:
- Interazione con il database
- Chiamate API
- Integrazione con servizi esterni

**Best Practice**:
- Utilizzare i database in memoria per i test
- Ripristinare lo stato tra i test
- Testare i casi limite

### 3. Test End-to-End (E2E)

**Scopo**: Verificare il flusso completo dell'applicazione dal punto di vista dell'utente.

**Strumenti**:
- Laravel Dusk per test browser
- Pest per test API

**Scenari Tipici**:
- Flusso di registrazione
- Processo di prenotazione
- Gestione del profilo utente

## Struttura delle Directory

```
tests/
├── Unit/
│   ├── Models/
│   ├── Actions/
│   └── Services/
├── Feature/
│   ├── Api/
│   ├── Http/
│   └── Jobs/
└── Browser/
    ├── Auth/
    └── Components/
```

## Configurazione

### phpunit.xml

```xml
<phpunit>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
    <coverage processUncoveredFiles="true">
        <include>
            <directory suffix=".php">./app</directory>
        </include>
    </coverage>
</phpunit>
```

## Esecuzione dei Test

### Comandi Base

```bash

# Esegui tutti i test
php artisan test

# Esegui solo i test unitari
php artisan test --testsuite=Unit

# Esegui un singolo test
php artisan test tests/Unit/Models/UserTest.php

# Con report di copertura
php artisan test --coverage-html=coverage
```

### Opzioni Avanzate

```bash

# Esegui i test in parallelo
php artisan test --parallel

# Filtra i test per nome
php artisan test --filter=it_handles_invalid_login

# Genera report JUnit
php artisan test --log-junit=junit.xml
```

## Continuous Integration

### GitHub Actions

```yaml
name: Run Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: dom, curl, libxml, mbstring, zip, pdo, sqlite, pdo_sqlite
      - name: Install Dependencies
        run: |
          composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
      - name: Generate key
        run: php artisan key:generate
      - name: Execute tests
        run: php artisan test --coverage-clover=coverage.xml
      - name: Upload coverage to Codecov
        uses: codecov/codecov-action@v3
        with:
          token: ${{ secrets.CODECOV_TOKEN }}
          file: ./coverage.xml
```

## Best Practice

1. **Test Isolati**: Ogni test deve essere indipendente dagli altri
2. **Nomi Descritivi**: Usare nomi che descrivano il comportamento atteso
3. **AAA Pattern**: Organizzare i test in Arrange-Act-Assert
4. **Test Deterministici**: Assicurarsi che i test producano sempre lo stesso risultato
5. **Mock Soltanto il Necessario**: Evitare di mockare eccessivamente

## Metriche

- Copertura codice: >80%
- Tempo di esecuzione: < 5 minuti
- Successo build: 100%

## Risoluzione dei Problemi

### Test Lenti
- Utilizzare database in memoria
- Ridurre le chiamate al database
- Usare i factory in modo efficiente

### Test Instabili
- Evitare sleep() nei test
- Usare i metodi di attesa di Laravel Dusk
- Verificare le condizioni asincrone

## Documentazione Aggiuntiva

- [Documentazione ufficiale PHPUnit](https://phpunit.de/documentation.html)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Pest PHP](https://pestphp.com/docs)
