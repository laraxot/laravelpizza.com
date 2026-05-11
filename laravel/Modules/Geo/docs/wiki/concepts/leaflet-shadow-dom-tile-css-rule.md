# Leaflet Shadow DOM Tile CSS Rule

## Regola

Se una mappa Leaflet vive dentro Shadow DOM, il CSS globale di Leaflet non basta.

Il componente deve includere nel proprio render root le regole minime per:

- `.leaflet-container`;
- `.leaflet-pane`;
- `.leaflet-tile-pane`;
- `.leaflet-tile-container`;
- `.leaflet-tile`;
- marker/control panes.

## Errore osservato

URL:

`/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`

Sintomo:

- la mappa appare;
- vengono caricati solo alcuni blocchi;
- restano quadrati vuoti.

## Root cause

Shadow DOM isola anche il CSS. Importare `leaflet/dist/leaflet.css` nel bundle puo' produrre CSS globale, ma quel CSS non attraversa lo shadow boundary.

Il false friend:

- `tileCount > 0` e `.leaflet-container` visibile non significano che la mappa e' renderizzata bene.
- Se i tile sono nel DOM ma il CSS Leaflet non e' nel render root, la griglia puo' apparire a blocchi.

## Best practice

- Per componenti Shadow DOM, portare CSS Leaflet core dentro lo style del componente.
- Dopo `fullscreen`, `step change` o `state update`, chiamare `invalidateSize()` con delay multipli.
- Verificare visualmente con screenshot e metriche:
  - tile visibili;
  - assenza di aree vuote nel viewport mappa;
  - `.leaflet-container` dimensioni uguali al pane.

## Bad practice

- Spostare Leaflet in Shadow DOM e affidarsi solo a CSS globale.
- Controllare solo che il custom element abbia altezza.
- Controllare solo il numero di tile senza screenshot.

