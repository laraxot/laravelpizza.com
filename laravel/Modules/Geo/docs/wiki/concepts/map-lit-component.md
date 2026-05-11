# Componente: map-lit

## Panoramica
Il componente `<map-lit>` è la conversione fedele in Lit.dev della logica di visualizzazione mappe del progetto `farmshops.eu` (`direktvermarkter.js`). Sostituisce le versioni precedenti di `geo-map-lit` risolvendo criticità di validazione dati e inizializzazione plugin.

## Caratteristiche Reference (Parità 1:1)

### 1. Clustering LOD (Level of Detail)
- **Raggio Dinamico**: Utilizza la logica di `farmshops.eu` per calcolare il raggio del cluster in base allo zoom (80px per zoom < 12, 45px per zoom >= 12).
- **Breakdown Categorie**: A livelli di zoom >= 8, il cluster non mostra solo il conteggio totale, ma include piccole icone (pallini colorati) che rappresentano le tipologie di ticket contenuti (es. Rifiuti, Strade, Verde).

### 2. Validazione Rigorosa GeoJSON
Per prevenire l'errore `TypeError: Cannot read properties of undefined (reading 'lat')`, il componente filtra ogni feature del dataset:
- Verifica che `geometry.coordinates` sia presente e sia un array.
- Verifica che lat/lng siano numeri validi (`!isNaN`).
- Scarta silenziando i punti malformati prima di passarli al `MarkerClusterGroup`.

### 3. Geolocation-First
La mappa tenta automaticamente di localizzare l'utente all'avvio:
- Se autorizzata, centra la mappa sulle coordinate dell'utente allo zoom 12.
- Se negata o non disponibile, esegue il `fitBounds` sul dataset caricato.

### 4. Popup Dinamici
I popup implementano il pattern di caricamento lazy:
- Al click sul marker, viene inviata una richiesta AJAX a `/api/ticket-details/{id}`.
- Il contenuto del popup viene aggiornato dinamicamente con descrizioni lunghe e galleria immagini.

## Integrazione Tecnica

- **Web Root**: Asset compilati in `/public_html/assets/geo/`.
- **Git Policy**: Sviluppo lineare "Forward-Only" (nessun revert, solo fix migliorativi).
- **Zero CDN**: Dipendenze (`leaflet`, `lit`, `markercluster`, `heat`) caricate esclusivamente via npm e bundle Vite.

---
*Ultimo aggiornamento: Aprile 2026*
