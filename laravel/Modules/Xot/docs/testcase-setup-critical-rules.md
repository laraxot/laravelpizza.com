# TestCase Setup - Critical Rules

## REGOLE FONDAMENTALI

### 1. MAI Eseguire migrate in setUp()

**❌ SBAGLIATO - NESSUNO MAI FARE QUESTO:**

```php
protected function setUp(): void
{
    parent::setUp();

    // ... config setup ...

    if (! self::$migrated) {
        $this->artisan('module:migrate');  // SBAGLIATO!
        self::$migrated = true;             // SBAGLIATO!
    }
}
```

**Perché è SBAGLIATO:**
1. Mantiene stato tra i test con `$migrated` (ANTI-PATTERN)
2. I test devono essere indipendenti e idempotenti
3. Se un test fallisce, `$migrated` rimane `true` e i successivi non eseguono migrate
4. Crea dipendenza tra i test (violazione isolamento)
5. `module:migrate` è ridondante se eseguito più volte

**✅ CORRETTO:**

```php
protected function setUp(): void
{
    parent::setUp();

    // ... config setup ...

    // NOTE: Migrations are NOT run in setUp()
    // They must be run ONCE externally: php artisan migrate --env=testing
    // DatabaseTransactions trait handles rollback automatically between tests
}
```

### 2. MAI Usare migrate:fresh

**❌ SBAGLIATO:**

```php
$this->artisan('migrate:fresh', ['--force' => true]);  // SBAGLIATO!
$this->artisan('module:migrate', ['--force' => true]); // SBAGLIATO!
```

**Perché è SBAGLIATO:**
1. `migrate:fresh` elimina tutte le tabelle e ricrea il database da zero
2. È lento, specialmente con molti moduli
3. Distrugge i dati tra i test
4. Il flag `--force` serve solo per produzione, non per testing
5. Eseguire `migrate:fresh` + `module:migrate` = migrate DUE VOLTE (ridondante!)

**✅ CORRETTO:**

```bash
# Esegui una volta sola esternamente
php artisan migrate --env=testing

# Non in setUp()!
```

### 3. MAI Mantenere Stato Statico tra i Test

**❌ SBAGLIATO:**

```php
protected static bool $migrated = false;  // SBAGLIATO - stato condiviso!

if (! self::$migrated) {
    $this->artisan('module:migrate');
    self::$migrated = true;  // SBAGLIATO - anti-pattern!
}
```

**Perché è SBAGLIATO:**
1. I test devono essere INDEPENDENTI
2. Lo stato statico crea dipendenze invisibili
3. Non prevede il fallimento parziale dei test
4. Rende difficile il debug
5. Violazione del principio "test isolation"

## Il Sistema CORRETTO

### DatabaseTransactions Trait

Il modo CORRETTO di gestire i test:

```php
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;  // TRAIT CHIAVE!

    /**
     * OBBLIGATORIO: elencare OGNI connessione usata dai Model del modulo.
     * Anche se le connessioni puntano allo stesso server MySQL,
     * sono handle PDO SEPARATI con scope transazionali INDIPENDENTI.
     * Senza elencare la connessione del modulo, i dati NON vengono rollbackati.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = [
        'mysql',
        '{module_snake}',  // DEVE corrispondere a $connection nei Model
        'user',            // Se i test usano Model User
    ];

    // NO setUp() con migrate - NON NECESSARIO
    // Esegui: php artisan migrate --env=testing
    // PRIMA di lanciare i test
}
```

### Come Funziona DatabaseTransactions

1. **Before Each Test**: Avvia una transazione
2. **During Test**: Tutte le operazioni database avvengono nella transazione
3. **After Each Test**: Rollback automatico della transazione

**Vantaggi:**
- Test completamente isolati
- Nessun residuo tra i test
- Performance ottima (rollback veloce)
- Nessun stato condiviso
- Idempotente

### Workflow di Testing Corretto

```bash
# 1. Configura .env.testing (copia carbone di .env con _test)
cd laravel
cp .env .env.testing
# Modifica: DB_DATABASE → DB_DATABASE_test

# 2. Esegui migration UNA VOLTA
php artisan migrate --env=testing

# 3. Esegui test (non eseguono migrate!)
php artisan test --env=testing

# 4. Per reset completo (quando necessario)
php artisan migrate:fresh --env=testing
```

## Pattern nei Test

### ✅ CORRETTO

```php
// Test semplice
it('creates user', function () {
    $user = User::factory()->create();
    expect($user->email)->not->toBeEmpty();
});

// Test con operazioni database
it('updates user', function () {
    $user = User::factory()->create();
    $user->update(['name' => 'Updated']);
    expect($user->name)->toBe('Updated');
});

// Test con transazioni multiple
it('creates related records', function () {
    $user = User::factory()->create();
    $profile = Profile::factory()->for($user)->create();
    expect($profile->user_id)->toBe($user->id);
});
```

### ❌ SBAGLIATO

```php
// Non eseguire migrate!
it('test with migrate', function () {
    $this->artisan('migrate');  // SBAGLIATO!
});

// Non mantenere stato!
protected static $counter = 0;  // SBAGLIATO!
```

## Checklist Anti-Errori

Prima di scrivere codice di test:

- [ ] Ho eseguito `artisan('migrate')` in setUp()? → **STOP! Rimuovi il codice.**
- [ ] Ho usato `artisan('migrate:fresh')`? → **STOP! Usa solo migrate esternamente.**
- [ ] Ho usato il flag `--force`? → **STOP! Serve solo per produzione.**
- [ ] Ho `protected static $migrated`? → **STOP! Rimuovi lo stato statico.**
- [ ] Ho il controllo `if (! self::$migrated)`? → **STOP! Rimuovi il controllo.**
- [ ] Uso `DatabaseTransactions` trait? → **OK!**

## Troubleshooting

### Problema: Test non trovano le tabelle

**Cause possibili:**
1. Migration non eseguite esternamente
2. `.env.testing` non configurato correttamente
3. Connessioni database configurate sbagliato

**Soluzione:**
```bash
# Verifica .env.testing
cat laravel/.env.testing | grep DB_DATABASE

# Esegui migration
php artisan migrate --env=testing

# Verifica database
php artisan db:table --env=testing
```

### Problema: I test si influenzano tra loro

**Causa errata:**
Manca il trait `DatabaseTransactions`

**Soluzione:**
```php
abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;  // AGGIUNGI QUESTO!
}
```

### Problema: Test lenti

**Causa errata:**
Eseguire migrate in setUp()

**Soluzione:**
Rimuovi le chiamate `artisan('migrate')` da setUp()

## Perché Questa Architettura è Migliore

### Isolamento Completo
- Ogni test avviene in una transazione pulita
- Nessun residuo tra i test
- Test completamente indipendenti

### Performance
- Rollback veloce vs delete + migrate
- Evita ricostruzione del database
- Migliora velocità dei test

### Manutenibilità
- Niente stato statico da gestire
- Niente controllo complesso
- Codice più pulito

### Affidabilità
- Test idempotenti
- Nessuna dipendenza tra test
- Fail-safe

## Documentazione Correlata

- [Database Configuration Critical Rules](./database-configuration-critical-rules.md)
- [Database Testing Configuration](../Gdpr/docs/database-testing-configuration.md)
- [Laraxot Testing Guidelines](./laraxot-testing-guidelines.md)

## Regole d'Oro per TestCase

1. **Niente migrate in setUp()** - Esegui esternamente una volta
2. **Niente migrate:fresh** - Distruttivo e lento
3. **Niente flag --force** - Solo per produzione
4. **Niente stato statico** - I test devono essere indipendenti
5. **Usa DatabaseTransactions** - Per rollback automatico

Queste regole devono essere ricordate e applicate da TUTTI gli agenti AI (iFlow, Windsurf, Cursor, Gemini, Antigravity, ecc.).