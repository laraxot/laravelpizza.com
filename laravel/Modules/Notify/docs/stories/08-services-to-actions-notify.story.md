---
title: "[STORY] Notify: elimina app/Services, const di NotificationLog in enum, push simulati tracciati"
type: story
status: done
priority: high
module: Notify
created: 2026-10-08
updated: 2026-10-08
tags: [notify, services-to-actions, queueable-action, enum, push, dedup, swarm]
related:
  - ./4.29.notify-services-to-actions.story.md
  - ./2026-10-08-phpstan-notify-push-delivery.story.md
  - ./2026-10-06-phpstan-cleanup-notify.dev.md
  - ../wiki/concepts/services-to-actions-migration.md
  - ../../../../../bmad-output/epic-code-standards-services-mixed-const.md
---

# [STORY] Notify: niente Services

## Richiesta

Epic "niente Services, mixed ultima spiaggia, const in tipi adatti": eliminare del tutto `app/Services` del modulo Notify,
riscrivere sulle Action i test che usano i Service, convertire le `const` di classe, chiudere gli aperti lasciati da
`2026-10-08-phpstan-notify-push-delivery.story.md`. Fase BMAD: Build + Measure.

## Analisi: era la migrazione 4.29, annullata da un merge

La story 4.29 (2026-09) e la wiki `services-to-actions-migration.md` (2026-07-13) avevano gia' deciso e fatto tutto questo.
Il working tree conteneva di nuovo i Service, i file non PHP e i test che li importano (la storia git del modulo riparte da
5 commit del 2026-10-07: `git log --follow` non mostra le cancellazioni). Lo scopo di ogni Service, provato con `rg` su
`laravel/Modules`, `laravel/Themes`, `config`, provider, `composer.json`, `module.json`:

| Era in `app/Services` | Scopo | Chiamanti vivi | Ora |
|---|---|---|---|
| `PushNotificationService` (98 righe, facade con array) | invio push per caso d'uso | solo 2 test | cancellato; i test chiamano `Actions/Push/*` con `PushNotificationData`/`PushCriteriaData` |
| `NotificationManager` | invio per codice template + lookup template | solo test | cancellato; copia esatta di `Actions\NotificationManager` (identica salvo `array_values($channels)`) |
| `SmsService` | dispatch SMS per riflessione verso `Services\SmsEngines\*` (namespace mai popolato) | solo 2 test | cancellato; successore `Actions\SMS\SendSmsAction`, gia' esistente |
| `MailEngines/MailtrapEngine` | `Mail::raw` per prova SMTP (`send()` era `throw 'Removed debug dddx'`) | nessuno | cancellato; successore `Actions\Mail\SendMailtrapMailAction` |
| `MailService.to_action`, `MailEngines/{Duocircle,duocircle}Engine.test` | non PHP, non autoloadabili | nessuno | cancellati; successori `Actions\Mail\{SendMailAction,TryMailAction}` e `Actions\Mail\Engines\Duocircle\*` |
| `.gitkeep` | preservava la cartella | - | cancellato con la cartella |

**MailEngines non e' un Contract/strategy scelto da config.** Nessuna interface, nessun binding in provider/config
(`rg 'MailEngine|Mail.Engines'` su Modules, Themes, config, composer.json: solo la classe stessa e il file `.to_action`).
L'unico dispatch per driver e' per stringa (`Str::studly($driver)`) in `Actions\Mail\SendMailAction`/`TryMailAction`, che
puntano gia' a `Actions\Mail\Engines\{Driver}\Send{Driver}MailAction`. Niente da conservare o spostare.

Altro residuo con riferimento a `Modules\Notify\Services\NotificationService` (classe inesistente): `app/Facades/NotificationFacade`
(accessor `notify.service` mai registrato, zero usi, nessun alias in composer/module.json). Cancellata (gia' archiviata
`.bak` il 2026-07-16 dalla wiki, tornata col merge). L'SMS reale non passa da qui ma da `Factories\SmsActionFactory` + `SmsChannel`.

## Modifiche

**Test riscritti sulle Action**
- `NotifyHighestMissCoverageTest`: il test del Service push diventa `push actions fan out, schedule and guard empty targets`
  (stesse asserzioni su `SendPushToDevice/Devices/Topic/AllUsers/WithTargeting/WithTemplate/SchedulePushNotificationAction`);
  `SmsService validates...` -> `SendSmsAction validates missing engine and accepts local vars`. Nuovi: `simulated apns and
  webpush deliveries are traced in the log`, `push targeting explains why it resolved no tokens`.
- `NotifyGapAttackCoverageTest`: il test a riflessione ("invoca tutti i metodi pubblici in try/catch che inghiotte tutto")
  diventa `Push actions, SendSmsAction e FCM channel` con asserzioni vere.
- `NotifyCoverage100RemainingTest`: import `Actions\NotificationManager`; il ciclo su `getAvailableChannels`/`getChannelConfig`
  (metodi mai esistiti, `method_exists` sempre falso) sostituito da `toThrow(Exception, 'Template not found: ...')`.
- `tests/Unit/Services/NotificationManagerTest` cancellato: ridondante con `tests/Unit/Actions/NotificationManagerTest`
  (stessi casi, verificato).

**Aperti della story precedente**
1. `LogSimulatedPushDeliveryAction` ora ha chiamanti: `SendPushToPlatformAction` (APNs: token + notification + data; Web Push:
   il payload che prima veniva costruito con `json_encode` e scartato) e `SendPushToTopicAction` (APNs/Web Push, nuovo
   helper `simulateTopicDelivery`; il topic e' nel payload perche' l'Action di log abbrevia `target` a 12 caratteri). Gli stub
   riavevano i parametri `$token`/`$notification`/`$data` che l'ultimo "fix PHPStan" aveva tolto.
2. `SendPushWithTargetingAction::getTokensByCriteria`: riletto (mtime 07:12:40, errore ancora li'). I due rami dovevano
   distinguere due motivi dello stesso `[]`, che `execute()` riporta in modo identico ("No tokens found"): criterio con
   piattaforma non supportata (bug del chiamante, `Log::warning`) e store dei device token non collegato (funzione
   mancante, `Log::notice`). Lo diceva gia' la story 2026-10-06 ("`getTokensByCriteria` logga il motivo del `[]`"); il log era
   andato perso, restava solo l'`if`. Restituiscono ancora `[]` entrambi: nessun cambio di esito.
3. Wiki: aggiornato il canonico `services-to-actions-migration.md` (sezione "Stato al 2026-10-08") e corrette le due che
   descrivevano la vecchia orchestrazione (`no-app-support-queueable-actions.md`, `notify-services-support-to-actions.md`).

**Const (7 di classe, tutte in `Models/NotificationLog`)**
`STATUS_{PENDING,PROCESSING,SENT,DELIVERED,FAILED,OPENED,CLICKED}` -> `Enums\NotificationLogStatusEnum` (riuso: era gia' usato da
`NotificationLogForm`, `NotificationLogInfolist` e `CleanupNotificationLogsCommand`). Mancava `PROCESSING`: aggiunto il case
(`'processing'`, i 7 literal nel DB sono invariati, nessuna migrazione) e la voce in `lang/it/notification_log_status_enum.php`
(senza, `getLabel()` ritorna `fix:<chiave>` a video). Usi: `markAsOpened/markAsClicked` (`->value`), `NotificationLogFactory`,
commenti in `Actions\NotificationManager`. Nessun uso fuori da Notify (rg su Modules e Themes). Nessun cast del modello a enum:
`Infolist` e `NotifyModelsTest` leggono `$log->status` come stringa; il cast richiede di toccarli e non e' verificabile senza DB.

**Extra, stesso file**: `NotificationLogFactory` usava colonne che nessuna migration ha (`title`, `content`, `channels`,
`error`) e `data` gia' json-encodato su un cast `array`; riallineata allo schema canonico `2026_09_01_150103` (`channel`,
`status_message`, `data` array). `NotifyModelsTest` passava `content`: ora `status_message`.

## File eliminati (recuperabili da HEAD del repo `Modules/Notify`)

`app/Services/{PushNotificationService,NotificationManager,SmsService}.php`, `app/Services/MailEngines/{MailtrapEngine.php,
DuocircleEngine.test,duocircleengine.test}`, `app/Services/MailService.to_action`, `app/Services/.gitkeep`,
`app/Facades/NotificationFacade.php`, `tests/Unit/Services/NotificationManagerTest.php`. (Nota: la facade ridotta a 98 righe di
`PushNotificationService` esisteva solo nel working tree; HEAD ha la versione da 536 righe.)

## Verifica

```
php -l su tutti i file toccati (Actions/Push, NotificationLog, enum, factory, lang, 5 test)   -> nessun errore
vendor/bin/phpstan analyse Modules/Notify/{app/Actions/Push, app/Actions/NotificationManager.php, app/Actions/SMS/SendSmsAction.php,
  app/Models/NotificationLog.php, app/Enums/NotificationLogStatusEnum.php, database/factories/NotificationLogFactory.php,
  app/Jobs/SendScheduledPushNotification.php, app/Console/Commands/CleanupNotificationLogsCommand.php,
  app/Filament/Resources/NotificationLogResource, i 5 test toccati + Actions/NotificationManagerTest} -c phpstan.neon
  -> [OK] No errors
rg 'Notify\\Services|MailEngines|SmsEngines|STATUS_(SENT|OPENED|...)' (esclusi docs/vendor) -> solo la stringa di dispatch
  `Actions\SMS\SmsEngines` in SendSmsAction (namespace nuovo, mai popolato)
```

Probe senza DB (script nello scratchpad, app bootstrappata, `Http::fake`, `Log` sostituito): 14 controlli `OK` (3 piattaforme
con APNs/Web Push tracciati e payload corretto, topic nel payload dei trace, targeting `unknown` -> solo `warning` e `fcm` ->
solo `notice`, `SendSmsAction` lancia `RuntimeException`, 7 literal dell'enum, cartelle sparite).

Pest mirato (`vendor/bin/pest ... --filter`): `SendSmsAction validates missing engine` 1 passed; i due test nuovi sui log push
falliscono con `Target class [config] does not exist`, cioe' l'harness Pest del modulo non boota l'app (stesso errore su un test
NON toccato, `push actions send across fcm apns and webpush with fakes`, e gia' documentato in 4.29). Limite d'ambiente, non un
verde: le stesse asserzioni sui log sono quelle verificate dal probe.

## Decisioni

- Cancellare invece di tenere un facade di compatibilita': i soli chiamanti erano test, riscritti qui.
- `NotificationManager` non spezzato in questa story: e' la copia pre-esistente `Actions\NotificationManager` (multi-metodo senza
  `execute()`), con `tests/TestCase.php` che la inietta; i suoi `getTemplate*` sono query su `NotificationTemplate` (andrebbero
  come scope del modello, non come Action proxy). Vedi "Aperto".
- Nessun `composer dump-autoload` (macchina condivisa con altri agenti): `vendor/composer/autoload_classmap.php` ha ancora le
  vecchie entry; `class_exists('...\Services\SmsService')` lancia `ErrorException` invece di `false` finche' non si rigenera.
  Nessun codice vivo le referenzia.

## Aperto

1. **Decisione di prodotto (non presa):** transport reale APNs/Web Push oppure `success: false` esplicito invece di simulare
   il successo. Cambia il contratto dei risultati push.
2. **Store dei device token**: la story 2026-10-06 dice "manca uno store", ma esistono due candidati non collegati a
   `getAllActiveTokens()`/`getTokensByCriteria()`: `User` (`IsProfileTrait::getMobileDeviceTokens()` via `DeviceUser`, usato
   da `FirebaseCloudMessagingChannel`) e `Mobile` (tabella `mobile_push_tokens` con `device_token`, `platform`, `is_active`,
   per `waiter_session`). Quale usare per "tutti gli utenti"/targeting e' una scelta architetturale (dipendenza Notify -> User o Mobile).
3. `Actions\NotificationManager`: multi-metodo senza `execute()`, zero chiamanti applicativi (solo test e `tests/TestCase.php`);
   `getTemplateStats`/`getRecipientStats` sono stub che ritornano zeri. Da spezzare o eliminare insieme a `TestCase`.
4. `Actions\SMS\SendSmsAction`: zero chiamanti, lancia sempre `RuntimeException` (cerca `Actions\SMS\SmsEngines\{Driver}Engine`,
   mai esistiti). Il recapito SMS vivo e' `SmsActionFactory`. Candidato alla rimozione col suo test.
5. `Actions\Mail\SendMailAction`: zero chiamanti e `SendMailtrapMailAction` non e' raggiungibile dal suo dispatch (vive in
   `Actions/Mail/`, non in `Actions/Mail/Engines/Mailtrap/`, e prende parametri invece dell'array `$vars`).
6. `Enums\NotificationStatusEnum` (7 valori, zero usi) e' ora un duplicato esatto di `NotificationLogStatusEnum`: unificare.
   Cast del modello `status` a enum (richiede di aggiornare Infolist e `NotifyModelsTest`).
7. Residui non PHP in `app/Models/`: `NotificationLog.php.up`, `notificationlog.php.up`, `NotificationTemplateVersion.php.up`,
   `notificationtemplateversion.php.up` (le prime due contengono ancora le vecchie `const STATUS_*`).
8. L'elenco `['fcm', 'apns', 'webpush']` e' ripetuto in 4 Action `Push/*` (e `detectPlatform`): candidato a enum backed `PushPlatformEnum`.
9. `composer dump-autoload` da lanciare quando la macchina e' libera (classmap ottimizzata con entry di classi cancellate).
