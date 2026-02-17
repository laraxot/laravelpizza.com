# Correzioni PHPStan per il Modulo User

## Panoramica

Questo documento descrive le correzioni implementate per risolvere gli errori PHPStan livello 9 nel modulo User, riducendo gli errori da migliaia a 94 errori specifici.

## Errori Risolti

### 1. Eventi con Costruttori che Hanno Tipo di Ritorno

**Problema**: Tutti gli eventi del modulo User avevano costruttori con tipo di ritorno `void`, che non è permesso in PHP.

**File Corretti**:
- `app/Events/AddingTeam.php`
- `app/Events/AddingTeamMember.php`
- `app/Events/InvalidState.php`
- `app/Events/InvitingTeamMember.php`
- `app/Events/Login.php`
- `app/Events/NewPasswordSet.php`
- `app/Events/RecoveryCodeReplaced.php`
- `app/Events/RecoveryCodesGenerated.php`
- `app/Events/Registered.php`
- `app/Events/RegistrationNotEnabled.php`
- `app/Events/RemovingTeamMember.php`
- `app/Events/SocialiteUserConnected.php`
- `app/Events/TeamEvent.php`
- `app/Events/TeamMemberAdded.php`
- `app/Events/TeamMemberRemoved.php`
- `app/Events/TeamMemberUpdated.php`
- `app/Events/TeamSwitched.php`
- `app/Events/TwoFactorAuthenticationEvent.php`
- `app/Events/UserNotAllowed.php`

**Correzione**:
```php
// PRIMA (errato)
public function __construct(): void {}

// DOPO (corretto)
public function __construct() {}
```

### 2. PasswordData - Proprietà Mancanti

**Problema**: La classe `PasswordData` estendeva `Spatie\LaravelData\Data` ma non aveva le proprietà definite, causando errori di accesso a proprietà non definite.

**File Corretto**: `app/Datas/PasswordData.php`

**Correzione**:
```php
class PasswordData extends Data
{
    public readonly int $otp_expiration_minutes;
    public readonly int $otp_length;
    public readonly int $expires_in;
    public readonly int $min;
    public readonly bool $mixedCase;
    public readonly bool $letters;
    public readonly bool $numbers;
    public readonly bool $symbols;
    public readonly bool $uncompromised;
    public readonly int $compromisedThreshold;

    public function __construct(
        int $otp_expiration_minutes = 15,
        int $otp_length = 6,
        int $expires_in = 30,
        int $min = 6,
        bool $mixedCase = false,
        bool $letters = false,
        bool $numbers = false,
        bool $symbols = false,
        bool $uncompromised = false,
        int $compromisedThreshold = 1
    ) {
        $this->otp_expiration_minutes = $otp_expiration_minutes;
        $this->otp_length = $otp_length;
        $this->expires_in = $expires_in;
        $this->min = $min;
        $this->mixedCase = $mixedCase;
        $this->letters = $letters;
        $this->numbers = $numbers;
        $this->symbols = $symbols;
        $this->uncompromised = $uncompromised;
        $this->compromisedThreshold = $compromisedThreshold;
    }
}
```

**Modifiche ai Metodi**:
- Rimosso il metodo `setFieldName()` (incompatibile con proprietà readonly)
- Modificato `getPasswordConfirmationFormComponent()` per accettare `$field_name` come parametro
- Aggiornato `getPasswordFormComponents()` per passare il parametro correttamente

### 3. Actions Socialite - Proprietà Readonly

**Problema**: Le classi `GetUserModelAttributesFromSocialiteAction` e `UserNameFieldsResolver` avevano proprietà readonly ma costruttori senza parametri.

**File Corretti**:
- `app/Actions/Socialite/GetUserModelAttributesFromSocialiteAction.php`
- `app/Actions/Socialite/Utils/UserNameFieldsResolver.php`

**Correzione**:
```php
// GetUserModelAttributesFromSocialiteAction
public function __construct(
    private readonly SocialiteUserContract $oauthUser,
    string $provider
) {
    // Inizializzazione delle proprietà readonly
}

// UserNameFieldsResolver
public function __construct(User $user) {
    $this->name = $this->resolveName($user);
    $this->first_name = $this->resolveName($user);
    $this->last_name = $this->resolveSurname($user);
}
```

## Test di Validazione

È stato creato un test completo in `tests/Unit/UserModulePhpstanFixesTest.php` che valida:

1. **PasswordData**:
   - Istanziazione con valori di default
   - Configurazione con valori personalizzati
   - Funzionamento dei metodi `getPasswordRule()` e `getHelperText()`
   - Esistenza dei metodi per i componenti form

2. **Eventi**:
   - Istanziazione corretta di tutti gli eventi
   - Presenza del trait `Dispatchable`

3. **Metodi Statici**:
   - Esistenza dei metodi statici `make()` e `getFormSchema()`

## Risultati

- **Prima**: Migliaia di errori PHPStan
- **Dopo**: 94 errori specifici rimanenti
- **Riduzione**: Circa 95% degli errori risolti

## Errori Rimanenti

Gli errori rimanenti (94) sono principalmente:
- Listeners con parametri non definiti
- Modelli con costruttori che hanno tipo di ritorno
- Problemi di tipizzazione nei widget Filament
- Eventi con parametri non corretti

## Collegamenti

- [Test di Validazione](../../tests/Unit/UserModulePhpstanFixesTest.php)
- [Configurazione Password](../../config/password.php)
- [Documentazione Root](../../../docs/user-module-phpstan-fixes.md)

## Note per il Futuro

1. **Eventi**: Non aggiungere mai tipo di ritorno ai costruttori degli eventi
2. **Data Classes**: Definire sempre tutte le proprietà readonly nel costruttore
3. **Actions**: Usare proprietà readonly solo quando necessario e inizializzarle correttamente
4. **Test**: Creare sempre test di validazione per le correzioni PHPStan

*Ultimo aggiornamento: dicembre 2024*
