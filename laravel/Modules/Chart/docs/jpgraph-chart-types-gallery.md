# JpGraph - Galleria Completa Tipi di Grafici

**Versione JpGraph**: 4.4.3
**Fonte**: [Gallery Ufficiale](https://jpgraph.net/features/gallery.php)
**Data**: Gennaio 2026

---

## Grafici Lineari

### Line Plots

Grafici a linee standard con configurazioni flessibili.

```php
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\LinePlot;

$graph = new Graph(800, 400);
$graph->SetScale('textlin');

$linePlot = new LinePlot($data);
$linePlot->SetColor('#1f77b4');
$linePlot->SetWeight(2);

$graph->Add($linePlot);
$graph->Stroke($path);
```

**Varianti**:
- **Filled Line Plots**: Riempimento con colore, semi-trasparente o gradiente
- **Step Line Plots**: Linee a 90 gradi tra punti
- **Line Plots With Markers**: Marcatori integrati o immagini custom
- **Inverted Y-axis**: Assi invertiti per profili specializzati
- **Values on Line**: Valori mostrati sui punti dati

### Area Charts

```php
$linePlot = new LinePlot($data);
$linePlot->SetFillColor('#1f77b4@0.3'); // Area con trasparenza
$linePlot->SetColor('#1f77b4');
```

---

## Grafici a Barre

### Bar Plots Standard

```php
use Amenadiel\JpGraph\Plot\BarPlot;

$barPlot = new BarPlot($data);
$barPlot->SetFillColor('#2ca02c@0.8');
$barPlot->SetColor('#2ca02c');
$barPlot->SetWidth(0.6);
```

**Varianti**:
- **Standard Bar**: Colori, gradienti, pattern
- **Sfondi e Pattern**: Bandiere, pattern di sfondo
- **Combined Line and Bar**: Combinazione di linee e barre nello stesso grafico

### Grouped Bar Plots

```php
use Amenadiel\JpGraph\Plot\GroupBarPlot;

$plot1 = new BarPlot($data1);
$plot1->SetFillColor('#1f77b4');
$plot2 = new BarPlot($data2);
$plot2->SetFillColor('#ff7f0e');

$group = new GroupBarPlot([$plot1, $plot2]);
$graph->Add($group);
```

### Stacked Bar Plots

```php
use Amenadiel\JpGraph\Plot\AccBarPlot;

$plot1 = new BarPlot($data1);
$plot2 = new BarPlot($data2);

$acc = new AccBarPlot([$plot1, $plot2]);
$graph->Add($acc);
```

### Horizontal Bar Plots

```php
$graph = new Graph(800, 400);
$graph->Set90AndMargin(100, 20, 50, 30);
$graph->SetScale('textlin');

$barPlot = new BarPlot($data);
$graph->Add($barPlot);
```

---

## Grafici Circolari

### Pie Plots 2D

```php
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;

$graph = new PieGraph(500, 400);
$piePlot = new PiePlotC($data);
$piePlot->SetSliceColors($colors);
$piePlot->SetLegends($labels);
$piePlot->SetLabelType(PIE_VALUE_PER);

$graph->Add($piePlot);
```

**Varianti**:
- **Standard Pie**: Con temi diversi
- **Exploding Pie**: Fette esplode per enfasi
- **Ring Plots (Donut)**: Anello centrale formattabile

### Pie 3D

```php
use Amenadiel\JpGraph\Plot\PiePlot3D;

$piePlot3D = new PiePlot3D($data);
$piePlot3D->SetAngle(45); // Prospettiva 3D
$piePlot3D->SetHeight(12); // Altezza 3D
```

---

## Grafici Specializzati

### Scatter Plots

```php
use Amenadiel\JpGraph\Plot\ScatterPlot;

$scatterPlot = new ScatterPlot($yData, $xData);
$scatterPlot->mark->SetType(MARK_FILLEDCIRCLE);
$scatterPlot->mark->SetFillColor('#d62728');
$scatterPlot->mark->SetSize(6);
```

**Varianti**:
- Scatter semplice
- Scatter con linee di collegamento
- Scatter con bubble (dimensione variabile)

### Radar Plots

```php
$graph = new RadarGraph(500, 400);
$graph->SetScale('lin');

$radarPlot = new RadarPlot($data);
$radarPlot->SetFillColor('#1f77b4@0.3');
$graph->Add($radarPlot);
```

### Polar Plots

```php
$graph = new PolarGraph(500, 400);
$polarPlot = new PolarPlot($data);
$graph->Add($polarPlot);
```

- **180 gradi**: Semicerchio
- **360 gradi**: Cerchio completo

### Gantt Charts

```php
$graph = new GanttGraph(800, 400);
// Configurazione task, milestones, dipendenze
```

### Stock Plots

Grafici finanziari OHLC (Open, High, Low, Close).

### Contour Plots

Curve di livello per dati tridimensionali.

### Impulse Plots

Barre sottili da asse a punto dati.

### Field Plots

Campi vettoriali con direzione e magnitudine.

### Spline Curves

Interpolazione cubica per curve morbide da pochi punti dati.

---

## Grafici Professional (Solo versione Pro)

### Odometer Plots

Indicatori gauge per KPI e metriche.

### Windrose Plots

Rose dei venti per dati direzionali.

### Barcodes

- **Lineari (1D)**: Code39, Code128, EAN13, UPC, etc.
- **PDF417 (2D)**
- **Datamatrix (2D)**
- **QR Code (2D)**

---

## Mappatura Chart Types -> Actions nel Progetto

| Tipo Grafico | JpGraph Class | Action Progetto | Usato Per |
|-------------|--------------|-----------------|-----------|
| Bar semplice | `BarPlot` | `Bar1Action` | Distribuzione risposte |
| Bar multiplo | `GroupBarPlot` | `Bar2Action` | Confronto periodi |
| Bar stacked | `AccBarPlot` | `Bar3Action` | Composizione totali |
| Bar orizzontale | `BarPlot` (90) | `Horizbar1Action` | Label lunghe |
| Pie/Donut | `PiePlotC` | `Pie1Action` | Distribuzione percentuale |
| Pie con media | `PiePlotC` | `PieAvgAction` | Media risposte |
| Line multiplo | `LinePlot` | `LineSubQuestionAction` | Trend subquestion |

---

## Riferimenti

- [JpGraph Gallery Ufficiale](https://jpgraph.net/features/gallery.php)
- [JpGraph 4.4.3 Reference](./jpgraph-4-4-3-reference.md)
- [JpGraph Installation e Namespace](./jpgraph-installation-and-namespaces.md)

---

**Versione Documentazione**: 1.0.0
**Data**: Gennaio 2026
