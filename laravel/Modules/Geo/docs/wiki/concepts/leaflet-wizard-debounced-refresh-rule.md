---
name: leaflet-wizard-debounced-refresh-rule
description: Debounced Leaflet size invalidation for Filament wizard steps to prevent flicker and redraw storms
---

# Leaflet Wizard Debounced Refresh Rule

## Problem

Dentro uno step wizard Filament/Livewire, il `coordinate-picker-lit` puo' ricevere mount iniziale, toggle di visibilita, resize layout e fullscreen quasi nello stesso intervallo temporale.

Il falso amico e' reagire a tutto con molti `invalidateSize()` annidati, `setInterval()` di assestamento e listener globali su ogni click. Questo produce lampeggio, redraw superflui e stress sui tile.

## Rule

Il runtime Geo deve usare un refresh **debounced e limitato**:

1. niente `setInterval()` di assestamento;
2. niente refresh globale su ogni `document.click`;
3. gli invalidate devono passare da una sola coda di timeout cancellabile;
4. usare pochi delay stabili, tipicamente `0`, `140-180`, `320-420`;
5. il redraw esplicito dei tile resta solo per `tileerror` o fullscreen.

## Best Practices

- Centralizzare il refresh in `_refreshMapSize(delays = [...])`.
- Cancellare i timeout pendenti prima di schedulare un nuovo refresh.
- Saltare `invalidateSize()` se il container ha width/height zero.
- Separare refresh geometrico e redraw tile di recovery.

## Bad Practices

- `document.addEventListener('click', ...)` per invalidare sempre la mappa.
- array delay lunghissimi concatenati fra loro.
- usare `setInterval(... invalidateSize ...)` durante il load.
- trattare il redraw tile come strategia primaria.

## False Friends

- "Piu' invalidateSize = piu' robustezza": falso, spesso significa solo flicker.
- "Basta aumentare i delay": falso, il problema e' spesso la quantita di refresh, non il loro tempo.
- "Ogni click puo' cambiare il layout": troppo generico per un listener globale permanente.

## Ownership

- **Geo** possiede il runtime Leaflet/Lit.
- **Sixteen** possiede il layout/CSS che deve restituire dimensioni stabili.
- **Fixcity** consuma il componente senza aggiungere loop di refresh propri.
