# XotBaseResource — pattern Filament

## Panoramica

`XotBaseResource` estende `Filament\Resources\Resource` e centralizza form, tabelle, pagine, relazioni e navigazione (DRY).

## Metodi finali (non sovrascrivere)

- `form()` — delega a `getFormSchema()`
- `table()` — delega a colonne/azioni via `XotBaseListRecords`

## Cosa implementare nella Resource figlia

| Metodo | Obbligatorio | Note |
| :--- | :---: | :--- |
| `getFormSchema()` | sì | Array con chiavi stringa |
| `getPages()` | no | Solo se servono view, pagine custom o naming Page non standard |
| `getRelations()` | no | Solo se ci sono RelationManager; non dichiarare `return []` |
| `getTableColumns()` | no | Colonne in `ListRecords::getListTableColumns()` |

## `getPages()` — quando non dichiararlo

Se la Resource espone solo list/create/edit e le classi Page rispettano la convenzione della base, **non** implementare `getPages()`.

Dettaglio, tabella naming ed esempi: [getpages-redundancy-rule.md](./getpages-redundancy-rule.md).

```php
// ✅ Resource minimale
class CoeffResource extends XotBaseResource
{
    protected static ?string $model = Coeff::class;

  /**
   * @return array<string, \Filament\Schemas\Components\Component>
   */
    public static function getFormSchema(): array
    {
        return [ /* ... */ ];
    }
}
```

Page attese (namespace `{Resource}\Pages\`):

- `List{Str::plural($name)}` — es. `ListCoeffs` per `CoeffResource`
- `Create{$name}` — es. `CreateCoeff`
- `Edit{$name}` — es. `EditCoeff`
- `View{$name}` — opzionale; la base la registra solo se la classe esiste

## Namespace e tipizzazione

- Namespace: `Modules\{ModuleName}\Filament\Resources`
- `declare(strict_types=1);` obbligatorio
- Non dichiarare `$navigationIcon`, `$navigationGroup`, `$navigationSort`, `$translationPrefix` (gestiti altrove)
- Mai `->label()` sui componenti Filament

## Esempio completo minimale

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Filament\Resources;

use Modules\Example\Models\Example;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ExampleResource extends XotBaseResource
{
    protected static ?string $model = Example::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // campi con chiavi stringa
        ];
    }
}
```

## Collegamenti

- [getpages-redundancy-rule.md](./getpages-redundancy-rule.md)
- [resources/architecture/forbidden-methods.md](./resources/architecture/forbidden-methods.md)
- [filament-class-extension-rules.md](../filament-class-extension-rules.md)
- [../filament-resource-rules.md](../filament-resource-rules.md)

*Ultimo aggiornamento: giugno 2025*
