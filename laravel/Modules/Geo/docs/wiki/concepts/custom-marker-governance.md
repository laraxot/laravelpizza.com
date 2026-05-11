# Custom Marker Implementation for Geo Module

## Regola: No default Leaflet markers

Tutti i marker nel modulo Geo devono usare icon custom SVG/PNG, non i marker di default di Leaflet.

## Assets disponibili nel progetto

### SVG custom
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/svg/location-animated.svg` - marker animato
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/svg/geo-icon.svg` - icona geo standard
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/svg/map-animated.svg` - mappa animata

### PNG custom
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/img/direktvermarkter.png` - da farmshops.eu (esempio)
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/img/a-pin2.png` - pin personalizzato
- `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/img/h-pin2.png` - pin personalizzato

## Esempio corretto

```js
// In map-picker-lit.js
const icon = L.divIcon({
    html: '<div class="custom-marker" style="background-image: url(/img/custom-marker.png);"...>',
    className: 'custom-marker',
    iconSize: [35, 45],
    iconAnchor: [17, 45],
});
```

## Motivazione tecnica

- evita dipendenze da CDN esterni (unpkg.com)
- migliora performance con assets locali
- permette personalizzazione completa del design
- riduce coupling con librerie esterne

## Impatto pratico

- tutti i nuovi marker devono usare icon custom
- i CSS devono includere classi per styling dei marker custom
- i componenti devono caricare assets da /resources/img/ o /resources/svg/

## Riferimenti

- [Custom marker example from farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js)
- [MapPickerLit component](./map-picker-lit.md)
- [CoordinatePicker component](./coordinate-picker.md)