# 🚀 FIXCITY - GUIDA RAPIDA SVILUPPATORI

**Versione**: 1.0  
**Data**: 2025-10-01  
**Target**: Sviluppatori che iniziano a lavorare su FixCity  

---

## 📋 PREREQUISITI

### Software Richiesto
- **PHP**: 8.3+
- **Composer**: 2.x
- **Node.js**: 20.x LTS
- **NPM/Yarn**: Latest
- **Database**: PostgreSQL 15+ (o SQLite per sviluppo)
- **Redis**: 7.x (opzionale, per cache e queue)

### Conoscenze Richieste
- Laravel 11.x
- Filament 4.x
- Livewire 3.x
- TailwindCSS
- Architettura modulare (Nwidart)

---

## 🏗️ SETUP INIZIALE

### 1. Clone Repository
```bash
git clone https://github.com/laraxot/fixcity.git
cd fixcity/laravel
```

### 2. Installazione Dipendenze
```bash
# PHP dependencies
composer install

# Node dependencies
cd ../
npm install
```

### 3. Configurazione Ambiente
```bash
# Copia file .env
cp .env.example .env

# Genera application key
php artisan key:generate

# Configura database in .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fixcity
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### 4. Database Setup
```bash
# Esegui migrations
php artisan migrate

# Seed database (opzionale)
php artisan db:seed
```

### 5. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Avvia Server
```bash
# Laravel development server
php artisan serve

# In un altro terminale, Vite dev server
npm run dev
```

Accedi a: http://localhost:8000

---

## 🎯 REGOLE FONDAMENTALI LARAXOT

### ⚠️ CRITICAL: Non Estendere Classi Base Direttamente

**MAI FARE**:
```php
use Filament\Resources\Resource;

class TicketResource extends Resource  // ❌ SBAGLIATO
{
    // ...
}
```

**SEMPRE FARE**:
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class TicketResource extends XotBaseResource  // ✅ CORRETTO
{
    // ...
}
```

### 📚 Classi Base da Usare

#### Filament Resources
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    // Usa getFormSchema() invece di form()
    public static function getFormSchema(): array
    {
        return [
            // schema fields
        ];
    }
    
    // NON definire table() method
}
```

#### Filament Pages (List)
```php
use Modules\Xot\Filament\Pages\XotBaseListRecords;

class ListTickets extends XotBaseListRecords
{
    // Metodi specifici
    public function getTableColumns(): array { }
    public function getTableFilters(): array { }
    public function getTableActions(): array { }
    public function getTableBulkActions(): array { }
}
```

#### Migrations
```php
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    // Usa tableCreate() e tableUpdate()
    // NON override down() method (è final)
};
```

#### Service Providers
```php
use Modules\Xot\Providers\XotBaseServiceProvider;

class MyServiceProvider extends XotBaseServiceProvider
{
    protected string $moduleName = 'ModuleName';
    protected string $moduleNameLower = 'modulename';
    
    public function boot(): void
    {
        parent::boot(); // SEMPRE chiamare parent
        // ...
    }
}
```

---

## 🚫 COSA NON FARE MAI

### 1. NON Usare ->label() in Filament
```php
// ❌ SBAGLIATO
TextInput::make('name')
    ->label('Nome')
    ->required();

// ✅ CORRETTO - usa traduzioni
TextInput::make('name')
    ->required();
```

Le label vengono gestite automaticamente da `LangServiceProvider` tramite file di traduzione.

### 2. NON Definire table() in Resources
```php
// ❌ SBAGLIATO
public static function table(Table $table): Table
{
    return $table->columns([...]);
}

// ✅ CORRETTO - usa getTableColumns() nella ListPage
```

### 3. NON Usare array numerici per componenti
```php
// ❌ SBAGLIATO
return [
    TextInput::make('name'),
    TextInput::make('email'),
];

// ✅ CORRETTO - usa array associativi
return [
    'name' => TextInput::make('name'),
    'email' => TextInput::make('email'),
];
```

---

## 📁 STRUTTURA PROGETTO

```
base_fixcity_fila5_mono/
├── laravel/                    # Applicazione Laravel
│   ├── Modules/               # Moduli Nwidart
│   │   ├── Fixcity/          # Core business logic
│   │   ├── User/             # Authentication
│   │   ├── Xot/              # Framework base
│   │   ├── UI/               # Component library
│   │   └── ...
│   ├── Themes/               # Temi Folio
│   │   ├── Sixteen/          # Frontend theme (AGID)
│   │   └── TwentyOne/        # Admin theme
│   └── app/                  # Laravel app standard
├── project_docs/             # Documentazione progetto
│   └── roadmaps/            # Roadmap strategiche
├── bashscripts/             # Script utility
└── DOCUMENTATION_INDEX.md   # Indice documentazione
```

---

## 🔧 COMANDI UTILI

### Development
```bash
# PHPStan analysis
./vendor/bin/phpstan analyse --level=9

# Run tests
php artisan test
./vendor/bin/pest

# Clear cache
php artisan optimize:clear

# Generate IDE helper
php artisan ide-helper:generate
php artisan ide-helper:models
```

### Moduli
```bash
# Lista moduli
php artisan module:list

# Crea nuovo modulo
php artisan module:make ModuleName

# Abilita modulo
php artisan module:enable ModuleName

# Pubblica assets modulo
php artisan module:publish ModuleName
```

### Filament
```bash
# Crea resource
php artisan make:filament-resource TicketResource --module=Fixcity

# Crea page
php artisan make:filament-page Dashboard --module=Fixcity

# Crea widget
php artisan make:filament-widget StatsWidget --module=Fixcity
```

---

## 🎨 WORKFLOW SVILUPPO

### 1. Crea Feature Branch
```bash
git checkout -b feature/nome-feature
```

### 2. Sviluppa Seguendo Regole
- Estendi sempre classi XotBase
- Usa traduzioni per label
- Segui PSR-12
- Type hints obbligatori
- PHPStan Level 9 compliant

### 3. Test
```bash
# Run PHPStan
./vendor/bin/phpstan analyse Modules/ModuleName --level=9

# Run tests
php artisan test --filter=ModuleName
```

### 4. Commit
```bash
git add .
git commit -m "feat(module): descrizione feature"
```

### 5. Push e Pull Request
```bash
git push origin feature/nome-feature
# Crea PR su GitHub
```

---

## 📚 TRADUZIONI

### Struttura File Lang
```php
// lang/it/modulename.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Inserisci il nome',
            'placeholder' => 'Es: Mario Rossi',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'tooltip' => 'Crea nuovo record',
        ],
    ],
];
```

### Uso nelle Risorse
```php
// Automatico tramite LangServiceProvider
TextInput::make('name')  // Label: "Nome" da lang file
    ->required();
```

---

## 🧪 TESTING

### Unit Test
```php
use Tests\TestCase;

class TicketTest extends TestCase
{
    public function test_can_create_ticket(): void
    {
        $ticket = Ticket::factory()->create();
        
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
        ]);
    }
}
```

### Feature Test
```php
use Tests\TestCase;

class TicketResourceTest extends TestCase
{
    public function test_can_list_tickets(): void
    {
        $this->actingAs($user = User::factory()->create());
        
        $response = $this->get(route('filament.admin.resources.tickets.index'));
        
        $response->assertSuccessful();
    }
}
```

---

## 🐛 DEBUG

### Laravel Telescope
```bash
# Installa Telescope (se non presente)
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Accedi a: http://localhost:8000/telescope

### Laravel Debugbar
```bash
# Installa Debugbar
composer require barryvdh/laravel-debugbar --dev
```

### Log Files
```bash
# Tail logs
tail -f storage/logs/laravel.log

# Clear logs
> storage/logs/laravel.log
```

---

## 📖 DOCUMENTAZIONE MODULI

Ogni modulo ha la sua documentazione in `Modules/ModuleName/docs/`:

- **README.md**: Panoramica modulo
- **ROADMAP_2025.md**: Roadmap dettagliata
- **structure.md**: Struttura file
- **technical.md**: Dettagli tecnici

**Esempio**: [Fixcity Module Docs](./laravel/Modules/Fixcity/docs/)

---

## 🎯 BEST PRACTICES

### 1. Code Quality
- ✅ PHPStan Level 9
- ✅ PSR-12 compliant
- ✅ Type hints obbligatori
- ✅ Return types espliciti
- ✅ Strict types: `declare(strict_types=1);`

### 2. Filament Resources
- ✅ Estendi XotBaseResource
- ✅ Usa getFormSchema()
- ✅ NON definire table()
- ✅ NON usare ->label()
- ✅ Array associativi per componenti

### 3. Migrations
- ✅ Estendi XotBaseMigration
- ✅ Usa tableCreate() / tableUpdate()
- ✅ NON override down()
- ✅ Use updateTimestamps()

### 4. Traduzioni
- ✅ Struttura espansa per fields
- ✅ Struttura espansa per actions
- ✅ NON hardcodare testi
- ✅ Supporto multilingua

---

## 🔗 LINK UTILI

### Documentazione
- **[Indice Documentazione](./DOCUMENTATION_INDEX.md)**
- **[Roadmap Status](./ROADMAP_STATUS_SUMMARY.md)**
- **[Documentation Status](./project_docs/DOCUMENTATION_STATUS.md)**

### Framework
- **[Laravel Docs](https://laravel.com/docs/11.x)**
- **[Filament Docs](https://filamentphp.com/docs/3.x)**
- **[Livewire Docs](https://livewire.laravel.com/docs)**

### Regole Progetto
- **[Laraxot Rules](./.windsurf/rules/user_15338591596331277449.md)**
- **[Code Quality](./.windsurf/rules/code-quality.md)**
- **[Project Rules](./.windsurf/rules/project-rules.md)**

---

## 🆘 TROUBLESHOOTING

### Problema: Errori PHPStan
**Soluzione**: Verifica di estendere classi XotBase e non classi Laravel/Filament dirette

### Problema: Label non visualizzate
**Soluzione**: Verifica file traduzioni in `lang/it/modulename.php`

### Problema: Migration fallisce
**Soluzione**: Verifica di estendere XotBaseMigration e non Migration standard

### Problema: Assets non caricati
**Soluzione**: 
```bash
npm run build
php artisan optimize:clear
```

---

## 📞 SUPPORTO

### Team
- **Slack**: #fixcity-dev
- **Email**: dev@fixcity.it

### Documentazione
- **Issues**: [GitHub Issues](https://github.com/laraxot/fixcity/issues)
- **Discussions**: [GitHub Discussions](https://github.com/laraxot/fixcity/discussions)

---


---

*Per contribuire al progetto, leggi attentamente questa guida e le regole Laraxot. In caso di dubbi, consulta la
documentazione del modulo specifico o chiedi supporto al team.*
