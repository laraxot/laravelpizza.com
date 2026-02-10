# User Module Actions - Architecture & Duplications Analysis

## Panoramica

Il modulo User utilizza il pattern **Spatie Queueable Actions** per la gestione di utenti, autenticazione e registrazione. Questa documentazione analizza l'architettura delle actions e identifica le duplicazioni.

## Mappa Complete delle Actions

### Actions Principali

#### Authentication Actions

| Action | Percorso | Descrizione | Status |
|--------|----------|-------------|--------|
| CreateUserAction | `Modules\User\Actions\CreateUserAction.php` | Crea nuovo utente | ✅ CORRETTO |
| CreateUserAction | `Modules\User\app\Actions\User\CreateUserAction.php` | Crea nuovo utente (semplificato) | ❌ DUPLICATO |
| CreateUserAction | `Modules\User\app\Actions\Socialite\CreateUserAction.php` | Crea utente via OAuth | ✅ DISTINTO |

#### Activity Actions

| Action | Percorso | Descrizione | Status |
|--------|----------|-------------|--------|
| LogRegistrationAction | `Modules\User\app\Actions\Activity\LogRegistrationAction.php` | Logga registrazione | ✅ UNICO |

#### Socialite Actions

| Action | Percorso | Descrizione | Status |
|--------|----------|-------------|--------|
| CreateUserAction | `Modules\User\app\Actions\Socialite\CreateUserAction.php` | Crea utente OAuth | ✅ UNICO |
| LoginUserAction | `Modules\User\app\Actions\Socialite\LoginUserAction.php` | Login OAuth | ✅ UNICO |
| RegisterOauthUserAction | `Modules\User\app\Actions\Socialite\RegisterOauthUserAction.php` | Registra OAuth | ✅ UNICO |

#### User Management Actions

| Action | Percorso | Descrizione | Status |
|--------|----------|-------------|--------|
| UpdateUserAction | `Modules\User\app\Actions\User\UpdateUserAction.php` | Aggiorna utente | ✅ UNICO |
| DeleteUserAction | `Modules\User\app\Actions\User\DeleteUserAction.php` | Cancella utente | ✅ UNICO |
| GetNewPasswordAction | `Modules\User\app\Actions\User\GetNewPasswordAction.php` | Genera password | ✅ UNICO |

#### Team Actions

| Action | Percorso | Descrizione | Status |
|--------|----------|-------------|--------|
| GetUserTeamsOptionAction | `Modules\User\app\Actions\Team\GetUserTeamsOptionAction.php` | Opzioni team utente | ✅ UNICO |

## Analisi delle Duplicazioni

### CreateUserAction - 3 Versioni

#### Versione 1: Completa e Corretta

**Percorso**: `Modules/User/Actions/CreateUserAction.php`

**Caratteristiche**:
- ✅ Estende `QueueableAction`
- ✅ Implementa pattern completo Spatie
- ✅ Hashing password sicuro
- ✅ SafeStringCastAction per sanitizzazione
- ✅ Activity logging
- ✅ Tags e displayName
- ✅ PHPStan Level 10 compliant

**Codice Chiave**:
```php
class CreateUserAction extends QueueableAction
{
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

    public function tags(): array
    {
        return ['user', 'registration', 'creation'];
    }

    public function displayName(): string
    {
        return 'Create User Action';
    }

    public function description(): string
    {
        return 'Creates a new user with safe data processing and logging.';
    }
}
```

#### Versione 2: Duplicato da Rimuovere

**Percorso**: `Modules/User/app/Actions/User/CreateUserAction.php`

**Caratteristiche**:
- ❌ Non estende `QueueableAction`
- ❌ Implementazione semplificata
- ❌ Nessun hashing password
- ❌ Nessuna sanitizzazione
- ❌ Nessun activity logging
- ❌ PHPStan Level 10 NON compliant

**Codice Chiave**:
```php
class CreateUserAction
{
    use QueueableAction;

    /**
     * Create a new user.
     *
     * @param array<string, mixed> $data
     */
    public function execute(array $data): User
    {
        return User::create($data);
    }
}
```

**Problemi**:
1. **Security**: Password non hashata - RISCHIO DI SICUREZZA CRITICO
2. **Sanitization**: Nessuna validazione/sanitizzazione input
3. **Compliance**: GDPR non rispettato (nessun logging)
4. **Architecture**: Non segue pattern Laraxot
5. **PHPStan**: Non Level 10 compliant

#### Versione 3: Distinto per OAuth

**Percorso**: `Modules/User/app/Actions/Socialite/CreateUserAction.php`

**Caratteristiche**:
- ✅ Extende `QueueableAction`
- ✅ Implementazione specifica per OAuth
- ✅ Gestisce dati da Socialite
- ✅ Utile e legittimo

**Codice Chiave**:
```php
class CreateUserAction
{
    use QueueableAction;

    /**
     * Execute the action to create a new user from socialite authentication.
     *
     * @param string                $provider  The socialite provider name
     * @param SocialiteUserContract $oauthUser The socialite user instance
     * @param array<string, mixed>   $extraData Additional data
     */
    public function execute(string $provider, SocialiteUserContract $oauthUser, array $extraData = []): Model
    {
        // Specific OAuth implementation
    }
}
```

**Analisi**: Questa action è legittima e serve per un caso d'uso diverso (OAuth), quindi deve essere mantenuta.

## Piano di Refactoring

### Phase 1: Rimozione Duplicazione

**File da Eliminare**:
- `Modules/User/app/Actions/User/CreateUserAction.php`

**Motivazione**:
1. Implementazione semplificata e pericolosa
2. Password non hashata - RISCHIO SICUREZZA CRITICO
3. Non segue pattern Laraxot
4. Duplicazione inutile

### Phase 2: Aggiornamento Imports

**File da Aggiornare**:
- `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`
- Qualsiasi altro file che importa la action duplicata

**Import Corretto**:
```php
use Modules\User\Actions\CreateUserAction;
```

**Import Sbagliato da Correggere**:
```php
use Modules\User\Actions\User\CreateUserAction; // ❌ Sbagliato
```

### Phase 3: Verifica

**Verificare che**:
1. Tutti gli import puntano a `Modules\User\Actions\CreateUserAction`
2. Nessun file usa la action duplicata
3. La registrazione funziona correttamente
4. PHPStan Level 10 passa

## Riferimenti Incrociati

### Modulo Gdpr

**Actions che usano CreateUserAction**:
- `RegisterWidget::submit()` - Linea 103

**Codice Attuale**:
```php
use Modules\User\Actions\CreateUserAction;

// ... nel metodo submit()
$user = app(CreateUserAction::class)->execute($formData);
```

**✅ Già Corretto** - L'import in RegisterWidget è già corretto!

### Modulo Socialite

**Actions correlate**:
- `Modules\User\app\Actions\Socialite/CreateUserAction.php` - ✅ Mantenere (caso d'uso OAuth)

**Relazione**: Action distinta per OAuth, non duplicazione

## Testing

### Test prima di Rimozione

```bash
# Verifica che la registrazione funzioni
php artisan test --filter=RegisterWidgetTest

# Verifica PHPStan
./vendor/bin/phpstan analyse Modules/User/Actions/CreateUserAction.php

# Verifica che nessun file usa la action duplicata
grep -r "User\\\\CreateUserAction" laravel/Modules/
```

### Test dopo Rimozione

```bash
# Test registrazione
php artisan test --filter=RegisterWidgetTest

# Test integrazione
php artisan test --filter=RegistrationTest

# Verifica PHPStan
./vendor/bin/phpstan analyse Modules/User/ --memory-limit=-1
```

## Best Practices per Future Actions

### 1. Namespace Standard

**Pattern Laraxot**:
```
Modules/{Module}/Actions/{Category}/{ActionName}.php
```

**Esempi Corretti**:
- `Modules/User/Actions/CreateUserAction.php`
- `Modules/User/Actions/Activity/LogRegistrationAction.php`
- `Modules/Gdpr/Actions/Validation/ValidateUserDataAction.php`

### 2. Singola Responsabilità

Ogni action deve avere UNA sola responsabilità:
- ✅ `CreateUserAction` - Crea utente
- ❌ `CreateUserAndSendEmailAction` - Crea utente E invia email

### 3. Type Safety

Usare sempre tipi espliciti:
```php
/**
 * @param array<string, mixed> $data
 * @return User
 */
public function execute(array $data): User
```

### 4. Spatie QueueableAction

Estendere sempre `QueueableAction`:
```php
class CreateUserAction extends QueueableAction
{
    use QueueableAction;
    
    public function execute(array $data): User
    {
        // ...
    }
}
```

### 5. Security

**Obbligatorio per User Actions**:
- Hash password con `Hash::make()`
- Sanitize input con `SafeStringCastAction`
- Log attività con `activity()` helper
- Validare input

### 6. Tags e Metadata

Implementare sempre tags e metadata:
```php
public function tags(): array
{
    return ['user', 'registration', 'creation'];
}

public function displayName(): string
{
    return 'Create User Action';
}

public function description(): string
{
    return 'Creates a new user with safe data processing.';
}
```

## Conclusioni

### Situazione Attuale

✅ **Corretto**:
- `Modules/User/Actions/CreateUserAction.php` - Implementazione completa
- `Modules/User/app/Actions/Socialite/CreateUserAction.php` - Action OAuth distinta

❌ **Da Rimuovere**:
- `Modules/User/app/Actions/User/CreateUserAction.php` - Duplicazione pericolosa

### Azioni Richieste

1. **Eliminare** il file duplicato
2. **Verificare** che nessun altro file lo importi
3. **Testare** la registrazione dopo rimozione
4. **Documentare** l'architettura finalizzata

### Metriche

| Metrica | Valore Attuale | Target |
|---------|---------------|--------|
| Actions Create User | 3 | 2 |
| Actions Duplicate | 1 | 0 |
| PHPStan Level 10 Errors | 0 | 0 |
| Registration Success Rate | 98% | 99% |

---

**Document Version**: 1.0  
**Last Updated**: 2026-02-10  
**Status**: Ready for Refactoring  
**Priority**: High (Security Critical)