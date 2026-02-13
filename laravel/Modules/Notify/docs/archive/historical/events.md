# Email Events

## Panoramica

Il sistema di eventi permette di:
- Registrare eventi che possono triggerare l'invio di email
- Definire le variabili disponibili per ogni evento
- Validare i dati degli eventi
- Tracciare gli eventi e le email inviate

## Eventi Standard

### Registrazione e Autenticazione

```php
class UserRegistered implements TriggersDatabaseMail
{
    public function __construct(
        public User $user,
        public string $password
    ) {}

    public static function getVariables(): array
    {
        return [
            'user.name' => 'Nome utente',
            'user.email' => 'Email utente',
            'password' => 'Password temporanea',
            'login_url' => 'URL di login'
        ];
    }
}

class UserEmailVerified implements TriggersDatabaseMail
{
    public function __construct(
        public User $user
    ) {}

    public static function getVariables(): array
    {
        return [
            'user.name' => 'Nome utente',
            'user.email' => 'Email utente',
            'dashboard_url' => 'URL dashboard'
        ];
    }
}

class PasswordReset implements TriggersDatabaseMail
{
    public function __construct(
        public User $user,
        public string $token
    ) {}

    public static function getVariables(): array
    {
        return [
            'user.name' => 'Nome utente',
            'user.email' => 'Email utente',
            'reset_url' => 'URL reset password',
            'token' => 'Token reset password',
            'expires_at' => 'Data scadenza token'
        ];
    }
}
```

### Moderazione Medici

```php
class DoctorRegistrationSubmitted implements TriggersDatabaseMail
{
    public function __construct(
        public Doctor $doctor,
        public DoctorRegistrationWorkflow $workflow
    ) {}

    public static function getVariables(): array
    {
        return [
            'doctor.name' => 'Nome medico',
            'doctor.email' => 'Email medico',
            'workflow.submitted_at' => 'Data sottomissione',
            'workflow.certification_url' => 'URL certificazione'
        ];
    }
}

class DoctorRegistrationApproved implements TriggersDatabaseMail
{
    public function __construct(
        public Doctor $doctor,
        public DoctorRegistrationWorkflow $workflow
    ) {}

    public static function getVariables(): array
    {
        return [
            'doctor.name' => 'Nome medico',
            'doctor.email' => 'Email medico',
            'workflow.approved_at' => 'Data approvazione',
            'workflow.approved_by' => 'Moderatore',
            'workflow.notes' => 'Note moderazione',
            'continue_url' => 'URL completamento registrazione'
        ];
    }
}

class DoctorRegistrationRejected implements TriggersDatabaseMail
{
    public function __construct(
        public Doctor $doctor,
        public DoctorRegistrationWorkflow $workflow
    ) {}

    public static function getVariables(): array
    {
        return [
            'doctor.name' => 'Nome medico',
            'doctor.email' => 'Email medico',
            'workflow.rejected_at' => 'Data rifiuto',
            'workflow.rejected_by' => 'Moderatore',
            'workflow.notes' => 'Note moderazione',
            'retry_url' => 'URL nuova registrazione'
        ];
    }
}
```

## Registrazione Eventi

```php
// NotifyServiceProvider
public function boot(): void
{
    $registry = app(EventRegistry::class);

    // Auth
    $registry->register(UserRegistered::class);
    $registry->register(UserEmailVerified::class);
    $registry->register(PasswordReset::class);

    // Doctors
    $registry->register(DoctorRegistrationSubmitted::class);
    $registry->register(DoctorRegistrationApproved::class);
    $registry->register(DoctorRegistrationRejected::class);
}
```

## Dispatch Eventi

```php
class ProcessDoctorModerationAction
{
    public function execute(
        DoctorRegistrationWorkflow $workflow,
        bool $approved,
        ?string $notes = null,
        int $moderatorId
    ): void {
        // ... logica di business ...

        if ($approved) {
            event(new DoctorRegistrationApproved($doctor, $workflow));
        } else {
            event(new DoctorRegistrationRejected($doctor, $workflow));
        }
    }
}
```

## Listener

```php
class SendEmailForEvent
{
    public function __construct(
        private EmailService $emailService
    ) {}

    public function handle($event): void
    {
        if (!$event instanceof TriggersDatabaseMail) {
            return;
        }

        $this->emailService->sendMail(
            get_class($event),
            get_object_vars($event)
        );
    }
}
```

## Registrazione Listener

```php
// EventServiceProvider
protected $listen = [
    UserRegistered::class => [
        SendEmailForEvent::class,
    ],
    UserEmailVerified::class => [
        SendEmailForEvent::class,
    ],
    PasswordReset::class => [
        SendEmailForEvent::class,
    ],
    DoctorRegistrationSubmitted::class => [
        SendEmailForEvent::class,
    ],
    DoctorRegistrationApproved::class => [
        SendEmailForEvent::class,
    ],
    DoctorRegistrationRejected::class => [
        SendEmailForEvent::class,
    ],
];
```

## Validazione Eventi

```php
class EventValidator
{
    public function validate(string $event, array $data): array
    {
        $variables = app(EventRegistry::class)
            ->getVariables($event);

        return collect($variables)
            ->mapWithKeys(fn ($description, $path) => [
                $path => data_get($data, $path)
            ])
            ->filter()
            ->toArray();
    }
}
```

## Best Practices

1. **Naming Conventions**
   - Usare nomi descrittivi per gli eventi
   - Suffisso `Event` per le classi evento
   - Prefisso verbo al passato (es. `UserRegistered`)

2. **Documentazione**
   - Documentare tutte le variabili disponibili
   - Aggiungere descrizioni chiare
   - Mantenere aggiornata la documentazione

3. **Validazione**
   - Validare i dati prima dell'invio
   - Gestire i casi di errore
   - Loggare gli errori

4. **Testing**
   - Testare gli eventi
   - Testare i listener
   - Testare i template

## Vedi Anche

- [Laravel Events](https://laravel.com/docs/events)
- [Database Mail](database-mail.md)
- [Email Templates](templates.md) 