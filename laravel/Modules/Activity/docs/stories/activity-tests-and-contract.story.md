---
title: "Activity: test che non girano o non provano e contratto del modulo"
type: story
status: blocked
priority: P2
created: 2026-10-20
updated: 2026-10-30
module: Activity
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on:
  - ../../../Xot/docs/stories/test-database-guard.story.md
  - ./phpstan-test-wave-activity.story.md
tags: [bmad, activity, tests, pest, test-database, sqlite, skip, tautologies, filament-blueprint, w2]
qmd: "Activity Pest test_data.sqlite SQLite condiviso XotBaseTestCase dati sacri blocker"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/328"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/329"
---

# Activity: test che non girano o non provano e contratto del modulo

Fase BMAD: Create Story (wave W2 dell'epic, lane Activity). Solo documentazione: nessun PHP toccato per scriverla.

## Richiesta

Ordine permanente dell'utente (2026-10-20): "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint". Qui: dire quanto della suite di Activity prova davvero qualcosa e che cosa serve per farla girare. Epic: [epic-code-quality-ratchet](../../../Xot/docs/bmad/epic-code-quality-ratchet.md). La causa dei 605 errori PHPStan di test e le decisioni sulle specifiche fantasma sono in [phpstan-test-wave-activity](./phpstan-test-wave-activity.story.md) (status done): questa story parte da li' e tiene solo il lavoro rimasto.

## Scopo

- Il modulo registra il log delle azioni (`Activity`, tabella `activity_log`), gli eventi (`StoredEvent`, `stored_events`) e gli snapshot (`Snapshot`, `snapshots`) per l'audit e per la prova di accountability del Gdpr. I test devono provare creazione, immutabilita' del log, ritenzione e visualizzazione (`LogViewer`).
- I test con scrittura hanno bisogno di quelle tre tabelle nel DB di test: senza, falliscono per colpa dell'ambiente, non del codice.

## Stato misurato

## Diagnosi aggiornata — 2026-10-30

La failure `laravel/database/test_data.sqlite` assente è riproducibile staticamente e
non nasce dal dominio Activity:

1. `Modules\Activity\Tests\TestCase::setUp()` invoca
   `prepareSharedSqliteForTesting()` **prima** di `parent::setUp()`.
2. `XotBaseTestCase::sharedSqlitePath()` cerca `config('xot.testing.sqlite_file')`,
   poi un unico `laravel/database/*.sqlite`, e infine ricade su
   `database_path('test_data.sqlite')`.
3. `laravel/config/xot.php` non definisce `xot.testing.sqlite_file`; la chiave
   `config/testing.php:database.connections.sqlite_file` è un’altra struttura e non
   viene letta da quel resolver.
4. `laravel/database` contiene solo `.gitignore` per `*.sqlite*`; il target di
   fallback non esiste nel checkout.
5. Il TestCase quindi punta le connessioni SQLite a un artefatto locale ignorato da
   Git, ma nessun bootstrap sicuro ne costruisce lo schema prima dell’avvio dei test.

Il comando esistente `php artisan xot:build-test-sqlite` è il meccanismo previsto per
costruire lo schema, ma il suo sorgente dimostra che:

- crea il file se manca e applica le migration dei moduli;
- `--fresh` esegue `unlink()` sul target esistente;
- anche senza `--fresh` modifica il database SQLite indicato.

Per rispetto dei dati sacri non è stato eseguito: manca una verifica esplicita che il
target sia disposable e non esiste nel repository un database Activity di test già
pronto. Non è quindi corretto risolvere la failure creando automaticamente un file o
aggiungendo una migration al `setUp()`.

### Esito della diagnosi

- **Causa primaria:** contratto incoerente: Activity forza SQLite condiviso, mentre
  `.env.testing` dichiara MySQL (`techplanner_data_test`) e `APP_ENV=local`.
- **Causa secondaria:** resolver Xot con fallback implicito a un file ignorato e non
  materializzato.
- **Codice Activity:** nessuna correzione sicura da applicare senza decidere il banco
  di test e il suo ciclo di vita.
- **Blocker:** owner dell’ambiente deve scegliere un database `_test` MySQL oppure
  autorizzare un target SQLite disposable e il comando non-fresh di build.

### Verifiche eseguite

- letti `Activity/tests/TestCase.php`, `Xot/tests/XotBaseTestCase.php`,
  `Xot/tests/CreatesApplication.php`, `.env.testing`, `config/testing.php` e
  `config/xot.php`;
- verificata l’assenza di `laravel/database/test_data.sqlite` e di qualunque SQLite
  nella directory `laravel/database`;
- verificato il sorgente di `xot:build-test-sqlite` senza invocarlo;
- nessun `migrate`, `migrate:fresh`, `reset`, Pest o connessione al database eseguita;
- nessun file applicativo modificato e nessun commit creato.

### Prossima azione autorizzabile

Dopo la scelta dell’owner, eseguire una sola lane isolata e tracciata: o test Activity
su connessioni MySQL con suffisso `_test`, oppure build SQLite su un percorso esplicito
usa-e-getta, senza `--fresh` alla prima costruzione. Solo dopo rilanciare Pest e
distinguere failure d’ambiente da failure del dominio.

Misura del 2026-10-20 tra le 13:35 e le 14:05 UTC. Cifre volatili. Il DB non e' stato interrogato in questa sessione.

- 100 file `*Test.php` (`/usr/bin/find laravel/Modules/Activity/tests -type f -name '*Test.php' | wc -l`).
- `SQLSTATE[42S02]`: la story `phpstan-test-wave-activity` (sezione Verifica) elenca 7 file che falliscono con tabelle assenti in `quaeris_data_test` e `quaeris_user_test`: `ActivityManagementTest`, `SnapshotBusinessLogicTest`, `ActivityEventSourcingTest`, `ActivityBusinessLogicTest`, `StoredEventBusinessLogicTest`, `ActivityTest`, `ActivityIntegrationTest`. Su disco i primi sei hanno un file in `tests/Feature/`, e `ActivityTest` e' `tests/Unit/Models/ActivityTest.php`; tre nomi esistono anche in `tests/Unit/Models/` come classi PHPUnit, e la story non dice quale dei due fallisca. Le tre migrazioni esistono (`database/migrations/2023_03_31_103350_create_activity_table.php`, `2023_10_30_103350_create_stored_events_table.php`, `2023_10_31_103350_create_snapshots_table.php`): non risulta che siano applicate ai DB di test. Non verificato a runtime (nessun accesso al DB).
- `RefreshDatabase`: il censimento attribuiva 2 file `StoredEvent*` a questo difetto, ma `rg -nP '^\s*use\s+RefreshDatabase\s*;|uses\([^)]*RefreshDatabase' laravel/Modules/Activity/tests` stampa 0 (controprova: lo stesso comando su `laravel/Modules/Notify/tests` stampa 4). I due hit sono commenti che lo vietano: `Feature/StoredEventEdgeCasesTest.php:7`, `Feature/StoredEventBusinessLogicExtendedTest.php:7`. Fatto smentito: Activity non ha `RefreshDatabase` attivo.
- 3 classi PHPUnit: `Unit/Models/SnapshotBusinessLogicTest.php:19`, `StoredEventBusinessLogicTest.php:19`, `ActivityBusinessLogicTest.php:15` (`final class ... extends TestCase`; `rg -lP '^(final |abstract )?class \w+Test extends' laravel/Modules/Activity/tests`).
- 12 file estendono il `Tests\TestCase` di radice invece di quello di modulo (`rg -lP '^use Tests\\TestCase;' laravel/Modules/Activity/tests | wc -l`), tra cui 8 in `Unit/Actions/Log/`, `Feature/Filament/LogViewerPageTest.php`, `LogDownloadPageTest.php`.
- 20 skip (`rg -n -e '(->|\b)(skip|todo|markTestSkipped)\w*\(' laravel/Modules/Activity/tests | wc -l`): 16 stub senza SUT, di cui `Unit/Listeners/LoginListenerTest.php:46-52` (7), `Feature/Actions/ListLogActivitiesActionTest.php:49-55` (7) e `Feature/Filament/Actions/ListLogActivitiesActionTest.php:50-51` (2); 4 condizionali (`Unit/Actions/Log/ListLogFilesActionTest.php:97`, `ResolveLogFilePathActionTest.php:79,91`, `Unit/ListLogActivitiesPageCoverageTest.php:65`). Causa degli stub: `Listeners/LoginListener.php:12` ha `handle(): void` con corpo `// ...` ed e' registrato in `Providers/EventServiceProvider.php:22`; `Filament/Actions/ListLogActivitiesAction.php` ha 4 funzioni e non i metodi che i test chiamavano.
- 6 test finti, tutti `assertGreaterThanOrEqual(0, ...)`: `Unit/Actions/CoverageHundredActionsTest.php:176,193,227` e `Unit/Actions/ActivityLoggerTest.php:186,196,208`.
- sqlite: `tests/TestCase.php:55,59` (`$connectionsToTransact = ['sqlite', 'activity', 'user']` e `prepareSharedSqliteForTesting()`). Il docblock (riga 22) e `Feature/StoredEventEdgeCasesTest.php:13` citano `fixcity_data.sqlite`, nome di un altro progetto.
- Contratto Filament: gia' conforme. `rg -nP '^(abstract |final )?class \w+ extends ' laravel/Modules/Activity/app/Filament -g '*.php' | rg -v 'extends XotBase'` stampa 0; zero stringhe di testo (`rg` del censimento); `Pages/LogViewer.php:58` dichiara `canAccess()`. Il blueprint elenca `ActivityResource`, `SnapshotResource`, `StoredEventResource` e tutti esistono.

## Lavoro

1. Decisione sul DB di test (non e' codice): applicare le tre migrazioni a `quaeris_data_test` e `quaeris_user_test`, oppure usare tabelle temporanee MySQL per i test di Activity (modello: Quaeris `GetAnswersByQuestionChartTest.php`). Regola di progetto: non creare tabelle senza chiedere. Dipende dalle decisioni 7.1 e 7.2 dell'epic. Decisione 1.
2. Dopo il punto 1 e dopo che la guardia e' dentro: rilanciare i 7 file uno alla volta e annotare l'output reale in coda a questa story; per ogni fallimento distinguere ambiente, SUT assente o difetto vero. Senza il punto 1 non si tocca nulla.
3. Le 3 classi PHPUnit in Pest con `php laravel/Modules/Xot/tools/convert-phpunit-to-pest.php Activity` e i 12 file da `Tests\TestCase` a `Modules\Activity\Tests\TestCase`. Rischio basso; si puo' fare prima del DB.
4. Gli stub: `LoginListener::handle()` e' un segnaposto registrato come listener (decisione 2 gia' aperta in `phpstan-test-wave-activity`): se il login va tracciato, implementare con `LogUserLoginAction` e riscrivere i 7 test; se no, togliere il listener e i 7 stub. Idem `ListLogActivitiesAction` (9 stub). Mai creare il metodo per far passare il test.
5. Sostituire le 6 tautologie con asserzioni esatte (conteggio atteso dopo una scrittura nota). Richiede il DB. Rischio basso.
6. sqlite: portare `TestCase` a MySQL dopo la decisione 7.4 dell'epic; intanto correggere i due docblock che citano `fixcity_data.sqlite`.
7. Cricchetto: aggiungere Activity ai contatori di `laravel/tests/Architecture/` (skip, tautologie, `Tests\TestCase` di radice) con baseline 20, 6, 12.

## Acceptance criteria

- [ ] Esiste una decisione scritta sul DB di test, con i tre nomi di tabella (`activity_log`, `stored_events`, `snapshots`) e la risposta dell'utente.
- [ ] Ognuno dei 7 file ha in coda a questa story un esito reale (passa / fallisce per ambiente / fallisce per SUT), con l'output allegato.
- [ ] `rg -lP '^(final |abstract )?class \w+Test extends' laravel/Modules/Activity/tests` stampa 0 file (prima: 3).
- [ ] `rg -lP '^use Tests\\TestCase;' laravel/Modules/Activity/tests` stampa 0 file (prima: 12).
- [ ] `rg -n 'assertGreaterThanOrEqual\(0' laravel/Modules/Activity/tests` stampa 0 righe (prima: 6).
- [ ] `rg -n -e '(->|\b)skip\(' laravel/Modules/Activity/tests` stampa 0 righe senza una story che motivi il SUT assente (prima: 16).
- [ ] `phpstan analyse` mirato sui file toccati: `[OK] No errors`; nessun ignore, nessun `mixed` nuovo.

## Verifica

Da `laravel/`, solo lettura: i comandi di "Stato misurato". Ogni zero va controprovato con il comando gemello. Nessun test eseguito da questa story.

## Vincoli

Nessun Pest/PHPUnit finche' la guardia DB (`Xot/tests/Support/TestDatabaseGuard.php`) non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta. PHPStan solo mirato, in coda `flock` di `bashscripts/docs/prompts/11-phpstan.md`; un solo run completo, a swarm fermo e a RAM libera. Un solo agente per modulo che edita PHP. `laravel/phpstan.neon` immutabile. Forward-only. Pest resta Pest (le 3 classi PHPUnit vanno convertite, non il contrario). Niente nuovi `*Service`. Niente `mixed`, `@var` o ignore di comodo. Nessuna migration o tabella senza chiedere. Il `docs/` di Activity e' di un'altra sessione.

## Decisioni aperte

1. DB di test di Activity: migrazioni sui `*_test`, tabelle temporanee MySQL o altro?
2. Il login va tracciato (listener) o il listener si ritira?
3. Una sola linea canonica dei test (decisione 1 di `phpstan-test-wave-activity`): il ramo remoto torna a `c49eef12` o si accetta di ripetere il lavoro?

## Come ripartire

1. Portare le decisioni 1 e 2 all'utente con questa lista di 7 file e 3 tabelle.
2. Nel frattempo fare i punti 3 e 6 (conversione a Pest, TestCase di modulo, docblock): non toccano il DB.
3. Dopo il via sulla guardia, rilanciare i 7 file uno per volta e allegare l'output in coda.
