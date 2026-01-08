# Models Analysis - Geo Module

## Factory e Seeder Status

### Models con Factory ✅
- Address - AddressFactory
- Comune - ComuneFactory
- County - CountyFactory
- Location - LocationFactory 
- Place - PlaceFactory
- PlaceType - PlaceTypeFactory
- Province - ProvinceFactory
- Region - RegionFactory
- State - StateFactory
- GeoNamesCap - GeoNamesCapFactory (newly created)
- Locality - LocalityFactory (exists but not needed - see below)

### Models senza Factory ❌
- GeoJsonModel - Non necessaria (classe base astratta)
- ComuneJson - Non necessaria (facade readonly per dati JSON)

### Seeders Status
- ✅ GeoDatabase - Main seeder per il modulo

## Models Business Logic Analysis

### 🟢 Core Business Models (CRITICAL for application)
1. **Address** - Indirizzi fisici per studi medici e pazienti
2. **Place** - Luoghi/strutture mediche 
3. **PlaceType** - Tipologie di strutture (Ospedale, Clinica, Studio, etc.)
4. **Comune** - Comuni italiani per form geografici
5. **Province** - Province italiane
6. **Region** - Regioni italiane

### 🟡 Support Models (USEFUL but not critical)
1. **Location** - Coordinate geografiche generiche
2. **County** - Contee (principalmente per compatibilità internazionale)
3. **State** - Stati/Regioni (duplicazione di Region)
4. **GeoNamesCap** - Database CAP (già coperto da Comune)

### 🔴 Non-Business Models (NOT NEEDED for business logic)
1. **BaseModel** - Classe base astratta (no factory needed)
2. **BaseMorphPivot** - Classe base pivot (no factory needed)
3. **BasePivot** - Classe base pivot (no factory needed)
4. **GeoJsonModel** - Classe base astratta per dati JSON (no factory needed)
5. **ComuneJson** - Facade readonly per JSON data (no factory needed)
6. **Locality** - Modello Sushi che genera dati da Comune (no factory needed)

## Recommendations

### Models da Rimuovere/Deprecare
- **County** - Duplicazione di Province/Region, non utilizzato in Italia
- **State** - Duplicazione di Region
- **GeoNamesCap** - Funzionalità già coperta da Comune

### Models da Mantenere
- **Address, Place, PlaceType** - Core business
- **Comune, Province, Region** - Essenziali per form geografici italiani
- **Location** - Utile per coordinate generiche

### Factory Missing che Servono
Tutte le factory business sono già state create ✅

### Seeder Missing che Servono
- **AddressSeeder** - Per dati di test indirizzi
- **PlaceSeeder** - Per strutture mediche di test  
- **PlaceTypeSeeder** - Per tipologie strutture standard

## Usage in Application

### Frontend Forms
- Address: Form di registrazione studi, pazienti
- Place: Selezione strutture mediche
- PlaceType: Categorizzazione strutture
- Comune/Province/Region: Form geografici italiani

### Business Logic
- Address: Geolocalizzazione appuntamenti
- Place: Gestione sedi operative
- PlaceType: Filtering and categorization

## Notes
- I modelli Sushi (Locality) non necessitano factory perché generano dati dinamicamente
- I modelli JSON readonly non necessitano factory perché sono facade su dati statici
- Le classi base astratte non necessitano factory