---
id: dcp-93
title: "DCP-93: Geo: namespace Blade dei componenti e follow-up della mappa di sola lettura"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P1
owner: module:Geo
created: 2026-10-13
updated: 2026-10-13
qmd: "geo point-map readonly coordinate-picker lit GeoServiceProvider componentNamespace module_ns ai activity mobile build"
related: [dcp-33]
---

# DCP-93: Geo, cosa resta dopo la mappa di sola lettura

## Fatto (DCP-33, agente `dcp33-geo-map`, riletto dall'orchestratore)
`<x-geo::point-map>` e attributo `readonly` del Lit `coordinate-picker-lit` (marker non trascinabile, nessuna scrittura di stato, nessuna chiamata a Nominatim); `CoordinatePicker->readOnly()` lo rispetta; 27 test Pest verdi (26 rossi prima), PHPStan a zero.

## Difetto trovato (reale, non corretto fuori da Geo)
`GeoServiceProvider` non ridefinisce `$module_ns`: `XotBaseServiceProvider` registrava il namespace `geo` su `Modules\Xot\View\Components`. Corretto in Geo con `Blade::componentNamespace('Modules\\Geo\\View\\Components', 'geo')` in `boot()`. **Lo stesso difetto e' latente in AI, Activity e Mobile** (lo ha rilevato l'agente, non verificato dal vivo): `<x-ai::...>` ecc. non troverebbero le classi. La correzione giusta e' a monte (`XotBaseServiceProvider` che deriva `$module_ns` dal nome del modulo) con test sul comportamento di tutti i provider, non quattro righe copiate.

## Follow-up
1. Build del modulo Geo (`npm run build && npm run copy` in `Modules/Geo`; oggi non eseguibile: manca `node_modules`) per il back office Filament.
2. Rimontaggio della mappa quando cambia il punto dentro Livewire reale e `readonly` reattivo dopo il primo render: non provati.
3. Contratto di centro iniziale per picker/mappa editabile: se il record/stato contiene coordinate, centrare su quelle; altrimenti provare la posizione browser/utente quando disponibile; altrimenti usare fallback Comune/default Geo, lasciando sempre selezione manuale. Non introdurre un requisito HTTPS per completare la segnalazione: la geolocalizzazione automatica e' progressiva e non bloccante (vedi DCP-35/DCP-43 Fixcity).
4. Mobile: il pan a un dito cattura lo scroll dentro la mappa (`dragging: !L.Browser.mobile` descritto nella nota `docs/wiki/concepts/point-map-readonly.md`, non applicato).
5. `min-height: 200px` del Lit contro l'altezza configurabile del componente.
6. Due istanze con lo stesso punto nello stesso componente Livewire richiedono `id` esplicito (il `wire:key` deriva dal contenuto).
7. Test preesistenti rotti in Geo: `CoordinatePicker is not dehydrated by default` e 24 in `FilamentComponentsTest`/`LatitudeLongitudeInputTest` (manca `database/fixcity_user_test.sqlite`).

## Acceptance criteria
1. Fix a monte del namespace con test per Geo, AI, Activity, Mobile.
2. Prova visiva reale della mappa di sola lettura nel riepilogo del wizard (tile veri, non intercettati).
3. I rossi preesistenti sistemati o spiegati.
