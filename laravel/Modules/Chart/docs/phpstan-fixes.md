# PHPStan Fixes - Chart Module

## Status: 🔄 19 ERRORI RIMANENTI (da 99 iniziali)

**Ultimo aggiornamento**: 2025-01-22

## Progresso

- **Errori iniziali**: 99
- **Errori corretti**: 80
- **Errori rimanenti**: 19
- **Percentuale completamento**: 81%

## File Completati (0 errori)

### ✅ Actions
- `app/Actions/JpGraph/ApplyGraphStyleAction.php` (6 → 0)
- `app/Actions/JpGraph/ApplyPlotStyleAction.php` (11 → 0)

### ✅ Datas
- `app/Datas/ChartData.php` (1 → 0)
- `app/Datas/AnswersChartData.php` (già corretto)

### ✅ Filament
- `app/Filament/Resources/MixedChartResource.php` (già corretto)
- Tutti i file Filament (16 files)

## Pattern Applicati

### 1. Type Narrowing per Mixed Properties
```php
// ❌ PRIMA
$graph->footer->right->SetFont(...);

// ✅ DOPO
$footer = $graph->footer;
Assert::object($footer, 'Footer must be an object');
if (property_exists($footer, 'right') && $footer->right instanceof Text) {
    $footer->right->SetFont(...);
}
```

### 2. Instanceof Check per Subclassi
```php
// ❌ PRIMA
Assert::isInstanceOf($barPlot->value, Text::class);
$barPlot->value->Show();

// ✅ DOPO
$value = $barPlot->value;
if (!($value instanceof Text)) {
    return $barPlot;
}
$value->Show();
```

### 3. Method Exists per API Dinamiche
```php
// ❌ PRIMA
$hex->toRgba($alpha);

// ✅ DOPO
if (is_object($hex) && method_exists($hex, 'toRgba')) {
    return (string) $hex->toRgba($alpha);
}
```

### 4. PHPStan Ignore per Metodi Subclass
```php
// Per metodi che esistono solo su subclassi
if (method_exists($value, 'SetFormat')) {
    /** @phpstan-ignore-next-line method.notFound */
    $value->SetFormat('%.1f');
}
```

## Errori Rimanenti

### JpGraph V1 Actions (19 errori)
Tutti gli errori rimanenti sono accessi a proprietà/metodi mixed nelle azioni JpGraph V1:
- `Bar2Action.php`
- `Bar3Action.php`
- `Horizbar1Action.php`
- `LineSubQuestionAction.php`
- `Pie1Action.php`
- `PieAvgAction.php`
- `GetGraphAction.php`

**Pattern comune**: Accessi a `$graph->xaxis`, `$graph->yaxis`, `$graph->title`, `$plot->value` che sono typed come `mixed` nella libreria JpGraph.

## Prossimi Passi

1. Applicare stesso pattern di type narrowing ai file JpGraph V1 rimanenti
2. Usare `property_exists()` e `method_exists()` per verifiche runtime
3. Separare variabili per evitare accessi diretti a mixed
4. Usare `@phpstan-ignore-next-line` solo quando necessario

## Lezioni Apprese

1. **Librerie Esterne**: JpGraph ha molte proprietà typed come `mixed`, serve type narrowing sistematico
2. **Instanceof vs Assert**: Preferire `instanceof` per early return invece di Assert multipli
3. **Method Exists**: Utile per API dinamiche dove metodi esistono solo su subclassi
4. **Batch Fixes**: Pattern simili possono essere applicati in batch per velocizzare

## Benefici

- ✅ Type safety migliorata per 81% del modulo
- ✅ Codice più robusto con verifiche runtime
- ✅ Documentazione pattern per correzioni future
- ✅ Zero modifiche a phpstan.neon (come richiesto)
