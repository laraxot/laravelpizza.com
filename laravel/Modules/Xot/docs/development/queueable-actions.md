# Spatie QueueableActions

## Introduzione

In Laraxot, preferiamo l'utilizzo di Spatie QueueableActions rispetto ai tradizionali Services. Questo approccio offre numerosi vantaggi in termini di manutenibilità, testabilità e scalabilità del codice.

## Implementazione Standard

### Struttura Base

```php
declare(strict_types=1);

namespace Modules\ModuleName\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateExampleAction
{
    use QueueableAction;

    public function execute(ExampleData $data): Example
    {
        // Implementazione
    }
}
```

### Vantaggi Principali

1. **Responsabilità Singola**
   - Ogni action ha uno scopo ben definito
   - Facilita la comprensione e la manutenzione
   - Migliora la leggibilità del codice

2. **Testabilità**
   - Facile da testare in isolamento
   - Dipendenze chiare e limitate
   - Mocking semplificato

3. **Accodamento**
   - Possibilità di eseguire in background
   - Gestione automatica delle code
   - Retry in caso di fallimento

4. **Composizione**
   - Combinare actions per operazioni complesse
   - Riutilizzo del codice
   - Separazione delle responsabilità

## Best Practices

### 1. Naming Conventions

- Utilizzare nomi che descrivono l'azione (verbo + sostantivo)
- Esempi: `CreateUserAction`, `UpdateProfileAction`, `SendNotificationAction`

### 2. Dependency Injection

```php
declare(strict_types=1);

class SendNotificationAction
{
    use QueueableAction;

    public function __construct(
        private readonly NotificationService $notificationService,
    ) {}

    public function execute(NotificationData $data): void
    {
        $this->notificationService->send($data);
    }
}
```

### 3. Integrazione con Data Objects

```php
declare(strict_types=1);

class UpdateUserAction
{
    use QueueableAction;

    public function execute(UserData $userData): User
    {
        $user = User::findOrFail($userData->id);
        
        $user->update([
            'name' => $userData->name,
            'email' => $userData->email,
        ]);
        
        return $user;
    }
}
```

### 4. Accodamento

```php
// Nel controller o in un'altra action
$updateUserAction->onQueue('users')->execute($userData);
```

### 5. Composizione di Actions

```php
declare(strict_types=1);

class RegisterUserAction
{
    use QueueableAction;

    public function __construct(
        private readonly CreateUserAction $createUserAction,
        private readonly SendWelcomeEmailAction $sendWelcomeEmailAction,
    ) {}

    public function execute(UserData $userData): User
    {
        $user = $this->createUserAction->execute($userData);
        $this->sendWelcomeEmailAction->execute($user);
        
        return $user;
    }
}
```

## Testing

```php
declare(strict_types=1);

class CreateUserActionTest extends TestCase
{
    public function test_creates_user_correctly(): void
    {
        // Arrange
        $action = app(CreateUserAction::class);
        $userData = new UserData(
            name: 'Test User',
            email: 'test@example.com',
        );
        
        // Act
        $user = $action->execute($userData);
        
        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }
}
```

## Confronto con i Services

| Aspetto | QueueableActions | Services |
|---------|------------------|----------|
| Responsabilità | Singola, ben definita | Spesso multiple |
| Testabilità | Alta | Media |
| Accodamento | Integrato | Richiede implementazione |
| Riutilizzo | Facile | Variabile |
| Manutenibilità | Alta | Media |
| Comprensibilità | Alta | Media |

## Casi d'Uso Comuni

1. **Operazioni CRUD**
   - `CreateResourceAction`
   - `UpdateResourceAction`
   - `DeleteResourceAction`

2. **Processi di Business**
   - `ApproveRequestAction`
   - `CalculateTotalsAction`
   - `GenerateReportAction`

3. **Integrazioni Esterne**
   - `SyncWithExternalServiceAction`
   - `ImportDataAction`
   - `ExportDataAction`

4. **Notifiche**
   - `SendEmailAction`
   - `SendPushNotificationAction`
   - `SendSmsAction`

## Conclusioni

L'utilizzo di Spatie QueueableActions rappresenta un approccio moderno e efficace alla gestione della logica di business in Laravel. Questo pattern promuove la scrittura di codice pulito, testabile e manutenibile, allineandosi perfettamente con i principi di Domain-Driven Design e SOLID. 