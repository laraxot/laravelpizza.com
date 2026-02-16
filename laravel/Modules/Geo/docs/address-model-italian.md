# Modello Address per Indirizzi Italiani

## Struttura Amministrativa Italiana
L'Italia ha una struttura amministrativa specifica che richiede un'attenzione particolare nella modellazione degli indirizzi:

1. **Regioni** (20 totali)
2. **Province** (107 totali, incluse città metropolitane)
3. **Comuni** (circa 7.900)
4. **Frazioni** o località minori

## Implementazione nel Modello Address

Il modello `Address` è stato progettato per supportare questa struttura gerarchica attraverso i seguenti campi:

```php
protected $fillable = [
    // ... altri campi
    'administrative_area_level_1', // Regione
    'administrative_area_level_2', // Provincia
    'administrative_area_level_3', // Comune
    'locality',                    // Frazione o località
    'postal_code',                 // CAP
    // ... altri campi
];
```

### Mappatura dei Campi per Indirizzi Italiani

| Campo del Modello          | Struttura Italiana | Esempio          |
|----------------------------|---------------------|------------------|
| administrative_area_level_1 | Regione            | Lombardia        |
| administrative_area_level_2 | Provincia          | Milano           |
| administrative_area_level_3 | Comune             | Milano           |
| locality                   | Frazione/Località   | Baggio           |
| postal_code                | CAP                | 20146            |
| route                      | Via/Piazza         | Via Roma         |
| street_number              | Numero civico      | 123              |

## Relazioni con Altri Modelli

Per garantire la coerenza dei dati e facilitare le ricerche, il modello `Address` può essere collegato ai modelli esistenti nel modulo Geo:

```php
/**
 * Relazione con il modello Region (Regione).
 */
public function region()
{
    return $this->belongsTo(Region::class, 'administrative_area_level_1', 'code');
}

/**
 * Relazione con il modello Province (Provincia).
 */
public function province()
{
    return $this->belongsTo(Province::class, 'administrative_area_level_2', 'code');
}

/**
 * Relazione con il modello Comune (Comune).
 */
public function comune()
{
    return $this->belongsTo(Comune::class, 'administrative_area_level_3', 'code');
}
```

## Validazione degli Indirizzi Italiani

Per gli indirizzi italiani, è importante implementare regole di validazione specifiche:

1. **CAP**: 5 cifre numeriche
2. **Provincia**: Codice di 2 lettere valido
3. **Regione**: Codice regionale valido
4. **Comune**: Codice ISTAT valido

Esempio di regole di validazione:

```php
$rules = [
    'postal_code' => ['required', 'regex:/^[0-9]{5}$/'],
    'administrative_area_level_1' => ['required', 'exists:regions,code'],
    'administrative_area_level_2' => ['required', 'exists:provinces,code'],
    'administrative_area_level_3' => ['required', 'exists:comuni,code'],
];
```

## Interfacciamento con GeoJsonModel

Il modulo Geo utilizza `GeoJsonModel` per gestire i dati geografici italiani. Il modello `Address` può interfacciarsi con questa implementazione:

```php
// Recupero del codice regione dal nome
$regionCode = GeoJsonModel::getRegionCodeByName($regionName);

// Recupero del codice provincia dal nome
$provinceCode = GeoJsonModel::getProvinceCodeByName($provinceName);

// Recupero del codice comune dal nome
$comuneCode = GeoJsonModel::getComuneCodeByName($comuneName, $provinceCode);
```

## Form di Inserimento Indirizzi

Per semplificare l'inserimento degli indirizzi italiani, è consigliabile implementare un form che:

1. Mostri un dropdown per la selezione della regione
2. Filtri dinamicamente le province in base alla regione selezionata
3. Filtri dinamicamente i comuni in base alla provincia selezionata
4. Filtri dinamicamente i CAP in base al comune selezionato

Esempio di implementazione con Filament:

```php
// In un form Filament
public static function getFormSchema(): array
{
    return [
        'administrative_area_level_1' => Select::make('administrative_area_level_1')
            ->label('Regione')
            ->options(fn () => GeoJsonModel::getRegionsForSelect())
            ->reactive()
            ->required(),
            
        'administrative_area_level_2' => Select::make('administrative_area_level_2')
            ->label('Provincia')
            ->options(fn (callable $get) => 
                GeoJsonModel::getProvincesForSelect($get('administrative_area_level_1')))
            ->reactive()
            ->required()
            ->disabled(fn (callable $get) => !$get('administrative_area_level_1')),
            
        'administrative_area_level_3' => Select::make('administrative_area_level_3')
            ->label('Comune')
            ->options(fn (callable $get) => 
                GeoJsonModel::getComuniForSelect($get('administrative_area_level_2')))
            ->reactive()
            ->required()
            ->disabled(fn (callable $get) => !$get('administrative_area_level_2')),
            
        'postal_code' => Select::make('postal_code')
            ->label('CAP')
            ->options(fn (callable $get) => 
                GeoJsonModel::getCapsForSelect($get('administrative_area_level_3')))
            ->required()
            ->disabled(fn (callable $get) => !$get('administrative_area_level_3')),
    ];
}
```

## Formattazione degli Indirizzi Italiani

La formattazione standard degli indirizzi italiani segue questo schema:

```
Nome Destinatario
Via/Piazza Nome Via, Numero Civico
CAP Comune (Sigla Provincia)
ITALIA
```

Esempio di implementazione:

```php
/**
 * Genera un indirizzo italiano formattato.
 */
public function formatItalianAddress(): string
{
    $parts = [];
    
    // Nome via e numero civico
    if (!empty($this->route)) {
        $addressLine = $this->route;
        if (!empty($this->street_number)) {
            $addressLine .= ', ' . $this->street_number;
        }
        $parts[] = $addressLine;
    }
    
    // CAP, Comune e Provincia
    $locationLine = '';
    if (!empty($this->postal_code)) {
        $locationLine .= $this->postal_code . ' ';
    }
    
    if (!empty($this->administrative_area_level_3)) {
        $locationLine .= $this->administrative_area_level_3;
        
        // Aggiungi sigla provincia tra parentesi
        if (!empty($this->administrative_area_level_2)) {
            $locationLine .= ' (' . $this->administrative_area_level_2 . ')';
        }
    }
    
    if (!empty($locationLine)) {
        $parts[] = $locationLine;
    }
    
    // Paese (se diverso dall'Italia, altrimenti implicito)
    if (!empty($this->country) && strtoupper($this->country) !== 'ITALIA' && strtoupper($this->country_code) !== 'IT') {
        $parts[] = strtoupper($this->country);
    }
    
    return implode("\n", $parts);
}
```

## Ricerca e Filtri

È importante implementare metodi di ricerca specifici per gli indirizzi italiani:

```php
/**
 * Filtra gli indirizzi per regione.
 */
public function scopeInRegion($query, $regionCode)
{
    return $query->where('administrative_area_level_1', $regionCode);
}

/**
 * Filtra gli indirizzi per provincia.
 */
public function scopeInProvince($query, $provinceCode)
{
    return $query->where('administrative_area_level_2', $provinceCode);
}

/**
 * Filtra gli indirizzi per comune.
 */
public function scopeInComune($query, $comuneCode)
{
    return $query->where('administrative_area_level_3', $comuneCode);
}

/**
 * Filtra gli indirizzi per CAP.
 */
public function scopeInPostalCode($query, $postalCode)
{
    return $query->where('postal_code', $postalCode);
}
```

## Conversione da e verso Altri Formati

### Da Google Maps API a Modello Address

```php
/**
 * Popola un indirizzo italiano dai componenti restituiti da Google Maps API.
 */
public function populateFromGoogleComponents(array $components): self
{
    foreach ($components as $component) {
        $types = $component['types'] ?? [];
        $value = $component['long_name'] ?? '';
        $shortValue = $component['short_name'] ?? '';
        
        if (in_array('postal_code', $types)) {
            $this->postal_code = $value;
        } elseif (in_array('administrative_area_level_1', $types)) {
            // Regione
            $this->administrative_area_level_1 = $value;
        } elseif (in_array('administrative_area_level_2', $types)) {
            // Provincia
            $this->administrative_area_level_2 = $shortValue; // Usiamo la sigla (MI, RM, ecc.)
        } elseif (in_array('administrative_area_level_3', $types)) {
            // Comune
            $this->administrative_area_level_3 = $value;
        } elseif (in_array('locality', $types)) {
            $this->locality = $value;
        } elseif (in_array('route', $types)) {
            $this->route = $value;
        } elseif (in_array('street_number', $types)) {
            $this->street_number = $value;
        } elseif (in_array('country', $types)) {
            $this->country = $value;
            $this->country_code = $shortValue;
        }
    }
    
    return $this;
}
```

## Best Practices per Indirizzi Italiani

1. **Utilizzare codici standard**: Usare i codici ISTAT per comuni, province e regioni
2. **Validare il CAP**: Verificare che il CAP sia coerente con il comune
3. **Normalizzazione**: Normalizzare i nomi delle vie (es. "VIA" → "Via")
4. **Abbreviazioni**: Gestire le abbreviazioni comuni (es. "S." per "San/Santo")
5. **Omonimi**: Gestire i comuni con lo stesso nome ma in province diverse

## Geocodifica degli Indirizzi Italiani

Per ottenere le coordinate geografiche degli indirizzi italiani, è possibile utilizzare:

1. **Google Geocoding API**: Ottimo per la copertura ma a pagamento
2. **OpenStreetMap/Nominatim**: Alternativa open source con buona copertura in Italia
3. **ISTAT/IGM**: Fonti ufficiali italiane per dati geografici

Esempio di implementazione:

```php
/**
 * Geocodifica un indirizzo italiano.
 */
public function geocode(): bool
{
    $address = $this->formatItalianAddress();
    
    // Utilizzo di un servizio di geocodifica
    $result = app(GeocodingService::class)->geocode($address);
    
    if ($result && isset($result['latitude'], $result['longitude'])) {
        $this->latitude = $result['latitude'];
        $this->longitude = $result['longitude'];
        $this->save();
        
        return true;
    }
    
    return false;
}
```

## Considerazioni per Multilingua

Per supportare gli indirizzi italiani in un contesto multilingua:

1. **Traduzioni**: Mantenere i nomi originali italiani ma fornire traduzioni per le etichette dei form
2. **Formattazione**: Adattare la formattazione in base alla lingua dell'utente
3. **Validation**: Mantenere regole di validazione specifiche per l'Italia

## Conclusione

La corretta gestione degli indirizzi italiani richiede una struttura dedicata che rispetti la suddivisione amministrativa del paese. Il modello `Address` proposto, con i campi e le relazioni specifiche per regioni, province e comuni italiani, fornisce una base solida per implementare un sistema di indirizzi completo e conforme agli standard italiani.
