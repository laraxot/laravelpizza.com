# Regola Critica: NO Services - Solo Spatie QueueableActions

**Data Creazione**: [DATE]
**Status**: Regola Fondamentale Laraxot
**Priorità**: CRITICA - Mai Violare

## 🚨 Regola Fondamentale

**NEL PROGETTO LARAXOT NON SI USANO MAI I SERVICES.**

**TUTTA la business logic deve essere implementata con Spatie QueueableActions.**

---

## ❌ COSA NON FARE MAI

### 1. Non Creare Service Classes

```php
// ❌ VIETATO - Non creare mai classi Service
namespace Modules\Quaeris\Services\Charts;

class ChartService
{
    public function generateChart(array $data): Chart
    {
        // MAI FARE QUESTO
    }
}
```

### 2. Non Iniettare Services

```php
// ❌ VIETATO - Non iniettare services
class ChartController extends Controller
{
    public function __construct(
        private ChartService $chartService  // MAI FARE QUESTO
    ) {}
}
```

### 3. Non Usare Pattern Service

```php
// ❌ VIETATO - Pattern Service tradizionale
class UserService
{
    public function createUser(array $data): User { }
    public function updateUser(User $user, array $data): User { }
    public function deleteUser(User $user): void { }
}
```

---

## ✅ COSA FARE SEMPRE

### 1. Usare Spatie QueueableActions

```php
// ✅ CORRETTO - Usa sempre Actions
namespace Modules\Quaeris\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;

class GenerateChartAction
{
    use QueueableAction;

    public function execute(array $data): Chart
    {
        // Business logic qui
        return Chart::create($data);
    }
}
```

### 2. Pattern Action per Ogni Operazione

```php
// ✅ CORRETTO - Una Action per ogni operazione
class CreateChartAction
{
    use QueueableAction;
    public function execute(array $data): Chart { }
}

class UpdateChartAction
{
    use QueueableAction;
    public function execute(Chart $chart, array $data): Chart { }
}

class DeleteChartAction
{
    use QueueableAction;
    public function execute(Chart $chart): void { }
}
```

### 3. Usare Actions Ovunque

```php
// ✅ CORRETTO - In Filament Resources
protected function handleRecordCreation(array $data): Model
{
    return app(CreateChartAction::class)->execute($data);
}

// ✅ CORRETTO - In Volt Components
public function save(): void
{
    $chart = app(CreateChartAction::class)->execute($this->data);
}

// ✅ CORRETTO - In Console Commands
public function handle(): void
{
    app(GenerateChartAction::class)->execute($data);
}
```

---

## 📋 Template Action Standard

```php
<?php

declare(strict_types=1);

namespace Modules\[Module]\Actions\[Subfolder];

use Spatie\QueueableAction\QueueableAction;

class [ActionName]Action
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @param  mixed  $param1  Descrizione parametro
     * @return mixed Tipo di ritorno
     */
    public function execute(mixed $param1): mixed
    {
        // Business logic qui
        return $result;
    }
}
```

---

## 🔄 Conversione da Service a Action

### Esempio: Service → Action

**❌ PRIMA (Service)**:
```php
namespace Modules\Quaeris\Services\Charts;

class ChartService
{
    public function generateChart(array $data): Chart
    {
        // Logica complessa
        $chart = Chart::create($data);
        $this->processChart($chart);
        return $chart;
    }

    private function processChart(Chart $chart): void
    {
        // Logica privata
    }
}
```

**✅ DOPO (Actions)**:
```php
// Modules/Quaeris/Actions/Chart/GenerateChartAction.php
namespace Modules\Quaeris\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Modules\Quaeris\Models\Chart;
use Modules\Quaeris\Actions\Chart\ProcessChartAction;

class GenerateChartAction
{
    use QueueableAction;

    public function execute(array $data): Chart
    {
        $chart = Chart::create($data);
        app(ProcessChartAction::class)->execute($chart);
        return $chart;
    }
}

// Modules/Quaeris/Actions/Chart/ProcessChartAction.php
namespace Modules\Quaeris\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Modules\Quaeris\Models\Chart;

class ProcessChartAction
{
    use QueueableAction;

    public function execute(Chart $chart): void
    {
        // Logica di processamento
    }
}
```

---

## 📚 Riferimenti

- [Action Pattern Guidelines](../.ai/guidelines/action-pattern.md)
- [Spatie QueueableAction Documentation](https://github.com/spatie/laravel-queueable-action)

---

## ⚠️ Checklist Pre-Commit

Prima di ogni commit, verifica:

- [ ] Non ho creato classi Service
- [ ] Non ho iniettato Services in costruttori
- [ ] Ho usato solo Spatie QueueableActions
- [ ] Ogni Action ha un solo metodo `execute()`
- [ ] Ogni Action usa il trait `QueueableAction`
- [ ] Le Actions sono organizzate in `app/Actions/`

---

**Filosofia**: Le Actions sono unità atomiche di business logic, riutilizzabili, testabili e queueable. I Services creano accoppiamento e violano il principio di responsabilità singola.

---

## 🎯 Caso Specifico: Filament Chart Widgets con Dati Demo

### Problema Comune

I Chart Widgets sperimentali spesso usano dati demo statici. **NON creare Services per centralizzare questi dati**.

### ❌ Pattern SBAGLIATO

```php
// ❌ MAI FARE - ChartService per dati demo
namespace Modules\Quaeris\Services;

class ChartService
{
    private const DEMO_DATA = [1250, 1380, 1520];

    public function getGrowthData(): array
    {
        return self::DEMO_DATA;
    }
}

// ❌ MAI FARE - Widget che dipende dal Service
class Simple02ChartWidget extends XotBaseChartWidget
{
    protected ChartService $chartService;

    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
        parent::__construct();
    }
}
```

### ✅ Pattern CORRETTO: Self-Contained Widget

```php
// ✅ CORRETTO - Widget completamente self-contained
namespace Modules\Quaeris\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class Simple02ChartWidget extends XotBaseChartWidget
{
    // Dati demo come costanti di classe
    private const MONTHLY_DATA = [1250, 1380, 1520, 1680];
    private const MONTH_LABELS = ['Gen', 'Feb', 'Mar', 'Apr'];

    protected function getData(): array
    {
        return [
            'datasets' => [['data' => self::MONTHLY_DATA]],
            'labels' => self::MONTH_LABELS,
        ];
    }

    // Metodi helper privati per logica specifica
    private function calculateGrowthPercentage(float $current, float $previous): float
    {
        return $previous === 0.0 ? 0.0 : (($current - $previous) / $previous) * 100;
    }
}
```

### Benefici Pattern Self-Contained

1. **No costruttori** → Evita problemi di hydration Livewire
2. **No dependency injection** → Nessuna complessità di autowiring
3. **Dati come costanti** → Immutabili e chiari
4. **Metodi privati** → Logica incapsulata nel widget
5. **Un file = una feature** → Facile da testare e mantenere

---

## 📅 Incidenti Risolti

### 28 Gennaio 2026 - ChartService Eliminato

**Problema**: `Modules\Quaeris\Services\ChartService` causava errori "Cannot call constructor" nei widget Simple05, Simple06, Simple11, Simple13, Simple20.

**Causa**:
- Il Service non era correttamente autoloadato da Composer
- I widget tentavano di istanziare il Service nel costruttore
- Alcuni metodi chiamati non esistevano nel Service

**Soluzione**:
1. Eliminato `ChartService.php`
2. Eliminata directory `app/Services/`
3. Refactored tutti i widget a pattern self-contained
4. Aggiornata documentazione

**File coinvolti**:
- `Simple02ChartWidget.php` → Self-contained
- `Simple05ChartWidget.php` → Self-contained
- `Simple06ChartWidget.php` → Self-contained
- `Simple11ChartWidget.php` → Self-contained
- `Simple13ChartWidget.php` → Self-contained
- `Simple20ChartWidget.php` → Self-contained
