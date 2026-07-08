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

## 📖 Documentazione Disponibile

### Guide Complete

#### Email System
- **[Email Attachments Usage](./email-sending/attachments_usage.md)** ⭐  
  Guida completa agli allegati email (path e binary data)

- **[Spatie Mail Templates Deep Dive](./spatie-database-mail-templates-deep-dive.md)**  
  Sistema template email database

- **[Email Layouts Best Practices](./mail-templates/EMAIL_LAYOUTS_BEST_PRACTICES.md)**  
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
**Prossimi passi**: Completamento test modelli base  
**Changelog**: [CHANGELOG.md](./CHANGELOG.md)

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

- **[PDF Actions](../../Xot/app/Actions/Pdf/)**  
  Actions per gestione PDF

### Documentazione Interna

#### Email System
- [Email Layouts Best Practices](./mail-templates/EMAIL_LAYOUTS_BEST_PRACTICES.md)
- [Spatie Mail Templates Structure](./mail-templates/SPATIE_MAIL_TEMPLATES_STRUCTURE.md)
- [Email Troubleshooting](./email-sending/EMAIL_TROUBLESHOOTING.md)

#### Notifications
- [Notifications Implementation Guide](./notifications/notifications_implementation_guide.md)
- [Notification Management Business Logic](./notifications/notification-management-business-logic.md)

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

---

**Ultimo aggiornamento:** 2025-01-22  
**Versione:** 2.1.0  
**Stato:** ✅ Production Ready  
**PHPStan Level:** 10
