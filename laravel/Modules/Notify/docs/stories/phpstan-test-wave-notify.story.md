---
title: "PHPStan test wave Notify, lane notify (residuo dopo notify-a e notify-b)"
type: story
module: Notify
phase: implementazione, quality gate
status: in-progress
priority: high
tags: [phpstan, pest, test, notify, regressione]
created: 2026-10-20
updated: 2026-11-23
issues: []
discussions: []
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - ./phpstan-test-wave-notify-a.story.md
  - ./phpstan-test-wave-notify-b.story.md
  - ./notify-phpstan-push-sms-tests.story.md
---

# PHPStan test wave Notify: lane notify (residuo)

## Fase BMAD

Build + Measure, quality gate. Perimetro: i 5 file di test che nel baseline delle 09:00 avevano ancora errori in `Modules/Notify` (128 errori in totale). Config PHPStan immutata, nessun ignore, nessuna baseline, nessun commit. Le lane `notify-a` e `notify-b` (stesso giorno) avevano gia' chiuso quasi tutto il resto del modulo: questa lane parte dal loro residuo.

## Misura di partenza

Baseline JSON del 2026-10-20, ordinata per file:

| File sotto `tests/` | Errori |
|---|---|
| `Unit/Models/NotificationTest.php` | 44 |
| `Unit/Models/ContactTest.php` | 34 |
| `Unit/Models/MailTemplateTest.php` | 27 |
| `Unit/Models/NotificationTemplateTest.php` | 16 |
| `Feature/NotificationApiTest.php` | 7 |

I primi quattro (121 errori) erano in corso di riscrittura da `notify-a` mentre misuravo: lock `notify-a` delle 09:40, scritti alle 09:44, lock rilasciati prima delle 09:49. Il quinto aveva un lock tracciato in git (vedi "File saltati per gate"). Il baseline era quindi vecchio per tutti e cinque.

## Scopo capito per causa

Raggruppo per (identificatore, messaggio normalizzato) e per ognuna ricostruisco cosa il test doveva garantire.

| Famiglia | Errori | Scopo del codice | Causa alla sorgente | Chi l'ha chiusa |
|---|---|---|---|---|
| `property.nonObject` su `Notification\|null`, `Contact\|null`, `MailTemplate\|null`, `NotificationTemplate\|null` | 97 | Dopo un `update()` o un `increment()` il test rilegge la riga dal DB e verifica il valore salvato | `Model::fresh()` ritorna `static\|null` | `notify-a`: `refresh()`, che ritorna `$this` e rilegge davvero dal DB |
| `theCodingMachineSafe.function` (`json_encode`) | 15 | Serializzare le colonne JSON (`params`, `sms_template`) per il test di cast | `json_encode` ritorna `false` in errore | `notify-a`: `use function Safe\json_encode;` |
| `offsetAccess.*` su `mixed` e `array\|null` | 17 | Leggere chiavi annidate di `sms_template` e `params` | Accesso a offset su colonne con cast `array` ma tipo dichiarato `mixed` | `notify-a`: `TestCase::notifyArrayGet()` e `firstOrFail()` al posto di `$collection[0]` |
| `method.protected` (`casts()`) | 4 | Verificare i cast reali del model | `Model::casts()` e' protetto: l'API pubblica e' `getCasts()` | `notify-a`: `getCasts()`, con attesi misurati sul comportamento reale (`HasTranslations` porta `array` sulle colonne tradotte) |
| `property.notFound` (`$metadata`, `$email`, `$mobile_phone`) | 6 | `$metadata` e' colonna di `notification_templates`; `email` e `mobile_phone` non sono colonne di `contacts` | `@property` mancante per `metadata`; per le altre due la specifica descrive colonne che non esistono | `notify-a`: `@property` additive su `NotificationTemplate`; i due test su `Contact::email` / `mobile_phone` sono diventati `markTestSkipped('Contact::email not implemented...')` |
| `function.notFound` (`assertNotifyArray`, `assertFreshModel`, `assertNotifyTableMissing`) e a cascata `mixed` | 7 | Helper di asserzione di `NotificationApiTest` | Erano funzioni globali di `tests/Pest.php`, rimosse il 2026-10-20 perche' globali a rischio "cannot redeclare" | Vedi sotto: file in modifica da un'altra sessione |
| `variable.unused` | 1 | | Variabile mai letta in `it_can_find_by_subject_pattern` | `notify-a` |

## Cosa ho trovato e non era nella tabella: `NotificationApiTest` e' una specifica fantasma

Il test chiama `POST /api/notify/send`, `GET|POST /api/notify/templates`, `GET|PUT|DELETE /api/notify/templates/{code}`. Verifica (2026-10-20):

- `Modules/Notify/routes/api.php` contiene solo un blocco commentato ("work in progress") per un webhook Telegram. Nessuna rotta e' registrata.
- `rg -P "notify/(send|templates)"` su `Modules/*/routes` e `routes/` non trova niente. `rg` su tutte le classi `*NotificationApi*Controller`, `*TemplateApi*Controller`, `*NotifyApi*Controller` in Modules e Themes non trova niente. L'unico controller del modulo e' `NotificationTrackingController`.
- `git -C Modules/Notify log --all -S'notify/templates' -- routes app` e `-S'/api/notify' -- routes app` sono vuoti: queste rotte non sono mai esistite nel prodotto. Le uniche tracce sono il test (introdotto con `102a581b2`, 2026-10-15), `docs/wiki/integrations/analysis-consolidated.md` (proposta di test) e `docs/grapesjs.md` (configurazione di un endpoint che il prodotto non espone).

Quindi i sette errori (helper globali spariti) sono il sintomo; la causa e' che il test descrive un'API REST mai implementata. Riallineare solo gli helper (la ricetta di `notify-a`: `TestCase::assertNotifyArray`, `XotBasePest::assertFreshModel`, `XotBasePest::assertTableMissing('notify', ...)`) porta PHPStan a zero ma lascia 8 test che a runtime restituiscono 404. Il test valido sarebbe solo `skip`:

```php
/**
 * Notification API: specifica non implementata.
 *
 * Il corpo originale (8 test) esercita POST /api/notify/send e il CRUD
 * /api/notify/templates. In Notify nessuna rotta e nessun controller li espone
 * (routes/api.php e' un blocco commentato). Quando l'API sara' implementata,
 * ripristinare il corpo da git: `git -C Modules/Notify show 13f2cb04f:tests/Feature/NotificationApiTest.php`.
 *
 * @see Modules/Notify/docs/stories/phpstan-test-wave-notify.story.md
 */
it('notification api')->skip('POST /api/notify/send and /api/notify/templates endpoints not implemented');
```

E' la forma gia' usata da `notify-b` per `ThemeManagementBusinessLogicTest.php` (scala delle decisioni, punto 3). Non l'ho applicata: vedi sotto.

## File saltati per gate

- `tests/Feature/NotificationApiTest.php`. `check.sh` stampa LOCKED: `NotificationApiTest.php.lock` e' tracciato in git (commit `80039556b`, 2026-10-16), contenuto `LOCKED at 2026-10-15T13:35:33`, task e agente `unknown`; il suo mtime di oggi (09:07:20) e' quello del pull, uguale a quello degli altri tre `.lock` tracciati. Per il criterio dei 60 minuti e' stantio, ma il gate dice SKIP. In piu' alle 09:50 un'altra sessione, senza lock, ha applicato la ricetta di `notify-a` al file (mtime 09:50:10, 09:50:34 e 09:51:04 nel corso della stessa misura): il file era caldo. Non l'ho toccato.
- I quattro `tests/Unit/Models/{Notification,Contact,MailTemplate,NotificationTemplate}Test.php`: lock `notify-a` vivo alle 09:44 (scritti quel minuto), quindi SKIP; rilasciato poi. Non li ho modificati: il lavoro era quello di `notify-a` e andava solo ri-misurato.

## Cosa ho corretto

Nessun file di codice. Il baseline era vecchio: dei 128 errori, 121 sono stati chiusi da `notify-a` mentre leggevo i file e i 7 restanti erano in modifica da un'altra sessione. Il valore della lane e' la causa del residuo (specifica fantasma), non un editor in piu' sullo stesso file.

## `Services\NotificationManager`: 7 errori del run completo, non di questa lane

Alle 10:04 il coordinatore ha riportato 7 errori nuovi in `app/Services/NotificationManager.php` (produzione Notify a 0 nel baseline). Annotazione dei fatti, senza cambiare comportamento.

**Autore dell'edit.** Non e' di questa lane: non ho mai aperto il file in scrittura. Alle 10:04:14 `SmsService.php` e `MailEngines/MailtrapEngine.php` hanno preso `use QueueableAction` + `execute()` (stesso schema descritto nel nuovo, non tracciato, `docs/queueable-actions-conversion.md`, mtime 10:04:42), e alle 10:04:22 e' toccato anche `NotificationManager.php`. Alle 10:06:19 lo stesso comando ha cancellato dal working tree `app/Services/NotificationManager.php` e `tests/Unit/Services/NotificationManagerTest.php` (stessi mtime di directory a 10:06:19.96). `bashscripts/lock/check.sh` dava FREE: nessun lock. Al momento dell'annotazione `git status` mostra i due file come ` D`. Con il file assente, i 7 errori non hanno piu' un file in cui stare; la causa vera e' sotto.

**Scopo ricostruito (`git log --follow`, lettura di `Actions\NotificationManager`, `SendNotificationAction`).**

- Il Service nasce il 2026-06-06 (`82ce6087f`, 166 righe) come copia quasi byte per byte di `Actions\NotificationManager` (`b5ef3af7b`, 2026-05-27). Doveva restare l'entry point "gestore di notifiche": inviare una notifica da template (`send`), a piu' destinatari (`sendMultiple`), cercare template per codice, categoria e canale, dare statistiche.
- La story `4.29.notify-services-to-actions.story.md` (2026-10-08, `3d83897ad`) lo aveva gia' cancellato come duplicato e ripuntato i chiamanti a `Actions\NotificationManager`, con il test `tests/Unit/Services/NotificationManagerTest.php`. Il pull del 2026-10-20 (`f066459c9`) li ha riportati nel working tree. La cancellazione delle 10:06 ripristina quella decisione.

**Le quattro domande del coordinatore.**

(a) `Actions\NotificationManager::send()` esiste (`app/Actions/NotificationManager.php`, riga 25) e ritorna `?Notification`. Il suo docblock dice "Entry point per QueueableAction, delega a send()" ma la classe non ha `execute()` ne' `queueMethod()`: con `QueueableAction` il default di `queueMethod()` e' `execute`, quindi `->onQueue()->send(...)` funzionerebbe solo come chiamata diretta, non come job in coda. Il Service HEAD non cita nessuna Action nel docblock; non posso verificare la versione delle 10:04 perche' il file non esiste piu'.

(b) Nel Service a HEAD `send()` ritorna sempre `[]` (il tipo dichiarato e' `array`, il valore non e' mai quello del risultato) e chiama `SendNotificationAction::execute()`, che non esiste: l'Action definisce solo `handle()`. A runtime sarebbe stata `BadMethodCallException` alla prima `send()` riuscita. `notify-a` l'aveva corretto in `handle()` (vedi la sua story), poi il file e' stato cancellato. `Actions\NotificationManager::send()` fa gia' la cosa giusta: `handle()` e `?Notification`.

(c) `getTemplateStats()` e `getRecipientStats()` ritornano zeri costanti con il corpo vero commentato, sia nel Service sia nell'Action. Le costanti `NotificationLog::STATUS_*` del commento non esistono piu'; nell'Action sono state riscritte come `NotificationLogStatusEnum::*->value`. Non implementare finche' `notification_logs` non ha la migration attiva (decisione aperta di `notify-b`, punto 2).

(d) Chiamanti di `Modules\Notify\Services\NotificationManager` in tutti i moduli e temi (`rg` su `Modules`, `Themes`, `app`, `routes`, `config`, php, senza `vendor` ne' `node_modules`): nessuno. Riferimenti non eseguibili: `bashscripts/tools/prompts/modules/notify.txt:145` (esempio testuale con un binding `notify.manager` che nessun provider registra; `rg "notify\.manager"` in `Modules` e `Themes` e' vuoto) e `laravel/coverage.xml`. Chiamanti di `Actions\NotificationManager`: solo test del modulo (`tests/Unit/Actions/NotificationManagerTest.php`, `tests/Unit/NotifyCoverage100RemainingTest.php`, `tests/Unit/NotifyZeroActionsCoverageTest.php`).

**Per la conversione a QueueableAction (epic del coordinatore).** `Actions\NotificationManager` e `SendNotificationAction` sono gia' `QueueableAction`, senza `execute()`. Va deciso quale delle due diventa l'entry point (regola di progetto: `execute()`) e rinominare `handle()`/`send()`, oppure sovrascrivere `queueMethod()`. Non e' un lavoro da fare in questa lane.

## Verifica

Vedi "Esito" in fondo: i conteggi e l'exit code sono quelli dei run `phpstan analyse` mirato e `phpstan analyse Modules/Notify` del 2026-10-20.

## Decisioni aperte

1. `NotificationApiTest`: neutralizzare con `skip` (consigliato, forma sopra) oppure implementare l'API REST dei template (rotte in `routes/api.php`, controller, validazione, middleware). Finche' il test resta con il corpo, e' PHPStan-verde ma rosso a runtime.
2. I quattro `.lock` tracciati in git (`NotificationApiTest`, `PushNotificationDataTest`, `SendPushNotificationActionTest`, `SendSmsActionTest`) vanno rimossi dal repo e aggiunti a `.gitignore`: bloccano il gate per sempre. Stessa decisione gia' aperta da `notify-a` (punto 7).
3. `docs/notify-phpstan-push-sms-tests.story.md` dichiara `NotificationApiTest.php` "API REST dei template" a zero errori con helper globali: era vero il 2026-10-15, ma l'API non esiste e gli helper non sono piu' globali. Non l'ho riscritta (story chiusa, cronologia); questa story la corregge.
4. Le docs di Notify restano disordinate (1.551 file `.md` nella radice di `docs/`): l'indice `00-INDEX.md` lo misura e lo documenta. Un riordino di massa va deciso e sequenziato con tutte le sessioni che scrivono in `docs/`; non l'ho fatto qui per non rompere link e non collidere con `notify-a`.

## Esito

- Run mirato (2026-10-20, exit 0, output vuoto) su 14 percorsi: `app/Services`, `app/Actions/NotificationManager.php`, `app/Actions/SendNotificationAction.php`, i tre test che usano `Actions\NotificationManager`, i 4 test di modello e `tests/Feature/NotificationApiTest.php`.
- Run finale `cd laravel && ./vendor/bin/phpstan analyse Modules/Notify --memory-limit=2G --no-progress --error-format=raw` (12:22 UTC, mtime di `NotificationApiTest.php` 09:51:04): **exit 0, 0 righe di errore**. Exit code scritto su file, non dedotto dal wrapper.
- Ripetuto dopo il cambio di working tree (merge in corso), in coda su `phpstan-gate.lock` con `flock`: un primo tentativo e' finito con exit 144 del wrapper, output vuoto e nessun `.exit` (segnale, non una misura, non contato); il secondo tentativo, unico, ha dato **exit 0** e come unica riga di output la nota `Using configuration file .../phpstan.neon`, zero errori.
- Dei 128 errori del baseline, 0 sono stati chiusi da edit di questa lane: 121 da `notify-a` e `notify-b` (helper in `tests/TestCase.php`, `refresh()`, `Safe\json_encode`, `getCasts()`, `firstOrFail()`), 7 da un'altra sessione sul file `NotificationApiTest.php` (helper statici `TestCase` e `XotBasePest`). I 7 errori di `Services\NotificationManager` sono spariti perche' un'altra sessione ha cancellato il file (ripristina la decisione di 4.29).
- Dopo il run, `git status` del modulo mostra `app/Services/SmsService.php` e `app/Services/MailEngines/MailtrapEngine.php` come `DU` (cancellati da noi, non risolti): un merge e' in corso nel repo del modulo. Non e' una causa PHPStan, ma va chiuso da chi lo ha avviato prima di rimisurare.
- Lane `notify`: nessun file di codice modificato da me. Toccati solo `docs/stories/phpstan-test-wave-notify.story.md` (nuovo) e `docs/00-INDEX.md` (un link; lock preso e rilasciato). Lock residui miei: nessuno.

## Aperto per l'utente

1. `NotificationApiTest.php` testa `/api/notify/send` e `/api/notify/templates`, che non esistono: ora PHPStan-verde ma rosso a runtime. Neutralizzare con `skip` o implementare l'API.
2. Chiusura del merge in corso su `SmsService` e `MailtrapEngine` e conversione dei `*Service` in QueueableAction (epic del coordinatore, ordine dell'utente del 2026-10-20). Chiamanti di `Services\NotificationManager`: nessuno in `Modules`, `Themes`, `app`, `routes`, `config`.
3. `Actions\NotificationManager` e `SendNotificationAction` sono `QueueableAction` senza `execute()`: in coda non girano finche' non si sceglie `execute()` o `queueMethod()`.
4. I quattro `.lock` che erano tracciati in git non sono piu' su disco ne' in `git status` (12:26 UTC): verificare che il merge in corso li abbia tolti dall'indice, e aggiungere `*.lock` al `.gitignore` del modulo.
