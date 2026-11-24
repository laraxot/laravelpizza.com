# User Module - Spatie Permission Methods Reference

## Overview

Il modulo User utilizza i package **Spatie Permission** che forniscono automaticamente tutti i metodi necessari per la gestione di ruoli e permessi tramite i trait:

- `Spatie\Permission\Traits\HasRoles`
- `Spatie\Permission\Traits\HasPermissions`

## ⚠️ IMPORTANTE: Non Duplicare i Metodi

**BaseUser NON deve sovrascrivere i metodi forniti dai trait Spatie** a meno che non sia necessario un comportamento personalizzato.

### Metodi Rimossi da BaseUser (2025-10-15)

I seguenti metodi sono stati rimossi perché **già forniti dai trait**:

```php
// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function hasRole(...): bool

// ❌ RIMOSSO - Duplicato dal trait HasPermissions
public function hasPermission(string $permission): bool

// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function assignRole(...): static
```

## Metodi Disponibili da Spatie Traits

### A. HasRoles Methods

#### 1. `hasRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha uno o più ruoli specifici.

**Parametri Accettati:**
- `string` - Nome ruolo singolo
- `int` - ID ruolo
- `array` - Array di nomi ruoli
- `Collection` - Collection di ruoli
- `Role` - Oggetto Role

**Esempi:**
```php
// String
$user->hasRole('admin');

// Array
$user->hasRole(['admin', 'editor']);

// Collection
$user->hasRole(collect(['admin', 'moderator']));

// Oggetto Role
$adminRole = Role::findByName('admin');
$user->hasRole($adminRole);

// Con guard specifico
$user->hasRole('admin', 'api');
```

#### 2. `hasAnyRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha ALMENO UNO dei ruoli specificati.

```php
$user->hasAnyRole(['admin', 'editor', 'moderator']);
// true se ha almeno uno di questi ruoli
```

#### 3. `hasAllRoles($roles, ?string $guard = null): bool`

Verifica se l'utente ha TUTTI i ruoli specificati.

```php
$user->hasAllRoles(['admin', 'editor']);
// true solo se ha entrambi i ruoli
```

#### 4. `assignRole($roles): static`

Assegna uno o più ruoli all'utente.

```php
// String singolo
$user->assignRole('admin');

// Array
$user->assignRole(['admin', 'editor']);

// Fluent
$user->assignRole('admin')->assignRole('editor');

// Con oggetto Role
$adminRole = Role::findByName('admin');
$user->assignRole($adminRole);
```

#### 5. `removeRole($roles): static`

Rimuove uno o più ruoli dall'utente.

```php
$user->removeRole('editor');
$user->removeRole(['editor', 'moderator']);
```

#### 6. `syncRoles($roles): static`

Sincronizza i ruoli (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncRoles(['admin', 'editor']);
// L'utente avrà SOLO admin e editor
```

#### 7. `getRoleNames(): Collection`

Ottiene i nomi di tutti i ruoli dell'utente.

```php
$roleNames = $user->getRoleNames();
// Collection(['admin', 'editor'])
```

### B. HasPermissions Methods

#### 1. `hasPermissionTo($permission, ?string $guardName = null): bool`

Verifica se l'utente ha un permesso specifico (diretto o tramite ruolo).

```php
$user->hasPermissionTo('edit articles');
$user->hasPermissionTo('delete users');
```

#### 2. `hasAnyPermission($permissions): bool`

Verifica se l'utente ha ALMENO UNO dei permessi specificati.

```php
$user->hasAnyPermission(['edit articles', 'delete articles', 'publish articles']);
```

#### 3. `hasAllPermissions($permissions): bool`

Verifica se l'utente ha TUTTI i permessi specificati.

```php
$user->hasAllPermissions(['edit articles', 'publish articles']);
```

#### 4. `givePermissionTo($permissions): static`

Assegna uno o più permessi diretti all'utente.

```php
$user->givePermissionTo('edit articles');
$user->givePermissionTo(['edit articles', 'delete articles']);
```

#### 5. `revokePermissionTo($permissions): static`

Revoca uno o più permessi diretti dall'utente.

```php
$user->revokePermissionTo('delete articles');
```

#### 6. `syncPermissions($permissions): static`

Sincronizza i permessi diretti (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncPermissions(['edit articles', 'view articles']);
```

#### 7. `getDirectPermissions(): Collection`

Ottiene solo i permessi assegnati direttamente all'utente (non tramite ruoli).

```php
$directPermissions = $user->getDirectPermissions();
```

#### 8. `getPermissionsViaRoles(): Collection`

Ottiene i permessi che l'utente ha tramite i suoi ruoli.

```php
$rolePermissions = $user->getPermissionsViaRoles();
```

#### 9. `getAllPermissions(): Collection`

Ottiene TUTTI i permessi dell'utente (diretti + tramite ruoli).

```php
$allPermissions = $user->getAllPermissions();
```

### C. Combined Queries

#### `roles(): BelongsToMany`

Relazione Eloquent per i ruoli.

```php
// Query ruoli
$adminUsers = User::role('admin')->get();

// Conta ruoli
$roleCount = $user->roles()->count();

// Eager loading
$users = User::with('roles')->get();
```

#### `permissions(): BelongsToMany`

Relazione Eloquent per i permessi.

```php
// Query permessi
$usersWithPermission = User::permission('edit articles')->get();

// Conta permessi diretti
$permissionCount = $user->permissions()->count();
```

## Query Scopes

Spatie fornisce automaticamente questi query scope:

### 1. `role($roles, $guard = null)`

Filtra utenti che hanno un ruolo specifico.

```php
// Utenti con ruolo admin
$admins = User::role('admin')->get();

// Utenti con uno dei ruoli specificati
$staff = User::role(['admin', 'editor'])->get();
```

### 2. `permission($permissions)`

Filtra utenti che hanno un permesso specifico.

```php
// Utenti che possono editare articoli
$editors = User::permission('edit articles')->get();

// Utenti con almeno uno dei permessi
$canPublish = User::permission(['edit articles', 'publish articles'])->get();
```

### 3. `withoutRole($roles)`

Filtra utenti che NON hanno un ruolo specifico.

```php
$nonAdmins = User::withoutRole('admin')->get();
```

### 4. `withoutPermission($permissions)`

Filtra utenti che NON hanno un permesso specifico.

```php
$cantDelete = User::withoutPermission('delete articles')->get();
```

## Blade Directives

Spatie fornisce automaticamente direttive Blade per il controllo accessi:

### Role Directives

```blade
@role('admin')
    <p>Contenuto visibile solo agli admin</p>
@endrole

@hasrole('editor')
    <p>Contenuto per editor</p>
@endhasrole

@hasanyrole(['admin', 'editor'])
    <p>Visibile a admin O editor</p>
@endhasanyrole

@hasallroles(['admin', 'super-admin'])
    <p>Visibile solo a chi ha entrambi i ruoli</p>
@endhasallroles

@unlessrole('guest')
    <p>Non visibile ai guest</p>
@endunlessrole
```

### Permission Directives

```blade
@can('edit articles')
    <button>Edit Article</button>
@endcan

@cannot('delete articles')
    <p>Non hai permesso di eliminare</p>
@endcannot

@canany(['edit articles', 'delete articles'])
    <button>Manage Articles</button>
@endcanany
```

## Gate & Policies

I permessi Spatie si integrano automaticamente con i Gate Laravel:

```php
// In un controller
if (Gate::allows('edit articles')) {
    // Utente può editare
}

// Con Policy
$this->authorize('update', $article);
```

## Middleware

Spatie registra automaticamente middleware per route protection:

```php
// Route con ruolo richiesto
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Route con permesso richiesto
Route::middleware(['permission:edit articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create']);
});

// Ruolo O permesso
Route::middleware(['role_or_permission:admin|edit articles'])->group(function () {
    // ...
});
```

## Best Practices

### 1. ✅ Usa i Metodi del Trait

```php
// ✅ CORRETTO - Usa il metodo del trait
$user->hasRole('admin');

// ❌ SBAGLIATO - Non creare metodi duplicati in BaseUser
public function hasRole(...): bool { ... }
```

### 2. ✅ Eager Loading

```php
// ✅ CORRETTO - Precarica ruoli e permessi
$users = User::with(['roles', 'permissions'])->get();

// ❌ LENTO - N+1 query problem
foreach ($users as $user) {
    if ($user->hasRole('admin')) { ... }
}
```

### 3. ✅ Cache Permissions

Spatie cache automaticamente i permessi. Per forzare il refresh:

```php
// Dopo aver modificato ruoli/permessi
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

### 4. ✅ Type Hinting

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function assignAdminRole(User $user): void
{
    $adminRole = Role::findByName('admin');
    $user->assignRole($adminRole);
}
```

## Testing

### Setup Test User

```php
use Modules\Fixcity\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

test('user can have roles and permissions', function () {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

    $user->assignRole($role);
    $user->givePermissionTo($permission);

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasPermissionTo('edit articles'))->toBeTrue();
});
```

### Test Role Hierarchy

```php
test('admin role has all permissions', function () {
    $user = User::factory()->create();
    $admin = Role::create(['name' => 'admin']);

    $permissions = [
        Permission::create(['name' => 'create articles']),
        Permission::create(['name' => 'edit articles']),
        Permission::create(['name' => 'delete articles']),
    ];

    $admin->syncPermissions($permissions);
    $user->assignRole($admin);

    expect($user->hasAllPermissions(['create articles', 'edit articles', 'delete articles']))->toBeTrue();
});
```

## Troubleshooting

### Problema: Permessi non funzionano

**Soluzione**: Pulire cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

### Problema: "Table roles doesn't exist"

**Soluzione**: Eseguire migrations

```bash
php artisan migrate --path=vendor/spatie/laravel-permission/database/migrations
```

### Problema: Guard mismatch

**Soluzione**: Specificare guard corretto

```php
$user->assignRole(Role::findByName('admin', 'web'));
```

## Documentation Links

- **Official Docs**: https://spatie.be/docs/laravel-permission/
- **GitHub**: https://github.com/spatie/laravel-permission
- **Changelog**: https://github.com/spatie/laravel-permission/blob/main/CHANGELOG.md

## Version Information

| Package | Version |
|---------|---------|
| spatie/laravel-permission | Check `composer.json` |
| Laravel | 12.34.0 |
| PHP | 8.3.26 |

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0
