# Filament Patterns

## Module Development
- All ServiceProviders MUST extend `XotBaseServiceProvider`
- All Resources MUST extend `XotBaseResource`
- Use `getFormSchema(): array` not `form(Form $form): Form`
- Never override `navigationIcon` in XotBaseResource children

## Composer autoload-dev per moduli (OBBLIGATORIO)

Ogni modulo deve avere nel proprio `composer.json`, **subito dopo il nodo `autoload`**, il nodo `autoload-dev`:

```json
"autoload-dev": {
    "psr-4": {
        "Modules\\<Modulo>\\Tests\\": "tests/"
    }
},
```

**Perché**: le classi di test in `Modules/<Modulo>/tests/` devono essere autoloadabili con namespace `Modules\<Modulo>\Tests\*`.

## Filament 5.x Patterns

### ✅ CORRECT - Array schema con chiavi stringa
```php
protected function getFormSchema(): array
{
    return [
        'name' => Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
    ];
}
```

### ❌ WRONG - Builder pattern
```php
protected function form(Form $form): Form
{
    return $form->schema([
        // components here
    ]);
}
```

### ❌ WRONG - array_values() rompe il return type
```php
protected function getHeaderActions(): array
{
    return array_values($actions);  // SBAGLIATO! Perde le chiavi stringa
}
```

### ✅ CORRECT - Mantieni chiavi stringa
```php
protected function getHeaderActions(): array
{
    return $actions;  // CORRETTO!
}
```

## HasXotTable policy: `table()` is FINAL

In `Modules\\Xot\\Filament\\Traits\\HasXotTable`, the builder method `table(Table $table): Table` is **final**.

- Do **not** override `table()` in pages/widgets/relation managers.
- **ManageRelatedRecords** (es. ManagePdfStyle, ManageCharts): NON usare `table()` che delega a `Resource::table()`. Override `getTableColumns()` e restituisci le colonne (es. da `Resource::getTableColumnsSchema()`).
- Customize the table through the supported hooks:
  - `getTableColumns()`
  - `getTableHeaderActions()`
  - `getTableActions()`
  - `getTableBulkActions()`
- `getTableFilters()` and other optional hooks provided by Xot/Filament

### Troubleshooting: `Table ... must have a [query()], [relationship()], or [records()]`

**Sintomo**
- In una pagina che estende `XotBaseListRecords` appare:
  - `LogicException: Table [...] must have a [query()], [relationship()], or [records()].`

**Causa tipica**
- Nel trait `HasXotTable` viene importato/usato `Filament\Tables\Concerns\InteractsWithTable`.
- Questo puo interferire con il flusso standard di Filament `ListRecords` (che imposta gia la query in `makeTable()`).

**Fix**
- In `Modules/Xot/app/Filament/Traits/HasXotTable.php` NON usare `InteractsWithTable`.
- Lasciare a `ListRecords` la responsabilita della sorgente dati tabella.

**Checklist veloce**
- La pagina list estende `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`.
- Nessun override anomalo di `table()` nella list page.
- `HasXotTable` non re-importa trait Filament che ridefiniscono il lifecycle della tabella.

## getTableColumns() must return string keys (CRITICAL)

- `getTableColumns()` **DEVE SEMPRE** restituire un array associativo: `array<string, Column>`.
- Le chiavi **devono essere stringhe**, mai indici numerici.
- Keys must be stable strings (e.g., column/field name: `'name'`, `'email'`).
- **MAI** usare `array_values()` — distrugge le chiavi.
- Vedi `.cursor/rules/gettablecolumns-string-keys.mdc`.

```php
// ✅ CORRETTO
return ['name' => TextColumn::make('name'), 'email' => TextColumn::make('email')];

// ❌ ERRATO
return [TextColumn::make('name'), TextColumn::make('email')];
```

## Livewire/Filament Widget Error Handling

### "Cannot call constructor" - CRITICAL FIX
When encountering "Cannot call constructor" in Filament widgets:

1. **Check getOptions() return type**: Filament ChartWidget accetta `array | RawJs | null`. Quando le opzioni passano via `@js()` al chart, **RawJs è obbligatorio** se contengono formatter/callback.
2. **No custom constructors**: Widget classes cannot have custom `__construct()` methods
3. **Livewire factory pattern**: Widgets are instantiated via `new $class()` in Livewire Factory
4. **RawJs**: può essere il tipo di ritorno di getOptions() o usato nei formatter

### Debugging Workflow
```bash
# 1. Check widget structure
grep -n "getOptions\|__construct" Modules/Quaeris/app/Filament/Widgets/Simple05ChartWidget.php

# 2. Verify PHPStan compliance
cd laravel && vendor/bin/phpstan analyse Modules/Quaeris/app/Filament/Widgets/Simple05ChartWidget.php

# 3. Check for syntax errors in related services
cd laravel && php -l Modules/Quaeris/app/Services/ChartService.php
```

## Chart Widget Pattern (CRITICAL)

### Constructor & Method Requirements
- **NO CUSTOM CONSTRUCTORS** in widgets extending XotBaseChartWidget
- **getOptions() può restituire array O RawJs**: Filament accetta entrambi
- **Follow XotBaseChartWidget inheritance pattern** exactly

### ✅ CORRECT Pattern
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'datalabels' => [
                'labels' => [
                    'average' => [
                        'formatter' => RawJs::make(<<<'JS'
                            function(v, ctx) {
                                var value = Number(v) || 0;
                                return value > 0 ? "€" + value.toLocaleString("it-IT") : '';
                            }
                        JS),
                    ],
                ],
            ],
        ],
    ];
}
```

### ❌ FORBIDDEN Patterns
```php
// ❌ WRONG - Constructor in widget
public function __construct() {
    parent::__construct(); // Don't do this
}

// ❌ WRONG - RawJs for entire options
return RawJs::make(<<<'JS'
{ plugins: {...} }
JS);
```

## JpGraph Integration Rules

### JpGraph Service Pattern Requirements
- **All JpGraph services MUST extend base service pattern** with proper namespace usage
- **Use Amenadiel\JpGraph namespace** for all JpGraph classes
- **Strict typing required** for all method signatures
- **Exception handling** MUST use custom JpGraphException classes
- **Cache management** MUST implement proper file cleanup

### JpGraph + Filament Widget Integration
```php
// ✅ CORRECT - Hybrid widget pattern
final class HybridChartWidget extends Widget
{
    private ?JpGraphService $chartService = null;
    
    public function getChartData(): array
    {
        $this->chartService ??= new JpGraphService();
        
        return [
            'static_url' => $this->generateStaticChart(),
            'interactive_data' => $this->getInteractiveData()
        ];
    }
}
```

### JpGraph vs Chart.js Decision Matrix
- **JpGraph**: PDF reports, email attachments, batch processing, advanced charts
- **Chart.js**: Interactive dashboards, real-time updates, mobile responsive
- **Hybrid**: Progressive enhancement, multiple outputs, accessibility compliance
