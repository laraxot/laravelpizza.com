# MapPicker Runtime Asset Governance

## Perche questa pagina

Il `MapPicker` e' business-critical nel wizard segnalazioni: se la mappa si rompe (asset 404, marker non visibile, quadrati bianchi) la compilazione ticket perde affidabilita.

Questa pagina fissa una governance runtime stabile per evitare regressioni dopo build/deploy.

## Root cause tipico osservato

- Richiesta 404 su sprite marker legacy (es. `markers_default-*.png`).
- Origine da CSS legacy `leaflet.extra-markers.min.css` con path `../img/markers_default*.png`.
- In parallelo, il `MapPicker` moderno usa marker custom SVG: i due mondi devono convivere senza collisioni.

## Regole operative

1. `MapPicker` moderno:
   - usa marker custom SVG locali;
   - importa Leaflet CSS da `leaflet/dist/leaflet.css` (bundle tema risolve `@theme-leaflet` / Lit da alias Vite);
   - no CDN.
   - non deve dipendere dai marker standard Leaflet (`marker-icon.png`, `marker-icon-2x.png`) come soluzione primaria;
   - se serve un marker grafico, va creato e versionato localmente nel progetto (SVG e, solo se utile, PNG fallback).
2. Compatibilita legacy:
   - garantire presenza sprite `markers_default*` e `markers_shadow*` in `resources/img` del modulo quando il CSS legacy e' ancora caricato.
3. No fix manuali volatili in `public_html/build/assets` come strategia primaria.
4. Ogni fix runtime deve essere verificato su URL reale con evidenze browser.
5. Controlli posizione/fullscreen/layer:
   - usare pulsanti custom del componente (`_locateMe`, `_toggleFullscreen`, `_switchLayer`);
   - non dipendere da `leaflet.locatecontrol` nel bundle tema se il pacchetto non e' presente.
6. Sincronizzazione stato:
   - evitare binding reattivo diretto `lat/lng` sul custom element durante drag;
   - usare API imperativa `setCoordinatesFromExternal()` per sync Livewire/Alpine -> mappa senza re-render distruttivi.
7. Stabilita marker:
   - se `latitude/longitude` sono null al bootstrap, creare il marker dopo geolocalizzazione o al primo click mappa;
   - non chiamare `setLatLng` su marker nullo.
   - preferire marker custom owner-side ispirati al pattern `farmshops.eu` (`L.ExtraMarkers.icon(...)` o `L.divIcon(...)` con SVG locale) invece dei marker default Leaflet.
8. Stabilita pan/drag:
   - non propagare automaticamente il `moveend` della mappa ai campi Livewire;
   - aggiornare coordinate solo su eventi espliciti utente (`drag`, `click`, `search`, `geolocation`).
9. Layout e fullscreen:
   - i pulsanti operativi devono essere overlay nel canvas mappa (in alto a destra), cosi restano utilizzabili anche in fullscreen;
   - evitare toolbar esterne alla mappa per locate/layer/fullscreen nel `MapPicker`.
10. Campo legacy `LatitudeLongitudeInput` (Blade + Alpine `latitudeLongitudeMap`):
   - la funzione **deve** essere definita in un `@once` **prima** del markup con `x-data="latitudeLongitudeMap(...)"`;
   - il container root del componente **deve** chiamare `x-init="init()"`, altrimenti mappa/marker/listener layer+geoloc non vengono inizializzati;
   - se lo script sta in fondo al partial, Alpine valuta `x-data` prima e si ottiene `ReferenceError: latitudeLongitudeMap is not defined`;
   - passare `statePath` come parametro alla factory, non usare `@js($statePath)` dentro il corpo JS (supporto multi-istanza).
   - se toolbar layer/geoloc non risulta visibile in pagina, preferire layout non assoluto (`position: relative`) sopra la mappa per evitare collisioni con stacking context del wizard;
   - il click geolocalizzazione deve sempre emettere un evento di fine ciclo UI (es. `geo-done`) sia su successo sia su errore, per ripristinare lo stato loading;
   - in fullscreen browser del shell mappa, forzare `width/height: 100vw/100vh` sul container e canvas Leaflet (`:fullscreen` e `:-webkit-full-screen`) per occupazione schermo completa.
11. Light DOM vs Shadow DOM:
   - il custom element usa `createRenderRoot() { return this; }` (light DOM) per integrazione stabile con Leaflet, `L.Control`, fullscreen e z-index Filament;
   - sui container dei controlli usare `L.DomUtil.disableClickPropagation` / `disableScrollPropagation` per evitare che pan/drag della mappa “rubino” click ai pulsanti.

## Checklist regressione post-build

- Aprire:
  - `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
- Verificare:
  - nessun 404 su marker asset in network;
  - marker visibile;
  - click/drag mappa aggiornano coordinate;
  - console senza errori JS critici;
  - nessun quadrato bianco da tile/asset rotti.

## REGOLA ANTI-CDN (permanente, non negoziabile)

```
VIETATO: https://unpkg.com/leaflet@1.9.4/dist/marker-icon.png
VIETATO: qualsiasi URL CDN/unpkg per marker
VIETATO: L.Icon.Default (cerca marker da CDN)

OBBLIGATORIO: createMapPickerLeafletIcon(L) da map-picker-marker-config.js
OBBLIGATORIO: L.divIcon con SVG inline — marker owner-side locale
PATTERN: farmshops.eu / direktvermarkter.js
```

Questa regola si applica a OGNI modifica o refactor di MapPicker.
Aggiornata: 2026-04-20 (story 8-27)

## Riferimenti

- [map-picker-filament-field](./map-picker-filament-field.md)
- [geo-map-widget-farmshops-pattern](./geo-map-widget-farmshops-pattern.md)
- [farmshops integration](../../farmshops-integration.md)
- [story 8-16](../../../../../_bmad-output/implementation-artifacts/8-16-map-picker-runtime-asset-hardening-and-visual-regression.md)
- [story 8-26](../../../../../_bmad-output/implementation-artifacts/8-26-mappicker-custom-local-marker-assets-farmshops-pattern.md)
- [story 8-27](../../../../../_bmad-output/implementation-artifacts/8-27-segnalazione-crea-mappicker-custom-marker-runtime-url-fix.md)
