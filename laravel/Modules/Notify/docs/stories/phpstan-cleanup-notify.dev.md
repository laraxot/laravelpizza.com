---
title: "[DEV] PHPStan cleanup Notify"
type: dev-story
status: done
priority: medium
module: Notify
story: ./2026-10-06-phpstan-cleanup-notify.story.md
created: 2026-10-06
updated: 2026-10-06
tags: [notify, phpstan, enum, push, notification-log]
---

# [DEV] PHPStan cleanup Notify

Story: [2026-10-06-phpstan-cleanup-notify.story.md](./2026-10-06-phpstan-cleanup-notify.story.md)

## Technical Plan

1. Ricostruire `NotificationLog` da HEAD (docblock + generics), poi applicare l'enum: cast `status`,
   `markAsOpened/Clicked` con l'enum, scope `withStatus(NotificationLogStatusEnum)`.
2. Allineare i consumatori dello stato: Infolist (Filament deriva label/colore dall'enum cast), factory
   (schema canonico `2026_09_01_150103_create_notification_logs_table`), test modello/enum, lang `processing`.
3. Stub push: un'unica Action `LogSimulatedPushDeliveryAction` invece di 12 copie di `Log::notice`;
   le firme restano (contratto), il payload Web Push non viene piu' scartato.
4. Pagine di test Filament: implementare l'intento (Firebase invia, SMTP precompila) o rimuovere i residui provati morti.
5. Test: sostituire variabili inutilizzate con asserzioni sull'oggetto creato; "has required imports" asserisce gli import veri.

## Files to Modify

Codice (`laravel/Modules/Notify/`):
- `app/Models/NotificationLog.php` (docblock/generics ripristinati, cast enum, no costanti)
- `app/Http/Controllers/NotificationTrackingController.php` (click tracciati in `metadata`, non nel payload `data`)
- `app/Filament/Resources/NotificationLogResource/Schemas/NotificationLogInfolist.php`
- `app/Actions/SendNotificationAction.php` (`NotificationStatusEnum::SENT->value` al posto di `'sent'`)
- `app/Actions/Push/LogSimulatedPushDeliveryAction.php` (nuovo)
- `app/Actions/Push/SendPushWithTargetingAction.php`
- `app/Actions/PushNotificationPlatformDelivery.php`, `app/Support/PushNotificationPlatformDelivery.php`, `app/Services/PushNotificationService.php`
- `app/Filament/Clusters/Test/Pages/{SendFirebasePushNotificationPage,TestSmtpPage,SendSpatieEmailPage,SendTelegramPage,SendWhatsAppPage}.php`
- `app/Actions/NotificationManager.php`, `app/Services/NotificationManager.php` (solo codice commentato: riferimento all'enum)
- `database/factories/NotificationLogFactory.php`, `lang/it/notification_log_status_enum.php`

Test (`tests/`):
- `Unit/NotifyModelsTest.php`, `Unit/Enums/NotificationLogStatusEnumTest.php`, `Unit/Models/{NotificationTemplateVersionTest,MailTemplateTest}.php`
- `Unit/Actions/{WhatsApp/Send{Facebook,Twilio,Vonage,360dialog}WhatsAppActionTest,Telegram/Send{Official,Nutgram,Botman}TelegramActionTest,SMS/FormatSmsMessageActionTest}.php`
- `Feature/NotifyThemeableBusinessLogicTest.php`

## Implementation Steps

- [x] Baseline: 69 errori; al secondo giro 6 `iterableValue` (test con classi anonime) risultavano gia' risolti da docblock aggiunti da altri.
- [x] `NotificationLog`: ripristino docblock/generics da HEAD, cast `status`, scope/mark con enum.
- [x] `NotificationLogStatusEnum`: riuso (aveva gia' `PROCESSING`); label/colore/icona `processing` in `lang/it`.
- [x] Infolist stato: via `formatStateUsing(fn (string $state) ...)` (con il cast lo stato e' l'enum: avrebbe dato TypeError).
- [x] Factory log: colonne dello schema canonico (`channel`, `status_message`, `data` array) al posto di `title/content/channels/error`.
- [x] Controller tracking: legge/scrive `metadata` (commento e variabile dicevano gia' "metadati").
- [x] Stub push: `LogSimulatedPushDeliveryAction`, `topic` nel risultato dei topic APNs/WebPush (allineato alla variante `Actions`), `getTokensByCriteria` logga il motivo del `[]`.
- [x] Pagina Firebase: `CloudMessage` + `Messaging::send`, rimossi import verso classe inesistente (`Notifications\PushNotification`).
- [x] Pagina SMTP: `->default()` da `mail.mailers.smtp`/`mail.from`; password mai precompilata (`password()->revealable()`).
- [x] Pagine Email/Telegram/WhatsApp: rimossi `$attachments` (asset inesistente) e `$user` (il form chiama gia' `getUser()`).
- [x] Test: asserzioni reali; `restore` -> `restoreTemplate` (il test puntava a un metodo inesistente); `method_exists` -> `ReflectionClass::hasMethod`.
- [x] Costanti: nessuna costante di stato rimasta in `app/` (`grep "const "` fuori da `Enums/`); `SendNotificationAction` usa `NotificationStatusEnum`.

## Testing

Pest **non eseguito**: `.env.testing` punta a MySQL (`techplanner_data_test`) con `APP_ENV=local`, mentre `phpunit.xml`
forza sqlite in-memory; `BaseModel` usa la connessione `notify`. Non essendo garantito l'isolamento dai dati, nessun test lanciato.
Da eseguire in ambiente con DB di test dedicato:

```bash
cd laravel && ./vendor/bin/pest Modules/Notify/tests/Unit/NotifyModelsTest.php Modules/Notify/tests/Unit/Enums Modules/Notify/tests/Unit/Models
```

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Notify --memory-limit=-1 --no-progress   # [OK] No errors
cd laravel/Modules/Notify && git status --short . | awk '{print $2}' | grep '\.php$' | xargs -n1 php -l
```

## Lessons Learned

- Un errore `property.notFound` su un modello e' spesso un docblock perso, non un campo mancante: confrontare il file con
  `git show HEAD:<path>` (in `Modules/Notify` il repo e' un git separato: path relativo al modulo) prima di toccare i chiamanti.
- Una variabile "mai letta" e' un indizio: qui indicava invio push mai fatto, default di form mai applicati, asserzioni mancanti.
  Verificare lo storico (`git log -S`) e' stato piu' utile che leggere l'errore.
- Cambiare un cast a enum impone di rivedere i consumatori tipizzati `string` (Filament `formatStateUsing`), le factory e i test:
  `grep` su `->status` / `'status'` prima di chiudere.
- Una factory puo' essere fuori schema da mesi senza che nessuno se ne accorga (`title/content/channels/error` non esistono in
  nessuna migration di `notification_logs`): confrontarla con la migration "owner" quando la si tocca.
- Gli stub "simulati" ritornano `success: true` senza inviare nulla: finche' non c'e' un transport reale, loggare il payload
  evita falsi positivi silenziosi. La decisione (implementare o fallire esplicitamente) spetta all'utente.

## Decisioni aperte (per l'utente)

- APNs e Web Push: implementare il transport reale oppure far fallire (`success: false`) invece di simulare il successo?
- Device token: manca uno store (tabella/modello) -> `getTokensByCriteria()` non puo' risolvere token; dove devono vivere?
- `NotificationStatusEnum` (nuovo, senza UI) e `NotificationLogStatusEnum` hanno gli stessi 7 valori: unificarli?
- `NotificationTrackingController` non ha route registrate (e `wiki/00-index.md` linka due doc inesistenti su di esso).
