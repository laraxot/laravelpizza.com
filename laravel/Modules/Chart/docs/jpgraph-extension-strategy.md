# JpGraph Extension Strategy: Inheritance-Based Approach

## Overview

Invece di creare un pacchetto completamente nuovo, estendiamo le classi JpGraph originali mantenendo la compatibilità e aggiungendo funzionalità custom con namespace coerenti.

## Philosophy

### 1. Why Extension Over Replacement?

- **Coerenza**: Manteniamo `amenadiel/jpgraph` come dipendenza base
- **Stabilità**: Ci appoggiamo su una base testata e funzionante
- **Estensibilità**: Aggiungiamo solo le funzionalità che ci servono
- **Manutenzione**: Meno codice da mantenere
- **Namespace Puliti**: Usiamo namespace logici e coerenti

### 2. Namespace Strategy

```
Amenadiel\JpGraph\    <- Base JpGraph
Modules\Chart\JpGraph\  <- Estensioni specifiche
Modules\Quaeris\JpGraph\ <- Estensioni business
```

## Implementation Strategy

### 1. Chart Module Extensions

#### 1.1 Enhanced Line Plot

```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Plot;

use Amenadiel\JpGraph\Plot\LinePlot;

/**
 * Enhanced Line Plot with additional features for Chart module
 */
class EnhancedLinePlot extends LinePlot
{
    protected bool $showGradient = false;
    protected string $gradientColor = '#ffffff';
    protected bool $smoothLine = false;
    protected array $dataLabels = [];
    protected bool $showDataLabels = false;
    
    /**
     * Enable gradient fill for line area
     */
    public function setGradientFill(string $color = '#ffffff'): self
    {
        $this->showGradient = true;
        $this->gradientColor = $color;
        return $this;
    }
    
    /**
     * Enable smooth curves
     */
    public function setSmooth(bool $smooth = true): self
    {
        $this->smoothLine = $smooth;
        return $this;
    }
    
    /**
     * Set data labels to display on points
     */
    public function setDataLabels(array $labels): self
    {
        $this->dataLabels = $labels;
        $this->showDataLabels = true;
        return $this;
    }
    
    /**
     * Override legend creation for enhanced display
     */
    public function Legend($graph)
    {
        $graph->legend->Add($this->legend, $this->color, $this->mark->GetType(), 0, '');
        
        if ($this->showGradient) {
            $graph->legend->Add($this->legend . ' (gradient)', $this->gradientColor, 0, 0, '');
        }
    }
    
    /**
     * Enhanced stroke method with gradient support
     */
    public function Stroke($img, $xscale, $yscale)
    {
        parent::Stroke($img, $xscale, $yscale);
        
        if ($this->showGradient) {
            $this->drawGradient($img, $xscale, $yscale);
        }
        
        if ($this->showDataLabels) {
            $this->drawDataLabels($img, $xscale, $yscale);
        }
    }
    
    /**
     * Draw gradient fill under the line
     */
    private function drawGradient($img, $xscale, $yscale): void
    {
        $numpoints = count($this->coords[0]);
        
        $p = [];
        for ($i = 0; $i < $numpoints; $i++) {
            $x = $xscale->Translate($this->coords[0][$i]);
            $y = $yscale->Translate($this->coords[1][$i]);
            $p[] = [$x, $y];
        }
        
        // Add bottom corners to close the shape
        $p[] = [$xscale->Translate($this->coords[0][$numpoints - 1]), $yscale->Translate(0)];
        $p[] = [$xscale->Translate($this->coords[0][0]), $yscale->Translate(0)];
        
        $img->SetLineWeight(1);
        $img->SetColor($this->gradientColor);
        $img->FilledPolygon($p);
    }
    
    /**
     * Draw data labels on points
     */
    private function drawDataLabels($img, $xscale, $yscale): void
    {
        $numpoints = count($this->coords[0]);
        
        $img->SetFont(FF_FONT1, FS_NORMAL, 8);
        $img->SetColor('black');
        
        for ($i = 0; $i < $numpoints && $i < count($this->dataLabels); $i++) {
            $x = $xscale->Translate($this->coords[0][$i]);
            $y = $yscale->Translate($this->coords[1][$i]);
            
            $label = $this->dataLabels[$i];
            $img->SetTextAlign('center');
            $img->StrokeText($x, $y - 10, $label);
        }
    }
}
```

#### 1.2 Enhanced Bar Plot

```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Plot;

use Amenadiel\JpGraph\Plot\BarPlot;

/**
 * Enhanced Bar Plot with advanced features
 */
class EnhancedBarPlot extends BarPlot
{
    protected bool $showValues = false;
    protected string $valueFormat = '%d';
    protected bool $roundedCorners = false;
    protected int $cornerRadius = 5;
    protected array $barPatterns = [];
    
    /**
     * Show values on top of bars
     */
    public function setShowValues(bool $show = true, string $format = '%d'): self
    {
        $this->showValues = $show;
        $this->valueFormat = $format;
        return $this;
    }
    
    /**
     * Enable rounded corners on bars
     */
    public function setRoundedCorners(bool $rounded = true, int $radius = 5): self
    {
        $this->roundedCorners = $rounded;
        $this->cornerRadius = $radius;
        return $this;
    }
    
    /**
     * Set pattern fill for bars
     */
    public function setBarPattern(string $pattern, string $color): self
    {
        $this->barPatterns = [
            'pattern' => $pattern,
            'color' => $color
        ];
        return $this;
    }
    
    /**
     * Enhanced stroke with values and rounded corners
     */
    public function Stroke($img, $xscale, $yscale)
    {
        parent::Stroke($img, $xscale, $yscale);
        
        if ($this->showValues) {
            $this->drawValues($img, $xscale, $yscale);
        }
    }
    
    /**
     * Draw values on top of bars
     */
    private function drawValues($img, $xscale, $yscale): void
    {
        $numpoints = count($this->coords[0]);
        
        $img->SetFont(FF_FONT1, FS_BOLD, 10);
        $img->SetColor($this->valuecolor ?? 'black');
        $img->SetTextAlign('center');
        
        for ($i = 0; $i < $numpoints; $i++) {
            $x = $xscale->Translate($this->coords[0][$i]);
            $y = $yscale->Translate($this->coords[1][$i]);
            
            $value = $this->coords[1][$i];
            $label = sprintf($this->valueFormat, $value);
            
            // Position label above bar
            $labelY = $y - 5;
            $img->StrokeText($x, $labelY, $label);
        }
    }
}
```

#### 1.3 Enhanced Pie Plot

```php
<?php declare(strict_types=1);

namespace Modules\Chart\JpGraph\Plot;

use Amenadiel\JpGraph\Plot\PiePlot;

/**
 * Enhanced Pie Plot with Italian business features
 */
class EnhancedPiePlot extends PiePlot
{
    protected bool $showLegendValues = false;
    protected bool $showAbsoluteValues = false;
    protected string $currencySymbol = '€';
    protected array $customColors = [];
    
    /**
     * Show values in legend
     */
    public function setShowLegendValues(bool $show = true): self
    {
        $this->showLegendValues = $show;
        return $this;
    }
    
    /**
     * Show absolute values instead of percentages
     */
    public function setShowAbsoluteValues(bool $show = true, string $currency = '€'): self
    {
        $this->showAbsoluteValues = $show;
        $this->currencySymbol = $currency;
        return $this;
    }
    
    /**
     * Set custom color palette
     */
    public function setCustomColors(array $colors): self
    {
        $this->customColors = $colors;
        return $this;
    }
    
    /**
     * Enhanced legend with values
     */
    public function Legend($graph)
    {
        if ($this->showLegendValues) {
            $this->enhancedLegend($graph);
        } else {
            parent::Legend($graph);
        }
    }
    
    /**
     * Create enhanced legend with values
     */
    private function enhancedLegend($graph): void
    {
        $n = count($this->data);
        
        for ($i = 0; $i < $n; $i++) {
            $label = $this->labels[$i];
            $value = $this->data[$i];
            
            if ($this->showAbsoluteValues) {
                $formattedValue = $this->currencySymbol . number_format($value, 2, ',', '.');
                $legendText = "{$label}: {$formattedValue}";
            } else {
                $percentage = ($value / array_sum($this->data)) * 100;
                $legendText = "{$label}: " . number_format($percentage, 1) . '%';
            }
            
            $color = $this->customColors[$i] ?? $this->icolors[$i];
            $graph->legend->Add($legendText, $color, 0, 8, '');
        }
    }
}
```

### 2. Quaeris Module Business Extensions

#### 2.1 Italian Business Chart

```php
<?php declare(strict_types=1);

namespace Modules\Quaeris\JpGraph\Chart;

use Amenadiel\JpGraph\Graph\Graph;
use Modules\Chart\JpGraph\Plot\EnhancedLinePlot;
use Modules\Chart\JpGraph\Plot\EnhancedBarPlot;
use Modules\Chart\JpGraph\Plot\EnhancedPiePlot;

/**
 * Italian Business Chart with localization and business logic
 */
class ItalianBusinessChart extends Graph
{
    protected array $italianMonths = [
        'Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu',
        'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'
    ];
    
    protected array $italianColors = [
        '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
        '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'
    ];
    
    /**
     * Create KPI trend chart with Italian formatting
     */
    public function createKPITrend(array $data, array $periods, array $options = []): EnhancedLinePlot
    {
        $this->SetScale('textlin');
        $this->title->Set($options['title'] ?? 'Andamento KPI');
        $this->xaxis->title->Set('Periodo');
        $this->yaxis->title->Set($options['unit'] ?? 'Valore');
        
        // Italian formatting for Y-axis
        $this->yaxis->SetLabelFormatCallback(function($label) {
            return number_format($label, 0, ',', '.');
        });
        
        $linePlot = new EnhancedLinePlot($data);
        $linePlot->SetColor($this->italianColors[0]);
        $linePlot->SetWeight(3);
        
        // Add gradient for better visual appeal
        if ($options['gradient'] ?? true) {
            $linePlot->setGradientFill($this->italianColors[1] . '40');
        }
        
        // Add markers if data points are few
        if (count($data) <= 12) {
            $linePlot->mark->SetType(MARK_FILLEDCIRCLE);
            $linePlot->mark->SetFillColor($linePlot->color);
            $linePlot->mark->SetWidth(6);
            $linePlot->mark->SetColor('#ffffff');
            $linePlot->mark->SetWeight(2);
        }
        
        // Format periods in Italian
        $italianPeriods = $this->formatItalianPeriods($periods);
        $this->xaxis->SetTickLabels($italianPeriods);
        
        $this->Add($linePlot);
        
        return $linePlot;
    }
    
    /**
     * Create revenue vs expense comparison
     */
    public function createRevenueComparison(
        array $revenue, 
        array $expense, 
        array $periods,
        array $options = []
    ): array {
        $this->SetScale('textlin');
        $this->title->Set($options['title'] ?? 'Ricavi vs Costi');
        $this->xaxis->title->Set('Periodo');
        $this->yaxis->title->Set('Importo (€)');
        
        // Italian currency formatting
        $this->yaxis->SetLabelFormatCallback(function($label) {
            return '€' . number_format($label, 0, ',', '.');
        });
        
        // Revenue bars
        $revenuePlot = new EnhancedBarPlot($revenue);
        $revenuePlot->SetColor($this->italianColors[2]);
        $revenuePlot->SetFillColor($this->italianColors[2]);
        $revenuePlot->SetLegend('Ricavi');
        $revenuePlot->setShowValues(true, '%.0f€');
        
        // Expense bars
        $expensePlot = new EnhancedBarPlot($expense);
        $expensePlot->SetColor($this->italianColors[3]);
        $expensePlot->SetFillColor($this->italianColors[3]);
        $expensePlot->SetLegend('Costi');
        $expensePlot->setShowValues(true, '%.0f€');
        
        // Group bars
        $groupBarPlot = new GroupBarPlot([$revenuePlot, $expensePlot]);
        
        $italianPeriods = $this->formatItalianPeriods($periods);
        $this->xaxis->SetTickLabels($italianPeriods);
        
        $this->Add($groupBarPlot);
        
        return [
            'revenue_plot' => $revenuePlot,
            'expense_plot' => $expensePlot,
            'group_plot' => $groupBarPlot
        ];
    }
    
    /**
     * Create Italian business pie chart
     */
    public function createBusinessPie(array $data, array $labels, array $options = []): EnhancedPiePlot
    {
        $this->title->Set($options['title'] ?? 'Distribuzione Business');
        
        $piePlot = new EnhancedPiePlot($data);
        $piePlot->SetLabels($labels);
        $piePlot->SetCenter(0.5, 0.5);
        $piePlot->SetSize(0.3);
        
        // Italian colors
        $piePlot->SetSliceColors($this->italianColors);
        
        // Show absolute values with Euro
        $piePlot->setShowAbsoluteValues(true, '€');
        $piePlot->setShowLegendValues(true);
        
        $this->Add($piePlot);
        
        return $piePlot;
    }
    
    /**
     * Format periods in Italian
     */
    private function formatItalianPeriods(array $periods): array
    {
        $formatted = [];
        
        foreach ($periods as $period) {
            if (preg_match('/^\d{4}-\d{2}$/', $period)) {
                // Format YYYY-MM to Italian month
                $date = \DateTime::createFromFormat('Y-m', $period);
                $formatted[] = $this->italianMonths[(int)$date->format('m') - 1] . ' ' . $date->format('Y');
            } elseif (preg_match('/^Q\d$/', $period)) {
                // Keep quarters as-is
                $formatted[] = $period;
            } else {
                $formatted[] = $period;
            }
        }
        
        return $formatted;
    }
}
```

#### 2.2 Financial Report Chart

```php
<?php declare(strict_types=1);

namespace Modules\Quaeris\JpGraph\Chart;

use Modules\Quaeris\JpGraph\Chart\ItalianBusinessChart;
use Modules\Chart\JpGraph\Plot\EnhancedBarPlot;
use Amenadiel\JpGraph\Plot\StockPlot;

/**
 * Financial Report Chart specialized for Italian businesses
 */
class FinancialReportChart extends ItalianBusinessChart
{
    /**
     * Create IVA analysis chart
     */
    public function createIVAChart(
        array $imponibili, 
        array $ivaAmounts,
        array $periods,
        array $options = []
    ): array {
        $this->title->Set($options['title'] ?? 'Analisi IVA');
        $this->yaxis->title->Set('Importo (€)');
        
        // Italian currency formatting
        $this->yaxis->SetLabelFormatCallback(function($label) {
            return '€' . number_format($label, 0, ',', '.');
        });
        
        // Stacked bars for imponibile + IVA
        $imponibilePlot = new EnhancedBarPlot($imponibili);
        $imponibilePlot->SetColor($this->italianColors[0]);
        $imponibilePlot->SetFillColor($this->italianColors[0]);
        $imponibilePlot->SetLegend('Imponibile');
        
        $ivaPlot = new EnhancedBarPlot($ivaAmounts);
        $ivaPlot->SetColor($this->italianColors[1]);
        $ivaPlot->SetFillColor($this->italianColors[1]);
        $ivaPlot->SetLegend('IVA');
        
        // Create accumulated bar plot
        $accBarPlot = new AccBarPlot([$imponibilePlot, $ivaPlot]);
        
        $italianPeriods = $this->formatItalianPeriods($periods);
        $this->xaxis->SetTickLabels($italianPeriods);
        
        $this->Add($accBarPlot);
        
        // Add IVA percentage annotation
        if ($options['show_iva_rate'] ?? true) {
            $totalIVA = array_sum($ivaAmounts);
            $totalImponibile = array_sum($imponibili);
            $ivaRate = $totalIVA / $totalImponibile * 100;
            
            $this->table->Set(1);
            $this->table->SetAlign('right');
            $this->table->Row(['Aliquota IVA: ' . number_format($ivaRate, 1) . '%']);
        }
        
        return [
            'imponibile_plot' => $imponibilePlot,
            'iva_plot' => $ivaPlot,
            'accumulated_plot' => $accBarPlot
        ];
    }
    
    /**
     * Create profit margin analysis
     */
    public function createProfitMarginChart(
        array $revenues,
        array $costs,
        array $periods,
        array $options = []
    ): array {
        $this->title->Set($options['title'] ?? 'Analisi Margini di Profitto');
        $this->yaxis->title->Set('Importo (€)');
        
        $profitPlot = new EnhancedBarPlot($revenues);
        $profitPlot->SetColor($this->italianColors[2]);
        $profitPlot->SetFillColor($this->italianColors[2]);
        $profitPlot->SetLegend('Ricavi');
        $profitPlot->setShowValues(true, '%.0f€');
        
        $costPlot = new EnhancedBarPlot($costs);
        $costPlot->SetColor($this->italianColors[3]);
        $costPlot->SetFillColor($this->italianColors[3]);
        $costPlot->SetLegend('Costi');
        $costPlot->setShowValues(true, '%.0f€');
        
        // Calculate profit margins
        $margins = [];
        for ($i = 0; $i < count($revenues); $i++) {
            $margin = $revenues[$i] - $costs[$i];
            $margins[] = max(0, $margin); // Don't show negative margins on chart
        }
        
        $marginPlot = new EnhancedBarPlot($margins);
        $marginPlot->SetColor($this->italianColors[4]);
        $marginPlot->SetFillColor($this->italianColors[4]);
        $marginPlot->SetLegend('Margine');
        $marginPlot->setShowValues(true, '%.0f€');
        
        $groupPlot = new GroupBarPlot([$profitPlot, $costPlot, $marginPlot]);
        
        $italianPeriods = $this->formatItalianPeriods($periods);
        $this->xaxis->SetTickLabels($italianPeriods);
        
        $this->Add($groupPlot);
        
        return [
            'revenue_plot' => $profitPlot,
            'cost_plot' => $costPlot,
            'margin_plot' => $marginPlot,
            'group_plot' => $groupPlot
        ];
    }
}
```

### 3. Service Integration

#### 3.1 Enhanced Chart Service

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Services;

use Modules\Quaeris\JpGraph\Chart\ItalianBusinessChart;
use Modules\Quaeris\JpGraph\Chart\FinancialReportChart;
use Modules\Chart\JpGraph\Plot\EnhancedLinePlot;
use Modules\Chart\JpGraph\Plot\EnhancedBarPlot;
use Modules\Chart\JpGraph\Plot\EnhancedPiePlot;

/**
 * Enhanced chart service using JpGraph extensions
 */
final class EnhancedJpGraphService
{
    private readonly string $cachePath;
    private readonly string $publicPath;
    
    public function __construct()
    {
        $this->cachePath = storage_path('app/public/charts');
        $this->publicPath = 'storage/charts';
        $this->ensureCacheDirectory();
    }
    
    /**
     * Create Italian business KPI chart
     */
    public function createBusinessKPIChart(
        array $data, 
        array $periods, 
        array $options = []
    ): string {
        $chart = new ItalianBusinessChart(800, 400);
        
        $linePlot = $chart->createKPITrend($data, $periods, $options);
        
        // Additional enhancements
        if ($options['data_labels'] ?? false) {
            $labels = array_map(function($value) {
                return number_format($value, 0, ',', '.');
            }, $data);
            $linePlot->setDataLabels($labels);
        }
        
        return $this->renderAndCache($chart, 'business_kpi');
    }
    
    /**
     * Create financial IVA chart
     */
    public function createIVAChart(
        array $imponibili, 
        array $ivaAmounts,
        array $periods,
        array $options = []
    ): string {
        $chart = new FinancialReportChart(800, 500);
        
        $chart->createIVAChart($imponibili, $ivaAmounts, $periods, $options);
        
        return $this->renderAndCache($chart, 'iva_analysis');
    }
    
    /**
     * Create profit margin analysis
     */
    public function createProfitMarginChart(
        array $revenues,
        array $costs,
        array $periods,
        array $options = []
    ): string {
        $chart = new FinancialReportChart(900, 500);
        
        $chart->createProfitMarginChart($revenues, $costs, $periods, $options);
        
        return $this->renderAndCache($chart, 'profit_margin');
    }
    
    /**
     * Create business pie chart
     */
    public function createBusinessPieChart(
        array $data, 
        array $labels, 
        array $options = []
    ): string {
        $chart = new ItalianBusinessChart(600, 400);
        
        $piePlot = $chart->createBusinessPie($data, $labels, $options);
        
        // Additional customization
        if ($options['explode'] ?? false) {
            $piePlot->Explode($options['explode_slices'] ?? 0.1);
        }
        
        return $this->renderAndCache($chart, 'business_pie');
    }
    
    /**
     * Create dashboard with multiple charts
     */
    public function createBusinessDashboard(array $dashboardData): array
    {
        $charts = [];
        
        // KPI Trend
        if (isset($dashboardData['kpi'])) {
            $charts['kpi_trend'] = $this->createBusinessKPIChart(
                $dashboardData['kpi']['values'],
                $dashboardData['kpi']['periods'],
                [
                    'title' => 'Andamento KPI Business',
                    'gradient' => true,
                    'data_labels' => $dashboardData['kpi']['show_labels'] ?? false
                ]
            );
        }
        
        // Revenue Comparison
        if (isset($dashboardData['revenue_comparison'])) {
            $charts['revenue_comparison'] = $this->createBusinessKPIChart(
                $dashboardData['revenue_comparison']['revenues'],
                $dashboardData['revenue_comparison']['periods'],
                [
                    'title' => 'Confronto Ricavi',
                    'unit' => '€'
                ]
            );
        }
        
        // IVA Analysis
        if (isset($dashboardData['iva'])) {
            $charts['iva_analysis'] = $this->createIVAChart(
                $dashboardData['iva']['imponibili'],
                $dashboardData['iva']['iva_amounts'],
                $dashboardData['iva']['periods'],
                [
                    'title' => 'Analisi IVA Trimestrale',
                    'show_iva_rate' => true
                ]
            );
        }
        
        // Profit Margins
        if (isset($dashboardData['margins'])) {
            $charts['profit_margins'] = $this->createProfitMarginChart(
                $dashboardData['margins']['revenues'],
                $dashboardData['margins']['costs'],
                $dashboardData['margins']['periods'],
                [
                    'title' => 'Analisi Margini di Profitto'
                ]
            );
        }
        
        return $charts;
    }
    
    private function renderAndCache($chart, string $type): string
    {
        $filename = $this->generateFilename($type);
        $fullPath = $this->cachePath . '/' . $filename;
        $chart->Stroke($fullPath);
        
        return $this->publicPath . '/' . $filename;
    }
    
    private function generateFilename(string $type): string
    {
        return $type . '_' . uniqid() . '_' . time() . '.png';
    }
    
    private function ensureCacheDirectory(): void
    {
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }
}
```

### 4. Composer Configuration

#### 4.1 Chart Module composer.json

```json
{
    "name": "nwidart/laravel-modules-chart",
    "description": "Chart module with enhanced JpGraph integration",
    "type": "laravel-module",
    "require": {
        "php": "^8.1",
        "amenadiel/jpgraph": "^4.4"
    },
    "autoload": {
        "psr-4": {
            "Modules\\Chart\\": ".",
            "Modules\\Chart\\JpGraph\\": "app/JpGraph",
            "Modules\\Quaeris\\JpGraph\\": "../Quaeris/app/JpGraph"
        }
    },
    "suggest": {
        "ext-gd": "For enhanced image processing",
        "ext-imagick": "For advanced image features"
    }
}
```

#### 4.2 Quaeris Module composer.json

```json
{
    "name": "nwidart/laravel-modules-quaeris",
    "description": "Quaeris module with business chart extensions",
    "type": "laravel-module",
    "require": {
        "php": "^8.1",
        "amenadiel/jpgraph": "^4.4"
    },
    "autoload": {
        "psr-4": {
            "Modules\\Quaeris\\": ".",
            "Modules\\Quaeris\\JpGraph\\": "app/JpGraph"
        }
    }
}
```

## Benefits of This Approach

1. **Coerenza Namespace**: Manteniamo coerenza con `amenadiel/jpgraph`
2. **Stabilità**: Ci appoggiamo su una base testata
3. **Estensibilità**: Aggiungiamo solo ciò che serve
4. **Manutenzione**: Meno codice custom da mantenere
5. **Localizzazione**: Supporto nativo per business italiano
6. **Performance**: Ottimizzato per casi d'uso specifici
7. **Testabilità**: Codice strutturato per test facili

## Usage Examples

```php
// Controller usage
$chartService = new EnhancedJpGraphService();

// Business KPI chart
$kpiChart = $chartService->createBusinessKPIChart(
    [1000, 1200, 1100, 1300],
    ['2024-01', '2024-02', '2024-03', '2024-04'],
    [
        'title' => 'Andamento Fatturato',
        'unit' => '€',
        'gradient' => true
    ]
);

// Dashboard completo
$dashboardCharts = $chartService->createBusinessDashboard([
    'kpi' => [
        'values' => [1000, 1200, 1100, 1300],
        'periods' => ['2024-01', '2024-02', '2024-03', '2024-04'],
        'show_labels' => true
    ],
    'iva' => [
        'imponibili' => [819, 983, 901, 1065],
        'iva_amounts' => [180, 216, 198, 234],
        'periods' => ['Q1', 'Q2', 'Q3', 'Q4']
    ]
]);
```

Questo approccio offre il meglio di entrambi i mondi: stabilità di JpGraph originale con estensibilità personalizzata per business italiano.