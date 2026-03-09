## Proposal
Standardizzare `<x-page>` su context payload unico `:data="[...]"` e rimuovere props rigide `container0`/`slug0` dal componente CMS `Page`.

## Why
- supporto nativo a routing annidato futuro (`container1`, `slug1`, ...)
- meno coupling nel costruttore (`resolveContext` non piu' necessario)
- piu' DRY/KISS: il componente tratta il context come payload trasparente

Issue correlata: #542

## Safety checks
- mantenere invariato merge `array_merge($data, $block->data)`
- test Pest che verifica forwarding di `container0/slug0` e di chiavi extra (`container1/slug1`)
- review punti in cui `<x-page>` passa ancora props rigide
