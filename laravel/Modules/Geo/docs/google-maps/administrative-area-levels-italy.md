# Google Maps Administrative Area Levels - Italy Mapping

## Official Documentation Reference

Based on Google Maps Geocoding API official documentation:
https://developers.google.com/maps/documentation/geocoding/requests-geocoding#Types

## Correct Mapping for Italy

| Google Maps Type | Italian Term | Description | Example |
|------------------|--------------|-------------|---------|
| `administrative_area_level_1` | **Regione** | First-order civil entity below country level | Lazio, Lombardia, Toscana |
| `administrative_area_level_2` | **Provincia** | Second-order civil entity below country level | Roma, Milano, Firenze |
| `administrative_area_level_3` | **Comune** | Third-order civil entity - minor civil division | Roma, Milano, Firenze |
| `country` | **Nazione** | National political entity | Italia |
| `locality` | **Località** | Incorporated city or town political entity | Roma (city) |

## Important Clarifications

### Common Confusions
1. **country ≠ Paese**: While "Paese" is correct in general Italian, "Nazione" is more precise for administrative contexts
2. **administrative_area_level_1 ≠ Nazione**: It's "Regione" (Region), not the country itself
3. **administrative_area_level_2 ≠ Regione**: It's "Provincia" (Province), not the region
4. **administrative_area_level_3 ≠ Provincia**: It's "Comune" (Municipality/Commune), not the province

### Italian Administrative Hierarchy
```
Nazione (Italy)
├── Regione (Lazio)
│   ├── Provincia (Roma)
│   │   ├── Comune (Roma)
│   │   ├── Comune (Guidonia Montecelio)
│   │   └── ...
│   └── ...
└── ...
```

## Code Implementation

### Correct Translation Mapping
```php
// In lang/it/address_item.php
'administrative_area_level_1' => [
    'label' => 'Regione',
    'placeholder' => 'Inserisci la regione',
    'helper_text' => 'Regione di riferimento',
    'description' => 'Nome della regione',
],
'administrative_area_level_2' => [
    'label' => 'Provincia',
    'placeholder' => 'Inserisci la provincia',
    'helper_text' => 'Provincia di riferimento',
    'description' => 'Sigla della provincia (es. RM)',
],
'administrative_area_level_3' => [
    'label' => 'Comune',
    'placeholder' => 'Inserisci il comune',
    'helper_text' => 'Comune di riferimento',
    'description' => 'Nome del comune',
],
'country' => [
    'label' => 'Nazione',
    'placeholder' => 'Inserisci la nazione',
    'helper_text' => 'Stato o nazione',
    'description' => 'Nome della nazione (es. Italia)',
],
```

## Real-World Example

Geocoding "Colosseo, Roma, Italia" returns:
```json
{
  "address_components": [
    {
      "long_name": "Roma",
      "types": ["locality", "political"]
    },
    {
      "long_name": "Roma",
      "types": ["administrative_area_level_3", "political"]
    },
    {
      "long_name": "Città Metropolitana di Roma",
      "types": ["administrative_area_level_2", "political"]
    },
    {
      "long_name": "Lazio",
      "types": ["administrative_area_level_1", "political"]
    },
    {
      "long_name": "Italia",
      "types": ["country", "political"]
    }
  ]
}
```

## Best Practices

1. **Always use correct Italian terms** in translations
2. **Document the mapping** between Google types and Italian terms
3. **Test with real addresses** to verify correct mapping
4. **Handle edge cases** like metropolitan cities (Città Metropolitana)
5. **Consider postal codes** (CAP) which are separate from administrative levels

## References
- [Google Maps Geocoding API - Address Types](https://developers.google.com/maps/documentation/geocoding/requests-geocoding#Address_types)
- [Italian Administrative Division](https://en.wikipedia.org/wiki/Regions_of_Italy)
- [Provinces of Italy](https://en.wikipedia.org/wiki/Provinces_of_Italy)
- [Municipalities of Italy](https://en.wikipedia.org/wiki/Municipalities_of_Italy)