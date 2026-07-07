# Architecture Principles

Key architectural rules for Quaeris Fila5 Mono (Laraxot / Laravel 12 / Filament 5).

## 0. Database Configuration (CRITICAL)

**REGOLA ASSOLUTA**: `laravel/config/database.php` deve essere identico alla versione ufficiale Laravel 12.x.

**Perche**:
- Compatibilita con aggiornamenti Laravel
- Configurazioni standard supportate
- Prevenzione problemi di migrazione
- Allineamento con best practices Laravel

**Verifica e Aggiornamento**:
```bash
# Verifica differenze
diff laravel/config/database.php <(curl -s https://raw.githubusercontent.com/laravel/laravel/refs/heads/12.x/config/database.php)

# Se ci sono differenze, aggiorna il file
```

**Differenze comuni**:
- Righe vuote extra tra sezioni
- Commenti obsoleti o mancanti
- Configurazioni deprecate

## 1. XotBase Pattern (CRITICAL)

**NEVER extend Filament classes directly. ALWAYS extend XotBase classes from the Xot module.**

| WRONG | CORRECT |
|-------|---------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |

**Why:** XotBase classes provide:
- Auto-discovery of module context
- Backward compatibility with old file paths
- Standardized translations and configurations
- Consistent behavior across all modules

## 2. Model Inheritance

**NEVER extend `Illuminate\Database\Eloquent\Model` directly.**

All models must extend one of these base classes:

```php
// Regular models
namespace Modules\{ModuleName}\Models;
class MyModel extends BaseModel { }

// Pivot tables (many-to-many)
class MyPivot extends BasePivot { }

// Polymorphic pivots
class MyMorphPivot extends BaseMorphPivot { }
```

**Connection auto-discovery:** The connection name is automatically extracted from the namespace (e.g., `Modules\User\Models\*` → `'user'`). Only set `$connection` manually if you need a different one.

## 3. Chart Assets Centralization

**CHART ASSETS MUST BE MANAGED CENTRALLY IN THE CHART MODULE - NEVER DUPLICATE IN OTHER MODULES.**

```php
// CORRECT: In Modules/Chart/app/Providers/Filament/AdminPanelProvider.php
FilamentAsset::register([
    Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
]);

// WRONG: In other modules like Quaeris, User, etc.
FilamentAsset::register([
    Js::make('chart-js-plugins', Vite::asset('Resources/assets/js/filament-chart-js-plugins.js', 'assets/quaeris'))->module(),
]);
```

**Why:** This follows DRY and KISS principles:
- **Single Source of Truth**: Chart assets registered in one place only
- **Maintainability**: Updates needed in only one location
- **Consistency**: All modules use the same chart assets
- **No Conflicts**: Prevents duplicate asset loading

## 4. Service Providers

All module ServiceProviders MUST extend XotBase providers:

```php
// CORRECT
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'ModuleName';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    protected string $moduleNamespace = 'Modules\\ModuleName\\Http\\Controllers';
}
```

## 5. Magic Properties Warning

**CRITICAL:** Laravel models use magic properties via `__get()`. **NEVER use `property_exists()` to check model attributes.**

```php
// WRONG
if (property_exists($model, 'email')) { }

// CORRECT
if (isset($model->email)) { }
if ($model->getAttribute('email') !== null) { }
```

## 6. Actions Over Services (CRITICAL)

**NEVER create Service classes for business logic. ALWAYS use Spatie QueueableAction.**

Package: `spatie/laravel-queueable-action` (v2.17.0 installato)
Ref: `.claude/docs/spatie-queueable-action.md`

```php
// WRONG - Service class FORBIDDEN
namespace Modules\Quaeris\Services;
class ReportService
{
    public function generate(SurveyPdf $pdf): void { ... }
}

// CORRECT - QueueableAction obbligatorio
namespace Modules\Quaeris\Actions;
use Spatie\QueueableAction\QueueableAction;

class GenerateReportAction
{
    use QueueableAction;

    public function execute(SurveyPdf $pdf): void { ... }
}

// Usage sincrona
app(GenerateReportAction::class)->execute($pdf);

// Usage asincrona (stesso codice, nessun Job separato)
app(GenerateReportAction::class)->onQueue('reports')->execute($pdf);
```

**Regole:**
- Business logic → Action class (`Modules/{Module}/Actions/`)
- Nome: `{Verb}{Noun}Action` (es. `GenerateReportAction`, `SendNotificationAction`)
- Entrypoint standard: `execute()` (non `__invoke()`)
- Constructor injection ammessa per collaboratori stabili
- Composizione: chiamare altre action via `app()` o injection
- MAI creare un Job separato: usare `onQueue()` sull'action esistente
- I ServiceProvider (`XotBaseServiceProvider`, `AdminPanelProvider`) NON sono "Service classes" — sono infrastruttura Laravel, si mantengono come sono

**Servizi legacy esistenti** (da non rimuovere, ma non creare di nuovi):
- `Modules/Xot/app/Services/` — infrastruttura framework, non business logic
- `Modules/Job/app/Services/ScheduleService.php` — wrapper scheduling

## 7. Type Safety Rules

**CRITICAL Type Safety Principles:**

1. **Return Types Must Use Array Keys**: Methods like `getTableColumns()`, `getFormSchema()`, `getTableBulkActions()`, `getTableActions()`, `getTableFilters()`, `getHeaderActions()` must return arrays with string/int keys (never plain numeric arrays when keys matter).

2. **Avoid Mixed Type**: Use `mixed` only as absolute last resort. Always prefer:
   - Union types: `string|int|null`
   - Specific types with type narrowing
   - Generic types in PHPDoc: `array<string, string>`

3. **Never Use property_exists() with Models**: Model attributes are magic properties accessed via `__get()` - they won't show up with `property_exists()`.

```php
// CORRECT: Array with string keys
public function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name'),
        'email' => TextInput::make('email'),
    ];
}

// WRONG: Using mixed unnecessarily
public function getData(): mixed { }

// CORRECT: Specific union type
public function getData(): string|int|null { }

// WRONG: property_exists on model
if (property_exists($user, 'email')) { }

// CORRECT: isset for magic properties
if (isset($user->email)) { }
```
