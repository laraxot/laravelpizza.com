# Chart.js Export Actions Documentation

## Overview

This document describes the actions created to handle Chart.js export to SVG and PNG formats in the Laraxot framework. These actions follow the Laraxot architecture patterns using Spatie QueueableAction.

## Actions Overview

### 1. ExportToPngAction

This action prepares chart data for PNG export. Since Chart.js runs client-side, this action provides the data structure needed for client-side canvas to PNG conversion.

**Location**: `Modules/Chart/app/Actions/ChartJs/ExportToPngAction.php`

> **Aggiornamento 18 novembre 2025**  
> L’azione ora usa `Webmozart\Assert` per validare base64 e contenuti dei file, documenta gli array come `list<string>` e normalizza il risultato di `Storage::get()` per mantenere PHPStan livello 10.

**Usage**:
```php
$result = app(ExportToPngAction::class)->execute(
    $chartData,           // Chart.js configuration data
    $chartId,             // HTML ID of the chart canvas
    $options              // Export options (quality, scale, etc.)
);
```

**Options**:
- `quality`: PNG quality (0.0 to 1.0, default 1.0)
- `scale`: Scale factor for high DPI (default 2)
- `filename`: Output filename (default 'chart_{timestamp}.png')
- `width`: Chart width (default from chart data or 800)
- `height`: Chart height (default from chart data or 600)

### 2. ExportToSvgAction

This action generates SVG content from Chart.js data on the server side. It supports multiple chart types including bar, line, pie, and doughnut charts.

**Location**: `Modules/Chart/app/Actions/ChartJs/ExportToSvgAction.php`

> **18 novembre 2025 – aggiornamento**  
> L'azione è stata completamente tipizzata: normalizza datasets/labels, usa Safe helpers per l'escaping e applica controlli sui valori numerici per evitare errori PHPStan livello 10.

> **22 dicembre 2025 – refactoring completo PHPStan Level 10**  
> Refactoring completo per PHPStan Level 10 con:
> - Helper methods per ridurre complexity (< 10)
> - Type narrowing completo con `is_array()`, `isset()`, `is_numeric()`
> - Safe functions per tutte le operazioni stringa (`Safe\sprintf`, `Safe\htmlspecialchars`)
> - Normalizzazione dati con metodi dedicati (`normalizeNumericSeries`, `normalizeColorPalette`, `normalizeLabels`)
> - PHPDoc espliciti per tutti i tipi di ritorno
> - Gestione sicura di divisioni per zero con `max(..., 1)`

**Usage**:
```php
$result = app(ExportToSvgAction::class)->execute(
    $chartData,           // Chart.js configuration data
    $options               // Export options
);
```

**Options**:
- `width`: SVG width (default from chart data or 800)
- `height`: SVG height (default from chart data or 600)
- `filename`: Output filename (default 'chart_{timestamp}.svg')
- `title`: Chart title (default from chart data or 'Chart')
- `includeStyles`: Whether to include basic CSS styles (default true)

**Supported Chart Types**:
- Bar charts
- Line charts  
- Pie charts
- Doughnut charts
- Generic chart (fallback)

### 3. SaveSvgToFileAction

This action saves the generated SVG content to a file in the storage directory.

**Location**: `Modules/Chart/app/Actions/ChartJs/SaveSvgToFileAction.php`

**Usage**:
```php
$filePath = app(SaveSvgToFileAction::class)->execute(
    $svgContent,          // SVG content string
    $filename,            // Optional filename
    $directory            // Directory relative to storage (default 'charts')
);
```

### 4. SavePngToFileAction

This action saves base64-encoded PNG data (typically from client-side canvas) to a file.

**Location**: `Modules/Chart/app/Actions/ChartJs/SavePngToFileAction.php`

**Usage**:
```php
$filePath = app(SavePngToFileAction::class)->execute(
    $base64Data,          // Base64 encoded PNG data
    $filename,            // Optional filename
    $directory            // Directory relative to storage (default 'charts')
);
```

## Integration with Filament Widgets

To use these actions with Filament chart widgets, you would typically implement the following pattern:

### Example: Chart Widget with Export Functionality

```php
<?php

namespace Modules\Chart\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Chart\Actions\ChartJs\ExportToSvgAction;
use Modules\Chart\Actions\ChartJs\ExportToPngAction;
use Modules\Chart\Actions\ChartJs\SaveSvgToFileAction;
use Modules\Chart\Actions\ChartJs\SavePngToFileAction;

class SampleChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Sample Chart';
    
    protected static ?string $maxHeight = '300px';
    
    protected int | string | array $columnSpan = 'full';
    
    public string $chartId = 'sample-chart';
    
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sample Data',
                    'data' => [10, 20, 30, 40, 25],
                    'backgroundColor' => ['rgba(54, 162, 235, 0.2)'],
                    'borderColor' => ['rgba(54, 162, 235, 1)'],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        ];
    }
    
    protected function getType(): string
    {
        return 'bar';
    }
    
    public function exportToSvg()
    {
        $chartData = $this->getData();
        $chartData['type'] = $this->getType();
        $chartData['width'] = 800;
        $chartData['height'] = 600;
        
        $result = app(ExportToSvgAction::class)->execute($chartData);
        
        $filePath = app(SaveSvgToFileAction::class)->execute(
            $result['svg_content'],
            'sample_chart_' . time() . '.svg'
        );
        
        return response()->download($filePath);
    }
    
    public function exportToPng()
    {
        // For client-side export, prepare data for JavaScript
        $chartData = $this->getData();
        $chartData['type'] = $this->getType();
        $chartData['width'] = 800;
        $chartData['height'] = 600;
        
        $result = app(ExportToPngAction::class)->execute(
            $chartData,
            $this->chartId
        );
        
        // Return the configuration for client-side processing
        return response()->json($result);
    }
}
```

### Example: Blade Template with Client-Side Export

```blade
<div class="chart-container">
    <canvas id="{{ $chartId }}"></canvas>
    
    <div class="export-buttons">
        <button wire:click="exportToSvg" class="bg-blue-500 text-white px-4 py-2 rounded">
            Export SVG
        </button>
        
        <button onclick="exportChartToPng()" class="bg-green-500 text-white px-4 py-2 rounded">
            Export PNG
        </button>
    </div>
</div>

<script>
function exportChartToPng() {
    @this.exportToPng().then(response => {
        const chart = Chart.getChart('{{ $chartId }}');
        if (chart) {
            // Get PNG data from chart
            const dataUrl = chart.toBase64Image();
            
            // Send to server to save
            fetch('/api/chart/save-png', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    base64Data: dataUrl,
                    filename: 'chart_' + Date.now() + '.png'
                })
            }).then(response => {
                if (response.ok) {
                    // Download the saved file
                    response.blob().then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'chart_' + Date.now() + '.png';
                        a.click();
                        window.URL.revokeObjectURL(url);
                    });
                }
            });
        }
    });
}
</script>
```

## PHPStan Level 10 Compliance - Safe Patterns

### Safe Functions Utilizzate

Tutte le operazioni su stringhe utilizzano funzioni Safe per garantire type safety:

```php
use function Safe\sprintf;
use function Safe\htmlspecialchars;

// ✅ CORRETTO - Safe sprintf per concatenazione stringhe
$svg = sprintf(
    '<svg width="%d" height="%d">%s</svg>',
    $width,
    $height,
    $content
);

// ✅ CORRETTO - Safe htmlspecialchars per escaping
$escapedTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
```

### Type Narrowing Pattern

Pattern completo per type narrowing di array e valori mixed:

```php
// ✅ CORRETTO - Type narrowing completo
private function extractChartPayload(array $chartData): array
{
    if (! isset($chartData['data']) || ! is_array($chartData['data'])) {
        return ['datasets' => [], 'labels' => []];
    }

    $data = $chartData['data'];

    // Normalizza datasets
    $datasets = [];
    if (isset($data['datasets']) && is_array($data['datasets'])) {
        foreach ($data['datasets'] as $dataset) {
            if (is_array($dataset)) {
                $datasets[] = $this->normalizeNumericSeries($dataset);
            }
        }
    }

    // Normalizza labels
    $labels = [];
    if (isset($data['labels']) && is_array($data['labels'])) {
        $labels = $this->normalizeLabels($data['labels']);
    }

    return [
        'datasets' => $datasets,
        'labels' => $labels,
    ];
}
```

### Helper Methods per Complexity Reduction

Metodi helper creati per ridurre complexity e migliorare manutenibilità:

#### normalizeNumericSeries()
Normalizza serie numeriche filtrando valori non numerici:

```php
/**
 * Normalizza serie numeriche filtrando valori non numerici.
 *
 * @param array<string, mixed> $dataset
 *
 * @return array<string, mixed>
 */
private function normalizeNumericSeries(array $dataset): array
{
    if (! isset($dataset['data']) || ! is_array($dataset['data'])) {
        return $dataset;
    }

    $data = $dataset['data'];
    $normalizedData = array_filter($data, fn ($value): bool => is_numeric($value));
    $normalizedData = array_map(fn ($value): float => (float) $value, $normalizedData);

    $dataset['data'] = array_values($normalizedData);

    return $dataset;
}
```

#### normalizeColorPalette()
Normalizza palette colori garantendo `list<string>`:

```php
/**
 * Normalizza palette colori garantendo list<string>.
 *
 * @param array<string, mixed> $dataset
 *
 * @return array<string, mixed>
 */
private function normalizeColorPalette(array $dataset): array
{
    $colorKeys = ['backgroundColor', 'borderColor', 'hoverBackgroundColor', 'hoverBorderColor'];

    foreach ($colorKeys as $key) {
        if (! isset($dataset[$key])) {
            continue;
        }

        $colors = $dataset[$key];
        if (! is_array($colors)) {
            continue;
        }

        // Filtra solo stringhe valide
        $normalizedColors = array_filter($colors, fn ($color): bool => is_string($color));
        $dataset[$key] = array_values($normalizedColors);
    }

    return $dataset;
}
```

#### normalizeLabels()
Normalizza labels generando placeholder se mancanti:

```php
/**
 * Normalizza labels garantendo list<string>.
 *
 * @param array<int|string, mixed> $labels
 *
 * @return list<string>
 */
private function normalizeLabels(array $labels): array
{
    $normalized = [];
    foreach ($labels as $label) {
        if (is_string($label)) {
            $normalized[] = $label;
        } elseif (is_numeric($label)) {
            $normalized[] = (string) $label;
        }
    }

    // Genera placeholder se labels vuote
    if (empty($normalized)) {
        $maxDataPoints = $this->maxDataPoints($this->extractChartPayload($this->chartData ?? [])['datasets'] ?? []);
        $normalized = array_map(fn (int $i): string => 'Label '.($i + 1), range(0, max($maxDataPoints - 1, 0)));
    }

    return $normalized;
}
```

#### sanitizeDimension()
Sanitizza dimensioni garantendo valori interi positivi:

```php
/**
 * Sanitizza dimensioni garantendo valori interi positivi.
 *
 * @param mixed $dimension
 */
private function sanitizeDimension(mixed $dimension): int
{
    if (is_int($dimension) && $dimension > 0) {
        return $dimension;
    }

    if (is_numeric($dimension)) {
        $int = (int) $dimension;

        return max($int, 1);
    }

    return 800; // Default
}
```

### Gestione Divisioni per Zero

Pattern per evitare divisioni per zero:

```php
// ✅ CORRETTO - max(..., 1) per evitare divisione per zero
$maxValue = max($this->maxDataPoints($datasets), 1);
$barWidth = ($width - ($padding * 2)) / $maxValue;

// ✅ CORRETTO - Verifica array non vuoto prima di max()
$dataValues = array_filter($data, fn ($value): bool => is_numeric($value));
if (empty($dataValues)) {
    return 0.0;
}
$maxValue = max($dataValues);
```

### PHPDoc Completi per Array Shapes

PHPDoc espliciti per tutti i tipi di ritorno:

```php
/**
 * @param array<string, mixed> $chartData
 * @param array<string, mixed> $options
 *
 * @return array{
 *     svg_content: string,
 *     export_options: array{width: int, height: int, filename: string, title: string, includeStyles: bool},
 *     timestamp: int
 * }
 */
public function execute(array $chartData, array $options = []): array
{
    // ...
}
```

## Best Practices

1. **Queue Heavy Operations**: Use the `QueueableAction` trait for operations that might be resource-intensive.

2. **Validate Input**: Always validate chart data and options before processing.

3. **Handle Different Chart Types**: The SVG generation supports multiple chart types, but ensure you're providing the correct data structure.

4. **File Management**: Clean up temporary files and implement appropriate file retention policies.

5. **Client-Server Coordination**: For PNG export, coordinate between client-side canvas generation and server-side file saving.

6. **PHPStan Level 10 Compliance**: 
   - Usa sempre Safe functions per operazioni stringa
   - Applica type narrowing completo con `is_array()`, `isset()`, `is_numeric()`
   - Crea helper methods per ridurre complexity (< 10)
   - Documenta tutti i tipi di ritorno con PHPDoc espliciti
   - Gestisci divisioni per zero con `max(..., 1)`

7. **Complexity Reduction**:
   - Estrai logica complessa in metodi privati focalizzati
   - Ogni metodo deve avere complexity < 10
   - Ogni metodo deve essere < 20 righe (target), max 50 righe

## Error Handling

All actions include proper error handling:

- Invalid base64 data is detected and throws an exception
- Missing directories are created automatically
- File extensions are validated and corrected if necessary
- Chart data is validated before SVG generation

## Performance Considerations

- SVG generation is done server-side and can be resource-intensive for complex charts
- PNG data is typically generated client-side and sent to server for storage
- Use queuing for batch export operations
- Consider caching for frequently exported charts

These actions provide a complete solution for Chart.js export functionality while following the Laraxot framework conventions and architecture patterns.