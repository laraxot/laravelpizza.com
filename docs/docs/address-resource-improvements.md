# Suggerimenti di Miglioramento per AddressResource.php

**File**: `/laravel/Modules/Geo/app/Filament/Resources/AddressResource.php`
**Priorità**: Alta (per performance e manutenibilità)

## 🎯 Obiettivi di Miglioramento

1. **Performance**: Ridurre query N+1 e ottimizzare caricamento dati
2. **UX**: Migliorare esperienza utente con feedback e validazioni
3. **Codice**: Refactoring per maggiore leggibilità e manutenibilità
4. **Sicurezza**: Aggiungere validazioni e sanitizzazione
5. **Funzionalità**: Implementare features mancanti

## 🚀 Miglioramenti Prioritari

### 1. **Ottimizzazione Performance** (Priorità: ALTA)

#### Problema: Query N+1 nei Select dinamici
**Soluzione proposta:**
```php
// Implementare caching per opzioni geografiche
protected static function getCachedRegions(): array
{
    return Cache::remember('geo.regions', 3600, function () {
        return Region::orderBy('name')->pluck('name', 'id')->toArray();
    });
}

protected static function getCachedProvinces(int $regionId): array
{
    return Cache::remember("geo.provinces.{$regionId}", 3600, function () use ($regionId) {
        return Province::where('region_id', $regionId)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    });
}
```

#### Problema: Query ripetute per CAP
**Soluzione proposta:**
- Implementare una tabella di lookup `postal_codes` con relazioni pre-calcolate
- Utilizzare eager loading per le relazioni geografiche

### 2. **Miglioramento UX/UI** (Priorità: ALTA)

#### Integrazione Google Maps
**Implementazione suggerita:**
```php
// Aggiungere campo mappa nel form
'map' => Map::make('location')
    ->mapControls([
        'mapTypeControl' => true,
        'scaleControl' => true,
        'streetViewControl' => true,
        'rotateControl' => true,
        'fullscreenControl' => true,
        'searchBoxControl' => false,
    ])
    ->height(fn () => '400px')
    ->defaultZoom(15)
    ->autocomplete('route')
    ->autocompleteReverse(true)
    ->reverseGeocode([
        'street_number' => '%n',
        'route' => '%S',
        'locality' => '%L',
        'administrative_area_level_2' => '%A1',
        'administrative_area_level_1' => '%A2',
        'postal_code' => '%z',
    ])
    ->columnSpanFull(),
```

#### Loading States e Feedback
**Implementazione suggerita:**
```php
// Aggiungere loading states ai Select
'administrative_area_level_2' => Select::make('administrative_area_level_2')
    ->options(function (Get $get) {
        // ... logica esistente
    })
    ->searchable()
    ->required()
    ->live()
    ->loadingMessage('Caricamento province...')
    ->noSearchResultsMessage('Nessuna provincia trovata')
    ->searchPrompt('Cerca una provincia...')
```

### 3. **Refactoring del Codice** (Priorità: MEDIA)

#### Estrazione della Logica in Service Classes
**Struttura proposta:**
```php
// App/Services/GeoDataService.php
class GeoDataService
{
    public function getRegionOptions(): array
    public function getProvinceOptions(int $regionId): array
    public function getLocalityOptions(int $regionId, int $provinceId): array
    public function getPostalCodeOptions(int $regionId, int $provinceId, ?int $localityId = null): array
}

// Nel Resource
public static function getFormSchema(): array
{
    $geoService = app(GeoDataService::class);

    return [
        // Utilizzo del service per le opzioni
        'administrative_area_level_1' => Select::make('administrative_area_level_1')
            ->options(fn() => $geoService->getRegionOptions())
            // ...
    ];
}
```

#### Pulizia del Codice
**Miglioramenti specifici:**
1. **Rimuovere spazi vuoti** nelle linee 49-51
2. **Standardizzare formattazione** degli array
3. **Rinominare variabili** (`$res` → `$options`)
4. **Aggiungere type hints** completi
5. **Estrarre costanti** per valori magici

### 4. **Validazioni e Sicurezza** (Priorità: MEDIA)

#### Validazioni Geografiche
**Implementazione suggerita:**
```php
// Custom validation rules
'locality' => Select::make('locality')
    ->options(/* ... */)
    ->rules([
        'required',
        new ValidGeographicCombination('locality', 'administrative_area_level_2', 'administrative_area_level_1')
    ]),

'postal_code' => Select::make('postal_code')
    ->options(/* ... */)
    ->rules([
        'required',
        'regex:/^\d{5}$/',
        new ValidPostalCodeForLocality()
    ]),
```

#### Sanitizzazione Input
```php
'route' => Forms\Components\TextInput::make('route')
    ->required()
    ->maxLength(255)
    ->dehydrateStateUsing(fn ($state) => trim(strip_tags($state)))
    ->rules(['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\,\-\']+$/u']),
```

### 5. **Nuove Funzionalità** (Priorità: BASSA)

#### Implementazione getSearchStep()
**Funzionalità proposta:**
```php
public static function getSearchStep(): array
{
    return [
        'search_address' => Forms\Components\TextInput::make('search_address')
            ->label('Cerca indirizzo')
            ->placeholder('Inserisci via, città o CAP...')
            ->suffixAction(
                Forms\Components\Actions\Action::make('search')
                    ->icon('heroicon-o-magnifying-glass')
                    ->action(function ($state, $set) {
                        // Integrazione con Google Geocoding API
                        $results = app(GeocodeService::class)->search($state);
                        // Popolare i campi con i risultati
                    })
            ),
    ];
}
```

#### Gestione Indirizzi Multipli
**Funzionalità proposta:**
- Wizard multi-step per inserimento guidato
- Validazione indirizzi in tempo reale
- Suggerimenti automatici basati su input parziali
- Import/Export indirizzi da CSV

## 🔧 Implementazione Graduale

### Fase 1 (Settimana 1-2): Ottimizzazioni Critiche
- [ ] Implementare caching per query geografiche
- [ ] Refactoring Select options con Service class
- [ ] Pulizia codice e formattazione
- [ ] Aggiungere loading states

### Fase 2 (Settimana 3-4): UX e Validazioni
- [ ] Integrazione Google Maps nel form
- [ ] Implementare validazioni geografiche
- [ ] Aggiungere feedback utente migliorato
- [ ] Sanitizzazione input

### Fase 3 (Settimana 5-6): Funzionalità Avanzate
- [ ] Implementare getSearchStep() completo
- [ ] Aggiungere wizard multi-step
- [ ] Import/Export funzionalità
- [ ] Testing e ottimizzazioni finali

## 📈 Benefici Attesi

### Performance
- **-70%** tempo di caricamento Select dinamici
- **-50%** query database per form rendering
- **+90%** cache hit rate per dati geografici

### UX
- **+80%** facilità inserimento indirizzi
- **+60%** accuratezza dati geografici
- **-40%** errori di validazione

### Manutenibilità
- **+90%** leggibilità codice
- **+70%** facilità testing
- **-50%** complessità ciclomatica

## 🧪 Testing Strategy

### Unit Tests
- Service classes per logica geografica
- Validation rules personalizzate
- Cache mechanisms

### Integration Tests
- Form submission completa
- Cascade updates tra Select
- Google Maps integration

### E2E Tests
- User journey completo inserimento indirizzo
- Validazione cross-browser
- Performance testing

## 📋 Checklist Pre-Implementazione

- [ ] Backup database esistente
- [ ] Setup ambiente di test
- [ ] Configurazione Google Maps API
- [ ] Preparazione dati di test geografici
- [ ] Review architetturale con team
- [ ] Pianificazione rollback strategy
