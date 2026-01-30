# Implementazione Sistema Ruoli e Permessi

## Obiettivi
- Integrare Spatie Laravel-permission
- Configurare permessi granulari per tenant
- Implementare policy per ogni risorsa
- Setup sistema di ereditarietà permessi

## Passi Implementativi

### 1. Setup Spatie Permission
1. Installare pacchetto
   ```bash
   composer require spatie/laravel-permission
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
   php artisan migrate
   ```

2. Configurare modello User
   ```php
   // app/Models/User.php
   use Spatie\Permission\Traits\HasRoles;
   
   class User extends Authenticatable
   {
       use HasRoles;
       // ...
   }
   ```

### 2. Configurazione Permessi Tenant
1. Implementare trait BelongsToTenant
   ```php
   // app/Traits/BelongsToTenant.php
   trait BelongsToTenant
   {
       // Implementazione trait
   }
   ```

2. Setup middleware tenant
   ```php
   // app/Http/Middleware/EnsureTenant.php
   class EnsureTenant
   {
       public function handle($request, Closure $next)
       {
           // Implementazione middleware
       }
   }
   ```

### 3. Policy e Permessi
1. Creare policy base
   ```php
   // app/Policies/BasePolicy.php
   abstract class BasePolicy
   {
       // Implementazione base
   }
   ```

2. Implementare policy per risorse
   ```php
   // app/Policies/PatientPolicy.php
   class PatientPolicy extends BasePolicy
   {
       // Implementazione policy
   }
   ```

### 4. Ereditarietà Permessi
1. Setup gerarchia ruoli
   ```php
   // database/seeders/RoleSeeder.php
   class RoleSeeder extends Seeder
   {
       public function run()
       {
           // Implementazione seeder
       }
   }
   ```

2. Configurare ereditarietà
   ```php
   // config/permission.php
   'role_hierarchy' => [
       'admin' => ['doctor', 'assistant'],
       'doctor' => ['assistant'],
   ],
   ```

## Testing
1. Unit Tests
   ```php
   // tests/Unit/PermissionTest.php
   class PermissionTest extends TestCase
   {
       // Implementazione test
   }
   ```

2. Feature Tests
   ```php
   // tests/Feature/PermissionTest.php
   class PermissionTest extends TestCase
   {
       // Implementazione test
   }
   ```

## Sicurezza
1. Validazione permessi
   ```php
   // app/Http/Middleware/CheckPermission.php
   class CheckPermission
   {
       public function handle($request, Closure $next, $permission)
       {
           // Implementazione middleware
       }
   }
   ```

2. Cache permessi
   ```php
   // config/permission.php
   'cache' => [
       'expiration' => \DateInterval::createFromDateString('24 hours'),
       'key' => 'spatie.permission.cache',
   ],
   ```

## Note Implementative
- Utilizzare cache per performance
- Implementare logging accessi
- Gestire revoca permessi
- Mantenere audit trail
- Implementare backup automatici 