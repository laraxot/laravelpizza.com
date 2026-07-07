# Componente: map-lit

## Panoramica
Il componente `<map-lit>` è la conversione fedele in Lit.dev della logica di visualizzazione mappe del progetto `farmshops.eu` (`direktvermarkter.js`). Sostituisce l'uso di `<geo-map-lit>` nella pagina pubblica elenco segnalazioni, mantenendo validazione dati e bootstrap plugin robusti.

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

- **Owner markup Sixteen**: `Themes/Sixteen/resources/views/pages/tests/ticket-list.blade.php` include `pub_theme::components.sections.map-lit`, mentre `Themes/Sixteen/resources/views/components/blocks/segnalazioni/layout.blade.php` usa `<map-lit data-url="/data/tickets.json">`.
- **Partial tema**: `Themes/Sixteen/resources/views/components/sections/map-lit.blade.php` esiste per evitare che `@include('pub_theme::components.sections.map-lit')` diventi un 500 server-side. La partial deve solo emettere il web component, non duplicare logica Leaflet.
- **Registrazione tema**: `Themes/Sixteen/resources/js/app.js` deve importare `@modules/Geo/resources/js/components/map-lit.js`; se manca, il tag resta un elemento HTML sconosciuto e la mappa non si inizializza.
- **Build Sixteen**: dopo ogni modifica agli import mappa eseguire `npm run build` e `npm run copy` dal tema Sixteen.
- **Plugin Leaflet**: `leaflet.markercluster` e `leaflet.heat` vanno importati a runtime dopo `window.L/globalThis.L = L`; l'import statico e' un false friend ESM/Vite.
- **Git Policy**: Sviluppo lineare "Forward-Only" (nessun revert, solo fix migliorativi).
- **Zero CDN**: Dipendenze (`leaflet`, `lit`, `markercluster`, `heat`) caricate esclusivamente via npm e bundle Vite.

## False Friend

`<geo-map-lit>` e' un componente Geo ancora presente, ma per la pagina pubblica `http://127.0.0.1:8000/it/tests/ticket-list` il tag corretto e' `<map-lit>`.
Le due cause tipiche di mappa invisibile sono:
- `customElements.get('map-lit')` falso: manca l'import nel bundle Sixteen.
- HTTP 500 `View [components.sections.map-lit] not found`: esiste un include server-side senza partial tema.

## Verifica 2026-05-08

```text
npx playwright test Modules/Geo/tests/Playwright/ticket-list.spec.js
11 passed
```

Smoke browser: `map-lit` definito, elemento 1108x522, Leaflet container presente, 15 tile caricate, 2 marker e 2 cluster.

---
*Ultimo aggiornamento: 2026-05-08*
