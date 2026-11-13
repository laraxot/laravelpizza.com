# Bad Practices – Geo Module

- ❌ **Evita** `L.Icon.Default` o URL CDN per marker (legge `map-marker-custom-asset.md`)
- ❌ **Non usare** `CoordinatePicker` come base per `LatitudeLongitudeInput` (viola `latitudelongitudeinput-extends-xotbasefield.md`)
- ❌ **Non utilizzare** `dehydrated(false)` sui field composti (sospende il passaggio lat/lng al modello)
- ❌ **Non inserire** script inline nei template Blade; usa componenti Lit separati (`lit-element-placement.md`)
- ❌ **Non ripetere** stili CSS Leaflet già definiti in `theme.css`; includi solo override.
