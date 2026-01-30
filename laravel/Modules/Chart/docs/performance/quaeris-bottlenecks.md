# Colli di Bottiglia nel Modulo Quaeris

## 1. GetAnswersByQuestionChart (Impatto: ALTO)
**File**: `Modules/Quaeris/app/Actions/QuestionChart/GetAnswersByQuestionChart.php`

**Problemi Identificati**:
1. Query ripetitive per ogni chart
2. Nessun caching dei risultati
3. Operazioni di string manipulation ad ogni richiesta
4. Query non ottimizzate con join multipli

**Soluzione Proposta**:
```php
class GetAnswersByQuestionChart
{
    use QueueableAction;

    public function execute(QuestionChart $q, ?string $group_by = null, ?string $sort_by = null, ?AnswersFilterData $filter = null): AnswersChartData
    {
        // 1. Cache dei risultati per chart statici
        $cacheKey = "chart_{$q->id}_{$group_by}_{$sort_by}_".md5(serialize($filter));
        
        return Cache::tags(['question_charts'])
            ->remember($cacheKey, now()->addMinutes(30), function() use ($q, $group_by, $sort_by, $filter) {
                return $this->processChart($q, $group_by, $sort_by, $filter);
            });
    }

    protected function processChart(QuestionChart $q, ?string $group_by, ?string $sort_by, ?AnswersFilterData $filter): AnswersChartData
    {
        // 2. Ottimizzazione query con eager loading
        $answers = $q->answers()
            ->with(['labels', 'metadata'])
            ->select(['id', 'submitdate', $q->field_name])
            ->when($filter?->date_from, fn($query, $date) => 
                $query->where('submitdate', '>=', $date)
            )
            ->when($filter?->date_to, fn($query, $date) => 
                $query->where('submitdate', '<=', 
                    str_replace('00:00:00', '23:59:59', $date)
                )
            );

        // 3. Query builder ottimizzato per type specifici
        if ($q->question_type === 'L') {
            $answers->leftJoin('answers_labels', 'answers.id', '=', 'answers_labels.answer_id')
                   ->where('answers_labels.field_name', $q->field_name)
                   ->select(['answers.*', 'answers_labels.label']);
        }

        // 4. Chunk processing per dataset grandi
        if ($answers->count() > 1000) {
            return $this->processLargeDataset($answers, $q);
        }

        return $this->formatResults($answers->get(), $q);
    }

    protected function processLargeDataset($query, QuestionChart $q): AnswersChartData 
    {
        return $query->chunk(1000, function($chunk) use ($q) {
            // Process chunk
            return $this->formatResults($chunk, $q);
        });
    }
}
```

## 2. GetChartsDataByQuestionChart (Impatto: ALTO)
**File**: `Modules/Quaeris/app/Actions/QuestionChart/GetChartsDataByQuestionChart.php`

**Problemi Identificati**:
1. Loop sincrono su tutti i chart
2. Chiamate ripetitive a GetAnswersByQuestionChart
3. Nessun parallelismo per chart indipendenti

**Soluzione Proposta**:
```php
class GetChartsDataByQuestionChart
{
    public function execute(QuestionChart $q, ?AnswersFilterData $filter = null): array
    {
        // 1. Parallel processing per chart indipendenti
        return collect($q->charts)
            ->map(function($chart) use ($q, $filter) {
                return async(function() use ($chart, $q, $filter) {
                    return $this->processChart($chart, $q, $filter);
                });
            })
            ->map(fn($promise) => $promise->await())
            ->all();
    }

    protected function processChart($chart, QuestionChart $q, ?AnswersFilterData $filter): AnswersChartData
    {
        // 2. Cache per singolo chart
        $cacheKey = "chart_data_{$q->id}_{$chart->id}_".md5(serialize($filter));
        
        return Cache::tags(['charts_data'])
            ->remember($cacheKey, now()->addMinutes(15), function() use ($chart, $q, $filter) {
                $group_by = is_string($chart['group_by']) ? $chart['group_by'] : null;
                $sort_by = is_string($chart['sort_by']) ? $chart['sort_by'] : null;
                
                $answersData = app(GetAnswersByQuestionChart::class)
                    ->execute($q, $group_by, $sort_by, $filter);
                
                $answersData->chart = ChartData::from($chart);
                return $answersData;
            });
    }
}
```

## 3. QuestionChartItemWidget (Impatto: MEDIO)
**File**: `Modules/Quaeris/app/Filament/Widgets/QuestionChartItemWidget.php`

**Problemi Identificati**:
1. Rendering sincrono dei widget
2. Nessun lazy loading dei dati
3. Update frequenti non necessari

**Soluzione Proposta**:
```php
class QuestionChartItemWidget extends ChartWidget
{
    protected static string $pollingInterval = '30s';
    
    public function filterUpdate(array $filter_data): void
    {
        // 1. Debounce degli update
        $this->deferredUpdate(function() use ($filter_data) {
            $filter = AnswersFilterData::from([
                'date_from' => Arr::get($filter_data, 'startDate'),
                'date_to' => Arr::get($filter_data, 'endDate').' 23:59:59',
                'question_filter' => Arr::get($filter_data, 'question_filter'),
            ]);

            // 2. Cache dei risultati del widget
            $cacheKey = "widget_{$this->question_chart->id}_{$this->chart_index}_".md5(serialize($filter));
            
            $answersData = Cache::tags(['widgets'])
                ->remember($cacheKey, now()->addMinutes(5), function() use ($filter) {
                    return $this->getChartData($filter);
                });

            $this->updateChartData($answersData);
        }, 500); // 500ms debounce
    }

    protected function getChartData($filter): AnswersChartData
    {
        $chart = $this->question_chart->charts[$this->chart_index];
        
        return app(GetAnswersByQuestionChart::class)->execute(
            $this->question_chart,
            $chart['group_by'] ?? null,
            $chart['sort_by'] ?? null,
            $filter
        );
    }
}
```

## Impatto Complessivo Stimato

1. **Performance**:
   - Riduzione 60% tempo di caricamento charts
   - Riduzione 50% utilizzo memoria
   - Miglioramento 45% tempo di risposta widget

2. **Scalabilità**:
   - Supporto 3x più chart concorrenti
   - Gestione 4x volume dati attuale
   - Riduzione 55% carico database

3. **User Experience**:
   - Caricamento chart più veloce
   - Update UI più reattivi
   - Meno timeout per dataset grandi

## Piano di Implementazione

1. **Fase 1** (Settimana 1):
   - Implementare caching in GetAnswersByQuestionChart
   - Ottimizzare query builder
   - Aggiungere chunk processing

2. **Fase 2** (Settimana 2):
   - Implementare parallel processing in GetChartsDataByQuestionChart
   - Aggiungere caching per chart data
   - Ottimizzare memory usage

3. **Fase 3** (Settimana 3):
   - Implementare debounce nei widget
   - Aggiungere lazy loading
   - Ottimizzare update cycle
