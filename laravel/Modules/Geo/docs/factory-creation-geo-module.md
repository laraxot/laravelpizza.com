# Factory Creation - Geo Module

## ERRORE GRAVISSIMO RISOLTO NEL MODULO GEO

Il modulo Geo aveva **10 factory mancanti** su 16 modelli totali. Alcuni modelli erano speciali (non Eloquent).

## 🎓 LEZIONI SPECIFICHE GEO MODULE

### 1. **Modelli Speciali Senza Factory**
- **GeoJsonModel**: Classe astratta per dati JSON statici - NON necessita factory
- **ComuneJson**: Estende GeoJsonModel, dati readonly - NON necessita factory
- **BaseModel, BasePivot**: Classi astratte - NON necessitano factory

### 2. **Modelli Geografici Realistici**
```php
// Dati geografici italiani realistici
$italianCities = ['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo'];
$italianRegions = ['Lombardia', 'Lazio', 'Campania', 'Piemonte', 'Sicilia'];

// Coordinate Italia
'latitude' => $this->faker->latitude(35.0, 47.0),
'longitude' => $this->faker->longitude(6.0, 19.0),
```

### 3. **PHPStan Tipizzazione Geo**
```php
// Cast espliciti per concatenazioni
/** @var string $street */
$street = (string) $this->faker->randomElement($italianStreets);
$fullAddress = $street . ' ' . (string) $this->faker->numberBetween(1, 999);

// Sprintf con parametri tipizzati
'formatted_address' => sprintf('%s, %s, %s, Italia', 
    (string) ($attributes['street'] ?? 'Via Roma 1'), 
    $city, 
    $state ?? (string) ($attributes['state'] ?? 'Lazio')
),
```

## 🏆 FACTORY CREATE GEO MODULE

### ✅ COMPLETATE (8/8 necessarie)
1. ✅ **AddressFactory** - Indirizzi italiani realistici
2. ✅ **LocationFactory** - Posizioni geografiche
3. ✅ **PlaceFactory** - Luoghi (ospedali, cliniche)
4. ✅ **PlaceTypeFactory** - Tipi di luoghi
5. ✅ **CountyFactory** - Contee italiane
6. ✅ **StateFactory** - Regioni italiane
7. ✅ **LocalityFactory** - Località specifiche
8. ✅ **GeoNamesCapFactory** - Codici postali

### ✅ GIÀ ESISTENTI (3/3)
- ComuneFactory ✅
- ProvinceFactory ✅  
- RegionFactory ✅

### ❌ NON NECESSARIE (2/2)
- **ComuneJson** - Non è modello Eloquent
- **GeoJsonModel** - Classe astratta

## 🎯 PATTERN GEOGRAFICI IMPLEMENTATI

### 1. **Coordinate Italiane**
- Latitudine: 35.0 - 47.0 (confini Italia)
- Longitudine: 6.0 - 19.0 (confini Italia)
- CAP: formato [0-9]{5}

### 2. **Stati Geografici**
```php
public function milano(): static
{
    return $this->state(fn (array $attributes): array => [
        'name' => 'Milano',
        'latitude' => 45.4642,
        'longitude' => 9.1900,
    ]);
}
```

### 3. **Relazioni Geografiche**
- Address → Comune
- Place → PlaceType
- Location → coordinate specifiche

## 🚀 BENEFICI OTTENUTI

### 1. **Testing Geografico Completo**
- Tutti i modelli geografici testabili
- Coordinate realistiche per test
- Relazioni geografiche verificabili

### 2. **Seeding Realistico**
- Dati italiani coerenti
- Coordinate corrette
- Indirizzi verosimili

### 3. **Sviluppo Semplificato**
- Debug geografico facilitato
- Test di geolocalizzazione possibili
- Prototipazione rapida

## 🔗 COLLEGAMENTI

- [Factory Lessons Learned CRITICAL](../../../docs/factory-lessons-learned-CRITICAL.md)
- [Geo Module README](./README.md)
- [Geographic Data Documentation](./geographic-data.md)

## ⚠️ REGOLE GEO SPECIFICHE

1. **Coordinate italiane** sempre nei bounds corretti
2. **Dati realistici** per città, regioni, CAP
3. **Cast espliciti** per concatenazioni stringhe
4. **PHPStan livello 9** sempre validato
5. **Modelli readonly** non necessitano factory

**MODULO GEO COMPLETAMENTE RIPRISTINATO!**

*Creato: 2025-01-06*
*Modulo: Geo - 8/8 factory necessarie completate*
*Status: ✅ ERRORE GRAVISSIMO RISOLTO*
