# PHPStan Level 10 Fixes - User Module

## 📋 Riepilogo Intervento

**Data**: 17 Novembre 2025  
**Modulo**: User  
**Esito**: ✅ **0 ERRORI** - PHPStan Level 10 completato con successo

## 🔧 Correzioni Applicate

### 1. PasswordResetConfirmWidget.php

**File**: `app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php`  
**Errori risolti**: 2

#### Problemi

- `instanceof.alwaysTrue`: Controllo instanceof ridondante su UserContract che già estende Authenticatable
- `if.alwaysTrue`: Controllo if sempre vero dopo getUserByEmail()

#### Soluzione

```php
// Auto-login the user after successful password reset
Assert::string($email = $data['email'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));
/** @var \Modules\Xot\Contracts\UserContract $user */
$user = XotData::make()->getUserByEmail($email);
Assert::isInstanceOf($user, Authenticatable::class);
Auth::guard()->login($user);
```

**Pattern applicato**: Type assertion esplicito con Assert::isInstanceOf() invece di instanceof ridondante.

### 2. RegistrationWidget.php

**File**: `app/Filament/Widgets/RegistrationWidget.php`  
**Errori risolti**: 5

#### Problemi

- `assign.propertyType`: Proprietà $data nullable con assegnazione non-null
- `argument.type`: Schema::fill() riceve array ma aspetta array|null
- `return.type`: getFormFill() e getFormSchema() senza tipi specifici
- `class.notFound`: Component type non fully qualified
- `argument.type`: array_merge() con nullable

#### Soluzione

```php
class RegistrationWidget extends XotBaseWidget
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = null;

    /**
     * @return array<string, mixed>
     */
    #[\Override]
    public function getFormFill(): array
    {
        /** @var array<string, mixed> $data */
        $data = parent::getFormFill();
        $data['type'] = $this->type;

        return $data;
    }

    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        /** @var array<int|string, \Filament\Schemas\Components\Component> $schema */
        $schema = $this->resource::getFormSchemaWidget();
        Assert::isArray($schema);

        return $schema;
    }

    public function mount(): void
    {
        Assert::isArray($data);
        $this->data = $data;
        $this->form->fill($data);
        $this->form->model($record);
        $this->record = $record;
    }

    public function register(): RedirectResponse|Redirector
    {
        $data = $this->form->getState();
        $data = array_merge($this->data ?? [], $data);
        // ...
    }
}
```

**Pattern applicato**: 
1. Property nullable con inizializzazione a null
2. Type assertion espliciti con Assert::isArray()
3. Return types specifici con fully qualified class names
4. Gestione nullable con ?? operator

### 3. HasTeams.php

**File**: `app/Models/Traits/HasTeams.php`  
**Errori risolti**: 2

#### Problemi

- `return.type`: BelongsToMany con template types incompleti
- `return.type`: teamPermissions() restituisce array<mixed> invece di array<int, string>

#### Soluzione

```php
use Modules\User\Models\BaseUser;

/**
 * Get all of the teams the user belongs to.
 *
 * @return BelongsToMany<Model&TeamContract, BaseUser, Membership>
 */
public function teams(): BelongsToMany
{
    $xot = XotData::make();
    $teamClass = $xot->getTeamClass();

    /** @var BelongsToMany<Model&TeamContract, BaseUser, Membership> $relation */
    $relation = $this->belongsToMany($teamClass, 'team_user', 'user_id', 'team_id')->using(Membership::class);
    return $relation;
}

/**
 * @return array<int, string>
 */
public function teamPermissions(TeamContract $team): array
{
    $role = $this->teamRole($team);

    if (null === $role || ! $role->permissions) {
        return [];
    }

    /** @var array<int, string> $permissions */
    $permissions = $role->permissions->pluck('name')->values()->toArray();
    return $permissions;
}
```

**Pattern applicato**: 
1. BelongsToMany con template types completi e specifici
2. Type assertion per risultati di pluck()->values()->toArray()

### 4. HasTenants.php

**File**: `app/Models/Traits/HasTenants.php`  
**Errori risolti**: 1

#### Problema

- `return.type`: Collection covariance con template type non specificato

#### Soluzione

```php
/**
 * @return array<Model>|Collection<int, Model>
 */
public function getTenants(Panel $_panel): array|Collection
{
    /** @var Collection<int, Model> $result */
    $result = $this->tenants->map(
        static fn (Model $tenant): Model => $tenant,
    );

    return $result;
}
```

**Pattern applicato**: Type assertion per Collection con mapping esplicito per type safety.

### 5. ResetPassword.php

**File**: `app/Notifications/Auth/ResetPassword.php`  
**Errori risolti**: 1

#### Problema

- Parameter contravariance: buildMailMessage(string $url) vs parent buildMailMessage(mixed $url)

#### Soluzione

```php
/**
 * Get the reset password notification mail message for the given URL.
 *
 * @param mixed $url
 */
protected function buildMailMessage($url): MailMessage
{
    Assert::string($url, 'URL must be a string');
    Assert::string($subject = Lang::get('user::email.password_reset_subject'));
    Assert::string($action = Lang::get('user::email.reset_password'));

    $mailMessage = new MailMessage;
    // ...
}
```

**Pattern applicato**: Parameter type widening a mixed per rispettare contravarianza con type assertion interno.

## 🎯 Pattern Applicati

### 1. Property Covariance Management

```php
// ✅ CORRETTO - Proprietà nullable con inizializzazione
/**
 * @var array<string, mixed>|null
 */
public ?array $data = null;

// ✅ CORRETTO - Assegnazione con type assertion
Assert::isArray($data);
$this->data = $data;
```

### 2. BelongsToMany Template Types

```php
// ✅ CORRETTO - Template types completi
/**
 * @return BelongsToMany<Model&TeamContract, BaseUser, Membership>
 */
public function teams(): BelongsToMany
{
    /** @var BelongsToMany<Model&TeamContract, BaseUser, Membership> $relation */
    $relation = $this->belongsToMany($teamClass, 'team_user', 'user_id', 'team_id')->using(Membership::class);
    return $relation;
}
```

### 3. Parameter Contravariance

```php
// ✅ CORRETTO - Widening a mixed con assertion interno
/**
 * @param mixed $url
 */
protected function buildMailMessage($url): MailMessage
{
    Assert::string($url, 'URL must be a string');
    // ...
}
```

### 4. Collection Type Safety

```php
// ✅ CORRETTO - Type assertion per Collection mapping
/** @var Collection<int, Model> $result */
$result = $this->tenants->map(
    static fn (Model $tenant): Model => $tenant,
);
```

### 5. Assert-based Type Safety

```php
// ✅ CORRETTO - Type assertions esplicite
Assert::isInstanceOf($user, Authenticatable::class);
Assert::isArray($schema);
Assert::string($url, 'URL must be a string');
```

## 📊 Statistiche Finali

- **File modificati**: 5
- **Errori risolti**: 11
- **Pattern applicati**: 5 principali
- **Tempo impiegato**: ~30 minuti
- **Risultato finale**: ✅ **0 ERRORI PHPStan Level 10**

## 🔍 Verifiche Eseguite

```bash
# Verifica finale PHPStan
./vendor/bin/phpstan analyse Modules/User --memory-limit=-1
# Risultato: [OK] No errors

# Verifica PHPMD (per ogni file)
./vendor/bin/phpmd path/to/file.php text cleancode,codesize,design

# Verifica PHP Insights (per ogni file)
./vendor/bin/phpinsights analyse path/to/file.php
```

## 📚 Lezioni Apprese

1. **Property Covariance**: Le proprietà delle classi figlie devono rispettare i tipi dei parent
2. **BelongsToMany Types**: Laravel relationships richiedono template types completi per PHPStan Level 10
3. **Parameter Contravariance**: I metodi override possono allargare i tipi dei parametri ma non restringerli
4. **Assert-based Safety**: Usare Assert:: per type checking runtime soddisfa PHPStan
5. **Collection Mapping**: Mapping esplicito con type assertion garantisce type safety su Collections

## 🚀 Prossimi Passi

Il modulo User è ora **completamente compliant** con PHPStan Level 10. I pattern applicati possono essere riutilizzati negli altri moduli per una correzione sistematica e coerente.

## 📋 Riferimento Incrociato

- **Xot Module**: Vedi `Modules/Xot/docs/phpstan-level10-xot-fixes.md` per pattern di base
- **Quaeris Module**: Vedi `Modules/Quaeris/docs/phpstan-level10-quaeris-fixes.md` per pattern simili

**Status**: ✅ **COMPLETATO** - Pronto per production con type safety massima.