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