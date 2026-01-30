# Filament Widget Best Practices

## ⚠️ REGOLA CRITICA: SEMPRE ESTENDERE CLASSI XOTBASE

### ❌ ERRORE GRAVE - MAI FARE
```php
// ❌ ERRORE GRAVE - MAI ESTENDERE DIRETTAMENTE FILAMENT
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Widget;

class MyWidget extends ChartWidget  // ERRORE GRAVE!
{
    // Implementazione...
}

class MyWidget extends Widget  // ERRORE GRAVE!
{
    // Implementazione...
}
```

### ✅ CORRETTO - SEMPRE USARE
```php
// ✅ CORRETTO - SEMPRE ESTENDERE XOTBASE
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyChartWidget extends XotBaseChartWidget  // CORRETTO!
{
    // Implementazione...
}

class MyStandardWidget extends XotBaseWidget  // CORRETTO!
{
    // Implementazione...
}
```

## Regole Critiche per Prevenire Errori di Tipizzazione

### 1. Estensione Corretta - REGOLA PRINCIPALE

#### ✅ CORRETTO - Estensione XotBase
```php
// Per ChartWidget
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class MyChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;  // SEMPRE bool, MAI ?bool
    protected static ?string $pollingInterval = '5m';
}

// Per Widget Standard
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyStandardWidget extends XotBaseWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '5m';
}
```

#### ❌ ERRORE GRAVE - Estensione Diretta Filament
```php
// ❌ ERRORE GRAVE - MAI FARE
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Widget;

class MyWidget extends ChartWidget  // ERRORE!
{
    // Implementazione...
}

class MyWidget extends Widget  // ERRORE!
{
    // Implementazione...
}
```

### 2. Proprietà Statiche Widget - Tipizzazione Obbligatoria

#### ✅ CORRETTO - Tipizzazione Esplicita
```php
class MyWidget extends XotBaseChartWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;  // SEMPRE bool, MAI ?bool
    protected static ?string $pollingInterval = '5m';
    protected static ?string $maxHeight = '400px';
}
```

#### ❌ ERRATO - Tipizzazione Nullable per isLazy
```php
class MyWidget extends XotBaseChartWidget
{
    protected static ?bool $isLazy = true;  // ERRORE: deve essere bool
    protected static ?string $heading = null;
}
```

### 3. Metodi Widget - Access Level Obbligatorio

#### ✅ CORRETTO - Metodi Public per Contratto
```php
/**
 * Restituisce il titolo del widget.
 * CRITICO: Deve essere public per rispettare il contratto ChartWidget
 */
public function getHeading(): ?string
{
    return __('modulename::widgets.widget_name.title');
}

/**
 * Restituisce i dati per il grafico.
 */
protected function getData(): array
{
    // Implementazione
}

/**
 * Restituisce il tipo di grafico.
 */
protected function getType(): string
{
    return 'line'; // o 'bar', 'pie', etc.
}
```

#### ❌ ERRATO - Metodi Protected per Contratto
```php
/**
 * ERRORE: Deve essere public per rispettare il contratto ChartWidget
 */
protected function getHeading(): ?string
{
    return __('modulename::widgets.widget_name.title');
}
```

### 4. Checklist Pre-Implementazione

Prima di creare qualsiasi widget, verificare:

- [ ] **Strict Types**: `declare(strict_types=1);` all'inizio del file
- [ ] **Namespace**: `Modules\{ModuleName}\Filament\Widgets`
- [ ] **Estensione XotBase**: `extends XotBaseChartWidget` o `extends XotBaseWidget` (MAI Filament diretto)
- [ ] **Import Corretto**: `use Modules\Xot\Filament\Widgets\XotBaseChartWidget;`
- [ ] **Proprietà isLazy**: `protected static bool $isLazy = true;` (MAI `?bool`)
- [ ] **Metodo getHeading**: `public function getHeading(): ?string`
- [ ] **Tipizzazione**: Tutti i metodi hanno tipi di ritorno espliciti
- [ ] **PHPDoc**: Documentazione completa per tutte le classi e metodi

### 5. Template Widget Standard

```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Widget per visualizzare [descrizione widget].
 *
 * Mostra [tipo di dati] con [caratteristiche specifiche].
 * I dati sono cacheati per 5 minuti per ottimizzare le performance.
 */
class MyWidget extends XotBaseChartWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '5m';

    /**
     * Restituisce il titolo del widget.
     * 
     * CRITICO: Deve essere public per rispettare il contratto ChartWidget
     */
    public function getHeading(): ?string
    {
        return __('modulename::widgets.widget_name.title');
    }

    /**
     * Restituisce i dati per il grafico.
     *
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $cacheKey = 'modulename:dashboard:widget:widget_name';
        
        return Cache::remember($cacheKey, 300, function () {
            // Implementazione query e formattazione dati
            return [
                'datasets' => [
                    [
                        'label' => __('modulename::widgets.widget_name.label'),
                        'data' => $data,
                        'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        'borderColor' => 'rgb(59, 130, 246)',
                        'borderWidth' => 2,
                    ],
                ],
                'labels' => $labels,
            ];
        });
    }

    /**
     * Restituisce il tipo di grafico.
     */
    protected function getType(): string
    {
        return 'line'; // o 'bar', 'pie', etc.
    }

    /**
     * Restituisce le opzioni del grafico.
     *
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
        ];
    }

    /**
     * Restituisce l'altezza del widget.
     */
    protected function getHeight(): ?string
    {
        return '400px';
    }
}
```

### 6. Errori Comuni e Soluzioni

#### Errore: "Type must be bool (as in class Widget)"
**Causa**: `protected static ?bool $isLazy = true;`
**Soluzione**: Cambiare in `protected static bool $isLazy = true;`

#### Errore: "Access level must be public"
**Causa**: `protected function getHeading(): ?string`
**Soluzione**: Cambiare in `public function getHeading(): ?string`

#### Errore: "Class not found"
**Causa**: Estendere direttamente `Filament\Widgets\ChartWidget`
**Soluzione**: Estendere `Modules\Xot\Filament\Widgets\XotBaseChartWidget`

#### Errore: "Method not found"
**Causa**: Metodo non implementato o nome errato
**Soluzione**: Implementare tutti i metodi richiesti dal contratto

### 7. Validazione Automatica

Eseguire sempre questi controlli prima del commit:

```bash

# Controllo estensione XotBase (CRITICO)
grep -r "extends ChartWidget" laravel/Modules/*/app/Filament/Widgets/
grep -r "extends Widget" laravel/Modules/*/app/Filament/Widgets/

# Controllo tipizzazione isLazy
grep -r "protected static \?\?bool \$isLazy" laravel/Modules/*/app/Filament/Widgets/

# Controllo access level getHeading
grep -r "protected function getHeading" laravel/Modules/*/app/Filament/Widgets/

# Controllo strict types
grep -L "declare(strict_types=1);" laravel/Modules/*/app/Filament/Widgets/*.php
```

### 8. Convenzioni Naming

- **Classi Widget**: `{Entity}{Action}Widget` (es. `PatientRegistrationTrendWidget`)
- **File Widget**: `{Entity}{Action}Widget.php`
- **Chiavi Traduzione**: `{entity}_{action}_widget` (es. `patient_registration_trend`)
- **Cache Keys**: `{modulename}:dashboard:widget:{widget_name}`

### 9. Performance e Caching

- **Cache TTL**: 300 secondi (5 minuti) per tutti i widget
- **Lazy Loading**: Abilitato per tutti i widget
- **Polling**: 5 minuti per aggiornamenti automatici
- **Error Handling**: Try-catch con fallback appropriato

### 10. Traduzioni

- **Struttura Espansa**: Sempre utilizzare struttura espansa per traduzioni
- **Tre Lingue**: Italiano, Inglese, Tedesco
- **Chiavi Descrittive**: Nomi chiavi chiari e descrittivi

### 11. Documentazione

- **PHPDoc**: Documentazione completa per tutte le classi
- **Commenti**: Commenti appropriati per logica complessa
- **README**: Documentazione aggiornata nel modulo

### 12. Import Corretti

#### ✅ CORRETTO - Import XotBase
```php
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
```

#### ❌ ERRATO - Import Filament Diretto
```php
use Filament\Widgets\ChartWidget;  // ERRORE!
use Filament\Widgets\Widget;       // ERRORE!
```

---

**Ultimo aggiornamento**: Dicembre 2024
**Versione**: 2.0
**Stato**: ✅ Attivo
