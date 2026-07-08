# Integrazione JpGraph e Chart.js nel Tema Zero

## Panoramica

Il tema Zero funge da "vestito" per l'applicazione healthcare_app, fornendo la presentazione visiva senza logica di business. Questo documento descrive come il tema Zero può supportare l'integrazione di JpGraph e Chart.js per la visualizzazione dei dati.

## Principi del Tema "Vestito"

Come definito nell'architettura Laraxot, il tema Zero deve fornire:
- Presentazione visiva
- Stile e design
- Interfaccia utente
- Nessuna logica di business

## Supporto per Differenti Tipi di Grafici

### Grafici Server-side (JpGraph)

Il tema Zero può supportare grafici generati server-side come:

```blade
{{-- Visualizzazione grafico JpGraph --}}
@if($chartImagePath)
    <div class="chart-container">
        <img src="{{ $chartImagePath }}" alt="Grafico Statistiche" class="chart-image">
    </div>
@endif

{{-- Con possibile fallback --}}
<div class="chart-wrapper">
    @if($chartImagePath)
        <img src="{{ $chartImagePath }}" alt="Grafico" class="chart-img">
    @else
        <div class="chart-placeholder">
            <p>Caricamento grafico in corso...</p>
        </div>
    @endif
</div>
```

### Grafici Client-side (Chart.js)

Per i grafici interattivi basati su Chart.js:

```blade
{{-- Canvas per Chart.js --}}
<div class="chart-container">
    <canvas id="interactive-chart" width="400" height="200"></canvas>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('interactive-chart').getContext('2d');
    
    // Dati forniti dal controller
    const chartData = @json($chartData);
    
    new Chart(ctx, {
        type: chartData.type || 'bar',
        data: chartData.data,
        options: chartData.options || {}
    });
});
</script>
```

## Componenti Blade per Grafici

Il tema Zero può fornire componenti riutilizzabili:

```blade
{{-- resources/views/components/chart-display.blade.php --}}
@props(['type' => 'chartjs', 'data', 'title' => null, 'width' => '100%', 'height' => '400px'])

<div class="chart-wrapper" style="width: {{ $width }}; height: {{ $height }}">
    @if($type === 'image' && $data['image_path'])
        <img src="{{ $data['image_path'] }}" alt="{{ $title }}" class="chart-image">
    @elseif($type === 'chartjs' && $data['chart_data'])
        <canvas {{ $attributes->merge(['class' => 'chart-canvas']) }}></canvas>
        
        <script>
        // Inizializzazione Chart.js
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.querySelector('.chart-canvas');
            if (canvas) {
                const chart = new Chart(canvas, @json($data['chart_data']));
            }
        });
        </script>
    @else
        <div class="chart-placeholder">
            <p>Nessun dato disponibile</p>
        </div>
    @endif
</div>
```

## Stili CSS per Grafici

Il tema Zero fornisce stili coerenti:

```css
/* resources/css/charts.css */
.chart-wrapper {
    position: relative;
    margin: 1rem 0;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background: white;
    overflow: hidden;
}

.chart-image {
    width: 100%;
    height: auto;
    display: block;
}

.chart-canvas {
    width: 100% !important;
    height: 100% !important;
}

.chart-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 300px;
    background-color: #f8f9fa;
    color: #6c757d;
}

/* Responsività */
@media (max-width: 768px) {
    .chart-wrapper {
        margin: 0.5rem 0;
    }
}
```

## Considerazioni di Design

### Per Grafici JpGraph (Statici)
- Assicurare qualità visiva anche quando ingranditi
- Ottimizzare dimensioni per tempi di caricamento
- Fornire alternative testuali per accessibilità

### Per Grafici Chart.js (Interattivi)
- Garantire esperienza utente coerente
- Ottimizzare per dispositivi mobili
- Considerare utenti con JavaScript disabilitato

## Integrazione con Widget di Filament

Il tema Zero supporta i widget di Filament che utilizzano grafici:

```blade
{{-- resources/views/filament/widgets/chart-widget.blade.php --}}
@props(['widget'])

<div class="filament-chart-widget">
    @if($widget->getChartType() === 'jpgraph' && $widget->getImagePath())
        <img src="{{ $widget->getImagePath() }}" alt="Chart" class="filament-chart-image">
    @else
        <div wire:ignore>
            <canvas id="{{ $widget->getId() }}" class="filament-chart-canvas"></canvas>
        </div>
    @endif
</div>
```

## Best Practices

### 1. Caricamento Differito
Per grafici pesanti o numerosi:

```javascript
// Lazy loading per grafici Chart.js
const chartObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Inizializza il grafico quando entra nella viewport
            initializeChart(entry.target);
            chartObserver.unobserve(entry.target);
        }
    });
});

document.querySelectorAll('.lazy-chart').forEach(chart => {
    chartObserver.observe(chart);
});
```

### 2. Gestione Errori
```blade
{{-- Gestione errori nel tema --}}
@if($chartError)
    <div class="chart-error alert alert-warning">
        <p>Impossibile caricare il grafico: {{ $chartError }}</p>
        <button onclick="retryChartLoad()">Riprova</button>
    </div>
@endif
```

### 3. Accessibilità
```blade
{{-- Assicurare accessibilità --}}
<figure class="chart-figure">
    <figcaption class="chart-caption">{{ $chartTitle }}</figcaption>
    @if($chartType === 'image')
        <img src="{{ $chartPath }}" alt="{{ $chartAltText }}" role="img">
    @else
        <canvas aria-label="{{ $chartAltText }}"></canvas>
    @endif
    <details class="chart-data-details">
        <summary>Dati del grafico</summary>
        <table class="chart-data-table">
            {{-- Tabella con dati per accessibilità --}}
        </table>
    </details>
</figure>
```

## Conclusione

Il tema Zero supporta pienamente l'integrazione di JpGraph e Chart.js mantenendo la separazione tra presentazione e logica di business. Fornisce componenti flessibili, stili coerenti e considerazioni di accessibilità per entrambi i tipi di grafici, permettendo una presentazione visiva di alta qualità dei dati generati dal sistema healthcare_app.
