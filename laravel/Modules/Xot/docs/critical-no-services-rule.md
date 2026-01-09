# Regola Critica: NO Services - Solo Spatie QueueableActions

**Data Creazione**: 2025-01-18
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
