# Eventi

## Configurazione Base

### Eventi
```php
// config/events.php
return [
    'default' => env('EVENT_DRIVER', 'redis'),
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
        ],
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ],
        ],
    ],
];
```

### Broadcasting
```php
// config/broadcasting.php
return [
    'default' => env('BROADCAST_DRIVER', 'pusher'),
    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ],
        ],
    ],
];
```

## Eventi Base

### Evento Semplice
```php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderShipped implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return new Channel('orders');
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
        ];
    }
}
```

### Listener
```php
namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendShipmentNotification implements ShouldQueue
{
    public function handle(OrderShipped $event)
    {
        // Invia notifica
    }
}
```

## Best Practices

### 1. Struttura
- Separare gli eventi per dominio
- Utilizzare nomi descrittivi
- Implementare interfacce appropriate
- Documentare gli eventi

### 2. Performance
- Utilizzare le code
- Implementare il rate limiting
- Ottimizzare i payload
- Monitorare gli eventi

### 3. Sicurezza
- Validare i dati
- Sanitizzare l'output
- Proteggere i canali
- Implementare il logging

### 4. Manutenzione
- Monitorare gli eventi
- Gestire i fallimenti
- Implementare alerting
- Documentare gli eventi

## Esempi di Utilizzo

### Eventi in Coda
```php
// Dispatch di un evento
event(new OrderShipped($order));

// Dispatch su coda specifica
OrderShipped::dispatch($order)->onQueue('orders');

// Dispatch con delay
OrderShipped::dispatch($order)->delay(now()->addMinutes(10));
```

### Eventi Broadcast
```php
namespace App\Events;

class UserStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $status;

    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'status.changed';
    }
}
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare un nuovo evento
php artisan make:event OrderShipped

# Creare un nuovo listener
php artisan make:listener SendShipmentNotification

# Listare gli eventi
php artisan event:list

# Generare eventi di test
php artisan event:generate
```

### Monitoraggio
```php
use Illuminate\Support\Facades\Event;

Event::listen('*', function ($eventName, array $data) {
    // Log di tutti gli eventi
});

Event::listen('App\Events\*', function ($eventName, array $data) {
    // Log di eventi specifici
});
```

## Gestione degli Errori

### Eventi Falliti
```php
namespace App\Events;

use Illuminate\Support\Facades\Log;

class OrderShipped implements ShouldBroadcast
{
    public function failed($exception)
    {
        Log::error('Evento fallito', [
            'event' => get_class($this),
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
```

### Retry Logic
```php
namespace App\Listeners;

class SendShipmentNotification implements ShouldQueue
{
    public $tries = 3;
    public $timeout = 30;
    public $backoff = [60, 180, 360];

    public function handle(OrderShipped $event)
    {
        // Invia notifica
    }
}
``` 