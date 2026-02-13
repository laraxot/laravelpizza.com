---
description:
globs:
alwaysApply: false
---
# Linee guida per l'uso di Spatie Queueable Action

## Introduzione
Utilizzare sempre [spatie/laravel-queueable-action](mdc:https:/github.com/spatie/laravel-queueable-action) per la business logic asincrona e sincrona nei moduli. Non utilizzare mai Service custom.

## Vantaggi
- Uniformità architetturale
- Supporto nativo a queue, chaining, tagging, middleware, backoff
- Costruttore con dependency injection
- Maggiore testabilità e riusabilità

## Esempio base
```php
use Spatie\QueueableAction\QueueableAction;

class ApproveUserAction
{
    use QueueableAction;
    public function execute(User $user): void
    {
        $user->state = 'approved';
        $user->save();
    }
}

// Esecuzione
app(ApproveUserAction::class)->execute($user); // sincrona
app(ApproveUserAction::class)->onQueue()->execute($user); // asincrona
```

## Checklist di implementazione
- [ ] Usare SEMPRE le Actions per la business logic
- [ ] Non creare mai Service custom
- [ ] Usare dependency injection nel costruttore
- [ ] Scrivere test per ogni Action
- [ ] Documentare ogni Action con PHPDoc

## Testing
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
Queue::fake();
app(ApproveUserAction::class)->onQueue()->execute($user);
QueueableActionFake::assertPushed(ApproveUserAction::class);
```

## Collegamenti correlati
- [README User](mdc:README.md)
- [Best Practices](mdc:best-practices.md)
- [Filament Best Practices](mdc:filament-best-practices.md)
- [Testing](mdc:testing.md)
- [Documentazione centrale](mdc:../../../../docs/INDEX.md)

