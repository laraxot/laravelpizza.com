# Geo Module - Code Coverage

## Percentuale coverage

**~2%** (stima su suite root: 2 test)

## Contesto misurazione

- **Suite eseguita**: `tests/Unit` + `tests/Feature` (root)
- **Test moduli**: i test in `Modules/Geo/tests/` non sono inclusi; alcuni falliscono (es. HasAddressTest: `Target class [config] does not exist`)
- **File analizzati**: solo `Modules/Geo/app/`

## Riflessioni

1. **Modulo geolocalizzazione**: molte Actions (GoogleMaps, Nominatim, Bing, ecc.), DTO, contratti; coverage molto basso.
2. **Punti coperti**: contratti (CalculateDistanceActionContract, GeocodingServiceInterface, HasGeolocation), GeoData.
3. **Gap principali**: tutte le Actions geocoding, MapBlock, AddressField, eccezioni, Comune/Provincia models.
4. **Blocchi noti**: HasAddressTest richiede bootstrap config; verificare TestCase e `config()` in test.
5. **Priorità**: fix HasAddressTest; coprire GetCoordinatesFromGoogleMapsAction, GetAddressFromNominatimAction; poi MapBlock e AddressField.

## Comando verifica

```bash
cd laravel && php artisan test --coverage --min=0
```

## Collegamenti

- [geo-overview](../geo-overview.md)
