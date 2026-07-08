# Troubleshooting - Modulo IndennitaResponsabilita

## Fatal Error Filament su `$record` (InteractsWithRecord)

- Sintomo: errore fatale "define the same property ($record) ... definition differs and is considered incompatible".
- Causa: la pagina ridefinisce `$record` gia dichiarata dalla trait Filament `InteractsWithRecord`.
- Fix: rimuovere la proprieta duplicata e usare getter tipizzato.
- Dettagli: [Filament `InteractsWithRecord` - Conflitto su proprieta `$record`](./filament-interactswithrecord-record-conflict.md)

## Errori Comuni PHPStan

### 1. Constructor Return Types

**Errore**: Constructor has a return type
**File**: `app/Emails/LettFMail.php:31`, `app/Emails/LettIMail.php:28`

**Soluzione**: I costruttori non devono avere tipo di ritorno esplicito, usare solo `void` se necessario.

### 2. Method Return Type Mismatches

**Errore**: Method should return X but returns Y
**File**: `app/Emails/LettIMail.php:38`

**Soluzione**: Assicurarsi che il tipo di ritorno dichiarato corrisponda al valore effettivamente restituito.

### 3. Undefined Properties and Methods

**Errori Frequenti**:
- Access to undefined property `$form`
- Call to undefined method `myLogs()`

**Soluzioni**:
- Verificare che le proprietà siano dichiarate o accessibili tramite magic methods
- Assicurarsi che i metodi siano definiti nei trait o nelle classi base

### 4. Template Type Resolution

**Errore**: Unable to resolve template type TKey in call to function collect

**Soluzione**: Specificare esplicitamente i tipi quando si usa `collect()`:
```php
// Invece di
$msg = collect($messages)->keyBy('type');

// Usare
/** @var Collection<string, object> $msg */
$msg = collect($messages)->keyBy('type');
```

### 5. Binary Operation Errors

**Errore**: Binary operation between non-falsy-string and mixed

**Soluzione**: Validare i tipi prima delle operazioni di concatenazione:
```php
// Invece di
$subject = $oggetto.' - '.$cognome.' '.$nome;

// Usare
$subject = (string)$oggetto.' - '.(string)$cognome.' '.(string)$nome;
```

### 6. Property Assignment Issues

**Errore**: Property is not writable

**Soluzione**: Verificare che le proprietà siano definite come writable o usare metodi setter appropriati.

## Debug Tips

### 1. Verifica delle Relazioni

```php
// Per verificare che una relazione esista
if ($this->relationLoaded('messages')) {
    // relazione caricata
}

// Per caricare una relazione se non presente
$this->loadMissing('messages');
```

### 2. Type Checking

```php
// Verifica tipo prima di usare
if (is_string($value) && $value !== '') {
    // usa $value
}

// Con null coalescing
$email = $this->email ?? '';
```

### 3. Debugging Collections

```php
// Verifica che collect riceva dati validi
if (is_iterable($messages)) {
    $msg = collect($messages)->keyBy('type');
} else {
    $msg = collect();
}
```

## Problemi di Performance

### 1. N+1 Query Problems

**Sintomo**: Troppe query database

**Soluzione**: Usare eager loading
```php
// Invece di caricare relazioni in loop
$records = LettF::all();
foreach ($records as $record) {
    echo $record->anag->name; // N+1 query
}

// Usare eager loading
$records = LettF::with('anag')->get();
foreach ($records as $record) {
    echo $record->anag->name; // Una sola query aggiuntiva
}
```

### 2. Memory Issues

**Sintomo**: Memory limit exceeded

**Soluzioni**:
- Usare chunk per elaborazioni batch
- Liberare memoria con `unset()`
- Usare lazy collections per dataset grandi

## Errori di Configurazione

### 1. Missing Environment Variables

Verificare che siano configurate:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
```

### 2. PDF Generation Issues

**Problemi comuni**:
- Font mancanti
- Permessi di scrittura
- Memory limit per PDF grandi

**Soluzioni**:
- Verificare configurazione PDF service
- Aumentare memory limit
- Verificare permessi filesystem

## Testing Issues

### 1. Factory Problems

**Errore**: Factory not found

**Soluzione**: Registrare factory nei service provider:
```php
// In service provider
$this->app->make(Factory::class)->load(__DIR__.'/../database/factories');
```

### 2. Database Issues in Tests

**Problemi**:
- Foreign key constraints
- Transaction rollback

**Soluzioni**:
- Usare `DatabaseTransactions` trait
- Configurare foreign key checks appropriatamente

## Filament Issues

### 1. Resource Not Found

**Errore**: Resource class not found

**Soluzione**: Verificare namespace e registrazione nel panel provider

### 2. Form Validation

**Errore**: Validation rules not working

**Soluzione**: Verificare che le regole siano definite correttamente nel modello o form

## Logging e Monitoring

### 1. Enable Debug Logging

```php
// In config/logging.php
'channels' => [
    'indennita' => [
        'driver' => 'single',
        'path' => storage_path('logs/indennita.log'),
        'level' => 'debug',
    ],
],
```

### 2. Custom Log Channel

```php
// Nel codice
Log::channel('indennita')->info('Debug message', ['data' => $data]);
```

## Sicurezza

### 1. Validation

Sempre validare input utente:
```php
$validated = $request->validate([
    'complessita' => 'required|numeric|min:0|max:40',
    'email' => 'required|email|max:255',
]);
```

### 2. Authorization

Usare policy per controllo accessi:
```php
// In controller
$this->authorize('update', $indennitaResponsabilita);

// In Filament Resource
protected static ?string $policy = IndennitaResponsabilitaPolicy::class;
```

### 3. Mass Assignment Protection

Configurare `$fillable` o `$guarded` appropriatamente:
```php
protected $fillable = [
    'posizione_lavoro',
    'complessita',
    'coordinamento',
    'responsabilita',
    // ... altri campi sicuri
];
```
