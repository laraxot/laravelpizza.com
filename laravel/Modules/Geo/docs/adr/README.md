---
<<<<<<< .merge_file_TBKPCF
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Architecture Decision Records"
=======
title: "ADR del modulo Geo"
>>>>>>> .merge_file_DT9jxC
type: index
tags: [adr, decisioni, geo]
created: 2026-11-18
<<<<<<< .merge_file_TBKPCF
<<<<<<< HEAD
updated: 2026-11-18
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
=======
updated: 2026-11-24
>>>>>>> .merge_file_DT9jxC
---

# ADR del modulo Geo

Il **perche'** delle forme di codice di Geo che sembrano strane e che un agente rischia di "semplificare": il proxy
OpenStreetMap lato server (privacy e policy di OSMF) e la sua cache delle rotte, la mappa dei provider di geocodifica scritta
dentro l'Action (vincolo di PHPStan), i componenti mappa Lit in Light DOM (stabilita' nei wizard Livewire), le integrazioni
HTTP come Actions invece che Services. Una decisione per file, con le alternative scartate; il nome del file e' l'argomento,
senza date ne' numeri (la data sta nella frontmatter).

Leggili prima di: far chiamare al browser un servizio di mappe esterno, spostare la scelta dei provider in config o
aggiungerne uno, scrivere o copiare un componente mappa JS, aggiungere una classe in `app/Services`.

## Metodo

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale; non e' un diario ne'
una spiegazione retroattiva inventata. Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea
un nuovo ADR e segna il precedente `superseded` o `deprecated`. Regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md)
e [ADR di Xot](../../../Xot/docs/adr/README.md).

## Formato

```markdown
---
title: "ADR - <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
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

## Verifica
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```

Un ADR "sostanziale" aggiunge `## Driver della decisione` e `## Conferma`.

## Decisioni

<<<<<<< .merge_file_TBKPCF
<<<<<<< HEAD
- [ADR — Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md)
=======
- [Le integrazioni HTTP geografiche sono Actions, non Services](no-service-geo-integrations.md)
- [Proxy Geo incluso nella cache delle rotte](route-cache-includes-proxy.md)
- [ADR — Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md)
- [Geocoding e tile OSM passano dal proxy](geo-uses-proxy-for-osm.md)
>>>>>>> laraxot/dev
=======
- [Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md) — il browser parla solo con il nostro dominio; il server rispetta cache, User-Agent e 1 richiesta/s di OSMF.
- [Geocoding e tile OSM passano dal proxy](geo-uses-proxy-for-osm.md) — versione breve della stessa decisione: throttling, cache, validazione e disattivazione del provider in un punto solo.
- [Il proxy Geo resta nella cache delle rotte](route-cache-includes-proxy.md) — il deploy rigenera la cache con `route:trans:cache`; un 404 HTML su una tile segnala una cache obsoleta.
- [Geocodifica: provider preferito da configurazione, poi fallback letterale](geocoding-preferred-provider-with-fallback.md) — `geo.driver` sceglie il primo provider; la mappa resta nel metodo per restare tipizzata.
- [Componenti mappa Lit in Light DOM con pane Leaflet protetto](map-components-lit-light-dom.md) — `createRenderRoot`, `guard([])` e `ResizeObserver` per mappe che sopravvivono a step, tab e Livewire.
- [Le integrazioni HTTP geografiche sono Actions, non Services](no-service-geo-integrations.md) — `BaseGeoService` va rimosso; use case solo in Queueable Actions con contratto in `docs/contracts/`.
>>>>>>> .merge_file_DT9jxC

## Decisioni precedenti (formato libero, non ancora ADR)

- [geo-geocoding-driver-consolidation](../wiki/decisions/geo-geocoding-driver-consolidation.md)
- [standardized-geo-architecture](../wiki/decisions/standardized-geo-architecture.md)
<<<<<<< .merge_file_TBKPCF
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
=======
>>>>>>> .merge_file_DT9jxC
