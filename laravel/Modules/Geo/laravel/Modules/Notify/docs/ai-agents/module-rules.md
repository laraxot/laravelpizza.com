# Regole Specifiche del Progetto

Vedi [index](index.md) per navigazione completa.

## Module Development
- All ServiceProviders MUST extend `XotBaseServiceProvider`
- All Resources MUST extend `XotBaseResource`
- Use `getFormSchema(): array` not `form(Form $form): Form`
- Never override `navigationIcon` in XotBaseResource children

## Models: factories and traits

- Do not add `use HasFactory;` in concrete models that extend the module `BaseModel` chain.
- `XotBaseModel` already uses `HasXotFactory`, so adding `HasFactory` in children (e.g., `Team`) is redundant.

## Composer autoload-dev per moduli (OBBLIGATORIO)

Ogni modulo deve avere nel proprio `composer.json`, **subito dopo il nodo `autoload`**, il nodo `autoload-dev`:

```json
"autoload-dev": {
    "psr-4": {
        "Modules\\<Modulo>\\Tests\\": "tests/"
    }
},
```

**Perché**: le classi di test in `Modules/<Modulo>/tests/` devono essere autoloadabili con namespace `Modules\<Modulo>\Tests\*`; senza questo nodo PHPUnit/Pest non risolvono le classi. `autoload-dev` viene caricato solo in dev, non in produzione.

**Verifica**: `laravel/docs/testing/autoload-configuration.md`.

## Filament 5.x Patterns
```php
// ✅ CORRECT - Array schema con chiavi stringa
protected function getFormSchema(): array
{
    return [
        'name' => Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
    ];
}

// ❌ WRONG - Builder pattern
protected function form(Form $form): Form
{
    return $form->schema([
        // components here
    ]);
}

// ❌ WRONG - array_values() rompe il return type
protected function getHeaderActions(): array
{
    return array_values($actions);  // SBAGLIATO! Perde le chiavi stringa
}

// ✅ CORRECT - Mantieni chiavi stringa
protected function getHeaderActions(): array
{
    return $actions;  // CORRETTO!
}
```

## Livewire/Filament Widget Error Handling

### "Cannot call constructor" - CRITICAL FIX
When encountering "Cannot call constructor" in Filament widgets:

1. **Check getOptions() return type**: Filament ChartWidget accetta `array | RawJs | null`. Quando le opzioni passano via `@js()` al chart (custom view, payload), **RawJs è obbligatorio** se contengono formatter/callback (JSON non serializza funzioni).
2. **No custom constructors**: Widget classes cannot have custom `__construct()` methods
3. **Livewire factory pattern**: Widgets are instantiated via `new $class()` in Livewire Factory
4. **RawJs**: può essere il tipo di ritorno di getOptions() o usato nei formatter; entrambi validi

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
- **getOptions() può restituire array O RawJs**: Filament accetta entrambi; RawJs obbligatorio quando options passano via @js() e contengono formatter
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
// ✅ RawJs come return type è valido (Filament accetta array|RawJs|null)

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

### JpGraph Chart Generation Rules
```php
// ✅ CORRECT - Proper JpGraph service pattern
final class JpGraphService
{
    private readonly string $cachePath;
    
    public function createLineChart(array $data, array $labels): string
    {
        try {
            $graph = new Graph(600, 400);
            $graph->SetScale('textlin');
            
            $linePlot = new LinePlot($data);
            $linePlot->SetColor('#1f77b4');
            
            $graph->Add($linePlot);
            
            return $this->renderAndCache($graph, 'line_chart');
        } catch (JpGraphException $e) {
            throw new ChartGenerationException('Chart failed: ' . $e->getMessage(), 0, $e);
        }
    }
}

// ❌ WRONG - Missing exception handling and strict typing
class BadJpGraphService
{
    public function createChart($data, $labels)
    {
        $graph = new Graph(600, 400);
        // ... implementation without proper error handling
    }
}
```

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
    
    private function generateStaticChart(): string
    {
        // Generate JpGraph for PDF/export
        return $this->chartService->createLineChart($data, $labels);
    }
}

// ❌ WRONG - Direct JpGraph usage in widget
class BadWidget extends Widget
{
    public function getChart()
    {
        $graph = new Graph(600, 400); // Wrong - services should handle this
        return $graph;
    }
}
```

### JpGraph Configuration & Namespaces
```php
<?php declare(strict_types=1);

// ✅ CORRECT - Proper imports and namespace usage
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\PiePlot;

// ❌ WRONG - Incomplete imports
use Amenadiel\JpGraph\Graph; // Missing specific Graph class
```

### JpGraph Memory & Performance Rules
- **ALWAYS implement caching** for generated charts
- **Clean up old chart files** to prevent disk space issues
- **Use queue jobs for batch chart generation**
- **Limit chart dimensions** for web display (max 2000x2000)
- **Validate input data** before chart generation

### JpGraph Testing Requirements
```php
// ✅ CORRECT - Complete test coverage
final class JpGraphServiceTest extends TestCase
{
    public function test_line_chart_creation(): void
    {
        $data = [10, 20, 30];
        $labels = ['Jan', 'Feb', 'Mar'];
        
        $chartPath = $this->chartService->createLineChart($data, $labels);
        
        $this->assertIsString($chartPath);
        $this->assertFileExists(public_path($chartPath));
    }
    
    public function test_invalid_data_handling(): void
    {
        $this->expectException(ChartGenerationException::class);
        
        $this->chartService->createLineChart([], []);
    }
}
```

## Quaeris ChartService + SimpleXXChartWidget (Memoria Critica)

- **ChartService unico e centrale** (`Modules/Quaeris/app/Services/ChartService.php`):
  - Deve esistere **una sola** classe `ChartService` nel file.
  - Vietato lasciare blocchi duplicati (seconda classe incollata in fondo, costanti duplicate, numeri "sciolti" fuori da array) perché generano `ParseError` che bloccano tutti i widget (`Simple01`, `Simple02`, ecc.) e le pagine Filament (`ViewQuestionChart`).
  - Tutti i widget semplici devono usare **solo** metodi realmente esistenti nel servizio:
    - dati: `getGrowthData()`, `getWeeklyGrowthData()`, `getDailyGrowthData()`, `getMonthlySalesData()`, `getMonthlyCustomerData()`;
    - etichette: `getItalianMonthLabels()`, `getItalianWeekLabels()`, `getItalianDayLabels()`;
    - logica: `calculateGrowthPercentage()`, `formatNumber()`, `formatPercentage()`, `normalizeData()`, `smoothData()`, `calculateGrowthStatistics()`.
- **Pattern per i widget SimpleXXChartWidget**:
  - Dichiarare il servizio come proprietà nullable e usare lazy init:
    - `protected ?ChartService $chartService = null;`
    - Dentro `getData()` o metodi simili: `$this->chartService ??= new ChartService();`
  - Non definire costruttori complessi nei widget che chiamano `parent::__construct()`: Livewire/Filament gestiscono il ciclo di vita, i costruttori manuali creano facilmente problemi e violano PHPStan.
  - Quando si lavora con `$this->period` o simili, usare sempre default robusti (`$period = $this->period ?? 'monthly';`) per evitare stati nulli durante l'inizializzazione.
- **Regola per tutti gli agenti AI quando c'è un errore sui grafici Quaeris**:
  1. Controllare che `ChartService.php` sia sintatticamente corretto (nessun `];` fuori posto, nessun blocco duplicato in coda).
  2. Verificare che i widget `SimpleXXChartWidget` chiamino solo metodi esistenti del `ChartService`.
  3. Eseguire PHPStan livello 10 su servizio + widget coinvolti, per esempio:
     - `cd laravel && ./vendor/bin/phpstan analyse Modules/Quaeris/app/Services/ChartService.php Modules/Quaeris/app/Filament/Widgets/Simple01ChartWidget.php Modules/Quaeris/app/Filament/Widgets/Simple02ChartWidget.php --level=10 --no-progress`
  4. Solo quando PHPStan è pulito e la pagina Filament si carica senza `ParseError` il bug è considerato chiuso.

## Riferimenti

- [index](index.md)
- [critical-rules](critical-rules.md)
- [memories](memories.md)
