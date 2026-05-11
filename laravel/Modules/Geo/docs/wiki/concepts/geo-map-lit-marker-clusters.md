# Marker Clusters in geo-map-lit

## REGOLA PERMANENTE: Marker clusters ispirati a farmshops.eu (direktvermarkter.js)

### Implementazione

Il componente `geo-map-lit` implementa marker clusters ispirati a [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js) con le seguenti caratteristiche:

- **Stile circolare**: Tutti i cluster hanno forma circolare con bordo colore istituzionale #0066cc
- **Dimensioni dinamiche**: 4 varianti di dimensione basate sul numero di marker nel cluster, con adattamento viewport mobile/tablet
- **Breakdown per categoria (zoom ≥ 8)**: Mostra icone colorate per tipo di segnalazione presente nel cluster
- **Performance**: Usa `L.markerClusterGroup` con ottimizzazioni per caricamento chunkato

### Codice

#### Configurazione MarkerClusterGroup
```javascript
this._markersLayer = L.markerClusterGroup({
    minimumClusterSize: 2,
    maxClusterRadius: (zoom) => zoom < 12 ? 80 : 45,
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true,
    iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
});
```

#### Creazione icona cluster personalizzata
```javascript
_createClusterIcon(cluster) {
    const markers = cluster.getAllChildMarkers();
    const count = markers.length;
    const zoom = this._map ? this._map.getZoom() : 0;
    const iconSize = this._computeClusterSize(count);

    // zoom >= 8: count + dots presenza tipo
    // zoom < 8: count-only
    // size: 56 / 68 / 80 / 92 con riduzione su viewport stretti
}
```

#### CSS per l'aspetto dei cluster
```css
.marker-cluster {
    background: #fff !important;
    border: 3px solid #0066cc !important;
    border-radius: 50% !important;
    width: 52px !important;
    height: 52px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    color: #0066cc !important;
    box-shadow: 0 2px 8px rgba(0,102,204,.35) !important;
}
.marker-cluster.marker-cluster-small  { width: 40px !important; height: 40px !important; font-size: 13px !important; border-width: 2px !important; }
.marker-cluster.marker-cluster-medium { width: 52px !important; height: 52px !important; font-size: 16px !important; border-width: 3px !important; }
.marker-cluster.marker-cluster-large { width: 64px !important; height: 64px !important; font-size: 18px !important; border-width: 3px !important; }
.geo-cluster-lod {
    background: #fff !important;
    border: 3px solid #0066cc !important;
    border-radius: 50% !important;
    width: 52px !important;
    height: 52px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: 700 !important;
    font-size: 13px !important;
    box-shadow: 0 2px 6px rgba(0,0,0,.25) !important;
}
```

### Aggiornamenti apportati

1. **Modifica CSS**: Aggiunti stili `.marker-cluster`, `.marker-cluster-small`, `.marker-cluster-medium`, `.marker-cluster-large` per replicare lo stile circolare di farmshops.eu
2. **Aggiornamento metodo `_createClusterIcon`**: Implementato breakdown per tipo con SVG colorati per zoom ≥ 8 + size dinamica in base alla densita
3. **Rimozione duplicazione CSS**: Consolidato tutti gli stili dei cluster in un unico approccio coerente
4. **Single-marker guard**: introdotto `minimumClusterSize: 2` per evitare cluster a 1 marker

### Story di riferimento

- Story 8-81: geo-map-lit: farmshops.eu parity — implementazione marker cluster ispirati a direktvermarkter.js
- Story 8-78: geo-map-lit segnalazioni-elenco + controlli unificati
- Story 8-79: Fix controlli mappa e ricerca indirizzo

### Validazione

```bash
# Verifica che non ci siano riferimenti a marker CDN/unpkg
grep -r "unpkg" laravel/Modules/Geo/resources/js/
# Deve ritornare 0 risultati

# Verifica che non ci siano L.Icon.Default
grep -r "Icon.Default" laravel/Modules/Geo/resources/js/
# Deve ritornare 0 risultati
```