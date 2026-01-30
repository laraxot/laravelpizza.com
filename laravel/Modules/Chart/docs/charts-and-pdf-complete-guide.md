# Grafici e PDF - Guida Completa Laraxot

## 📋 Indice Generale

### 🎯 Quick Navigation

| Hai bisogno di... | Vai a... |
|-------------------|----------|
| **Grafici dinamici Chart.js in PDF** | [Spatie Laravel PDF (per Chart.js)](#spatie-laravel-pdf-per-chartjs) |
| **Grafici statici JPGraph in PDF** | [JPGraph Step-by-Step](#jpgraph-step-by-step) |
| **Grafici interattivi web** | [Chart.js Export](#chartjs-export) |
| **Scegliere il motore PDF** | [Confronto Html2Pdf vs Spatie PDF](./pdf-engines-comparison.md) |
| **Capire l'architettura** | [Architettura Sistema](#architettura-sistema) |

---

## 📚 Documentazione Tecnica Completa

### 1. JPGraph Step-by-Step

**File:** [jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md)

**Contenuto:**
- ✅ Installazione e configurazione JPGraph
- ✅ Creazione grafici base (Bar, Pie, Line, Radar)
- ✅ Export PNG con alta qualità
- ✅ Export SVG (limitazioni e alternative)
- ✅ Personalizzazione completa (colori, font, assi, griglia)
- ✅ Esempi pratici per survey reports
- ✅ Best practices performance e qualità

**Quando usare:**
- Generazione PDF server-side con immagini statiche
- Grafici statici di alta qualità
- Batch processing (report multipli)
- No dipendenze JavaScript per il rendering del grafico

**Esempio Quick Start:**

```php
use Modules\Chart\Actions\JpGraph\V1\Bar2Action;
use Modules\Chart\Datas\AnswersChartData;

// Genera grafico
$graph = app(Bar2Action::class)->execute($answersChartData);

// Export PNG
$imageData = $graph->Stroke(_IMG_HANDLER);
ob_start();
imagepng($imageData, null, 6);
$base64 = base64_encode(ob_get_clean());
imagedestroy($imageData);
```

---

### 2. Spatie Laravel PDF (per Chart.js)

**File:** (Integrato principalmente tramite `spatie/browsershot` per il rendering JS)

**Contenuto:**
- ✅ Come `spatie/laravel-pdf` utilizza `spatie/browsershot` per l'esecuzione di JavaScript.
- ✅ Il rendering accurato dei grafici Chart.js dinamici.
- ✅ Embedding di grafici Chart.js da Filament in PDF.
- ✅ Impostazioni cruciali (`setDelay`, per attesa rendering JS).
- ✅ Embedding di immagini statiche (es. da JPGraph) in PDF.
- ✅ Vantaggi rispetto a soluzioni solo HTML statico (come Spipu HTML2PDF).
- ✅ Ottimizzazione della qualità (dimensioni, compressione).
- ✅ Troubleshooting problemi comuni.

**Quando usare:**
- Incorporare grafici Filament ChartWidget (Chart.js) in PDF.
- Necessità di rendering JavaScript per elementi dinamici.
- Generare report PDF professionali con contenuti web moderni.
- Migliore qualità per layout complessi e CSS avanzati.

**Esempio Quick Start (da Action Filament o Controller):**

```php
use Modules\Quaeris\Actions\GetSurveyResponseDataAction;
use Modules\Quaeris\Datas\SurveyQueryParametersData;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Blade;

// Prepara dati per il grafico Filament
$params = new SurveyQueryParametersData(
    surveyId: '12345',
    questionId: 'Q01',
    // ... altri parametri
);
$chartData = app(GetSurveyResponseDataAction::class)->execute($params, 'chart');

// Renderizza una Blade view che include il grafico Chart.js
$html = Blade::render('quaeris::pdfs.survey-report', compact('chartData'));

// Converti in PDF usando Spatie Laravel PDF (con Browsershot)
$pdfContent = Pdf::html($html)
    ->withBrowsershot(function (Browsershot $browsershot) {
        $browsershot
            ->setDelay(4000) // Cruciale: attendere il rendering JS
            ->format('A4')
            ->landscape();
    })
    ->name('filament_chart_report');

return $pdfContent->download('report.pdf');
```

---

### 3. Spipu PDF Embedding (per HTML Statico / JPGraph)

**File:** (Riferimento storico per HTML2PDF)

**Contenuto:**
- ✅ Come funziona Spipu HTML2PDF (PHP server-side)
- ✅ Metodi di embedding (Base64, File Path, URL) per immagini statiche.
- ✅ Flusso JPGraph → PDF passo-passo.
- ❌ **LIMITAZIONE: Non supporta JavaScript**, quindi non adatto a grafici Chart.js dinamici.

**Quando usare:**
- Incorporare grafici JPGraph in PDF.
- Creare report PDF professionali **senza alcun contenuto dinamico JavaScript**.
- Gestire layout multi-pagina.
- Ottimizzare dimensione file PDF con HTML/CSS molto semplici.

**Esempio Quick Start:**

```php
use Modules\Xot\Actions\Pdf\Engine\SpipuPdfByHtmlAction;

// Prepara dati
$charts = [
    [
        'title' => 'Grafico 1',
        'base64' => $base64FromJpGraph, // Immagine da JPGraph
    ],
];

// Genera HTML
$html = view('pdf.report', ['charts' => $charts])->render();

// Converti in PDF
$pdfPath = app(SpipuPdfByHtmlAction::class)->execute(
    html: $html,
    filename: 'report.pdf',
    out: 'path',
);
```

---

### 4. Chart.js Export

**File:** [chart-js-export-guide.md](./chart-js-export-guide.md)

**Contenuto:**
- ✅ Setup Chart.js v4.4.3
- ✅ Export client-side (PNG, JPEG, Blob) dal canvas.
- ✅ Export server-side (tramite Browsershot/Puppeteer, come usato da Spatie Laravel PDF).
- ✅ Integrazione con Laravel/Livewire.
- ✅ Export SVG (con limitazioni).
- ✅ Service JavaScript completo.
- ✅ Backend handler per salvataggio.
- ✅ Best practices performance e qualità.

**Quando usare:**
- Dashboard interattive.
- Grafici real-time.
- Export dinamico user-driven (es. download diretto PNG/JPG dal browser).
- Web UI con export capabilities.

**Esempio Quick Start:**

```javascript
// Client-side
const chart = new Chart(ctx, config);
const base64 = chart.toBase64Image('image/png', 1.0);

// Download
chart.canvas.toBlob((blob) => {
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'chart.png';
    link.click();
});
```

---

<h2>Filament 4 ChartWidget → PDF (strategie in Laraxot)</h2>

In Filament 4 i widget chart sono renderizzati con <b>Chart.js</b> (client-side) tramite <code>getData()</code> / <code>getType()</code> / <code>getOptions()</code>.

Per generare un PDF che include questi grafici, le strategie supportate nel nostro stack sono:

<ol>
<li>
<p><b>Strategia Preferita: <code>spatie/laravel-pdf</code> per Grafici Dinamici</b></p>
<ul>
<li><b>Come funziona:</b> Converte una Blade view (che include i grafici Chart.js renderizzati in HTML/JS) in PDF usando Browsershot (basato su Chromium). Questo garantisce che il JavaScript venga eseguito e che i grafici appaiano come nel browser.</li>
<li><b>Vantaggi:</b> Supporto completo JS, layout moderni, alta fedeltà di rendering.</li>
<li><b>Riferimento:</b> <a href="#spatie-laravel-pdf-per-chartjs">Spatie Laravel PDF (per Chart.js)</a></li>
</ul>
</li>
<li>
<p><b>Alternativa: Generazione Server-side (per grafici statici/batch)</b></p>
<ul>
<li><b>Come funziona:</b> Utilizza <b>JPGraph</b> per generare immagini PNG/JPG dei grafici direttamente sul server. Queste immagini vengono poi incorporate in una Blade view HTML, che può essere convertita in PDF con <code>spatie/laravel-pdf</code> (o, per HTML molto semplice, con <code>Spipu HTML2PDF</code>).</li>
<li><b>Vantaggi:</b> Nessuna dipendenza da Node.js/Puppeteer per il rendering dei grafici, adatto per batch processing.</li>
<li><b>Riferimenti:</b>
<ul>
<li><a href="#jpgraph-step-by-step">JPGraph Step-by-Step</a></li>
<li><a href="#spatie-laravel-pdf-per-chartjs">Spatie Laravel PDF (per Chart.js)</a> (per l'embedding delle immagini)</li>
<li><a href="#spipu-pdf-embedding-per-html-statico--jpgraph">Spipu PDF Embedding (per HTML Statico / JPGraph)</a></li>
</ul>
</li>
</ul>
</li>
</ol>

<h2>LimeSurvey upstream: export statistiche e limiti PDF</h2>

In upstream LimeSurvey, l'export PDF delle statistiche è limitato (in pratica non copre tutti i casi di chart/reporting “enterprise”).

Note principali:

<ul>
<li>libreria: <b>pChart</b></li>
<li>PDF: grafici supportati solo in un sottoinsieme di casi (tipicamente pie/bar a seconda del tipo domanda)</li>
</ul>

Riferimento:

<ul>
<li><a href="https://www.limesurvey.org/manual/Statistics">https://www.limesurvey.org/manual/Statistics</a></li>
</ul>

---

<h2>🏗️ Architettura Sistema</h2>

<h3>Stack Completo (Aggiornato)</h3>

<pre><code>┌─────────────────────────────────────────────────────────┐
│                   LARAXOT CHART SYSTEM                   │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌────────────────┐         ┌──────────────────┐       │
│  │  Survey Data   │────────▶│   ChartData +    │       │
│  │  (Questions,   │         │  AnswersChartData│       │
│  │   Responses)   │         └──────────────────┘       │
│  └────────────────┘                  │                  │
│                                      │                  │
│                                      ▼                  │
│         ┌────────────────────────────────────┐          │
│         │    RENDERING ENGINE SELECTION      │          │
│         └────────────────────────────────────┘          │
│                    │                │                   │
│           ┌────────┴────────┐      │                   │
│           ▼                 ▼      ▼                   │
│     ┌──────────┐      ┌──────────┐ ┌──────────┐       │
│     │ JPGraph  │      │Chart.js  │ │ Others   │       │
│     │(Server)  │      │(Client)  │ │(Future)  │       │
│     └──────────┘      └──────────┘ └──────────┘       │
│           │                 │           │              │
│           │                 │           │              │
│           ▼                 ▼           ▼              │
│     ┌──────────┐      ┌─────────────────────────┐      │
│     │   PNG    │      │  Canvas (PNG/SVG/Base64)│      │
│     │  Base64  │      └─────────────────────────┘      │
│     └──────────┘                 │                     │
│           │                      │                     │
│           └───────────┬──────────┘                     │
│                       │                                │
│                       ▼                                │
│         ┌──────────────────────┐                       │
│         │   HTML/Blade View    │                       │
│         │ (con JS/immagini)    │                       │
│         └──────────────────────┘                       │
│                       │                                │
│                       ▼                                │
│         ┌──────────────────────┐                       │
│         │ Spatie Laravel PDF   │                       │
│         │ (via Browsershot)    │                       │
│         └──────────────────────┘                       │
│                       │                                │
│                       ▼                                │
│         ┌──────────────────────┐                       │
│         │    PDF Document      │                       │
│         │   (Report Output)    │                       │
│         └──────────────────────┘                       │
│                                                         │
└─────────────────────────────────────────────────────────┘
</code></pre>

<h3>Flusso Dati Dettagliato (Aggiornato)</h3>

<h4>1. Raccolta Dati Survey</h4>

<pre><code>// Survey → Questions → Responses
$survey = SurveyPdf::find($id);
$questions = $survey->questions()-&gt;with('responses')-&gt;get();
</code></pre>

<h4>2. Preparazione ChartData</h4>

<pre><code>// Transform in ChartData + AnswersChartData
$chartData = ChartData::from([
    'type' =&gt; 'bar',
    'width' =&gt; 700,
    'height' =&gt; 400,
    'title' =&gt; $question-&gt;text,
    // ... configurazione
]);

$answersData = AnswersChartData::from([
    'chart' =&gt; $chartData,
    'answers' =&gt; $processedResponses,
]);
</code></pre>

<h4>3. Generazione Grafico (JPGraph o Chart.js)</h4>

<p><b>A. JPGraph (per immagini statiche):</b></p>

<pre><code>// JPGraph Action
$graph = app(Bar2Action::class)-&gt;execute($answersData);

// Export PNG
$imageData = $graph-&gt;Stroke(_IMG_HANDLER);
$base64 = base64_encode($imageData); // Ensure imageData is binary
</code></pre>

<p><b>B. Chart.js (per rendering dinamico in PDF):</b><br />
La generazione avviene nel browser headless di Browsershot durante la conversione. L'HTML del Blade template include il JS di Chart.js che si occupa del rendering.</p>

<h4>4. Embedding in HTML (per Spatie Laravel PDF)</h4>

<p><b>A. Immagini JPGraph:</b></p>

<pre><code>&lt;img src="data:image/png;base64,{{ $base64 }}"
     alt="Grafico"
     style="max-width: 100%; height: auto;" /&gt;
</code></pre>

<p><b>B. Grafici Chart.js:</b><br />
Il Blade template conterrà un elemento <code>&lt;canvas&gt;</code> e il JavaScript per inizializzare il grafico con i dati passati.</p>

<pre><code>&lt;div class="chart-container"&gt;
    &lt;canvas id="myChart"&gt;&lt;/canvas&gt;
&lt;/div&gt;
&lt;script&gt;
    const chartData = @json($chartDataFromAction);
    new Chart(document.getElementById('myChart'), {
        type: chartData.type,
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets
        },
        options: chartData.options
    });
&lt;/script&gt;
</code></pre>

<h4>5. Conversione PDF (Spatie Laravel PDF)</h4>

<pre><code>// Spatie Laravel PDF (con Browsershot)
$html = view('pdf.report', compact('charts', 'chartDataFromAction'))-&gt;render(); // o altri dati
$pdf = Pdf::html($html)-&gt;withBrowsershot(...)
</code></pre>

---

<h2>🎯 Use Cases Pratici (Aggiornati)</h2>

<h3>Use Case 1: Report Survey PDF (Grafici Dinamici Filament)</h3>

<p><b>Scenario:</b> Generare report PDF con analisi visiva di un survey, utilizzando grafici dinamici Chart.js come in Filament.</p>

<p><b>Stack:</b></p>

<ul>
<li>Chart.js (grafici client-side, renderizzati da Browsershot)</li>
<li><code>spatie/laravel-pdf</code> (conversione HTML+JS → PDF)</li>
<li>Laravel Actions (preparazione dati)</li>
</ul>

<p><b>Steps:</b></p>

<p>1. <b>Raccogli e prepara dati</b></p>

<pre><code>$params = new SurveyQueryParametersData(...);
$chartData = app(GetSurveyResponseDataAction::class)-&gt;execute($params, 'chart');
</code></pre>

<p>2. <b>Crea HTML (Blade view con Canvas e JS)</b></p>

<pre><code>$html = view('quaeris::pdfs.survey-report', compact('chartData'))-&gt;render();
</code></pre>

<p>3. <b>Converti in PDF (con attesa rendering JS)</b></p>

<pre><code>$pdf = Pdf::html($html)
    -&gt;withBrowsershot(fn (Browsershot $browsershot) =&gt; $browsershot-&gt;setDelay(4000))
    -&gt;download('report.pdf');
</code></pre>

<p><b>Guide:</b></p>

<ul>
<li><a href="#spatie-laravel-pdf-per-chartjs">Spatie Laravel PDF (per Chart.js)</a></li>
<li><a href="../../Quaeris/docs/advanced_filament_charts_and_limesurvey_pdfs.md">advanced_filament_charts_and_limesurvey_pdfs.md</a></li>
</ul>

---

<h3>Use Case 2: Report Survey PDF (Grafici Statici JPGraph)</h3>

<p><b>Scenario:</b> Generare report PDF con grafici statici ad alta qualità per scenari di batch o dove non si vuole dipendere da Node.js/Puppeteer.</p>

<p><b>Stack:</b></p>

<ul>
<li>JPGraph (generazione immagini PNG/JPG server-side)</li>
<li><code>spatie/laravel-pdf</code> (embedding immagini → PDF)</li>
<li>Laravel Actions (preparazione dati)</li>
</ul>

<p><b>Steps:</b></p>

<p>1. <b>Raccogli dati e genera immagini JPGraph</b></p>

<pre><code>$base64ChartImage = app(JpGraphService::class)-&gt;generateForSurvey($surveyId, $questionId); // Ritorna base64
</code></pre>

<p>2. <b>Crea HTML (Blade view con tag <code>&lt;img&gt;</code> base64)</b></p>

<pre><code>$html = view('quaeris::pdfs.static-chart-report', compact('base64ChartImage'))-&gt;render();
</code></pre>

<p>3. <b>Converti in PDF</b></p>

<pre><code>$pdf = Pdf::html($html)-&gt;download('static_report.pdf');
</code></pre>

<p><b>Guide:</b></p>

<ul>
<li><a href="#jpgraph-step-by-step">JPGraph Step-by-Step</a></li>
<li><a href="#spatie-laravel-pdf-per-chartjs">Spatie Laravel PDF (per Chart.js)</a> (per l'embedding delle immagini)</li>
<li><a href="../../Quaeris/docs/advanced_filament_charts_and_limesurvey_pdfs.md">advanced_filament_charts_and_limesurvey_pdfs.md</a></li>
</ul>

---

<h3>Use Case 3: Dashboard Interattiva (con Export on-demand)</h3>

<p><b>Scenario:</b> Dashboard real-time con grafici Chart.js interattivi e possibilità di esportazione on-demand (PNG/PDF).</p>

<p><b>Stack:</b></p>

<ul>
<li>Chart.js (grafici client-side)</li>
<li>Livewire (reattività)</li>
<li>Laravel API (backend per export)</li>
<li><code>spatie/laravel-pdf</code> (per export PDF on-demand)</li>
</ul>

<p><b>Steps:</b></p>

<p>1. <b>Crea chart interattivo in Filament Widget</b></p>

<pre><code>// MySurveyChartWidget estende XotBaseChartWidget
// ... implementa getData(), getOptions(), form()
</code></pre>

<p>2. <b>Implementa Export on-demand (Action Filament/API endpoint)</b></p>

<pre><code>// Da un'azione Filament o un controller API, puoi rigenerare il PDF
$pdf = Pdf::html(view('quaeris::pdfs.survey-report', compact('chartData')))-&gt;download();
</code></pre>

<p><b>Guide:</b></p>

<ul>
<li><a href="#chartjs-export">Chart.js Export</a></li>
<li><a href="../../Quaeris/docs/advanced_filament_charts_and_limesurvey_pdfs.md">advanced_filament_charts_and_limesurvey_pdfs.md</a></li>
</ul>

---

<h3>Use Case 4: Batch Report Generation (Notturno)</h3>

<p><b>Scenario:</b> Generare 1000+ report PDF di notte (queue) con grafici ad alta fedeltà.</p>

<p><b>Stack:</b></p>

<ul>
<li>JPGraph (performance server-side per immagini)</li>
<li>Laravel Queue</li>
<li>Redis Cache</li>
<li><code>spatie/laravel-pdf</code> (per conversione PDF batch)</li>
</ul>

<p><b>Steps:</b></p>

<p>1. <b>Queue job</b></p>

<pre><code>dispatch(new GenerateReportsJob($surveyIds));
</code></pre>

<p>2. <b>Generazione grafici e PDF in background</b></p>

<pre><code>// Dentro il job:
$base64ChartImage = app(JpGraphService::class)-&gt;generateForSurvey($surveyId, $questionId);
$html = view('quaeris::pdfs.static-chart-report', compact('base64ChartImage'))-&gt;render();
Pdf::html($html)-&gt;save(storage_path('app/reports/report_' . $surveyId . '.pdf'));
</code></pre>

<p><b>Guide:</b></p>

<ul>
<li><a href="#jpgraph-step-by-step">JPGraph Step-by-Step</a></li>
<li><a href="#spatie-laravel-pdf-per-chartjs">Spatie Laravel PDF (per Chart.js)</a></li>
<li><a href="../../Quaeris/docs/advanced_filament_charts_and_limesurvey_pdfs.md">advanced_filament_charts_and_limesurvey_pdfs.md</a></li>
</ul>

---

<h2>📊 Comparison Matrix (Aggiornata)</h2>

<h3>JPGraph vs Chart.js vs Filament Chart Widgets</h3>

<table>
<thead>
<tr>
<th>Caratteristica</th>
<th>JPGraph</th>
<th>Chart.js</th>
<th>Filament ChartWidget (Chart.js)</th>
<th>Vincitore</th>
</tr>
</thead>
<tbody>
<tr>
<td><b>Server-Side Rendering</b></td>
<td>✅ Nativo</td>
<td>❌ (Richiede headless browser per output immagine)</td>
<td>❌ (Richiede headless browser per output immagine)</td>
<td>JPGraph</td>
</tr>
<tr>
<td><b>Client-Side Rendering</b></td>
<td>❌</td>
<td>✅ Nativo</td>
<td>✅ Nativo (in dashboard)</td>
<td>Chart.js / Filament</td>
</tr>
<tr>
<td><b>Qualità Grafica (Web)</b></td>
<td>⭐⭐⭐⭐</td>
<td>⭐⭐⭐⭐⭐</td>
<td>⭐⭐⭐⭐⭐</td>
<td>Chart.js / Filament</td>
</tr>
<tr>
<td><b>Qualità Grafica (PDF)</b></td>
<td>⭐⭐⭐⭐⭐ (come immagine)</td>
<td>⭐⭐⭐⭐⭐ (via Browsershot)</td>
<td>⭐⭐⭐⭐⭐ (via Browsershot)</td>
<td>Pari (se Browsershot)</td>
</tr>
<tr>
<td><b>Interattività (Web)</b></td>
<td>❌</td>
<td>✅</td>
<td>✅</td>
<td>Chart.js / Filament</td>
</tr>
<tr>
<td><b>Performance Batch</b></td>
<td>⭐⭐⭐⭐⭐</td>
<td>⭐⭐ (con rendering headless)</td>
<td>⭐⭐ (con rendering headless)</td>
<td>JPGraph</td>
</tr>
<tr>
<td><b>SVG Support</b></td>
<td>⭐⭐</td>
<td>⭐⭐⭐</td>
<td>⭐⭐⭐</td>
<td>Chart.js / Filament</td>
</tr>
<tr>
<td><b>Facilità Setup (Base)</b></td>
<td>⭐⭐⭐⭐</td>
<td>⭐⭐⭐⭐⭐</td>
<td>⭐⭐⭐⭐⭐</td>
<td>Chart.js / Filament</td>
</tr>
<tr>
<td><b>Dipendenze</b></td>
<td>Solo PHP (GD)</td>
<td>JS (Browser)</td>
<td>PHP, JS (Browser/Node.js)</td>
<td>JPGraph</td>
</tr>
</tbody>
</table>

<h3>Scegliere l'Engine Giusto (Aggiornato)</h3>

<pre><code>Hai bisogno di...
│
├─ PDF statici professionali con grafici veloci da generare (batch)?
│  └─ ✅ JPGraph (immagini) + Spatie Laravel PDF
│
├─ Dashboard interattive con grafici dinamici?
│  └─ ✅ Filament ChartWidget (Chart.js)
│
├─ PDF che replichino fedelmente grafici dinamici della dashboard?
│  └─ ✅ Filament ChartWidget (Chart.js) + Spatie Laravel PDF
│
├─ Real-time updates nella dashboard?
│  └─ ✅ Filament ChartWidget (Chart.js)
│
└─ Esportazioni user-driven (PNG/PDF) direttamente dalla dashboard?
   └─ ✅ Filament ChartWidget (Chart.js) + Spatie Laravel PDF / Export client-side
</code></pre>

---

<h2>🛠️ Tools e Utilities (Aggiornati)</h2>

<h3>Helper Functions (Aggiunto <code>JpGraphService</code>)</h3>

<pre><code>// Chart Generation Helper (for JpGraph)
function generateJpGraphBase64($question): string
{
    // Esempio: Invocazione di un servizio per JpGraph
    $imageData = app(\Modules\Quaeris\Services\JpGraphService::class)-&gt;generateForQuestion($question); // Ritorna PNG binary
    return base64_encode($imageData);
}

// PDF Generation Helper (con Spatie Laravel PDF)
function generatePdfReport(array $chartsBase64, array $chartJsData, string $filename): BinaryFileResponse
{
    $html = view('quaeris::pdfs.survey-report', compact('chartsBase64', 'chartJsData'))-&gt;render();

    return Pdf::html($html)
        -&gt;withBrowsershot(function (Browsershot $browsershot) {
            $browsershot-&gt;setDelay(4000)-&gt;format('A4')-&gt;landscape();
        })
        -&gt;name($filename)
        -&gt;download();
}
</code></pre>

<h3>Service Classes (Aggiunto <code>JpGraphService</code> concettuale)</h3>

<pre><code>// ChartService.php
class ChartService
{
    public function generateForPdf($question): array
    {
        // Questo metodo potrebbe ora scegliere tra JPGraph o dati per Chart.js
        if ($question-&gt;chart_type === 'static_image') {
            $base64 = app(\Modules\Quaeris\Services\JpGraphService::class)-&gt;generateForQuestion($question);
            return [
                'type' =&gt; 'image',
                'base64' =&gt; $base64,
                'title' =&gt; $question-&gt;text,
            ];
        } else {
            // Prepara dati per Chart.js
            $chartData = app(GetSurveyResponseDataAction::class)-&gt;execute($question-&gt;getChartParams(), 'chart');
            return [
                'type' =&gt; 'chartjs',
                'data' =&gt; $chartData,
                'title' =&gt; $question-&gt;text,
            ];
        }
    }

    public function generateMultiple(Collection $questions): array
    {
        return $questions-&gt;map(fn($q) =&gt; $this-&gt;generateForPdf($q))-&gt;all();
    }
}

// Modules/Quaeris/Services/JpGraphService.php (Concettuale)
namespace Modules\Quaeris\Services;

use Graph;
use AccImage; // Per caching
// ... altri usi di JPGraph

class JpGraphService
{
    public function generateForQuestion(\Modules\Quaeris\Models\QuestionChart $questionChart): string
    {
        // Prepara i dati dalla logica del QuestionChart
        $data = $questionChart-&gt;getJpGraphData(); // Metodo concettuale per ottenere i dati

        $graph = new Graph(600, 300);
        $graph-&gt;SetScale('textlin');
        // ... configurazione JPGraph

        $linePlot = new LinePlot($data['values']);
        $graph-&gt;Add($linePlot);

        // Cattura l'output dell'immagine
        ob_start();
        $graph-&gt;Stroke(_IMG_HANDLER); // Strokare direttamente per restituire il binario
        $imageData = ob_get_clean();

        return $imageData; // Ritorna il binario PNG
    }
}
</code></pre>

---

<h2>📖 Riferimenti Esterni (Aggiornati)</h2>

<h3>Librerie Ufficiali</h3>

<ul>
<li><a href="https://jpgraph.net/doc/">JPGraph Documentation</a></li>
<li><a href="https://www.chartjs.org/docs/latest/">Chart.js Documentation</a></li>
<li><a href="https://spatie.be/docs/laravel-pdf/v1/introduction">Spatie Laravel PDF Documentation</a> (Raccomandato per PDF con grafici dinamici)</li>
<li><a href="https://github.com/spipu/html2pdf">Spipu HTML2PDF GitHub</a> (Per PDF statici, senza JavaScript)</li>
<li><a href="https://github.com/spatie/browsershot">Spatie Browsershot</a> (Componente core di Spatie Laravel PDF)</li>
</ul>

<h3>Documentazione Interna</h3>

<ul>
<li><a href="../../../CLAUDE.md">CLAUDE.md</a> - Regole architettura Laraxot</li>
<li><a href="../../Xot/docs/actions/pdf-actions-overview.md">Modulo Xot - PDF Actions</a></li>
<li><a href="../../Quaeris/README.md">Modulo Quaeris - Survey System</a></li>
<li><a href="../../Quaeris/docs/query_model_for_widgets.md">Query Model for Filament Table and Chart Widgets</a></li>
<li><a href="../../Quaeris/docs/advanced_filament_charts_and_limesurvey_pdfs.md">Advanced Filament Chart Widgets and LimeSurvey PDF Exports</a></li>
</ul>

---

<h2>🎓 Tutorial Video (Futuro)</h2>

<ul>
<li><input checked="" disabled="" type="checkbox" /> Tutorial: Generazione PDF con grafici Chart.js tramite Spatie Laravel PDF</li>
<li><input checked="" disabled="" type="checkbox" /> Tutorial: Creare grafici statici con JPGraph e integrarli in PDF</li>
<li><input checked="" disabled="" type="checkbox" /> Tutorial: Dashboard Chart.js con export PDF/PNG on-demand</li>
<li><input checked="" disabled="" type="checkbox" /> Tutorial: Batch PDF generation con JPGraph e Queue</li>
</ul>

---

<h2>🤝 Contributing (Nessuna modifica)</h2>

<p>Per contribuire a questa documentazione:</p>

<ol>
<li>Leggi <a href="../../../CLAUDE.md">CLAUDE.md</a> per le convenzioni</li>
<li>Usa nomenclatura kebab-case per file <code>.md</code></li>
<li>Mantieni esempi pratici e funzionanti</li>
<li>Testa tutti i codici di esempio</li>
<li>Aggiungi screenshots quando possibile</li>
</ol>

---

<h2>📝 Changelog Documentazione (Aggiornato)</h2>

<h3>v1.1 (2026-01-14)</h3>

<ul>
<li>✅ Incorporazione di Spatie Laravel PDF come soluzione preferita per grafici Chart.js dinamici in PDF.</li>
<li>✅ Dettaglio sull'uso di JPGraph per immagini statiche in PDF.</li>
<li>✅ Confronto aggiornato tra JPGraph, Chart.js e Filament ChartWidget.</li>
<li>✅ Implementazione concettuale di <code>JpGraphService</code> per il rendering server-side.</li>
<li>✅ Aggiornamento Indice Generale e Architettura Sistema.</li>
<li>✅ Riferimenti esterni e interni aggiornati.</li>
</ul>

<h3>v1.0 (2025-11-17)</h3>

<ul>
<li>✅ Guida JPGraph completa con esempi pratici</li>
<li>✅ Guida Spipu PDF embedding step-by-step</li>
<li>✅ Guida Chart.js export (client e server-side)</li>
<li>✅ Use cases dettagliati per ogni scenario</li>
<li>✅ Comparison matrix e decision tree</li>
<li>✅ Helper functions e service classes</li>
</ul>

---

<div align="center">

<b>📊 Sistema Grafici e PDF Laraxot</b>

<i>Documentazione completa per generazione grafici e PDF professionali</i>

<b>Creato con ❤️ da AI Assistant - Ultimo aggiornamento: 2026-01-14</b>

</div>