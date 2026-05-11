# geojson-map-lit — Componente Mappa GeoJSON Riutilizzabile

## Ownership

**`Modules/Geo`** è owner di tutti i componenti JS mappa riutilizzabili.
`geojson-map-lit.js` vive qui perché può essere usato da qualsiasi modulo che ha
bisogno di visualizzare una collezione GeoJSON su una mappa Leaflet.

## Regola Architetturale

> **Componenti JS mappa riutilizzabili → SEMPRE in `Modules/Geo/resources/js/components/`**
> 
> Nomi GENERICI, non domain-specific: `geojson-map-lit.js` NON `ticket-map-lit.js` o `farmshop-map-lit.js`.
> MAI in moduli domain (Fixcity, User, ecc.).

## File

```
Modules/Geo/resources/js/components/geojson-map-lit.js
```

## Custom Element

```html
<geojson-map-lit
    id="my-map"
    data-url="/data/points.json"
    style="height:450px;display:block;width:100%"
></geojson-map-lit>
```

## API pubblica

```javascript
// Filtra per qualsiasi valore di feature.properties.type
element.filterByType('waste_collection');

// Mostra tutti i marker
element.filterByType(null);
```

## Evento emesso

```javascript
element.addEventListener('map-loaded', (e) => {
    console.log('Markers loaded:', e.detail.count);
});
```

## GeoJSON Format atteso

```json
{
  "type": "FeatureCollection",
  "features": [{
    "type": "Feature",
    "geometry": { "type": "Point", "coordinates": [lng, lat] },
    "properties": {
      "id": 1,
      "title": "...",
      "type": "waste_collection",
      "type_label": "Raccolta Rifiuti",
      "type_color": "#4caf50",
      "address": "...",
      "status": "pending",
      "url": "/path/to/detail"
    }
  }]
}
```

## Dipendenze (CDN)

Il componente richiede Leaflet e MarkerCluster già presenti nel DOM:

```html
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
```

## Utilizzo dal blade (inline)

```blade
{{-- Inlining del componente dal modulo Geo --}}
<script>
(function () {
{{ file_get_contents(base_path('../Modules/Geo/resources/js/components/ticket-map-lit.js')) }}
})();
</script>
```

## Regola: mai `id="map"`

Il componente usa `class="map-container"` internamente, mai `id="map"`.
Regola: `leaflet-class-selector-governance.md` nel wiki Geo.

## Pattern ispirato a

- [farmshops.eu/direktvermarkter.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js)
- File JSON statico → fetch → L.geoJSON → MarkerCluster

## Riferimenti

- Story: `.planning/stories/8-75-segnalazioni-elenco-map-list.story.md`
- Wiki Fixcity: `Modules/Fixcity/docs/wiki/concepts/segnalazioni-elenco-map-architecture.md`
- Wiki Sixteen: `Themes/Sixteen/docs/wiki/concepts/segnalazioni-elenco-map-integration.md`
- Regola leaflet: `concepts/leaflet-class-selector-governance.md`
