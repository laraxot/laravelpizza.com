# LatitudeLongitudeInput Runtime UX

## Regola

Quando lo stato iniziale `latitude/longitude` è nullo o non numerico, il componente avvia automaticamente la geolocalizzazione.

La stessa regola va applicata ai picker Geo runtime-equivalent:

- se `latitude === null` **oppure** `longitude === null`, la coppia è considerata incompleta;
- il componente deve tentare geolocalizzazione browser e usare la posizione corrente per valorizzare entrambe le coordinate.

## Vincoli UX obbligatori

- controlli mappa sempre visibili:
  - layer switch
  - locate
  - fullscreen
- nessun aggancio Leaflet a id globali

## Implementazione

- Blade passa `auto-locate-on-init` al web component
- Lit esegue `requestGeolocation()` in bootstrap solo quando il flag è attivo
- fallback center rimane disponibile per robustezza rendering
- non mantenere mai una coordinata "mezzo valida" con la seconda mancante

## Collegamenti

- [latitudelongitudeinput-xotbasefield-rule](./latitudelongitudeinput-xotbasefield-rule.md)
- [leaflet-class-selector-governance](./leaflet-class-selector-governance.md)
