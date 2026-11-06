---
id: test-database-guard
title: "Guardia nel bootstrap dei test: rifiuta di partire se un test puo' raggiungere un database non usa-e-getta"
type: story
status: done
priority: P0
owner: module:Xot
module: Xot
created: 2026-10-20
updated: 2026-10-20
tags: [test, database, sicurezza, isolamento, guardia]
qmd: "test database guard TestDatabaseGuard CreatesApplication _test RefreshDatabase migrate:fresh APP_ENV testing"
related: [dcp-45-isolamento-db-test-pest-scratch]
---

# Guardia sul database dei test

Fase BMAD: Dev (story, implementazione, verifica senza database).

## Richiesta
Dopo il boot dell'app di test e prima di qualunque test, abortire con un messaggio chiaro se:
1. l'ambiente non e' `testing`; oppure
2. esiste una connessione non sqlite con `database` valorizzato che non finisce per `_test`.

Le connessioni sqlite (anche `:memory:`) sono ammesse. Il messaggio nomina connessioni e database, mai password.

## Causa
Nessuna guardia nel codice: `tests/TestCase.php` era vuoto, `Modules/Xot/tests/CreatesApplication.php` non controllava il nome del DB. 18 file usano `RefreshDatabase` (`migrate:fresh` sulla connessione di default, cioe' DROP di tutte le tabelle) e `SendInviteActionFailedJobRetryTest` fa `truncate()` su `jobs`. Il DB reale e quello di test stanno sullo stesso server, con lo stesso account (che ha DROP): li separa solo il nome. Tre rotture portano al DB reale:
1. `APP_ENV` gia' esportato diverso da `testing`: `phpunit.xml` non ha `force="true"`, quindi non lo sovrascrive e si carica `.env`.
2. `DB_DATABASE`, `DB_DATABASE_USER`, `DB_DATABASE_LIMESURVEY` gia' esportati: l'ambiente di processo batte `.env.testing`.
3. `.env.testing` assente: `App\Application::environmentFile()` ripiega in silenzio su `.env` (percorso `Tests\TestCase` radice).

Una quarta, trovata durante il lavoro: `DB_URL` impostato. Nelle connessioni base `url => env('DB_URL')`, e schema/path dell'URL vincono su `driver` e `database`, anche su una connessione dichiarata sqlite.

## Cosa e' stato messo e dove
- `laravel/Modules/Xot/tests/Support/TestDatabaseGuard.php` (nuovo): classe finale con `assert(string $env, array $connections): void`, funzione pura (shape `array<string, array{driver?: string, database?: string|null, url?: string|null}>`), piu' `assertApplication(Application $app)` che legge ambiente e `database.connections` effettivi (anche da config in cache) e li restringe di tipo. Per `url` usa `Illuminate\Support\ConfigurationUrlParser`, lo stesso parser del runtime. L'URL non viene mai stampato.
- `laravel/Modules/Xot/tests/CreatesApplication.php`: una riga dopo `$app->boot()` e prima di `return $app;`. Copre tutti i TestCase di modulo (`XotBaseTestCase`, Geo, Notify, e quindi anche i 4 `RefreshDatabase` di modulo).
- `laravel/tests/TestCase.php`: override minimo di `createApplication()` che chiama `parent::createApplication()` e poi la stessa guardia. Copre i 14 file `RefreshDatabase` su `Tests\TestCase` radice e `Modules/Cms` (estende la radice). Comportamento del boot invariato.
- `laravel/tests/Architecture/TestDatabaseGuardTest.php` (nuovo, Pest, NON eseguito): gli stessi casi in versione Pest, senza boot Laravel.

### Eccezioni documentate (da leggere)
- Connessione `liveuser_general` esclusa. Evidenza: `config/localhost/database.php:27` legge `DB_DATABASE_LU`, che non e' definita ne' in `.env` ne' in `.env.testing`, quindi anche nel caso normale vale il fallback fisso `forge13`. Unico consumatore: `config/localhost/auth.php:109` (`auth.passwords.users.connection`, token di reset password). Nessun codice di `Modules/*/app` la usa. Senza esclusione la guardia scatterebbe a ogni run.
- Prefisso `claude_scratch_pest_` accettato oltre a `_test`. Evidenza: `bashscripts/tools/pest-scratch-db.sh:25` crea `claude_scratch_pest_<ts>_<pid>` ed esporta quel nome nelle tre variabili DB; lo elimina in uscita. Senza eccezione ogni run con quello script verrebbe rifiutato.

### Fallback con nomi reali in `config/database.php` (non toccati)
Riga 126 (`quaeris`) e 144 (`quaeris_data`): `'quaeris_data'`; riga 161 (`quaeris_user`): `'quaeris_user'`; riga 178 (`quaeris_survey`): `'quaeris_survey'`. Se la variabile manca, la connessione punta al DB reale. Altri fallback non `_test` (`laravel` righe 54/74/94/109; `forge11`, `forge86`, `forge15`, `forge17`, `forge19`, `forge21` in `config/localhost/database.php`) hanno lo stesso effetto. La guardia li intercetta tutti, tranne `liveuser_general`.

## Verifica (senza database, senza Pest, senza artisan)
`php -l` pulito su tutti e 4 i file toccati. Controllo eseguibile della sola funzione pura (script nello scratchpad, `vendor/autoload.php` per il parser URL, nessun boot Laravel):

```
PASS | 1 testing + soli *_test e sqlite -> ok | ok
PASS | 2 env=local -> eccezione | eccezione
PASS | 3 mysql con quaeris_data -> eccezione | eccezione
PASS | 4 sqlite :memory: + mysql quaeris_data_test -> ok | ok
PASS | 5 DB_URL mysql su connessione sqlite, password non stampata -> eccezione | eccezione
PASS | 6 scratch pest + liveuser_general ignorata -> ok | ok
```

PHPStan mirato sui 4 file (`phpstan.neon` del progetto): prima passata exit 1 (`Function parse_url is unsafe`), corretta usando `ConfigurationUrlParser`; seconda passata exit 0, nessun errore.

Non verificato: il boot reale dell'app con la guardia (vietato lanciare Pest, artisan o aprire connessioni). Che `liveuser_general` sia l'unica connessione non `_test` nel caso normale e' dedotto da lettura statica di `config/database.php`, `config/localhost/database.php`, `.env.testing` e `TenantServiceProvider`. Al primo run reale, se la guardia scatta su un'altra connessione, il messaggio la nomina con il suo database.

## Cosa NON copre
- Account DB con DROP sullo stesso server: se `_test` e reale sono raggiungibili con lo stesso utente, un test che scrive una connessione costruita a mano (non in `database.connections` al boot) non e' fermato. La vera difesa e' un account di test con grant solo su `*_test`. Decisione dell'utente.
- Connessioni aggiunte dopo il boot (ad esempio `Config::set('database.connections.limesurvey', ...)` in comandi di `Modules/Quaeris`): la guardia gira una volta sola, al boot.
- Test senza TestCase (Pest puro) che aprono connessioni per conto proprio.
- Esistenza dei DB `*_test` sul server: la guardia non si connette.
- Un database di nome `*_test` che contiene dati veri: la guardia si fida del nome.

## Decisioni aperte
1. Account MySQL di test con grant solo su `quaeris_data_test`, `quaeris_user_test`, `quaeris_survey_test` (utente).
2. Definire `DB_DATABASE_LU=<nome>_test` in `.env.testing` (o cambiare il fallback `forge13`) e poi togliere `liveuser_general` da `IGNORED_CONNECTIONS` (utente o lane config).
3. Rinominare lo scratch di `pest-scratch-db.sh` con suffisso `_test` e togliere il prefisso `claude_scratch_pest_` dalla guardia (lane tooling).
4. Fallback reali di `config/database.php` righe 126/144/161/178: sostituirli con un valore che fallisce (ad esempio stringa vuota) o con `*_test`. Config di produzione, fuori da questa story.
5. Legare `dcp-45` (isolamento DB di `pest-scratch-db.sh`): questa guardia ne copre in parte i punti 2 e 3, per i soli test che bootano Laravel.
