# Chart.js - Guida Export SVG/PNG

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Completa  
**Versione**: 2.0.0

## 📋 Panoramica

Chart.js è utilizzato per grafici interattivi nel browser. Questa guida documenta come esportare grafici Chart.js in formato SVG o PNG per includerli nei PDF.

> **📖 Per una guida passo-passo completa e dettagliata, vedi**: [Chart.js Export Step-by-Step Guide](./chartjs-export-step-by-step.md)

---

## 🎯 Architettura Chart.js in Laraxot

### Flusso Dati

```
AnswersChartData (DTO)
    ↓
getChartJsType() → 'bar', 'doughnut', 'line', ecc.
    ↓
getChartJsData() → { datasets: [...], labels: [...] }
    ↓
getChartJsOptionsArray() → { plugins: {...}, ... }
    ↓
Frontend (Blade/Livewire)
    ↓
Chart.js Canvas
    ↓
Export SVG/PNG
```

---

## 📊 Parte 1: Preparazione Dati Chart.js

### 1.1 AnswersChartData

**File**: `Modules/Chart/app/Datas/AnswersChartData.php`

```php
namespace Modules\Chart\Datas;

class AnswersChartData extends Data
{
    public DataCollection $answers;
    public ChartData $chart;

    /**
     * Ottiene il tipo Chart.js.
     */
    public function getChartJsType(): string
    {
        $type = $this->chart->type;
        return match($type) {
            'pie1', 'pieAvg' => 'doughnut',
            'lineSubQuestion' => 'line',
            'bar2', 'bar1', 'bar3', 'horizbar1' => 'bar',
            default => $type,
        };
    }

    /**
     * Ottiene i dati in formato Chart.js.
     */
    public function getChartJsData(): array
    {
        $labels = $this->answers->toCollection()
            ->pluck('label')
            ->map(fn($label) => (string)$label)
            ->values()
            ->all();

        $data = $this->answers->toCollection()->pluck('value')->all();

        // Gestisci dati multipli
        if (isset($data[0]) && is_array($data[0])) {
            $legends = array_keys($data[0]);
            $datasets = [];
            
            foreach ($legends as $key => $legend) {
                $series = array_column($data, $legend);
                $datasets[] = [
                    'label' => (string)$legend,
                    'data' => $this->normalizeSeries($series),
                    'borderColor' => $this->chart->getColorsRgba(0.5)[$key] ?? null,
                    'backgroundColor' => $this->chart->getColorsRgba(0.5)[$key] ?? null,
                ];
            }
        } else {
            $datasets = [[
                'label' => 'Dati',
                'data' => $this->normalizeSeries($data),
                'borderColor' => $this->chart->getColorsRgba(0.5),
                'backgroundColor' => $this->chart->getColorsRgba(0.5),
            ]];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    /**
     * Ottiene le opzioni Chart.js.
     */
    public function getChartJsOptionsArray(): array
    {
        $options = [
            'plugins' => [
                'title' => $this->title !== 'no_set' ? [
                    'display' => true,
                    'text' => $this->title,
                    'font' => ['size' => 14],
                ] : [],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];

        if ($this->chart->type === 'horizbar1') {
            $options['indexAxis'] = 'y';
        }

        return $options;
    }
}
```

---

## 🎨 Parte 2: Export Client-Side (JavaScript)

### 2.1 Export a PNG

**Metodo 1: Canvas toBlob (Nativo)**

```javascript
/**
 * Export Chart.js canvas to PNG
 * 
 * @param {Chart} chart - Chart.js instance
 * @param {string} filename - Output filename
 */
function exportChartToPng(chart, filename) {
    const canvas = chart.canvas;
    
    // Convert canvas to blob
    canvas.toBlob(function(blob) {
        // Create download link
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename + '.png';
        link.click();
        URL.revokeObjectURL(url);
    }, 'image/png');
}

// Uso
const chart = new Chart(ctx, config);
exportChartToPng(chart, 'my-chart');
```

**Metodo 2: Canvas toDataURL**

```javascript
function exportChartToPngDataUrl(chart, filename) {
    const canvas = chart.canvas;
    const dataUrl = canvas.toDataURL('image/png');
    
    // Invia al server
    fetch('/api/chart/export', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            image: dataUrl,
            filename: filename,
            format: 'png'
        })
    });
}
```

### 2.2 Export a SVG

**Metodo: Canvas to SVG Conversion**

```javascript
/**
 * Export Chart.js canvas to SVG
 * 
 * @param {Chart} chart - Chart.js instance
 * @param {string} filename - Output filename
 */
function exportChartToSvg(chart, filename) {
    const canvas = chart.canvas;
    
    // Crea SVG wrapper
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', canvas.width);
    svg.setAttribute('height', canvas.height);
    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    
    // Crea image element con data URL del canvas
    const img = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    img.setAttributeNS('http://www.w3.org/1999/xlink', 'href', 
        canvas.toDataURL('image/png'));
    img.setAttribute('width', canvas.width);
    img.setAttribute('height', canvas.height);
    
    svg.appendChild(img);
    
    // Serializza SVG
    const serializer = new XMLSerializer();
    const svgString = serializer.serializeToString(svg);
    
    // Download
    const blob = new Blob([svgString], { type: 'image/svg+xml' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename + '.svg';
    link.click();
    URL.createObjectURL(url);
}

// Uso
const chart = new Chart(ctx, config);
exportChartToSvg(chart, 'my-chart');
```

**Nota**: Questo metodo crea un SVG con un'immagine PNG embedded. Per un SVG vero (vettoriale), usa librerie come `chartjs-plugin-datalabels` con export SVG nativo o `chartjs-to-image`.

### 2.3 Export con html2canvas (Migliore Qualità)

```javascript
import html2canvas from 'html2canvas';

/**
 * Export Chart.js usando html2canvas per migliore qualità
 */
async function exportChartToPngHtml2Canvas(chartElement, filename) {
    // html2canvas cattura l'intero elemento, non solo il canvas
    const canvas = await html2canvas(chartElement, {
        backgroundColor: '#ffffff',
        scale: 2, // Maggiore risoluzione
        logging: false,
    });
    
    canvas.toBlob(function(blob) {
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename + '.png';
        link.click();
        URL.revokeObjectURL(url);
    }, 'image/png');
}
```

---

## 🖥️ Parte 3: Export Server-Side

### 3.1 Con Puppeteer (Headless Chrome)

**File**: `Modules/Chart/app/Actions/ChartJs/ExportChartJsToPngAction.php`

```php
namespace Modules\Chart\Actions\ChartJs;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

class ExportChartJsToPngAction
{
    use QueueableAction;

    /**
     * Esporta Chart.js a PNG usando Puppeteer.
     * 
     * @param array<string, mixed> $chartConfig Configurazione Chart.js
     * @param string $outputPath Percorso output
     * @param int $width Larghezza canvas
     * @param int $height Altezza canvas
     */
    public function execute(
        array $chartConfig,
        string $outputPath,
        int $width = 800,
        int $height = 600
    ): bool {
        // 1. Crea HTML temporaneo
        $html = $this->generateChartHtml($chartConfig, $width, $height);
        $htmlPath = storage_path('app/temp/chart_'.uniqid().'.html');
        File::ensureDirectoryExists(dirname($htmlPath));
        File::put($htmlPath, $html);
        
        // 2. Crea script Puppeteer
        $script = $this->generatePuppeteerScript($htmlPath, $outputPath);
        $scriptPath = storage_path('app/temp/export_'.uniqid().'.js');
        File::put($scriptPath, $script);
        
        // 3. Esegui Puppeteer
        $command = "node {$scriptPath}";
        exec($command, $output, $returnCode);
        
        // 4. Pulisci file temporanei
        File::delete($htmlPath);
        File::delete($scriptPath);
        
        return File::exists($outputPath) && $returnCode === 0;
    }

    private function generateChartHtml(
        array $chartConfig,
        int $width,
        int $height
    ): string {
        $configJson = json_encode($chartConfig, JSON_PRETTY_PRINT);
        
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
        
        // Attendi che il grafico sia renderizzato
        chart.update();
    </script>
</body>
</html>
HTML;
    }

    private function generatePuppeteerScript(
        string $htmlPath,
        string $outputPath
    ): string {
        return <<<JS
const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    const page = await browser.newPage();
    await page.goto('file://{$htmlPath}', { waitUntil: 'networkidle0' });
    
    // Attendi che Chart.js sia renderizzato
    await page.waitForTimeout(1000);
    
    const canvas = await page.$('canvas');
    if (canvas) {
        await canvas.screenshot({ path: '{$outputPath}' });
    }
    
    await browser.close();
})();
JS;
    }
}
```

**Installazione Puppeteer**:
```bash
npm install puppeteer
```

### 3.2 Con wkhtmltoimage (Alternativa)

```php
namespace Modules\Chart\Actions\ChartJs;

class ExportChartJsToPngWkhtmlAction
{
    public function execute(
        array $chartConfig,
        string $outputPath,
        int $width = 800,
        int $height = 600
    ): bool {
        $html = $this->generateChartHtml($chartConfig, $width, $height);
        $htmlPath = storage_path('app/temp/chart_'.uniqid().'.html');
        File::put($htmlPath, $html);
        
        $command = sprintf(
            'wkhtmltoimage --width %d --height %d %s %s',
            $width,
            $height,
            escapeshellarg($htmlPath),
            escapeshellarg($outputPath)
        );
        
        exec($command, $output, $returnCode);
        File::delete($htmlPath);
        
        return File::exists($outputPath) && $returnCode === 0;
    }
}
```

---

## 📄 Parte 4: Integrazione con PDF

### 4.1 Workflow Completo

```php
// 1. Prepara dati Chart.js
$answersData = AnswersChartData::from([
    'answers' => $answers,
    'chart' => $chartData,
]);

// 2. Export a PNG (server-side)
$chartConfig = [
    'type' => $answersData->getChartJsType(),
    'data' => $answersData->getChartJsData(),
    'options' => $answersData->getChartJsOptionsArray(),
];

$outputPath = public_path('chart/'.$questionChart->id.'.png');
app(ExportChartJsToPngAction::class)->execute(
    $chartConfig,
    $outputPath,
    800,
    600
);

// 3. Includi nel PDF
$html = view('pdf.template', [
    'chart_image' => $outputPath,
])->render();

$html2pdf = new Html2Pdf('L', 'A4', 'it');
$html2pdf->writeHTML($html);
$html2pdf->output('report.pdf', 'D');
```

### 4.2 Template Blade

```blade
{{-- Includi immagine Chart.js nel PDF --}}
@if(File::exists($chart_image))
    <img src="{{ $chart_image }}" 
         style="max-width: 100%; height: auto;" />
@else
    <p style="color: red;">Grafico non disponibile</p>
@endif
```

---

## 🔧 Parte 5: Best Practices

### 5.1 Qualità Immagini

**Per PNG**:
- Usa `scale: 2` con html2canvas per maggiore risoluzione
- Imposta dimensioni canvas appropriate (800x600 per PDF)
- Usa `maintainAspectRatio: false` per controllo completo

**Per SVG**:
- Preferisci export vettoriale quando possibile
- Considera librerie come `chartjs-plugin-datalabels` per SVG nativo

### 5.2 Performance

**Client-Side**:
- Export solo quando necessario
- Usa debounce per export multipli
- Mostra loading durante export

**Server-Side**:
- Cache immagini generate
- Usa queue per export asincroni
- Limita dimensioni canvas per performance

### 5.3 Compatibilità

**Browser Support**:
- Canvas toBlob: Modern browsers
- html2canvas: IE11+ (con polyfills)
- SVG Export: Modern browsers

**Server Requirements**:
- Puppeteer: Node.js 14+
- wkhtmltoimage: Binary installato

---

## 📚 Riferimenti

- [Chart.js Documentation](https://www.chartjs.org/)
- [html2canvas Documentation](https://html2canvas.hertzen.com/)
- [Puppeteer Documentation](https://pptr.dev/)
- [PDF Integration Guide](./pdf-integration-complete-guide.md)

---

**Filosofia**: Chart.js è per grafici interattivi. L'export a PNG/SVG permette di includerli nei PDF mantenendo la qualità e la flessibilità.

