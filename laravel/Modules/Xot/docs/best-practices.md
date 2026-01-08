# Best Practices

## Laravel
- Utilizzare sempre i Data Transfer Objects (DTO) di Spatie per la gestione dei dati
- Preferire le QueableActions di Spatie invece dei Services
- Seguire le convenzioni PSR-12 per il codice
- Utilizzare i tipi di ritorno e i parametri tipizzati
- Implementare le interfacce per le dipendenze
- Utilizzare i Repository Pattern per l'accesso ai dati
- Implementare il Model Context Protocol per la gestione del contesto

## Database
- Utilizzare le migrazioni per tutte le modifiche al database
- Implementare gli indici appropriati
- Utilizzare le foreign key constraints
- Implementare il soft delete dove appropriato
- Utilizzare le transazioni per operazioni multiple

## Testing
- Scrivere test unitari per la logica di business
- Scrivere test di integrazione per le API
- Utilizzare i factory per i test
- Implementare il test coverage
- Utilizzare i database in memoria per i test

## Sicurezza
- Implementare la validazione dei dati
- Utilizzare l'escape appropriato per l'output
- Implementare l'autenticazione e l'autorizzazione
- Utilizzare HTTPS
- Implementare il rate limiting
- Proteggere contro CSRF e XSS

## Performance
- Utilizzare il caching appropriato
- Ottimizzare le query del database
- Implementare la paginazione
- Utilizzare le code per i task pesanti
- Implementare il lazy loading

## Code Review
- Verificare la conformità con le convenzioni
- Controllare la sicurezza
- Verificare la performance
- Controllare la manutenibilità
- Verificare la testabilità
# 🔧 **Best Practices Modulo Xot**

## 📋 **Panoramica**

Questo documento contiene le best practices essenziali per sviluppare moduli che estendono il modulo Xot, seguendo i principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**.

## 🎯 **Principi Fondamentali**

### **DRY (Don't Repeat Yourself)**
- **Centralizzazione**: Utilizzare sempre le classi base Xot
- **Riusabilità**: Creare trait e classi astratte per funzionalità comuni
- **Manutenibilità**: Evitare duplicazioni di codice

### **KISS (Keep It Simple, Stupid)**
- **Semplicità**: Mantenere il codice semplice e leggibile
- **Chiarezza**: Naming esplicito e autoesplicativo
- **Linearità**: Strutture lineari e intuitive

### **SOLID**
- **Single Responsibility**: Ogni classe ha una sola responsabilità
- **Open/Closed**: Estendibile senza modificare il codice esistente
- **Liskov Substitution**: Sottoclassi perfettamente sostituibili
- **Interface Segregation**: Interfacce specifiche e focalizzate
- **Dependency Inversion**: Dipendenze da astrazioni

### **Robust**
- **Gestione errori**: Gestire sempre le eccezioni
- **Validazione**: Validare tutti gli input
- **Fallback**: Prevedere meccanismi di recupero

### **Laraxot**
- **Convenzioni**: Seguire sempre le convenzioni del framework
- **Modularità**: Mantenere i moduli isolati e indipendenti
- **Integrazione**: Utilizzare i componenti nativi quando possibile

## 🏗️ **Classi Base e Ereditarietà**

### **1. Sempre Estendere Classi Base Xot**

```php
// ✅ CORRETTO
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Providers\XotBaseServiceProvider;

class MioModello extends BaseModel
{
    // Implementazione
}

class MiaRisorsa extends XotBaseResource
{
    // Implementazione
}

class MioServiceProvider extends XotBaseServiceProvider
{
    // Implementazione
}

// ❌ ERRATO - Mai estendere direttamente le classi Laravel
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Resource;
use Illuminate\Support\ServiceProvider;

class MioModello extends Model // ❌ ERRATO
class MiaRisorsa extends Resource // ❌ ERRATO
class MioServiceProvider extends ServiceProvider // ❌ ERRATO
```

### **2. Utilizzare i Trait Xot**

```php
use Modules\Xot\Models\Traits\HasXotTable;
use Modules\Xot\Models\Traits\HasExtra;

class MioModello extends BaseModel
{
    use HasXotTable, HasExtra;
    
    // Implementazione specifica
}
```

## 📝 **Convenzioni Naming**

### **1. Nomi delle Classi**
```php
// ✅ CORRETTO - PascalCase
class UserProfile extends BaseModel
class ProductCategory extends BaseModel
class OrderItem extends BaseModel

// ❌ ERRATO
class user_profile extends BaseModel
class productcategory extends BaseModel
```

### **2. Nomi dei Metodi**
```php
// ✅ CORRETTO - camelCase
public function getUserProfile(): UserProfile
public function createProductCategory(): ProductCategory
public function updateOrderItem(): bool

// ❌ ERRATO
public function get_user_profile(): UserProfile
public function createproductcategory(): ProductCategory
```

### **3. Nomi delle Proprietà**
```php
// ✅ CORRETTO - snake_case
protected $fillable = ['user_id', 'product_name'];
protected $hidden = ['password', 'remember_token'];
protected $casts = ['is_active' => 'boolean'];

// ❌ ERRATO
protected $fillable = ['userId', 'productName'];
protected $hidden = ['Password', 'RememberToken'];
```

### **4. Nomi delle Tabelle**
```php
// ✅ CORRETTO - snake_case, plurale
protected $table = 'user_profiles';
protected $table = 'product_categories';
protected $table = 'order_items';

// ❌ ERRATO
protected $table = 'UserProfile';
protected $table = 'productCategory';
protected $table = 'order_item';
```

## 🔧 **Implementazione Modelli**

### **1. Struttura Standard del Modello**

```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\app\Models;

use Modules\Xot\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nome
 * @property string $descrizione
 * @property bool $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\MioModulo\app\Models\AltroModello> $altri_modelli
 */
class MioModello extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'descrizione',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related models.
     */
    public function altriModelli(): HasMany
    {
        return $this->hasMany(AltroModello::class);
    }
}
```

### **2. Gestione Campi Extra**

```php
// ✅ CORRETTO - Utilizzare i metodi Xot per i campi extra
$modello->setExtra('campo_custom', 'valore');
$valore = $modello->getExtra('campo_custom');

// ❌ ERRATO - Non accedere direttamente alla proprietà extra
$modello->extra['campo_custom'] = 'valore'; // ❌ ERRATO
```

## 🎨 **Implementazione Risorse Filament**

### **1. Struttura Standard della Risorsa**

```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\app\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Tables;

/**
 * @property-read \Modules\MioModulo\app\Models\MioModello $record
 */
class MioModelloResource extends XotBaseResource
{
    protected static ?string $model = \Modules\MioModulo\app\Models\MioModello::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Mio Modulo';

    /**
     * Get the form schema for the resource.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nome')
                ->required()
                ->maxLength(255),
                
            Forms\Components\Textarea::make('descrizione')
                ->maxLength(1000)
                ->columnSpanFull(),
                
            Forms\Components\Toggle::make('is_active')
                ->required(),
        ];
    }

    /**
     * Get the table columns for the resource.
     *
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('descrizione')
                ->limit(50),
                
            Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
```

### **2. Azioni Personalizzate**

```php
/**
 * Get the table actions for the resource.
 *
 * @return array<string, \Filament\Tables\Actions\Action>
 */
public static function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
        
        // Azione personalizzata
        Tables\Actions\Action::make('custom_action')
            ->icon('heroicon-o-star')
            ->action(function (MioModello $record): void {
                // Logica dell'azione
            }),
    ];
}
```

## 🔌 **Implementazione Service Provider**

### **1. Struttura Standard del Service Provider**

```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Service provider for the MioModulo module.
 */
class MioModuloServiceProvider extends XotBaseServiceProvider
{
    /**
     * The module namespace.
     */
    protected string $module_name = 'MioModulo';

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        
        // Personalizzazioni specifiche del modulo
        $this->registerCustomComponents();
        $this->registerCustomCommands();
    }

    /**
     * Register custom components.
     */
    protected function registerCustomComponents(): void
    {
        // Registrazione componenti custom
    }

    /**
     * Register custom commands.
     */
    protected function registerCustomCommands(): void
    {
        // Registrazione comandi custom
    }
}
```

## 🗄️ **Implementazione Migrazioni**

### **1. Struttura Standard della Migrazione**

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * The name of the table.
     */
    protected string $table_name = 'mio_modello';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if ($this->hasTable($this->table_name)) {
            return;
        }

        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descrizione')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Indici per performance
            $table->index(['user_id', 'is_active']);
            $table->index('nome');
        });

        $this->tableComment($this->table_name, 'Tabella per i modelli personalizzati');
    }
};
```

### **2. Aggiornamento Tabelle Esistenti**

```php
public function up(): void
{
    if (! $this->hasTable($this->table_name)) {
        // Crea la tabella se non esiste
        Schema::create($this->table_name, function (Blueprint $table) {
            // Schema completo
        });
        return;
    }

    // Aggiungi solo le nuove colonne se la tabella esiste
    if (! $this->hasColumn($this->table_name, 'nuova_colonna')) {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->string('nuova_colonna')->nullable();
        });
    }
}
```

## 🧪 **Testing Best Practices**

### **1. Struttura Standard dei Test**

```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\Tests;

use Modules\Xot\Tests\XotBaseTestCase;
use Modules\MioModulo\app\Models\MioModello;
use Modules\User\app\Models\User;

class MioModelloTest extends XotBaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup comune per tutti i test
    }

    /** @test */
    public function it_can_create_model(): void
    {
        $user = User::factory()->create();
        
        $modello = MioModello::create([
            'nome' => 'Test Model',
            'descrizione' => 'Test Description',
            'is_active' => true,
            'user_id' => $user->id,
        ]);

        $this->assertModelExists($modello);
        $this->assertEquals('Test Model', $modello->nome);
        $this->assertTrue($modello->is_active);
    }

    /** @test */
    public function it_can_update_model(): void
    {
        $modello = MioModello::factory()->create();
        
        $modello->update(['nome' => 'Updated Name']);
        
        $this->assertEquals('Updated Name', $modello->fresh()->nome);
    }

    /** @test */
    public function it_can_delete_model(): void
    {
        $modello = MioModello::factory()->create();
        
        $modello->delete();
        
        $this->assertModelMissing($modello);
    }
}
```

### **2. Factory per i Modelli**

```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MioModulo\app\Models\MioModello;
use Modules\User\app\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\MioModulo\app\Models\MioModello>
 */
class MioModelloFactory extends Factory
{
    protected $model = MioModello::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence(3),
            'descrizione' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(80),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the model is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the model is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
```

## 🔒 **Sicurezza e Validazione**

### **1. Validazione dei Modelli**

```php
/**
 * Get the validation rules for the model.
 */
public static function rules(): array
{
    return [
        'nome' => ['required', 'string', 'max:255'],
        'descrizione' => ['nullable', 'string', 'max:1000'],
        'is_active' => ['required', 'boolean'],
        'user_id' => ['required', 'exists:users,id'],
    ];
}

/**
 * Get the validation messages for the model.
 */
public static function messages(): array
{
    return [
        'nome.required' => 'Il nome è obbligatorio',
        'nome.max' => 'Il nome non può superare i 255 caratteri',
        'descrizione.max' => 'La descrizione non può superare i 1000 caratteri',
        'user_id.exists' => 'L\'utente selezionato non esiste',
    ];
}
```

### **2. Autorizzazione**

```php
/**
 * Determine if the user can view the model.
 */
public function canView(User $user): bool
{
    return $user->can('view', $this);
}

/**
 * Determine if the user can update the model.
 */
public function canUpdate(User $user): bool
{
    return $user->can('update', $this);
}

/**
 * Determine if the user can delete the model.
 */
public function canDelete(User $user): bool
{
    return $user->can('delete', $this);
}
```

## 📈 **Performance e Ottimizzazione**

### **1. Eager Loading per Relazioni**

```php
// ✅ CORRETTO - Utilizzare eager loading
$modelli = MioModello::with(['user', 'altriModelli'])->get();

// ❌ ERRATO - N+1 query problem
$modelli = MioModello::all();
foreach ($modelli as $modello) {
    echo $modello->user->name; // Query aggiuntiva per ogni modello
}
```

### **2. Indici per Performance**

```php
// Aggiungere indici per colonne frequentemente utilizzate
$table->index(['user_id', 'is_active']);
$table->index('nome');
$table->index('created_at');
```

### **3. Caching**

```php
// Utilizzare il caching per dati costosi da calcolare
public function getComputedValueAttribute(): string
{
    return cache()->remember(
        "modello_{$this->id}_computed_value",
        now()->addMinutes(30),
        fn() => $this->computeValue()
    );
}
```

## 🚨 **Anti-Pattern da Evitare**

### **1. Non Estendere Classi Laravel Direttamente**

```php
// ❌ ERRATO
class MioModello extends \Illuminate\Database\Eloquent\Model
class MiaRisorsa extends \Filament\Resources\Resource
class MioServiceProvider extends \Illuminate\Support\ServiceProvider

// ✅ CORRETTO
class MioModello extends BaseModel
class MiaRisorsa extends XotBaseResource
class MioServiceProvider extends XotBaseServiceProvider
```

### **2. Non Duplicare Funzionalità Base**

```php
// ❌ ERRATO - Non reimplementare funzionalità già presenti nelle classi base
public function boot(): void
{
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'mio-modulo');
    $this->loadTranslationsFrom(__DIR__.'/../lang', 'mio-modulo');
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
}

// ✅ CORRETTO - Utilizzare il parent che già gestisce tutto
public function boot(): void
{
    parent::boot();
    // Solo personalizzazioni specifiche
}
```

### **3. Non Ignorare la Gestione Errori**

```php
// ❌ ERRATO - Non gestire le eccezioni
public function createModel(array $data): MioModello
{
    return MioModello::create($data); // Può fallire silenziosamente
}

// ✅ CORRETTO - Gestire sempre le eccezioni
public function createModel(array $data): MioModello
{
    try {
        return MioModello::create($data);
    } catch (\Exception $e) {
        Log::error('Errore nella creazione del modello', [
            'data' => $data,
            'error' => $e->getMessage()
        ]);
        throw new ModelCreationException('Impossibile creare il modello', 0, $e);
    }
}
```

## 🔗 **Collegamenti e Riferimenti**

- [**README.md**](README.md) - Documentazione principale del modulo
- [**Architettura**](architecture.md) - Architettura del modulo Xot
- [**Best Practices Globali**](../docs/best-practices.md) - Best practices globali

---

*Ultimo aggiornamento: giugno 2025 - Versione 2.0.0*
