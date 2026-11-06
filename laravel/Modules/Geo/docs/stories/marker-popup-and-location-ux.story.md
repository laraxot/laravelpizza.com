# Popup marker e posizione: leggibilita e layout

- Stato: done (2026-10-07), con un caso non riprodotto (vedi Aperto)
- Fase BMAD: Quick Flow
- Owner: Modules/Geo (map-lit); build e CSS in Themes/Sixteen

## Segnalazione

"Cliccando sul marker il popup ha scritta bianca su sfondo bianco." Altri difetti emersi misurando il popup nel browser.

## Misure (Chrome headless, dati reali del proprietario + mock per gli stati)

Contrasto calcolato su ogni nodo di testo del popup, in tema chiaro e scuro, stati `pending/open/resolved`, caricamento, foto e
mobile 390px: nessun testo sotto 4,5:1. Difetti reali trovati:

- Mobile: popup piu largo della mappa, tagliato a destra e sul bordo inferiore.
- Indirizzo ripetuto tre volte (anteprima in intestazione, "Indirizzo", link mappe); descrizione tagliata dal footer
  (`.popup__body` a 160px).
- Pulsanti "Dettagli"/"Chiudi" impilati e sottolineati, alti 131px.
- Intestazione: icona in una colonna da 180px perche `.popup__header-bar { grid-template-columns: 1fr auto !important }`
  batteva la variante con icona; stato e titolo lontani dall'icona.
- Foto non caricata: riquadro grigio con icona rotta.

## Modifiche (`map/popup-ticket.js`, unico foglio stile attivo; `popup-ticket-styles.js` non e importato)

- Larghezza `min(360px, 100vw - 3rem)`, su mobile `100vw - 6.75rem`; altezza mobile `min(250px, 58vh)`.
- Anteprima indirizzo nascosta; descrizione sempre visibile; footer in riga (primario 60%, "Chiudi" a destra), senza sottolineatura.
- Variante con icona piu specifica (`.popup__header-bar.popup__header-bar--with-icon`) con colonne `2.75rem minmax(0,1fr)`.
- `onerror` su hero e gallery rimuove l'immagine rotta; `autoPanPadding` mobile 56px a sinistra, 28px in basso.
- Geolocalizzazione: contesto non sicuro, permesso bloccato (Permissions API) e altri errori hanno messaggi distinti (story Sixteen).

## Aperto

- Il bianco su bianco non e riproducibile con i dati disponibili: se riappare serve il tipo di ticket/stato e il browser.
- `popup-ticket-styles.js` e codice morto duplicato di `popupTicketStylesText`: da eliminare in un task dedicato.
