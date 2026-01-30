# Best Practices per Nested Resources con Laravel Modules

## Introduzione

Questo documento descrive le best practices per implementare nested resources all'interno di un'applicazione strutturata con Laravel Modules. Le nested resources permettono di creare una struttura gerarchica di dati che riflette le relazioni reali tra le entità.

## Struttura Consigliata

### 1. Organizzazione del Codice

```
Modules/
└── SurveyModule/
    ├── app/
    │   ├── Filament/
    │   │   ├── Resources/
    │   │   │   ├── SurveyResource/
    │   │   │   │   ├── Pages/
    │   │   │   │   │   ├── ListSurveys.php
    │   │   │   │   │   ├── CreateSurvey.php
    │   │   │   │   │   ├── ViewSurvey.php
    │   │   │   │   │   ├── EditSurvey.php
    │   │   │   │   │   └── ManageSurveyQuestions.php  # Nested resource page
    │   │   │   │   ├── QuestionsRelationManager.php  # Link to nested resource
    │   │   │   │   └── SurveyResource.php
    │   │   │   ├── QuestionResource/
    │   │   │   │   ├── Pages/
    │   │   │   │   │   ├── ListQuestions.php
    │   │   │   │   │   ├── CreateQuestion.php
    │   │   │   │   │   ├── ViewQuestion.php
    │   │   │   │   │   └── EditQuestion.php
    │   │   │   │   └── QuestionResource.php
    │   │   │   └── AnswerResource/
    │   │   │       └── AnswerResource.php
    │   └── Models/
    │       ├── Survey.php
    │       ├── Question.php
    │       └── Answer.php
    └── docs/
        └── nested-resources-best-practices.md
```

### 2. Naming Convention per Nested Resources

- Usare la forma singolare per i nomi delle risorse: `QuestionResource` invece di `QuestionsResource`
- Usare il formato `ParentResource::class` per il riferimento alla risorsa padre
- Mantenere la gerarchia logica: Survey → Question → Answer

## Implementazione delle Relazioni

### 1. Modello Parente

```php
<?php

namespace Modules\SurveyModule\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['title', 'description', 'tenant_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Se si usa multi-tenancy
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (auth()->hasUser() && filament()->getTenant()) {
                $query->where('tenant_id', filament()->getTenant()->id);
            }
        });
    }
}
```

### 2. Modello Figlio

```php
<?php

namespace Modules\SurveyModule\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['survey_id', 'question_text', 'question_type', 'order'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
```

### 3. Nested Resource

```php
<?php

namespace Modules\SurveyModule\Filament\Resources\QuestionResource;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SurveyModule\Filament\Resources\SurveyResource;

class QuestionResource extends XotBaseResource
{
    protected static ?string $model = \Modules\SurveyModule\Models\Question::class;
    protected static ?string $parentResource = SurveyResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'view' => Pages\ViewQuestion::route('/{record}'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
```

## Implementazione del Relation Manager

### 1. Relation Manager per Collegamento

```php
<?php

namespace Modules\SurveyModule\Filament\Resources\SurveyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\SurveyModule\Filament\Resources\QuestionResource;
use Modules\SurveyModule\Models\Question;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';
    protected static ?string $relatedResource = QuestionResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question_text')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('question_type')
                    ->options([
                        'text' => 'Text',
                        'multiple_choice' => 'Multiple Choice',
                        'rating' => 'Rating',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text')
            ->columns([
                Tables\Columns\TextColumn::make('question_text'),
                Tables\Columns\TextColumn::make('question_type'),
                Tables\Columns\TextColumn::make('order'),
            ])
            ->filters([
                //
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
}
```

## Implementazione della Pagina di Gestione

### 1. Pagina per Gestire Risorse Annidate

```php
<?php

namespace Modules\SurveyModule\Filament\Resources\SurveyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRelatedRecords;
use Modules\SurveyModule\Filament\Resources\QuestionResource;
use Modules\SurveyModule\Models\Survey;

class ManageSurveyQuestions extends ManageRelatedRecords
{
    protected static string $resource = QuestionResource::class;
    protected static string $relationship = 'questions';
    protected static ?string $navigationLabel = 'Questions';
    protected static ?string $breadcrumb = 'Questions';

    public function getTitle(): string
    {
        $survey = $this->getOwnerRecord();
        return "Questions for: {$survey->title}";
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(QuestionResource::getUrl('create', [
                    'survey' => $this->getOwnerRecord()->id
                ])),
        ];
    }
}
```

## Gestione della Multi-tenancy

### 1. Implementazione nel Modello Utente

```php
<?php

namespace Modules\User\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Tenant\Models\Team::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
```

### 2. Implementazione nel Panel Configuration

```php
use Modules\Tenant\Models\Team;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->tenant(Team::class, slugAttribute: 'slug')
        ->tenantRegistration(RegisterTeam::class)
        ->tenantProfile(EditTeamProfile::class);
}
```

## Considerazioni di Sicurezza

### 1. Controllo degli Accessi

```php
// In QuestionResource.php
public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
{
    // Verifica che l'utente possa vedere le domande per questo survey
    return $ownerRecord->tenant_id === filament()->getTenant()->id;
}
```

### 2. Scoping Automatico

```php
// In Question.php
protected static function booted(): void
{
    static::addGlobalScope('tenant_and_survey', function (Builder $query) {
        if (auth()->hasUser() && filament()->getTenant()) {
            $query->whereHas('survey', function (Builder $subQuery) {
                $subQuery->where('tenant_id', filament()->getTenant()->id);
            });
        }
    });
}
```

## Performance Optimization

### 1. Eager Loading

```php
// In SurveyResource.php
protected function getTableQuery(): Builder
{
    return static::getModel()::query()
        ->with(['questions', 'responses'])
        ->where('tenant_id', filament()->getTenant()->id);
}
```

### 2. Indicizzazione

```php
// Migration per assicurare buone performance
Schema::table('questions', function (Blueprint $table) {
    $table->index(['survey_id', 'tenant_id']);
    $table->index(['tenant_id', 'created_at']);
});
```

## Gestione degli Errori

### 1. Controllo dell'esistenza della relazione

```php
public function mount(int | string $survey): void
{
    $this->survey = Survey::findOrFail($survey);
    
    // Verifica che l'utente possa accedere a questo survey
    abort_unless($this->survey->can('view', $this->survey), 403);
    
    // Verifica la relazione con il tenant
    abort_unless(
        $this->survey->tenant_id === filament()->getTenant()->id, 
        403
    );
}
```

## Testing delle Nested Resources

### 1. Test per la funzionalità di annidamento

```php
public function test_user_can_view_nested_questions(): void
{
    $user = User::factory()->create();
    $survey = Survey::factory()->for($user->teams->first())->create();
    $question = Question::factory()->create(['survey_id' => $survey->id]);

    $response = $this->actingAs($user)
        ->get(QuestionResource::getUrl('view', ['record' => $question->id]));

    $response->assertSuccessful();
}

public function test_user_cannot_view_other_tenants_questions(): void
{
    $user = User::factory()->create();
    $otherTenantSurvey = Survey::factory()->create(['tenant_id' => 999]); // Different tenant
    $question = Question::factory()->create(['survey_id' => $otherTenantSurvey->id]);

    $response = $this->actingAs($user)
        ->get(QuestionResource::getUrl('view', ['record' => $question->id]));

    $response->assertForbidden();
}
```

## Conclusione

Implementare nested resources con Laravel Modules richiede attenzione alla struttura del codice, alla sicurezza e alle performance. Seguendo queste best practices, si può creare un sistema robusto e scalabile che mantiene la separazione logica tra i moduli mentre permette relazioni complesse tra le risorse.