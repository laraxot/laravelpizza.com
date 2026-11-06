---
title: "Geo — scopo e perche'"
type: concept
module: Geo
status: active
created: 2026-10-20
updated: 2026-10-20
tags: [scopo, geo, geocoding, indirizzi, comuni, mappe]
qmd: "geo scopo perche geocoding indirizzi comuni anpr mappe filament query spaziali"
---

# Geo — scopo e perche'

## Perche' esiste

Il modulo Geo esiste perche' **ogni altro modulo che parla di "dove"** (indirizzo, coordinate, comune italiano, mappa) deve consumare un solo dominio, non reinventare provider e modelli. Geocoding multi-provider, anagrafica comuni (Sushi/JSON), componenti Filament di indirizzo/mappa e Actions accodabili vivono qui.

In una riga:

> **Geo possiede la geolocalizzazione e i dati geografici riusabili; i moduli foglia importano Actions e componenti, non provider grezzi.**

## Cosa e' (e cosa no)

| E' | Non e' |
|----|--------|
| Dispatcher geocoding (`GetAddressDataFromFullAddressAction`, `config('geo.driver')`) | Un `GeocodingService` monolitico (policy no-services) |
| Queueable Actions in `app/Actions/**` (HTTP maps, gerarchia comuni, distanza) | Cartella `app/Services/` (vietata; delete-again se merge riesuma) |
| Modelli Address / Location / Place / Comune | Il dominio HR o anagrafica utente |
| Campi Filament (`AddressInput`, mappe Leaflet, …) | Layout/CSS del tema |

Navigazione componenti: [00-INDEX.md](./00-index.md). Catalogo esteso (storico): [INDEX.md](./index.md). Analisi modelli: [geo-models-domain-analysis.md](./geo-models-domain-analysis.md).

## Wave PHPStan

Ground truth: `.cursor-scratch/phpstan-wave/Geo.tsv`. Coordinator-owned; **non** toccare file di test lockati da altre lane; non rilanciare `analyse Modules`. Story esistente: [stories/phpstan-test-wave-geo.story.md](./stories/phpstan-test-wave-geo.story.md). Nota wave: [stories/phpstan-wave-coord.story.md](./stories/phpstan-wave-coord.story.md). Wave2 rector/costanti: [stories/phpstan-wave2-rector-and-constants.story.md](./stories/phpstan-wave2-rector-and-constants.story.md) (`analyse Modules/Geo` → 0).

**Gate unico:** l'unico misuratore e' `laravel/phpstan.neon` (solo l'umano lo modifica). I `phpstan-*.neon` sotto `Modules/Geo/` e `Geo/docs/` restano **archivio legacy** — non usarli con `-c`. Comando: `cd laravel && ./vendor/bin/phpstan analyse Modules`. Perche': [memoria Xot](../../Xot/docs/wiki/memories/phpstan-single-neon-config.md).

## Collegamenti

- [00-INDEX.md](./00-index.md) — indice canonico (contratto moduli)
- [README.md](./README.md)
- [Cms — scopo](../../Cms/docs/scopo.md) · [User — scopo](../../User/docs/scopo.md)
