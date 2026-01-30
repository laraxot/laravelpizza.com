# JpGraph Class Reference Completa - Guida Approfondita

**Data Creazione:** Gennaio 2026  
**Versione JpGraph:** 4.4.3 (PHP 8.5 support)  
**Fonte:** Analisi approfondita codice progetto + [Class Reference ufficiale](https://jpgraph.net/download/manuals/classref/index.html)  
**Status:** Production Ready

**Nota:** Per una versione sintetica con link diretti alla documentazione ufficiale, vedere [jpgraph-class-reference.md](./jpgraph-class-reference.md)

---

## 📋 Indice Completo

1. [Panoramica Classi Principali](#panoramica-classi-principali)
2. [Graph Class - Riferimento Completo](#graph-class-riferimento-completo)
3. [PieGraph Class - Riferimento Completo](#piegraph-class-riferimento-completo)
4. [Plot Classes - Riferimento Completo](#plot-classes-riferimento-completo)
5. [Axis Class - Riferimento Completo](#axis-class-riferimento-completo)
6. [Text Class - Riferimento Completo](#text-class-riferimento-completo)
7. [Scale Classes - Riferimento Completo](#scale-classes-riferimento-completo)
8. [Theme Classes - Riferimento Completo](#theme-classes-riferimento-completo)
9. [Pattern di Utilizzo nel Progetto](#pattern-di-utilizzo-nel-progetto)
10. [Metodi Avanzati e Best Practices](#metodi-avanzati-e-best-practices)

---

## Panoramica Classi Principali

### Gerarchia Classi JpGraph

```
Graph (base)
├── PieGraph (specializzato per pie charts)
│
Plot (base)
├── BarPlot
├── AccBarPlot (stacked bars)
├── GroupBarPlot (grouped bars)
├── LinePlot
├── PiePlot
├── PiePlotC (pie con centro)
├── PiePlot3D
├── ScatterPlot
├── RadarPlot
└── ... (altri plot types)

Axis
├── xaxis (X-axis)
├── yaxis (Y-axis)
└── y2axis (second Y-axis)

Text
├── title
├── subtitle
├── footer->center
├── footer->right
└── footer->left

Scale
├── xscale
├── yscale
└── y2scale
```

### Namespace nel Progetto

```php
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Plot\AccBarPlot;
use Amenadiel\JpGraph\Text\Text;
use Amenadiel\JpGraph\Themes\UniversalTheme;
```

---

## Graph Class - Riferimento Completo

### Costruttore

```php
/**
 * Crea un nuovo Graph.
 * 
 * @param int $width Larghezza in pixel
 * @param int $height Altezza in pixel
 * @param string|null $cache_name Nome cache (opzionale)
 * @param int $timeout Timeout cache in secondi (opzionale)
 */
$graph = new Graph(800, 400);
$graph = new Graph(800, 400, 'chart_key_123', 3600); // Con cache
```

### Metodi Fondamentali

#### SetScale()

```php
/**
 * Configura il tipo di scala per gli assi.
 * 
 * Formato: '{xscale}{yscale}'
 * 
 * Scale types:
 * - 'lin' = Linear
 * - 'log' = Logarithmic
 * - 'int' = Integer
 * - 'text' = Text labels (per X-axis)
 * - 'date' = Date (per X-axis)
 */
$graph->SetScale('textlin');  // X text, Y linear (più comune)
$graph->SetScale('linlin');   // X linear, Y linear
$graph->SetScale('loglin');   // X log, Y linear
$graph->SetScale('datlin');   // X date, Y linear
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa sempre `SetScale('textlin')` per grafici con label testuali
- `LineSubQuestionAction`: Usa `SetScale('textlin')` per linee con labels

#### SetShadow()

```php
/**
 * Aggiunge ombra al grafico.
 * 
 * Overload:
 * - SetShadow() - Ombra default
 * - SetShadow($color, $x_offset, $y_offset) - Ombra personalizzata
 */
$graph->SetShadow();  // Default shadow
$graph->SetShadow('#cccccc', 2, 2);  // Custom shadow
```

**Pattern nel Progetto:**
- `GetGraphAction`: Sempre chiama `SetShadow()` per effetto 3D
- `ApplyGraphStyleAction`: Applica shadow per stile professionale

#### SetTheme()

```php
/**
 * Applica un tema predefinito al grafico.
 * 
 * Temi disponibili:
 * - UniversalTheme (default nel progetto)
 * - OceanTheme
 * - PastelTheme
 * - ... (altri temi)
 */
$universalTheme = new UniversalTheme;
$graph->SetTheme($universalTheme);
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa sempre `UniversalTheme` per consistenza

#### SetBox()

```php
/**
 * Mostra/nasconde il box (bordo) attorno all'area plot.
 * 
 * @param bool $show Mostra box se true
 */
$graph->SetBox(true);   // Mostra box
$graph->SetBox(false);  // Nascondi box
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa `$chartData->show_box` per configurazione dinamica
- `LineSubQuestionAction`: Usa `SetBox(false)` per stile minimale

#### SetMargin()

```php
/**
 * Configura i margini del grafico.
 * 
 * @param int $left Margine sinistro
 * @param int $right Margine destro
 * @param int $top Margine superiore
 * @param int $bottom Margine inferiore
 */
$graph->SetMargin(60, 30, 40, 80);  // left, right, top, bottom
$graph->img->SetMargin(50, 50, 50, 100);  // Alternativa via img property
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa `$graph->img->SetMargin(50, 50, 50, 100)` per spazio labels
- `Bar3Action`: Stesso pattern per spazio ottimale

#### Add()

```php
/**
 * Aggiunge un Plot al grafico.
 * 
 * @param Plot $plot Plot da aggiungere (BarPlot, LinePlot, PiePlot, etc.)
 */
$graph->Add($barPlot);
$graph->Add($groupBarPlot);
$graph->Add($linePlot);
```

**Pattern nel Progetto:**
- Tutti gli Actions aggiungono il plot finale con `$graph->Add($plot)`

#### Stroke()

```php
/**
 * Genera e salva l'immagine PNG.
 * 
 * Overload:
 * - Stroke() - Output diretto al browser
 * - Stroke($filename) - Salva su file
 */
$graph->Stroke();  // Browser output
$graph->Stroke('/path/to/chart.png');  // File output
```

**Pattern nel Progetto:**
- `MakeMonthlyChartForPdfAction`: Usa `Stroke($filePath)` per salvare PNG
- Pattern: Genera → Salva → Ritorna path per embedding PDF

### Proprietà Graph

#### title (Text)

```php
/**
 * Titolo principale del grafico.
 */
if ($graph->title instanceof Text) {
    $graph->title->Set('Monthly Survey Results');
    $graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
    $graph->title->SetColor('#1f2937');
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura title da `$chartData->title`
- Font size: 11pt (standard nel progetto)

#### subtitle (Text)

```php
/**
 * Sottotitolo del grafico.
 */
if ($graph->subtitle instanceof Text) {
    $graph->subtitle->Set('Average ratings by month');
    $graph->subtitle->SetFont(FF_ARIAL, FS_NORMAL, 11);
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura subtitle da `$chartData->subtitle`
- Font size: 11pt (stesso del title)

#### footer (object)

```php
/**
 * Footer del grafico con tre sezioni: left, center, right.
 */
if (is_object($graph->footer)) {
    // Center footer
    if (isset($graph->footer->center) && $graph->footer->center instanceof Text) {
        $graph->footer->center->Set('Total Responses: 150');
        $graph->footer->center->SetFont(FF_ARIAL, FS_NORMAL, 10);
    }
    
    // Right footer
    if (isset($graph->footer->right) && $graph->footer->right instanceof Text) {
        $graph->footer->right->Set(date('Y-m-d'));
        $graph->footer->right->SetFont(FF_ARIAL, FS_NORMAL, 10);
    }
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura footer->center e footer->right
- `Bar3Action`: Usa footer->center per totali
- Font size: 10pt (più piccolo del title)

#### xaxis (Axis)

```php
/**
 * Asse X del grafico.
 */
if ($graph->xaxis instanceof Axis) {
    $graph->xaxis->SetTickLabels(['Gen', 'Feb', 'Mar', 'Apr']);
    $graph->xaxis->SetLabelAngle(45);  // Rotazione labels
    $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
    $graph->xaxis->SetLabelMargin(5);  // Margine labels
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura xaxis via `applyGraphXStyle()`
- `Bar2Action`: Usa `SetTickLabels()` per labels dinamiche
- `LineSubQuestionAction`: Configura xaxis con labels e angolo

#### yaxis (Axis)

```php
/**
 * Asse Y del grafico.
 */
if ($graph->yaxis instanceof Axis) {
    $graph->yaxis->HideZeroLabel();  // Nascondi label zero
    $graph->yaxis->HideLine(false);  // Mostra linea
    $graph->yaxis->HideTicks(false, false);  // Mostra ticks
    $graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura yaxis via `applyGraphYStyle()`
- `Bar2Action`: Configura yaxis per visibilità
- `LineSubQuestionAction`: Nasconde zero label, mostra linee e ticks

#### yscale (Scale)

```php
/**
 * Scala Y del grafico.
 */
if (is_object($graph->yscale)) {
    // Auto min/max
    $graph->yscale->SetAutoMin(true);
    $graph->yscale->SetAutoMax(true);
    
    // Manual min/max
    $graph->yscale->SetAutoMin(false);
    $graph->yscale->SetMin(0);
    $graph->yscale->SetMax(100);
    
    // Grace (padding sopra max)
    if (method_exists($graph->yscale, 'SetGrace')) {
        $graph->yscale->SetGrace(10);  // 10% padding
    }
    
    // Ticks
    if (isset($graph->yscale->ticks) && is_object($graph->yscale->ticks)) {
        $graph->yscale->ticks->SupressZeroLabel(false);
    }
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura auto min/max da `$chartData->min/max`
- `ApplyGraphStyleAction`: Applica grace da `$chartData->y_grace`
- `Bar2Action`: Configura ticks per zero label

#### ygrid (Grid)

```php
/**
 * Griglia Y del grafico.
 */
if (is_object($graph->ygrid) && method_exists($graph->ygrid, 'SetFill')) {
    $graph->ygrid->SetFill(false);  // No fill
    $graph->ygrid->SetColor('#e5e7eb');  // Colore griglia
    $graph->ygrid->SetLineStyle('dashed');  // Stile linea
}
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa `SetFill(false)` per griglia pulita
- `Bar3Action`: Stesso pattern
- `LineSubQuestionAction`: Configura ygrid per visibilità

#### legend (Legend)

```php
/**
 * Legenda del grafico.
 */
if (isset($graph->legend) && $graph->legend instanceof Legend) {
    $graph->legend->SetFrameWeight(1);
    $graph->legend->SetColor('#4E4E4E', '#00A78A');
    $graph->legend->SetMarkAbsSize(8);
    $graph->legend->SetPos(0.5, 0.98, 'center', 'bottom');
    $graph->legend->SetLayout(LEGEND_HOR);  // Layout orizzontale
}
```

**Pattern nel Progetto:**
- `LineSubQuestionAction`: Configura legend per multiple linee
- `Bar2Action`: Legend automatica da `SetLegend()` sui plot

#### img (Image)

```php
/**
 * Oggetto immagine interno (per configurazioni avanzate).
 */
if (is_object($graph->img) && method_exists($graph->img, 'SetMargin')) {
    $graph->img->SetMargin(50, 50, 50, 100);
}
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa `img->SetMargin()` per configurazione margini
- `Bar3Action`: Stesso pattern

---

## PieGraph Class - Riferimento Completo

### Costruttore

```php
/**
 * Crea un nuovo PieGraph (specializzato per pie charts).
 * 
 * @param int $width Larghezza in pixel
 * @param int $height Altezza in pixel
 * @param string|null $cache_name Nome cache (opzionale)
 */
$graph = new PieGraph(500, 400);
```

**Pattern nel Progetto:**
- `Pie1Action`: Usa `PieGraph` invece di `Graph` per pie charts
- `PieAvgAction`: Stesso pattern

### Metodi Specifici PieGraph

PieGraph eredita tutti i metodi di Graph, ma è ottimizzato per pie charts:

```php
$graph = new PieGraph($chart->width, $chart->height, 'auto');
$graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);
```

---

## Plot Classes - Riferimento Completo

### BarPlot

#### Costruttore

```php
/**
 * Crea un nuovo BarPlot.
 * 
 * @param array<int|float> $data Array di valori numerici
 */
$barPlot = new BarPlot([40, 60, 31, 22]);
```

#### Metodi Principali

##### SetFillColor()

```php
/**
 * Imposta il colore di riempimento delle barre.
 * 
 * Formati supportati:
 * - Stringa singola: '#3b82f6'
 * - Con trasparenza: '#3b82f6@0.8' (80% opaco)
 * - Array colori: ['#3b82f6', '#22c55e', '#f59e0b']
 * - Array con trasparenza: ['#3b82f6@0.8', '#22c55e@0.8']
 */
$barPlot->SetFillColor('#3b82f6');
$barPlot->SetFillColor('#3b82f6@0.8');  // Con trasparenza
$barPlot->SetFillColor(['#3b82f6', '#22c55e']);  // Colori multipli
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Usa `$chartData->list_color.'@'.$chartData->transparency`
- `Bar2Action`: Applica colori con trasparenza per ogni dataset
- `Bar3Action`: Stesso pattern per stacked bars

##### SetColor()

```php
/**
 * Imposta il colore del bordo delle barre.
 * 
 * @param string $color Colore hex (es. '#3b82f6')
 */
$barPlot->SetColor('#2563eb');  // Bordo più scuro del fill
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Usa stesso colore del fill per bordo
- `Bar2Action`: Configura colore per ogni bar plot nel gruppo

##### SetWidth()

```php
/**
 * Imposta la larghezza delle barre.
 * 
 * @param float $width Larghezza (0.0 - 1.0, dove 1.0 = 100% spazio disponibile)
 */
$barPlot->SetWidth(0.6);  // 60% dello spazio
$barPlot->SetWidth($chartData->plot_perc_width / 100);  // Da percentuale
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Converte `plot_perc_width` da percentuale a decimale
- `Bar3Action`: Applica width anche a `AccBarPlot`

##### SetValuePos()

```php
/**
 * Imposta la posizione dei valori sopra le barre.
 * 
 * @param string $pos Posizione: 'top', 'center', 'bottom'
 */
$barPlot->SetValuePos('top');     // Sopra la barra
$barPlot->SetValuePos('center');  // Centro barra
$barPlot->SetValuePos('bottom');  // Sotto la barra
```

**Pattern nel Progetto:**
- `Bar3Action`: Usa `SetValuePos('bottom')` e `SetValuePos('top')` per stacked bars
- `ApplyPlotStyleAction`: Configura da `$chartData->plot_value_pos`

##### SetLegend()

```php
/**
 * Imposta la label della legenda per questo plot.
 * 
 * @param string $legend Testo legenda
 */
$barPlot->SetLegend('2024');
$barPlot->SetLegend($legend);  // Da variabile
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa `SetLegend()` per ogni dataset nel gruppo
- `LineSubQuestionAction`: Usa `SetLegend()` per ogni linea

#### Proprietà BarPlot

##### value (Text)

```php
/**
 * Oggetto Text per configurare i valori sopra le barre.
 */
if (isset($barPlot->value) && $barPlot->value instanceof Text) {
    $barPlot->value->Show();  // Mostra valori
    $barPlot->value->SetFormat('%.1f');  // Formato: 1 decimale
    $barPlot->value->SetFont(FF_ARIAL, FS_BOLD, 10);
    $barPlot->value->SetColor('black');
    $barPlot->value->SetAlign('left', 'center');
    $barPlot->value->setAngle(45);  // Rotazione valori
}
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Configurazione completa value object
- Formato: `'%.1f &#37;'` per percentuali, `'%.1f'` per decimali, `'%.0f'` per interi
- Font: Usa `$chartData->font_family`, `font_style`, `font_size`
- Colore: Usa `$chartData->plot_value_color ?? 'black'`

### GroupBarPlot

#### Costruttore

```php
/**
 * Crea un GroupBarPlot (barre raggruppate side-by-side).
 * 
 * @param array<BarPlot> $plots Array di BarPlot da raggruppare
 */
$plot1 = new BarPlot($data1);
$plot2 = new BarPlot($data2);
$groupBarPlot = new GroupBarPlot([$plot1, $plot2]);
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa `GroupBarPlot` per multiple dataset side-by-side
- Pattern: Crea array di `BarPlot`, poi wrappa in `GroupBarPlot`

#### Metodi Principali

```php
// GroupBarPlot eredita metodi da Plot base
// Configurazione width applicata ai singoli BarPlot prima del wrapping
```

### AccBarPlot

#### Costruttore

```php
/**
 * Crea un AccBarPlot (barre accumulate/stacked).
 * 
 * @param array<BarPlot> $plots Array di BarPlot da stackare
 */
$plot1 = new BarPlot($data1);
$plot2 = new BarPlot($data2);
$accBarPlot = new AccBarPlot([$plot1, $plot2]);
```

**Pattern nel Progetto:**
- `Bar3Action`: Usa `AccBarPlot` per stacked bars
- Pattern: Crea array di `BarPlot`, configura `SetValuePos()` diverso per ogni livello, poi wrappa in `AccBarPlot`

#### Metodi Principali

##### SetWidth()

```php
/**
 * Imposta la larghezza delle barre stackate.
 * 
 * @param float $width Larghezza (0.0 - 1.0)
 */
$accBarPlot->SetWidth($chart->plot_perc_width / 100);
```

**Pattern nel Progetto:**
- `Bar3Action`: Applica width all'`AccBarPlot` dopo il wrapping

### LinePlot

#### Costruttore

```php
/**
 * Crea un nuovo LinePlot.
 * 
 * @param array<int|float> $data Array di valori numerici
 */
$linePlot = new LinePlot([40, 60, 31, 22, 85]);
```

#### Metodi Principali

##### SetColor()

```php
/**
 * Imposta il colore della linea.
 * 
 * @param string $color Colore hex
 */
$linePlot->SetColor('#3b82f6');
```

**Pattern nel Progetto:**
- `LineSubQuestionAction`: Usa palette colori per multiple linee
- Colori: `['#55bbdd', '#aaaaaa', '#d60021', '#0baa90']`

##### SetWeight()

```php
/**
 * Imposta lo spessore della linea.
 * 
 * @param int $weight Spessore in pixel (default: 1)
 */
$linePlot->SetWeight(2);  // Linea più spessa
```

##### SetFillColor()

```php
/**
 * Imposta il colore di riempimento sotto la linea (area chart).
 * 
 * @param string $color Colore con alpha (es. '#3b82f680')
 */
$linePlot->SetFillColor('#3b82f680');  // Area riempita con trasparenza
```

##### SetCenter()

```php
/**
 * Centra i punti dati sulla scala.
 */
$linePlot->SetCenter();
```

**Pattern nel Progetto:**
- `LineSubQuestionAction`: Usa `SetCenter()` per allineamento corretto

#### Proprietà LinePlot

##### mark (PlotMark)

```php
/**
 * Oggetto PlotMark per configurare i marcatori sui punti.
 */
if (is_object($linePlot->mark)) {
    $linePlot->mark->SetType(MARK_FILLEDCIRCLE);  // Tipo marcatore
    $linePlot->mark->SetColor('#3b82f6');  // Colore marcatore
    $linePlot->mark->SetFillColor('#ffffff');  // Fill marcatore
    $linePlot->mark->SetSize(6);  // Dimensione marcatore
}
```

**Pattern nel Progetto:**
- `LineSubQuestionAction`: Configura marker per ogni linea con `configureMarker()`
- Marker types: Array di interi `[1, 2, 3, ..., 12]` per diversi tipi
- Pattern: `$mark->SetType($marker, '', 1.2)` con marker da array

### PiePlotC

#### Costruttore

```php
/**
 * Crea un nuovo PiePlotC (pie chart con centro configurabile).
 * 
 * @param array<int|float> $data Array di valori numerici
 */
$piePlotC = new PiePlotC([40, 25, 20, 15]);
```

#### Metodi Principali

##### SetSliceColors()

```php
/**
 * Imposta i colori per ogni slice della torta.
 * 
 * @param array<string> $colors Array di colori hex
 */
$colors = explode(',', $chart->list_color);
foreach ($colors as $k => $color) {
    $colors[$k] = $color.'@'.$chart->transparency;
}
$piePlotC->SetSliceColors($colors);
```

**Pattern nel Progetto:**
- `Pie1Action`: Applica trasparenza a ogni colore prima di `SetSliceColors()`
- Pattern: Split `list_color` per virgola, aggiungi trasparenza, passa array

##### SetLegends()

```php
/**
 * Imposta le label per ogni slice.
 * 
 * @param array<string> $legends Array di stringhe
 */
$piePlotC->SetLegends(['Eccellente', 'Buono', 'Sufficiente', 'Insufficiente']);
$piePlotC->SetLegends($labels);  // Da variabile
```

**Pattern nel Progetto:**
- `Pie1Action`: Usa labels estratte da `$answersChartData->answers`

##### SetGuideLines()

```php
/**
 * Abilita/disabilita le guide lines (linee guida) per le label.
 * 
 * @param bool $show Mostra guide lines
 * @param bool $adj Aggiusta automaticamente
 */
$piePlotC->SetGuideLines(true, false);
$piePlotC->SetGuideLinesAdjust(1.5);  // Aggiustamento distanza
```

**Pattern nel Progetto:**
- `Pie1Action`: Usa `SetGuideLines(true, false)` e `SetGuideLinesAdjust(1.5)`

##### SetLabelType()

```php
/**
 * Imposta il tipo di label da mostrare.
 * 
 * Costanti:
 * - PIE_VALUE_ABS = Valori assoluti (40, 25, 20, 15)
 * - PIE_VALUE_PER = Percentuali (40%, 25%, 20%, 15%)
 * - PIE_VALUE_ADJPER = Percentuali aggiustate
 */
$piePlotC->SetLabelType(PIE_VALUE_PER);  // Mostra percentuali
```

**Pattern nel Progetto:**
- `Pie1Action`: Usa sempre `PIE_VALUE_PER` per percentuali

##### SetMidSize()

```php
/**
 * Imposta la dimensione del centro (per donut chart).
 * 
 * @param float $size Dimensione centro (0.0 - 1.0, dove 0.8 = 80% raggio interno)
 */
$piePlotC->SetMidSize(0.8);  // Donut chart (80% raggio interno)
$piePlotC->SetMidSize($chart->plot_perc_width / 100);  // Da percentuale
```

**Pattern nel Progetto:**
- `Pie1Action`: Usa `plot_perc_width` convertito da percentuale a decimale
- Pattern: `plot_perc_width = 80` → `SetMidSize(0.8)` → donut chart

##### SetMidColor()

```php
/**
 * Imposta il colore del centro (per donut chart).
 * 
 * @param string $color Colore hex
 */
$piePlotC->SetMidColor('white');  // Centro bianco
```

**Pattern nel Progetto:**
- `Pie1Action`: Usa sempre `SetMidColor('white')` per contrasto

#### Proprietà PiePlotC

##### value (Text)

```php
/**
 * Oggetto Text per configurare i valori sulle slice.
 */
if (is_object($piePlotC->value) && method_exists($piePlotC->value, 'Show')) {
    $piePlotC->value->Show();
    $piePlotC->value->SetFont(FF_ARIAL, FS_BOLD, 10);
    $piePlotC->value->SetColor('black');
    $piePlotC->value->SetFormat('%2.1f%%');  // Formato percentuale
}
```

**Pattern nel Progetto:**
- `Pie1Action`: Configurazione completa value object
- Formato: `'%2.1f%%'` per percentuali con 1 decimale

##### midtitle (Text)

```php
/**
 * Oggetto Text per il titolo al centro (donut chart).
 */
if (is_object($piePlotC->midtitle)) {
    $piePlotC->midtitle->Set('Total: 150');
    $piePlotC->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);
}
```

**Pattern nel Progetto:**
- `Pie1Action`: Pulisce midtitle con `Set('')` per centro vuoto

---

## Axis Class - Riferimento Completo

### Metodi Principali

#### SetTickLabels()

```php
/**
 * Imposta le label per i tick dell'asse.
 * 
 * @param array<string> $labels Array di stringhe
 */
$graph->xaxis->SetTickLabels(['Gen', 'Feb', 'Mar', 'Apr']);
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa labels estratte da `$answersChartData->answers->pluck('label')`
- `Bar3Action`: Stesso pattern
- `LineSubQuestionAction`: Estrae labels da answers collection

#### SetLabelAngle()

```php
/**
 * Ruota le label dell'asse.
 * 
 * @param int $angle Angolo in gradi (0 = orizzontale, 90 = verticale)
 */
$graph->xaxis->SetLabelAngle(45);  // 45 gradi
$graph->xaxis->SetLabelAngle($chart->x_label_angle);  // Da configurazione
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura da `$chartData->x_label_angle`
- `Bar2Action`: Applica angolo per labels lunghe
- `LineSubQuestionAction`: Configura angolo per leggibilità

#### SetLabelMargin()

```php
/**
 * Imposta il margine tra le label e l'asse.
 * 
 * @param int $margin Margine in pixel
 */
$graph->xaxis->SetLabelMargin(5);
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura da `$chartData->x_label_margin`

#### SetFont()

```php
/**
 * Imposta il font per le label dell'asse.
 * 
 * @param int $family Font family constant (FF_ARIAL, etc.)
 * @param int $style Font style constant (FS_BOLD, etc.)
 * @param int $size Font size in punti
 */
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa `$chartData->font_family`, `font_style`, `font_size`
- Font size standard: 10pt per axis labels

#### HideZeroLabel()

```php
/**
 * Nasconde la label zero sull'asse.
 */
$graph->yaxis->HideZeroLabel();
```

**Pattern nel Progetto:**
- `GetGraphAction`: Sempre chiama `HideZeroLabel()` su yaxis
- `LineSubQuestionAction`: Stesso pattern

#### HideLine()

```php
/**
 * Nasconde la linea dell'asse.
 * 
 * @param bool $hide Nascondi se true
 */
$graph->yaxis->HideLine(false);  // Mostra linea
$graph->yaxis->HideLine(true);   // Nascondi linea
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa `HideLine(false)` per mostrare linea
- `Bar2Action`: Stesso pattern
- `LineSubQuestionAction`: Stesso pattern

#### HideTicks()

```php
/**
 * Nasconde i tick dell'asse.
 * 
 * @param bool $hideMajor Nascondi major ticks
 * @param bool $hideMinor Nascondi minor ticks
 */
$graph->yaxis->HideTicks(false, false);  // Mostra entrambi
$graph->yaxis->HideTicks(true, false);   // Nascondi solo major
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa `HideTicks(false, false)` per mostrare entrambi
- `Bar2Action`: Stesso pattern
- `LineSubQuestionAction`: Stesso pattern

#### Hide()

```php
/**
 * Nasconde completamente l'asse.
 */
$graph->yaxis->Hide();
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa `Hide()` quando `$chartData->yaxis_hide === true`

---

## Text Class - Riferimento Completo

### Metodi Principali

#### Set()

```php
/**
 * Imposta il testo.
 * 
 * @param string $text Testo da mostrare
 */
$text->Set('Monthly Survey Results');
```

**Pattern nel Progetto:**
- Usato per title, subtitle, footer, value labels

#### SetFont()

```php
/**
 * Imposta il font.
 * 
 * @param int $family Font family constant
 * @param int $style Font style constant
 * @param int $size Font size in punti
 */
$text->SetFont(FF_ARIAL, FS_BOLD, 14);
```

**Pattern nel Progetto:**
- Title: 11pt (standard)
- Subtitle: 11pt (stesso del title)
- Footer: 10pt (più piccolo)
- Value labels: 10pt (standard)

#### SetColor()

```php
/**
 * Imposta il colore del testo.
 * 
 * @param string $color Colore hex o nome
 */
$text->SetColor('#1f2937');
$text->SetColor('black');
```

**Pattern nel Progetto:**
- Value labels: `'black'` (default)
- Title: Colore scuro per contrasto

#### SetFormat()

```php
/**
 * Imposta il formato per valori numerici.
 * 
 * Formati supportati:
 * - '%.1f' = 1 decimale
 * - '%.0f' = Intero
 * - '%2.1f%%' = Percentuale con 1 decimale
 * - '%.1f &#37;' = Percentuale HTML entity
 */
$text->SetFormat('%.1f');  // 1 decimale
$text->SetFormat('%2.1f%%');  // Percentuale
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Switch su `plot_value_format`:
  - `1`: `'%.1f &#37;'` (percentuale HTML)
  - `2`: `'%.1f'` (decimale)
  - `3`: `'%.0f'` (intero)
- `Pie1Action`: Usa `'%2.1f%%'` per percentuali

#### SetAlign()

```php
/**
 * Imposta l'allineamento del testo.
 * 
 * @param string $halign Allineamento orizzontale: 'left', 'center', 'right'
 * @param string $valign Allineamento verticale: 'top', 'center', 'bottom'
 */
$text->SetAlign('left', 'center');
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Usa `SetAlign('left', 'center')` per value labels

#### setAngle()

```php
/**
 * Ruota il testo.
 * 
 * @param int $angle Angolo in gradi
 */
$text->setAngle(45);  // Ruota 45 gradi
```

**Pattern nel Progetto:**
- `ApplyPlotStyleAction`: Usa `$chartData->x_label_angle` per rotazione valori

#### SetPos()

```php
/**
 * Imposta la posizione assoluta del testo (per Text objects aggiunti manualmente).
 * 
 * @param int $x Posizione X in pixel
 * @param int $y Posizione Y in pixel
 */
$txt = new Text('Total: 150');
$txt->SetPos(400, 20);  // Posizione assoluta
$graph->AddText($txt);
```

**Pattern nel Progetto:**
- `Bar2Action`: Usa `SetPos()` per testo sopra le barre
- `Bar3Action`: Usa `SetPos()` per multiple righe di testo sopra stacked bars
- Pattern: Calcola `$delta` basato su width e numero elementi, posiziona dinamicamente

---

## Scale Classes - Riferimento Completo

### Metodi Principali

#### SetAutoMin() / SetAutoMax()

```php
/**
 * Configura auto-calcolo min/max.
 * 
 * @param bool $auto Auto-calcola se true
 */
$graph->yscale->SetAutoMin(true);  // Auto min
$graph->yscale->SetAutoMax(true);  // Auto max
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura da `$chartData->min/max` se presenti

#### SetMin() / SetMax()

```php
/**
 * Imposta valore min/max manuale.
 * 
 * @param int|float $value Valore min/max
 */
$graph->yscale->SetAutoMin(false);
$graph->yscale->SetMin(0);
$graph->yscale->SetMax(100);
```

**Pattern nel Progetto:**
- Usato quando `SetAutoMin/Max(false)` per range fisso

#### SetGrace()

```php
/**
 * Aggiunge padding sopra il valore massimo.
 * 
 * @param int|float $grace Percentuale di padding (es. 10 = 10%)
 */
if (method_exists($graph->yscale, 'SetGrace')) {
    $graph->yscale->SetGrace(10);  // 10% padding sopra max
}
```

**Pattern nel Progetto:**
- `GetGraphAction`: Configura da `$chartData->y_grace`
- `ApplyGraphStyleAction`: Applica grace per spazio visivo

---

## Theme Classes - Riferimento Completo

### UniversalTheme

```php
/**
 * Tema universale predefinito JpGraph.
 * 
 * Applica stili consistenti a tutti gli elementi del grafico.
 */
$universalTheme = new UniversalTheme;
$graph->SetTheme($universalTheme);
```

**Pattern nel Progetto:**
- `GetGraphAction`: Usa sempre `UniversalTheme` per consistenza
- Pattern: Crea tema → Applica con `SetTheme()`

---

## Pattern di Utilizzo nel Progetto

### Pattern Completo: Dati → Graph → PNG

```php
/**
 * Pattern completo utilizzato nel progetto.
 * 
 * STEP 1: Prepara dati
 */
$monthlyData = SurveyResponse::getResponsesForSurvey($surveyId)
    ->selectRaw('DATE_FORMAT(submitdate, "%Y-%m") as month_key, COUNT(*) as count')
    ->groupBy('month_key')
    ->get();

/**
 * STEP 2: Crea ChartData DTO
 */
$chartData = ChartData::from([
    'type' => 'bar2',
    'width' => 800,
    'height' => 400,
    'list_color' => '#3b82f6,#10b981',
    'transparency' => '0.8',
    'title' => 'Risposte Mensili',
    'font_family' => FF_ARIAL,
    'font_style' => FS_BOLD,
    'font_size' => 12,
]);

/**
 * STEP 3: Crea AnswersChartData DTO
 */
$answersChartData = AnswersChartData::from([
    'answers' => $monthlyData->map(fn($m) => AnswerData::from([
        'label' => $m->month_key,
        'value' => $m->count,
    ])),
    'chart' => $chartData,
]);

/**
 * STEP 4: Risolvi Action class
 */
$actionClass = $chartData->getActionClass();  // → '\Modules\Chart\Actions\JpGraph\V1\Bar2Action'

/**
 * STEP 5: Esegue Action
 */
$graphAction = app($actionClass);
$graph = $graphAction->execute($answersChartData);

/**
 * STEP 6: Salva PNG
 */
$filename = 'chart/monthly-'.time().'.png';
$filePath = public_path($filename);
$graph->Stroke($filePath);

return $filename;
```

### Pattern GetGraphAction

```php
/**
 * Pattern GetGraphAction - Crea Graph base con configurazione completa.
 */
class GetGraphAction
{
    public function execute(ChartData $chartData): Graph
    {
        // 1. Crea Graph
        $graph = new Graph($chartData->width, $chartData->height, 'auto');
        
        // 2. Configura scale
        $graph->SetScale('textlin');
        
        // 3. Applica shadow
        $graph->SetShadow();
        
        // 4. Applica tema
        $universalTheme = new UniversalTheme;
        $graph->SetTheme($universalTheme);
        
        // 5. Configura scale Y (min/max)
        if (is_object($graph->yscale)) {
            if (isset($chartData->min) && method_exists($graph->yscale, 'SetAutoMin')) {
                $graph->yscale->SetAutoMin($chartData->min);
            }
            if (isset($chartData->max) && method_exists($graph->yscale, 'SetAutoMax')) {
                $graph->yscale->SetAutoMax($chartData->max);
            }
        }
        
        // 6. Configura titoli
        if ($chartData->title !== null && $graph->title instanceof Text) {
            $graph->title->Set($chartData->title);
            $graph->title->SetFont($chartData->font_family, $chartData->font_style, 11);
        }
        
        if ($chartData->subtitle !== null && $graph->subtitle instanceof Text) {
            $graph->subtitle->Set($chartData->subtitle);
            $graph->subtitle->SetFont($chartData->font_family, $chartData->font_style, 11);
        }
        
        // 7. Configura footer
        if ($chartData->footer !== null && is_object($graph->footer)) {
            if (isset($graph->footer->center) && $graph->footer->center instanceof Text) {
                $graph->footer->center->Set($chartData->footer);
                $graph->footer->center->SetFont($chartData->font_family, $chartData->font_style, 10);
            }
        }
        
        // 8. Configura box
        $graph->SetBox($chartData->show_box);
        
        // 9. Configura assi
        if ($graph->xaxis instanceof Axis) {
            $this->applyGraphXStyle($graph->xaxis, $chartData);
        }
        if ($graph->yaxis instanceof Axis) {
            $this->applyGraphYStyle($graph->yaxis, $chartData);
        }
        
        return $graph;
    }
}
```

### Pattern ApplyPlotStyleAction

```php
/**
 * Pattern ApplyPlotStyleAction - Applica stile ai Plot.
 */
class ApplyPlotStyleAction
{
    public function execute(BarPlot $barPlot, ChartData $chartData): BarPlot
    {
        // 1. Colore fill con trasparenza
        $barPlot->SetFillColor($chartData->list_color ?? 'red@'.$chartData->transparency);
        
        // 2. Colore bordo
        $barPlot->SetColor($chartData->list_color ?? 'red');
        
        // 3. Larghezza barre
        $barPlot->SetWidth($chartData->plot_perc_width / 100);
        
        // 4. Configura valori sopra barre
        if ($chartData->plot_value_show) {
            Assert::notNull($barPlot->value);
            $value = $barPlot->value;
            if ($value instanceof Text) {
                $value->Show();
                $value->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
                $value->SetAlign('left', 'center');
                $value->SetColor($chartData->plot_value_color ?? 'black');
                
                // Formato valori
                if (method_exists($value, 'SetFormat')) {
                    switch ($chartData->plot_value_format) {
                        case 1: $value->SetFormat('%.1f &#37;'); break;
                        case 2: $value->SetFormat('%.1f'); break;
                        case 3: $value->SetFormat('%.0f'); break;
                        default: $value->SetFormat('%.1f &#37;');
                    }
                }
                
                // Posizione valori
                if ($chartData->plot_value_pos === 0) {
                    $barPlot->SetValuePos('center');
                }
                
                // Rotazione valori
                $value->setAngle($chartData->x_label_angle);
            }
        }
        
        return $barPlot;
    }
}
```

### Pattern Bar2Action (Grouped Bars)

```php
/**
 * Pattern Bar2Action - Bar chart multiplo con GroupBarPlot.
 */
class Bar2Action
{
    public function execute(AnswersChartData $answersChartData): Graph
    {
        // 1. Estrai dati
        $data = $answersChartData->answers->pluck('avg')->all();
        $data1 = $answersChartData->answers->pluck('value')->all();
        $labels = $answersChartData->answers->pluck('label')->all();
        
        // 2. Crea Graph base
        $graph = app(GetGraphAction::class)->execute($chart);
        
        // 3. Configura margini
        if (is_object($graph->img) && method_exists($graph->img, 'SetMargin')) {
            $graph->img->SetMargin(50, 50, 50, 100);
        }
        
        // 4. Configura griglia
        if (is_object($graph->ygrid) && method_exists($graph->ygrid, 'SetFill')) {
            $graph->ygrid->SetFill(false);
        }
        
        // 5. Configura X-axis
        if (is_object($graph->xaxis)) {
            $graph->xaxis->SetTickLabels($labels);
            $graph->xaxis->SetLabelAngle($chart->x_label_angle);
        }
        
        // 6. Configura Y-axis
        if (is_object($graph->yaxis)) {
            $graph->yaxis->HideLine(false);
            $graph->yaxis->HideTicks(false, false);
        }
        
        // 7. Crea BarPlot multipli
        $colors = explode(',', $chart->list_color);
        $bplot = [];
        
        foreach ($legends as $i => $legend) {
            $tmp_data = $legend === 0 ? $data : array_column($data, $legend);
            $tmp = new BarPlot($tmp_data);
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);
            $tmp->SetColor($colors[$i]);
            $tmp->SetFillColor($colors[$i].'@'.$chart->transparency);
            
            if (isset($tmp->value) && is_object($tmp->value) && method_exists($tmp->value, 'Show')) {
                $tmp->value->Show();
            }
            
            if ($legend !== 0) {
                $tmp->SetLegend($legend);
            }
            
            $bplot[] = $tmp;
        }
        
        // 8. Crea GroupBarPlot
        $groupBarPlot = new GroupBarPlot($bplot);
        $graph->Add($groupBarPlot);
        
        // 9. Aggiungi testo sopra barre (opzionale)
        $delta = ($chart->width - 100) / count($data1);
        foreach ($data1 as $i => $v) {
            $txt = new Text((string) $v);
            $x = 50 + ($delta * $i) + ($delta / 3);
            $txt->SetPos($x, 25);
            $graph->AddText($txt);
        }
        
        return $graph;
    }
}
```

### Pattern Pie1Action (Pie Chart)

```php
/**
 * Pattern Pie1Action - Pie chart con PiePlotC.
 */
class Pie1Action
{
    public function execute(AnswersChartData $answersChartData): Graph
    {
        // 1. Estrai dati
        $labels = $answersChartData->answers->pluck('label')->all();
        $data = $answersChartData->answers->pluck('avg')->all();
        
        // 2. Gestisci "other" slice se max presente
        if (isset($chart->max)) {
            $sum = collect($data)->sum();
            $other = $chart->max - $sum;
            if ($other > 0.01) {
                $data[] = $other;
                $labels[] = $chart->answer_value_no_txt;
            }
        }
        
        // 3. Crea PieGraph
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);
        
        // 4. Crea PiePlotC
        $piePlotC = new PiePlotC($data);
        
        // 5. Configura colori con trasparenza
        $color_array = explode(',', $chart->list_color);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$chart->transparency;
        }
        $piePlotC->SetSliceColors($color_array);
        
        // 6. Configura labels
        $piePlotC->SetLegends($labels);
        $piePlotC->SetGuideLines(true, false);
        $piePlotC->SetGuideLinesAdjust(1.5);
        $piePlotC->SetLabelType(PIE_VALUE_PER);
        
        // 7. Configura valori
        if (is_object($piePlotC->value) && method_exists($piePlotC->value, 'Show')) {
            $piePlotC->value->Show();
            $piePlotC->value->SetFont(FF_ARIAL, FS_BOLD, 10);
            $piePlotC->value->SetColor('black');
            $piePlotC->value->SetFormat('%2.1f%%');
        }
        
        // 8. Configura donut (centro)
        $piePlotC->SetMidSize($chart->plot_perc_width / 100);
        $piePlotC->SetMidColor('white');
        
        // 9. Configura titoli
        if (isset($graph->title) && $graph->title instanceof Text) {
            $graph->title->Set($chart->title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }
        
        // 10. Aggiungi plot
        $graph->Add($piePlotC);
        
        return $graph;
    }
}
```

---

## Metodi Avanzati e Best Practices

### Gestione Errori

```php
/**
 * Pattern error handling completo per JpGraph.
 */
try {
    $graph = $graphAction->execute($answersChartData);
    
    if (!is_object($graph) || !method_exists($graph, 'Stroke')) {
        throw new \Exception('Graph object invalid');
    }
    
    $graph->Stroke($filePath);
    
    if (!File::exists($filePath)) {
        throw new \Exception('PNG file not created');
    }
    
    if (filesize($filePath) === 0) {
        throw new \Exception('PNG file is empty');
    }
    
} catch (\Throwable $e) {
    \Log::error('JpGraph generation failed', [
        'question_chart_id' => $questionChart->id,
        'chart_type' => $chartData->type,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);
    
    // Fallback: usa placeholder
    return 'chart/placeholder.png';
}
```

### Memory Management

```php
/**
 * Pattern gestione memoria per grafici complessi.
 */
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

try {
    // Genera grafici
    foreach ($questionCharts as $chart) {
        $graph = $this->generateChart($chart);
        $graph->Stroke($filePath);
    }
} finally {
    // Opzionale: ripristina limiti
    // ini_restore('memory_limit');
}
```

### Caching Strategy

```php
/**
 * Pattern caching per grafici generati.
 */
$cacheKey = 'chart-'.$questionChart->id.'-'.md5(serialize($filter));
$cacheTTL = $this->getCacheTTL($filter);

$chartImage = Cache::tags(['charts', 'question-chart-'.$questionChart->id])
    ->remember($cacheKey, $cacheTTL, function () use ($questionChart, $filter) {
        return $this->generateChart($questionChart, $filter);
    });
```

---

## Riferimenti e Documentazione

### Documentazione JpGraph Ufficiale

- [JpGraph Official Site](https://jpgraph.net/)
- [JpGraph Documentation Portal](https://jpgraph.net/download/manuals) - Tutorial 750+ pagine
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html) - ⭐ **RIFERIMENTO PRINCIPALE**
- [JpGraph HowTo's](https://jpgraph.net/doc/howto.php) - Guide pratiche
- [JpGraph FAQ](https://jpgraph.net/doc/faq.php) - Domande frequenti
- [JpGraph Gallery](https://jpgraph.net/features/gallery.php) - Galleria esempi

### Documentazione Progetto

- [JpGraph Complete Guide](./jpgraph-complete-guide.md) - Guida completa con esempi
- [JpGraph Deep Dive and Alternatives](./jpgraph-deep-dive-and-alternatives.md) - Analisi approfondita e alternative
- [JpGraph Step-by-Step Guide](./jpgraph-step-by-step-guide.md) - Guida passo-passo
- [Chart.js Integration](./filament-charts-professional-guide.md) - Integrazione Chart.js
- [PDF Integration](../../Quaeris/docs/pdf-generation-with-charts.md) - Integrazione PDF

### Actions nel Progetto

- [GetGraphAction](../app/Actions/JpGraph/GetGraphAction.php) - Crea Graph base
- [ApplyGraphStyleAction](../app/Actions/JpGraph/ApplyGraphStyleAction.php) - Applica stile Graph
- [ApplyPlotStyleAction](../app/Actions/JpGraph/ApplyPlotStyleAction.php) - Applica stile Plot
- [Bar2Action](../app/Actions/JpGraph/V1/Bar2Action.php) - Bar chart multiplo
- [Bar3Action](../app/Actions/JpGraph/V1/Bar3Action.php) - Bar chart stacked
- [Pie1Action](../app/Actions/JpGraph/V1/Pie1Action.php) - Pie chart standard
- [PieAvgAction](../app/Actions/JpGraph/V1/PieAvgAction.php) - Pie chart con media
- [LineSubQuestionAction](../app/Actions/JpGraph/V1/LineSubQuestionAction.php) - Line chart multiplo

---

**Ultimo aggiornamento:** Gennaio 2026  
**Versione JpGraph:** 4.4.3 (PHP 8.5 support)  
**Pattern:** DRY + KISS  
**Livello:** Approfondito con analisi completa class reference
