# Implementazione degli Enum nel Modulo Geo

## Introduzione

Questo documento descrive l'implementazione degli enum nel modulo Geo di <main module>, con particolare attenzione alla gestione dei tipi e stati dei modelli geografici.

## Struttura degli Enum

### Posizione dei File

Tutti gli enum devono essere posizionati nella directory `Modules/Geo/Enums/` con il seguente formato di nome:

```
Modules/Geo/
  Enums/
    ComuneType.php
    ProvinciaType.php
    RegioneType.php
```

### Formato del Nome del File

- Usa il nome dell'enum in PascalCase
- Usa il suffisso appropriato (Type, Status, ecc.)
- Mantieni i nomi descrittivi e coerenti

### Struttura dell'Enum

Ogni enum deve seguire questa struttura base:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Enums;

use Filament\Support\Contracts\HasLabel;

enum ComuneType: string implements HasLabel
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
    
    public function getColor(): string
    {
        return match($this) {
            self::CAPOLUOGO => 'primary',
            self::COMUNE => 'success',
            self::FRAZIONE => 'info',
        };
    }
}
```

## Best Practices

1. **Type Safety**: Utilizzare sempre gli enum per rappresentare tipi e stati
2. **Interfacce**: Implementare `HasLabel` per l'integrazione con Filament
3. **Documentazione**: Documentare ogni caso enum con commenti esplicativi
4. **Metodi di Utilità**: Aggiungere metodi per colori, icone, ecc.
5. **Localizzazione**: Utilizzare i file di traduzione per le etichette

## Utilizzo nei Modelli

### Casting Automatico

```php
protected $casts = [
    'type' => ComuneType::class,
];
```

### Utilizzo nei Metodi

```php
public function isCapoluogo(): bool
{
    return $this->type === ComuneType::CAPOLUOGO;
}
```

## Integrazione con Filament

### Select con Enum

```php
use Filament\Forms\Components\Select;
use Modules\Geo\Enums\ComuneType;

Select::make('type')
    ->label('Tipo')
    ->options(ComuneType::class)
    ->required();
```

### Colonna con Badge

```php
use Filament\Tables\Columns\TextColumn;
use Modules\Geo\Enums\ComuneType;

TextColumn::make('type')
    ->badge()
    ->color(fn (ComuneType $state): string => $state->getColor())
    ->formatStateUsing(fn (ComuneType $state): string => $state->getLabel());
```

## Validazione

```php
use Illuminate\Validation\Rules\Enum;

$request->validate([
    'type' => ['required', new Enum(ComuneType::class)],
]);
```

## Collegamenti Correlati

- [Documentazione PHP sugli Enum](https://www.php.net/manual/en/language.enumerations.php)
- [Filament Enums Docs](https://filamentphp.com/project_docs/3.x/support/enums)
- [Best Practices Enum](enums-best-practices.md) 
