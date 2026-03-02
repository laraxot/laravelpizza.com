# Regole Anti-Ridondanza per XotBase Classes

## Principio Fondamentale: DRY (Don't Repeat Yourself)

Le classi base Xot forniscono già tutte le funzionalità necessarie. Aggiungere trait o implementazioni già presenti nella classe base è **ridondante** e viola il principio DRY.

## ❌ Ridondanze Comuni da Evitare

### 1. HasXotTable in RelationManager

**ERRORE**: Aggiungere `use HasXotTable;` in un RelationManager che estende `XotBaseRelationManager`.

```php
// ❌ ERRATO - RIDONDANTE
namespace Modules\User\Filament\Resources\SsoProviderResource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\Xot\Filament\Traits\HasXotTable; // ❌ RIDONDANTE!

class UsersRelationManager extends XotBaseRelationManager
{
    use HasXotTable; // ❌ XotBaseRelationManager già include HasXotTable!
}
```

**CORRETTO**:

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Resources\SsoProviderResource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class UsersRelationManager extends XotBaseRelationManager
{
    // HasXotTable è già incluso in XotBaseRelationManager
    // Non serve aggiungerlo!
}
```

**Motivazione**: `XotBaseRelationManager` già include `HasXotTable` alla riga 32. Aggiungerlo nuovamente è ridondante e può causare conflitti.

### 2. Passport Configuration in UserServiceProvider

**ERRORE**: Registrare policies o configurare Passport in `UserServiceProvider` quando esiste già `PassportServiceProvider`.

```php
// ❌ ERRATO - RIDONDANTE
namespace Modules\User\Providers;

class UserServiceProvider extends XotBaseServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        $this->registerPolicies(); // ❌ Policy di Passport qui!
    }

    protected function registerPolicies(): void
    {
        Gate::policy(OauthClient::class, OauthClientPolicy::class); // ❌ Passport!
    }
}
```

**CORRETTO**:

```php
// ✅ CORRETTO - UserServiceProvider
namespace Modules\User\Providers;

class UserServiceProvider extends XotBaseServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        // ✅ SOLO configurazione core del modulo User
        $this->registerPasswordRules();
        $this->registerPulse();
        $this->registerMailsNotification();
        // ❌ NO policies di Passport qui!
    }
}
```

```php
// ✅ CORRETTO - PassportServiceProvider
namespace Modules\User\Providers;

class PassportServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRoutes();
        $this->configureTokenExpiration();
        $this->configureModels();
        $this->configurePasswordGrant();
        $this->configureScopes();
        $this->registerPolicies(); // ✅ Policy di Passport qui!
    }

    protected function registerPolicies(): void
    {
        Gate::policy(OauthClient::class, OauthClientPolicy::class);
    }
}
```

**Motivazione**: 
- `PassportServiceProvider` è registrato in `module.json` e ha la responsabilità unica di configurare Passport
- `UserServiceProvider` deve occuparsi SOLO della configurazione core del modulo User
- Separation of Concerns: ogni provider ha una responsabilità ben definita

## 📋 Checklist Anti-Ridondanza

Prima di aggiungere un trait o una configurazione, verifica:

- [ ] La classe base già include questo trait?
- [ ] Esiste già un ServiceProvider dedicato per questa funzionalità?
- [ ] La configurazione è già gestita da un provider registrato in `module.json`?
- [ ] Sto violando il principio DRY?

## 🔍 Come Verificare

### Verificare Trait nella Classe Base

```bash
# Cerca il trait nella classe base
grep -r "use HasXotTable" laravel/Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php
```

### Verificare Provider Registration

```bash
# Verifica se un provider è già registrato in module.json
grep -r "PassportServiceProvider" laravel/Modules/User/module.json
```

## 📚 Collegamenti

- [XotBaseRelationManager Documentation](./relation-managers.md)
- [Service Provider Architecture](../../user/docs/service_provider_architecture.md)
- [DRY Principle](../../../../../docs/dry-kiss-principles.md)

