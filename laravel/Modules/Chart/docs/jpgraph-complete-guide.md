# JpGraph - Guida Completa per Generazione Grafici

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Completa  
**Versione**: 1.0.0  
**Autore**: Analisi Completa del Sistema

---

## 📋 Indice Completo

1. [Panoramica Generale](#panoramica-generale)
2. [Architettura JpGraph](#architettura-jpgraph)
3. [Creazione Grafici Base](#creazione-grafici-base)
4. [Tipi di Grafici Disponibili](#tipi-di-grafici-disponibili)
5. [Personalizzazione Grafici](#personalizzazione-grafici)
6. [Salvataggio Grafici](#salvataggio-grafici)
7. [Best Practices](#best-practices)
8. [Esempi Completi](#esempi-completi)

---

## Panoramica Generale

### Cos'è JpGraph

JpGraph è una libreria PHP per generazione grafici server-side. I grafici vengono generati come oggetti `Graph` e salvati come immagini PNG usando il metodo `Stroke()`.

### Licenza (importante)

JpGraph è **dual-license**:

- **Uso non commerciale:** QPL-1.0
- **Uso commerciale:** richiede **JpGraph Professional License**

Prima di adottare/estendere JpGraph nel progetto, verificare che lo scenario di deploy sia compatibile con la licenza (es. prodotto venduto, servizio a pagamento, intranet aziendale oltre le soglie del vendor).

### Vantaggi JpGraph

- **Server-Side**: Generazione lato server, no dipendenze JavaScript
- **Alta Qualità**: Grafici vettoriali convertiti in PNG ad alta risoluzione
- **Personalizzabile**: Controllo completo su stile, colori, font, layout
- **Performance**: Generazione veloce per grafici semplici/medi

### Limitazioni

- **PHP Only**: Richiede PHP con estensioni GD/ImageMagick
- **Memory**: Grafici complessi possono richiedere molta memoria
- **Learning Curve**: API complessa, richiede studio documentazione

---

## Alternative (librerie simili)

Questa sezione serve come checklist di valutazione quando si considera di introdurre una libreria diversa da JpGraph.

### Alternative server-side (PHP → immagini)

- **pChart**: generazione immagini via GD. Attenzione alla licenza (spesso GPL) e alla compatibilità con il modello di distribuzione.
- **PHPlot**: libreria per grafici server-side (PNG) con set feature più semplice.
- **Libchart**: libreria storica, spesso considerata **discontinuata**.
- **Image-Charts (SaaS)**: genera immagini via API/URL; introduce dipendenza esterna e vincoli su privacy/dati.

### Alternative client-side (JS)

- **Apache ECharts** (Apache-2.0): ricca di feature, adatta anche a dataset grandi.
- **Plotly.js** (MIT per pacchetto OSS): molto potente ma bundle più pesante.
- **Vega-Lite** (BSD-3-Clause): approccio dichiarativo (grammar of graphics).
- **Highcharts**: tipicamente licenza commerciale per uso business.

---

## Architettura JpGraph

### Struttura Actions

```
Modules/Chart/app/Actions/JpGraph/
├── GetGraphAction.php          # Crea Graph base con configurazione
├── ApplyGraphStyleAction.php   # Applica stile globale al Graph
├── ApplyPlotStyleAction.php    # Applica stile ai Plot
└── V1/
    ├── Bar1Action.php          # Bar chart semplice (un dataset)
    ├── Bar2Action.php          # Bar chart multiplo (più dataset)
    ├── Bar3Action.php          # Bar chart avanzato (AccBarPlot)
    ├── Horizbar1Action.php     # Bar chart orizzontale
    ├── Pie1Action.php          # Pie chart standard
    ├── PieAvgAction.php        # Pie chart con media
    └── LineSubQuestionAction.php # Line chart per subquestion
```

### Pattern Action

Ogni Action JpGraph segue questo pattern:

```php
class MyChartAction
{
    use QueueableAction;
    
    public function execute(AnswersChartData $answersData): Graph
    {
        // 1. Estrai dati
        $data = $answersData->answers->toCollection()->pluck('value')->all();
        $labels = $answersData->answers->toCollection()->pluck('label')->all();
        $chart = $answersData->chart;
        
        // 2. Crea Graph base
        $graph = app(GetGraphAction::class)->execute($chart);
        
        // 3. Crea Plot appropriato
        $plot = new BarPlot($data);
        
        // 4. Applica stile al Plot
        $plot = app(ApplyPlotStyleAction::class)->execute($plot, $chart);
        
        // 5. Aggiungi Plot al Graph
        $graph->Add($plot);
        
        // 6. Ritorna Graph (non salva ancora!)
        return $graph;
    }
}
```

### Flusso Generazione

```
1. AnswersChartData (dati risposte + stile)
   ↓
2. Action JpGraph appropriata (Bar1Action, Pie1Action, etc.)
   ↓
3. GetGraphAction (crea Graph base)
   ↓
4. Crea Plot (BarPlot, PiePlotC, LinePlot, etc.)
   ↓
5. ApplyPlotStyleAction (applica stile)
   ↓
6. Graph->Add($plot) (aggiungi Plot al Graph)
   ↓
7. Ritorna Graph
   ↓
8. Graph->Stroke($file_path) (salva PNG)
```

---

## Creazione Grafici Base

### Step 1: Preparazione Dati

**File**: `MakeImgByQuestionChartModel2Action.php`

```php
// 1. Recupera dati risposte
$datas = app(GetChartsDataByQuestionChart::class)
    ->execute($questionChart, $responses, $answersFilterData);

// 2. Per ogni chart style
foreach ($datas as $k => $data_answers) {
    $answers = $data_answers->answers;
    $chart_obj = $questionChart->charts[$k];
    
    // 3. Crea ChartData con stile
    $chart_style = ChartData::from($chart_obj->toArray());
    
    // 4. Aggiungi titolo, sottotitolo, footer
    $chart_style['title'] = app(GetTitleAction::class)->execute($questionChart);
    $chart_style['subtitle'] = app(GetSubtitleAction::class)->execute($questionChart);
    $chart_style['footer'] = app(GetFooterAction::class)->execute($questionChart);
    
    // 5. Crea AnswersChartData
    $answersData = AnswersChartData::from([
        'answers' => $answers,
        'chart' => $chart_style,
    ]);
}
```

### Step 2: Determinazione Action

**File**: `ChartData.php` (metodo `getActionClass()`)

```php
public function getActionClass(): string
{
    $type = $this->type; // Es: 'bar1', 'pie1', 'lineSubQuestion'
    $engine = 'JpGraph\V1';
    $action = Str::studly($type).'Action'; // 'bar1' → 'Bar1Action'
    
    return '\Modules\Chart\Actions\\'.$engine.'\\'.$action;
    // Es: '\Modules\Chart\Actions\JpGraph\V1\Bar1Action'
}
```

### Step 3: Esecuzione Action

**File**: `MakeImgByQuestionChartModel2Action.php`

```php
// 1. Determina Action class
$action_class = $chart_style->getActionClass();
// Es: '\Modules\Chart\Actions\JpGraph\V1\Bar1Action'

// 2. Verifica che Action esista
if (! class_exists($action_class)) {
    logger()->error('⚠️ Classe azione grafico non trovata', [
        'class' => $action_class
    ]);
    continue;
}

// 3. Esegue Action
$graphAction = app($action_class);
if (! \is_object($graphAction) || ! method_exists($graphAction, 'execute')) {
    continue;
}

$graph = $graphAction->execute($answersData);
// $graph è un oggetto Graph di JpGraph
```

### Step 4: Salvataggio PNG

**File**: `MakeImgByQuestionChartModel2Action.php`

```php
// 1. Determina path file
$filename = 'chart/'.$questionChart->id.'-'.$k.'.png';
$file_path = public_path($filename);

// 2. Elimina file esistente se presente
if (File::exists($file_path)) {
    File::delete($file_path);
}

// 3. Verifica che Graph abbia metodo Stroke()
if (! \is_object($graph) || ! method_exists($graph, 'Stroke')) {
    logger()->error('❌ Metodo Stroke() non trovato', [
        'graph_class' => \is_object($graph) ? $graph::class : 'N/A',
    ]);
    continue;
}

// 4. Salva PNG
try {
    $graph->Stroke($file_path);
    // JpGraph salva PNG direttamente su filesystem
} catch (\Throwable $e) {
    logger()->error('❌ Errore durante Stroke()', [
        'exception' => $e->getMessage(),
        'file_path' => $file_path,
    ]);
}

// 5. Verifica che file sia stato creato
if (! File::exists($file_path)) {
    logger()->error('❌ Immagine NON generata', [
        'file_path' => $file_path,
    ]);
}
```

---

## Tipi di Grafici Disponibili

### 1. Bar Chart (Bar1Action)

**Tipo**: `bar1`

**Caratteristiche**:
- Bar chart semplice con un dataset
- Un colore per tutte le barre
- Valori mostrati sopra barre (opzionale)

**Esempio**:

```php
// ChartData
$chartData = ChartData::from([
    'type' => 'bar1',
    'width' => 800,
    'height' => 600,
    'list_color' => '#d60021',
    'plot_value_show' => true,
]);

// AnswersChartData
$answersData = AnswersChartData::from([
    'answers' => $answers, // Collection di AnswerData
    'chart' => $chartData,
]);

// Esegue Action
$graph = app(Bar1Action::class)->execute($answersData);
$graph->Stroke($file_path);
```

**Dati Richiesti**:
- `answers`: Collection di AnswerData con `value` (numerico) e `label` (stringa)

### 2. Bar Chart Multiplo (Bar2Action)

**Tipo**: `bar2`

**Caratteristiche**:
- Bar chart con più dataset (GroupBarPlot)
- Colori diversi per ogni dataset
- Legenda automatica

**Esempio**:

```php
$chartData = ChartData::from([
    'type' => 'bar2',
    'list_color' => '#d60021,#0066cc,#00cc66', // Colori separati da virgola
]);

$graph = app(Bar2Action::class)->execute($answersData);
$graph->Stroke($file_path);
```

**Dati Richiesti**:
- `answers`: Collection con `value` (array per dataset multipli) e `avg`

### 3. Pie Chart (Pie1Action)

**Tipo**: `pie1`

**Caratteristiche**:
- Pie chart standard (PieGraph + PiePlotC)
- Percentuali mostrate
- Colori personalizzabili per ogni slice
- Legenda automatica

**Esempio**:

```php
$chartData = ChartData::from([
    'type' => 'pie1',
    'width' => 600,
    'height' => 600,
    'list_color' => '#d60021,#0066cc,#00cc66,#ff9900',
    'plot_perc_width' => 80, // Dimensione cerchio interno (0-100)
    'transparency' => '0.8', // Trasparenza colori
]);

$graph = app(Pie1Action::class)->execute($answersData);
$graph->Stroke($file_path);
```

**Dati Richiesti**:
- `answers`: Collection con `avg` (percentuale) e `label` (nome slice)

### 4. Line Chart (LineSubQuestionAction)

**Tipo**: `lineSubQuestion`

**Caratteristiche**:
- Line chart per subquestion
- Marker personalizzabili
- Linee multiple supportate

**Esempio**:

```php
$chartData = ChartData::from([
    'type' => 'lineSubQuestion',
    'width' => 1000,
    'height' => 600,
]);

$graph = app(LineSubQuestionAction::class)->execute($answersData);
$graph->Stroke($file_path);
```

### 5. Bar Chart Orizzontale (Horizbar1Action)

**Tipo**: `horizbar1`

**Caratteristiche**:
- Bar chart con assi invertiti (orizzontale)
- Utile per label lunghe

**Esempio**:

```php
$chartData = ChartData::from([
    'type' => 'horizbar1',
    'width' => 800,
    'height' => 600,
]);

$graph = app(Horizbar1Action::class)->execute($answersData);
$graph->Stroke($file_path);
```

---

## Personalizzazione Grafici

### Configurazione Graph Base

**File**: `GetGraphAction.php`

```php
public function execute(ChartData $chartData): Graph
{
    // 1. Crea Graph con dimensioni
    $graph = new Graph($chartData->width, $chartData->height, 'auto');
    
    // 2. Configura scale
    $graph->SetScale('textlin'); // Scale lineare con label testuali
    
    // 3. Aggiungi ombra
    $graph->SetShadow();
    
    // 4. Applica tema
    $universalTheme = new UniversalTheme;
    $graph->SetTheme($universalTheme);
    
    // 5. Configura titolo
    if ($chartData->title !== null) {
        $graph->title->Set($chartData->title);
        $graph->title->SetFont($chartData->font_family, $chartData->font_style, 11);
    }
    
    // 6. Configura sottotitolo
    if ($chartData->subtitle !== null) {
        $graph->subtitle->Set($chartData->subtitle);
        $graph->subtitle->SetFont($chartData->font_family, $chartData->font_style, 11);
    }
    
    // 7. Configura footer
    if ($chartData->footer !== null) {
        $graph->footer->center->Set($chartData->footer);
        $graph->footer->center->SetFont($chartData->font_family, $chartData->font_style, 10);
    }
    
    // 8. Configura box
    $graph->SetBox($chartData->show_box);
    
    // 9. Configura assi
    $this->applyGraphXStyle($graph->xaxis, $chartData);
    $this->applyGraphYStyle($graph->yaxis, $chartData);
    
    return $graph;
}
```

### Configurazione Assi

**File**: `GetGraphAction.php`

```php
// Asse X
public function applyGraphXStyle(Axis &$axis, ChartData $chartData): void
{
    $axis->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
    $axis->SetLabelAngle($chartData->x_label_angle); // Angolo label (0-90)
    $axis->SetLabelMargin($chartData->x_label_margin); // Margine label
}

// Asse Y
public function applyGraphYStyle(Axis &$axis, ChartData $chartData): void
{
    // Grace (spazio extra sopra barre)
    if (method_exists($axis->scale, 'SetGrace')) {
        $axis->scale->SetGrace($chartData->y_grace);
    }
    
    // Nascondi asse Y se richiesto
    if ($chartData->yaxis_hide) {
        $axis->Hide();
    }
    
    $axis->HideZeroLabel();
    $axis->HideLine(false);
    $axis->HideTicks(false, false);
}
```

### Configurazione Plot

**File**: `ApplyPlotStyleAction.php`

```php
public function execute(BarPlot $barPlot, ChartData $chartData): BarPlot
{
    // 1. Colore riempimento (con trasparenza)
    $barPlot->SetFillColor($chartData->list_color.'@'.$chartData->transparency);
    
    // 2. Colore bordo
    $barPlot->SetColor($chartData->list_color);
    
    // 3. Larghezza barre (percentuale)
    $barPlot->SetWidth($chartData->plot_perc_width / 100);
    
    // 4. Mostra valori sopra barre
    if ($chartData->plot_value_show) {
        $barPlot->value->Show();
        $barPlot->value->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
        $barPlot->value->SetColor($chartData->plot_value_color ?? 'black');
    }
    
    return $barPlot;
}
```

### Configurazione Colori

**File**: `ChartData.php`

```php
// Colori multipli separati da virgola
$chartData->list_color = '#d60021,#0066cc,#00cc66';

// Trasparenza (0.0 - 1.0)
$chartData->transparency = '0.8'; // 80% opaco

// Colori con trasparenza (formato JpGraph)
$color = '#d60021@0.8'; // Rosso con 80% opacità
```

### Configurazione Font

**File**: `ChartData.php`

```php
// Font family (costanti JpGraph)
$chartData->font_family = FF_ARIAL; // O FF_TIMES, FF_COURIER, etc.

// Font style
$chartData->font_style = FS_BOLD; // O FS_NORMAL, FS_ITALIC

// Font size
$chartData->font_size = 12; // Punti
```

---

## Salvataggio Grafici

### Metodo Stroke()

**Sintassi**:

```php
$graph->Stroke($file_path);
```

**Parametri**:
- `$file_path`: Path assoluto dove salvare PNG

**Esempio**:

```php
$file_path = public_path('chart/123.png');
$graph->Stroke($file_path);
```

### Gestione Errori

```php
try {
    $graph->Stroke($file_path);
} catch (\Throwable $e) {
    logger()->error('❌ Errore durante Stroke()', [
        'exception' => $e->getMessage(),
        'file_path' => $file_path,
        'trace' => $e->getTraceAsString(),
    ]);
    
    // Usa immagine placeholder
    $file_path = public_path('chart/NoDataImage.jpeg');
}
```

### Verifica File Creato

```php
if (! File::exists($file_path)) {
    logger()->error('❌ Immagine NON generata', [
        'file_path' => $file_path,
        'question_chart_id' => $questionChart->id,
    ]);
}
```

### Memory Management

```php
// Aumenta memory limit per grafici complessi
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

// Genera grafico
$graph->Stroke($file_path);

// Ripristina limiti (opzionale)
ini_restore('memory_limit');
ini_restore('max_execution_time');
```

---

## Best Practices

### 1. Dimensioni Ottimali

**Pratica**: Usa dimensioni appropriate per PDF.

```php
// ✅ CORRETTO - Dimensioni per PDF A4 Landscape
$chartData->width = 1000;
$chartData->height = 600;

// ❌ SBAGLIATO - Dimensioni troppo grandi
$chartData->width = 4000;
$chartData->height = 3000; // File PNG troppo grande
```

### 2. Colori e Trasparenza

**Pratica**: Usa trasparenza per grafici sovrapposti.

```php
// ✅ CORRETTO - Trasparenza per barre sovrapposte
$chartData->transparency = '0.7';

// ❌ SBAGLIATO - Opacità totale
$chartData->transparency = '1.0'; // Barre sovrapposte non visibili
```

### 3. Font e Leggibilità

**Pratica**: Usa font size appropriati per PDF.

```php
// ✅ CORRETTO - Font size leggibile
$chartData->font_size = 12; // Titoli
$chartData->font_size = 10; // Labels

// ❌ SBAGLIATO - Font troppo piccoli
$chartData->font_size = 6; // Illeggibile in PDF
```

### 4. Gestione Errori

**Pratica**: Gestisci sempre errori gracefully.

```php
// ✅ CORRETTO - Try-catch completo
try {
    $graph->Stroke($file_path);
    if (! File::exists($file_path)) {
        throw new \Exception('File not created');
    }
} catch (\Throwable $e) {
    logger()->error('Errore generazione grafico', [
        'exception' => $e->getMessage(),
    ]);
    // Fallback a placeholder
}

// ❌ SBAGLIATO - No error handling
$graph->Stroke($file_path); // Può fallire silenziosamente
```

### 5. Performance

**Pratica**: Genera grafici in queue per performance.

```php
// ✅ CORRETTO - Queueable action
MakeImgByQuestionChartModel2Action::dispatch($questionChart, $responses)
    ->onQueue('charts');

// ❌ SBAGLIATO - Sincrono (blocca request)
app(MakeImgByQuestionChartModel2Action::class)
    ->execute($questionChart, $responses);
```

---

## Esempi Completi

### Esempio 1: Bar Chart Semplice

```php
// 1. Prepara dati
$answers = collect([
    ['label' => 'Opzione A', 'value' => 45],
    ['label' => 'Opzione B', 'value' => 30],
    ['label' => 'Opzione C', 'value' => 25],
]);

// 2. Crea ChartData
$chartData = ChartData::from([
    'type' => 'bar1',
    'width' => 800,
    'height' => 600,
    'title' => 'Distribuzione Risposte',
    'list_color' => '#d60021',
    'transparency' => '0.8',
    'plot_value_show' => true,
    'font_family' => FF_ARIAL,
    'font_style' => FS_BOLD,
    'font_size' => 12,
]);

// 3. Crea AnswersChartData
$answersData = AnswersChartData::from([
    'answers' => $answers,
    'chart' => $chartData,
]);

// 4. Esegue Action
$graph = app(Bar1Action::class)->execute($answersData);

// 5. Salva PNG
$file_path = public_path('chart/example-bar1.png');
$graph->Stroke($file_path);
```

### Esempio 2: Pie Chart con Percentuali

```php
// 1. Prepara dati
$answers = collect([
    ['label' => 'Soddisfatto', 'avg' => 60.5],
    ['label' => 'Neutro', 'avg' => 25.3],
    ['label' => 'Insoddisfatto', 'avg' => 14.2],
]);

// 2. Crea ChartData
$chartData = ChartData::from([
    'type' => 'pie1',
    'width' => 600,
    'height' => 600,
    'title' => 'Soddisfazione Cliente',
    'list_color' => '#00cc66,#ff9900,#d60021',
    'transparency' => '0.8',
    'plot_perc_width' => 80,
]);

// 3. Crea AnswersChartData
$answersData = AnswersChartData::from([
    'answers' => $answers,
    'chart' => $chartData,
]);

// 4. Esegue Action
$graph = app(Pie1Action::class)->execute($answersData);

// 5. Salva PNG
$file_path = public_path('chart/example-pie1.png');
$graph->Stroke($file_path);
```

### Esempio 3: Bar Chart Multiplo

```php
// 1. Prepara dati con dataset multipli
$answers = collect([
    [
        'label' => 'Gennaio',
        'value' => [100, 80], // Due dataset
        'avg' => 90,
    ],
    [
        'label' => 'Febbraio',
        'value' => [120, 90],
        'avg' => 105,
    ],
]);

// 2. Crea ChartData
$chartData = ChartData::from([
    'type' => 'bar2',
    'width' => 1000,
    'height' => 600,
    'title' => 'Vendite Mensili',
    'list_color' => '#d60021,#0066cc', // Colori per ogni dataset
    'transparency' => '0.7',
]);

// 3. Crea AnswersChartData
$answersData = AnswersChartData::from([
    'answers' => $answers,
    'chart' => $chartData,
]);

// 4. Esegue Action
$graph = app(Bar2Action::class)->execute($answersData);

// 5. Salva PNG
$file_path = public_path('chart/example-bar2.png');
$graph->Stroke($file_path);
```

---

## Conclusioni

### Workflow Completo JpGraph

1. **Prepara Dati**: AnswersChartData con risposte e stile
2. **Determina Action**: `ChartData->getActionClass()`
3. **Esegue Action**: Action JpGraph appropriata
4. **Crea Graph**: GetGraphAction crea Graph base
5. **Crea Plot**: BarPlot, PiePlotC, LinePlot, etc.
6. **Applica Stile**: ApplyPlotStyleAction
7. **Aggiungi Plot**: `Graph->Add($plot)`
8. **Salva PNG**: `Graph->Stroke($file_path)`

### Tipi Grafici Supportati

- **Bar1Action**: Bar chart semplice
- **Bar2Action**: Bar chart multiplo
- **Bar3Action**: Bar chart avanzato
- **Horizbar1Action**: Bar chart orizzontale
- **Pie1Action**: Pie chart standard
- **PieAvgAction**: Pie chart con media
- **LineSubQuestionAction**: Line chart

### Best Practices

1. Dimensioni ottimali per PDF
2. Colori e trasparenza appropriati
3. Font size leggibili
4. Gestione errori completa
5. Performance con queue

---

## Riferimenti e Documentazione Approfondita

### Documentazione JpGraph Ufficiale

- [JpGraph Official Site](https://jpgraph.net/) - Sito ufficiale
- [JpGraph Documentation Portal](https://jpgraph.net/download/manuals) - Portale documentazione
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html) - ⭐ **RIFERIMENTO PRINCIPALE** - Class Reference completa ufficiale
- [JpGraph HowTo's](https://jpgraph.net/doc/howto.php) - Guide pratiche
- [JpGraph FAQ](https://jpgraph.net/doc/faq.php) - Domande frequenti
- [JpGraph Gallery](https://jpgraph.net/features/gallery.php) - Galleria esempi

### Documentazione Progetto

- [JpGraph Class Reference Complete](./jpgraph-class-reference-complete.md) - ⭐ **NUOVO** - Guida completa Class Reference basata su documentazione ufficiale, con riferimento dettagliato a tutte le classi principali, metodi, pattern di utilizzo nel progetto, e esempi pratici
- [JpGraph Deep Dive and Alternatives](./jpgraph-deep-dive-and-alternatives.md) - Analisi approfondita JpGraph, alternative, confronto, e best practices
- [JpGraph Step-by-Step Guide](./jpgraph-step-by-step-guide.md) - Guida passo-passo
- [Chart.js Integration](./filament-charts-professional-guide.md) - Integrazione Chart.js
- [PDF Integration](./pdf-integration-complete-guide.md) - Integrazione PDF

### Actions Esistenti

- [GetGraphAction](../app/Actions/JpGraph/GetGraphAction.php) - Crea Graph base
- [ApplyGraphStyleAction](../app/Actions/JpGraph/ApplyGraphStyleAction.php) - Applica stile Graph
- [ApplyPlotStyleAction](../app/Actions/JpGraph/ApplyPlotStyleAction.php) - Applica stile Plot
- [Bar2Action](../app/Actions/JpGraph/V1/Bar2Action.php) - Bar chart multiplo
- [Pie1Action](../app/Actions/JpGraph/V1/Pie1Action.php) - Pie chart standard

---

**Ultimo Aggiornamento**: Gennaio 2026  
**Versione JpGraph**: 4.4.3 (PHP 8.5 support)  
**Versione Documentazione**: 2.0.0
