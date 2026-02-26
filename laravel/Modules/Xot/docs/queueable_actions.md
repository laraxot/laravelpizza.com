# Queueable Actions

## Panoramica

Le Queueable Actions sono una soluzione elegante per incapsulare la logica di business in classi dedicate che possono essere eseguite sia in modo sincrono che asincrono.

## Vantaggi

- **Incapsulamento**: Logica di business isolata e riutilizzabile
- **Flessibilità**: Esecuzione sincrona o asincrona 
- **Testabilità**: Facile da testare in isolamento
- **Dependency Injection**: Supporto completo per DI
- **Job Chaining**: Possibilità di concatenare azioni
- **Middleware**: Supporto per middleware delle code

## Implementazione Base

```php
use Spatie\QueueableAction\QueueableAction;

class ProcessDoctorModerationAction
{
    use QueueableAction;

    public function execute(DoctorRegistrationWorkflow $workflow, bool $approved): void
    {
        // Logica di business
    }
}
```

## Utilizzo

### Esecuzione Sincrona
```php
app(ProcessDoctorModerationAction::class)->execute($workflow, true);
```

### Esecuzione Asincrona
```php 
app(ProcessDoctorModerationAction::class)->onQueue()->execute($workflow, true);
```

### Con Dependency Injection
```php
class ProcessDoctorModerationAction
{
    use QueueableAction;

    public function __construct(
        private EmailService $emailService,
        private LogService $logService
    ) {}

    public function execute(DoctorRegistrationWorkflow $workflow, bool $approved): void
    {
        // Accesso ai servizi iniettati
        $this->emailService->send(...);
        $this->logService->log(...);
    }
}
```

## Middleware

```php
class ProcessDoctorModerationAction
{
    use QueueableAction;

    public function middleware(): array
    {
        return [new RateLimited('moderation')];
    }
}
```

## Job Chaining

```php
ProcessDoctorModerationAction::make()
    ->onQueue()
    ->chain([
        new SendEmailJob(),
        new UpdateStatsJob()
    ])
    ->execute($workflow, true);
```

## Testing

```php
class ProcessDoctorModerationActionTest extends TestCase
{
    /** @test */
    public function it_can_process_moderation()
    {
        $action = app(ProcessDoctorModerationAction::class);
        
        $workflow = DoctorRegistrationWorkflow::factory()->create();
        
        $action->execute($workflow, true);
        
        $this->assertTrue($workflow->fresh()->isModerationApproved());
    }
}
```

## Best Practices

1. **Naming**: Usare nomi descrittivi che indicano l'azione
   ```php
   ProcessDoctorModerationAction
   GenerateInvoiceAction
   SendWelcomeEmailAction
   ```

2. **Single Responsibility**: Ogni action dovrebbe fare una cosa sola
   ```php
   // ❌ Troppa responsabilità
   class ProcessUserRegistrationAction
   {
       public function execute(User $user)
       {
           $this->validateUser($user);
           $this->createProfile($user);
           $this->sendWelcomeEmail($user);
           $this->notifyAdmins($user);
       }
   }

   // ✅ Responsabilità singola
   class ValidateUserAction {}
   class CreateUserProfileAction {}
   class SendUserWelcomeEmailAction {}
   class NotifyAdminsAboutNewUserAction {}
   ```

3. **Dependency Injection**: Iniettare dipendenze nel costruttore
   ```php
   class ProcessDoctorModerationAction
   {
       public function __construct(
           private EmailService $emailService,
           private LogService $logService,
           private NotificationService $notificationService
       ) {}
   }
   ```

4. **Return Types**: Specificare sempre i tipi di ritorno
   ```php
   public function execute(Workflow $workflow): bool
   {
       return true;
   }
   ```

5. **Exception Handling**: Gestire le eccezioni in modo appropriato
   ```php
   public function execute(Workflow $workflow): bool
   {
       try {
           // Logica
           return true;
       } catch (Exception $e) {
           report($e);
           return false;
       }
   }
   ```

## Esempi Reali

### Moderazione Medici
```php
class ProcessDoctorModerationAction
{
    use QueueableAction;

    public function __construct(
        private EmailService $emailService,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(
        DoctorRegistrationWorkflow $workflow,
        bool $approved,
        ?string $notes = null,
        int $moderatorId
    ): bool {
        try {
            // Aggiorna workflow
            $workflow->status = $approved 
                ? DoctorRegistrationWorkflow::STATUS_MODERATION_APPROVED 
                : DoctorRegistrationWorkflow::STATUS_MODERATION_REJECTED;
            
            $workflow->moderation_notes = $notes;
            $workflow->moderated_at = now();
            $workflow->moderated_by = $moderatorId;
            
            if ($approved) {
                $workflow->generateModerationToken();
                $workflow->current_step = 'contacts';
            }
            
            $workflow->save();

            // Invia email
            $this->emailService->sendModerationResult($workflow);

            // Log attività
            $this->activityLogger->log(
                'doctor_moderation',
                $workflow,
                $moderatorId,
                ['approved' => $approved, 'notes' => $notes]
            );

            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function middleware(): array
    {
        return [
            new RateLimited('moderation'),
            new PreventOverlapping($this)
        ];
    }
}
```

## Vedi Anche

- [Laravel Queues](https://laravel.com/docs/queues)
- [Spatie Documentation](https://spatie.be/docs/laravel-queueable-action) 