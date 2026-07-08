# Regola: Action che generano file DEVONO restituire StreamedResponse

## Data: Febbraio 2026

## Regola

Quando una closure di un'Action Filament chiama un metodo `execute()` che genera un file (PDF, Excel, ecc.) per il download del browser, la closure DEVE:

1. Avere return type `StreamedResponse` (o `mixed`), **MAI** `void`
2. `return` il risultato della chiamata `execute()`
3. Passare i parametri direttamente, **NON** wrappati in array non necessari

## Pattern Corretto

```php
use Illuminate\Http\StreamedResponse;

->action(function (): StreamedResponse {
    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
    return app(MakePdf::class)->execute($tableFilters);
}),
```

## Anti-Pattern (ERRATO)

```php
// ❌ void return type - il browser non riceve mai il file!
->action(function (): void {
    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
    $data = ['anno/valutatore' => $tableFilters]; // ❌ wrapping non necessario
    app(MakePdf::class)->execute($data); // ❌ manca il return
}),
```

## Motivazione

- Se il return type è `void` e non si fa `return` del `StreamedResponse`, il browser non riceve mai il download del file
- Filament necessita che il `StreamedResponse` venga restituito dalla closure dell'action per inviarlo al browser
- Il wrapping di `$tableFilters` in `['anno/valutatore' => $tableFilters]` è inutile — la classe Action deve gestire la struttura dei filtri internamente

## Si applica a

- Qualsiasi action che chiama `MakePdf`, `ExportXls`, `GeneratePdf`, `PdfByView` o simili Action che generano file
- Sia closure inline che definizioni in `setUp()`

## File corretti (Febbraio 2026)

- `Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/ListCondizioniLavoros.php`

## Collegamenti

- [Regole Filament Best Practices](../../../.windsurf/rules/filament-best-practices.md)
- [Xot docs consolidated actions](../../Xot/docs/consolidated/actions-pattern.md)
