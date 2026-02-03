# pattern di estensione filament

## regola fondamentale

non estendiamo **mai** classi filament direttamente. estendiamo sempre una classe astratta con lo stesso nome ma con il prefisso `XotBase`, rispettando anche la struttura del namespace.

## struttura corretta di estensione

| classe filament originale | classe da estendere |
|---------------------------|---------------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |

## come implementare correttamente

```php
// ERRATO: estensione diretta di una classe Filament
class DoctorResource extends Resource
{
    // ...
}

// CORRETTO: estensione della versione XotBase
class DoctorResource extends XotBaseResource
{
    // ...
}
```

## struttura del namespace

mantenere sempre lo stesso pattern di namespace rispetto a filament, ma usando il namespace del modulo:

```php
// namespace originale filament
namespace Filament\Resources\Pages;

// namespace corretto nel modulo
namespace Modules\<nome progetto>\Filament\Resources\Pages;
```

## metodi delle classi base

le classi `XotBase*` spesso forniscono:
- metodi astratti che devi implementare
- metodi finali che non possono essere sovrascritti
- metodi hook per personalizzare il comportamento

prima di implementare o sovrascrivere un metodo, verificare sempre che:
1. non sia dichiarato come `final` nella classe base
2. seguire il pattern di implementazione previsto dalla classe base

## esempio: infolist vs getInfolistSchema

```php
// ERRATO: sovrascrivere un metodo final
public function infolist(Infolist $infolist): Infolist
{
    // ...
}

// CORRETTO: implementare il metodo astratto
protected function getInfolistSchema(): array
{
    return [
        // ...
    ];
}
```

## linkback

- [errore override metodo final](/var/www/html/base_<nome progetto>/laravel/docs/errors/filament_final_method_override.md)
- [linee guida filament](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/filament-resources.md)
