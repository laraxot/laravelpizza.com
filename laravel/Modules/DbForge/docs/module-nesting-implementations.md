# Guide Specifiche per Implementazione Nesting per Modulo

## 🎯 Modulo Job - Implementation Guide

### Analisi delle Relazioni Esistenti

**Modello Task Relazioni:**
```php
// Da Modules/Job/app/Models/Task.php
public function frequencies(): HasMany
public function results(): HasMany
public function scheduleHistory(): HasMany
```

### Implementazione Proposta

#### 1. **TaskResource con Multiple RelationManagers**

```php
// Modules/Job/app/Filament/Resources/TaskResource.php
class TaskResource extends XotBaseResource
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
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
            'board' => BoardTasks::route('/board'),
        ];
    }
}
```

#### 2. **FrequenciesRelationManager**

```php
// Modules/Job/app/Filament/Resources/TaskResource/RelationManagers/FrequenciesRelationManager.php
<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\TaskResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Modules\Job\Models\Frequency;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class FrequenciesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'frequencies';
    
    protected static ?string $recordTitleAttribute = 'type';
    
    public function getFormSchema(): array
    {
        $task = $this->ownerRecord;
        
        return [
            Select::make('type')
                ->required()
                ->options([
                    'cron' => 'Cron Expression',
                    'interval' => 'Interval (minutes)',
                    'once' => 'Once',
                    'recurring' => 'Recurring',
                ])
                ->default('cron')
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('helper_text', $this->getHelperText($state))
                ),
                
            TextInput::make('expression')
                ->required()
                ->helperText(fn ($get) => $get('helper_text') ?? 'Enter cron expression or minutes')
                ->placeholder(fn ($get) => $this->getPlaceholder($get('type'))),
                
            Select::make('timezone')
                ->options(function () {
                    return Cache::remember('timezones_list', 86400, function () {
                        return timezone_identifiers_list();
                    });
                })
                ->searchable()
                ->default(config('app.timezone')),
                
            Toggle::make('is_active')
                ->default(true)
                ->helperText('Enable or disable this frequency'),
                
            TextInput::make('max_runs')
                ->numeric()
                ->helperText('Maximum number of runs (leave empty for unlimited)'),
                
            Select::make('failure_action')
                ->options([
                    'stop' => 'Stop on failure',
                    'retry' => 'Retry with backoff',
                    'continue' => 'Continue regardless',
                ])
                ->default('stop'),
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable()
                ->toggleable(),
                
            TextColumn::make('type')
                ->badge()
                ->color(fn ($state) => match($state) {
                    'cron' => 'primary',
                    'interval' => 'success',
                    'once' => 'warning',
                    'recurring' => 'info',
                    default => 'gray',
                }),
                
            TextColumn::make('expression')
                ->copyable()
                ->searchable()
                ->wrap(),
                
            TextColumn::make('timezone')
                ->toggleable(),
                
            TextColumn::make('next_run')
                ->dateTime('Y-m-d H:i:s')
                ->sortable()
                ->description(fn ($record): string => 
                    $record->next_run ? $record->next_run->diffForHumans() : ''
                ),
                
            TextColumn::make('run_count')
                ->label('Runs')
                ->sortable()
                ->alignCenter(),
                
            TextColumn::make('is_active')
                ->badge()
                ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                ->color(fn ($state) => $state ? 'success' : 'danger'),
        ];
    }
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            Action::make('test_expression')
                ->label('Test Expression')
                ->icon('heroicon-o-play-circle')
                ->color('primary')
                ->form([
                    TextInput::make('test_date')
                        ->default(now()->format('Y-m-d H:i:s'))
                        ->helperText('Date to test the expression against'),
                    TextInput::make('test_runs')
                        ->numeric()
                        ->default(5)
                        ->helperText('Number of next runs to calculate'),
                ])
                ->action(function (array $data) {
                    $task = $this->ownerRecord;
                    // Implement cron expression testing logic
                    $results = $this->testCronExpression(
                        $data['expression'], 
                        $data['test_date'], 
                        $data['test_runs'],
                        $data['timezone']
                    );
                    
                    $this->notify('success', 'Expression test results: ' . implode(', ', $results));
                }),
                
            Action::make('import_frequencies')
                ->label('Import Templates')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Select::make('template')
                        ->options([
                            'daily' => 'Daily Tasks',
                            'weekly' => 'Weekly Tasks', 
                            'monthly' => 'Monthly Tasks',
                            'custom' => 'Custom Schedule',
                        ]),
                ])
                ->action(function (array $data) {
                    $task = $this->ownerRecord;
                    $this->importFrequencyTemplate($task, $data['template']);
                }),
        ]);
    }
    
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            Action::make('run_now')
                ->label('Run Now')
                ->icon('heroicon-o-play')
                ->color('success')
                ->visible(fn ($record) => $record->is_active)
                ->action(function (Frequency $record) {
                    $task = $this->ownerRecord;
                    // Execute task immediately
                    dispatch(new \Modules\Job\Jobs\ExecuteTaskJob($task, $record));
                    $this->notify('success', 'Task queued for execution');
                }),
                
            Action::make('duplicate')
                ->label('Duplicate')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (Frequency $record) {
                    $new = $record->replicate();
                    $new->is_active = false; // Start inactive
                    $new->save();
                    $this->notify('success', 'Frequency duplicated');
                }),
        ]);
    }
    
    private function getHelperText(string $type): string
    {
        return match($type) {
            'cron' => 'Examples: */5 * * * * (every 5 min), 0 2 * * * (daily at 2 AM)',
            'interval' => 'Enter number of minutes between runs (e.g., 30 for every 30 minutes)',
            'once' => 'Enter date in YYYY-MM-DD HH:MM:SS format',
            'recurring' => 'Enter recurrence pattern (e.g., daily, weekly, monthly)',
            default => '',
        };
    }
    
    private function getPlaceholder(?string $type): string
    {
        return match($type) {
            'cron' => '*/5 * * * *',
            'interval' => '30',
            'once' => now()->format('Y-m-d H:i:s'),
            'recurring' => 'daily',
            default => '',
        };
    }
    
    private function testCronExpression(string $expression, string $testDate, int $runs, string $timezone): array
    {
        // Implement cron expression testing logic
        // This would use a cron library to calculate next runs
        return [];
    }
    
    private function importFrequencyTemplate($task, string $template): void
    {
        $templates = [
            'daily' => [
                ['type' => 'cron', 'expression' => '0 2 * * *', 'timezone' => config('app.timezone')],
            ],
            'weekly' => [
                ['type' => 'cron', 'expression' => '0 2 * * 0', 'timezone' => config('app.timezone')],
            ],
            'monthly' => [
                ['type' => 'cron', 'expression' => '0 2 1 * *', 'timezone' => config('app.timezone')],
            ],
        ];
        
        foreach ($templates[$template] ?? [] as $freq) {
            $task->frequencies()->create($freq);
        }
        
        $this->notify('success', "Imported {$template} frequency templates");
    }
}
```

#### 3. **ResultsRelationManager**

```php
// Modules/Job/app/Filament/Resources/TaskResource/RelationManagers/ResultsRelationManager.php
<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\TaskResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Modules\Job\Models\Result;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class ResultsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'results';
    
    protected static ?string $recordTitleAttribute = 'status';
    
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('status')
                ->badge()
                ->color(fn ($state) => match($state) {
                    'success' => 'success',
                    'failed' => 'danger',
                    'running' => 'warning',
                    'pending' => 'info',
                    default => 'gray',
                }),
            TextColumn::make('started_at')->dateTime(),
            TextColumn::make('finished_at')->dateTime(),
            TextColumn::make('duration')
                ->formatStateUsing(function ($state, $record) {
                    if (!$record->started_at || !$record->finished_at) return 'N/A';
                    return $record->finished_at->diffInSeconds($record->started_at) . 's';
                }),
            TextColumn::make('output')
                ->limit(50)
                ->searchable(),
            TextColumn::make('error_message')
                ->limit(50)
                ->color('danger')
                ->searchable(),
        ];
    }
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            Action::make('cleanup_old')
                ->label('Cleanup Old Results')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->form([
                    TextInput::make('days_old')
                        ->numeric()
                        ->default(30)
                        ->helperText('Delete results older than X days'),
                ])
                ->action(function (array $data) {
                    $task = $this->ownerRecord;
                    $count = $task->results()
                        ->where('created_at', '<', now()->subDays($data['days_old']))
                        ->delete();
                    $this->notify('success', "Deleted {$count} old results");
                }),
        ]);
    }
    
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            Action::make('view_logs')
                ->label('View Full Log')
                ->icon('heroicon-o-document-text')
                ->modalContent(function (Result $record) {
                    return view('job::result-logs', ['result' => $record]);
                }),
                
            Action::make('retry')
                ->label('Retry Task')
                ->icon('heroicon-o-arrow-path')
                ->visible(fn (Result $record) => $record->status === 'failed')
                ->action(function (Result $record) {
                    // Implement retry logic
                    $this->notify('success', 'Task queued for retry');
                }),
        ]);
    }
}
```

---

## 🎨 Modulo Chart - Implementation Guide

### Analisi delle Relazioni Potenziali

**Chart Model Relazioni:**
- Chart → MixedCharts (HasMany)
- Chart → ChartConfigs (HasMany)
- Chart → ChartDatasets (HasMany)

### Implementazione Proposta

#### 1. **ChartResource con MixedCharts RelationManager**

```php
// Modules/Chart/app/Filament/Resources/ChartResource/RelationManagers/MixedChartsRelationManager.php
<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Chart\Models\MixedChart;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class MixedChartsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'mixedCharts';
    
    protected static ?string $recordTitleAttribute = 'name';
    
    public function getFormSchema(): array
    {
        $parentChart = $this->ownerRecord;
        
        return [
            TextInput::make('name')
                ->required()
                ->helperText('Name for this mixed chart configuration'),
                
            Select::make('layout_type')
                ->options([
                    'vertical' => 'Vertical Stack',
                    'horizontal' => 'Horizontal Stack',
                    'grid' => 'Grid Layout',
                    'overlay' => 'Overlay Charts',
                ])
                ->default('vertical')
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $state === 'grid' ? $set('show_grid_options', true) : $set('show_grid_options', false)
                ),
                
            Repeater::make('chart_components')
                ->label('Chart Components')
                ->schema([
                    Select::make('chart_id')
                        ->label('Chart')
                        ->options(fn () => \Modules\Chart\Models\Chart::pluck('name', 'id'))
                        ->required()
                        ->searchable(),
                        
                    TextInput::make('position')
                        ->numeric()
                        ->default(1),
                        
                    Select::make('size')
                        ->options([
                            'small' => 'Small (25%)',
                            'medium' => 'Medium (50%)',
                            'large' => 'Large (75%)',
                            'full' => 'Full (100%)',
                        ])
                        ->default('medium'),
                        
                    TextInput::make('weight')
                        ->numeric()
                        ->default(1)
                        ->helperText('Weight for layout calculation'),
                ])
                ->columns(2)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => 
                    \Modules\Chart\Models\Chart::find($state['chart_id'] ?? null)?->name ?? 'New Chart'
                ),
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable(),
            TextColumn::make('layout_type')->badge(),
            TextColumn::make('chart_components_count')
                ->label('Components')
                ->counts('chartComponents')
                ->alignCenter(),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
    
    public function getTableHeaderActions(): array
    {
        return array_merge(parent::getTableHeaderActions(), [
            Action::make('preview_mixed_chart')
                ->label('Preview Mixed Chart')
                ->icon('heroicon-o-eye')
                ->color('primary')
                ->action(function () {
                    $parentChart = $this->ownerRecord;
                    // Generate preview URL or modal
                    $this->notify('info', 'Preview functionality coming soon');
                }),
        ]);
    }
    
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            Action::make('duplicate')
                ->label('Duplicate')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (MixedChart $record) {
                    $new = $record->replicate();
                    $new->name = $record->name . ' (Copy)';
                    $new->save();
                    $this->notify('success', 'Mixed chart duplicated');
                }),
        ]);
    }
}
```

---

## 🔔 Modulo Notify - Implementation Guide

### Analisi delle Relazioni Potenziali

**NotifyTheme Relazioni:**
- NotifyTheme → NotifyTemplates (HasMany)
- NotifyTheme → NotificationLogs (HasMany)

### Implementazione Proposta

#### 1. **NotifyThemeResource con Templates RelationManager**

```php
// Modules/Notify/app/Filament/Resources/NotifyThemeResource/RelationManagers/TemplatesRelationManager.php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class TemplatesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'templates';
    
    protected static ?string $recordTitleAttribute = 'name';
    
    public function getFormSchema(): array
    {
        $theme = $this->ownerRecord;
        
        return [
            TextInput::make('name')
                ->required()
                ->helperText('Template name for identification'),
                
            Select::make('type')
                ->options([
                    'email' => 'Email Template',
                    'sms' => 'SMS Template',
                    'push' => 'Push Notification',
                    'webhook' => 'Webhook Template',
                ])
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    match($state) {
                        'email' => $set('show_email_options', true),
                        'sms' => $set('show_sms_options', true),
                        'push' => $set('show_push_options', true),
                        'webhook' => $set('show_webhook_options', true),
                        default => null,
                    };
                }),
                
            TextInput::make('subject')
                ->visible(fn (callable $get) => $get('type') === 'email')
                ->required(fn (callable $get) => $get('type') === 'email'),
                
            RichEditor::make('content')
                ->required()
                ->helperText('Template content. Use {{variable}} syntax for dynamic values.')
                ->columnSpanFull(),
                
            Select::make('channel')
                ->options([
                    'default' => 'Default Channel',
                    'urgent' => 'Urgent Channel',
                    'marketing' => 'Marketing Channel',
                ])
                ->default('default'),
                
            TextInput::make('priority')
                ->numeric()
                ->default(1)
                ->helperText('Higher number = higher priority'),
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable(),
            TextColumn::make('type')->badge()->color(fn ($state) => match($state) {
                'email' => 'primary',
                'sms' => 'success', 
                'push' => 'warning',
                'webhook' => 'info',
                default => 'gray',
            })),
            TextColumn::make('subject')
                ->limit(30)
                ->visible(fn ($record) => $record->type === 'email'),
            TextColumn::make('channel')->badge(),
            TextColumn::make('priority')->alignCenter(),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
```

---

## 📝 Modulo CMS - Implementation Guide

### Analisi delle Relazioni Potenziali

**Page Model Relazioni:**
- Page → PageBlocks (HasMany)
- Page → PageVersions (HasMany)
- Article → ArticleTags (ManyToMany)

### Implementazione Proposta

#### 1. **PageResource con Blocks RelationManager**

```php
// Modules/Cms/app/Filament/Resources/PageResource/RelationManagers/BlocksRelationManager.php
<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\RelationManagers;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class BlocksRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'blocks';
    
    protected static ?string $recordTitleAttribute = 'type';
    
    public function getFormSchema(): array
    {
        return [
            Select::make('type')
                ->required()
                ->options([
                    'text' => 'Text Block',
                    'image' => 'Image Block',
                    'video' => 'Video Block',
                    'gallery' => 'Gallery Block',
                    'form' => 'Form Block',
                    'hero' => 'Hero Section',
                    'testimonial' => 'Testimonial',
                    'faq' => 'FAQ Section',
                    'contact' => 'Contact Form',
                ])
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    match($state) {
                        'text' => $set('show_text_options', true),
                        'image' => $set('show_image_options', true),
                        'video' => $set('show_video_options', true),
                        'gallery' => $set('show_gallery_options', true),
                        default => null,
                    };
                }),
                
            TextInput::make('title')
                ->helperText('Optional title for the block'),
                
            RichEditor::make('content')
                ->visible(fn (callable $get) => $get('type') === 'text')
                ->columnSpanFull(),
                
            TextInput::make('position')
                ->numeric()
                ->default(function () {
                    $page = $this->ownerRecord;
                    return $page->blocks()->max('position') + 1;
                })
                ->helperText('Position in page layout'),
                
            Toggle::make('is_active')
                ->default(true),
                
            Toggle::make('is_full_width')
                ->default(false)
                ->helperText('Make block span full width'),
        ];
    }
    
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('type')->badge(),
            TextColumn::make('title')->searchable(),
            TextColumn::make('position')->sortable(),
            IconColumn::make('is_active')->boolean(),
            IconColumn::make('is_full_width')->boolean(),
            TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }
    
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            \Filament\Tables\Actions\Action::make('move_up')
                ->label('Move Up')
                ->icon('heroicon-o-chevron-up')
                ->action(function ($record) {
                    $currentPos = $record->position;
                    $record->update(['position' => max(1, $currentPos - 1)]);
                })
                ->visible(fn ($record) => $record->position > 1),
                
            \Filament\Tables\Actions\Action::make('move_down')
                ->label('Move Down') 
                ->icon('heroicon-o-chevron-down')
                ->action(function ($record) {
                    $currentPos = $record->position;
                    $record->update(['position' => $currentPos + 1]);
                }),
        ]);
    }
}
```

---

## 📁 Template Generale per Implementazione

### Directory Structure Template

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

### Migration Template

```php
// database/migrations/create_child_models_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_model_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type')->default('default');
            $table->text('content')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['parent_model_id', 'position']);
            $table->index(['parent_model_id', 'is_active']);
        });
    }
};
```

### Policy Template

```php
// app/Policies/ChildPolicy.php
class ChildPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user, ParentModel $parent): bool
    {
        return $user->can('view', $parent);
    }
    
    public function create(User $user, ParentModel $parent): bool
    {
        return $user->can('update', $parent) && $parent->can_have_children;
    }
    
    public function update(User $user, ChildModel $child): bool
    {
        return $user->can('update', $child->parent);
    }
    
    public function delete(User $user, ChildModel $child): bool
    {
        return $user->can('delete', $child->parent) && !$child->is_locked;
    }
}
```

---

## 🎯 Roadmap di Implementazione Prioritaria

### Phase 1: Job Module (Week 1-2)
- [ ] Implementare FrequenciesRelationManager
- [ ] Implementare ResultsRelationManager  
- [ ] Creare actions per task testing
- [ ] Aggiungere performance widgets

### Phase 2: Chart Module (Week 2-3)
- [ ] Implementare MixedChartsRelationManager
- [ ] Creare preview functionality
- [ ] Integrare con existing charts
- [ ] Aggiungere export features

### Phase 3: Notify Module (Week 3-4)
- [ ] Implementare TemplatesRelationManager
- [ ] Aggiungere template preview
- [ ] Creare send test actions
- [ ] Integrare con notification system

### Phase 4: CMS Module (Week 4-5)
- [ ] Implementare BlocksRelationManager
- [ ] Aggiungere drag & drop ordering
- [ ] Creare preview functionality
- [ ] Integrare con frontend rendering

### Phase 5: Testing & Documentation (Week 5-6)
- [ ] Scrivere unit tests per tutti i RelationManagers
- [ ] Creare browser tests per UI interactions
- [ ] Documentare patterns e best practices
- [ ] Creare migration scripts

---

**Ultimo Aggiornamento:** 2026-01-23  
**Status:** Ready for Implementation  
**Priority:** High - Job Module First
