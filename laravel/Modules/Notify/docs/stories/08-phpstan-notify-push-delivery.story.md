---
title: "[STORY] PHPStan Notify push delivery: tre copie, un solo scopo"
type: story
status: done
priority: high
module: Notify
created: 2026-10-08
updated: 2026-10-08
tags: [notify, phpstan, push, dedup, swarm, services-to-actions]
related:
  - ./4.29.notify-services-to-actions.story.md
  - ./2026-10-06-phpstan-cleanup-notify.dev.md
  - ../wiki/concepts/services-to-actions-migration.md
---

# [STORY] PHPStan Notify push delivery

## Richiesta

Ordine permanente: azzerare gli errori PHPStan, alzare la qualita', tenere ordinata la documentazione. Perimetro: 30 errori
(`return.type`, `missingType.iterableValue`, `method.unusedParameter`, `argument.type`) in tre file che sembravano copie dello
stesso recapito push:

- `app/Actions/PushNotificationPlatformDelivery.php` (9)
- `app/Support/PushNotificationPlatformDelivery.php` (11)
- `app/Services/PushNotificationService.php` (10)

## Analisi: i 30 errori erano il sintomo di una migrazione annullata

Prima dell'errore, lo scopo. Mappa dei chiamanti (`rg -i` su `laravel/` e `bashscripts/`, config, provider, test, stringhe;
nessuna classmap authoritative in `vendor/composer`):

| Classe | Chiamanti vivi | Verdetto |
|---|---|---|
| `Actions\PushNotificationPlatformDelivery` | nessuno | residuo |
| `Support\PushNotificationPlatformDelivery` | solo `Actions\SendPushNotificationAction` | residuo |
| `Actions\SendPushNotificationAction` | nessuno (nemmeno test) | residuo |
| `Services\PushNotificationService` | solo 2 test (`NotifyHighestMissCoverageTest`, `NotifyGapAttackCoverageTest`) | facade di compatibilita' |
| `Actions\Push\*` (7 Action + `PushNotificationData`/`PushCriteriaData`) | `Jobs\SendScheduledPushNotification`, test | **canonica** |

La decisione era gia' presa e documentata: `docs/wiki/concepts/services-to-actions-migration.md` (2026-07-13) dice che il
Service, `SendPushNotificationAction` e `PushNotificationPlatformDelivery` "sono stati rimossi perche' non referenziati altrove
e superati dallo split in `Actions/Push/`"; la story 4.29 mappa ogni metodo pubblico del Service su una Action `Push/*`.
Nel working tree erano tornati tutti (e con loro `app/Services/{SmsService,NotificationManager,MailEngines}` e i test che li
importano): la storia git del modulo riparte da 5 commit (2026-10-07), quindi `git log --follow` non mostra la cancellazione.
Le tre classi erano copie 1:1 della stessa logica FCM/APNs/WebPush, ciascuna con la stessa famiglia di errori: correggerle
tre volte avrebbe cristallizzato un duplicato gia' dichiarato rimosso.

Stato iniziale del working tree: modifiche non committate delle 07:14 identiche nelle tre copie (parametri `$token`,
`$notification`, `$data` tolti dagli stub APNs/WebPush, e un `if ($criteria !== []) { return []; } return [];` tautologico in
`getTokensByCriteria`). Erano il vecchio riflesso "togli il parametro per zittire PHPStan"; non sono state riprese.

## Scopo scoperto: `$topic` e gli stub APNs/WebPush

`$topic` (e `$token`, `$notification`) "inutilizzati" non erano parametri vestigiali ma logica persa:

- APNs non ha topic pub/sub (l'header `apns-topic` e' il bundle id) e Web Push non ha topic: solo FCM ha `/topics/{name}`.
  Per APNs/WebPush un invio "a topic" richiede una tabella di sottoscrizioni topic -> token che non esiste (neppure per i token:
  `getAllActiveTokens()`/`getTokensByCriteria()` ritornano `[]`). Gli stub sono quindi "simulati" per decisione 2026-09-29.
- Il comportamento corretto dello stub, deciso il 2026-10-06 (`2026-10-06-phpstan-cleanup-notify.dev.md`): ritornare il `topic`
  nel risultato e loggare la consegna simulata con `Actions\Push\LogSimulatedPushDeliveryAction`, per non avere falsi positivi
  silenziosi. Nella canonica `SendPushToTopicAction` il `topic` nel risultato c'e' gia'. **Il log no**: la Action di log non ha
  nessun chiamante (la chiamata viveva nelle copie ora rimosse). Vedi "Aperto".
- La decisione di fondo (implementare il transport APNs/WebPush o far fallire con `success: false`) resta dell'utente.

## Modifiche

- Cancellati (zero riferimenti provati, procedura `42-delete-obsolete-files-safely`):
  `app/Actions/PushNotificationPlatformDelivery.php`, `app/Support/PushNotificationPlatformDelivery.php` (+ cartella `app/Support/`
  rimasta vuota; il modulo documenta "no `app/Support`"), `app/Actions/SendPushNotificationAction.php` (fuori perimetro: unico
  riferimento delle due delivery, a sua volta senza chiamanti e documentata come rimossa; recuperabile da HEAD).
- `app/Services/PushNotificationService.php`: da 532 a 98 righe. Nessuna logica propria: converte gli array in
  `PushNotificationData`/`PushCriteriaData` e delega alle Action `Push/*`, firme pubbliche invariate (le usano ancora due test).
  Niente piu' `QueueableAction` senza `execute()`, niente `$config` mai usato per APNs/WebPush, niente `@deprecated` (il progetto ha
  `phpstan-deprecation-rules`: i due test chiamanti diventerebbero errori).
- Le shape degli array sono tipizzate una volta sola, dove vivono: `Actions\Push\*` (`array{success: bool, ...}`) e i due Data.

## Verifica

```
php -l Modules/Notify/app/Services/PushNotificationService.php          -> No syntax errors detected
vendor/bin/phpstan analyse Modules/Notify/app/Services/PushNotificationService.php -c phpstan.neon   -> [OK] No errors
vendor/bin/phpstan analyse NotifyHighestMissCoverageTest NotifyGapAttackCoverageTest Modules/Notify/app/Actions/Push -c phpstan.neon -> [OK] No errors
```

Probe senza DB (`Http::fake`, `Queue::fake`, cache `array`, app bootstrappata da script): `sendToDevice`, `sendToDevices`,
`sendToTopic` (con `topic` in FCM/APNs/WebPush), `sendToAll`, `sendWithTargeting`, `sendWithTemplate`, `scheduleNotification`
(payload ricostruibile da `PushNotificationData::from`, come fa il Job) -> 10 controlli `OK`. Pest non lanciato: il MySQL di
test non e' raggiungibile da questo host.

## Decisioni

- Delegare il Service invece di cancellarlo: il brief chiedeva di mantenere la firma pubblica per i chiamanti vivi, e i due test
  sono fuori perimetro. Il passo successivo e' gia' descritto in 4.29 (vedi "Aperto").
- Cancellare `SendPushNotificationAction` (fuori perimetro): lasciarla avrebbe prodotto `class.notFound` su un file che nessuno usa.

## Aperto

1. Cancellare `app/Services/PushNotificationService.php` e riscrivere i due test sulle Action `Push/*`, come da 4.29
   (`NotifyHighestMissCoverageTest` ha gia' il test equivalente "push actions send across fcm apns and webpush with fakes";
   `NotifyGapAttackCoverageTest` va riscritto). Stessa cosa per `app/Services/{SmsService,NotificationManager,MailEngines}`,
   anch'essi tornati dopo 4.29: audit generale del modulo.
2. Collegare `Actions\Push\LogSimulatedPushDeliveryAction` agli stub di `SendPushToPlatformAction` (APNs/WebPush) e
   `SendPushToTopicAction` (APNs/WebPush). Oggi la Action di log non ha chiamanti: gli stub ritornano `success: true` in silenzio.
3. `Actions\Push\SendPushWithTargetingAction::getTokensByCriteria()` ha (modifica non committata delle 07:12) un `if` con due rami
   identici (`return []`): o il controllo sulla piattaforma produce un esito diverso, o va tolto.
4. Doc stale da aggiornare nell'audit: `docs/wiki/concepts/{no-app-support-queueable-actions,notify-services-support-to-actions}.md`
   descrivono ancora `SendPushNotificationAction` -> `PushNotificationPlatformDelivery` come orchestrazione corrente.

**Seguito (2026-10-08):** gli aperti 1-4 sono chiusi in [2026-10-08-services-to-actions-notify.story.md](./2026-10-08-services-to-actions-notify.story.md) (Service e test rimossi, log dei push simulati collegato, rami di `getTokensByCriteria` distinti, wiki aggiornata).
