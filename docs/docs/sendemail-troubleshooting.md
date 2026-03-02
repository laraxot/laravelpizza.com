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
