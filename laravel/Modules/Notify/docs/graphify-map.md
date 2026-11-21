---
qmd: "graphify map"
issues: []
discussions: []
title: "Notify Module — Mappa Graphify"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
---

# Notify Module — Mappa Graphify

**Versione:** 1.0.0 | **Modulo:** Notify | **Data:** 2026-08-02

---

## 📌 Cosa fa il modulo Notify

Il modulo **Notify** gestisce:
- **Multi-channel notifications:** email, SMS, push, WhatsApp, Telegram (6+ provider)
- **Template system:** modelli di notifica con variabili, compilazione dinamica, versioning
- **Notification logging:** registro completo di invii, fallimenti, stato consegna
- **Contact management:** gestione contatti con validazione canali (email, phone, etc.)
- **Mail template engine:** template HTML con supporto temi personalizzati
- **Bulk notifications:** invio massiccio a più destinatari
- **Scheduled notifications:** push notification programmata
- **Theme support:** temi customizzabili per email con allegati PDF

---

## 🏗️ Architettura Essenziale

### Entry Points

| Tipo | Classe | Path |
|------|--------|------|
| **Model** | `Notification` | `app/Models/Notification.php` |
| **Model** | `NotificationTemplate` | `app/Models/NotificationTemplate.php` |
| **Model** | `Contact` | `app/Models/Contact.php` |
| **Model** | `MailTemplate` | `app/Models/MailTemplate.php` |
| **Action** | `SendNotificationAction` | `app/Actions/SendNotificationAction.php` |
| **Action** | `SendNotificationToRecipientAction` | `app/Actions/SendNotificationToRecipientAction.php` |
| **Action** | `SendRecordNotificationAction` | `app/Actions/SendRecordNotificationAction.php` |
| **Action** | `SendMailAction` | `app/Actions/Mail/SendMailAction.php` |
| **Action** | `SendPushToDeviceAction` | `app/Actions/Push/SendPushToDeviceAction.php` |
| **Action** | `SendPushWithTemplateAction` | `app/Actions/Push/SendPushWithTemplateAction.php` |
| **Action** | `FormatSmsMessageAction` | `app/Actions/SMS/FormatSmsMessageAction.php` |
| **Job** | `SendNotificationJob` | `app/Jobs/SendNotificationJob.php` |
| **Job** | `SendScheduledPushNotification` | `app/Jobs/SendScheduledPushNotification.php` |
| **Filament** | `NotificationResource` | `app/Filament/Resources/NotificationResource.php` |
| **Filament** | `NotificationTemplateResource` | `app/Filament/Resources/NotificationTemplateResource.php` |
| **Filament** | `MailTemplateResource` | `app/Filament/Resources/MailTemplateResource.php` |
| **Filament** | `ContactResource` | `app/Filament/Resources/ContactResource.php` |
| **Notification** | `GenericNotification` | `app/Notifications/GenericNotification.php` |

### Canali (Channels)

**Email Providers:**
- `SmtpMailSendAction` — standard SMTP
- `SendMailtrapMailAction` — Mailtrap testing
- `SendDuocircleMailAction` — Duocircle provider
- Mail layout resolver

**SMS Providers:**
- `SendTwilioSMSAction` — Twilio
- `SendNexmoSMSAction` — Nexmo/Vonage
- `SendNetfunSMSAction` — Netfun
- `SendPlivoSMSAction` — Plivo
- `SendAgiletelecomSMSAction` — Agiletelecom
- `FormatSmsMessageAction` — validazione e troncamento

**Push Notifications:**
- `SendPushToDeviceAction` — singolo dispositivo
- `SendPushToDevicesAction` — multipli dispositivi
- `SendPushToPlatformAction` — per piattaforma (iOS/Android)
- `SendPushToTopicAction` — per topic Firebase
- `SendPushWithTemplateAction` — con template predefinito
- `SendPushToAllUsersAction` — broadcast globale
- `SchedulePushNotificationAction` — invio programmato

**WhatsApp Providers:**
- `SendTwilioWhatsAppAction` — Twilio
- `Send360dialogWhatsAppAction` — 360dialog
- `SendFacebookWhatsAppAction` — Facebook Business
- `SendVonageWhatsAppAction` — Vonage

**Telegram Providers:**
- `SendOfficialTelegramAction` — Bot Telegram ufficiale
- `SendBotmanTelegramAction` — Botman integration
- `SendNutgramTelegramAction` — Nutgram framework

### Dependencies (Incoming)

```
IndennitaResponsabilita → Notify (invio mail per documenti)
Pdnd → Notify (notifiche PDND e proxy)
Progressioni → Notify (mail per progressioni)
Ptv → Notify (notifiche per schede e procedure)
User → Notify (registrazione e recupero password)
Xot → Notify (base models, core infrastructure)
```

### Dependencies (Outgoing)

```
Notify → Xot (BaseModel, ProfileContract, core traits)
Notify → Laravel\Notifications (NotificationFacade, Mailable)
Notify → Laravel\Mail (Mail service)
Notify → Laravel\Queue (QueueableAction, jobs async)
Notify → Spatie\QueueableAction (async action handling)
Notify → Spatie\LaravelData (data objects)
Notify → Filament (admin resources, forms, tables)
Notify → Third-party SMS/Email/Push APIs (Twilio, Nexmo, Mailtrap, etc.)
```

---

## 🔗 Relazioni Dati (Schema Logico)

### Tabelle Principali

```
notifications
  ├── id (PK)
  ├── type (notifica tipo: generic, appointment, alert)
  ├── message
  ├── subject
  ├── notifiable_type (polimorfic)
  ├── notifiable_id (polimorfic)
  ├── user_id (FK → users)
  ├── subject_type (optional polimorfic)
  ├── subject_id (optional polimorfic)
  ├── channels (array: mail, sms, push, database)
  ├── status (pending, sent, failed, delivered)
  ├── data (JSON: template_code, subject, body_html, body_text, payload)
  ├── read_at
  ├── sent_at
  ├── timestamps (created_at, updated_at, deleted_at)
  └── audit (created_by, updated_by, deleted_by, tenant_id)

notification_templates
  ├── id (PK)
  ├── code (unique: registration_welcome, password_reset, etc.)
  ├── name
  ├── type (generic, appointment, alert)
  ├── subject (template con {{variables}})
  ├── body_html
  ├── body_text
  ├── channels (array: mail, sms, push, telegram, whatsapp)
  ├── is_active
  ├── conditions (JSON: regole per shouldSend())
  ├── variables (array: user_name, appointment_date, etc.)
  └── timestamps + versioning

notification_template_versions
  ├── id (PK)
  ├── notification_template_id (FK)
  ├── version_number
  ├── subject
  ├── body_html, body_text
  ├── created_at
  └── created_by

contacts
  ├── id (PK)
  ├── type (email, phone, whatsapp, telegram)
  ├── value (email@example.com or +1234567890)
  ├── contactable_type (polimorfic)
  ├── contactable_id (polimorfic)
  ├── is_primary
  ├── is_verified
  ├── verified_at
  └── timestamps

mail_templates
  ├── id (PK)
  ├── name
  ├── html_layout_path
  ├── variables (array)
  ├── is_active
  └── timestamps + audit

mail_template_logs
  ├── id (PK)
  ├── mail_template_id (FK)
  ├── recipient_email
  ├── subject_sent
  ├── body_sent
  ├── status (sent, bounced, opened, clicked)
  ├── sent_at
  ├── delivered_at
  └── metadata (JSON)

notify_themes
  ├── id (PK)
  ├── name (theme name)
  ├── description
  ├── config (JSON: colors, fonts, etc.)
  ├── is_active
  └── timestamps

notification_logs
  ├── id (PK)
  ├── notification_id (FK)
  ├── channel (mail, sms, push, telegram, whatsapp)
  ├── status (queued, sent, failed, delivered)
  ├── error_message
  ├── provider_id (provider response ID)
  └── timestamps
```

### Relazioni

```
Notification ──1:N──> NotificationLog (audit trail)
           ──*:1──> NotificationTemplate (template usato)
           ──*:1──> User (recipient indirizzato)
           ──*:1──> NotifyTheme (tema HTML)
           ──*:1──> Contact (contatto destinatario)

NotificationTemplate ──1:N──> NotificationTemplateVersion (versioning)
                    ──1:N──> Notification (istanze)

Contact ──*:1──> Notifiable (email, phone, etc.)

MailTemplate ──1:N──> MailTemplateLog (invii)
           ──1:1──> NotifyTheme (tema visuale)

NotifyTheme ──*:N──> Notification (polimorfic themeable)
           ──*:N──> MailTemplate (riferimenti)
```

---

## 🎯 Task Comuni + Graphify

### Task 1: Setup Email Channel e Template

**Domanda Graphify:**
```bash
graphify query "Notify email setup workflow with SmtpMailSendAction and MailTemplateResource"
```

**Workflow:**
1. Configurare `config/mail.php` (SMTP, from address)
2. Creare `NotificationTemplate` via Filament admin
3. Compilare template con `NotificationTemplate::compile($data)`
4. Inviare via `SendNotificationAction` con channel `mail`
5. Loggare invio in `NotificationLog`

**File critici:**
- `config/mail.php`, `config/notify.php`
- `app/Actions/SendNotificationAction.php` (linea 89: mail channel)
- `app/Actions/Mail/SendMailAction.php`
- `app/Models/NotificationTemplate.php` (compile logic)

---

### Task 2: Configurare SMS (Twilio, Nexmo)

**Domanda Graphify:**
```bash
graphify query "Notify SMS provider setup Twilio Nexmo FormatSmsMessageAction"
```

**Workflow:**
1. Aggiungere API key in `.env` (TWILIO_SID, TWILIO_AUTH_TOKEN)
2. Configurare `config/sms.php` con provider attivo
3. Creare template con channel `sms`
4. Validare numero destinatario in `Contact::routeNotificationForSms()`
5. Mandare via `SendNotificationAction` o `SendSmsAction`
6. `FormatSmsMessageAction` tronca messaggi > 160 char

**File critici:**
- `config/sms.php`
- `app/Actions/SMS/SendTwilioSMSAction.php`
- `app/Actions/SMS/FormatSmsMessageAction.php` (linea 191: truncate 320→317)
- `app/Actions/SendNotificationAction.php` (linea 176-199: SMS logic)

---

### Task 3: Push Notifications (Firebase, OneSignal)

**Domanda Graphify:**
```bash
graphify query "Notify push notification Firebase device targeting SendPushToDeviceAction"
```

**Workflow:**
1. Registrare dispositivi in `Contact::push_token`
2. Configurare Firebase/OneSignal in `config/notify.php`
3. Creare push template con variabili (title, body, data)
4. Inviare via:
   - `SendPushToDeviceAction` (singolo)
   - `SendPushToPlatformAction` (iOS/Android)
   - `SendPushToTopicAction` (subscribers)
   - `SchedulePushNotificationAction` (ritardato)
5. Job `SendScheduledPushNotification` processa invii programmati

**File critici:**
- `config/notify.php` (firebase config)
- `app/Actions/Push/SendPushToDeviceAction.php`
- `app/Actions/Push/SendPushToPlatformAction.php`
- `app/Jobs/SendScheduledPushNotification.php`
- `app/Models/Contact.php` (push_token storage)

---

### Task 4: WhatsApp Multi-Provider

**Domanda Graphify:**
```bash
graphify query "Notify WhatsApp Twilio 360dialog Facebook routing SendFacebookWhatsAppAction"
```

**Workflow:**
1. Scegliere provider: Twilio, 360dialog, Facebook, Vonage
2. Configurare credenziali in `config/whatsapp.php`
3. Validare numero WhatsApp nel Contact (formato: +390123456789)
4. Template con media (immagini, documenti)
5. Router seleziona action appropriata based on config
6. Inviare via `Send{Provider}WhatsAppAction`

**File critici:**
- `config/whatsapp.php`
- `app/Actions/WhatsApp/SendTwilioWhatsAppAction.php`
- `app/Actions/WhatsApp/Send360dialogWhatsAppAction.php`
- `app/Actions/WhatsApp/SendFacebookWhatsAppAction.php`
- `app/Models/Contact.php` (whatsapp_number validation)

---

### Task 5: Notification Template Versioning

**Domanda Graphify:**
```bash
graphify query "Notify template versioning NotificationTemplateVersion rollback history"
```

**Workflow:**
1. Creare template via `NotificationTemplateResource`
2. Ogni edit salva automaticamente in `NotificationTemplateVersion`
3. Struttura: v1, v2, v3...
4. Controllare history in Filament tab "Versioni"
5. Rollback a versione precedente mantiene track audit
6. Compilazione usa versione attiva

**File critici:**
- `app/Models/NotificationTemplate.php`
- `app/Models/NotificationTemplateVersion.php`
- `app/Filament/Resources/NotificationTemplateResource.php`
- Migrazioni per tabelle versioning

---

### Task 6: Bulk Notifications & Scheduling

**Domanda Graphify:**
```bash
graphify query "Notify bulk send SendRecordsNotificationAction SendRecordsNotificationBulkAction"
```

**Workflow:**
1. Selezionare multiple records in Filament table
2. Azione bulk: `SendRecordsNotificationBulkAction`
3. Scegliere template e canali
4. Enqueue in queue (background job)
5. Job `SendNotificationJob` processa in batch
6. Log ogni invio in `NotificationLog` con status
7. Admin dashboard mostra delivery metrics

**File critici:**
- `app/Actions/SendRecordsNotificationAction.php`
- `app/Actions/SendRecordNotificationAction.php`
- `app/Filament/Actions/SendRecordsNotificationBulkAction.php`
- `app/Jobs/SendNotificationJob.php`
- Queue config (`.env` → QUEUE_CONNECTION)

---

### Task 7: Contact Validation & Routing

**Domanda Graphify:**
```bash
graphify query "Notify Contact model email phone whatsapp telegram routing validation"
```

**Workflow:**
1. Model `Contact` stores: email, phone, whatsapp, telegram
2. Validare: email format, phone E.164, etc.
3. Flag `is_verified`, `is_primary`
4. Recipient model must implement: `routeNotificationForMail()`, `routeNotificationForSms()`
5. Smart routing: seleziona canale primario verificato
6. Fallback: retry con canale secondario

**File critici:**
- `app/Models/Contact.php`
- `app/Models/Traits/HasContact.php` (polimorfic relation)
- `app/Actions/NormalizePhoneNumberAction.php`
- `app/Actions/SendNotificationAction.php` (linea 104-112: routing)

---

## 📊 Grafo Locale (Query Rapide)

### Scoprire Entità Core

```bash
graphify query "Notify module models actions services"
```

### Tracciare Flusso Principale (Happy Path)

```bash
graphify path --from "SendNotificationAction" --to "NotificationTemplate::compile"
graphify path --from "SendNotificationAction" --to "NotificationLog"
graphify path --from "SendMailAction" --to "MailTemplate"
```

### Trovare Dipendenze Esterne

```bash
graphify query "Notify Twilio Nexmo Mailtrap API integrations"
graphify query "Notify third-party providers SMS push email"
```

### Mappa Canali

```bash
graphify query "Notify channels email sms push whatsapp telegram"
```

### Trovare Tutte le Actions Send*

```bash
graphify query "Notify SendNotificationAction SendMailAction SendPushAction SendSmsAction"
```

---

## 🔗 Integrazioni Esterne

### Email Providers
- **Mailtrap** — testing/staging
- **Duocircle** — enterprise SMTP
- **AWS SES** — scalable mail
- **Mailgun** — transactional email

### SMS Providers
- **Twilio** — SMS + WhatsApp + Voice
- **Nexmo/Vonage** — SMS + OTP
- **Netfun** — SMS locale Italia
- **Plivo** — SMS + Voice
- **Agiletelecom** — SMS Europa
- **Gammu** — SMS gateway locale

### Push Notifications
- **Firebase Cloud Messaging (FCM)** — Android
- **Apple Push Notification (APN)** — iOS
- **OneSignal** — multi-platform orchestration

### WhatsApp
- **Twilio** — managed service
- **360dialog** — WhatsApp Business API
- **Facebook Business** — ufficiale Meta
- **Vonage** — multi-channel

### Telegram
- **Official Bot API** — standard
- **Botman** — framework wrapper
- **Nutgram** — PHP framework moderno

---

## 📋 Test Coverage Map

```bash
graphify query "Notify module test coverage pest phpunit"
```

### Checklist Copertura

- [ ] `app/Actions/SendNotificationAction.php` → test invio multi-canale
- [ ] `app/Actions/Mail/SendMailAction.php` → test SMTP + fallback
- [ ] `app/Actions/Push/SendPushToDeviceAction.php` → test Firebase/OneSignal
- [ ] `app/Actions/SMS/SendTwilioSMSAction.php` → test SMS provider
- [ ] `app/Models/NotificationTemplate.php::compile()` → test template rendering
- [ ] `app/Models/Contact.php` → test validazione email/phone/whatsapp
- [ ] `app/Jobs/SendNotificationJob.php` → test job dispatch
- [ ] `app/Filament/Resources/NotificationTemplateResource.php` → test admin CRUD
- [ ] Bulk action → test `SendRecordsNotificationBulkAction`
- [ ] Scheduled push → test `SendScheduledPushNotification` job

---

## 🚀 Comandi Rapidi

```bash
# Esplora architettura
graphify query "Notify module architecture models actions jobs"

# Dipendenze
graphify query "Notify module dependencies incoming outgoing"

# Canali
graphify query "Notify channels email sms push telegram whatsapp"

# Template system
graphify query "Notify template compilation versioning"

# Admin interface
graphify query "Notify Filament resources ContactResource NotificationResource"

# Test coverage
graphify query "Notify test coverage pest"

# External APIs
graphify query "Notify third-party integrations Twilio Firebase Mailtrap"

# Performance
graphify query "Notify queue jobs async SendNotificationJob"
```

---

## 📚 Riferimenti

- **Graphify Central:** `docs/graphify-integration.md`
- **Module Discipline:** `docs/wiki/rules/module-naming-discipline.md`
- **Notify Config:** `config/notify.php`, `config/mail.php`, `config/sms.php`
- **Laravel Notifications:** https://laravel.com/docs/11/notifications
- **Spatie QueueableAction:** https://github.com/spatie/laravel-queueable-action
- **Filament Admin:** https://filamentphp.com

---

**Responsabile:** @marco76tv | **Last updated:** 2026-08-02
