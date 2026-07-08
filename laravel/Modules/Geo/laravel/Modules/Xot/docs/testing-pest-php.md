# Testing con Pest PHP

## Introduzione

Pest PHP è un framework di test estremamente leggero ed espressivo per PHP. In questo progetto Laraxot, Pest è configurato per funzionare con la struttura modulare dei Laravel Modules.

## Installazione e Configurazione

Pest è già configurato nel progetto. La configurazione principale si trova in `phpunit.xml` e si integra con la struttura dei moduli.

### File di configurazione

- `phpunit.xml` - Configurazione principale di PHPUnit/Pest
- `.env.testing` - Variabili d'ambiente per i test

### Struttura PSR-4
La configurazione PSR-4 per lo sviluppo è:

```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    }
}
```

Grazie all'uso di `wikimedia/composer-merge-plugin`, i moduli sono gestiti automaticamente senza bisogno di specificare `"Modules\\": "Modules/"` nell'autoloader.

## Come eseguire i test con Pest

### Comando base
Dalla cartella `laravel/`:

```bash
./vendor/bin/pest
```

## Regole progetto

- I test vanno eseguiti usando `laravel/.env.testing`.
- `DB_CONNECTION` in `.env.testing` deve avere lo **stesso dialetto** di `laravel/.env`.
- `Illuminate\Foundation\Testing\RefreshDatabase` è **vietato** (dialetto/DB condiviso e costi di migrazione).

## Composer merge plugin

Il progetto usa `wikimedia/composer-merge-plugin` per includere automaticamente `Modules/*/composer.json`.
Di conseguenza, in `laravel/composer.json` **non** va aggiunto `"Modules\\": "Modules/"` in `autoload-dev`.

### Eseguire test per un modulo specifico

```bash
./vendor/bin/pest Modules/{ModuleName}/tests/
```

### Eseguire test specifici

```bash
./vendor/bin/pest Modules/User/tests/Feature/UserRegistrationTest.php
```

### Eseguire test con opzioni specifiche

```bash
# Con coverage
./vendor/bin/pest --coverage

# Solo test unitari
./vendor/bin/pest --group=unit

# Solo test funzionali
./vendor/bin/pest --group=feature

# Con verbose output
./vendor/bin/pest -v
```

## Struttura dei test

### Tipi di test
1. **Unit Test** - Testano componenti singoli (Actions, Services, ecc.)
2. **Feature Test** - Testano funzionalità complete

### Convenzioni di denominazione

- I test sono scritti esclusivamente in Pest PHP (non in PHPUnit)
- I file di test seguono la struttura: `Modules/{ModuleName}/tests/{Type}/{TestName}.php`
- I test utilizzano la funzione `it()` per descrivere il comportamento

### Esempio di test Pest

```php
<?php

it('can register a new user', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
    ]);
});
```

### File .env.testing
I test utilizzano il file `.env.testing` che contiene le configurazioni specifiche per l'ambiente di test:

- `APP_ENV=testing`
- `DB_CONNECTION=mysql` (Deve corrispondere a quello di produzione/locale)
- `SESSION_DRIVER=array`
- `CACHE_DRIVER=array`
- `QUEUE_CONNECTION=sync`

### TestCase base
Ogni modulo dovrebbe avere un TestCase base che estende il TestCase principale del framework Xot.

## Best Practices

### 1. DRY + KISS + SOLID + Robust

- **DRY** (Don't Repeat Yourself): Non duplicare logica di test
- **KISS** (Keep It Simple, Stupid): Mantieni i test semplici e diretti
- **SOLID**: Segui principi SOLID nei componenti testati
- **Robust**: Gestisci eccezioni e casi limite

### 2. Struttura AAA
- **Arrange**: Imposta il contesto del test
- **Act**: Esegue l'azione da testare
- **Assert**: Verifica i risultati attesi

### 3. Coverage del 100%

- Obiettivo: 100% di code coverage per ogni modulo
- Testa tutti i percorsi logici
- Testa anche i casi limite e le eccezioni

## Conversione da PHPUnit a Pest

Se trovi test scritti in stile PHPUnit, devono essere convertiti in Pest:

### Vecchio stile (PHPUnit)

```php
class UserTest extends TestCase
{
    /** @test */
    public function it_can_register_user()
    {
        $response = $this->post('/register', $data);
        $response->assertStatus(200);
    }
}
```

### Nuovo stile (Pest)

```php
<?php

it('can register user', function () {
    $response = $this->post('/register', $data);
    $response->assertStatus(200);
});
```

## Risoluzione problemi comuni

### Problemi di autoloading

- Assicurati che Composer sia stato aggiornato: `composer dump-autoload`
- Verifica che la configurazione PSR-4 sia corretta

### Problemi di connessione al database

- Controlla che il file `.env.testing` sia configurato correttamente
- MAI usare `RefreshDatabase`. Se necessario, usa database temporanei o cleanup manuale.

### Test che falliscono a causa di dipendenze esterne

- Usa mocking per simulare dipendenze esterne
- Isola i test dalle dipendenze esterne dove possibile