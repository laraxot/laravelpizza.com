---
type: decision-log
title: "Decision Log — Geo"
links: {github_issue: #XXX, discussion: #XXX}
---
# Decision Log — Geo

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `cd999d97e`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `cd999d97e` (07/10 06:37), l'ultimo commit prima del merge `10076511` che ha preso la copia di lavoro del 28/09 (`bfd4966a`).
- **Over**: Fermarsi ai file delle voci precedenti (gruppo `Address`/`HasAddress`, tre pagine View).
- **Because**: Ogni contenuto sovrascritto o eliminato e' stato verificato come gia' esistente prima del 07/10 (32 + 22 su 54).
  - 32 toccati solo dalla copia vecchia: contenuto da `cd999d97e`.
  - 22 aggiunti solo dalla copia vecchia: eliminati. `tests/playwright/**` (16), `app/Models/Traits/SushiToJsons.php` (doppione: Cms usa quello di Tenant), `app/Models/Traits/GeographicalScopes.php` (non usato), `app/datatransferobjects/LocationDTO.php` (namespace `DataTransferObjects`, usato solo da file `.wip`; il DTO buono e' `app/Datas/LocationDTO.php`), una migrazione `.bak1`, uno spec e un geojson di test.
  - Lavoro di Marco mantenuto:
    - `f890c86f` (story `map-controls-i18n-it-en-de-es`, `map-popup-contrast-and-fit`, `marker-popup-and-location-ux`), `589764c0` (messaggi di errore della geolocalizzazione) e `e46ede56`: uniti a tre vie senza conflitti; `resources/js/components/map/labels.js` nuovo.
    - `b112b61b` (Services → Actions): restano eliminati i 9 servizi di `app/Services`, lo stub e i 3 test dei servizi; restano `GoogleMapsActionElevationStub` e `LoadGeoHierarchyActionTest`; test e `GeoDataConfig` uniti a tre vie.
  - Contenuto da `cd999d97e` per le tre action `GetCitiesAction`, `GetRegionsAction`, `LoadGeoHierarchyAction` (in conflitto): la migrazione da `GeoDataService` era gia' fatta in `cd999d97e` ("Sostituisce GeoDataService") con le chiavi di cache condivise in `GeoDataConfig`; `b112b61b` la rifaceva sulla copia vecchia duplicando le costanti nelle action.
  - Contenuto da `cd999d97e` per i 13 file toccati solo da `f9e8b556`: rimozione meccanica di variabili, espressioni in linea, test vuoti marcati `todo`.
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; `php artisan about` si avvia; le 246 classi di `app/` si caricano; PHPStan su `Modules` senza errori in Geo. Pest prima/dopo a blocchi, confronto JUnit: 0 peggiorati, 3 migliorati. Molti test Geo falliscono in entrambi gli stati per l'ambiente (il bootstrap cerca `Themes/Meetup`).

### 2026-10-08: Tre pagine View riportate alla linea buona per l'avvio con Xot riallineato
- **Choose**: Riportare a `cd999d97e` (linea buona, 07/10 06:37) `AddressResource/Pages/ViewAddress.php`, `LocationResource/Pages/ViewLocation.php`, `Resources/Pages/ViewLocation.php`.
- **Over**: Aggiungere di nuovo `getInfolistSchema()` alla classe base di Xot.
- **Because**: Dopo il riallineamento di Xot a `cadb1578e` l'app non partiva: le tre pagine, ancora alla copia del 28/09 portata dal merge `10076511`, ridefinivano `getInfolistSchema()` con `#[\Override]`, metodo assente da `XotBaseViewRecord` su `master`, nello stato del 06/10 e nella linea buona di Geo. Nessun commit dopo il merge tocca i tre file.
- **Aperto**: il resto di Geo ancora alla copia del 28/09 (vedi voce sotto) va riallineato con Marco.

### 2026-10-08: Ripristino parziale dei file regrediti dal merge `10076511` del 07/10
- **Choose**: Riportare alla linea buona (`cd999d97e`, 07/10 06:37) `Models/Address`, `Models/Traits/GeoTrait` (blob `2ae1d61a`, con il fix di `7e2fb091` su `scopeWithDistance`), `Models/Traits/HasAddress`, `Adapters/HereClient`, `tests/TestCase.php`, `tests/Unit/Traits/{HasAddressTest,TraitsTest}.php`, `tests/Fixtures/Traits/HasAddressTestModel.php`; eliminare i file assenti sulla linea buona: `app/Traits/HasAddresses.php`, `tests/Unit/Traits/TestModel.php` e le fixture `*PhpstanProbe*` / `HasAddressesTestModel`.
- **Over**: Ripristinare tutto il modulo, o tenere lo stato attuale.
- **Because**: Il merge `10076511` ha preso per 113 file di codice il lato `bfd4966a`, una copia di lavoro ferma al 28/09 (tutti identici alla base `f0ca6e67`). I file scelti sono quelli dei file gravi e le loro dipendenze dirette, mai toccati dopo il merge; le fixture erano già state rimosse su linea buona da `d1cedf07` ("rimossi i probe PHPStan tornati") e da Marco il 05/10.
- **Lasciato fuori di proposito**: gli altri ~70 file ancora alla copia del 28/09 e i 23 modificati dopo il merge da Marco l'08/10 (`b112b61b`, `f9e8b556`, `e46ede56`: servizi eliminati, action `GeoData` riscritte). Il merge a tre vie dà 12 file in conflitto tra due progetti diversi della stessa parte: da decidere con Marco.
- **Verifica**: `php -l`; PHPStan su `Modules/Geo` senza errori; test prima/dopo identici.

### 2026-10-14: index.md come ingresso unico e mappa di migrazione della radice (proposta)
- **Choose**: `docs/index.md` e l'unico punto d'ingresso; `00-index.md` e `00-index.md` portano in testa "Superseded: vedi index.md" e restano per cronologia; `docs/docs-migration-map.md` ha una riga (vecchio, nuovo proposto, scopo, nota, stato `proposto`) per ognuno dei 622 file della radice; `wiki/concepts/index.md` elenca tutti i 148 concept.
- **Over**: spostare o cancellare subito i file della radice; fondere i tre indici cancellando due.
- **Because**: il progetto vieta spostamenti senza mappa e senza decisione. La radice ha 622 file (575 `.md`, 47 di configurazione o senza estensione), 62 copie byte-identiche e 1933 link relativi non risolvibili: spostare prima di decidere moltiplicherebbe i link rotti. Le destinazioni proposte sono cartelle gia esistenti di `docs/` (nessuna cartella nuova di primo livello).
- **Verifica** (strumento `bashscripts/tools/docs/docs-organizer.py links`, escluse `raw/` e `stories/`): prima 2275 eventi (1933 irrisolti + 342 correggibili); dopo 1933 eventi (0 correggibili): 340 link riparati dallo strumento, tutti con bersaglio esistente (verificato uno per uno), piu 9 riparati a mano con bersaglio unico (`leaflet-marker-map-input.md`, `../config/config.php`, `map-lit-it-incidents-2026.md` in due file, `../coordinate-picker.md`, 4 profondita `../` sbagliate: 3 in `wiki/index.md` e 1 nel campo `sources` del concept `coordinate-picker-design-comuni-runtime-rule.md`). Gli irrisolti puntano a file inesistenti: non riparati, nessun bersaglio inventato. Il confronto non e al pelo: la prima misura saltava i file toccati da meno di 10 minuti.
- **Aperto**: approvazione gruppo per gruppo della mappa (poi `git mv` e `links --fix`); `docs/wiki/.gitignore` ignora `concepts/`, quindi i concept nuovi (es. `picker-marker-and-controls-on-host-pages.md`) vanno aggiunti con `git add -f`; `wiki/index.md` ha ancora un link rotto senza bersaglio (`ai-harness-module-discipline.md`); `geo-map-lit.js` importa ancora `leaflet.heat` senza usarlo (cambio di codice, fuori da questa revisione).

## Open Questions

