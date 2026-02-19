# Filament 5.x Multi-Tenancy - Guida Completa

**Data Creazione:** Gennaio 2026  
**Versione Filament:** 5.x  
**Fonte:** [Documentazione Ufficiale Filament 5.x](https://filamentphp.com/docs/5.x/users/tenancy)  
**Status:** Production Ready

---

## 📋 Indice

1. [Introduzione](#introduzione)
2. [Architettura Tenancy in Laraxot](#architettura-tenancy-in-laraxot)
3. [Configurazione Base](#configurazione-base)
4. [Implementazione User Model](#implementazione-user-model)
5. [Configurazione Panel](#configurazione-panel)
6. [Tenant Registration](#tenant-registration)
7. [Tenant Profile](#tenant-profile)
8. [Accesso al Tenant Corrente](#accesso-al-tenant-corrente)
9. [Scoping Automatico](#scoping-automatico)
10. [Sicurezza](#sicurezza)
11. [Best Practices](#best-practices)
12. [Troubleshooting](#troubleshooting)

---

## Introduzione

Multi-tenancy è un concetto dove una singola istanza dell'applicazione serve più clienti. Ogni cliente ha i propri dati e regole di accesso che impediscono di visualizzare o modificare i dati degli altri.

**⚠️ IMPORTANTE**: Filament non fornisce garanzie sulla sicurezza della tua applicazione. È tua responsabilità assicurarti che l'applicazione sia sicura.

---

## Architettura Tenancy in Laraxot

### Modello Tenant

Il progetto utilizza il modello `Tenant` dal modulo `User`:

```php
// Modules/User/app/Models/Tenant.php
class Tenant extends BaseTenant
{
    // Implementazione tenant
}
```

### Trait HasTenants

Gli utenti implementano il trait `HasTenants` per gestire la relazione many-to-many con i tenant:

```php
// Modules/User/app/Models/Traits/HasTenants.php
trait HasTenants
{
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->tenants()->whereKey($tenant)->exists();
    }

    public function getTenants(Panel $_panel): array|Collection
    {
        return $this->tenants;
    }

    public function tenants(): BelongsToMany
    {
        $tenant_class = XotData::make()->getTenantClass();
        return $this->belongsToManyX($tenant_class);
    }
}
```

### Trait InteractsWithTenant

I modelli che appartengono a un tenant utilizzano il trait `InteractsWithTenant`:

```php
// Modules/User/app/Models/Traits/InteractsWithTenant.php
trait InteractsWithTenant
{
    public function tenant(): BelongsTo
    {
        $tenant = $this->getTenant();
        if (null === $tenant) {
            $this->loadTenantFromSession();
            $tenant = $this->getTenant();
        }

        $tenantClass = config('tenant.tenant_model', Tenant::class);
        return $this->belongsTo($tenantClass, 'tenant_id');
    }

    protected static function bootInteractsWithTenant(): void
    {
        static::addGlobalScope(new TenantScope());
    }
}
```

---

## Configurazione Base

### 1. Configurazione Panel

La configurazione del tenant viene applicata tramite `ApplyTenancyToPanelAction`:

```php
// Modules/Xot/app/Actions/Panel/ApplyTenancyToPanelAction.php
class ApplyTenancyToPanelAction
{
    public function execute(Panel &$panel): Panel
    {
        $tenant_class = XotData::make()->getTenantClass();

        $panel
            ->tenant($tenant_class, 'slug', 'tenants')
            ->tenantRegistration(RegisterTenant::class)
            ->tenantProfile(EditTenantProfile::class);

        return $panel;
    }
}
```

**Parametri `tenant()`**:
- `$tenant_class`: Classe del modello tenant
- `'slug'`: Attributo slug per URL (opzionale)
- `'tenants'`: Nome relazione sul modello User (opzionale)

### 2. Configurazione Ownership Relationship

Per personalizzare il nome della relazione di ownership:

```php
// Configurazione globale
$panel->tenant(Team::class, ownershipRelationship: 'owner');

// Configurazione per singola resource
class PostResource extends XotBaseResource
{
    protected static ?string $tenantOwnershipRelationshipName = 'owner';
}
```

### 3. Configurazione Resource Relationship

Per personalizzare il nome della relazione sul tenant:

```php
class PostResource extends XotBaseResource
{
    protected static ?string $tenantRelationshipName = 'blogPosts';
}
```

---

## Implementazione User Model

### Interfaccia HasTenants

Il modello User deve implementare `Filament\Models\Contracts\HasTenants`:

```php
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasTenants;

    public function tenants(): BelongsToMany
    {
        $tenant_class = XotData::make()->getTenantClass();
        return $this->belongsToManyX($tenant_class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->tenants;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->tenants()->whereKey($tenant)->exists();
    }
}
```

### Metodo getDefaultTenant

Per impostare il tenant predefinito al login:

```php
use Filament\Models\Contracts\HasDefaultTenant;

class User extends Authenticatable implements HasDefaultTenant
{
    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->latestTeam;
    }

    public function latestTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'latest_team_id');
    }
}
```

---

## Configurazione Panel

### Applicazione Tenancy

La tenancy viene applicata automaticamente tramite `XotBasePanelProvider`:

```php
// Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php
protected function panel(Panel $panel): Panel
{
    // Tenancy applicata tramite ApplyTenancyToPanelAction
    app(ApplyTenancyToPanelAction::class)->execute($panel);

    return $panel;
}
```

### Middleware Tenant-Aware

Per applicare middleware aggiuntivi alle route tenant-aware:

```php
$panel->tenantMiddleware([
    ApplyTenantScopes::class,
], isPersistent: true);
```

**Nota**: `isPersistent: true` fa eseguire il middleware anche su richieste Livewire AJAX.

---

## Tenant Registration

### Pagina di Registrazione

La pagina di registrazione tenant estende `Filament\Pages\Tenancy\RegisterTenant`:

```php
// Modules/User/app/Filament/Pages/Tenancy/RegisterTenant.php
class RegisterTenant extends BaseRegisterTenant
{
    use TransTrait;

    public function schema(Schema $schema): Schema
    {
        $resourceClass = $this->resolveResourceClass();
        return $resourceClass::schema($schema);
    }

    protected function handleRegistration(array $data): Model
    {
        $tenantClass = XotData::make()->getTenantClass();
        $tenant = $tenantClass::create($data);
        
        // Associa automaticamente l'utente corrente al tenant
        $tenant->members()->attach(auth()->user());
        
        return $tenant;
    }
}
```

### Personalizzazione Form

Il form viene risolto automaticamente dal Resource del tenant. Per personalizzazioni:

```php
public function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'slug' => TextInput::make('slug')->required(),
        // Altri campi...
    ];
}
```

---

## Tenant Profile

### Pagina Profilo

La pagina profilo tenant estende `Filament\Pages\Tenancy\EditTenantProfile`:

```php
// Modules/User/app/Filament/Pages/Tenancy/EditTenantProfile.php
class EditTenantProfile extends BaseEditTenantProfile
{
    public function schema(Schema $schema): Schema
    {
        $resource = XotData::make()->getTenantResourceClass();
        return $resource::schema($schema);
    }
}
```

---

## Accesso al Tenant Corrente

### Metodo Filament::getTenant()

In qualsiasi punto dell'applicazione:

```php
use Filament\Facades\Filament;

$tenant = Filament::getTenant();
```

### Nel Trait InteractsWithTenant

```php
protected function loadTenantFromSession(): void
{
    try {
        $this->currentTenant = Filament::getTenant();
    } catch (\Throwable $e) {
        $this->currentTenant = null;
    }
}
```

---

## Scoping Automatico

### Global Scope Automatico

Filament applica automaticamente un global scope a tutti i modelli con risorse tenant-aware:

- Le query vengono automaticamente filtrate per il tenant corrente
- I record creati vengono automaticamente associati al tenant corrente
- Tentativi di accesso a record di altri tenant restituiscono 404

### Disabilitare Tenancy per una Resource

```php
class PostResource extends XotBaseResource
{
    protected static bool $isScopedToTenant = false;
}
```

### Disabilitare Tenancy per Tutte le Resources

```php
// In ServiceProvider boot()
use Filament\Resources\Resource;

Resource::scopeToTenant(false);
```

Ora devi opt-in esplicitamente:

```php
class PostResource extends XotBaseResource
{
    protected static bool $isScopedToTenant = true;
}
```

### Applicare Scope Manualmente

Per modelli senza resource:

```php
// Middleware ApplyTenantScopes
class ApplyTenantScopes
{
    public function handle(Request $request, Closure $next)
    {
        Author::addGlobalScope('tenant', fn(Builder $query) => 
            $query->whereBelongsTo(Filament::getTenant())
        );
        
        return $next($request);
    }
}
```

---

## Sicurezza

### Validazione Unique e Exists

Laravel's `unique` e `exists` non usano global scopes. Usa `scopedUnique()` e `scopedExists()`:

```php
use Filament\Forms\Components\TextInput;

TextInput::make('email')
    ->scopedUnique()  // ✅ Usa global scopes
    // oppure
    ->scopedExists()  // ✅ Usa global scopes
```

### Verifica Accesso Tenant

Il metodo `canAccessTenant()` viene chiamato automaticamente da Filament per verificare l'accesso:

```php
public function canAccessTenant(Model $tenant): bool
{
    return $this->tenants()->whereKey($tenant)->exists();
}
```

### Disabilitare Scope Temporaneamente

```php
// Disabilita solo scope tenancy
Model::withoutGlobalScope(filament()->getTenancyScopeName())
    ->get();

// Disabilita tutti gli scope tranne tenancy
Model::withoutGlobalScopes([
    OtherScope::class,
])->get();
```

---

## Best Practices

### 1. Usa Slug invece di ID

```php
$panel->tenant(Team::class, slugAttribute: 'slug');
```

**Vantaggi**:
- URL più leggibili: `/admin/team-acme/posts` invece di `/admin/1/posts`
- SEO friendly
- Più sicuro (non esporre ID interni)

### 2. Implementa HasName per Nome Personalizzato

```php
use Filament\Models\Contracts\HasName;

class Team extends Model implements HasName
{
    public function getFilamentName(): string
    {
        return "{$this->name} ({$this->subscription_plan})";
    }
}
```

### 3. Implementa HasAvatar per Avatar Personalizzato

```php
use Filament\Models\Contracts\HasAvatar;

class Team extends Model implements HasAvatar
{
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
```

### 4. Usa Tenant Menu Items Personalizzati

```php
$panel->tenantMenuItems([
    Action::make('settings')
        ->url(fn(): string => Settings::getUrl())
        ->icon('heroicon-m-cog-8-tooth'),
]);
```

### 5. Middleware Persistente per Scope Aggiuntivi

```php
$panel->tenantMiddleware([
    ApplyTenantScopes::class,
], isPersistent: true);  // ✅ Eseguito anche su AJAX
```

---

## Troubleshooting

### Problema: Record non visibili dopo cambio tenant

**Causa**: Global scope non applicato correttamente.

**Soluzione**: Verifica che la resource sia registrata nel panel con tenancy abilitata.

### Problema: Record creati senza tenant_id

**Causa**: Creazione record prima che il tenant sia identificato.

**Soluzione**: Assicurati che la creazione avvenga dopo il middleware stack del panel.

### Problema: Validazione unique fallisce tra tenant diversi

**Causa**: Uso di `unique` invece di `scopedUnique()`.

**Soluzione**: Usa `scopedUnique()` nei form components.

### Problema: Query non scoped correttamente

**Causa**: Query eseguite prima che il tenant sia identificato.

**Soluzione**: Usa tenant middleware per garantire che il tenant sia disponibile.

---

## Collegamenti Correlati

- [Filament 5.x Nested Resources Complete Guide](filament-5-nested-resources-complete-guide.md)
- [Filament Nesting Best Practices](../filament-nesting-best-practices.md)
- [User Module Tenancy Documentation](../../user/docs/traits/has-tenants.md)
- [Tenant Module Documentation](../../tenant/docs/readme.md)
- [XotBasePanelProvider Documentation](../filament-integration.md)

---

**Ultimo aggiornamento:** Gennaio 2026  
**Versione Filament:** 5.x  
**Compatibilità:** Laravel 12.x, PHP 8.3+
