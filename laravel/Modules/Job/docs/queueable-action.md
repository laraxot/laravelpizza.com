# Standard SaluteOra: spatie/laravel-queueable-action

In tutto il progetto SaluteOra, **NON si utilizzano Service class custom**. La business logic asincrona e le azioni riutilizzabili sono gestite SEMPRE tramite [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action).

## Vantaggi rispetto ai Service

- Azioni invocabili sia sincrone che asincrone
- Testabilità e riuso
- Dispatch asincrono semplice
- Chiarezza architetturale

## Pattern di utilizzo

```php
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;
    public function execute(User $user): void
    {
        // logica
    }
}
// Sincrono
(new SendWelcomeEmailAction())->execute($user);
// Asincrono
(new SendWelcomeEmailAction())->dispatch($user);
```

## Collegamenti

- [Documentazione ufficiale](https://github.com/spatie/laravel-queueable-action)
- [README Notify](../laravel/Modules/Notify/docs/README.md)
