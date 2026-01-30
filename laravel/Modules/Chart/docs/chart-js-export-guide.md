# Chart.js - Guida Export PNG/SVG/PDF

## 📋 Indice
1. [Introduzione](#introduzione)
2. [Setup Chart.js](#setup-chartjs)
3. [Export Client-Side (Browser)](#export-client-side-browser)
4. [Export Server-Side (Node.js/Puppeteer)](#export-server-side-nodejspuppeteer)
5. [Integration con Laravel/Livewire](#integration-con-laravellivewire)
6. [Export SVG da Chart.js](#export-svg-da-chartjs)
7. [Best Practices](#best-practices)
8. [Esempi Pratici](#esempi-pratici)
9. [Troubleshooting](#troubleshooting)

---

## Introduzione

**Chart.js** è una libreria JavaScript per grafici interattivi nel browser. Per incorporare i grafici Chart.js nei PDF server-side (Spipu), ci sono **due approcci principali**:

### Approccio 1: Client-Side Export
```
Browser → Chart.js → Canvas → PNG/Base64 → Backend → PDF
```

### Approccio 2: Server-Side Rendering
```
Backend → Puppeteer/Headless Browser → Chart.js → PNG → PDF
```

---

## Setup Chart.js

### Installazione

Il modulo Quaeris ha già Chart.js installato:

```json
// Modules/Quaeris/package.json
{
  "devDependencies": {
    "chart.js": "^4.4.3",
    "chartjs-plugin-datalabels": "^2.2.0"
  }
}
```

```bash
cd Modules/Quaeris
npm install
```

### Setup Base HTML

```html
<!DOCTYPE html>
<html>
<head>
    <title>Chart.js Demo</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.js"></script>
</head>
<body>
    <div style="width: 700px; height: 400px;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag'],
                datasets: [{
                    label: 'Vendite 2024',
                    data: [65, 59, 80, 81, 56],
                    backgroundColor: '#3B82F6',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    </script>
</body>
</html>
```

---

## Export Client-Side (Browser)

### Metodo 1: Canvas.toDataURL() - PNG

```javascript
/**
 * Esporta Chart.js in PNG Base64
 *
 * @param {Chart} chartInstance - Istanza Chart.js
 * @param {string} format - 'image/png' o 'image/jpeg'
 * @param {number} quality - 0.0 - 1.0 (solo per JPEG)
 * @returns {string} - Data URL base64
 */
function exportChartToPNG(chartInstance, format = 'image/png', quality = 1.0) {
    // Chart.js fornisce metodo helper
    return chartInstance.toBase64Image(format, quality);
}

// Uso
const chart = new Chart(ctx, config);
const base64 = exportChartToPNG(chart);

console.log(base64);
// Output: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA..."
```

### Metodo 2: Blob per Download Diretto

```javascript
/**
 * Scarica grafico come PNG
 *
 * @param {Chart} chartInstance - Istanza Chart.js
 * @param {string} filename - Nome file
 */
function downloadChartAsPNG(chartInstance, filename = 'chart.png') {
    const canvas = chartInstance.canvas;

    canvas.toBlob(function(blob) {
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.download = filename;
        link.href = url;
        link.click();

        // Cleanup
        URL.revokeObjectURL(url);
    });
}

// Uso
const chart = new Chart(ctx, config);
downloadChartAsPNG(chart, 'vendite-2024.png');
```

### Metodo 3: Export ad Alta Risoluzione

```javascript
/**
 * Export chart in alta risoluzione (per stampa)
 *
 * @param {Chart} chartInstance - Istanza Chart.js
 * @param {number} scale - Moltiplicatore risoluzione (2x, 3x, etc.)
 * @returns {string} - Base64 HD
 */
function exportChartHD(chartInstance, scale = 2) {
    const canvas = chartInstance.canvas;

    // Crea canvas temporaneo ad alta risoluzione
    const tempCanvas = document.createElement('canvas');
    const tempCtx = tempCanvas.getContext('2d');

    // Dimensioni scalate
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    // Scala contesto
    tempCtx.scale(scale, scale);

    // Ridisegna chart su canvas HD
    // (Richiede ricreazione chart - vedi esempio completo sotto)
    const hdChart = new Chart(tempCtx, chartInstance.config);

    // Aspetta rendering
    return new Promise((resolve) => {
        setTimeout(() => {
            const base64 = tempCanvas.toDataURL('image/png', 1.0);
            hdChart.destroy();
            resolve(base64);
        }, 100);
    });
}

// Uso
const chart = new Chart(ctx, config);
const hdBase64 = await exportChartHD(chart, 3); // 3x risoluzione
```

### Service JavaScript Completo

```javascript
// resources/js/services/chart-export-service.js

class ChartExportService {
    /**
     * Export chart to PNG base64
     */
    toPNG(chart, quality = 1.0) {
        return chart.toBase64Image('image/png', quality);
    }

    /**
     * Export chart to JPEG base64
     */
    toJPEG(chart, quality = 0.95) {
        return chart.toBase64Image('image/jpeg', quality);
    }

    /**
     * Download chart as file
     */
    download(chart, filename, format = 'png', quality = 1.0) {
        const mimeType = format === 'png' ? 'image/png' : 'image/jpeg';
        const canvas = chart.canvas;

        canvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.download = `${filename}.${format}`;
            link.href = url;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }, mimeType, quality);
    }

    /**
     * Send chart to backend for PDF generation
     */
    async sendToBackend(chart, endpoint = '/api/charts/save') {
        const base64 = this.toPNG(chart);

        // Rimuovi prefisso "data:image/png;base64,"
        const base64Data = base64.split(',')[1];

        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                chart_base64: base64Data,
                chart_config: chart.config,
            }),
        });

        return await response.json();
    }

    /**
     * Export multiple charts
     */
    async exportMultiple(charts, filename = 'charts.zip') {
        const exports = await Promise.all(
            charts.map((chart, index) => ({
                name: `chart-${index + 1}.png`,
                data: this.toPNG(chart),
            }))
        );

        // Invia a backend per creare ZIP
        return await fetch('/api/charts/export-multiple', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ exports, filename }),
        });
    }
}

// Export globale
window.ChartExportService = new ChartExportService();
```

### Integrazione con Blade/Livewire

```blade
{{-- resources/views/charts/interactive-chart.blade.php --}}
<div class="chart-wrapper" x-data="chartComponent()">
    <div style="position: relative; height: 400px;">
        <canvas id="chart-{{ $chartId }}"></canvas>
    </div>

    <div class="chart-controls" style="margin-top: 15px; text-align: center;">
        <button @click="downloadPNG()" class="btn btn-primary">
            Download PNG
        </button>
        <button @click="downloadJPEG()" class="btn btn-secondary">
            Download JPEG
        </button>
        <button @click="sendToBackend()" class="btn btn-success">
            Salva nel Report
        </button>
    </div>
</div>

@push('scripts')
<script>
function chartComponent() {
    return {
        chart: null,

        init() {
            const ctx = document.getElementById('chart-{{ $chartId }}').getContext('2d');
            this.chart = new Chart(ctx, @json($chartConfig));
        },

        downloadPNG() {
            window.ChartExportService.download(this.chart, 'chart-{{ $chartId }}', 'png');
        },

        downloadJPEG() {
            window.ChartExportService.download(this.chart, 'chart-{{ $chartId }}', 'jpeg', 0.95);
        },

        async sendToBackend() {
            try {
                const result = await window.ChartExportService.sendToBackend(this.chart);
                alert('Chart salvato con successo!');
            } catch (error) {
                alert('Errore nel salvataggio: ' + error.message);
            }
        }
    }
}
</script>
@endpush
```

### Backend Handler (Laravel)

```php
<?php

// routes/api.php
Route::post('/charts/save', [ChartController::class, 'saveChart']);

// app/Http/Controllers/ChartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChartController extends Controller
{
    public function saveChart(Request $request)
    {
        $validated = $request->validate([
            'chart_base64' => 'required|string',
            'chart_config' => 'nullable|array',
        ]);

        // Decodifica base64
        $imageData = base64_decode($validated['chart_base64']);

        // Genera filename unico
        $filename = 'charts/chart-' . uniqid() . '.png';

        // Salva su storage
        Storage::disk('public')->put($filename, $imageData);

        // Ritorna path per uso futuro
        return response()->json([
            'success' => true,
            'path' => Storage::disk('public')->path($filename),
            'url' => Storage::disk('public')->url($filename),
        ]);
    }
}
```

---

## Export Server-Side (Node.js/Puppeteer)

Per generare grafici Chart.js **completamente server-side** (senza interazione utente), usa **Puppeteer** o **node-canvas**.

### Setup Puppeteer (Raccomandato)

```bash
composer require spatie/browsershot
```

```bash
npm install puppeteer
```

### Action: Chart.js → PNG Server-Side

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Spatie\Browsershot\Browsershot;
use Spatie\QueueableAction\QueueableAction;

class RenderChartJsAction
{
    use QueueableAction;

    /**
     * Renderizza Chart.js server-side e ritorna PNG base64
     *
     * @param array $chartConfig Configurazione Chart.js
     * @param int $width Larghezza canvas
     * @param int $height Altezza canvas
     * @return string Base64 encoded PNG
     */
    public function execute(array $chartConfig, int $width = 700, int $height = 400): string
    {
        // Crea HTML temporaneo con Chart.js
        $html = $this->createChartHtml($chartConfig, $width, $height);

        // Renderizza con Puppeteer via Browsershot
        $png = Browsershot::html($html)
            ->setScreenshotType('png')
            ->windowSize($width, $height)
            ->setDelay(500) // Aspetta rendering
            ->screenshot();

        return base64_encode($png);
    }

    /**
     * Crea HTML standalone con Chart.js
     */
    private function createChartHtml(array $chartConfig, int $width, int $height): string
    {
        $configJson = json_encode($chartConfig, JSON_UNESCAPED_UNICODE);

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: white;
        }
        #chart-container {
            width: {$width}px;
            height: {$height}px;
        }
    </style>
</head>
<body>
    <div id="chart-container">
        <canvas id="chart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const config = {$configJson};
        new Chart(ctx, config);
    </script>
</body>
</html>
HTML;
    }

    /**
     * Versione ottimizzata con caching
     */
    public function executeWithCache(array $chartConfig, string $cacheKey, int $ttl = 3600): string
    {
        return \Cache::remember($cacheKey, $ttl, function () use ($chartConfig) {
            return $this->execute($chartConfig);
        });
    }
}
```

### Uso in Survey Report

```php
use Modules\Chart\Actions\RenderChartJsAction;

// Configurazione Chart.js
$chartConfig = [
    'type' => 'bar',
    'data' => [
        'labels' => ['Opzione A', 'Opzione B', 'Opzione C'],
        'datasets' => [[
            'label' => 'Risposte',
            'data' => [65, 78, 45],
            'backgroundColor' => '#3B82F6',
        ]],
    ],
    'options' => [
        'responsive' => true,
        'plugins' => [
            'title' => [
                'display' => true,
                'text' => 'Distribuzione Risposte',
            ],
        ],
    ],
];

// Genera PNG server-side
$base64 = app(RenderChartJsAction::class)->execute($chartConfig, 700, 400);

// Usa in PDF
$charts[] = [
    'title' => 'Domanda 1',
    'base64' => $base64,
];
```

---

## Integration con Laravel/Livewire

### Livewire Component con Chart.js

```php
<?php

namespace App\Livewire;

use Livewire\Component;

class InteractiveChart extends Component
{
    public $chartData;
    public $chartConfig;

    public function mount($data)
    {
        $this->chartData = $data;
        $this->chartConfig = $this->buildChartConfig($data);
    }

    public function exportToPdf()
    {
        // Riceve base64 da frontend via evento
        $this->dispatch('export-chart-to-pdf');
    }

    private function buildChartConfig($data)
    {
        return [
            'type' => 'bar',
            'data' => [
                'labels' => $data['labels'],
                'datasets' => [[
                    'label' => $data['label'],
                    'data' => $data['values'],
                    'backgroundColor' => '#3B82F6',
                ]],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.interactive-chart');
    }
}
```

```blade
{{-- resources/views/livewire/interactive-chart.blade.php --}}
<div
    x-data="{ chart: null }"
    x-init="
        const ctx = $refs.canvas.getContext('2d');
        chart = new Chart(ctx, @js($chartConfig));

        // Ascolta evento export
        $wire.on('export-chart-to-pdf', () => {
            const base64 = chart.toBase64Image();
            $wire.call('handleExport', base64);
        });
    "
>
    <div style="position: relative; height: 400px;">
        <canvas x-ref="canvas"></canvas>
    </div>

    <button wire:click="exportToPdf" class="btn btn-primary mt-3">
        Esporta in PDF
    </button>
</div>
```

---

## Export SVG da Chart.js

⚠️ **Nota:** Chart.js **non supporta nativamente SVG**. Usa una di queste alternative:

### Opzione 1: chart.js-to-svg (Plugin)

```bash
npm install chart.js-to-svg
```

```javascript
import { toSVG } from 'chart.js-to-svg';

// Converti Chart.js in SVG
const svg = toSVG(chartInstance);

// Download SVG
const blob = new Blob([svg], { type: 'image/svg+xml' });
const url = URL.createObjectURL(blob);
const link = document.createElement('a');
link.href = url;
link.download = 'chart.svg';
link.click();
```

### Opzione 2: Canvas to SVG Conversion

```javascript
/**
 * Converti canvas Chart.js in SVG (approssimato)
 * Nota: Qualità inferiore rispetto a SVG nativo
 */
function canvasToSVG(canvas) {
    const dataURL = canvas.toDataURL('image/png');
    const width = canvas.width;
    const height = canvas.height;

    return `
        <svg xmlns="http://www.w3.org/2000/svg"
             width="${width}"
             height="${height}">
            <image href="${dataURL}"
                   width="${width}"
                   height="${height}" />
        </svg>
    `;
}

// Uso
const svg = canvasToSVG(chart.canvas);
```

### Opzione 3: Usa JPGraph per SVG

Se serve **vero SVG vettoriale**, meglio usare JPGraph server-side (vedi `jpgraph-step-by-step-guide.md`).

---

## Best Practices

### 1. Performance Client-Side

```javascript
// ✅ BUONO: Esporta solo quando necessario
button.addEventListener('click', () => {
    const base64 = chart.toBase64Image();
    sendToBackend(base64);
});

// ❌ CATTIVO: Export continuo
setInterval(() => {
    const base64 = chart.toBase64Image(); // Spreco risorse!
}, 1000);
```

### 2. Qualità Export

```javascript
// ✅ BUONO: Alta qualità per PDF
const base64 = chart.toBase64Image('image/png', 1.0); // Qualità massima

// ✅ BUONO: Comprimi per web
const base64 = chart.toBase64Image('image/jpeg', 0.8); // Compromesso

// ❌ CATTIVO: Qualità troppo bassa
const base64 = chart.toBase64Image('image/jpeg', 0.3); // Pixelato!
```

### 3. Caching Server-Side

```php
// ✅ BUONO: Cache renderizzazioni Puppeteer
$cacheKey = 'chart-' . md5(json_encode($chartConfig));

$base64 = Cache::remember($cacheKey, 3600, function () use ($chartConfig) {
    return app(RenderChartJsAction::class)->execute($chartConfig);
});

// ❌ CATTIVO: Sempre re-render
$base64 = app(RenderChartJsAction::class)->execute($chartConfig);
```

### 4. Gestione Memoria

```javascript
// ✅ BUONO: Cleanup dopo export
async function exportAndCleanup(chart) {
    const base64 = chart.toBase64Image();
    await sendToBackend(base64);

    chart.destroy(); // Libera memoria
}

// ❌ CATTIVO: Memory leak con molti grafici
charts.forEach(chart => {
    exportChart(chart); // Chart mai distrutto!
});
```

---

## Esempi Pratici

### Esempio 1: Export Multipli Grafici

```javascript
// Frontend: Export batch di grafici
async function exportAllCharts() {
    const charts = [chart1, chart2, chart3];

    const exports = charts.map((chart, index) => ({
        id: `chart-${index + 1}`,
        base64: chart.toBase64Image('image/png', 1.0).split(',')[1],
        config: chart.config,
    }));

    // Invia a backend
    const response = await fetch('/api/charts/generate-pdf', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ charts: exports }),
    });

    // Scarica PDF
    const blob = await response.blob();
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'report-completo.pdf';
    link.click();
}
```

```php
// Backend: Genera PDF da multipli base64
Route::post('/api/charts/generate-pdf', function (Request $request) {
    $charts = $request->input('charts');

    // Decodifica e prepara per PDF
    $chartData = collect($charts)->map(function ($chart) {
        return [
            'title' => "Grafico {$chart['id']}",
            'base64' => $chart['base64'],
        ];
    })->all();

    // Genera PDF
    $html = view('pdf.charts-report', ['charts' => $chartData])->render();

    return app(SpipuPdfByHtmlAction::class)->execute(
        html: $html,
        filename: 'charts-report.pdf',
        out: 'download',
    );
});
```

### Esempio 2: Real-Time Chart con Export

```blade
{{-- Survey real-time con auto-export --}}
<div x-data="liveChartComponent()" x-init="init()">
    <div style="height: 400px;">
        <canvas x-ref="canvas"></canvas>
    </div>

    <div class="controls">
        <button @click="refreshData()" class="btn btn-secondary">
            Aggiorna Dati
        </button>
        <button @click="exportToPDF()" class="btn btn-primary">
            Esporta PDF
        </button>
    </div>
</div>

<script>
function liveChartComponent() {
    return {
        chart: null,
        pollInterval: null,

        init() {
            // Crea grafico iniziale
            this.createChart();

            // Auto-refresh ogni 30 secondi
            this.pollInterval = setInterval(() => {
                this.refreshData();
            }, 30000);
        },

        createChart() {
            const ctx = this.$refs.canvas.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Risposte Real-Time',
                        data: [],
                        borderColor: '#3B82F6',
                        tension: 0.1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        },

        async refreshData() {
            // Fetch nuovi dati
            const response = await fetch('/api/survey/stats');
            const data = await response.json();

            // Aggiorna grafico
            this.chart.data.labels = data.labels;
            this.chart.data.datasets[0].data = data.values;
            this.chart.update();
        },

        async exportToPDF() {
            const base64 = this.chart.toBase64Image('image/png', 1.0).split(',')[1];

            const response = await fetch('/api/charts/export-pdf', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ chart_base64: base64 }),
            });

            const blob = await response.blob();
            const url = URL.createObjectURL(blob);
            window.open(url, '_blank');
        },

        destroy() {
            clearInterval(this.pollInterval);
            if (this.chart) {
                this.chart.destroy();
            }
        }
    }
}
</script>
```

---

## Troubleshooting

### Problema 1: Chart Non Si Esporta

**Sintomo:** `toBase64Image()` ritorna stringa vuota o errore

**Causa:** Chart non completamente renderizzato

**Soluzione:**

```javascript
// ✅ Aspetta rendering completo
setTimeout(() => {
    const base64 = chart.toBase64Image();
    console.log(base64);
}, 100);

// ✅ Usa callback Chart.js
const chart = new Chart(ctx, {
    ...config,
    options: {
        ...config.options,
        animation: {
            onComplete: () => {
                const base64 = chart.toBase64Image();
                // Export qui
            }
        }
    }
});
```

### Problema 2: Qualità Bassa

**Sintomo:** Immagine pixelata o sfocata

**Soluzione:**

```javascript
// ✅ Aumenta risoluzione device pixel ratio
const canvas = chart.canvas;
const dpr = window.devicePixelRatio || 1;

canvas.width = 700 * dpr;
canvas.height = 400 * dpr;
canvas.style.width = '700px';
canvas.style.height = '400px';

const ctx = canvas.getContext('2d');
ctx.scale(dpr, dpr);

// Ricrea chart
const chart = new Chart(ctx, config);
```

### Problema 3: CORS Error con Puppeteer

**Sintomo:** Browsershot fallisce con errore CORS

**Soluzione:**

```php
// ✅ Usa HTML inline (no URL esterni)
$html = $this->createChartHtml($chartConfig);

Browsershot::html($html) // Non ::url()
    ->setScreenshotType('png')
    ->screenshot();

// ✅ Se devi usare URL, abilita CORS
Browsershot::url($url)
    ->setOption('args', ['--disable-web-security'])
    ->screenshot();
```

---

## Riferimenti

- [Chart.js Official Docs](https://www.chartjs.org/docs/latest/)
- [Spatie Browsershot](https://github.com/spatie/browsershot)
- [jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md)
- [spipu-pdf-charts-embedding-guide.md](../../Quaeris/docs/spipu-pdf-charts-embedding-guide.md)

---

*Guida Chart.js Export v1.0 - Creato: 2025-11-17*
*Modulo Chart - Architettura Laraxot*
