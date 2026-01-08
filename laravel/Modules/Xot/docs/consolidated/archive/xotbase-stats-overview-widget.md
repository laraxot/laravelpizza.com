# XotBaseStatsOverviewWidget

## Panoramica

`XotBaseStatsOverviewWidget` è la classe base per tutti i widget di statistiche overview nel sistema Xot. Estende `Filament\Widgets\StatsOverviewWidget` e fornisce funzionalità comuni e metodi helper avanzati per la creazione di statistiche.

## Caratteristiche

### Estensione Base
```php
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

class MyStatsWidget extends XotBaseStatsOverviewWidget
{
    // Implementazione...
}
```

### Proprietà Predefinite
- `$pollingInterval = '5m'` - Aggiornamento automatico ogni 5 minuti
- `$isLazy = true` - Caricamento lazy per ottimizzare le performance
- `$sort = 1` - Ordinamento nella dashboard
- `$defaultCacheTtl = 300` - TTL predefinito per la cache (5 minuti)

### Trait Inclusi
- `TransTrait` - Per la gestione delle traduzioni

## Metodi Principali

### getStats()
```php
protected function getStats(): array
{
    return [
        $this->createStat('Utenti Totali', '1,234'),
        $this->createStatWithCalculatedTrend('Nuovi Utenti', 56, 45),
        $this->createStatFromQuery('Articoli', 'articles'),
        $this->createStatWithUrl('Vedi Tutti', '1,234', '/admin/users'),
    ];
}
```

## Metodi Helper Base

### createStat()
Crea una statistica standard:
```php
protected function createStat(
    string $label,
    string $value,
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

### createStatWithTrend()
Crea una statistica con trend:
```php
protected function createStatWithTrend(
    string $label,
    string $value,
    string $trend,
    string $trendIcon = 'heroicon-m-arrow-trending-up',
    string $trendColor = 'success',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

### createStatWithChart()
Crea una statistica con grafico:
```php
protected function createStatWithChart(
    string $label,
    string $value,
    array $chartData,
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

## Metodi Helper Avanzati

### Calcolo Trend Automatico

#### calculateTrend()
Calcola automaticamente il trend percentuale:
```php
protected function calculateTrend(
    float $currentValue,
    float $previousValue,
    int $decimals = 1
): array
```

**Risultato**:
```php
[
    'trend' => '+12.5%',
    'icon' => 'heroicon-m-arrow-trending-up',
    'color' => 'success'
]
```

#### createStatWithCalculatedTrend()
Crea statistica con trend calcolato automaticamente:
```php
protected function createStatWithCalculatedTrend(
    string $label,
    float $currentValue,
    float $previousValue,
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info',
    int $decimals = 1
): Stat
```

### Formattazione Numeri

#### formatNumber()
Formatta numeri con separatori delle migliaia:
```php
protected function formatNumber(float|int $number, int $decimals = 0): string
// Esempio: 1234.56 -> "1.234,56"
```

#### formatPercentage()
Formatta numeri come percentuali:
```php
protected function formatPercentage(float $number, int $decimals = 1): string
// Esempio: 0.15 -> "15.0%"
```

#### formatCurrency()
Formatta numeri come valuta:
```php
protected function formatCurrency(float $amount, string $currency = '€', int $decimals = 2): string
// Esempio: 1234.56 -> "1.234,56 €"
```

### Statistiche Interattive

#### createStatWithUrl()
Crea statistica con URL di navigazione:
```php
protected function createStatWithUrl(
    string $label,
    string $value,
    string $url,
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

#### createStatWithAction()
Crea statistica con azione personalizzata:
```php
protected function createStatWithAction(
    string $label,
    string $value,
    Action $action,
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

#### createStatWithBadge()
Crea statistica con badge:
```php
protected function createStatWithBadge(
    string $label,
    string $value,
    string $badge,
    string $badgeColor = 'info',
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

### Statistiche Comparative

#### createComparativeStat()
Crea statistica comparativa tra due periodi:
```php
protected function createComparativeStat(
    string $label,
    float $currentValue,
    float $previousValue,
    string $currentPeriod,
    string $previousPeriod,
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

### Gestione Errori

#### createStatWithErrorHandling()
Crea statistica con gestione errori:
```php
protected function createStatWithErrorHandling(
    string $label,
    callable $valueCallback,
    string $fallbackValue = '0',
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

### Query Database

#### createStatFromQuery()
Crea statistica da query COUNT:
```php
protected function createStatFromQuery(
    string $label,
    string $table,
    string $column = '*',
    array $conditions = [],
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

#### createStatFromAggregateQuery()
Crea statistica da query di aggregazione:
```php
protected function createStatFromAggregateQuery(
    string $label,
    string $table,
    string $aggregateFunction, // sum, avg, max, min
    string $column,
    array $conditions = [],
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info',
    int $decimals = 0
): Stat
```

#### createStatWithTrendFromQuery()
Crea statistica con trend da query database:
```php
protected function createStatWithTrendFromQuery(
    string $label,
    string $table,
    string $dateColumn,
    Carbon $currentPeriod,
    Carbon $previousPeriod,
    array $conditions = [],
    string $description = '',
    string $icon = 'heroicon-m-information-circle',
    string $color = 'info'
): Stat
```

### Gestione Cache

#### getCachedData()
Ottiene dati cacheati con gestione errori:
```php
protected function getCachedData(string $cacheKey, int $ttl, callable $callback)
```

#### getCachedDataWithDefaultTtl()
Ottiene dati cacheati con TTL predefinito:
```php
protected function getCachedDataWithDefaultTtl(string $cacheKey, callable $callback)
```

## Esempio di Implementazione Avanzata

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MyAdvancedStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '2m';

    protected function getStats(): array
    {
        $cacheKey = 'mymodule:dashboard:advanced_stats_overview';
        
        return $this->getCachedDataWithDefaultTtl($cacheKey, function () {
            $currentMonth = Carbon::now()->startOfMonth();
            $previousMonth = Carbon::now()->subMonth()->startOfMonth();
            
            return [
                // Statistica base con formattazione
                $this->createStat(
                    'Utenti Totali',
                    $this->formatNumber(DB::table('users')->count()),
                    'Tutti gli utenti registrati',
                    'heroicon-m-users',
                    'success'
                ),
                
                // Statistica con trend calcolato automaticamente
                $this->createStatWithCalculatedTrend(
                    'Nuovi Utenti',
                    DB::table('users')->where('created_at', '>=', $currentMonth)->count(),
                    DB::table('users')->where('created_at', '>=', $previousMonth)->count(),
                    'heroicon-m-user-plus',
                    'info'
                ),
                
                // Statistica da query con condizioni
                $this->createStatFromQuery(
                    'Utenti Attivi',
                    'users',
                    '*',
                    ['status' => 'active'],
                    'Utenti con stato attivo',
                    'heroicon-m-check-circle',
                    'success'
                ),
                
                // Statistica con aggregazione
                $this->createStatFromAggregateQuery(
                    'Valore Medio Ordini',
                    'orders',
                    'avg',
                    'total_amount',
                    ['status' => 'completed'],
                    'Valore medio degli ordini completati',
                    'heroicon-m-currency-euro',
                    'warning',
                    2
                ),
                
                // Statistica con URL
                $this->createStatWithUrl(
                    'Vedi Tutti gli Utenti',
                    $this->formatNumber(DB::table('users')->count()),
                    '/admin/users',
                    'Clicca per visualizzare tutti gli utenti',
                    'heroicon-m-arrow-right',
                    'primary'
                ),
                
                // Statistica con badge
                $this->createStatWithBadge(
                    'Ordini in Attesa',
                    $this->formatNumber(DB::table('orders')->where('status', 'pending')->count()),
                    'Nuovo',
                    'warning',
                    'Ordini che richiedono attenzione',
                    'heroicon-m-clock',
                    'warning'
                ),
                
                // Statistica con trend da query
                $this->createStatWithTrendFromQuery(
                    'Vendite Mensili',
                    'orders',
                    'created_at',
                    $currentMonth,
                    $previousMonth,
                    ['status' => 'completed'],
                    'Confronto vendite mese corrente vs precedente',
                    'heroicon-m-chart-bar',
                    'primary'
                ),
            ];
        });
    }

    public function getHeading(): ?string
    {
        return __('mymodule::widgets.advanced_stats_overview.title');
    }

    public static function canView(): bool
    {
        return auth()->user()->can('view_advanced_stats');
    }
}
```

## Esempio con Gestione Errori

```php
protected function getStats(): array
{
    return [
        // Statistica con gestione errori
        $this->createStatWithErrorHandling(
            'Dati Complessi',
            function () {
                // Query complessa che potrebbe fallire
                return DB::table('complex_table')
                    ->join('another_table', 'complex_table.id', '=', 'another_table.complex_id')
                    ->where('status', 'active')
                    ->sum('amount');
            },
            '0',
            'Dati calcolati in tempo reale',
            'heroicon-m-calculator',
            'info'
        ),
        
        // Statistica con azione personalizzata
        $this->createStatWithAction(
            'Esporta Dati',
            '1,234',
            Action::make('export')
                ->label('Esporta CSV')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(function () {
                    // Logica di esportazione
                }),
            'Clicca per esportare i dati',
            'heroicon-m-document-arrow-down',
            'secondary'
        ),
    ];
}
```

## Colori Disponibili

- `'success'` - Verde
- `'danger'` - Rosso
- `'warning'` - Giallo
- `'info'` - Blu
- `'primary'` - Blu primario
- `'secondary'` - Grigio

## Icone Heroicon

### Icone Generali
- `'heroicon-m-information-circle'` - Informazioni
- `'heroicon-m-users'` - Utenti
- `'heroicon-m-user-plus'` - Nuovo utente
- `'heroicon-m-chart-bar'` - Grafico
- `'heroicon-m-currency-euro'` - Valuta
- `'heroicon-m-check-circle'` - Verificato
- `'heroicon-m-clock'` - Orologio
- `'heroicon-m-calculator'` - Calcolatrice
- `'heroicon-m-document-arrow-down'` - Download documento

### Icone Trend
- `'heroicon-m-arrow-trending-up'` - Trend positivo
- `'heroicon-m-arrow-trending-down'` - Trend negativo
- `'heroicon-m-arrow-up'` - Freccia su
- `'heroicon-m-arrow-down'` - Freccia giù
- `'heroicon-m-minus'` - Nessun cambiamento

## Best Practices

### 1. Utilizzare il Caching
```php
return $this->getCachedDataWithDefaultTtl('cache_key', function () {
    // Query costose qui
});
```

### 2. Formattare i Numeri
```php
$this->createStat('Utenti', $this->formatNumber($count))
$this->createStat('Percentuale', $this->formatPercentage($ratio))
$this->createStat('Valore', $this->formatCurrency($amount))
```

### 3. Gestire gli Errori
```php
$this->createStatWithErrorHandling('Dati', function () {
    // Query che potrebbe fallire
}, '0', 'Descrizione', 'heroicon-m-exclamation-triangle', 'danger')
```

### 4. Utilizzare Trend Automatici
```php
$this->createStatWithCalculatedTrend('Metrica', $current, $previous)
```

### 5. Query Database Ottimizzate
```php
$this->createStatFromQuery('Conteggio', 'table', '*', ['status' => 'active'])
$this->createStatFromAggregateQuery('Media', 'table', 'avg', 'column')
```

### 6. Statistiche Interattive
```php
$this->createStatWithUrl('Vedi Tutti', $count, '/admin/resource')
$this->createStatWithBadge('Nuovi', $count, 'Nuovo', 'warning')
```

### 7. Implementare Autorizzazioni
```php
public static function canView(): bool
{
    return auth()->user()->can('view_stats');
}
```

### 8. Personalizzare l'Intervallo di Polling
```php
protected static ?string $pollingInterval = '2m'; // Per dati che cambiano spesso
```

## Miglioramenti Implementati

### ✅ Nuove Funzionalità
- **Calcolo trend automatico** con `calculateTrend()` e `createStatWithCalculatedTrend()`
- **Formattazione numeri** con `formatNumber()`, `formatPercentage()`, `formatCurrency()`
- **Statistiche interattive** con URL, azioni e badge
- **Gestione errori** con `createStatWithErrorHandling()`
- **Query database ottimizzate** con metodi dedicati
- **Statistiche comparative** con `createComparativeStat()`
- **Cache migliorata** con gestione errori e TTL predefinito

### ✅ Miglioramenti Performance
- **Gestione errori cache** con fallback automatico
- **Query ottimizzate** con metodi dedicati
- **Formattazione automatica** per ridurre codice duplicato

### ✅ Miglioramenti UX
- **Statistiche interattive** con navigazione e azioni
- **Badge informativi** per evidenziare stati
- **Trend automatici** per analisi immediate
- **Formattazione consistente** dei numeri

## Collegamenti Correlati
- [XotBaseChartWidget](./xotbase-chart-widget.md)
- [XotBaseWidget](./xotbase-widget.md)
- [Filament Widgets Documentation](https://filamentphp.com/project_docs/2.x/admin/widgets) 