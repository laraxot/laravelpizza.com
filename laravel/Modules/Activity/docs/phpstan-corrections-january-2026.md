# PHPStan Corrections - Activity Module - Gennaio 2026

**Data**: 2026-01-02  
**Status**: ✅ COMPLETATO  
**Errori corretti**: Da 2 a 0

## File corretti

### 1. app/Actions/ActivityLogger.php - getStatistics()

**Problema**: 
- Return type mismatch: `by_type` deve essere `array<string, int>` ma restituisce `array<int|string, mixed>`
- Parameter type mismatch: `mapWithKeys()` si aspetta `callable(object{event: string, count: int}, int): array<string, int>` ma riceve `Closure(\stdClass): non-empty-array<string, int>`

**Soluzione implementata**:
```php
'by_type' => (function () use ($query): array {
    /** @var \Illuminate\Database\Eloquent\Builder<Activity> $clonedQuery */
    $clonedQuery = $query->clone();

    /** @var \Illuminate\Support\Collection<int, object{event: string, count: int}> $results */
    $results = $clonedQuery
        ->selectRaw('event, COUNT(*) as count')
        ->groupBy('event')
        ->get();

    // Explicitly map and cast to ensure types
    /** @var array<string, int> $byType */
    $byType = $results->mapWithKeys(function (object $item, int $_key): array {
        // PHPStan L10: isset() per magic attributes invece di property_exists()
        if (! isset($item->event, $item->count)) {
            return [];
        }

        return [(string) $item->event => (int) $item->count];
    })->toArray();

    return $byType;
})(),
```

**Pattern applicati**:
1. **Type narrowing con PHPDoc**: `@var array<string, int> $byType` per specificare il tipo corretto dopo `toArray()`
2. **Closure signature corretta**: `function (object $item, int $_key): array` - accetta entrambi i parametri richiesti da `mapWithKeys()`
3. **isset() invece di property_exists()**: Per magic attributes di oggetti stdClass
4. **Guard clause**: Early return se le proprietà non esistono

**Risultato**:
- ✅ PHPStan Level 10: 0 errori
- ✅ PHPMD: Nessun problema di complexity
- ✅ PHP Insights: Code 97.8%, Complexity 33.3% (media 1.92), Architecture 88.2%, Style 91.6%

## Pattern Documentati

### mapWithKeys() Return Type Narrowing

**Problema**: `Collection::mapWithKeys()->toArray()` restituisce `array<int|string, mixed>` ma spesso serve `array<string, int>`.

**Soluzione**:
```php
/** @var array<string, int> $result */
$result = $collection->mapWithKeys(function (object $item, int $_key): array {
    // Closure deve accettare (item, key) e restituire array
    return [(string) $item->key => (int) $item->value];
})->toArray();
```

**Regole**:
1. Closure deve accettare **entrambi** i parametri: `(object $item, int $key)`
2. Closure deve restituire `array` (non `non-empty-array`)
3. Aggiungere PHPDoc `@var array<string, int>` dopo `toArray()`
4. Usare `isset()` per verificare proprietà magic attributes

## Collegamenti

- [ActivityLogger.php](../../app/Actions/ActivityLogger.php)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Correzioni Precedenti](./phpstan-corrections.md)
