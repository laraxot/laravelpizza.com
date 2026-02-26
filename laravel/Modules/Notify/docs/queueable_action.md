# Spatie Laravel Queueable Action

In <nome progetto>, **NON si utilizza il pattern Service**. Per la business logic asincrona e la gestione di azioni riutilizzabili si adotta SEMPRE il package [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action).

## Vantaggi rispetto ai Service
- **Riuso**: le azioni sono invocabili, testabili e possono essere messe in coda facilmente.
- **Testabilità**: ogni azione è una classe isolata, facilmente mockabile.
- **Dispatch asincrono**: le azioni possono essere eseguite sincrone o asincrone senza cambiare la logica di invocazione.
- **Chiarezza architetturale**: pattern esplicito, niente ambiguità tra Service, Job e Command.

## Pattern di utilizzo
```php
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function execute(User $user): void
    {
        // Logica di invio email
    }
}

// Invocazione sincrona
'test@example.com');
$action = new SendWelcomeEmailAction();
$action->execute($user);

// Invocazione asincrona
$action->dispatch($user);
```

## Regola di progetto
- **Mai** usare Service class custom.
- Documentare sempre l’uso di queueable-action nei README e nelle guide.
- Collegare questa pagina da ogni README e guida tecnica del modulo.

## Collegamenti
- [Documentazione ufficiale](https://github.com/spatie/laravel-queueable-action)
- [README Notify](README.md)
