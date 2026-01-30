# Guida Completa al Nesting di Filament - Quaeris Fila5 Mono

## 📖 Introduzione

Il nesting di Filament è una potente funzionalità che permette di gestire relazioni complesse tra modelli attraverso un'interfaccia tabbed integrata. In Quaeris Fila5 Mono, questa funzionalità è implementata attraverso il pattern **XotBaseRelationManager**.

### 🎯 Obiettivi della Guida

- Comprendere l'architettura del nesting nel progetto
- Imparare a implementare RelationManager personalizzati
- Applicare best practices per performance e sicurezza
- Identificare opportunità di nesting nei moduli esistenti

## 🏗️ Architettura del Nesting in Quaeris

### 1. **XotBaseRelationManager - Il Fondamento**

```php
// Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php
abstract class XotBaseRelationManager extends FilamentRelationManager
{
    use HasXotTable;
    
    protected static string $relationship = '';
    protected static string $resource;
    
    // Auto-resolve della Resource class
    public function getResource(): string
    {
        // Logica automatica per risolvere la Resource
        // Basata sul namespace: Modules\Module\Filament\Resources\Resource\RelationManagers\This
    }
    
    // Form schema di default dalla Resource
    public function getFormSchema(): array
    {
        return $this->getResource()::getFormSchema();
    }
    
    // Table columns di default dalla Resource
    public function getTableColumns(): array
    {
        // Estrae le colonne dalla pagina index della Resource
    }
    
    // Actions di base con autorizzazioni
    public function getTableActions(): array
    {
        return [
            EditAction::make()->visible(fn($record) => $this->canEdit($record)),
            DetachAction::make()->visible(fn($record) => $this->canDetach($record)),
        ];
    }
}
```

### 2. **Pattern di Namespace Automatico**

Il framework risolve automaticamente le Resource basandosi sul namespace:

```
Modules\Quaeris\Filament\Resources\CustomerResource\RelationManagers\SurveyPdfsRelationManager
                    ↓                    ↓                         ↓
                 Modules            Quaeris          CustomerResource
```

## 📋 Tipi di Nesting Implementati

### 1. **HasMany Relations - Customer → SurveyPdfs**

**File Structure:**
```
Modules/Quaeris/
├── app/Filament/Resources/
│   ├── CustomerResource.php
│   └── CustomerResource/
│       └── RelationManagers/
│           └── SurveyPdfsRelationManager.php
```

**Implementazione:**
```php
class SurveyPdfsRelationManager extends RelationManager
{
    protected static string $relationship = 'surveyPdfs';
    protected static ?string $recordTitleAttribute = 'id';
    
    public function form(Schema $schema): Schema
    {
        return SurveyPdfResource::form($schema);
    }
    
    public function table(Table $table): Table
    {
        return SurveyPdfResource::table($table);
    }
}
```

**Model Relationship:**
```php
// Customer.php
public function surveyPdfs(): HasMany
{
    return $this->hasMany(SurveyPdf::class);
}
```

### 2. **HasMany Relations - SurveyPdf → QuestionCharts**

**Relazione Multi-Livello:**
```php
class QuestionChartsRelationManager extends RelationManager
{
    protected static string $relationship = 'questionCharts';
    
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('question')
                ->options(function () {
                    $surveyPdf = $this->ownerRecord;
                    return app(GetQuestionOptionsBySurveyId::class)
                        ->execute((string) $surveyPdf->survey_id);
                }),
            // Altri fields...
        ]);
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('questionTxt')->sortable()->wrap(),
                ImageColumn::make('img_src')->disk('public_html')->height(120),
                ToggleColumn::make('show_on_pdf'),
            ])
            ->headerActions([
                CreateAction::make(),
                Action::make('exportPdf')
                    ->icon('heroicon-s-document')
                    ->action(function () {
                        // Export logic
                    }),
            ]);
    }
}
```

### 3. **ManyToMany Relations - User → Roles**

```php
class RolesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'roles';
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            'attach' => AttachRoleAction::make(),
        ]);
    }
}
```

## 🔧 Implementazione Step-by-Step

### Step 1: Definire le Relazioni nei Modelli

```php
// Parent Model
class ParentModel extends BaseModel
{
    // HasMany
    public function children(): HasMany
    {
        return $this->hasMany(ChildModel::class);
    }
    
    // ManyToMany
    public function relatedModels(): BelongsToMany
    {
        return $this->belongsToMany(RelatedModel::class)
            ->withPivot('extra_field');
    }
}

// Child Model
class ChildModel extends BaseModel
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class);
    }
}
```

### Step 2: Creare la Resource Parent

```php
class ParentResource extends XotBaseResource
{
    protected static ?string $model = ParentModel::class;
    
    public static function getRelations(): array
    {
        return [
            ChildrenRelationManager::class,
            RelatedModelsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListParents::route('/'),
            'create' => CreateParent::route('/create'),
            'edit' => EditParent::route('/{record}/edit'),
        ];
    }
}
```

### Step 3: Creare il RelationManager

```php
// app/Filament/Resources/ParentResource/RelationManagers/ChildrenRelationManager.php
class ChildrenRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'children';
    protected static ?string $recordTitleAttribute = 'name';
    
    // Override del form schema (opzionale)
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            Select::make('type')
                ->options(['type1' => 'Type 1', 'type2' => 'Type 2']),
            TextInput::make('position')->numeric(),
            Toggle::make('is_active')->default(true),
        ];
    }
    
    // Override delle colonne tabella (opzionale)
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('type')->badge()->color('primary'),
            TextColumn::make('position')->sortable(),
            ToggleColumn::make('is_active'),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
    
    // Custom header actions
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            Action::make('bulk_import')
                ->label('Importa Massivo')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    FileUpload::make('file')
                        ->acceptedFileTypes(['.csv', '.xlsx'])
                        ->helperText('Carica file CSV o Excel'),
                ])
                ->action(function (array $data) {
                    // Import logic
                }),
        ]);
    }
    
    // Custom record actions
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (ChildModel $record) {
                    $new = $record->replicate();
                    $new->name = $record->name . ' (Copy)';
                    $new->save();
                }),
        ]);
    }
    
    // Custom bulk actions
    public function getTableBulkActions(): array
    {
        return array_merge(parent::getTableBulkActions(), [
            BulkAction::make('bulk_activate')
                ->label('Attiva Selezionati')
                ->icon('heroicon-o-check')
                ->action(function (Collection $records) {
                    $records->each->update(['is_active' => true]);
                }),
        ]);
    }
    
    // Filters personalizzati
    public function getTableFilters(): array
    {
        return [
            Filter::make('active')
                ->query(fn (Builder $query) => $query->where('is_active', true)),
            Filter::make('type')
                ->form([
                    Select::make('type')
                        ->options(['type1' => 'Type 1', 'type2' => 'Type 2']),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when($data['type'], fn($query, $type) => 
                        $query->where('type', $type));
                }),
        ];
    }
}
```

### Step 4: Configurare la Navigazione

```php
class ParentResource extends XotBaseResource
{
    // Per navigazione standalone
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
    
    // Per solo nested navigation
    public static function getParent(): ?string
    {
        return GrandParentResource::class;
    }
    
    // Sub-navigation pages
    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditParent::class,
            ManageChildren::class,
            ManageRelatedModels::class,
        ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListParents::route('/'),
            'create' => CreateParent::route('/create'),
            'edit' => EditParent::route('/{record}/edit'),
            'manage-children' => ManageChildren::route('/{record}/children'),
            'manage-related' => ManageRelatedModels::route('/{record}/related'),
        ];
    }
}
```

## 🎨 Advanced Features

### 1. **Conditional Fields Based on Parent**

```php
public function getFormSchema(): array
{
    $parent = $this->ownerRecord;
    
    return [
        TextInput::make('name')->required(),
        
        Select::make('category')
            ->options(function () use ($parent) {
                // Opzioni basate sul parent
                return $parent->availableCategories();
            }),
            
        TextInput::make('prefix')
            ->default($parent->default_prefix)
            ->visible(fn() => $parent->requires_prefix),
    ];
}
```

### 2. **Dynamic Actions Based on Parent State**

```php
public function getTableHeaderActions(): array
{
    $parent = $this->ownerRecord;
    $actions = parent::getTableHeaderActions();
    
    if ($parent->can_import_children) {
        $actions[] = Action::make('import')
            ->action(function () use ($parent) {
                // Import logic specifico per questo parent
            });
    }
    
    if ($parent->is_locked) {
        // Rimuovi azioni di modifica
        $actions = array_filter($actions, fn($action) => 
            !in_array($action->getName(), ['create', 'attach'])
        );
    }
    
    return $actions;
}
```

### 3. **Complex Filtering with Parent Context**

```php
public function getTableQuery(): Builder
{
    $parent = $this->ownerRecord;
    
    return parent::getTableQuery()
        ->where('parent_type', $parent->type)
        ->when($parent->requires_approval, function($query) {
            return $query->where('approved', true);
        })
        ->orderBy('position');
}
```

### 4. **Custom Validation with Parent Context**

```php
protected function handleRecordCreation(array $data): Model
{
    $parent = $this->ownerRecord;
    
    // Validazione custom basata sul parent
    if ($parent->max_children && $parent->children()->count() >= $parent->max_children) {
        throw ValidationException::withMessages([
            'name' => 'Maximum number of children reached for this parent.',
        ]);
    }
    
    $data['parent_id'] = $parent->id;
    $data['created_by'] = auth()->id();
    
    return parent::handleRecordCreation($data);
}
```

## 📊 Performance Optimization

### 1. **Eager Loading Optimization**

```php
class ParentResource extends XotBaseResource
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'children' => fn($query) => $query->with(['category', 'tags']),
                'children.relations'
            ]);
    }
}

class ChildrenRelationManager extends XotBaseRelationManager
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['category', 'tags'])
            ->withCount(['subChildren'])
            ->orderBy('position');
    }
}
```

### 2. **Lazy Loading per Large Datasets**

```php
public function table(Table $table): Table
{
    return $table
        ->defaultPaginationPageOption(25)
        ->poll('60s') // Auto-refresh
        ->extremePaginationLinks()
        ->modifyQueryUsing(fn (Builder $query) => 
            $query->withCount(['relations'])
        );
}
```

### 3. **Caching Strategies**

```php
public function getFormSchema(): array
{
    return Cache::remember(
        'children_form_schema_' . $this->ownerRecord->id,
        3600,
        function () {
            return [
                Select::make('category_id')
                    ->options(function () {
                        return $this->ownerRecord->availableCategories()
                            ->pluck('name', 'id');
                    }),
            ];
        }
    );
}
```

## 🔒 Security & Authorization

### 1. **Policy Integration**

```php
class ChildrenRelationManager extends XotBaseRelationManager
{
    public function canCreate(): bool
    {
        return auth()->user()->can('createChild', $this->ownerRecord);
    }
    
    public function canEdit(Model $record): bool
    {
        return auth()->user()->can('update', $record);
    }
    
    public function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete', $record) 
            && !$this->ownerRecord->is_locked;
    }
    
    public function canDetach(Model $record): bool
    {
        return auth()->user()->can('detachChild', [
            'parent' => $this->ownerRecord,
            'child' => $record,
        ]);
    }
}
```

### 2. **Tenancy Scoping**

```php
class ParentResource extends XotBaseResource
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereBelongsTo(auth()->user()->currentTeam());
    }
}

class ChildrenRelationManager extends XotBaseRelationManager
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->whereBelongsTo($this->ownerRecord)
            ->whereHas('parent', function($query) {
                $query->whereBelongsTo(auth()->user()->currentTeam());
            });
    }
}
```

### 3. **Field-level Authorization**

```php
public function getFormSchema(): array
{
    $schema = [
        TextInput::make('name')->required(),
        TextInput::make('internal_code')
            ->visible(auth()->user()->can('viewInternalData')),
    ];
    
    if (auth()->user()->can('manageAdvancedSettings')) {
        $schema[] = TextInput::make('advanced_field');
    }
    
    return $schema;
}
```

## 🧪 Testing Strategies

### 1. **Unit Test per RelationManager**

```php
class ChildrenRelationManagerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_create_child_when_authorized()
    {
        $parent = ParentModel::factory()->create();
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get(ParentResource::getUrl('edit', ['record' => $parent]))
            ->assertSuccessful();
            
        $this->post(
            ParentResource::getUrl('children.create', ['record' => $parent]),
            ['name' => 'Test Child']
        )->assertRedirect();
        
        $this->assertDatabaseHas('children', [
            'parent_id' => $parent->id,
            'name' => 'Test Child',
        ]);
    }
    
    public function test_cannot_create_child_when_unauthorized()
    {
        $parent = ParentModel::factory()->create();
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->post(
                ParentResource::getUrl('children.create', ['record' => $parent]),
                ['name' => 'Test Child']
            )->assertForbidden();
    }
}
```

### 2. **Browser Test per Interaction**

```php
class ChildrenRelationManagerBrowserTest extends DuskTestCase
{
    public function test_can_manage_children_via_ui()
    {
        $parent = ParentModel::factory()->create();
        $user = User::factory()->create();
        
        $this->browse(function (Browser $browser) use ($parent, $user) {
            $browser->loginAs($user)
                ->visit(ParentResource::getUrl('edit', ['record' => $parent]))
                ->waitFor('@children-relation-manager')
                ->click('@create-child-button')
                ->waitFor('@create-child-modal')
                ->type('@name-input', 'Test Child')
                ->click('@save-button')
                ->waitForText('Child created successfully')
                ->assertSeeIn('@children-table', 'Test Child');
        });
    }
}
```

## 📁 File Structure Template

```
Modules/ModuleName/
├── app/Filament/Resources/
│   ├── ParentResource.php
│   └── ParentResource/
│       ├── Pages/
│       │   ├── ListParents.php
│       │   ├── CreateParent.php
│       │   ├── EditParent.php
│       │   └── ManageChildren.php
│       └── RelationManagers/
│           ├── ChildrenRelationManager.php
│           └── RelatedModelsRelationManager.php
├── app/Models/
│   ├── ParentModel.php
│   ├── ChildModel.php
│   └── RelatedModel.php
├── app/Policies/
│   ├── ParentPolicy.php
│   ├── ChildPolicy.php
│   └── RelatedModelPolicy.php
└── tests/Feature/
    ├── ParentResourceTest.php
    ├── ChildrenRelationManagerTest.php
    └── RelatedModelsRelationManagerTest.php
```

## 🎯 Common Pitfalls & Solutions

### 1. **Circular Relations**

**Problem:** Parent-child circular references causing infinite loops.

**Solution:** Use proper eager loading and limit depth:
```php
protected $with = ['children' => fn($query) => $query->with(['grandChildren'])];
```

### 2. **Performance Issues with Large Datasets**

**Problem:** Slow loading with many related records.

**Solution:** Implement pagination and filtering:
```php
public function table(Table $table): Table
{
    return $table
        ->defaultPaginationPageOption(10)
        ->searchable()
        ->filters([
            Filter::make('active')->query(fn($q) => $q->where('active', true)),
        ]);
}
```

### 3. **Authorization Conflicts**

**Problem:** Complex authorization rules between parent and child.

**Solution:** Create dedicated policies for nested operations:
```php
class ChildPolicy
{
    public function create(User $user, ParentModel $parent): bool
    {
        return $user->can('update', $parent) && $parent->can_have_children;
    }
}
```

## 📚 Additional Resources

### Documentation
- [Filament Relation Managers](https://filamentphp.com/docs/3.x/admin/resources/relation-managers)
- [Filament Nested Resources](https://filamentphp.com/docs/3.x/admin/resources/nested-resources)
- [Laravel Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)

### Project-Specific Resources
- XotBaseRelationManager (`Modules/Xot/`)
- Existing examples in `Quaeris/` and `User/` modules
- Policy examples in `Modules/*/app/Policies/`

### Community Examples
- Filament Discord community
- GitHub repository issues and discussions
- Stack Overflow tag: `filamentphp`

---

**Ultimo Aggiornamento:** 2026-01-23  
**Versione Filament:** v5.0.0  
**Versione PHP:** 8.2+  
**Author:** AI Agent - Filament Nesting Specialist  
**Review Status:** Ready for Implementation
