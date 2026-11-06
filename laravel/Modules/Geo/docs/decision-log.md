---
type: decision-log
title: "Decision Log — Geo"
links: {github_issue: "#XXX", discussion: "#XXX"}
status: draft
updated: 2026-10-20
tags: [docs, geo]
qmd: "decision log   geo geo"
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

### 2026-10-14: INDEX.md come ingresso unico e mappa di migrazione della radice (proposta)
- **Choose**: `docs/INDEX.md` e l'unico punto d'ingresso; `00-INDEX.md` e `00-index.md` portano in testa "Superseded: vedi INDEX.md" e restano per cronologia; `docs/DOCS-MIGRATION-MAP.md` ha una riga (vecchio, nuovo proposto, scopo, nota, stato `proposto`) per ognuno dei 622 file della radice; `wiki/concepts/INDEX.md` elenca tutti i 148 concept.
- **Over**: spostare o cancellare subito i file della radice; fondere i tre indici cancellando due.
- **Because**: il progetto vieta spostamenti senza mappa e senza decisione. La radice ha 622 file (575 `.md`, 47 di configurazione o senza estensione), 62 copie byte-identiche e 1933 link relativi non risolvibili: spostare prima di decidere moltiplicherebbe i link rotti. Le destinazioni proposte sono cartelle gia esistenti di `docs/` (nessuna cartella nuova di primo livello).
- **Verifica** (strumento `bashscripts/tools/docs/docs-organizer.py links`, escluse `raw/` e `stories/`): prima 2275 eventi (1933 irrisolti + 342 correggibili); dopo 1933 eventi (0 correggibili): 340 link riparati dallo strumento, tutti con bersaglio esistente (verificato uno per uno), piu 9 riparati a mano con bersaglio unico (`leaflet-marker-map-input.md`, `../config/config.php`, `map-lit-it-incidents-2026.md` in due file, `../coordinate-picker.md`, 4 profondita `../` sbagliate: 3 in `wiki/index.md` e 1 nel campo `sources` del concept `coordinate-picker-design-comuni-runtime-rule.md`). Gli irrisolti puntano a file inesistenti: non riparati, nessun bersaglio inventato. Il confronto non e al pelo: la prima misura saltava i file toccati da meno di 10 minuti.
- **Aperto**: approvazione gruppo per gruppo della mappa (poi `git mv` e `links --fix`); `docs/wiki/.gitignore` ignora `concepts/`, quindi i concept nuovi (es. `picker-marker-and-controls-on-host-pages.md`) vanno aggiunti con `git add -f`; `wiki/index.md` ha ancora un link rotto senza bersaglio (`ai-harness-module-discipline.md`); `geo-map-lit.js` importa ancora `leaflet.heat` senza usarlo (cambio di codice, fuori da questa revisione).

### 2026-10-20: Regressione PHPStan da pull, lane geo (483 errori a 0)
- **Choose**: Correggere alla sorgente le tre cause (alias `@phpstan-type` usati come tipo nativo, docblock `/** @var */` degradati, test riespansi) e ripristinare i test dai blob di `HEAD` con `git show`, senza `checkout` ne' `restore`.
- **Over**: Correggere riga per riga i 483 errori, o aggiungere ignore e baseline.
- **Because**: Il pull delle 08:57 ha riscritto la working copy con una versione diversa da `HEAD` (`6fde33ea`). I blob di `HEAD` sono lo stato dell'8 ottobre, a 0 errori. Gli alias erano un `TypeError` a runtime, non solo un errore statico.
- **Verifica**: PHPStan JSON a 0 su 29 file; Pest verde su `LookupPlaceActionTest` (nuovo, 5 test) e sui due test del dataset mappa (6 test).
- **Aperto**: quattro servizi di `app/Services` risorti dal pull (tipizzati sul posto, non cancellati) e quattro test del widget rossi. Dettagli: [phpstan-test-wave-geo.story.md](./stories/phpstan-test-wave-geo.story.md).


### 2026-10-20: Services Geo di nuovo a zero (wave services-to-actions)

- **Choose**: eliminare i residui riesumati; Actions gia' in `Actions/Here|GeoData|GoogleMaps|Distance|Polygon`.
- **Because**: no-services; i cinque `*Service` erano zombie (0 chiamanti produzione). In questa sessione i 5 erano gia' spariti; rimosso anche `GeoDataValidator` (successore `ValidateGeoDataIntegrityAction`). Cartella `app/Services` vuota/rimossa.
- **Verifica**: `rg --files Modules -g '*Service.php'` → solo `TermsOfService` Livewire User.

### 2026-10-20: Services Geo, equivalenza dimostrata prima di chiudere

- **Choose**: non creare Action nuove; confrontare con un probe i blob originali contro i successori e correggere solo cio' che il confronto smentisce.
- **Over**: fidarsi dei nomi ("Sostituisce GeoService::haversine()") o ricreare le classi come Action.
- **Because**: il probe ha dato 330 confronti uguali e 20 diversi, tutti spiegati. Uno era un difetto vero: `Distance/BuildHaversineSqlAction` produceva SQL con una parentesi in meno e nessuno se n'era accorto perche' non ha chiamanti. Corretto con test rosso poi verde.
- **Non appianato**: `getCities` ha cambiato forma (lista di coppie nel Service, mappa `codice => nome` nelle Action), `comuni.json` reale non ha la struttura `regions` che il codice GeoData richiede, `GeoServiceFacade` ha accessor `geo.service` senza binding. Tutte in [services-to-actions-geo.story.md](./stories/services-to-actions-geo.story.md) come decisioni per l'owner.

### 2026-10-20: Religione cartella `app/Services` assente (delete-again)

- **Choose**: path `Modules/Geo/app/Services/` assente; ratchet `archAllowedServicesDirs()` = `[]`; merge riesuma → delete-again senza nuove Actions.
- **Over**: allowlist Geo o ricreazione Service «temporanea».
- **Because**: mid-sessione cinque PHP riesumati con 0 `use Modules\Geo\Services\`. Hub: [brainstorming-services-to-actions-wave](../../Xot/docs/bmad/brainstorming-services-to-actions-wave.md).
- **Verifica**: `find` dirs/files Services = 0; PHPStan Modules OK (`--memory-limit=2G` post-SIGKILL).

## Open Questions

- (2026-10-14, studio degli ingressi) Quale file e' l'indice canonico del modulo? Il contratto `bmad-output/docs-architecture/module-theme-docs-contract.md` dice `00-INDEX.md`; la decisione del 2026-10-14 sopra dice `INDEX.md` e marca `00-INDEX.md` e `00-index.md` come superseded (due nomi che differiscono solo per le maiuscole). Nessuna rinomina fatta. Vedi la story `stories/studio-docs-geo-ingressi-verificati.story.md`.
## 2026-10-20 — Iniezione esplicita nelle Queueable Actions Geo

`FilterCoordinatesInRadiusAction` riceve `CalculateDistanceActionContract` nel
costruttore invece di risolverlo con `app()` dentro `execute()`. Lo scopo è
rendere visibile la dipendenza, mantenere il caso d'uso testabile e impedire che
il comportamento dipenda da binding globali nascosti. Il contratto resta
sincrono per le letture usate dalla UI; il trait Spatie rimane disponibile per
il dispatch esplicito.

## 2026-10-20 — Contratti delle Actions risolti dal container

`FilterCoordinatesInRadiusAction`, `ClusterLocationsAction` e `OptimizeRouteAction`
dipendono da `CalculateDistanceActionContract`. `GeoServiceProvider` registra ora il
binding verso `CalculateDistanceAction`, così la composizione applicativa resta
testabile tramite contratto e non fallisce quando Laravel costruisce l'Action.

### 2026-11-03: GeoTrait cancellato da `7dd0faaa` e ripristinato, trait non piu' generico
- **Choose**: Ripristinare `app/Models/Traits/GeoTrait.php` dal blob `2ae1d61a` (la linea buona della voce del 2026-10-08) scrivendolo con `git cat-file -p`, senza `checkout`. Togliere al trait `@template TModel`, scrivere gli scope con `Builder<static>` (come `Xot/app/Models/Traits/HasCommonScopes.php`) e togliere da `Address` il docblock `@use GeoTrait<Address>`.
- **Over**: Il blob di 371 righe di `7dd0faaa^`, che non e' generico ma copriva gli scope con `@phpstan-ignore-next-line` e accedeva a `$address`; tenere il trait generico; aggiungere ignore.
- **Because**: Il commit `7dd0faaa` (Marco Xot, 2026-11-01, ".") ha cancellato il trait insieme ai probe PHPStan di `tests/Fixtures`, ma `Address` lo usa ancora: `use` di un trait inesistente e' un errore fatale al caricamento della classe, cioe' ogni pagina che tocca `Address` si rompe. Con PHPStan 2.3.4 e Larastan 3.13.2 un trait generico usato con `@use GeoTrait<Address>` perde il PHPDoc degli scope (`missingType.generics` su `scopeWithDistance` e `scopeOfInPolygon`, anche con `Builder<static>` o con il template rinominato); senza `@use` resta solo "trait generico senza tipi". Il trait non serve generico: gli scope parlano del modello che lo usa, che e' `static`.
- **Verifica**: PHPStan sull'intero progetto `[OK] No errors`; Pint passa su `GeoTrait.php`; su `Address.php` restano le 5 regole Pint che il file violava gia' prima (yoda, spazi, docblock), non toccate. `tests/Unit/Models/AddressTest.php` non gira qui: il TestCase di Geo cerca la connessione `fixcity`, di un altro progetto.
- **Aperto**: lo stesso commit `7dd0faaa` ha ridotto `docs/img/debug-segnalazione-crea.png` e `docs/img/debug-ticket-crea.png` da 75 KB a 130 byte. Probabile la stessa corruzione dei binari da `laravel/.gitattributes` (eol=lf) gia' nota; non toccati. Il ripristino va committato anche nel repo di Geo, altrimenti il prossimo pull lo cancella di nuovo.

### 2026-11-03: `scopeOfInPolygon` e `getFormattedAddressAttribute` portati alle regole di qualita'
- **Choose**: In `GeoTrait::scopeOfInPolygon()` l'SQL resta letterale su `zone_polygon` e il parametro `$polygon_field` deve valere `zone_polygon` (`Assert::same`); tolta la parentesi chiusa in piu' che rendeva la query non valida. In `Address::getFormattedAddressAttribute()` il calcolo e' diviso in quattro metodi privati (via, localita', provincia, paese) con un solo helper `filledString()` che conserva la regola dei vecchi `if ($this->campo)` (`''` e `'0'` assenti). Pint applicato a `Address.php`.
- **Over**: Interpolare la colonna nell'SQL (anche validata e quotata): `whereRaw()` e `Expression` accettano solo `literal-string`, quindi servirebbe un cast o un ignore.
- **Because**: Prima `scopeOfInPolygon('altra_colonna', ...)` controllava `altra_colonna IS NOT NULL` ma calcolava il poligono su `zone_polygon`, in silenzio; ora e' un errore. Nessun chiamante nel repo. L'accessor aveva complessita' ciclomatica 21 (NPath 5760) e portava la classe a 51 (soglia 50).
- **Verifica**: `tests/Unit/Models/GeoTraitPolygonScopeTest.php` (SQL su `zone_polygon`, parentesi bilanciate, binding, colonne rifiutate) e `tests/Unit/Models/AddressFormattedAddressTest.php` (5 casi scritti e verdi prima del refactor, verdi dopo), su `LightTestCase`: 10 passed. Stringhe letterali dell'SQL identiche all'originale (22). PHPStan intero progetto `[OK]`, Pint passa, PHPMD senza segnalazioni oltre `StaticAccess`.
