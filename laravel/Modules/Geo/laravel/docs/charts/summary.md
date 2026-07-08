# 📊 Charts System - Documentazione Completa PTVX

**Data**: 2025-12-09
**Status**: ✅ Complete
**Versione**: 1.0.0

---

## 📋 Indice Documentazione

### 📖 Documentazione Generale
- **[README Principale](./README.md)** - Guida completa a Filament Charts + Chart.js

### 🧩 Moduli con Charts

#### Core Modules
| Modulo | Documentazione | Use Cases |
|--------|----------------|-----------|
| **Activity** | [docs/charts/README.md](../../Modules/Activity/docs/charts/README.md) | Activity logs, timeline, event types |
| **Performance** | [docs/charts/README.md](../../Modules/Performance/docs/charts/README.md) | KPI dashboard, team comparison, goal tracking |
| **Gdpr** | [docs/charts/README.md](../../Modules/Gdpr/docs/charts/README.md) | Privacy requests, compliance metrics |
| **Xot** | [docs/charts/README.md](../../Modules/Xot/docs/charts/README.md) | **Shared Actions** - Export PNG/SVG |

### 🎨 Temi

| Tema | Documentazione | Features |
|------|----------------|----------|
| **One** | [docs/charts/README.md](../../Themes/One/docs/charts/README.md) | Theme customization, responsive design, accessibility |

---

## 🚀 Quick Start

### 1. Creare un Chart Widget

```bash
php artisan make:filament-widget SalesChart --chart
```

### 2. Implementare il Widget

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Sales';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [100, 200, 150, 300],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr'],
        ];
    }
}
```

### 3. Aggiungere Export PNG/SVG

```php
use Modules\Xot\Filament\Actions\ExportChartPngAction;
use Modules\Xot\Filament\Actions\ExportChartSvgAction;

class SalesChart extends ChartWidget
{
    // ... existing code ...

    protected function getHeaderActions(): array
    {
        return [
            ExportChartPngAction::make(),
            ExportChartSvgAction::make(),
        ];
    }

    // Required for export
    public function getCachedData(): array
    {
        return $this->getData();
    }

    public function getOptions(): array
    {
        return [
            'responsive' => true,
        ];
    }
}
```

---

## 📊 Tipi di Chart Disponibili

### Chart.js Standard (8 tipi)

| Tipo | Use Case | Esempio |
|------|----------|---------|
| **line** | Trend temporali | Sales over time |
| **bar** | Confronti categoriali | Sales by department |
| **pie** | Proporzioni | Market share |
| **doughnut** | Proporzioni (variante) | Budget allocation |
| **radar** | Multi-dimensionale | KPI comparison |
| **polarArea** | Proporzioni radiali | Feature usage |
| **bubble** | 3 dimensioni | Risk/Reward matrix |
| **scatter** | Correlazioni | Price vs Quality |

### Plugin Charts Aggiuntivi

| Plugin | Chart Type | Use Case |
|--------|------------|----------|
| **chartjs-chart-matrix** | Heatmap | Compliance matrix |
| **chartjs-chart-treemap** | Treemap | Budget breakdown |
| **chartjs-chart-sankey** | Sankey | Flow analysis |
| **chartjs-chart-geo** | Choropleth | Geographic data |

---

## 🧩 Plugin Ecosystem

### Plugin Installati/Consigliati

#### 1. **Annotation Plugin** ⭐
```bash
npm install chartjs-plugin-annotation
```
**Use Cases**: Target lines, threshold zones, labels

#### 2. **Zoom Plugin** ⭐
```bash
npm install chartjs-plugin-zoom
```
**Use Cases**: Pan & zoom, detail exploration

#### 3. **DataLabels Plugin**
```bash
npm install chartjs-plugin-datalabels
```
**Use Cases**: Show values on chart

#### 4. **Streaming Plugin**
```bash
npm install chartjs-plugin-streaming
```
**Use Cases**: Real-time data

#### 5. **Gradient Plugin**
```bash
npm install chartjs-plugin-gradient
```
**Use Cases**: Beautiful fills

### Installazione Plugin

```javascript
// resources/js/app.js
import { Chart } from 'chart.js';
import annotationPlugin from 'chartjs-plugin-annotation';
import zoomPlugin from 'chartjs-plugin-zoom';

Chart.register(annotationPlugin, zoomPlugin);
```

---

## 💾 Export System

### Architecture

```
┌─────────────────────────────────────────────┐
│         Filament Chart Widget               │
│  (getData, getType, getOptions)             │
└─────────────────┬───────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────┐
│     ExportChartPngAction / SvgAction        │
│  (Filament Action - User Interface)         │
└─────────────────┬───────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────┐
│  ExportChartPngQueueableAction              │
│  (Spatie QueueableAction - Background)      │
├─────────────────────────────────────────────┤
│  1. Generate HTML with Chart.js             │
│  2. Render with Browsershot + Puppeteer     │
│  3. Save PNG/SVG to storage/app/public      │
│  4. Return file path                        │
└─────────────────────────────────────────────┘
```

### PNG Export Flow

```php
// User clicks "Export PNG" button
ExportChartPngAction::make()->action(function ($livewire) {
    // 1. Get chart data
    $chartData = $livewire->getCachedData();
    $chartType = $livewire->getType();
    $options = $livewire->getOptions();

    // 2. Queue action
    $path = app(ExportChartPngQueueableAction::class)
        ->onQueue()
        ->execute($chartData, $chartType, $options);

    // 3. Notify user
    Notification::make()->success()->send();

    // 4. Download
    return response()->download($path);
});
```

### SVG Export Flow

```php
// User clicks "Export SVG" button
ExportChartSvgAction::make()->action(function ($livewire) {
    // Same as PNG, but with SVG output
    $path = app(ExportChartSvgQueueableAction::class)
        ->onQueue()
        ->execute($chartData, $chartType, $options);

    return response()->download($path);
});
```

---

## 🎯 Best Practices

### 1. Performance

✅ **DO**: Cache heavy calculations
```php
protected function getData(): array
{
    return Cache::remember('chart-' . auth()->id(), 3600, fn () => $this->calculate());
}
```

✅ **DO**: Use lazy loading
```php
protected static bool $isLazy = true;
```

✅ **DO**: Limit data points
```php
->take(365) // Max 1 year
```

### 2. Responsiveness

✅ **DO**: Enable responsive mode
```php
'responsive' => true,
'maintainAspectRatio' => true,
```

✅ **DO**: Adjust for mobile
```php
protected int | string | array $columnSpan = [
    'sm' => 2,
    'md' => 2,
    'lg' => 1,
];
```

### 3. Accessibilità

✅ **DO**: Add descriptions
```php
protected function getDescription(): ?string
{
    return 'Sales trend for the last 30 days';
}
```

✅ **DO**: Use high contrast colors
```php
'borderColor' => 'rgb(59, 130, 246)', // Good contrast
```

### 4. Theming

✅ **DO**: Use theme trait (Theme One)
```php
use Themes\One\Traits\ThemeOneChartTrait;

protected function getOptions(): array
{
    return $this->applyThemeOneStyles([...]);
}
```

---

## 📚 Examples Repository

### Activity Module
- **ActivityTimelineChart** - Line chart con trend
- **EventTypesPieChart** - Doughnut con distribuzione
- **UserActivityChart** - Bar chart confronto

### Performance Module
- **PerformanceTimelineChart** - Line chart con average
- **TeamComparisonChart** - Horizontal bar chart
- **KpiRadarChart** - Radar multi-dimensionale
- **GoalProgressChart** - Bar chart con annotation

### GDPR Module
- **GdprRequestsTimelineChart** - Line chart richieste
- **RequestTypesChart** - Doughnut distribuzione
- **ResponseTimeChart** - Bar chart con compliance line

---

## 🔧 Troubleshooting

### Problema: Browsershot non funziona

**Soluzione**:
```bash
# Installa Chromium/Chrome
sudo apt-get install chromium-browser

# Oppure Puppeteer
npm install puppeteer

# Verifica PATH
which chromium-browser
```

### Problema: Export SVG non genera vettoriale

**Soluzione**: Usa `canvas2svg` library
```javascript
npm install canvas2svg
```

### Problema: Queue non processa export

**Soluzione**:
```bash
# Avvia queue worker
php artisan queue:work --queue=charts

# Verifica job
php artisan queue:failed
```

### Problema: Chart non viene visualizzato

**Soluzione**:
```php
// Verifica getData() return format
return [
    'datasets' => [...], // Required
    'labels' => [...],   // Required
];
```

---

## 📊 Metriche & Analytics

### Export Statistics (Example)

| Formato | Export/Mese | Dimensione Media | Tempo Generazione |
|---------|-------------|------------------|-------------------|
| PNG | 450 | 85 KB | 2.3s |
| SVG | 120 | 42 KB | 3.1s |

### Most Used Charts

| Chart Type | Utilizzo | Moduli |
|------------|----------|--------|
| Line | 45% | Activity, Performance, Ptv |
| Bar | 30% | Performance, Gdpr |
| Doughnut | 15% | Activity, Gdpr |
| Radar | 7% | Performance |
| Altri | 3% | Vari |

---

## 🔗 Risorse

### Documentazione Ufficiale
- [Chart.js Docs](https://www.chartjs.org/)
- [Filament Charts Docs](https://filamentphp.com/docs/4.x/widgets/charts)
- [Spatie Browsershot](https://github.com/spatie/browsershot)
- [Spatie QueueableActions](https://github.com/spatie/laravel-queueable-action)

### Plugin Ecosystem
- [Awesome Chart.js](https://github.com/chartjs/awesome)
- [Annotation Plugin](https://www.chartjs.org/chartjs-plugin-annotation/latest/)
- [Zoom Plugin](https://www.chartjs.org/chartjs-plugin-zoom/latest/)
- [DataLabels Plugin](https://chartjs-plugin-datalabels.netlify.app/)

### Tools & Libraries
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)
- [html2canvas](https://html2canvas.hertzen.com/)
- [canvas2svg](https://github.com/gliffy/canvas2svg)

---

## 📝 Changelog

| Data | Versione | Modifiche |
|------|----------|-----------|
| 2025-12-09 | 1.0.0 | Documentazione iniziale completa per tutti i moduli e temi |

---

## 🎯 Roadmap

### Q1 2025
- [ ] Implementare export batch (multiple charts in single PDF)
- [ ] Aggiungere preset templates per chart comuni
- [ ] Dashboard builder con drag & drop charts

### Q2 2025
- [ ] Real-time streaming charts con WebSockets
- [ ] Chart comparison tool (side-by-side)
- [ ] Export scheduler (automated reports)

### Q3 2025
- [ ] AI-powered chart suggestions
- [ ] Interactive dashboard sharing
- [ ] Mobile app chart viewer

---

**Autore**: PTVX Development Team
**Manutentore**: Development Team
**Licenza**: Internal Use Only

---

## 📞 Supporto

Per domande o problemi:
1. Consulta questa documentazione
2. Verifica esempi nei moduli esistenti
3. Contatta il team di sviluppo

---

**🎉 Happy Charting!**
