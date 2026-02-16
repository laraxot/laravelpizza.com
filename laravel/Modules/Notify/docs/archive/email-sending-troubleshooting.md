# Troubleshooting: Sistema di Invio Email in Notify

## Problema: `SendEmail.php` vs `TestSmtpPage.php`

È stato rilevato che nel modulo Notify:
- `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php` funziona correttamente
- `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php` non funziona

Questa guida spiega le differenze e come risolvere il problema.

## Analisi delle Differenze

### 1. Estensione Base

```php
// TestSmtpPage.php (funzionante)
class TestSmtpPage extends XotBasePage implements HasForms

// SendEmail.php (non funzionante)
class SendEmail extends Page implements HasForms
```

**Problema**: `SendEmail` estende direttamente `Filament\Pages\Page` invece di `Modules\Xot\Filament\Pages\XotBasePage`.

### 2. Gestione della Configurazione SMTP

```php
// TestSmtpPage.php (funzionante)
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    // ...permette di inserire i dati SMTP
}

// SendEmail.php (non funzionante)
public function emailForm(Form $form): Form
{
    // Non gestisce la configurazione SMTP, ma usa solo quella predefinita
}
```

**Problema**: `SendEmail` non permette di configurare le impostazioni SMTP, ma usa direttamente la configurazione di sistema.

### 3. Metodo di Invio Email

```php
// TestSmtpPage.php (funzionante)
public function sendEmail(): void
{
    try {
        // Crea nuovo mailer con configurazione dinamica
        // Gestisce gli errori
    }

// SendEmail.php (non funzionante)
public function sendEmail(): void
{
    $data = $this->emailForm->getState();
    $email_data = EmailData::from($data);

    Mail::to($data['to'])->send(
        new EmailDataEmail($email_data)
    );
    // Nessuna gestione errori
}
```

**Problema**: `SendEmail` usa il mailer di sistema senza override di configurazione o gestione errori.

## Soluzioni

### Approccio 1: Estendere `XotBasePage`

Modifica `SendEmail.php` per estendere `XotBasePage` anziché `Page`:

```php
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage implements HasForms
```

### Approccio 2: Implementare la Configurazione SMTP 

Aggiungere campi di configurazione nel form:

```php
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    
    return $form
        ->schema(
            [
                Forms\Components\Section::make('SMTP')
                    ->schema(
                        [
                            Forms\Components\TextInput::make('host'),
                            Forms\Components\TextInput::make('port')->numeric(),
                            Forms\Components\TextInput::make('username'),
                            Forms\Components\TextInput::make('password'),
                            Forms\Components\TextInput::make('encryption'),
                        ]
                    )->columns(3),
                // Resto del form
            ]
        );
}
```

### Approccio 3: Override della Configurazione nel Metodo `sendEmail()`

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);
        
        // Crea configurazione temporanea
        $config = [
            'transport' => 'smtp',
            'host' => $data['host'] ?? env('MAIL_HOST'),
            'port' => $data['port'] ?? env('MAIL_PORT'),
            'encryption' => $data['encryption'] ?? env('MAIL_ENCRYPTION'),
            'username' => $data['username'] ?? env('MAIL_USERNAME'),
            'password' => $data['password'] ?? env('MAIL_PASSWORD'),
        ];
        
        // Crea mailer temporaneo
        $mailer = app('mail.manager')->createTransport($config);
        $symfony_mailer = new \Symfony\Component\Mailer\Mailer($mailer);
        
        // Invia usando mailer temporaneo
        $symfony_mailer->send(new EmailDataEmail($email_data));
        
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
    }
}
```

### Approccio 4: Configurazione del file `.env`

Se si desidera utilizzare il mailer di sistema, assicurarsi che il file `.env` contenga le corrette impostazioni:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="Your Name"
```

> **Nota**: Il mailer di default è configurato come 'log' nel file `config/mail.php`. Modificare `.env` per utilizzare 'smtp' o altro mailer.

## Soluzione Raccomandata

La soluzione migliore è combinare gli approcci 1 e 3:

1. Estendere `XotBasePage` per sfruttare le funzionalità base
2. Implementare la gestione della configurazione SMTP
3. Utilizzare un blocco try/catch per gestire gli errori

## Esempi di Implementazione

Un esempio completo di implementazione è disponibile in `TestSmtpPage.php`. Si consiglia di studiare questo file come riferimento per risolvere i problemi in `SendEmail.php`.

## Best Practices

1. Utilizzare sempre le classi base di Xot quando disponibili
2. Implementare la gestione degli errori per operazioni che potrebbero fallire
3. Offrire opzioni flessibili per la configurazione SMTP
4. Testare l'invio di email in diversi ambienti (sviluppo, test, produzione)

## Riferimenti

- [Documentazione Laravel Mail](https://laravel.com/docs/10.x/mail)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Modulo Xot - XotBasePage](mdc:../../Xot/docs/pages.md)