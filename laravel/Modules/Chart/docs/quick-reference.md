# 🚀 Quick Reference - <nome progetto>

## 📋 Comandi Essenziali

### Artisan Commands

```bash

# Moduli
php artisan module:list                    # Lista moduli
php artisan module:make NomeModulo        # Crea nuovo modulo
php artisan module:migrate NomeModulo     # Migra modulo specifico
php artisan module:seed NomeModulo        # Seed modulo specifico
php artisan module:enable NomeModulo      # Abilita modulo
php artisan module:disable NomeModulo     # Disabilita modulo

# Cache
php artisan cache:clear                   # Pulisci cache
php artisan config:cache                  # Cache configurazioni
php artisan route:cache                   # Cache route
php artisan view:cache                    # Cache viste
php artisan filament:cache-components     # Cache componenti Filament

# Database
php artisan migrate                       # Esegui migrazioni
php artisan migrate:rollback             # Rollback ultima migrazione
php artisan migrate:fresh --seed         # Fresh migration con seed
php artisan db:seed                      # Esegui seeder

# Queue
php artisan queue:work                   # Processa queue
php artisan queue:listen                 # Ascolta queue
php artisan horizon                      # Avvia Horizon
php artisan horizon:pause                # Pausa Horizon
php artisan horizon:continue             # Continua Horizon

# Manutenzione
php artisan down                         # Modalità manutenzione
php artisan up                           # Esci da manutenzione
php artisan optimize                     # Ottimizza applicazione
php artisan storage:link                 # Link storage pubblico
```

### Composer Commands

```bash

# Dipendenze
composer install                         # Installa dipendenze
composer update                          # Aggiorna dipendenze
composer dump-autoload                   # Rigenera autoload
composer show                            # Mostra pacchetti installati

# Produzione
composer install --optimize-autoloader --no-dev
composer update --optimize-autoloader --no-dev
```

### NPM Commands

```bash

# Development
npm install                              # Installa dipendenze
npm run dev                              # Build sviluppo
npm run watch                            # Watch mode

# Production
npm run build                            # Build produzione
npm run build -- --analyze               # Build con analisi
```

### Testing Commands

```bash

# PHPUnit
php artisan test                         # Esegui tutti i test
php artisan test --filter TestName       # Test specifico
php artisan test --coverage              # Con coverage
php artisan test Modules/NomeModulo      # Test modulo

# PHPStan
vendor/bin/phpstan analyse               # Analisi livello default
vendor/bin/phpstan analyse -l 9          # Analisi livello 9
vendor/bin/phpstan analyse --memory-limit=2G

# Dusk
php artisan dusk                         # Browser test
php artisan dusk:chrome-driver           # Aggiorna Chrome driver
```

## 🛠️ Operazioni Comuni

### Creare un Modulo

```bash

# 1. Genera modulo
php artisan module:make Blog

# 2. Attiva modulo
php artisan module:enable Blog

# 3. Crea modello
php artisan module:make-model Post Blog

# 4. Crea migrazione
php artisan module:make-migration create_posts_table Blog

# 5. Crea controller
php artisan module:make-controller PostController Blog

# 6. Crea resource Filament
php artisan module:make-filament-resource Post Blog
```

### Creare una Resource Filament

```php
// 1. Crea file Resource
// Modules/NomeModulo/Filament/Resources/UserResource.php

namespace Modules\NomeModulo\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required(),
            'email' => TextInput::make('email')->email()->required(),
        ];
    }
}

// 2. Registra nel service provider
public function boot(): void
{
    Filament::registerResources([
        UserResource::class,
    ]);
}
```

### Creare un'Action

```php
// 1. Crea Action
// Modules/NomeModulo/Actions/CreateUserAction.php

namespace Modules\NomeModulo\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;
    
    public function execute(UserData $data): User
    {
        return User::create($data->toArray());
    }
}

// 2. Usa l'Action
$user = app(CreateUserAction::class)->execute($userData);

// 3. O in queue
app(CreateUserAction::class)->onQueue()->execute($userData);
```

### Creare un DTO

```php
// Modules/NomeModulo/Datas/UserData.php

namespace Modules\NomeModulo\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;

class UserData extends Data
{
    public function __construct(
        public string $name,
        #[Email]
        public string $email,
    ) {}
}

// Uso
$userData = UserData::from($request->validated());
$userData = UserData::from(['name' => 'John', 'email' => 'john@example.com']);
```

## 📁 Struttura File Modulo

```
Modules/NomeModulo/
├── Actions/              # Business logic (QueueableActions)
├── Config/               # config.php
├── Console/              # Comandi Artisan
├── Database/
│   ├── Migrations/       # Migrazioni
│   └── Seeders/         # Seeder
├── Datas/               # DTO (Spatie Laravel Data)
├── Enums/               # Enumerazioni
├── Events/              # Eventi
├── Filament/
│   ├── Resources/       # Risorse Filament
│   └── Pages/           # Pagine custom
├── Http/
│   ├── Controllers/     # Controller
│   ├── Middleware/      # Middleware
│   └── Requests/        # Form Requests
├── Jobs/                # Job asincroni
├── Listeners/           # Event listeners
├── Models/              # Modelli Eloquent
├── Notifications/       # Notifiche
├── Policies/            # Policy autorizzazioni
├── Providers/           # Service providers
├── Resources/
│   ├── views/           # Blade views
│   └── lang/            # Traduzioni
├── Routes/              # web.php, api.php
├── Tests/               # Unit e Feature test
├── composer.json        # Dipendenze modulo
└── module.json          # Configurazione modulo
```

## ⚠️ NAMESPACE CRITICO

### ❌ MAI includere 'App' nei namespace

```php
// ❌ ERRATO - ROMPE L'AUTOLOADING
namespace Modules\Blog\App\Models;
namespace Modules\User\App\Filament\Resources;
namespace Modules\Geo\App\Actions;

// ✅ CORRETTO - SEMPRE COSÌ
namespace Modules\Blog\Models;
namespace Modules\User\Filament\Resources;
namespace Modules\Geo\Actions;
```

### Verifica sempre
```bash
composer dumpautoload  # Dopo ogni nuovo file
```

## 🔧 Snippet di Codice

### Model con PHPStan

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Models;

use Modules\Xot\Models\XotBaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends XotBaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

### Controller Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Http\Controllers;

use Modules\Xot\Http\Controllers\XotBaseController;
use Modules\NomeModulo\Actions\ListUsersAction;
use Modules\NomeModulo\Datas\UserData;

class UserController extends XotBaseController
{
    public function index(ListUsersAction $action): \Illuminate\View\View
    {
        $users = $action->execute();
        
        return view('nomemodulo::users.index', [
            'users' => $users,
        ]);
    }
}
```

### Form Request

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
```

### Test Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user(): void
    {
        $response = $this->post('/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }
}
```

## 🐛 Troubleshooting Rapido

### Errori Comuni e Soluzioni

```bash

# Class not found
composer dump-autoload
php artisan cache:clear

# Route not found
php artisan route:clear
php artisan route:cache

# View not found
php artisan view:clear
php artisan view:cache

# Config not updated
php artisan config:clear
php artisan config:cache

# Permission denied
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Migration error
php artisan migrate:rollback
php artisan migrate

# Queue not processing
php artisan queue:restart
php artisan horizon:terminate
```

## 🔍 Debug Tools

```php
// Ray
ray($variable)->green();
ray()->pause();
ray()->showQueries();

// DD
dd($variable);
dump($variable);

// Log
\Log::info('Message', ['context' => $data]);
\Log::error('Error', ['exception' => $e]);

// DB Query Log
\DB::enableQueryLog();
// ... queries ...
dd(\DB::getQueryLog());
```

## 📝 Git Commands

```bash

# Branch
git checkout -b feature/nome-feature
git push -u origin feature/nome-feature

# Commit
git add .
git commit -m "feat: descrizione feature"
git push

# Update from main
git fetch origin
git merge origin/main

# Stash
git stash
git stash pop
git stash list

# Reset
git reset --soft HEAD~1  # Undo last commit
git reset --hard HEAD    # Discard changes
```

## 🔗 Link Utili

### Documentazione Interna
- [Indice Documentazione](INDICE_DOCUMENTAZIONE.md)
- [Guida Sviluppatore](GUIDA_SVILUPPATORE.md)
- [Architettura Sistema](ARCHITETTURA_SISTEMA.md)
- [Best Practices](best-practices.md)

### Risorse Esterne
- [Laravel Docs](https://laravel.com/docs)
- [Filament Docs](https://filamentphp.com/docs)
- [Spatie Docs](https://spatie.be/docs)
- [PHPStan Docs](https://phpstan.org/user-guide)

---

*Quick Reference v1.0 - Aggiornato: 28 Maggio 2025*
