# Geo Picker Runtime Stability Best Practices

## Context

I bug recenti sui picker Geo hanno mostrato quattro classi di problemi ricorrenti:

- componente Lit non importato nel bundle del tema
- Leaflet inizializzato in un container invisibile dentro wizard/step
- flicker dovuto a refresh troppo aggressivi
- regressioni architetturali nei field XotBase

## Best Practices

- Ogni custom element Lit del modulo Geo deve essere importato esplicitamente nel bundle tema.
- Leaflet deve fare `invalidateSize()` quando lo step diventa visibile, non in loop continuo.
- Il refresh dei tile va fatto solo quando serve davvero: step visible, fullscreen, tile error.
- I trait condivisi (`HasCoordinatePicker`) devono contenere solo logica comune riusabile e stabile.
- I componenti che estendono `XotBaseField` non devono dichiarare `protected string $view`.
- Verificare sempre la route target completa con query step del wizard (esempio: `.../tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`).
- Distinguere responsabilita':
  - modulo Geo: runtime mappa, eventi, sincronizzazione stato
  - tema: layout, z-index, spacing, fullscreen cosmetics

## Bad Practices

- Affidarsi a CSS per pagina per correggere una mappa che non si inizializza.
- Forzare `setView` e redraw a ogni minimo update.
- Duplicare proprieta' e metodi di coordinate in piu' componenti invece di estrarli nel trait.
- Lasciare import JS mancanti confidando su bundle legacy o asset pubblicati altrove.

## False Friends

- Se il custom element esiste nel Blade, non significa che il browser lo conosca: senza import JS resta un tag inert.
- Se `ResizeObserver` esiste, non basta per gli step nascosti con `display: none`.
- Se la mappa appare una volta, non significa che il contratto wizard/fullscreen sia stabile.
- Se un field estende `ViewComponent`, non vale la stessa regola di `XotBaseField` sul `$view`.
- Se la mappa e' visibile su `/it/tests/segnalazione-crea`, non significa che sia stabile nello step target del wizard.

## Regole Operative

- Prima di dichiarare “fixato” un picker Geo:
  1. verificare import JS nel tema
  2. verificare URL reale nel browser con query step
  3. entrare nello step wizard target
  4. muovere la mappa
  5. provare fullscreen
  6. controllare che non ci siano tile vuoti o flicker
