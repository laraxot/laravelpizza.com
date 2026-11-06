---
qmd: "notify docs README ownership mappa del codice canali limiti verificati"
issues: []
discussions: []
title: "Notify Module Documentation"
type: documentation
status: active
tags: [module, documentation]
created: 2026-06-05
updated: 2026-10-20
related:
  - ./00-index.md
  - ./stories/docs-ingressi-notify.story.md
  - ./bmad/decision-log.md
  - ./bmad/filament-blueprint.md
---

# Documentation

## Queueable Actions

Notify non usa `app/Jobs/`, `app/Services/` o `app/Servces/`. Le operazioni
asincrone sono Actions con `Spatie\QueueableAction`; la decisione e il contratto
sono documentati in [Queueable Actions](../../Xot/docs/architecture/queueable-actions.md).

I riferimenti a Jobs nei report storici di questa cartella descrivono lo stato
precedente e non sono percorsi validi del codice corrente.

**Scopo:** Notify e' il motore di consegna multi-canale del monorepo: un owner di dominio decide *cosa* e *a chi*, Notify decide *come* (factory/driver, template, log, preferenze) senza duplicare transport in Fixcity o nel tema.

This directory contains documentation for the Notify module.

## Structure

- **architecture.md** - Module architecture and design patterns
- **README.md** - This file

## Guidelines

Documentation should be:
- Clear and concise
- Example-driven
- Updated with code changes
- Use Markdown format (.md)

## Sistemi di Notificazione

- Mail notifications
- Database notifications
- Template management
- Queue integration

## Modelli Principali (verificato 2026-07-24 contro `app/Models/`)

```php
Modules\Notify\Models\MailTemplate
Modules\Notify\Models\MailTemplateVersion
Modules\Notify\Models\MailTemplateLog
Modules\Notify\Models\Notification
Modules\Notify\Models\NotificationLog
Modules\Notify\Models\NotificationType
Modules\Notify\Models\NotificationChannel
Modules\Notify\Models\NotificationTemplate
Modules\Notify\Models\NotificationTemplateVersion
```

## Traits

> **Verificato 2026-07-24**: `Modules\Notify\Models\Traits\HasNotify` **non esiste** (unico trait presente in
> `app/Models/Traits/` è `HasContact.php`). Se questo trait serve, va creato, non documentato come
> già presente.

## Collegamenti

- [Xot Base](../../Xot/docs) - Core framework
- [User Module](../../User/docs) - User management integration

## Risorse

- [PHPStan Config](./phpstan/) - Type checking configuration
- [On-Demand Pattern](./on-demand-pattern.md): Pattern per caricamento efficiente
- [QMD Setup](./qmd-setup.md): Configurazione ricerca locale
- [Performance](./performance-optimization.md): Metriche e best practice
- [Project Structure](./project-structure.md): Directory layout

---

<!-- Merged from readme.md, which collided with this file on case-insensitive filesystems. -->

---
title: "Modulo Notify - Documentazione"
type: index
tags: [notify, docs]
module: Notify
created: 2026-07-20
updated: 2026-07-20
qmd: "notify documentazione readme modulo notify - documentazione index readme frontmatter qmd search"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/56"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/57"
related:
  - README.md
  - wiki/index.md
  - notifications/readme.md
  - integrations/readme.md
  - templates/readme.md
---
# Modulo Notify - Documentazione

## 📚 Overview

Il modulo **Notify** è il sistema centrale per **email, notifiche, SMS e comunicazioni** nel framework Laraxot.  
Supporta template dinamici, allegati binari, multi-canale e integrazione completa con Spatie Laravel Mail Templates.

---

## 🎯 Funzionalità Principali

### 1. **Sistema Email con Template Database**
- Template email salvati su database (Spatie Mail Templates)
- Placeholder dinamici con Mustache
- Supporto HTML/Text/SMS
- Preview email in admin panel

### 2. **Allegati Email Avanzati**
- ⭐ **Allegati da contenuto binario** (PDF generati al volo)
- Allegati da file esistenti
- Multiple attachment support
- Auto-detection MIME types

### 3. **Multi-Channel Notifications**
- Email (SMTP, Mailgun, SES, ecc.)
- SMS (Twilio, Vonage, ecc.)
- WhatsApp (Twilio API)
- Database notifications

### 4. **Integrazione Filament**
- Admin panel per gestione template
- Preview email real-time
- Testing tools integrati

---

Cartella `docs/` del modulo Notify. Indice operativo (directory canoniche, evidence, famiglie dei file della radice):
[00-INDEX.md](./00-index.md). Hub BMAD: [bmad/decision-log.md](./bmad/decision-log.md), [bmad/filament-blueprint.md](./bmad/filament-blueprint.md). Questo file descrive il codice reale; quanto segue e' stato verificato il 2026-10-14 con
`ls` e `grep` su `laravel/Modules/Notify`.


Ownership: pacchetto `laraxot/module_notify_fila5` (repo git separato in `laravel/Modules/Notify`); provider
`Modules\Notify\Providers\NotifyServiceProvider` e `Providers\Filament\AdminPanelProvider` (`module.json`), su base `Xot`.
Dipendenze dichiarate in `composer.json`: aws/aws-sdk-php, filament/filament ^5, irazasyed/telegram-bot-sdk,
kreait/laravel-firebase ^7, laravel-notification-channels/fcm ^6 e /telegram, spatie/laravel-database-mail-templates,
symfony/postmark-mailer, symfony/http-client.

## Mappa del codice

| Area | Contenuto reale |
|---|---|
| `app/Actions` | 49 file PHP. Radice: `SendNotificationAction`, `SendNotificationToRecipientAction`, `SendRecordNotificationAction`, `SendRecordsNotificationAction`, `SendAppointmentNotificationAction`, `BuildMailMessageAction`, `SmtpMailSendAction`, `NetfunSendAction`, `EsendexSendAction`, `NormalizePhoneNumberAction`, `DetermineSeasonalContentViewPathAction`, e `NotificationManager` (classe, non Action) |
| Canali (Actions) | `SMS/` 12 classi (Agiletelecom v1/v2, Gammu, Netfun, Nexmo, Plivo, SmsFactor, Twilio, `SendSmsAction`), `Push/` 10 (FCM: dispositivo, piattaforma, topic, template, programmato), `Mail/` 4 + `Mail/Engines/Duocircle` 2, `Telegram/` 3 (Botman, Nutgram, Official), `WhatsApp/` 4 (360dialog, Facebook, Twilio, Vonage) |
| `app/Channels`, `app/Notifications/Channels` | `NetfunChannel`, `SmsChannel`, `TelegramChannel`, `WhatsAppChannel`; `FirebaseCloudMessagingChannel`, `NetfunChannel`, `TelegramChannel` |
| `app/Notifications` | `GenericNotification`, `RecordNotification`, `ThemeNotification`, `EmailDataNotification`, `SmsNotification`, `TelegramNotification`, `WhatsAppNotification`, `FirebaseAndroidNotification`, `TicketAssignedNotification`, `TicketStatusChangedNotification` |
| `app/Models` | 14 modelli: `Contact`, `EmailTemplate`, `MailTemplate`, `MailTemplateLog`, `MailTemplateVersion`, `Notification`, `NotificationChannel`, `NotificationLog`, `NotificationTemplate`, `NotificationTemplateVersion`, `NotificationType`, `NotifyTheme`, `NotifyThemeable`, `Theme`; 11 Policy in `Models/Policies`; unico trait `HasContact` |
| `app/Filament` | 6 Resource (`Contact`, `MailTemplate`, `Notification`, `NotificationLog`, `NotificationTemplate`, `NotifyTheme`), pagine `Dashboard` e `SettingPage`, cluster `Test` con 15 pagine di prova invio (SMTP, SES, Spatie, SMS, Netfun, Telegram, WhatsApp, Slack, push) |
| `app/Console/Commands` | `notify:send-mail`, `notify:cleanup-logs {--days=30 --batch=1000}`, `notify:migrate-themes-to-mail-templates`, `notify:analyze-translations`, `telegram:set-webhook` |
| `app/Jobs` | non esiste: la coda è eseguita dalle Queueable Actions |
| `config/` | `notify.php` (company, test_data, webhooks, email, paths, template_variables), `sms.php` (default `smsfactor`, retry, rate limit, circuit breaker), `telegram.php`, `whatsapp.php`, `config.php` (layouts e templates mail), `beautymail.php`; `NotifyServiceProvider` unisce i valori da `config('notify-env')` |
| `database/migrations` | 24 file `.php` piu' 1 `.php.no` e le sottocartelle `_archive_redundant` e `_bak` |
| `tests/` | 156 file PHP, 127 `*Test.php` (Unit: Actions, Architecture, Channels, Console, Datas, Emails, Enums, Factories, Filament, Models, Notifications, Providers, Traits; Feature: 17 file) |
| `lang/` | `de`, `en`, `es`, `fr`, `hi`, `it`, `pl`, `pt`, `ru`, `zh` |

Quick start (da `laravel/`): `php artisan module:list`, `./vendor/bin/pest Modules/Notify`, `./vendor/bin/phpstan analyse Modules/Notify`
(config unica `laravel/phpstan.neon`). Esito non rieseguito per questa revisione dei docs; attenzione: Pest in questo
monorepo puo' scrivere sul DB di sviluppo se la config e' in cache.

## Limiti verificati

- `routes/web.php` contiene solo un commento e `routes/api.php` e' vuoto: il modulo non registra rotte. Le chiavi
  `config.php` `routes.enabled` e `routes.middleware` non risultano lette da `routes/`.
- `app/Http/Controllers/NotificationTrackingController.php` (`trackOpen`, `trackClick`) esiste ma nessuna rotta lo
  richiama (grep su `laravel/Modules/*/routes`, `laravel/routes`, `Themes/*/routes`). Il test
  `tests/Unit/Architecture/NoOrphanHttpControllersTest.php` pretende che il file NON esista, ma costruisce il path con
  `dirname(__DIR__, 4)`, che da `tests/Unit/Architecture` risale a `Modules/` e non a `Modules/Notify`: l'asserzione e'
  vuota (ragionamento sul path, test non eseguito). Il docs `no-notification-tracking-controller.md` descrive la regola, non lo stato del codice.
- `SendSmsAction` delega per riflessione a `Actions\SMS\SmsEngines\{Driver}Engine`, namespace che non esiste: per
  ammissione del suo stesso docblock lancia sempre `RuntimeException`. L'invio SMS funzionante passa dalle Action per
  provider (`SendNetfunSMSAction`, `SendSmsFactorSMSAction`, ...). `SmsDriverEnum` ha un solo caso (`smsfactor`).
- `NotifyServiceProvider::boot()` chiama `Mail::alwaysTo($fallback_to)` se la config tenant `mail.fallback_to` e' una
  stringa: con quella chiave impostata TUTTE le email in uscita vanno a quell'indirizzo.
- `TrackNotificationEventAction`, citata in `monitoring.md`, non esiste in `app/`; `SendSchedeNotification`, citata
  nell'albero qui sotto in una versione precedente, non esiste; il modulo `Ptv`, citato nei collegamenti, non e' nel repo.
- Restano nel codice file di lavoro: `*.php.up` (4 in `app/Models`, 2 in `app/Filament/Resources`), `*.test` e `*.wip`
  (`app/Notifications`, `app/Emails`, `app/Filament/Resources`).
- Le migrazioni `create_mail_templates_table` sono 9 file con timestamp diversi (2018 x7, 2026-09-01, 2026-09-10); non
  verificato se siano idempotenti.

## Guidelines

Documentation should be:
- Clear and concise
- Example-driven
- Updated with code changes
- Use Markdown format (.md)

## Sistemi di Notificazione

- Mail notifications
- Database notifications
- Template management
- Queue integration

## Modelli Principali (verificato 2026-10-14 contro `app/Models/`)

```php
Modules\Notify\Models\MailTemplate
Modules\Notify\Models\MailTemplateVersion
Modules\Notify\Models\MailTemplateLog
Modules\Notify\Models\Notification
Modules\Notify\Models\NotificationLog
Modules\Notify\Models\NotificationType
Modules\Notify\Models\NotificationChannel
Modules\Notify\Models\NotificationTemplate
Modules\Notify\Models\NotificationTemplateVersion
Modules\Notify\Models\Contact          // aggiunto 2026-10-14: mancava in questo elenco
Modules\Notify\Models\EmailTemplate    // idem
Modules\Notify\Models\NotifyTheme      // idem
Modules\Notify\Models\NotifyThemeable  // idem
Modules\Notify\Models\Theme            // idem
```

## Traits

> **Verificato 2026-07-24**: `Modules\Notify\Models\Traits\HasNotify` **non esiste** (unico trait presente in
> `app/Models/Traits/` è `HasContact.php`). Se questo trait serve, va creato, non documentato come
> già presente.

## Collegamenti

- [Xot Base](../../Xot/docs) - Core framework
- [User Module](../../User/docs) - User management integration

## Risorse

- PHPStan: la cartella `docs/phpstan/` non esiste (verificato 2026-10-14); la configurazione e' unica in `laravel/phpstan.neon`
- [On-Demand Pattern](./on-demand-pattern.md): Pattern per caricamento efficiente
- [QMD Setup](./qmd-setup.md): Configurazione ricerca locale
- [Performance](./performance-optimization.md): Metriche e best practice
- [Project Structure](./project-structure.md): Directory layout

---

<!-- Merged from readme.md, which collided with this file on case-insensitive filesystems. -->

<!-- Frontmatter della seconda parte, resa commento il 2026-10-14 perche' un secondo blocco `---` a meta' file e' invalido
title: "Modulo Notify - Documentazione"
type: index
tags: [notify, docs]
module: Notify
created: 2026-07-20
updated: 2026-07-20
qmd: "notify documentazione readme modulo notify - documentazione index readme frontmatter qmd search"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/56"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/57"
related:
  - README.md
  - wiki/index.md
  - notifications/readme.md
  - integrations/readme.md
  - templates/readme.md
-->

# Modulo Notify - Documentazione

> Dalla riga precedente in poi il testo e' la vecchia `readme.md` (file distinto, `readme.md`, ancora presente). I canali
> elencati sotto vanno letti con la "Mappa del codice" di inizio file: SMS nel codice = Twilio, Nexmo (oggi Vonage), Plivo, Netfun,
> SmsFactor, Agiletelecom, Gammu; WhatsApp = 360dialog, Facebook, Twilio, Vonage; esistono anche push FCM e Telegram.

## 📚 Overview

Il modulo **Notify** è il sistema centrale per **email, notifiche, SMS e comunicazioni** nel framework Laraxot.  
Supporta template dinamici, allegati binari, multi-canale e integrazione completa con Spatie Laravel Mail Templates.

---

## 🎯 Funzionalità Principali

### 1. **Sistema Email con Template Database**
- Template email salvati su database (Spatie Mail Templates)
- Placeholder dinamici con Mustache
- Supporto HTML/Text/SMS
- Preview email in admin panel

### 2. **Allegati Email Avanzati**
- ⭐ **Allegati da contenuto binario** (PDF generati al volo)
- Allegati da file esistenti
- Multiple attachment support
- Auto-detection MIME types

### 3. **Multi-Channel Notifications**
- Email (SMTP, Mailgun, SES, ecc.)
- SMS (Twilio, Vonage, ecc.)
- WhatsApp (Twilio API)
- Database notifications

### 4. **Integrazione Filament**
- Admin panel per gestione template
- Preview email real-time
- Testing tools integrati

---

## 📖 Documentazione Disponibile

### Guide Complete

#### Email System
- **[Email Attachments Usage](./email-sending/attachments_usage.md)** ⭐  
  Guida completa agli allegati email (path e binary data)

- **[Spatie Mail Templates Deep Dive](./spatie-database-mail-templates-deep-dive.md)**  
  Sistema template email database

- **[Email Layouts Best Practices](./mail-templates/email_layouts_best_practices.md)**  
- **[Email Layouts Best Practices](./mail-templates/email_layouts_best_practices.md)**  
  Best practices layout email

#### Notifications
- **[Notifications Implementation Guide](./notifications/notifications_implementation_guide.md)**  
  Come implementare notifiche custom

- **[RecordNotification Usage](./notifications/record-notification.md)**  
  Notifiche basate su record Eloquent

#### SMS & WhatsApp
- **[WhatsApp Provider Architecture](./whatsapp_provider_architecture.md)**  
  Architettura provider WhatsApp

---

## 🏗️ Architettura

### Componenti Chiave

```
Modules/Notify/
├── app/
│   ├── Emails/
│   │   ├── SpatieEmail.php              ⭐ Email con allegati binari
│   │   └── EmailDataEmail.php
│   │  
│   ├── Notifications/
│   │   ├── RecordNotification.php       ⭐ Notifica generica per record
│   │   ├── ThemeNotification.php
│   │   └── SendSchedeNotification.php
│   │   └── ThemeNotification.php        # (SendSchedeNotification.php citato in passato: non esiste)
│   │  
│   ├── Datas/
│   │   ├── EmailData.php                # DTO Email
│   │   ├── SmtpData.php                 # DTO SMTP config
│   │   ├── SmsData.php                  # DTO SMS
│   │   └── EmailAttachmentData.php      # DTO Attachment
│   │  
│   ├── Actions/
│   │   └── BuildMailMessageAction.php
│   │  
│   └── Channels/
│       ├── SmsChannel.php
│       └── WhatsAppChannel.php
│  
└── docs/                                 # Documentazione
    ├── README.md                         ⭐ QUESTO FILE
    ├── email-sending/
    │   └── attachments_usage.md
    └── notifications/
        └── record-notification.md
```

---

## 🚀 Quick Start

### 1. Invio Email Semplice

```php
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

$user = User::find(1);
$email = new SpatieEmail($user, 'welcome');

Mail::to('user@example.com')->send($email);
```

### 2. Email con Allegato PDF Dinamico ⭐

```php
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Illuminate\Support\Facades\Notification;

// Genera PDF binario
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

// Prepara allegato
$attachments = [
    [
        'data' => $pdfContent,           // Contenuto binario PDF
        'as' => 'documento.pdf',         // Nome file nell'email
        'mime' => 'application/pdf',     // MIME type
    ],
];

// Crea e invia notifica
$notify = new RecordNotification($record, 'template-slug');
$notify = $notify->addAttachments($attachments);

Notification::route('mail', 'destinatario@example.com')->notify($notify);
```

### 3. Email con File Esistente

```php
$attachments = [
    [
        'path' => storage_path('pdfs/contratto.pdf'),
        'as' => 'contratto.pdf',
        'mime' => 'application/pdf',
    ],
];

$email = new SpatieEmail($user, 'contract-template');
$email->addAttachments($attachments);

Mail::to($user->email)->send($email);
```

### 4. Notifica Multi-Canale

```php
use Modules\Notify\Notifications\RecordNotification;

$notify = new RecordNotification($record, 'multi-channel-template');

// Invia via Email + SMS + WhatsApp
Notification::route('mail', 'user@example.com')
    ->route('sms', '+393331234567')
    ->route('whatsapp', '+393331234567')
    ->notify($notify);
```

---

## 💡 Pattern e Best Practices

### Pattern 1: Allegati Binari (Raccomandato)

**Quando usare:**
- PDF generati dinamicamente
- File creati al volo
- Contenuti non salvati su filesystem

**Vantaggi:**
- ✅ No file temporanei
- ✅ Performance migliori
- ✅ Thread-safe
- ✅ Scalabilità

```php
$attachments = [
    [
        'data' => $binaryContent,    // Contenuto binario
        'as' => 'filename.pdf',
        'mime' => 'application/pdf',
    ],
];
```

### Pattern 2: Allegati da Path

**Quando usare:**
- File esistenti su filesystem
- PDF pre-generati e cachati
- Asset statici

```php
$attachments = [
    [
        'path' => storage_path('files/doc.pdf'),
        'as' => 'documento.pdf',
        'mime' => 'application/pdf',
    ],
];
```

### Pattern 3: RecordNotification (Raccomandato)

**Quando usare:**
- Notifiche basate su record Eloquent
- Template dinamici da database
- Multi-canale support

```php
$notify = new RecordNotification($record, 'template-slug');
$notify = $notify->mergeData(['custom_var' => 'value']);
$notify = $notify->addAttachments($attachments);

Notification::route('mail', 'to@example.com')->notify($notify);
```

---

**Ultimo aggiornamento**: Novembre 2025 (PSR-4 fixes)  
**Versione**: 1.1  
**Stato**: PSR-4 compliant, test business logic completati (95% copertura)  
**Stato**: PSR-4 compliant, test business logic completati (95% copertura: cifra senza fonte, non verificata il 2026-10-14)  
**Prossimi passi**: Completamento test modelli base  
**Changelog**: [changelog.md](./CHANGELOG.md)

## 🔗 Collegamenti

### Moduli Correlati

#### Ptv (Schede Valutazione)
- **[Complete PDF Email Guide](../../Ptv/docs/pdf-email-attachments-complete-guide.md)**  
  Caso d'uso completo: invio schede valutazione con PDF

- **[SendMailByRecord Action](../../Ptv/app/Actions/Scheda/SendMailByRecord.php)**  
  Implementation reference

#### Xot (Core Framework)
- **[GetPdfContentByRecordAction](../../Xot/docs/actions/pdf-content-generation-technical.md)**  
  Generazione PDF binario da record
- Il modulo `Ptv` non e' presente in questo repository (verificato 2026-10-14: `laravel/Modules/` non lo contiene).
  I due riferimenti che seguivano (`Ptv/docs/pdf-email-attachments-complete-guide.md` e
  `Ptv/app/Actions/Scheda/SendMailByRecord.php`) sono stati ridotti a testo perche' i bersagli non esistono qui.

#### Xot (Core Framework)
- **[GetPdfContentByRecordAction](../../Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php)**  
  Generazione PDF binario da record (codice; la guida `Xot/docs/actions/pdf-content-generation-technical.md` non esiste)

- **[PDF Actions](../../Xot/app/Actions/Pdf/)**  
  Actions per gestione PDF

### Documentazione Interna

#### Email System
- [Email Layouts Best Practices](./mail-templates/email_layouts_best_practices.md)
- [Spatie Mail Templates Structure](./mail-templates/spatie_mail_templates_structure.md)
- [Email Troubleshooting](./email-sending/email_troubleshooting.md)

#### Notifications
- [Notifications Implementation Guide](./notifications/notifications_implementation_guide.md)
- [Notification Management Business Logic](./notifications/notification-management-business-logic.md)
- [Email Layouts Best Practices](./mail-templates/email_layouts_best_practices.md)
- [Spatie Mail Templates Structure](./mail-templates/spatie_mail_templates_structure.md)
- [Email Troubleshooting](./email-sending/email_troubleshooting.md)

#### Notifications
- [Notifications Implementation Guide](./notifications/notifications_implementation_guide.md)
- Notification Management Business Logic: la pagina `notifications/notification-management-business-logic.md` non esiste; il comportamento e' coperto da `tests/Feature/NotificationManagementBusinessLogicTest.php`

---

## 🧪 Testing

### Test Email con Allegati

```php
use Tests\TestCase;
use Modules\Notify\Emails\SpatieEmail;

class SpatieEmailTest extends TestCase
{
    /** @test */
    public function it_attaches_binary_pdf_content(): void
    {
        $pdfContent = '%PDF-1.4...'; // Mock binary
        
        $attachments = [
            [
                'data' => $pdfContent,
                'as' => 'test.pdf',
                'mime' => 'application/pdf',
            ],
        ];
        
        $email = new SpatieEmail($record, 'test-template');
        $email->addAttachments($attachments);
        
        $this->assertCount(1, $email->attachments());
    }
}
```

### Test Notifiche

```bash
php artisan test --filter=RecordNotificationTest
```

---

## 🛠️ Troubleshooting

### Email Non Arriva

**Checklist:**
- [ ] Configurazione SMTP corretta (`.env`)
- [ ] Template email esiste nel database
- [ ] Destinatario valido
- [ ] Allegati corretti (path esiste o data non vuoto)
- [ ] Log errori (`storage/logs/laravel.log`)

**Debug:**
```bash
php artisan tinker
>>> Mail::raw('Test', fn($m) => $m->to('test@example.com'));
>>> Mail::failures();
```

### Allegato Non Arriva

**Cause comuni:**
- Array allegati malformato
- MIME type errato
- Contenuto binario corrotto
- File path non esistente

**Test:**
```php
// Verifica formato allegato
$attachments = [
    [
        'data' => $content,  // DEVE essere presente
        'as' => 'file.pdf',  // DEVE essere stringa
        'mime' => 'application/pdf', // DEVE essere stringa
    ],
];
```

---

## 📊 Performance

### Ottimizzazioni Applicate

1. **Lazy Template Loading** - Template caricati on-demand
2. **Queue Support** - Notifiche in coda per performance
3. **Binary Attachments** - No file I/O per allegati dinamici
4. **Cache Templates** - Template cachati in produzione

### Monitoring

```php
use Illuminate\Support\Facades\Log;

Log::channel('email')->info('Email sent', [
    'to' => $recipient,
    'template' => $slug,
    'attachments_count' => count($attachments),
]);
```

---

## 🔐 Sicurezza

### Controlli Implementati

- ✅ **Email Validation** - Validazione indirizzi email (Webmozart Assert)
- ✅ **MIME Type Validation** - Validazione tipi file
- ✅ **File Existence Check** - Controllo esistenza file path
- ✅ **Input Sanitization** - Sanitizzazione input utente
- ✅ **Rate Limiting** - Throttle su invii massivi

---

## 📝 Changelog

### v2.1.0 (2025-01-22)
- ✨ Supporto allegati binari (data field)
- ✅ PHPStan Level 10 compliance
- 📚 Documentazione completa aggiornata
- 🐛 Fix tipizzazione SpatieEmail
- 🐛 Fix validazione RecordNotification

### v2.0.0
- Integrazione Spatie Mail Templates
- Multi-canale support
- Template database

---

## 👥 Contributors

- **Team Laraxot** - Core implementation
- **Xot Module** - PDF generation support

## Documentation

**Ultimo aggiornamento:** 2025-01-22  
**Versione:** 2.1.0  
**Stato:** ✅ Production Ready  
**PHPStan Level:** 10
