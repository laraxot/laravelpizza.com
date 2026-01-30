# Integrazione Chart Mensili LimeSurvey nel Modulo Chart - Guida Approfondita

**Data:** Gennaio 2026  
**Modulo:** Chart  
**Target:** Filament 5.x, Laravel 12.x  
**Integrazione:** LimeSurvey + JpGraph + PDF

---

## Overview

Questo documento descrive in dettaglio come integrare widget chart Filament con dati LimeSurvey per visualizzare aggregazioni mensili (numero risposte e media) e come generare chart per PDF usando JpGraph, seguendo i pattern esistenti nel codebase.

---

## Architettura Integrazione

### Pattern Dual: Chart.js (Frontend) + JpGraph (Backend PDF)

Il sistema utilizza due librerie complementari:

```
┌─────────────────────────────────────────────────────────────┐
│                    FILAMENT DASHBOARD                        │
│  ┌──────────────────────────────────────────────────────┐   │
│  │  Widget Chart (XotBaseChartWidget)                  │   │
│  │  - Chart.js per visualizzazione interattiva         │   │
│  │  - getData(): Query aggregazione mensile            │   │
│  │  - getOptions(): Configurazione Chart.js            │   │
│  └──────────────────┬───────────────────────────────────┘   │
└─────────────────────┼───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│              PDF GENERATION                                  │
│  ┌──────────────────────────────────────────────────────┐   │
│  │  MakeImgByQuestionChartModel2Action                   │   │
│  │  - JpGraph per generazione server-side                │   │
│  │  - AnswersChartData + ChartData DTOs                  │   │
│  │  - getActionClass() → JpGraph Action                  │   │
│  │  - $graph->Stroke() → PNG                             │   │
│  └──────────────────┬───────────────────────────────────┘   │
└─────────────────────┼───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│              CHART MODULE                                     │
│  ┌──────────────────────────────────────────────────────┐   │
│  │  JpGraph Actions (V1/)                                │   │
│  │  - Bar2Action, Pie1Action, LineSubQuestionAction     │   │
│  │  - Execute(AnswersChartData) → Graph                  │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

## Pattern Chart.js (Frontend Widget)

### Widget Base Pattern

Tutti i widget chart mensili devono estendere `XotBaseChartWidget`:

```php
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class LimeSurveyMonthlyChartWidget extends XotBaseChartWidget
{
    protected function getData(): array
    {
        // Query aggregazione mensile
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
        
        return [
            'datasets' => [
                [
                    'label' => 'Numero Risposte',
                    'data' => $monthlyData->pluck('response_count')->toArray(),
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Media Risposte',
                    'data' => $monthlyData->pluck('avg_value')->toArray(),
                    'type' => 'line',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $monthlyData->pluck('month_label')->toArray(),
        ];
    }
}
```

### Dual Y-axis Configuration

Per visualizzare numero risposte (bar) e media (line) insieme:

```php
protected function getOptions(): array
{
    $options = parent::getOptions();
    
    $options['scales'] = [
        'y' => [
            'type' => 'linear',
            'position' => 'left',
            'beginAtZero' => true,
            'title' => ['display' => true, 'text' => 'Numero Risposte'],
        ],
        'y1' => [
            'type' => 'linear',
            'position' => 'right',
            'beginAtZero' => true,
            'title' => ['display' => true, 'text' => 'Media Risposte'],
            'grid' => ['drawOnChartArea' => false], // Evita sovrapposizione
        ],
    ];
    
    return $options;
}
```

---

## Pattern JpGraph (Backend PDF)

### Workflow Completo Generazione Chart PDF

Basato su `MakeImgByQuestionChartModel2Action`:

```php
/**
 * Pattern completo generazione chart mensile per PDF.
 * 
 * Workflow:
 * 1. GetChartsDataByQuestionChart → AnswersChartData[]
 * 2. Per ogni chart: ChartData::from() + AnswersChartData::from()
 * 3. getActionClass() → JpGraph Action class
 * 4. Action->execute() → Graph object
 * 5. Graph->Stroke() → PNG file
 */
class MakeMonthlyChartForPdfAction
{
    public function execute(
        QuestionChart $questionChart,
        ?AnswersFilterData $filter = null
    ): string {
        // STEP 1: Query aggregazione mensile
        $monthlyData = SurveyResponse::getResponsesForSurvey($surveyId)
            ->selectRaw('DATE_FORMAT(submitdate, "%Y-%m") as month, COUNT(*) as count, AVG(...) as avg')
            ->groupBy('month')
            ->get();
        
        // STEP 2: Prepara AnswerData collection
        $answers = $monthlyData->map(function ($month) {
            return AnswerData::from([
                'label' => $month->month_label,
                'value' => $month->response_count,
                'avg' => $month->avg_value,
            ]);
        });
        
        // STEP 3: Crea ChartData DTO (configurazione grafico)
        $chartData = ChartData::from([
            'type' => 'bar2',  // Tipo JpGraph
            'width' => 800,    // Dimensioni per PDF A4 landscape
            'height' => 400,
            'list_color' => '#3b82f6,#10b981',  // Colori dataset
            'transparency' => 0.8,
        ]);
        
        // STEP 4: Crea AnswersChartData DTO
        $answersChartData = AnswersChartData::from([
            'answers' => $answers,
            'chart' => $chartData,
        ]);
        
        // STEP 5: Risolvi Action class dal tipo
        // ChartData->getActionClass() mappa:
        // 'bar2' → '\Modules\Chart\Actions\JpGraph\V1\Bar2Action'
        $actionClass = $chartData->getActionClass();
        
        // STEP 6: Esegue Action JpGraph
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

### Tipi Chart JpGraph Supportati per Aggregazione Mensile

#### Bar2Action (Consigliato per Mensile)

**Uso**: Numero risposte per mese, confronto visivo

```php
$chartData = ChartData::from([
    'type' => 'bar2',
    'width' => 800,
    'height' => 400,
    'list_color' => '#3b82f6',  // Colore barre
]);
```

**Caratteristiche:**
- Barre verticali
- Supporta multiple dataset (stacked)
- Ideale per confronto mensile

#### LineSubQuestionAction (Per Trend Media)

**Uso**: Trend temporale media risposte

```php
$chartData = ChartData::from([
    'type' => 'lineSubQuestion',
    'width' => 800,
    'height' => 400,
    'list_color' => '#10b981',  // Colore linea
]);
```

**Caratteristiche:**
- Linea continua
- Marker per ogni punto
- Ideale per visualizzare trend

#### Pie1Action (Per Distribuzione)

**Uso**: Distribuzione percentuale risposte per categoria (non mensile)

```php
$chartData = ChartData::from([
    'type' => 'pie1',
    'width' => 600,
    'height' => 600,
    'list_color' => '#3b82f6,#10b981,#f59e0b',  // Colori fette
]);
```

**Nota**: Pie chart generalmente non usato per aggregazione mensile (usa bar o line).

### Pattern ChartData DTO

Il DTO `ChartData` contiene tutte le configurazioni del grafico:

```php
use Modules\Chart\Datas\ChartData;

$chartData = ChartData::from([
    // Tipo grafico (determina Action class)
    'type' => 'bar2',
    
    // Dimensioni (per PDF: 800x400 landscape, 600x300 portrait)
    'width' => 800,
    'height' => 400,
    
    // Colori (comma-separated per multiple dataset)
    'list_color' => '#3b82f6,#10b981',
    
    // Trasparenza (0.0-1.0)
    'transparency' => 0.8,
    
    // Titolo, sottotitolo, footer (opzionali)
    'title' => 'Risposte Mensili',
    'subtitle' => 'Gennaio - Dicembre 2026',
    'footer' => 'Fonte: LimeSurvey',
    
    // Configurazioni avanzate
    'max' => 10,  // Max valore Y-axis
    'min' => 0,   // Min valore Y-axis
]);
```

### Pattern AnswersChartData DTO

Il DTO `AnswersChartData` combina dati risposte + configurazione:

```php
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\AnswerData;

$answers = collect($monthlyData)->map(function ($month) {
    return AnswerData::from([
        'label' => $month->month_label,      // "Gen 2026"
        'value' => $month->response_count,    // Numero risposte
        'avg' => $month->avg_value,          // Media (se numerico)
    ]);
});

$answersChartData = AnswersChartData::from([
    'answers' => $answers,  // Collection<AnswerData>
    'chart' => $chartData,   // ChartData DTO
]);
```

### Pattern getActionClass()

Il metodo `ChartData->getActionClass()` mappa tipo grafico → Action class:

```php
// In ChartData DTO
public function getActionClass(): string
{
    return match($this->type) {
        'bar1' => '\Modules\Chart\Actions\JpGraph\V1\Bar1Action',
        'bar2' => '\Modules\Chart\Actions\JpGraph\V1\Bar2Action',
        'bar3' => '\Modules\Chart\Actions\JpGraph\V1\Bar3Action',
        'pie1' => '\Modules\Chart\Actions\JpGraph\V1\Pie1Action',
        'pieAvg' => '\Modules\Chart\Actions\JpGraph\V1\PieAvgAction',
        'horizbar1' => '\Modules\Chart\Actions\JpGraph\V1\Horizbar1Action',
        'lineSubQuestion' => '\Modules\Chart\Actions\JpGraph\V1\LineSubQuestionAction',
        default => throw new \Exception("Unknown chart type: {$this->type}"),
    };
}
```

---

## Best Practices per Chart Mensili

### 1. Dimensioni PDF

**Landscape A4:**
- Width: 800px
- Height: 400px

**Portrait A4:**
- Width: 600px
- Height: 300px

### 2. Colori Palette

Usa palette coerente con design system:

```php
// Palette professionale slate
$colors = [
    '#1e293b',  // Slate-800 (primaria)
    '#475569',  // Slate-600 (secondaria)
    '#64748b',  // Slate-500 (terziaria)
    '#94a3b8',  // Slate-400 (quaternaria)
];

// Palette accenti
$accentColors = [
    '#3b82f6',  // Blue-500
    '#10b981',  // Green-500
    '#f59e0b',  // Yellow-500
    '#ef4444',  // Red-500
];
```

### 3. Performance

- **Cache chart generati** per periodi non recenti
- **Lazy loading** per widget dashboard
- **Query ottimizzate** con indici su submitdate

### 4. Error Handling

```php
try {
    $graph = $graphAction->execute($answersChartData);
    $graph->Stroke($filePath);
} catch (\Exception $e) {
    \Log::error('Chart generation failed', [
        'question_chart_id' => $questionChart->id,
        'error' => $e->getMessage(),
        'chart_type' => $chartData->type,
    ]);
    
    // Fallback: restituisci path vuoto o immagine placeholder
    return null;
}
```

---

## Pattern Integrazione con MakePdf2Action

### Workflow Completo PDF con Chart Mensili

```php
/**
 * Pattern: Estendere MakePdf2Action per chart mensili.
 * 
 * Basato su MakePdf2Action esistente con aggiunta aggregazione mensile.
 */
class MakeMonthlyPdfAction extends MakePdf2Action
{
    public function execute(
        SurveyPdf $surveyPdf,
        AnswersFilterData $answersFilterData
    ): BinaryFileResponse {
        $questionCharts = $surveyPdf->questionCharts
            ->where('show_on_pdf', 1);

        $chartImages = [];
        $monthlyData = [];

        // Genera chart per ogni question chart
        foreach ($questionCharts as $questionChart) {
            // Genera chart PNG (pattern MakeImgByQuestionChartModel2Action)
            $chartImage = app(MakeMonthlyChartForPdfAction::class)
                ->execute($questionChart, $answersFilterData);
            
            $chartImages[$questionChart->id] = $chartImage;

            // Prepara dati mensili per tabella (pattern QuestionChartAnswersByMonthTableWidget)
            $monthlyData[$questionChart->id] = $this->getMonthlyData(
                $questionChart,
                $answersFilterData
            );
        }

        // Renderizza template Blade (pattern MakeHtmlBySurveyPdfModelAction)
        $html = view('surveys.pdf-monthly-report', [
            'surveyPdf' => $surveyPdf,
            'questionCharts' => $questionCharts,
            'chartImages' => $chartImages,
            'monthlyData' => $monthlyData,
            'dateFrom' => $answersFilterData->date_from,
            'dateTo' => $answersFilterData->date_to,
        ])->render();

        // Genera PDF (pattern MakePdf2Action)
        $html2pdf = new Html2Pdf('L', 'A4', 'it');
        $html2pdf->setTestIsImage(false);
        $html2pdf->writeHTML($html);

        $filename = 'monthly-report-'.$surveyPdf->id.'-'.date('Y-m-d').'.pdf';
        $path = storage_path('app/'.$filename);
        $html2pdf->output($path, 'F');

        return response()->download($path);
    }
}
```

---

## DTOs Pattern: ChartData e AnswersChartData - Analisi Approfondita

### ChartData DTO: Configurazione Completa

Il DTO `ChartData` contiene tutte le configurazioni necessarie per generare un grafico:

```php
use Modules\Chart\Datas\ChartData;

$chartData = ChartData::from([
    // ⚠️ OBBLIGATORIO: Tipo determina Action class
    'type' => 'bar2',  // Mappa a Bar2Action
    
    // Dimensioni (obbligatorie per PDF)
    'width' => 800,    // A4 landscape
    'height' => 400,
    
    // Colori (comma-separated per multiple dataset)
    'list_color' => '#3b82f6,#10b981',  // Blu per risposte, verde per media
    
    // Trasparenza (0.0-1.0)
    'transparency' => 0.8,
    
    // Testi (opzionali)
    'title' => 'Risposte Mensili',
    'subtitle' => 'Gennaio - Dicembre 2026',
    'footer' => 'Fonte: LimeSurvey',
    
    // Range Y-axis (opzionali)
    'max' => 10,  // Max valore (per scale 0-10)
    'min' => 0,   // Min valore
    
    // Styling avanzato
    'font_family' => 'Arial',
    'font_size' => '12',
    'font_style' => 'normal',
    'x_label_angle' => 45,  // Rotazione labels X-axis
    'plot_value_show' => true,  // Mostra valori su barre
    'plot_value_pos' => 0,  // Posizione valori (0=top, 1=bottom)
]);
```

**Metodi Utili ChartData:**

```php
// Ottieni array colori
$colors = $chartData->getColors();  // ['#3b82f6', '#10b981']

// Ottieni colori RGBA con alpha
$colorsRgba = $chartData->getColorsRgba(0.8);  // ['rgba(59, 130, 246, 0.8)', ...]

// Risolvi Action class dal tipo
$actionClass = $chartData->getActionClass();  // '\Modules\Chart\Actions\JpGraph\V1\Bar2Action'
```

### AnswersChartData DTO: Dati + Configurazione

Il DTO `AnswersChartData` combina dati risposte con configurazione grafico:

```php
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\AnswerData;

// Prepara AnswerData collection
$answers = collect($monthlyData)->map(function ($month) {
    return AnswerData::from([
        'label' => $month->month_label,      // "Gen 2026"
        'value' => $month->response_count,    // Numero risposte
        'avg' => $month->avg_value,          // Media (se numerico)
    ]);
});

// Crea AnswersChartData
$answersChartData = AnswersChartData::from([
    'answers' => $answers,  // DataCollection<AnswerData>
    'chart' => $chartData,   // ChartData DTO
    'title' => 'Risposte Mensili',  // Opzionale
    'footer' => 'Periodo: Gen-Dic 2026',  // Opzionale
    'tot' => $totalResponses,  // Totale risposte
]);
```

**Metodi Utili AnswersChartData:**

```php
// Converti a formato Chart.js (per widget Filament)
$chartJsData = $answersChartData->getChartJsData();
// [
//     'datasets' => [...],
//     'labels' => [...]
// ]

// Ottieni tipo Chart.js equivalente
$chartJsType = $answersChartData->getChartJsType();  // 'bar', 'line', 'doughnut'

// Ottieni opzioni Chart.js
$chartJsOptions = $answersChartData->getChartJsOptionsArray();
```

### Pattern Bar2Action: Analisi Approfondita

Basato su `Bar2Action` esistente:

```php
/**
 * Bar2Action - Pattern per chart mensili con numero risposte + media.
 * 
 * Caratteristiche:
 * - Supporta multiple dataset (stacked bars)
 * - Usa 'value' per altezza barre, 'avg' per dataset secondario
 * - Colori configurabili via list_color
 */
class Bar2Action
{
    public function execute(AnswersChartData $answersChartData): Graph
    {
        // Estrae dati da AnswerData collection
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $data1 = $answersChartData->answers->toCollection()->pluck('value')->all();
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        
        $chart = $answersChartData->chart;
        
        // Crea Graph object (pattern GetGraphAction)
        $graph = app(GetGraphAction::class)->execute($chart);
        
        // Configura margini
        $graph->img->SetMargin(50, 50, 50, 100);
        
        // Configura X-axis labels
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($chart->x_label_angle);
        
        // Crea BarPlot per ogni dataset
        $colors = explode(',', $chart->list_color);
        $bplot = [];
        
        foreach ($legends as $i => $legend) {
            $tmp_data = $legend === 0 ? $data : array_column($data, $legend);
            $tmp = new BarPlot($tmp_data);
            
            // Applica stile (pattern ApplyPlotStyleAction)
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);
            
            // Colori con trasparenza
            $tmp->SetColor($colors[$i]);
            $tmp->SetFillColor($colors[$i].'@'.$chart->transparency);
            
            $bplot[] = $tmp;
        }
        
        // Crea GroupBarPlot per multiple dataset
        $gbplot = new GroupBarPlot($bplot);
        $graph->Add($gbplot);
        
        return $graph;
    }
}
```

**Pattern per Chart Mensile:**

```php
// Dataset 1: Numero risposte (value)
$data1 = $answersChartData->answers->toCollection()->pluck('value')->all();

// Dataset 2: Media risposte (avg)
$data = $answersChartData->answers->toCollection()->pluck('avg')->all();

// Labels: Mesi
$labels = $answersChartData->answers->toCollection()->pluck('label')->all();

// Colori: Blu per risposte, verde per media
$chart->list_color = '#3b82f6,#10b981';
```

---

## Pattern Integrazione Completa: Esempio Reale

### Esempio Completo: Widget + PDF

```php
/**
 * Esempio completo: Widget chart mensile + generazione PDF.
 * 
 * Pattern:
 * 1. Widget Filament (Chart.js) per dashboard
 * 2. Action PDF (JpGraph) per report
 */
class MonthlySurveyChartSystem
{
    // ============================================================
    // PARTE 1: Widget Filament (Frontend)
    // ============================================================
    
    /**
     * Widget per dashboard Filament.
     */
    class MonthlyChartWidget extends XotBaseChartWidget
    {
        protected function getData(): array
        {
            $monthlyData = SurveyResponse::getResponsesForSurvey($surveyId)
                ->selectRaw('DATE_FORMAT(submitdate, "%Y-%m") as month, COUNT(*) as count, AVG(...) as avg')
                ->groupBy('month')
                ->get();
            
            return [
                'datasets' => [
                    ['label' => 'Risposte', 'data' => $monthlyData->pluck('count')],
                    ['label' => 'Media', 'data' => $monthlyData->pluck('avg'), 'type' => 'line'],
                ],
                'labels' => $monthlyData->pluck('month'),
            ];
        }
    }
    
    // ============================================================
    // PARTE 2: Action PDF (Backend)
    // ============================================================
    
    /**
     * Action per generare chart PDF.
     */
    class MakeMonthlyChartForPdfAction
    {
        public function execute(QuestionChart $questionChart, ?AnswersFilterData $filter = null): string
        {
            // 1. Query aggregazione mensile
            $monthlyData = SurveyResponse::getResponsesForSurvey($surveyId)
                ->selectRaw('DATE_FORMAT(submitdate, "%Y-%m") as month, COUNT(*) as count, AVG(...) as avg')
                ->groupBy('month')
                ->get();
            
            // 2. Prepara AnswerData
            $answers = $monthlyData->map(fn($m) => AnswerData::from([
                'label' => $m->month,
                'value' => $m->count,
                'avg' => $m->avg,
            ]));
            
            // 3. Crea ChartData
            $chartData = ChartData::from([
                'type' => 'bar2',
                'width' => 800,
                'height' => 400,
                'list_color' => '#3b82f6,#10b981',
            ]);
            
            // 4. Crea AnswersChartData
            $answersChartData = AnswersChartData::from([
                'answers' => $answers,
                'chart' => $chartData,
            ]);
            
            // 5. Genera con JpGraph
            $actionClass = $chartData->getActionClass();  // Bar2Action
            $graph = app($actionClass)->execute($answersChartData);
            
            // 6. Salva PNG
            $filename = 'chart/monthly-'.$questionChart->id.'.png';
            $graph->Stroke(public_path($filename));
            
            return $filename;
        }
    }
}
```

---

## Riferimenti

### Documentazione Moduli

- [Guida Completa LimeSurvey Chart Widget](../../Quaeris/docs/limesurvey-chart-widget-complete-guide.md) - ⭐ **PRINCIPALE**
- [PDF Generation Guide](../../Quaeris/docs/pdf-generation-with-charts.md)
- [JpGraph Actions System](./actions-system.md)
- [Chart.js Integration](./filament-charts-professional-guide.md)

### DTOs e Actions

- [ChartData DTO](../app/Datas/ChartData.php)
- [AnswersChartData DTO](../app/Datas/AnswersChartData.php)
- [Bar2Action](../app/Actions/JpGraph/V1/Bar2Action.php)
- [Pie1Action](../app/Actions/JpGraph/V1/Pie1Action.php)
- [LineSubQuestionAction](../app/Actions/JpGraph/V1/LineSubQuestionAction.php)

---

**Ultimo aggiornamento:** Gennaio 2026  
**Pattern:** DRY + KISS  
**Integrazione:** LimeSurvey + JpGraph + PDF  
**Livello:** Approfondito con pattern reali dal codebase
