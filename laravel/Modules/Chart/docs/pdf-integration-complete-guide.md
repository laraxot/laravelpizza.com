# Guida Completa: Grafici nei PDF con Spipu PDF

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Completa  
**Versione**: 1.0.0

## 📋 Panoramica

Questa guida documenta passo-passo come creare grafici e includerli nei PDF generati con Spipu PDF. Copre JpGraph (PNG), Chart.js (SVG/PNG) e l'integrazione completa nel workflow PDF.

---

## 🎯 Workflow Completo

### Flusso Generale

```
1. Preparazione Dati
   ↓
2. Generazione Grafico (JpGraph o Chart.js)
   ↓
3. Salvataggio Immagine (PNG/SVG)
   ↓
4. Inclusione in HTML
   ↓
5. Conversione HTML → PDF (Spipu)
```

---

## 📊 Parte 1: Creazione Grafici con JpGraph

### 1.1 Architettura e Flusso Dati

**Diagramma del Flusso**:

```
QuestionChart Model
    ↓
GetChartsDataByQuestionChart Action
    ↓
AnswersChartData[] (array di DTO)
    ↓
Per ogni AnswersChartData:
    ├─→ Chart Model → ChartData DTO
    ├─→ AnswersChartData DTO
    ├─→ ChartData->getActionClass()
    │   └─→ '\Modules\Chart\Actions\JpGraph\V1\{Type}Action'
    ├─→ Action->execute(AnswersChartData)
    │   └─→ Graph Object (JpGraph)
    ├─→ Graph->Stroke($file_path)
    │   └─→ PNG salvato in public/chart/
    └─→ $filenames[] = 'chart/{id}-{k}.png'
    ↓
Merge Action (se count($filenames) > 1)
    └─→ Unisce verticalmente → 'chart/{id}.png'
    ↓
QuestionChart->img_src = 'chart/{id}.png'
```

### 1.2 Preparazione Dati - Dettaglio Tecnico

**File**: `Modules/Quaeris/app/Actions/QuestionChart/MakeImgByQuestionChartModel2Action.php`

**Processo Completo con Spiegazioni**:

```php
namespace Modules\Quaeris\Actions\QuestionChart;

use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;
use Modules\Chart\Models\Chart;
use Modules\Media\Actions\Image\Merge;

class MakeImgByQuestionChartModel2Action
{
    public function execute(
        QuestionChart $questionChart,
        Builder $responses,
        ?AnswersFilterData $answersFilterData = null
    ): array {
        // ⚙️ Configurazione Memory/Time per grafici complessi
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        
        // 📊 STEP 1: Recupera dati aggregati per i grafici
        // GetChartsDataByQuestionChart esegue query complesse:
        // - Raggruppa risposte per domanda
        // - Calcola medie, totali, percentuali
        // - Filtra per AnswersFilterData (date, question_filter)
        // - Restituisce array di AnswersChartData (uno per ogni sottodomanda)
        $datas = app(GetChartsDataByQuestionChart::class)
            ->execute($questionChart, $responses, $answersFilterData);
        
        $filenames = [];
        
        // 🔄 STEP 2: Loop su ogni set di dati (sottodomande)
        // Una QuestionChart può avere più Chart associati (es: barre + torta)
        if ($datas[0]->answers->count() > 0) {
            foreach ($datas as $k => $data_answers) {
                $answers = $data_answers->answers; // Collection<AnswerData>
                $chart_obj = $questionChart->charts[$k]; // Chart Model
                
                // 📋 STEP 3: Converti Chart Model in ChartData DTO
                // ChartData contiene tutte le configurazioni:
                // - type, width, height, colors, fonts, transparency, ecc.
                $chart_style = ChartData::from($chart_obj->toArray());
                
                // 🎨 STEP 4: Personalizza stile per primo grafico
                // Solo il primo grafico (k=0) ha titolo, sottotitolo, footer
                if ($k === 0) {
                    if ($answersFilterData !== null) {
                        $chart_style->title = app(GetTitleAction::class)
                            ->execute($questionChart, $answersFilterData);
                        $chart_style->subtitle = app(GetSubtitleAction::class)
                            ->execute($questionChart, $answersFilterData);
                        $chart_style->footer = app(GetFooterAction::class)
                            ->execute($questionChart, $answersFilterData);
                    }
                }
                
                // 📈 STEP 5: Crea AnswersChartData DTO
                // Combina dati risposte + configurazione grafico
                $answersData = AnswersChartData::from([
                    'answers' => $answers,
                    'chart' => $chart_style,
                ]);
                
                // 🔍 STEP 6: Risolvi Action Class dal tipo grafico
                // ChartData->getActionClass() mappa:
                // 'horizbar1' → '\Modules\Chart\Actions\JpGraph\V1\Horizbar1Action'
                // 'pie1' → '\Modules\Chart\Actions\JpGraph\V1\Pie1Action'
                // 'bar2' → '\Modules\Chart\Actions\JpGraph\V1\Bar2Action'
                $action_class = $chart_style->getActionClass();
                
                if (!class_exists($action_class)) {
                    logger()->error('⚠️ Classe azione grafico non trovata', [
                        'class' => $action_class,
                        'type' => $chart_style->type,
                    ]);
                    continue;
                }
                
                // 🎨 STEP 7: Esegui Action per generare Graph
                // Ogni Action (Horizbar1Action, Pie1Action, ecc.) crea un Graph JpGraph
                // Il Graph è un oggetto complesso con:
                // - Plot (BarPlot, PiePlotC, ecc.)
                // - Assi (xaxis, yaxis)
                // - Stili (colors, fonts, margins)
                $graphAction = app($action_class);
                if (!is_object($graphAction) || !method_exists($graphAction, 'execute')) {
                    logger()->error('⚠️ Action non valida', ['class' => $action_class]);
                    continue;
                }
                
                $graph = $graphAction->execute($answersData);
                
                // 💾 STEP 8: Prepara percorso file PNG
                // Naming: chart/{questionChart_id}-{index}.png
                // Esempio: chart/123-0.png, chart/123-1.png
                $filename = 'chart/'.$questionChart->id.'-'.$k.'.png';
                $file_path = public_path($filename);
                
                // 🗑️ STEP 9: Elimina file esistente (se presente)
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }
                
                // 🖼️ STEP 10: Genera PNG con JpGraph Stroke()
                // Stroke() è il metodo che renderizza il Graph e salva come PNG
                // Supporta solo PNG, non SVG o altri formati
                if (!is_object($graph) || !method_exists($graph, 'Stroke')) {
                    logger()->error('❌ Metodo Stroke() non trovato', [
                        'graph_class' => is_object($graph) ? $graph::class : 'N/A',
                        'file_path' => $file_path,
                    ]);
                    continue;
                }
                
                try {
                    $graph->Stroke($file_path);
                } catch (\Throwable $e) {
                    logger()->error('❌ Errore durante Stroke()', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'file_path' => $file_path,
                    ]);
                    continue;
                }
                
                // ✅ STEP 11: Verifica creazione file
                if (!File::exists($file_path)) {
                    logger()->error('❌ Immagine NON generata', [
                        'file_path' => $file_path,
                        'chart_type' => $chart_style->type,
                        'answers_count' => $answers->count(),
                    ]);
                    continue;
                }
                
                $filenames[] = $filename;
            }
        } else {
            // 📭 STEP 12: Nessun dato - usa immagine placeholder
            if (!File::exists('chart/NoDataImage.jpeg')) {
                $pathFrom = module_path('Chart', 'resources/img/NoDataImage.jpeg');
                $pathTo = public_path('chart/NoDataImage.jpeg');
                File::ensureDirectoryExists(dirname($pathTo));
                File::copy($pathFrom, $pathTo);
            }
            $filenames[] = 'chart/NoDataImage.jpeg';
        }
        
        // 🔗 STEP 13: Unisci immagini multiple (se presenti)
        // Se ci sono più grafici (es: barre + torta), uniscili verticalmente
        $fileName = 'chart/'.$questionChart->id.'.png';
        if (count($filenames) > 1) {
            $mergeAction = app(Merge::class);
            if (is_object($mergeAction) && method_exists($mergeAction, 'execute')) {
                // Merge->execute() unisce tutte le immagini in $filenames
                // verticalmente in un'unica immagine
                $mergeAction->execute($filenames, $fileName);
            } else {
                // Fallback: usa prima immagine se merge non disponibile
                $fileName = $filenames[0] ?? 'chart/NoDataImage.jpeg';
            }
        } else {
            $fileName = $filenames[0] ?? 'chart/NoDataImage.jpeg';
        }
        
        // 💾 STEP 14: Salva percorso nel modello
        $questionChart->img_src = $fileName;
        $questionChart->generated_at = now();
        $questionChart->save();
        
        return [
            'q' => $questionChart,
            'filenames' => $fileName,
        ];
    }
}
```

**Note Tecniche Importanti**:

1. **Memory Limit**: JpGraph può consumare molta memoria per grafici complessi, quindi `memory_limit = -1` è necessario.

2. **File Naming**: Pattern `chart/{id}-{k}.png` permette di avere più grafici per QuestionChart senza conflitti.

3. **Error Handling**: Ogni step ha try-catch e logging per debug.

4. **Merge Logic**: Il Merge action unisce verticalmente tutte le immagini in `$filenames`.

### 1.2 Tipi di Grafici JpGraph Supportati

**Directory**: `Modules/Chart/app/Actions/JpGraph/V1/`

#### Tipi Disponibili

1. **Horizbar1Action** - Barre orizzontali
2. **Bar2Action** - Barre verticali multiple
3. **Bar3Action** - Barre verticali avanzate
4. **Pie1Action** - Grafico a torta
5. **PieAvgAction** - Grafico a torta con media
6. **LineSubQuestionAction** - Linee con sottodomande

#### Esempio: Creazione Grafico a Barre Orizzontali

```php
// Modules/Chart/app/Actions/JpGraph/V1/Horizbar1Action.php
namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Modules\Chart\Datas\AnswersChartData;

class Horizbar1Action
{
    public function execute(AnswersChartData $answersChartData): Graph
    {
        // 1. Estrai dati e labels
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $labels = $answersChartData->answers->toCollection()
            ->pluck('label')
            ->map(fn($item) => wordwrap((string)$item, 25, PHP_EOL))
            ->all();
        
        $chart = $answersChartData->chart;
        
        // 2. Crea il grafico base
        $graph = app(GetGraphAction::class)->execute($chart);
        $graph->SetScale('textlin');
        $graph->Set90AndMargin(250, 20, 50, 30);
        
        // 3. Applica stili
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);
        
        // 4. Imposta labels
        if (method_exists($graph->xaxis, 'SetTickLabels')) {
            $graph->xaxis->SetTickLabels($labels);
        }
        
        // 5. Crea il plot
        $bplot = new BarPlot($data);
        $bplot = app(ApplyPlotStyleAction::class)->execute($bplot, $chart);
        
        // 6. Imposta colori
        $colors = [];
        foreach ($labels as $k => $label) {
            $colors[$k] = $chart->getColors()[0].'@'.$chart->transparency;
        }
        $bplot->SetFillColor($colors);
        
        // 7. Aggiungi al grafico
        $graph->Add($bplot);
        
        return $graph;
    }
}
```

### 1.3 Salvataggio come PNG

**Metodo**: `$graph->Stroke($file_path)`

```php
// Il metodo Stroke() di JpGraph salva automaticamente come PNG
$graph->Stroke($file_path);

// Verifica che il file sia stato creato
if (!File::exists($file_path)) {
    logger()->error('Immagine NON generata', [
        'file_path' => $file_path,
        'chart_type' => $chart_type,
    ]);
}
```

**Note Importanti**:
- JpGraph supporta solo PNG per il salvataggio
- Il percorso deve essere assoluto (`public_path()`)
- La directory deve esistere e essere scrivibile
- Il formato è sempre PNG, non SVG

---

## 🎨 Parte 2: Creazione Grafici con Chart.js e Export SVG/PNG

### 2.1 Preparazione Dati Chart.js

**File**: `Modules/Chart/app/Datas/AnswersChartData.php`

```php
namespace Modules\Chart\Datas;

class AnswersChartData extends Data
{
    public DataCollection $answers;
    public ChartData $chart;

    /**
     * Ottiene il tipo Chart.js corrispondente.
     */
    public function getChartJsType(): string
    {
        $type = $this->chart->type;
        return match($type) {
            'pie1', 'pieAvg' => 'doughnut',
            'lineSubQuestion' => 'line',
            'bar2', 'bar1', 'bar3', 'horizbar1' => 'bar',
            default => $type,
        };
    }

    /**
     * Ottiene i dati in formato Chart.js.
     */
    public function getChartJsData(): array
    {
        $labels = $this->answers->toCollection()->pluck('label')->all();
        $data = $this->answers->toCollection()->pluck('value')->all();
        
        return [
            'datasets' => [[
                'label' => 'Dati',
                'data' => $data,
                'backgroundColor' => $this->chart->getColorsRgba(0.5),
            ]],
            'labels' => $labels,
        ];
    }

    /**
     * Ottiene le opzioni Chart.js.
     */
    public function getChartJsOptionsArray(): array
    {
        return [
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => $this->title !== 'no_set' ? $this->title : null,
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
```

### 2.2 Export Chart.js a SVG/PNG (JavaScript)

**File**: `Modules/Chart/resources/js/chart-export.js` (da creare)

```javascript
/**
 * Export Chart.js canvas to SVG or PNG
 * 
 * @param {Chart} chart - Chart.js instance
 * @param {string} format - 'svg' or 'png'
 * @param {string} filename - Output filename
 */
function exportChartJs(chart, format, filename) {
    const canvas = chart.canvas;
    
    if (format === 'svg') {
        // Export to SVG
        const svg = canvasToSvg(canvas);
        downloadFile(svg, filename + '.svg', 'image/svg+xml');
    } else if (format === 'png') {
        // Export to PNG
        canvas.toBlob(function(blob) {
            const url = URL.createObjectURL(blob);
            downloadFile(url, filename + '.png', 'image/png');
        });
    }
}

/**
 * Convert canvas to SVG
 */
function canvasToSvg(canvas) {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', canvas.width);
    svg.setAttribute('height', canvas.height);
    
    const img = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    img.setAttributeNS('http://www.w3.org/1999/xlink', 'href', canvas.toDataURL('image/png'));
    img.setAttribute('width', canvas.width);
    img.setAttribute('height', canvas.height);
    
    svg.appendChild(img);
    
    return new XMLSerializer().serializeToString(svg);
}

/**
 * Download file helper
 */
function downloadFile(content, filename, mimeType) {
    const blob = content instanceof Blob ? content : new Blob([content], { type: mimeType });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    link.click();
    URL.revokeObjectURL(url);
}
```

### 2.3 Export Chart.js a PNG (Server-Side con Puppeteer/Headless Browser)

**Nota**: Per export server-side, è necessario usare un headless browser. Ecco un esempio con Puppeteer:

```php
// Modules/Chart/app/Actions/ChartJs/ExportChartJsToPngAction.php
namespace Modules\Chart\Actions\ChartJs;

use Spatie\QueueableAction\QueueableAction;

class ExportChartJsToPngAction
{
    use QueueableAction;

    /**
     * Esporta un grafico Chart.js a PNG usando Puppeteer.
     * 
     * @param array<string, mixed> $chartConfig Configurazione Chart.js
     * @param string $outputPath Percorso di output
     */
    public function execute(array $chartConfig, string $outputPath): bool
    {
        // 1. Crea HTML temporaneo con Chart.js
        $html = $this->generateChartHtml($chartConfig);
        $htmlPath = storage_path('app/temp/chart_'.uniqid().'.html');
        File::put($htmlPath, $html);
        
        // 2. Usa Puppeteer per renderizzare e salvare
        $script = "
            const puppeteer = require('puppeteer');
            (async () => {
                const browser = await puppeteer.launch();
                const page = await browser.newPage();
                await page.goto('file://{$htmlPath}');
                await page.waitForSelector('canvas');
                const canvas = await page.$('canvas');
                await canvas.screenshot({ path: '{$outputPath}' });
                await browser.close();
            })();
        ";
        
        exec("node -e \"{$script}\"");
        
        return File::exists($outputPath);
    }

    private function generateChartHtml(array $chartConfig): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="chart"></canvas>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, <?php echo json_encode($chartConfig); ?>);
    </script>
</body>
</html>
HTML;
    }
}
```

**Alternativa più semplice**: Usa `html2canvas` lato client e invia al server:

```javascript
// Client-side
import html2canvas from 'html2canvas';

async function exportChartToPng(chartElement, filename) {
    const canvas = await html2canvas(chartElement);
    const dataUrl = canvas.toDataURL('image/png');
    
    // Invia al server
    fetch('/api/chart/export', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            image: dataUrl,
            filename: filename
        })
    });
}
```

---

## 📄 Parte 3: Inclusione Grafici nei PDF Spipu

### 3.1 Generazione HTML con Grafici

**File**: `Modules/Quaeris/app/Actions/SurveyPdf/MakeHtmlBySurveyPdfModelAction.php`

```php
namespace Modules\Quaeris\Actions\SurveyPdf;

class MakeHtmlBySurveyPdfModelAction
{
    public function execute(
        SurveyPdf $surveyPdf,
        ?AnswersFilterData $answersFilterData = null
    ): View {
        // 1. Recupera i grafici da includere
        $rows = $surveyPdf->questionCharts()
            ->where('show_on_pdf', 1)
            ->get();
        
        // 2. Raggruppa per layout
        $rows = QuaerisService::make()->getGroupsByRows($rows);
        
        // 3. Prepara i parametri per la view
        $view_params = [
            'rows' => $rows,
            'parent' => $surveyPdf,
            'survey_title' => $surveyPdf->surveylsTitle(),
            'pdf' => $surveyPdf->pdfStyle,
            // ... altri parametri
        ];
        
        // 4. Renderizza la view
        $view = 'quaeris::pdf.'.$surveyPdf->pdf_view;
        return view($view, $view_params);
    }
}
```

### 3.2 Template Blade per PDF

**File**: `Modules/Quaeris/resources/views/pdf/template1.blade.php`

```blade
@foreach($rows as $row)
    <page>
        <table>
            <tr>
                @foreach($row as $img)
                    <td style="width: {{ ($img->col_size * 100) / 12 }}%">
                        <h3>{{ mb_convert_encoding($img->title, 'Windows-1252', 'UTF-8') }}</h3>
                        
                        @php
                            // Percorso assoluto dell'immagine
                            $imgPath = public_path(ltrim($img->img_src, '/'));
                        @endphp

                        @if(File::exists($imgPath))
                            {{-- Includi l'immagine nel PDF --}}
                            <img src="{{ $imgPath }}" 
                                 style="max-width: 100%; height: auto;" />
                        @else
                            <p style="color: red;">
                                [Grafico non generato per ID {{ $img->id }}]
                            </p>
                        @endif
                    </td>
                @endforeach
            </tr>
        </table>
    </page>
@endforeach
```

**Note Importanti per Spipu PDF**:
- Usa percorsi assoluti per le immagini (`public_path()`)
- Le immagini devono essere accessibili dal filesystem
- Spipu PDF non supporta URL remote per default
- Usa `setTestIsImage(false)` per disabilitare validazione immagini se necessario

### 3.3 Generazione PDF con Spipu

**File**: `Modules/Quaeris/app/Actions/SurveyPdf/MakePdf2Action.php`

```php
namespace Modules\Quaeris\Actions\SurveyPdf;

use Spipu\Html2Pdf\Html2Pdf;

class MakePdf2Action
{
    public function execute(
        SurveyPdf $surveyPdf,
        ?AnswersFilterData $answersFilterData = null
    ): BinaryFileResponse {
        // 1. Inizializza Html2Pdf
        $html2pdf = new Html2Pdf('L', 'A4', 'it');
        $html2pdf->setTestIsImage(false); // Disabilita validazione immagini
        
        // 2. Genera le immagini dei grafici PRIMA di generare l'HTML
        $questionCharts = $surveyPdf->questionCharts->where('show_on_pdf', 1);
        $responses = SurveyResponse::getResponsesForSurvey($surveyPdf->survey_id)
            ->withParticipants()
            ->where('submitdate', '!=', null)
            ->ofDashboardFilterData($dashboardFilterData)
            ->withAllAnswers('subquery');
        
        foreach ($questionCharts as $questionChart) {
            app(MakeImgByQuestionChartModel2Action::class)
                ->execute($questionChart, $responses, $answersFilterData);
        }
        
        // 3. Genera l'HTML (che include i tag <img>)
        $html = app(MakeHtmlBySurveyPdfModelAction::class)
            ->execute($surveyPdf, $answersFilterData);
        
        if (request('debug', false)) {
            return $html; // Debug: mostra HTML
        }
        
        // 4. Renderizza HTML se è una View
        if ($html instanceof View) {
            $html = $html->render();
        }
        
        // 5. Scrivi HTML nel PDF
        $html2pdf->writeHTML($html);
        
        // 6. Salva il PDF
        $filename = Str::slug($surveyPdf->name.'_sett_'.$survey_date_to).'.pdf';
        $path = Storage::disk('cache')->path($filename);
        $html2pdf->output($path, 'F');
        
        // 7. Restituisci download
        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
```

---

## 🔧 Parte 4: Best Practices e Troubleshooting

### 4.1 Best Practices

#### 1. Ordine delle Operazioni

**✅ CORRETTO**:
```php
// 1. Genera immagini PRIMA
foreach ($questionCharts as $questionChart) {
    app(MakeImgByQuestionChartModel2Action::class)
        ->execute($questionChart, $responses, $answersFilterData);
}

// 2. Poi genera HTML (che referenzia le immagini)
$html = app(MakeHtmlBySurveyPdfModelAction::class)
    ->execute($surveyPdf, $answersFilterData);

// 3. Infine genera PDF
$html2pdf->writeHTML($html);
```

**❌ SBAGLIATO**:
```php
// NON generare HTML prima delle immagini!
$html = app(MakeHtmlBySurveyPdfModelAction::class)->execute($surveyPdf);
// Le immagini non esistono ancora!
```

#### 2. Percorsi Immagini

**✅ CORRETTO**:
```php
// Usa percorsi assoluti
$imgPath = public_path(ltrim($img->img_src, '/'));
// Esempio: /var/www/.../public/chart/123.png
```

**❌ SBAGLIATO**:
```php
// NON usare percorsi relativi o URL
$imgPath = '/chart/123.png'; // Spipu non lo trova
$imgPath = asset('chart/123.png'); // URL non funziona
```

#### 3. Validazione Immagini

```php
// Disabilita validazione se necessario
$html2pdf->setTestIsImage(false);

// Oppure verifica esistenza prima
if (File::exists($imgPath)) {
    // Includi immagine
} else {
    // Messaggio di errore
}
```

### 4.2 Troubleshooting

#### Problema: Immagini non appaiono nel PDF

**Causa**: Percorso immagine errato o immagine non generata.

**Soluzione**:
```php
// 1. Verifica che l'immagine esista
$imgPath = public_path(ltrim($img->img_src, '/'));
if (!File::exists($imgPath)) {
    logger()->error('Immagine non trovata', [
        'path' => $imgPath,
        'img_src' => $img->img_src,
    ]);
    // Genera l'immagine
    app(MakeImgByQuestionChartModel2Action::class)
        ->execute($questionChart, $responses, $answersFilterData);
}
```

#### Problema: Grafico JpGraph non viene generato

**Causa**: Errore durante `Stroke()` o dati mancanti.

**Soluzione**:
```php
try {
    $graph->Stroke($file_path);
} catch (\Throwable $e) {
    logger()->error('Errore generazione grafico', [
        'exception' => $e->getMessage(),
        'file_path' => $file_path,
        'chart_type' => $chart_type,
    ]);
    // Usa immagine placeholder
    $file_path = public_path('chart/NoDataImage.jpeg');
}
```

#### Problema: PDF troppo grande o lento

**Causa**: Immagini troppo grandi o troppi grafici.

**Soluzione**:
```php
// 1. Riduci dimensioni grafici
$chart_style->width = 800; // invece di 1200
$chart_style->height = 600; // invece di 900

// 2. Comprimi immagini PNG
// Usa Intervention Image per ottimizzare
$image = Image::make($file_path);
$image->resize(800, 600, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
});
$image->save($file_path, 80); // Qualità 80%
```

---

## 📚 Parte 5: Esempi Completi

### 5.1 Esempio Completo: Grafico a Barre nel PDF

```php
// 1. Prepara i dati
$questionChart = QuestionChart::find(1);
$responses = SurveyResponse::getResponsesForSurvey($surveyId)
    ->where('submitdate', '!=', null);

// 2. Genera il grafico
$result = app(MakeImgByQuestionChartModel2Action::class)
    ->execute($questionChart, $responses, $answersFilterData);

// 3. Verifica che l'immagine sia stata creata
$imgPath = public_path($result['filenames']);
if (!File::exists($imgPath)) {
    throw new Exception('Grafico non generato');
}

// 4. Crea HTML con il grafico
$html = view('pdf.template', [
    'chart_image' => $imgPath,
    'chart_title' => $questionChart->title,
])->render();

// 5. Genera PDF
$html2pdf = new Html2Pdf('L', 'A4', 'it');
$html2pdf->setTestIsImage(false);
$html2pdf->writeHTML($html);
$html2pdf->output('report.pdf', 'D');
```

### 5.2 Esempio: Multiple Grafici in un PDF

```php
$surveyPdf = SurveyPdf::find(1);
$questionCharts = $surveyPdf->questionCharts->where('show_on_pdf', 1);

// Genera tutte le immagini
foreach ($questionCharts as $questionChart) {
    app(MakeImgByQuestionChartModel2Action::class)
        ->execute($questionChart, $responses, $answersFilterData);
}

// Genera HTML con tutti i grafici
$html = app(MakeHtmlBySurveyPdfModelAction::class)
    ->execute($surveyPdf, $answersFilterData);

// Genera PDF
$html2pdf = new Html2Pdf('L', 'A4', 'it');
$html2pdf->setTestIsImage(false);
$html2pdf->writeHTML($html->render());
$html2pdf->output('report.pdf', 'D');
```

---

## 🔗 Riferimenti

- [Spipu Html2Pdf Documentation](https://github.com/spipu/html2pdf)
- [JpGraph Documentation](https://jpgraph.net/)
- [Chart.js Documentation](https://www.chartjs.org/)
- [Chart Module Philosophy](../philosophy.md)
- [Quaeris PDF Generation](../Quaeris/docs/pdf-generation.md)

---

**Filosofia**: I grafici nei PDF seguono il principio di separazione delle responsabilità: dati → grafico → immagine → HTML → PDF. Ogni step è isolato e testabile.

