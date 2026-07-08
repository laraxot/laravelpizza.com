# EnumTrait Pattern - Standard Architetturale per Enums

## Scopo

`Modules\Xot\Traits\EnumTrait` e' il trait standard Laraxot per gli enum PHP backed proprietari. Centralizza metadati UI, traduzioni, helper di form, liste e colonne derivate dagli enum, evitando che ogni modulo riscriva manualmente la stessa logica.

## Regola Architetturale

> Tutti gli enum PHP backed proprietari in `laravel/Modules` devono importare e usare `Modules\Xot\Traits\EnumTrait`.

La regola vale per gli enum Filament (`HasLabel`, `HasColor`, `HasIcon`, `HasDescription`) e anche per enum di dominio non ancora esposti in Filament: il trait e' il contratto comune e rende l'enum pronto alla normalizzazione.

Sono esclusi codice `vendor`, package terzi vendorizzati e fixture di test non applicative.

## Perche

- **Logica**: `getLabel()`, `getColor()`, `getIcon()` e `getDescription()` hanno una sola implementazione corretta. Gli enum dichiarano casi; il trait risolve la rappresentazione.
- **Politica**: Xot governa il protocollo cross-module. I moduli possiedono valori e traduzioni, ma non ridefiniscono il contratto.
- **Religione del progetto**: DRY, type safety, traduzioni e Filament devono convergere, non moltiplicarsi in `match` locali.
- **Bellezza**: un enum leggibile mostra il dominio. I dettagli visuali stanno nei lang file, dove possono essere governati e tradotti.
- **Zen**: stesso gesto ovunque: import, `use EnumTrait;`, traduzioni sotto `values`. Meno eccezioni, meno rumore.

## Struttura Enum

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum MioEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case CASO_UNO = 'caso_uno';
    case CASO_DUE = 'caso_due';
}
```

## Traduzioni Canoniche

`EnumTrait` usa `TransTrait::transClass()` e legge questa struttura:

```text
{module}::{enum_snake}.values.{enum_value}.label
{module}::{enum_snake}.values.{enum_value}.color
{module}::{enum_snake}.values.{enum_value}.icon
{module}::{enum_snake}.values.{enum_value}.description
```

Esempio `Modules/NomeModulo/lang/it/mio_enum.php`:

```php
<?php

declare(strict_types=1);

return [
    'values' => [
        'caso_uno' => [
            'label' => 'Caso uno',
            'color' => 'primary',
            'icon' => 'heroicon-o-star',
            'description' => 'Descrizione del caso uno',
        ],
        'caso_due' => [
            'label' => 'Caso due',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Descrizione del caso due',
        ],
    ],
];
```

## Metodi ereditati

| Metodo | Fonte canonica |
|---|---|
| `getLabel(): string` | `values.{value}.label` |
| `getColor(): string` | `values.{value}.color` |
| `getIcon(): string` | `values.{value}.icon` |
| `getDescription(): string` | `values.{value}.description` |
| `getSearchable(): array` | `static::cases()` |
| `getFormSchema(): array` | campi `TextInput` generati dai casi |
| `columns(Blueprint, ?XotBaseMigration)` | definizioni colonna dell'enum |
| `toArray(): array` | mappa value => label |

## Anti-pattern

```php
// Sbagliato: protocollo UI duplicato nel singolo enum.
public function getLabel(): string
{
    return match ($this) {
        self::CASO_UNO => 'Caso uno',
    };
}
```

```php
// Sbagliato: TransTrait diretto al posto di EnumTrait.
use Modules\Xot\Filament\Traits\TransTrait;

use TransTrait;
```

## Migrazione legacy

1. Aggiungere `use Modules\Xot\Traits\EnumTrait;`.
2. Inserire `use EnumTrait;` nel body dell'enum.
3. Sostituire `TransTrait` diretto con `EnumTrait` quando presente.
4. Portare le traduzioni legacy da `{value}.label` o `options.{value}` a `values.{value}.label`.
5. Rimuovere `getLabel()`, `getColor()`, `getIcon()`, `getDescription()` manuali solo quando tutte le chiavi `values` sono presenti.
6. Mantenere metodi di dominio non standard (`label()`, `color()`, `options()`, `getDefault()`) se sono parte del contratto applicativo esistente.

## Riferimenti

- Regola root: `docs/wiki/rules/enum-trait-required.md`
- Regola storica: `docs/wiki/rules/enum-trait-standard.md`