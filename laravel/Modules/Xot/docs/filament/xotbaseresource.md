# XotBaseResource Pattern

## Panoramica

`XotBaseResource` estende `Resource` di Filament e centralizza configurazione comune (DRY).

## Metodi Finali (NON sovrascrivere)

- `form()` — delegato a `getFormSchema()`
- `table()` — delegato a `XotBaseListRecords::getListTableColumns()`

## Metodi da Implementare nella Resource

- `getFormSchema(): array` — schema del form (obbligatorio)

## Metodi NON Necessari nella Resource

- `getTableColumns()` — **NON richiesto**, gestito da `XotBaseListRecords::getListTableColumns()` nella pagina ListRecords
- `getPages()` — NON necessario se standard (CRUD)
- `getTableActions()` — NON necessario se standard

## Utilizzo

```php
namespace Modules\YourModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class YourResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;

    public static function getFormSchema(): array
    {
        return [
            // Definisci qui lo schema del form
        ];
    }

    // getTableColumns() NON necessario - gestito da XotBaseListRecords
}
```

## Best Practices

1. NON sovrascrivere `form()` e `table()` (sono `final`)
2. Le colonne tabella vanno in `ListRecords::getListTableColumns()`, NON nella Resource
3. Namespace: `Modules\{ModuleName}\Filament\Resources`
4. `declare(strict_types=1)` obbligatorio

Per la guida completa: `filament-class-extension-rules.md`
