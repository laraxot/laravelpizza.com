# Pattern Infolist Filament

## Overview

Il modulo Performance implementa il pattern **Infolist dedicato** introdotto in `XotBaseResource` per gli infolist **Filament v5** (`Filament\Schemas\Components\Component`).

## Regola del Pattern

`XotBaseResource::infolist()` cerca automaticamente una classe dedicata per configurare l'infolist seguendo questa convenzione:

```
{ResourceNamespace}\Schemas\{ModelName}Infolist
```

### Esempio Pratico

Per la risorsa `OrganizzativaResource`:

- **Resource:** `Modules\Performance\Filament\Resources\OrganizzativaResource`
- **Model:** `Organizzativa`
- **Infolist Class:** `Modules\Performance\Filament\Resources\OrganizzativaResource\Schemas\OrganizzativaInfolist`

## Implementazione

### 1. Estendere XotBaseResourceInfolist

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
     * Definisce lo schema dell'infolist (richiesto dalla classe base).
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

**Nota Filament v5:** In Filament v5:
- `Section` e componenti contenitore: `Filament\Schemas\Components\*`
- `TextEntry` e entry specifici: `Filament\Infolists\Components\*`

### 2. Requisiti della Classe

- **Namespace corretto:** `{ResourceNamespace}\Schemas`
- **Nome corretto:** `{ModelName}Infolist`
- **Estensione:** `XotBaseResourceInfolist`
- **Metodo obbligatorio:** `getInfolistSchema(): array` (astratto dalla classe base)

**Nota:** Non implementare `configure()` - è già `final` nella classe base e usa `static::` per chiamare il tuo `getInfolistSchema()`.

### 3. Flusso di Risoluzione

```php
// In XotBaseResource::infolist()
$class = static::class.'\Schemas\\'.class_basename(static::getModel()).'Infolist';

if (class_exists($class)) {
    // Usa la classe dedicata (es: OrganizzativaInfolist::configure($schema))
    return $class::configure($schema);
}

// Fallback al metodo tradizionale
return $schema->components(static::getInfolistSchema());
```

### 4. Meccanismo di Ereditarietà

La classe base implementa `configure()` usando `static::` (late static binding):

```php
abstract class XotBaseResourceInfolist
{
    final public static function configure(Schema $schema): Schema
    {
        // static:: chiama getInfolistSchema() della classe FIGLIA
        return $schema->components(static::getInfolistSchema());
    }

    abstract public static function getInfolistSchema(): array;
}
```

Quindi la classe figlia implementa solo `getInfolistSchema()`:

```php
class OrganizzativaInfolist extends XotBaseResourceInfolist
{
    // Non serve override configure() - è già implementato nella base!

    public static function getInfolistSchema(): array
    {
        return [
            'section' => Section::make(...)
        ];
    }
}
```

**Nota:** La classe figlia **non deve** override `configure()`. Il metodo è `final` nella classe base.

### 5. Gerarchia Classi

```
XotBaseResourceInfolist (abstract)
    └── OrganizzativaInfolist
    └── LogInfolist
    └── CacheInfolist
    └── ...
```

## Vantaggi

1. **Separazione delle responsabilità:** La configurazione infolist è isolata dalla risorsa
2. **Codice più pulito:** La risorsa non contiene logica di presentazione
3. **Testabilità:** L'infolist può essere testato indipendentemente
4. **Type Safety:** Estendendo la classe base astratta, si garantisce l'implementazione corretta
5. **DRY:** Pattern riutilizzabile per tutte le risorse

## Collegamenti

- [XotBaseResource](../../Xot/docs/filament-resources.md)
- [XotBaseResourceInfolist](../../Xot/app/Filament/Resources/Schemas/XotBaseResourceInfolist.php)
- [OrganizzativaResource](../app/Filament/Resources/OrganizzativaResource.php)
- [OrganizzativaInfolist](../app/Filament/Resources/OrganizzativaResource/Schemas/OrganizzativaInfolist.php)
