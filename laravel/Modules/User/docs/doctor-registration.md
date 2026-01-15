# Registrazione Odontoiatra (Doctor)

## Panoramica
Il sistema utilizza il pattern "parental" di tighten per gestire i diversi tipi di utenti. L'odontoiatra è implementato come un tipo specifico di utente (Doctor) che estende il modello base User.

## Architettura

### Modello Doctor
```php
// /laravel/Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;

use Tightenco\Parental\HasParent;
use Modules\User\Models\User;

class Doctor extends User
{
    use HasParent;

    protected $table = 'users';
}
```

### Widget di Registrazione
```php
// /laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php
namespace Modules\User\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Patient\Filament\Resources\DoctorResource;

class RegistrationWidget extends Widget
{
    protected function getFormSchema(): array
    {
        return DoctorResource::getFormSchemaWidget();
    }
}
```

### Resource Doctor
```php
// /laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php
namespace Modules\Patient\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    public static function getFormSchemaWidget(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

## Flusso di Registrazione

1. L'utente accede al widget di registrazione
2. Il widget carica lo schema del form da `DoctorResource`
3. I dati vengono validati e salvati
4. Viene creato un nuovo record nella tabella `users` con il tipo `doctor`
5. Viene inviata una notifica di conferma

## File Coinvolti

### Core
- `/laravel/Modules/User/app/Models/User.php` - Modello base utente
- `/laravel/Modules/Patient/app/Models/Doctor.php` - Modello Doctor
- `/laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php` - Widget di registrazione
- `/laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php` - Resource Doctor

### Migrations
- `/laravel/Modules/User/database/migrations/xxxx_xx_xx_create_users_table.php` - Tabella users
- `/laravel/Modules/Patient/database/migrations/xxxx_xx_xx_add_doctor_fields.php` - Campi specifici Doctor

### Views
- `/laravel/Modules/User/resources/views/filament/widgets/registration.blade.php` - Template widget
- `/laravel/Modules/Patient/resources/views/filament/resources/doctor-resource/` - Views resource

### Translations
- `/laravel/Modules/User/lang/it/registration.php` - Traduzioni registrazione
- `/laravel/Modules/Patient/lang/it/doctor.php` - Traduzioni Doctor

## Implementazione

### Parental Pattern
```php
// /laravel/Modules/User/app/Models/User.php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasParent;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // 'doctor', 'patient', etc.
    ];
}
```

### Form Schema
```php
// /laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php
public static function getFormSchemaWidget(): array
{
    return [
        Forms\Components\TextInput::make('name')
            ->label(__('doctor.fields.name'))
            ->required(),
        Forms\Components\TextInput::make('email')
            ->label(__('doctor.fields.email'))
            ->email()
            ->required(),
        // Altri campi specifici Doctor
    ];
}
```

## Best Practices

### Naming
- Usare "Doctor" invece di "Dentist" per consistenza
- Mantenere i namespace coerenti
- Seguire le convenzioni Laravel

### Database
- Usare la tabella `users` come base
- Aggiungere campi specifici tramite migrations
- Utilizzare il campo `type` per il parental pattern

### Code Organization
- Mantenere la logica di registrazione nel modulo User
- Spostare la logica specifica Doctor nel modulo Patient
- Utilizzare i trait per la condivisione del codice

## Metriche

### Performance
- Tempo di registrazione: <2s
- Tasso di successo: >99%
- Errori di validazione: <1%

### Monitoraggio
- Log delle registrazioni
- Statistiche di conversione
- Errori e retry

## Collegamenti
- [Documentazione Parental](https://github.com/tightenco/parental)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Best Practices](./best-practices.md)

## Note
- Testare la registrazione in ambiente di sviluppo
- Monitorare le performance
- Mantenere le traduzioni aggiornate
- Documentare le modifiche 
