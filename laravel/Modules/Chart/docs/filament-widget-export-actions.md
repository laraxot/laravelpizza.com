# Filament Widget Export Actions - Guida Completa

## 📋 Indice
1. [Introduzione](#introduzione)
2. [Actions Disponibili](#actions-disponibili)
3. [Export PNG - Passo-Passo](#export-png---passo-passo)
4. [Export SVG - Passo-Passo](#export-svg---passo-passo)
5. [Esempi Pratici](#esempi-pratici)
6. [Integration con PDF](#integration-con-pdf)
7. [Best Practices](#best-practices)

---

## Introduzione

Queste **Actions** permettono di esportare widget Filament Chart.js in immagini PNG e SVG di alta qualità, perfette per:

- 📄 **Report PDF**: Incorporare grafici nei documenti
- 📊 **Dashboard Export**: Salvare snapshot dashboard
- 📧 **Email Reports**: Allegare grafici via email
- 💾 **Archivio**: Salvare versioni storiche dei grafici

### Architettura

```
FilamentWidget → RenderChartWidgetHtmlAction → HTML
                                                   ↓
                                            Browsershot (Puppeteer)
                                                   ↓
                                    ┌──────────────┴──────────────┐
                                    ↓                              ↓
                    SaveChartWidgetAsPngAction      SaveChartWidgetAsSvgAction
                                    ↓                              ↓
                                  PNG File                       SVG File
```

---

## Actions Disponibili

### 1. SaveChartWidgetAsPngAction

**Location:** `Modules/Chart/app/Actions/Widget/SaveChartWidgetAsPngAction.php`

**Scopo:** Esporta widget Filament Chart.js in PNG ad alta risoluzione

**Features:**
- ✅ PNG ad alta qualità (2x device pixel ratio)
- ✅ Rendering server-side con Browsershot/Puppeteer
- ✅ Supporto caching per performance
- ✅ Dimensioni personalizzabili
- ✅ Ritorna path, URL e base64

### 2. SaveChartWidgetAsSvgAction

**Location:** `Modules/Chart/app/Actions/Widget/SaveChartWidgetAsSvgAction.php`

**Scopo:** Esporta widget in SVG (con PNG embedded)

**Features:**
- ✅ SVG con immagine PNG embedded
- ✅ Compatibilità universale
- ✅ Supporto caching
- ✅ Cleanup automatico file temporanei

⚠️ **Nota:** Chart.js non supporta SVG vettoriale nativo. Questa action crea SVG con PNG embedded.

### 3. RenderChartWidgetHtmlAction

**Location:** `Modules/Chart/app/Actions/Widget/RenderChartWidgetHtmlAction.php`

**Scopo:** Helper per renderizzare widget come HTML standalone

**Features:**
- ✅ HTML completo con Chart.js
- ✅ CDN Chart.js v4.4.3
- ✅ Plugin datalabels incluso
- ✅ Styling responsive

---

## Export PNG - Passo-Passo

### Step 1: Crea il Widget

```php
use Modules\Quaeris\Filament\Widgets\QuestionChartAnswersByMonthChartWidget;

// Istanzia il widget
$widget = new QuestionChartAnswersByMonthChartWidget();

// Se il widget richiede un record
$record = \Modules\Quaeris\Models\QuestionChart::find(1);
$widget->mount($record);
```

### Step 2: Esporta in PNG

```php
use Modules\Chart\Actions\Widget\SaveChartWidgetAsPngAction;

// Esegui l'action
$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    filename: 'charts/question-1-monthly.png',
    width: 1200,    // Larghezza in pixel
    height: 600,    // Altezza in pixel
    disk: 'public', // Disco storage
    quality: 90     // Qualità PNG (1-100)
);

// $result contiene:
// [
//     'path' => '/full/path/to/file.png',
//     'url' => 'https://domain.com/storage/charts/question-1-monthly.png',
//     'base64' => 'iVBORw0KGgo...',
//     'size' => 45678,
//     'width' => 2400,  // 2x per HD
//     'height' => 1200, // 2x per HD
//     'format' => 'png',
//     'filename' => 'charts/question-1-monthly.png'
// ]
```

### Step 3: Usa l'Immagine

```php
// Usa il path per PDF
$pdfCharts[] = [
    'title' => 'Risposte Mensili',
    'base64' => $result['base64'],
];

// Oppure mostra in HTML
echo '<img src="' . $result['url'] . '" alt="Chart" />';
```

---

## Export SVG - Passo-Passo

### Step 1: Crea il Widget

```php
use Modules\Quaeris\Filament\Widgets\QuestionChartAnswersByMonthChartWidget;

$widget = new QuestionChartAnswersByMonthChartWidget();
$record = \Modules\Quaeris\Models\QuestionChart::find(1);
$widget->mount($record);
```

### Step 2: Esporta in SVG

```php
use Modules\Chart\Actions\Widget\SaveChartWidgetAsSvgAction;

$result = app(SaveChartWidgetAsSvgAction::class)->execute(
    widget: $widget,
    filename: 'charts/question-1-monthly.svg',
    width: 1200,
    height: 600,
    disk: 'public'
);

// $result contiene:
// [
//     'path' => '/full/path/to/file.svg',
//     'url' => 'https://domain.com/storage/charts/question-1-monthly.svg',
//     'content' => '<?xml version="1.0"...',
//     'size' => 12345,
//     'width' => 1200,
//     'height' => 600,
//     'format' => 'svg',
//     'filename' => 'charts/question-1-monthly.svg',
//     'note' => 'SVG with embedded PNG image (not vector)'
// ]
```

### Step 3: Usa l'SVG

```php
// Mostra in HTML
echo '<img src="' . $result['url'] . '" alt="Chart SVG" />';

// Oppure inline SVG
echo $result['content'];
```

---

## Esempi Pratici

### Esempio 1: Export Tutti i Widget di una Page

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions\Export;

use Modules\Chart\Actions\Widget\SaveChartWidgetAsPngAction;
use Modules\Quaeris\Filament\Widgets\QuestionChartAnswersByMonthChartWidget;
use Modules\Quaeris\Filament\Widgets\QuestionChartAnswersByWeekTableWidget;
use Modules\Quaeris\Models\QuestionChart;
use Spatie\QueueableAction\QueueableAction;

class ExportQuestionChartsAction
{
    use QueueableAction;

    /**
     * Esporta tutti i grafici di una QuestionChart
     *
     * @param QuestionChart $questionChart
     * @return array<int, array{path: string, url: string, title: string}>
     */
    public function execute(QuestionChart $questionChart): array
    {
        $exports = [];

        // 1. Widget chart mensile
        $monthlyWidget = new QuestionChartAnswersByMonthChartWidget();
        $monthlyWidget->mount($questionChart);

        $monthlyResult = app(SaveChartWidgetAsPngAction::class)->execute(
            widget: $monthlyWidget,
            filename: "charts/question-{$questionChart->id}-monthly.png",
            width: 1200,
            height: 600
        );

        $exports[] = [
            'path' => $monthlyResult['path'],
            'url' => $monthlyResult['url'],
            'base64' => $monthlyResult['base64'],
            'title' => 'Risposte per Mese',
            'type' => 'monthly',
        ];

        // 2. Altri widget...
        // Aggiungi qui altri widget se necessario

        return $exports;
    }
}
```

### Esempio 2: Export con Caching

```php
use Modules\Chart\Actions\Widget\SaveChartWidgetAsPngAction;

// Widget pesante da renderizzare
$widget = new QuestionChartAnswersByMonthChartWidget();
$widget->mount($record);

// Export con cache (1 ora)
$cacheKey = "chart-png-{$record->id}-monthly";

$result = app(SaveChartWidgetAsPngAction::class)->executeWithCache(
    widget: $widget,
    cacheKey: $cacheKey,
    ttl: 3600, // 1 ora
    filename: "charts/cached-{$record->id}.png",
    width: 1200,
    height: 600
);

// Chiamate successive usano cache!
```

### Esempio 3: Export per Email Report

```php
use Modules\Chart\Actions\Widget\SaveChartWidgetAsPngAction;
use Illuminate\Support\Facades\Mail;

// 1. Export widget
$widget = new QuestionChartAnswersByMonthChartWidget();
$widget->mount($record);

$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    filename: 'temp/email-chart.png',
    width: 800,
    height: 400,
    disk: 'local' // Temporary local storage
);

// 2. Invia email con allegato
Mail::send('emails.report', [], function ($message) use ($result) {
    $message->to('user@example.com')
        ->subject('Report Mensile')
        ->attach($result['path'], [
            'as' => 'grafico-mensile.png',
            'mime' => 'image/png',
        ]);
});

// 3. Cleanup
\Storage::disk('local')->delete($result['filename']);
```

### Esempio 4: Batch Export Multipli Widget

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions\Export;

use Modules\Chart\Actions\Widget\SaveChartWidgetAsPngAction;
use Modules\Quaeris\Models\QuestionChart;
use Spatie\QueueableAction\QueueableAction;

class BatchExportChartsAction
{
    use QueueableAction;

    /**
     * Export batch di widget per PDF report
     *
     * @param array<QuestionChart> $questionCharts
     * @return array<int, array{base64: string, title: string}>
     */
    public function execute(array $questionCharts): array
    {
        $charts = [];

        foreach ($questionCharts as $questionChart) {
            // Crea widget
            $widget = new \Modules\Quaeris\Filament\Widgets\QuestionChartAnswersByMonthChartWidget();
            $widget->mount($questionChart);

            // Export PNG
            $result = app(SaveChartWidgetAsPngAction::class)->execute(
                widget: $widget,
                filename: "charts/batch-{$questionChart->id}.png",
                width: 1200,
                height: 600
            );

            $charts[] = [
                'base64' => $result['base64'],
                'title' => $questionChart->title ?? "Question {$questionChart->id}",
                'question_id' => $questionChart->id,
            ];

            // Cleanup memoria
            unset($widget, $result);
            gc_collect_cycles();
        }

        return $charts;
    }
}
```

---

## Integration con PDF

### Uso con Spipu HTML2PDF

```php
use Modules\Chart\Actions\Widget\SaveChartWidgetAsPngAction;
use Modules\Xot\Actions\Pdf\Engine\SpipuPdfByHtmlAction;

// 1. Export widget in PNG
$widget = new QuestionChartAnswersByMonthChartWidget();
$widget->mount($record);

$chartResult = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    filename: 'temp/chart.png',
    width: 1200,
    height: 600,
    disk: 'local'
);

// 2. Prepara dati per template
$charts = [
    [
        'title' => 'Risposte Mensili',
        'base64' => $chartResult['base64'],
    ],
];

// 3. Genera HTML
$html = view('quaeris::pdf.report', compact('charts'))->render();

// 4. Converti in PDF
$pdfPath = app(SpipuPdfByHtmlAction::class)->execute(
    html: $html,
    filename: 'report-with-charts.pdf',
    disk: 'public',
    out: 'path'
);

// 5. Cleanup
\Storage::disk('local')->delete($chartResult['filename']);

return $pdfPath;
```

---

## Best Practices

### 1. Dimensioni Ottimali

```php
// ✅ Per PDF A4 portrait
$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    width: 1200,  // ~19cm @ 150dpi
    height: 600   // ~10cm @ 150dpi
);

// ✅ Per dashboard HD
$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    width: 1920,  // Full HD width
    height: 1080  // Full HD height
);

// ❌ Evita dimensioni troppo grandi
$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    width: 4000,  // Spreco memoria!
    height: 3000
);
```

### 2. Caching Intelligente

```php
// ✅ Cache per widget statici
$cacheKey = "widget-png-{$record->id}-{$record->updated_at->timestamp}";

$result = app(SaveChartWidgetAsPngAction::class)->executeWithCache(
    widget: $widget,
    cacheKey: $cacheKey,
    ttl: 86400 // 24 ore
);

// ✅ Invalida cache quando record cambia
$record->save(); // updated_at cambia → nuovo cacheKey
```

### 3. Gestione Memoria

```php
// ✅ Export batch con gestione memoria
foreach ($widgets as $widget) {
    $result = app(SaveChartWidgetAsPngAction::class)->execute(
        widget: $widget,
        // ... parametri
    );

    // Usa $result...

    // Cleanup
    unset($widget, $result);
    gc_collect_cycles(); // Forza garbage collection
}
```

### 4. Error Handling

```php
try {
    $result = app(SaveChartWidgetAsPngAction::class)->execute(
        widget: $widget,
        filename: 'charts/my-chart.png'
    );

    // Usa $result...
} catch (\RuntimeException $e) {
    \Log::error('Chart export failed', [
        'widget' => get_class($widget),
        'error' => $e->getMessage(),
    ]);

    // Fallback: usa placeholder
    $result = [
        'base64' => $this->getPlaceholderChart(),
    ];
}
```

### 5. Queue per Export Pesanti

```php
use Illuminate\Support\Facades\Queue;

// ✅ Export pesanti in queue
Queue::push(new ExportChartsJob($questionCharts));

// Job class
class ExportChartsJob
{
    public function handle()
    {
        foreach ($this->questionCharts as $chart) {
            app(SaveChartWidgetAsPngAction::class)->execute(
                widget: $this->createWidget($chart),
                // ...
            );
        }
    }
}
```

---

## Requisiti Tecnici

### Dipendenze

```bash
# Browsershot (già installato)
composer require spatie/browsershot

# Node.js e Puppeteer (per Browsershot)
npm install puppeteer
```

### Verifica Setup

```bash
# Test Browsershot funziona
php artisan tinker
```

```php
\Spatie\Browsershot\Browsershot::html('<h1>Test</h1>')
    ->screenshot('/tmp/test.png');

// Se funziona, vedi file /tmp/test.png
```

---

## Troubleshooting

### Problema: Browsershot Timeout

**Sintomo:** `RuntimeException: The process has been signaled with signal "9"`

**Soluzione:**

```php
// Aumenta timeout
$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    // ... parametri
);

// Oppure modifica l'action per usare timeout custom
```

### Problema: Memoria Insufficiente

**Sintomo:** `Allowed memory size of X bytes exhausted`

**Soluzione:**

```php
// Riduci dimensioni
$result = app(SaveChartWidgetAsPngAction::class)->execute(
    widget: $widget,
    width: 800,   // Invece di 1920
    height: 400   // Invece di 1080
);

// Oppure aumenta memory_limit in php.ini
```

### Problema: Chart Non Renderizza

**Sintomo:** PNG bianco o errore

**Soluzione:**

```php
// Debug: salva HTML per ispezione
$html = app(RenderChartWidgetHtmlAction::class)->execute($widget);
file_put_contents('/tmp/debug-chart.html', $html);

// Apri /tmp/debug-chart.html in browser per vedere cosa c'è
```

---

## Link Utili

- [Spatie Browsershot Documentation](https://github.com/spatie/browsershot)
- [Chart.js Documentation](https://www.chartjs.org/)
- [Filament Widgets Documentation](https://filamentphp.com/docs/widgets)
- [spipu-pdf-charts-embedding-guide.md](../../Quaeris/docs/spipu-pdf-charts-embedding-guide.md)

---

*Guida Filament Widget Export Actions v1.0 - Creato: 2025-11-17*
*Modulo Chart - Architettura Laraxot*
