---
title: "Sushi nei modelli Tenant: trappole verificate"
type: how-to
module: Tenant
slug: sushi-model-pitfalls
status: active
created: 2026-09-30
updated: 2026-09-30
---
tags: [docs, tenant, bmad]

# Sushi nei modelli Tenant: trappole verificate

Sintomi visti sul campo, causa verificata sul codice, cura. Story: `stories/7.4.sushi-connection-by-name.story.md`.

## 1. `unique` / `exists` rispondono "no such table"

Sintomo: `SQLSTATE[HY000]: General error: 1 no such table: web_services (Connection: Modules\Sigma\Models\WebService, Database: :memory:, ...)`
su `select count(*) ... where "name" = ...` durante la validazione di un form Filament con `->unique()`.

Causa:

- `Sushi::getConnectionName()` restituisce `static::class` (`vendor/calebporzio/sushi/src/Sushi.php:276`).
- `Rule::unique(Model::class)` risolve il nome connessione dal modello (`DatabaseRule::resolveTableName`, `Illuminate/Validation/Rules/DatabaseRule.php:61`)
  e `DatabaseManager::connection($nome)` costruisce la connessione dalla config.
- Sushi scrive solo la config `database.connections.<Classe>` con `database => ':memory:'` (`Sushi.php:137`): `DatabaseManager` apre un SQLite in memoria
  NUOVO e vuoto, diverso dall'istanza `$sushiConnection` dove Sushi ha creato la tabella.
- Con la cache su file la config punta a un file vero e il problema non compare; senza cache (il default per `getRows()`, `Sushi.php:30`) compare sempre.

Cura: `Modules\Tenant\Models\Traits\SushiConnectionByName` registra `DB::extend(static::class, ...)` che restituisce l'istanza viva.
Lo usano `SushiToJson`, `SushiToJsons`, `SushiToCsv`, `SushiToPhpArray`. Un modello con `use Sushi;` puro deve aggiungere `use SushiConnectionByName;`.

## 2. Il primo salvataggio fallisce con JSON vuoto

- Con zero righe Sushi crea la tabella con `id` e timestamp e nient'altro (`Sushi.php:149`, `createTableWithNoData`).
  Il modello deve dichiarare `protected array $schema = ['colonna' => 'tipo', ...]` con TUTTE le colonne che scrive,
  comprese `created_by` e `updated_by` (le scrive `SushiToJson` quando c'e' un utente autenticato).
- Un file JSON a 0 byte: `Safe\json_decode('')` lancia `JsonException`. Un file vuoto vale "nessun record", un JSON malformato resta un errore
  (non si cattura: un `catch` che restituisce `[]` nasconde la corruzione e contraddice `it throws exception when json data is invalid`).

## 3. `count(): Argument #1 ($value) must be of type Countable|array, null given`

Un modello che estende `BaseModelJson` e ripete `use \Sushi\Sushi;` reimporta il `getRows()` del vendor (`return $this->rows`), che scavalca quello ereditato
da `SushiToJson`. Il `use` va tolto: il trait c'e' gia' nel padre.

## 4. Cache su file (`sushiShouldCache() = true`)

- Il file e' `storage/framework/cache/sushi-<classe-kebab>.sqlite`: il nome non contiene il tenant, e non ho trovato override tenant dello storage.
- E' considerato aggiornato se `filemtime(file del MODELLO) <= filemtime(cache)`: modificare il JSON a mano non lo invalida.
- Se il primo `migrate()` fallisce resta un file a 0 byte PIU' RECENTE del modello: Sushi lo prende per valido e da allora ogni richiesta risponde `no such table`.
  Cura: cancellare il file (e' un artefatto), oppure rieditare il file del modello.
- I test devono impostare `config(['sushi.cache-path' => <cartella temporanea>])` prima del boot, mai scrivere in `storage/framework/cache`.

## 5. Test dei modelli Sushi

- `Model::clearBootedModels()` da solo registra due volte i listener `creating/updating/deleting`: prima `Modello::flushEventListeners()`.
- Sushi legge il JSON al boot del modello, quindi ogni test deve ripartire da un modello non avviato.
- Fixture di riferimento: `tests/Unit/Traits/SushiConnectionByNameTest.php` (Tenant), `tests/Unit/Models/WebServiceJsonStorageTest.php` (Sigma).
