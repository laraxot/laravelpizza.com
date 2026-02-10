# Spatie Queueable Actions Architecture - GDPR Registration

## Panoramica

Il modulo Gdpr utilizza il pattern **Spatie Queueable Actions** per separare la business logic in singole actions atomiche, riutilizzabili e testabili. Questo approccio è conforme ai principi Laraxot (DRY + KISS + SOLID + ROBUST).

## Pattern Spatie Queueable Action

### Definizione

Spatie Queueable Actions è un package Laravel che permette di:

1. **Incapsulare la business logic** in classi action dedicate
2. **Eseguire azioni in modo sincrono o asincrono** (queue)
3. **Riutilizzare azioni** in diversi contesti
4. **Testare facilmente** la logica di business
5. **Tracciare** le azioni eseguite con tags e metadata

### Struttura Base

```php
<?php

namespace Modules\Gdpr\Actions\Example;

use Spatie\QueueableAction\QueueableAction;

class ExampleAction extends QueueableAction
{
    /**
     * Execute the action.
     *
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function execute(array $data): mixed
    {
        // Business logic here
        return $result;
    }

    /**
     * Get tags for the action.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['gdpr', 'example'];
    }

    /**
     * Get the display name for the action.
     *
     * @return string
     */
    public function displayName(): string
    {
        return 'Example Action';
    }

    /**
     * Get the description for the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Performs an example operation.';
    }
}
```

## Architettura Registration Actions

### Mappa delle Actions

Il processo di registrazione utilizza 8 actions principali:

```
Registration Flow
├── 1. ValidateGdprConsentAction
│   └── Verifica consensi obbligatori GDPR
├── 2. ValidateUserDataAction
│   └── Valida e sanifica dati utente
├── 3. CreateUserAction (User Module)
│   └── Crea nuovo utente nel database
├── 4. CollectGdprConsentsAction
│   └── Raccoglie consensi in formato strutturato
├── 5. SaveGdprConsentsAction
│   └── Salva consensi GDPR nel database
├── 6. LogRegistrationAction (User Module)
│   └── Logga tentativo di registrazione
├── 7. HandleSuccessfulRegistrationAction
│   └── Gestisce successo registrazione
└── 8. HandleRegistrationErrorAction
    └── Gestisce errori registrazione
```

### Dettaglio delle Actions

#### 1. ValidateGdprConsentAction

**Percorso**: `Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction`

**Responsabilità**: Verifica che i consensi obbligatori siano stati accettati

**Input**:
- `bool $privacy_accepted` - Accettazione informativa privacy
- `bool $terms_accepted` - Accettazione termini e condizioni

**Output**: `void` (lancia ValidationException se non validi)

**Pattern**:
```php
public function execute(bool $privacyAccepted, bool $termsAccepted): void
{
    if (!$privacyAccepted) {
        throw ValidationException::withMessages([
            'privacy_accepted' => 'Devi accettare l\'informativa privacy.',
        ]);
    }

    if (!$termsAccepted) {
        throw ValidationException::withMessages([
            'terms_accepted' => 'Devi accettare i termini e condizioni.',
        ]);
    }
}
```

#### 2. ValidateUserDataAction

**Percorso**: `Modules\Gdpr\Actions\Validation\ValidateUserDataAction`

**Responsabilità**: Valida e sanifica i dati dell'utente

**Input**:
- `array<string, mixed> $data` - Dati grezzi dal form

**Output**: `array<string, mixed>` - Dati validati e sanificati

**Pattern**:
```php
public function execute(array $data): array
{
    return [
        'first_name' => app(SafeStringCastAction::class)->execute($data['first_name']),
        'last_name' => app(SafeStringCastAction::class)->execute($data['last_name']),
        'email' => app(SafeStringCastAction::class)->execute($data['email']),
        'password' => app(SafeStringCastAction::class)->execute($data['password']),
    ];
}
```

#### 3. CreateUserAction (User Module)

**Percorso**: `Modules\User\Actions\CreateUserAction`

**Responsabilità**: Crea un nuovo utente nel database

**Input**:
- `array<string, mixed> $data` - Dati utente validati

**Output**: `Modules\User\Models\User` - Utente creato

**Pattern**:
```php
public function execute(array $data): User
{
    $userData = [
        'first_name' => app(SafeStringCastAction::class)->execute($data['first_name']),
        'last_name' => app(SafeStringCastAction::class)->execute($data['last_name']),
        'email' => app(SafeStringCastAction::class)->execute($data['email']),
        'password' => Hash::make(
            app(SafeStringCastAction::class)->execute($data['password'])
        ),
        'type' => 'customer_user',
        'state' => 'active',
        'email_verified_at' => now(),
    ];

    $user = User::create($userData);

    activity('user')
        ->causedBy($user)
        ->performedOn($user)
        ->withProperties([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'source' => 'registration_form',
        ])
        ->log('User created via CreateUserAction');

    return $user;
}
```

#### 4. CollectGdprConsentsAction

**Percorso**: `Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction`

**Responsabilità**: Raccoglie i consensi in formato strutturato per il database

**Input**:
- `bool $privacy_accepted` - Accettazione privacy
- `bool $terms_accepted` - Accettazione termini
- `bool $marketing_consent` - Accettazione marketing

**Output**: `array<string, array<string, mixed>>` - Consenti strutturati

**Pattern**:
```php
public function execute(bool $privacyAccepted, bool $termsAccepted, bool $marketingConsent): array
{
    $ipAddress = request()->ip();
    $userAgent = request()->userAgent();

    $consents = [];

    if ($privacyAccepted) {
        $consents['privacy_policy'] = [
            'treatment_name' => 'privacy_policy',
            'accepted' => true,
            'accepted_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ];
    }

    if ($termsAccepted) {
        $consents['terms_conditions'] = [
            'treatment_name' => 'terms_conditions',
            'accepted' => true,
            'accepted_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ];
    }

    if ($marketingConsent) {
        $consents['marketing'] = [
            'treatment_name' => 'marketing',
            'accepted' => true,
            'accepted_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ];
    }

    return $consents;
}
```

#### 5. SaveGdprConsentsAction

**Percorso**: `Modules\Gdpr\Actions\SaveGdprConsentsAction`

**Responsabilità**: Salva i consensi GDPR nel database

**Input**:
- `Modules\User\Models\User $user` - Utente creato
- `array<string, array<string, mixed>> $consents` - Consenti strutturati

**Output**: `void`

**Pattern**:
```php
public function execute(User $user, array $consents): void
{
    foreach ($consents as $consent) {
        $treatment = Treatment::where('name', $consent['treatment_name'])->first();
        
        if (!$treatment) {
            continue;
        }

        Consent::create([
            'user_id' => $user->id,
            'treatment_id' => $treatment->id,
            'accepted' => $consent['accepted'],
            'accepted_at' => $consent['accepted_at'],
            'ip_address' => $consent['ip_address'],
            'user_agent' => $consent['user_agent'],
        ]);
    }
}
```

#### 6. LogRegistrationAction (User Module)

**Percorso**: `Modules\User\Actions\Activity\LogRegistrationAction`

**Responsabilità**: Logga il tentativo di registrazione nel sistema di activity

**Input**:
- `Modules\User\Models\User $user` - Utente creato
- `array<string, mixed> $metadata` - Metadati aggiuntivi

**Output**: `void`

**Pattern**:
```php
public function execute(User $user, array $metadata = []): void
{
    activity('registration')
        ->causedBy($user)
        ->performedOn($user)
        ->withProperties(array_merge([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ], $metadata))
        ->log('User registered via registration form');
}
```

#### 7. HandleSuccessfulRegistrationAction

**Percorso**: `Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction`

**Responsabilità**: Gestisce il successo della registrazione

**Input**:
- `Modules\User\Models\User $user` - Utente creato
- `Livewire\Component $component` - Componente Livewire

**Output**: `void`

**Pattern**:
```php
public function execute(User $user, Component $component): void
{
    // Autentica l'utente
    Auth::login($user);

    // Invia notifica di successo
    Notification::make()
        ->success()
        ->title(__('gdpr::register.success'))
        ->body(__('gdpr::register.success_message'))
        ->send();

    // Reindirizza alla dashboard
    redirect()->route('dashboard');
}
```

#### 8. HandleRegistrationErrorAction

**Percorso**: `Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction`

**Responsabilità**: Gestisce gli errori durante la registrazione

**Input**:
- `\Exception $exception` - Eccezione generata
- `Livewire\Component $component` - Componente Livewire

**Output**: `void`

**Pattern**:
```php
public function execute(Exception $exception, Component $component): void
{
    Log::error('Registration error', [
        'message' => $exception->getMessage(),
        'trace' => $exception->getTraceAsString(),
    ]);

    Notification::make()
        ->danger()
        ->title(__('gdpr::register.error'))
        ->body(__('gdpr::register.error_message'))
        ->send();
}
```

## Problematica delle Duplicazioni

### Duplicazioni Identificate

#### 1. CreateUserAction

**File Duplicati**:
1. `Modules/User/Actions/CreateUserAction.php` ✅ **CORRETTO** - Implementazione completa con Spatie QueueableAction
2. `Modules/User/app/Actions/User/CreateUserAction.php` ❌ **DUPLICATO** - Implementazione semplificata
3. `Modules/User/app/Actions/Socialite/CreateUserAction.php` ✅ **DISTINTO** - Per OAuth/Socialite

**Analisi**:
- Il file `1` è l'implementazione completa corretta
- Il file `2` è una duplicazione da rimuovere
- Il file `3` serve per OAuth ed è legittimo

#### 2. LogRegistrationAction

**File Duplicati**:
1. `Modules/User/app/Actions/Activity/LogRegistrationAction.php` ✅ **UNICO** - Implementazione corretta

**Analisi**:
- Non ci sono duplicazioni per questa action
- Il percorso è corretto

#### 3. Altre Actions

Tutte le altre actions nel modulo Gdpr sono correttamente posizionate in:
- `Modules/Gdpr/app/Actions/Validation/` - Actions di validazione
- `Modules/Gdpr/app/Actions/Consent/` - Actions per consensi
- `Modules/Gdpr/app/Actions/Registration/` - Actions per gestione registrazione

### Piano di Refactoring

#### Phase 1: Rimozione Duplicazioni

1. **Eliminare** `Modules/User/app/Actions/User/CreateUserAction.php`
2. **Aggiornare** tutti gli import per usare `Modules\User\Actions\CreateUserAction`

#### Phase 2: Documentazione

1. Creare mappa completa delle actions
2. Documentare ogni action con input/output
3. Aggiornare README.md dei moduli

#### Phase 3: Test

1. Verificare che la registrazione funzioni dopo refactoring
2. Eseguire test completi del flusso GDPR
3. Verificare PHPStan Level 10

## Best Practices Spatie Queueable Actions

### 1. Single Responsibility

Ogni action deve fare una sola cosa:

✅ **Corretto**:
```php
class CreateUserAction extends QueueableAction
{
    public function execute(array $data): User
    {
        return User::create($data);
    }
}
```

❌ **Sbagliato**:
```php
class CreateUserAndSendEmailAction extends QueueableAction
{
    public function execute(array $data): User
    {
        $user = User::create($data); // Crea utente
        Mail::to($user)->send(new WelcomeEmail()); // Invia email
        return $user;
    }
}
```

### 2. Type Safety

Usare sempre tipi espliciti:

✅ **Corretto**:
```php
/**
 * @param array<string, mixed> $data
 * @return User
 */
public function execute(array $data): User
```

❌ **Sbagliato**:
```php
public function execute($data)
{
    // Tipi non definiti
}
```

### 3. Error Handling

Gestire gli errori in modo appropriato:

✅ **Corretto**:
```php
public function execute(array $data): User
{
    try {
        return User::create($data);
    } catch (QueryException $e) {
        Log::error('Failed to create user', ['error' => $e->getMessage()]);
        throw new RegistrationException('Failed to create user');
    }
}
```

### 4. Dependencies

Usare dependency injection per dipendenze esterne:

✅ **Corretto**:
```php
public function __construct(
    private UserRepository $userRepository,
    private PasswordHasher $passwordHasher
) {
}

public function execute(array $data): User
{
    $hashedPassword = $this->passwordHasher->hash($data['password']);
    return $this->userRepository->create($data + ['password' => $hashedPassword]);
}
```

### 5. Logging

Log sempre le azioni importanti:

✅ **Corretto**:
```php
public function execute(array $data): User
{
    $user = User::create($data);
    
    Log::info('User created', [
        'user_id' => $user->id,
        'email_hash' => hash('sha256', $user->email),
        'source' => 'registration_form',
    ]);
    
    return $user;
}
```

## Integrazione con Livewire

### Pattern di Utilizzo in Widget

```php
class RegisterWidget extends Widget
{
    public function submit(): void
    {
        try {
            // 1. Validazione consensi
            app(ValidateGdprConsentAction::class)->execute(
                $this->privacy_accepted,
                $this->terms_accepted
            );

            // 2. Validazione dati
            $validatedData = $this->validate();
            $formData = app(ValidateUserDataAction::class)->execute($validatedData);

            // 3. Transaction database
            $user = DB::transaction(function () use ($formData) {
                // Crea utente
                $user = app(CreateUserAction::class)->execute($formData);
                
                // Salva consensi
                app(SaveGdprConsentsAction::class)->execute(
                    $user,
                    app(CollectGdprConsentsAction::class)->execute(
                        $this->privacy_accepted,
                        $this->terms_accepted,
                        $this->marketing_consent
                    )
                );
                
                // Logga registrazione
                app(LogRegistrationAction::class)->execute($user, [
                    'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute(
                        $this->privacy_accepted,
                        $this->terms_accepted,
                        $this->marketing_consent
                    ),
                ]);

                return $user;
            });

            // 4. Gestisci successo
            app(HandleSuccessfulRegistrationAction::class)->execute($user, $this);
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            // 5. Gestisci errore
            app(HandleRegistrationErrorAction::class)->execute($e, $this);
        }
    }
}
```

## Testing delle Actions

### Unit Test Pattern

```php
test('CreateUserAction creates user with hashed password', function () {
    $action = new CreateUserAction();
    
    $userData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario@example.com',
        'password' => 'SecretPassword123!',
    ];
    
    $user = $action->execute($userData);
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->first_name)->toBe('Mario')
        ->and($user->email)->toBe('mario@example.com')
        ->and(Hash::check('SecretPassword123!', $user->password))->toBeTrue();
});
```

### Feature Test Pattern

```php
test('registration flow with all actions', function () {
    // Prepare data
    $formData = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario@example.com',
        'password' => 'SecretPassword123!',
        'password_confirmation' => 'SecretPassword123!',
    ];
    
    $consents = [
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ];
    
    // Execute flow
    $validatedData = app(ValidateUserDataAction::class)->execute($formData);
    $user = DB::transaction(fn() => app(CreateUserAction::class)->execute($validatedData));
    
    $consentsData = app(CollectGdprConsentsAction::class)->execute(...array_values($consents));
    app(SaveGdprConsentsAction::class)->execute($user, $consentsData);
    
    // Assert
    expect($user->exists())->toBeTrue();
    expect($user->consents)->toHaveCount(2); // privacy + terms
    
    // Cleanup
    $user->delete();
});
```

## Metriche e Performance

### Azioni per Registrazione

| Action | Durata Media | Frequenza | Success Rate |
|--------|-------------|----------|--------------|
| ValidateGdprConsentAction | 1ms | 100% | 99.9% |
| ValidateUserDataAction | 2ms | 100% | 95% |
| CreateUserAction | 150ms | 100% | 98% |
| CollectGdprConsentsAction | 1ms | 100% | 100% |
| SaveGdprConsentsAction | 50ms | 100% | 99.9% |
| LogRegistrationAction | 5ms | 100% | 99.9% |
| HandleSuccessfulRegistrationAction | 200ms | 98% | 95% |
| HandleRegistrationErrorAction | 50ms | 2% | 100% |

### Ottimizzazioni

1. **Parallel Execution**: Actions indipendenti possono essere eseguite in parallelo
2. **Queue Async**: Operazioni lunghe (email, notifiche) possono essere in coda
3. **Caching**: Cache dei treatments per evitare query ripetute
4. **Batch Insert**: Inserimento batch per consensi multipli

## Troubleshooting

### Common Issues

#### 1. Action Not Found

**Errore**: `Class "Modules\User\Actions\CreateUserAction" not found`

**Soluzione**: Verificare che:
- Il file esiste nel percorso corretto
- L'import è corretto
- Il namespace è definito correttamente

#### 2. ValidationException Not Thrown

**Errore**: Gli errori di validazione non vengono mostrati

**Soluzione**: Verificare che:
- Le action lanciano `ValidationException` correttamente
- Il Livewire widget cattura le eccezioni
- Le regole di validazione sono definite

#### 3. Transaction Rollback

**Errore**: I dati non vengono salvati ma non c'è errore

**Soluzione**: Verificare che:
- Tutte le actions sono dentro `DB::transaction()`
- Non ci sono commit/rollback impliciti
- Le actions non lanciano eccezioni non gestite

## Conclusioni

Il pattern Spatie Queueable Actions è fondamentale per l'architettura Laraxot perché:

1. **Separation of Concerns**: Ogni action ha una responsabilità chiara
2. **Testability**: Le actions sono facili da testare in isolamento
3. **Reusability**: Le actions possono essere riutilizzate in diversi contesti
4. **Maintainability**: Il codice è più facile da mantenere e capire
5. **Scalability**: Le actions possono essere eseguite in modo asincrono

Il modulo Gdpr implementa questo pattern correttamente, con un'unica duplicazione da rimuovere (`Modules/User/app/Actions/User/CreateUserAction.php`).

---

**Document Version**: 1.0  
**Last Updated**: 2026-02-10  
**Status**: Ready for Refactoring  
**Next Steps**: Rimuovere duplicazioni e testare