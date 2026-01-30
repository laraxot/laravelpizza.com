# Tecniche Avanzate per Grafici nei PDF - Guida Completa

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Avanzata  
**Versione**: 2.0.0  
**Autore**: Analisi Completa del Sistema

---

## 📋 Indice Completo

1. [Ottimizzazione Performance](#ottimizzazione-performance)
2. [Gestione Memoria](#gestione-memoria)
3. [Merge Avanzato Immagini](#merge-avanzato-immagini)
4. [Caching Intelligente](#caching-intelligente)
5. [Error Handling Avanzato](#error-handling-avanzato)
6. [Debugging e Monitoring](#debugging-e-monitoring)
7. [Best Practices Avanzate](#best-practices-avanzate)

---

## Ottimizzazione Performance

### 1. Queue Processing

**Problema**: Generazione PDF sincrona blocca request per secondi/minuti.

**Soluzione**: Usa queue per processare in background.

```php
// ❌ SBAGLIATO - Sincrono (blocca request)
$pdfResponse = app(MakePdf2Action::class)
    ->execute($surveyPdf, $answersFilterData);

// ✅ CORRETTO - Asincrono (queue)
MakePdf2Action::dispatch($surveyPdf, $answersFilterData)
    ->onQueue('pdf-generation')
    ->delay(now()->addSeconds(5)); // Delay opzionale

// Notifica utente quando PDF è pronto
Notification::route('mail', $user->email)
    ->notify(new PdfReadyNotification($surveyPdf));
```

**Configurazione Queue**:

```php
// config/queue.php
'connections' => [
    'pdf-generation' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'pdf-generation',
        'retry_after' => 300, // 5 minuti
    ],
],
```

### 2. Parallel Processing

**Problema**: Generazione grafici sequenziale è lenta.

**Soluzione**: Genera grafici in parallelo.

```php
use Illuminate\Support\Facades\Parallel;

// Genera grafici in parallelo
$results = Parallel::map($questionCharts, function ($questionChart) use ($responses, $answersFilterData) {
    return app(MakeImgByQuestionChartModel2Action::class)
        ->execute($questionChart, $responses, $answersFilterData);
});
```

**Alternativa con Promise**:

```php
use React\Promise\PromiseInterface;

$promises = [];
foreach ($questionCharts as $questionChart) {
    $promises[] = app(MakeImgByQuestionChartModel2Action::class)
        ->executeAsync($questionChart, $responses, $answersFilterData);
}

// Attendi completamento di tutti
$results = Promise\all($promises)->wait();
```

### 3. Lazy Loading Grafici

**Problema**: Genera tutti i grafici anche se non necessari.

**Soluzione**: Genera solo grafici visibili.

```php
// Genera solo grafici con show_on_pdf = 1
$questionCharts = $surveyPdf->questionCharts
    ->where('show_on_pdf', 1)
    ->filter(function ($chart) {
        // Filtra anche per altre condizioni
        return $chart->isVisible() && $chart->hasData();
    });

foreach ($questionCharts as $questionChart) {
    // Genera solo se necessario
    if (! $questionChart->isGenerated() || $questionChart->needsRegeneration()) {
        app(MakeImgByQuestionChartModel2Action::class)
            ->execute($questionChart, $responses, $answersFilterData);
    }
}
```

---

## Gestione Memoria

### 1. Memory Limit Dinamico

**Problema**: Grafici complessi esauriscono memoria.

**Soluzione**: Aumenta memory limit solo quando necessario.

```php
public function execute(QuestionChart $questionChart, ...): array
{
    // Salva memory limit corrente
    $originalMemoryLimit = ini_get('memory_limit');
    
    try {
        // Aumenta memory limit per grafici complessi
        $chartComplexity = $this->calculateComplexity($questionChart);
        if ($chartComplexity > 1000) {
            ini_set('memory_limit', '512M');
        } else {
            ini_set('memory_limit', '256M');
        }
        
        // Genera grafico
        $result = $this->generateChart($questionChart);
        
        return $result;
    } finally {
        // Ripristina memory limit originale
        ini_set('memory_limit', $originalMemoryLimit);
    }
}

private function calculateComplexity(QuestionChart $questionChart): int
{
    $dataPoints = $questionChart->answers()->count();
    $chartTypes = $questionChart->charts()->count();
    
    return $dataPoints * $chartTypes;
}
```

### 2. Cleanup Risorse

**Problema**: Immagini temporanee non eliminate consumano spazio.

**Soluzione**: Cleanup automatico dopo generazione.

```php
public function execute(QuestionChart $questionChart, ...): array
{
    $tempFiles = [];
    
    try {
        // Genera grafici
        foreach ($datas as $k => $data_answers) {
            $filename = 'chart/'.$questionChart->id.'-'.$k.'.png';
            $file_path = public_path($filename);
            
            // Genera grafico
            $graph->Stroke($file_path);
            
            // Registra file temporaneo
            $tempFiles[] = $file_path;
        }
        
        // Merge immagini
        $finalPath = public_path('chart/'.$questionChart->id.'.png');
        $this->mergeImages($tempFiles, $finalPath);
        
        return $result;
    } finally {
        // Cleanup file temporanei
        foreach ($tempFiles as $tempFile) {
            if (File::exists($tempFile)) {
                File::delete($tempFile);
            }
        }
    }
}
```

### 3. Streaming per Grafici Grandi

**Problema**: Grafici molto grandi esauriscono memoria.

**Soluzione**: Usa streaming per grafici grandi.

```php
public function executeLargeChart(QuestionChart $questionChart): void
{
    // Crea canvas in chunks
    $chunkSize = 1000; // Punti dati per chunk
    $chunks = $questionChart->answers()->chunk($chunkSize);
    
    $tempCanvas = null;
    foreach ($chunks as $chunkIndex => $chunk) {
        // Genera grafico per chunk
        $chunkGraph = $this->generateChunkGraph($chunk);
        $chunkPath = public_path("chart/temp_chunk_{$chunkIndex}.png");
        $chunkGraph->Stroke($chunkPath);
        
        // Merge chunk con canvas principale
        if ($tempCanvas === null) {
            $tempCanvas = $chunkPath;
        } else {
            $this->mergeChunk($tempCanvas, $chunkPath);
        }
    }
    
    // Salva risultato finale
    File::move($tempCanvas, public_path('chart/'.$questionChart->id.'.png'));
}
```

---

## Merge Avanzato Immagini

### 1. Merge Verticale (Stack)

**Caso d'uso**: Più grafici da mostrare uno sopra l'altro.

```php
public function mergeVertical(array $filenames, string $outputPath): bool
{
    $manager = new InterventionImageManager(new GdDriver);
    
    // Calcola dimensioni totali
    $totalHeight = 0;
    $maxWidth = 0;
    $images = [];
    
    foreach ($filenames as $filename) {
        $img = $manager->read(public_path($filename));
        $images[] = $img;
        $totalHeight += $img->height() + 10; // 10px spacing
        $maxWidth = max($maxWidth, $img->width());
    }
    
    // Crea canvas finale
    $finalImage = $manager->create($maxWidth, $totalHeight, '#ffffff');
    
    // Posiziona immagini verticalmente
    $yOffset = 0;
    foreach ($images as $img) {
        $finalImage->place($img, 'top-left', 0, $yOffset);
        $yOffset += $img->height() + 10; // Spacing
    }
    
    $finalImage->save(public_path($outputPath));
    return true;
}
```

### 2. Merge Orizzontale (Side-by-Side)

**Caso d'uso**: Grafici da mostrare affiancati.

```php
public function mergeHorizontal(array $filenames, string $outputPath): bool
{
    $manager = new InterventionImageManager(new GdDriver);
    
    // Calcola dimensioni totali
    $totalWidth = 0;
    $maxHeight = 0;
    $images = [];
    
    foreach ($filenames as $filename) {
        $img = $manager->read(public_path($filename));
        $images[] = $img;
        $totalWidth += $img->width() + 10; // 10px spacing
        $maxHeight = max($maxHeight, $img->height());
    }
    
    // Crea canvas finale
    $finalImage = $manager->create($totalWidth, $maxHeight, '#ffffff');
    
    // Posiziona immagini orizzontalmente
    $xOffset = 0;
    foreach ($images as $img) {
        $finalImage->place($img, 'top-left', $xOffset, 0);
        $xOffset += $img->width() + 10; // Spacing
    }
    
    $finalImage->save(public_path($outputPath));
    return true;
}
```

### 3. Merge Grid (Griglia)

**Caso d'uso**: Grafici in griglia 2x2, 3x3, etc.

```php
public function mergeGrid(array $filenames, int $columns, string $outputPath): bool
{
    $manager = new InterventionImageManager(new GdDriver);
    
    $rows = (int) ceil(count($filenames) / $columns);
    $images = [];
    $maxWidth = 0;
    $maxHeight = 0;
    
    // Carica tutte le immagini
    foreach ($filenames as $filename) {
        $img = $manager->read(public_path($filename));
        $images[] = $img;
        $maxWidth = max($maxWidth, $img->width());
        $maxHeight = max($maxHeight, $img->height());
    }
    
    // Crea canvas finale
    $finalWidth = $maxWidth * $columns + (10 * ($columns - 1)); // Spacing
    $finalHeight = $maxHeight * $rows + (10 * ($rows - 1)); // Spacing
    $finalImage = $manager->create($finalWidth, $finalHeight, '#ffffff');
    
    // Posiziona immagini in griglia
    $index = 0;
    for ($row = 0; $row < $rows; $row++) {
        for ($col = 0; $col < $columns && $index < count($images); $col++) {
            $x = $col * ($maxWidth + 10);
            $y = $row * ($maxHeight + 10);
            $finalImage->place($images[$index], 'top-left', $x, $y);
            $index++;
        }
    }
    
    $finalImage->save(public_path($outputPath));
    return true;
}
```

---

## Caching Intelligente

### 1. Cache Basata su Hash Dati

**Problema**: Rigenera grafici anche se dati non cambiati.

**Soluzione**: Cache basata su hash dei dati.

```php
public function execute(QuestionChart $questionChart, ...): array
{
    // Calcola hash dei dati
    $dataHash = $this->calculateDataHash($questionChart, $responses, $answersFilterData);
    $cacheKey = "chart_{$questionChart->id}_{$dataHash}";
    
    // Verifica cache
    if (Cache::has($cacheKey)) {
        $cachedPath = Cache::get($cacheKey);
        if (File::exists(public_path($cachedPath))) {
            $questionChart->img_src = $cachedPath;
            return ['filenames' => $cachedPath];
        }
    }
    
    // Genera grafico
    $result = $this->generateChart($questionChart, ...);
    
    // Salva in cache
    Cache::put($cacheKey, $result['filenames'], 3600); // 1 ora
    
    return $result;
}

private function calculateDataHash(QuestionChart $questionChart, ...): string
{
    $data = [
        'question_chart_id' => $questionChart->id,
        'answers_count' => $responses->count(),
        'date_from' => $answersFilterData->date_from,
        'date_to' => $answersFilterData->date_to,
        'question_filter' => $answersFilterData->question_filter,
        'chart_config' => $questionChart->charts->map(fn($c) => $c->toArray())->toArray(),
    ];
    
    return md5(json_encode($data));
}
```

### 2. Cache Invalidation Intelligente

**Problema**: Cache non si invalida quando dati cambiano.

**Soluzione**: Invalida cache quando necessario.

```php
// Event listener per invalidare cache
Event::listen(SurveyResponseCreated::class, function ($event) {
    // Invalida cache grafici per survey
    $surveyId = $event->surveyResponse->survey_id;
    Cache::tags(["survey_{$surveyId}_charts"])->flush();
});

// Usa tags per cache
Cache::tags(["survey_{$surveyId}_charts"])
    ->put($cacheKey, $result['filenames'], 3600);
```

---

## Error Handling Avanzato

### 1. Retry Logic

**Problema**: Errori temporanei causano fallimento completo.

**Soluzione**: Retry con backoff esponenziale.

```php
public function executeWithRetry(QuestionChart $questionChart, int $maxRetries = 3): array
{
    $attempt = 0;
    $lastException = null;
    
    while ($attempt < $maxRetries) {
        try {
            return $this->execute($questionChart, ...);
        } catch (\Throwable $e) {
            $lastException = $e;
            $attempt++;
            
            if ($attempt < $maxRetries) {
                // Backoff esponenziale
                $delay = pow(2, $attempt); // 2, 4, 8 secondi
                sleep($delay);
                
                logger()->warning("Retry attempt {$attempt} for chart {$questionChart->id}", [
                    'exception' => $e->getMessage(),
                ]);
            }
        }
    }
    
    // Tutti i retry falliti, usa placeholder
    logger()->error("All retries failed for chart {$questionChart->id}", [
        'exception' => $lastException?->getMessage(),
    ]);
    
    return $this->getPlaceholderImage($questionChart);
}
```

### 2. Fallback Graceful

**Problema**: Errore in un grafico blocca tutto il PDF.

**Soluzione**: Fallback a placeholder o grafico semplificato.

```php
public function execute(QuestionChart $questionChart, ...): array
{
    try {
        return $this->generateChart($questionChart, ...);
    } catch (ChartGenerationException $e) {
        logger()->error("Chart generation failed, using placeholder", [
            'question_chart_id' => $questionChart->id,
            'exception' => $e->getMessage(),
        ]);
        
        return $this->getPlaceholderImage($questionChart);
    } catch (\Throwable $e) {
        logger()->error("Unexpected error in chart generation", [
            'question_chart_id' => $questionChart->id,
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        // Tenta grafico semplificato
        try {
            return $this->generateSimplifiedChart($questionChart, ...);
        } catch (\Throwable $e2) {
            return $this->getPlaceholderImage($questionChart);
        }
    }
}

private function getPlaceholderImage(QuestionChart $questionChart): array
{
    $placeholderPath = 'chart/NoDataImage.jpeg';
    if (! File::exists(public_path($placeholderPath))) {
        $this->createPlaceholderImage($placeholderPath);
    }
    
    return [
        'filenames' => $placeholderPath,
        'is_placeholder' => true,
    ];
}
```

---

## Debugging e Monitoring

### 1. Logging Dettagliato

**Problema**: Difficile capire dove fallisce la generazione.

**Soluzione**: Logging dettagliato a ogni step.

```php
public function execute(QuestionChart $questionChart, ...): array
{
    $logger = logger()->channel('chart-generation');
    $startTime = microtime(true);
    
    $logger->info("Starting chart generation", [
        'question_chart_id' => $questionChart->id,
        'chart_type' => $questionChart->chart_type,
    ]);
    
    try {
        // Step 1: Recupera dati
        $logger->debug("Step 1: Fetching data");
        $datas = app(GetChartsDataByQuestionChart::class)
            ->execute($questionChart, $responses, $answersFilterData);
        $logger->debug("Step 1 completed", ['data_count' => count($datas)]);
        
        // Step 2: Genera grafici
        $logger->debug("Step 2: Generating charts");
        foreach ($datas as $k => $data_answers) {
            $logger->debug("Generating chart {$k}", [
                'answers_count' => $data_answers->answers->count(),
            ]);
            
            // ... generazione grafico ...
            
            $logger->debug("Chart {$k} generated", ['filename' => $filename]);
        }
        
        // Step 3: Merge
        $logger->debug("Step 3: Merging images");
        $this->mergeImages($filenames, $fileName);
        $logger->debug("Step 3 completed", ['final_filename' => $fileName]);
        
        $duration = microtime(true) - $startTime;
        $logger->info("Chart generation completed", [
            'question_chart_id' => $questionChart->id,
            'duration_seconds' => round($duration, 2),
        ]);
        
        return $result;
    } catch (\Throwable $e) {
        $duration = microtime(true) - $startTime;
        $logger->error("Chart generation failed", [
            'question_chart_id' => $questionChart->id,
            'duration_seconds' => round($duration, 2),
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        throw $e;
    }
}
```

### 2. Performance Monitoring

**Problema**: Non sai quali grafici sono lenti.

**Soluzione**: Monitora performance per ogni grafico.

```php
public function execute(QuestionChart $questionChart, ...): array
{
    $metrics = [
        'start_time' => microtime(true),
        'memory_start' => memory_get_usage(true),
        'steps' => [],
    ];
    
    // Step 1
    $stepStart = microtime(true);
    $datas = app(GetChartsDataByQuestionChart::class)->execute(...);
    $metrics['steps']['fetch_data'] = [
        'duration_ms' => (microtime(true) - $stepStart) * 1000,
        'memory_peak_mb' => memory_get_peak_usage(true) / 1024 / 1024,
    ];
    
    // Step 2
    foreach ($datas as $k => $data_answers) {
        $stepStart = microtime(true);
        // ... generazione ...
        $metrics['steps']["generate_chart_{$k}"] = [
            'duration_ms' => (microtime(true) - $stepStart) * 1000,
            'memory_peak_mb' => memory_get_peak_usage(true) / 1024 / 1024,
        ];
    }
    
    $metrics['total_duration_ms'] = (microtime(true) - $metrics['start_time']) * 1000;
    $metrics['memory_peak_mb'] = memory_get_peak_usage(true) / 1024 / 1024;
    
    // Salva metrics per analisi
    $this->saveMetrics($questionChart, $metrics);
    
    return $result;
}
```

---

## Best Practices Avanzate

### 1. Pre-generazione Grafici

**Problema**: Generazione PDF lenta per molti grafici.

**Soluzione**: Pre-genera grafici in background.

```php
// Command per pre-generare grafici
class PreGenerateChartsCommand extends Command
{
    public function handle(): int
    {
        $surveyPdfs = SurveyPdf::where('auto_generate_charts', true)->get();
        
        foreach ($surveyPdfs as $surveyPdf) {
            $questionCharts = $surveyPdf->questionCharts->where('show_on_pdf', 1);
            
            foreach ($questionCharts as $questionChart) {
                // Pre-genera grafico se necessario
                if ($questionChart->needsRegeneration()) {
                    MakeImgByQuestionChartModel2Action::dispatch($questionChart)
                        ->onQueue('chart-generation');
                }
            }
        }
        
        return 0;
    }
}

// Schedule nel Kernel
$schedule->command('charts:pregenerate')
    ->hourly()
    ->withoutOverlapping();
```

### 2. Compressione Immagini

**Problema**: Immagini PNG troppo grandi.

**Soluzione**: Comprimi immagini dopo generazione.

```php
public function compressImage(string $imagePath): void
{
    $manager = new InterventionImageManager(new GdDriver);
    $image = $manager->read($imagePath);
    
    // Ottimizza PNG
    $image->toPng()->save($imagePath, quality: 85);
    
    // Alternativa: usa TinyPNG API
    // app(TinyPngCompressAction::class)->execute($imagePath);
}
```

### 3. CDN per Immagini

**Problema**: Immagini servite da server principale.

**Soluzione**: Carica immagini su CDN.

```php
public function uploadToCdn(string $imagePath): string
{
    $cdnPath = "charts/{$questionChart->id}/".basename($imagePath);
    
    Storage::disk('s3')->put($cdnPath, file_get_contents($imagePath));
    
    return Storage::disk('s3')->url($cdnPath);
}
```

---

**Ultimo Aggiornamento**: 2025-01-18  
**Versione**: 2.0.0

