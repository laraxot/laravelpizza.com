# Filosofia dei Comandi Console - Modulo User

## Principi Fondamentali

### 1. Interattività Moderna
I comandi console del modulo User seguono la filosofia di **interattività moderna** utilizzando esclusivamente Laravel Prompts invece delle API legacy di Laravel Console.

**✅ CORRETTO**:
```php
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;
use function Laravel\Prompts\multiselect;

$email = text('Inserisci l\'email dell\'utente:');
$password = password('Inserisci la nuova password:');
$modules = multiselect('Seleziona moduli:', $options);
```

**❌ ERRATO**:
```php
$email = $this->ask('Inserisci l\'email dell\'utente:');
$password = $this->secret('Inserisci la nuova password:');
$modules = $this->choice('Seleziona moduli:', $options);
```

### 2. Type Safety Rigorosa
Ogni comando deve implementare **type safety rigorosa** con:
- `declare(strict_types=1);` obbligatorio
- Tipi di ritorno espliciti per tutti i metodi
- Type hints per tutti i parametri
- PHPDoc completi per proprietà e metodi

```php
/**
 * Recupera l'utente tramite email.
 *
 * @param string $email Email dell'utente
 * @return \Modules\User\Models\User|null Utente trovato o null
 */
private function getUserByEmail(string $email): ?\Modules\User\Models\User
{
    // Implementazione
}
```

### 3. Gestione Errori Robusta
La gestione degli errori deve essere **preventiva e informativa**:

```php
public function handle(): int
{
    try {
        // Controlli preventivi
        if (empty($email)) {
            $this->error('Email non fornita.');
            return Command::FAILURE;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email non valida: ' . $email);
            return Command::FAILURE;
        }
        
        // Logica principale
        $result = $this->processCommand();
        
        $this->info('Operazione completata con successo!');
        return Command::SUCCESS;
        
    } catch (\Exception $e) {
        $this->error('Errore durante l\'esecuzione: ' . $e->getMessage());
        return Command::FAILURE;
    }
}
```

### 4. Return Codes Standardizzati
Tutti i comandi devono utilizzare i **return codes standardizzati** di Laravel:

```php
return Command::SUCCESS;   // 0 - Operazione completata
return Command::FAILURE;   // 1 - Errore durante l'esecuzione
return Command::INVALID;   // 2 - Input non valido (se applicabile)
```

## Architettura e Design

### 1. Separazione delle Responsabilità
Ogni comando deve seguire il principio di **separazione delle responsabilità**:

```php
class ChangePasswordCommand extends Command
{
    // Metodo principale - coordinamento
    public function handle(): int { /* ... */ }
    
    // Metodi privati - responsabilità specifiche
    private function getUserEmail(): string { /* ... */ }
    private function getUserByEmail(string $email): ?User { /* ... */ }
    private function displayUserInfo(User $user): void { /* ... */ }
    private function getNewPassword(): string { /* ... */ }
    private function confirmPassword(string $password): ?string { /* ... */ }
    private function updateUserPassword(User $user, string $password): void { /* ... */ }
}
```

### 2. Pattern di Validazione
La validazione deve seguire un **pattern consistente**:

```php
// 1. Controllo esistenza
if (empty($value)) {
    $this->error('Valore non fornito.');
    return Command::FAILURE;
}

// 2. Controllo formato
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $this->error('Formato non valido: ' . $email);
    return Command::FAILURE;
}

// 3. Controllo business logic
if (!$this->businessRuleCheck($value)) {
    $this->error('Regola business non soddisfatta.');
    return Command::FAILURE;
}
```

### 3. Feedback Utente
Il feedback deve essere **chiaro e informativo**:

```php
// Informazioni utente
$this->info('=== Informazioni Utente ===');
$this->info("ID: {$user->id}");
$this->info("Email: {$user->email}");
$this->info('==========================');

// Successo
$this->info('Operazione completata con successo!');
$this->info("Utente: {$user->email}");

// Errori
$this->error('Errore durante l\'operazione: ' . $message);

// Warning
$this->warn('Attenzione: ' . $warning);
```

## Integrazione con Laraxot

### 1. Utilizzo di XotData
I comandi devono utilizzare **XotData** per l'accesso ai dati:

```php
// ✅ CORRETTO
$user = XotData::make()->getUserByEmail($email);

// ❌ ERRATO
$user = User::where('email', $email)->first();
```

### 2. Contracts e Interfacce
Utilizzare sempre **contracts e interfacce** per type safety:

```php
use Modules\Xot\Contracts\UserContract;

private function getUserByEmail(string $email): ?UserContract
{
    return XotData::make()->getUserByEmail($email);
}
```

### 3. Eventi e Notifiche
I comandi devono **dispatched eventi appropriati**:

```php
// Dopo operazione di successo
event(new NewPasswordSet($user));

// Dopo assegnazione ruolo
event(new RoleAssigned($user, $role));

// Dopo creazione utente
event(new UserCreated($user));
```

## Best Practices per UX

### 1. Prompts Intelligenti
I prompts devono essere **intelligenti e contestuali**:

```php
// Con placeholder informativo
$email = text('Inserisci l\'email dell\'utente:')
    ->placeholder('es. admin@example.com');

// Con validazione in tempo reale
$email = text('Inserisci l\'email dell\'utente:')
    ->validate(fn (string $value): string|bool => 
        filter_var($value, FILTER_VALIDATE_EMAIL) ? true : 'Email non valida'
    );

// Con opzioni predefinite
$modules = multiselect(
    label: 'Seleziona moduli',
    options: $modules_opts,
    default: $currentModules,  // Pre-checked
    required: false,
    scroll: 10,
);
```

### 2. Conferme e Validazioni
Implementare **conferme e validazioni** appropriate:

```php
// Conferma password
$password = password('Inserisci la nuova password:');
$confirmPassword = password('Conferma la nuova password:');

if ($password !== $confirmPassword) {
    $this->error('Le password non coincidono!');
    return Command::FAILURE;
}

// Conferma operazioni distruttive
if (!$this->confirm('Sei sicuro di voler eliminare questo utente?')) {
    $this->info('Operazione annullata.');
    return Command::SUCCESS;
}
```

### 3. Output Strutturato
L'output deve essere **strutturato e leggibile**:

```php
// Header informativo
$this->info('=== GESTIONE UTENTI ===');
$this->info('Comando: ' . $this->getName());
$this->info('Timestamp: ' . now()->format('d/m/Y H:i:s'));
$this->info('========================');

// Dettagli operazione
$this->info('Operazione completata:');
$this->info("  - Utente: {$user->email}");
$this->info("  - Ruolo: {$role->name}");
$this->info("  - Timestamp: {$user->updated_at->format('d/m/Y H:i:s')}");

// Footer
$this->info('========================');
$this->info('Operazione completata con successo!');
```

## Sicurezza e Compliance

### 1. Validazione Input
Implementare **validazione input rigorosa**:

```php
// Sanitizzazione
$email = trim($email);
$email = strtolower($email);

// Validazione formato
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $this->error('Email non valida: ' . $email);
    return Command::FAILURE;
}

// Validazione business rules
if (strlen($password) < 8) {
    $this->error('Password troppo corta (minimo 8 caratteri)');
    return Command::FAILURE;
}
```

### 2. Audit Trail
Mantenere **audit trail completo**:

```php
// Tracciamento operazioni
$user->update([
    'password' => Hash::make($password),
    'updated_by' => 'console-command',
    'updated_at' => now(),
]);

// Logging
\Log::info('Password cambiata via console', [
    'user_id' => $user->id,
    'email' => $user->email,
    'command' => $this->getName(),
    'timestamp' => now(),
]);
```

### 3. Controlli di Accesso
Implementare **controlli di accesso appropriati**:

```php
// Verifica permessi
if (!$this->userCanPerformAction($action)) {
    $this->error('Non hai i permessi per eseguire questa operazione.');
    return Command::FAILURE;
}

// Verifica ambiente
if (app()->environment('production')) {
    if (!$this->confirm('Stai operando in produzione. Continuare?')) {
        $this->info('Operazione annullata.');
        return Command::SUCCESS;
    }
}
```

## Testing e Qualità

### 1. Test Unitari
Ogni comando deve avere **test unitari completi**:

```php
#[Test]
#[Group('console-commands')]
public function it_changes_user_password_successfully(): void
{
    // Arrange
    $user = User::factory()->create();
    
    // Act
    $result = $this->artisan('user:change-password', [
        '--email' => $user->email
    ]);
    
    // Assert
    $result->assertExitCode(Command::SUCCESS);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'updated_by' => 'console-command',
    ]);
}
```

### 2. Test di Integrazione
Implementare **test di integrazione** per scenari complessi:

```php
#[Test]
#[Group('console-commands')]
public function it_handles_nonexistent_user_gracefully(): void
{
    // Act
    $result = $this->artisan('user:change-password', [
        '--email' => 'nonexistent@example.com'
    ]);
    
    // Assert
    $result->assertExitCode(Command::FAILURE);
    $result->expectsOutput('Utente con email \'nonexistent@example.com\' non trovato.');
}
```

### 3. Test di Performance
Verificare **performance e scalabilità**:

```php
#[Test]
#[Group('console-commands')]
public function it_handles_large_datasets_efficiently(): void
{
    // Arrange
    User::factory()->count(1000)->create();
    
    // Act & Assert
    $startTime = microtime(true);
    
    $result = $this->artisan('user:list');
    
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    
    $this->assertLessThan(5.0, $executionTime, 'Comando troppo lento');
    $result->assertExitCode(Command::SUCCESS);
}
```

## Evoluzione e Manutenzione

### 1. Versioning
Mantenere **versioning chiaro** per ogni comando:

```php
/**
 * ChangePasswordCommand
 * 
 * @version 2.0
 * @since 2025-01-27
 * @author Laraxot Team
 */
class ChangePasswordCommand extends Command
{
    // ...
}
```

### 2. Changelog
Mantenere **changelog dettagliato**:

```markdown
## Changelog

### 2.0 - 2025-01-27
- ✅ Migrazione a Laravel Prompts
- ✅ Validazione email migliorata
- ✅ Gestione errori robusta
- ✅ Return codes standardizzati

### 1.0 - 2025-01-20
- ✅ Funzionalità base
- ✅ Interfaccia console
- ✅ Gestione password
```

### 3. Deprecation Policy
Implementare **politica di deprecazione**:

```php
// Metodo deprecato
/**
 * @deprecated Since version 2.0, use getNewPassword() instead
 */
private function getPasswordLegacy(): string
{
    trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);
    return $this->getNewPassword();
}
```

## Collegamenti
- [README Comandi Console](README.md)
- [ChangePasswordCommand](change-password-command.md)
- [AssignModuleCommand](assign-module-command.md)
- [Testing Strategy](../testing/console-commands-testing.md)
- [Security Guidelines](../security/console-commands-security.md)

## Aggiornamenti

### 2025-01-27 - Versione 2.0
- ✅ **Filosofia Documentata**: Principi e best practice completi
- ✅ **Pattern Architetturali**: Separazione responsabilità e type safety
- ✅ **UX Guidelines**: Prompts intelligenti e feedback strutturato
- ✅ **Security Framework**: Validazione, audit trail e controlli accesso
- ✅ **Testing Strategy**: Test unitari, integrazione e performance
- ✅ **Maintenance Policy**: Versioning, changelog e deprecation

*Ultimo aggiornamento: 2025-01-27*





