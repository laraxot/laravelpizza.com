# Modulo Notify

## Descrizione
Il modulo Notify fornisce un sistema di notifiche centralizzato per il progetto, supportando vari canali di comunicazione come email, SMS e notifiche database.

## Service Provider

### NotifyServiceProvider
Il NotifyServiceProvider estende XotBaseServiceProvider e segue le best practices per l'implementazione dei service provider dei moduli.

```php
namespace Modules\Notify\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class NotifyServiceProvider extends XotBaseServiceProvider
{
    /**
     * @var string
     */
    public string $name = 'Notify';

    /**
     * @var string
     */
    protected string $module_dir = __DIR__;

    /**
     * @var string
     */
    protected string $module_ns = __NAMESPACE__;

    public function register(): void
    {
        parent::register();
        
        // Registrazioni specifiche del modulo
        $this->app->singleton('notify.manager', function ($app) {
            return new \Modules\Notify\Services\NotificationManager();
        });
    }

    public function provides(): array
    {
        return [
            'notify.manager',
        ];
    }
}
```

### Caratteristiche Chiave
1. Estende `XotBaseServiceProvider`
2. Definisce le proprietà richieste:
   - `$name`: Nome del modulo (public)
   - `$module_dir`: Directory del modulo
   - `$module_ns`: Namespace del modulo
3. Implementa solo le funzionalità specifiche del modulo
4. Utilizza le funzionalità base fornite da XotBaseServiceProvider

### Funzionalità Ereditate
Il modulo eredita automaticamente da XotBaseServiceProvider:
- Registrazione delle traduzioni
- Registrazione delle viste
- Caricamento delle migrazioni
- Registrazione dei componenti Blade e Livewire
- Pubblicazione delle risorse

## Struttura del Modulo

```
Notify/
├── app/
│   ├── Providers/
│   │   ├── NotifyServiceProvider.php
│   │   └── EventServiceProvider.php
│   ├── Notifications/
│   │   ├── GenericNotification.php
│   │   └── ...
│   └── Services/
│       └── NotificationManager.php
├── config/
│   └── notify.php
├── database/
│   └── migrations/
├── resources/
│   ├── views/
│   └── lang/
└── routes/
    └── web.php
```

## Utilizzo

### Invio Notifiche
```php
use Modules\Notify\Notifications\GenericNotification;

// Invio notifica email
$user->notify(new GenericNotification(
    'Titolo',
    'Messaggio',
    ['mail']
));

// Invio notifica multi-canale
$user->notify(new GenericNotification(
    'Titolo',
    'Messaggio',
    ['mail', 'sms', 'database']
));
```

### NotificationManager
```php
$manager = app('notify.manager');

// Invio notifica a gruppo
$manager->notifyGroup('admin', new GenericNotification(...));

// Invio notifica broadcast
$manager->broadcast(new GenericNotification(...));
```

## Best Practices

1. **Estensione Service Provider**
   - Estendere sempre XotBaseServiceProvider
   - Definire tutte le proprietà richieste
   - Non reimplementare funzionalità già fornite

2. **Notifiche**
   - Usare code per notifiche asincrone
   - Implementare interfaccia ShouldQueue
   - Gestire fallimenti con retry

3. **Configurazione**
   - Usare file di configurazione per valori variabili
   - Documentare tutte le opzioni
   - Fornire valori di default sensati

4. **Testing**
   - Testare ogni canale di notifica
   - Simulare scenari di fallimento
   - Verificare code e retry

## Collegamenti
- [Documentazione XotBaseServiceProvider](../xot/XotBaseServiceProvider.md)
- [Guida Notifiche Laravel](https://laravel.com/docs/notifications)
- [Best Practices Moduli](../standards/module-standards.md)

## Informazioni Generali
- **Nome**: `laraxot/module_notify_fila3`
- **Descrizione**: Modulo dedicato alla gestione delle notifiche
- **Namespace**: `Modules\Notify`
- **Repository**: https://github.com/laraxot/module_notify_fila3.git

## Service Providers
1. `Modules\Notify\Providers\NotifyServiceProvider`
2. `Modules\Notify\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi di notifica
```

## Dipendenze
### Pacchetti Required
- `aws/aws-sdk-php`
- `filament/filament`
- `irazasyed/telegram-bot-sdk`
- `kreait/laravel-firebase`
- `laravel-notification-channels/fcm`
- `laravel-notification-channels/telegram`: ^5.0
- `symfony/http-client`
- `symfony/postmark-mailer`

### Moduli Required
- Xot
- Tenant
- UI

## Database
### Factories
Namespace: `Modules\Notify\Database\Factories`

### Seeders
Namespace: `Modules\Notify\Database\Seeders`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Notifiche Email
  - SMTP
  - Amazon SES
  - Postmark
- Notifiche Push
  - Firebase Cloud Messaging
  - Web Push
- Notifiche Telegram
- Notifiche SMS
- Notifiche WhatsApp
- Code asincrona
- Templates personalizzabili

## Configurazione
### Providers
- Configurazione in `config/services.php`
- Chiavi richieste in `.env`:
  ```
  MAIL_MAILER=
  AWS_ACCESS_KEY_ID=
  AWS_SECRET_ACCESS_KEY=
  TELEGRAM_BOT_TOKEN=
  FIREBASE_CREDENTIALS=
  ```

## Risorse e Tutorial

### Email e SMTP
- **Test SMTP in Laravel**
  - [Test Laravel SMTP Mail via Tinker](https://medium.com/@azishapidin/test-laravel-smtp-mail-via-tinker-cec59999214)

- **Gestione Email**
  - [Laravel Mailator - Email Scheduler & Templates](https://codebrisk.com/blog/laravel-mailator-for-configuring-email-scheduler-templates) (simile a ThemeNotification)
  - [Check if you can Send Email via Given Mail Server](https://codebrisk.com/blog/check-if-you-can-send-email-via-given-mail-server-in-laravel)
  - [Catch All Sent Email & Show them on Laravel Application View](https://codebrisk.com/blog/catch-all-sent-email-show-them-on-laravel-application-view)

### SMS
- **Provider Supportati**
  - Skebby
  - Netfun
  - Esendex

### Notifiche Push
- **Firebase**
  - [Integrating Push Notifications in Laravel Using Firebase](https://medium.com/@hala.s.salim/integrating-push-notifications-in-laravel-0bae5411d7f9)
  - [Push Notifications with Laravel](https://medium.com/@peterhrobar/push-notifications-with-laravel-61049ab9aec6)

### Telegram
- **Integrazione**
  - [Laravel Package to Integrate Telegram Bot API](https://dev.to/millykhamroev/laravel-package-to-integrate-telegram-bot-api-3l6e)
  - [Send Telegram Notifications with Laravel](https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406)
  - [Laravel Notifications Telegram Bot](https://abstractentropy.com/laravel-notifications-telegram-bot/)

- **Configurazione**
  ```php
  // config/services.php
  'telegram-bot-api' => [
      'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
  ],
  ```

### WhatsApp
- **Integrazione**
  - [How to Send WhatsApp Messages with Laravel](https://levelup.gitconnected.com/how-to-send-whatsapp-messages-with-laravel-ed6426b4be96)
  - [WhatsApp Integration with Laravel Using Twilio API](https://medium.com/@snomanali1996/whatsapp-integration-with-laravel-using-twilio-api-9bd8ecd06dbf)

- **Provider Supportati**
  - [Twilio/Vonage](https://www.twilio.com/blog/create-laravel-php-notification-channel-whatsapp-twilio)
  - [WhatsApp Cloud API (Meta)](https://developers.facebook.com/docs/whatsapp/cloud-api/get-started)

### Altre Integrazioni
- [Laravel Notifications with Database](http://laradevsbd.com/story/laravel-notifications-with-database)
- [Laravel Login Link](https://codebrisk.com/blog/a-blade-component-to-quickly-login-to-your-local-environment) - Componente Blade per login rapido in ambiente locale
- [Laravel Facet Filter](https://codebrisk.com/blog/add-simple-facet-filtering-in-your-laravel-applications) - Filtri avanzati per le applicazioni

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Implementare rate limiting
7. Gestire fallback per notifiche
8. Monitorare le code

## Troubleshooting
### Problemi Comuni
1. **Errori di Invio Email**
   - Verificare configurazione SMTP
   - Controllare limiti provider
   - Verificare template email

2. **Problemi Firebase**
   - Verificare credenziali Firebase
   - Controllare configurazione FCM
   - Verificare token dispositivi

3. **Problemi SMS**
   - Verificare credenziali provider
   - Controllare formato numero telefonico
   - Verificare saldo disponibile

3. **Errori Telegram**
   - Verificare token bot
   - Controllare permessi bot
   - Verificare chat ID

## Test SMTP
- Disponibile pagina di test SMTP
- Verifica configurazione email
- Debug problemi di invio

## Changelog
Le modifiche vengono tracciate nel repository GitHub. 
## Collegamenti tra versioni di module_notify.md
* [module_notify.md](docs/module_notify.md)
* [module_notify.md](laravel/Modules/Notify/docs/module_notify.md)

