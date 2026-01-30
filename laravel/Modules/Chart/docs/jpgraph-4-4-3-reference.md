# JpGraph 4.4.3 - Riferimento Completo

**Versione**: 4.4.3 (26 Gennaio 2026)
**Supporto PHP**: 5.1+ / 7.x / 8.0-8.5
**Licenza**: QPL 1.0 (non-commerciale) / JpGraph Professional (commerciale)
**Ultimo Aggiornamento Documentazione**: Gennaio 2026

---

## Indice

1. [Panoramica](#panoramica)
2. [Installazione](#installazione)
3. [Struttura Manuale Ufficiale](#struttura-manuale-ufficiale)
4. [Tipi di Grafici](#tipi-di-grafici)
5. [Classi Principali](#classi-principali)
6. [Pattern di Utilizzo nel Progetto](#pattern-di-utilizzo-nel-progetto)
7. [Configurazioni Avanzate](#configurazioni-avanzate)
8. [Performance e Caching](#performance-e-caching)
9. [Risorse e Documentazione](#risorse-e-documentazione)

---

## Panoramica

### Cos'è JpGraph

JpGraph è una libreria PHP object-oriented per la generazione di grafici server-side. Genera immagini PNG ad alta qualità senza dipendenze JavaScript, ideale per:

- **Generazione PDF**: Grafici embedded in documenti PDF
- **Report automatizzati**: Grafici generati in batch/queue
- **Dashboard backend**: Immagini statiche per email/export
- **Ambienti senza browser**: CLI, cron jobs, API

### Novità Versione 4.4.3

- **PHP 8.5 Support**: Piena compatibilità con PHP 8.5
- **Miglioramenti Performance**: Ottimizzazioni rendering
- **Bug Fix**: Correzioni varie per compatibilità

### Requisiti di Sistema

| Requisito | Minimo | Consigliato |
|-----------|--------|-------------|
| PHP | 5.1+ | 8.2+ |
| Estensione GD | Richiesta | - |
| Estensione FreeType | Consigliata | Per font TTF |
| Memory Limit | 128MB | 256MB+ |

---

## Installazione

### Via Composer - amenadiel/jpgraph (Usato nel Progetto)

Il progetto utilizza `amenadiel/jpgraph` che fornisce JpGraph con namespace PSR-4 `Amenadiel\JpGraph\*`:

```bash
cd laravel
composer require amenadiel/jpgraph:"^4.1"
```

La dipendenza e' dichiarata in `Modules/Chart/composer.json` e viene risolta automaticamente dal sistema `wikimedia/composer-merge-plugin`.

### Utilizzo Base

```php
// Importa le classi con namespace PSR-4
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;

// Usa classi JpGraph normalmente
$graph = new Graph(800, 400);
$graph->SetScale('textlin');

$plot = new BarPlot([10, 20, 30]);
$graph->Add($plot);
$graph->Stroke('/path/to/chart.png');
```

### Package Alternativo: mitoteam/jpgraph

Esiste un package alternativo con patch PHP 8.5:

```bash
composer require mitoteam/jpgraph
```

**Differenze**:
- `mitoteam/jpgraph` v10.5.x: Include patch PHP 8.2-8.5, Extended Mode, namespace diverso
- `amenadiel/jpgraph` v4.x: Namespace PSR-4 `Amenadiel\JpGraph\*`, usato nel progetto

### Download Manuale

Download da [jpgraph.net/download](https://jpgraph.net/download/):
- **jpgraph-4.4.3.tar.gz** (12.7 MB) - Versione Free
- **jpgraph-4.4.3-pro.tar.gz** - Versione Professional

---

## Struttura Manuale Ufficiale

Il manuale JpGraph ufficiale comprende 750+ pagine organizzate in 9 parti:

### Parte I: Installazione e Configurazione (Cap. 1-3)

| Capitolo | Argomento |
|----------|-----------|
| 1 | Introduzione (licenza, prerequisiti, caratteristiche) |
| 2 | Installazione rapida per esperti PHP/Apache |
| 3 | Installazione dettagliata, requisiti, supporto font |

### Parte II: Creazione Grafici di Base (Cap. 4-10)

| Capitolo | Argomento |
|----------|-----------|
| 4 | Primo script grafico (esempio macchie solari) |
| 5 | Fondamenti generazione dinamica (stream HTTP, cache) |
| 6 | Gestione errori e localizzazione |
| 7 | Gestione colori (nomi, RGB, HTML, trasparenza) |
| 8 | Testo e font (TTF, rotazione, Unicode, codifiche) |
| 9 | Sistema cache automatico |
| 10 | Mappe immagine lato client (CSIM) |

### Parte III: Caratteristiche Comuni (Cap. 12-14)

| Capitolo | Argomento |
|----------|-----------|
| 12 | Oggetti comuni (assi, legende, griglie) |
| 13 | Sorgenti dati (file, database, URI, NULL) |
| 14 | Grafici cartesiani (scale, assi multipli, log, date, gradienti) |

### Parte IV: Grafici Lineari e Non-Lineari (Cap. 15-18)

| Capitolo | Argomento |
|----------|-----------|
| 15 | Tipi lineari (linee, aree, barre, errori, stock, scatter, contour) |
| 16 | Tipi non-lineari (torta, radar, polare, Gantt) |
| 17 | Tipi aggiuntivi (LED, CAPTCHA, canvas) |
| 18 | Regressione lineare |

### Parte V: Tipi Professional (Cap. 19-23)

| Capitolo | Argomento |
|----------|-----------|
| 19 | Tabelle grafiche |
| 20 | Odometri |
| 21 | Windrose (rose dei venti) |
| 22 | Grafici matrice |
| 23 | Contour riempito |

### Parte VI: Codici a Barre (Cap. 24-27)

| Capitolo | Argomento |
|----------|-----------|
| 24 | Codici lineari (1D) |
| 25 | PDF417 (2D) |
| 26 | Datamatrix (2D) |
| 27 | QR (2D) |

### Parti VII-IX: Temi, Case Study, Appendici (Cap. 28-35+)

- **Cap. 28-31**: Temi predefiniti e personalizzati
- **Cap. 32-35**: Case study (assi sincronizzati, USPS, statistiche, Gantt avanzato)
- **Appendici**: FAQ, colori nominati, marcatori, bandiere, error messages, compilazione PHP

---

## Tipi di Grafici

### Grafici Lineari (Versione Free)

| Tipo | Classe | Descrizione |
|------|--------|-------------|
| Line | `LinePlot` | Grafico a linee |
| Area | `LinePlot` + `SetFillColor()` | Area riempita |
| Bar | `BarPlot` | Barre verticali |
| Horizontal Bar | `BarPlot` + `RotateGraph()` | Barre orizzontali |
| Grouped Bar | `GroupBarPlot` | Barre raggruppate |
| Stacked Bar | `AccBarPlot` | Barre impilate |
| Scatter | `ScatterPlot` | Punti dispersi |
| Error | `ErrorPlot` | Barre di errore |
| Stock | `StockPlot` | OHLC finanziario |
| Contour | `ContourPlot` | Curve di livello |

### Grafici Non-Lineari (Versione Free)

| Tipo | Classe | Descrizione |
|------|--------|-------------|
| Pie 2D | `PiePlot` | Torta 2D |
| Pie 3D | `PiePlot3D` | Torta 3D |
| Donut | `PiePlotC` | Torta con centro |
| Radar | `RadarPlot` | Spider/Radar |
| Polar | `PolarPlot` | Coordinate polari |
| Gantt | `GanttGraph` | Diagramma Gantt |

### Grafici Professional

| Tipo | Classe | Descrizione |
|------|--------|-------------|
| Odometer | `OdoGraph` | Indicatori gauge |
| Windrose | `WindroseGraph` | Rose dei venti |
| Matrix | `MatrixGraph` | Grafici matrice |
| Filled Contour | `FilledContourPlot` | Contour colorato |

### Barcodes (Professional)

- Linear (1D): Code39, Code128, EAN13, UPC, etc.
- PDF417 (2D)
- Datamatrix (2D)
- QR Code (2D)

---

## Namespace (amenadiel/jpgraph)

Il progetto usa il package `amenadiel/jpgraph` con namespace PSR-4:

```php
// Graph
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Legend;

// Plot
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Plot\AccBarPlot;

// Text e Themes
use Amenadiel\JpGraph\Text\Text;
use Amenadiel\JpGraph\Themes\UniversalTheme;
```

Per dettagli completi su namespace e installazione, vedere: [jpgraph-installation-and-namespaces.md](./jpgraph-installation-and-namespaces.md)

---

## Classi Principali

### Graph

```php
// Costruttore
$graph = new Graph($width, $height, $cache_name = null, $timeout = 0);

// Metodi fondamentali
$graph->SetScale('textlin');      // Scale: textlin, linlin, loglin, datlin
$graph->SetShadow();              // Ombra
$graph->SetTheme($theme);         // Tema
$graph->SetBox(true|false);       // Box/bordo
$graph->SetMargin($l, $r, $t, $b); // Margini
$graph->Add($plot);               // Aggiungi plot
$graph->Stroke($filename);        // Genera PNG

// Proprietà
$graph->title                     // Text: titolo
$graph->subtitle                  // Text: sottotitolo
$graph->footer->center            // Text: footer centro
$graph->xaxis                     // Axis: asse X
$graph->yaxis                     // Axis: asse Y
$graph->yscale                    // Scale: scala Y
$graph->ygrid                     // Grid: griglia Y
$graph->legend                    // Legend: legenda
```

### PieGraph

```php
// Costruttore (specializzato per pie charts)
$graph = new PieGraph($width, $height, $cache_name = null);

// Eredita tutti i metodi di Graph
```

### BarPlot

```php
// Costruttore
$plot = new BarPlot($data_array);

// Metodi principali
$plot->SetFillColor($color);      // Colore riempimento (supporta @alpha)
$plot->SetColor($color);          // Colore bordo
$plot->SetWidth($width);          // Larghezza (0.0-1.0)
$plot->SetValuePos('top');        // Posizione valori: top, center, bottom
$plot->SetLegend($text);          // Testo legenda

// Proprietà
$plot->value                      // Text: configurazione valori
```

### LinePlot

```php
// Costruttore
$plot = new LinePlot($data_array);

// Metodi principali
$plot->SetColor($color);          // Colore linea
$plot->SetWeight($weight);        // Spessore linea
$plot->SetFillColor($color);      // Riempimento (area chart)
$plot->SetCenter();               // Centra punti

// Proprietà
$plot->mark                       // PlotMark: configurazione marker
```

### PiePlotC

```php
// Costruttore (pie con centro/donut)
$plot = new PiePlotC($data_array);

// Metodi principali
$plot->SetSliceColors($colors);   // Array colori slice
$plot->SetLegends($labels);       // Array labels
$plot->SetGuideLines(true);       // Linee guida
$plot->SetLabelType(PIE_VALUE_PER); // Tipo label: ABS, PER, ADJPER
$plot->SetMidSize($size);         // Dimensione centro (donut)
$plot->SetMidColor($color);       // Colore centro
```

### GroupBarPlot / AccBarPlot

```php
// Barre raggruppate
$group = new GroupBarPlot([$plot1, $plot2]);

// Barre impilate
$acc = new AccBarPlot([$plot1, $plot2]);
$acc->SetWidth($width);
```

### Axis

```php
// Metodi principali (via $graph->xaxis o $graph->yaxis)
$axis->SetTickLabels($labels);    // Labels tick
$axis->SetLabelAngle($angle);     // Rotazione labels
$axis->SetLabelMargin($margin);   // Margine labels
$axis->SetFont($family, $style, $size); // Font
$axis->HideZeroLabel();           // Nascondi zero
$axis->HideLine(true|false);      // Nascondi linea
$axis->HideTicks($major, $minor); // Nascondi tick
$axis->Hide();                    // Nascondi tutto
```

### Scale

```php
// Metodi principali (via $graph->yscale)
$scale->SetAutoMin(true|false);   // Auto min
$scale->SetAutoMax(true|false);   // Auto max
$scale->SetMin($value);           // Valore min manuale
$scale->SetMax($value);           // Valore max manuale
$scale->SetGrace($percent);       // Padding sopra max
```

### Text

```php
// Metodi principali (via title, subtitle, footer, value)
$text->Set($string);              // Imposta testo
$text->SetFont($family, $style, $size); // Font
$text->SetColor($color);          // Colore
$text->SetFormat($format);        // Formato numerico (%.1f, %2.1f%%)
$text->SetAlign($h, $v);          // Allineamento
$text->setAngle($angle);          // Rotazione
$text->SetPos($x, $y);            // Posizione (per Text aggiunti)
```

---

## Pattern di Utilizzo nel Progetto

### Architettura Actions

```
Modules/Chart/app/Actions/JpGraph/
├── GetGraphAction.php          # Crea Graph base
├── ApplyGraphStyleAction.php   # Applica stile globale
├── ApplyPlotStyleAction.php    # Applica stile plot
└── V1/
    ├── Bar1Action.php          # Bar chart semplice
    ├── Bar2Action.php          # Bar chart multiplo (GroupBarPlot)
    ├── Bar3Action.php          # Bar chart stacked (AccBarPlot)
    ├── Horizbar1Action.php     # Bar orizzontale
    ├── Pie1Action.php          # Pie chart (PiePlotC)
    ├── PieAvgAction.php        # Pie con media
    └── LineSubQuestionAction.php # Line chart multiplo
```

### Flusso Generazione

```
1. Dati Survey (SurveyResponse)
   ↓
2. DTO: AnswersChartData + ChartData
   ↓
3. Action Selection: ChartData->getActionClass()
   ↓
4. Action Execution: Bar1Action->execute()
   ↓
5. Graph Creation: GetGraphAction->execute()
   ↓
6. Plot Creation + Style: ApplyPlotStyleAction
   ↓
7. Graph->Add($plot)
   ↓
8. Graph->Stroke($file_path) → PNG
```

### Esempio Completo

```php
use Modules\Chart\Datas\ChartData;
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Actions\JpGraph\V1\Bar2Action;

// 1. Prepara ChartData
$chartData = ChartData::from([
    'type' => 'bar2',
    'width' => 800,
    'height' => 600,
    'list_color' => '#d60021,#0066cc',
    'transparency' => '0.8',
    'title' => 'Risultati Survey',
    'font_family' => FF_ARIAL,
    'font_style' => FS_BOLD,
    'font_size' => 12,
]);

// 2. Prepara AnswersChartData
$answersChartData = AnswersChartData::from([
    'answers' => $processedAnswers,
    'chart' => $chartData,
]);

// 3. Esegui Action
$graph = app(Bar2Action::class)->execute($answersChartData);

// 4. Salva PNG
$filePath = public_path('chart/result.png');
$graph->Stroke($filePath);
```

---

## Configurazioni Avanzate

### Colori con Trasparenza

```php
// Formato: '#RRGGBB@alpha' dove alpha = 0.0 (trasparente) - 1.0 (opaco)
$plot->SetFillColor('#d60021@0.8');  // Rosso 80% opaco

// Array colori
$colors = ['#d60021@0.8', '#0066cc@0.8', '#00cc66@0.8'];
```

### Font Constants

```php
// Font Families
FF_ARIAL    // Arial
FF_TIMES    // Times New Roman
FF_COURIER  // Courier
FF_VERDANA  // Verdana
FF_GEORGIA  // Georgia

// Font Styles
FS_NORMAL   // Normale
FS_BOLD     // Grassetto
FS_ITALIC   // Corsivo
FS_BOLDITALIC // Grassetto corsivo
```

### Formati Numerici

```php
$text->SetFormat('%.0f');      // Intero: 42
$text->SetFormat('%.1f');      // 1 decimale: 42.5
$text->SetFormat('%.2f');      // 2 decimali: 42.50
$text->SetFormat('%2.1f%%');   // Percentuale: 42.5%
$text->SetFormat('%.1f &#37;'); // Percentuale HTML entity
```

### Temi Disponibili

```php
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Amenadiel\JpGraph\Themes\OceanTheme;
use Amenadiel\JpGraph\Themes\PastelTheme;

$graph->SetTheme(new UniversalTheme());  // Default progetto
```

---

## Performance e Caching

### Memory Management

```php
// Per grafici complessi
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

try {
    $graph->Stroke($filePath);
} finally {
    ini_restore('memory_limit');
    ini_restore('max_execution_time');
}
```

### Cache JpGraph Built-in

```php
// Abilita cache con timeout (secondi)
$graph = new Graph(800, 400, 'cache_key_123', 3600);
```

### Cache Laravel

```php
$cacheKey = 'chart-'.$chartId.'-'.md5(serialize($filters));

$imagePath = Cache::tags(['charts'])
    ->remember($cacheKey, 3600, function () use ($chartData) {
        return $this->generateChart($chartData);
    });
```

### Generazione Asincrona

```php
// Usa queue per grafici pesanti
dispatch(function () use ($chartData, $filePath) {
    $graph = app(Bar2Action::class)->execute($chartData);
    $graph->Stroke($filePath);
})->onQueue('charts');
```

---

## Risorse e Documentazione

### Link Ufficiali

| Risorsa | URL |
|---------|-----|
| Sito Ufficiale | [jpgraph.net](https://jpgraph.net/) |
| Manuale Online | [jpgraph.net/download/manuals/chunkhtml](https://jpgraph.net/download/manuals/chunkhtml/index.html) |
| Class Reference | [jpgraph.net/download/manuals/classref](https://jpgraph.net/download/manuals/classref/index.html) |
| HowTo's | [jpgraph.net/doc/howto.php](https://jpgraph.net/doc/howto.php) |
| FAQ | [jpgraph.net/doc/faq.php](https://jpgraph.net/doc/faq.php) |
| Gallery | [jpgraph.net/features/gallery.php](https://jpgraph.net/features/gallery.php) |
| Download | [jpgraph.net/download](https://jpgraph.net/download/) |

### Package Composer

| Package | Usato nel Progetto | Descrizione |
|---------|-------------------|-------------|
| `amenadiel/jpgraph` | **SI** | Namespace PSR-4 `Amenadiel\JpGraph\*` |
| `mitoteam/jpgraph` | No (alternativa) | Patch PHP 8.5, Extended Mode |

### Documentazione Progetto

| File | Descrizione |
|------|-------------|
| `jpgraph-installation-and-namespaces.md` | **Installazione e Namespace** |
| `jpgraph-complete-guide.md` | Guida completa con esempi |
| `jpgraph-class-reference-complete.md` | Reference API dettagliata |
| `jpgraph-class-reference.md` | Quick reference |
| `jpgraph-best-practices-with-limesurvey-data-and-questionnaires.md` | Best practices LimeSurvey |
| `jpgraph-step-by-step-guide.md` | Guida passo-passo |
| `jpgraph-deep-dive-and-alternatives.md` | Analisi approfondita |
| `jpgraph-complete-integration-with-quaeris-module-features.md` | Integrazione Quaeris |
| `jpgraph-optimization-techniques-for-large-limesurvey-datasets.md` | Ottimizzazione |
| `jpgraph-vs-chartjs-pdf-integration-comparison.md` | Confronto Chart.js |

---

## Quick Reference Card

### Creazione Graph Base

```php
$graph = new Graph(800, 400);
$graph->SetScale('textlin');
$graph->SetShadow();
$graph->SetTheme(new UniversalTheme());
$graph->title->Set('Titolo');
```

### Bar Chart Semplice

```php
$plot = new BarPlot($data);
$plot->SetFillColor('#3b82f6@0.8');
$plot->SetWidth(0.6);
$graph->Add($plot);
```

### Pie Chart

```php
$graph = new PieGraph(500, 400);
$plot = new PiePlotC($data);
$plot->SetSliceColors($colors);
$plot->SetLegends($labels);
$plot->SetLabelType(PIE_VALUE_PER);
$graph->Add($plot);
```

### Salvataggio

```php
$graph->Stroke('/path/to/chart.png');
```

---

**Versione Documentazione**: 1.0.0
**Data**: Gennaio 2026
**Autore**: Documentazione Progetto Quaeris
