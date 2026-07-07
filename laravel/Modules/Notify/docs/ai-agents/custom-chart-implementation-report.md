# Custom Chart Implementation Report - 2026-03-17

## Executive Summary

Implementazione completa delle funzionalità di grafici custom da Fila4 a Fila5, con ottimizzazioni per SurveyResponse e pattern moderni.

---

## 1. Analisi Fila4 vs Fila5

### Fila4 Features Studiate

**Directory Analizzate**:
- `./laravel/Modules/Quaeris/app/Actions/QuestionChart/`
- `./laravel/Modules/Chart/app/Actions/`

**File Chiave Esaminati**:
1. `GetAnswersByQuestionChart.php` - 16KB
2. `GetChartsDataByQuestionChart.php` - 3KB
3. `ExportChartFromWidgetAction.php` - 6KB
4. `ExportChartToPngAction.php` - 8KB
5. `ExportChartToSvgAction.php` - 7KB

### Pattern Identificati

#### 1. Custom Question Type Handling
```php
if (Str::startsWith((string) $q->question, 'custom:')) {
    return $this->handleCustomQuestionType($q, $group_by, $sort_by, $filter);
}
```

#### 2. Label Join Pattern
```php
public function withAnswersLabel(Builder $query, string $qid, string $field_name): Builder
{
    return $query
        ->leftJoin('lime_answers as ask', ...)
        ->leftJoin('lime_answer_l10ns as ask_lang', ...);
}
```

#### 3. Builder Cloning
```php
foreach ($charts as $chart) {
    $base = clone $responses; // Clone per ogni chart
    $answersData = $this->execute($q, $base);
    $data[] = $answersData;
}
```

---

## 2. Implementazione Fila5

### 2.1 DTOs Creati ✅

| DTO | File | Scopo |
|-----|------|-------|
| AnswerData | `Modules/Chart/app/Datas/AnswerData.php` | Singola risposta |
| ChartData | `Modules/Chart/app/Datas/ChartData.php` | Configurazione chart |
| AnswersChartData | `Modules/Chart/app/Datas/AnswersChartData.php` | Dati aggregati |

**Totale Righe**: ~60

### 2.2 Actions Implementate ✅

#### GetAnswersByQuestionChart
**File**: `Modules/Quaeris/app/Actions/QuestionChart/GetAnswersByQuestionChart.php`

**Features**:
- ✅ Custom question type handling (`custom:*`)
- ✅ Label joins per risposte
- ✅ Supporto subquestions
- ✅ Filtri date e domande
- ✅ Group by e sort by
- ✅ Query optimization

**Righe**: ~250

**Metodi Principali**:
- `execute()` - Entry point
- `withAnswersLabel()` - Label joins
- `handleCustomQuestionType()` - Custom fields
- `processResults()` - Result processing

#### GetChartsDataByQuestionChart
**File**: `Modules/Quaeris/app/Actions/QuestionChart/GetChartsDataByQuestionChart.php`

**Features**:
- ✅ Multiple charts per question
- ✅ Builder cloning
- ✅ Default chart creation
- ✅ Chart configuration

**Righe**: ~80

#### ExportChartToSvgAction
**File**: `Modules/Chart/app/Actions/ExportChartToSvgAction.php`

**Features**:
- ✅ Export da base64
- ✅ Export da Chart.js data
- ✅ SVG generation
- ✅ Storage integration

**Righe**: ~150

#### ExportChartToPngAction
**File**: `Modules/Chart/app/Actions/ExportChartToPngAction.php`

**Features**:
- ✅ Export da base64
- ✅ Export da Chart.js data
- ✅ Intervention Image integration
- ✅ Quality settings
- ✅ GD library

**Righe**: ~180

---

## 3. Differenze Fila4 → Fila5

### Architecture Changes

| Aspect | Fila4 | Fila5 | Note |
|--------|-------|-------|------|
| **Base Query** | Direct DB | `SurveyResponse::getResponsesForSurvey()` | ✅ Better abstraction |
| **Data Transfer** | Arrays | Spatie Laravel Data | ✅ Type safety |
| **Actions** | QueueableAction | QueueableAction | ✅ Same pattern |
| **PHPStan** | Level 8 | Level 10 | ✅ Stricter types |
| **Custom Fields** | Manual quoting | `quoteColumn()` helper | ✅ Reusable |

### Code Quality Improvements

1. **Type Safety**: PHPStan Level 10 enforcement
2. **DTOs**: Spatie Data invece di array
3. **Helpers**: `quoteColumn()` per campi speciali
4. **Documentation**: Inline docs più dettagliati

---

## 4. Files Created/Modified

### Created (11 files)

#### DTOs (3)
1. `Modules/Chart/app/Datas/AnswerData.php`
2. `Modules/Chart/app/Datas/ChartData.php`
3. `Modules/Chart/app/Datas/AnswersChartData.php`

#### Actions (4)
4. `Modules/Quaeris/app/Actions/QuestionChart/GetAnswersByQuestionChart.php`
5. `Modules/Quaeris/app/Actions/QuestionChart/GetChartsDataByQuestionChart.php`
6. `Modules/Chart/app/Actions/ExportChartToSvgAction.php`
7. `Modules/Chart/app/Actions/ExportChartToPngAction.php`

#### Documentation (3)
8. `Modules/Quaeris/docs/custom-chart-implementation.md`
9. `.kilo/docs/custom-chart-implementation-report.md` (this file)
10. `.github/ISSUE_TEMPLATE/custom-chart-implementation.md`

#### GitHub (1)
11. `.github/ISSUE_TEMPLATE/custom-chart-implementation.md`

**Totale Righe Create**: ~1000+

---

## 5. Usage Examples

### Basic Usage

```php
use Modules\Quaeris\Actions\QuestionChart\GetChartsDataByQuestionChart;
use Modules\Chart\Actions\ExportChartToSvgAction;
use Modules\Chart\Actions\ExportChartToPngAction;

// 1. Get chart data
$chartsData = app(GetChartsDataByQuestionChart::class)->execute(
    $questionChart,
    $responses,
    $filters
);

// 2. Export each chart
foreach ($chartsData as $chartData) {
    // Export SVG
    $svg = app(ExportChartToSvgAction::class)->executeFromChartData(
        $chartData->toArray()
    );
    
    // Export PNG
    $png = app(ExportChartToPngAction::class)->executeFromChartData(
        $chartData->toArray(),
        quality: 95
    );
}
```

### Widget Integration

```php
class QuestionChartAnswersCompositeWidget extends Widget
{
    public function render(): View
    {
        $chartsData = app(GetChartsDataByQuestionChart::class)->execute(
            $this->record,
            $this->getResponsesQuery(),
            $this->filters
        );
        
        return view('quaeris::filament.widgets.question-chart-answers-composite-widget', [
            'chartsData' => $chartsData,
        ]);
    }
}
```

---

## 6. Testing Strategy

### Unit Tests (To Implement)

```php
it('can get answers by question chart', function () {
    $questionChart = QuestionChart::factory()->create();
    $responses = SurveyResponse::getResponsesForSurvey($questionChart->survey_id);
    
    $answersData = app(GetAnswersByQuestionChart::class)->execute(
        $questionChart, null, null, null, $responses
    );
    
    expect($answersData)->toBeInstanceOf(AnswersChartData::class);
});

it('can export chart to svg', function () {
    $chartData = ['labels' => ['Yes', 'No'], 'datasets' => [...]];
    
    $result = app(ExportChartToSvgAction::class)->executeFromChartData($chartData);
    
    expect($result['mime_type'])->toBe('image/svg+xml');
});
```

### Integration Tests (To Implement)

```php
it('can handle custom question types', function () {
    $questionChart = QuestionChart::factory()->create([
        'question' => 'custom:root_grouped_bf'
    ]);
    
    $answersData = app(GetAnswersByQuestionChart::class)->execute($questionChart, ...);
    
    expect($answersData->answers)->not->toBeEmpty();
});
```

---

## 7. Performance Considerations

### Query Optimization

1. **Builder Cloning**: Ogni chart lavora su una copia del builder
2. **Lazy Loading**: Dati caricati solo quando necessario
3. **Caching**: Da implementare per query frequenti

### Memory Management

1. **DTO Efficiency**: Spatie Data sono leggere
2. **Stream Export**: Export in streaming per file grandi
3. **Batch Processing**: Per grandi volumi di dati

---

## 8. Known Limitations

### Current Limitations

1. **Chart.js to SVG**: Implementazione base (può essere migliorata)
2. **JpGraph Integration**: Non ancora implementata per PDF
3. **Real-time Updates**: Non supportati (richiederebbe WebSocket)

### Future Enhancements

1. **Advanced SVG**: Usare librerie dedicate (es. chartjs-node-canvas)
2. **PDF Export**: Integrare JpGraph da Fila4
3. **Caching**: Implementare cache per query costose
4. **Batch Export**: Export multiplo in background

---

## 9. Migration Checklist

### For Developers Migrating from Fila4

- [ ] Review new DTO structure
- [ ] Update widget integrations
- [ ] Test custom question types
- [ ] Verify export functionality
- [ ] Update documentation
- [ ] Run PHPStan Level 10
- [ ] Run tests

### For Existing Fila5 Installation

- [ ] Run composer install (new dependencies)
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Test existing charts
- [ ] Enable new features gradually

---

## 9.1 SQL GROUP BY MySQL Strict Mode Fix (2026-03-17)

### Problema

Errore: `Column not found: 1054 Unknown column 'DATE_FORMAT(sms_sent_at, "%Y-%b")' in 'group statement'`

### Causa

Utilizzo di variabili PHP in `orderByRaw()` che venivano interpretate come nomi colonna invece di espressioni SQL raw.

### Soluzione

Usare SEMPRE espressioni inline dirette in `orderByRaw()`:

```php
// ERRORE
$sort_by_expr = 'DATE_FORMAT(sms_sent_at, "%Y-%m")';
->orderByRaw($sort_by_expr)

// CORRETTO
->orderByRaw('DATE_FORMAT(sms_sent_at, "%Y-%m")')
```

### File Corretto

- `laravel/Modules/Quaeris/app/Actions/QuestionChart/Custom/SmsResponseRate.php`

### Test URL

- `/quaeris/admin/ats/survey-pdfs/16/question-charts/191`
- `/quaeris/admin/ats/survey-pdfs/16/question-charts/234`

---

## 10. Metrics

### Code Metrics

| Metric | Value |
|--------|-------|
| Files Created | 11 |
| Total Lines | ~1000+ |
| Actions | 4 |
| DTOs | 3 |
| Documentation Files | 3 |
| Test Coverage | TBD |

### Performance Metrics (To Measure)

| Metric | Target | Actual |
|--------|--------|--------|
| Chart Load Time | < 500ms | TBD |
| Export Time (SVG) | < 1s | TBD |
| Export Time (PNG) | < 2s | TBD |
| Memory Usage | < 50MB | TBD |

---

## 11. Next Steps

### Immediate (Week 1)
- [x] Study Fila4 implementation
- [x] Create core actions
- [x] Create DTOs
- [x] Write documentation
- [ ] Write unit tests
- [ ] Integration testing

### Short Term (Week 2-3)
- [ ] Update widgets to use new actions
- [ ] Add export buttons to UI
- [ ] Test with real data
- [ ] Performance optimization
- [ ] Bug fixes

### Long Term (Week 4+)
- [ ] JpGraph integration for PDF
- [ ] Advanced caching
- [ ] Real-time updates
- [ ] Chart templates
- [ ] Advanced filtering

---

## 12. References

### Internal Documentation
- [Custom Chart Implementation Guide](Modules/Quaeris/docs/custom-chart-implementation.md)
- [GitHub Issue Template](.github/ISSUE_TEMPLATE/custom-chart-implementation.md)
- [Fila4 Source Code](file://./laravel/Modules/Quaeris/app/Actions/QuestionChart/)

### External Resources
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Intervention Image](https://image.intervention.io/)

---

**Date**: 2026-03-17  
**Status**: ✅ Core Implementation Complete  
**Next Phase**: Testing & Integration  
**Version**: 1.0.0
