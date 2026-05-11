# Leaflet Partial Tile Load Rule

## Sintomi

- La mappa si vede solo a blocchi.
- Restano quadrati vuoti nella griglia tile.
- In fullscreen o dopo cambio step alcuni tile non vengono richiesti o non vengono ridisegnati.

## Root cause

Leaflet calcola la griglia tile in base alle dimensioni del container al momento dell'inizializzazione o dell'ultimo `invalidateSize()`. Nei wizard Filament/Livewire e nei fullscreen CSS, il container cambia dimensione in piu' fasi:

1. Livewire aggiorna DOM/stato step;
2. CSS rende visibile il pannello;
3. Bootstrap/Design Comuni applica layout e stacking;
4. Leaflet deve ricalcolare viewport e tile.

Se `invalidateSize()` avviene troppo presto, Leaflet carica tile per una dimensione parziale e restano quadrati vuoti.

## Best practices

- Chiamare `invalidateSize()` con una sequenza differita dopo cambio step, fullscreen, resize e selezione indirizzo.
- Dopo fullscreen usare anche `panTo`/`setView` sul marker corrente per forzare ricalcolo e repaint.
- Assicurare al pane Leaflet dimensioni esplicite e stabili (`width: 100%`, `height/min-height`).
- Verificare visivamente con screenshot dopo attesa, non solo con HTTP 200.

## Bad practices

- Inizializzare Leaflet una sola volta e assumere che `ResizeObserver` basti.
- Usare overlay o CSS specifici di pagina per mascherare i quadrati vuoti.
- Verificare solo la presenza del custom element senza controllare tile caricati e bounding box.

## False friends

- HTTP 200 della pagina non dice nulla sui tile: il problema e' client-side.
- Un marker visibile non implica che la mappa sia correttamente invalidata.
- `setView()` senza `invalidateSize()` puo' lasciare una griglia tile calcolata su dimensioni vecchie.
- `invalidateSize()` immediato dopo il toggle puo' usare ancora il vecchio rettangolo; servono refresh ripetuti durante l'assestamento.
