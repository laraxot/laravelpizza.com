# Trait HasTenants

## Descrizione
Il trait `HasTenants` fornisce funzionalità per la gestione dei tenant nell'applicazione. Permette agli utenti di appartenere a più tenant e gestire le autorizzazioni a livello di tenant.

## Proprietà
- `$tenants`: Collection di tenant a cui l'utente appartiene
- `$ownedTenants`: Collection di tenant di cui l'utente è proprietario

## Metodi Principali

### Relazioni
- `tenants()`: Restituisce la relazione many-to-many con i tenant
- `ownedTenants()`: Restituisce la relazione one-to-many con i tenant posseduti

### Gestione Tenant
- `createTenant(array $input)`: Crea un nuovo tenant
- `updateTenant(Tenant $tenant, array $input)`: Aggiorna un tenant esistente
- `deleteTenant(Tenant $tenant)`: Elimina un tenant

### Verifiche
- `belongsToTenant(Tenant $tenant)`: Verifica se l'utente appartiene al tenant
- `ownsTenant(Tenant $tenant)`: Verifica se l'utente è proprietario del tenant
- `canAccessTenant(Model $tenant)`: Verifica se l'utente può accedere al tenant

### Gestione Membri
- `addTenantMember(Tenant $tenant, string $email, ?string $role)`: Aggiunge un membro al tenant
- `removeTenantMember(Tenant $tenant, int $userId)`: Rimuove un membro dal tenant

### Autorizzazioni
- `canManageTenant(Tenant $tenant)`: Verifica se l'utente può gestire il tenant
- `canUpdateTenant(Tenant $tenant)`: Verifica se l'utente può aggiornare il tenant
- `canDeleteTenant(Tenant $tenant)`: Verifica se l'utente può eliminare il tenant

### Integrazione con Filament
- `getTenants(Panel $panel)`: Restituisce i tenant disponibili per il pannello Filament

## Utilizzo
```php
use Modules\User\Models\Traits\HasTenants;

class User extends Authenticatable
{
    use HasTenants;
    
    // ... resto del codice
}
```

## Note
- Il trait richiede che il modello utilizzi anche il trait `HasRoles` per la gestione dei ruoli
- È necessario avere una tabella pivot `tenant_user` con le colonne `user_id`, `tenant_id`, `role` e `timestamps`
- La tabella dei tenant deve avere le colonne `id`, `name`, `domain`, `settings`, `owner_id` e `timestamps`
- Il trait è integrato con Filament per la gestione dei tenant nel pannello amministrativo 