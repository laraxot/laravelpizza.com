# PHPStan Errori ActivityLogger - Analisi e Correzione

## Problema Identificato

Il metodo `getStatistics()` in `ActivityLogger.php` presenta errori PHPStan livello 10:

1. **Return type mismatch**: Il tipo di ritorno non corrisponde esattamente
   - Atteso: `array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}`
   - Restituito: `array{total: int<0, max>, by_type: array, today: int<0, max>, ...}`
2. **mapWithKeys type**: Il callback restituisce `array<string, int>` ma PHPStan vede `array<int|string, int|string>`

## Analisi Business Logic

### Scopo del Metodo
`getStatistics()` restituisce statistiche sulle attività:
- `total`: Totale attività
- `by_type`: Conteggio per tipo evento (array associativo)
- `today`: Attività oggi
- `this_week`: Attività questa settimana
- `this_month`: Attività questo mese

## Strategia di Correzione Proposta

### Correzione Tipo di Ritorno
1. **Cast esplicito per `by_type`**: Assicurarsi che `mapWithKeys` restituisca esattamente `array<string, int>`
2. **Annotazione PHPDoc**: Aggiungere annotazione completa per tipo di ritorno
3. **Type narrowing**: Usare cast espliciti per garantire tipi corretti

### Implementazione Corretta
```php
/**
 * @return array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}
 */
public function getStatistics(): array
{
    // ... query setup ...
    
    return [
        'total' => (int) $query->count(),
        'by_type' => (function () use ($query): array {
            $results = $query->clone()
                ->selectRaw('event, COUNT(*) as count')
                ->groupBy('event')
                ->get();
            
            /** @var array<string, int> $mapped */
            $mapped = $results->mapWithKeys(function (\stdClass $item): array {
                return [(string) $item->event => (int) $item->count];
            })->toArray();
            
            return $mapped;
        })(),
        'today' => (int) $query->clone()->whereDate('created_at', now()->toDateString())->count(),
        'this_week' => (int) $query->clone()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        'this_month' => (int) $query->clone()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
    ];
}
```

## File da Modificare

- ✅ `laravel/Modules/Activity/app/Actions/ActivityLogger.php` (correggere tipi)

## Implementazione Completata

### Correzione Applicata
1. **Cast espliciti per count()**: Aggiunto `(int)` per tutti i `count()` per garantire tipo `int` invece di `int<0, max>`
2. **Costruzione manuale array by_type**: Sostituito `mapWithKeys()` con loop `foreach` per evitare problemi di tipo con `stdClass`
3. **Annotazione PHPDoc**: Aggiunta annotazione `@var array<string, int>` per `$byType`

### Codice Corretto
```php
/** @var array<string, int> $byType */
$byType = (function () use ($query): array {
    $clonedQuery = $query->clone();
    $results = $clonedQuery
        ->selectRaw('event, COUNT(*) as count')
        ->groupBy('event')
        ->get();

    /** @var array<string, int> $mapped */
    $mapped = [];
    foreach ($results as $item) {
        /** @var \stdClass $item */
        $mapped[(string) $item->event] = (int) $item->count;
    }

    return $mapped;
})();

return [
    'total' => (int) $query->count(),
    'by_type' => $byType,
    'today' => (int) $query->clone()->whereDate('created_at', now()->toDateString())->count(),
    // ...
];
```

## Verifica Qualità

- ✅ **PHPStan livello 10**: Passa senza errori
- ✅ **PHPMD**: Solo warning minori (StaticAccess, CouplingBetweenObjects - accettabili)
- ✅ **PHPInsights**: 96% code, 88.2% architecture

## Note

- I cast `(int)` sono necessari perché `count()` può restituire `int<0, max>`
- Il loop `foreach` garantisce il tipo corretto senza problemi con `stdClass`
- L'annotazione PHPDoc completa aiuta PHPStan

*Ultimo aggiornamento: [DATE]*

