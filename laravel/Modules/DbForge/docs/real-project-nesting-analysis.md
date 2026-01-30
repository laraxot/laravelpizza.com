# Analisi del Nesting Reale nel Progetto Quaeris Fila5 Mono

## 📊 Analisi Completa delle Implementazioni Esistenti

### 🎯 Modulo Quaeris - Implementazioni Real

#### 1. **Customer → SurveyPdfs RelationManager**

**File:** `Modules/Quaeris/app/Filament/Resources/CustomerResource/RelationManagers/SurveyPdfsRelationManager.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Modules\Quaeris\Filament\Resources\SurveyPdfResource;

class SurveyPdfsRelationManager extends RelationManager
{
    protected static string $relationship = 'surveyPdfs';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return SurveyPdfResource::form($schema);
        /*
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
        */
    }

    public function table(Table $table): Table
    {
        return SurveyPdfResource::table($table);
    }
}
```

**Caratteristiche Chiave:**
- ✅ **Pattern Semplice e Diretto**: Reuse completo del form e della tabella da SurveyPdfResource
- ✅ **Astrazione Pulita**: Nessun codice duplicato, massima riusabilità
- ✅ **XotBase Pattern**: Non estende XotBaseRelationManager (da aggiornare)

**Model Relationship Corrispondente:**
```php
// Modules/Quaeris/app/Models/Customer.php
public function surveyPdfs(): HasMany
{
    return $this->hasMany(SurveyPdf::class);
}
```

#### 2. **SurveyPdf → QuestionCharts RelationManager**

**File:** `Modules/Quaeris/app/Filament/Resources/SurveyPdfResource/RelationManagers/QuestionChartsRelationManager.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Resources\SurveyPdfResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Chart\Actions\Chart\GetFontFamilyOptions;
use Modules\Chart\Actions\Chart\GetFontStyleOptions;
use Modules\Chart\Actions\Chart\GetTypeOptions;
use Modules\Limesurvey\Models\SurveyResponse;
use Modules\Quaeris\Actions\QuestionChart\GetQuestionOptionsBySurveyId;
use Modules\Quaeris\Actions\QuestionChart\MakeImgByQuestionChartModel2Action;
use Modules\Quaeris\Actions\SurveyPdf\ExportTypeAction;
use Modules\Quaeris\Datas\AnswersFilterData;
use Modules\Quaeris\Exports\AlertExport;
use Modules\Quaeris\Exports\EmailsExport;
use Modules\Quaeris\Filament\Resources\QuestionChartResource;
use Modules\Quaeris\Models\QuestionChart;
use Modules\Quaeris\Models\SurveyPdf;
use function Safe\date;
use Webmozart\Assert\Assert;

class QuestionChartsRelationManager extends RelationManager
{
    public static array $route_params = [];

    protected static string $relationship = 'questionCharts';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('question')
                    ->label('Domande')
                    ->options(
                        function () {
                            Assert::isInstanceOf($surveyPdf = $this->ownerRecord, SurveyPdf::class);

                            return app(GetQuestionOptionsBySurveyId::class)
                                ->execute((string) $surveyPdf->survey_id);
                        }
                    )
                    ->columnSpan('full')
                    ->searchable(),

                Fieldset::make('Domande')
                    ->schema([
                        TextInput::make('group_name'),
                        TextInput::make('title'),
                    ]),

                Fieldset::make('Risposte')
                    ->schema([
                        TextInput::make('answer_value'),
                        TextInput::make('answer_value_txt'),
                        TextInput::make('answer_value_no_txt'),
                        Select::make('data_type')
                            ->options([
                                'zeroTen' => 'Da zero a dieci',
                                'text' => 'Testuale',
                            ]),
                        TextInput::make('take')
                            ->integer(),
                    ]),

                Toggle::make('show_on_pdf'),
                Toggle::make('show_tot_invited'),
                TextInput::make('min')->integer(),
                TextInput::make('max')->integer(),
                TextInput::make('col_size')->integer(),
                Toggle::make('add_nulls')->inline(false),

                Fieldset::make('Chart vars')
                    ->relationship('chart')
                    ->schema([
                        Select::make('type')->options(app(GetTypeOptions::class)->execute()),
                        Select::make('group_by')
                            ->options([null => '---', 'date:o-W' => 'Settimanale', 'date:Y-M' => 'Mensile', 'date:Y-M-d' => 'Giornaliero', 'field:Q41' => 'field:Q41']),
                        Select::make('sort_by')
                            ->options([null => '---', 'date:o-W' => 'Settimanale', 'date:Y-m' => 'Mensile', 'date:Y-m-d' => 'Giornaliero', '_value' => '_value', 'field:Q41' => 'field:Q41']),
                        TextInput::make('width'),
                        TextInput::make('height'),
                        Toggle::make('show_box'),
                        Select::make('font_family')->options(app(GetFontFamilyOptions::class)->execute()),
                        Select::make('font_style')->options(app(GetFontStyleOptions::class)->execute()),
                        TextInput::make('font_size'),
                        Select::make('transparency')->options([
                            '0.0' => '0%', '0.1' => '10%', '0.2' => '20%', '0.3' => '30%',
                            '0.4' => '40%', '0.5' => '50%', '0.6' => '60%', '0.7' => '70%',
                            '0.8' => '80%', '0.9' => '90%', '1.0' => '100%',
                        ]),
                        TextInput::make('y_grace'),
                        Toggle::make('yaxis_hide'),
                        TextInput::make('x_label_angle'),
                        TextInput::make('x_label_margin'),
                        TextInput::make('plot_perc_width'),
                        Toggle::make('plot_value_show'),
                        Select::make('plot_value_format')->options([
                            1 => 'percentuale', 2 => '2 cifre decimali', 3 => '0 cifre decimali',
                        ]),
                        Toggle::make('plot_value_pos'),
                        ColorPicker::make('plot_value_color'),
                    ]),

                Repeater::make('chart colorissimi')
                    ->relationship('chart')
                    ->schema([
                        ColorPicker::make('list_color'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('questionTxt')->sortable()->wrap(),
                ImageColumn::make('img_src')->label('img')->disk('public_html')->height(120)->width(120),
                ToggleColumn::make('show_on_pdf'),
            ])
            ->filters([])

            ->recordActions([
                EditAction::make(),
                Action::make('regenImg2')
                    ->label('regenerate2')
                    ->icon('heroicon-o-arrow-path')
                    ->url(static function ($record): string {
                        $params = ['record' => $record];
                        $routeParams = self::$route_params;
                        $mergedParams = array_merge($params, $routeParams);

                        return QuestionChartResource::getUrl('regen-img-2', $mergedParams);
                    }),
            ])

            ->toolbarActions([
                DeleteBulkAction::make(),
                BulkAction::make('regen-imgs')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(function (Collection $collection): void {
                        foreach ($collection as $record) {
                            Assert::isInstanceOf($questionChart = $record, QuestionChart::class);
                            $responses = SurveyResponse::getResponsesForSurvey(
                                (string) $questionChart->survey_id
                            );
                            $responses = $responses->where('submitdate', '!=', null);
                            app(MakeImgByQuestionChartModel2Action::class)
                                ->onQueue()
                                ->execute($questionChart, $responses);
                        }
                    }),
            ])

            ->headerActions([
                CreateAction::make(),
                Action::make('exportPdf')
                    ->label('Pdf ')
                    ->icon('heroicon-s-document')
                    ->action(function () {
                        $ownerRecord = $this->ownerRecord;
                        Assert::isInstanceOf($ownerRecord, SurveyPdf::class);
                        $surveyPdf = $ownerRecord;
                        $answersFilterData = null;
                        if (session()->has('tableFilters')) {
                            $answersFilterData = AnswersFilterData::from(session('tableFilters'));
                        }
                        if ($answersFilterData === null) {
                            $answersFilterData = AnswersFilterData::from([
                                'survey_pdf_id' => (string) $surveyPdf->id,
                            ]);
                        }

                        return app(ExportTypeAction::class)->execute($surveyPdf, 'pdf', $answersFilterData);
                    }),

                Action::make('alert')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('gray')
                    ->action(function (array $data) {
                        $answersFilterData = AnswersFilterData::from(['date_from' => $data['date_from'], 'date_to' => $data['date_to']]);
                        Assert::isInstanceOf($this->ownerRecord, SurveyPdf::class);

                        return Excel::download(
                            new AlertExport($this->ownerRecord, $answersFilterData),
                            $this->ownerRecord->name.'_alert_Sett_'.date('W').'.xlsx'
                        );
                    })
                    ->schema([
                        DatePicker::make('date_from')->displayFormat('d/m/Y'),
                        DatePicker::make('date_to')->displayFormat('d/m/Y'),
                    ]),

                Action::make('email')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('gray')
                    ->action(function (array $data) {
                        $answersFilterData = AnswersFilterData::from(['date_from' => $data['date_from'], 'date_to' => $data['date_to']]);
                        Assert::isInstanceOf($this->ownerRecord, SurveyPdf::class);

                        return Excel::download(
                            new EmailsExport($this->ownerRecord, $answersFilterData),
                            $this->ownerRecord->name.'_contact_emails_Sett_'.date('W').'.xlsx'
                        );
                    })
                    ->schema([
                        DatePicker::make('date_from')->displayFormat('d/m/Y'),
                        DatePicker::make('date_to')->displayFormat('d/m/Y'),
                    ]),
            ])

            ->defaultSort('pos', 'asc');
    }
}
```

**Caratteristiche Eccezionali:**
- ✅ **Form Complesso Multi-Level**: Gestisce domande da LimeSurvey
- ✅ **Actions Custom Avanzate**: Export PDF/Excel con filtri dinamici
- ✅ **Integration Multi-Modulo**: Chart, LimeSurvey, Notify integration
- ✅ **Image Generation**: Auto-generazione immagini charts
- ✅ **Bulk Actions**: Rigenerazione massiva immagini
- ✅ **Dynamic Options**: Carica opzioni dinamiche dal parent SurveyPdf

**Model Relationships Corrispondenti:**
```php
// Modules/Quaeris/app/Models/SurveyPdf.php
public function questionCharts(): HasMany
{
    return $this->hasMany(QuestionChart::class);
}

public function questions(): HasMany
{
    return $this->hasMany(LimeQuestion::class, 'sid', 'survey_id');
}
```

### 🎯 Modulo User - Implementazioni Real

#### 1. **User → Roles RelationManager**

**File:** `Modules/User/app/Filament/Resources/UserResource/RelationManagers/RolesRelationManager.php`

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\User\Filament\Actions\Header\AttachRoleAction;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class RolesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    #[\Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
        ];
    }

    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'name' => TextColumn::make('name'),
            'team_id' => TextColumn::make('team_id'),
        ];
    }

    #[\Override]
    public function getTableHeaderActions(): array
    {
        /** @var array<string, Action> $parentActions */
        $parentActions = parent::getTableHeaderActions();

        return array_merge(
            $parentActions,
            [
                'attach' => AttachRoleAction::make(),
            ]
        );
    }
}
```

**Caratteristiche Chiave:**
- ✅ **XotBase Pattern**: Estende XotBaseRelationManager correttamente
- ✅ **Custom Attach Action**: Usa AttachRoleAction custom
- ✅ **Team Scoping**: Mostra team_id nelle colonne
- ✅ **Proper Override**: Usa #[\Override] per type safety

### 🏗️ Analisi dell'Architettura XotBaseRelationManager

#### XotBaseRelationManager - Il Fondamento

**File:** `Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`

**Caratteristiche Principali:**

1. **Auto-Resource Resolution**:
```php
public function getResource(): string
{
    if (isset(static::$resource) && \is_string(static::$resource) && static::$resource !== '') {
        return static::$resource;
    }

    $relationManagerClass = static::class;
    $parts = explode('\\', $relationManagerClass);
    $resourcesIndex = array_search('Resources', $parts, true);
    
    // Build resource class: Modules\Module\Filament\Resources\Resource
    $resourceParts = \array_slice($parts, 0, $resourcesIndex + 2);
    $resource = implode('\\', $resourceParts);
    
    static::$resource = $resource;
    return static::$resource;
}
```

2. **Form Schema Reuse**:
```php
public function getFormSchema(): array
{
    return $this->getResource()::getFormSchema();
}
```

3. **Dynamic Table Columns**:
```php
#[Override]
public function getTableColumns(): array
{
    $index = Arr::get($this->getResource()::getPages(), 'index');
    if (! $index) return [];
    
    $index_page = $index->getPage();
    if (! method_exists($index_page, 'getTableColumns')) return [];
    
    $instance = \is_string($index_page) ? app($index_page) : $index_page;
    return $instance->getTableColumns();
}
```

4. **Default Actions con Autorizzazioni**:
```php
public function getTableActions(): array
{
    return [
        EditAction::make()->visible(fn($record) => $this->canEdit($record)),
        DetachAction::make()->visible(fn($record) => $this->canDetach($record)),
    ];
}
```

## 📋 Gap Analysis - Moduli che Potrebbero Implementare il Nesting

### 🔍 Analisi dei Moduli con Potenziale Nesting

#### 1. **Modulo Job** - High Priority

**Relazioni Identificate:**
```php
// Modules/Job/app/Models/Task.php
public function frequencies(): HasMany
public function results(): HasMany

// Modules/Job/app/Models/Result.php
// Ha task_id foreign key - perfetto per nesting
```

**Implementazione Suggerita:**
- TaskResource → FrequenciesRelationManager
- TaskResource → ResultsRelationManager
- SchedulingHistory → ResultsRelationManager

#### 2. **Modulo Chart** - Medium Priority

**Resource Analizzate:**
- `ChartResource.php` - Esiste ma senza nesting
- `MixedChartResource.php` - Potrebbe essere nested sotto Chart

**Potenziali Relazioni:**
- Chart → MixedCharts (HasMany)
- Chart → ChartConfigs (HasMany)

#### 3. **Modulo Notify** - Medium Priority

**Resources Identificate:**
- Potenziale NotifyThemeResource → TemplatesRelationManager
- Potenziale NotifyTemplateResource → LogsRelationManager

#### 4. **Modulo CMS** - Medium Priority

**Struttura Potenziale:**
- PageResource → BlocksRelationManager
- ArticleResource → TagsRelationManager (ManyToMany)
- MenuResource → ItemsRelationManager

#### 5. **Modulo Geo** - Low Priority

**Potenziali Relazioni:**
- LocationResource → CoordinatesRelationManager
- RegionResource → LocationsRelationManager

## 🛠️ Pattern di Miglioramento Identificati

### 1. **Issue: Customer SurveyPdfs RelationManager**

**Current Code:**
```php
class SurveyPdfsRelationManager extends RelationManager
```

**Should Be:**
```php
class SurveyPdfsRelationManager extends XotBaseRelationManager
```

### 2. **Best Practice: Dynamic Options Loading**

**Pattern da QuestionChartsRelationManager:**
```php
Select::make('question')
    ->options(function () {
        $surveyPdf = $this->ownerRecord;
        return app(GetQuestionOptionsBySurveyId::class)
            ->execute((string) $surveyPdf->survey_id);
    })
```

### 3. **Best Practice: Custom Actions Integration**

**Pattern da QuestionChartsRelationManager:**
```php
Action::make('exportPdf')
    ->icon('heroicon-s-document')
    ->action(function () {
        $surveyPdf = $this->ownerRecord;
        return app(ExportTypeAction::class)
            ->execute($surveyPdf, 'pdf', $answersFilterData);
    })
```

### 4. **Best Practice: Bulk Operations**

**Pattern da QuestionChartsRelationManager:**
```php
BulkAction::make('regen-imgs')
    ->requiresConfirmation()
    ->action(function (Collection $collection): void {
        foreach ($collection as $record) {
            // Process each record
            app(MakeImgByQuestionChartModel2Action::class)
                ->onQueue()->execute($questionChart, $responses);
        }
    })
```

## 📊 Metriche di Utilizzo Correnti

### Moduli con Nesting Implementato:
- ✅ **Quaeris**: 2 RelationManagers (Customer→SurveyPdfs, SurveyPdf→QuestionCharts)
- ✅ **User**: 1+ RelationManagers (User→Roles con XotBase)

### Moduli senza Nesting (opportunità):
- 🔵 **Job**: 0 RelationManagers (potenziale 2-3)
- 🔵 **Chart**: 0 RelationManagers (potenziale 2)
- 🔵 **Notify**: 0 RelationManagers (potenziale 2-3)
- 🔵 **CMS**: 0 RelationManagers (potenziale 3-4)
- 🔵 **Geo**: 0 RelationManagers (potenziale 2)

### Copertura Attuale: ~20% del potenziale totale

## 🎯 Raccomandazioni Prioritarie

### 1. **Immediate (Week 1)**
- [ ] Fix SurveyPdfsRelationManager → estendere XotBaseRelationManager
- [ ] Implementare Job Module FrequenciesRelationManager

### 2. **Short-term (Weeks 2-3)**
- [ ] Implementare Chart Module MixedChartsRelationManager
- [ ] Implementare Notify Module TemplatesRelationManager

### 3. **Medium-term (Weeks 4-6)**
- [ ] Implementare CMS Module BlocksRelationManager
- [ ] Implementare Geo Module LocationsRelationManager

### 4. **Long-term (Month 2+)**
- [ ] Standardizzare tutti i RelationManager su XotBase
- [ ] Creare shared patterns per operations comuni
- [ ] Documentare best practices enterprise

---

**Analisi Basata Su:** Codice reale del progetto al 2026-01-23  
**Status:** Ready for Implementation  
**Priorità:** High - Job Module First  
**Estimated Effort:** 40-60 developer hours for full implementation
