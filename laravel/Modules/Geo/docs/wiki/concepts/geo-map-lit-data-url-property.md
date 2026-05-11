---
type: concept
module: Geo
component: geo-map-lit
created: 2026-04-30
updated: 2026-04-30
stories:
  - 8-81-geo-map-lit-farmshops-parity
  - 8-78-segnalazioni-elenco-polish
---

# `data-url` Property — `geo-map-lit` Component

## Scopo

Aggiunta della proprietà `dataUrl` (attribute `data-url`) al Web Component `<geo-map-lit>` per permettere il caricamento dinamico del file GeoJSON da un URL configurabile.

## Problema risolto

Precedentemente l'URL del GeoJSON era hardcoded in `DEFAULT_TICKETS_JSON_URL = '/data/tickets.json'`. Questo impediva di riutilizzare il componente con URL diversi senza modificare il sorgente JS.

## Implementazione

### 1. Dichiarazione proprietà

```javascript
// In GeoMapLit class, static properties
static properties = {
    // ...altre proprietà...
    dataUrl: { type: String, attribute: 'data-url' },
};
```

### 2. Utilizzo in `_loadGeoJson()`

```javascript
_loadGeoJson() {
    // Fallback: usa data-url attribute, poi dataset.url, poi default
    const url = this.dataUrl || this.dataset?.url || DEFAULT_TICKETS_JSON_URL;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            // ...processing...
        });
}
```

### 3. Uso nella Blade

```blade
<geo-map-lit
    id="segnalazioni-map"
    data-url="/data/tickets.json"
    active-layer="markers"
></geo-map-lit>
```

## Vantaggi

- **Riusabilità**: stesso componente con URL diversi
- **Coerenza**: segue pattern `coordinate-picker-lit` che usa `state` per le coordinate
- **Sovrascrivibile**: priorità `dataUrl` property > `data-url` attribute > default

## Test di verifica

```bash
# Verifica che il componente legga l'URL dal data attribute
curl -s http://127.0.0.1:8000/it/tests/segnalazioni-elenco | grep 'data-url'
```

## Regole correlate

- [geojson-map-lit-component](../entities/geo-map-lit.md) — entità principale
- [static-geo-map-widget-pattern](../concepts/static-geo-map-widget-pattern.md) — pattern per pagine pubbliche
- [segnalazioni-elenco-map-integration](../../../Themes/Sixteen/docs/wiki/concepts/segnalazioni-elenco-map-integration.md) — integrazione tema
