---
title: "Test e qualita del modulo Geo: Pest, Playwright, PHPStan"
type: guide
status: active
module: Geo
tags: [geo, test, pest, playwright, phpstan, qualita, architettura]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo testing pest testcase sqlite databasetransactions playwright phpstan livello 10 arch debt business behavior no probe"
related:
  - ./architecture.md
  - ./maps-and-widgets.md
---

# Test e qualita

Sintesi unica delle ~25 pagine su testing (principi, guide, "regola suprema", fix di `TestCase`) e delle ~40 su PHPStan
(roadmap, report di sessione, correzioni) che erano in radice di `docs/` (originali nel backup
`~/backups/laravelpizza-docs-md-before-cap100.tar.gz`). I report di sessione PHPStan sono cronologia e non sono stati
riportati; restano le regole durevoli.

## Struttura dei test

118 file `*Test.php` in `tests/`:

| Cartella | Contenuto |
|---|---|
| `tests/Unit/Actions/` | un test per Action o famiglia (`Address`, `Distance`, `Elevation`, `GeoData`, `Geocoding`, `GoogleMaps`, `Here`, `IPGeolocation`, `LocationIQ`, `Map`, `Maps`, `Mapbox`, `Nominatim`, `Polygon`, e le Action in radice) |
| `tests/Unit/Models/`, `Traits/`, `Datas/`, `Enums/`, `Services/`, `Support/`, `Filament/`, `View/` | modelli (`Address`, `Comune`, `Province`, `Region`, `Location`, scope di `GeoTrait`), trait (`HasAddress`, `HandlesCoordinates`), Spatie Data, enum, servizi storici |
| `tests/Feature/` | `AddressIntegrationTest`, `GeoApiTest`, `MapPickerIntegrationTest`, `OsmProxyTest`, `Filament/` (widget mappa, campi) |
| `tests/Fixtures/` | stub di Action/servizi (distance matrix, IP, elevazione): doppioni reali per i test, non "probe" per PHPStan |
| `tests/Playwright/`, `tests/Browser/` | spec browser (`geo-map-lit*.spec.js`, cluster, legenda, filtri, GPS); config `playwright.config.js` (`testDir: ./tests/Playwright`, `baseURL` 127.0.0.1:8000, 1 worker) |
| `tests/Arch/debt.php` | debito di architettura del modulo: classi che violano una regola di `Modules/Xot/tests/Arch/ArchitectureTest.php`; solo in discesa (chi corregge una classe toglie la voce, chi ne aggiunge una la motiva) |

Classi base (`tests/`): `TestCase` (SQLite condiviso in memoria con `prepareSharedSqliteForTesting()`, `DatabaseTransactions` sulle
connessioni `sqlite` e `geo`: il modello `BaseModel` usa la connessione `geo`, che i test devono configurare, altrimenti
`Database connection [geo] not configured`), `LightTestCase` (senza database, `Http::preventStrayRequests()`), `UnitTestCase`
(Testbench con i provider `XotServiceProvider` e `GeoServiceProvider`). `Pest.php` non usa `uses()->in()` (PHPStan
`method.internalClass`): ogni file dichiara la propria classe base; helper globali `createRegion()` e `createComune()`.

## Come si lanciano

```bash
./vendor/bin/pest Modules/Geo/tests                      # tutto il modulo
./vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php
./vendor/bin/pest Modules/Geo/tests --coverage           # copertura minima 80%
cd Modules/Geo && npx playwright test                    # spec browser (serve l'app su :8000)
```

Regole del progetto: solo Pest (mai PHPUnit diretto); mai `RefreshDatabase`, mai `migrate:fresh`/`migrate:refresh`/`--force`
(i dati sono sacri); su un ambiente di produzione i test non si eseguono. Se i test falliscono in `setUp` con "Unknown
database", lanciarli con `DB_DATABASE_USER=` vuoto. I test che scrivono su `Comune` puntano `geo.comuni_json_path` a un fixture
per non riscrivere il JSON versionato (vedi [json-database.md](./json-database.md)). I test HTTP verso provider esterni usano
`Http::fake()`/stub: mai chiamate reali.

## Cosa testare

Il comportamento di business, non l'implementazione: se un test si rompe rifattorizzando senza cambiare il comportamento,
testava l'implementazione. Si testano regole e validazioni, flussi completi (input → risultato), permessi, effetti
collaterali (cache, notifiche), calcoli (distanza, raggio, poligono), risposte degli endpoint. Non si testano `$fillable`,
`$casts`, `$table` ne' "quale trait usa la classe". I test esistenti non si cancellano: si correggono portandoli sul
comportamento. Ogni modello ha la sua factory (vedi [json-database.md](./json-database.md)).

## PHPStan

- Livello 10 con la configurazione condivisa `laravel/phpstan.neon` (analizza `laravel/Modules`; esclude docs, test e Blade).
  Il file `phpstan.neon` non si modifica per far tacere un errore e non si usa baseline: si corregge il codice.
  Comando: `php -d memory_limit=-1 ./vendor/bin/phpstan analyse --level=max Modules/Geo`.
- Strategia "narrowing invece di `mixed`": tipi espliciti e generics sulle collezioni, `@var` sulle variabili intermedie dopo
  `Cache::remember()` e `json_decode()`, forme degli array nei docblock (`Collection<int, array{nome: string, codice: string}>`).
  `GeoJsonModel`, `ComuneJson`, `Locality` e `GeoDataService`/`GeoDataValidator` sono stati irrigiditi cosi'.
- Niente file "probe" scritti solo per far passare PHPStan: nessuna cartella `app/Phpstan`, nessuna classe `*PhpstanProbe*`
  (verificato: assenti). Per un trait non usato si annota `@phpstan-ignore trait.unused`; per esercitare un trait in un test si
  usa una classe anonima o una fixture reale legata a un test.
- Dopo spostamenti di classi: `composer dump-autoload -o` prima di contare gli errori; i marcatori di conflitto nei `.php` fermano
  l'analisi (vedi [geo-sync-marker-repair.md](./geo-sync-marker-repair.md)).
- `Pint` per lo stile (`./vendor/bin/pint Modules/Geo`).
