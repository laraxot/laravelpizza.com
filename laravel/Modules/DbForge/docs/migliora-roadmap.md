# Migliora Roadmap - Guida Completa al Nesting di Filament in Quaeris Fila5 Mono

## 📋 Panoramica del Nesting nel Progetto

Questo documento analizza in profondità l'implementazione del nesting di Filament nel progetto Quaeris Fila5 Mono, identificando i moduli che utilizzano già questa funzionalità e quelli che potrebbero beneficiarne.

### 🏗️ Architettura Base Xot

Il progetto utilizza **XotBaseRelationManager** come base per tutti i RelationManager:
- `Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`
- Estende `FilamentRelationManager` con funzionalità aggiuntive
- Implementa pattern di navigazione automatici
- Gestisce autorizzazioni e azioni personalizzate

## 📊 Analisi dei Moduli con Nesting

### ✅ Moduli che Già Utilizzano il Nesting

#### 1. **Modulo Quaeris** - Implementazione Completa

**Relazioni Implementate:**
- **Customer → SurveyPdfs** (HasMany)
- **SurveyPdf → QuestionCharts** (HasMany)

```php
// CustomerResource/RelationManagers/SurveyPdfsRelationManager.php
class SurveyPdfsRelationManager extends RelationManager
{
    protected static string $relationship = 'surveyPdfs';
    
    public function form(Schema $schema): Schema
    {
        return SurveyPdfResource::form($schema);
    }
    
    public function table(Table $table): Table
    {
        return SurveyPdfResource::table($table);
    }
}

// SurveyPdfResource/RelationManagers/QuestionChartsRelationManager.php
class QuestionChartsRelationManager extends RelationManager
{
    protected static string $relationship = 'questionCharts';
    
    // Form complesso con图表 configurazioni
    // Actions custom per export PDF/Excel
    // Integration con LimeSurvey
}
```

**Punti di Forza:**
- Form condiviso tra Resource e RelationManager
- Actions custom (regenImg, export, alert)
- Gestione di relazioni complesse con Chart
- Navigazione a tab multi-livello

#### 2. **Modulo User** - Gestione Permessi e Ruoli

**Relazioni Implementate:**
- **User → Roles** (ManyToMany)
- **Role → Permissions** (ManyToMany)
- **Role → Users** (ManyToMany)

```php
// UserResource/RelationManagers/RolesRelationManager.php
class RolesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'roles';
    
    #[Override]
    public function getTableHeaderActions(): array
    {
        $parentActions = parent::getTableHeaderActions();
        return array_merge($parentActions, [
            'attach' => AttachRoleAction::make(),
        ]);
    }
}
```

**Caratteristiche:**
- Actions custom per attach/detach
- Gestione ManyToMany con pivot
- Autorizzazioni granulari

### 🔄 Moduli che Potrebbero Implementare il Nesting

#### 1. **Modulo Job** - Gestione Task e Schedule

**Potenziali Relazioni:**
- **Task → Frequencies** (HasMany)
- **Task → Results** (HasMany)
- **Task → ScheduleHistory** (HasMany)

```php
// Proposto: JobResource/RelationManagers/FrequenciesRelationManager.php
class FrequenciesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'frequencies';
    
    public function getFormSchema(): array
    {
        return [
            'type' => Select::make('type')
                ->options(['cron' => 'Cron', 'interval' => 'Intervallo']),
            'expression' => TextInput::make('expression')
                ->helperText('Espressione cron o intervallo in minuti'),
            'timezone' => Select::make('timezone')
                ->options(config('app.timezones', [])),
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'type' => TextColumn::make('type')->badge(),
            'expression' => TextColumn::make('expression')->copyable(),
            'timezone' => TextColumn::make('timezone'),
            'next_run' => TextColumn::make('next_run')->dateTime(),
        ];
    }
}
```

**Implementazione Suggerita:**
- Nested resources per Task → Frequencies
- Actions per test execution
- Stats widget per performance monitoring

#### 2. **Modulo Chart** - Integrazione Charts con Risorse

**Potenziali Relazioni:**
- **Chart → MixedCharts** (HasMany)
- **Chart → ChartConfigs** (HasMany)

```php
// Proposto: ChartResource/RelationManagers/MixedChartsRelationManager.php
class MixedChartsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'mixedCharts';
    
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required(),
            'chart_type' => Select::make('chart_type')
                ->options([
                    'bar' => 'Bar Chart',
                    'line' => 'Line Chart', 
                    'pie' => 'Pie Chart',
                    'mixed' => 'Mixed Chart',
                ]),
            'chart_config' => Repeater::make('chart_config')
                ->schema([
                    'chart_id' => Select::make('chart_id')
                        ->options(fn() => Chart::pluck('name', 'id')),
                    'position' => TextInput::make('position')->numeric(),
                ]),
        ];
    }
}
```

## 🛠️ Pattern di Implementazione

### 1. **Base Pattern XotBaseRelationManager**

```php
abstract class CustomRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = '';
    
    // Override methods
    public function getFormSchema(): array
    {
        return [
            // Custom form fields
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            // Custom table columns
        ];
    }
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            // Custom actions
        ]);
    }
}
```

### 2. **Nested Resources Pattern**

```php
// Parent Resource
class ParentResource extends XotBaseResource
{
    public static function getRelations(): array
    {
        return [
            ChildRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListParents::route('/'),
            'edit' => EditParent::route('/{record}/edit'),
            'manage-children' => ManageChildren::route('/{record}/children'),
        ];
    }
}
```

### 3. **Many-to-Many Relations Pattern**

```php
class ManyToManyRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'relatedModels';
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            AttachAction::make()
                ->form([
                    'extra_field' => TextInput::make('extra_field'),
                ]),
        ]);
    }
    
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            DetachAction::make(),
            EditAction::make(),
        ]);
    }
}
```

## 📈 Best Practices per Performance

### 1. **Lazy Loading Eager Loading**

```php
class ParentModel extends BaseModel
{
    protected $with = ['children', 'grandChildren']; // Preload relazioni
}

// Nella Resource
public function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with(['children.relation1', 'children.relation2']); // Lazy eager loading
}
```

### 2. **Query Optimization per Large Datasets**

```php
public function table(Table $table): Table
{
    return $table
        ->defaultPaginationPageOption(25)
        ->poll('60s') // Auto-refresh per dati in tempo reale
        ->striped()
        ->modifyQueryUsing(fn (Builder $query) => 
            $query->orderBy('position')->withCount(['children'])
        );
}
```

## 🔒 Sicurezza e Autorizzazioni

### 1. **Policy Integration**

```php
class ChildRelationManager extends XotBaseRelationManager
{
    public function canCreate(): bool
    {
        return auth()->user()->can('create', [$this->getRelatedModel(), $this->ownerRecord]);
    }
    
    public function canEdit(Model $record): bool
    {
        return auth()->user()->can('update', $record);
    }
    
    public function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete', $record);
    }
}
```

### 2. **Scoping per Tenancy**

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->where('team_id', auth()->user()->currentTeam->id);
}
```

## 🎯 Roadmap di Implementazione

### Fase 1: Modulo Job (Priorità Alta)
- [ ] Implementare Task → Frequencies RelationManager
- [ ] Aggiungere Task → Results RelationManager  
- [ ] Creare Actions per test execution
- [ ] Implementare performance widgets

### Fase 2: Modulo Chart (Priorità Media)
- [ ] Chart → MixedCharts RelationManager
- [ ] Integration con existing chart types
- [ ] Preview widgets per charts
- [ ] Export functionality

### Fase 3: Modulo Notify (Priorità Media)
- [ ] NotifyTheme → Templates RelationManager
- [ ] NotifyTheme → Logs RelationManager
- [ ] Template duplication feature
- [ ] Send test notification actions

### Fase 4: Moduli Aggiuntivi
- [ ] Geo → Locations RelationManager
- [ ] Media → Galleries RelationManager
- [ ] Activity → Logs RelationManager

## 📝 Esempi Pratici Completi

### Esempio 1: Job Resource con Frequencies Nesting

```php
// JobResource.php
class JobResource extends XotBaseResource
{
    protected static ?string $model = Task::class;
    
    public static function getRelations(): array
    {
        return [
            FrequenciesRelationManager::class,
            ResultsRelationManager::class,
            ScheduleHistoryRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'edit' => EditJob::route('/{record}/edit'),
            'manage-frequencies' => ManageFrequencies::route('/{record}/frequencies'),
        ];
    }
}

// FrequenciesRelationManager.php
class FrequenciesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'frequencies';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('type')
                ->required()
                ->default('cron'),
            TextInput::make('expression')
                ->required()
                ->helperText('Cron expression o minuti per intervallo'),
            Select::make('timezone')
                ->options(config('app.timezones', []))
                ->default(config('app.timezone')),
            Toggle::make('is_active')->default(true),
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'type' => TextColumn::make('type')->badge()
                ->color(fn($state) => match($state) {
                    'cron' => 'primary',
                    'interval' => 'success',
                    default => 'gray',
                }),
            'expression' => TextColumn::make('expression')->copyable(),
            'timezone' => TextColumn::make('timezone'),
            'is_active' => ToggleColumn::make('is_active'),
            'next_run' => TextColumn::make('next_run')->dateTime(),
        ];
    }
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            Action::make('test_expression')
                ->label('Test Expression')
                ->icon('heroicon-o-play')
                ->form([
                    TextInput::make('test_date')
                        ->default(now()->format('Y-m-d H:i:s'))
                        ->helperText('Data per testare l\'espressione'),
                ])
                ->action(function (array $data) {
                    // Test cron expression logic
                }),
        ]);
    }
}
```

### Esempio 2: Multi-Level Nesting (Customer → SurveyPdf → QuestionCharts)

```php
// CustomerResource.php - Livello 1
class CustomerResource extends XotBaseResource
{
    public static function getRelations(): array
    {
        return [
            SurveyPdfsRelationManager::class,
        ];
    }
}

// SurveyPdfsRelationManager.php - Livello 2
class SurveyPdfsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'surveyPdfs';
    
    public function getFormSchema(): array
    {
        return SurveyPdfResource::getFormSchema();
    }
    
    public function getRelations(): array
    {
        return [
            QuestionChartsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'manage-charts' => ManageQuestionCharts::route('/{record}/charts'),
        ];
    }
}

// QuestionChartsRelationManager.php - Livello 3
class QuestionChartsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'questionCharts';
    
    // Form e table con custom actions per chart generation
}
```

## 📚 Risorse e Riferimenti

### Documentazione Filament Ufficiale
- [Relation Managers](https://filamentphp.com/docs/3.x/admin/resources/relation-managers)
- [Nested Resources](https://filamentphp.com/docs/3.x/admin/resources/nested-resources)

### Pattern del Progetto
- XotBaseRelationManager (`Modules/Xot/`)
- Esempi esistenti in `Quaeris/` e `User/`

### Best Practices
- Sempre estendere XotBaseRelationManager
- Utilizzare policy per autorizzazioni
- Implementare caching per performance
- Gestire lazy/eager loading ottimale

---

**Ultimo Aggiornamento:** 2026-01-23  
**Versione Filament:** v5.0.0  
**Versione PHP:** 8.2+  
**Status:** Roadmap di Implementazione Attiva
