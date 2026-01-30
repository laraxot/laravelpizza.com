# JPGraph - Guida Passo-Passo

## 📋 Indice
1. [Introduzione](#introduzione)
2. [Installazione e Configurazione](#installazione-e-configurazione)
3. [Creare un Grafico Base](#creare-un-grafico-base)
4. [Tipi di Grafici Disponibili](#tipi-di-grafici-disponibili)
5. [Export in PNG](#export-in-png)
6. [Export in SVG](#export-in-svg)
7. [Personalizzazione Grafica](#personalizzazione-grafica)
8. [Esempi Pratici](#esempi-pratici)
9. [Best Practices](#best-practices)

---

## Introduzione

**JPGraph** è una libreria PHP per la generazione di grafici server-side di alta qualità. Nel nostro stack Laraxot, JPGraph è utilizzato principalmente per:

- **Generazione PDF**: Grafici di alta qualità da incorporare in PDF
- **Report statici**: Immagini grafiche per documenti
- **Export batch**: Generazione massiva di grafici senza overhead JavaScript

### Perché JPGraph per i PDF?

- ✅ **Nessuna dipendenza JavaScript**: Rendering completamente server-side
- ✅ **Alta qualità**: Output PNG/SVG perfetto per stampa
- ✅ **Performance**: Ottimizzato per batch processing
- ✅ **Controllo totale**: Styling preciso pixel-per-pixel

---

## Installazione e Configurazione

### Verifica Installazione

JPGraph è già installato tramite Composer come `amenadiel/jpgraph`:

```bash
composer show amenadiel/jpgraph
```

### Configurazione Base

Nel modulo Chart, JPGraph è configurato tramite `ChartData`:

```php
// Modules/Chart/app/Datas/ChartData.php
class ChartData extends Data
{
    public int $width = 600;        // Larghezza grafico (px)
    public int $height = 400;       // Altezza grafico (px)
    public string $list_color = '#d60021';  // Colori
    public int $font_family = 15;   // Font (FF_ARIAL = 15)
    public int $font_style = 9002;  // Stile font (FS_NORMAL = 9002)
    public int $font_size = 12;     // Dimensione font
    // ... altre proprietà
}
```

---

## Creare un Grafico Base

### Passo 1: Preparare i Dati

```php
// I tuoi dati
$labels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag'];
$values = [65, 78, 45, 92, 58];

// Crea ChartData
$chartData = ChartData::from([
    'type' => 'horizbar1',
    'width' => 600,
    'height' => 400,
    'title' => 'Vendite Mensili',
    'list_color' => '#3B82F6',
    'font_family' => FF_ARIAL,
    'font_style' => FS_NORMAL,
    'font_size' => 12,
]);
```

### Passo 2: Creare il Graph Object

Usa `GetGraphAction` per creare il grafico base:

```php
use Modules\Chart\Actions\JpGraph\GetGraphAction;

// Crea il graph
$graph = app(GetGraphAction::class)->execute($chartData);

// Il graph è già configurato con:
// - Dimensioni (width x height)
// - Tema e stile
// - Title e subtitle
// - Assi X e Y configurati
```

### Passo 3: Aggiungere il Plot

```php
use Amenadiel\JpGraph\Plot\BarPlot;

// Crea il plot con i dati
$plot = new BarPlot($values);

// Configura colori e stile
$plot->SetFillColor('#3B82F6');
$plot->SetColor('#1E40AF');

// Configura etichette asse X
$graph->xaxis->SetTickLabels($labels);

// Aggiungi plot al grafico
$graph->Add($plot);
```

### Passo 4: Generare l'Output

```php
// Output diretto (browser)
$graph->Stroke();

// Salva in file
$graph->Stroke('/path/to/chart.png');

// Ottieni l'immagine come risorsa
$imageData = $graph->Stroke(_IMG_HANDLER);
imagepng($imageData, '/path/to/chart.png');
imagedestroy($imageData);
```

---

## Tipi di Grafici Disponibili

### 1. Bar Chart (Barre Verticali)

```php
use Modules\Chart\Actions\JpGraph\V1\Bar2Action;
use Modules\Chart\Datas\AnswersChartData;

// Prepara i dati
$answersChartData = AnswersChartData::from([
    'chart' => $chartData,
    'answers' => [
        ['label' => 'Prodotto A', 'avg' => 65],
        ['label' => 'Prodotto B', 'avg' => 78],
        ['label' => 'Prodotto C', 'avg' => 45],
    ],
]);

// Genera il grafico
$graph = app(Bar2Action::class)->execute($answersChartData);
$graph->Stroke('/path/to/bar-chart.png');
```

**Personalizzazione Bar Chart:**

```php
use Amenadiel\JpGraph\Plot\BarPlot;

$plot = new BarPlot($values);

// Larghezza barre (0.0 - 1.0)
$plot->SetWidth(0.8);

// Mostra valori sopra le barre
$plot->value->Show();
$plot->value->SetFont(FF_ARIAL, FS_BOLD, 10);
$plot->value->SetColor('black');
$plot->value->SetFormat('%.1f');

// Ombreggiatura
$plot->SetShadow('darkgray', 2, 2);
```

### 2. Horizontal Bar Chart (Barre Orizzontali)

```php
use Modules\Chart\Actions\JpGraph\V1\Horizbar1Action;

// Genera grafico orizzontale
$graph = app(Horizbar1Action::class)->execute($answersChartData);
$graph->Stroke('/path/to/horizbar-chart.png');
```

**Configurazione speciale per Horizbar:**

```php
use Amenadiel\JpGraph\Graph\Graph;

$graph = new Graph($width, $height);
$graph->SetScale('textlin'); // Scala lineare con etichette testuali

// Ruota etichette asse X (utile per nomi lunghi)
$graph->xaxis->SetLabelAngle(45);
```

### 3. Pie Chart (Torta)

```php
use Modules\Chart\Actions\JpGraph\V1\Pie1Action;

// Genera pie chart
$graph = app(Pie1Action::class)->execute($answersChartData);
$graph->Stroke('/path/to/pie-chart.png');
```

**Personalizzazione Pie Chart:**

```php
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;

$graph = new PieGraph($width, $height);
$plot = new PiePlotC($values);

// Colori fette (con trasparenza)
$colors = ['#3B82F6@0.8', '#10B981@0.8', '#F59E0B@0.8'];
$plot->SetSliceColors($colors);

// Legenda
$plot->SetLegends(['Opzione A', 'Opzione B', 'Opzione C']);

// Guide lines (linee di collegamento)
$plot->SetGuideLines(true, false);
$plot->SetGuideLinesAdjust(1.5);

// Formato valori (percentuale)
$plot->SetLabelType(PIE_VALUE_PER);
$plot->value->SetFormat('%2.1f%%');

// Dimensione "buco" centrale (donut)
$plot->SetMidSize(0.8); // 0 = pieno, 1 = solo bordo
```

### 4. Line Chart (Linee)

```php
use Modules\Chart\Actions\JpGraph\V1\LineSubQuestionAction;
use Amenadiel\JpGraph\Plot\LinePlot;

// Line plot base
$plot = new LinePlot($values);

// Stile linea
$plot->SetColor('#3B82F6');
$plot->SetWeight(2); // Spessore linea

// Marker (punti)
$plot->mark->SetType(MARK_FILLEDCIRCLE);
$plot->mark->SetFillColor('#1E40AF');
$plot->mark->SetWidth(6);

// Area riempita sotto la linea
$plot->SetFillColor('#3B82F6@0.2'); // Colore con trasparenza
```

### 5. Radar Chart (Spider/Ragnatela)

```php
use Amenadiel\JpGraph\Graph\RadarGraph;
use Amenadiel\JpGraph\Plot\RadarPlot;

// Radar graph per Likert scale
$graph = new RadarGraph($width, $height);
$graph->SetScale('lin', 0, 5); // Scala 0-5

$plot = new RadarPlot($values);
$plot->SetColor('#3B82F6', 2); // Colore e spessore
$plot->SetFillColor('#3B82F6@0.2'); // Riempimento trasparente

// Titoli assi
$graph->SetTitles(['Criterio A', 'Criterio B', 'Criterio C']);

$graph->Add($plot);
```

---

## Export in PNG

### Metodo 1: Diretto su File System

```php
use Amenadiel\JpGraph\Graph\Graph;

// Crea e configura il grafico
$graph = new Graph(600, 400);
// ... configurazione ...

// Salva direttamente in PNG
$filePath = storage_path('app/charts/my-chart.png');
$graph->Stroke($filePath);

// Ritorna il path per uso successivo
return $filePath;
```

### Metodo 2: In-Memory con Base64 (per PDF)

```php
// Genera l'immagine in memoria
$imageData = $graph->Stroke(_IMG_HANDLER);

// Salva temporaneamente
$tempPath = storage_path('app/temp/chart-' . uniqid() . '.png');
imagepng($imageData, $tempPath);

// Converti in base64 per embedding in HTML/PDF
$base64 = base64_encode(file_get_contents($tempPath));

// Pulisci memoria
imagedestroy($imageData);

// Usa in HTML
$imageTag = '<img src="data:image/png;base64,' . $base64 . '" />';
```

### Metodo 3: Con Qualità e Compressione

```php
// Genera immagine
$imageData = $graph->Stroke(_IMG_HANDLER);

// Salva con qualità specifica (0-9, dove 9 = massima compressione)
$quality = 6; // Compromesso qualità/dimensione
imagepng($imageData, $filePath, $quality);

imagedestroy($imageData);
```

### Esempio Completo: Action per Export PNG

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Amenadiel\JpGraph\Graph\Graph;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

class ExportChartToPngAction
{
    use QueueableAction;

    /**
     * Esporta un grafico JPGraph in PNG
     *
     * @param Graph $graph Grafico JPGraph configurato
     * @param string|null $filename Nome file (opzionale)
     * @param string $disk Disco storage Laravel
     * @param int $quality Qualità PNG (0-9)
     * @return array{path: string, base64: string, size: int}
     */
    public function execute(
        Graph $graph,
        ?string $filename = null,
        string $disk = 'public',
        int $quality = 6
    ): array {
        // Genera nome file se non fornito
        $filename = $filename ?? 'chart-' . uniqid() . '.png';

        // Ottieni path completo
        $path = Storage::disk($disk)->path($filename);

        // Genera immagine in memoria
        $imageData = $graph->Stroke(_IMG_HANDLER);

        // Salva con qualità specificata
        imagepng($imageData, $path, $quality);

        // Ottieni dimensione file
        $size = filesize($path);

        // Genera base64 per embedding
        $base64 = base64_encode(file_get_contents($path));

        // Pulisci memoria
        imagedestroy($imageData);

        return [
            'path' => $path,
            'url' => Storage::disk($disk)->url($filename),
            'base64' => $base64,
            'size' => $size,
            'width' => imagesx($imageData),
            'height' => imagesy($imageData),
        ];
    }
}
```

---

## Export in SVG

⚠️ **Nota importante**: JPGraph supporta SVG **in modo limitato**. Per export SVG di qualità professionale, si consiglia Chart.js (vedi documentazione separata).

### Export SVG con JPGraph

```php
use Amenadiel\JpGraph\Graph\Graph;

// Crea il grafico
$graph = new Graph(600, 400);
// ... configurazione ...

// Abilita output SVG
$graph->SetBackgroundImage('', BGIMG_FILLFRAME);

// Genera SVG
$svgData = $graph->StrokeSVG();

// Salva in file
file_put_contents('/path/to/chart.svg', $svgData);
```

### Limitazioni SVG in JPGraph

- ❌ **Supporto incompleto**: Non tutti i tipi di grafico supportano SVG
- ❌ **Qualità variabile**: Alcuni elementi potrebbero non renderizzare correttamente
- ❌ **Font limitati**: Supporto font più limitato rispetto a PNG

### Alternativa: Chart.js per SVG

Per export SVG di qualità, usa **Chart.js** (vedi `chart-js-export-guide.md`):

```javascript
// Client-side con Chart.js
const canvas = document.getElementById('myChart');
const svg = canvasToSVG(canvas);
```

---

## Personalizzazione Grafica

### 1. Colori e Temi

```php
use Amenadiel\JpGraph\Themes\UniversalTheme;

// Applica tema universale
$theme = new UniversalTheme();
$graph->SetTheme($theme);

// Colori personalizzati
$colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];

// Colore sfondo
$graph->SetMarginColor('white');
$graph->SetBackgroundGradient('#E0E7FF', '#FFFFFF', GRAD_HOR);

// Ombreggiatura grafico
$graph->SetShadow(true);
```

### 2. Font e Testo

```php
// Costanti font JPGraph
define('FF_ARIAL', 15);
define('FS_NORMAL', 9002);
define('FS_BOLD', 9001);
define('FS_ITALIC', 9003);

// Configura title
$graph->title->Set('Titolo Grafico');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->title->SetColor('#1E40AF');

// Configura subtitle
$graph->subtitle->Set('Sottotitolo');
$graph->subtitle->SetFont(FF_ARIAL, FS_NORMAL, 11);

// Footer
$graph->footer->center->Set('Generato da Laraxot Survey System');
$graph->footer->center->SetFont(FF_ARIAL, FS_NORMAL, 8);
$graph->footer->center->SetColor('#6B7280');
```

### 3. Assi e Griglia

```php
// Asse X
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
$graph->xaxis->SetLabelAngle(45); // Ruota etichette
$graph->xaxis->SetLabelMargin(10); // Margine etichette
$graph->xaxis->SetColor('#666666');

// Asse Y
$graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
$graph->yaxis->HideZeroLabel(); // Nascondi etichetta 0
$graph->yaxis->HideLine(false); // Mostra linea asse

// Griglia
$graph->ygrid->Show();
$graph->ygrid->SetColor('#E5E7EB');
$graph->ygrid->SetLineStyle('dashed');

// Grace (spazio extra assi)
if (is_object($graph->yaxis->scale)) {
    $graph->yaxis->scale->SetGrace(10); // 10% spazio extra
}
```

### 4. Margini e Layout

```php
// Margini (sinistra, destra, alto, basso)
$graph->img->SetMargin(50, 30, 40, 80);

// Box intorno al grafico
$graph->SetBox(true, '#CCCCCC', 2);

// Frame intorno all'intera immagine
$graph->SetFrame(true, '#000000', 1);
```

---

## Esempi Pratici

### Esempio 1: Bar Chart per Survey Report

```php
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\ChartData;
use Amenadiel\JpGraph\Plot\BarPlot;

// Dati survey
$questionText = "Quanto sei soddisfatto del servizio?";
$responses = [
    'Molto insoddisfatto' => 5,
    'Insoddisfatto' => 12,
    'Neutrale' => 28,
    'Soddisfatto' => 45,
    'Molto soddisfatto' => 38,
];

// Prepara dati per JPGraph
$labels = array_keys($responses);
$values = array_values($responses);

// Crea ChartData
$chartData = ChartData::from([
    'type' => 'bar',
    'width' => 700,
    'height' => 450,
    'title' => $questionText,
    'subtitle' => 'n = ' . array_sum($values) . ' risposte',
    'list_color' => '#3B82F6',
    'font_family' => FF_ARIAL,
    'font_size' => 11,
    'x_label_angle' => 25,
    'show_box' => false,
]);

// Crea grafico
$graph = app(GetGraphAction::class)->execute($chartData);

// Crea plot
$plot = new BarPlot($values);
$plot->SetFillColor('#3B82F6@0.8');
$plot->SetColor('#1E40AF');
$plot->SetWidth(0.7);

// Mostra valori
$plot->value->Show();
$plot->value->SetFont(FF_ARIAL, FS_BOLD, 10);
$plot->value->SetColor('white');
$plot->value->SetFormat('%d');

// Configura X axis
$graph->xaxis->SetTickLabels($labels);

// Aggiungi plot
$graph->Add($plot);

// Salva per PDF
$imageData = $graph->Stroke(_IMG_HANDLER);
$pngPath = storage_path('app/charts/satisfaction-' . uniqid() . '.png');
imagepng($imageData, $pngPath, 6);
imagedestroy($imageData);

// Ritorna path per embedding in PDF
return $pngPath;
```

### Esempio 2: Pie Chart Multi-Colore

```php
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;

// Dati
$data = [120, 85, 65, 45, 30];
$labels = ['Categoria A', 'Categoria B', 'Categoria C', 'Categoria D', 'Categoria E'];

// Colori personalizzati (palette Tailwind)
$colors = [
    '#3B82F6@0.9', // blue-500
    '#10B981@0.9', // green-500
    '#F59E0B@0.9', // amber-500
    '#EF4444@0.9', // red-500
    '#8B5CF6@0.9', // violet-500
];

// Crea grafico
$graph = new PieGraph(600, 500);
$graph->SetShadow();

// Title
$graph->title->Set('Distribuzione per Categoria');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->title->SetColor('#1E40AF');

// Crea pie plot
$plot = new PiePlotC($data);
$plot->SetSliceColors($colors);
$plot->SetLegends($labels);

// Guide lines
$plot->SetGuideLines(true, false);
$plot->SetGuideLinesAdjust(1.5);

// Valori percentuale
$plot->SetLabelType(PIE_VALUE_PER);
$plot->value->Show();
$plot->value->SetFont(FF_ARIAL, FS_BOLD, 11);
$plot->value->SetColor('black');
$plot->value->SetFormat('%2.1f%%');

// Donut style (60% riempimento)
$plot->SetMidSize(0.6);
$plot->SetMidColor('white');

// Aggiungi plot
$graph->Add($plot);

// Export
$graph->Stroke('/path/to/pie-chart.png');
```

### Esempio 3: Line Chart Temporale

```php
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;

// Dati temporali
$dates = ['01/11', '02/11', '03/11', '04/11', '05/11', '06/11', '07/11'];
$values = [45, 52, 48, 61, 58, 67, 72];

// Crea grafico
$graph = new Graph(800, 400);
$graph->SetScale('textlin');
$graph->SetShadow();

// Margini
$graph->img->SetMargin(60, 30, 40, 80);

// Title
$graph->title->Set('Andamento Settimanale');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// Griglia
$graph->ygrid->Show();
$graph->ygrid->SetColor('#E5E7EB');

// Crea line plot
$plot = new LinePlot($values);
$plot->SetColor('#3B82F6');
$plot->SetWeight(3);

// Marker
$plot->mark->SetType(MARK_FILLEDCIRCLE);
$plot->mark->SetFillColor('#1E40AF');
$plot->mark->SetWidth(8);

// Area riempita
$plot->SetFillColor('#3B82F6@0.15');

// Asse X
$graph->xaxis->SetTickLabels($dates);
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
$graph->xaxis->title->Set('Data');

// Asse Y
$graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
$graph->yaxis->title->Set('Valore');

// Aggiungi plot
$graph->Add($plot);

// Export
$graph->Stroke('/path/to/line-chart.png');
```

---

## Best Practices

### 1. Performance

```php
// ✅ BUONO: Usa batch processing per molti grafici
$charts = [];
foreach ($questions as $question) {
    $graph = $this->createChart($question);
    $charts[] = $this->exportToPng($graph);
}

// ✅ BUONO: Pulisci sempre la memoria
$imageData = $graph->Stroke(_IMG_HANDLER);
imagepng($imageData, $path);
imagedestroy($imageData); // IMPORTANTE!

// ❌ CATTIVO: Non generare grafici sincroni in request HTTP
// Usa queue per generazione massiva
```

### 2. Qualità Output

```php
// ✅ BUONO: Usa dimensioni appropriate per PDF
$width = 700;  // Buona larghezza per A4
$height = 450; // Buona altezza per visibilità

// ✅ BUONO: Usa qualità PNG equilibrata
$quality = 6; // Compromesso dimensione/qualità

// ❌ CATTIVO: Non usare dimensioni troppo piccole
$width = 200; // Illeggibile in PDF!
```

### 3. Colori e Accessibilità

```php
// ✅ BUONO: Usa palette accessibili
$colors = [
    '#3B82F6', // blue - visibile
    '#10B981', // green - visibile
    '#F59E0B', // amber - visibile
];

// ✅ BUONO: Usa contrasto sufficiente
$backgroundColor = 'white';
$textColor = '#333333'; // Contrasto alto

// ❌ CATTIVO: Colori troppo simili
$colors = ['#FF0000', '#FE0100']; // Indistinguibili!
```

### 4. Gestione Errori

```php
try {
    $graph = $this->createChart($data);
    $path = $this->exportToPng($graph);
} catch (\Exception $e) {
    // Log error
    Log::error('Chart generation failed', [
        'error' => $e->getMessage(),
        'data' => $data,
    ]);

    // Return fallback
    return $this->createFallbackChart($data);
}
```

### 5. Caching

```php
use Illuminate\Support\Facades\Cache;

// Caching intelligente
$cacheKey = 'chart-' . md5(json_encode($data));

$chartPath = Cache::remember($cacheKey, 3600, function () use ($data) {
    $graph = $this->createChart($data);
    return $this->exportToPng($graph);
});
```

---

## Riferimenti

- [JPGraph Official Documentation](https://jpgraph.net/doc/)
- [Modules/Chart/docs/philosophy.md](./philosophy.md) - Filosofia modulo Chart
- [Modules/Quaeris/docs/charts-pdf-generation-complete.md](../../Quaeris/docs/charts-pdf-generation-complete.md) - Guida PDF completa
- [chart-js-export-guide.md](./chart-js-export-guide.md) - Guida Chart.js export

---

*Guida JPGraph v1.0 - Creato: 2025-11-17*
*Modulo Chart - Architettura Laraxot*
