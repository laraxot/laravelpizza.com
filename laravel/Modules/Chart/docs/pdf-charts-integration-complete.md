# Integrazione Grafici nei PDF con Spipu PDF - Guida Completa

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Completa  
**Versione**: 1.0.0  
**Autore**: Analisi Completa del Sistema

---

## 📋 Indice Completo

1. [Panoramica Generale](#panoramica-generale)
2. [Architettura del Sistema](#architettura-del-sistema)
3. [Workflow Completo](#workflow-completo)
4. [Generazione Grafici con JpGraph](#generazione-grafici-con-jpgraph)
5. [Generazione Grafici con Chart.js](#generazione-grafici-con-chartjs)
6. [Integrazione Grafici nel PDF](#integrazione-grafici-nel-pdf)
7. [Best Practices](#best-practices)
8. [Troubleshooting](#troubleshooting)

---

## Panoramica Generale

### Obiettivo

Generare PDF con Spipu PDF contenenti grafici generati da:
- **JpGraph**: Libreria PHP per generazione grafici server-side (PNG)
- **Chart.js**: Libreria JavaScript per grafici interattivi (SVG/PNG export)

### Stack Tecnologico

- **Spipu Html2Pdf**: Generazione PDF da HTML
- **JpGraph (amenadiel/jpgraph)**: Generazione grafici PHP (PNG)
- **Chart.js**: Libreria JavaScript per grafici (SVG/PNG export)
- **Laravel Storage**: Gestione file temporanei
- **Image Processing**: Merge di immagini multiple

### Processo Completo

```
1. Preparazione Dati
   ↓
2. Generazione Grafici (JpGraph o Chart.js)
   ↓
3. Salvataggio Immagini (PNG/SVG)
   ↓
4. Generazione HTML con Immagini
   ↓
5. Conversione HTML → PDF (Spipu)
   ↓
6. Download/Stream PDF
```

---

## Architettura del Sistema

### Componenti Principali

#### 1. MakePdf2Action

**File**: `Modules/Quaeris/app/Actions/SurveyPdf/MakePdf2Action.php`

**Responsabilità**:
- Coordinare generazione PDF completa
- Generare grafici per ogni QuestionChart
- Generare HTML con grafici
- Convertire HTML in PDF con Spipu
- Fornire download PDF

**Flusso**:
```php
1. Inizializza Html2Pdf
2. Recupera QuestionCharts da includere
3. Per ogni QuestionChart:
   - Genera immagini grafici (MakeImgByQuestionChartModel2Action)
4. Genera HTML (MakeHtmlBySurveyPdfModelAction)
5. Converte HTML in PDF (Spipu Html2Pdf)
6. Salva PDF su storage
7. Ritorna download response
```

#### 2. MakeImgByQuestionChartModel2Action

**File**: `Modules/Quaeris/app/Actions/QuestionChart/MakeImgByQuestionChartModel2Action.php`

**Responsabilità**:
- Generare immagini grafici per QuestionChart
- Usare JpGraph per generazione server-side
- Salvare immagini PNG in `public/chart/`
- Merge immagini multiple se necessario

**Flusso**:
```php
1. Recupera dati risposte (GetChartsDataByQuestionChart)
2. Per ogni chart style:
   - Crea AnswersChartData
   - Esegue Action JpGraph appropriata
   - Genera grafico con Stroke()
   - Salva PNG in public/chart/
3. Merge immagini multiple se necessario
4. Salva path immagine finale in QuestionChart->img_src
```

#### 3. MakeHtmlBySurveyPdfModelAction

**File**: `Modules/Quaeris/app/Actions/SurveyPdf/MakeHtmlBySurveyPdfModelAction.php`

**Responsabilità**:
- Generare HTML Blade template con grafici
- Passare dati necessari al template
- Gestire formattazione date e filtri

**Flusso**:
```php
1. Recupera QuestionCharts da includere
2. Raggruppa per righe (getGroupsByRows)
3. Prepara dati per template (date, filtri, etc.)
4. Renderizza Blade template (quaeris::pdf.template1)
5. Ritorna View con HTML
```

#### 4. Template Blade PDF

**File**: `Modules/Quaeris/resources/views/pdf/template1.blade.php`

**Responsabilità**:
- Definire struttura HTML PDF
- Includere immagini grafici
- Formattare layout con CSS inline
- Usare tag `<page>` di Spipu PDF

**Struttura**:
```blade
<page> <!-- Spipu PDF page tag -->
    <page_header>...</page_header>
    <page_footer>...</page_footer>
    
    @foreach ($rows as $row)
        <table>
            <tr>
                <!-- Titoli domande -->
            </tr>
            <tr>
                @foreach ($row as $img)
                    <td>
                        <img src="{{ public_path($img->img_src) }}" />
                    </td>
                @endforeach
            </tr>
        </table>
    @endforeach
</page>
```

---

## Workflow Completo

### Step 1: Preparazione Dati

**File**: `MakePdf2Action.php` (linee 50-70)

```php
// 1. Recupera QuestionCharts da includere nel PDF
$questionCharts = $surveyPdf->questionCharts->where('show_on_pdf', 1);

// 2. Prepara filtri risposte
$dashboardFilterData = DashboardFilterData::fromArray([
    'survey_pdf_id' => $answersFilterData->survey_pdf_id,
    'question_filter' => $answersFilterData->question_filter,
    'startDate' => $answersFilterData->date_from,
    'endDate' => $answersFilterData->date_to,
]);

// 3. Recupera risposte survey filtrate
$survey_response_query = SurveyResponse::getResponsesForSurvey((string) $surveyPdf->survey_id)
    ->withParticipants()
    ->where('submitdate', '!=', null)
    ->ofDashboardFilterData($dashboardFilterData)
    ->withAllAnswers('subquery');

$responses = $survey_response_query;
```

### Step 2: Generazione Grafici

**File**: `MakePdf2Action.php` (linee 72-75)

```php
// Per ogni QuestionChart, genera immagini grafici
foreach ($questionCharts as $questionChart) {
    app(MakeImgByQuestionChartModel2Action::class)
        ->execute($questionChart, $responses, $answersFilterData);
}
```

**⚠️ Nota Importante**: La generazione grafici è il passo più critico e lento. Per performance, considera:
- **Queue Processing**: Usa `MakeImgByQuestionChartModel2Action::dispatch()` per processare in background
- **Parallel Processing**: Genera grafici in parallelo se possibile
- **Cache**: Cache grafici generati per evitare rigenerazione

**Dettaglio**: `MakeImgByQuestionChartModel2Action.php`

```php
// 1. Recupera dati risposte per il grafico
$datas = app(GetChartsDataByQuestionChart::class)
    ->execute($q, $responses, $answersFilterData);

// 2. Per ogni chart style (un QuestionChart può avere più grafici)
foreach ($datas as $k => $data_answers) {
    $answers = $data_answers->answers;
    $chart_obj = $q->charts[$k];
    
    // 3. Prepara ChartData con stile
    $chart_style = ChartData::from($chart_obj->toArray());
    
    // 4. Aggiungi titolo, sottotitolo, footer
    $chart_style['title'] = app(GetTitleAction::class)->execute($q, $answersFilterData);
    $chart_style['subtitle'] = app(GetSubtitleAction::class)->execute($q, $answersFilterData);
    $chart_style['footer'] = app(GetFooterAction::class)->execute($q, $answersFilterData);
    
    // 5. Crea AnswersChartData
    $answersData = AnswersChartData::from([
        'answers' => $answers,
        'chart' => $chart_style,
    ]);
    
    // 6. Determina Action JpGraph da usare
    $action_class = $chart_style->getActionClass();
    // Esempio: 'bar1' → 'Modules\Chart\Actions\JpGraph\V1\Bar1Action'
    
    // 7. Esegue Action per generare grafico
    $graphAction = app($action_class);
    $graph = $graphAction->execute($answersData);
    
    // 8. Salva grafico come PNG
    $filename = 'chart/'.$q->id.'-'.$k.'.png';
    $file_path = public_path($filename);
    $graph->Stroke($file_path); // JpGraph salva PNG
    
    $filenames[] = $filename;
}

// 9. Se ci sono più grafici, merge in un'unica immagine
if (count($filenames) > 1) {
    $mergeAction = app(Merge::class);
    $mergeAction->execute($filenames, $fileName);
}

// 10. Salva path immagine finale
$q->img_src = $fileName;
$q->save();
```

### Step 3: Generazione HTML

**File**: `MakePdf2Action.php` (linea 77)

```php
$html = app(MakeHtmlBySurveyPdfModelAction::class)->execute($surveyPdf, $answersFilterData);
```

**Dettaglio**: `MakeHtmlBySurveyPdfModelAction.php`

```php
// 1. Recupera QuestionCharts con immagini generate
$rows = $surveyPdf->questionCharts()->where('show_on_pdf', 1)->get();

// 2. Raggruppa per righe (layout tabella)
$rows = QuaerisService::make()->getGroupsByRows($rows);

// 3. Prepara dati per template
$view_params = [
    'rows' => $rows, // QuestionCharts raggruppati
    'parent' => $surveyPdf,
    'survey_title' => $surveyPdf->surveylsTitle(),
    'pdf' => $surveyPdf->pdfStyle,
    'date_from' => $date_from,
    'date_to' => $date_to,
];

// 4. Renderizza Blade template
$view = 'quaeris::pdf.'.$surveyPdf->pdf_view; // Es: 'template1'
return view($view, $view_params);
```

### Step 4: Conversione HTML → PDF

**File**: `MakePdf2Action.php` (linee 47-98)

```php
// 1. Inizializza Spipu Html2Pdf
$html2pdf = new Html2Pdf('L', 'A4', 'it'); // Landscape, A4, italiano
$html2pdf->setTestIsImage(false); // Disabilita controllo immagini

// 2. Renderizza HTML se è View
if ($html instanceof View) {
    $html = $html->render();
}

// 3. Scrive HTML in PDF
$html2pdf->writeHTML($html);

// 4. Salva PDF su storage
$filename = Str::slug($surveyPdf->name.'_sett_'.$survey_date_to).'.pdf';
$path = Storage::disk('cache')->path($filename);
$html2pdf->output($path, 'F'); // 'F' = File

// 5. Ritorna download response
return response()->download($path, $filename, [
    'Content-Type' => 'application/pdf',
]);
```

---

## Generazione Grafici con JpGraph

### Architettura JpGraph

JpGraph è una libreria PHP per generazione grafici server-side. I grafici vengono generati come oggetti `Graph` e salvati come PNG usando il metodo `Stroke()`.

### Struttura Actions JpGraph

```
Modules/Chart/app/Actions/JpGraph/
├── GetGraphAction.php          # Crea Graph base con stile
├── ApplyGraphStyleAction.php   # Applica stile al Graph
├── ApplyPlotStyleAction.php    # Applica stile al Plot
└── V1/
    ├── Bar1Action.php          # Bar chart semplice
    ├── Bar2Action.php          # Bar chart multiplo
    ├── Bar3Action.php          # Bar chart avanzato
    ├── Horizbar1Action.php     # Bar chart orizzontale
    ├── Pie1Action.php          # Pie chart
    ├── PieAvgAction.php        # Pie chart media
    └── LineSubQuestionAction.php # Line chart
```

### Pattern Action JpGraph

**Esempio**: `Bar1Action.php`

```php
class Bar1Action
{
    public function execute(AnswersChartData $answersData): Graph
    {
        // 1. Crea ChartData
        $chartData = $answersData->chart;
        
        // 2. Crea Graph base con stile
        $graph = app(GetGraphAction::class)->execute($chartData);
        
        // 3. Prepara dati per BarPlot
        $data = [];
        $labels = [];
        foreach ($answersData->answers as $answer) {
            $data[] = (float) $answer->value;
            $labels[] = $answer->label;
        }
        
        // 4. Crea BarPlot
        $barPlot = new BarPlot($data);
        $barPlot->SetLegend($labels);
        
        // 5. Applica stile al Plot
        $barPlot = app(ApplyPlotStyleAction::class)->execute($barPlot, $chartData);
        
        // 6. Aggiungi Plot al Graph
        $graph->Add($barPlot);
        
        // 7. Ritorna Graph (non salva ancora!)
        return $graph;
    }
}
```

### Salvataggio Grafico PNG

**File**: `MakeImgByQuestionChartModel2Action.php` (linee 133-148)

```php
// 1. Esegue Action JpGraph
$graph = $graphAction->execute($answersData);

// 2. Verifica che Graph abbia metodo Stroke()
if (! \is_object($graph) || ! method_exists($graph, 'Stroke')) {
    logger()->error('❌ Metodo Stroke() non trovato');
    continue;
}

// 3. Salva PNG
$filename = 'chart/'.$q->id.'-'.$k.'.png';
$file_path = public_path($filename);

try {
    $graph->Stroke($file_path); // Salva PNG direttamente
} catch (\Throwable $e) {
    logger()->error('❌ Errore durante Stroke()', [
        'exception' => $e->getMessage(),
        'file_path' => $file_path,
    ]);
}

// 4. Verifica che file sia stato creato
if (! File::exists($file_path)) {
    logger()->error('❌ Immagine NON generata', [
        'file_path' => $file_path,
    ]);
}
```

### Configurazione JpGraph

**File**: `GetGraphAction.php`

```php
public function execute(ChartData $chartData): Graph
{
    // 1. Crea Graph con dimensioni
    $graph = new Graph($chartData->width, $chartData->height, 'auto');
    
    // 2. Configura scale
    $graph->SetScale('textlin');
    $graph->SetShadow();
    
    // 3. Applica tema
    $universalTheme = new UniversalTheme;
    $graph->SetTheme($universalTheme);
    
    // 4. Configura titolo
    if ($chartData->title !== null) {
        $graph->title->Set($chartData->title);
        $graph->title->SetFont($chartData->font_family, $chartData->font_style, 11);
    }
    
    // 5. Configura sottotitolo
    if ($chartData->subtitle !== null) {
        $graph->subtitle->Set($chartData->subtitle);
    }
    
    // 6. Configura footer
    if ($chartData->footer !== null) {
        $graph->footer->center->Set($chartData->footer);
    }
    
    // 7. Configura assi
    $this->applyGraphXStyle($graph->xaxis, $chartData);
    $this->applyGraphYStyle($graph->yaxis, $chartData);
    
    return $graph;
}
```

---

## Generazione Grafici con Chart.js

### Architettura Chart.js

Chart.js è una libreria JavaScript per grafici interattivi. Per includere grafici Chart.js in PDF, dobbiamo:
1. Generare grafico Chart.js
2. Esportare come immagine (SVG o PNG)
3. Salvare immagine su server
4. Includere immagine nel PDF

### Export Chart.js come SVG

**Metodo 1: Usando canvas.toSVG() (se supportato)**

```javascript
// 1. Crea grafico Chart.js
const ctx = document.getElementById('myChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: chartOptions
});

// 2. Esporta come SVG
const svg = chart.toBase64Image('image/svg+xml');

// 3. Invia SVG al server
fetch('/api/chart/export', {
    method: 'POST',
    body: JSON.stringify({ svg: svg }),
    headers: { 'Content-Type': 'application/json' }
});
```

**Metodo 2: Usando chartjs-plugin-datalabels + canvas**

```javascript
// 1. Installa plugin
import ChartDataLabels from 'chartjs-plugin-datalabels';

// 2. Crea grafico
const chart = new Chart(ctx, {
    plugins: [ChartDataLabels],
    // ...
});

// 3. Esporta canvas come base64
const base64 = chart.toBase64Image('image/png');
```

### Export Chart.js come PNG

**Metodo 1: Canvas toDataURL()**

```javascript
// 1. Crea grafico Chart.js
const chart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: chartOptions
});

// 2. Esporta canvas come PNG base64
const pngBase64 = chart.toBase64Image('image/png');

// 3. Invia al server
fetch('/api/chart/export', {
    method: 'POST',
    body: JSON.stringify({ 
        image: pngBase64,
        filename: 'chart.png'
    }),
    headers: { 'Content-Type': 'application/json' }
});
```

**Metodo 2: Usando html2canvas (per grafici complessi)**

```javascript
import html2canvas from 'html2canvas';

// 1. Cattura elemento grafico
const chartElement = document.getElementById('myChart');

// 2. Converti in canvas
html2canvas(chartElement).then(canvas => {
    // 3. Esporta come PNG
    const pngBase64 = canvas.toDataURL('image/png');
    
    // 4. Invia al server
    fetch('/api/chart/export', {
        method: 'POST',
        body: JSON.stringify({ image: pngBase64 }),
    });
});
```

### Action Server-Side per Salvare Chart.js

**File**: `Modules/Quaeris/app/Actions/QuestionChart/SaveChartJsImageAction.php` (da creare)

```php
class SaveChartJsImageAction
{
    use QueueableAction;
    
    public function execute(
        QuestionChart $questionChart,
        string $imageBase64,
        string $format = 'png'
    ): string {
        // 1. Decodifica base64
        $imageData = base64_decode(
            preg_replace('/^data:image\/\w+;base64,/', '', $imageBase64)
        );
        
        // 2. Determina path file
        $filename = 'chart/'.$questionChart->id.'.'.$format;
        $file_path = public_path($filename);
        
        // 3. Crea directory se non esiste
        $dir = dirname($file_path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        
        // 4. Salva immagine
        File::put($file_path, $imageData);
        
        // 5. Aggiorna QuestionChart
        $questionChart->img_src = $filename;
        $questionChart->generated_at = now();
        $questionChart->save();
        
        return $filename;
    }
}
```

### Integrazione Chart.js nel Workflow PDF

**Modifica**: `MakeImgByQuestionChartModel2Action.php`

```php
public function execute(QuestionChart $questionChart, ...): array
{
    // 1. Verifica engine grafico
    if ($questionChart->chart_engine === 'chartjs') {
        // 2. Genera dati Chart.js
        $answersData = AnswersChartData::from([...]);
        
        // 3. Ritorna dati per rendering client-side
        // (grafico verrà generato via JavaScript e inviato al server)
        return [
            'chart_js_data' => $answersData->getChartJsData(),
            'chart_js_type' => $answersData->getChartJsType(),
            'chart_js_options' => $answersData->getChartJsOptions(),
        ];
    } else {
        // Engine JpGraph (default)
        // ... codice esistente ...
    }
}
```

**Endpoint API per Export Chart.js**

```php
// routes/api.php
Route::post('/chart/export', function (Request $request) {
    $questionChart = QuestionChart::find($request->question_chart_id);
    $imageBase64 = $request->image;
    
    $filename = app(SaveChartJsImageAction::class)
        ->execute($questionChart, $imageBase64, 'png');
    
    return response()->json(['filename' => $filename]);
});
```

---

## Integrazione Grafici nel PDF

### Template Blade PDF

**File**: `Modules/Quaeris/resources/views/pdf/template1.blade.php`

```blade
<page>
    @foreach ($rows as $row)
        <table class="tablechart">
            <tr>
                <!-- Titoli domande -->
                <td colspan="{{ $row->count() }}">
                    @foreach ($row->first()->getQuestionBreads() as $bread)
                        <p>{{ $bread->question }}</p>
                    @endforeach
                </td>
            </tr>
            <tr>
                @foreach ($row as $img)
                    <td style="width: {{ ($img->col_size * 100) / 12 }}%">
                        <h3>{{ $img->title }}</h3>
                        
                        @php
                            $imgPath = public_path(ltrim($img->img_src, '/'));
                        @endphp
                        
                        @if(File::exists($imgPath))
                            <img src="{{ $imgPath }}" />
                        @else
                            <p style="color: red;">
                                [Grafico non generato per ID {{ $img->id }}]
                            </p>
                        @endif
                    </td>
                @endforeach
            </tr>
        </table>
    @endforeach
</page>
```

### Configurazione Spipu PDF

**File**: `MakePdf2Action.php`

```php
// 1. Inizializza Html2Pdf
$html2pdf = new Html2Pdf('L', 'A4', 'it');
// Parametri:
// - 'L' = Landscape (orizzontale)
// - 'A4' = Formato pagina
// - 'it' = Lingua italiana

// 2. Disabilita controllo immagini (importante per path assoluti)
$html2pdf->setTestIsImage(false);

// 3. Configurazioni aggiuntive
$html2pdf->setTestTdInOnePage(false); // Permetti tabelle su più pagine
```

### Path Immagini nel PDF

**Regola Critica**: Spipu PDF richiede path assoluti per le immagini.

```php
// ✅ CORRETTO - Path assoluto
$imgPath = public_path(ltrim($img->img_src, '/'));
// Es: /var/www/.../public/chart/123.png

// ❌ SBAGLIATO - Path relativo
$imgPath = $img->img_src;
// Es: chart/123.png (non funziona con Spipu)
```

**Nel Template Blade**:

```blade
@php
    $imgPath = public_path(ltrim($img->img_src, '/'));
@endphp

@if(File::exists($imgPath))
    <img src="{{ $imgPath }}" />
@else
    <p>[Grafico non generato]</p>
@endif
```

### CSS Inline per PDF

**Regola Critica**: Spipu PDF non supporta CSS esterni, solo inline.

```blade
<!-- ✅ CORRETTO - CSS inline -->
<td style="width: 50%; padding: 10mm;">
    <img src="{{ $imgPath }}" style="max-width: 100%;" />
</td>

<!-- ❌ SBAGLIATO - CSS esterno -->
<link rel="stylesheet" href="/css/pdf.css" />
<td class="chart-cell">
    <img src="{{ $imgPath }}" />
</td>
```

### Gestione Dimensioni Immagini

```blade
<!-- Immagine con dimensioni fisse -->
<img src="{{ $imgPath }}" style="width: 150mm; height: 100mm;" />

<!-- Immagine responsive (mantiene proporzioni) -->
<img src="{{ $imgPath }}" style="max-width: 100%; height: auto;" />

<!-- Immagine con dimensioni da QuestionChart -->
<img src="{{ $imgPath }}" 
     style="width: {{ $img->width }}mm; height: {{ $img->height }}mm;" />
```

---

## Best Practices

### 1. Generazione Grafici Asincrona

**Pratica**: Genera grafici in queue per performance.

```php
// ✅ CORRETTO - Queueable action
MakeImgByQuestionChartModel2Action::dispatch($questionChart, $responses)
    ->onQueue('charts');

// ❌ SBAGLIATO - Sincrono (blocca request)
app(MakeImgByQuestionChartModel2Action::class)
    ->execute($questionChart, $responses);
```

### 2. Cache Grafici

**Pratica**: Cache grafici generati per evitare rigenerazione.

```php
// Cache key basata su QuestionChart ID + filtri
$cacheKey = "chart_{$questionChart->id}_{$answersFilterData->getCacheKey()}";

if (Cache::has($cacheKey)) {
    $imgPath = Cache::get($cacheKey);
} else {
    // Genera grafico
    $imgPath = app(MakeImgByQuestionChartModel2Action::class)
        ->execute($questionChart, $responses);
    
    // Cache per 1 ora
    Cache::put($cacheKey, $imgPath, 3600);
}
```

### 3. Gestione Errori

**Pratica**: Gestisci errori gracefully.

```php
try {
    $graph->Stroke($file_path);
} catch (\Throwable $e) {
    logger()->error('❌ Errore generazione grafico', [
        'question_chart_id' => $questionChart->id,
        'exception' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);
    
    // Usa immagine placeholder
    $file_path = public_path('chart/NoDataImage.jpeg');
}
```

### 4. Cleanup File Temporanei

**Pratica**: Pulisci file temporanei dopo generazione PDF.

```php
// Dopo generazione PDF
foreach ($questionCharts as $questionChart) {
    $tempFiles = glob(public_path('chart/'.$questionChart->id.'-*.png'));
    foreach ($tempFiles as $tempFile) {
        File::delete($tempFile);
    }
}
```

### 5. Memory Management

**Pratica**: Aumenta memory limit per grafici complessi.

```php
// All'inizio di MakeImgByQuestionChartModel2Action
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
```

### 6. Validazione Immagini

**Pratica**: Verifica che immagini siano state generate correttamente.

```php
if (! File::exists($file_path)) {
    logger()->error('❌ Immagine NON generata', [
        'file_path' => $file_path,
        'question_chart_id' => $questionChart->id,
    ]);
    
    // Usa placeholder
    $file_path = public_path('chart/NoDataImage.jpeg');
}
```

---

## Troubleshooting

### Problema 1: Immagini non appaiono nel PDF

**Sintomi**: PDF generato ma grafici non visibili.

**Soluzioni**:
1. Verifica path assoluto: `public_path(ltrim($img->img_src, '/'))`
2. Verifica che file esista: `File::exists($imgPath)`
3. Disabilita controllo immagini: `$html2pdf->setTestIsImage(false)`
4. Verifica permessi file: `chmod 644 $imgPath`

### Problema 2: Grafici JpGraph non generati

**Sintomi**: File PNG non creato.

**Soluzioni**:
1. Verifica che Action JpGraph esista: `class_exists($action_class)`
2. Verifica che Graph abbia metodo Stroke: `method_exists($graph, 'Stroke')`
3. Aumenta memory limit: `ini_set('memory_limit', '-1')`
4. Controlla log errori: `logger()->error(...)`

### Problema 3: Chart.js non esporta correttamente

**Sintomi**: Immagine Chart.js non salvata.

**Soluzioni**:
1. Verifica che canvas sia renderizzato: `chart.update()`
2. Usa `toBase64Image()` invece di `toDataURL()`
3. Verifica formato base64: `preg_replace('/^data:image\/\w+;base64,/', '', $base64)`
4. Verifica permessi directory: `chmod 755 public/chart/`

### Problema 4: PDF troppo grande

**Sintomi**: PDF generato ma file molto grande.

**Soluzioni**:
1. Comprimi immagini PNG: `imagepng($image, $path, 9)` (quality 0-9)
2. Usa dimensioni ottimizzate: `$chartData->width = 800; $chartData->height = 600;`
3. Considera formato SVG invece di PNG (più leggero per grafici semplici)

### Problema 5: Grafici sovrapposti nel PDF

**Sintomi**: Grafici si sovrappongono nel layout PDF.

**Soluzioni**:
1. Verifica `col_size` di ogni QuestionChart
2. Usa tabelle HTML per layout: `<table><tr><td>...</td></tr></table>`
3. Aggiungi margini: `style="padding: 5mm;"`
4. Verifica dimensioni immagini: `style="max-width: 100%;"`

---

## Conclusioni

### Workflow Completo Documentato

1. **Preparazione Dati**: Recupera QuestionCharts e risposte filtrate
2. **Generazione Grafici**: Usa JpGraph o Chart.js per generare immagini
3. **Salvataggio Immagini**: Salva PNG/SVG in `public/chart/`
4. **Generazione HTML**: Renderizza Blade template con immagini
5. **Conversione PDF**: Usa Spipu Html2Pdf per convertire HTML in PDF
6. **Download**: Fornisci PDF come download response

### Tecnologie Utilizzate

- **Spipu Html2Pdf**: Conversione HTML → PDF
- **JpGraph**: Generazione grafici server-side (PNG)
- **Chart.js**: Generazione grafici client-side (SVG/PNG export)
- **Laravel Storage**: Gestione file temporanei
- **Blade Templates**: Template HTML per PDF

### Best Practices Implementate

1. Queueable actions per performance
2. Cache grafici generati
3. Gestione errori graceful
4. Cleanup file temporanei
5. Memory management
6. Validazione immagini

---

**Ultimo Aggiornamento**: 2025-01-18  
**Versione**: 1.0.0

