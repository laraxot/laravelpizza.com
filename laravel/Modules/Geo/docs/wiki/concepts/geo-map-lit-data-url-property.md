---
type: concept
module: Geo
<<<<<<< HEAD
component: geo-map-lit
=======
component: map-lit
>>>>>>> 40b96bcd6 (.)
created: 2026-04-30
updated: 2026-04-30
stories:
  - 8-81-geo-map-lit-farmshops-parity
<<<<<<< HEAD
  - 8-78-segnalazioni-elenco-polish
---

# `data-url` Property — `geo-map-lit` Component

## Scopo

Aggiunta della proprietà `dataUrl` (attribute `data-url`) al Web Component `<geo-map-lit>` per permettere il caricamento dinamico del file GeoJSON da un URL configurabile.
=======
  - 8-78-ticket-list-polish
---

# `data-url` Property — `map-lit` Component

## Scopo

Aggiunta della proprietà `dataUrl` (attribute `data-url`) al Web Component `<map-lit>` per permettere il caricamento dinamico del file GeoJSON da un URL configurabile.
>>>>>>> 40b96bcd6 (.)

## Problema risolto

Precedentemente l'URL del GeoJSON era hardcoded in `DEFAULT_TICKETS_JSON_URL = '/data/tickets.json'`. Questo impediva di riutilizzare il componente con URL diversi senza modificare il sorgente JS.

## Implementazione

### 1. Dichiarazione proprietà

```javascript
<<<<<<< HEAD
// In GeoMapLit class, static properties
=======
// In MapLit class, static properties
>>>>>>> 40b96bcd6 (.)
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
<<<<<<< HEAD
<geo-map-lit
    id="segnalazioni-map"
    data-url="/data/tickets.json"
    active-layer="markers"
></geo-map-lit>
=======
<map-lit
    id="segnalazioni-map"
    data-url="/data/tickets.json"
    active-layer="markers"
></map-lit>
>>>>>>> 40b96bcd6 (.)
```

## Vantaggi

- **Riusabilità**: stesso componente con URL diversi
- **Coerenza**: segue pattern `coordinate-picker-lit` che usa `state` per le coordinate
- **Sovrascrivibile**: priorità `dataUrl` property > `data-url` attribute > default

## Test di verifica

```bash
# Verifica che il componente legga l'URL dal data attribute
<<<<<<< HEAD
curl -s http://127.0.0.1:8000/it/tests/segnalazioni-elenco | grep 'data-url'
=======
curl -s http://127.0.0.1:8000/it/tests/ticket-list | grep 'data-url'
>>>>>>> 40b96bcd6 (.)
```

## Regole correlate

<<<<<<< HEAD
- [geojson-map-lit-component](../entities/geo-map-lit.md) — entità principale
- [static-geo-map-widget-pattern](../concepts/static-geo-map-widget-pattern.md) — pattern per pagine pubbliche
- [segnalazioni-elenco-map-integration](../../../Themes/Sixteen/docs/wiki/concepts/segnalazioni-elenco-map-integration.md) — integrazione tema
=======
- [map-lit-component](./map-lit-component.md) — entità principale per ticket-list
- [static-geo-map-widget-pattern](../concepts/static-geo-map-widget-pattern.md) — pattern per pagine pubbliche
- [ticket-list-map-integration](../../../Themes/Sixteen/docs/wiki/concepts/ticket-list-map-integration.md) — integrazione tema
>>>>>>> 40b96bcd6 (.)
