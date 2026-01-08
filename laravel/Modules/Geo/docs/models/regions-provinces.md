# Gestione Regioni e Province Italiane

## Overview
In Italia, la struttura amministrativa prevede una chiara distinzione tra regioni (20 in totale) e province (attualmente 107). Per una corretta gestione degli indirizzi italiani, è fondamentale mantenere questa distinzione nei dati memorizzati.

## Tabelle di Riferimento

Il modulo Geo include tabelle di riferimento dedicate per le entità geografiche italiane:

- `regions` - Le 20 regioni italiane
- `provinces` - Le province italiane
- `cities` - I comuni italiani
- `caps` - I codici di avviamento postale

## Relazioni Gerarchiche

La struttura gerarchica delle entità geografiche italiane è così organizzata:

```
Region (Regione)
  └── Province (Provincia)
       └── City (Comune)
            └── CAP (Codice di Avviamento Postale)
```

## Modello Address: Campi per Indirizzi Italiani

Per supportare correttamente gli indirizzi italiani, il modello `Address` è stato esteso includendo:

```php
// Migrazione
$table->string('address_region', 100)->nullable()->comment('Regione (es. Lombardia)');
$table->string('province', 100)->nullable()->comment('Provincia (es. Milano)');
$table->string('province_short', 2)->nullable()->comment('Sigla provincia (es. MI)');
$table->string('address_locality', 100)->nullable()->comment('Comune (es. Milano)');
$table->string('postal_code', 20)->nullable()->comment('CAP (es. 20100)');
```

## Relazioni nel Modello Address

```php
/**
 * Get the region relationship.
 */
public function region(): BelongsTo
{
    return $this->belongsTo(Region::class, 'address_region', 'name');
}

/**
 * Get the province relationship.
 */
public function provinceRelation(): BelongsTo
{
    return $this->belongsTo(Province::class, 'province', 'name');
}

/**
 * Get the city relationship.
 */
public function city(): BelongsTo
{
    return $this->belongsTo(City::class, 'address_locality', 'name');
}
```

## Esempi di Utilizzo

### Recupero Informazioni Geografiche Complete

```php
$address = Address::find(1);

// Recupero regione completa
$region = $address->region;

// Recupero provincia completa
$province = $address->provinceRelation;

// Recupero comune completo
$city = $address->city;

// Dati demografici della regione
$population = $address->region->population;

// Dati geografici della provincia
$area = $address->provinceRelation->area;
```

### Filtraggio Indirizzi per Area Geografica

```php
// Tutti gli indirizzi in Lombardia
$addressesInLombardia = Address::where('address_region', 'Lombardia')->get();

// Tutti gli indirizzi nella provincia di Milano
$addressesInMilano = Address::where('province', 'Milano')->get();

// Tutti gli indirizzi nel comune di Roma
$addressesInRoma = Address::where('address_locality', 'Roma')->get();
```

## Validazione degli Indirizzi Italiani

```php
// Regole di validazione per indirizzi italiani
$rules = [
    'address_region' => ['required_if:address_country,IT', 'exists:regions,name'],
    'province' => ['required_if:address_country,IT', 'exists:provinces,name'],
    'address_locality' => ['required', 'exists:cities,name'],
    'postal_code' => ['required_if:address_country,IT', 'regex:/^[0-9]{5}$/'],
];
```

## Integrazione con Select Dinamici in Filament

Per i form in Filament, è possibile implementare select a cascata per regioni/province:

```php
Forms\Components\Select::make('address_region')
    ->label('address.fields.address_region.label')
    ->options(fn () => Region::pluck('name', 'name')->toArray())
    ->reactive()
    ->afterStateUpdated(fn (callable $set) => $set('province', null)),

Forms\Components\Select::make('province')
    ->label('address.fields.province.label')
    ->options(function (callable $get) {
        $region = $get('address_region');
        if (!$region) {
            return Province::pluck('name', 'name')->toArray();
        }
        return Province::where('region_id', Region::where('name', $region)->first()?->id)
            ->pluck('name', 'name')
            ->toArray();
    })
    ->reactive()
    ->afterStateUpdated(fn (callable $set) => $set('address_locality', null)),

Forms\Components\Select::make('address_locality')
    ->label('address.fields.address_locality.label')
    ->options(function (callable $get) {
        $province = $get('province');
        if (!$province) {
            return [];
        }
        return City::where('province_id', Province::where('name', $province)->first()?->id)
            ->pluck('name', 'name')
            ->toArray();
    }),
```

## Mantenimento Dati di Riferimento

È consigliabile mantenere aggiornati i dati di riferimento per:

1. Fusioni di comuni
2. Cambiamenti nelle province (es. riorganizzazioni territoriali)
3. Variazioni nei CAP

Si raccomanda di utilizzare fonti ufficiali come ISTAT per gli aggiornamenti periodici.

## Normalizzazione degli Indirizzi

Per gli indirizzi italiani inseriti dagli utenti, si consiglia di implementare procedure di normalizzazione:

```php
public function normalizeItalianAddress(Address $address): Address
{
    // Normalizza nome regione (es. "lombardia" -> "Lombardia")
    if ($address->address_region) {
        $normalizedRegion = Region::where('name', 'LIKE', $address->address_region)
            ->orWhere('name', 'LIKE', ucfirst(strtolower($address->address_region)))
            ->first();
        
        if ($normalizedRegion) {
            $address->address_region = $normalizedRegion->name;
        }
    }
    
    // Normalizza nome provincia
    if ($address->province) {
        $normalizedProvince = Province::where('name', 'LIKE', $address->province)
            ->orWhere('name', 'LIKE', ucfirst(strtolower($address->province)))
            ->first();
        
        if ($normalizedProvince) {
            $address->province = $normalizedProvince->name;
            $address->province_short = $normalizedProvince->code;
        }
    }
    
    // Normalizza CAP
    if ($address->postal_code) {
        $address->postal_code = preg_replace('/[^0-9]/', '', $address->postal_code);
        
        // Assicura che sia di 5 cifre
        if (strlen($address->postal_code) < 5) {
            $address->postal_code = str_pad($address->postal_code, 5, '0', STR_PAD_LEFT);
        }
    }
    
    return $address;
}
```