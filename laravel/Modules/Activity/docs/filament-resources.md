# Filament Resources nel Modulo Activity

## Struttura delle Risorse

Le risorse Filament nel modulo Activity seguono una struttura specifica che estende le classi base di Xot.

### ActivityResource e SnapshotResource

Le risorse principali per la gestione delle attività e degli snapshots.

```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class ActivityResource extends XotBaseResource
{
    // ...
}

class SnapshotResource extends XotBaseResource
{
    // ...
}
```

## Pagine delle Risorse

### ListActivities e ListSnapshots

Le pagine di elenco devono seguire queste regole:

1. Estendere `XotBaseListRecords` invece di `ListRecords`
2. I metodi di configurazione della tabella devono essere non-statici
3. Utilizzare i trait corretti per le funzionalità
4. Mantenere la compatibilità con i metodi della classe base

```php
use Modules\Xot\Filament\Pages\XotBaseListRecords;

class ListSnapshots extends XotBaseListRecords
{
    // CORRETTO: metodo non statico e compatibile con la classe base
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable()
                ->label('ID'),
            TextColumn::make('aggregate_uuid')
                ->searchable()
                ->label('Aggregate UUID'),
            // altre colonne...
        ];
    }

    // ERRATO: non usare metodi statici
    public static function getTableColumns(): array // ❌
    {
        // ...
    }
}
```

## Errori Comuni

### 1. Metodi Statici vs Non-Statici

**Errore**:
```
Cannot make non static method Filament\Resources\Pages\ListRecords::getTableColumns() static in class Modules\Activity\Filament\Resources\SnapshotResource\Pages\ListSnapshots
```

**Causa**:
Il metodo `getTableColumns()` è stato dichiarato come statico mentre dovrebbe essere un metodo di istanza.

**Soluzione**:
1. Rimuovere la keyword `static` dalla dichiarazione del metodo
2. Utilizzare `public function getTableColumns()`

### 2. Compatibilità dei Metodi

**Errore**:
```
Method 'ListSnapshots::getTableColumns()' is not compatible with method 'XotBaseListRecords::getTableColumns()'
```

**Causa**:
La firma del metodo non corrisponde esattamente a quella della classe base.

**Soluzione**:
1. Assicurarsi che la firma del metodo sia identica a quella della classe base
2. Verificare il tipo di ritorno e i parametri
3. Controllare la visibilità del metodo (public/protected)

### Best Practices

1. Non rendere statici i metodi di configurazione della tabella
2. Estendere sempre le classi base di Xot invece delle classi Filament dirette
3. Utilizzare i trait appropriati per le funzionalità aggiuntive
4. Seguire le convenzioni di naming del modulo
5. Mantenere la compatibilità con i metodi della classe base

## Configurazione Corretta

### ListSnapshots

```php
namespace Modules\Activity\Filament\Resources\SnapshotResource\Pages;

use Modules\Xot\Filament\Pages\XotBaseListRecords;
use Filament\Tables\Columns\TextColumn;

class ListSnapshots extends XotBaseListRecords
{
    protected static string $resource = SnapshotResource::class;

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable()
                ->label('ID'),
            TextColumn::make('aggregate_uuid')
                ->searchable()
                ->label('Aggregate UUID'),
            TextColumn::make('aggregate_version')
                ->sortable()
                ->label('Version'),
            TextColumn::make('state')
                ->searchable()
                ->label('State'),
            TextColumn::make('created_at')
                ->sortable()
                ->dateTime()
                ->label('Created At'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            // filtri...
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // azioni...
        ];
    }
}
```

## Note Aggiuntive

- Tutti i metodi di configurazione della tabella devono essere non-statici
- Le colonne devono essere definite nel metodo `getTableColumns()`
- I filtri devono essere definiti nel metodo `getTableFilters()`
- Le azioni devono essere definite nel metodo `getTableActions()`
- Utilizzare i trait appropriati per funzionalità aggiuntive
- Verificare sempre la compatibilità con i metodi della classe base

## Riferimenti

- [Documentazione Filament](https://filamentphp.com/docs/tables)
- [XotBaseListRecords](../Xot/docs/filament-pages.md)
- [Best Practices Filament](../Xot/docs/filament-best-practices.md)
- [Compatibilità dei Metodi in PHP](https://www.php.net/manual/en/language.oop5.inheritance.php) 