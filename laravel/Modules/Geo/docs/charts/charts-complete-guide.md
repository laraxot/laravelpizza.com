# 📊 Charts & Visualizzazioni - Guida PTVX

> **DATA VISUALIZATION**: Sistema completo per grafici interattivi con esportazione avanzata.

---

## 🎯 **Panoramica Charts in PTVX**

Il sistema di visualizzazione dati PTVX integra:

- ✅ **Filament Charts** - Framework UI per dashboard
- ✅ **Chart.js v4** - Engine di rendering avanzato
- ✅ **Plugin Ecosystem** - Zoom, annotation, datalabels, etc.
- ✅ **Esportazione** - PNG/SVG automatica
- ✅ **Real-time Updates** - WebSocket integration
- ✅ **Caching Intelligente** - Performance ottimizzata

---

## 🏗️ **Architettura Charts**

### Componenti Core
| Componente | Responsabilità | Tecnologia |
|------------|---------------|------------|
| **ChartWidget** | UI e configurazione | Filament 4.x |
| **Chart.js Engine** | Rendering e interattività | Chart.js v4 |
| **Plugin System** | Funzionalità avanzate | Community Plugins |
| **Export Service** | Conversione formati | html2canvas/SVG |

### Workflow Completo
1. **Data Collection** → Repository/Service prepara dati
2. **Configuration** → ChartWidget definisce struttura
3. **Rendering** → Chart.js renderizza su canvas
4. **Interactivity** → Plugin gestiscono features avanzate
5. **Export** → Servizio salva in PNG/SVG per report

---

## 📊 **Filament ChartWidget Base**

### Creazione Widget
```bash
php artisan make:filament-widget AnalyticsChart --chart
```

### Implementazione Base
```php
<?php

namespace Modules\Analytics\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Vendite Mensili';
    protected ?string $color = 'success';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return Cache::remember('sales_chart', 3600, function () {
            return [
                'datasets' => [
                    [
                        'label' => 'Vendite (€)',
                        'data' => [12000, 15000, 18000, 22000],
                        'borderColor' => '#10B981',
                        'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                        'tension' => 0.4,
                        'fill' => true,
                    ],
                ],
                'labels' => ['Gen', 'Feb', 'Mar', 'Apr'],
            ];
        });
    }
}
```

---

## 🔌 **Plugin Chart.js Avanzati**

### 1. **Zoom Plugin** - Navigazione interattiva
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'zoom' => [
                'zoom' => [
                    'wheel' => ['enabled' => true],
                    'pinch' => ['enabled' => true],
                    'mode' => 'xy',
                ],
                'pan' => [
                    'enabled' => true,
                    'mode' => 'xy',
                ],
            ],
        ],
    ];
}
```

### 2. **Annotation Plugin** - Linee e marker
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'annotation' => [
                'annotations' => [
                    'target' => [
                        'type' => 'line',
                        'yMin' => 20000,
                        'yMax' => 20000,
                        'borderColor' => 'red',
                        'borderWidth' => 2,
                        'label' => [
                            'content' => 'Target €20k',
                            'enabled' => true,
                        ],
                    ],
                    'zone' => [
                        'type' => 'box',
                        'xMin' => 1,
                        'xMax' => 3,
                        'backgroundColor' => 'rgba(255, 0, 0, 0.1)',
                    ],
                ],
            ],
        ],
    ];
}
```

### 3. **Datalabels Plugin** - Etichette sui dati
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'color' => 'white',
                'font' => ['weight' => 'bold'],
                'formatter' => "function(value) { return value + '€'; }",
                'anchor' => 'end',
                'align' => 'top',
            ],
        ],
    ];
}
```

### 4. **Autocolors Plugin** - Colori automatici
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'autocolors' => [
                'mode' => 'dataset', // o 'data'
                'enabled' => true,
            ],
        ],
    ];
}
```

---

## 💾 **Esportazione Chart - Metodi Implementativi**

### Metodo 1: Client-Side con html2canvas (PNG)
```php
<?php

namespace Modules\Analytics\Services;

use Illuminate\Support\Str;

class ChartExportService
{
    /**
     * Genera JavaScript per esportazione PNG
     */
    public function exportToPng(string $chartId, string $filename = null): string
    {
        $filename = $filename ?: 'chart_' . Str::uuid() . '.png';

        return "
            html2canvas(document.querySelector('#{$chartId} canvas'), {
                backgroundColor: '#ffffff',
                scale: 2, // Risoluzione alta
                logging: false,
                useCORS: true,
                allowTaint: false
            }).then(function(canvas) {
                var link = document.createElement('a');
                link.download = '{$filename}';
                link.href = canvas.toDataURL('image/png');
                link.click();
                
                // Cleanup
                setTimeout(() => URL.revokeObjectURL(link.href), 100);
            }).catch(function(error) {
                console.error('Chart export failed:', error);
            });
        ";
    }

    /**
     * Salva PNG su filesystem per report
     */
    public function savePngToStorage(string $chartId, string $path): bool
    {
        try {
            // Implementazione server-side con Puppeteer o Playwright
            $imageData = $this->captureChartWithBrowser($chartId);
            $imageData = str_replace('data:image/png;base64,', '', $imageData);

            \Storage::put($path, base64_decode($imageData));

            return true;
        } catch (\Exception $e) {
            \Log::error('PNG export failed', [
                'chart_id' => $chartId,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
```

### Metodo 2: SVG Export Nativo
```php
<?php

namespace Modules\Analytics\Services;

class ChartSvgExportService
{
    /**
     * Esporta come SVG usando canvg o simili
     */
    public function exportToSvg(string $chartId, string $filename = null): string
    {
        $filename = $filename ?: 'chart_' . Str::uuid() . '.svg';

        return "
            // Usa canvg per convertire canvas a SVG
            var canvas = document.querySelector('#{$chartId} canvas');
            var ctx = canvas.getContext('2d');
            
            // Crea SVG context
            var svgContext = new C2S(canvas.width, canvas.height);
            
            // Copia tutto il contenuto
            svgContext.drawImage(canvas, 0, 0);
            
            var svgData = svgContext.getSerializedSvg(true);
            
            var link = document.createElement('a');
            link.download = '{$filename}';
            link.href = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgData);
            link.click();
        ";
    }

    /**
     * Genera SVG direttamente dai dati (server-side)
     */
    public function generateSvgFromData(array $chartData, array $options = []): string
    {
        // Implementazione con librerie Node.js o PHP
        // Placeholder per ora
        $svgTemplate = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="400"><!-- Chart SVG --></svg>';

        return $svgTemplate;
    }
}
```

### Metodo 3: Hybrid Approach (Raccomandato)
```php
<?php

namespace Modules\Analytics\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AdvancedChartExportService
{
    public function __construct(
        private ChartExportService $pngService,
        private ChartSvgExportService $svgService
    ) {}

    /**
     * Esporta in multiple formats
     */
    public function exportChart(string $chartId, array $formats = ['png', 'svg']): array
    {
        $exports = [];

        foreach ($formats as $format) {
            $method = 'exportTo' . ucfirst($format);
            if (method_exists($this->{$format . 'Service'}, $method)) {
                $exports[$format] = [
                    'filename' => "chart_{$chartId}_" . now()->format('Y-m-d_H-i-s') . ".{$format}",
                    'js_code' => $this->{$format . 'Service'}->{$method}($chartId),
                ];
            }
        }

        return $exports;
    }

    /**
     * Salva chart per report automatici
     */
    public function saveChartForReport(string $chartId, string $reportId): array
    {
        $cacheKey = "chart_export_{$chartId}_{$reportId}";

        return Cache::remember($cacheKey, 3600, function () use ($chartId, $reportId) {
            $basePath = "reports/{$reportId}/charts";

            return [
                'png_saved' => $this->pngService->savePngToStorage($chartId, "{$basePath}/chart.png"),
                'svg_generated' => $this->svgService->generateSvgFromData($this->getChartData($chartId)),
                'exported_at' => now(),
                'cache_key' => $cacheKey,
            ];
        });
    }

    /**
     * Batch export per dashboard completi
     */
    public function exportDashboardCharts(array $chartIds, string $dashboardId): array
    {
        $results = [];

        foreach ($chartIds as $chartId) {
            $results[$chartId] = $this->saveChartForReport($chartId, $dashboardId);
        }

        return $results;
    }

    private function getChartData(string $chartId): array
    {
        // Recupera configurazione chart dal database/cache
        return Cache::get("chart_config_{$chartId}", []);
    }
}
```

---

## 🎨 **Chart Types Avanzati**

### Mixed Charts (Multi-tipo)
```php
protected function getData(): array
{
    return [
        'datasets' => [
            [
                'type' => 'line',
                'label' => 'Trend',
                'data' => [10, 20, 30, 40, 50],
                'borderColor' => '#3B82F6',
                'yAxisID' => 'y',
            ],
            [
                'type' => 'bar',
                'label' => 'Valori',
                'data' => [15, 25, 35, 45, 55],
                'backgroundColor' => '#10B981',
                'yAxisID' => 'y1',
            ],
        ],
        'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag'],
    ];
}

protected function getOptions(): array
{
    return [
        'scales' => [
            'y' => [
                'type' => 'linear',
                'position' => 'left',
            ],
            'y1' => [
                'type' => 'linear',
                'position' => 'right',
                'grid' => ['drawOnChartArea' => false],
            ],
        ],
    ];
}
```

### Real-time Charts
```php
public function mount(): void
{
    $this->chartData = $this->getData();
    $this->poll('updateChartData'); // Aggiorna ogni 30 secondi
}

public function updateChartData(): void
{
    $this->chartData = $this->getData();
    $this->dispatch('chart-updated', data: $this->chartData);
}

protected function getOptions(): array
{
    return [
        'animation' => [
            'duration' => 500, // Animazioni più veloci per real-time
        ],
        'plugins' => [
            'streaming' => [
                'frameRate' => 30,
            ],
        ],
    ];
}
```

### Charts con Filtri Dinamici
```php
public ?string $timeRange = 'month';

protected function getFilters(): ?array
{
    return [
        'day' => 'Oggi',
        'week' => 'Questa settimana',
        'month' => 'Questo mese',
        'year' => 'Quest\'anno',
    ];
}

protected function getData(): array
{
    $query = match($this->filter) {
        'day' => Trend::model(Sale::class)->between(now()->startOfDay(), now()->endOfDay()),
        'week' => Trend::model(Sale::class)->between(now()->startOfWeek(), now()->endOfWeek()),
        'month' => Trend::model(Sale::class)->between(now()->startOfMonth(), now()->endOfMonth()),
        'year' => Trend::model(Sale::class)->between(now()->startOfYear(), now()->endOfYear()),
        default => Trend::model(Sale::class)->between(now()->startOfMonth(), now()->endOfMonth()),
    };

    $data = $query->perDay()->sum('amount');

    return [
        'datasets' => [
            [
                'label' => 'Vendite (€)',
                'data' => $data->map(fn($value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn($value) => $value->date),
    ];
}
```

---

## 🔧 **Integrazione con Filament Actions**

### Chart Widget con Esportazione
```php
<?php

namespace Modules\Analytics\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Actions\Action;
use Modules\Analytics\Services\AdvancedChartExportService;

class ExportableChart extends ChartWidget
{
    protected static ?string $heading = 'Chart con Esportazione';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_png')
                ->label('Esporta PNG')
                ->icon('heroicon-o-photo')
                ->color('success')
                ->action(function () {
                    $exportService = app(AdvancedChartExportService::class);
                    $exports = $exportService->exportChart($this->getId(), ['png']);

                    $this->js($exports['png']['js_code']);
                }),

            Action::make('export_svg')
                ->label('Esporta SVG')
                ->icon('heroicon-o-document')
                ->color('info')
                ->action(function () {
                    $exportService = app(AdvancedChartExportService::class);
                    $exports = $exportService->exportChart($this->getId(), ['svg']);

                    $this->js($exports['svg']['js_code']);
                }),

            Action::make('export_both')
                ->label('Esporta Entrambi')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->action(function () {
                    $exportService = app(AdvancedChartExportService::class);
                    $exports = $exportService->exportChart($this->getId(), ['png', 'svg']);

                    $this->js($exports['png']['js_code']);
                    // Nota: SVG richiede implementazione separata
                }),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Performance',
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
            ],
            'labels' => ['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'zoom' => [
                    'zoom' => [
                        'wheel' => ['enabled' => true],
                        'mode' => 'xy',
                    ],
                ],
                'annotation' => [
                    'annotations' => [
                        'goal' => [
                            'type' => 'line',
                            'yMin' => 70,
                            'yMax' => 70,
                            'borderColor' => '#10B981',
                            'borderWidth' => 2,
                            'label' => [
                                'content' => 'Target 70%',
                                'enabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
```

---

## 🚀 **Performance & Ottimizzazioni**

### Caching Strategico
```php
protected function getData(): array
{
    $cacheKey = 'chart_' . $this->getType() . '_' . $this->filter;

    return Cache::remember($cacheKey, 1800, function () {
        return $this->fetchChartData();
    });
}
```

### Lazy Loading per Chart Pesanti
```php
public $chartLoaded = false;

public function loadChart(): void
{
    $this->chartLoaded = true;
    $this->chartData = $this->getData();
}
```

### Decimation per Dataset Grandi
```php
protected function getOptions(): array
{
    return [
        'plugins' => [
            'decimation' => [
                'enabled' => true,
                'algorithm' => 'lttb', // Largest Triangle Three Bucket
                'samples' => 100, // Limita punti visualizzati
            ],
        ],
    ];
}
```

---

## 🐛 **Troubleshooting**

### Chart Non Si Carica
```php
// Forza dimensioni specifiche
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'width' => 800,
        'height' => 400,
    ];
}
```

### Plugin Non Funziona
```javascript
// Verifica registrazione plugin (resources/js/app.js)
import zoomPlugin from 'chartjs-plugin-zoom';
import annotationPlugin from 'chartjs-plugin-annotation';
import datalabelsPlugin from 'chartjs-plugin-datalabels';

Chart.register(zoomPlugin, annotationPlugin, datalabelsPlugin);
```

### Esportazione Fallisce
```php
// Debug esportazione
public function debugExport(string $chartId): array
{
    return [
        'chart_exists' => !empty(document.querySelector("#{$chartId} canvas")),
        'canvas_dimensions' => [
            'width' => "canvas.width",
            'height' => "canvas.height"
        ],
        'timestamp' => now(),
    ];
}
```

---

## 📚 **Risorse e Documentazione**

### Documentazione Ufficiale
- **[Filament Charts](https://filamentphp.com/docs/4.x/widgets/charts)** - Guida base Filament
- **[Chart.js v4](https://www.chartjs.org/docs/latest/)** - Documentazione completa
- **[Awesome Chart.js](https://github.com/chartjs/awesome)** - Lista plugin

### Plugin Principali
- **[Zoom Plugin](https://www.chartjs.org/chartjs-plugin-zoom/latest/)** - Zoom e pan
- **[Annotation Plugin](https://www.chartjs.org/chartjs-plugin-annotation/latest/)** - Linee e marker
- **[Datalabels Plugin](https://chartjs-plugin-datalabels.netlify.app/)** - Etichette dati

### Esempi Implementazione
- **[Chart.js Samples](https://www.chartjs.org/docs/latest/samples/)** - Esempi interattivi
- **[Filament Examples](https://filamentphp.com/docs/4.x/widgets/charts#generating-chart-data-from-an-eloquent-model)** - Integrazione Eloquent

---

**🎯 Charts PTVX: Visualizzazioni avanzate con esportazione professionale!**

**🚀 Framework completo per dashboard interattivi e report esportabili!**

---

*Documentazione Charts - Giugno 2025*
