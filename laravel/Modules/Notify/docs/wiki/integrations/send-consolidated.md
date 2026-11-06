---
qmd: "send consolidated"
issues: []
discussions: []
title: "send: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# send: Consolidated Documentation

Consolidated from **20** individual files.

## Table of Contents

- [---](#send-email-fix-1)
- [Guida alla Correzione di SendEmail.php](#send-email-fix)
- [Fix Traduzioni File send_email.php - Modulo Notify](#send-email-translation-fix-1)
- [---](#send-email-translation-fix-2)
- [Fix Traduzioni File send_email.php - Modulo Notify](#send-email-translation-fix)
- [Miglioramento File Traduzione send_email.php](#send-email-translation-improvement-1)
- [---](#send-email-translation-improvement-2)
- [Miglioramento File Traduzione send_email.php](#send-email-translation-improvement)
- [Fix Traduzioni File send_email.php - Modulo Notify](#send-email-translation)
- [Guida alla Correzione di SendEmail.php](#send-email)
- [SendNotificationBulkAction - Implementazione Completa](#send-notification-bulk-action)
- [Risoluzione conflitto git su SendPushNotification.php](#send-push-notification-conflict-resolution)
- [Risoluzione conflitto git su SendPushNotification.php](#send-push-notification-resolution)
- [Refactoring: SendRecordNotificationAction Duplication](#send-record-notification-action-refactoring)
- [Guida alla Correzione di SendEmail.php](#send_email_fix)
- [Fix Traduzioni File send_email.php - Modulo Notify](#send_email_translation_fix)
- [Miglioramento File Traduzione send_email.php](#send_email_translation_improvement)
- [---](#sendemail-troubleshooting-1)
- [Troubleshooting SendEmail](#sendemail-troubleshooting)
- [Troubleshooting SendEmail](#sendemail_troubleshooting)

---

## send-email-fix-1

*Consolidated from: `send-email-fix.md`*

title: "Guida alla Correzione di SendEmail.php"
type: concept
tags: [send, email, fix]
created: 2026-07-14
updated: 2026-07-14
qmd: "send-email-fix-1 guida alla correzione di sendemail.php"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Guida alla Correzione di SendEmail.php

## 🔍 Analisi del Problema

Il file `SendEmail.php` non funziona correttamente per i seguenti motivi:

1. **Configurazione SMTP Mancante**
   - Non utilizza la configurazione SMTP corretta
   - Manca la gestione delle credenziali

2. **Problemi di Implementazione**
   - Non estende `XotBasePage`
   - Manca la gestione degli errori
   - Non utilizza DTO per i dati

## 🛠️ Soluzione

### 1. Configurazione SMTP

Aggiungere nel file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_from_address
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modifiche al Codice

```php
<?php

namespace Modules\Notify\App\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Modules\Notify\App\Data\EmailData;
use Modules\Notify\App\Data\SmtpData;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Invia Email';
    protected static ?string $title = 'Invia Email';
    protected static ?string $slug = 'send-email';

    public ?EmailData $emailData = null;
    public ?SmtpData $smtpData = null;

    public function mount(): void
    {
        $this->authorize('view', $this);
        $this->emailData = new EmailData();
        $this->smtpData = new SmtpData();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configurazione SMTP')
                    ->schema([
                        Forms\Components\TextInput::make('smtp.host')
                            ->required()
                            ->label('Host SMTP')
                            ->default(config('mail.mailers.smtp.host')),
                        Forms\Components\TextInput::make('smtp.port')
                            ->required()
                            ->numeric()
                            ->label('Porta SMTP')
                            ->default(config('mail.mailers.smtp.port')),
                        Forms\Components\TextInput::make('smtp.username')
                            ->required()
                            ->label('Username SMTP')
                            ->default(config('mail.mailers.smtp.username')),
                        Forms\Components\TextInput::make('smtp.password')
                            ->required()
                            ->password()
                            ->label('Password SMTP')
                            ->default(config('mail.mailers.smtp.password')),
                        Forms\Components\TextInput::make('smtp.encryption')
                            ->label('Crittografia SMTP')
                            ->default(config('mail.mailers.smtp.encryption')),
                    ]),
                Forms\Components\Section::make('Dettagli Email')
                    ->schema([
                        Forms\Components\TextInput::make('email.to')
                            ->required()
                            ->email()
                            ->label('Destinatario'),
                        Forms\Components\TextInput::make('email.subject')
                            ->required()
                            ->label('Oggetto'),
                        Forms\Components\RichEditor::make('email.body')
                            ->required()
                            ->label('Corpo Email'),
                    ]),
            ]);
    }

    public function sendEmail(): void
    {
        try {
            $data = $this->form->getState();
            
            // Configura SMTP
            config([
                'mail.mailers.smtp.host' => $data['smtp']['host'],
                'mail.mailers.smtp.port' => $data['smtp']['port'],
                'mail.mailers.smtp.username' => $data['smtp']['username'],
                'mail.mailers.smtp.password' => $data['smtp']['password'],
                'mail.mailers.smtp.encryption' => $data['smtp']['encryption'],
            ]);

            // Crea DTO
            $smtpData = SmtpData::from($data['smtp']);
            $emailData = EmailData::from($data['email']);

            // Invia email
            $smtpData->send($emailData);

            Notification::make()
                ->success()
                ->title('Email inviata con successo')
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Errore nell\'invio dell\'email')
                ->body($e->getMessage())
                ->send();
        }
    }
}
```

### 3. Creazione DTO

Creare i file DTO necessari:

```php
// app/Data/EmailData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class EmailData extends Data
{
    public function __construct(
        public string $to,
        public string $subject,
        public string $body,
    ) {
    }
}

// app/Data/SmtpData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class SmtpData extends Data
{
    public function __construct(
        public string $host,
        public int $port,
        public string $username,
        public string $password,
        public ?string $encryption = null,
    ) {
    }

    public function send(EmailData $emailData): void
    {
        // Implementare la logica di invio
        // Utilizzare Mail::to()->send() o un servizio SMTP
    }
}
```

## 📋 Checklist di Verifica

1. **Configurazione**
   - [ ] File `.env` configurato correttamente
   - [ ] Credenziali SMTP valide
   - [ ] Configurazione mail in `config/mail.php`

2. **Implementazione**
   - [ ] DTO creati e configurati
   - [ ] Form implementato correttamente
   - [ ] Gestione errori implementata
   - [ ] Notifiche configurate

3. **Test**
   - [ ] Test connessione SMTP
   - [ ] Test invio email
   - [ ] Verifica feedback utente
   - [ ] Controllo log errori

## 🔗 Collegamenti Utili

- [Documentazione Laravel Mail](https://laravel.com/project_docs/mail)
- [Documentazione Filament Forms](https://filamentphp.com/project_docs/forms)
- [Best Practices SMTP](https://laravel.com/project_docs/mail#smtp-configuration)

## ⚠️ Note Importanti

1. **Sicurezza**
   - Non committare mai le credenziali SMTP
   - Utilizzare variabili d'ambiente
   - Implementare rate limiting

2. **Performance**
   - Implementare coda per email
   - Gestire timeout
   - Monitorare utilizzo risorse

3. **Manutenzione**
   - Aggiornare regolarmente le dipendenze
   - Monitorare log errori
   - Verificare configurazione SMTP 
---

## send-email-fix

*Consolidated from: `send-email-fix.md`*


## 🔍 Analisi del Problema

Il file `SendEmail.php` non funziona correttamente per i seguenti motivi:

1. **Configurazione SMTP Mancante**
   - Non utilizza la configurazione SMTP corretta
   - Manca la gestione delle credenziali

2. **Problemi di Implementazione**
   - Non estende `XotBasePage`
   - Manca la gestione degli errori
   - Non utilizza DTO per i dati

## 🛠️ Soluzione

### 1. Configurazione SMTP

Aggiungere nel file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_from_address
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modifiche al Codice

```php
<?php

namespace Modules\Notify\App\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Modules\Notify\App\Data\EmailData;
use Modules\Notify\App\Data\SmtpData;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Invia Email';
    protected static ?string $title = 'Invia Email';
    protected static ?string $slug = 'send-email';

    public ?EmailData $emailData = null;
    public ?SmtpData $smtpData = null;

    public function mount(): void
    {
        $this->authorize('view', $this);
        $this->emailData = new EmailData();
        $this->smtpData = new SmtpData();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configurazione SMTP')
                    ->schema([
                        Forms\Components\TextInput::make('smtp.host')
                            ->required()
                            ->label('Host SMTP')
                            ->default(config('mail.mailers.smtp.host')),
                        Forms\Components\TextInput::make('smtp.port')
                            ->required()
                            ->numeric()
                            ->label('Porta SMTP')
                            ->default(config('mail.mailers.smtp.port')),
                        Forms\Components\TextInput::make('smtp.username')
                            ->required()
                            ->label('Username SMTP')
                            ->default(config('mail.mailers.smtp.username')),
                        Forms\Components\TextInput::make('smtp.password')
                            ->required()
                            ->password()
                            ->label('Password SMTP')
                            ->default(config('mail.mailers.smtp.password')),
                        Forms\Components\TextInput::make('smtp.encryption')
                            ->label('Crittografia SMTP')
                            ->default(config('mail.mailers.smtp.encryption')),
                    ]),
                Forms\Components\Section::make('Dettagli Email')
                    ->schema([
                        Forms\Components\TextInput::make('email.to')
                            ->required()
                            ->email()
                            ->label('Destinatario'),
                        Forms\Components\TextInput::make('email.subject')
                            ->required()
                            ->label('Oggetto'),
                        Forms\Components\RichEditor::make('email.body')
                            ->required()
                            ->label('Corpo Email'),
                    ]),
            ]);
    }

    public function sendEmail(): void
    {
        try {
            $data = $this->form->getState();
            
            // Configura SMTP
            config([
                'mail.mailers.smtp.host' => $data['smtp']['host'],
                'mail.mailers.smtp.port' => $data['smtp']['port'],
                'mail.mailers.smtp.username' => $data['smtp']['username'],
                'mail.mailers.smtp.password' => $data['smtp']['password'],
                'mail.mailers.smtp.encryption' => $data['smtp']['encryption'],
            ]);

            // Crea DTO
            $smtpData = SmtpData::from($data['smtp']);
            $emailData = EmailData::from($data['email']);

            // Invia email
            $smtpData->send($emailData);

            Notification::make()
                ->success()
                ->title('Email inviata con successo')
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Errore nell\'invio dell\'email')
                ->body($e->getMessage())
                ->send();
        }
    }
}
```

### 3. Creazione DTO

Creare i file DTO necessari:

```php
// app/Data/EmailData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class EmailData extends Data
{
    public function __construct(
        public string $to,
        public string $subject,
        public string $body,
    ) {
    }
}

// app/Data/SmtpData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class SmtpData extends Data
{
    public function __construct(
        public string $host,
        public int $port,
        public string $username,
        public string $password,
        public ?string $encryption = null,
    ) {
    }

    public function send(EmailData $emailData): void
    {
        // Implementare la logica di invio
        // Utilizzare Mail::to()->send() o un servizio SMTP
    }
}
```

## 📋 Checklist di Verifica

1. **Configurazione**
   - [ ] File `.env` configurato correttamente
   - [ ] Credenziali SMTP valide
   - [ ] Configurazione mail in `config/mail.php`

2. **Implementazione**
   - [ ] DTO creati e configurati
   - [ ] Form implementato correttamente
   - [ ] Gestione errori implementata
   - [ ] Notifiche configurate

3. **Test**
   - [ ] Test connessione SMTP
   - [ ] Test invio email
   - [ ] Verifica feedback utente
   - [ ] Controllo log errori

## 🔗 Collegamenti Utili

- [Documentazione Laravel Mail](https://laravel.com/project_docs/mail)
- [Documentazione Filament Forms](https://filamentphp.com/project_docs/forms)
- [Best Practices SMTP](https://laravel.com/project_docs/mail#smtp-configuration)
- [Documentazione Laravel Mail](https://laravel.com/docs/mail)
- [Documentazione Filament Forms](https://filamentphp.com/docs/forms)
- [Best Practices SMTP](https://laravel.com/docs/mail#smtp-configuration)

## ⚠️ Note Importanti

1. **Sicurezza**
   - Non committare mai le credenziali SMTP
   - Utilizzare variabili d'ambiente
   - Implementare rate limiting

2. **Performance**
   - Implementare coda per email
   - Gestire timeout
   - Monitorare utilizzo risorse

3. **Manutenzione**
   - Aggiornare regolarmente le dipendenze
   - Monitorare log errori
   - Verificare configurazione SMTP 
---

## send-email-translation-fix-1

*Consolidated from: `send-email-translation-fix-1.md`*
*Consolidated from: `send-email-translation-fix.md`*


## Problemi Identificati

### 1. Conflitti di Merge Non Risolti
- Presenza di marcatori git  nel file
- Codice duplicato e inconsistente

### 2. Sintassi Obsoleta
- Uso di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Struttura Non Espansa
- Campi con struttura semplificata invece di struttura espansa
- Mancanza di `label`, `placeholder`, `help` per alcuni campi

### 4. Campi Mancanti
- Programmazione invio (`scheduled_at`)
- Configurazione mittente (`from_email`, `from_name`)
- Priorità email (`priority`)
- Categoria email (`category`)
- Tracking (`tracking_enabled`)

### 5. Azioni Incomplete
- Messaggi di successo/errore mancanti
- Conferme modali incomplete

### 6. Validazione Incompleta
- Messaggi di validazione specifici mancanti
- Regole di validazione non documentate

## Soluzioni Implementate

### ✅ Struttura Espansa Completa
Ogni campo ora ha la struttura espansa completa:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'description' => 'Descrizione del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto perché diverso da placeholder
],
```

### ✅ Regola Critica: Tooltip e Helper Text
**REGOLA IMPORTANTE**: Ogni campo con `label` e `placeholder` DEVE avere:
- `tooltip`: Informazione aggiuntiva per l'utente
- `helper_text`: Impostato a `''` quando diverso da placeholder

### ✅ Campi Aggiunti
- `sections`: Organizzazione logica dei campi
- `to`, `cc`, `bcc`: Separazione destinatari
- `content`: Contenuto testuale separato da HTML
- `parameters`: Parametri JSON per template
- `priority`: Priorità di invio
- `category`: Categorizzazione email
- `tracking_enabled`: Abilitazione tracking

### ✅ Azioni Migliorate
- Messaggi di successo/errore completi
- Conferme modali con descrizioni dettagliate
- Tooltip per ogni azione

### ✅ Validazione Completa
- Messaggi specifici per ogni regola di validazione
- Validazione per tutti i nuovi campi

## Struttura Finale

### Sezioni Organizzate
1. **Dettagli Email**: Oggetto, template
2. **Destinatari**: To, CC, BCC
3. **Contenuto**: Testo, HTML, parametri
4. **Allegati**: File da allegare
5. **Programmazione**: Invio programmato
6. **Avanzate**: Priorità, categoria, tracking

### Campi Principali
- `subject`: Oggetto email
- `template_id`: Template predefinito
- `to`: Destinatario principale
- `cc`: Copia conoscenza
- `bcc`: Copia nascosta
- `from_email`: Email mittente
- `from_name`: Nome mittente
- `content`: Contenuto testuale
- `body_html`: Contenuto HTML
- `parameters`: Parametri template
- `attachments`: File allegati
- `priority`: Priorità invio
- `scheduled_at`: Programmazione
- `category`: Categoria email
- `tracking_enabled`: Abilita tracking

### Azioni Disponibili
- `send`: Invio immediato
- `preview`: Anteprima email
- `save_draft`: Salva bozza
- `schedule`: Programma invio
- `test_smtp`: Test configurazione

## Conformità Standard

### ✅ Sintassi Moderna
- `declare(strict_types=1);` presente
- Sintassi breve array `[]`
- Tipizzazione corretta

### ✅ Struttura Espansa
- Tutti i campi con struttura completa
- Tooltip e helper_text per ogni campo
- Organizzazione logica in sezioni

### ✅ Completezza
- Tutti i campi necessari presenti
- Azioni complete con messaggi
- Validazione specifica

### ✅ Coerenza
- Naming consistente
- Terminologia uniforme
- Struttura standardizzata

## Collegamenti

- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)

## Note Importanti

### Regola Critica: Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'tooltip' => 'Informazione aggiuntiva per l\'utente',
'helper_text' => '', // Vuoto se diverso da placeholder
```

### Struttura Espansa Obbligatoria
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```

*Ultimo aggiornamento: 2025-01-06*
---

## send-email-translation-fix-2

*Consolidated from: `send-email-translation-fix.md`*

title: "Fix Traduzioni File send_email.php - Modulo Notify"
type: concept
tags: [send, email, translation, fix]
created: 2026-07-14
updated: 2026-07-14
qmd: "send-email-translation-fix-2 fix traduzioni file send_email.php - modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Fix Traduzioni File send_email.php - Modulo Notify

## Problemi Identificati

### 1. Conflitti di Merge Non Risolti
- Presenza di marcatori git  nel file
- Codice duplicato e inconsistente

### 2. Sintassi Obsoleta
- Uso di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Struttura Non Espansa
- Campi con struttura semplificata invece di struttura espansa
- Mancanza di `label`, `placeholder`, `help` per alcuni campi

### 4. Campi Mancanti
- Programmazione invio (`scheduled_at`)
- Configurazione mittente (`from_email`, `from_name`)
- Priorità email (`priority`)
- Categoria email (`category`)
- Tracking (`tracking_enabled`)

### 5. Azioni Incomplete
- Messaggi di successo/errore mancanti
- Conferme modali incomplete

### 6. Validazione Incompleta
- Messaggi di validazione specifici mancanti
- Regole di validazione non documentate

## Soluzioni Implementate

### ✅ Struttura Espansa Completa
Ogni campo ora ha la struttura espansa completa:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'description' => 'Descrizione del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto perché diverso da placeholder
],
```

### ✅ Regola Critica: Tooltip e Helper Text
**REGOLA IMPORTANTE**: Ogni campo con `label` e `placeholder` DEVE avere:
- `tooltip`: Informazione aggiuntiva per l'utente
- `helper_text`: Impostato a `''` quando diverso da placeholder

### ✅ Campi Aggiunti
- `sections`: Organizzazione logica dei campi
- `to`, `cc`, `bcc`: Separazione destinatari
- `content`: Contenuto testuale separato da HTML
- `parameters`: Parametri JSON per template
- `priority`: Priorità di invio
- `category`: Categorizzazione email
- `tracking_enabled`: Abilitazione tracking

### ✅ Azioni Migliorate
- Messaggi di successo/errore completi
- Conferme modali con descrizioni dettagliate
- Tooltip per ogni azione

### ✅ Validazione Completa
- Messaggi specifici per ogni regola di validazione
- Validazione per tutti i nuovi campi

## Struttura Finale

### Sezioni Organizzate
1. **Dettagli Email**: Oggetto, template
2. **Destinatari**: To, CC, BCC
3. **Contenuto**: Testo, HTML, parametri
4. **Allegati**: File da allegare
5. **Programmazione**: Invio programmato
6. **Avanzate**: Priorità, categoria, tracking

### Campi Principali
- `subject`: Oggetto email
- `template_id`: Template predefinito
- `to`: Destinatario principale
- `cc`: Copia conoscenza
- `bcc`: Copia nascosta
- `from_email`: Email mittente
- `from_name`: Nome mittente
- `content`: Contenuto testuale
- `body_html`: Contenuto HTML
- `parameters`: Parametri template
- `attachments`: File allegati
- `priority`: Priorità invio
- `scheduled_at`: Programmazione
- `category`: Categoria email
- `tracking_enabled`: Abilita tracking

### Azioni Disponibili
- `send`: Invio immediato
- `preview`: Anteprima email
- `save_draft`: Salva bozza
- `schedule`: Programma invio
- `test_smtp`: Test configurazione

## Conformità Standard

### ✅ Sintassi Moderna
- `declare(strict_types=1);` presente
- Sintassi breve array `[]`
- Tipizzazione corretta

### ✅ Struttura Espansa
- Tutti i campi con struttura completa
- Tooltip e helper_text per ogni campo
- Organizzazione logica in sezioni

### ✅ Completezza
- Tutti i campi necessari presenti
- Azioni complete con messaggi
- Validazione specifica

### ✅ Coerenza
- Naming consistente
- Terminologia uniforme
- Struttura standardizzata

## Collegamenti

- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)

## Note Importanti

### Regola Critica: Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'tooltip' => 'Informazione aggiuntiva per l\'utente',
'helper_text' => '', // Vuoto se diverso da placeholder
```

### Struttura Espansa Obbligatoria
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```

*Ultimo aggiornamento: 2025-01-06* 
---

## send-email-translation-fix

*Consolidated from: `send-email-translation-fix.md`*


## Problemi Identificati

### 1. Conflitti di Merge Non Risolti
- Presenza di marcatori git  nel file
- Codice duplicato e inconsistente

### 2. Sintassi Obsoleta
- Uso di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Struttura Non Espansa
- Campi con struttura semplificata invece di struttura espansa
- Mancanza di `label`, `placeholder`, `help` per alcuni campi

### 4. Campi Mancanti
- Programmazione invio (`scheduled_at`)
- Configurazione mittente (`from_email`, `from_name`)
- Priorità email (`priority`)
- Categoria email (`category`)
- Tracking (`tracking_enabled`)

### 5. Azioni Incomplete
- Messaggi di successo/errore mancanti
- Conferme modali incomplete

### 6. Validazione Incompleta
- Messaggi di validazione specifici mancanti
- Regole di validazione non documentate

## Soluzioni Implementate

### ✅ Struttura Espansa Completa
Ogni campo ora ha la struttura espansa completa:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'description' => 'Descrizione del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto perché diverso da placeholder
],
```

### ✅ Regola Critica: Tooltip e Helper Text
**REGOLA IMPORTANTE**: Ogni campo con `label` e `placeholder` DEVE avere:
- `tooltip`: Informazione aggiuntiva per l'utente
- `helper_text`: Impostato a `''` quando diverso da placeholder

### ✅ Campi Aggiunti
- `sections`: Organizzazione logica dei campi
- `to`, `cc`, `bcc`: Separazione destinatari
- `content`: Contenuto testuale separato da HTML
- `parameters`: Parametri JSON per template
- `priority`: Priorità di invio
- `category`: Categorizzazione email
- `tracking_enabled`: Abilitazione tracking

### ✅ Azioni Migliorate
- Messaggi di successo/errore completi
- Conferme modali con descrizioni dettagliate
- Tooltip per ogni azione

### ✅ Validazione Completa
- Messaggi specifici per ogni regola di validazione
- Validazione per tutti i nuovi campi

## Struttura Finale

### Sezioni Organizzate
1. **Dettagli Email**: Oggetto, template
2. **Destinatari**: To, CC, BCC
3. **Contenuto**: Testo, HTML, parametri
4. **Allegati**: File da allegare
5. **Programmazione**: Invio programmato
6. **Avanzate**: Priorità, categoria, tracking

### Campi Principali
- `subject`: Oggetto email
- `template_id`: Template predefinito
- `to`: Destinatario principale
- `cc`: Copia conoscenza
- `bcc`: Copia nascosta
- `from_email`: Email mittente
- `from_name`: Nome mittente
- `content`: Contenuto testuale
- `body_html`: Contenuto HTML
- `parameters`: Parametri template
- `attachments`: File allegati
- `priority`: Priorità invio
- `scheduled_at`: Programmazione
- `category`: Categoria email
- `tracking_enabled`: Abilita tracking

### Azioni Disponibili
- `send`: Invio immediato
- `preview`: Anteprima email
- `save_draft`: Salva bozza
- `schedule`: Programma invio
- `test_smtp`: Test configurazione

## Conformità Standard

### ✅ Sintassi Moderna
- `declare(strict_types=1);` presente
- Sintassi breve array `[]`
- Tipizzazione corretta

### ✅ Struttura Espansa
- Tutti i campi con struttura completa
- Tooltip e helper_text per ogni campo
- Organizzazione logica in sezioni

### ✅ Completezza
- Tutti i campi necessari presenti
- Azioni complete con messaggi
- Validazione specifica

### ✅ Coerenza
- Naming consistente
- Terminologia uniforme
- Struttura standardizzata

## Collegamenti

- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)

## Note Importanti

### Regola Critica: Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'tooltip' => 'Informazione aggiuntiva per l\'utente',
'helper_text' => '', // Vuoto se diverso da placeholder
```

### Struttura Espansa Obbligatoria
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```

*Ultimo aggiornamento: [DATE]* 
---

## send-email-translation-improvement-1

*Consolidated from: `send-email-translation-improvement.md`*


## 🔍 Analisi del Problema

Il file `laravel/Modules/Notify/lang/it/send_email.php` presenta diversi problemi critici:

### 1. Conflitto di Merge Non Risolto
- Presenza di marcatori
- Due versioni del file in conflitto
- Sintassi PHP non valida che impedisce l'esecuzione

### 2. Problemi di Struttura
- Uso di sintassi `array()` invece di `[]` moderna
- Mancanza di `declare(strict_types=1);`
- Struttura non espansa per alcuni campi
- Duplicazioni e campi non necessari

### 3. Non Conformità alle Best Practice Laraxot
- Mancanza di struttura espansa per tutti i campi
- Uso di `helper_text` uguale alla chiave dell'array
- Mancanza di organizzazione logica delle sezioni

## 🛠️ Soluzioni Implementate

### 1. Risoluzione Conflitto di Merge

**Prima**:
```php
declare(strict_types=1);

return [
    // Versione HEAD
];
return array (
    // Versione branch trans
);
```

**Dopo**:
```php
<?php

declare(strict_types=1);

return [
    // Struttura unificata e migliorata
];
```

### 2. Modernizzazione Sintassi

**Prima**:
```php
return array (
  'navigation' =>
  array (
    'label' => 'Invio Email',
    // ...
  ),
);
```

**Dopo**:
```php
return [
    'navigation' => [
        'label' => 'Invio Email',
        // ...
    ],
];
```

### 3. Struttura Espansa Completa

**Implementata per tutti i campi**:
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'description' => 'Descrizione dettagliata del campo'
    ]
]
```

### 4. Organizzazione in Sezioni Logiche

```php
'sections' => [
    'email_details' => [
        'label' => 'Dettagli Email',
        'description' => 'Informazioni principali dell\'email',
    ],
    'recipients' => [
        'label' => 'Destinatari',
        'description' => 'Configurazione destinatari e copie',
    ],
    'content' => [
        'label' => 'Contenuto',
        'description' => 'Contenuto dell\'email e template',
    ],
    'attachments' => [
        'label' => 'Allegati',
        'description' => 'File da allegare all\'email',
    ],
    'scheduling' => [
        'label' => 'Programmazione',
        'description' => 'Configurazione invio programmato',
    ],
    'advanced' => [
        'label' => 'Avanzate',
        'description' => 'Opzioni avanzate per l\'invio',
    ],
],
```

### 5. Campi Migliorati e Aggiunti

#### Campi per Programmazione
```php
'scheduled_at' => [
    'label' => 'Data e Ora Programmate',
    'placeholder' => 'Seleziona data e ora per l\'invio programmato',
    'help' => 'Programma l\'invio dell\'email per una data e ora specifiche',
    'description' => 'Data e ora per l\'invio programmato dell\'email',
],
```

#### Configurazione Mittente
```php
'from_email' => [
    'label' => 'Email Mittente',
    'placeholder' => 'mittente@dominio.com',
    'help' => 'Indirizzo email del mittente (se diverso dal default)',
    'description' => 'Indirizzo email del mittente personalizzato',
],
'from_name' => [
    'label' => 'Nome Mittente',
    'placeholder' => 'Nome del mittente',
    'help' => 'Nome visualizzato del mittente (se diverso dal default)',
    'description' => 'Nome visualizzato del mittente personalizzato',
],
```

#### Opzioni Priorità Migliorate
```php
'priority' => [
    'label' => 'Priorità',
    'placeholder' => 'Seleziona la priorità dell\'email',
    'help' => 'Imposta la priorità di invio dell\'email',
    'description' => 'Livello di priorità per l\'invio dell\'email',
    'options' => [
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
],
```

### 6. Azioni Migliorate

```php
'actions' => [
    'send' => [
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo al destinatario',
        'error' => 'Errore nell\'invio dell\'email. Verifica la configurazione.',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
        'tooltip' => 'Invia l\'email al destinatario specificato',
        'modal' => [
            'heading' => 'Conferma Invio Email',
            'description' => 'Stai per inviare un\'email. Questa azione non può essere annullata.',
            'confirm' => 'Invia Email',
            'cancel' => 'Annulla',
        ],
    ],
    'test_smtp' => [
        'label' => 'Test SMTP',
        'success' => 'Test SMTP completato con successo',
        'error' => 'Errore nel test SMTP',
        'tooltip' => 'Testa la configurazione SMTP prima dell\'invio',
        'modal' => [
            'heading' => 'Test Configurazione SMTP',
            'description' => 'Verifica la configurazione SMTP prima dell\'invio',
            'confirm' => 'Esegui Test',
            'cancel' => 'Annulla',
        ],
    ],
],
```

### 7. Messaggi di Validazione Migliorati

```php
'validation' => [
    'subject_required' => 'L\'oggetto dell\'email è obbligatorio',
    'subject_max' => 'L\'oggetto non può superare i 255 caratteri',
    'to_required' => 'Il destinatario è obbligatorio',
    'to_valid' => 'Il destinatario deve essere un indirizzo email valido',
    'to_max' => 'L\'indirizzo email del destinatario è troppo lungo',
    'cc_valid' => 'Gli indirizzi in CC devono essere email valide',
    'cc_max' => 'Uno o più indirizzi in CC sono troppo lunghi',
    'bcc_valid' => 'Gli indirizzi in BCC devono essere email valide',
    'bcc_max' => 'Uno o più indirizzi in BCC sono troppo lunghi',
    'content_required' => 'Il contenuto testuale dell\'email è obbligatorio',
    'content_max' => 'Il contenuto testuale è troppo lungo (max 10000 caratteri)',
    'body_html_max' => 'Il contenuto HTML è troppo lungo (max 20000 caratteri)',
    'template_exists' => 'Il template selezionato non esiste',
    'parameters_required' => 'I parametri sono obbligatori quando si utilizza un template',
    'parameters_json' => 'I parametri devono essere in formato JSON valido',
    'parameters_max' => 'I parametri superano la lunghezza massima consentita',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_valid' => 'La priorità deve essere una delle opzioni disponibili',
    'attachments_max' => 'Numero massimo di allegati consentito: :max',
    'attachments_total_size' => 'La dimensione totale degli allegati supera il limite consentito',
    'file_required' => 'Seleziona un file da allegare',
    'file_size_max' => 'Dimensione massima del file: :max_size',
    'file_type_allowed' => 'Tipo di file non consentito. Tipi supportati: :types',
    'scheduled_at_required' => 'Specifica la data e l\'ora per la programmazione',
    'scheduled_at_date' => 'La data di programmazione non è valida',
    'scheduled_at_after' => 'La data di programmazione deve essere futura',
],
```

### 8. Stati e Categorie Migliorati

```php
'status' => [
    'draft' => 'Bozza',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'opened' => 'Letta',
    'failed' => 'Fallita',
    'bounced' => 'Rimbalzata',
    'complained' => 'Segnalata come spam',
    'cancelled' => 'Annullata',
],

'categories' => [
    'marketing' => 'Marketing',
    'transactional' => 'Transazionale',
    'notification' => 'Notifica',
    'newsletter' => 'Newsletter',
    'system' => 'Sistema',
],
```

## 📋 Validazione e Testing

### 1. Controllo Sintassi PHP
```bash
cd laravel
php -l Modules/Notify/lang/it/send_email.php

# Output: No syntax errors detected
```

### 2. Conformità Best Practice
- ✅ Sintassi array moderna `[]`
- ✅ `declare(strict_types=1);` presente
- ✅ Struttura espansa per tutti i campi
- ✅ Nessuna duplicazione
- ✅ Campi organizzati logicamente
- ✅ Messaggi di validazione completi
- ✅ Helper text diverso da placeholder e description
- ✅ Organizzazione in sezioni logiche

### 3. Controllo PHPStan
```bash
./vendor/bin/phpstan analyze Modules/Notify/lang/it/send_email.php --level=9
```

## 🔗 Collegamenti

### Documentazione Correlata
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Struttura Modulo Notify](./README.md)

### File Modificati
- `laravel/Modules/Notify/lang/it/send_email.php` - File principale migliorato
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione

## 📝 Note di Implementazione

1. **Backward Compatibility**: Le modifiche mantengono compatibilità con il codice esistente
2. **Estensibilità**: La nuova struttura permette facile aggiunta di nuovi campi
3. **Manutenibilità**: Organizzazione logica facilita la manutenzione
4. **Conformità**: Rispetta tutte le convenzioni Laraxot per traduzioni
5. **Struttura Espansa**: Tutti i campi hanno struttura espansa completa
6. **Helper Text**: Nessun helper_text uguale alla chiave dell'array

## 🚀 Prossimi Passi

1. **Testing**: Verificare che tutte le traduzioni funzionino correttamente
2. **Documentazione**: Aggiornare documentazione Filament se necessario
3. **Review**: Code review per verificare conformità standards
4. **Deployment**: Deploy in ambiente di sviluppo per testing

---

**Ultimo aggiornamento**: Gennaio 2025
**Autore**: Sistema di miglioramento automatico
---

## send-email-translation-improvement-2

*Consolidated from: `send-email-translation-improvement.md`*

title: "Miglioramento File Traduzione send_email.php"
type: concept
tags: [send, email, translation, improvement]
created: 2026-07-14
updated: 2026-07-14
qmd: "send-email-translation-improvement-2 miglioramento file traduzione send_email.php"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Miglioramento File Traduzione send_email.php

## 🔍 Analisi del Problema

Il file `laravel/Modules/Notify/lang/it/send_email.php` presenta diversi problemi critici:

### 1. Conflitto di Merge Non Risolto
- Presenza di marcatori 
- Due versioni del file in conflitto
- Sintassi PHP non valida che impedisce l'esecuzione

### 2. Problemi di Struttura
- Uso di sintassi `array()` invece di `[]` moderna
- Mancanza di `declare(strict_types=1);`
- Struttura non espansa per alcuni campi
- Duplicazioni e campi non necessari

### 3. Non Conformità alle Best Practice Laraxot
- Mancanza di struttura espansa per tutti i campi
- Uso di `helper_text` uguale alla chiave dell'array
- Mancanza di organizzazione logica delle sezioni

## 🛠️ Soluzioni Implementate

### 1. Risoluzione Conflitto di Merge

**Prima**:
```php
declare(strict_types=1);

return [
    // Versione HEAD
];
return array (
    // Versione branch trans
);
```

**Dopo**:
```php
<?php

declare(strict_types=1);

return [
    // Struttura unificata e migliorata
];
```

### 2. Modernizzazione Sintassi

**Prima**:
```php
return array (
  'navigation' => 
  array (
    'label' => 'Invio Email',
    // ...
  ),
);
```

**Dopo**:
```php
return [
    'navigation' => [
        'label' => 'Invio Email',
        // ...
    ],
];
```

### 3. Struttura Espansa Completa

**Implementata per tutti i campi**:
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'description' => 'Descrizione dettagliata del campo'
    ]
]
```

### 4. Organizzazione in Sezioni Logiche

```php
'sections' => [
    'email_details' => [
        'label' => 'Dettagli Email',
        'description' => 'Informazioni principali dell\'email',
    ],
    'recipients' => [
        'label' => 'Destinatari',
        'description' => 'Configurazione destinatari e copie',
    ],
    'content' => [
        'label' => 'Contenuto',
        'description' => 'Contenuto dell\'email e template',
    ],
    'attachments' => [
        'label' => 'Allegati',
        'description' => 'File da allegare all\'email',
    ],
    'scheduling' => [
        'label' => 'Programmazione',
        'description' => 'Configurazione invio programmato',
    ],
    'advanced' => [
        'label' => 'Avanzate',
        'description' => 'Opzioni avanzate per l\'invio',
    ],
],
```

### 5. Campi Migliorati e Aggiunti

#### Campi per Programmazione
```php
'scheduled_at' => [
    'label' => 'Data e Ora Programmate',
    'placeholder' => 'Seleziona data e ora per l\'invio programmato',
    'help' => 'Programma l\'invio dell\'email per una data e ora specifiche',
    'description' => 'Data e ora per l\'invio programmato dell\'email',
],
```

#### Configurazione Mittente
```php
'from_email' => [
    'label' => 'Email Mittente',
    'placeholder' => 'mittente@dominio.com',
    'help' => 'Indirizzo email del mittente (se diverso dal default)',
    'description' => 'Indirizzo email del mittente personalizzato',
],
'from_name' => [
    'label' => 'Nome Mittente',
    'placeholder' => 'Nome del mittente',
    'help' => 'Nome visualizzato del mittente (se diverso dal default)',
    'description' => 'Nome visualizzato del mittente personalizzato',
],
```

#### Opzioni Priorità Migliorate
```php
'priority' => [
    'label' => 'Priorità',
    'placeholder' => 'Seleziona la priorità dell\'email',
    'help' => 'Imposta la priorità di invio dell\'email',
    'description' => 'Livello di priorità per l\'invio dell\'email',
    'options' => [
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
],
```

### 6. Azioni Migliorate

```php
'actions' => [
    'send' => [
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo al destinatario',
        'error' => 'Errore nell\'invio dell\'email. Verifica la configurazione.',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
        'tooltip' => 'Invia l\'email al destinatario specificato',
        'modal' => [
            'heading' => 'Conferma Invio Email',
            'description' => 'Stai per inviare un\'email. Questa azione non può essere annullata.',
            'confirm' => 'Invia Email',
            'cancel' => 'Annulla',
        ],
    ],
    'test_smtp' => [
        'label' => 'Test SMTP',
        'success' => 'Test SMTP completato con successo',
        'error' => 'Errore nel test SMTP',
        'tooltip' => 'Testa la configurazione SMTP prima dell\'invio',
        'modal' => [
            'heading' => 'Test Configurazione SMTP',
            'description' => 'Verifica la configurazione SMTP prima dell\'invio',
            'confirm' => 'Esegui Test',
            'cancel' => 'Annulla',
        ],
    ],
],
```

### 7. Messaggi di Validazione Migliorati

```php
'validation' => [
    'subject_required' => 'L\'oggetto dell\'email è obbligatorio',
    'subject_max' => 'L\'oggetto non può superare i 255 caratteri',
    'to_required' => 'Il destinatario è obbligatorio',
    'to_valid' => 'Il destinatario deve essere un indirizzo email valido',
    'to_max' => 'L\'indirizzo email del destinatario è troppo lungo',
    'cc_valid' => 'Gli indirizzi in CC devono essere email valide',
    'cc_max' => 'Uno o più indirizzi in CC sono troppo lunghi',
    'bcc_valid' => 'Gli indirizzi in BCC devono essere email valide',
    'bcc_max' => 'Uno o più indirizzi in BCC sono troppo lunghi',
    'content_required' => 'Il contenuto testuale dell\'email è obbligatorio',
    'content_max' => 'Il contenuto testuale è troppo lungo (max 10000 caratteri)',
    'body_html_max' => 'Il contenuto HTML è troppo lungo (max 20000 caratteri)',
    'template_exists' => 'Il template selezionato non esiste',
    'parameters_required' => 'I parametri sono obbligatori quando si utilizza un template',
    'parameters_json' => 'I parametri devono essere in formato JSON valido',
    'parameters_max' => 'I parametri superano la lunghezza massima consentita',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_valid' => 'La priorità deve essere una delle opzioni disponibili',
    'attachments_max' => 'Numero massimo di allegati consentito: :max',
    'attachments_total_size' => 'La dimensione totale degli allegati supera il limite consentito',
    'file_required' => 'Seleziona un file da allegare',
    'file_size_max' => 'Dimensione massima del file: :max_size',
    'file_type_allowed' => 'Tipo di file non consentito. Tipi supportati: :types',
    'scheduled_at_required' => 'Specifica la data e l\'ora per la programmazione',
    'scheduled_at_date' => 'La data di programmazione non è valida',
    'scheduled_at_after' => 'La data di programmazione deve essere futura',
],
```

### 8. Stati e Categorie Migliorati

```php
'status' => [
    'draft' => 'Bozza',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'opened' => 'Letta',
    'failed' => 'Fallita',
    'bounced' => 'Rimbalzata',
    'complained' => 'Segnalata come spam',
    'cancelled' => 'Annullata',
],

'categories' => [
    'marketing' => 'Marketing',
    'transactional' => 'Transazionale',
    'notification' => 'Notifica',
    'newsletter' => 'Newsletter',
    'system' => 'Sistema',
],
```

## 📋 Validazione e Testing

### 1. Controllo Sintassi PHP
```bash
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/_bases/<nome repository>/laravel
cd /var/www/html/_bases/<nome repository>/laravel
php -l Modules/Notify/lang/it/send_email.php

# Output: No syntax errors detected
```

### 2. Conformità Best Practice
- ✅ Sintassi array moderna `[]`
- ✅ `declare(strict_types=1);` presente
- ✅ Struttura espansa per tutti i campi
- ✅ Nessuna duplicazione
- ✅ Campi organizzati logicamente
- ✅ Messaggi di validazione completi
- ✅ Helper text diverso da placeholder e description
- ✅ Organizzazione in sezioni logiche

### 3. Controllo PHPStan
```bash
./vendor/bin/phpstan analyze Modules/Notify/lang/it/send_email.php --level=9
```

## 🔗 Collegamenti

### Documentazione Correlata
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
- [Struttura Modulo Notify](./README.md)
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Struttura Modulo Notify](./README.md)

### File Modificati
- `laravel/Modules/Notify/lang/it/send_email.php` - File principale migliorato
- `laravel/Modules/Notify/docs/send-email-translation-improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send-email-translation-improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send-email-translation-improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send-email-translation-improvement.md` - Questa documentazione

## 📝 Note di Implementazione

1. **Backward Compatibility**: Le modifiche mantengono compatibilità con il codice esistente
2. **Estensibilità**: La nuova struttura permette facile aggiunta di nuovi campi
3. **Manutenibilità**: Organizzazione logica facilita la manutenzione
4. **Conformità**: Rispetta tutte le convenzioni Laraxot per traduzioni
5. **Struttura Espansa**: Tutti i campi hanno struttura espansa completa
6. **Helper Text**: Nessun helper_text uguale alla chiave dell'array

## 🚀 Prossimi Passi

1. **Testing**: Verificare che tutte le traduzioni funzionino correttamente
2. **Documentazione**: Aggiornare documentazione Filament se necessario
3. **Review**: Code review per verificare conformità standards
4. **Deployment**: Deploy in ambiente di sviluppo per testing

---

**Ultimo aggiornamento**: Gennaio 2025  
**Autore**: Sistema di miglioramento automatico  
---

## send-email-translation-improvement

*Consolidated from: `send-email-translation-improvement.md`*


## 🔍 Analisi del Problema

Il file `laravel/Modules/Notify/lang/it/send_email.php` presenta diversi problemi critici:

### 1. Conflitto di Merge Non Risolto
- Presenza di marcatori
- Due versioni del file in conflitto
- Sintassi PHP non valida che impedisce l'esecuzione

### 2. Problemi di Struttura
- Uso di sintassi `array()` invece di `[]` moderna
- Mancanza di `declare(strict_types=1);`
- Struttura non espansa per alcuni campi
- Duplicazioni e campi non necessari

### 3. Non Conformità alle Best Practice Laraxot
- Mancanza di struttura espansa per tutti i campi
- Uso di `helper_text` uguale alla chiave dell'array
- Mancanza di organizzazione logica delle sezioni

## 🛠️ Soluzioni Implementate

### 1. Risoluzione Conflitto di Merge

**Prima**:
```php
declare(strict_types=1);

return [
    // Versione HEAD
];
return array (
    // Versione branch trans
);
```

**Dopo**:
```php
<?php

declare(strict_types=1);

return [
    // Struttura unificata e migliorata
];
```

### 2. Modernizzazione Sintassi

**Prima**:
```php
return array (
  'navigation' =>
  array (
    'label' => 'Invio Email',
    // ...
  ),
);
```

**Dopo**:
```php
return [
    'navigation' => [
        'label' => 'Invio Email',
        // ...
    ],
];
```

### 3. Struttura Espansa Completa

**Implementata per tutti i campi**:
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'description' => 'Descrizione dettagliata del campo'
    ]
]
```

### 4. Organizzazione in Sezioni Logiche

```php
'sections' => [
    'email_details' => [
        'label' => 'Dettagli Email',
        'description' => 'Informazioni principali dell\'email',
    ],
    'recipients' => [
        'label' => 'Destinatari',
        'description' => 'Configurazione destinatari e copie',
    ],
    'content' => [
        'label' => 'Contenuto',
        'description' => 'Contenuto dell\'email e template',
    ],
    'attachments' => [
        'label' => 'Allegati',
        'description' => 'File da allegare all\'email',
    ],
    'scheduling' => [
        'label' => 'Programmazione',
        'description' => 'Configurazione invio programmato',
    ],
    'advanced' => [
        'label' => 'Avanzate',
        'description' => 'Opzioni avanzate per l\'invio',
    ],
],
```

### 5. Campi Migliorati e Aggiunti

#### Campi per Programmazione
```php
'scheduled_at' => [
    'label' => 'Data e Ora Programmate',
    'placeholder' => 'Seleziona data e ora per l\'invio programmato',
    'help' => 'Programma l\'invio dell\'email per una data e ora specifiche',
    'description' => 'Data e ora per l\'invio programmato dell\'email',
],
```

#### Configurazione Mittente
```php
'from_email' => [
    'label' => 'Email Mittente',
    'placeholder' => 'mittente@dominio.com',
    'help' => 'Indirizzo email del mittente (se diverso dal default)',
    'description' => 'Indirizzo email del mittente personalizzato',
],
'from_name' => [
    'label' => 'Nome Mittente',
    'placeholder' => 'Nome del mittente',
    'help' => 'Nome visualizzato del mittente (se diverso dal default)',
    'description' => 'Nome visualizzato del mittente personalizzato',
],
```

#### Opzioni Priorità Migliorate
```php
'priority' => [
    'label' => 'Priorità',
    'placeholder' => 'Seleziona la priorità dell\'email',
    'help' => 'Imposta la priorità di invio dell\'email',
    'description' => 'Livello di priorità per l\'invio dell\'email',
    'options' => [
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
],
```

### 6. Azioni Migliorate

```php
'actions' => [
    'send' => [
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo al destinatario',
        'error' => 'Errore nell\'invio dell\'email. Verifica la configurazione.',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
        'tooltip' => 'Invia l\'email al destinatario specificato',
        'modal' => [
            'heading' => 'Conferma Invio Email',
            'description' => 'Stai per inviare un\'email. Questa azione non può essere annullata.',
            'confirm' => 'Invia Email',
            'cancel' => 'Annulla',
        ],
    ],
    'test_smtp' => [
        'label' => 'Test SMTP',
        'success' => 'Test SMTP completato con successo',
        'error' => 'Errore nel test SMTP',
        'tooltip' => 'Testa la configurazione SMTP prima dell\'invio',
        'modal' => [
            'heading' => 'Test Configurazione SMTP',
            'description' => 'Verifica la configurazione SMTP prima dell\'invio',
            'confirm' => 'Esegui Test',
            'cancel' => 'Annulla',
        ],
    ],
],
```

### 7. Messaggi di Validazione Migliorati

```php
'validation' => [
    'subject_required' => 'L\'oggetto dell\'email è obbligatorio',
    'subject_max' => 'L\'oggetto non può superare i 255 caratteri',
    'to_required' => 'Il destinatario è obbligatorio',
    'to_valid' => 'Il destinatario deve essere un indirizzo email valido',
    'to_max' => 'L\'indirizzo email del destinatario è troppo lungo',
    'cc_valid' => 'Gli indirizzi in CC devono essere email valide',
    'cc_max' => 'Uno o più indirizzi in CC sono troppo lunghi',
    'bcc_valid' => 'Gli indirizzi in BCC devono essere email valide',
    'bcc_max' => 'Uno o più indirizzi in BCC sono troppo lunghi',
    'content_required' => 'Il contenuto testuale dell\'email è obbligatorio',
    'content_max' => 'Il contenuto testuale è troppo lungo (max 10000 caratteri)',
    'body_html_max' => 'Il contenuto HTML è troppo lungo (max 20000 caratteri)',
    'template_exists' => 'Il template selezionato non esiste',
    'parameters_required' => 'I parametri sono obbligatori quando si utilizza un template',
    'parameters_json' => 'I parametri devono essere in formato JSON valido',
    'parameters_max' => 'I parametri superano la lunghezza massima consentita',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_valid' => 'La priorità deve essere una delle opzioni disponibili',
    'attachments_max' => 'Numero massimo di allegati consentito: :max',
    'attachments_total_size' => 'La dimensione totale degli allegati supera il limite consentito',
    'file_required' => 'Seleziona un file da allegare',
    'file_size_max' => 'Dimensione massima del file: :max_size',
    'file_type_allowed' => 'Tipo di file non consentito. Tipi supportati: :types',
    'scheduled_at_required' => 'Specifica la data e l\'ora per la programmazione',
    'scheduled_at_date' => 'La data di programmazione non è valida',
    'scheduled_at_after' => 'La data di programmazione deve essere futura',
],
```

### 8. Stati e Categorie Migliorati

```php
'status' => [
    'draft' => 'Bozza',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'opened' => 'Letta',
    'failed' => 'Fallita',
    'bounced' => 'Rimbalzata',
    'complained' => 'Segnalata come spam',
    'cancelled' => 'Annullata',
],

'categories' => [
    'marketing' => 'Marketing',
    'transactional' => 'Transazionale',
    'notification' => 'Notifica',
    'newsletter' => 'Newsletter',
    'system' => 'Sistema',
],
```

## 📋 Validazione e Testing

### 1. Controllo Sintassi PHP
```bash
cd laravel
php -l Modules/Notify/lang/it/send_email.php

# Output: No syntax errors detected
```

### 2. Conformità Best Practice
- ✅ Sintassi array moderna `[]`
- ✅ `declare(strict_types=1);` presente
- ✅ Struttura espansa per tutti i campi
- ✅ Nessuna duplicazione
- ✅ Campi organizzati logicamente
- ✅ Messaggi di validazione completi
- ✅ Helper text diverso da placeholder e description
- ✅ Organizzazione in sezioni logiche

### 3. Controllo PHPStan
```bash
./vendor/bin/phpstan analyze Modules/Notify/lang/it/send_email.php --level=9
```

## 🔗 Collegamenti

### Documentazione Correlata
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Struttura Modulo Notify](./README.md)

### File Modificati
- `laravel/Modules/Notify/lang/it/send_email.php` - File principale migliorato
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione

## 📝 Note di Implementazione

1. **Backward Compatibility**: Le modifiche mantengono compatibilità con il codice esistente
2. **Estensibilità**: La nuova struttura permette facile aggiunta di nuovi campi
3. **Manutenibilità**: Organizzazione logica facilita la manutenzione
4. **Conformità**: Rispetta tutte le convenzioni Laraxot per traduzioni
5. **Struttura Espansa**: Tutti i campi hanno struttura espansa completa
6. **Helper Text**: Nessun helper_text uguale alla chiave dell'array

## 🚀 Prossimi Passi

1. **Testing**: Verificare che tutte le traduzioni funzionino correttamente
2. **Documentazione**: Aggiornare documentazione Filament se necessario
3. **Review**: Code review per verificare conformità standards
4. **Deployment**: Deploy in ambiente di sviluppo per testing

---

**Ultimo aggiornamento**: Gennaio 2025
**Autore**: Sistema di miglioramento automatico
# Miglioramento File Traduzione send_email.php

## 🔍 Analisi del Problema

Il file `laravel/Modules/Notify/lang/it/send_email.php` presenta diversi problemi critici:

### 1. Conflitto di Merge Non Risolto
- Presenza di marcatori
- Due versioni del file in conflitto
- Sintassi PHP non valida che impedisce l'esecuzione

### 2. Problemi di Struttura
- Uso di sintassi `array()` invece di `[]` moderna
- Mancanza di `declare(strict_types=1);`
- Struttura non espansa per alcuni campi
- Duplicazioni e campi non necessari

### 3. Non Conformità alle Best Practice Laraxot
- Mancanza di struttura espansa per tutti i campi
- Uso di `helper_text` uguale alla chiave dell'array
- Mancanza di organizzazione logica delle sezioni

## 🛠️ Soluzioni Implementate

### 1. Risoluzione Conflitto di Merge

**Prima**:
```php
declare(strict_types=1);

return [
    // Versione HEAD
];
return array (
    // Versione branch trans
);
```

**Dopo**:
<?php

    // Struttura unificata e migliorata

### 2. Modernizzazione Sintassi

**Prima**:
```php
  'navigation' =>
  array (
    'label' => 'Invio Email',
    // ...
  ),
);
```

**Dopo**:
return [
    'navigation' => [
    ],
];

### 3. Struttura Espansa Completa

**Implementata per tutti i campi**:
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'description' => 'Descrizione dettagliata del campo'
    ]
```

### 4. Organizzazione in Sezioni Logiche

'sections' => [
    'email_details' => [
        'label' => 'Dettagli Email',
        'description' => 'Informazioni principali dell\'email',
    ],
    'recipients' => [
        'label' => 'Destinatari',
        'description' => 'Configurazione destinatari e copie',
    'content' => [
        'label' => 'Contenuto',
        'description' => 'Contenuto dell\'email e template',
    'attachments' => [
        'label' => 'Allegati',
        'description' => 'File da allegare all\'email',
    'scheduling' => [
        'label' => 'Programmazione',
        'description' => 'Configurazione invio programmato',
    ],
    'advanced' => [
        'label' => 'Avanzate',
        'description' => 'Opzioni avanzate per l\'invio',
```

### 5. Campi Migliorati e Aggiunti

#### Campi per Programmazione
```php
'scheduled_at' => [
    'label' => 'Data e Ora Programmate',
    'placeholder' => 'Seleziona data e ora per l\'invio programmato',
    'help' => 'Programma l\'invio dell\'email per una data e ora specifiche',
    'description' => 'Data e ora per l\'invio programmato dell\'email',
],

#### Configurazione Mittente
'from_email' => [
    'label' => 'Email Mittente',
    'placeholder' => 'mittente@dominio.com',
    'help' => 'Indirizzo email del mittente (se diverso dal default)',
    'description' => 'Indirizzo email del mittente personalizzato',
'from_name' => [
    'label' => 'Nome Mittente',
    'placeholder' => 'Nome del mittente',
    'help' => 'Nome visualizzato del mittente (se diverso dal default)',
    'description' => 'Nome visualizzato del mittente personalizzato',
],
```

#### Opzioni Priorità Migliorate
```php
'priority' => [
    'label' => 'Priorità',
    'placeholder' => 'Seleziona la priorità dell\'email',
    'help' => 'Imposta la priorità di invio dell\'email',
    'description' => 'Livello di priorità per l\'invio dell\'email',
    'options' => [
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
```

### 6. Azioni Migliorate

```php
'actions' => [
    'send' => [
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo al destinatario',
        'error' => 'Errore nell\'invio dell\'email. Verifica la configurazione.',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
        'tooltip' => 'Invia l\'email al destinatario specificato',
        'modal' => [
            'heading' => 'Conferma Invio Email',
            'description' => 'Stai per inviare un\'email. Questa azione non può essere annullata.',
            'confirm' => 'Invia Email',
            'cancel' => 'Annulla',
        ],
    'test_smtp' => [
        'label' => 'Test SMTP',
        'success' => 'Test SMTP completato con successo',
        'error' => 'Errore nel test SMTP',
        'tooltip' => 'Testa la configurazione SMTP prima dell\'invio',
        'modal' => [
            'heading' => 'Test Configurazione SMTP',
            'description' => 'Verifica la configurazione SMTP prima dell\'invio',
            'confirm' => 'Esegui Test',
            'cancel' => 'Annulla',
        ],
```

### 7. Messaggi di Validazione Migliorati

```php
'validation' => [
    'subject_required' => 'L\'oggetto dell\'email è obbligatorio',
    'subject_max' => 'L\'oggetto non può superare i 255 caratteri',
    'to_required' => 'Il destinatario è obbligatorio',
    'to_valid' => 'Il destinatario deve essere un indirizzo email valido',
    'to_max' => 'L\'indirizzo email del destinatario è troppo lungo',
    'cc_valid' => 'Gli indirizzi in CC devono essere email valide',
    'cc_max' => 'Uno o più indirizzi in CC sono troppo lunghi',
    'bcc_valid' => 'Gli indirizzi in BCC devono essere email valide',
    'bcc_max' => 'Uno o più indirizzi in BCC sono troppo lunghi',
    'content_required' => 'Il contenuto testuale dell\'email è obbligatorio',
    'content_max' => 'Il contenuto testuale è troppo lungo (max 10000 caratteri)',
    'body_html_max' => 'Il contenuto HTML è troppo lungo (max 20000 caratteri)',
    'template_exists' => 'Il template selezionato non esiste',
    'parameters_required' => 'I parametri sono obbligatori quando si utilizza un template',
    'parameters_json' => 'I parametri devono essere in formato JSON valido',
    'parameters_max' => 'I parametri superano la lunghezza massima consentita',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_valid' => 'La priorità deve essere una delle opzioni disponibili',
    'attachments_max' => 'Numero massimo di allegati consentito: :max',
    'attachments_total_size' => 'La dimensione totale degli allegati supera il limite consentito',
    'file_required' => 'Seleziona un file da allegare',
    'file_size_max' => 'Dimensione massima del file: :max_size',
    'file_type_allowed' => 'Tipo di file non consentito. Tipi supportati: :types',
    'scheduled_at_required' => 'Specifica la data e l\'ora per la programmazione',
    'scheduled_at_date' => 'La data di programmazione non è valida',
    'scheduled_at_after' => 'La data di programmazione deve essere futura',
],
```

### 8. Stati e Categorie Migliorati

```php
'status' => [
    'draft' => 'Bozza',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'opened' => 'Letta',
    'failed' => 'Fallita',
    'bounced' => 'Rimbalzata',
    'complained' => 'Segnalata come spam',
    'cancelled' => 'Annullata',
],

'categories' => [
    'marketing' => 'Marketing',
    'transactional' => 'Transazionale',
    'notification' => 'Notifica',
    'newsletter' => 'Newsletter',
    'system' => 'Sistema',
```

## 📋 Validazione e Testing

### 1. Controllo Sintassi PHP
```bash
cd laravel
php -l Modules/Notify/lang/it/send_email.php

# Output: No syntax errors detected

### 2. Conformità Best Practice
- ✅ Sintassi array moderna `[]`
- ✅ `declare(strict_types=1);` presente
- ✅ Struttura espansa per tutti i campi
- ✅ Nessuna duplicazione
- ✅ Campi organizzati logicamente
- ✅ Messaggi di validazione completi
- ✅ Helper text diverso da placeholder e description
- ✅ Organizzazione in sezioni logiche

### 3. Controllo PHPStan
```bash
./vendor/bin/phpstan analyze Modules/Notify/lang/it/send_email.php --level=9
```

## 🔗 Collegamenti

### Documentazione Correlata
- [Regole Traduzioni Laraxot](../../../../docs/translation-standards.md)
- [Regole Traduzioni Laraxot](../../translation-standards.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Best Practice Filament](../../../../docs/project/FILAMENT-BEST-PRACTICES.md)
- [Best Practice Filament](../../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../../docs/project/translation-standards.md)
- [Struttura Modulo Notify](./README.md)

### File Modificati
- `laravel/Modules/Notify/lang/it/send_email.php` - File principale migliorato
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione

## 📝 Note di Implementazione

1. **Backward Compatibility**: Le modifiche mantengono compatibilità con il codice esistente
2. **Estensibilità**: La nuova struttura permette facile aggiunta di nuovi campi
3. **Manutenibilità**: Organizzazione logica facilita la manutenzione
4. **Conformità**: Rispetta tutte le convenzioni Laraxot per traduzioni
5. **Struttura Espansa**: Tutti i campi hanno struttura espansa completa
6. **Helper Text**: Nessun helper_text uguale alla chiave dell'array

## 🚀 Prossimi Passi

1. **Testing**: Verificare che tutte le traduzioni funzionino correttamente
2. **Documentazione**: Aggiornare documentazione Filament se necessario
3. **Review**: Code review per verificare conformità standards
4. **Deployment**: Deploy in ambiente di sviluppo per testing

---

**Ultimo aggiornamento**: Gennaio 2025
**Autore**: Sistema di miglioramento automatico

---

## send-email-translation

*Consolidated from: `send-email-translation.md`*


## Problemi Identificati

### 1. Conflitti di Merge Non Risolti
- Presenza di marcatori git  nel file
- Codice duplicato e inconsistente

### 2. Sintassi Obsoleta
- Uso di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Struttura Non Espansa
- Campi con struttura semplificata invece di struttura espansa
- Mancanza di `label`, `placeholder`, `help` per alcuni campi

### 4. Campi Mancanti
- Programmazione invio (`scheduled_at`)
- Configurazione mittente (`from_email`, `from_name`)
- Priorità email (`priority`)
- Categoria email (`category`)
- Tracking (`tracking_enabled`)

### 5. Azioni Incomplete
- Messaggi di successo/errore mancanti
- Conferme modali incomplete

### 6. Validazione Incompleta
- Messaggi di validazione specifici mancanti
- Regole di validazione non documentate

## Soluzioni Implementate

### ✅ Struttura Espansa Completa
Ogni campo ora ha la struttura espansa completa:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'description' => 'Descrizione del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto perché diverso da placeholder
],
```

### ✅ Regola Critica: Tooltip e Helper Text
**REGOLA IMPORTANTE**: Ogni campo con `label` e `placeholder` DEVE avere:
- `tooltip`: Informazione aggiuntiva per l'utente
- `helper_text`: Impostato a `''` quando diverso da placeholder

### ✅ Campi Aggiunti
- `sections`: Organizzazione logica dei campi
- `to`, `cc`, `bcc`: Separazione destinatari
- `content`: Contenuto testuale separato da HTML
- `parameters`: Parametri JSON per template
- `priority`: Priorità di invio
- `category`: Categorizzazione email
- `tracking_enabled`: Abilitazione tracking

### ✅ Azioni Migliorate
- Messaggi di successo/errore completi
- Conferme modali con descrizioni dettagliate
- Tooltip per ogni azione

### ✅ Validazione Completa
- Messaggi specifici per ogni regola di validazione
- Validazione per tutti i nuovi campi

## Struttura Finale

### Sezioni Organizzate
1. **Dettagli Email**: Oggetto, template
2. **Destinatari**: To, CC, BCC
3. **Contenuto**: Testo, HTML, parametri
4. **Allegati**: File da allegare
5. **Programmazione**: Invio programmato
6. **Avanzate**: Priorità, categoria, tracking

### Campi Principali
- `subject`: Oggetto email
- `template_id`: Template predefinito
- `to`: Destinatario principale
- `cc`: Copia conoscenza
- `bcc`: Copia nascosta
- `from_email`: Email mittente
- `from_name`: Nome mittente
- `content`: Contenuto testuale
- `body_html`: Contenuto HTML
- `parameters`: Parametri template
- `attachments`: File allegati
- `priority`: Priorità invio
- `scheduled_at`: Programmazione
- `category`: Categoria email
- `tracking_enabled`: Abilita tracking

### Azioni Disponibili
- `send`: Invio immediato
- `preview`: Anteprima email
- `save_draft`: Salva bozza
- `schedule`: Programma invio
- `test_smtp`: Test configurazione

## Conformità Standard

### ✅ Sintassi Moderna
- `declare(strict_types=1);` presente
- Sintassi breve array `[]`
- Tipizzazione corretta

### ✅ Struttura Espansa
- Tutti i campi con struttura completa
- Tooltip e helper_text per ogni campo
- Organizzazione logica in sezioni

### ✅ Completezza
- Tutti i campi necessari presenti
- Azioni complete con messaggi
- Validazione specifica

### ✅ Coerenza
- Naming consistente
- Terminologia uniforme
- Struttura standardizzata

## Collegamenti

- [Documentazione Root](../../docs/translation_standards_links.md)
- [Regole Helper Text](../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)
- [Best Practices Filament](../../docs/filament_translation_best_practices.md)

## Note Importanti

### Regola Critica: Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'tooltip' => 'Informazione aggiuntiva per l\'utente',
'helper_text' => '', // Vuoto se diverso da placeholder
```

### Struttura Espansa Obbligatoria
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```


---

## send-email

*Consolidated from: `send-email.md`*


## 🔍 Analisi del Problema

Il file `SendEmail.php` non funziona correttamente per i seguenti motivi:

1. **Configurazione SMTP Mancante**
   - Non utilizza la configurazione SMTP corretta
   - Manca la gestione delle credenziali

2. **Problemi di Implementazione**
   - Non estende `XotBasePage`
   - Manca la gestione degli errori
   - Non utilizza DTO per i dati

## 🛠️ Soluzione

### 1. Configurazione SMTP

Aggiungere nel file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_from_address
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modifiche al Codice

```php
<?php

namespace Modules\Notify\App\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Modules\Notify\App\Data\EmailData;
use Modules\Notify\App\Data\SmtpData;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Invia Email';
    protected static ?string $title = 'Invia Email';
    protected static ?string $slug = 'send-email';

    public ?EmailData $emailData = null;
    public ?SmtpData $smtpData = null;

    public function mount(): void
    {
        $this->authorize('view', $this);
        $this->emailData = new EmailData();
        $this->smtpData = new SmtpData();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configurazione SMTP')
                    ->schema([
                        Forms\Components\TextInput::make('smtp.host')
                            ->required()
                            ->label('Host SMTP')
                            ->default(config('mail.mailers.smtp.host')),
                        Forms\Components\TextInput::make('smtp.port')
                            ->required()
                            ->numeric()
                            ->label('Porta SMTP')
                            ->default(config('mail.mailers.smtp.port')),
                        Forms\Components\TextInput::make('smtp.username')
                            ->required()
                            ->label('Username SMTP')
                            ->default(config('mail.mailers.smtp.username')),
                        Forms\Components\TextInput::make('smtp.password')
                            ->required()
                            ->password()
                            ->label('Password SMTP')
                            ->default(config('mail.mailers.smtp.password')),
                        Forms\Components\TextInput::make('smtp.encryption')
                            ->label('Crittografia SMTP')
                            ->default(config('mail.mailers.smtp.encryption')),
                    ]),
                Forms\Components\Section::make('Dettagli Email')
                    ->schema([
                        Forms\Components\TextInput::make('email.to')
                            ->required()
                            ->email()
                            ->label('Destinatario'),
                        Forms\Components\TextInput::make('email.subject')
                            ->required()
                            ->label('Oggetto'),
                        Forms\Components\RichEditor::make('email.body')
                            ->required()
                            ->label('Corpo Email'),
                    ]),
            ]);
    }

    public function sendEmail(): void
    {
        try {
            $data = $this->form->getState();
            
            // Configura SMTP
            config([
                'mail.mailers.smtp.host' => $data['smtp']['host'],
                'mail.mailers.smtp.port' => $data['smtp']['port'],
                'mail.mailers.smtp.username' => $data['smtp']['username'],
                'mail.mailers.smtp.password' => $data['smtp']['password'],
                'mail.mailers.smtp.encryption' => $data['smtp']['encryption'],
            ]);

            // Crea DTO
            $smtpData = SmtpData::from($data['smtp']);
            $emailData = EmailData::from($data['email']);

            // Invia email
            $smtpData->send($emailData);

            Notification::make()
                ->success()
                ->title('Email inviata con successo')
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Errore nell\'invio dell\'email')
                ->body($e->getMessage())
                ->send();
        }
    }
}
```

### 3. Creazione DTO

Creare i file DTO necessari:

```php
// app/Data/EmailData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class EmailData extends Data
{
    public function __construct(
        public string $to,
        public string $subject,
        public string $body,
    ) {
    }
}

// app/Data/SmtpData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class SmtpData extends Data
{
    public function __construct(
        public string $host,
        public int $port,
        public string $username,
        public string $password,
        public ?string $encryption = null,
    ) {
    }

    public function send(EmailData $emailData): void
    {
        // Implementare la logica di invio
        // Utilizzare Mail::to()->send() o un servizio SMTP
    }
}
```

## 📋 Checklist di Verifica

1. **Configurazione**
   - [ ] File `.env` configurato correttamente
   - [ ] Credenziali SMTP valide
   - [ ] Configurazione mail in `config/mail.php`

2. **Implementazione**
   - [ ] DTO creati e configurati
   - [ ] Form implementato correttamente
   - [ ] Gestione errori implementata
   - [ ] Notifiche configurate

3. **Test**
   - [ ] Test connessione SMTP
   - [ ] Test invio email
   - [ ] Verifica feedback utente
   - [ ] Controllo log errori

## 🔗 Collegamenti Utili

- [Documentazione Laravel Mail](https://laravel.com/project_docs/mail)
- [Documentazione Filament Forms](https://filamentphp.com/project_docs/forms)
- [Best Practices SMTP](https://laravel.com/project_docs/mail#smtp-configuration)
- [Documentazione Laravel Mail](https://laravel.com/docs/mail)
- [Documentazione Filament Forms](https://filamentphp.com/docs/forms)
- [Best Practices SMTP](https://laravel.com/docs/mail#smtp-configuration)

## ⚠️ Note Importanti

1. **Sicurezza**
   - Non committare mai le credenziali SMTP
   - Utilizzare variabili d'ambiente
   - Implementare rate limiting

2. **Performance**
   - Implementare coda per email
   - Gestire timeout
   - Monitorare utilizzo risorse

3. **Manutenzione**
   - Aggiornare regolarmente le dipendenze
   - Monitorare log errori
   - Verificare configurazione SMTP 
---

## send-notification-bulk-action

*Consolidated from: `send-notification-bulk-action.md`*


**Status**: ✅ Implementazione completata e PHPStan Level 10 compliant  
**Module**: Notify

## Overview

`SendNotificationBulkAction` è la BulkAction Filament riutilizzabile che permette di inviare notifiche a più record contemporaneamente utilizzando template MailTemplate e canali multipli (Email, SMS, WhatsApp).  
Dal 2025‑12‑18 la catena interna è stata ulteriormente semplificata:

```
Filament Bulk Action (UI) ──► SendRecordsNotificationBulkAction (queueable, multi-record)
                                      │
                                      └─► SendRecordNotificationAction (single record, multi-channel)
```

Questo significa:
- naming coerente: `SendRecordsNotificationBulkAction` per la parte bulk, `SendRecordNotificationAction` per la parte single record;
- DRY assoluto: tutta la logica di invio (normalizzazione numeri, estrazione contatti, gestione templating) vive nella action single record e viene riutilizzata dalla bulk;
- queue-friendly: entrambe le action sono stateless e risolvono le dipendenze solo quando servono tramite `app()`.

## Architettura

### Separazione delle Responsabilità

L'implementazione segue il principio di separazione tra UI (Filament) e business logic (Spatie Actions):

```
┌─────────────────────────────────────┐
│ SendNotificationBulkAction          │
│ (Filament BulkAction)               │
│ - Gestisce UI e form modal          │
│ - Validazione input utente          │
│ - Notifiche di risultato            │
└──────────────┬──────────────────────┘
               │ DELEGA
               ▼
┌─────────────────────────────────────┐
│ SendRecordsNotificationBulkAction   │
│ (Spatie QueueableAction)            │
│ - Orchestrazione bulk               │
│ - Aggregazione risultati            │
│ - Gestione errori aggregati         │
└──────────────┬──────────────────────┘
               │ COMPONE
               ▼
┌─────────────────────────────────────┐
│ SendRecordNotificationAction        │
│ (Spatie QueueableAction)            │
│ - Logica business invio notifica    │
│ - Gestione canali multipli          │
│ - Estrazione email/phone/whatsapp   │
│ - Normalizzazione telefoni          │
└──────────────┬──────────────────────┘
               │ USA
               ▼
┌─────────────────────────────────────┐
│ RecordNotification                  │
│ WhatsAppNotification                │
│ (Laravel Notification)              │
│ - Generazione contenuto da template │
│ - Invio via Notification::route()   │
└─────────────────────────────────────┘
```

## Componenti

### 1. SendRecordsNotificationBulkAction (Spatie QueueableAction)

**File**: `Modules/Notify/app/Actions/SendRecordsNotificationBulkAction.php`

**Responsabilità**:
- **Orchestrazione bulk**: Riceve una collection di record e itera su ognuno
- **Composizione DRY**: Per ogni record, compone `SendRecordNotificationAction` (singolo record)
- **Aggregazione risultati**: Converte i risultati della single-action in `SendNotificationBulkResultData`
- **Gestione errori**: Cattura eccezioni e gestisce fallimenti silenziosi

**Pattern DRY**: Questa Action **non duplica** la logica di invio. Compone semplicemente `SendRecordNotificationAction` per ogni record, seguendo il principio "Single Responsibility" e "Don't Repeat Yourself".

**Pattern simile**: `SendMailByRecordsAction` che compone `SendMailByRecordAction`.

**Metodo principale**:
```php
public function execute(
    Collection $records,
    string $templateSlug,
    array $channels
): SendNotificationBulkResultData
```

**Canali supportati**:
- **mail**: Usa `RecordNotification` con `Notification::route('mail', $email)`
- **sms**: Usa `RecordNotification` con `Notification::route('sms', $phone)`
- **whatsapp**: Usa `WhatsAppNotification` con `Notification::route('whatsapp', $whatsapp)` e contenuto estratto da `SpatieEmail::buildSms()`

**Estrazione contatti**: Gestita da `SendRecordNotificationAction` con pattern DRY:
- Metodo generico `extractRecordAttribute()` elimina duplicazione tra `getRecordEmail()`, `getRecordPhone()`, `getRecordWhatsApp()`
- Email: Cerca attributi `email`, `pec`, `contact_email` (convalidati come email valide tramite validator custom)
- Phone: Cerca attributi `mobile`, `phone`, `telephone`, `contact_phone`
- WhatsApp: Cerca attributo `whatsapp`, con fallback su phone
- Vedi: [Contact Extraction Pattern](./contact-extraction-pattern.md) per dettagli implementazione DRY
- Vedi: [Contact Extraction Pattern](../../contact-extraction-pattern.md) per dettagli implementazione DRY

**Pattern DRY - Composizione**:
- **Questa bulk action compone** `SendRecordNotificationAction` per ogni record
- **Zero duplicazione**: La logica di estrazione contatti e invio è solo in `SendRecordNotificationAction`
- Pattern `app()`: Usa `app(SendRecordNotificationAction::class)->execute()` dentro `execute()`
- Vedi: [DRY Composition Pattern](./dry-composition-pattern.md)
- Vedi: [DRY Composition Pattern](../../dry-composition-pattern.md)

### 2. SendNotificationBulkAction (Filament BulkAction)

**File**: `Modules/Notify/app/Filament/Actions/SendNotificationBulkAction.php`

**Responsabilità**:
- Fornisce UI modal per selezione template e canali
- Valida input utente
- Chiama `SendRecordsNotificationBulkAction` (nota: nome plurale "Records")
- Mostra notifiche di successo/errore all'utente

**Estende**: `XotBaseBulkAction` (che estende `Filament\Actions\BulkAction`)

**Form Schema**:
- `template_slug`: Select con slug e nome di MailTemplate, searchable, preload
- `channels`: CheckboxList con opzioni mail, sms, whatsapp (minimo 1 richiesto)

### 3. SendRecordNotificationAction (Spatie QueueableAction)

**File**: `Modules/Notify/app/Actions/SendRecordNotificationAction.php`

**Responsabilità**:
- Invia la notifica a **un singolo record** su uno o più canali
- Risolve email/phone/whatsapp occupandosi di normalizzazione (es. `NormalizePhoneNumberAction`)
- Usa sempre `RecordNotification` (mail/sms) o `WhatsAppNotification` con contenuto derivato da `SpatieEmail`

> L'intera logica di invio vive qui: la bulk action non duplica nulla, semplicemente la richiama per ogni record.

### 4. SendNotificationBulkResultData (Spatie Data)

**File**: `Modules/Notify/app/Datas/SendNotificationBulkResultData.php`

**Proprietà**:
- `successCount`: int - Numero di notifiche inviate con successo
- `errorCount`: int - Numero di errori
- `errors`: Collection<int, array{record: string, channel: string, error: string}> - Dettagli errori
- `totalProcessed`: int - Totale operazioni (record × canali)

## Utilizzo

### In una ListRecords Page

```php
use Modules\Notify\Filament\Actions\SendNotificationBulkAction;

public function getTableBulkActions(): array
{
    return [
        'sendNotifications' => SendNotificationBulkAction::make(),
        // altre azioni...
    ];
}
```

### Workflow Utente

1. L'utente seleziona uno o più record nella tabella
2. Clicca su "Invia notifiche" (BulkAction)
3. Si apre un modal con:
   - Select per template (ricercabile)
   - CheckboxList per canali (mail, sms, whatsapp)
4. L'utente seleziona template e canali
5. Clicca "Invia"
6. Sistema mostra notifiche:
   - Successo: "Inviate X notifiche su Y con successo"
   - Errori: Dettagli per ogni record/canale fallito

## Pattern di Invio

### Email
```php
$recordNotification = new RecordNotification($record, $templateSlug);
Notification::route('mail', $email)->notify($recordNotification);
```

### SMS
```php
$recordNotification = new RecordNotification($record, $templateSlug);
$normalizedPhone = app(NormalizePhoneNumberAction::class)->execute($phone);
Notification::route('sms', $normalizedPhone)->notify($recordNotification);
```

### WhatsApp
```php
$spatieEmail = new SpatieEmail($record, $templateSlug);
$message = $spatieEmail->buildSms(); // Estrae contenuto testuale dal template
$normalizedWhatsApp = app(NormalizePhoneNumberAction::class)->execute($whatsapp);
$whatsappNotification = new WhatsAppNotification($message, ['to' => $normalizedWhatsApp]);
Notification::route('whatsapp', $normalizedWhatsApp)->notify($whatsappNotification);
```

### Strategia di risoluzione delle dipendenze (NormalizePhoneNumberAction)

- **Motivazione**: `SendRecordsNotificationBulkAction` usa `QueueableAction`, quindi può essere serializzata e accodata. Iniettare `NormalizePhoneNumberAction` nel costruttore renderebbe la serializzazione fragile (dipendenza non serializzabile) e violerebbe la filosofia Laraxot *"un solo punto di verità"* per la risoluzione runtime.
- **Politica**: risolviamo il normalizzatore con `app(NormalizePhoneNumberAction::class)` esattamente dove serve (`sendSms`, `sendWhatsApp`). In questo modo l'azione rimane stateless, idempotente e compatibile con i job queue.
- **Strategia**: se in futuro servirà un normalizzatore diverso basterà aggiornare l'IoC container senza toccare l'azione. Nessun constructor injection significa meno lock‑in e più libertà di override a livello di modulo/tenant.
- **Zen**: le queueable actions devono essere leggere come piume; niente proprietà pesanti, solo dipendenze risolte al bisogno.

## Traduzioni

**File**: `Modules/Notify/lang/it/actions.php`

Struttura completa con:
- Label azione
- Form fields (template_slug, channels)
- Errori per canale non supportato, email/phone/whatsapp non disponibili
- Notifiche di successo/errore

## Error Handling

- **Email non disponibile**: Eccezione con messaggio localizzato
- **Phone non disponibile**: Eccezione con messaggio localizzato
- **WhatsApp non disponibile**: Eccezione con messaggio localizzato
- **Canale non supportato**: Eccezione con messaggio localizzato
- **Errori invio**: Loggati con contesto completo, inclusi nel risultato

Tutti gli errori vengono raccolti e mostrati all'utente tramite notifica Filament.

## Filosofia e Principi

### DRY (Don't Repeat Yourself)
- Una sola implementazione riutilizzabile in tutto il progetto
- Nessuna duplicazione di logica di invio notifiche

### KISS (Keep It Simple, Stupid)
- Modal semplice con 2 campi (template + canali)
- Logica chiara e diretta

### Separation of Concerns
- UI separata da business logic
- Azione riutilizzabile in qualsiasi contesto

### Single Responsibility
- Ogni componente ha una responsabilità ben definita
- Facile da testare e mantenere

## Integrazione in App

**File**: `app/Filament/Resources/ClientResource/Pages/ListClients.php`
## Integrazione in TechPlanner

**File**: `Modules/TechPlanner/app/Filament/Resources/ClientResource/Pages/ListClients.php`

```php
public function getTableBulkActions(): array
{
    return [
        'updateCoordinates' => UpdateCoordinatesBulkAction::make(),
        'sendNotifications' => SendNotificationBulkAction::make(),
    ];
}
```

L'azione è completamente riutilizzabile e può essere aggiunta a qualsiasi Resource Filament che gestisce modelli con proprietà per contatti (email, phone, whatsapp).

## Requisiti Modello

I modelli target devono avere almeno una di queste proprietà:

**Email**:
- `email` (validato come email)
- `pec` (validato come email)
- `contact_email` (validato come email)

**Phone**:
- `mobile`
- `phone`
- `telephone`
- `contact_phone`

**WhatsApp**:
- `whatsapp` (con fallback su phone)

## Estendibilità

L'azione è progettata per essere facilmente estendibile:

- **Nuovi canali**: Aggiungere case nel match statement di `sendNotificationToRecord()`
- **Nuovi attributi contatto**: Aggiungere alla lista di attributi cercati nei metodi `getRecord*()`
- **Validazioni personalizzate**: Estendere `SendRecordNotificationAction` per modificare la logica di invio singolo, che automaticamente si riflette nella bulk

## Pattern DRY: Composizione Actions

### Filosofia

Questa Action segue il pattern **DRY (Don't Repeat Yourself)** composendo `SendRecordNotificationAction` invece di duplicare la logica:

- **SendRecordNotificationAction**: Gestisce invio a UN singolo record (mail, sms, whatsapp)
- **SendRecordsNotificationBulkAction**: Gestisce orchestrazione per più record, compone `SendRecordNotificationAction`

**Pattern simile**: `SendMailByRecordsAction` che compone `SendMailByRecordAction`.

### Composizione nel Codice

```php
// In SendRecordsNotificationBulkAction
$singleRecordAction = app(SendRecordNotificationAction::class);
$singleRecordAction->execute($record, $templateSlug, [$channel]);
```

**Vantaggi**:
- **DRY**: Logica di invio in un solo punto
- **KISS**: Bulk Action semplice, solo orchestrazione
- **Single Responsibility**: Ogni Action ha uno scopo chiaro
- **Testabilità**: Testare single Action separatamente dalla bulk

Vedi: [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md)

## Backlink e Collegamenti

- [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md) - Pattern per Actions che chiamano altre Actions
- [Notification System Architecture](./notification-implementation.md)
- [MailTemplate Model](./models.md#mailtemplate)
- [RecordNotification Class](../../app/Notifications/RecordNotification.php)
- [App Client Management](../App/docs/README.md#client-management)
- [TechPlanner Client Management](../TechPlanner/docs/README.md#client-management)
- [Geo Module Reusable Components Philosophy](../geo/docs/reusable-components-philosophy.md)
Vedi: [Actions Calling Actions Pattern](../../actions-calling-actions-pattern.md)

## Backlink e Collegamenti

- [Actions Calling Actions Pattern](../../actions-calling-actions-pattern.md) - Pattern per Actions che chiamano altre Actions
- [Notification System Architecture](../../notification-implementation.md)
- [MailTemplate Model](./models.md#mailtemplate)
- [RecordNotification Class](../../../app/Notifications/RecordNotification.php)
- [App Client Management](../App/docs/README.md#client-management)
- [TechPlanner Client Management](../TechPlanner/docs/README.md#client-management)
- [Geo Module Reusable Components Philosophy](../../../../Geo/docs/reusable-components-philosophy.md)
- [Xot Filament Class Extension Rules](../xot/docs/filament-class-extension-rules.md)

---

**Ultimo aggiornamento**: [DATE]  
**PHPStan Level**: ✅ 10  
**Quality**: ✅ PHPMD, PHPInsights compliant

---

## send-push-notification-conflict-resolution

*Consolidated from: `send-push-notification-conflict-resolution.md`*


## Intent
- Garantire robustezza e validazione rigorosa dei dati in ingresso, adottando un approccio fail‑fast per prevenire malfunzionamenti in caso di dati mancanti o malformati.

## Cosa
- Consolidamento delle importazioni Firebase, mantenendo solo le classi essenziali per l’invio delle notifiche.
- Validazioni esplicite sugli oggetti e sulle proprietà (profilo, token, device) per prevenire eccezioni a runtime.
- Filtro semplificato e affidabile dei dispositivi attivi.

## Collegamenti
- Documentazione principale: [Ris. conflitti Git - Modulo Notify](../../../docs/risoluzione_conflitti_git.md#modulo-notify)

---

## send-push-notification-resolution

*Consolidated from: `send-push-notification-resolution.md`*


## Intent
- Garantire robustezza e validazione rigorosa dei dati in ingresso, adottando un approccio fail‑fast per prevenire malfunzionamenti in caso di dati mancanti o malformati.

## Cosa
- Consolidamento delle importazioni Firebase, mantenendo solo le classi essenziali per l’invio delle notifiche.
- Validazioni esplicite sugli oggetti e sulle proprietà (profilo, token, device) per prevenire eccezioni a runtime.
- Filtro semplificato e affidabile dei dispositivi attivi.

## Collegamenti
- Documentazione principale: [Ris. conflitti Git - Modulo Notify](../../../../docs/risoluzione_conflitti_git.md#modulo-notify)

---

## send-record-notification-action-refactoring

*Consolidated from: `send-record-notification-action-refactoring.md`*


**Date**: 18 Dicembre 2025  
**Status**: ✅ Refactoring Completed  
**Module**: Notify  
**Focus**: DRY + KISS + Clean Code Principles

## Overview

This document describes the refactoring of `SendRecordNotificationAction` to eliminate code duplication and improve maintainability by applying DRY (Don't Repeat Yourself) and KISS (Keep It Simple, Stupid) principles.

## Identified Duplications

### 1. Contact Information Retrieval
- `getRecordEmail()`, `getRecordPhone()`, and `getRecordWhatsApp()` methods followed the same pattern:
  - Iterate through attribute candidates
  - Check if attribute exists using `$record->offsetExists()`
  - Validate attribute value
  - Return first valid match

### 2. Notification Sending Pattern
- `sendMail()` and `sendSms()` methods contained similar logic:
  - Get contact info from record
  - Validate contact info availability
  - Create `RecordNotification` instance
  - Send via `Notification::route()`

The `sendWhatsApp()` method was slightly different but still shared the core notification pattern.

## Refactoring Strategy

### Applied Patterns
1. **Generic Contact Retrieval**: Created `extractRecordAttribute()` method to eliminate attribute lookup duplication
2. **Unified Notification Sending**: Created `sendGenericNotification()` method for common notification logic
3. **Parameterized Logic**: Used configuration parameters instead of hardcoded attribute lists

### Benefits Achieved
- Reduced code duplication significantly
- Improved maintainability - changes to notification logic only need to be made in one place
- Enhanced testability - smaller, focused methods
- Better adherence to DRY principle
- Simpler extension for new notification channels

## Before vs After Metrics

### Before Refactoring
- Lines of Code: ~150
- Method repetition: 3 similar notification methods (with 2 nearly identical)
- Attribute lookup duplication: 3 similar lookup methods

### After Refactoring  
- Lines of Code: ~140 (slightly reduced due to better organization)
- Method repetition: Eliminated through `extractRecordAttribute()` and `sendGenericNotification()` abstractions
- Attribute lookup: Unified through generic approach
- Maintainability: Significantly improved

## Architecture Compliance

✅ **QueueableAction Pattern**: Maintained proper action structure  
✅ **Error Handling**: Preserved comprehensive exception handling  
✅ **Type Safety**: Maintained strict typing throughout  
✅ **Backward Compatibility**: Public interface unchanged  
✅ **Laraxot Philosophy**: Follows established architectural patterns

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
---

## send_email_fix

*Consolidated from: `send_email_fix.md`*


## 🔍 Analisi del Problema

Il file `SendEmail.php` non funziona correttamente per i seguenti motivi:

1. **Configurazione SMTP Mancante**
   - Non utilizza la configurazione SMTP corretta
   - Manca la gestione delle credenziali

2. **Problemi di Implementazione**
   - Non estende `XotBasePage`
   - Manca la gestione degli errori
   - Non utilizza DTO per i dati

## 🛠️ Soluzione

### 1. Configurazione SMTP

Aggiungere nel file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_from_address
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modifiche al Codice

```php
<?php

namespace Modules\Notify\App\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Modules\Notify\App\Data\EmailData;
use Modules\Notify\App\Data\SmtpData;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Invia Email';
    protected static ?string $title = 'Invia Email';
    protected static ?string $slug = 'send-email';

    public ?EmailData $emailData = null;
    public ?SmtpData $smtpData = null;

    public function mount(): void
    {
        $this->authorize('view', $this);
        $this->emailData = new EmailData();
        $this->smtpData = new SmtpData();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configurazione SMTP')
                    ->schema([
                        Forms\Components\TextInput::make('smtp.host')
                            ->required()
                            ->label('Host SMTP')
                            ->default(config('mail.mailers.smtp.host')),
                        Forms\Components\TextInput::make('smtp.port')
                            ->required()
                            ->numeric()
                            ->label('Porta SMTP')
                            ->default(config('mail.mailers.smtp.port')),
                        Forms\Components\TextInput::make('smtp.username')
                            ->required()
                            ->label('Username SMTP')
                            ->default(config('mail.mailers.smtp.username')),
                        Forms\Components\TextInput::make('smtp.password')
                            ->required()
                            ->password()
                            ->label('Password SMTP')
                            ->default(config('mail.mailers.smtp.password')),
                        Forms\Components\TextInput::make('smtp.encryption')
                            ->label('Crittografia SMTP')
                            ->default(config('mail.mailers.smtp.encryption')),
                    ]),
                Forms\Components\Section::make('Dettagli Email')
                    ->schema([
                        Forms\Components\TextInput::make('email.to')
                            ->required()
                            ->email()
                            ->label('Destinatario'),
                        Forms\Components\TextInput::make('email.subject')
                            ->required()
                            ->label('Oggetto'),
                        Forms\Components\RichEditor::make('email.body')
                            ->required()
                            ->label('Corpo Email'),
                    ]),
            ]);
    }

    public function sendEmail(): void
    {
        try {
            $data = $this->form->getState();
            
            // Configura SMTP
            config([
                'mail.mailers.smtp.host' => $data['smtp']['host'],
                'mail.mailers.smtp.port' => $data['smtp']['port'],
                'mail.mailers.smtp.username' => $data['smtp']['username'],
                'mail.mailers.smtp.password' => $data['smtp']['password'],
                'mail.mailers.smtp.encryption' => $data['smtp']['encryption'],
            ]);

            // Crea DTO
            $smtpData = SmtpData::from($data['smtp']);
            $emailData = EmailData::from($data['email']);

            // Invia email
            $smtpData->send($emailData);

            Notification::make()
                ->success()
                ->title('Email inviata con successo')
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Errore nell\'invio dell\'email')
                ->body($e->getMessage())
                ->send();
        }
    }
}
```

### 3. Creazione DTO

Creare i file DTO necessari:

```php
// app/Data/EmailData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class EmailData extends Data
{
    public function __construct(
        public string $to,
        public string $subject,
        public string $body,
    ) {
    }
}

// app/Data/SmtpData.php
<?php

namespace Modules\Notify\App\Data;

use Spatie\LaravelData\Data;

class SmtpData extends Data
{
    public function __construct(
        public string $host,
        public int $port,
        public string $username,
        public string $password,
        public ?string $encryption = null,
    ) {
    }

    public function send(EmailData $emailData): void
    {
        // Implementare la logica di invio
        // Utilizzare Mail::to()->send() o un servizio SMTP
    }
}
```

## 📋 Checklist di Verifica

1. **Configurazione**
   - [ ] File `.env` configurato correttamente
   - [ ] Credenziali SMTP valide
   - [ ] Configurazione mail in `config/mail.php`

2. **Implementazione**
   - [ ] DTO creati e configurati
   - [ ] Form implementato correttamente
   - [ ] Gestione errori implementata
   - [ ] Notifiche configurate

3. **Test**
   - [ ] Test connessione SMTP
   - [ ] Test invio email
   - [ ] Verifica feedback utente
   - [ ] Controllo log errori

## 🔗 Collegamenti Utili

- [Documentazione Laravel Mail](https://laravel.com/project_docs/mail)
- [Documentazione Filament Forms](https://filamentphp.com/project_docs/forms)
- [Best Practices SMTP](https://laravel.com/project_docs/mail#smtp-configuration)

## ⚠️ Note Importanti

1. **Sicurezza**
   - Non committare mai le credenziali SMTP
   - Utilizzare variabili d'ambiente
   - Implementare rate limiting

2. **Performance**
   - Implementare coda per email
   - Gestire timeout
   - Monitorare utilizzo risorse

3. **Manutenzione**
   - Aggiornare regolarmente le dipendenze
   - Monitorare log errori
   - Verificare configurazione SMTP 
---

## send_email_translation_fix

*Consolidated from: `send_email_translation_fix.md`*


## Problemi Identificati

### 1. Conflitti di Merge Non Risolti
- Presenza di marcatori git  nel file
- Codice duplicato e inconsistente

### 2. Sintassi Obsoleta
- Uso di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Struttura Non Espansa
- Campi con struttura semplificata invece di struttura espansa
- Mancanza di `label`, `placeholder`, `help` per alcuni campi

### 4. Campi Mancanti
- Programmazione invio (`scheduled_at`)
- Configurazione mittente (`from_email`, `from_name`)
- Priorità email (`priority`)
- Categoria email (`category`)
- Tracking (`tracking_enabled`)

### 5. Azioni Incomplete
- Messaggi di successo/errore mancanti
- Conferme modali incomplete

### 6. Validazione Incompleta
- Messaggi di validazione specifici mancanti
- Regole di validazione non documentate

## Soluzioni Implementate

### ✅ Struttura Espansa Completa
Ogni campo ora ha la struttura espansa completa:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'description' => 'Descrizione del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto perché diverso da placeholder
],
```

### ✅ Regola Critica: Tooltip e Helper Text
**REGOLA IMPORTANTE**: Ogni campo con `label` e `placeholder` DEVE avere:
- `tooltip`: Informazione aggiuntiva per l'utente
- `helper_text`: Impostato a `''` quando diverso da placeholder

### ✅ Campi Aggiunti
- `sections`: Organizzazione logica dei campi
- `to`, `cc`, `bcc`: Separazione destinatari
- `content`: Contenuto testuale separato da HTML
- `parameters`: Parametri JSON per template
- `priority`: Priorità di invio
- `category`: Categorizzazione email
- `tracking_enabled`: Abilitazione tracking

### ✅ Azioni Migliorate
- Messaggi di successo/errore completi
- Conferme modali con descrizioni dettagliate
- Tooltip per ogni azione

### ✅ Validazione Completa
- Messaggi specifici per ogni regola di validazione
- Validazione per tutti i nuovi campi

## Struttura Finale

### Sezioni Organizzate
1. **Dettagli Email**: Oggetto, template
2. **Destinatari**: To, CC, BCC
3. **Contenuto**: Testo, HTML, parametri
4. **Allegati**: File da allegare
5. **Programmazione**: Invio programmato
6. **Avanzate**: Priorità, categoria, tracking

### Campi Principali
- `subject`: Oggetto email
- `template_id`: Template predefinito
- `to`: Destinatario principale
- `cc`: Copia conoscenza
- `bcc`: Copia nascosta
- `from_email`: Email mittente
- `from_name`: Nome mittente
- `content`: Contenuto testuale
- `body_html`: Contenuto HTML
- `parameters`: Parametri template
- `attachments`: File allegati
- `priority`: Priorità invio
- `scheduled_at`: Programmazione
- `category`: Categoria email
- `tracking_enabled`: Abilita tracking

### Azioni Disponibili
- `send`: Invio immediato
- `preview`: Anteprima email
- `save_draft`: Salva bozza
- `schedule`: Programma invio
- `test_smtp`: Test configurazione

## Conformità Standard

### ✅ Sintassi Moderna
- `declare(strict_types=1);` presente
- Sintassi breve array `[]`
- Tipizzazione corretta

### ✅ Struttura Espansa
- Tutti i campi con struttura completa
- Tooltip e helper_text per ogni campo
- Organizzazione logica in sezioni

### ✅ Completezza
- Tutti i campi necessari presenti
- Azioni complete con messaggi
- Validazione specifica

### ✅ Coerenza
- Naming consistente
- Terminologia uniforme
- Struttura standardizzata

## Collegamenti

- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)

## Note Importanti

### Regola Critica: Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'tooltip' => 'Informazione aggiuntiva per l\'utente',
'helper_text' => '', // Vuoto se diverso da placeholder
```

### Struttura Espansa Obbligatoria
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```

*Ultimo aggiornamento: 2025-01-06* 

---

## send_email_translation_improvement

*Consolidated from: `send_email_translation_improvement.md`*


## 🔍 Analisi del Problema

Il file `laravel/Modules/Notify/lang/it/send_email.php` presenta diversi problemi critici:

### 1. Conflitto di Merge Non Risolto
- Presenza di marcatori
- Presenza di marcatori 
- Due versioni del file in conflitto
- Sintassi PHP non valida che impedisce l'esecuzione

### 2. Problemi di Struttura
- Uso di sintassi `array()` invece di `[]` moderna
- Mancanza di `declare(strict_types=1);`
- Struttura non espansa per alcuni campi
- Duplicazioni e campi non necessari

### 3. Non Conformità alle Best Practice Laraxot
- Mancanza di struttura espansa per tutti i campi
- Uso di `helper_text` uguale alla chiave dell'array
- Mancanza di organizzazione logica delle sezioni

## 🛠️ Soluzioni Implementate

### 1. Risoluzione Conflitto di Merge

**Prima**:
```php
declare(strict_types=1);

return [
    // Versione HEAD
];
return array (
    // Versione branch trans
);
```

**Dopo**:
```php
<?php

declare(strict_types=1);

return [
    // Struttura unificata e migliorata
];
```

### 2. Modernizzazione Sintassi

**Prima**:
```php
return array (
  'navigation' =>
  'navigation' => 
  array (
    'label' => 'Invio Email',
    // ...
  ),
);
```

**Dopo**:
```php
return [
    'navigation' => [
        'label' => 'Invio Email',
        // ...
    ],
];
```

### 3. Struttura Espansa Completa

**Implementata per tutti i campi**:
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'description' => 'Descrizione dettagliata del campo'
    ]
]
```

### 4. Organizzazione in Sezioni Logiche

```php
'sections' => [
    'email_details' => [
        'label' => 'Dettagli Email',
        'description' => 'Informazioni principali dell\'email',
    ],
    'recipients' => [
        'label' => 'Destinatari',
        'description' => 'Configurazione destinatari e copie',
    ],
    'content' => [
        'label' => 'Contenuto',
        'description' => 'Contenuto dell\'email e template',
    ],
    'attachments' => [
        'label' => 'Allegati',
        'description' => 'File da allegare all\'email',
    ],
    'scheduling' => [
        'label' => 'Programmazione',
        'description' => 'Configurazione invio programmato',
    ],
    'advanced' => [
        'label' => 'Avanzate',
        'description' => 'Opzioni avanzate per l\'invio',
    ],
],
```

### 5. Campi Migliorati e Aggiunti

#### Campi per Programmazione
```php
'scheduled_at' => [
    'label' => 'Data e Ora Programmate',
    'placeholder' => 'Seleziona data e ora per l\'invio programmato',
    'help' => 'Programma l\'invio dell\'email per una data e ora specifiche',
    'description' => 'Data e ora per l\'invio programmato dell\'email',
],
```

#### Configurazione Mittente
```php
'from_email' => [
    'label' => 'Email Mittente',
    'placeholder' => 'mittente@dominio.com',
    'help' => 'Indirizzo email del mittente (se diverso dal default)',
    'description' => 'Indirizzo email del mittente personalizzato',
],
'from_name' => [
    'label' => 'Nome Mittente',
    'placeholder' => 'Nome del mittente',
    'help' => 'Nome visualizzato del mittente (se diverso dal default)',
    'description' => 'Nome visualizzato del mittente personalizzato',
],
```

#### Opzioni Priorità Migliorate
```php
'priority' => [
    'label' => 'Priorità',
    'placeholder' => 'Seleziona la priorità dell\'email',
    'help' => 'Imposta la priorità di invio dell\'email',
    'description' => 'Livello di priorità per l\'invio dell\'email',
    'options' => [
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
],
```

### 6. Azioni Migliorate

```php
'actions' => [
    'send' => [
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo al destinatario',
        'error' => 'Errore nell\'invio dell\'email. Verifica la configurazione.',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
        'tooltip' => 'Invia l\'email al destinatario specificato',
        'modal' => [
            'heading' => 'Conferma Invio Email',
            'description' => 'Stai per inviare un\'email. Questa azione non può essere annullata.',
            'confirm' => 'Invia Email',
            'cancel' => 'Annulla',
        ],
    ],
    'test_smtp' => [
        'label' => 'Test SMTP',
        'success' => 'Test SMTP completato con successo',
        'error' => 'Errore nel test SMTP',
        'tooltip' => 'Testa la configurazione SMTP prima dell\'invio',
        'modal' => [
            'heading' => 'Test Configurazione SMTP',
            'description' => 'Verifica la configurazione SMTP prima dell\'invio',
            'confirm' => 'Esegui Test',
            'cancel' => 'Annulla',
        ],
    ],
],
```

### 7. Messaggi di Validazione Migliorati

```php
'validation' => [
    'subject_required' => 'L\'oggetto dell\'email è obbligatorio',
    'subject_max' => 'L\'oggetto non può superare i 255 caratteri',
    'to_required' => 'Il destinatario è obbligatorio',
    'to_valid' => 'Il destinatario deve essere un indirizzo email valido',
    'to_max' => 'L\'indirizzo email del destinatario è troppo lungo',
    'cc_valid' => 'Gli indirizzi in CC devono essere email valide',
    'cc_max' => 'Uno o più indirizzi in CC sono troppo lunghi',
    'bcc_valid' => 'Gli indirizzi in BCC devono essere email valide',
    'bcc_max' => 'Uno o più indirizzi in BCC sono troppo lunghi',
    'content_required' => 'Il contenuto testuale dell\'email è obbligatorio',
    'content_max' => 'Il contenuto testuale è troppo lungo (max 10000 caratteri)',
    'body_html_max' => 'Il contenuto HTML è troppo lungo (max 20000 caratteri)',
    'template_exists' => 'Il template selezionato non esiste',
    'parameters_required' => 'I parametri sono obbligatori quando si utilizza un template',
    'parameters_json' => 'I parametri devono essere in formato JSON valido',
    'parameters_max' => 'I parametri superano la lunghezza massima consentita',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_valid' => 'La priorità deve essere una delle opzioni disponibili',
    'attachments_max' => 'Numero massimo di allegati consentito: :max',
    'attachments_total_size' => 'La dimensione totale degli allegati supera il limite consentito',
    'file_required' => 'Seleziona un file da allegare',
    'file_size_max' => 'Dimensione massima del file: :max_size',
    'file_type_allowed' => 'Tipo di file non consentito. Tipi supportati: :types',
    'scheduled_at_required' => 'Specifica la data e l\'ora per la programmazione',
    'scheduled_at_date' => 'La data di programmazione non è valida',
    'scheduled_at_after' => 'La data di programmazione deve essere futura',
],
```

### 8. Stati e Categorie Migliorati

```php
'status' => [
    'draft' => 'Bozza',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'opened' => 'Letta',
    'failed' => 'Fallita',
    'bounced' => 'Rimbalzata',
    'complained' => 'Segnalata come spam',
    'cancelled' => 'Annullata',
],

'categories' => [
    'marketing' => 'Marketing',
    'transactional' => 'Transazionale',
    'notification' => 'Notifica',
    'newsletter' => 'Newsletter',
    'system' => 'Sistema',
],
```

## 📋 Validazione e Testing

### 1. Controllo Sintassi PHP
```bash
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/_bases/<nome repository>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
php -l Modules/Notify/lang/it/send_email.php

# Output: No syntax errors detected
```

### 2. Conformità Best Practice
- ✅ Sintassi array moderna `[]`
- ✅ `declare(strict_types=1);` presente
- ✅ Struttura espansa per tutti i campi
- ✅ Nessuna duplicazione
- ✅ Campi organizzati logicamente
- ✅ Messaggi di validazione completi
- ✅ Helper text diverso da placeholder e description
- ✅ Organizzazione in sezioni logiche

### 3. Controllo PHPStan
```bash
./vendor/bin/phpstan analyze Modules/Notify/lang/it/send_email.php --level=9
```

## 🔗 Collegamenti

### Documentazione Correlata
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
- [Struttura Modulo Notify](./README.md)

### File Modificati
- `laravel/Modules/Notify/lang/it/send_email.php` - File principale migliorato
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione

## 📝 Note di Implementazione

1. **Backward Compatibility**: Le modifiche mantengono compatibilità con il codice esistente
2. **Estensibilità**: La nuova struttura permette facile aggiunta di nuovi campi
3. **Manutenibilità**: Organizzazione logica facilita la manutenzione
4. **Conformità**: Rispetta tutte le convenzioni Laraxot per traduzioni
5. **Struttura Espansa**: Tutti i campi hanno struttura espansa completa
6. **Helper Text**: Nessun helper_text uguale alla chiave dell'array

## 🚀 Prossimi Passi

1. **Testing**: Verificare che tutte le traduzioni funzionino correttamente
2. **Documentazione**: Aggiornare documentazione Filament se necessario
3. **Review**: Code review per verificare conformità standards
4. **Deployment**: Deploy in ambiente di sviluppo per testing

---

**Ultimo aggiornamento**: Gennaio 2025
**Autore**: Sistema di miglioramento automatico
**Ultimo aggiornamento**: Gennaio 2025  
**Autore**: Sistema di miglioramento automatico  

---

## sendemail-troubleshooting-1

*Consolidated from: `sendemail-troubleshooting.md`*

title: "Troubleshooting SendEmail"
type: concept
tags: [sendemail, troubleshooting]
created: 2026-07-14
updated: 2026-07-14
qmd: "sendemail-troubleshooting-1 troubleshooting sendemail"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Troubleshooting SendEmail

## Problema
La pagina `SendEmail` non funziona correttamente, mentre `TestSmtpPage` funziona.

## Cause Possibili

1. **Configurazione SMTP Mancante**
   - `SendEmail` si aspetta una configurazione SMTP valida in `.env`
   - Mancano i controlli di validazione della configurazione

2. **Mancata Gestione delle Eccezioni**
   - Non ci sono try-catch per gestire gli errori di invio
   - L'utente non riceve feedback chiaro in caso di errore

3. **Configurazione del Mailer**
   - Potrebbe mancare la configurazione del mailer di default
   - Le credenziali SMTP potrebbero essere mancanti o errate

## Soluzioni

### 1. Verificare la Configurazione di Base

Assicurati che il file `.env` contenga le seguenti variabili:

```ini
MAIL_MAILER=smtp
MAIL_HOST=tuo_host_smtp
MAIL_PORT=587
MAIL_USERNAME=tuo_username
MAIL_PASSWORD=tua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tuo@email.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modificare la Classe SendEmail

Aggiorna il metodo `sendEmail()` in `SendEmail.php`:

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);

        // Verifica che la configurazione SMTP sia presente
        if (empty(config('mail.mailers.smtp'))) {
            throw new \Exception('Configurazione SMTP non trovata');
        }

        Mail::to($data['to'])->send(
            new EmailDataEmail($email_data)
        );

        Notification::make()
            ->success()
            ->title(__('Email inviata con successo'))
            ->send();
            
    } catch (\Exception $e) {
        Notification::make()
            ->danger()
            ->title(__('Errore nell\'invio dell\'email'))
            ->body($e->getMessage())
            ->send();
            
        // Log dell'errore
        \Log::error('Errore invio email: ' . $e->getMessage(), [
            'exception' => $e,
            'data' => $data ?? []
        ]);
    }
}
```

### 3. Aggiungere Validazione al Form

Aggiorna il metodo `emailForm` per includere la validazione:

```php
public function emailForm(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('to')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subject')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('body_html')
                        ->required()
                        ->columnSpanFull(),
                ]),
        ])
        ->model($this->getUser())
        ->statePath('emailData');
}
```

### 4. Verificare la Configurazione del Mailer

Crea o aggiorna il file di configurazione `config/mail.php`:

```php
return [
    'default' => env('MAIL_MAILER', 'smtp'),
    
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
];
```

### 5. Testare la Configurazione

Crea un comando Artisan per testare la configurazione:

```bash
php artisan make:command TestEmailCommand
```

Poi aggiorna il file generato in `app/Console/Commands/TestEmailCommand.php`:

```php
public function handle()
{
    try {
        Mail::raw('Test email', function($message) {
            $message->to(env('MAIL_TEST_RECIPIENT'))
                  ->subject('Test Email');
        });
        
        $this->info('Email inviata con successo!');
    } catch (\Exception $e) {
        $this->error("Errore: ".$e->getMessage());
    }
}
```

Esegui il comando con:
```bash
php artisan email:test
```

## Debug Avanzato

1. **Abilita il Log delle Email**
   ```php
   // In config/mail.php
   'log_channel' => env('MAIL_LOG_CHANNEL'),
   ```

2. **Usa Mailtrap per il Testing**
   ```ini
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=tuo_username_mailtrap
   MAIL_PASSWORD=tua_password_mailtrap
   MAIL_ENCRYPTION=tls
   ```

3. **Verifica i Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Conclusione

1. Verifica la configurazione SMTP in `.env`
2. Aggiorna la classe `SendEmail` con una migliore gestione degli errori
3. Aggiungi la validazione del form
4. Testa la configurazione con il comando Artisan
5. Usa strumenti come Mailtrap per il debug in fase di sviluppo

---

## sendemail-troubleshooting

*Consolidated from: `sendemail-troubleshooting.md`*


## Problema
La pagina `SendEmail` non funziona correttamente, mentre `TestSmtpPage` funziona.

## Cause Possibili

1. **Configurazione SMTP Mancante**
   - `SendEmail` si aspetta una configurazione SMTP valida in `.env`
   - Mancano i controlli di validazione della configurazione

2. **Mancata Gestione delle Eccezioni**
   - Non ci sono try-catch per gestire gli errori di invio
   - L'utente non riceve feedback chiaro in caso di errore

3. **Configurazione del Mailer**
   - Potrebbe mancare la configurazione del mailer di default
   - Le credenziali SMTP potrebbero essere mancanti o errate

## Soluzioni

### 1. Verificare la Configurazione di Base

Assicurati che il file `.env` contenga le seguenti variabili:

```ini
MAIL_MAILER=smtp
MAIL_HOST=tuo_host_smtp
MAIL_PORT=587
MAIL_USERNAME=tuo_username
MAIL_PASSWORD=tua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tuo@email.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modificare la Classe SendEmail

Aggiorna il metodo `sendEmail()` in `SendEmail.php`:

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);

        // Verifica che la configurazione SMTP sia presente
        if (empty(config('mail.mailers.smtp'))) {
            throw new \Exception('Configurazione SMTP non trovata');
        }

        Mail::to($data['to'])->send(
            new EmailDataEmail($email_data)
        );

        Notification::make()
            ->success()
            ->title(__('Email inviata con successo'))
            ->send();
            
    } catch (\Exception $e) {
        Notification::make()
            ->danger()
            ->title(__('Errore nell\'invio dell\'email'))
            ->body($e->getMessage())
            ->send();
            
        // Log dell'errore
        \Log::error('Errore invio email: ' . $e->getMessage(), [
            'exception' => $e,
            'data' => $data ?? []
        ]);
    }
}
```

### 3. Aggiungere Validazione al Form

Aggiorna il metodo `emailForm` per includere la validazione:

```php
public function emailForm(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('to')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subject')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('body_html')
                        ->required()
                        ->columnSpanFull(),
                ]),
        ])
        ->model($this->getUser())
        ->statePath('emailData');
}
```

### 4. Verificare la Configurazione del Mailer

Crea o aggiorna il file di configurazione `config/mail.php`:

```php
return [
    'default' => env('MAIL_MAILER', 'smtp'),
    
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
];
```

### 5. Testare la Configurazione

Crea un comando Artisan per testare la configurazione:

```bash
php artisan make:command TestEmailCommand
```

Poi aggiorna il file generato in `app/Console/Commands/TestEmailCommand.php`:

```php
public function handle()
{
    try {
        Mail::raw('Test email', function($message) {
            $message->to(env('MAIL_TEST_RECIPIENT'))
                  ->subject('Test Email');
        });
        
        $this->info('Email inviata con successo!');
    } catch (\Exception $e) {
        $this->error("Errore: ".$e->getMessage());
    }
}
```

Esegui il comando con:
```bash
php artisan email:test
```

## Debug Avanzato

1. **Abilita il Log delle Email**
   ```php
   // In config/mail.php
   'log_channel' => env('MAIL_LOG_CHANNEL'),
   ```

2. **Usa Mailtrap per il Testing**
   ```ini
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=tuo_username_mailtrap
   MAIL_PASSWORD=tua_password_mailtrap
   MAIL_ENCRYPTION=tls
   ```

3. **Verifica i Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Conclusione

1. Verifica la configurazione SMTP in `.env`
2. Aggiorna la classe `SendEmail` con una migliore gestione degli errori
3. Aggiungi la validazione del form
4. Testa la configurazione con il comando Artisan
5. Usa strumenti come Mailtrap per il debug in fase di sviluppo

---

## sendemail_troubleshooting

*Consolidated from: `sendemail_troubleshooting.md`*


## Problema
La pagina `SendEmail` non funziona correttamente, mentre `TestSmtpPage` funziona.

## Cause Possibili

1. **Configurazione SMTP Mancante**
   - `SendEmail` si aspetta una configurazione SMTP valida in `.env`
   - Mancano i controlli di validazione della configurazione

2. **Mancata Gestione delle Eccezioni**
   - Non ci sono try-catch per gestire gli errori di invio
   - L'utente non riceve feedback chiaro in caso di errore

3. **Configurazione del Mailer**
   - Potrebbe mancare la configurazione del mailer di default
   - Le credenziali SMTP potrebbero essere mancanti o errate

## Soluzioni

### 1. Verificare la Configurazione di Base

Assicurati che il file `.env` contenga le seguenti variabili:

```ini
MAIL_MAILER=smtp
MAIL_HOST=tuo_host_smtp
MAIL_PORT=587
MAIL_USERNAME=tuo_username
MAIL_PASSWORD=tua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tuo@email.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Modificare la Classe SendEmail

Aggiorna il metodo `sendEmail()` in `SendEmail.php`:

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);

        // Verifica che la configurazione SMTP sia presente
        if (empty(config('mail.mailers.smtp'))) {
            throw new \Exception('Configurazione SMTP non trovata');
        }

        Mail::to($data['to'])->send(
            new EmailDataEmail($email_data)
        );

        Notification::make()
            ->success()
            ->title(__('Email inviata con successo'))
            ->send();
            
    } catch (\Exception $e) {
        Notification::make()
            ->danger()
            ->title(__('Errore nell\'invio dell\'email'))
            ->body($e->getMessage())
            ->send();
            
        // Log dell'errore
        \Log::error('Errore invio email: ' . $e->getMessage(), [
            'exception' => $e,
            'data' => $data ?? []
        ]);
    }
}
```

### 3. Aggiungere Validazione al Form

Aggiorna il metodo `emailForm` per includere la validazione:

```php
public function emailForm(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('to')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subject')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('body_html')
                        ->required()
                        ->columnSpanFull(),
                ]),
        ])
        ->model($this->getUser())
        ->statePath('emailData');
}
```

### 4. Verificare la Configurazione del Mailer

Crea o aggiorna il file di configurazione `config/mail.php`:

```php
return [
    'default' => env('MAIL_MAILER', 'smtp'),
    
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
];
```

### 5. Testare la Configurazione

Crea un comando Artisan per testare la configurazione:

```bash
php artisan make:command TestEmailCommand
```

Poi aggiorna il file generato in `app/Console/Commands/TestEmailCommand.php`:

```php
public function handle()
{
    try {
        Mail::raw('Test email', function($message) {
            $message->to(env('MAIL_TEST_RECIPIENT'))
                  ->subject('Test Email');
        });
        
        $this->info('Email inviata con successo!');
    } catch (\Exception $e) {
        $this->error("Errore: ".$e->getMessage());
    }
}
```

Esegui il comando con:
```bash
php artisan email:test
```

## Debug Avanzato

1. **Abilita il Log delle Email**
   ```php
   // In config/mail.php
   'log_channel' => env('MAIL_LOG_CHANNEL'),
   ```

2. **Usa Mailtrap per il Testing**
   ```ini
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=tuo_username_mailtrap
   MAIL_PASSWORD=tua_password_mailtrap
   MAIL_ENCRYPTION=tls
   ```

3. **Verifica i Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Conclusione

1. Verifica la configurazione SMTP in `.env`
2. Aggiorna la classe `SendEmail` con una migliore gestione degli errori
3. Aggiungi la validazione del form
4. Testa la configurazione con il comando Artisan
5. Usa strumenti come Mailtrap per il debug in fase di sviluppo

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
