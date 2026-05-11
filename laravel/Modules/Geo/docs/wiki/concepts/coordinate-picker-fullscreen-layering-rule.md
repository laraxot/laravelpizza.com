# Coordinate Picker Fullscreen Layering Rule

## Sintomi

- In fullscreen resta visibile la scrollbar verticale della pagina.
- Sopra la mappa fullscreen compare il box laterale o informativo del wizard.
- Leaflet non carica bene i tile dopo l'ingresso in fullscreen.

## Regola

Il fullscreen del `coordinate-picker-lit` deve essere un vero overlay applicativo:

- container `position: fixed` su tutto il viewport;
- z-index superiore a header, sidebar, navscroll, modali non attive e contenuti wizard;
- blocco scroll del documento finche' il fullscreen e' attivo;
- `invalidateSize()` differito dopo ogni toggle fullscreen.

## Best practices

- La logica di toggle e reinvalidazione resta nel componente Geo.
- Il layer visuale (`z-index`, dimensioni, overlay controls) resta nel CSS del tema.
- Uscendo dal fullscreen bisogna ripristinare lo scroll precedente, non forzare stati permanenti.
- Dopo `isFullscreen = true`, chiamare refresh differiti: Leaflet misura il container solo dopo che il CSS fixed e' applicato.

## Bad practices

- Usare z-index bassi o locali che permettono a sidebar/box wizard di sovrapporsi.
- Bloccare solo `document.body.style.overflow` se il layout usa anche `html` o wrapper scrollabili.
- Inserire hack fullscreen nel Blade del widget Fixcity.
- Usare CSS per slug pagina invece di regole `coordinate-picker-lit` riusabili.

## False friends

- `position: fixed` non basta se un antenato crea stacking context o se il z-index e' sotto altri componenti Bootstrap Italia.
- Una scrollbar visibile non significa che la mappa non sia fullscreen: spesso e' il documento sottostante che continua a scrollare.
- Chiamare `invalidateSize()` immediatamente dopo il toggle puo' essere troppo presto; serve una sequenza differita.
