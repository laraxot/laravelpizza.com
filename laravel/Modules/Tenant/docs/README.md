# Modulo Tenant - Multi-Tenancy

## Overview

Il modulo **Tenant** implementa l'architettura multi-tenant per isolamento completo dei dati tra diversi tenant/organizzazioni.

## Architettura Multi-Tenant

### Approccio: Database-per-Tenant

Ogni tenant ha il proprio database isolato con naming convenzioni standardizzate.

### Modelli Principali

```php
// Tenant model
Modules\Tenant\Models\Tenant

// TenantUser pivot
Modules\Tenant\Models\TenantUser

// BaseModel con scope tenant
Modules\Tenant\Models\BaseModel extends XotBaseModel
```

## Configurazione Database

### Connessioni Dinamiche

```php
// TenantServiceProvider gestisce switch automatico
Tenant::configureConnection($tenantId);
```

### Migrations

- Migrations tenant-specifiche in `database/migrations/tenant/`
- Override `XotBaseMigration` per context switching

## Filament Integration

```php
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->tenant(Tenant::class)
            ->tenantRoutePrefix('admin');
    }
}
```

## Trait HasTenants

```php
use Modules\User\Models\Traits\HasTenants;

class User extends Authenticatable
{
    use HasTenants;
}
```

## Collegamenti

- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)
- [Database Switching](./database-switching.md)

## Backlinks

- [Configurazione Root](../../../docs/TENANT_MODULE.md)
