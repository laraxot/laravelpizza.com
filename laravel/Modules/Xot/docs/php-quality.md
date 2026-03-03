# PHPStan Code Quality Guide - Laraxot

**
**Principi**: DRY + KISS + SOLID + Robust
**Stack**: Laravel 12 + Filament 4 + PHP 8.3 + Laraxot
**Obiettivo**: 0 errori PHPStan Level 10 + Complexity < 10 + Quality > 80%

---

## 📑 Indice

1. [Regole Assolute](#-regole-assolute)
2. [Quick Reference - Comandi](#-quick-reference---comandi-essenziali)
3. [Workflow Operativo](#-workflow-operativo)
4. [Regole Architetturali](#-regole-architetturali)
5. [Patterns di Correzione](#-patterns-di-correzione)
6. [Complexity Reduction](#-complexity-reduction-patterns)
7. [Widget Best Practices](#-widget-best-practices)
8. [Code Quality Tools](#-code-quality-tools)
9. [Commenti e TODO](#-commenti-e-todo)
10. [Filament Class Extensions](#-filament-class-extension-rules)
11. [Anti-Pattern da Evitare](#-anti-pattern-da-evitare)
12. [Checklist e Mantra](#-checklist-e-mantra-finale)

---

## 🚨 Regole Assolute

### Mai Modificare Configurazione
- **NON modificare MAI** `laravel/phpstan.neon`
- **NON creare baseline** - tutti gli errori vanno corretti
- **NON ignorare errori** - approccio "fix, don't ignore"
- **NON usare** `@phpstan-ignore` (eccezione: solo per bug noti di PHPStan con issue aperta)

### Filosofia Fondamentale
- **Docs come Bibbia**: Studia `Modules/{Modulo}/docs/` prima di ogni correzione
- **Link sempre relativi**: Mai path assoluti nei file .md
- **Naming files**: Minuscolo, no date, solo README.md può essere maiuscolo
- **Property exists**: NON funziona con magic attributes Eloquent - usa `isset()`
- **Complexity target**: Ogni metodo < 10 cyclomatic complexity
- **Function length**: Ogni metodo < 20 righe (target), max 50 righe

---

## 📋 Quick Reference - Comandi Essenziali

```bash
# Analisi PHPStan completa
cd laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1

# Analisi singolo modulo
./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1

# Analisi file specifico
./vendor/bin/phpstan analyse Modules/{Module}/app/path/to/File.php --level=10 --error-format=table

# Verifica autoload
composer dump-autoload && php artisan config:clear && php artisan cache:clear

# Code Quality Tools
./vendor/bin/pint --dirty                    # Format changed files
php phpmd.phar path/to/file text cleancode,codesize,design,naming
./vendor/bin/phpinsights analyse Modules/{Module} --format=table

# Complexity Analysis
php phpmd.phar Modules/{Module} text codesize --reportfile /tmp/complexity.txt
```

---

## 🎯 Workflow Operativo

### Fase 1: Preparazione
1. **Aumenta confidenza**: Studia architettura e business logic
2. **Studia docs**: Leggi `Modules/{Modulo}/docs/` e `Themes/{Tema}/docs/`
3. **Aggiorna docs**: Mantieni documentazione sempre aggiornata

### Fase 2: Analisi
```bash
cd laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1 > /tmp/phpstan-report.txt
./vendor/bin/phpinsights analyse Modules/{Module} > /tmp/insights-report.txt
```

### Fase 3: Correzione Sistematica
1. **Scegli modulo**: Inizia da moduli con meno errori (quick wins)
2. **Categorizza errori**: Raggruppa per tipo (argument.type, return.type, ecc.)
3. **Correggi batch**: Pattern simili insieme
4. **Verifica incrementale**: Riesegui PHPStan dopo ogni batch
5. **Aggiorna docs**: Documenta modifiche e pattern applicati
6. **Quality check**: Verifica complexity e PHP Insights

### Fase 4: Verifica Finale
```bash
./vendor/bin/phpstan analyse Modules --memory-limit=-1
./vendor/bin/pint --dirty
./vendor/bin/phpinsights analyse Modules/{Module}
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

---

## 🏗️ Regole Architetturali

### Struttura Modulare
- Ogni modulo è **completamente indipendente**
- Namespace: `Modules\{ModuleName}\` (MAI con prefisso "app")
- Autoload indipendente per ogni modulo
- Ogni modulo ha proprio `composer.json`

### Estensione Classi Filament
**MAI estendere classi Filament direttamente** - sempre XotBase:
- `Filament\Resources\Resource` → `Modules\Xot\Filament\Resources\XotBaseResource`
- `Filament\Resources\Pages\CreateRecord` → `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- `Filament\Resources\Pages\EditRecord` → `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord`
- `Filament\Resources\Pages\ListRecords` → `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
- `Filament\Widgets\Widget` → `Modules\Xot\Filament\Widgets\XotBaseWidget`
- `Filament\Widgets\TableWidget` → `Modules\Xot\Filament\Widgets\XotBaseTableWidget`
- `Filament\Widgets\ChartWidget` → `Modules\Xot\Filament\Widgets\XotBaseChartWidget`
- `Filament\Widgets\StatsOverviewWidget` → `Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget`
- `Illuminate\Support\ServiceProvider` → `Modules\Xot\Providers\XotBaseServiceProvider`

### Metodi Resource Filament
- Chi estende `XotBaseResource` **NON deve avere** `getTableColumns()`
- `getTableActions()` e `getTableBulkActions()` devono restituire `array<string, mixed>`
- Se solo azioni standard → **rimuovile completamente**
- Se azioni personalizzate → includi `...parent::getTableActions()`

### Metodi Page Filament
Chi estende `XotBasePage` **NON deve avere**:
- `protected static ?string $navigationIcon`
- `protected static ?string $title`
- `protected static ?string $navigationLabel`

### Gestione Traduzioni
- **NON usare MAI**: `->label()`, `->placeholder()`, `->tooltip()`
- Tutte le etichette tramite file di traduzione nei moduli
- Usa `LangServiceProvider` per gestione automatica
- Struttura chiavi: `modulo::risorsa.fields.campo.label`

### Type Safety
- **Type hints rigorosi** per tutti i parametri e return types
- Gestisci **nullable values** (`?string`, `?int`)
- Evita `mixed` types salvo necessità documentate
- Array con **strutture definite** (`array<string, mixed>`)
- Usa `declare(strict_types=1);` in tutti i file PHP
- Usa **Webmozart Assert** per validazioni robuste
- Usa **TheCodingMachine Safe** per funzioni PHP sicure

---

## 🔧 Patterns di Correzione

### 1. Carbon createFromFormat (Carbon|null vs Carbon|false)
```php
// ✅ CORRETTO - L'estensione Carbon restituisce Carbon|null
$targetMonth = Carbon::createFromFormat('Y-m', $month);
if ($targetMonth === null) {
    $targetMonth = now()->startOfMonth();
} else {
    $targetMonth = $targetMonth->startOfMonth();
}
```

### 2. Type Narrowing con Assert
```php
use Webmozart\Assert\Assert;

// ✅ CORRETTO
if (is_array($data)) {
    Assert::isArray($data);
    $value = $data['key'] ?? null;
}
```

### 3. Cast Actions Centralizzate
```php
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// ✅ CORRETTO
$data = SafeArrayCastAction::cast($input);
$title = SafeStringCastAction::cast($mod->title);
```

### 4. Array Associativi Filament
```php
// ❌ ERRORE - array<int, Action>
public function getTableActions(): array
{
    return [EditAction::make(), DeleteAction::make()];
}

// ✅ CORRETTO - array<string, mixed>
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

### 5. Property Access su Mixed (Eloquent)
```php
// ❌ ERRORE - property_exists() NON funziona con magic attributes
if (property_exists($model, 'attribute')) {
    $value = $model->attribute;
}

// ✅ CORRETTO - usa isset() per magic attributes
if (isset($model->attribute)) {
    $value = $model->attribute;
}

// ✅ ANCHE CORRETTO - validazione multipla
if (is_object($model) && isset($model->attribute)) {
    $value = $model->attribute;
}
```

### 6. Casts Completi per Properties
```php
// ✅ CORRETTO - Tutte le properties usate DEVONO essere nei casts()
protected function casts(): array
{
    return [
        'auto_cleanup_num' => 'integer',
        'auto_cleanup_type' => 'string',
        'notification_email_address' => 'string',
    ];
}
```

### 7. HasXotFactory NON è Generico
```php
// ❌ ERRORE - HasXotFactory NON accetta generics
/** @use HasXotFactory<TFactory> */
use HasXotFactory;

// ✅ CORRETTO - Rimuovi generics
use HasXotFactory;
```

### 8. Notification via() Return Type
```php
// ❌ ERRORE - list<string>
public function via($notifiable): array
{
    return ['mail', 'nexmo'];
}

// ✅ CORRETTO - array<string, mixed>
/**
 * @return array<string, mixed>
 */
public function via($notifiable): array
{
    return [
        'mail' => 'mail',
        'nexmo' => 'nexmo',
    ];
}
```

### 9. Relazioni Eloquent con Generics
```php
// ✅ CORRETTO - Generics solo in PHPDoc
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @return HasMany<Post>
 */
public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}
```

### 10. Factory Typing
```php
// ✅ CORRETTO
/**
 * @var \Illuminate\Database\Eloquent\Factories\Factory<Model> $factory
 */
$factory = Model::factory();
Assert::object($factory);
Assert::methodExists($factory, 'create');
$result = $factory->create($data);
```

### 11. Builder Type Hints con PHPDoc
```php
// ✅ CORRETTO - Type hint per query builder
/**
 * @param  \Illuminate\Database\Eloquent\Builder<\Modules\Limesurvey\Models\SurveyResponse>  $query
 */
private function applyFilters(\Illuminate\Database\Eloquent\Builder $query): void
{
    $query->where('status', 'active');
}

// ✅ ANCHE CORRETTO - PHPDoc per variabile
/** @var \Illuminate\Database\Eloquent\Builder<\Modules\User\Models\User> $query */
$query = User::query()->where('active', true);
```

---

## 🎯 Complexity Reduction Patterns

### Extract Method Pattern

**Problema**: Funzione troppo lunga (> 20 righe) o complessa (cyclomatic complexity > 10)

**Soluzione**: Estrarre logica in metodi privati focalizzati

#### Esempio Reale: QuestionChartStatsOverviewWidget

```php
// ❌ PRIMA - 104 righe, complexity 15
protected function getStats(): array
{
    if ($this->record === null) {
        return [
<<<<<<< .merge_file_1HcUuK
            Stat::make(__('healthcare_app::question_chart_stats_overview.stats.total_responses.label'), '0')
                ->description(__('healthcare_app::question_chart_stats_overview.messages.no_data_available'))
=======
            Stat::make(__('ptvx::question_chart_stats_overview.stats.total_responses.label'), '0')
                ->description(__('ptvx::question_chart_stats_overview.messages.no_data_available'))
>>>>>>> .merge_file_UmlB0w
                ->color('gray'),
        ];
    }

    $record = $this->record;
    $filters = $this->pageFilters ?? [];

    // ... 90 righe di logica complessa ...
}

// ✅ DOPO - 5 righe, complexity 2
protected function getStats(): array
{
    if (! $this->isRecordValid()) {
        return $this->getEmptyStats();
    }

    /** @var object $record */
    $record = $this->record;

    $qid = $this->extractQuestionId($record);
    if ($qid === null) {
        return $this->getInvalidQuestionStats();
    }

    $stats = $this->fetchStatsFromDatabase($record, $qid);

    if ($stats === null) {
        return $this->getEmptyStats();
    }

    return $this->buildStatsArray($stats);
}

// Metodi estratti (ognuno < 25 righe, complexity < 3)
private function isRecordValid(): bool
{
    if ($this->record === null) {
        return false;
    }

    return isset($this->record->surveyId, $this->record->field_name);
}

private function extractQuestionId(object $record): mixed
{
    return $record->parent_qid ?? $record->question ?? null;
}

private function fetchStatsFromDatabase(object $record, mixed $qid): ?object
{
    if (! isset($record->field_name, $record->surveyId)) {
        return null;
    }

    $fieldName = (string) $record->field_name;
    $filters = $this->pageFilters ?? [];

    /** @phpstan-ignore-next-line */
    $baseQuery = SurveyResponse::getResponsesForSurvey($record->surveyId);

    /** @var \Illuminate\Database\Eloquent\Builder<\Modules\Limesurvey\Models\SurveyResponse> $query */
    $query = $baseQuery
        /* @phpstan-ignore-next-line */
        ->withAnswersLabel($qid, $fieldName)
        ->select($this->getStatsColumns($fieldName))
        ->whereNotNull('submitdate');

    $this->applyFiltersToQuery($query, $filters, $record);

    /** @phpstan-ignore-next-line */
    return $query->first();
}

private function buildStatsArray(object $stats): array
{
    /* @phpstan-ignore-next-line */
    $totalResponses = (int) ($stats->total_responses ?? 0);
    /* @phpstan-ignore-next-line */
    $completedResponses = (int) ($stats->completed_responses ?? 0);
    /* @phpstan-ignore-next-line */
    $uniqueResponses = (int) ($stats->unique_responses ?? 0);
    $completionRate = $this->calculateCompletionRate($totalResponses, $completedResponses);

    return [
        $this->createTotalResponsesStat($totalResponses),
        $this->createCompletedResponsesStat($completedResponses),
        $this->createCompletionRateStat($completionRate),
        $this->createUniqueResponsesStat($uniqueResponses),
    ];
}
```

**Risultato**: Complexity 15 → 2 (-87%), 104 righe → 5 righe (-95%)

### Guard Clauses Pattern

**Problema**: Nesting profondo, difficile da seguire

**Soluzione**: Early returns per validazione

```php
// ❌ PRIMA
public function process($data)
{
    if ($data !== null) {
        if (is_array($data)) {
            if (isset($data['key'])) {
                $value = $data['key'];
                if ($value !== '') {
                    return $this->handle($value);
                }
            }
        }
    }
    return null;
}

// ✅ DOPO
public function process($data)
{
    if ($data === null) {
        return null;
    }

    if (! is_array($data)) {
        return null;
    }

    if (! isset($data['key'])) {
        return null;
    }

    $value = $data['key'];
    if ($value === '') {
        return null;
    }

    return $this->handle($value);
}
```

### Template Method Pattern

**Problema**: Duplicazione logica simile in metodi diversi

**Soluzione**: Metodo template che chiama hook methods

```php
// ❌ PRIMA - Duplicazione
public function mount(): void
{
    if (! isset($this->stats['tot'])) {
        $this->tot = 0.0;
        return;
    }
    $stat = $this->stats['tot'];
    if (! is_array($stat) || ! isset($stat[0])) {
        $this->tot = 0.0;
        return;
    }
    $this->tot = (float) $stat[0];
}

// ✅ DOPO - Template method
public function mount(): void
{
    $this->tot = $this->extractStat('tot');
    $this->sms = $this->extractStat('sms');
    $this->emails = $this->extractStat('emails');
}

private function extractStat(string $key): float
{
    if (! isset($this->stats[$key])) {
        return 0.0;
    }
    $stat = $this->stats[$key];
    if (! is_array($stat) || ! isset($stat[0])) {
        return 0.0;
    }
    return (float) $stat[0];
}
```

### Strategy Pattern per Fallback

**Problema**: Logica di fallback duplicata

**Soluzione**: Metodo strategia condiviso

```php
// ✅ CORRETTO
public function getFormSchema(): array
{
    $action = $this->getActionName(__FUNCTION__);

    if (! $this->isActionValid($action)) {
        return $this->getFallbackFormSchema();
    }

    return $this->executeAction($action);
}

private function getFallbackFormSchema(): array
{
    return [
        TextInput::make('title'),
        Grid::make()
            ->schema([
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
            ]),
    ];
}
```

### Single Responsibility Principle

**Ogni metodo deve fare UNA sola cosa**

```php
// ❌ SBAGLIATO - Fa troppe cose
public function processUser($data)
{
    // Validazione
    if (! isset($data['email'])) {
        throw new Exception('Email required');
    }

    // Business logic
    $user = User::create($data);

    // Notifiche
    Mail::to($user)->send(new Welcome($user));

    // Logging
    Log::info('User created', ['id' => $user->id]);

    return $user;
}

// ✅ CORRETTO - Responsabilità separate
public function processUser(array $data): User
{
    $this->validateUserData($data);
    $user = $this->createUser($data);
    $this->notifyUser($user);
    $this->logUserCreation($user);

    return $user;
}

private function validateUserData(array $data): void
{
    if (! isset($data['email'])) {
        throw new ValidationException('Email required');
    }
}

private function createUser(array $data): User
{
    return User::create($data);
}

private function notifyUser(User $user): void
{
    Mail::to($user)->send(new Welcome($user));
}

private function logUserCreation(User $user): void
{
    Log::info('User created', ['id' => $user->id]);
}
```

---

## 🎨 Widget Best Practices

### Estensione Base Widgets

```php
// ✅ CORRETTO - Sempre estendere XotBase widgets
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class MyTableWidget extends XotBaseTableWidget
{
    // Auto-managed properties from parent
}

// Altri base widgets disponibili:
// - XotBaseWidget (generic widget)
// - XotBaseTableWidget (table display)
// - XotBaseChartWidget (charts)
// - XotBaseStatsOverviewWidget (stats cards)
```

### Widget con Filtri

```php
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Livewire\Attributes\On;

class MyWidget extends XotBaseTableWidget
{
    use InteractsWithPageFilters;

    /**
     * Ascolta evento di aggiornamento filtri
     *
     * @param  array<string, mixed>  $_filters  Parametro non usato direttamente
     */
    #[On('filterUpdate')]
    public function updateFilters(array $_filters): void
    {
        // Filters are automatically handled by InteractsWithPageFilters
        // Force table refresh when filters change
        $this->resetTable();
    }

    protected function getTableQuery(): Builder
    {
        /** @var array<string, mixed> $filters */
        $filters = $this->pageFilters ?? [];

        $query = MyModel::query();

        $this->applyFilters($query, $filters);

        return $query;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<MyModel>  $query
     * @param  array<string, mixed>  $filters
     */
    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, array $filters): void
    {
        if (isset($filters['date_from']) && $filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
    }
}
```

### Widget con Record Key Univoca

```php
/**
 * Restituisce una chiave univoca per ogni record.
 *
 * IMPORTANTE: Non usare mai chiavi hardcoded, altrimenti Livewire
 * pensa che tutti i record siano lo stesso e mostra duplicati.
 */
public function getTableRecordKey(\Illuminate\Database\Eloquent\Model|array $record): string
{
    if (\is_array($record)) {
        return (string) ($record['id'] ?? $record['_id'] ?? '');
    }

    return (string) ($record->id ?? $record->_id ?? '');
}
```

### Widget Stats con Complessità Ridotta

```php
// ✅ PATTERN - Factory methods per stats
private function createTotalResponsesStat(int $count): Stat
{
    return Stat::make(
<<<<<<< .merge_file_1HcUuK
        __('healthcare_app::question_chart_stats_overview.stats.total_responses.label'),
        number_format((float) $count)
    )
        ->description(__('healthcare_app::question_chart_stats_overview.stats.total_responses.description'))
=======
        __('ptvx::question_chart_stats_overview.stats.total_responses.label'),
        number_format((float) $count)
    )
        ->description(__('ptvx::question_chart_stats_overview.stats.total_responses.description'))
>>>>>>> .merge_file_UmlB0w
        ->color($count > 0 ? 'success' : 'gray')
        ->icon('heroicon-o-document-text');
}

private function createCompletionRateStat(float $rate): Stat
{
    return Stat::make(
<<<<<<< .merge_file_1HcUuK
        __('healthcare_app::question_chart_stats_overview.stats.completion_rate.label'),
        $rate.'%'
    )
        ->description(__('healthcare_app::question_chart_stats_overview.stats.completion_rate.description'))
=======
        __('ptvx::question_chart_stats_overview.stats.completion_rate.label'),
        $rate.'%'
    )
        ->description(__('ptvx::question_chart_stats_overview.stats.completion_rate.description'))
>>>>>>> .merge_file_UmlB0w
        ->color($rate >= 75 ? 'success' : ($rate >= 50 ? 'warning' : 'danger'))
        ->icon('heroicon-o-chart-bar');
}
```

---

## 🛠️ Code Quality Tools

### Laravel Pint (Code Formatting)

```bash
# Format tutti i file modificati (git)
./vendor/bin/pint --dirty

# Format file specifico
./vendor/bin/pint path/to/File.php

# Test senza modificare
./vendor/bin/pint --test

# Format con preset specifico
./vendor/bin/pint --preset laravel
```

### PHPMD (Mess Detector)

```bash
# Analisi completa
./vendor/bin/phpmd Modules/{Module} text cleancode,codesize,controversial,design,naming,unusedcode

# Solo complexity
./vendor/bin/phpmd Modules/{Module} text codesize

# Output su file
./vendor/bin/phpmd Modules/{Module} text codesize > /tmp/phpmd-report.txt
```

**Thresholds PHPMD**:
- Cyclomatic Complexity: < 10
- NPath Complexity: < 200
- Function Length: < 20 righe (raccomandato), max 50

### PHP Insights (Architettura + Quality)

```bash
# Analisi modulo
./vendor/bin/phpinsights analyse Modules/{Module} --format=table

# Analisi con min-quality
./vendor/bin/phpinsights analyse Modules/{Module} --min-quality=80

# Fix automatico dove possibile
./vendor/bin/phpinsights analyse Modules/{Module} --fix
```

**PHP Insights Scores**:
- Code: > 90%
- Complexity: > 70% (target: 80%)
- Architecture: > 90%
- Style: > 95%

### Workflow Combinato

```bash
# 1. Fix code style
./vendor/bin/pint --dirty

# 2. Analizza PHPStan
./vendor/bin/phpstan analyse Modules/{Module} --level=10

# 3. Controlla complexity
./vendor/bin/phpmd Modules/{Module} text codesize

# 4. Quality overview
./vendor/bin/phpinsights analyse Modules/{Module}
```

---

## 💬 Commenti e TODO

### Regole per Commenti

```php
// ❌ SBAGLIATO - Commento ovvio
// Get the user
$user = User::find($id);

// ❌ SBAGLIATO - Commento obsoleto
// TODO: Fix this later (scritto 2 anni fa)

// ❌ SBAGLIATO - Codice commentato
/*
protected function oldMethod()
{
    return 'old logic';
}
*/

// ✅ CORRETTO - Spiega il "perché", non il "cosa"
// PHPStan L10: Type narrowing required for magic attributes
if (is_object($model) && isset($model->attribute)) {
    $value = $model->attribute;
}

// ✅ CORRETTO - Documenta decisione architetturale
/**
 * Usa isset() invece di property_exists() perché Eloquent usa magic attributes
 * che non sono rilevati da property_exists()
 */
private function hasAttribute(object $model, string $attribute): bool
{
    return isset($model->{$attribute});
}

// ✅ CORRETTO - Placeholder per implementazione futura
public function onDateSelect(string $_start, ?string $_end): void
{
    // Placeholder for future date selection implementation
}
```

### Gestione TODO

**REGOLA ASSOLUTA**: NON lasciare TODO nel codice production

```php
// ❌ SBAGLIATO
public function process()
{
    // TODO: Implement validation
    return $this->data;
}

// ✅ OPZIONE 1 - Implementa subito
public function process()
{
    $this->validateData();
    return $this->data;
}

// ✅ OPZIONE 2 - Placeholder professionale
public function process()
{
    // Validation will be implemented in next iteration (TICKET-123)
    return $this->data;
}

// ✅ OPZIONE 3 - Rimuovi metodo se non implementato
// (Se il metodo non è usato, eliminalo completamente)
```

### Codice Commentato

**REGOLA**: ZERO codice commentato nel repository

```php
// ❌ SBAGLIATO
class MyWidget extends Widget
{
    /*
    protected function modalActions(): array
    {
        return [
            \Saade\FilamentFullCalendar\Actions\EditAction::make(),
            \Saade\FilamentFullCalendar\Actions\DeleteAction::make(),
        ];
    }
    */
}

// ✅ CORRETTO - Rimuovi completamente
class MyWidget extends Widget
{
    // Se il metodo sarà necessario, verrà ripristinato da git history
}
```

### Import Commentati

```php
// ❌ SBAGLIATO
// use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Widgets\Widget;

// ✅ CORRETTO - Rimuovi import non usato
use Filament\Widgets\Widget;
```

---

## 📚 Risorse Filament v4

Studia costantemente:
- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [What's New in Filament v4](https://filamentphp.com/content/leandrocfe-whats-new-in-filament-v4)
- [Filament v4 Forms Overview](https://filamentphp.com/docs/4.x/forms/overview)
- [Filament v4 Tables](https://filamentphp.com/docs/4.x/tables/overview)
- [Filament v4 Widgets](https://filamentphp.com/docs/4.x/widgets/overview)

---

## ✅ Checklist Pre-Correzione

Prima di correggere un errore:
- [ ] Ho letto la documentazione del modulo in `docs/`?
- [ ] Ho compreso la causa radice dell'errore?
- [ ] Ho valutato l'impatto architetturale?
- [ ] La soluzione rispetta i pattern esistenti?
- [ ] La soluzione usa classi XotBase quando necessario?
- [ ] La soluzione usa Cast Actions centralizzate?
- [ ] Ho verificato la complexity del metodo (< 10)?
- [ ] Ho verificato la lunghezza del metodo (< 20 righe)?

---

## ✅ Checklist Post-Correzione

Dopo aver corretto un batch:
- [ ] PHPStan Level 10 non segnala nuovi errori?
- [ ] Il numero totale di errori è diminuito?
- [ ] Pint ha formattato correttamente il codice?
- [ ] PHPMD non segnala complexity > 10?
- [ ] PHP Insights score è migliorato?
- [ ] L'autoload funziona correttamente?
- [ ] L'applicazione si avvia senza errori?
- [ ] La documentazione è aggiornata?
- [ ] TODO e codice commentato rimossi?

---

## 🎯 Strategia Ottimale

1. **Analisi per Modulo**: Eseguire PHPStan su singolo modulo
2. **Pattern Recognition**: Identificare errori ricorrenti
3. **Batch Fixes**: Correggere pattern simili insieme
4. **Complexity Check**: Verificare e ridurre complexity dopo ogni batch
5. **Documentazione Parallela**: Aggiornare docs durante correzioni
6. **Verifica Incrementale**: Riesegui tutti i tool dopo ogni batch

**Quick Wins**: Inizia da moduli con meno errori per massimizzare impatto.

---

## 🔍 Errori Più Comuni

### 1. Property Access su Mixed
```php
// ERRORE: Cannot access property $state on mixed
$record->state->transitionTo($newState);

// SOLUZIONE
if (method_exists($record, 'getState')) {
    $state = $record->getState();
    Assert::notNull($state);
    if (method_exists($state, 'transitionTo')) {
        $state->transitionTo($newState);
    }
}
```

### 2. Array Access su Mixed
```php
// ERRORE: Cannot access offset on mixed
$value = $data['key'];

// SOLUZIONE
$data = SafeArrayCastAction::cast($data);
$value = $data['key'] ?? null;
```

### 3. Return Type Mismatch
```php
// ERRORE: Method should return array but returns mixed
public function getData(): array {
    return $this->data;
}

// SOLUZIONE
public function getData(): array {
    Assert::isArray($this->data);
    return $this->data;
}
```

---

## 📖 Documentazione

### Struttura
- **Modulo**: `Modules/{ModuleName}/docs/` - Documentazione tecnica approfondita
- **Root**: `docs/` - Indici e collegamenti bidirezionali
- **Tema**: `Themes/{ThemeName}/docs/` - Documentazione tema

### Aggiornamento
- **Prima di correggere**: Studia docs del modulo
- **Dopo correzione**: Aggiorna docs con modifiche e pattern
- **Link relativi**: Mai path assoluti nei file .md
- **Naming**: Minuscolo, no date, solo README.md maiuscolo

---

## 🚫 Anti-Pattern da Evitare

### ❌ Ignorare Errori
```php
// SBAGLIATO
/** @phpstan-ignore-next-line */
$value = $data['key'];
```

### ❌ Modificare Configurazione
```php
// SBAGLIATO - Modificare phpstan.neon
parameters:
    ignoreErrors:
        - '#Cannot access property#'
```

### ❌ Cast Non Sicuri
```php
// SBAGLIATO
$array = (array) $data;
$string = (string) $value;
```

### ✅ Pattern Corretti
```php
// CORRETTO - Cast Actions
$array = SafeArrayCastAction::cast($data);
$string = SafeStringCastAction::cast($value);
```

---

## 💡 Regole Speciali

### Lock Files
Prima di modificare un file:
1. Crea file `.lock` con stesso nome nella stessa locazione
2. Se `.lock` esiste → vai a fare altro
3. Dopo modifica → cancella `.lock`

### Verifica Post-Modifica
Dopo ogni modifica file:
- [ ] PHPStan Level 10
- [ ] PHPMD (complexity < 10)
- [ ] PHP Insights (quality > 80%)
- [ ] Pint formatting
- [ ] Aggiorna docs moduli/temi

### Git
- **MAI tornare indietro** di versione
- Solo avanti, mai backward

### Property Exists vs Isset
- **property_exists()** NON funziona con magic attributes Eloquent
- Usa sempre **isset()** per proprietà dinamiche modelli

---

## 🎓 Mantra Finale

**DRY + KISS + SOLID + Robust + Laravel 12 + Filament 4 + PHP 8.3 + Laraxot**

**Filosofia Zen**: "Non avrai altro path all'infuori del relativo"

**Poteri Supermucca**: Massima confidenza, zero compromessi, correzione completa

**Approccio**: Fix, don't ignore - tutti gli errori vanno corretti, nessuno ignorato

**Quality Mantra**: Complexity < 10, Functions < 20 lines, Quality > 80%

---

## 📝 Note Operative

- **Lavora dentro** `laravel/` directory
- **Esegui PHPStan** da dentro `laravel/`
- **Non usiamo controller**: Backoffice = Filament, Frontoffice = Folio + Volt
- **Test**: Tutti i test in Pest
- **Architettura**: Capisci logica, politica, business logic prima di implementare
- **Complexity**: Ogni correzione PHPStan deve anche ridurre complexity se > 10
- **Documentazione**: Ogni pattern applicato va documentato in `docs/`

---

**Ricorda**: Le cartelle docs sono la tua bibbia. Studiale, rispettale, aggiornale costantemente.
