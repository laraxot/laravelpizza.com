---
description: 
globs: 
alwaysApply: true
---
# Regole per gli Enum nel Modulo Geo (Windsurf)

## Obiettivo
Utilizzare SEMPRE enum PHP 8.1+ per tutti i campi "tipo" e "stato" (es. ComuneTypeEnum, ProvinciaTypeEnum, ecc.), MAI costanti stringa o integer.

## Definizione
```php
namespace Modules\Geo\Enums;

use Filament\Support\Contracts\HasLabel;

enum ComuneTypeEnum: string implements HasLabel
{
    case CAPOLUOGO = 'capoluogo';
    case COMUNE = 'comune';
    case FRAZIONE = 'frazione';

    public function getLabel(): string
    {
        return match($this) {
            self::CAPOLUOGO => 'Capoluogo',
            self::COMUNE => 'Comune',
            self::FRAZIONE => 'Frazione',
        };
    }
}
```

## Regole
- Usare SEMPRE l'enum per i campi tipo/stato nei modelli
- Cast automatico Eloquent:
  ```php
  protected $casts = [
      'type' => ComuneTypeEnum::class,
  ];
  ```
- In Filament, usare l'enum per:
  - Opzioni Select, Radio, CheckboxList
  - Colonne Table/Badge (label e colore)
  - Policies e scoping
- MAI usare costanti tipo `public const TYPE_CAPOLUOGO = 'capoluogo'` (deprecato)
- Documentare sempre l'uso dell'enum in ogni modulo

## Best Practice Filament
- Implementare HasLabel per label UI
- Usare l'enum direttamente in Select/Radio/Badge:
  ```php
  Select::make('type')->options(ComuneTypeEnum::class)
  ```
- Vedi: [Filament Enums Docs](mdc:https:/filamentphp.com/docs/3.x/support/enums)

## Collegamenti
- [Implementazione Enum](mdc:enums-implementation.md)
- [Best Practices Enum](mdc:enums-best-practices.md)
- [Filament Enums](mdc:https:/filamentphp.com/docs/3.x/support/enums)

---
**Questa regola è OBBLIGATORIA per tutti i moduli che gestiscono tipi o stati.**
