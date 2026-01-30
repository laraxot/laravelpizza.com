# Chart.js Export SVG/PNG - Guida Completa

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Completa  
**Versione**: 1.0.0  
**Autore**: Analisi Completa del Sistema

---

## 📋 Indice Completo

1. [Panoramica Generale](#panoramica-generale)
2. [Export Chart.js come PNG](#export-chartjs-come-png)
3. [Export Chart.js come SVG](#export-chartjs-come-svg)
4. [Integrazione Server-Side](#integrazione-server-side)
5. [Best Practices](#best-practices)
6. [Esempi Completi](#esempi-completi)

---

## Panoramica Generale

### Obiettivo

Esportare grafici Chart.js come immagini (PNG o SVG) per includerli in PDF generati con Spipu PDF.

### Metodi Disponibili

1. **Canvas toDataURL()**: Export diretto da canvas Chart.js (PNG)
2. **Canvas toSVG()**: Export SVG (se supportato)
3. **html2canvas**: Cattura elemento DOM come canvas (PNG)
4. **chartjs-plugin-datalabels**: Plugin per export avanzato

### Stack Tecnologico

- **Chart.js 4.x**: Libreria grafici JavaScript
- **chartjs-plugin-datalabels**: Plugin per labels
- **html2canvas**: Cattura DOM come canvas (opzionale)
- **Laravel Backend**: API per salvare immagini

---

## Export Chart.js come PNG

### Metodo 1: toBase64Image() (Raccomandato)

**Vantaggi**:
- Metodo nativo Chart.js
- Supporto completo per tutti i tipi di grafico
- Include plugins (datalabels, etc.)

**Implementazione**:

```javascript
// 1. Crea grafico Chart.js
const ctx = document.getElementById('myChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: chartOptions,
    plugins: [ChartDataLabels] // Plugin opzionale
});

// 2. Attendi che grafico sia renderizzato
chart.update();

// 3. Esporta come PNG base64
const pngBase64 = chart.toBase64Image('image/png', 1.0);
// Parametri:
// - 'image/png': Formato immagine
// - 1.0: Quality (0.0 - 1.0)

// 4. Invia al server
fetch('/api/chart/export', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        question_chart_id: questionChartId,
        image: pngBase64,
        format: 'png'
    })
})
.then(response => response.json())
.then(data => {
    console.log('Grafico esportato:', data.filename);
});
```

### Metodo 2: Canvas toDataURL()

**Vantaggi**:
- Controllo diretto su canvas
- Possibilità di modificare canvas prima dell'export

**Implementazione**:

```javascript
// 1. Crea grafico Chart.js
const chart = new Chart(ctx, { ... });

// 2. Attendi renderizzazione
chart.update();

// 3. Ottieni canvas element
const canvas = chart.canvas;

// 4. Esporta canvas come PNG
const pngBase64 = canvas.toDataURL('image/png', 1.0);

// 5. Invia al server
fetch('/api/chart/export', {
    method: 'POST',
    body: JSON.stringify({ image: pngBase64 })
});
```

### Metodo 3: html2canvas (Per Grafici Complessi)

**Vantaggi**:
- Cattura elemento DOM completo (inclusi stili CSS)
- Utile per grafici con overlay o elementi esterni

**Implementazione**:

```javascript
import html2canvas from 'html2canvas';

// 1. Seleziona elemento contenitore grafico
const chartElement = document.getElementById('chart-container');

// 2. Cattura come canvas
html2canvas(chartElement, {
    backgroundColor: '#ffffff',
    scale: 2, // Risoluzione (2x per qualità migliore)
    logging: false,
    useCORS: true
}).then(canvas => {
    // 3. Esporta canvas come PNG
    const pngBase64 = canvas.toDataURL('image/png', 1.0);
    
    // 4. Invia al server
    fetch('/api/chart/export', {
        method: 'POST',
        body: JSON.stringify({ image: pngBase64 })
    });
});
```

### Configurazione Quality e Dimensioni

```javascript
// Export ad alta risoluzione
const highResBase64 = chart.toBase64Image('image/png', 1.0);

// Export a bassa risoluzione (più leggero)
const lowResBase64 = chart.toBase64Image('image/png', 0.7);

// Export con dimensioni specifiche
const canvas = chart.canvas;
const tempCanvas = document.createElement('canvas');
tempCanvas.width = 1200; // Larghezza desiderata
tempCanvas.height = 800; // Altezza desiderata
const tempCtx = tempCanvas.getContext('2d');
tempCtx.drawImage(canvas, 0, 0, tempCanvas.width, tempCanvas.height);
const resizedBase64 = tempCanvas.toDataURL('image/png', 1.0);
```

---

## Export Chart.js come SVG

### Metodo 1: Canvas toSVG() (Se Supportato)

**Nota**: Non tutti i browser supportano `canvas.toSVG()`. Usa come fallback PNG.

**Implementazione**:

```javascript
// 1. Crea grafico Chart.js
const chart = new Chart(ctx, { ... });

// 2. Attendi renderizzazione
chart.update();

// 3. Prova export SVG
let svgBase64;
try {
    svgBase64 = chart.canvas.toSVG();
} catch (e) {
    // Fallback a PNG se SVG non supportato
    svgBase64 = chart.toBase64Image('image/png');
}

// 4. Invia al server
fetch('/api/chart/export', {
    method: 'POST',
    body: JSON.stringify({ 
        image: svgBase64,
        format: 'svg'
    })
});
```

### Metodo 2: Conversione Canvas → SVG (Manuale)

**Implementazione**:

```javascript
// 1. Crea grafico Chart.js
const chart = new Chart(ctx, { ... });

// 2. Ottieni canvas
const canvas = chart.canvas;

// 3. Converti canvas in SVG
function canvasToSVG(canvas) {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', canvas.width);
    svg.setAttribute('height', canvas.height);
    
    const image = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    image.setAttribute('href', canvas.toDataURL('image/png'));
    image.setAttribute('width', canvas.width);
    image.setAttribute('height', canvas.height);
    
    svg.appendChild(image);
    
    return new XMLSerializer().serializeToString(svg);
}

// 4. Genera SVG
const svgString = canvasToSVG(canvas);
const svgBase64 = 'data:image/svg+xml;base64,' + btoa(svgString);

// 5. Invia al server
fetch('/api/chart/export', {
    method: 'POST',
    body: JSON.stringify({ image: svgBase64, format: 'svg' })
});
```

### Metodo 3: Usando Libreria Esterna (canvg)

**Installazione**:

```bash
npm install canvg
```

**Implementazione**:

```javascript
import { Canvg } from 'canvg';

// 1. Crea grafico Chart.js
const chart = new Chart(ctx, { ... });

// 2. Ottieni canvas
const canvas = chart.canvas;

// 3. Converti canvas in SVG usando canvg
const ctx2d = canvas.getContext('2d');
const svg = Canvg.fromString(ctx2d, canvas.toDataURL('image/png'));

// 4. Esporta SVG
const svgString = svg.toString();
const svgBase64 = 'data:image/svg+xml;base64,' + btoa(svgString);

// 5. Invia al server
fetch('/api/chart/export', {
    method: 'POST',
    body: JSON.stringify({ image: svgBase64, format: 'svg' })
});
```

---

## Integrazione Server-Side

### Action per Salvare Immagine

**File**: `Modules/Quaeris/app/Actions/QuestionChart/SaveChartJsImageAction.php` (da creare)

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions\QuestionChart;

use Illuminate\Support\Facades\File;
use Modules\Quaeris\Models\QuestionChart;
use Spatie\QueueableAction\QueueableAction;

class SaveChartJsImageAction
{
    use QueueableAction;
    
    /**
     * Salva immagine Chart.js esportata.
     *
     * @param QuestionChart $questionChart QuestionChart da aggiornare
     * @param string $imageBase64 Immagine in formato base64
     * @param string $format Formato immagine ('png' o 'svg')
     * @return string Path file salvato
     */
    public function execute(
        QuestionChart $questionChart,
        string $imageBase64,
        string $format = 'png'
    ): string {
        // 1. Rimuovi data URL prefix se presente
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageBase64);
        
        // 2. Decodifica base64
        $decoded = base64_decode($imageData, true);
        if ($decoded === false) {
            throw new \Exception('Invalid base64 image data');
        }
        
        // 3. Determina path file
        $filename = 'chart/'.$questionChart->id.'.'.$format;
        $file_path = public_path($filename);
        
        // 4. Crea directory se non esiste
        $dir = dirname($file_path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        
        // 5. Elimina file esistente se presente
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        
        // 6. Salva immagine
        File::put($file_path, $decoded);
        
        // 7. Verifica che file sia stato creato
        if (! File::exists($file_path)) {
            throw new \Exception("Failed to save image to {$file_path}");
        }
        
        // 8. Aggiorna QuestionChart
        $questionChart->img_src = $filename;
        $questionChart->generated_at = now();
        $questionChart->save();
        
        return $filename;
    }
}
```

### Endpoint API

**File**: `Modules/Quaeris/routes/api.php` (da aggiungere)

```php
use Illuminate\Support\Facades\Route;
use Modules\Quaeris\Actions\QuestionChart\SaveChartJsImageAction;
use Modules\Quaeris\Models\QuestionChart;

Route::post('/chart/export', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'question_chart_id' => 'required|exists:question_charts,id',
        'image' => 'required|string',
        'format' => 'nullable|in:png,svg',
    ]);
    
    $questionChart = QuestionChart::findOrFail($request->question_chart_id);
    $format = $request->format ?? 'png';
    
    $filename = app(SaveChartJsImageAction::class)
        ->execute($questionChart, $request->image, $format);
    
    return response()->json([
        'success' => true,
        'filename' => $filename,
        'url' => asset($filename),
    ]);
})->middleware('auth');
```

### Integrazione nel Widget Filament

**File**: `Modules/Quaeris/app/Filament/Widgets/QuestionChartItemWidget.php`

```php
public function exportChart(): void
{
    // 1. Ottieni dati grafico
    $answersData = $this->getAnswersChartData();
    
    // 2. Prepara dati per Chart.js
    $chartData = $answersData->getChartJsData();
    $chartType = $answersData->getChartJsType();
    $chartOptions = $answersData->getChartJsOptionsJs();
    
    // 3. Emetti evento JavaScript per export
    $this->dispatch('export-chart-js', [
        'question_chart_id' => $this->questionChart->id,
        'chart_data' => $chartData,
        'chart_type' => $chartType,
        'chart_options' => $chartOptions,
    ]);
}
```

**JavaScript nel Widget**:

```javascript
// resources/views/filament/widgets/question-chart-item-widget.blade.php

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('export-chart-js', (data) => {
        // 1. Crea canvas temporaneo
        const canvas = document.createElement('canvas');
        canvas.width = 1200;
        canvas.height = 800;
        const ctx = canvas.getContext('2d');
        
        // 2. Crea grafico Chart.js
        const chart = new Chart(ctx, {
            type: data.chart_type,
            data: data.chart_data,
            options: JSON.parse(data.chart_options),
        });
        
        // 3. Attendi renderizzazione
        chart.update('none', () => {
            // 4. Esporta come PNG
            const pngBase64 = chart.toBase64Image('image/png', 1.0);
            
            // 5. Invia al server
            fetch('/api/chart/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    question_chart_id: data.question_chart_id,
                    image: pngBase64,
                    format: 'png'
                })
            })
            .then(response => response.json())
            .then(result => {
                console.log('Grafico esportato:', result.filename);
                // Notifica successo
                Livewire.dispatch('chart-exported', { filename: result.filename });
            })
            .catch(error => {
                console.error('Errore export:', error);
            });
        });
    });
});
</script>
```

---

## Best Practices

### 1. Attendi Renderizzazione

**Pratica**: Sempre attendere che grafico sia renderizzato prima di esportare.

```javascript
// ✅ CORRETTO - Attendi renderizzazione
chart.update('none', () => {
    const pngBase64 = chart.toBase64Image('image/png');
    // Export...
});

// ❌ SBAGLIATO - Export immediato
const pngBase64 = chart.toBase64Image('image/png'); // Grafico non ancora renderizzato
```

### 2. Gestione Errori

**Pratica**: Gestisci errori gracefully.

```javascript
try {
    const pngBase64 = chart.toBase64Image('image/png', 1.0);
    // Invia al server...
} catch (error) {
    console.error('Errore export grafico:', error);
    // Fallback o notifica errore
}
```

### 3. Quality vs File Size

**Pratica**: Bilanciare qualità e dimensione file.

```javascript
// Alta qualità (file grande)
const highQuality = chart.toBase64Image('image/png', 1.0);

// Media qualità (file medio)
const mediumQuality = chart.toBase64Image('image/png', 0.8);

// Bassa qualità (file piccolo)
const lowQuality = chart.toBase64Image('image/png', 0.6);
```

### 4. Dimensioni Ottimizzate

**Pratica**: Usa dimensioni appropriate per PDF.

```javascript
// Dimensioni per PDF A4 Landscape
const canvas = chart.canvas;
const tempCanvas = document.createElement('canvas');
tempCanvas.width = 1000;  // Larghezza ottimale per PDF
tempCanvas.height = 600;  // Altezza ottimale per PDF
const tempCtx = tempCanvas.getContext('2d');
tempCtx.drawImage(canvas, 0, 0, tempCanvas.width, tempCanvas.height);
const optimizedBase64 = tempCanvas.toDataURL('image/png', 0.9);
```

### 5. Validazione Server-Side

**Pratica**: Valida sempre dati lato server.

```php
// Valida formato base64
if (! preg_match('/^data:image\/(png|svg\+xml);base64,/', $imageBase64)) {
    throw new \Exception('Invalid image format');
}

// Valida dimensione
$decoded = base64_decode($imageData);
if (strlen($decoded) > 10 * 1024 * 1024) { // Max 10MB
    throw new \Exception('Image too large');
}
```

---

## Esempi Completi

### Esempio 1: Export PNG da Widget Filament

**File**: `Modules/Quaeris/resources/views/filament/widgets/question-chart-widget.blade.php`

```blade
<div>
    <canvas id="chart-{{ $questionChart->id }}"></canvas>
    
    <button onclick="exportChart{{ $questionChart->id }}()">
        Esporta PNG
    </button>
</div>

<script>
let chart{{ $questionChart->id }};

// Inizializza grafico
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('chart-{{ $questionChart->id }}').getContext('2d');
    chart{{ $questionChart->id }} = new Chart(ctx, {
        type: '{{ $chartType }}',
        data: @json($chartData),
        options: {!! $chartOptions !!}
    });
});

// Funzione export
function exportChart{{ $questionChart->id }}() {
    chart{{ $questionChart->id }}.update('none', () => {
        const pngBase64 = chart{{ $questionChart->id }}.toBase64Image('image/png', 1.0);
        
        fetch('/api/chart/export', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                question_chart_id: {{ $questionChart->id }},
                image: pngBase64,
                format: 'png'
            })
        })
        .then(response => response.json())
        .then(data => {
            alert('Grafico esportato: ' + data.filename);
        });
    });
}
</script>
```

### Esempio 2: Export SVG con Fallback PNG

```javascript
function exportChartAsSVG(chart) {
    let svgBase64;
    
    try {
        // Prova export SVG
        if (chart.canvas.toSVG) {
            svgBase64 = chart.canvas.toSVG();
        } else {
            throw new Error('SVG not supported');
        }
    } catch (e) {
        // Fallback a PNG
        console.warn('SVG not supported, using PNG');
        svgBase64 = chart.toBase64Image('image/png', 1.0);
    }
    
    return svgBase64;
}
```

### Esempio 3: Batch Export Multiple Charts

```javascript
async function exportAllCharts(questionChartIds) {
    const results = [];
    
    for (const id of questionChartIds) {
        const chart = getChartById(id);
        
        // Attendi renderizzazione
        await new Promise(resolve => {
            chart.update('none', resolve);
        });
        
        // Esporta
        const pngBase64 = chart.toBase64Image('image/png', 1.0);
        
        // Invia al server
        const response = await fetch('/api/chart/export', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                question_chart_id: id,
                image: pngBase64,
                format: 'png'
            })
        });
        
        const result = await response.json();
        results.push(result);
    }
    
    return results;
}
```

---

## Conclusioni

### Metodi Disponibili

1. **toBase64Image()**: Metodo nativo Chart.js (raccomandato)
2. **Canvas toDataURL()**: Controllo diretto canvas
3. **html2canvas**: Cattura DOM completo
4. **SVG Export**: Supporto limitato, usa fallback PNG

### Workflow Completo

1. Crea grafico Chart.js
2. Attendi renderizzazione (`chart.update()`)
3. Esporta come base64 (`toBase64Image()`)
4. Invia al server via API
5. Server salva immagine in `public/chart/`
6. Aggiorna `QuestionChart->img_src`
7. Include immagine nel PDF

### Best Practices

1. Attendi sempre renderizzazione
2. Gestisci errori gracefully
3. Bilanciare quality vs file size
4. Usa dimensioni ottimizzate per PDF
5. Valida sempre server-side

---

---

## Riferimenti e Collegamenti

- [Guida Passo Passo Completa](./chartjs-export-step-by-step.md) - Guida dettagliata passo passo
- [Integrazione PDF Completa](./pdf-charts-integration-complete.md) - Come integrare grafici nei PDF
- [Tecniche Avanzate](./pdf-charts-advanced-techniques.md) - Ottimizzazioni e best practices avanzate

---

**Ultimo Aggiornamento**: 2025-01-18  
**Versione**: 1.0.0

