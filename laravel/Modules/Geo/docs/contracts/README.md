---
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

- [FetchOsmTileAction](fetch-osm-tile-action.md)
- [QueryNominatimAction](query-nominatim-action.md)
<<<<<<< HEAD
=======
=======
title: "Contratti del modulo Geo"
type: index
tags: [contracts, actions, geo]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Geo

Cosa promettono le Action di Geo che parlano con servizi esterni (OpenStreetMap, Nominatim, provider di geocodifica) o
scrivono coordinate nel DB, e soprattutto cosa **non** fanno. Le due Action del proxy OSM sono nell'elenco `REQUIRED` di
`Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`: il loro contratto è obbligatorio.

Leggili prima di chiamare, modificare o imitare una di queste Action; le invarianti con un group Pest si verificano con
`cd laravel && vendor/bin/pest Modules/Geo/tests --group=<ID>`, quelle con `—` sono debito dichiarato.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Indice

- [FetchOsmTileAction](fetch-osm-tile-action.md) — tile OSM dal nostro dominio, cache su disco di almeno 7 giorni, richieste condizionali, copia scaduta se OSM è giù.
- [QueryNominatimAction](query-nominatim-action.md) — ricerca e geocodifica inversa via proxy: 1 richiesta/s per il sito, parametri filtrati, cache, spegnibile da config.
- [GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md) — dispatcher della geocodifica: provider di `geo.driver` per primo, poi fallback; mai eccezioni, errori in `getErrors()`.
- [UpdateCoordinatesFromAddressAction](update-coordinates-from-address-action.md) — geocodifica l'indirizzo di un modello e scrive solo `latitude`/`longitude`.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
