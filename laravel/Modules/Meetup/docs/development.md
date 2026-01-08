# 🛠️ Guida Sviluppo - Modulo Meetup

## Introduzione

Questa guida descrive il workflow di sviluppo completo per il modulo Meetup, dal setup dell'ambiente fino al deployment.

## Setup Ambiente di Sviluppo

### Prerequisiti
Assicurati di aver completato l'[installazione](./INSTALLATION.md) prima di procedere.

### Comandi di Sviluppo

```bash
# Avvia server di sviluppo (tutto in uno)
composer dev

# Questo comando esegue concorrently:
# - php artisan serve (server Laravel)
# - php artisan queue:work (worker code)
# - php artisan pail (log viewer)
# - npm run dev (Vite HMR)
```

### Comandi Individuali

Se preferisci eseguire i comandi separatamente:

```bash
# Terminal 1: Server Laravel
php artisan serve

# Terminal 2: Vite dev server
npm run dev

# Terminal 3: Queue worker (opzionale)
php artisan queue:work

# Terminal 4: Log viewer (opzionale)
php artisan pail
```

## Struttura Progetto

```
base_laravelpizza/
├── laravel/                          # Applicazione Laravel
│   ├── Modules/
│   │   └── Meetup/                   # Il nostro modulo
│   │       ├── app/
│   │       │   ├── Actions/          # Spatie Queueable Actions
│   │       │   ├── Datas/            # Spatie Laravel Data objects
│   │       │   ├── Filament/         # Admin panel resources
│   │       │   ├── Http/             # Controllers, Livewire
│   │       │   ├── Models/           # Eloquent models
│   │       │   └── Providers/        # Service providers
│   │       ├── database/
│   │       │   ├── factories/
│   │       │   ├── migrations/
│   │       │   └── seeders/
│   │       ├── docs/                 # Documentazione
│   │       ├── routes/               # Route files
│   │       └── tests/                # Tests
│   └── Themes/
│       └── Meetup/                   # Tema per il frontend
│           └── resources/
│               ├── views/            # Blade templates
│               ├── assets/
│               │   ├── css/          # TailwindCSS
│               │   └── js/           # JavaScript
│               └── lang/             # Traduzioni
└── .cursor/                          # Configurazioni MCP e IDE
```

## Workflow di Sviluppo

### 1. Creazione Nuova Feature

#### 1.1. Pianificazione

```bash
# Analizza i requisiti
# Consulta architecture.md e business-logic.md
# Aggiorna todo.md con nuove task
```

#### 1.2. Database

```bash
# Crea migration
php artisan make:migration create_meetup_table_name --path=Modules/Meetup/database/migrations

# Edita il file migration
# Esegui migration
php artisan migrate

# Crea factory (opzionale)
php artisan make:factory TableNameFactory --model=Modules\\Meetup\\Models\\TableName

# Crea seeder (opzionale)
php artisan make:seeder Modules\\Meetup\\Database\\Seeders\\TableNameSeeder
```

#### 1.3. Model

```bash
# Il modello va in Modules/Meetup/app/Models/
```

**Esempio Pizza.php:**

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model
{
    use HasFactory;

    protected $table = 'meetup_pizzas';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'category_id',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(
            Ingredient::class,
            'meetup_pizza_ingredient'
        );
    }

    // Factory
    protected static function newFactory()
    {
        return \Modules\Meetup\Database\Factories\PizzaFactory::new();
    }
}
```

#### 1.4. Data Object (opzionale ma consigliato)

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Datas;

use Spatie\LaravelData\Data;

class PizzaData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,
        public float $price,
        public ?string $image,
        public int $category_id,
        public bool $is_active,
    ) {
    }
}
```

#### 1.5. Action (Invece di Service)

**IMPORTANTE**: Usa **Actions** invece di Services (convenzione Laraxot).

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Pizza;

use Modules\Meetup\Models\Pizza;
use Spatie\QueueableAction\QueueableAction;

class GetPizzaListAction
{
    use QueueableAction;

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Pizza>
     */
    public function execute(?int $categoryId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Pizza::query()
            ->where('is_active', true)
            ->with(['category', 'ingredients']);

        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        return $query->get();
    }
}
```

#### 1.6. Filament Resource (Admin)

**IMPORTANTE**: Estendi sempre `XotBaseResource`, MAI `Filament\Resources\Resource`.

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Meetup\Models\Pizza;

class PizzaResource extends XotBaseResource
{
    protected static ?string $model = Pizza::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->rows(3),

            TextInput::make('price')
                ->numeric()
                ->prefix('€')
                ->required(),

            FileUpload::make('image')
                ->image()
                ->directory('pizzas'),

            Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),

            Toggle::make('is_active')
                ->default(true),
        ];
    }
}
```

#### 1.7. Controller (Frontend)

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Meetup\Actions\Pizza\GetPizzaListAction;

class MenuController extends Controller
{
    public function index(Request $request, GetPizzaListAction $action)
    {
        $categoryId = $request->query('category');
        $pizzas = $action->execute($categoryId);

        return view('meetup::pages.menu', compact('pizzas'));
    }
}
```

#### 1.8. View (Blade + TailwindCSS)

```blade
{{-- Themes/Meetup/resources/views/pages/menu.blade.php --}}
<x-meetup::layouts.app>
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-display font-bold text-pizza-red-500 mb-8">
            Il Nostro Menu
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pizzas as $pizza)
                <x-meetup::blocks.pizza-card :pizza="$pizza" />
            @endforeach
        </div>
    </div>
</x-meetup::layouts.app>
```

### 2. Testing

#### 2.1. Unit Tests

```bash
# Crea test
php artisan make:test Modules/Meetup/Tests/Unit/PizzaTest --unit

# Esegui tests modulo specifico
php artisan test Modules/Meetup/Tests/
```

**Esempio test:**

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit;

use Tests\TestCase;
use Modules\Meetup\Models\Pizza;
use Modules\Meetup\Models\Category;

class PizzaTest extends TestCase
{
    public function test_can_create_pizza(): void
    {
        $category = Category::factory()->create();

        $pizza = Pizza::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('meetup_pizzas', [
            'id' => $pizza->id,
            'name' => $pizza->name,
        ]);
    }

    public function test_pizza_belongs_to_category(): void
    {
        $pizza = Pizza::factory()->create();

        $this->assertInstanceOf(Category::class, $pizza->category);
    }
}
```

#### 2.2. Feature Tests

```bash
php artisan make:test Modules/Meetup/Tests/Feature/MenuControllerTest
```

#### 2.3. Browser Tests (Playwright/Puppeteer via MCP)

```
Claude, testa il flusso completo di ordinazione:
1. Homepage
2. Navigazione al menu
3. Selezione pizza
4. Aggiunta al carrello
5. Checkout
6. Conferma ordine
```

### 3. Code Quality

#### 3.1. PHPStan (OBBLIGATORIO - Livello 10)

```bash
# Analizza file modificato
vendor/bin/phpstan analyse --level=10 Modules/Meetup/app/Models/Pizza.php

# Analizza tutto il modulo
vendor/bin/phpstan analyse --level=10 Modules/Meetup/

# Con configurazione modulo (se presente)
cd Modules/Meetup
../../vendor/bin/phpstan analyse --configuration=phpstan.neon
```

**Non procedere MAI senza passare PHPStan livello 10!**

#### 3.2. PHP Pint (Code Formatting)

```bash
# Formatta modulo
vendor/bin/pint Modules/Meetup/

# Dry run (solo preview)
vendor/bin/pint Modules/Meetup/ --test
```

#### 3.3. PHPInsights (opzionale ma consigliato)

```bash
php artisan insights Modules/Meetup/ --no-interaction --min-quality=90
```

#### 3.4. PHPMD (Mess Detector)

```bash
vendor/bin/phpmd Modules/Meetup/app/ text cleancode,codesize,design,naming,unusedcode
```

### 4. Git Workflow

#### 4.1. Branch Strategy

```bash
# Crea branch per feature
git checkout -b feature/meetup-pizza-management

# Lavora sulla feature
# Commit frequenti con messaggi descrittivi

# Quando pronto
git add .
git commit -m "Add pizza management feature

- Created Pizza model and migration
- Implemented PizzaResource for admin
- Added pizza listing page
- Tests for pizza CRUD operations

🤖 Generated with Claude Code

Co-Authored-By: Claude <noreply@anthropic.com>"
```

#### 4.2. Commit Message Format

```
<type>: <subject>

<body>

🤖 Generated with Claude Code

Co-Authored-By: Claude <noreply@anthropic.com>
```

**Types:**
- `feat`: Nuova feature
- `fix`: Bug fix
- `refactor`: Refactoring
- `docs`: Documentazione
- `test`: Tests
- `style`: Formatting, CSS
- `chore`: Manutenzione

### 5. Debugging

#### 5.1. Laravel Telescope (se installato)

```bash
php artisan telescope:install
php artisan migrate

# Accedi a /telescope
```

#### 5.2. Laravel Pail (Log Viewer)

```bash
php artisan pail
```

#### 5.3. Ray Debug Tool (se installato)

```php
// In qualsiasi punto del codice
ray($variable);
ray()->measure();
```

#### 5.4. Xdebug (se configurato)

```bash
# In VS Code/Cursor, aggiungi breakpoint
# Avvia debug con F5
```

### 6. Performance

#### 6.1. Query Optimization

```php
// ❌ N+1 Problem
$pizzas = Pizza::all();
foreach ($pizzas as $pizza) {
    echo $pizza->category->name; // N query
}

// ✅ Eager Loading
$pizzas = Pizza::with('category')->get();
foreach ($pizzas as $pizza) {
    echo $pizza->category->name; // 1 query
}
```

#### 6.2. Caching

```php
use Illuminate\Support\Facades\Cache;

// Cache pizza list
$pizzas = Cache::remember('pizzas.all', 3600, function () {
    return Pizza::with(['category', 'ingredients'])->get();
});
```

#### 6.3. Database Indexing

```php
// In migration
$table->index('category_id');
$table->index('slug');
$table->index(['is_active', 'category_id']);
```

### 7. Asset Building

#### 7.1. Development

```bash
# HMR (Hot Module Replacement)
npm run dev
```

#### 7.2. Production

```bash
# Build ottimizzato
npm run build

# Verifica output in ../public_html/build/
```

#### 7.3. TailwindCSS Purge

TailwindCSS rimuove automaticamente le utility non usate in produzione.

Verifica `content` in `tailwind.config.js`:

```javascript
content: [
  "./Themes/Meetup/resources/**/*.blade.php",
  "./Modules/Meetup/resources/**/*.blade.php",
],
```

## Best Practices

### 1. Segui Architettura Laraxot

- ✅ Estendi `XotBaseResource`, `XotBaseWidget`, `XotBasePage`
- ❌ Non estendere mai classi Filament direttamente
- ✅ Usa Actions invece di Services
- ✅ Usa Data objects per DTOs
- ✅ Usa `declare(strict_types=1);` in tutti i file

### 2. Type Safety

```php
// ✅ GOOD - Fully typed
public function execute(Pizza $pizza, float $discount): float
{
    return $pizza->price * (1 - $discount);
}

// ❌ BAD - No types
public function execute($pizza, $discount)
{
    return $pizza->price * (1 - $discount);
}
```

### 3. Non Ripetere Codice (DRY)

```php
// ✅ GOOD - Riutilizza action
app(GetPizzaListAction::class)->execute($categoryId);

// ❌ BAD - Query duplicata
Pizza::where('category_id', $categoryId)->get();
```

### 4. Traduzioni

**MAI** hardcodare stringhe. Usa translation files.

```php
// ❌ BAD
TextInput::make('name')->label('Nome Pizza');

// ✅ GOOD - Gestito automaticamente da LangServiceProvider
TextInput::make('name');
```

### 5. Security

```php
// Validazione input
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
]);

// Mass assignment protection
protected $fillable = ['name', 'price'];

// Query Builder (protegge da SQL injection)
Pizza::where('name', $request->input('search'))->get();
```

## Risoluzione Problemi Comuni

### Cache non si aggiorna

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Modulo non viene riconosciuto

```bash
composer dump-autoload
php artisan module:list
```

### Assets non si compilano

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Migration error

```bash
# Rollback
php artisan migrate:rollback

# Fresh
php artisan migrate:fresh --seed
```

## Checklist Pre-Commit

Prima di ogni commit, verifica:

- [ ] PHPStan livello 10 passa senza errori
- [ ] PHP Pint formattazione applicata
- [ ] Tests passano (`php artisan test`)
- [ ] Nessun `dd()`, `dump()`, `ray()` nel codice
- [ ] Documentazione aggiornata
- [ ] Changelog aggiornato (se applicabile)
- [ ] Commit message descrittivo

## Risorse

- [Architecture](./architecture.md)
- [Business Logic](./business-logic.md)
- [API Endpoints](./api_endpoints.md)
- [Installation](./INSTALLATION.md)
- [MCP Configuration](./mcp_configuration.md)
- [UI/UX MCP Guide](../../../.cursor/UI_UX_MCP_GUIDE.md)
- [Todo List](./todo.md)

## Supporto

Per domande o problemi:
- Consulta `Modules/Xot/docs/` per documentazione Laraxot
- Vedi issues su GitHub
- Chiedi supporto al team
