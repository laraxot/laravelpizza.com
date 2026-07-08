# User Module Traits

## HasTeams

Gestisce l'appartenenza a team multipli.

```php
use Modules\User\Models\Traits\HasTeams;

class User extends Authenticatable
{
    use HasTeams;
}
```

## HasTenants

Gestione multi-tenant Filament.

```php
use Modules\User\Models\Traits\HasTenants;

class User extends Authenticatable
{
    use HasTenants;
}
```

## HasAuthenticationLogTrait

Logging autenticazioni.

```php
use Modules\User\Models\Traits\HasAuthenticationLogTrait;

class User extends Authenticatable
{
    use HasAuthenticationLogTrait;
}
```

## Collegamenti

- [Modulo User](./README.md)
- [Xot Traits](../../Xot/docs/)
