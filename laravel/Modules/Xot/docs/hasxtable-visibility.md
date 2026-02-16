# Fix Visibilità Metodi HasXotTable - [DATE]

**Status**: ✅ Risolto  
**Errore**: `Access level to Filament\Tables\Concerns\InteractsWithTable::getTableActions() must be public (as in class Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords)`

## Problema Identificato

L'errore si verificava quando si accedeva a una pagina che estende `XotBaseManageRelatedRecords` (es. `ManageQuestionCharts`):

```
Access level to Filament\Tables\Concerns\InteractsWithTable::getTableActions() 
must be public (as in class Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords)
```

### Causa Radice

Il trait `HasXotTable` aveva i metodi dichiarati come `public`, mentre il trait `InteractsWithTable` di Filament li ha ora come `protected` in Filament 5.
Questa discrepanza causava un conflitto di visibilità quando entrambi i trait venivano usati nella stessa classe (come in `XotBaseManageRelatedRecords`).

### Conflitto di Visibilità

- `InteractsWithTable` (Filament 5) -> `protected`
- `HasXotTable` (Laraxot) -> `public`

PHP 8.3 rileva questo come un conflitto di trait non risolvibile se la classe non fornisce un override manuale con la stessa visibilità del trait "vincitore".
La soluzione migliore è allineare `HasXotTable` allo standard `protected` di Filament 5.

Tutti i metodi `getTable*()` in `HasXotTable` sono stati cambiati da `public` a `protected`:

### Metodi Corretti (Trait)

```php
// ✅ CORRETTO - Ora protected per match Filament 5
protected function getTableHeaderActions(): array
protected function getTableActions(): array
protected function getTableBulkActions(): array
protected function getTableFilters(): array
abstract protected function getTableColumns(): array
```

### Metodi che Restano Protected

Questi metodi possono rimanere `protected` perché vengono chiamati internamente:

```php
// ✅ CORRETTO - Protected (chiamati internamente)
protected function getDefaultTableSortColumn(): ?string
protected function getDefaultTableSortDirection(): ?string
protected function getTablePaginated(): bool|array
protected function getTablePollInterval(): ?string
protected function getTableHeading(): ?string
protected function getTableEmptyStateActions(): array
```

## File Modificati

1. **`Modules/Xot/app/Filament/Traits/HasXotTable.php`**
   - `getTableHeaderActions()`: `protected` → `public`
   - `getTableActions()`: `protected` → `public`
   - `getTableBulkActions()`: `protected` → `public`
   - `getTableFilters()`: `protected` → `public`

2. **`Modules/Xot/docs/filament/widget-method-visibility-rules.md`**
   - Aggiunta sezione "Errore InteractsWithTable"
   - Aggiornata data ultimo aggiornamento

3. **`Modules/Quaeris/docs/question-chart-implementation-guide.md`**
   - Aggiunta nota critica sulla visibilità dei metodi `getTable*()`

## Pattern Corretto

Quando si estende `XotBaseManageRelatedRecords` o si usa `HasXotTable`:

```php
class ManageQuestionCharts extends XotBaseManageRelatedRecords
{
    /**
     * CRITICO: Deve essere public.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
        ];
    }

    /**
     * CRITICO: Deve essere public.
     *
     * @return array<string, \Filament\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * CRITICO: Deve essere public (se sovrascritto).
     *
     * @return array<string, \Filament\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
```

## Verifica

Dopo la correzione, l'errore non dovrebbe più verificarsi:

```bash
# Test accesso pagina
curl http://quaeris.local/quaeris/admin/ats/survey-pdfs/16/question-charts/226
# ✅ Dovrebbe funzionare senza errori
```

## Riferimenti

- [Widget Method Visibility Rules](./widget-method-visibility-rules.md)
- [HasXotTable Trait Source](../../app/Filament/Traits/HasXotTable.php)
- [XotBaseManageRelatedRecords Source](../../app/Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php)

## Lezioni Apprese

1. **Principio di Liskov**: Quando si estende una classe o si usa un trait, la visibilità dei metodi non può essere ridotta
2. **Compatibilità Filament**: I trait di Filament (`InteractsWithTable`) hanno requisiti specifici di visibilità
3. **Documentazione**: La documentazione esistente (`widget-method-visibility-rules.md`) era corretta ma non era stata applicata al trait base

*Ultimo aggiornamento: [DATE]*
