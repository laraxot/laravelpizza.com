---
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
<<<<<<< HEAD
updated: 2026-11-18
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
---

# Architecture Decision Records

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
```

## Decisioni

<<<<<<< HEAD
- [ADR — Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md)
=======
- [Le integrazioni HTTP geografiche sono Actions, non Services](no-service-geo-integrations.md)
- [Proxy Geo incluso nella cache delle rotte](route-cache-includes-proxy.md)
- [ADR — Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md)
- [Geocoding e tile OSM passano dal proxy](geo-uses-proxy-for-osm.md)
>>>>>>> laraxot/dev

## Decisioni precedenti (formato libero, non ancora ADR)

- [geo-geocoding-driver-consolidation](../wiki/decisions/geo-geocoding-driver-consolidation.md)
- [standardized-geo-architecture](../wiki/decisions/standardized-geo-architecture.md)
<<<<<<< HEAD
=======
=======
title: "ADR del modulo Geo"
type: index
tags: [adr, decisioni, geo]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Geo

Il **perché** delle forme di codice di Geo che sembrano strane e che un agente rischia di "semplificare": il proxy
OpenStreetMap lato server (privacy e policy di OSMF), la mappa dei provider di geocodifica scritta dentro l'Action
(vincolo di PHPStan), i componenti mappa Lit in Light DOM (stabilità nei wizard Livewire).

Leggili prima di: far chiamare al browser un servizio di mappe esterno, spostare la scelta dei provider in config o
aggiungerne uno, scrivere o copiare un componente mappa JS.

Formato (cinque sezioni, `type: decision`, nome file senza date né numeri) e regole:
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md). Chi cambia una decisione scrive un
nuovo ADR e segna il vecchio `status: superseded`.

## Indice

- [Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md) — il browser parla solo con il nostro dominio; il server rispetta cache, User-Agent e 1 richiesta/s di OSMF.
- [Geocodifica: provider preferito da configurazione, poi fallback letterale](geocoding-preferred-provider-with-fallback.md) — `geo.driver` sceglie il primo provider; la mappa resta nel metodo per restare tipizzata.
- [Componenti mappa Lit in Light DOM con pane Leaflet protetto](map-components-lit-light-dom.md) — `createRenderRoot`, `guard([])` e `ResizeObserver` per mappe che sopravvivono a step, tab e Livewire.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
