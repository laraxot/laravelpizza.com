# Chart.js Export SVG/PNG - Guida Passo-Passo Completa

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Completa e Pratica  
**Versione**: 3.0.0 - Implementazione Filament Actions

## ⚠️ IMPORTANTE: Architettura Filament

**CRITICO**: Questo progetto usa **SOLO Filament Actions**, NON controller o rotte custom.

- ✅ **Actions**: `SaveChartJsPngAction`, `SaveChartJsSvgAction` (Spatie QueueableActions)
- ✅ **Widget**: `QuestionChartItemWidget` con metodi Livewire
- ✅ **View**: Template Blade custom con JavaScript Alpine.js
- ❌ **NO Controller**: Non creare controller per export
- ❌ **NO Routes**: Non aggiungere rotte in `web.php` o `api.php`

## 📋 Panoramica

Questa guida documenta passo-passo come esportare grafici Chart.js in formato SVG e PNG, sia lato client (JavaScript) che lato server (PHP), con esempi pratici basati sul codice esistente del progetto.

---

## 🎯 Architettura Chart.js nel Progetto

### Flusso Completo

```
Backend (PHP)
    ↓
AnswersChartData DTO
    ├─→ getChartJsType() → 'bar', 'doughnut', 'line'
    ├─→ getChartJsData() → { datasets: [...], labels: [...] }
    └─→ getChartJsOptionsArray() → { plugins: {...}, ... }
    ↓
Frontend (Blade/Livewire)
    ├─→ QuestionChart Livewire Component
    ├─→ ChartColumn Blade Component
    └─→ Canvas Element con Chart.js
    ↓
Export (Client o Server)
    ├─→ PNG (Canvas toBlob / Server-side)
    └─→ SVG (Canvas to SVG / Server-side)
```

---

## 📊 Parte 1: Preparazione Dati Backend

### 1.1 Creazione AnswersChartData

**File**: `Modules/Chart/app/Datas/AnswersChartData.php`

**Step 1**: Prepara i dati delle risposte

```php
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;

// Dati risposte (esempio)
$answers = collect([
    ['label' => 'Opzione A', 'value' => 10, 'avg' => 25.5],
    ['label' => 'Opzione B', 'value' => 20, 'avg' => 50.0],
    ['label' => 'Opzione C', 'value' => 10, 'avg' => 24.5],
]);

// Configurazione grafico
$chartData = ChartData::from([
    'type' => 'bar',
    'width' => 800,
    'height' => 600,
    'list_color' => '#3B82F6,#10B981,#F59E0B',
    // ... altre configurazioni
]);

// Crea AnswersChartData
$answersChartData = AnswersChartData::from([
    'answers' => $answers,
    'chart' => $chartData,
    'title' => 'Titolo Grafico',
    'footer' => 'Footer Grafico',
]);
```

**Step 2**: Ottieni configurazione Chart.js

```php
// Tipo grafico Chart.js
$chartJsType = $answersChartData->getChartJsType();
// 'bar', 'doughnut', 'line', ecc.

// Dati Chart.js
$chartJsData = $answersChartData->getChartJsData();
// {
//     datasets: [
//         {
//             label: 'Dati',
//             data: [10, 20, 10],
//             backgroundColor: ['rgba(59, 130, 246, 0.5)', ...],
//             borderColor: ['rgba(59, 130, 246, 0.5)', ...]
//         }
//     ],
//     labels: ['Opzione A', 'Opzione B', 'Opzione C']
// }

// Opzioni Chart.js
$chartJsOptions = $answersChartData->getChartJsOptionsArray();
// {
//     plugins: {
//         title: { display: true, text: 'Titolo Grafico' }
//     },
//     responsive: true,
//     maintainAspectRatio: false
// }
```

**Step 3**: Configurazione completa per Chart.js

```php
$chartConfig = [
    'type' => $chartJsType,
    'data' => $chartJsData,
    'options' => $chartJsOptions,
];

// JSON per frontend
$chartConfigJson = json_encode($chartConfig, JSON_PRETTY_PRINT);
```

---

## 🎨 Parte 2: Rendering Frontend

### 2.1 Setup Canvas HTML

**File**: `Modules/Chart/resources/views/tables/columns/chart-column.blade.php`

**Step 1**: Crea elemento canvas

```blade
<div x-data="chart({
    cachedData: @js($obj->getCachedData()),
    options: @js($obj->getOptions()),
    type: @js($obj->getType()),
})">
    <canvas x-ref="canvas" id="chart-{{ $uniqueId }}"></canvas>
</div>
```

**Step 2**: Inizializza Chart.js

```javascript
// In Alpine.js component o script separato
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('chart-{{ $uniqueId }}');
    const ctx = canvas.getContext('2d');
    
    const chartConfig = {
        type: '{{ $chartJsType }}',
        data: @json($chartJsData),
        options: @json($chartJsOptions)
    };
    
    const chart = new Chart(ctx, chartConfig);
    
    // Salva riferimento per export
    window.chartInstances = window.chartInstances || {};
    window.chartInstances['chart-{{ $uniqueId }}'] = chart;
});
```

---

## 💾 Parte 3: Export PNG - Client-Side

### 3.1 Metodo Base: Canvas toBlob

**Step 1**: Crea funzione export PNG

```javascript
/**
 * Export Chart.js canvas to PNG (Client-Side)
 * 
 * @param {Chart|string} chartOrId - Chart.js instance o ID canvas
 * @param {string} filename - Nome file (senza estensione)
 * @param {number} quality - Qualità 0-1 (default: 1)
 */
function exportChartToPng(chartOrId, filename = 'chart', quality = 1) {
    // Ottieni Chart instance
    let chart;
    if (typeof chartOrId === 'string') {
        // Se è un ID, recupera da window.chartInstances
        chart = window.chartInstances?.[chartOrId];
        if (!chart) {
            console.error('Chart non trovato:', chartOrId);
            return false;
        }
    } else {
        chart = chartOrId;
    }
    
    const canvas = chart.canvas;
    
    // Step 1: Converti canvas a Blob
    canvas.toBlob(function(blob) {
        if (!blob) {
            console.error('Errore generazione blob');
            return;
        }
        
        // Step 2: Crea URL temporaneo
        const url = URL.createObjectURL(blob);
        
        // Step 3: Crea link download
        const link = document.createElement('a');
        link.href = url;
        link.download = filename + '.png';
        
        // Step 4: Trigger download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Step 5: Pulisci URL
        setTimeout(() => URL.revokeObjectURL(url), 100);
        
        console.log('✅ PNG esportato:', filename + '.png');
    }, 'image/png', quality);
    
    return true;
}
```

**Step 2**: Usa la funzione

```javascript
// Metodo 1: Con Chart instance
const chart = new Chart(ctx, config);
exportChartToPng(chart, 'my-chart');

// Metodo 2: Con ID canvas
exportChartToPng('chart-123', 'my-chart');

// Metodo 3: Con qualità personalizzata
exportChartToPng(chart, 'my-chart', 0.9);
```

### 3.2 Metodo Avanzato: html2canvas (Migliore Qualità)

**Step 1**: Installa html2canvas

```bash
npm install html2canvas
```

**Step 2**: Importa e usa

```javascript
import html2canvas from 'html2canvas';

/**
 * Export Chart.js usando html2canvas (Alta Qualità)
 * 
 * @param {HTMLElement} chartElement - Elemento contenitore del grafico
 * @param {string} filename - Nome file
 * @param {object} options - Opzioni html2canvas
 */
async function exportChartToPngHtml2Canvas(
    chartElement, 
    filename = 'chart',
    options = {}
) {
    // Opzioni default
    const defaultOptions = {
        backgroundColor: '#ffffff',
        scale: 2, // Maggiore risoluzione (2x)
        logging: false,
        useCORS: true,
        allowTaint: false,
    };
    
    const finalOptions = { ...defaultOptions, ...options };
    
    try {
        // Step 1: Cattura elemento con html2canvas
        const canvas = await html2canvas(chartElement, finalOptions);
        
        // Step 2: Converti a Blob
        canvas.toBlob(function(blob) {
            if (!blob) {
                console.error('Errore generazione blob');
                return;
            }
            
            // Step 3: Download
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename + '.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            
            console.log('✅ PNG esportato (html2canvas):', filename + '.png');
        }, 'image/png', 1);
        
    } catch (error) {
        console.error('Errore export html2canvas:', error);
    }
}

// Uso
const chartContainer = document.querySelector('#chart-container');
exportChartToPngHtml2Canvas(chartContainer, 'my-chart', { scale: 3 });
```

### 3.3 Metodo: Invia al Server (DataURL)

**Step 1**: Crea funzione che invia al server

```javascript
/**
 * Export Chart.js e invia al server
 * 
 * @param {Chart} chart - Chart.js instance
 * @param {string} filename - Nome file
 * @param {string} format - 'png' o 'svg'
 */
async function exportChartToServer(chart, filename, format = 'png') {
    const canvas = chart.canvas;
    let dataUrl;
    
    if (format === 'png') {
        dataUrl = canvas.toDataURL('image/png');
    } else if (format === 'svg') {
        // Converti canvas a SVG (vedi sezione SVG)
        dataUrl = await canvasToSvgDataUrl(canvas);
    }
    
    // Invia al server
    try {
        const response = await fetch('/api/chart/export', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                image: dataUrl,
                filename: filename,
                format: format
            })
        });
        
        if (response.ok) {
            const result = await response.json();
            console.log('✅ File salvato:', result.path);
            return result;
        } else {
            console.error('Errore server:', await response.text());
        }
    } catch (error) {
        console.error('Errore fetch:', error);
    }
}
```

---

## 🎨 Parte 4: Export SVG - Client-Side

### 4.1 Metodo Base: Canvas to SVG (PNG Embedded)

**Step 1**: Crea funzione export SVG

```javascript
/**
 * Export Chart.js canvas to SVG (PNG embedded)
 * 
 * NOTA: Questo crea un SVG con PNG embedded, non un SVG vettoriale puro.
 * Per SVG vettoriale puro, usa librerie specializzate.
 * 
 * @param {Chart|string} chartOrId - Chart.js instance o ID canvas
 * @param {string} filename - Nome file (senza estensione)
 */
function exportChartToSvg(chartOrId, filename = 'chart') {
    // Ottieni Chart instance
    let chart;
    if (typeof chartOrId === 'string') {
        chart = window.chartInstances?.[chartOrId];
        if (!chart) {
            console.error('Chart non trovato:', chartOrId);
            return false;
        }
    } else {
        chart = chartOrId;
    }
    
    const canvas = chart.canvas;
    
    // Step 1: Crea elemento SVG
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', canvas.width);
    svg.setAttribute('height', canvas.height);
    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    
    // Step 2: Crea elemento image con data URL del canvas
    const img = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    img.setAttributeNS('http://www.w3.org/1999/xlink', 'href', 
        canvas.toDataURL('image/png'));
    img.setAttribute('width', canvas.width);
    img.setAttribute('height', canvas.height);
    img.setAttribute('x', '0');
    img.setAttribute('y', '0');
    
    // Step 3: Aggiungi image a SVG
    svg.appendChild(img);
    
    // Step 4: Serializza SVG a stringa
    const serializer = new XMLSerializer();
    const svgString = serializer.serializeToString(svg);
    
    // Step 5: Crea Blob e download
    const blob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename + '.svg';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    
    console.log('✅ SVG esportato:', filename + '.svg');
    return true;
}
```

**Step 2**: Usa la funzione

```javascript
// Con Chart instance
const chart = new Chart(ctx, config);
exportChartToSvg(chart, 'my-chart');

// Con ID canvas
exportChartToSvg('chart-123', 'my-chart');
```

### 4.2 Metodo Avanzato: SVG Vettoriale con chartjs-to-image

**Step 1**: Installa libreria

```bash
npm install chartjs-to-image
```

**Step 2**: Usa per export SVG vettoriale

```javascript
import { ChartJSNodeCanvas } from 'chartjs-node-canvas';

// NOTA: chartjs-to-image funziona principalmente server-side
// Per client-side SVG vettoriale, usa chartjs-plugin-svg
```

**Alternativa Client-Side**: Usa `chartjs-plugin-svg`

```bash
npm install chartjs-plugin-svg
```

```javascript
import Chart from 'chart.js/auto';
import svgPlugin from 'chartjs-plugin-svg';

Chart.register(svgPlugin);

// Configura Chart.js con plugin SVG
const chart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        plugins: {
            svg: {
                enabled: true
            }
        }
    }
});

// Export SVG vettoriale
const svgString = chart.toSVG();
const blob = new Blob([svgString], { type: 'image/svg+xml' });
// ... download come sopra
```

---

## 🖥️ Parte 5: Export Server-Side (PHP)

### 5.1 Action: Export Chart.js a PNG

**File**: `Modules/Chart/app/Actions/ChartJs/ExportChartJsToPngAction.php`

**Step 1**: Crea Action

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\ChartJs;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

class ExportChartJsToPngAction
{
    use QueueableAction;

    /**
     * Esporta Chart.js a PNG usando Puppeteer (Headless Chrome).
     * 
     * @param array<string, mixed> $chartConfig Configurazione Chart.js completa
     * @param string $outputPath Percorso assoluto output (es: public_path('chart/123.png'))
     * @param int $width Larghezza canvas (default: 800)
     * @param int $height Altezza canvas (default: 600)
     * @return bool Successo operazione
     */
    public function execute(
        array $chartConfig,
        string $outputPath,
        int $width = 800,
        int $height = 600
    ): bool {
        // Step 1: Genera HTML temporaneo con Chart.js
        $html = $this->generateChartHtml($chartConfig, $width, $height);
        $htmlPath = storage_path('app/temp/chart_'.uniqid().'.html');
        File::ensureDirectoryExists(dirname($htmlPath));
        File::put($htmlPath, $html);
        
        // Step 2: Genera script Puppeteer
        $script = $this->generatePuppeteerScript($htmlPath, $outputPath);
        $scriptPath = storage_path('app/temp/export_'.uniqid().'.js');
        File::put($scriptPath, $script);
        
        // Step 3: Esegui Puppeteer
        $command = "node {$scriptPath} 2>&1";
        exec($command, $output, $returnCode);
        
        // Step 4: Pulisci file temporanei
        File::delete($htmlPath);
        File::delete($scriptPath);
        
        // Step 5: Verifica risultato
        if (File::exists($outputPath) && $returnCode === 0) {
            logger()->info('Chart.js PNG esportato', [
                'path' => $outputPath,
                'size' => File::size($outputPath),
            ]);
            return true;
        }
        
        logger()->error('Errore export Chart.js PNG', [
            'output' => $output,
            'return_code' => $returnCode,
            'output_path' => $outputPath,
        ]);
        
        return false;
    }

    /**
     * Genera HTML con Chart.js.
     */
    private function generateChartHtml(
        array $chartConfig,
        int $width,
        int $height
    ): string {
        $configJson = json_encode($chartConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            margin: 0; 
            padding: 20px; 
            background: white; 
            font-family: Arial, sans-serif;
        }
        #chart-container { 
            width: {$width}px; 
            height: {$height}px; 
            margin: 0 auto;
        }
        canvas {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div id="chart-container">
        <canvas id="chart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chartConfig = {$configJson};
        
        // Crea Chart.js instance
        const chart = new Chart(ctx, chartConfig);
        
        // Attendi che il grafico sia completamente renderizzato
        chart.update();
        
        // Attendi un po' per assicurarsi che tutto sia renderizzato
        setTimeout(() => {
            console.log('Chart renderizzato');
        }, 1000);
    </script>
</body>
</html>
HTML;
    }

    /**
     * Genera script Puppeteer per screenshot.
     */
    private function generatePuppeteerScript(
        string $htmlPath,
        string $outputPath
    ): string {
        $htmlPathEscaped = addslashes($htmlPath);
        $outputPathEscaped = addslashes($outputPath);
        
        return <<<JS
const puppeteer = require('puppeteer');

(async () => {
    let browser;
    try {
        browser = await puppeteer.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu'
            ]
        });
        
        const page = await browser.newPage();
        
        // Imposta viewport
        await page.setViewport({
            width: 1200,
            height: 800,
            deviceScaleFactor: 2 // Maggiore risoluzione
        });
        
        // Carica HTML
        await page.goto('file://{$htmlPathEscaped}', {
            waitUntil: 'networkidle0',
            timeout: 30000
        });
        
        // Attendi che Chart.js sia renderizzato
        await page.waitForSelector('canvas', { timeout: 10000 });
        await page.waitForTimeout(2000); // Attendi animazioni
        
        // Trova canvas
        const canvas = await page.$('canvas');
        if (!canvas) {
            throw new Error('Canvas non trovato');
        }
        
        // Screenshot del canvas
        await canvas.screenshot({
            path: '{$outputPathEscaped}',
            type: 'png',
            omitBackground: false
        });
        
        console.log('Screenshot salvato:', '{$outputPathEscaped}');
        
    } catch (error) {
        console.error('Errore Puppeteer:', error.message);
        process.exit(1);
    } finally {
        if (browser) {
            await browser.close();
        }
    }
})();
JS;
    }
}
```

**Step 2**: Installa Puppeteer

```bash
# Nel progetto root
npm install puppeteer

# Oppure globalmente
npm install -g puppeteer
```

**Step 3**: Usa l'Action

```php
use Modules\Chart\Actions\ChartJs\ExportChartJsToPngAction;

// Prepara configurazione Chart.js
$chartConfig = [
    'type' => 'bar',
    'data' => [
        'labels' => ['A', 'B', 'C'],
        'datasets' => [[
            'label' => 'Dati',
            'data' => [10, 20, 30],
            'backgroundColor' => ['#3B82F6', '#10B981', '#F59E0B'],
        ]],
    ],
    'options' => [
        'responsive' => false,
        'plugins' => [
            'title' => [
                'display' => true,
                'text' => 'Titolo Grafico',
            ],
        ],
    ],
];

// Export
$outputPath = public_path('chart/123.png');
$success = app(ExportChartJsToPngAction::class)->execute(
    $chartConfig,
    $outputPath,
    800, // width
    600  // height
);

if ($success) {
    echo "PNG esportato: {$outputPath}";
}
```

### 5.2 Action: Export Chart.js a SVG

**File**: `Modules/Chart/app/Actions/ChartJs/ExportChartJsToSvgAction.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\ChartJs;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

class ExportChartJsToSvgAction
{
    use QueueableAction;

    /**
     * Esporta Chart.js a SVG usando Puppeteer.
     * 
     * @param array<string, mixed> $chartConfig Configurazione Chart.js
     * @param string $outputPath Percorso assoluto output
     * @param int $width Larghezza canvas
     * @param int $height Altezza canvas
     * @return bool Successo operazione
     */
    public function execute(
        array $chartConfig,
        string $outputPath,
        int $width = 800,
        int $height = 600
    ): bool {
        // Step 1: Genera HTML
        $html = $this->generateChartHtml($chartConfig, $width, $height);
        $htmlPath = storage_path('app/temp/chart_'.uniqid().'.html');
        File::ensureDirectoryExists(dirname($htmlPath));
        File::put($htmlPath, $html);
        
        // Step 2: Genera script Puppeteer per SVG
        $script = $this->generatePuppeteerSvgScript($htmlPath, $outputPath);
        $scriptPath = storage_path('app/temp/export_svg_'.uniqid().'.js');
        File::put($scriptPath, $script);
        
        // Step 3: Esegui
        $command = "node {$scriptPath} 2>&1";
        exec($command, $output, $returnCode);
        
        // Step 4: Pulisci
        File::delete($htmlPath);
        File::delete($scriptPath);
        
        return File::exists($outputPath) && $returnCode === 0;
    }

    private function generateChartHtml(
        array $chartConfig,
        int $width,
        int $height
    ): string {
        $configJson = json_encode($chartConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <style>
        body { margin: 0; padding: 20px; background: white; }
        #chart-container { width: {$width}px; height: {$height}px; }
    </style>
</head>
<body>
    <div id="chart-container">
        <canvas id="chart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {$configJson});
        chart.update();
    </script>
</body>
</html>
HTML;
    }

    private function generatePuppeteerSvgScript(
        string $htmlPath,
        string $outputPath
    ): string {
        $htmlPathEscaped = addslashes($htmlPath);
        $outputPathEscaped = addslashes($outputPath);
        
        return <<<JS
const puppeteer = require('puppeteer');

(async () => {
    let browser;
    try {
        browser = await puppeteer.launch({
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });
        
        const page = await browser.newPage();
        await page.goto('file://{$htmlPathEscaped}', { waitUntil: 'networkidle0' });
        await page.waitForSelector('canvas');
        await page.waitForTimeout(2000);
        
        // Ottieni data URL del canvas
        const dataUrl = await page.evaluate(() => {
            const canvas = document.querySelector('canvas');
            return canvas.toDataURL('image/png');
        });
        
        // Crea SVG con PNG embedded
        const svg = \`<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}">
            <image href="\${dataUrl}" width="{$width}" height="{$height}"/>
        </svg>\`;
        
        // Salva SVG
        const fs = require('fs');
        fs.writeFileSync('{$outputPathEscaped}', svg, 'utf8');
        
        console.log('SVG salvato:', '{$outputPathEscaped}');
        
    } catch (error) {
        console.error('Errore:', error.message);
        process.exit(1);
    } finally {
        if (browser) {
            await browser.close();
        }
    }
})();
JS;
    }
}
```

---

## 🔗 Parte 6: Integrazione Completa

### 6.1 Workflow Completo: Backend → Frontend → Export

**Step 1**: Backend prepara dati

```php
// Modules/Quaeris/app/Actions/QuestionChart/ExportChartJsAction.php
namespace Modules\Quaeris\Actions\QuestionChart;

use Modules\Chart\Actions\ChartJs\ExportChartJsToPngAction;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;

class ExportChartJsAction
{
    use QueueableAction;
    
    public function execute(
        QuestionChart $questionChart,
        string $format = 'png' // 'png' o 'svg'
    ): string {
        // 1. Prepara dati
        $answersData = AnswersChartData::from([
            'answers' => $answers,
            'chart' => $chartData,
        ]);
        
        // 2. Configurazione Chart.js
        $chartConfig = [
            'type' => $answersData->getChartJsType(),
            'data' => $answersData->getChartJsData(),
            'options' => $answersData->getChartJsOptionsArray(),
        ];
        
        // 3. Export
        $filename = 'chart/'.$questionChart->id.'.'.$format;
        $outputPath = public_path($filename);
        
        if ($format === 'png') {
            app(ExportChartJsToPngAction::class)->execute(
                $chartConfig,
                $outputPath,
                800,
                600
            );
        } else {
            app(ExportChartJsToSvgAction::class)->execute(
                $chartConfig,
                $outputPath,
                800,
                600
            );
        }
        
        return $filename;
    }
}
```

**Step 2**: Frontend mostra grafico e permette export

```blade
{{-- resources/views/chart/export.blade.php --}}
<div id="chart-container">
    <canvas id="chart-{{ $questionChart->id }}"></canvas>
</div>

<button onclick="exportToPng()">Export PNG</button>
<button onclick="exportToSvg()">Export SVG</button>

<script>
const chartConfig = @json($chartConfig);
const ctx = document.getElementById('chart-{{ $questionChart->id }}').getContext('2d');
const chart = new Chart(ctx, chartConfig);

// Salva riferimento
window.chartInstances = window.chartInstances || {};
window.chartInstances['chart-{{ $questionChart->id }}'] = chart;

function exportToPng() {
    exportChartToPng(chart, 'chart-{{ $questionChart->id }}');
}

function exportToSvg() {
    exportChartToSvg(chart, 'chart-{{ $questionChart->id }}');
}
</script>
```

---

## 📚 Riferimenti e Best Practices

### Best Practices

1. **Qualità PNG**: Usa `scale: 2` o `3` con html2canvas per alta risoluzione
2. **Dimensioni**: 800x600 è ottimale per PDF, 1200x900 per stampa
3. **Cache**: Cache immagini generate per evitare rigenerazioni
4. **Error Handling**: Sempre gestire errori con try-catch
5. **Performance**: Usa queue per export server-side pesanti

### Compatibilità Browser

- **Canvas toBlob**: Chrome 50+, Firefox 42+, Safari 10+
- **html2canvas**: Chrome, Firefox, Safari (IE11 con polyfills)
- **SVG Export**: Tutti i browser moderni

### Server Requirements

- **Puppeteer**: Node.js 14+, Chrome/Chromium
- **Memory**: Minimo 2GB RAM per Puppeteer
- **Disk**: Spazio per file temporanei

---

## 📚 Riferimenti

- [Chart.js Documentation](https://www.chartjs.org/)
- [html2canvas Documentation](https://html2canvas.hertzen.com/)
- [Puppeteer Documentation](https://pptr.dev/)
- [PDF Integration Guide](./pdf-integration-complete-guide.md)
- [JpGraph Guide](./jpgraph-complete-guide.md)

---

**Filosofia**: Chart.js è per grafici interattivi nel browser. L'export permette di includerli nei PDF mantenendo qualità e flessibilità, combinando il meglio di entrambi i mondi.
