# Chart.js - Export SVG e PNG Passo-Passo

## 📋 Indice
1. [Introduzione](#introduzione)
2. [EXPORT PNG - Passo-Passo](#export-png---passo-passo)
3. [EXPORT SVG - Passo-Passo](#export-svg---passo-passo)
4. [Esempi Pratici Completi](#esempi-pratici-completi)
5. [Integration con Laravel Backend](#integration-con-laravel-backend)
6. [Troubleshooting](#troubleshooting)

---

## Introduzione

Chart.js è basato su **HTML Canvas**, che rende l'export in PNG **nativo e semplice**, mentre l'export in SVG richiede **librerie aggiuntive** o **conversione**.

### Cosa Imparerai

- ✅ Export PNG con qualità professionale
- ✅ Export SVG con metodi diversi (nativo, plugin, server-side)
- ✅ Download automatico file
- ✅ Invio base64 a backend Laravel
- ✅ Export ad alta risoluzione per stampa

---

## EXPORT PNG - Passo-Passo

### Metodo 1: toBase64Image() - Il Più Semplice

#### Step 1: Crea il Grafico

```html
<!DOCTYPE html>
<html>
<head>
    <title>Chart.js PNG Export</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.js"></script>
</head>
<body>
    <!-- Canvas per il grafico -->
    <div style="width: 800px; margin: 0 auto;">
        <canvas id="myChart"></canvas>
    </div>

    <!-- Pulsante export -->
    <div style="text-align: center; margin-top: 20px;">
        <button id="exportPNG" style="padding: 10px 20px; font-size: 16px;">
            📥 Esporta PNG
        </button>
    </div>

    <script src="chart-script.js"></script>
</body>
</html>
```

#### Step 2: Inizializza Chart.js

```javascript
// chart-script.js

// 1. Ottieni il context del canvas
const ctx = document.getElementById('myChart').getContext('2d');

// 2. Configura i dati
const chartData = {
    labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio'],
    datasets: [{
        label: 'Vendite 2024',
        data: [65, 59, 80, 81, 56],
        backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
        ],
        borderWidth: 2
    }]
};

// 3. Configura le opzioni
const chartOptions = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
        title: {
            display: true,
            text: 'Report Vendite Mensili',
            font: {
                size: 18,
                weight: 'bold'
            }
        },
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Importo (€)'
            }
        },
        x: {
            title: {
                display: true,
                text: 'Mese'
            }
        }
    }
};

// 4. Crea il grafico
const myChart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: chartOptions
});

console.log('✅ Grafico creato con successo!');
```

#### Step 3: Implementa Export PNG

```javascript
// Aggiungi listener al pulsante export
document.getElementById('exportPNG').addEventListener('click', function() {
    console.log('🖱️ Click su Export PNG');

    // METODO 1: toBase64Image() - RACCOMANDATO
    // Questo metodo è fornito direttamente da Chart.js
    const base64Image = myChart.toBase64Image('image/png', 1.0);
    // Parametri:
    // - 'image/png': tipo MIME (può essere anche 'image/jpeg')
    // - 1.0: qualità (0.0 - 1.0, dove 1.0 = massima qualità)

    console.log('📊 Base64 generato:', base64Image.substring(0, 50) + '...');

    // Converti base64 in file e scarica
    downloadBase64AsPNG(base64Image, 'grafico-vendite.png');
});

/**
 * Helper function: Scarica base64 come file PNG
 */
function downloadBase64AsPNG(base64, filename) {
    // 1. Crea un link temporaneo
    const link = document.createElement('a');

    // 2. Imposta l'href con il base64
    link.href = base64;

    // 3. Imposta il nome del file
    link.download = filename;

    // 4. Aggiungi il link al DOM (necessario per alcuni browser)
    document.body.appendChild(link);

    // 5. Simula il click
    link.click();

    // 6. Rimuovi il link dal DOM
    document.body.removeChild(link);

    console.log('✅ Download avviato:', filename);
}
```

**Risultato:** Quando clicchi il pulsante "Esporta PNG", il browser scarica automaticamente `grafico-vendite.png`!

---

### Metodo 2: toBlob() - Più Controllo

```javascript
document.getElementById('exportPNG').addEventListener('click', function() {
    // Ottieni il canvas dal grafico
    const canvas = myChart.canvas;

    // Converti canvas in Blob (più efficiente per file grandi)
    canvas.toBlob(function(blob) {
        // 1. Crea URL temporaneo dal blob
        const url = URL.createObjectURL(blob);

        // 2. Crea link per download
        const link = document.createElement('a');
        link.href = url;
        link.download = 'grafico-vendite.png';

        // 3. Avvia download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // 4. Libera memoria (IMPORTANTE!)
        setTimeout(() => {
            URL.revokeObjectURL(url);
            console.log('🧹 Memoria liberata');
        }, 100);

        console.log('✅ PNG esportato via Blob');
    }, 'image/png', 1.0); // tipo, qualità
});
```

**Vantaggio:** Blob è più efficiente per file grandi e permette maggiore controllo.

---

### Metodo 3: Export ad Alta Risoluzione (per Stampa)

```javascript
/**
 * Export PNG ad alta risoluzione (2x, 3x, 4x)
 * Perfetto per stampa professionale
 */
function exportHighResPNG(chart, scale = 2, filename = 'chart.png') {
    console.log(`📐 Export PNG ${scale}x risoluzione`);

    // 1. Ottieni canvas originale
    const originalCanvas = chart.canvas;

    // 2. Crea canvas temporaneo ad alta risoluzione
    const tempCanvas = document.createElement('canvas');
    const tempCtx = tempCanvas.getContext('2d');

    // 3. Calcola dimensioni scalate
    tempCanvas.width = originalCanvas.width * scale;
    tempCanvas.height = originalCanvas.height * scale;

    // 4. Scala il context
    tempCtx.scale(scale, scale);

    // 5. Copia contenuto canvas originale
    tempCtx.drawImage(originalCanvas, 0, 0);

    // 6. Export come PNG
    tempCanvas.toBlob(function(blob) {
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        setTimeout(() => URL.revokeObjectURL(url), 100);

        console.log(`✅ PNG ${scale}x esportato:`, filename);
    }, 'image/png', 1.0);
}

// Uso
document.getElementById('exportPNG').addEventListener('click', function() {
    exportHighResPNG(myChart, 3, 'grafico-vendite-HD.png');
    // 3x risoluzione = 3 volte la qualità originale
});
```

**Quando usare:** Per grafici destinati alla stampa professionale o presentazioni HD.

---

## EXPORT SVG - Passo-Passo

⚠️ **Importante:** Chart.js **non supporta nativamente SVG** perché usa Canvas. Devi usare **soluzioni alternative**.

### Metodo 1: chart2svg (Plugin Raccomandato)

#### Step 1: Installa Plugin

```bash
npm install chartjs-to-svg
```

Oppure via CDN:

```html
<script src="https://cdn.jsdelivr.net/npm/chartjs-to-svg@1.0.0/dist/chartjs-to-svg.min.js"></script>
```

#### Step 2: Converti Chart in SVG

```javascript
// Importa il plugin (se usi ES6 modules)
import { toSVG } from 'chartjs-to-svg';

// Oppure usa globale (se usi CDN)
// const { toSVG } = window.ChartToSVG;

document.getElementById('exportSVG').addEventListener('click', function() {
    console.log('🎨 Export SVG avviato');

    try {
        // 1. Converti chart in SVG string
        const svgString = toSVG(myChart);

        console.log('📄 SVG generato:', svgString.substring(0, 100) + '...');

        // 2. Download SVG
        downloadSVG(svgString, 'grafico-vendite.svg');

    } catch (error) {
        console.error('❌ Errore export SVG:', error);
        alert('Errore durante export SVG. Vedi console.');
    }
});

/**
 * Helper: Download SVG string come file
 */
function downloadSVG(svgString, filename) {
    // 1. Crea Blob SVG
    const blob = new Blob([svgString], {
        type: 'image/svg+xml;charset=utf-8'
    });

    // 2. Crea URL temporaneo
    const url = URL.createObjectURL(blob);

    // 3. Crea link e scarica
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // 4. Cleanup
    setTimeout(() => URL.revokeObjectURL(url), 100);

    console.log('✅ SVG scaricato:', filename);
}
```

---

### Metodo 2: Canvas to SVG (Conversione Immagine Embedded)

⚠️ **Limitazione:** Questo metodo crea un SVG che **contiene un'immagine PNG embedded**, non un vero SVG vettoriale.

```javascript
function canvasToSVG(canvas) {
    console.log('🔄 Conversione Canvas → SVG (image embedded)');

    // 1. Ottieni dimensioni canvas
    const width = canvas.width;
    const height = canvas.height;

    // 2. Converti canvas in PNG base64
    const dataURL = canvas.toDataURL('image/png');

    // 3. Crea SVG con immagine embedded
    const svg = `
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     width="${width}"
     height="${height}"
     viewBox="0 0 ${width} ${height}">
    <title>Grafico Vendite</title>
    <image href="${dataURL}"
           width="${width}"
           height="${height}" />
</svg>
    `.trim();

    return svg;
}

// Uso
document.getElementById('exportSVG').addEventListener('click', function() {
    const svg = canvasToSVG(myChart.canvas);
    downloadSVG(svg, 'grafico-vendite.svg');
});
```

**Pro:**
- ✅ Funziona sempre
- ✅ Semplice da implementare

**Contro:**
- ❌ NON è vero SVG vettoriale
- ❌ File più pesante
- ❌ Non scalabile infinitamente

---

### Metodo 3: Server-Side SVG con Puppeteer

Per **vero SVG vettoriale**, usa rendering server-side con librerie dedicate.

```javascript
// Frontend: Invia configurazione a backend
async function exportSVGServerSide() {
    console.log('🖥️ Export SVG server-side');

    // 1. Invia configurazione chart a backend
    const response = await fetch('/api/charts/export-svg', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            type: myChart.config.type,
            data: myChart.config.data,
            options: myChart.config.options
        })
    });

    if (!response.ok) {
        throw new Error('Backend error');
    }

    // 2. Ricevi SVG
    const svg = await response.text();

    // 3. Download
    downloadSVG(svg, 'grafico-vendite.svg');

    console.log('✅ SVG server-side generato');
}
```

```php
// Backend Laravel (routes/api.php)
Route::post('/charts/export-svg', [ChartController::class, 'exportSVG']);

// app/Http/Controllers/ChartController.php
public function exportSVG(Request $request)
{
    $chartConfig = $request->all();

    // Usa libreria PHP per SVG (es. svg-php o D3.js via Node)
    $svg = $this->generateSVG($chartConfig);

    return response($svg)
        ->header('Content-Type', 'image/svg+xml');
}
```

**Pro:**
- ✅ Vero SVG vettoriale
- ✅ Qualità infinita
- ✅ File leggero

**Contro:**
- ❌ Complesso da implementare
- ❌ Richiede backend

---

## Esempi Pratici Completi

### Esempio 1: Pulsanti Export Multipli

```html
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Chart.js Export Completo</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.js"></script>
    <style>
        .container {
            max-width: 900px;
            margin: 50px auto;
            font-family: Arial, sans-serif;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .controls {
            text-align: center;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }

        .btn-primary {
            background: #3B82F6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563EB;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #10B981;
            color: white;
        }

        .btn-secondary:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #F59E0B;
            color: white;
        }

        .btn-warning:hover {
            background: #D97706;
            transform: translateY(-2px);
        }

        h1 {
            text-align: center;
            color: #1E40AF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Chart.js Export Demo</h1>

        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>

        <div class="controls">
            <button class="btn btn-primary" id="exportPNG">
                📥 Export PNG
            </button>
            <button class="btn btn-secondary" id="exportPNG_HD">
                📥 Export PNG HD (3x)
            </button>
            <button class="btn btn-warning" id="exportJPEG">
                📥 Export JPEG
            </button>
            <button class="btn btn-primary" id="sendToBackend">
                🚀 Invia a Backend
            </button>
        </div>
    </div>

    <script>
        // ==========================================
        // 1. CREAZIONE GRAFICO
        // ==========================================
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'],
                datasets: [{
                    label: 'Vendite 2024 (€)',
                    data: [12000, 19000, 8000, 15000, 22000, 18000],
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Report Vendite Mensili 2024',
                        font: { size: 18, weight: 'bold' },
                        color: '#1E40AF'
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Importo (€)'
                        }
                    }
                }
            }
        });

        // ==========================================
        // 2. EXPORT PNG STANDARD
        // ==========================================
        document.getElementById('exportPNG').addEventListener('click', function() {
            console.log('📥 Export PNG standard');

            const base64 = myChart.toBase64Image('image/png', 1.0);
            downloadBase64(base64, 'vendite-2024.png');
        });

        // ==========================================
        // 3. EXPORT PNG HD (3x risoluzione)
        // ==========================================
        document.getElementById('exportPNG_HD').addEventListener('click', function() {
            console.log('📥 Export PNG HD (3x)');

            exportHighResPNG(myChart, 3, 'vendite-2024-HD.png');
        });

        // ==========================================
        // 4. EXPORT JPEG (più leggero)
        // ==========================================
        document.getElementById('exportJPEG').addEventListener('click', function() {
            console.log('📥 Export JPEG');

            const base64 = myChart.toBase64Image('image/jpeg', 0.9);
            downloadBase64(base64, 'vendite-2024.jpg');
        });

        // ==========================================
        // 5. INVIA A BACKEND
        // ==========================================
        document.getElementById('sendToBackend').addEventListener('click', async function() {
            console.log('🚀 Invio a backend');

            const base64 = myChart.toBase64Image('image/png', 1.0);
            const base64Data = base64.split(',')[1]; // Rimuovi prefisso

            try {
                const response = await fetch('/api/charts/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        chart_base64: base64Data,
                        title: 'Vendite 2024',
                        type: 'bar'
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Grafico salvato con successo!');
                    console.log('Salvato in:', result.path);
                } else {
                    alert('❌ Errore nel salvataggio');
                }
            } catch (error) {
                console.error('Errore:', error);
                alert('❌ Errore di rete');
            }
        });

        // ==========================================
        // HELPER FUNCTIONS
        // ==========================================

        function downloadBase64(base64, filename) {
            const link = document.createElement('a');
            link.href = base64;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            console.log('✅ Download:', filename);
        }

        function exportHighResPNG(chart, scale, filename) {
            const canvas = chart.canvas;
            const tempCanvas = document.createElement('canvas');
            const tempCtx = tempCanvas.getContext('2d');

            tempCanvas.width = canvas.width * scale;
            tempCanvas.height = canvas.height * scale;
            tempCtx.scale(scale, scale);
            tempCtx.drawImage(canvas, 0, 0);

            tempCanvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                setTimeout(() => URL.revokeObjectURL(url), 100);
                console.log(`✅ PNG ${scale}x:`, filename);
            }, 'image/png', 1.0);
        }
    </script>
</body>
</html>
```

---

### Esempio 2: Component Vue.js con Export

```vue
<template>
    <div class="chart-wrapper">
        <!-- Canvas per Chart.js -->
        <div class="chart-container">
            <canvas ref="chartCanvas"></canvas>
        </div>

        <!-- Controlli export -->
        <div class="export-controls">
            <button @click="exportPNG" class="btn btn-primary">
                📥 Export PNG
            </button>
            <button @click="exportPNG_HD" class="btn btn-success">
                📥 Export HD (3x)
            </button>
            <button @click="sendToBackend" class="btn btn-warning">
                🚀 Salva
            </button>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
    name: 'ChartComponent',

    props: {
        chartData: {
            type: Object,
            required: true
        },
        chartOptions: {
            type: Object,
            default: () => ({})
        }
    },

    data() {
        return {
            chart: null
        };
    },

    mounted() {
        this.createChart();
    },

    beforeUnmount() {
        if (this.chart) {
            this.chart.destroy();
        }
    },

    methods: {
        createChart() {
            const ctx = this.$refs.chartCanvas.getContext('2d');

            this.chart = new Chart(ctx, {
                type: 'bar',
                data: this.chartData,
                options: {
                    responsive: true,
                    ...this.chartOptions
                }
            });
        },

        exportPNG() {
            const base64 = this.chart.toBase64Image('image/png', 1.0);
            this.downloadBase64(base64, 'chart.png');
        },

        exportPNG_HD() {
            this.exportHighRes(3, 'chart-HD.png');
        },

        async sendToBackend() {
            const base64 = this.chart.toBase64Image('image/png', 1.0);
            const base64Data = base64.split(',')[1];

            try {
                const response = await fetch('/api/charts/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ chart_base64: base64Data })
                });

                const result = await response.json();

                if (result.success) {
                    this.$emit('chart-saved', result);
                    alert('✅ Grafico salvato!');
                }
            } catch (error) {
                console.error('Errore:', error);
                alert('❌ Errore nel salvataggio');
            }
        },

        downloadBase64(base64, filename) {
            const link = document.createElement('a');
            link.href = base64;
            link.download = filename;
            link.click();
        },

        exportHighRes(scale, filename) {
            const canvas = this.chart.canvas;
            const tempCanvas = document.createElement('canvas');
            const tempCtx = tempCanvas.getContext('2d');

            tempCanvas.width = canvas.width * scale;
            tempCanvas.height = canvas.height * scale;
            tempCtx.scale(scale, scale);
            tempCtx.drawImage(canvas, 0, 0);

            tempCanvas.toBlob((blob) => {
                const url = URL.createObjectURL(blob);
                this.downloadBase64(url, filename);
                setTimeout(() => URL.revokeObjectURL(url), 100);
            }, 'image/png', 1.0);
        }
    }
};
</script>

<style scoped>
.chart-wrapper {
    padding: 20px;
}

.chart-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.export-controls {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-primary {
    background: #3B82F6;
    color: white;
}

.btn-success {
    background: #10B981;
    color: white;
}

.btn-warning {
    background: #F59E0B;
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
```

---

## Integration con Laravel Backend

### Backend Handler

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChartController extends Controller
{
    /**
     * Salva grafico Chart.js inviato da frontend
     */
    public function saveChart(Request $request)
    {
        $validated = $request->validate([
            'chart_base64' => 'required|string',
            'title' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:bar,line,pie,doughnut',
        ]);

        // 1. Decodifica base64
        $imageData = base64_decode($validated['chart_base64']);

        if ($imageData === false) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid base64 data'
            ], 400);
        }

        // 2. Genera filename unico
        $filename = 'charts/' . uniqid('chart_') . '.png';

        // 3. Salva su storage
        $stored = Storage::disk('public')->put($filename, $imageData);

        if (!$stored) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to save file'
            ], 500);
        }

        // 4. Ottieni info file
        $path = Storage::disk('public')->path($filename);
        $url = Storage::disk('public')->url($filename);
        $size = Storage::disk('public')->size($filename);

        // 5. (Opzionale) Salva metadata nel database
        // $chart = Chart::create([
        //     'title' => $validated['title'] ?? 'Untitled Chart',
        //     'type' => $validated['type'] ?? 'unknown',
        //     'filename' => $filename,
        //     'path' => $path,
        //     'size' => $size,
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Chart saved successfully',
            'data' => [
                'filename' => $filename,
                'path' => $path,
                'url' => $url,
                'size' => $size,
            ],
        ]);
    }
}
```

### Routes

```php
// routes/api.php
use App\Http\Controllers\ChartController;

Route::post('/charts/save', [ChartController::class, 'saveChart'])
    ->middleware('auth:sanctum');
```

---

## Troubleshooting

### Problema 1: Download Non Funziona

**Sintomo:** Click sul pulsante ma nessun download

**Soluzione:**

```javascript
// ✅ Verifica che il base64 sia valido
const base64 = myChart.toBase64Image();

if (!base64 || base64.length < 100) {
    console.error('❌ Base64 vuoto o invalido');
    return;
}

// ✅ Forza download con timeout
setTimeout(() => {
    const link = document.createElement('a');
    link.href = base64;
    link.download = 'chart.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}, 100);
```

### Problema 2: Qualità Bassa PNG

**Sintomo:** Immagine esportata è pixelata

**Soluzione:**

```javascript
// ✅ Usa qualità massima
const base64 = myChart.toBase64Image('image/png', 1.0); // 1.0 = max quality

// ✅ Export ad alta risoluzione
exportHighResPNG(myChart, 3, 'chart-HD.png'); // 3x resolution
```

### Problema 3: File PNG Troppo Pesante

**Sintomo:** PNG > 5MB

**Soluzione:**

```javascript
// ✅ Usa JPEG con compressione
const base64 = myChart.toBase64Image('image/jpeg', 0.8); // 80% quality

// Oppure riduci dimensioni canvas
myChart.resize(600, 400); // Riduci dimensioni
```

### Problema 4: SVG Non Vettoriale

**Sintomo:** SVG esportato non scala bene

**Soluzione:**

```javascript
// ❌ Evita canvas-to-SVG (crea PNG embedded)
// const svg = canvasToSVG(canvas);

// ✅ Usa plugin chart2svg
import { toSVG } from 'chartjs-to-svg';
const svg = toSVG(myChart); // Vero SVG vettoriale

// Oppure usa backend con libreria SVG nativa
```

---

## Riepilogo

### PNG Export

| Metodo | Qualità | Dimensione File | Facilità | Raccomandato |
|--------|---------|-----------------|----------|--------------|
| `toBase64Image()` | ⭐⭐⭐⭐ | Media | ⭐⭐⭐⭐⭐ | ✅ Sì |
| `toBlob()` | ⭐⭐⭐⭐ | Media | ⭐⭐⭐⭐ | ✅ Sì |
| `High-Res (3x)` | ⭐⭐⭐⭐⭐ | Grande | ⭐⭐⭐ | ✅ Per stampa |
| `JPEG` | ⭐⭐⭐ | Piccola | ⭐⭐⭐⭐⭐ | ✅ Per web |

### SVG Export

| Metodo | Qualità | Vettoriale | Facilità | Raccomandato |
|--------|---------|------------|----------|--------------|
| `chart2svg plugin` | ⭐⭐⭐⭐ | ✅ Sì | ⭐⭐⭐ | ✅ Sì |
| `canvas-to-SVG` | ⭐⭐ | ❌ No | ⭐⭐⭐⭐⭐ | ❌ Solo fallback |
| `Server-side` | ⭐⭐⭐⭐⭐ | ✅ Sì | ⭐⭐ | ✅ Per qualità max |

---

## Link Utili

- [Chart.js Documentation](https://www.chartjs.org/docs/latest/)
- [chart2svg Plugin](https://github.com/toyobayashi/chartjs-to-svg)
- [Canvas API - toDataURL](https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/toDataURL)
- [Canvas API - toBlob](https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/toBlob)

---

*Guida Chart.js Export SVG/PNG v1.0 - Creato: 2025-11-17*
*Modulo Chart - Architettura Laraxot*
