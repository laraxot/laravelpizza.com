# AddressResource

## Panoramica

`AddressResource` è una risorsa Filament che fornisce un'interfaccia amministrativa completa per gestire gli indirizzi nel modulo Geo. La risorsa segue le best practices del progetto e le linee guida di implementazione per le risorse Filament.

## Struttura

`AddressResource` estende `XotBaseResource` e implementa tutte le funzionalità necessarie per la gestione degli indirizzi:

```php
<?php

namespace Modules\Geo\Filament\Resources;

use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Tables;
use Modules\Geo\Models\Address;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AddressResource extends XotBaseResource
{
    // Implementazione...
}
```

## Form Schema

La risorsa definisce uno schema form completo per la gestione degli indirizzi, che può essere riutilizzato in altre risorse Filament:

```php
public static function getFormSchema(): array
{
    return [
        'name' => Forms\Components\TextInput::make('name')
            ->maxLength(255),
            
        'description' => Forms\Components\Textarea::make('description')
            ->maxLength(1000)
            ->columnSpanFull(),
            
        'route' => Forms\Components\TextInput::make('route')
            ->required()
            ->maxLength(255),
            
        'street_number' => Forms\Components\TextInput::make('street_number')
            ->maxLength(20),
            
        // Altri campi...
            
        'map' => Map::make('map')
            ->reactive()
            ->afterStateUpdated(/* ... */)
            ->columnSpanFull(),
    ];
}
```

## Riutilizzo del Form Schema

Una caratteristica importante di `AddressResource` è la possibilità di riutilizzare il suo schema form in altre risorse Filament, permettendo una gestione coerente degli indirizzi in tutta l'applicazione.

Invece di duplicare la definizione dei campi per gli indirizzi in ogni risorsa, è possibile utilizzare lo schema predefinito:

```php
use Modules\Geo\Filament\Resources\AddressResource;

// In un'altra risorsa Filament
public static function getFormSchema(): array
{
    return [
        // Campi specifici della risorsa...
        
        'addresses' => Forms\Components\Repeater::make('addresses')
            ->relationship('addresses')
            ->schema(AddressResource::getFormSchema()),
    ];
}
```

## Funzionalità di Mappa

`AddressResource` integra il componente Map di Filament Google Maps, offrendo:

- Geocodifica automatica
- Autocompletamento indirizzi
- Selezione sulla mappa
- Visualizzazione dell'indirizzo su mappa

```php
Map::make('map')
    ->reactive()
    ->afterStateUpdated(function (array $state, callable $set, callable $get) {
        $set('latitude', $state['lat'] ?? null);
        $set('longitude', $state['lng'] ?? null);
    })
    ->defaultLocation([41.9027835, 12.4963655]) // Roma
    ->mapControls([
        'zoomControl' => true,
        'mapTypeControl' => true,
    ])
    ->debug()
    ->clickable()
    ->autocomplete('formatted_address')
    ->autocompleteReverse()
    ->reverseGeocode([
        'locality' => '%L',
        'postal_code' => '%z',
        'administrative_area_level_2' => '%A1',
        'administrative_area_level_3' => '%A2',
        'route' => '%R',
        'street_number' => '%n',
        'country' => '%C',
    ])
    ->geolocate()
    ->columnSpanFull(),
```

## Table Columns

La risorsa definisce colonne ottimizzate per la visualizzazione degli indirizzi in tabella:

```php
public static function getTableColumns(): array
{
    return [
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable(),
            
        'full_address' => Tables\Columns\TextColumn::make('full_address')
            ->searchable(),
            
        'type' => Tables\Columns\TextColumn::make('type')
            ->badge()
            ->formatStateUsing(/* ... */),
            
        // Altre colonne...
    ];
}
```

## Filtri

La risorsa include filtri avanzati per la ricerca degli indirizzi:

```php
public static function getTableFilters(): array
{
    return [
        'type' => Tables\Filters\SelectFilter::make('type')
            ->options([/* ... */]),
            
        'is_primary' => Tables\Filters\TernaryFilter::make('is_primary'),
            
        'locality' => Tables\Filters\SelectFilter::make('locality')
            ->options(fn (): array => Address::query()
                ->select('locality')
                ->distinct()
                ->pluck('locality', 'locality')
                ->toArray()
            ),
            
        // Altri filtri...
    ];
}
```

## Azioni

`AddressResource` implementa azioni specifiche per la gestione degli indirizzi:

```php
public static function getTableActions(): array
{
    return [
        'edit' => Tables\Actions\EditAction::make(),
            
        'view' => Tables\Actions\ViewAction::make(),
            
        'delete' => Tables\Actions\DeleteAction::make(),
            
        'setPrimary' => Tables\Actions\Action::make('setPrimary')
            ->visible(fn (Address $record): bool => !$record->is_primary)
            ->icon('heroicon-o-star')
            ->color('warning')
            ->requiresConfirmation()
            ->action(function (Address $record): void {
                // Imposta l'indirizzo come principale
                // ...
            }),
    ];
}
```

## Infolist Schema

La risorsa definisce uno schema dettagliato per la visualizzazione delle informazioni dell'indirizzo:

```php
public static function getInfolistSchema(): array
{
    return [
        Forms\Components\Section::make('address.sections.metadata.label')
            ->description('address.sections.metadata.description')
            ->schema([/* ... */]),
            
        Forms\Components\Section::make('address.sections.address.label')
            ->description('address.sections.address.description')
            ->schema([/* ... */]),
            
        Forms\Components\Section::make('address.sections.location.label')
            ->description('address.sections.location.description')
            ->schema([/* ... */]),
            
        Forms\Components\Section::make('address.sections.map.label')
            ->description('address.sections.map.description')
            ->schema([/* ... */]),
    ];
}
```

## Traduzione

Le etichette e i messaggi della risorsa sono gestiti tramite file di traduzione:

```php
// In /lang/it/address.php
return [
    'singular' => 'Indirizzo',
    'plural' => 'Indirizzi',
    'navigation' => 'Gestione Indirizzi',
    
    'fields' => [
        'route' => [
            'label' => 'Via',
            'placeholder' => 'Inserisci la via',
        ],
        // Altri campi...
    ],
    
    // Altre traduzioni...
];
```

## Best Practices

1. **Riutilizzo dello schema form**: Preferire sempre il riutilizzo dello schema form di `AddressResource` piuttosto che ridefinire i campi degli indirizzi in altre risorse.

2. **Traduzione centralizzata**: Utilizzare le chiavi di traduzione anziché stringhe hardcoded per mantenere coerenza linguistica.

3. **Validazione**: Applicare regole di validazione appropriate per garantire la qualità dei dati degli indirizzi.

4. **Navigazione**: Rispettare la struttura di navigazione del progetto, mantenendo `AddressResource` nel gruppo "Geo".

5. **Azioni contestuali**: Implementare azioni specifiche per gli indirizzi, come "Imposta come principale", che riflettono il dominio applicativo.

## Riferimenti

- [Modello Address](../models/address.md)
- [Trait HasAddress](../traits/hasaddress-implementation.md)
- [XotBaseResource](../../Xot/docs/filament/xotbase-resource.md)
- [Documentazione Filament](https://filamentphp.com/docs/3.x/panels/resources/getting-started)