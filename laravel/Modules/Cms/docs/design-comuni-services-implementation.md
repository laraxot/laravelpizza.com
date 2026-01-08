# 🏛️ Design Comuni - Services Implementation Guide

**Date:** 2025-10-02  
**Module:** Cms  
**Related:** Theme Sixteen, Design Comuni Italia

---

## 📋 Overview

Questa guida descrive come implementare la gestione dei servizi comunali secondo il modello Design Comuni Italia nel modulo Cms di FixCity.

---

## 🎯 Obiettivi

1. **Conformità AGID** - Rispettare standard Design Comuni
2. **Scheda Servizio Completa** - Tutte le sezioni richieste
3. **Accessibilità** - WCAG 2.1 Level AA
4. **Integrazione SPID/CIE** - Autenticazione digitale
5. **Gestione Documentale** - Allegati e link utili

---

## 🗄️ Database Schema

### Services Table Extension

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Informazioni base Design Comuni
            $table->text('target_audience')->nullable()->comment('A chi si rivolge');
            $table->text('how_to')->nullable()->comment('Come fare');
            $table->text('requirements')->nullable()->comment('Cosa serve');
            
            // Costi
            $table->decimal('cost', 10, 2)->nullable()->comment('Costo del servizio');
            $table->text('cost_description')->nullable()->comment('Descrizione costi');
            
            // Tempi e scadenze
            $table->text('timing')->nullable()->comment('Tempi e scadenze');
            $table->integer('processing_days')->nullable()->comment('Giorni lavorazione');
            
            // Accesso online
            $table->boolean('has_online_access')->default(false);
            $table->boolean('spid_required')->default(false);
            $table->boolean('cie_required')->default(false);
            $table->string('online_url')->nullable();
            
            // Stato e visibilità
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->string('slug')->unique();
            
            // Indici
            $table->index('status');
            $table->index('published_at');
            $table->fulltext(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'target_audience', 'how_to', 'requirements',
                'cost', 'cost_description', 'timing', 'processing_days',
                'has_online_access', 'spid_required', 'cie_required', 'online_url',
                'status', 'published_at', 'metadata', 'slug'
            ]);
        });
    }
};
```

### Related Tables

```php
<?php

// Service Contacts
Schema::create('service_contacts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->string('office')->comment('Ufficio di riferimento');
    $table->string('phone', 50)->nullable();
    $table->string('email')->nullable();
    $table->text('address')->nullable();
    $table->json('opening_hours')->nullable();
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

// Service Documents
Schema::create('service_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('file_path', 500);
    $table->string('file_name');
    $table->string('file_size', 20);
    $table->string('mime_type', 100);
    $table->integer('downloads')->default(0);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

// Service Links
Schema::create('service_links', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->string('url', 500);
    $table->text('description')->nullable();
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

// Service Categories (se non esiste già)
Schema::create('service_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('icon', 50)->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

---

## 💻 Models Implementation

### Service Model

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Service model conforming to Design Comuni Italia standards.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $target_audience
 * @property string|null $how_to
 * @property string|null $requirements
 * @property float|null $cost
 * @property string|null $cost_description
 * @property string|null $timing
 * @property int|null $processing_days
 * @property bool $has_online_access
 * @property bool $spid_required
 * @property bool $cie_required
 * @property string|null $online_url
 * @property string $status
 * @property \Carbon\Carbon|null $published_at
 */
class Service extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'target_audience',
        'how_to',
        'requirements',
        'cost',
        'cost_description',
        'timing',
        'processing_days',
        'has_online_access',
        'spid_required',
        'cie_required',
        'online_url',
        'status',
        'published_at',
        'metadata',
        'slug',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'processing_days' => 'integer',
        'has_online_access' => 'boolean',
        'spid_required' => 'boolean',
        'cie_required' => 'boolean',
        'published_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get slug options.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Category relationship.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * Contacts relationship.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(ServiceContact::class)->orderBy('sort_order');
    }

    /**
     * Documents relationship.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ServiceDocument::class)->orderBy('sort_order');
    }

    /**
     * Links relationship.
     */
    public function links(): HasMany
    {
        return $this->hasMany(ServiceLink::class)->orderBy('sort_order');
    }

    /**
     * Scope for published services.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for services by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Check if service is free.
     */
    public function isFree(): bool
    {
        return $this->cost === null || $this->cost == 0;
    }

    /**
     * Check if service requires authentication.
     */
    public function requiresAuth(): bool
    {
        return $this->spid_required || $this->cie_required;
    }

    /**
     * Get formatted cost.
     */
    public function getFormattedCostAttribute(): string
    {
        if ($this->isFree()) {
            return 'Gratuito';
        }

        return '€ ' . number_format($this->cost, 2, ',', '.');
    }

    /**
     * Get processing time description.
     */
    public function getProcessingTimeAttribute(): string
    {
        if (!$this->processing_days) {
            return 'Non specificato';
        }

        if ($this->processing_days === 1) {
            return '1 giorno lavorativo';
        }

        return $this->processing_days . ' giorni lavorativi';
    }

    /**
     * Get icon based on category.
     */
    public function getIconAttribute(): string
    {
        return $this->category->icon ?? 'it-pa';
    }

    /**
     * Check if service is complete (all required fields filled).
     */
    public function isComplete(): bool
    {
        return !empty($this->title) &&
               !empty($this->description) &&
               !empty($this->target_audience) &&
               !empty($this->how_to) &&
               !empty($this->requirements) &&
               $this->contacts()->exists();
    }

    /**
     * Get completion percentage.
     */
    public function getCompletionPercentage(): int
    {
        $fields = [
            'title',
            'description',
            'target_audience',
            'how_to',
            'requirements',
            'timing',
            'cost_description',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        if ($this->contacts()->exists()) {
            $filled++;
        }

        $total = count($fields) + 1; // +1 for contacts

        return (int) (($filled / $total) * 100);
    }
}
```

### ServiceContact Model

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceContact extends Model
{
    protected $fillable = [
        'service_id',
        'office',
        'phone',
        'email',
        'address',
        'opening_hours',
        'sort_order',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'sort_order' => 'integer',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get formatted opening hours.
     */
    public function getFormattedOpeningHoursAttribute(): string
    {
        if (!$this->opening_hours) {
            return 'Non specificato';
        }

        $formatted = [];
        foreach ($this->opening_hours as $day => $hours) {
            if ($hours) {
                $formatted[] = ucfirst($day) . ': ' . $hours;
            }
        }

        return implode('<br>', $formatted);
    }
}
```

---

## 🎨 Filament Resource

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\Cms\Models\Service;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ServiceResource extends XotBaseResource
{
    protected static ?string $model = Service::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    protected static string | \UnitEnum | null $navigationGroup = 'Servizi';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Service')
                ->tabs([
                    // Tab 1: Informazioni Base
                    Forms\Components\Tabs\Tab::make('Informazioni Base')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Titolo')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => 
                                    $set('slug', \Str::slug($state))
                                ),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),

                            Forms\Components\Select::make('category_id')
                                ->label('Categoria')
                                ->relationship('category', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),

                            Forms\Components\RichEditor::make('description')
                                ->label('Descrizione')
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\Select::make('status')
                                ->label('Stato')
                                ->options([
                                    'draft' => 'Bozza',
                                    'published' => 'Pubblicato',
                                    'archived' => 'Archiviato',
                                ])
                                ->default('draft')
                                ->required(),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Data Pubblicazione')
                                ->default(now()),
                        ]),

                    // Tab 2: Dettagli Servizio
                    Forms\Components\Tabs\Tab::make('Dettagli')
                        ->schema([
                            Forms\Components\RichEditor::make('target_audience')
                                ->label('A chi si rivolge')
                                ->hint('Descrivi i destinatari del servizio')
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('how_to')
                                ->label('Come fare')
                                ->hint('Spiega la procedura per accedere al servizio')
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('requirements')
                                ->label('Cosa serve')
                                ->hint('Elenca documenti e requisiti necessari')
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('timing')
                                ->label('Tempi e scadenze')
                                ->hint('Indica i tempi di erogazione e eventuali scadenze')
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('processing_days')
                                ->label('Giorni lavorativi')
                                ->numeric()
                                ->suffix('giorni'),
                        ]),

                    // Tab 3: Costi
                    Forms\Components\Tabs\Tab::make('Costi')
                        ->schema([
                            Forms\Components\TextInput::make('cost')
                                ->label('Costo')
                                ->numeric()
                                ->prefix('€')
                                ->step(0.01)
                                ->hint('Lascia vuoto se gratuito'),

                            Forms\Components\RichEditor::make('cost_description')
                                ->label('Descrizione costi')
                                ->hint('Dettagli su costi, modalità di pagamento, ecc.')
                                ->columnSpanFull(),
                        ]),

                    // Tab 4: Accesso Online
                    Forms\Components\Tabs\Tab::make('Accesso Online')
                        ->schema([
                            Forms\Components\Toggle::make('has_online_access')
                                ->label('Servizio accessibile online')
                                ->live(),

                            Forms\Components\TextInput::make('online_url')
                                ->label('URL servizio online')
                                ->url()
                                ->visible(fn (Forms\Get $get) => $get('has_online_access')),

                            Forms\Components\Toggle::make('spid_required')
                                ->label('Richiede SPID')
                                ->visible(fn (Forms\Get $get) => $get('has_online_access')),

                            Forms\Components\Toggle::make('cie_required')
                                ->label('Richiede CIE')
                                ->visible(fn (Forms\Get $get) => $get('has_online_access')),
                        ]),

                    // Tab 5: Contatti
                    Forms\Components\Tabs\Tab::make('Contatti')
                        ->schema([
                            Forms\Components\Repeater::make('contacts')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('office')
                                        ->label('Ufficio')
                                        ->required(),

                                    Forms\Components\TextInput::make('phone')
                                        ->label('Telefono')
                                        ->tel(),

                                    Forms\Components\TextInput::make('email')
                                        ->label('Email')
                                        ->email(),

                                    Forms\Components\Textarea::make('address')
                                        ->label('Indirizzo')
                                        ->rows(2),

                                    Forms\Components\KeyValue::make('opening_hours')
                                        ->label('Orari di apertura')
                                        ->keyLabel('Giorno')
                                        ->valueLabel('Orario'),
                                ])
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['office'] ?? null)
                                ->columnSpanFull(),
                        ]),

                    // Tab 6: Documenti e Link
                    Forms\Components\Tabs\Tab::make('Documenti e Link')
                        ->schema([
                            Forms\Components\Repeater::make('documents')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Titolo')
                                        ->required(),

                                    Forms\Components\FileUpload::make('file_path')
                                        ->label('File')
                                        ->directory('service-documents')
                                        ->acceptedFileTypes(['application/pdf', 'application/msword'])
                                        ->maxSize(10240),

                                    Forms\Components\Textarea::make('description')
                                        ->label('Descrizione')
                                        ->rows(2),
                                ])
                                ->collapsible()
                                ->columnSpanFull(),

                            Forms\Components\Repeater::make('links')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Titolo')
                                        ->required(),

                                    Forms\Components\TextInput::make('url')
                                        ->label('URL')
                                        ->url()
                                        ->required(),

                                    Forms\Components\Textarea::make('description')
                                        ->label('Descrizione')
                                        ->rows(2),
                                ])
                                ->collapsible()
                                ->columnSpanFull(),
                        ]),
                ]),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
                ->label('Titolo')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('category.name')
                ->label('Categoria')
                ->badge()
                ->sortable(),

            Tables\Columns\IconColumn::make('has_online_access')
                ->label('Online')
                ->boolean(),

            Tables\Columns\TextColumn::make('cost')
                ->label('Costo')
                ->money('EUR')
                ->sortable()
                ->placeholder('Gratuito'),

            Tables\Columns\BadgeColumn::make('status')
                ->label('Stato')
                ->colors([
                    'warning' => 'draft',
                    'success' => 'published',
                    'danger' => 'archived',
                ])
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'draft' => 'Bozza',
                    'published' => 'Pubblicato',
                    'archived' => 'Archiviato',
                }),

            Tables\Columns\TextColumn::make('published_at')
                ->label('Pubblicato')
                ->dateTime()
                ->sortable(),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('view')
                ->label('Visualizza')
                ->icon('heroicon-o-eye')
                ->url(fn (Service $record): string => route('servizi.show', $record))
                ->openUrlInNewTab(),

            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                
                Tables\Actions\BulkAction::make('publish')
                    ->label('Pubblica')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['status' => 'published', 'published_at' => now()])
                    )
                    ->deselectRecordsAfterCompletion(),

                Tables\Actions\BulkAction::make('archive')
                    ->label('Archivia')
                    ->icon('heroicon-o-archive-box')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['status' => 'archived'])
                    )
                    ->deselectRecordsAfterCompletion(),
            ]),
        ];
    }
}
```

---

## 🧪 Testing

```php
<?php

namespace Modules\Cms\Tests\Feature;

use Tests\TestCase;
use Modules\Cms\Models\Service;
use Modules\Cms\Models\ServiceCategory;

class ServiceTest extends TestCase
{
    /** @test */
    public function it_can_create_a_service()
    {
        $category = ServiceCategory::factory()->create();
        
        $service = Service::create([
            'title' => 'Carta d\'Identità',
            'description' => 'Rilascio carta d\'identità elettronica',
            'category_id' => $category->id,
            'target_audience' => 'Tutti i cittadini residenti',
            'how_to' => 'Prenota un appuntamento online',
            'requirements' => 'Documento scaduto, foto tessera',
            'cost' => 22.20,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('services', [
            'title' => 'Carta d\'Identità',
            'cost' => 22.20,
        ]);
    }

    /** @test */
    public function it_generates_slug_automatically()
    {
        $service = Service::factory()->create([
            'title' => 'Servizio di Test',
        ]);

        $this->assertEquals('servizio-di-test', $service->slug);
    }

    /** @test */
    public function it_checks_if_service_is_free()
    {
        $freeService = Service::factory()->create(['cost' => null]);
        $paidService = Service::factory()->create(['cost' => 10.00]);

        $this->assertTrue($freeService->isFree());
        $this->assertFalse($paidService->isFree());
    }

    /** @test */
    public function it_calculates_completion_percentage()
    {
        $service = Service::factory()->create([
            'title' => 'Test',
            'description' => 'Test',
            'target_audience' => 'Test',
            'how_to' => 'Test',
            'requirements' => 'Test',
            'timing' => 'Test',
            'cost_description' => 'Test',
        ]);

        $service->contacts()->create([
            'office' => 'Test Office',
            'phone' => '123456789',
        ]);

        $this->assertEquals(100, $service->getCompletionPercentage());
    }
}
```

---

**📝 Documento preparato da:** Super Mucca 🐮  
**📅 Data:** 2025-10-02
