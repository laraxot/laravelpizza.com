# PHPStan Array Types Fixes - Modulo User

## 🚨 REGOLA CRITICA RISPETTATA 🚨

**NON è stato modificato** `phpstan.neon`
**NON è stato modificato** `phpstan.neon`

## Problema Identificato

Il modulo User presenta numerosi errori PHPStan `missingType.iterableValue` per parametri e proprietà di tipo `array` senza specificazione del tipo degli elementi contenuti.

## Errori Identificati per Categoria

### 1. **Console Commands** (3 errori)
- `RemoveRoleCommand.php` - `getOptions()` return type
- `SetCurrentTeamCommand.php` - `getOptions()` return type  
- `SuperAdminCommand.php` - `getOptions()` return type

### 2. **Contracts** (14 errori)
- `CreatesNewUsers.php` - parametro `$input`
- `CreatesTeams.php` - parametro `$input`
- `HasTeamsContract.php` - return type `teamPermissions()`
- `PassportHasApiTokensContract.php` - parametro `$scopes`
- `ResetsUserPasswords.php` - parametro `$input`
- `TeamContract.php` - parametro `$with`
- `TwoFactorAuthenticatableContract.php` - return type `recoveryCodes()`
- `UpdatesTeamNames.php` - parametro `$input`
- `UpdatesUserPasswords.php` - parametro `$input`
- `UpdatesUserProfileInformation.php` - parametro `$input`
- `UserContract.php` - parametro `$roles`

### 3. **Datas/DTOs** (3 errori)
- `PasswordData.php` - return type `getFormSchema()`
- `SocialProviderData.php` - proprietà `$scopes`, `$parameters`

### 4. **Filament Components** (15 errori)
- `Appearance/Pages/*.php` - proprietà `$data`, return types `getUpdateFormActions()`
- `MyProfilePage.php` - proprietà `$profileData`, `$passwordData`, return types
- `RegisterWidget.php` - return types e parametri
- `EditUserWidget.php` - proprietà `$data`
- `RegistrationWidget.php` - return type `getFormFill()`

### 5. **Models** (8 errori)
- `AuthenticationLog.php` - proprietà `$location`
- `BaseProfile.php` - proprietà `$schemalessAttributes`
- `BaseUser.php` - parametro `$roles` in `hasRole()`
- `Device.php` - proprietà `$languages`
- `OauthAccessToken.php` - proprietà `$scopes`
- `OauthClient.php` - proprietà `$grant_types`, `$scopes`
- `Profile.php` - proprietà `$preferences`
- `SocialProvider.php` - proprietà `$parameters`, `$scopes`, `$schema`

### 6. **Altri File** (5 errori)
- `Notifications/Auth/Otp.php` - return types `via()`, `toArray()`
- `Providers/EventServiceProvider.php` - proprietà `$subscribe`
- `Support/Utils.php` - return types vari
- `Http/Livewire/Team/Change.php` - proprietà `$teams`

## Pattern di Correzione Standard

### Console Commands
```php
// PRIMA (errore PHPStan)
public function getOptions(): array

// DOPO (corretto)
/**
 * Get command options.
 *
 * @return array<int, array<string, mixed>>
 */
public function getOptions(): array
```

### Contracts con Input Data
```php
// PRIMA (errore PHPStan)
public function create(array $input): User;

// DOPO (corretto)
/**
 * Create a new user.
 *
 * @param array<string, mixed> $input
 */
public function create(array $input): User;
```

### Filament Data Properties
```php
// PRIMA (errore PHPStan)
public array $data = [];

// DOPO (corretto)
/**
 * Form data.
 *
 * @var array<string, mixed>
 */
public array $data = [];
```

### Model Properties con JSON
```php
// PRIMA (errore PHPStan)
/**
 * @property array $preferences
 */

// DOPO (corretto)
/**
 * @property array<string, mixed> $preferences
 */
```

### Return Types per Form Schema
```php
// PRIMA (errore PHPStan)
public function getFormSchema(): array

// DOPO (corretto)
/**
 * Get form schema.
 *
 * @return array<int, \Filament\Forms\Components\Component>
 */
public function getFormSchema(): array
```

## Soluzioni Specifiche per Tipi Comuni

### 1. **Scopes OAuth/API**
```php
// Tipo corretto per scopes
array<int, string> $scopes
```

### 2. **Form Data Filament**
```php
// Tipo corretto per dati form
array<string, mixed> $data
```

### 3. **Configuration Arrays**
```php
// Tipo corretto per configurazioni
array<string, string|int|bool> $config
```

### 4. **Command Options**
```php
// Tipo corretto per opzioni comandi
array<int, array<string, mixed>> $options
```

### 5. **Model Attributes**
```php
// Tipo corretto per attributi modello
array<string, mixed> $attributes
```

## Priorità di Correzione

### 🚨 **Alta Priorità** (Critici per il framework)
1. **Contracts** - Definiscono interfacce per tutto il sistema
2. **BaseUser.php** - Modello base utilizzato ovunque
3. **Filament Base Classes** - Classi base per UI

### ⚠️ **Media Priorità** 
1. **Console Commands** - Utilizzati per automazione
2. **Datas/DTOs** - Oggetti di trasferimento dati
3. **Widgets Filament** - Componenti UI

### ✅ **Bassa Priorità**
1. **Notifications** - Sistema notifiche
2. **Support Utils** - Utility functions
3. **OAuth Models** - Funzionalità specifiche

## Benefici delle Correzioni

### ✅ **Type Safety**
- Migliore controllo dei tipi a compile-time
- Riduzione errori runtime
- IDE support migliorato

### ✅ **Code Quality**
- PHPStan livello 9+ raggiungibile
- Codice più robusto e manutenibile
- Documentazione migliorata

### ✅ **Developer Experience**
- Autocompletamento IDE migliore
- Refactoring più sicuro
- Debug più facile

## Comando di Verifica

```bash
# Test modulo User completo
./vendor/bin/phpstan analyze Modules/User --level=9

# Test file specifico
./vendor/bin/phpstan analyze Modules/User/app/Path/File.php --level=9

# Conteggio errori rimanenti
./vendor/bin/phpstan analyze Modules/User --level=9 | grep -c "missingType.iterableValue"
```

## Stato Attuale

### ✅ **Completato**
- Identificazione completa di tutti gli errori
- Documentazione pattern di correzione
- Strategia di prioritizzazione

### 🔄 **In Corso**
- Correzione file critici del modulo Xot
- Implementazione pattern standardizzati

### 📋 **Da Fare**
- Correzione sistematica file modulo User
- Test e verifica correzioni
- Aggiornamento documentazione

## Collegamenti

- [Xot - PHPStan Missing Array Types](../Xot/docs/phpstan-missing-array-types-fixes.md)
- [Xot - PHPStan Critical Rules](../Xot/docs/phpstan-critical-rules.md)
- [docs_project - PHPStan Intouchable Rule](../../../docs_project/phpstan-intouchable-rule.md)

---

**Data Analisi**: Gennaio 2025  
**Errori Identificati**: ~45 errori nel modulo User  
**phpstan.neon**: ✅ INTOCCATO  
**Stato**: 📋 Analisi Completata - Pronto per Correzioni
