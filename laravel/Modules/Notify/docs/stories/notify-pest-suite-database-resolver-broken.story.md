---
tags: [documentation]
qmd: "notify pest suite database resolver broken.story"
issues: []
discussions: []
title: "Modules/Notify: la suite Pest non riesce a interrogare il database in modo affidabile: la maggior parte dei file di test fallisce per il bootstrap, non per la logica"
type: story
module: Notify
epic: null
story_id: null
slug: notify-pest-suite-database-resolver-broken
status: ready-for-dev
cold_gate: null
created: '2026-09-15'
updated: '2026-09-15'
repository: "https://github.com/laraxot/module_notify_fila5.git"
github_issue: "https://github.com/laraxot/module_notify_fila5/issues/70"
github_discussion: "https://github.com/laraxot/module_notify_fila5/discussions/71"
estimated_effort: null
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "laravel/Modules/Notify/tests/TestCase.php"
  - "laravel/Modules/Xot/tests/XotBaseTestCase.php"
related:
  - "../../Quaeris/docs/stories/quaeris-send-invite-migrate-to-record-notification.md"
  - "../testing-testcaseatabase-connection.md"
  - "../testing-testcase-database-connection-fix.md"
---

# Modules/Notify: la suite Pest non riesce a interrogare il database in modo affidabile

## Contesto

Scoperto il 2026-09-15 facendo il Task 8 (AC12) della story
`quaeris-send-invite-migrate-to-record-notification.md` (`module_quaeris_fila5#38`):
una passata Pest completa, file per file, per verificare che le modifiche di
quella story non avessero introdotto regressioni in `Modules/Notify`.

Non è un problema causato da quella story. Confermato riportando
temporaneamente `SmsChannel.php`, `RecordNotification.php` e `SpatieEmail.php`
al commit precedente (`git checkout f4418d9dc --`) e rieseguendo gli stessi
test: **risultati identici, file per file**, prima e dopo le modifiche.

## Scala del problema

Eseguendo ogni file di test di `Modules/Notify` singolarmente (137 file totali
tra Notify e Quaeris, per evitare l'inquinamento tra file di cui sotto):
**~75 file su ~90 in `Modules/Notify` hanno almeno un test fallito.**

Due sintomi diversi, probabilmente la stessa causa radice:
1. Alcuni file falliscono dal primo test che tocca davvero il database, con
   `Error: Call to a member function connection() on null` (in
   `Illuminate\Database\Eloquent\Model::resolveConnection()` -
   `static::$resolver` è `null`).
2. Altri file hanno i primi test (di solito reflection pura, nessun accesso al
   DB) verdi, poi il primo che tocca davvero il database fallisce con
   `BindingResolutionException: Target class [config] does not exist`: e da
   quel punto in poi, nello stesso file, ogni test successivo fallisce a
   cascata con lo stesso errore (il container Laravel risulta svuotato di
   binding di base come `'config'`).

## Riproduzione minima

Un test banale, estraneo a qualunque logica applicativa, riproduce il sintomo
1 in modo identico:

```php
it('can count mail templates', function (): void {
    $count = \Modules\Notify\Models\MailTemplate::query()->count();
    Assert::assertIsInt($count);
});
```

Fallisce identico sia in `Modules/Notify/tests/Unit/Emails/` sia in
`Modules/Notify/tests/Unit/Models/` (cartelle diverse, stesso risultato): non
è una questione di dove si trova il file, è la prima query reale a
`MailTemplate` (connessione `notify`) in un processo Pest pulito a fallire.

Al contrario, un test che non tocca il database (es. via
`Notification::fake()`, o via `app(SmsChannel::class)` con uno stub PHP puro
senza mai chiamare il driver reale) passa sempre pulito, indipendentemente
dall'ordine in cui viene eseguito.

## Meccanismo (analisi, non fix)

`Modules/Notify/tests/TestCase::setUp()` chiama
`$this->prepareSharedSqliteForTesting()` (definito in
`Modules/Xot/tests/XotBaseTestCase.php:288`) **prima** di `parent::setUp()`.
Quel metodo:

1. Scansiona `config('database.connections')` e raccoglie solo le connessioni
   il cui `driver` risulta **già** `sqlite` a quel punto del boot.
2. Punta tutte quelle connessioni allo stesso file sqlite condiviso
   (`self::sharedSqlitePath()`, pensato per essere costruito esternamente da
   `php artisan xot:build-test-sqlite`).
3. Usa reflection su `Illuminate\Database\DatabaseManager::$connections` per
   far condividere a tutte quelle connessioni **lo stesso oggetto connessione
   fisico** (non solo la stessa config).

Se la connessione `notify` non risulta ancora con `driver=sqlite` nel momento
esatto in cui questo metodo gira (es. perché la config del modulo Notify non è
ancora stata mergiata, o perché in questo ambiente la connessione resta
`mysql` per qualche altro motivo), `notify` **non entra in questo meccanismo**
e resta affidata al comportamento normale di Testbench per la connessione
reale: che in questo ambiente, per qualche motivo non ancora isolato, non
basta a inizializzare `Model::$resolver` in modo affidabile.

## Nota storica: un fix diverso per un problema simile, oggi non più presente

Due documenti esistenti in questo stesso modulo, entrambi marcati
**"Status: Completed"** (gennaio 2025):

- [testing-testcaseatabase-connection.md](../testing-testcaseatabase-connection.md)
- [testing-testcase-database-connection-fix.md](../testing-testcase-database-connection-fix.md)

descrivono un problema quasi identico nel sintomo
(`InvalidArgumentException: Database connection [notify] not configured`) e un
fix **diverso**: configurare esplicitamente ogni connessione (incluso
`notify`) a sqlite in-memory dentro `setUp()`, poi lanciare
`php artisan module:migrate` per Xot/User/Notify nello stesso metodo: nessuna
dipendenza da un file sqlite pre-costruito esternamente.

Quel pattern **non è più nel codice attuale**: è stato sostituito da
`prepareSharedSqliteForTesting()`/`xot:build-test-sqlite` (probabilmente per
velocità: un file condiviso invece di ricostruire lo schema per ogni
processo). Non è chiaro, senza indagare oltre, se questa sostituzione abbia
reintrodotto lo stesso problema del 2025 in una forma diversa, o se sia un
problema distinto introdotto dal nuovo meccanismo.

## Impatto concreto sulla story `module_quaeris_fila5#38`

Il Task 7 di quella story (test Pest per `SendInviteAction`) non è impattato:
usa `Notification::fake()`, che non tocca mai il database per davvero.

Ma per proteggere con un test reale il Difetto 16 (`SpatieEmail` non
valorizzava `html_layout_path` sui template auto-creati) e la prima metà del
Difetto 17 (`RecordNotification::toSms()` doveva ritornare `null` a corpo
vuoto) serve davvero interrogare `MailTemplate`: e questo problema lo
impedisce. Due file di test sono stati scritti e sono corretti (verificato che
la stessa identica cosa, banale e priva di qualunque logica di dominio, fallisce
allo stesso modo), ma restano rossi per questa causa esterna:

- `laravel/Modules/Notify/tests/Unit/Emails/SpatieEmailAutoCreateDefaultsTest.php`
- `laravel/Modules/Notify/tests/Unit/Notifications/RecordNotificationToSmsTest.php`

Il terzo file scritto per lo stesso Difetto 17 non è impattato, perché non
tocca il database:

- `laravel/Modules/Notify/tests/Unit/Channels/SmsChannelSendTest.php` (3/3 verdi)

## Cosa NON è stato fatto, deliberatamente

Nessun tentativo di modificare `prepareSharedSqliteForTesting()`,
`XotBaseTestCase.php`, o `Notify/tests/TestCase.php`: su richiesta esplicita
dell'utente di capire meglio il problema prima di decidere come affrontarlo.
Questa story è analisi/tracciamento, non un fix.

## Possibili prossimi passi (da decidere, non da eseguire autonomamente)

1. Verificare con un dump di `config('database.connections.notify.driver')`
   nel punto esatto in cui gira `prepareSharedSqliteForTesting()`, per
   confermare se `notify` viene davvero escluso dal meccanismo shared-sqlite.
2. Verificare se `php artisan xot:build-test-sqlite` è mai stato eseguito/è
   aggiornato in questo ambiente, e cosa succede se si rigenera.
3. Decidere se recuperare il pattern del 2025 (migrate esplicito per
   connessione dentro `setUp()`) come fallback quando una connessione
   richiesta non rientra nel meccanismo shared-sqlite, o se il problema è
   altrove (es. ordine dei service provider, cache di boot).
4. Verificare se il problema è specifico di questa macchina/ambiente locale o
   riproducibile anche in CI: cambia molto la priorità.

## Acceptance Criteria (per una futura story di fix: non questa)

1. Un test Pest nuovo, minimo, che interroga `Modules\Notify\Models\MailTemplate`
   come prima operazione del file, passa in modo affidabile e ripetibile.
2. `SpatieEmailAutoCreateDefaultsTest.php` e `RecordNotificationToSmsTest.php`
   (già scritti, corretti) passano senza modifiche al loro contenuto.
3. Nessuna regressione sui file di `Modules/Notify` attualmente verdi.
