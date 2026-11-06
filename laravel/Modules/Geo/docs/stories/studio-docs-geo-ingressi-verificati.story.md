---
title: "Studio delle docs del modulo Geo e correzione degli ingressi con fatti verificati nel codice"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Geo
epic: docs-organization
related:
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ../../../Fixcity/docs/stories/studio-docs-fixcity-ingressi-verificati.story.md
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
tags: [docs, organizzazione, verifica-nel-codice, second-brain, doc-010, doc-002, config, test]
qmd: "studio docs geo ingressi README INDEX 00-INDEX index.md PTVX stale config geo.config geo.driver null Themes Meetup test TestCase pub_theme phpstan zero Actions duplicate"
---

# Studio delle docs di Geo: ingressi corretti con fatti verificati

Fase BMAD: documentazione e qualita' (DOC-010 + DOC-002 del piano `bmad-output/stories/docs-organization/`). Non tocca codice applicativo, non sposta e non cancella file, git in sola lettura.

## Richiesta
Utente, 2026-10-13 e 2026-10-14: studiare, aggiornare, migliorare e organizzare le cartelle `docs/` di moduli e temi con BMAD e second brain. Perimetro: `laravel/Modules/Geo/docs`. Complemento: [studio di Fixcity](../../../Fixcity/docs/stories/studio-docs-fixcity-ingressi-verificati.story.md).

## Analisi: cosa e' stato letto
`module.json`, `composer.json`, `package.json`, `vite.config.js`; `app/` (77 file `.php` in `Actions/`, 16 file in `Models/` con 13 modelli e 13 policy, 46 in `Datas/`, `Adapters/`, `Contracts/`, `Support/`, `Filament/` con `Forms/Components`, `Resources`, `Pages`, `Widgets`); `routes/`, `config/config.php`, `resources/js/components`, `resources/svg`, `lang/`, `tests/` (105 file PHP, 16 spec Playwright, 1 test Node). Prove eseguite: `php artisan module:list`, `route:list --json`, `tinker` sulle chiavi di config (senza config cache), PHPStan, `node --test`, un file Pest su database usa-e-getta.

### Falso o mancante, con la realta'
| Documento | Affermazione | Realta' verificata |
|---|---|---|
| `README.md` | `app/Services/GeocodingService.php`, `MapProviderService.php`; `Filament/Fields/{AddressInput,...}` | `app/Services/` e' vuota; i componenti sono in `app/Filament/Forms/Components/` |
| `README.md` | `GetCoordinatesAction::execute([...'provider'...])` statico | `execute(string $formattedAddress): ?LocationData`, solo Google Maps, chiave `services.google.maps.key` |
| `README.md` | `CalculateDistanceAction::execute([lat1..unit])` restituisce "470.2 km" | vuole due `LocationData`, usa Google Distance Matrix; la distanza senza API e' `Math/CalculateGeoDistanceAction` |
| `README.md` | `FilterCoordinatesInRadiusAction` con raggio in km | `execute(float, float, array, int $radius)`, raggio in metri, una chiamata Distance Matrix per punto |
| `README.md` | `AddressInput->provider()->storeCoordinates()->showMap()`, `LeafletMarkerMapInput->storeAs()` | nessuno dei quattro metodi e' definito in `app/` |
| `README.md` | config in `laravel/config/local/geo/config.php` con `default_provider`, `providers`, `distance_unit` | la config e' `Modules/Geo/config/config.php` con altre chiavi; `laravel/config/local/geo` non esiste |
| `README.md` | test `pest Modules/Geo/tests/Feature/GeocodingTest.php`, copertura 80%, `phpstan --level=max` | il file non esiste; il livello e' fissato da `laravel/phpstan.neon`; copertura non misurata |
| `INDEX.md` | `GetCoordinatesFromAddressAction`; 5 link a `_bmad/`, `DesignComuni`, `Fixcity/docs/address-implementation.md`, `_integration/archive/` | la classe e' `GetCoordinatesByAddressAction`; i bersagli non esistono (uno ricollocato in `_integration/here-com.md`); sezione "DEDUPLICATION" parla di cancellazioni mai avvenute |
| `00-INDEX.md` | `app/Enums/AddressItemType.php`; `FilterCoordinatesInRadius.php` e `ClusterLocationsAction.wip` rinominati `.bak` | gli enum sono `AddressItemEnum`, `AddressTypeEnum`; `FilterCoordinatesInRadius.php` esiste ancora, i `.wip` pure, e `ClusterLocationsAction.php` esiste |
| `00-index.md` | 51 azioni, 6 widget, 7 link inesistenti | 77 file in `Actions/`, 7 widget; link annotati |
| `index.md` | sembra l'indice di Geo | e' l'indice "PTVX - Documentazione Completa" (41 link senza bersaglio): segnato `stale` |
| `wiki/ProjectHome.md`, `projecthome.md`, `reflective.md`, `method-name-homonym-census.md` | wiki di Geo | contenuti di PTVX, Ptv/UI e un censimento di progetto: segnati `stale` |
| `wiki/bmad-method.md`, `wiki/agents.md` | stub con canonical inesistente; segnaposto `{{TYPE^}}` | stub riportato al concept `docs/wiki/concepts/bmad-method.md`; segnaposto annotato |

### Scoperte sul codice (non corrette, fuori perimetro)
1. **Chiavi di config sbagliate.** `config/config.php` si carica come `geo.config`. `GetAddressDataFromFullAddressAction`, `GoogleMapsAction` e `GoogleMaps/GoogleMapsHttpAction` leggono `config('geo.driver')`, `geo.api_keys.*`, `geo.cache.*`, `geo.rate_limits.*`, `geo.http_client.*`. Misura con `php artisan tinker` (nessuna config cache): `config('geo')` ha le sole chiavi `config` e `sushi`, e `config('geo.driver')` vale `null`. Quindi `GEO_DRIVER` (ADR `wiki/decisions/geo-geocoding-driver-consolidation.md`) non ha effetto. Solo `HasCoordinatePicker` legge la chiave giusta, `geo.config.map.default_view`.
2. **Test PHP non eseguibili qui.** `tests/TestCase.php` (righe 73 e 77) forza `xra.pub_theme = 'Meetup'`; `laravel/Themes/Meetup` esiste ma non ha `resources/views/pages`. `FormatCoordinatesActionTest` (nessuna dipendenza): 6 falliti, 1 passato, `realpath not find dir[.../Themes/Meetup/resources/views/pages]`. Conferma la nota del decision-log del 2026-10-08.
3. **Duplicati di Actions**: due `GetAddressFromBingMapsAction` (`Bing/` e `BingMaps/`), due `CalculateGeoDistanceAction` (`Distance/`, `Math/`), due `IsPointInPolygonAction` (`Math/`, `Polygon/`), due `OptimizeRouteAction` (radice e `GoogleMaps/`); 19 file di scarto in `app/` (`.wip`, `.disabled*`, `.fila3`, `.maybe_profile`, `.old`, `.backup-*`, `.bak*`).
4. `app/DataTransferObjects/LocationDTO.php` esiste, mentre il decision-log del 2026-10-08 lo dava per eliminato.

## Modifiche (solo sostituzioni mirate)
`README.md` (sezione di identita'/quick start, albero, tabella componenti, esempi, config, test, qualita', link), `INDEX.md` (nota sul contratto, classificazione delle directory, 5 link, nome classe, nota sulla deduplicazione), `00-INDEX.md` e `00-index.md` (correzioni con evidenza, link annotati), `decision-log.md` (una voce in Open Questions), `stories/index.md` (link a questa story e alle recenti), `wiki/index.md`, `wiki/log.md`, `wiki/agents.md`, `wiki/bmad-method.md`, `wiki/coordinate-picker-filament5-save-pattern.md`; `index.md`, `wiki/ProjectHome.md`, `wiki/projecthome.md`, `wiki/reflective.md`, `wiki/method-name-homonym-census.md` segnati `stale` con lo strumento; questa story e la nota di memoria `bashscripts/ai/wiki/memories/docs-fixcity-geo-studio.md`. Nessun file spostato, rinominato o cancellato.

## Verifica (output reale, 2026-10-14)
- Link non risolti (`docs-organizer.py --busy-minutes 0 links ... --by-name`, dry-run), prima -> dopo: `README.md` 2 -> 0, `00-INDEX.md` 4 -> 0, `00-index.md` 7 -> 0, `INDEX.md` 6 -> 0, `wiki/index.md` 1 -> 0, `wiki/log.md` 2 -> 0, `wiki/bmad-method.md` 1 -> 0, `wiki/coordinate-picker-filament5-save-pattern.md` 2 -> 0; `wiki/agents.md` 1 -> 1 (annotato, il tool conta comunque il commento). Somma sugli ingressi e sulle pagine corrette: 26 -> 1. Restano 101 eventi nei 5 file `stale` (`index.md` 41, `ProjectHome.md` 10, `projecthome.md` 10, `reflective.md` 7, `method-name-homonym-census.md` 33): spiegati dalla nota `stale`, non annotati uno per uno. Intera cartella: 1787 -> 1762.
- Controllo indipendente di ogni link relativo: `README.md` 0/15 e `INDEX.md` 0/74 rotti.
- `phpstan analyse Modules/Fixcity Modules/Geo` (config unica, livello `max`): Geo 0 errori.
- `node --test Modules/Geo/tests/js/default-view.test.mjs`: 3 passati, 0 falliti.
- Pest: vedi scoperta 2; DB di sviluppo invariato (18 ticket, 11 utenti prima e dopo).
- `php artisan module:list`: Geo `Enabled`. `route:list`: `geo/admin`, `geo/admin/addresses`, `geo/admin/locations` e 7 pagine; nessuna rotta fuori dal pannello.

## Decisioni
- Nessun indice nuovo. Il conflitto fra contratto (`00-INDEX.md` canonico) e decisione del 2026-10-14 (`INDEX.md` ingresso unico) non e' risolto qui: annotato in `INDEX.md` e nel decision-log.
- Le sezioni storiche false non sono state cancellate: correzione in linea con evidenza.

## Aperto
- Decidere l'indice canonico (e la collisione `00-INDEX.md`/`00-index.md` su filesystem insensibili alle maiuscole, DOC-006).
- Correggere le chiavi `geo.*` nel codice (o spostare il file di config) e rendere eseguibili i test PHP di Geo (`Meetup`): sono bug di codice.
- Rimuovere o archiviare i 19 file di scarto e le copie di Actions, con decisione e mappa dei riferimenti.
- 101 link nei 5 file `stale` e il resto della cartella (1762 eventi) dipendono da DOC-004/006.
- Le sottocartelle non confrontate con il codice (`roadmap/`, `testing/`, `utils/`, `pdf/`, `scripts/`, ...) restano da verificare.
