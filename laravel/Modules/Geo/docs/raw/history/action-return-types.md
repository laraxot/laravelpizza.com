# Regola: Tipo Ritorno Action per File/Stream

## ⚠️ REGOLA CRITICA

Le azioni Filament che generano **file**, **PDF**, o **stream** devono avere:
- Tipo di ritorno: `StreamedResponse`
- Deve includere `return` del risultato

Le azioni che non restituiscono nulla (operazioni CRUD, redirect, ecc.) usano:
- Tipo di ritorno: `void`
- Nessun `return` necessario

## ❌ ANTI-PATTERN (Vietato per azioni file)

```php
use Filament\Actions\Action;

Action::make('exportPdf')
    ->label('PDF')
    ->icon('heroicon-s-document')
    ->action(function (): void {                    // ❌ void per azione file
        $filters = is_array($this->tableFilters) ? $this->tableFilters : [];
        $data = ['anno/valutatore' => $filters];     // ❌ Wrappatura inutile
        app(MakePdf::class)->execute($data);        // ❌ Manca return
    }),
```

## ✅ PATTERN CORRETTO

```php
use Filament\Actions\Action;
use Illuminate\Http\StreamedResponse;

Action::make('exportPdf')
    ->label('PDF')
    ->icon('heroicon-s-document')
    ->action(function (): StreamedResponse {      // ✅ StreamedResponse
        $filters = is_array($this->tableFilters) ? $this->tableFilters : [];
        return app(MakePdf::class)->execute($filters); // ✅ return diretto
    }),
```

## Perché è Importante

### 1. Type Safety con PHPStan Level 10
Il tipo di ritorno deve corrispondere a ciò che l'Action restituisce.

### 2. StreamedResponse per Download File
Quando l'Action genera un PDF o file, deve restituire una `StreamedResponse` per:
- Gestire correttamente lo streaming del file
- Impostare gli header HTTP appropriati
- Supportare download di grandi dimensioni

### 3. Void per Operazioni CRUD
Le azioni che modificano dati ma non restituiscono file usano `void`:

```php
Action::make('delete')
    ->label('Elimina')
    ->action(function (): void {
        $this->record->delete();
        // Nessun return necessario
    }),
```

## Differenza tra Action Types

### Action che Restituiscono File
```php
use Illuminate\Http\StreamedResponse;

// PDF, Excel, CSV, ZIP, ecc.
action(function (): StreamedResponse {
    return app(GeneratePdf::class)->execute($data);
}),

action(function (): StreamedResponse {
    return app(ExportExcel::class)->execute($data);
}),
```

### Action che Modificano Dati (senza file)
```php
// Delete, Update, Replicate, ecc.
action(function (): void {
    app(ReplicateRecord::class)->execute($data);
}),

action(function (): void {
    $this->record->update(['status' => 'completed']);
}),
```

### Action con Redirect
```php
use Illuminate\Http\RedirectResponse;

action(function (): RedirectResponse {
    return redirect()->route('success');
}),
```

## Checklist per Code Review

### Per Azioni File
- [ ] Import `use Illuminate\Http\StreamedResponse;`
- [ ] Tipo di ritorno: `function (): StreamedResponse`
- [ ] Include `return` prima di `app(...)->execute(...)`
- [ ] Passa i parametri direttamente, senza wrapparli inutilmente

### Per Azioni CRUD
- [ ] Tipo di ritorno: `function (): void`
- [ ] Nessun `return` necessario
- [ ] Logica di business corretta

## Esempi Completi

### Esempio 1: Export PDF
```php
use Filament\Actions\Action;
use Illuminate\Http\StreamedResponse;
use Modules\MyModule\Actions\GeneratePdf;

protected function getHeaderActions(): array
{
    return [
        'exportPdf' => Action::make('exportPdf')
            ->label('PDF')
            ->icon('heroicon-s-document')
            ->action(function (): StreamedResponse {
                $filters = is_array($this->tableFilters) ? $this->tableFilters : [];
                return app(GeneratePdf::class)->execute($filters);
            }),
    ];
}
```

### Esempio 2: Replicazione Record (void)
```php
use Filament\Actions\Action;
use Modules\MyModule\Actions\ReplicateRecord;

protected function getHeaderActions(): array
{
    return [
        'replicate' => Action::make('replicate')
            ->label('Duplica')
            ->icon('heroicon-o-clipboard')
            ->action(function (): void {
                $filters = is_array($this->tableFilters) ? $this->tableFilters : [];
                app(ReplicateRecord::class)->execute($filters);
            }),
    ];
}
```

### Esempio 3: Download CSV
```php
use Filament\Actions\Action;
use Illuminate\Http\StreamedResponse;
use Modules\MyModule\Actions\ExportCsv;

protected function getHeaderActions(): array
{
    return [
        'exportCsv' => Action::make('exportCsv')
            ->label('CSV')
            ->icon('heroicon-s-table-cells')
            ->action(function (): StreamedResponse {
                return app(ExportCsv::class)->execute($this->getTableQuery());
            }),
    ];
}
```

## Errori Comuni

### Errore 1: void per azione file
```php
// ❌ SBAGLIATO
action(function (): void {
    return app(MakePdf::class)->execute($data);
}),

// ✅ CORRETTO
action(function (): StreamedResponse {
    return app(MakePdf::class)->execute($data);
}),
```

### Errore 2: Manca return
```php
// ❌ SBAGLIATO
action(function (): StreamedResponse {
    app(MakePdf::class)->execute($data);
}),

// ✅ CORRETTO
action(function (): StreamedResponse {
    return app(MakePdf::class)->execute($data);
}),
```

### Errore 3: Wrappatura inutile
```php
// ❌ SBAGLIATO
action(function (): StreamedResponse {
    $data = ['filters' => $this->tableFilters];
    return app(MakePdf::class)->execute($data);
}),

// ✅ CORRETTO
action(function (): StreamedResponse {
    return app(MakePdf::class)->execute($this->tableFilters);
}),
```

## Collegamenti

- [Filament Actions Documentation](https://filamentphp.com/docs/3.x/actions/overview)
- [Laravel StreamedResponse](https://laravel.com/docs/responses#file-downloads)
- [WorkerColumn Rule](./WORKERCOLUMN-RULE.md)
- [PHPStan Level 10](./PHPSTAN-LEVEL10.md)

---
**Ultimo aggiornamento**: 2025-02-17  
**Priorità**: Alta  
**Violazione**: Critica - Errori PHPStan + Funzionalità rotta
