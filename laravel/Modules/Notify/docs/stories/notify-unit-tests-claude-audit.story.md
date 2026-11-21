---
title: "Notify — Unit Tests for claude-audit 100/100"
type: story
module: Notify
epic: "claude-audit-perfection"
slug: notify-unit-tests-claude-audit-100
status: ready-for-dev
priority: high
created: 2026-09-27
updated: 2026-09-27
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/XXXX"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/XXXX"
related:
  - "docs/stories/geo-unit-tests-claude-audit-100.story.md"
  - "docs/stories/tenant-unit-tests-claude-audit-100.story.md"
  - "../../../docs/wiki/guidelines/claude-audit-static-free-tier.md"
---

# Notify — Unit Tests for claude-audit 100/100

## Fase BMAD

Build + Measure. Questa story fa parte del batch per portare i moduli Geo, Notify, Tenant a 100/100 claude-audit.

## Problema

Il modulo Notify ha score claude-audit 78-79/100 (Grade B). Il finding principale è "No tests found" nella struttura `laravel/tests/Unit/Modules/Notify/` e `laravel/tests/Feature/Modules/Notify/`. I test esistono in `Modules/Notify/tests/` ma non sono rilevati da claude-audit.

## Obiettivo

Creare unit test nella struttura standard del progetto (`laravel/tests/Unit/Modules/Notify/`) per la business logic critica del modulo Notify, raggiungendo 100/100 claude-audit.

## Azioni

### 1. Test per Actions critiche (Core Notification Flow)

Creare test per le seguenti Actions in `laravel/tests/Unit/Modules/Notify/Actions/`:

- **SendNotificationActionTest.php** - Invio notifiche multi-canale (core)
- **SendNotificationToRecipientActionTest.php** - Invio a singolo destinatario
- **BuildMailMessageActionTest.php** - Costruzione messaggio email
- **SendMailActionTest.php** - Invio email (con engine Duocircle/Mailtrap)
- **SendRecordNotificationActionTest.php** - Notifiche record database
- **SendAppointmentNotificationActionTest.php** - Notifiche appuntamenti

### 2. Test per SMS Actions

Creare test in `laravel/tests/Unit/Modules/Notify/Actions/SMS/`:

- **SendSmsActionTest.php** - Invio SMS generico
- **NormalizePhoneNumberActionTest.php** - Normalizzazione numeri
- **FormatSmsMessageActionTest.php** - Formattazione messaggio
- **SendTwilioSMSActionTest.php** - Provider Twilio
- **SendPlivoSMSActionTest.php** - Provider Plivo
- **SendNexmoSMSActionTest.php** - Provider Vonage/Nexmo
- **SendAgiletelecomSMSActionTest.php** - Provider Agiletelecom v1/v2
- **SendNetfunSMSActionTest.php** - Provider Netfun
- **SendSmsFactorSMSActionTest.php** - Provider SmsFactor
- **SendGammuSMSActionTest.php** - Provider Gammu

### 3. Test per Push Notification Actions

Creare test in `laravel/tests/Unit/Modules/Notify/Actions/Push/`:

- **SendPushNotificationActionTest.php** - Invio push generico
- **SendPushToDeviceActionTest.php** - Invio a singolo device
- **SendPushToDevicesActionTest.php** - Invio multi-device
- **SendPushToTopicActionTest.php** - Invio a topic
- **SendPushToAllUsersActionTest.php** - Broadcast a tutti
- **SendPushWithTemplateActionTest.php** - Con template
- **SendPushWithTargetingActionTest.php** - Con targeting criteri
- **SchedulePushNotificationActionTest.php** - Scheduling
- **SendScheduledPushNotificationActionTest.php** - Esecuzione schedulati

### 4. Test per WhatsApp Actions

Creare test in `laravel/tests/Unit/Modules/Notify/Actions/WhatsApp/`:

- **SendTwilioWhatsAppActionTest.php** - Provider Twilio
- **SendVonageWhatsAppActionTest.php** - Provider Vonage

### 5. Test per Telegram Actions

Creare test in `laravel/tests/Unit/Modules/Notify/Actions/Telegram/`:

- **SendOfficialTelegramActionTest.php** - Bot API ufficiale
- **SendBotmanTelegramActionTest.php** - Botman driver
- **SendNutgramTelegramActionTest.php** - Nutgram driver

### 6. Test per Models

Creare test in `laravel/tests/Unit/Modules/Notify/Models/`:

- **NotificationTemplateTest.php** - Template notifiche (compile, channels, shouldSend)
- **NotificationTest.php** - Model notifica (status, sent_at, data)
- **NotificationTypeTest.php** - Tipi notifica (business logic)
- **ContactTest.php** - Contatti (phone, email, preferences)
- **MailTemplateTest.php** - Template email
- **NotifyThemeTest.php** - Temi notifiche

### 7. Test per Data Objects (DTO)

Creare test in `laravel/tests/Unit/Modules/Notify/Datas/`:

- **NotificationDataTest.php** - DTO notifica generica
- **NotificationTemplateDataTest.php** - DTO template
- **SmsDataTest.php** / **SmsMessageDataTest.php** - DTO SMS
- **EmailDataTest.php** / **EmailAttachmentDataTest.php** - DTO Email
- **PushNotificationDataTest.php** - DTO Push
- **WhatsAppDataTest.php** - DTO WhatsApp
- **TelegramDataTest.php** - DTO Telegram
- **RecordNotificationDataTest.php** - DTO notifica record

### 8. Test per Traits

Creare test in `laravel/tests/Unit/Modules/Notify/Traits/`:

- **HasTenantNotificationsTest.php** - Trait tenant-aware notifications
- **HasNotificationTrackingTest.php** - Trait tracking
- **HasNotificationRateLimitingTest.php** - Trait rate limiting

### 9. Feature Tests

Creare test in `laravel/tests/Feature/Modules/Notify/`:

- **NotificationApiTest.php** - Endpoint API per invio notifiche
- **NotificationTemplateWorkflowTest.php** - Workflow CRUD template
- **MultiChannelDeliveryTest.php** - Test delivery multi-canale

## Acceptance Criteria

1. ✅ Tutti i test passano: `./vendor/bin/pest laravel/tests/Unit/Modules/Notify laravel/tests/Feature/Modules/Notify`
2. ✅ PHPStan L10 pulito: `./vendor/bin/phpstan analyse Modules/Notify --memory-limit=-1`
3. ✅ claude-audit score 100/100 per modulo Notify
4. ✅ Test coverage ≥ 80% per Actions e Models critici
5. ✅ Nessun test flaky o dipendente da servizi esterni (usare mock/fake)

## Technical Notes

### Pattern Testing

Seguire il pattern di `laravel/tests/Unit/Modules/Chart/Actions/CreateChartActionTest.php`:
- Usa `uses(TestCase::class, RefreshDatabase::class, WithFaker::class)`
- `beforeEach` per setup action e factory
- `describe` / `it` per organizzazione
- `expect()` per assertions
- Mock servizi esterni (HTTP client, API keys, Firebase, Twilio, etc.)

### Mock Strategy

Per Actions che chiamano servizi esterni:
- **HTTP APIs (Twilio, Plivo, Vonage, Agiletelecom, Netfun, Firebase, etc.)**: `Http::fake()` con fixture JSON
- **Firebase Cloud Messaging**: Mock `FirebaseCloudMessagingChannel`
- **Telegram (Bot API, Botman, Nutgram)**: Mock client HTTP
- **WhatsApp (Twilio, Vonage)**: Mock HTTP responses
- **Email (Duocircle, Mailtrap, SMTP)**: Mock `Mail::fake()` o HTTP fake

### Notification Template Testing

Il `NotificationTemplate` ha logica complessa:
- `compile($data)` → deve restituire subject, body_html, body_text
- `shouldSend($data)` → conditional sending
- `channels` → array canali supportati
- Testare con variabili Blade, conditional, loop

### QueueableAction Testing

Tutte le Actions usano `Spatie\QueueableAction\QueueableAction`:
- Testare `execute()` metodo sincrono
- Testare `onQueue()` / `delay()` per job async
- Verificare che il job venga pushato correttamente

### Dependencies

- Modulo Xot (TestCase base, QueueableAction)
- Modulo User (User factory, Notification routing)
- Laravel Notification facade fake
- Laravel Mail fake
- Laravel HTTP Client testing utilities

## Definition of Done

- [ ] Story creata e commitata
- [ ] Tutti i test Actions Core implementati
- [ ] Tutti i test SMS Actions implementati
- [ ] Tutti i test Push Actions implementati
- [ ] Tutti i test WhatsApp Actions implementati
- [ ] Tutti i test Telegram Actions implementati
- [ ] Tutti i test Models implementati
- [ ] Tutti i test DTO implementati
- [ ] Tutti i test Traits implementati
- [ ] Feature tests implementati
- [ ] Tutti i test passano
- [ ] PHPStan L10 OK
- [ ] claude-audit 100/100 verificato
- [ ] Story aggiornata con risultati

## Story Points Breakdown

- **Core Actions tests (6 actions × 4 test):** 5 punti
- **SMS Actions tests (10 actions × 3 test):** 8 punti
- **Push Actions tests (9 actions × 3 test):** 6 punti
- **WhatsApp Actions tests (2 actions × 3 test):** 2 punti
- **Telegram Actions tests (3 actions × 3 test):** 2 punti
- **Models tests (6 models × 3 test):** 4 punti
- **DTO tests (8 DTOs × 2 test):** 3 punti
- **Traits tests (3 traits × 3 test):** 2 punti
- **Feature tests (3 areas × 3 test):** 2 punti
- **Fix flaky/setup + fixture creation:** 4 punti
- **Verifica finale + docs:** 2 punti
- **Totale:** 38 punti

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5 (kilo-auto/free)

### File List (da creare)

- `laravel/tests/Unit/Modules/Notify/Actions/SendNotificationActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SendNotificationToRecipientActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/BuildMailMessageActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SendMailActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SendRecordNotificationActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SendAppointmentNotificationActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendSmsActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/NormalizePhoneNumberActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/FormatSmsMessageActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendTwilioSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendPlivoSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendNexmoSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendAgiletelecomSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendNetfunSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendSmsFactorSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/SMS/SendGammuSMSActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushNotificationActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushToDeviceActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushToDevicesActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushToTopicActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushToAllUsersActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushWithTemplateActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendPushWithTargetingActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SchedulePushNotificationActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Push/SendScheduledPushNotificationActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/WhatsApp/SendTwilioWhatsAppActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/WhatsApp/SendVonageWhatsAppActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Telegram/SendOfficialTelegramActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Telegram/SendBotmanTelegramActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Actions/Telegram/SendNutgramTelegramActionTest.php`
- `laravel/tests/Unit/Modules/Notify/Models/NotificationTemplateTest.php`
- `laravel/tests/Unit/Modules/Notify/Models/NotificationTest.php`
- `laravel/tests/Unit/Modules/Notify/Models/NotificationTypeTest.php`
- `laravel/tests/Unit/Modules/Notify/Models/ContactTest.php`
- `laravel/tests/Unit/Modules/Notify/Models/MailTemplateTest.php`
- `laravel/tests/Unit/Modules/Notify/Models/NotifyThemeTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/NotificationDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/SmsDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/SmsMessageDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/EmailDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/EmailAttachmentDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/PushNotificationDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/WhatsAppDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/TelegramDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Datas/RecordNotificationDataTest.php`
- `laravel/tests/Unit/Modules/Notify/Traits/HasTenantNotificationsTest.php`
- `laravel/tests/Unit/Modules/Notify/Traits/HasNotificationTrackingTest.php`
- `laravel/tests/Unit/Modules/Notify/Traits/HasNotificationRateLimitingTest.php`
- `laravel/tests/Feature/Modules/Notify/NotificationApiTest.php`
- `laravel/tests/Feature/Modules/Notify/NotificationTemplateWorkflowTest.php`
- `laravel/tests/Feature/Modules/Notify/MultiChannelDeliveryTest.php`
- `laravel/tests/Fixtures/Notify/*.json` (fixture per mock HTTP)

---

*This story was created using BMAD Method v6 - Phase 4 (Implementation Planning)*