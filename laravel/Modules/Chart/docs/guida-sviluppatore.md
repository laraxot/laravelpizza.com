# Guida Completa per lo Sviluppatore <nome progetto>

## 📋 Indice

1. [Setup Iniziale](#setup-iniziale)
2. [Struttura del Progetto](#struttura-del-progetto)
3. [Standard di Codice](#standard-di-codice)
4. [Sviluppo Moduli](#sviluppo-moduli)
5. [Filament Development](#filament-development)
6. [Testing](#testing)
7. [Deployment](#deployment)
8. [Troubleshooting](#troubleshooting)

## 🚀 Setup Iniziale

### Prerequisiti

- PHP >= 8.2 con estensioni: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Composer >= 2.5
- Node.js >= 18.x e NPM >= 9.x
- MySQL >= 8.0 o MariaDB >= 10.6
- Redis >= 7.0
- Git

### Installazione

1. **Clone del repository**
   ```bash
   git clone [repository-url]
   cd base_<nome progetto>/laravel
   ```

2. **Installazione dipendenze PHP**
   ```bash
   composer install
   ```

3. **Configurazione ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurazione database**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=<nome progetto>
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Migrazioni e seeder**
   ```bash
   php artisan migrate --seed
   php artisan module:migrate
   php artisan module:seed
   ```

6. **Installazione dipendenze frontend**
   ```bash
   npm install
   npm run build
   ```

7. **Link storage**
   ```bash
   php artisan storage:link
   ```

8. **Configurazione queue**
   ```bash
   php artisan queue:work
   # oppure con Horizon
   php artisan horizon
   ```

## 📁 Struttura del Progetto

```
base_<nome progetto>/
├── laravel/                    # Applicazione Laravel
│   ├── Modules/               # Moduli applicativi
│   │   ├── Xot/              # Modulo base framework
│   │   ├── User/             # Gestione utenti
│   │   ├── <nome progetto>/        # Core business
│   │   ├── Patient/          # Gestione pazienti
│   │   ├── Dental/           # Modulo odontoiatrico
│   │   └── ...               # Altri moduli
│   ├── Themes/                # Temi frontend
│   │   ├── One/              # Tema principale
│   │   └── Two/              # Tema alternativo
│   ├── config/                # Configurazioni
│   ├── database/              # Migrazioni e seeder
│   ├── public/                # Asset pubblici
│   ├── resources/             # Risorse (views, js, css)
│   ├── routes/                # Definizione route
│   ├── storage/               # Storage files
│   └── tests/                 # Test suite
├── docs/                      # Documentazione
├── .cursor/                   # Regole Cursor AI
└── .windsurf/                # Regole Windsurf
```

### Struttura di un Modulo

```
Modules/NomeModulo/
├── Actions/                   # QueueableActions (business logic)
├── Config/                    # Configurazioni modulo
├── Console/                   # Comandi Artisan
├── Database/                  # Migrazioni e seeder
│   ├── Migrations/
│   └── Seeders/
├── Datas/                     # Data Transfer Objects
├── Enums/                     # Enumerazioni
├── Events/                    # Eventi
├── Filament/                  # Risorse Filament
│   ├── Resources/
│   └── Pages/
├── Http/                      # Controller e Middleware
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Jobs/                      # Job asincroni
├── Listeners/                 # Event listeners
├── Models/                    # Modelli Eloquent
├── Notifications/             # Notifiche
├── Policies/                  # Policy autorizzazioni
├── Providers/                 # Service providers
├── Resources/                 # Viste e traduzioni
│   ├── views/
│   └── lang/
├── Routes/                    # Route del modulo
├── Tests/                     # Test del modulo
├── composer.json              # Dipendenze modulo
└── module.json               # Configurazione modulo
```

## 📝 Standard di Codice

### PHP Standards

1. **PSR-12 Compliance**
   ```php
   <?php

   declare(strict_types=1);

   namespace Modules\NomeModulo\Models;

   use Illuminate\Database\Eloquent\Model;

   final class ExampleModel extends Model
   {
       protected $fillable = [
           'name',
           'email',
       ];
   }
   ```

2. **Type Declarations**
   ```php
   public function processData(array $data, bool $validate = true): UserData
   {
       // Implementazione
   }
   ```

3. **PHPStan Level 9**
   ```php
   /**
    * @param array<string, mixed> $data
    * @return list<string>
    */
   public function extractNames(array $data): array
   {
       return array_values(array_filter(
           array_map(
               fn ($item) => is_string($item['name'] ?? null) ? $item['name'] : null,
               $data
           )
       ));
   }
   ```

### Naming Conventions

1. **Classi**: PascalCase
   ```php
   class UserController
   class CreateUserAction
   class UserData
   ```

2. **Metodi e Variabili**: camelCase
   ```php
   public function getUserById(int $userId): User
   {
       $userData = $this->repository->find($userId);
       return $userData;
   }
   ```

3. **Costanti e Enum**: UPPER_SNAKE_CASE
   ```php
   const MAX_LOGIN_ATTEMPTS = 5;
   
   enum UserStatus: string
   {
       case ACTIVE = 'active';
       case INACTIVE = 'inactive';
       case SUSPENDED = 'suspended';
   }
   ```

4. **Database**: snake_case
   ```php
   Schema::create('user_profiles', function (Blueprint $table) {
       $table->id();
       $table->string('first_name');
       $table->string('last_name');
       $table->timestamps();
   });
   ```

## 🔧 Sviluppo Moduli

### Creare un Nuovo Modulo

1. **Generazione modulo**
   ```bash
   php artisan module:make NomeModulo
   ```

2. **Struttura base del modulo**
   ```php
   // Providers/NomeModuloServiceProvider.php
   namespace Modules\NomeModulo\Providers;

   use Modules\Xot\Providers\XotBaseServiceProvider;

   class NomeModuloServiceProvider extends XotBaseServiceProvider
   {
       public string $name = 'NomeModulo';
       protected string $module_dir = __DIR__;
       protected string $module_ns = __NAMESPACE__;
   }
   ```

3. **Configurazione module.json**
   ```json
   {
       "name": "NomeModulo",
       "alias": "nomemodulo",
       "description": "Descrizione del modulo",
       "keywords": [],
       "priority": 0,
       "providers": [
           "Modules\\NomeModulo\\Providers\\NomeModuloServiceProvider"
       ],
       "files": []
   }
   ```

### Modelli

1. **Modello base**
   ```php
   namespace Modules\NomeModulo\Models;

   use Modules\Xot\Models\XotBaseModel;

   /**
    * @property int $id
    * @property string $name
    * @property string $email
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

2. **Relazioni**
   ```php
   /**
    * @return HasMany<Post, $this>
    */
   public function posts(): HasMany
   {
       return $this->hasMany(Post::class);
   }

   /**
    * @return BelongsToMany<Role, $this>
    */
   public function roles(): BelongsToMany
   {
       return $this->belongsToMany(Role::class);
   }
   ```

### Actions (QueueableAction)

```php
namespace Modules\NomeModulo\Actions;

use Modules\NomeModulo\Datas\UserData;
use Modules\NomeModulo\Models\User;
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    public function execute(UserData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);
    }
}
```

### Data Transfer Objects

```php
namespace Modules\NomeModulo\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Min;

class UserData extends Data
{
    public function __construct(
        #[Required]
        public readonly string $name,
        
        #[Required, Email]
        public readonly string $email,
        
        #[Required, Min(8)]
        public readonly string $password,
    ) {}
}
```

## 🎨 Filament Development

### Resource Base

```php
namespace Modules\NomeModulo\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Tables;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),
            
            'password' => Forms\Components\TextInput::make('password')
                ->password()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state)),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
            
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            
            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
            
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

### Page Personalizzate

```php
namespace Modules\NomeModulo\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Actions\Action;

class Dashboard extends XotBasePage
{
    protected static string $view = 'nomemodulo::filament.pages.dashboard';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Aggiorna')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->redirect(static::getUrl())),
        ];
    }
}
```

## 🧪 Testing

### Unit Test

```php
namespace Modules\NomeModulo\Tests\Unit;

use Tests\TestCase;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Actions\CreateUserAction;
use Modules\NomeModulo\Datas\UserData;

class CreateUserActionTest extends TestCase
{
    public function test_it_creates_a_user(): void
    {
        // Arrange
        $userData = new UserData(
            name: 'John Doe',
            email: 'john@example.com',
            password: 'password123'
        );

        // Act
        $user = app(CreateUserAction::class)->execute($userData);

        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }
}
```

### Feature Test

```php
namespace Modules\NomeModulo\Tests\Feature;

use Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_list(): void
    {
        // Arrange
        $admin = User::factory()->admin()->create();
        User::factory()->count(5)->create();

        // Act
        $response = $this->actingAs($admin)
            ->get('/admin/users');

        // Assert
        $response->assertOk();
        $response->assertSee('Utenti');
    }
}
```

### Browser Test (Dusk)

```php
namespace Modules\NomeModulo\Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Modules\User\Models\User;

class LoginTest extends DuskTestCase
{
    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/dashboard')
                ->assertAuthenticated();
        });
    }
}
```

## 🚀 Deployment

### Pre-deployment Checklist

1. **Ottimizzazione**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan filament:cache-components
   ```

2. **Asset compilation**
   ```bash
   npm run build
   ```

3. **Database**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

### Deployment con Docker

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

CMD ["php-fpm"]
```

### CI/CD con GitHub Actions

```yaml
name: Deploy

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          
      - name: Install dependencies
        run: composer install --optimize-autoloader --no-dev
        
      - name: Run tests
        run: php artisan test
        
      - name: Deploy
        run: |
          # Deploy script here
```

## 🔧 Troubleshooting

### Problemi Comuni

1. **Errore: Class not found**
   ```bash
   composer dump-autoload
   php artisan cache:clear
   ```

2. **Errore: Migration failed**
   ```bash
   php artisan migrate:fresh --seed
   # ATTENZIONE: cancella tutti i dati!
   ```

3. **Errore: npm run dev non funziona**
   ```bash
   rm -rf node_modules package-lock.json
   npm install
   npm run dev
   ```

4. **Errore: Permission denied**
   ```bash
   sudo chown -R $USER:www-data storage bootstrap/cache
   sudo chmod -R 775 storage bootstrap/cache
   ```

### Debug Tools

1. **Laravel Debugbar**
   ```bash
   composer require barryvdh/laravel-debugbar --dev
   ```

2. **Telescope**
   ```bash
   composer require laravel/telescope --dev
   php artisan telescope:install
   ```

3. **Ray**
   ```php
   ray($variable)->green();
   ray()->pause();
   ```

### Performance Optimization

1. **Query optimization**
   ```php
   // Evitare N+1
   $users = User::with(['posts', 'roles'])->get();
   
   // Usare chunk per grandi dataset
   User::chunk(1000, function ($users) {
       foreach ($users as $user) {
           // Process user
       }
   });
   ```

2. **Cache strategies**
   ```php
   // Cache query results
   $users = Cache::remember('users', 3600, function () {
       return User::all();
   });
   
   // Cache model
   class User extends Model
   {
       protected $cacheTTL = 3600;
   }
   ```

## 📚 Risorse Utili

### Documentazione Interna
- [Architettura Sistema](ARCHITETTURA_SISTEMA.md)
- [Best Practices](best-practices.md)
- [PHPStan Rules](./standards/phpstan-level-9.md)

### Documentazione Esterna
- [Laravel Docs](https://laravel.com/docs)
- [Filament Docs](https://filamentphp.com/docs)
- [Livewire Docs](https://livewire.laravel.com/docs)
- [Spatie Packages](https://spatie.be/docs)

### Community
- Slack: #<nome progetto>-dev
- GitHub Issues
- Stack Overflow

---

*Ultimo aggiornamento: 28 Maggio 2025*
