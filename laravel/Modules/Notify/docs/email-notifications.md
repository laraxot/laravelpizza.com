# Sistema Notifiche Email - il progetto

## Panoramica

Sistema di notifiche per eventi e azioni in il progetto.

## Struttura Notifiche

### 1. Notifiche Base

```php
namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notify\Mail\TemplatedMail;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $template;
    protected $data;

    public function __construct(MailTemplate $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): TemplatedMail
    {
        return (new TemplatedMail($this->template, $this->data))
            ->to($notifiable->email);
    }

    public function toArray($notifiable): array
    {
        return [
            'template_id' => $this->template->id,
            'data' => $this->data,
        ];
    }
}
```

### 2. Notifiche Specifiche

```php
namespace Modules\Notify\Notifications;

class AppointmentNotification extends GenericNotification
{
    public function __construct(Appointment $appointment)
    {
        $template = MailTemplate::where('type', 'appointment')->first();
        
        $data = [
            'appointment' => $appointment,
            'patient' => $appointment->patient,
            'doctor' => $appointment->doctor,
            'date' => $appointment->date->format('d/m/Y'),
            'time' => $appointment->time->format('H:i'),
        ];

        parent::__construct($template, $data);
    }
}

class PaymentNotification extends GenericNotification
{
    public function __construct(Payment $payment)
    {
        $template = MailTemplate::where('type', 'payment')->first();
        
        $data = [
            'payment' => $payment,
            'amount' => $payment->amount,
            'date' => $payment->date->format('d/m/Y'),
            'method' => $payment->method,
        ];

        parent::__construct($template, $data);
    }
}
```

## Eventi

### 1. Event Listeners

```php
namespace Modules\Notify\Listeners;

class SendAppointmentNotification
{
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        
        // Notifica paziente
        $appointment->patient->notify(new AppointmentNotification($appointment));
        
        // Notifica medico
        $appointment->doctor->notify(new AppointmentNotification($appointment));
    }
}

class SendPaymentNotification
{
    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment;
        
        // Notifica paziente
        $payment->patient->notify(new PaymentNotification($payment));
        
        // Notifica amministrazione
        User::where('role', 'admin')->get()
            ->each->notify(new PaymentNotification($payment));
    }
}
```

### 2. Event Service Provider

```php
namespace Modules\Notify\Providers;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AppointmentCreated::class => [
            SendAppointmentNotification::class,
        ],
        PaymentReceived::class => [
            SendPaymentNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        // Registra eventi
        Event::listen('appointment.*', function ($event, $payload) {
            // Log evento
            Log::info('Appointment event', [
                'event' => $event,
                'payload' => $payload,
            ]);
        });
    }
}
```

## Integrazione con Filament

### 1. Notifications Resource

```php
namespace Modules\Notify\Filament\Resources;

class NotificationResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Template
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->required()
                    ->label('Template'),
                    
                // Dati
                KeyValue::make('data')
                    ->label('Dati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),
                    
                // Destinatari
                Select::make('recipients')
                    ->multiple()
                    ->options([
                        'patient' => 'Paziente',
                        'doctor' => 'Medico',
                        'admin' => 'Amministrazione',
                    ])
                    ->required()
                    ->label('Destinatari'),
                    
                // Programma
                DateTimePicker::make('scheduled_at')
                    ->label('Programma')
                    ->nullable(),
            ])
        ]);
    }
}
```

### 2. Notifications Actions

```php
class NotificationActions
{
    public static function make(): array
    {
        return [
            // Invia ora
            Action::make('send_now')
                ->label('Invia Ora')
                ->icon('heroicon-o-paper-airplane')
                ->action(function (Notification $record) {
                    $record->send();
                }),
                
            // Programma
            Action::make('schedule')
                ->label('Programma')
                ->icon('heroicon-o-clock')
                ->form([
                    DateTimePicker::make('scheduled_at')
                        ->required()
                        ->label('Data e Ora'),
                ])
                ->action(function (array $data, Notification $record) {
                    $record->schedule($data['scheduled_at']);
                }),
                
            // Duplica
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (Notification $record) {
                    $record->replicate()->save();
                }),
        ];
    }
}
```

## Best Practices

### 1. Gestione Template

```php
class NotificationTemplate
{
    public static function make(string $type, array $data = []): MailTemplate
    {
        $template = MailTemplate::where('type', $type)->first();
        
        if (!$template) {
            throw new \Exception("Template {$type} not found");
        }
        
        // Verifica placeholder
        $placeholders = $template->getPlaceholders();
        $missing = array_diff($placeholders, array_keys($data));
        
        if (!empty($missing)) {
            throw new \Exception("Missing placeholders: " . implode(', ', $missing));
        }
        
        return $template;
    }
}
```

### 2. Validazione Dati

```php
class NotificationValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Verifica template
        if (!isset($data['template'])) {
            $errors[] = 'Template is required';
        }

        // Verifica destinatari
        if (empty($data['recipients'])) {
            $errors[] = 'Recipients are required';
        }

        // Verifica dati
        if (!$this->validateData($data['data'])) {
            $errors[] = 'Invalid data';
        }

        return $errors;
    }

    protected function validateData(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_string($value)) {
                return false;
            }
        }

        return true;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Notifiche non inviate**
   - Verifica template
   - Controlla destinatari
   - Debug eventi

2. **Dati mancanti**
   - Verifica placeholder
   - Controlla validazione
   - Debug payload

3. **Errori invio**
   - Verifica configurazione
   - Controlla log
   - Debug queue

### 2. Debug

```php
class NotificationDebugger
{
    public function debug(Notification $notification): array
    {
        return [
            'template' => [
                'id' => $notification->template->id,
                'type' => $notification->template->type,
                'placeholders' => $notification->template->getPlaceholders(),
            ],
            'data' => $notification->data,
            'recipients' => $notification->recipients,
            'scheduled' => $notification->scheduled_at,
            'status' => $notification->status,
            'error' => $notification->error,
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)

## Vedi Anche
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Mail](https://laravel.com/project_docs/mail) 
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Mail](https://laravel.com/docs/mail) 
