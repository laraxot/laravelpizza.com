# Coordinate Picker Fullscreen Stacking Rule

## Regola

Quando `coordinate-picker-lit` entra in fullscreen:

- non deve comparire scrollbar verticale della pagina;
- nessun box del wizard deve stare sopra la mappa;
- Leaflet deve ricalcolare dimensioni dopo il cambio layout;
- i controlli mappa devono restare sopra i tile.

## Errore osservato

URL:

`/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`

Sintomi:

- click fullscreen sulla mappa;
- resta una scrollbar verticale;
- il box "Informazioni richieste" appare sopra la mappa;
- la mappa non si carica bene.

## Root cause probabile

Fullscreen implementato come classe interna del componente, ma il contesto pagina continua ad avere:

- body/document scroll attivo;
- elementi Filament/Design Comuni con stacking context superiore;
- wizard content non isolato;
- `invalidateSize()` chiamato prima che il layout fullscreen sia stabile.

## Best practice

- In fullscreen bloccare scroll su `html` e `body`, non solo `body`.
- Usare `position: fixed` con `inset: 0` e `z-index` superiore ai layer header/wizard/modali ordinari.
- Garantire che il contenitore mappa sia nel render root del componente e non dipenda dal layout dello step.
- Dopo toggle fullscreen, chiamare `invalidateSize()` con piu' delay.
- Verificare con Playwright dimensioni viewport, tile count e assenza di overlay del wizard.

## Bad practice

- Bloccare solo `document.body.style.overflow`.
- Mettere fullscreen dentro contenitori con `overflow`, `transform`, `position` o `z-index` superiori.
- Considerare "mappa visibile" sufficiente senza controllare tile e dimensioni Leaflet.

## False friends

- `position: fixed` su un elemento interno non basta se un antenato crea stacking context anomalo.
- `z-index: 9999` puo' non bastare se modali/debugbar/header usano stacking piu' alto.
- La scrollbar residua indica che il documento continua a scorrere: fullscreen non e' davvero isolato.

