# Setup Super Admin - Guida Completa

**Data Creazione**: 15 Ottobre 2025  
**Comando**: `php artisan user:super-admin`  
**Prerequisiti**: Database migrato

## Problema Comune

### Errore "no such table: roles"

```
SQLSTATE[HY000]: General error: 1 no such table: roles 
(Connection: sqlite, SQL: select * from "roles" where 
("team_id" is null or "team_id" is null) and "name" = super-admin 
and "guard_name" = web limit 1)
```

**Causa**: Le migrazioni del database non sono state eseguite o sono incomplete.

**Soluzione**: Eseguire le migrazioni prima di creare il super admin.

## Sequenza Corretta di Setup

### 1. Preparazione Database

#### Opzione A: Database Vuoto (Prima Installazione)
```bash
# Esegui tutte le migrazioni
php artisan migrate --force

# Verifica migrazioni eseguite
php artisan migrate:status
```

#### Opzione B: Reset Completo del Database
```bash
# ATTENZIONE: Elimina TUTTI i dati!
php artisan migrate:fresh --force

# Verifica che le tabelle siano state create
php artisan migrate:status
```

#### Opzione C: Con Dati di Test
```bash
# Reset + Migrazioni + Seeding
php artisan migrate:fresh --seed --force
```

### 2. Verifica Tabelle Create

**Tabelle necessarie** per il comando `user:super-admin`:
- ✅ `users` - Tabella utenti
- ✅ `roles` - Tabella ruoli (Spatie Permission)
- ✅ `permissions` - Tabella permessi
- ✅ `model_has_roles` - Pivot utenti-ruoli
- ✅ `model_has_permissions` - Pivot utenti-permessi
- ✅ `role_has_permissions` - Pivot ruoli-permessi

**Verifica con SQLite**:
```bash
sqlite3 database/fixcity_data.sqlite ".tables"
```

**Verifica con MySQL**:
```bash
php artisan tinker
>>> DB::connection()->getSchemaBuilder()->getTableListing();
```

### 3. Creazione Super Admin

```bash
php artisan user:super-admin
```

**Input richiesto**:
```
┌ email ? ─────────────────────────────────────────────────────┐
│ marco.sottana@gmail.com                                      │
└──────────────────────────────────────────────────────────────┘
```

**Output atteso**:
```
super-admin assigned to marco.sottana@gmail.com
```

## Cosa Fa il Comando

### 1. Verifica Utente Esistente

Il comando cerca l'utente tramite email usando `XotData::getUserByEmail($email)`.

**Se l'utente NON esiste**: Il comando FALLISCE.  
**Soluzione**: Creare prima l'utente (vedi sezione "Creazione Utente").

### 2. Crea Role Super Admin

```php
$role = Role::firstOrCreate(['name' => 'super-admin']);
$user->assignRole($role->name);
```

Crea il ruolo `super-admin` se non esiste e lo assegna all'utente.

### 3. Crea Roles Admin per Ogni Modulo

```php
foreach ($modules as $module) {
    $role_name = Str::lower($module).'::admin';
    $role = Role::firstOrCreate(['name' => $role_name]);
    $user->assignRole($role->name);
}
```

Per ogni modulo attivo, crea un ruolo `{modulo}::admin` e lo assegna.

**Esempi di ruoli creati**:
- `user::admin`
- `blog::admin`
- `fixcity::admin`
- `cms::admin`
- `notify::admin`
- ecc...

## Creazione Utente

Se l'utente non esiste, crearlo prima:

### Opzione 1: Tramite Tinker
```bash
php artisan tinker

>>> use Modules\Xot\Datas\XotData;
>>> $userClass = XotData::make()->getUserClass();
>>> $user = $userClass::create([
...     'email' => 'marco.sottana@gmail.com',
...     'name' => 'Marco Sottana',
...     'password' => bcrypt('password'),
... ]);
>>> $user->markEmailAsVerified();
```

### Opzione 2: Tramite Seeder

Creare un seeder dedicato per l'admin:

**File**: `Modules/User/database/seeders/AdminUserSeeder.php`

```php
<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Xot\Datas\XotData;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $userClass = XotData::make()->getUserClass();
        
        $user = $userClass::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Admin user created: '.$user->email);
    }
}
```

**Esecuzione**:
```bash
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\AdminUserSeeder"
```

### Opzione 3: Tramite Filament (UI)

1. Accedere a `/admin/register` (se registrazione abilitata)
2. Oppure creare tramite Filament User Resource
3. Poi eseguire `user:super-admin` con quella email

## Troubleshooting

### Errore: "User not found"

**Causa**: L'utente con quella email non esiste.

**Soluzione**:
```bash
# Verifica utenti esistenti
php artisan tinker
>>> Modules\Xot\Datas\XotData::make()->getUserClass()::pluck('email');

# Oppure crea l'utente (vedi sezione precedente)
```

### Errore: "SQLSTATE[HY000]: General error: 1 no such table: roles"

**Causa**: Migrazioni non eseguite.

**Soluzione**:
```bash
php artisan migrate --force
# Poi riprova
php artisan user:super-admin
```

### Errore: "Class 'Spatie\Permission\Models\Role' not found"

**Causa**: Pacchetto Spatie Permission non installato.

**Soluzione**:
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### Ruoli non vengono assegnati

**Verifica**:
```bash
php artisan tinker
>>> $user = Modules\Xot\Datas\XotData::make()->getUserByEmail('email@example.com');
>>> $user->roles;
>>> $user->getAllPermissions();
```

**Se vuoto, riassegna**:
```bash
php artisan user:super-admin
# Inserire di nuovo la stessa email
```

## Verifica Super Admin Funzionante

### 1. Verifica Ruoli Assegnati

```bash
php artisan tinker

>>> $user = Modules\Xot\Datas\XotData::make()->getUserByEmail('marco.sottana@gmail.com');
>>> $user->roles->pluck('name');
// Dovrebbe mostrare: ['super-admin', 'user::admin', 'blog::admin', ...]
```

### 2. Verifica Permessi

```php
>>> $user->hasRole('super-admin');
// true

>>> $user->hasRole('blog::admin');
// true

>>> $user->can('viewAny', SomeModel::class);
// true (se policies configurate)
```

### 3. Accesso Filament Admin

1. Accedere a `/admin`
2. Verificare accesso a tutte le risorse
3. Verificare presenza di tutti i menu dei moduli

## Configurazione

### Guard Predefinito

Il comando usa il guard `web` di default. Configurato in:

**File**: `config/auth.php`
```php
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],
```

### Team Support

Il comando supporta anche team/tenancy. Se si usa Filament con teams:

**File**: `Modules/User/app/Console/Commands/SuperAdminCommand.php`

Modificare per specificare team:
```php
$role = Role::firstOrCreate([
    'name' => 'super-admin',
    'team_id' => $team_id, // Aggiungere se necessario
]);
```

## Best Practices

### Sicurezza

1. ✅ **Password Forte**: Usare password sicura per super-admin
2. ✅ **Email Verificata**: Assicurarsi che l'email sia verificata
3. ✅ **2FA**: Considerare autenticazione a due fattori
4. ✅ **Audit Log**: Tracciare azioni del super-admin

### Ambiente di Produzione

```bash
# NON usare mai --force in produzione senza conferma
php artisan user:super-admin

# Backup prima di modifiche
php artisan backup:run

# Verificare ruoli critici
php artisan permission:cache-reset
```

### Ambiente di Sviluppo

```bash
# Setup rapido per dev
php artisan migrate:fresh --seed --force
php artisan user:super-admin
# Email: admin@example.com (se seeded)
```

## Sequenza Completa Setup Iniziale

### Setup da Zero (Prima Installazione)

```bash
# 1. Copia file .env e configura database
cp .env.example .env
php artisan key:generate

# 2. Configura database in .env
# DB_CONNECTION=sqlite
# DB_DATABASE=/var/www/.../database/fixcity_data.sqlite

# 3. Crea file database SQLite (se non esiste)
touch database/fixcity_data.sqlite

# 4. Esegui migrazioni
php artisan migrate --force

# 5. (Opzionale) Seed dati di test
php artisan db:seed --force

# 6. Crea primo utente se non esiste
php artisan tinker
# >>> Crea utente come mostrato sopra
# >>> exit

# 7. Assegna super-admin
php artisan user:super-admin
# Email: [inserire email utente creato]

# 8. Verifica
php artisan tinker
# >>> $user = Modules\Xot\Datas\XotData::make()->getUserByEmail('email@example.com');
# >>> $user->roles->pluck('name');

# 9. Ottimizza
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 10. Accedi a /admin e verifica accesso completo
```

## Collegamenti

### Documentazione Locale
- [User Module README](../README.md)
- [Roles & Permissions](./roles-permissions.md)
- [Authentication](./authentication.md)

### Migrazioni Correlate
- [Create Roles Table](../database/migrations/2024_01_01_000011_create_roles_table.php)
- [Create Users Table](../database/migrations/)

### Root Progetto
- [Setup Guide](../../../docs/setup-guide.md)
- [Database Configuration](../../../docs/database-configuration.md)

## Codice Sorgente

**Comando**: `Modules/User/app/Console/Commands/SuperAdminCommand.php`

**Modello Role**: Usa `Modules\User\Models\Role` che estende `Spatie\Permission\Models\Role`

**Integration**: Sistema di permessi basato su [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)

## Note Operative

### Aggiunta di Nuovi Moduli

Quando si aggiunge un nuovo modulo, il super-admin riceverà automaticamente il ruolo `{modulo}::admin` al prossimo login o alla prossima esecuzione di `user:super-admin`.

### Rimozione Ruoli

Per rimuovere il super-admin:
```bash
php artisan tinker
>>> $user = Modules\Xot\Datas\XotData::make()->getUserByEmail('email@example.com');
>>> $user->removeRole('super-admin');
>>> $user->removeRole('blog::admin'); // specifico
```

### Backup Ruoli

Prima di modifiche importanti:
```bash
php artisan tinker
>>> $roles = Spatie\Permission\Models\Role::with('permissions')->get();
>>> file_put_contents('backup_roles.json', $roles->toJson(JSON_PRETTY_PRINT));
```

## Conclusioni

Il comando `user:super-admin` è fondamentale per il setup iniziale dell'applicazione. Seguire sempre la sequenza corretta:

1. ✅ Migrazioni database
2. ✅ Creazione utente
3. ✅ Assegnazione super-admin
4. ✅ Verifica funzionamento

Con questa guida, il setup dovrebbe essere straightforward e senza errori! 🚀

