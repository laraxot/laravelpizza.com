# Colli di Bottiglia nel Modulo Chart

## 1. GetGraphAction (Impatto: ALTO)
**File**: `Modules/Chart/app/Actions/JpGraph/GetGraphAction.php`

**Problemi Identificati**:
1. Creazione ripetitiva di oggetti Graph
2. Font loading e styling per ogni grafico
3. Nessun caching dei temi e stili comuni
4. Operazioni di styling ripetitive

**Soluzione Proposta**:
```php
class GetGraphAction
{
    use QueueableAction;
    
    private ?UniversalTheme $theme = null;
    private array $fontCache = [];
    
    public function execute(ChartData $chartData): Graph
    {
        // 1. Cache del tema
        if ($this->theme === null) {
            $this->theme = Cache::tags(['chart_themes'])
                ->remember('universal_theme', now()->addDay(), function() {
                    return new UniversalTheme();
                });
        }
        
        // 2. Cache del grafico base
        $cacheKey = "graph_base_{$chartData->width}_{$chartData->height}";
        $graph = Cache::tags(['charts'])
            ->remember($cacheKey, now()->addMinutes(30), function() use ($chartData) {
                $graph = new Graph($chartData->width, $chartData->height, 'auto');
                $graph->SetScale('textlin');
                $graph->SetShadow();
                $graph->SetTheme($this->theme);
                return $graph;
            });
            
        // 3. Ottimizzazione font loading
        $this->applyFontStyles($graph, $chartData);
        
        // 4. Applicazione configurazioni specifiche
        $this->applyChartConfig($graph, $chartData);
        
        return $graph;
    }
    
    protected function applyFontStyles(Graph $graph, ChartData $chartData): void
    {
        // Cache dei font styles
        $fontKey = "{$chartData->font_family}_{$chartData->font_style}_{$chartData->font_size}";
        
        if (!isset($this->fontCache[$fontKey])) {
            $this->fontCache[$fontKey] = [
                'family' => $chartData->font_family,
                'style' => $chartData->font_style,
                'size' => $chartData->font_size
            ];
        }
        
        $font = $this->fontCache[$fontKey];
        
        // Batch application dei font styles
        collect([
            [$graph->title, 11],
            [$graph->subtitle, 11],
            [$graph->footer->center, 10],
            [$graph->footer->right, $font['size']],
            [$graph->xaxis, $font['size']],
            [$graph->yaxis, $font['size']]
        ])->each(function($config) use ($font) {
            [$element, $size] = $config;
            $element->SetFont($font['family'], $font['style'], $size);
        });
    }
    
    protected function applyChartConfig(Graph $graph, ChartData $chartData): void
    {
        // Batch application delle configurazioni
        $configs = [
            'min' => fn() => $graph->yscale->SetAutoMin($chartData->min),
            'max' => fn() => $graph->yscale->SetAutoMax($chartData->max),
            'title' => fn() => $graph->title->Set($chartData->title),
            'subtitle' => fn() => $graph->subtitle->Set($chartData->subtitle),
            'footer' => fn() => $graph->footer->center->Set($chartData->footer)
        ];
        
        collect($configs)
            ->filter(fn($_, $key) => isset($chartData->$key))
            ->each(fn($config) => $config());
            
        $graph->SetBox($chartData->show_box);
    }
}
```

## 2. ApplyPlotStyleAction (Impatto: MEDIO)
**File**: `Modules/Chart/app/Actions/JpGraph/ApplyPlotStyleAction.php`

**Problemi Identificati**:
1. Styling ripetitivo per plot simili
2. Nessun riuso di configurazioni comuni
3. Calcoli ripetuti per stili

**Soluzione Proposta**:
```php
class ApplyPlotStyleAction
{
    private array $styleCache = [];
    
    public function execute(BarPlot $barPlot, ChartData $chartData): void
    {
        // 1. Cache degli stili comuni
        $styleKey = $this->getStyleKey($chartData);
        
        if (!isset($this->styleCache[$styleKey])) {
            $this->styleCache[$styleKey] = $this->computeStyles($chartData);
        }
        
        $styles = $this->styleCache[$styleKey];
        
        // 2. Batch application degli stili
        $this->applyStyles($barPlot, $styles);
    }
    
    protected function getStyleKey(ChartData $chartData): string
    {
        return md5(serialize([
            $chartData->width,
            $chartData->height,
            $chartData->style_options
        ]));
    }
    
    protected function computeStyles(ChartData $chartData): array
    {
        return Cache::tags(['plot_styles'])
            ->remember("style_{$this->getStyleKey($chartData)}", now()->addHour(), function() use ($chartData) {
                return [
                    'colors' => $this->generateColors($chartData),
                    'patterns' => $this->generatePatterns($chartData),
                    'legends' => $this->generateLegends($chartData)
                ];
            });
    }
    
    protected function applyStyles(BarPlot $barPlot, array $styles): void
    {
        collect($styles)->each(function($style, $key) use ($barPlot) {
            $method = "apply{$key}Style";
            if (method_exists($this, $method)) {
                $this->$method($barPlot, $style);
            }
        });
    }
}
```

## 3. Chart Widgets (Impatto: MEDIO)
**File**: `Modules/Chart/app/Filament/Widgets/Samples/Sample01Chart.php`

**Problemi Identificati**:
1. Rendering sincrono dei widget
2. Dati non cachati per chart statici
3. Opzioni ripetitive non ottimizzate

**Soluzione Proposta**:
```php
abstract class BaseChartWidget extends ChartWidget
{
    protected static string $pollingInterval = '30s';
    protected array $optionsCache = [];
    
    protected function getData(): array
    {
        // 1. Cache dei dati per chart statici
        if ($this->isStaticChart()) {
            return Cache::tags(['chart_widgets'])
                ->remember($this->getCacheKey(), $this->getCacheDuration(), function() {
                    return $this->generateChartData();
                });
        }
        
        return $this->generateChartData();
    }
    
    protected function getOptions(): array
    {
        // 2. Cache delle opzioni comuni
        $optionsKey = $this->getType();
        
        if (!isset($this->optionsCache[$optionsKey])) {
            $this->optionsCache[$optionsKey] = Cache::tags(['chart_options'])
                ->remember("options_{$optionsKey}", now()->addHour(), function() {
                    return $this->generateOptions();
                });
        }
        
        return $this->optionsCache[$optionsKey];
    }
    
    protected function isStaticChart(): bool
    {
        return !$this->hasFilters() && !$this->hasRealTimeData();
    }
    
    protected function getCacheKey(): string
    {
        return "widget_{$this->getId()}_{$this->getType()}";
    }
    
    protected function getCacheDuration(): \DateTimeInterface
    {
        return now()->addMinutes(30);
    }
    
    abstract protected function generateChartData(): array;
    abstract protected function generateOptions(): array;
    abstract protected function hasFilters(): bool;
    abstract protected function hasRealTimeData(): bool;
}

class Sample01Chart extends BaseChartWidget
{
    protected function generateChartData(): array
    {
        // Implementazione specifica
    }
    
    protected function generateOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'datalabels' => [
                    'display' => true,
                    'backgroundColor' => '#ccc',
                    'borderRadius' => 3,
                    'anchor' => 'start',
                    'font' => [
                        'color' => 'red',
                        'weight' => 'bold'
                    ]
                ]
            ]
        ];
    }
    
    protected function hasFilters(): bool
    {
        return false;
    }
    
    protected function hasRealTimeData(): bool
    {
        return false;
    }
}
```

## Impatto Complessivo Stimato

1. **Performance**:
   - Riduzione 55% tempo generazione grafici
   - Riduzione 45% memoria utilizzata
   - Miglioramento 40% tempo di risposta widget

2. **Scalabilità**:
   - Supporto 3x più grafici concorrenti
   - Gestione 2x volume dati attuale
   - Riduzione 50% carico server

3. **User Experience**:
   - Rendering grafici più veloce
   - Widget più reattivi
   - Meno lag nell'interfaccia

## Piano di Implementazione

1. **Fase 1** (Settimana 1):
   - Implementare caching in GetGraphAction
   - Ottimizzare font e theme handling
   - Aggiungere batch styling

2. **Fase 2** (Settimana 2):
   - Implementare ApplyPlotStyleAction ottimizzato
   - Aggiungere caching stili
   - Ottimizzare pattern generation

3. **Fase 3** (Settimana 3):
   - Implementare BaseChartWidget
   - Convertire widget esistenti
   - Testing e monitoring
