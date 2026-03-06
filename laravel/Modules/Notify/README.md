# Notify Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Actions 35](https://img.shields.io/badge/Actions-35-purple.svg)](#azioni)
[![Channels 5](https://img.shields.io/badge/Channels-5-orange.svg)](#canali)

> **Hub di comunicazione multi-canale**: Email, SMS, WhatsApp, Telegram e notifiche database. Template da DB con Spatie, allegati binari, temi personalizzabili, 35 azioni per 12+ provider.

---

## Cosa fa

Il modulo Notify centralizza tutte le comunicazioni dell'applicazione: dalla semplice email alla notifica WhatsApp, dal template HTML personalizzabile all'SMS di massa. I template vivono nel database (Spatie Mail Templates), i temi sono gestibili da Filament, e ogni canale ha provider multipli con fallback.

```php
// Invio email da template database
app(SendEmailAction::class)->execute(
    to: 'user@example.com',
    template: 'survey-invitation',
    data: ['survey_name' => 'Customer Satisfaction', 'link' => $url],
);

// Invio SMS multi-provider
app(SendSmsAction::class)->execute(
    to: '+39123456789',
    message: 'Il tuo survey e pronto!',
    provider: 'twilio', // o plivo, nexmo, agiletelecom...
);

// Notifica WhatsApp
app(SendWhatsAppAction::class)->execute(
    to: '+39123456789',
    template: 'event-reminder',
);
```

---

## Canali e Provider

### 5 Canali di comunicazione

| Canale | Provider disponibili |
|--------|---------------------|
| **Email** | SMTP, SES, Mailgun (+ Spatie Mail Templates) |
| **SMS** | Twilio, Plivo, Nexmo, Agiletelecom, Netfun, Gammu, SmsFactor |
| **WhatsApp** | Twilio, Vonage, Facebook Business, 360dialog |
| **Telegram** | Official Bot API, Nutgram, Botman |
| **Database** | Laravel Notifications (persistente) |

### Architettura

```
Evento trigger (survey creato, evento registrato, etc.)
    |
    v
35 Queueable Actions (selezione canale + provider)
    |
    +-- Email: Template DB → Tema → SMTP/SES
    +-- SMS: Normalizzazione numero → Provider → Invio
    +-- WhatsApp: Template → Provider → Invio
    +-- Telegram: Bot API → Chat/Group → Messaggio
    +-- Database: Laravel Notification → Persistenza
    |
    v
Log di invio (NotificationLog, MailTemplateLog)
```

---

## Modelli (11)

| Modello | Funzione |
|---------|----------|
| **Notification** | Record notifica con stato e canale |
| **NotificationType** | Tipo notifica (email, sms, whatsapp, telegram) |
| **NotificationTemplate** | Template notifica con variabili |
| **NotificationTemplateVersion** | Versioning template |
| **NotificationLog** | Log invio con esito |
| **MailTemplate** | Template email da database (Spatie) |
| **MailTemplateVersion** | Versioning template email |
| **MailTemplateLog** | Log email inviate |
| **Contact** | Contatto con canali preferiti |
| **NotifyTheme** | Tema grafico per email |
| **NotifyThemeable** | Associazione tema-entita (polymorphic) |

---

## Azioni (35 Queueable Actions)

### Email

| Action | Funzione |
|--------|----------|
| **SendEmailAction** | Invio email da template DB |
| **SendBulkEmailAction** | Invio massivo con queue |
| **RenderMailTemplateAction** | Rendering template con dati |

### SMS (7 provider)

| Action | Provider |
|--------|----------|
| **SendTwilioSmsAction** | Twilio |
| **SendPlivoSmsAction** | Plivo |
| **SendNexmoSmsAction** | Nexmo/Vonage |
| **SendAgiletelecomSmsAction** | Agiletelecom |
| **SendNetfunSmsAction** | Netfun |
| **SendGammuSmsAction** | Gammu (gateway locale) |
| **SendSmsFactorAction** | SmsFactor |

### WhatsApp (4 provider)

| Action | Provider |
|--------|----------|
| **SendTwilioWhatsAppAction** | Twilio |
| **SendVonageWhatsAppAction** | Vonage |
| **SendFacebookWhatsAppAction** | Facebook Business |
| **Send360dialogWhatsAppAction** | 360dialog |

### Telegram (3 provider)

| Action | Provider |
|--------|----------|
| **SendTelegramOfficialAction** | Bot API ufficiale |
| **SendNutgramAction** | Nutgram |
| **SendBotmanAction** | Botman |

### Utility

| Action | Funzione |
|--------|----------|
| **NormalizePhoneAction** | Normalizzazione numeri telefono |
| **FormatMessageAction** | Formattazione messaggio per canale |
| **RecordNotificationAction** | Registrazione invio su DB |

---

## Filament Integration (5 Resource)

| Resource | Funzione |
|----------|----------|
| **NotificationResource** | CRUD notifiche |
| **NotificationTemplateResource** | Gestione template notifica |
| **MailTemplateResource** | Gestione template email (Spatie) |
| **NotifyThemeResource** | Gestione temi grafici |
| **ContactResource** | Rubrica contatti |

---

## Template Email da Database

```php
// I template vivono nel DB, editabili da Filament
// Spatie Mail Templates gestisce variabili e rendering

$template = MailTemplate::where('name', 'survey-invitation')->first();
// Subject: "Sei invitato al survey: {{survey_name}}"
// Body: HTML con variabili {{link}}, {{user_name}}, {{deadline}}

// Invio con sostituzione automatica variabili
app(SendEmailAction::class)->execute(
    to: $user->email,
    template: 'survey-invitation',
    data: [
        'survey_name' => $survey->title,
        'user_name' => $user->name,
        'link' => $invitationUrl,
        'deadline' => $survey->deadline->format('d/m/Y'),
    ],
);
```

### Allegati binari

```php
// Genera PDF in memoria e allega senza salvare su disco
app(SendEmailAction::class)->execute(
    to: $user->email,
    template: 'survey-report',
    attachments: [
        ['content' => $pdfBinary, 'name' => 'report.pdf', 'mime' => 'application/pdf'],
    ],
);
```

---

## Integrazione con altri moduli

```
<<<<<<< .merge_file_M18npd
Notify <── healthcare_app    (inviti survey, report PDF via email)
=======
<<<<<<< HEAD
Notify <── ExternalProject    (inviti survey, report PDF via email)
=======
Notify <── ModuloEsempio    (inviti survey, report PDF via email)
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> .merge_file_dhasRq
Notify <── Meetup     (inviti eventi, reminder, conferme)
Notify <── User       (welcome email, reset password)
Notify <── Activity   (notifiche su eventi tracciati)
Notify <── Tenant     (comunicazioni per tenant)
Notify <── Lang       (template multilingua IT/EN/DE)
```

---

## Quick Start

```bash
php artisan module:enable Notify
php artisan migrate

# Crea un template email
php artisan tinker
>>> Modules\Notify\Models\MailTemplate::create([
...     'name' => 'test',
...     'subject' => 'Test: {{title}}',
...     'html_template' => '<h1>{{title}}</h1><p>{{body}}</p>',
... ]);
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 11 |
| **Azioni** | 35 |
| **Canali** | 5 (Email, SMS, WhatsApp, Telegram, DB) |
| **Provider SMS** | 7 |
| **Provider WhatsApp** | 4 |
| **Provider Telegram** | 3 |
| **Resource Filament** | 5 |
| **PHPStan Level** | 10 |

---

**Module Type**: Multi-Channel Communication
**Architecture**: Actions-over-Services, template DB-driven, multi-provider
**Quality**: PHPStan Level 10, 35 Queueable Actions

*Ogni messaggio sul canale giusto: email, SMS, WhatsApp e Telegram con template da database e provider intercambiabili.*
