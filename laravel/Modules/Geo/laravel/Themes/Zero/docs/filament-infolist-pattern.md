# Pattern Infolist Filament (Theme Zero)

## Overview

Il tema Zero utilizza il pattern **Infolist dedicato** per le risorse Filament che estendono `XotBaseResource`.

## Come Funziona

Quando una risorsa Filament chiama il metodo `infolist()`, `XotBaseResource` cerca automaticamente una classe dedicata seguendo la convenzione di naming:

```
{ResourceNamespace}\Schemas\{ModelName}Infolist
```

### Pattern nel Tema

Per risorse del tema che estendono classi base:

- **Resource:** `Themes\Zero\Filament\Resources\{Model}Resource`
- **Infolist:** `Themes\Zero\Filament\Resources\{Model}Resource\Schemas\{Model}Infolist`

## Regola: Estendere Sempre XotBaseResourceInfolist

Tutte le classi Infolist devono estendere la classe base astratta:

```php
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OrganizzativaInfolist extends XotBaseResourceInfolist
{
    // Implementa getInfolistSchema() (richiesto dalla classe base)
}
```

## Esempio dal Modulo Performance

Il modulo Performance implementa correttamente questo pattern per la risorsa `Organizzativa`:

```php
// Resource
Modules\Performance\Filament\Resources\OrganizzativaResource

// Infolist dedicato (estende XotBaseResourceInfolist)
Modules\Performance\Filament\Resources\OrganizzativaResource\Schemas\OrganizzativaInfolist
```

### Struttura Completa della Classe

```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OrganizzativaInfolist extends XotBaseResourceInfolist
{
    /**
     * Definisce lo schema dell'infolist (richiesto dalla classe base astratta).
     *
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'dati_lavoratore' => Section::make('dati_lavoratore')
                ->schema([
                    TextEntry::make('matr'),
                    TextEntry::make('cognome'),
                    TextEntry::make('nome'),
                ])
                ->columns(4),
        ];
    }
}
```

## Note per il Tema

- **Obbligatorio:** Estendere sempre `XotBaseResourceInfolist`
- **Obbligatorio:** Implementare `getInfolistSchema()` (metodo astratto della classe base)
- **Non override:** Il metodo `configure()` è `final` nella classe base - **non** sovrascriverlo
- La classe base usa `static::` (late static binding) per chiamare `getInfolistSchema()` della classe figlia

### Meccanismo Interno

```php
abstract class XotBaseResourceInfolist
{
    final public static function configure(Schema $schema): Schema
    {
        // static:: = late static binding, chiama il metodo della classe FIGLIA
        return $schema->components(static::getInfolistSchema());
    }

    abstract public static function getInfolistSchema(): array;
}
```

La classe figlia implementa **solo** `getInfolistSchema()`, il resto è gestito dalla classe base.

### Namespace Filament v5

Attenzione ai namespace in Filament v5:

```php
use Filament\Infolists\Components\TextEntry;  // Entry specifici
use Filament\Schemas\Components\Section;        // Contenitori/layout
use Filament\Schemas\Components\Component;      // Classe base componenti
```

- `Section`, `Grid`, `Fieldset` → `Filament\Schemas\Components\*`
- `TextEntry`, `ImageEntry`, `IconEntry` → `Filament\Infolists\Components\*`

## Gerarchia Classi

```
XotBaseResourceInfolist (abstract)
    ├── OrganizzativaInfolist
    ├── LogInfolist
    ├── CacheInfolist
    └── ... altre risorse
```

## Documentazione Modulo

Per dettagli completi del pattern, vedere:

- [Documentazione Performance - Infolist Pattern](../../Modules/Performance/docs/filament-infolist-pattern.md)
- [Progressioni - Schemas e Tables (migrazione Filament 5)](../../Modules/Progressioni/docs/filament-resource-schemas-tables.md)
- [XotBaseResourceInfolist - Sorgente](../../Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceInfolist.php)
- [XotBaseResource - Sorgente](../../Modules/Xot/app/Filament/Resources/XotBaseResource.php)
