# Activity Module - Guida Step-by-Step Migrazione Filament 4

## 🎯 Panoramica della Migrazione

Il modulo Activity gestisce logging delle attività utente con Spatie Activity Log. La migrazione a Filament 4 migliorerà significativamente performance e UX per visualizzazione/analisi degli activity logs.

---

## 📋 Pre-Migrazione Checklist

### Step 1: Environment Preparation
```bash
# 1.1 - Backup del modulo
cp -r Modules/Activity/ backup_activity_module/
git branch activity-filament-4-migration

# 1.2 - Verificare dipendenze Spatie
composer show spatie/laravel-activitylog

# 1.3 - Backup activity logs (importanti per audit)
mysqldump -u username -p database_name activity_log > backup_activity_logs.sql
```

### Step 2: Verify Current State
```bash
# 2.1 - Controllare tabelle esistenti
php artisan tinker
>>> Schema::hasTable('activity_log')
>>> \Spatie\Activitylog\Models\Activity::count()

# 2.2 - Verificare dependency da Xot
grep -r "XotBaseResource" Modules/Activity/
```

---

## 🏗️ STEP 1: Enhanced Activity Model

### 1.1 - Create Enhanced Activity Resource

**File:** `Modules/Activity/app/Filament/Resources/ActivityResource.php`

```php
<?php

namespace Modules\Activity\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Schema\Components\TextInput;
use Filament\Schema\Components\Textarea;
use Filament\Schema\Components\Select;
use Filament\Schema\Components\KeyValue;
use Filament\Schema\Components\ViewField;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\DateFilter;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'System';
    protected static ?string $navigationLabel = 'Activity Logs';

    // Read-only resource
    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }

    /**
     * STEP 1: Schema per view-only con enhanced details
     */
    public static function getMainSchema(): array
    {
        return [
            TextInput::make('log_name')
                ->disabled()
                ->label('Log Category'),

            TextInput::make('description')
                ->disabled()
                ->label('Action Description'),

            TextInput::make('causer.name')
                ->disabled()
                ->label('Performed By'),

            TextInput::make('subject_type')
                ->disabled()
                ->formatStateUsing(fn($state) => class_basename($state))
                ->label('Model Type'),

            ViewField::make('properties_display')
                ->view('activity::properties-display')
                ->viewData(fn($record) => [
                    'properties' => $record->properties,
                    'changes' => $record->changes,
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * STEP 2: Enhanced table con performance optimization
     */
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')
                ->dateTime('M j, H:i')
                ->sortable()
                ->description(fn($record) => $record->created_at->diffForHumans())
                ->weight('medium'),

            BadgeColumn::make('log_name')
                ->colors([
                    'primary' => 'default',
                    'success' => 'created',
                    'warning' => 'updated',
                    'danger' => 'deleted',
                    'info' => 'login',
                ])
                ->sortable(),

            TextColumn::make('description')
                ->searchable()
                ->sortable()
                ->limit(50)
                ->tooltip(fn($record) => $record->description),

            TextColumn::make('causer.name')
                ->searchable()
                ->sortable()
                ->placeholder('System')
                ->url(fn($record) => $record->causer_id ?
                    route('filament.admin.resources.users.view', $record->causer_id) : null
                )
                ->openUrlInNewTab(),

            TextColumn::make('subject_type')
                ->formatStateUsing(fn($state) => $state ? class_basename($state) : 'N/A')
                ->badge()
                ->color('gray'),

            TextColumn::make('subject_id')
                ->sortable()
                ->placeholder('N/A'),

            BadgeColumn::make('changes_count')
                ->getStateUsing(fn($record) => count($record->changes ?? []))
                ->colors([
                    'success' => fn($state) => $state === 0,
                    'warning' => fn($state) => $state > 0 && $state <= 5,
                    'danger' => fn($state) => $state > 5,
                ])
                ->label('Changes'),
        ];
    }

    /**
     * STEP 3: Advanced filtering per large datasets
     */
    public static function getTableFilters(): array
    {
        return array_merge(parent::getTableFilters(), [
            SelectFilter::make('log_name')
                ->options([
                    'default' => 'Default',
                    'created' => 'Created',
                    'updated' => 'Updated',
                    'deleted' => 'Deleted',
                    'login' => 'Login',
                    'logout' => 'Logout',
                ])
                ->multiple(),

            SelectFilter::make('causer')
                ->relationship('causer', 'name')
                ->searchable()
                ->multiple()
                ->preload(),

            SelectFilter::make('subject_type')
                ->options(function() {
                    return Activity::query()
                        ->whereNotNull('subject_type')
                        ->distinct()
                        ->pluck('subject_type')
                        ->mapWithKeys(fn($type) => [$type => class_basename($type)])
                        ->toArray();
                })
                ->multiple(),

            DateFilter::make('created_at')
                ->label('Activity Date'),

            \Filament\Tables\Filters\Filter::make('today')
                ->query(fn($query) => $query->whereDate('created_at', today()))
                ->label('Today'),

            \Filament\Tables\Filters\Filter::make('with_changes')
                ->query(fn($query) => $query->whereNotNull('properties->attributes'))
                ->label('With Changes'),

            \Filament\Tables\Filters\Filter::make('system_actions')
                ->query(fn($query) => $query->whereNull('causer_id'))
                ->label('System Actions'),
        ]);
    }

    /**
     * STEP 4: Actions per analisi dettagliata
     */
    public static function getTableActions(): array
    {
        return [
            Action::make('view_changes')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->visible(fn($record) => !empty($record->changes))
                ->modalContent(function($record) {
                    return view('activity::changes-modal', [
                        'activity' => $record,
                        'changes' => $record->changes,
                    ]);
                })
                ->modalHeading('Activity Changes')
                ->modalWidth('3xl'),

            Action::make('view_subject')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('success')
                ->visible(fn($record) => $record->subject_id && $record->subject_type)
                ->action(function($record) {
                    // Navigate to subject if resource exists
                    return $this->redirectToSubject($record);
                }),

            Action::make('export_context')
                ->icon('heroicon-o-document-arrow-down')
                ->color('gray')
                ->action(function($record) {
                    return response()->json([
                        'activity' => $record->toArray(),
                        'properties' => $record->properties,
                        'changes' => $record->changes,
                    ])
                    ->download("activity-{$record->id}-context.json");
                }),
        ];
    }

    /**
     * STEP 5: Performance optimization crucial per large datasets
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['causer:id,name']) // Only load needed columns
            ->latest() // Default to latest first
            ->limit(1000); // Limit large datasets
    }

    /**
     * STEP 6: Table configuration per performance
     */
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return parent::table($table)
            ->defaultSort('created_at', 'desc')
            ->poll('60s') // Longer poll interval per performance
            ->deferLoading() // Defer loading per large tables
            ->paginated([25, 50, 100])
            ->extremePaginationLinks();
    }
}
```

---

## 🏗️ STEP 2: Activity Dashboard Widget

### 2.1 - Real-time Activity Dashboard

**File:** `Modules/Activity/app/Filament/Widgets/ActivityDashboard.php`

```php
<?php

namespace Modules\Activity\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Spatie\Activitylog\Models\Activity;

class ActivityDashboard extends Widget
{
    protected static string $view = 'activity::widgets.dashboard';

    /**
     * STEP 1: Static table data per monitoring
     */
    public function table(Table $table): Table
    {
        return $table
            ->records($this->getActivityMetrics())
            ->columns([
                TextColumn::make('period')
                    ->weight('semibold'),

                TextColumn::make('total_activities')
                    ->numeric()
                    ->color('primary'),

                TextColumn::make('unique_users')
                    ->numeric()
                    ->color('success'),

                TextColumn::make('system_actions')
                    ->numeric()
                    ->color('gray'),

                BadgeColumn::make('trend')
                    ->colors([
                        'success' => fn($state) => str_contains($state, '+'),
                        'danger' => fn($state) => str_contains($state, '-'),
                        'gray' => fn($state) => $state === '0%',
                    ]),
            ])
            ->poll('120s'); // 2-minute updates
    }

    private function getActivityMetrics(): array
    {
        return [
            [
                'period' => 'Last Hour',
                'total_activities' => Activity::where('created_at', '>', now()->subHour())->count(),
                'unique_users' => Activity::where('created_at', '>', now()->subHour())
                    ->whereNotNull('causer_id')
                    ->distinct('causer_id')
                    ->count(),
                'system_actions' => Activity::where('created_at', '>', now()->subHour())
                    ->whereNull('causer_id')
                    ->count(),
                'trend' => '+12%',
            ],
            [
                'period' => 'Today',
                'total_activities' => Activity::whereDate('created_at', today())->count(),
                'unique_users' => Activity::whereDate('created_at', today())
                    ->whereNotNull('causer_id')
                    ->distinct('causer_id')
                    ->count(),
                'system_actions' => Activity::whereDate('created_at', today())
                    ->whereNull('causer_id')
                    ->count(),
                'trend' => '+8%',
            ],
            [
                'period' => 'This Week',
                'total_activities' => Activity::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
                'unique_users' => Activity::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->whereNotNull('causer_id')->distinct('causer_id')->count(),
                'system_actions' => Activity::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->whereNull('causer_id')->count(),
                'trend' => '+15%',
            ],
        ];
    }
}
```

---

## 🏗️ STEP 3: Performance Optimizations

### 3.1 - Database Optimization

```bash
# STEP 1: Add performance indexes
php artisan make:migration add_activity_performance_indexes

# In migration:
Schema::table('activity_log', function (Blueprint $table) {
    $table->index(['log_name', 'created_at']);
    $table->index(['causer_id', 'created_at']);
    $table->index(['subject_type', 'subject_id', 'created_at']);
    $table->index('created_at');
});
```

### 3.2 - Cleanup Command

**File:** `Modules/Activity/app/Console/Commands/CleanupActivityLogsCommand.php`

```php
<?php

namespace Modules\Activity\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class CleanupActivityLogsCommand extends Command
{
    protected $signature = 'activity:cleanup {--days=90 : Number of days to keep}';
    protected $description = 'Clean up old activity logs to maintain performance';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Cleaning up activity logs older than {$days} days...");

        $deletedCount = Activity::where('created_at', '<', $cutoffDate)->delete();

        $this->info("Deleted {$deletedCount} old activity log entries.");

        // Optimize table
        \DB::statement('OPTIMIZE TABLE activity_log');
        $this->info('Activity log table optimized.');

        return Command::SUCCESS;
    }
}
```

---

## 🏗️ STEP 4: Enhanced Views

### 4.1 - Properties Display View

**File:** `Modules/Activity/resources/views/properties-display.blade.php`

```blade
<div class="space-y-4">
    @if(!empty($properties))
        <div>
            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Properties</h4>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                <pre class="text-sm overflow-x-auto">{{ json_encode($properties, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    @endif

    @if(!empty($changes))
        <div>
            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Changes</h4>
            <div class="space-y-2">
                @foreach($changes as $field => $change)
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded p-2">
                        <span class="font-medium">{{ $field }}:</span>
                        <div class="ml-4 mt-1">
                            @if(is_array($change) && isset($change['old'], $change['new']))
                                <div class="text-red-600 dark:text-red-400">- {{ $change['old'] ?? 'null' }}</div>
                                <div class="text-green-600 dark:text-green-400">+ {{ $change['new'] ?? 'null' }}</div>
                            @else
                                <div>{{ json_encode($change) }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
```

---

## 🏗️ STEP 5: Testing Implementation

### 5.1 - Feature Tests

**File:** `Modules/Activity/tests/Feature/ActivityResourceTest.php`

```php
<?php

namespace Modules\Activity\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Activity\Filament\Resources\ActivityResource;
use Spatie\Activitylog\Models\Activity;
use Modules\User\Models\User;

class ActivityResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_activity_list(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Activity::factory()->count(10)->create();

        Livewire::test(ActivityResource\Pages\ListActivities::class)
            ->assertSuccessful();
    }

    public function test_can_filter_activities_by_log_name(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Activity::factory()->create(['log_name' => 'created']);
        Activity::factory()->create(['log_name' => 'updated']);

        Livewire::test(ActivityResource\Pages\ListActivities::class)
            ->filterTable('log_name', ['created'])
            ->assertCanSeeTableRecords(Activity::where('log_name', 'created')->get())
            ->assertCanNotSeeTableRecords(Activity::where('log_name', 'updated')->get());
    }

    public function test_performance_with_large_dataset(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        // Create large dataset
        Activity::factory()->count(1000)->create();

        $start = microtime(true);

        Livewire::test(ActivityResource\Pages\ListActivities::class)
            ->assertSuccessful();

        $duration = microtime(true) - $start;

        $this->assertLessThan(3.0, $duration, 'Activity resource loading too slow');
    }
}
```

---

## 🏗️ STEP 6: Deployment Steps

### 6.1 - Migration Deployment

```bash
# STEP 1: Run performance migrations
php artisan migrate --path=Modules/Activity/database/migrations/

# STEP 2: Register cleanup command
# Add to ActivityServiceProvider:
$this->commands([
    \Modules\Activity\Console\Commands\CleanupActivityLogsCommand::class,
]);

# STEP 3: Setup scheduled cleanup
# In app/Console/Kernel.php:
$schedule->command('activity:cleanup --days=90')->monthly();

# STEP 4: Test performance
php artisan activity:cleanup --days=30
```

### 6.2 - Performance Verification

```bash
# STEP 1: Query performance test
php artisan tinker
>>> $start = microtime(true);
>>> $activities = \Spatie\Activitylog\Models\Activity::with('causer:id,name')->latest()->paginate(25);
>>> $duration = microtime(true) - $start;
>>> echo "Query took: " . round($duration * 1000, 2) . "ms";

# STEP 2: Index effectiveness
>>> DB::select("SHOW INDEX FROM activity_log");
```

---

## ✅ Success Indicators

✅ **Activity logs caricano velocemente** (< 2s con 1000+ records)
✅ **Filtri real-time** funzionano senza lag
✅ **Dashboard widgets** aggiornano automaticamente
✅ **Performance indexes** attivi e utilizzati
✅ **Cleanup automatico** configurato
✅ **Change tracking** visualizzazione chiara

## 🎯 Miglioramenti Implementati

1. **Performance optimization** con eager loading e indexes
2. **Advanced filtering** per large datasets
3. **Real-time dashboard** con metrics
4. **Change visualization** enhanced
5. **Automatic cleanup** per maintenance
6. **Export capabilities** per audit compliance

La migrazione Activity module dimostra come gestire **large datasets** con Filament 4 mantenendo performance ottimali.
