# Events detail: "Nessun evento trovato"

## Sintomo

Da `/it/events` i link dettaglio aprono `/it/events/{slug}` ma il blocco detail mostra stato vuoto.

## Diagnosi

Il blocco detail e' corretto solo se riceve almeno uno tra:
- `event`
- `item`
- `slug0`

Se il renderer CMS non mergea il contesto route nei blocchi, `slug0` non arriva e il lookup evento fallisce.

## Soluzione

Nel renderer pagina CMS usare merge dati globale+blocco:

- `array_merge($data, $block->data)`

Questo mantiene DRY+KISS e risolve tutti i block che dipendono da `container0/slug0`.
