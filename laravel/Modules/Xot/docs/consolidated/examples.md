# 💡 **Esempi Modulo Xot**

## 📋 **Panoramica**

Questo documento contiene esempi pratici e casi d'uso per sviluppare moduli che estendono il modulo Xot, seguendo i principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**.

## 🏗️ **Esempi di Modelli**

### **1. Modello Base Completo**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\app\Models;

use Modules\Xot\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $nome
 * @property string $descrizione
 * @property bool $is_active
 * @property int $user_id
 * @property int $category_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\User\app\Models\User $user
 * @property-read \Modules\Example\app\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Example\app\Models\Tag> $tags
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Example\app\Models\Comment> $comments
 */
class Example extends BaseModel
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
        'user_id',
        'category_id',
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
     * Get the user that owns the example.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for the example.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags for the example.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'example_tag')
            ->withTimestamps()
            ->withPivot('added_at');
    }

    /**
     * Get the comments for the example.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a query to only include active examples.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include examples by user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->nome} - {$this->category->nome}";
    }

    /**
     * Check if the example is recent.
     */
    public function isRecent(): bool
    {
        return $this->created_at->isAfter(now()->subDays(7));
    }

    /**
     * Activate the example.
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Deactivate the example.
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }
}
```

### **2. Modello con Campi Extra**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\app\Models;

use Modules\Xot\Models\BaseModel;

class ExampleWithExtra extends BaseModel
{
    protected $fillable = ['nome', 'tipo'];

    /**
     * Get custom field from extra.
     */
    public function getCustomField(string $key, $default = null)
    {
        return $this->getExtra($key, $default);
    }

    /**
     * Set custom field in extra.
     */
    public function setCustomField(string $key, $value): void
    {
        $this->setExtra($key, $value);
    }

    /**
     * Check if custom field exists.
     */
    public function hasCustomField(string $key): bool
    {
        return $this->hasExtra($key);
    }

    /**
     * Remove custom field.
     */
    public function removeCustomField(string $key): void
    {
        $this->removeExtra($key);
    }
}

// Utilizzo
$example = new ExampleWithExtra();
$example->setCustomField('priority', 'high');
$example->setCustomField('tags', ['urgent', 'important']);

$priority = $example->getCustomField('priority', 'medium');
$tags = $example->getCustomField('tags', []);
```

## 🎨 **Esempi di Risorse Filament**

### **1. Risorsa Base Completa**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\app\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * @property-read \Modules\Example\app\Models\Example $record
 */
class ExampleResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Example\app\Models\Example::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Example Module';
    protected static ?int $navigationSort = 1;

    /**
     * Get the form schema for the resource.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informazioni Base')
                ->description('Dettagli principali dell\'esempio')
                ->schema([
                    Forms\Components\TextInput::make('nome')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Inserisci il nome dell\'esempio'),
                        
                    Forms\Components\Textarea::make('descrizione')
                        ->label('Descrizione')
                        ->maxLength(1000)
                        ->placeholder('Inserisci una descrizione dettagliata')
                        ->columnSpanFull(),
                        
                    Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true)
                        ->helperText('Determina se l\'esempio è attivo'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Relazioni')
                ->description('Collegamenti con altri moduli')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Utente')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Seleziona un utente'),
                        
                    Forms\Components\Select::make('category_id')
                        ->label('Categoria')
                        ->relationship('category', 'nome')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->placeholder('Seleziona una categoria'),
                        
                    Forms\Components\Select::make('tags')
                        ->label('Tag')
                        ->relationship('tags', 'nome')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->placeholder('Seleziona i tag'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Campi Extra')
                ->description('Campi personalizzati aggiuntivi')
                ->schema([
                    Forms\Components\KeyValue::make('extra_fields')
                        ->label('Campi Extra')
                        ->keyLabel('Chiave')
                        ->valueLabel('Valore')
                        ->helperText('Aggiungi campi personalizzati'),
                ])
                ->collapsible()
                ->collapsed(),
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
                ->label('Nome')
                ->searchable()
                ->sortable()
                ->limit(50),
                
            Tables\Columns\TextColumn::make('descrizione')
                ->label('Descrizione')
                ->limit(100)
                ->searchable(),
                
            Tables\Columns\TextColumn::make('user.name')
                ->label('Utente')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('category.nome')
                ->label('Categoria')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\IconColumn::make('is_active')
                ->label('Stato')
                ->boolean()
                ->sortable()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),
                
            Tables\Columns\TextColumn::make('tags.nome')
                ->label('Tag')
                ->badge()
                ->separator(',')
                ->color('info'),
                
            Tables\Columns\TextColumn::make('created_at')
                ->label('Creato il')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Aggiornato il')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Get the table filters for the resource.
     *
     * @return array<int, \Filament\Tables\Filters\Filter>
     */
    public static function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('is_active')
                ->label('Solo Attivi')
                ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                
            Tables\Filters\SelectFilter::make('category_id')
                ->label('Categoria')
                ->relationship('category', 'nome')
                ->searchable()
                ->preload(),
                
            Tables\Filters\SelectFilter::make('user_id')
                ->label('Utente')
                ->relationship('user', 'name')
                ->searchable()
                ->preload(),
                
            Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')
                        ->label('Creato da'),
                    Forms\Components\DatePicker::make('created_until')
                        ->label('Creato fino a'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
        ];
    }

    /**
     * Get the table actions for the resource.
     *
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            
            Tables\Actions\Action::make('activate')
                ->label('Attiva')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => ! $record->is_active)
                ->action(fn ($record) => $record->activate())
                ->requiresConfirmation()
                ->modalHeading('Attivare Esempio')
                ->modalDescription('Sei sicuro di voler attivare questo esempio?')
                ->modalSubmitActionLabel('Attiva'),
                
            Tables\Actions\Action::make('deactivate')
                ->label('Disattiva')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn ($record) => $record->is_active)
                ->action(fn ($record) => $record->deactivate())
                ->requiresConfirmation()
                ->modalHeading('Disattivare Esempio')
                ->modalDescription('Sei sicuro di voler disattivare questo esempio?')
                ->modalSubmitActionLabel('Disattiva'),
        ];
    }

    /**
     * Get the table bulk actions for the resource.
     *
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public static function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                
                Tables\Actions\BulkAction::make('activate')
                    ->label('Attiva Selezionati')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($records) {
                        $records->each->activate();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Attivare Esempi Selezionati')
                    ->modalDescription('Sei sicuro di voler attivare gli esempi selezionati?')
                    ->modalSubmitActionLabel('Attiva'),
                    
                Tables\Actions\BulkAction::make('deactivate')
                    ->label('Disattiva Selezionati')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function ($records) {
                        $records->each->deactivate();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Disattivare Esempi Selezionati')
                    ->modalDescription('Sei sicuro di voler disattivare gli esempi selezionati?')
                    ->modalSubmitActionLabel('Disattiva'),
            ]),
        ];
    }

    /**
     * Get the table query builder for the resource.
     */
    public static function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc');
    }
}
```

### **2. Risorsa con Azioni Personalizzate**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\app\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions\Action;

class ExampleWithCustomActionsResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Example\app\Models\Example::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nome')
                ->required(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome')
                ->searchable()
                ->sortable(),
        ];
    }

    /**
     * Get the header actions for the resource.
     *
     * @return array<string, \Filament\Actions\Action>
     */
    public static function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Importa')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('File CSV')
                        ->acceptedFileTypes(['text/csv'])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    // Logica di importazione
                })
                ->successNotificationTitle('Importazione completata'),
                
            Action::make('export')
                ->label('Esporta')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function (): void {
                    // Logica di esportazione
                })
                ->successNotificationTitle('Esportazione completata'),
        ];
    }
}
```

## 🔌 **Esempi di Service Provider**

### **1. Service Provider Base**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Example\app\Models\Example;
use Modules\Example\app\Policies\ExamplePolicy;

/**
 * Service provider for the Example module.
 */
class ExampleServiceProvider extends XotBaseServiceProvider
{
    /**
     * The module namespace.
     */
    protected string $module_name = 'Example';

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        
        // Registrazione policy
        $this->registerPolicies();
        
        // Registrazione comandi
        $this->registerCommands();
        
        // Registrazione componenti custom
        $this->registerCustomComponents();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();
        
        // Registrazione servizi
        $this->registerServices();
        
        // Registrazione repository
        $this->registerRepositories();
    }

    /**
     * Register policies for the module.
     */
    protected function registerPolicies(): void
    {
        Gate::policy(Example::class, ExamplePolicy::class);
    }

    /**
     * Register commands for the module.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Modules\Example\app\Console\Commands\ExampleCommand::class,
            ]);
        }
    }

    /**
     * Register custom components.
     */
    protected function registerCustomComponents(): void
    {
        // Registrazione componenti Livewire
        \Livewire\Livewire::component('example::example-component', 
            \Modules\Example\app\Livewire\ExampleComponent::class);
            
        // Registrazione componenti Blade
        \Blade::component('example::example-card', 
            \Modules\Example\app\View\Components\ExampleCard::class);
    }

    /**
     * Register services.
     */
    protected function registerServices(): void
    {
        $this->app->singleton(\Modules\Example\app\Services\ExampleService::class);
        $this->app->singleton(\Modules\Example\app\Services\ExampleValidationService::class);
    }

    /**
     * Register repositories.
     */
    protected function registerRepositories(): void
    {
        $this->app->bind(
            \Modules\Example\app\Repositories\ExampleRepositoryInterface::class,
            \Modules\Example\app\Repositories\ExampleRepository::class
        );
    }
}
```

### **2. Service Provider con Configurazione**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Illuminate\Support\Facades\Config;

class ExampleWithConfigServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = 'Example';

    public function boot(): void
    {
        parent::boot();
        
        // Pubblica configurazione
        $this->publishes([
            __DIR__.'/../config/example.php' => config_path('example.php'),
        ], 'example-config');
        
        // Carica configurazione
        $this->mergeConfigFrom(
            __DIR__.'/../config/example.php', 'example'
        );
        
        // Carica routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    public function register(): void
    {
        parent::register();
        
        // Registra configurazione
        $this->app->singleton('example.config', function () {
            return Config::get('example');
        });
    }
}
```

## 🗄️ **Esempi di Migrazioni**

### **1. Migrazione Base**

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
    protected string $table_name = 'examples';

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
            
            // Campi base
            $table->string('nome');
            $table->text('descrizione')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Relazioni
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Campi extra (gestiti da Xot)
            $table->json('extra')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indici per performance
            $table->index(['user_id', 'is_active']);
            $table->index(['category_id', 'is_active']);
            $table->index('nome');
            $table->index('created_at');
            
            // Vincoli univoci
            $table->unique(['user_id', 'nome']);
        });

        // Commenti per documentazione
        $this->tableComment($this->table_name, 'Tabella per gli esempi del modulo');
        $this->columnComment($this->table_name, 'nome', 'Nome dell\'esempio');
        $this->columnComment($this->table_name, 'descrizione', 'Descrizione dettagliata');
        $this->columnComment($this->table_name, 'is_active', 'Stato di attivazione');
    }
};
```

### **2. Migrazione con Aggiornamento**

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected string $table_name = 'examples';

    public function up(): void
    {
        if (! $this->hasTable($this->table_name)) {
            // Crea la tabella se non esiste
            Schema::create($this->table_name, function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->text('descrizione')->nullable();
                $table->boolean('is_active')->default(true);
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->json('extra')->nullable();
                $table->timestamps();
                
                $table->index(['user_id', 'is_active']);
                $table->index('nome');
            });
            
            $this->tableComment($this->table_name, 'Tabella per gli esempi');
            return;
        }

        // Aggiungi nuove colonne se la tabella esiste
        
        if (! $this->hasColumn($this->table_name, 'priority')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->enum('priority', ['low', 'medium', 'high'])
                    ->default('medium')
                    ->after('is_active');
            });
            
            $this->columnComment($this->table_name, 'priority', 'Priorità dell\'esempio');
        }

        if (! $this->hasColumn($this->table_name, 'due_date')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->date('due_date')->nullable()->after('priority');
            });
            
            $this->columnComment($this->table_name, 'due_date', 'Data di scadenza');
        }

        if (! $this->hasColumn($this->table_name, 'tags')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->json('tags')->nullable()->after('due_date');
            });
            
            $this->columnComment($this->table_name, 'tags', 'Tag associati all\'esempio');
        }

        // Aggiungi indici per le nuove colonne
        if (! $this->hasIndex($this->table_name, 'examples_priority_index')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->index('priority');
            });
        }

        if (! $this->hasIndex($this->table_name, 'examples_due_date_index')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->index('due_date');
            });
        }
    }
};
```

## 🧪 **Esempi di Testing**

### **1. Test Base**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Tests;

use Modules\Xot\Tests\XotBaseTestCase;
use Modules\Example\app\Models\Example;
use Modules\User\app\Models\User;
use Modules\Example\app\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends XotBaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup comune per tutti i test
    }

    /** @test */
    public function it_can_create_example(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        
        $example = Example::create([
            'nome' => 'Test Example',
            'descrizione' => 'Test Description',
            'is_active' => true,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $this->assertModelExists($example);
        $this->assertEquals('Test Example', $example->nome);
        $this->assertTrue($example->is_active);
        $this->assertEquals($user->id, $example->user_id);
        $this->assertEquals($category->id, $example->category_id);
    }

    /** @test */
    public function it_can_update_example(): void
    {
        $example = Example::factory()->create();
        
        $example->update([
            'nome' => 'Updated Example',
            'is_active' => false,
        ]);
        
        $this->assertEquals('Updated Example', $example->fresh()->nome);
        $this->assertFalse($example->fresh()->is_active);
    }

    /** @test */
    public function it_can_delete_example(): void
    {
        $example = Example::factory()->create();
        
        $example->delete();
        
        $this->assertModelMissing($example);
    }

    /** @test */
    public function it_can_activate_example(): void
    {
        $example = Example::factory()->create(['is_active' => false]);
        
        $result = $example->activate();
        
        $this->assertTrue($result);
        $this->assertTrue($example->fresh()->is_active);
    }

    /** @test */
    public function it_can_deactivate_example(): void
    {
        $example = Example::factory()->create(['is_active' => true]);
        
        $result = $example->deactivate();
        
        $this->assertTrue($result);
        $this->assertFalse($example->fresh()->is_active);
    }

    /** @test */
    public function it_can_get_full_name(): void
    {
        $category = Category::factory()->create(['nome' => 'Test Category']);
        $example = Example::factory()->create([
            'nome' => 'Test Example',
            'category_id' => $category->id,
        ]);
        
        $fullName = $example->full_name;
        
        $this->assertEquals('Test Example - Test Category', $fullName);
    }

    /** @test */
    public function it_can_check_if_recent(): void
    {
        $example = Example::factory()->create([
            'created_at' => now()->subDays(3),
        ]);
        
        $this->assertTrue($example->isRecent());
        
        $oldExample = Example::factory()->create([
            'created_at' => now()->subDays(10),
        ]);
        
        $this->assertFalse($oldExample->isRecent());
    }

    /** @test */
    public function it_can_scope_active_examples(): void
    {
        Example::factory()->create(['is_active' => true]);
        Example::factory()->create(['is_active' => true]);
        Example::factory()->create(['is_active' => false]);
        
        $activeExamples = Example::active()->get();
        
        $this->assertEquals(2, $activeExamples->count());
        $this->assertTrue($activeExamples->every(fn ($example) => $example->is_active));
    }

    /** @test */
    public function it_can_scope_by_user(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        Example::factory()->create(['user_id' => $user1->id]);
        Example::factory()->create(['user_id' => $user1->id]);
        Example::factory()->create(['user_id' => $user2->id]);
        
        $user1Examples = Example::byUser($user1->id)->get();
        
        $this->assertEquals(2, $user1Examples->count());
        $this->assertTrue($user1Examples->every(fn ($example) => $example->user_id === $user1->id));
    }
}
```

### **2. Test di Relazioni**

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Tests;

use Modules\Xot\Tests\XotBaseTestCase;
use Modules\Example\app\Models\Example;
use Modules\User\app\Models\User;
use Modules\Example\app\Models\Category;
use Modules\Example\app\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleRelationshipsTest extends XotBaseTestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $example = Example::factory()->create(['user_id' => $user->id]);
        
        $this->assertInstanceOf(User::class, $example->user);
        $this->assertEquals($user->id, $example->user->id);
    }

    /** @test */
    public function it_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $example = Example::factory()->create(['category_id' => $category->id]);
        
        $this->assertInstanceOf(Category::class, $example->category);
        $this->assertEquals($category->id, $example->category->id);
    }

    /** @test */
    public function it_has_many_comments(): void
    {
        $example = Example::factory()->create();
        $comment1 = $example->comments()->create(['content' => 'Comment 1']);
        $comment2 = $example->comments()->create(['content' => 'Comment 2']);
        
        $this->assertCount(2, $example->comments);
        $this->assertTrue($example->comments->contains($comment1));
        $this->assertTrue($example->comments->contains($comment2));
    }

    /** @test */
    public function it_belongs_to_many_tags(): void
    {
        $example = Example::factory()->create();
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        
        $example->tags()->attach([$tag1->id, $tag2->id]);
        
        $this->assertCount(2, $example->tags);
        $this->assertTrue($example->tags->contains($tag1));
        $this->assertTrue($example->tags->contains($tag2));
    }

    /** @test */
    public function it_can_attach_tags_with_pivot_data(): void
    {
        $example = Example::factory()->create();
        $tag = Tag::factory()->create();
        
        $example->tags()->attach($tag->id, ['added_at' => now()]);
        
        $this->assertCount(1, $example->tags);
        $this->assertNotNull($example->tags->first()->pivot->added_at);
    }
}
```

## 🔗 **Collegamenti e Riferimenti**

- [**README.md**](README.md) - Documentazione principale del modulo
- [**Best Practices**](best-practices.md) - Best practices per lo sviluppo
- [**Architettura**](architecture.md) - Architettura del modulo Xot
- [**Troubleshooting**](troubleshooting.md) - Risoluzione problemi

---

*Ultimo aggiornamento: giugno 2025 - Versione 2.0.0*
