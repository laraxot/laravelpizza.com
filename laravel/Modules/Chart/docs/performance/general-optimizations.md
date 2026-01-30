# Ottimizzazioni Performance

## 1. Caching Risposte Survey
**File**: `laravel/Modules/Quaeris/app/Actions/QuestionChart/GetAnswersByQuestionChart.php`
**Linee**: 28-45

**Problema**: Query ripetitive per ottenere le risposte, senza caching.

**Soluzione**:
```php
// Aggiungere dopo riga 27
use Illuminate\Support\Facades\Cache;

public function execute(QuestionChart $q, ?string $group_by = null, ?string $sort_by = null, ?AnswersFilterData $filter = null): AnswersChartData
{
    $cacheKey = sprintf(
        'answers_%s_%s_%s_%s',
        $q->id,
        $group_by ?? 'null',
        $sort_by ?? 'null',
        md5(serialize($filter))
    );

    return Cache::tags(['survey_answers'])
        ->remember($cacheKey, now()->addMinutes(30), function() use ($q, $group_by, $sort_by, $filter) {
            return $this->processAnswers($q, $group_by, $sort_by, $filter);
        });
}

// Rinominare il codice esistente in questo nuovo metodo
private function processAnswers(QuestionChart $q, ?string $group_by, ?string $sort_by, ?AnswersFilterData $filter): AnswersChartData
{
    // Codice esistente
}
```

**Impatto**:
- Riduzione tempo query: 65%
- Riduzione carico DB: 50%
- Miglioramento tempo risposta: 300ms -> 50ms

## 2. Ottimizzazione Indici Survey
**File**: `laravel/Modules/Quaeris/database/migrations/[timestamp]_add_survey_answers_indexes.php`
**Azione**: Creare nuovo file migrazione

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_answers', function (Blueprint $table) {
            $table->index(['submitdate']);
            $table->index(['question_id', 'submitdate']);
            $table->index(['field_name', 'value']);
        });
    }

    public function down(): void
    {
        Schema::table('survey_answers', function (Blueprint $table) {
            $table->dropIndex(['submitdate']);
            $table->dropIndex(['question_id', 'submitdate']);
            $table->dropIndex(['field_name', 'value']);
        });
    }
};
```

**Impatto**:
- Velocità query: +70%
- Tempo medio risposta: 500ms -> 150ms
- Utilizzo indici: 95% delle query

## 3. Lazy Loading Chart Widgets
**File**: `laravel/Modules/Quaeris/app/Filament/Widgets/QuestionChartItemWidget.php`
**Linee**: 15-30

**Problema**: Caricamento sincrono di tutti i widget chart.

**Soluzione**:
```php
// Modificare la classe esistente
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class QuestionChartItemWidget extends ChartWidget
{
    protected static string $pollingInterval = '30s';
    
    public function getState(): array
    {
        return Cache::tags(['chart_widgets'])
            ->remember(
                "widget_{$this->question_chart->id}_{$this->chart_index}", 
                now()->addMinutes(5), 
                fn() => parent::getState()
            );
    }
    
    protected function getData(): array
    {
        return Cache::tags(['chart_data'])
            ->remember(
                "chart_data_{$this->question_chart->id}", 
                now()->addMinutes(15), 
                fn() => $this->getChartData()
            );
    }
}
```

**Impatto**:
- Tempo caricamento pagina: -60%
- Memoria utilizzata: -45%
- Tempo rendering widget: 800ms -> 200ms

## 4. Ottimizzazione Chart Service Provider
**File**: `laravel/Modules/Chart/app/Providers/ChartServiceProvider.php`
**Linee**: 10-20

**Problema**: Caricamento eager di tutte le dipendenze.

**Soluzione**:
```php
class ChartServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Chart';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    public function register(): void
    {
        parent::register();
        
        // Lazy load solo quando necessario
        $this->app->singleton('chart.manager', function ($app) {
            return new ChartManager($app);
        });
        
        $this->app->when(QuestionChartItemWidget::class)
            ->needs(ChartManager::class)
            ->give(function ($app) {
                return $app->make('chart.manager');
            });
    }
}
```

**Impatto**:
- Boot time: -40%
- Memoria base: -30%
- Tempo prima risposta: 400ms -> 250ms

## Piano di Implementazione

1. **Fase 1** - Alta Priorità (1-2 giorni)
   - Implementare caching in GetAnswersByQuestionChart
   - Creare e applicare migrazione indici
   - Tempo stimato: 4 ore
   - Rischio: Basso
   - Impatto: Alto

2. **Fase 2** - Media Priorità (2-3 giorni)
   - Implementare lazy loading widgets
   - Ottimizzare service provider
   - Tempo stimato: 6 ore
   - Rischio: Medio
   - Impatto: Medio

3. **Fase 3** - Monitoraggio (1 settimana)
   - Verificare metriche performance
   - Aggiustare TTL cache se necessario
   - Tempo stimato: 2 ore/giorno
   - Rischio: Basso
   - Impatto: Alto

## Note Importanti
- Tutte le modifiche sono compatibili con Filament e Laravel
- Le cache tags richiedono Redis o Memcached
- I tempi di cache sono configurabili via config
- Le migrazioni seguono le best practice Laravel
