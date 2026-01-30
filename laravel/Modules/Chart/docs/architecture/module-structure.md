# Struttura dei Moduli

## Modulo Xot
Il modulo Xot è il modulo base che fornisce le classi astratte e le funzionalità core.

### Classi Base
- `XotBaseResource`
- `XotBasePage`
- `XotBaseWidget`
- `XotBaseAction`

### Dipendenze
- Tutti i moduli devono dipendere da Xot
- Non ci devono essere dipendenze circolari

## Struttura Standard Modulo
```
Module/
├── app/
│   ├── Actions/           # Spatie/Laravel-Queueable-Action
│   ├── Enums/            # Enum generici e specifici
│   ├── Filament/         # Resources, Pages, Widgets
│   ├── Models/           # Modelli
│   ├── Notifications/    # RecordNotification
│   └── Providers/        # Service Providers
├── lang/                 # File di traduzione
├── docs/                 # Documentazione specifica
└── README.md            # Documentazione principale
```

## Regole di Implementazione

### Resources
```php
namespace Modules\Dentist\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorRegistrationResource extends XotBaseResource
{
    // NON implementare form() e table()
    // Usare le implementazioni base di Xot
}
```

### Actions
```php
namespace Modules\Dentist\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateDentistAction implements QueueableAction
{
    use QueueableAction;
    
    public function execute(array $data)
    {
        // Implementazione
    }
}
```

### Notifiche
```php
use Modules\Notify\Notifications\RecordNotification;

// Usare direttamente RecordNotification
$notification = new RecordNotification($record, 'dentist.registration');
```

### Traduzioni
```php
// lang/it/registration.php
return [
    'fields' => [
        'name' => 'Nome',
        'email' => 'Email',
    ],
];
```

## Collegamenti
- [Modulo Xot](../laravel/Modules/Xot/README.md)
- [Regole Progetto](./project-rules.md)
- [Best Practices](./best-practices.md)

## Note
- Seguire sempre questa struttura
- Consultare la documentazione del modulo Xot
- Mantenere la coerenza tra i moduli 
