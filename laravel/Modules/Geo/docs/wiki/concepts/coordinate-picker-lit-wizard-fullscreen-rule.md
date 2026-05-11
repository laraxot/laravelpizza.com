# Coordinate Picker Lit: Wizard, Boolean Attributes, Fullscreen

## Regola

`coordinate-picker-lit` deve funzionare uguale dentro qualunque wizard Filament/Livewire:

- non usare CSS o JS legato a slug pagina o wizard specifici;
- non emettere attributi booleani HTML quando il valore PHP e' `false`;
- se Leaflet vive nello Shadow DOM, il CSS Leaflet deve essere iniettato nello Shadow DOM;
- quando uno step nascosto diventa visibile, chiamare `invalidateSize()` con refresh differiti;
- in fullscreen bloccare overflow su `html` e `body`;
- il layer fullscreen deve vincere sugli stacking context del wizard e dei box informativi.

## Best Practices

- Per Lit boolean properties usare attributo presente solo quando vero:
  `@if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif`.
- Il componente mappa possiede il proprio DOM con Shadow DOM e monta Leaflet tramite selector locale nel `renderRoot`.
- Importare `leaflet/dist/leaflet.css?inline` e inserirlo nello `<style>` del componente Lit: il CSS globale non attraversa lo Shadow DOM.
- Ricerca indirizzo: `setCoordinates(lat, lon, 'search')` deve spostare viewport, marker e stato Livewire.
- Fullscreen: `position: fixed`, `inset: 0`, z-index molto alto, `document.documentElement.style.overflow = 'hidden'` e reset in `disconnectedCallback()`.
- Dopo `invalidateSize()` ridisegnare i tile layer attivi con `redraw()` quando il container e' appena diventato visibile.

## Bad Practices

- `geolocate-when-empty="{{ false }}"`: in HTML l'attributo esiste comunque, quindi Lit lo interpreta come `true`.
- Forzare overlay o opacita' via CSS tema per "sbloccare" la mappa: la causa e' spesso stato JS/geolocalizzazione, non colore.
- Usare id globali o selettori pagina per Leaflet dentro wizard.
- Applicare fullscreen solo al container interno senza gestire lo scroll documento.
- Importare `leaflet.css` solo globalmente quando il markup Leaflet e' dentro Shadow DOM.

## False Friends

- Una mappa con filtro bianco sopra puo' sembrare disabilitata, ma puo' essere la loading overlay della geolocalizzazione partita per un attributo booleano falso ma presente.
- `body { overflow: hidden }` non basta sempre: su alcune pagine rimane scrollbar se `html` continua a scrollare.
- Z-index `9999` non e' necessariamente sopra componenti Bootstrap/Filament con stacking context propri.
- Tile caricati "a blocchi" o quadrati vuoti non indicano sempre rete lenta: spesso mancano le regole CSS Leaflet nello stesso DOM in cui Leaflet crea pane, layer e tile.

## Evidenza 2026-04-22

Nel wizard `segnalazione-crea` la mappa risultava vuota o velata dopo click su `Avanti` e in fullscreen appariva sopra il box "Informazioni richieste". Fix applicato nel modulo Geo:

- attributo `geolocate-when-empty` emesso solo se vero;
- autogeolocalizzazione avviata solo quando richiesta;
- fullscreen con z-index alto e blocco overflow su `html` + `body`;
- reset overflow quando il componente viene disconnesso.
- CSS Leaflet inline nello Shadow DOM e redraw dei tile layer dopo `invalidateSize()` per evitare quadrati vuoti.
