# Servizi del Modulo Xot

## LangService

Il servizio di gestione delle traduzioni fornisce un sistema centralizzato per la gestione delle traduzioni dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Services\LangService;

// Caricamento automatico delle traduzioni
LangService::loadTranslations('broker');

// Recupero traduzione con fallback
$translation = LangService::get('broker.polizze.status.active', 'Attiva');

// Cache delle traduzioni
LangService::cache()->get('broker.polizze.labels');

// Supporto multi-lingua
LangService::setLocale('it');
$translation = LangService::get('broker.polizze.status.active');
```

### Struttura File Traduzioni

```php
// Modules/Broker/Resources/lang/it/polizze.php
return [
    'status' => [
        'active' => 'Attiva',
        'suspended' => 'Sospesa',
        'cancelled' => 'Annullata',
    ],
    'labels' => [
        'policy_number' => 'Numero Polizza',
        'customer' => 'Cliente',
    ],
];
```

## PermissionService

Gestisce i permessi e i ruoli dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Services\PermissionService;

// Verifica permessi
PermissionService::can('polizze.view');

// Assegnazione ruoli
PermissionService::assignRole($user, 'admin');

// Cache dei permessi
PermissionService::cache()->get('user.1.permissions');

// Sincronizzazione permessi
PermissionService::sync();
```

### Struttura Permessi

```php
// config/permissions.php
return [
    'roles' => [
        'admin' => [
            'label' => 'Amministratore',
            'permissions' => ['*'],
        ],
        'broker' => [
            'label' => 'Broker',
            'permissions' => [
                'polizze.*',
                'clienti.view',
                'clienti.create',
            ],
        ],
    ],
    'permissions' => [
        'polizze.view' => 'Visualizza polizze',
        'polizze.create' => 'Crea polizze',
        'polizze.edit' => 'Modifica polizze',
        'polizze.delete' => 'Elimina polizze',
    ],
];
```

## ConfigService

Gestisce le configurazioni dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Services\ConfigService;

// Recupero configurazioni
$config = ConfigService::get('broker.settings');

// Cache configurazioni
ConfigService::cache()->get('broker.settings');

// Aggiornamento configurazioni
ConfigService::set('broker.settings.default_currency', 'EUR');

// Merge configurazioni
ConfigService::merge('broker.settings', [
    'notification_email' => 'admin@example.com',
]);
```

### Struttura Configurazioni

```php
// Modules/Broker/Config/config.php
return [
    'settings' => [
        'default_currency' => 'EUR',
        'vat_rate' => 22,
        'notification_email' => 'admin@example.com',
    ],
];
```

## FileService

Gestisce il caricamento e la manipolazione dei file.

### Caratteristiche Principali

```php
use Modules\Xot\Services\FileService;

// Upload file
$path = FileService::upload($file, 'documenti');

// Generazione URL
$url = FileService::url($path);

// Eliminazione file
FileService::delete($path);

// Manipolazione immagini
FileService::image($path)
    ->resize(800, 600)
    ->save();
```

### Configurazione Storage

```php
// config/filesystems.php
return [
    'disks' => [
        'documenti' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],
    ],
];
```

## NotificationService

Gestisce l'invio di notifiche attraverso vari canali.

### Caratteristiche Principali

```php
use Modules\Xot\Services\NotificationService;

// Invio notifica
NotificationService::send($user, new PolizzaScadenzaNotification($polizza));

// Notifica immediata
NotificationService::sendNow($user, new UrgentNotification());

// Notifica programmata
NotificationService::sendLater($user, new ReminderNotification(), now()->addDays(7));

// Verifica stato notifica
NotificationService::check($notificationId);
```

### Configurazione Notifiche

```php
// config/notifications.php
return [
    'channels' => [
        'mail' => [
            'from' => [
                'address' => 'noreply@example.com',
                'name' => 'OrisBroker',
            ],
        ],
        'database' => true,
        'slack' => [
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
        ],
    ],
];
```

## Best Practices

1. **Dependency Injection**
   - Utilizzare l'iniezione delle dipendenze
   - Evitare l'uso diretto delle facciate
   - Preferire l'interfaccia ai dettagli implementativi

2. **Caching**
   - Implementare strategie di cache
   - Utilizzare chiavi di cache significative
   - Gestire l'invalidazione della cache

3. **Error Handling**
   - Utilizzare eccezioni personalizzate
   - Loggare errori significativi
   - Fornire messaggi di errore chiari

4. **Testing**
   - Scrivere test unitari per ogni servizio
   - Utilizzare mock per le dipendenze
   - Testare i casi limite 