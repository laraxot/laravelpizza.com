# PTVX - Chart Documentation Index

## 📋 Panoramica

Questa è la documentazione completa per l'implementazione, personalizzazione ed export di chart in PTVX utilizzando Filament Charts e Chart.js.

**Ultima Generazione:** Dicembre 2025
**Framework:** Laraxot/PTVX
**Filament:** 4.x
**Chart.js:** 4.x

---

## 📚 Documentazione Disponibile

### 🎯 Core Documentation (Modules/Xot/docs)

#### 1. Filament Charts - Guida Completa
**File:** `Modules/Xot/docs/filament-charts-complete-guide.md`

**Contenuti:**
- ✅ Creazione chart widget con Artisan
- ✅ Tutti i tipi di chart (Line, Bar, Pie, Doughnut, Radar, Polar, Bubble, Scatter)
- ✅ Personalizzazione completa (colori, font, dimensioni)
- ✅ Integrazione Laravel Trend per dati dinamici
- ✅ Filtri semplici e avanzati con schema
- ✅ Plugin Chart.js (Annotation, Zoom, DataLabels)
- ✅ Best practices PTVX
- ✅ Testing

**Quando usarla:**
- Creare nuovi chart widget
- Capire tipi di chart disponibili
- Personalizzare appearance e behavior
- Integrare dati da database

---

#### 2. Chart Export Guide - PNG e SVG
**File:** `Modules/Xot/docs/chart-export-guide.md`

**Contenuti:**
- ✅ Client-side export (browser)
- ✅ Server-side export (Node.js)
- ✅ **Spatie QueueableAction implementation**
- ✅ Export chart in PNG
- ✅ Export chart in SVG
- ✅ Batch export e PDF generation
- ✅ Scheduled exports (cron)
- ✅ Email attachments
- ✅ Storage management

**Quando usarla:**
- Implementare download chart
- Creare report PDF con grafici
- Salvare chart per archivio
- Inviare chart via email
- Automatizzare export periodici

**Implementazione Chiave:**

```php
use Modules\Xot\Actions\Chart\ExportChartAction;
use Modules\Xot\Actions\Chart\ExportChartWidgetAction;

// Export PNG
$storedPath = app(ExportChartAction::class)->executeToPng($chartConfig, 1200, 800);

// Export SVG
$storedPath = app(ExportChartAction::class)->executeToSvg($chartConfig, 1200, 800);

// Export widget direttamente
$storedPath = app(ExportChartWidgetAction::class)->execute($widget, 'png', 1200, 800);

// Download
return Storage::download($storedPath, 'chart.png');
```

---

### 📦 Module-Specific Documentation

#### 3. User Module - Charts Implementation
**File:** `Modules/User/docs/charts-implementation.md`

**Contenuti:**
- ✅ UsersChartWidget (authentication logs)
- ✅ UserTypeRegistrationsChartWidget
- ✅ Performance optimization (90 days limit, 1000 records max)
- ✅ Page filters integration
- ✅ Error handling patterns
- ✅ Statistiche implementabili:
  - User Activity Heatmap
  - User Growth Trend
  - Failed Login Attempts
- ✅ Export actions implementation
- ✅ Testing examples

**Quando usarla:**
- Creare statistiche utenti
- Monitorare autenticazioni
- Analizzare trend registrazioni
- Implementare dashboard utenti

---

### 🎨 Theme-Specific Documentation

#### 4. Theme One - Charts Integration
**File:** `Themes/One/docs/charts-integration.md`

**Contenuti:**
- ✅ Design system completo
- ✅ Palette colori dedicata
- ✅ Tipografia personalizzata
- ✅ `ThemeOneChartWidget` base class
- ✅ Helper methods per styling
- ✅ CSS customization
- ✅ Animazioni custom
- ✅ Plugin integration con tema
- ✅ Multi-dataset charts styled
- ✅ Dark mode support

**Quando usarla:**
- Creare chart con Theme One
- Mantenere coerenza visiva
- Applicare brand colors
- Customizzare appearance avanzata

**Features Chiave:**
- Colori tema automatici
- Font Inter pre-configurato
- Helper `createDataset()` per consistency
- Export con styling preservato

---

#### 5. Theme Zero - Charts Integration
**File:** `Themes/Zero/docs/charts-integration.md`

**Contenuti:**
- ✅ Approccio minimale
- ✅ `ZeroChartWidget` base class
- ✅ Implementazioni semplici
- ✅ Colori base opzionali
- ✅ Export base

**Quando usarla:**
- Quick prototyping
- MVP implementation
- Performance-first approach
- Progetti senza branding specifico

---

## 🚀 Quick Start Guide

### 1. Creare un Nuovo Chart Widget

```bash
# Generate widget
php artisan make:filament-widget SalesChart --chart
```

```php
<?php

namespace App\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget; // o ThemeOneChartWidget
use Flowframe\Trend\Trend;
use App\Models\Sale;

class SalesChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = 'Sales Trend';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(Sale::class)
            ->between(start: now()->subDays(30), end: now())
            ->perDay()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $data->map(fn($v) => $v->aggregate)->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn($v) => $v->date->format('d/m'))->toArray(),
        ];
    }
}
```

### 2. Aggiungere Export

```php
use Modules\Xot\Actions\Chart\ExportChartWidgetAction;
use Filament\Actions\Action;

class SalesChartWidget extends XotBaseChartWidget
{
    // ... existing code ...

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPng')
                ->label('Export PNG')
                ->icon('heroicon-o-photo')
                ->action(function (ExportChartWidgetAction $action) {
                    $storedPath = $action->execute($this, 'png', 1200, 800);
                    return Storage::download($storedPath, 'sales-chart.png');
                }),

            Action::make('exportSvg')
                ->label('Export SVG')
                ->icon('heroicon-o-document-text')
                ->action(function (ExportChartWidgetAction $action) {
                    $storedPath = $action->execute($this, 'svg', 1200, 800);
                    return Storage::download($storedPath, 'sales-chart.svg');
                }),
        ];
    }
}
```

### 3. Registrare nel Dashboard

```php
// app/Filament/Pages/Dashboard.php
public function getWidgets(): array
{
    return [
        SalesChartWidget::class,
        // ... other widgets
    ];
}
```

---

## 📊 Tipi di Chart Disponibili

| Tipo | Uso Ideale | Complessità | Doc |
|------|------------|-------------|-----|
| **Line** | Trend temporali | Bassa | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#1-line-chart) |
| **Bar** | Comparazioni | Bassa | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#2-bar-chart) |
| **Pie** | Distribuzioni | Bassa | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#3-pie-chart) |
| **Doughnut** | Distribuzioni con centro | Bassa | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#4-doughnut-chart) |
| **Radar** | Multi-variabili | Media | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#5-radar-chart) |
| **Polar** | Distribuzioni radiali | Media | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#6-polar-area-chart) |
| **Bubble** | 3 dimensioni (x, y, size) | Alta | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#7-bubble-chart) |
| **Scatter** | Correlazioni | Alta | [Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#8-scatter-chart) |

---

## 🎯 Best Practices

### Performance

1. **Caching**
   ```php
   Cache::remember('chart-data', 300, fn() => $this->fetchData());
   ```

2. **Limiti Query**
   ```php
   ->take(1000) // Max records
   ->whereBetween('created_at', [now()->subDays(90), now()]) // Max range
   ```

3. **Lazy Loading**
   ```php
   protected static bool $isLazy = true;
   ```

4. **Polling Disabilitato per Performance**
   ```php
   protected ?string $pollingInterval = null;
   ```

### Sicurezza

1. **Validazione Input**
   ```php
   Assert::nullOrString($startDate);
   Assert::nullOrString($endDate);
   ```

2. **Error Handling**
   ```php
   try {
       return $this->fetchChartData();
   } catch (\Exception $e) {
       return $this->getEmptyDataset();
   }
   ```

### Manutenibilità

1. **Estendi Base Classes**
   - `XotBaseChartWidget` per logica comune
   - `ThemeOneChartWidget` per styling consistente

2. **Riusa Helper Methods**
   - `createDataset()` per dataset styled
   - `getThemeColors()` per colori tema
   - `getDefaultChartOptions()` per configurazioni

3. **Type Safety (PHPStan Level 10)**
   ```php
   /** @return array<string, mixed> */
   protected function getData(): array
   ```

---

## 🔌 Plugin Chart.js

### Installati e Documentati

| Plugin | Funzionalità | Setup |
|--------|--------------|-------|
| **Annotation** | Linee/box annotazioni | `npm install chartjs-plugin-annotation` |
| **Zoom** | Pan e zoom grafici | `npm install chartjs-plugin-zoom` |
| **DataLabels** | Label sui data point | `npm install chartjs-plugin-datalabels` |

**Registrazione:**
```javascript
// resources/js/chartjs-plugins.js
import annotationPlugin from 'chartjs-plugin-annotation';
window.filamentChartJsPlugins.push(annotationPlugin);
```

---

## 🧪 Testing

### Unit Test
```php
public function test_chart_returns_valid_data()
{
    $widget = new SalesChartWidget();
    $data = $widget->getData();

    $this->assertArrayHasKey('datasets', $data);
    $this->assertArrayHasKey('labels', $data);
    $this->assertNotEmpty($data['datasets']);
}
```

### Feature Test
```php
public function test_chart_export_works()
{
    Storage::fake('public');

    $action = app(ExportChartAction::class);
    $storedPath = $action->executeToPng($chartConfig);

    Storage::disk('public')->assertExists($storedPath);
}
```

---

## 🔗 Risorse External

### Documentazione Ufficiale
- [Filament Charts](https://filamentphp.com/docs/4.x/widgets/charts)
- [Chart.js Documentation](https://www.chartjs.org/docs/latest/)
- [Chart.js Samples](https://www.chartjs.org/docs/latest/samples/)
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)

### Chart.js Plugins
- [Annotation Plugin](https://www.chartjs.org/chartjs-plugin-annotation/latest/)
- [Zoom Plugin](https://www.chartjs.org/chartjs-plugin-zoom/latest/)
- [Awesome Chart.js](https://github.com/chartjs/awesome)

### Export Resources
- [QuickChart - Chart.js Export](https://quickchart.io/documentation/chart-js/image-export/)
- [chartjs-node-canvas](https://www.npmjs.com/package/chartjs-node-canvas)
- [Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)

---

## 📝 Checklist Implementazione

### Nuovo Chart Widget

- [ ] Creare widget con Artisan command
- [ ] Estendere `XotBaseChartWidget` o `ThemeOneChartWidget`
- [ ] Implementare `getType()` method
- [ ] Implementare `getData()` method con Laravel Trend
- [ ] Aggiungere caching per performance
- [ ] Implementare error handling
- [ ] Configurare lazy loading
- [ ] Disabilitare polling se non necessario
- [ ] Aggiungere PHPDoc types
- [ ] Testare con PHPStan Level 10

### Export Functionality

- [ ] Installare dipendenze Node.js (`chartjs-node-canvas`)
- [ ] Creare Node.js export script
- [ ] Implementare `ChartExportService`
- [ ] Creare `ExportChartAction` con QueueableAction
- [ ] Aggiungere header actions nel widget
- [ ] Configurare storage disk
- [ ] Implementare cleanup automatico vecchi file
- [ ] Testare export PNG
- [ ] Testare export SVG
- [ ] Documentare uso per il team

### Theme Styling

- [ ] Definire palette colori in config
- [ ] Creare base chart widget class per tema
- [ ] Implementare helper methods per styling
- [ ] Aggiungere CSS personalizzazioni
- [ ] Testare dark mode (se applicabile)
- [ ] Verificare responsive behavior
- [ ] Documentare pattern di styling

---

## 🎓 Training Materials

### Beginner
1. Leggi [Filament Charts Complete Guide](../Modules/Xot/docs/filament-charts-complete-guide.md)
2. Crea un semplice Line Chart con dati mock
3. Integra Laravel Trend per dati reali
4. Aggiungi filtri base

### Intermediate
1. Estendi `XotBaseChartWidget`
2. Implementa multi-dataset chart
3. Personalizza colori e stili
4. Aggiungi export PNG

### Advanced
1. Usa Theme-specific base classes
2. Integra Chart.js plugins
3. Implementa export SVG con QueueableAction
4. Crea scheduled exports
5. Genera PDF report con multipli chart
6. Ottimizza performance su large datasets

---

## 📞 Support

### Domande Frequenti
**Q:** Come posso cambiare i colori del chart?
**A:** Vedi sezione "Personalizzazione" in [Filament Charts Guide](../Modules/Xot/docs/filament-charts-complete-guide.md#personalizzazione) o usa Theme-specific classes.

**Q:** Export non funziona, cosa fare?
**A:** Verifica installazione Node.js dependencies e controlla [Chart Export Guide](../Modules/Xot/docs/chart-export-guide.md#troubleshooting).

**Q:** Come posso migliorare performance?
**A:** Implementa caching, limita range temporale, disabilita polling. Vedi [Best Practices](#performance).

### Issue Tracking
- Repository interno PTVX per bug reports
- Documentazione issues in `docs/issues/`

---

**Documentazione generata:** Dicembre 2025
**Framework:** Laraxot/PTVX v4.x
**Filament:** 4.x
**Chart.js:** 4.x
**PHPStan:** Level 10
**Maintainer:** PTVX Team
