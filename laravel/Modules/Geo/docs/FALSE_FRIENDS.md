# False Friends – Geo Module

| Concetto | Interpretazione errata | Corretto |
|---------|------------------------|----------|
| `CoordinatePicker` vs `LatitudeLongitudeInput` | Sono la stessa classe con nomi diversi | Sono due componenti con stato diverso: CoordinatePicker usa campi composti `{lat,lng}`, LatitudeLongitudeInput usa campi separati |
| `dehydrated(false)` | Serve per salvare lat/lng nel modello | Blocca il passaggio dei dati; usare `dehydrateStateUsing()` |
| `leaflet container id` | Usare `#map` è sicuro perché l'ID è nel mio template | In pagine multi-componente gli ID collidono; usare classi `.map-container` |
| `state binding` | `->live()` è l'unico modificatore utile | Defer, Live, Deferred sono scelte intenzionali; usare `$applyStateBindingModifiers()` |
| `map marker assets` | L'icona di default Leaflet va bene per produzione | L'icona default cerca asset su CDN; usare SVG locali |

## Esempi di errore comune

### Errore 1: Ereditarietà errata
```php
// ❌ FALSE FRIEND
class LatitudeLongitudeInput extends CoordinatePicker {}
// ✅ CORRETTO
class LatitudeLongitudeInput extends XotBaseField {}
```

### Errore 2: Container globale
```javascript
// ❌ FALSE FRIEND
const map = L.map('map');
// ✅ CORRETTO
const map = L.map(this.querySelector('.coordinate-picker-map'));
```
