# Conversione farmshops.eu -> map-lit.js (Lit.dev)

## Panoramica
Questa documentazione descrive il processo di migrazione della logica di visualizzazione mappe dal progetto `farmshops.eu` (`direktvermarkter.js`) al componente Web nativo `<map-lit>` basato su Lit.dev.

## Corrispondenza Funzionale (1:1)

| Feature | direktvermarkter.js (jQuery) | map-lit.js (Lit.dev) | Note |
|---------|-----------------------------|----------------------|------|
| **Inizializzazione** | Inizializzazione globale `L.map` | Incapsulata nel lifecycle `firstUpdated()` | Utilizza `window.L = L` per compatibilità plugin. |
| **Data Fetching** | Variabile globale o `$.getJSON` | Fetch nativo con validazione rigorosa delle coordinate | Risolto errore `TypeError: lat`. |
| **Clustering** | `L.markerClusterGroup` custom | Idem, con factory check robusto | Gestione LOD (Level of Detail) integrata. |
| **Radius Dinamico** | Funzione `GetClusterRadius` | Arrow function: `(z) => z < 12 ? 80 : 45` | Identica alla reference. |
| **Icone Cluster** | `iconCreateFunction` con dots | Template Lit html con pallini colorati | Appare solo a zoom >= 8. |
| **Popup** | Badge Bootstrap e titoli | Lit html con supporto per AJAX details | Caricamento lazy dei dati del ticket. |
| **Ricerca** | Integrazione manuale | Modulo `map-picker-search.js` condiviso | UX migliorata con attivazione via lente. |
| **Geolocalizzazione** | Plugin `L.control.locate` | Metodo `requestGeolocation` (auto-start) | La mappa centra l'utente all'avvio. |

## Sfide Tecniche Risolte

### 1. Risoluzione Plugin Leaflet (ESM)
In ambiente Vite/ESM, i plugin come `markercluster` richiedono `L` globale. 
**Soluzione**: `window.L = L` all'inizio del file e controllo `typeof L.markerClusterGroup === 'function'`.

### 2. Validazione Dati GeoJSON
L'errore `TypeError: Cannot read properties of undefined (reading 'lat')` è stato eliminato filtrando preventivamente le feature con coordinate `NaN` o `null`.

### 3. Integrazione con public_html
Gli asset vengono compilati e distribuiti esclusivamente in `/public_html/assets/geo/`, rispettando l'architettura di sicurezza del progetto.

## Utilizzo
```blade
<map-lit
    id="segnalazioni-map"
    data-url="/data/tickets.json"
    labels="{{ json_encode([...]) }}"
></map-lit>
```

---
*Ultimo aggiornamento: Aprile 2026*
