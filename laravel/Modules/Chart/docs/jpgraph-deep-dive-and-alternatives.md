# JpGraph Deep Dive e Librerie Alternative - Guida Approfondita

**Data:** Gennaio 2026  
**Modulo:** Chart  
**Versione JpGraph:** 4.4.3 (PHP 8.5 support)  
**Fonte:** https://jpgraph.net/

---

## 📋 Indice

1. [JpGraph: Analisi Approfondita](#jpgraph-analisi-approfondita)
2. [Caratteristiche e Capacità](#caratteristiche-e-capacità)
3. [Librerie Alternative: Confronto Completo](#librerie-alternative-confronto-completo)
4. [Quando Usare JpGraph vs Alternative](#quando-usare-jpgraph-vs-alternative)
5. [Pattern di Utilizzo nel Progetto](#pattern-di-utilizzo-nel-progetto)
6. [Best Practices e Ottimizzazioni](#best-practices-e-ottimizzazioni)

---

## JpGraph: Analisi Approfondita

### Overview Completo

**JpGraph** è una libreria PHP orientata agli oggetti per la generazione di grafici server-side di alta qualità. È completamente scritta in PHP e pronta per essere utilizzata in qualsiasi script PHP (CGI/APXS/CLI).

**Versione Attuale:** 4.4.3 (Gennaio 2026)
- ✅ Supporta PHP 8.5
- ✅ Free version disponibile
- ✅ Professional version con features avanzate

### Caratteristiche Principali

#### 1. Web-Friendly Output

- **Dimensione Media Immagine**: 2-5KB per immagini 300x200px
- **Formato**: PNG (ottimizzato per web)
- **Qualità**: Alta risoluzione per stampa PDF
- **Compressione**: Automatica e ottimizzata

#### 2. Tipi di Grafici Supportati

**Line/Area Charts:**
- Line Plots (linee base)
- Filled Line Plots (aree riempite)
- Step Line Plots (linee a gradino)
- Line Plots With Markers (linee con marcatori)
- Line Plots With Inverted Y-axis (assi invertiti)
- Line Plots With Values (valori mostrati)

**Bar Charts:**
- Standard Bar plots (barre verticali)
- Horizontal Bar plots (barre orizzontali)
- Adding backgrounds and patterns (sfondi e pattern)
- Combined Line and Bar plots (combinati)

**Pie Charts:**
- Pie Plots (torte standard)
- 3D Pie plots (torte 3D)
- Exploding Pie plots (torte esplose)

**Altri Tipi:**
- Scatter plots (grafici a dispersione)
- Impulse plots (grafici impulso)
- Field plots (grafici campo)
- Splines (curve spline)
- Geo Maps (mappe geografiche)
- Stock charts (grafici azionari)
- Polar charts (grafici polari)
- Error plots (grafici errore)
- Balloon plots (grafici palloncino)
- Radar charts (grafici radar)
- Contour charts (grafici contorno)
- Canvas charts (Pro version)

#### 3. Features Avanzate

**Interattività:**
- ✅ **Client-side image maps**: Generazione automatica per drill-down
- ✅ **Clickable charts**: Grafici cliccabili con link

**Visualizzazione:**
- ✅ **Alpha blending**: Supporto trasparenza avanzata
- ✅ **200+ Country flags**: Bandiere integrate
- ✅ **400+ Named colors**: Palette colori estesa
- ✅ **Background images**: Supporto immagini di sfondo

**Scales e Assi:**
- ✅ **Multiple Y-axes**: Supporto assi Y multipli
- ✅ **Flexible scales**: Integer, linear, logarithmic, text (counting)
- ✅ **Combination scales**: Qualsiasi combinazione di scale

**Documentazione:**
- ✅ **750+ pages tutorial**: Tutorial completo
- ✅ **Extensive class reference**: Riferimento classi completo
- ✅ **HowTo's**: Guide pratiche
- ✅ **FAQ**: Domande frequenti

**Performance:**
- ✅ **Internal caching**: Cache interna con timeout
- ✅ **Optimized for HTTP**: Ottimizzato per server HTTP

### Architettura JpGraph nel Progetto

#### Pattern Action-Based

Il progetto utilizza un pattern **Action-Based** per generare grafici JpGraph:

```
ChartData DTO
    ↓
getActionClass() → '\Modules\Chart\Actions\JpGraph\V1\{Type}Action'
    ↓
Action->execute(AnswersChartData)
    ↓
GetGraphAction (crea Graph base)
    ↓
Crea Plot (BarPlot, PiePlotC, LinePlot, etc.)
    ↓
ApplyPlotStyleAction (applica stile)
    ↓
Graph->Add($plot)
    ↓
Graph->Stroke($file_path) → PNG
```

#### Actions Disponibili

**Location**: `Modules/Chart/app/Actions/JpGraph/V1/`

| Action | Tipo | Uso | Features |
|--------|------|-----|----------|
| `Bar1Action` | `bar1` | Bar chart semplice | Un dataset, un colore |
| `Bar2Action` | `bar2` | Bar chart multiplo | GroupBarPlot, multiple dataset |
| `Bar3Action` | `bar3` | Bar chart avanzato | AccBarPlot, stacked |
| `Horizbar1Action` | `horizbar1` | Bar chart orizzontale | Assi invertiti |
| `Pie1Action` | `pie1` | Pie chart standard | PiePlotC, percentuali |
| `PieAvgAction` | `pieAvg` | Pie chart con media | Media calcolata |
| `LineSubQuestionAction` | `lineSubQuestion` | Line chart | Multiple linee, markers |

#### Pattern GetGraphAction

```php
/**
 * GetGraphAction - Crea Graph base con configurazione completa.
 * 
 * Pattern:
 * - Crea Graph con dimensioni
 * - Applica tema UniversalTheme
 * - Configura titolo, sottotitolo, footer
 * - Configura assi X e Y
 * - Configura scale e range
 */
class GetGraphAction
{
    public function execute(ChartData $chartData): Graph
    {
        // 1. Crea Graph
        $graph = new Graph($chartData->width, $chartData->height, 'auto');
        
        // 2. Configura scale
        $graph->SetScale('textlin'); // Scale lineare con label testuali
        
        // 3. Applica tema
        $universalTheme = new UniversalTheme;
        $graph->SetTheme($universalTheme);
        
        // 4. Configura titoli
        if ($chartData->title !== null) {
            $graph->title->Set($chartData->title);
            $graph->title->SetFont($chartData->font_family, $chartData->font_style, 11);
        }
        
        // 5. Configura assi
        $this->applyGraphXStyle($graph->xaxis, $chartData);
        $this->applyGraphYStyle($graph->yaxis, $chartData);
        
        return $graph;
    }
}
```

#### Pattern ApplyPlotStyleAction

```php
/**
 * ApplyPlotStyleAction - Applica stile ai Plot.
 * 
 * Pattern:
 * - Colori con trasparenza
 * - Larghezza barre
 * - Valori sopra barre
 * - Font e colori valori
 */
class ApplyPlotStyleAction
{
    public function execute(BarPlot $barPlot, ChartData $chartData): BarPlot
    {
        // Colore con trasparenza (formato JpGraph: #color@alpha)
        $barPlot->SetFillColor($chartData->list_color.'@'.$chartData->transparency);
        $barPlot->SetColor($chartData->list_color);
        
        // Larghezza barre (percentuale)
        $barPlot->SetWidth($chartData->plot_perc_width / 100);
        
        // Mostra valori sopra barre
        if ($chartData->plot_value_show) {
            $barPlot->value->Show();
            $barPlot->value->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
            $barPlot->value->SetColor($chartData->plot_value_color ?? 'black');
        }
        
        return $barPlot;
    }
}
```

---

## Caratteristiche e Capacità

### 1. Tipi di Grafici Dettagliati

#### Line/Area Charts

**Line Plots Base:**
```php
$linePlot = new LinePlot($data);
$linePlot->SetColor('#3b82f6');
$linePlot->SetWeight(2);
$graph->Add($linePlot);
```

**Filled Line Plots:**
```php
$linePlot = new LinePlot($data);
$linePlot->SetFillColor('#3b82f6@0.3'); // Area riempita con trasparenza
$graph->Add($linePlot);
```

**Line Plots With Markers:**
```php
$linePlot = new LinePlot($data);
$linePlot->mark->SetType(MARK_CIRCLE);
$linePlot->mark->SetColor('#3b82f6');
$linePlot->mark->SetFillColor('#ffffff');
$graph->Add($linePlot);
```

#### Bar Charts

**Standard Bar Plots:**
```php
$barPlot = new BarPlot($data);
$barPlot->SetFillColor('#3b82f6@0.8');
$barPlot->SetColor('#2563eb');
$graph->Add($barPlot);
```

**Grouped Bar Plots (Bar2Action Pattern):**
```php
$bplot1 = new BarPlot($data1);
$bplot2 = new BarPlot($data2);
$groupBarPlot = new GroupBarPlot([$bplot1, $bplot2]);
$graph->Add($groupBarPlot);
```

**Accumulated Bar Plots (Bar3Action Pattern):**
```php
$accBarPlot = new AccBarPlot([$bplot1, $bplot2]);
$graph->Add($accBarPlot);
```

#### Pie Charts

**Pie PlotC (Pie1Action Pattern):**
```php
$piePlotC = new PiePlotC($data);
$piePlotC->SetSliceColors($colors); // Array colori
$piePlotC->SetLegends($labels);
$piePlotC->SetMidSize(0.8); // Doughnut effect
$piePlotC->SetLabelType(PIE_VALUE_PER); // Percentuali
$graph->Add($piePlotC);
```

**3D Pie Plots:**
```php
$piePlot3D = new PiePlot3D($data);
$piePlot3D->SetSliceColors($colors);
$piePlot3D->SetEdge('#ffffff', 1);
$graph->Add($piePlot3D);
```

#### Scatter Plots

```php
$scatterPlot = new ScatterPlot($dataX, $dataY);
$scatterPlot->mark->SetType(MARK_CIRCLE);
$scatterPlot->mark->SetColor('#3b82f6');
$graph->Add($scatterPlot);
```

### 2. Scales e Assi Avanzati

#### Multiple Y-Axes

```php
// Y-axis sinistro
$graph->SetYScale('lin', 0, 100);
$graph->SetY2Scale('lin', 0, 10); // Y-axis destro

// Plot per Y-axis sinistro
$plot1 = new LinePlot($data1);
$plot1->SetYAxis('y'); // Usa Y-axis sinistro
$graph->Add($plot1);

// Plot per Y-axis destro
$plot2 = new LinePlot($data2);
$plot2->SetYAxis('y2'); // Usa Y-axis destro
$graph->AddY2($plot2);
```

#### Scale Types

```php
// Linear scale
$graph->SetScale('linlin'); // X linear, Y linear

// Logarithmic scale
$graph->SetScale('loglin'); // X log, Y linear

// Text scale (per labels)
$graph->SetScale('textlin'); // X text, Y linear

// Date scale
$graph->SetScale('datlin'); // X date, Y linear
```

### 3. Personalizzazione Avanzata

#### Colori e Trasparenza

```php
// Colore singolo
$color = '#3b82f6';

// Colore con trasparenza (formato JpGraph)
$color = '#3b82f6@0.8'; // 80% opaco

// Array colori
$colors = ['#3b82f6', '#10b981', '#f59e0b'];

// Array colori con trasparenza
$colors = ['#3b82f6@0.8', '#10b981@0.8', '#f59e0b@0.8'];
```

#### Font e Testi

```php
// Font constants (JpGraph)
FF_ARIAL = 1
FF_TIMES = 2
FF_COURIER = 3
FF_VERDANA = 4

// Font style constants
FS_NORMAL = 0
FS_BOLD = 1
FS_ITALIC = 2
FS_BOLDITALIC = 3

// Uso
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
```

#### Margini e Layout

```php
// Margini (top, right, bottom, left)
$graph->img->SetMargin(50, 50, 50, 100);

// Box (bordo)
$graph->SetBox(true); // Mostra box
$graph->SetBox(false); // Nascondi box

// Shadow (ombra)
$graph->SetShadow(); // Aggiungi ombra
```

---

## Librerie Alternative: Confronto Completo

### Panoramica Alternative

| Libreria | Tipo | Output | PHP 8.x | Status | Quando Usare |
|----------|------|--------|---------|--------|--------------|
| **JpGraph** | Server-side | PNG/SVG | ✅ 8.5 | ✅ Attivo | PDF, report statici, batch |
| **pChart** | Server-side | PNG/JPG | ⚠️ Limitato | ⚠️ Legacy | Grafici semplici, legacy code |
| **PHPGraphLib** | Server-side | PNG | ❌ No | ⚠️ Abbandonato | ❌ Non usare |
| **ChartDirector** | Server-side | PNG/SVG | ✅ | ✅ Commerciale | Enterprise, alta qualità |
| **GraPHPite** | Server-side | PNG | ⚠️ | ⚠️ Limitato | Grafici base |
| **LibChart** | Server-side | PNG | ❌ | ❌ Abbandonato | ❌ Non usare |
| **TeeChart** | Server-side | PNG/SVG | ✅ | ✅ Commerciale | Enterprise, .NET background |
| **FusionCharts** | Client/Server | PNG/SVG/Flash | ✅ | ✅ Attivo | Dashboard interattive |
| **ChartLogix** | Server-side | PNG/JPG | ✅ | ✅ Attivo | Grafici leggeri |
| **Image-Charts** | API Service | PNG/GIF/JPEG | ✅ | ✅ Attivo | SaaS, no install |
| **SVG Charts** | Server-side | SVG | ✅ | ✅ Attivo | Grafici vettoriali |

### Analisi Dettagliata Alternative

#### 1. pChart

**Caratteristiche:**
- Libreria PHP leggera
- Supporto grafici base (bar, line, pie)
- Output PNG/JPG
- Sintassi semplice

**Vantaggi:**
- Leggero e veloce
- Facile da usare
- Buona per grafici semplici

**Svantaggi:**
- Limitato supporto PHP 8.x
- Features limitate rispetto a JpGraph
- Meno personalizzabile
- Documentazione limitata

**Quando Usare:**
- Grafici molto semplici
- Progetti legacy
- Quando JpGraph è overkill

**Quando NON Usare:**
- Grafici complessi
- PDF professionali
- Multiple dataset
- Personalizzazione avanzata

#### 2. ChartDirector

**Caratteristiche:**
- Libreria commerciale potente
- Supporto PHP 8.x completo
- Output PNG/SVG di alta qualità
- Features enterprise

**Vantaggi:**
- Alta qualità output
- Features avanzate
- Supporto commerciale
- Performance ottimizzate

**Svantaggi:**
- Costo (licenza commerciale)
- Learning curve ripida
- Overkill per progetti semplici

**Quando Usare:**
- Progetti enterprise
- Budget per licenza
- Grafici molto complessi
- Qualità massima richiesta

#### 3. Image-Charts (API Service)

**Caratteristiche:**
- Servizio API (SaaS)
- No installazione locale
- Output PNG/GIF/JPEG
- Supporto Chart.js syntax

**Vantaggi:**
- No installazione
- Scalabile
- Sempre aggiornato
- Chart.js compatibility

**Svantaggi:**
- Dipendenza esterna
- Costo per volume
- Privacy dati (API esterna)
- Latency network

**Quando Usare:**
- No installazione locale possibile
- Scalabilità cloud
- Chart.js migration
- Budget per API service

**Quando NON Usare:**
- Dati sensibili (privacy)
- Offline/air-gapped
- Budget limitato
- Controllo totale richiesto

#### 4. ChartLogix

**Caratteristiche:**
- Libreria PHP leggera
- Self-contained
- Output PNG/JPG
- Supporto PHP 8.x

**Vantaggi:**
- Leggero
- Facile implementazione
- Self-contained
- Supporto attivo

**Svantaggi:**
- Features limitate
- Meno tipi grafici
- Personalizzazione limitata

**Quando Usare:**
- Grafici semplici
- Progetti leggeri
- Quando JpGraph è troppo

#### 5. SVG Charts (maantje/charts)

**Caratteristiche:**
- Generazione SVG server-side
- Moderno (PHP 8.x)
- Vettoriale (scalabile)
- GitHub: 318 stars

**Vantaggi:**
- Output vettoriale (scalabile)
- Moderno e attivo
- Leggero
- Buono per web

**Svantaggi:**
- Features limitate
- Meno maturo di JpGraph
- Community più piccola

**Quando Usare:**
- Output SVG richiesto
- Grafici web moderni
- Scalabilità vettoriale

---

## Quando Usare JpGraph vs Alternative

### Decision Tree

```
Hai bisogno di grafici server-side per PDF?
├─ SÌ → Budget per licenza commerciale?
│   ├─ SÌ → ChartDirector (enterprise)
│   └─ NO → JpGraph (free, potente)
│
└─ NO → Grafici web interattivi?
    ├─ SÌ → Chart.js (frontend)
    └─ NO → Grafici semplici?
        ├─ SÌ → pChart o ChartLogix
        └─ NO → JpGraph
```

### Criteri di Scelta

#### Usa JpGraph Quando:

1. **PDF Generation**: Grafici per PDF professionali
2. **Server-Side Only**: Nessuna dipendenza JavaScript
3. **Multiple Chart Types**: Bar, pie, line, scatter, radar, etc.
4. **Customization**: Personalizzazione avanzata richiesta
5. **Quality**: Alta qualità output per stampa
6. **Batch Processing**: Generazione massiva grafici
7. **No External Dependencies**: Tutto server-side, no API esterne

#### Usa Alternative Quando:

**pChart:**
- Grafici molto semplici
- Progetti legacy
- Budget zero per librerie

**ChartDirector:**
- Budget enterprise
- Qualità massima richiesta
- Supporto commerciale necessario

**Image-Charts:**
- No installazione possibile
- Scalabilità cloud
- Chart.js compatibility

**SVG Charts:**
- Output SVG richiesto
- Grafici web moderni
- Scalabilità vettoriale

---

## Pattern di Utilizzo nel Progetto

### Pattern Completo: Dati → PNG

```php
/**
 * Pattern completo generazione chart JpGraph nel progetto.
 * 
 * Workflow:
 * 1. Query dati aggregazione mensile
 * 2. Prepara AnswerData collection
 * 3. Crea ChartData DTO
 * 4. Crea AnswersChartData DTO
 * 5. Risolvi Action class
 * 6. Esegue Action → Graph
 * 7. Graph->Stroke() → PNG
 */
class MakeMonthlyChartForPdfAction
{
    public function execute(
        QuestionChart $questionChart,
        ?AnswersFilterData $filter = null
    ): string {
        // STEP 1: Query aggregazione mensile
        $monthlyData = SurveyResponse::getResponsesForSurvey($surveyId)
            ->selectRaw('
                DATE_FORMAT(submitdate, "%Y-%m") as month_key,
                DATE_FORMAT(submitdate, "%b %Y") as month_label,
                COUNT(*) as response_count,
                ROUND(AVG(CAST('.$fieldName.' AS DECIMAL(10,2))), 2) as avg_value
            ')
            ->whereNotNull('submitdate')
            ->whereNotNull($fieldName)
            ->groupBy('month_key', 'month_label')
            ->orderBy('month_key')
            ->get();
        
        // STEP 2: Prepara AnswerData
        $answers = $monthlyData->map(function ($month) {
            return AnswerData::from([
                'label' => $month->month_label,
                'value' => $month->response_count,
                'avg' => $month->avg_value,
            ]);
        });
        
        // STEP 3: Crea ChartData
        $chartData = ChartData::from([
            'type' => 'bar2',  // Determina Action class
            'width' => 800,     // A4 landscape
            'height' => 400,
            'list_color' => '#3b82f6,#10b981',  // Colori dataset
            'transparency' => '0.8',
            'title' => 'Risposte Mensili',
            'font_family' => FF_ARIAL,
            'font_style' => FS_BOLD,
            'font_size' => 12,
        ]);
        
        // STEP 4: Crea AnswersChartData
        $answersChartData = AnswersChartData::from([
            'answers' => $answers,
            'chart' => $chartData,
        ]);
        
        // STEP 5: Risolvi Action class
        // ChartData->getActionClass() → '\Modules\Chart\Actions\JpGraph\V1\Bar2Action'
        $actionClass = $chartData->getActionClass();
        
        // STEP 6: Esegue Action
        $graphAction = app($actionClass);
        $graph = $graphAction->execute($answersChartData);
        
        // STEP 7: Salva PNG
        $filename = 'chart/monthly-'.$questionChart->id.'-'.time().'.png';
        $filePath = public_path($filename);
        $graph->Stroke($filePath);
        
        return $filename;
    }
}
```

### Pattern Memory Management

```php
/**
 * Pattern gestione memoria per grafici complessi.
 * 
 * JpGraph può richiedere molta memoria per grafici complessi.
 * Pattern: Aumenta limiti temporaneamente, poi ripristina.
 */
class MakeImgByQuestionChartModel2Action
{
    public function execute(...): array
    {
        // Aumenta limiti per generazione
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        
        try {
            // Genera grafici
            foreach ($questionCharts as $chart) {
                $graph = $this->generateChart($chart);
                $graph->Stroke($filePath);
            }
        } finally {
            // Ripristina limiti (opzionale)
            // ini_restore('memory_limit');
            // ini_restore('max_execution_time');
        }
    }
}
```

### Pattern Error Handling

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

---

## Best Practices e Ottimizzazioni

### 1. Dimensioni Ottimali per PDF

```php
/**
 * Dimensioni ottimali per PDF A4.
 * 
 * Pattern:
 * - Landscape: 800x400px (ottimo per bar/line)
 * - Portrait: 600x300px (ottimo per pie)
 * - Evita dimensioni > 2000px (file PNG troppo grandi)
 */
$chartData = ChartData::from([
    'width' => 800,   // Landscape A4
    'height' => 400,
    // OPPURE
    'width' => 600,   // Portrait A4
    'height' => 300,
]);
```

### 2. Colori e Trasparenza

```php
/**
 * Pattern colori ottimizzato.
 * 
 * - Usa trasparenza 0.7-0.8 per leggibilità
 * - Evita trasparenza < 0.5 (troppo trasparente)
 * - Usa palette coerente con design system
 */
$chartData->list_color = '#3b82f6,#10b981,#f59e0b';  // Palette coerente
$chartData->transparency = '0.8';  // 80% opaco (ottimo)
```

### 3. Font e Leggibilità

```php
/**
 * Pattern font per PDF.
 * 
 * - Font size minimo: 10pt (leggibile in PDF)
 * - Font size titoli: 12-14pt
 * - Font size labels: 10-11pt
 * - Usa FF_ARIAL per leggibilità
 */
$chartData->font_family = FF_ARIAL;  // Leggibile
$chartData->font_size = 12;           // Titoli
$chartData->font_style = FS_BOLD;      // Enfatizza
```

### 4. Performance Optimization

```php
/**
 * Pattern caching per grafici generati.
 * 
 * Strategia:
 * - Cache grafici per periodi non recenti
 * - Invalida cache quando dati cambiano
 * - Usa tag cache per invalidazione selettiva
 */
$cacheKey = 'chart-'.$questionChart->id.'-'.md5(serialize($filter));
$cacheTTL = $this->getCacheTTL($filter);

$chartImage = Cache::tags(['charts', 'question-chart-'.$questionChart->id])
    ->remember($cacheKey, $cacheTTL, function () use ($questionChart, $filter) {
        return $this->generateChart($questionChart, $filter);
    });
```

### 5. Quality Settings

```php
/**
 * Pattern qualità output.
 * 
 * JpGraph genera PNG di alta qualità di default.
 * Per ottimizzare:
 * - Usa dimensioni appropriate (non eccessive)
 * - Evita trasparenza eccessiva
 * - Limita numero dataset (max 5-6 per grafico)
 */
$chartData = ChartData::from([
    'width' => 800,   // Ottimo per qualità/dimensione
    'height' => 400,
    'transparency' => '0.8',  // Non troppo trasparente
]);
```

---

## Confronto JpGraph vs Chart.js

### Quando Usare JpGraph (Server-Side)

✅ **Usa JpGraph per:**
- PDF generation
- Report statici
- Batch processing
- No JavaScript dependency
- Server-side only

### Quando Usare Chart.js (Client-Side)

✅ **Usa Chart.js per:**
- Dashboard interattive
- Real-time updates
- User interaction (zoom, pan, click)
- Web applications
- Responsive design

### Pattern Dual (Progetto Attuale)

Il progetto utilizza **entrambi** in modo complementare:

```
Dashboard Filament
    ↓
Chart.js (interattivo)
    ↓
User clicks "Export PDF"
    ↓
JpGraph (genera PNG)
    ↓
Embed in PDF
```

---

## Riferimenti

### Documentazione JpGraph

- [JpGraph Official Site](https://jpgraph.net/)
- [JpGraph Documentation Portal](https://jpgraph.net/download/manuals)
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html) - ⭐ **RIFERIMENTO PRINCIPALE** - Class Reference completa ufficiale
- [JpGraph HowTo's](https://jpgraph.net/doc/howto.php)
- [JpGraph FAQ](https://jpgraph.net/doc/faq.php)
- [JpGraph Gallery](https://jpgraph.net/features/gallery.php)

### Alternative Libraries

- [pChart](http://www.pchart.net/) - Lightweight PHP charts
- [ChartDirector](https://www.advsofteng.com/) - Commercial PHP charts
- [Image-Charts](https://www.image-charts.com/) - API service
- [ChartLogix](https://phpcharting.com/) - Lightweight PHP charts
- [SVG Charts](https://github.com/maantje/charts) - SVG generation

### Documentazione Moduli

- [JpGraph Class Reference Complete](./jpgraph-class-reference-complete.md) - ⭐ **NUOVO** - Guida completa Class Reference basata su documentazione ufficiale
- [JpGraph Complete Guide](./jpgraph-complete-guide.md)
- [JpGraph Step-by-Step Guide](./jpgraph-step-by-step-guide.md)
- [Chart.js Integration](./filament-charts-professional-guide.md)
- [PDF Integration](./pdf-integration-complete-guide.md)

---

**Ultimo aggiornamento:** Gennaio 2026  
**Versione JpGraph:** 4.4.3 (PHP 8.5)  
**Pattern:** DRY + KISS  
**Livello:** Approfondito con analisi alternative
