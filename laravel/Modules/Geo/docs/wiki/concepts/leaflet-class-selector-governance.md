# Leaflet Class Selector Governance

## Regola

Nei componenti mappa del modulo Geo, Leaflet deve essere montato usando classi locali del componente, non id globali.

## Esempio corretto

```js
const container = this.querySelector('.coordinate-picker-map');
```

## Esempio da evitare

```js
const container = document.getElementById('map');
```

## Motivazione tecnica

- evita collisioni quando esistono più picker nello stesso wizard/step
- riduce coupling tra markup e runtime globale
- migliora riuso, testabilità e manutenzione del componente

## Impatto pratico

- tutte le nuove mappe devono introdurre una classe locale dedicata (`.js-*` o `.xyz-map-container`)
- i bridge Alpine devono cercare il custom element via `this.$el.querySelector(...)`
- i web component Lit devono cercare il pane mappa via `this.querySelector(...)`

## Riferimenti

- [map-picker-family-architecture](./map-picker-family-architecture.md)
- [map-picker-runtime-asset-governance](./map-picker-runtime-asset-governance.md)
