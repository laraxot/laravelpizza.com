# 🎯 Filament 5.x Nested Resources - Guida Completa 2024

## 📋 **Introduzione a Nested Resources**

I Nested Resources in Filament 5.x forniscono un modo potente per creare relazioni gerarchiche tra le risorse, permettendo di gestire entità figlio come risorse complete con le loro proprie pagine di lista, creazione e modifica.

## 🎯 **Caso d'Uso Principale**

### **Esempio: Course e Lessons**
- **CourseResource**: Risorsa principale per corsi
- **LessonResource**: Nested resource per lezioni
- **Relazione**: Un corso può avere molte lezioni
- **Flusso**: Gestire lezioni direttamente dalla pagina del corso

## 🚀 **Creazione di un Nested Resource**

### **Passo 1: Creare la Nested Resource**

```bash
# Creare la nested resource usando artisan
php artisan make:filament-resource Lesson --nested
```

### **Passo 2: Creare il Relation Manager**

```bash
# Creare il relation manager per il parent resource
php artisan make:filament-relation-manager CourseResource lessons title
```

### **Passo 3: Creare la Pagina di Gestione**

```bash
# Creare la pagina per gestire i record correlati
php artisan make:filament-page ManageCourseLessons --resource=CourseResource --type=ManageRelatedRecords
```

## 🔧 **Implementazione delle Classi**

### **1. Parent Resource (CourseResource)**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses;

use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons\LessonResource;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    public static function getRelations(): array
    {
        return [
            'lessons' => LessonsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
            'lessons' => Pages\ManageCourseLessons::route('/{record}/lessons'),
        ];
    }

    // Breadcrumb personalizzato
    public static function getBreadcrumbRecordLabel(Model $record): string
    {
        return $record->title;
    }
}
```

### **2. Nested Resource (LessonResource)**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons;

use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Modules\healthcare_app\Filament\Resources\Courses\CourseResource;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;
    
    // Puntatore al parent resource
    protected static ?string $parentResource = CourseResource::class;

    public static function getRelations(): array
    {
        return [
            // Relazioni per le lesson
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/{parent}/lessons'),
            'create' => Pages\CreateLesson::route('/{parent}/lessons/create'),
            'view' => Pages\ViewLesson::route('/{parent}/lessons/{record}'),
            'edit' => Pages\EditLesson::route('/{parent}/lessons/{record}/edit'),
        ];
    }

    // Breadcrumb personalizzato
    public static function getBreadcrumbRecordLabel(Model $record): string
    {
        return $record->title;
    }
}
```

### **3. Relation Manager (LessonsRelationManager)**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Forms;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons\LessonResource;

class LessonsRelationManager extends RelationManager
{
    protected static ?string $relationship = 'lessons';
    
    // Puntatore alla nested resource
    protected static ?string $relatedResource = LessonResource::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->formatStateUsing(fn ($state) => $state . ' minuti'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Filtri per le lesson
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
            ]);
    }
}
```

## 🎨 **Personalizzazione Avanzata**

### **1. Customizzazione dei Nomi di Relazione**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\ParentResourceRegistration;
use Modules\healthcare_app\Filament\Resources\Courses\CourseResource;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;
    protected static ?string $parentResource = CourseResource::class;

    public static function getParentResourceRegistration(): ?ParentResourceRegistration
    {
        return CourseResource::asParent()
            ->relationship('lessons')
            ->inverseRelationship('course');
    }
}
```

### **2. Personalizzazione delle Breadcrumb**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;

class LessonsRelationManager extends RelationManager
{
    public static function getBreadcrumbRecordLabel(Model $record): string
    {
        return $record->title;
    }

    public static function getBreadcrumbs(Model $record, string $operation): array
    {
        return [
            'index' => 'Lezioni',
            'view' => $record->title,
        ];
    }
}
```

### **3. Gestione dei Permessi**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class LessonsRelationManager extends RelationManager
{
    public static function canViewAny(): bool
    {
        return Gate::allows('view-any', static::$relatedModel);
    }

    public static function canCreate(): bool
    {
        return Gate::allows('create', static::$relatedModel);
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('update', $record);
    }

    public static function canDelete(Model $record): bool
    {
        return Gate::allows('delete', $record);
    }
}
```

## 🔗 **Gestione degli URL e Routing**

### **1. Routing Automatico**

```php
// Il routing viene generato automaticamente:
// /courses/{course}/lessons
// /courses/{course}/lessons/create
// /courses/{course}/lessons/{lesson}/edit
```

### **2. URL Parameters**

```php
// Per accedere ai dati del parent durante la creazione:
public function mount($parent): void
{
    $this->parent = Course::find($parent);
}
```

### **3. Redirect corretto**

```php
// Nelle pagine nested, assicurati di usare il parametro corretto
// per il redirect dopo la creazione/modifica
public function create(): array
{
    return [
        'index' => Pages\ListLessons::route('/{parent}/lessons'),
        'create' => Pages\CreateLesson::route('/{parent}/lessons/create'),
    ];
}
```

## 📊 **Pattern di Implementazione**

### **1. Pattern per Accesso al Parent**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons\LessonResource;
use Modules\healthcare_app\Models\Course;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Accedi al parent tramite il parametro route
        $courseId = $this->getRouteKey();
        $course = Course::find($courseId);
        
        // Imposta il parent per la nuova lesson
        $data['course_id'] = $courseId;
        
        return $data;
    }
}
```

### **2. Pattern per la Validazione**

```php
<?php

namespace Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\healthcare_app\Filament\Resources\Courses\Resources\Lessons\LessonResource;
use Illuminate\Validation\Rule;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function getFormSchema(): array
    {
        return [
            // Campi del form
            \Filament\Forms\Components\TextInput::make('title')
                ->required()
                ->unique(
                    table: (new static::$resource::$model)()->getTable(),
                    column: 'title',
                    ignoreRecord: true,
                    modifyRuleUsing: function (Rule $rule, callable $get) {
                        return $rule->where('course_id', $get('course_id'));
                    }
                ),
        ];
    }
}
```

## 🎯 **Best Practices**

### **1. Struttura delle Cartelle**

```
app/Filament/Resources/
├── CourseResource.php
├── Pages/
│   ├── ListCourses.php
│   ├── CreateCourse.php
│   ├── EditCourse.php
│   └── ManageCourseLessons.php
└── Resources/
    └── Lessons/
        ├── LessonResource.php
        ├── Pages/
        │   ├── ListLessons.php
        │   ├── CreateLesson.php
        │   ├── EditLesson.php
        │   └── ViewLesson.php
        └── RelationManagers/
            └── LessonsRelationManager.php
```

### **2. Pattern di Navigazione**

```php
// Nella navigazione, usa i breadcrumb corretti
public static function getNavigationItems(): array
{
    return [
        NavigationItem::make('Lezioni')
            ->url(static::getUrl('lessons', ['record' => $this->record]))
            ->icon('heroicon-o-bookmark'),
    ];
}
```

### **3. Performance Optimization**

```php
// Usa eager loading per migliorare le performance
public static function table(Table $table): Table
{
    return $table
        ->query(static::$model::with(['course', 'category']))
        ->columns([
            // Colonne
        ]);
}
```

## 🔍 **Debug e Testing**

### **1. Debug dei Nomi di Relazione**

```php
// Verifica che i nomi di relazione siano corretti
dd($course->lessons()->getRelated());
```

### **2. Debug dei Parametri Route**

```php
// Debug dei parametri passati
dd($this->getRouteKey(), $this->getRecord());
```

### **3. Testing della Navigazione**

```php
// Test per verificare che il routing funzioni correttamente
public function test_nested_resource_routing()
{
    $course = Course::factory()->create();
    $response = $this->get(route('filament.healthcare_app.resources.courses.resources.lessons.list', [
        'course' => $course,
    ]));
    
    $response->assertStatus(200);
}
```

## 📚 **Riferimenti Ufficiali**

- **Documentazione Ufficiale**: https://filamentphp.com/docs/5.x/resources/nesting
- **API Reference**: https://filamentphp.com/docs/5.x/api/resources/nested-resources
- **Plugin Guava**: https://filamentphp.com/plugins/guava-nested-resources

## 🔄 **Integrazione con healthcare_app**

### **Pattern di Integrazione**

```php
// Pattern per gestire le relazioni gerarchiche
class NestedResourceGenerator
{
    public function generateNestedResource(string $parentResource, string $childResource, string $relationshipName): void
    {
        // 1. Genera la nested resource
        // 2. Crea il relation manager
        // 3. Configura i routing
        // 4. Imposta i permessi
    }
}
```

---

**
**Versione Filament:** 5.x  
**Stato:** 📚 Completamente Analizzato e Documentato