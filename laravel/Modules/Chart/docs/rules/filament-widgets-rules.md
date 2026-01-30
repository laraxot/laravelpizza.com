# Filament Widgets Rules

## REGOLA CRITICA FONDAMENTALE - ESTENSIONE CLASSI

### ⚠️ REGOLA CRITICA: SEMPRE ESTENDERE CLASSI XOTBASE
**MAI estendere direttamente le classi Filament! SEMPRE usare le classi XotBase!**

### ⚠️ REGOLA CRITICA: TRAIT FILAMENT SI USANO DIRETTAMENTE
**I trait di Filament si utilizzano direttamente, non attraverso classi XotBase!**

```php
// ❌ SBAGLIATO - MAI fare questo!
use Filament\Widgets\ChartWidget;
class MyWidget extends ChartWidget

// ✅ CORRETTO - SEMPRE fare questo!
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
class MyWidget extends XotBaseChartWidget
{
    // ✅ CORRETTO - I trait Filament si usano direttamente
    use Filament\Widgets\Concerns\InteractsWithPageFilters;
    use Filament\Forms\Concerns\InteractsWithForms;
}
```

### Mappatura Classi Filament → XotBase
```php
// Widgets
Filament\Widgets\ChartWidget → Modules\Xot\Filament\Widgets\XotBaseChartWidget
Filament\Widgets\StatsOverviewWidget → Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget
Filament\Widgets\TableWidget → Modules\Xot\Filament\Widgets\XotBaseTableWidget

// Resources
Filament\Resources\Resource → Modules\Xot\Filament\Resources\XotBaseResource

// Pages
Filament\Pages\Page → Modules\Xot\Filament\Pages\XotBasePage
Filament\Pages\Dashboard → Modules\Xot\Filament\Pages\XotBaseDashboard
```

### ⚠️ PENALITÀ GRAVE PER VIOLAZIONI
- **Prima violazione**: Correzione immediata + studio approfondito della struttura Xot
- **Seconda violazione**: Rivedere completamente tutte le regole + test completo
- **Terza violazione**: Implementazione obbligatoria di checklist pre-implementazione

## Regole Critiche per Widget Filament

### 1. Tipi di Proprietà - REGOLA CRITICA
**MAI modificare i tipi delle proprietà ereditate da Filament Widgets!**

```php
// ❌ SBAGLIATO - Non modificare il tipo
protected static ?bool $isLazy = true;

// ✅ CORRETTO - Usa il tipo esatto della classe base
protected static bool $isLazy = true;
```

**Proprietà che DEVONO mantenere il tipo esatto:**
- `protected static bool $isLazy` (non `?bool`)
- `protected static ?string $heading` (può rimanere nullable)
- `protected static ?int $sort` (può rimanere nullable)
- `protected static ?string $pollingInterval` (può rimanere nullable)

### 2. Metodi Override - REGOLA CRITICA
**I metodi override DEVONO mantenere la stessa visibilità e firma della classe base:**

```php
// ❌ SBAGLIATO - Cambio di visibilità
protected function getHeading(): ?string
protected function getHeaderWidgets(): array
protected function getFooterWidgets(): array

// ✅ CORRETTO - Stessa visibilità della classe base
public function getHeading(): ?string
public function getHeaderWidgets(): array
public function getFooterWidgets(): array
public function getWidgets(): array
```

### 3. ChartWidget Pattern Standard
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget; // ⚠️ SEMPRE XotBase
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Modules\ModuleName\Models\ModelName;

class ModelNameChart extends XotBaseChartWidget // ⚠️ SEMPRE XotBase
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true; // ⚠️ SEMPRE bool, mai ?bool
    protected static ?string $pollingInterval = '300s';

    public function getHeading(): ?string // ⚠️ SEMPRE public, mai protected
    {
        return __('modulename::widgets.chart.title');
    }

    protected function getData(): array
    {
        try {
            $data = Trend::model(ModelName::class)
                ->between(
                    start: now()->subDays(30),
                    end: now(),
                )
                ->perDay()
                ->count();

            return [
                'datasets' => [
                    [
                        'label' => __('modulename::widgets.chart.label'),
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                        'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                        'borderColor' => 'rgb(59, 130, 246)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => \Carbon\Carbon::parse($value->date)->format('d/m')),
            ];
        } catch (\Exception $e) {
            // Fallback appropriato senza logging inutile
            return [
                'datasets' => [
                    [
                        'label' => __('modulename::widgets.chart.label'),
                        'data' => [],
                        'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                        'borderColor' => 'rgb(59, 130, 246)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                    ],
                ],
                'labels' => [],
            ];
        }
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

### 4. Checklist Pre-Implementazione OBBLIGATORIA
Prima di implementare qualsiasi widget Filament:

- [ ] **CRITICO**: Verificare che estenda la classe XotBase corretta
- [ ] **CRITICO**: Usare `Modules\Xot\Filament\Widgets\XotBaseChartWidget` (non `Filament\Widgets\ChartWidget`)
- [ ] **CRITICO**: I trait Filament si usano direttamente (non attraverso XotBase)
- [ ] Verificare i tipi delle proprietà nella classe base Filament
- [ ] Usare esattamente gli stessi tipi (bool, non ?bool)
- [ ] **CRITICO**: Mantenere la stessa visibilità dei metodi (public/protected)
- [ ] **CRITICO**: Metodi Dashboard devono essere public (`getHeaderWidgets`, `getFooterWidgets`, `getWidgets`)
- [ ] Implementare try-catch per error handling
- [ ] Aggiungere fallback graceful senza logging
- [ ] Usare traduzioni corrette
- [ ] **CRITICO**: Con Trend, usare `\Carbon\Carbon::parse($value->date)` per le date
- [ ] Testare il widget dopo l'implementazione

### 5. Errori Comuni da Evitare

#### ❌ Errori di Estensione Classe
```php
// SBAGLIATO - MAI estendere direttamente Filament
use Filament\Widgets\ChartWidget;
class MyWidget extends ChartWidget

// CORRETTO - SEMPRE estendere XotBase
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
class MyWidget extends XotBaseChartWidget
```

#### ❌ Errori di Utilizzo Trait
```php
// SBAGLIATO - Non usare trait che non esistono
use Modules\Xot\Filament\Widgets\InteractsWithPageFilters; // ❌ Non esiste

// CORRETTO - Usare trait Filament direttamente
use Filament\Widgets\Concerns\InteractsWithPageFilters; // ✅ Esiste
```

#### ❌ Errori di Tipo
```php
// SBAGLIATO
protected static ?bool $isLazy = true;  // Dovrebbe essere bool
protected static string $heading = '';  // Dovrebbe essere ?string
```

#### ❌ Errori di Visibilità
```php
// SBAGLIATO
protected function getHeading(): ?string  // Dovrebbe essere public
private function getData(): array        // Dovrebbe essere protected
protected function getHeaderWidgets(): array  // Dovrebbe essere public
protected function getFooterWidgets(): array  // Dovrebbe essere public
protected function getWidgets(): array       // Dovrebbe essere public
```

#### ❌ Errori di Gestione Errori
```php
// SBAGLIATO
} catch (\Exception $e) {
    Log::error('Widget error: ' . $e->getMessage());  // Logging inutile
    return [];  // Fallback incompleto
}

// CORRETTO
} catch (\Exception $e) {
    // Fallback appropriato senza logging inutile
    return [
        'datasets' => [
            [
                'label' => __('widget.label'),
                'data' => [],
                'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                'borderColor' => 'rgb(59, 130, 246)',
            ],
        ],
        'labels' => [],
    ];
}
```

#### ❌ Errori di Gestione Date con Trend
```php
// SBAGLIATO - $value->date è una stringa, non Carbon
'labels' => $data->map(fn (TrendValue $value) => $value->date->format('d/m')),

// CORRETTO - Parsing esplicito della stringa
'labels' => $data->map(fn (TrendValue $value) => \Carbon\Carbon::parse($value->date)->format('d/m')),
```

### 6. Penalità per Violazioni
- **Prima violazione**: Correzione immediata + documentazione dell'errore
- **Seconda violazione**: Studio approfondito della classe base + test completo
- **Terza violazione**: Rivedere completamente le regole e implementare checklist obbligatoria
- **Violazione Estensione Classe**: Penalità GRAVE - correzione immediata + studio struttura Xot

### 7. Test Post-Implementazione
Dopo ogni implementazione di widget:

1. **CRITICO**: Verificare che estenda la classe XotBase corretta
2. Verificare che non ci siano errori di tipo
3. Testare il caricamento del widget
4. Verificare che i dati vengano visualizzati correttamente
5. Testare il fallback in caso di errori
6. Verificare che le traduzioni funzionino

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 3.0
**Autore**: AI Assistant
**Stato**: Regole Critiche Aggiornate con Estensione Classi XotBase 