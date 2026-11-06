---
title: "[STORY] Marker di conflitto committati in quattro test di Geo: PHPStan non li legge"
type: story
status: review
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Geo
tags: [git, conflict-markers, tests, phpstan, merge]
related:
  - ../../../../../bashscripts/docs/prompts/51-conflitti-git-current-change.md
  - ../../../Quaeris/docs/stories/getformschemaold-final-quaeris-resources.story.md
---

# [STORY] Marker di conflitto in quattro test di Geo

## Richiesta

Dopo il pull dei sottomoduli, PHPStan segnala errori in:

- `tests/Unit/GeocodingBusinessLogicTest.php`
- `tests/Unit/Models/ComuneBusinessLogicTest.php`
- `tests/Unit/Models/ProvinceBusinessLogicTest.php`
- `tests/Unit/Models/RegionBusinessLogicTest.php`

## Analisi

### Causa

`php -l`: `syntax error, unexpected token "<<"`. I quattro file contengono marker di conflitto git (`<<<<<<<`, `=======`, `>>>>>>>`), sei blocchi in tutto, committati dal merge `41c00823` del repo Geo (genitori `789c41e7` e `5408a3c2`). Il commit `0ffbcc9a` del 2026-09-24 li aveva gia' tolti da questi file. Il merge li ha rimessi. `bashscripts/tools/check-conflict-markers.sh` conferma: sono gli unici file PHP del progetto con marker.

### I due lati

| File | Blocchi | Lato A (primo) | Lato B (secondo) |
|---|---|---|---|
| `RegionBusinessLogicTest` | 1 | `Assert::assertSame('integer', (new Region)->getKeyType())`; `$schema = (new Region)->getSchema()` | `$region = new Region(); expect(...)` |
| `ProvinceBusinessLogicTest` | 2 | `$schema = (new Province)->getSchema()`; `$rows = (new Province)->getRows()` | `$province = new Province();` |
| `ComuneBusinessLogicTest` | 2 | `$schema = (new Comune)->getSchema()`; `assertSame('', jsonDirectory)`; `assertSame([], translatable)` | `$comune = new Comune();`; `toBeString()`; `toBeArray()` |
| `GeocodingBusinessLogicTest` | 1 | closure `static` tipizzata, con PHPDoc delle forme degli array, e `Assert::` | closure `fn` senza tipi, `expect()` |

### Decisione: lato A in tutti e sei i blocchi

1. **Solo il lato A e' compatibile con il codice comune che segue.** Dopo ogni blocco le righe non in conflitto usano `$schema` e `$rows`, che solo il lato A definisce. Il lato B definisce `$region`, `$province` e `$comune`, che poi nessuno usa: con il lato B i test userebbero variabili non definite.
2. **Il lato A e' la versione consolidata.** Ricostruendo ogni file con il lato A: `GeocodingBusinessLogicTest` e' identico al genitore `789c41e7`. Negli altri tre, l'unica differenza dal genitore e' `new X()` al posto di `new X` in righe fuori dai blocchi, prese pulite dall'altro ramo.
3. **Stesso stile del resto del file.** Tutte le altre asserzioni dei quattro file usano `PHPUnit\Framework\Assert`. Nella versione di `0ffbcc9a` non c'era nessun `expect()`.
4. **Nessun controllo perso.** Le asserzioni del lato A sono uguali o piu' severe (`assertSame('')` invece di `toBeString()`, `assertSame([])` invece di `toBeArray()`). Il lato B non contiene controlli che il lato A non abbia.

Le righe fuori dai blocchi non si toccano, nemmeno le differenze di stile `new X()`.

## Modifiche

Nei quattro file: ogni blocco sostituito dal suo lato A, marker tolti. Modifica in avanti, nessun `checkout --ours/--theirs`.

## Fuori scope

Marker anche in alcuni `.md` di `docs/` di Geo, in documenti di Xot e User e in `UI/.../InteractiveMap.php.old`. Nessuno e' PHP caricato: non bloccano PHPStan ne' l'autoload. Non toccati.

## Verifica

Vedi "Esito" in coda.

## Esito (2026-10-20)

- **Marker:** nessuno nei quattro file (`/bin/grep` vuoto). `bashscripts/tools/check-conflict-markers.sh` non elenca piu' alcun file PHP con marker nel progetto.
- **`git diff --check`:** pulito. Il diff contiene solo righe tolte (47: marker e lato B).
- **`php -l`:** pulito sui quattro file. Ogni file e' identico al "lato A" ricostruito prima della modifica.
- **PHPStan:** lo lancia l'utente; l'errore era il parsing di questi quattro file.
- **PHPMD / PHPInsights:** non lanciati. Il diff toglie solo righe, quindi non puo' introdurre segnalazioni nuove.
- **Pest sui quattro file:** `Tests: 21 failed, 29 passed`. Ora i test vengono letti, e si vedono due problemi che i marker nascondevano, non collegati alla scelta del lato:
  1. `ComuneBusinessLogicTest`, `ProvinceBusinessLogicTest`, `RegionBusinessLogicTest` non dichiarano `uses(TestCase::class)`, e non l'hanno mai fatto (stesso stato in `0ffbcc9a`, `789c41e7`, `5408a3c2`). Senza applicazione avviata il modello Sushi chiama `storage_path()` sul container nudo: `Call to undefined method Illuminate\Container\Container::storagePath()`. Nei test successivi lo stesso modello resta a meta' boot: `bootIfNotBooted ... while it is being booted`. Falliscono anche test che non contenevano conflitti (`... can be instantiated without errors`, `... can be queried by name`). Anche il lato B istanziava gli stessi modelli.
  2. Altri test rossi negli stessi file, fuori dai blocchi: `HasFactory` atteso sui modelli Sushi, `Unknown format "randomElement"` (Faker), `storedEventRepository` non risolvibile (Spatie Event Sourcing), due limiti numerici in `GeocodingBusinessLogicTest` > "Data Quality and Validation".
- **Il test di Geocoding che conteneva il blocco** ("validates coordinate bounds checking") passa: `Tests: 1 passed (2 assertions)`.

## Aperto

- `uses(TestCase::class)` mancante nei tre test dei modelli (punto 1 dell'Esito). Proposta: aggiungerlo come negli altri test di `tests/Unit/Models` (es. `ComuneTest.php`). Da confermare: il log del 2026-10-14 segnala che `tests/TestCase.php` di Geo forza il tema `Meetup`, che in un altro progetto impediva l'avvio dei test.
- Le altre cause del punto 2.