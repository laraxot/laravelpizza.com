# Rule: File-generating Action closures MUST return StreamedResponse

## Date: February 2026

## Rule

When a Filament Action closure calls an `execute()` method that generates a file (PDF, Excel, etc.) for browser download, the closure MUST:

1. Have return type `StreamedResponse` (or `mixed`), **NEVER** `void`
2. `return` the result of the `execute()` call
3. Pass parameters directly, **NOT** wrapped in unnecessary arrays

## Correct Pattern

```php
use Illuminate\Http\StreamedResponse;

// In setUp() of custom Action class:
->action(function (ListRecords $livewire): mixed {
    $tableFilters = $livewire->tableFilters ?? [];
    return app(PdfByViewAction::class)->execute($view, $filename);
}),

// In inline header action:
->action(function (): StreamedResponse {
    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
    return app(MakePdf::class)->execute($tableFilters);
}),
```

## Anti-Pattern (WRONG)

```php
// ❌ void return type - browser never receives the file!
->action(function (): void {
    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
    $data = ['anno/valutatore' => $tableFilters]; // ❌ unnecessary wrapping
    app(MakePdf::class)->execute($data); // ❌ no return statement
}),
```

## Why

- If return type is `void` and you don't `return` the `StreamedResponse`, the browser never receives the file download
- Filament needs the `StreamedResponse` returned from the action closure to send it to the browser
- Wrapping `$tableFilters` in `['anno/valutatore' => $tableFilters]` is unnecessary — the Action class should handle the filter structure internally

## Applies to

- Any action that calls `MakePdf`, `ExportXls`, `GeneratePdf`, `PdfByView`, or similar file-generating Actions
- Both inline closures and `setUp()` action definitions
- All modules: IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Incentivi, etc.

## Existing correct implementations

- `Modules/Xot/app/Filament/Actions/Header/ExportXlsAction.php` — returns result of `ExportXlsByCollection::execute()`
- `Modules/Progressioni/app/Filament/Resources/SchedeResource/Actions/Header/MakePdfAction.php` — returns result of `PdfByViewAction::execute()`
- `Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/ListCondizioniLavoros.php` — returns `StreamedResponse`

## Links

- [IndennitaCondizioniLavoro action-return-type-rule](../../indennitacondizionilavoro/docs/action-return-type-rule.md)
- [Consolidated actions pattern](consolidated/actions-pattern.md)
- [Filament best practices](../../../.windsurf/rules/filament-best-practices.md)
