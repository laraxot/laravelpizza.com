# Queueable Actions con Spatie in Notify

In <nome progetto>, per tutte le operazioni asincrone (invio email, preview, azioni Filament) si utilizza il package [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action). Le Queueable Actions sostituiscono i tradizionali Service/ServiceProvider, garantendo codice più modulare e dispatch asincrono via queue.

---
## Installazione
```bash
composer require spatie/laravel-queueable-action
```

## Definizione di Action
Esempio di Action per inviare una Welcome Mail:
```php
namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Notify\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailAction
{
    use QueueableAction;

    public function execute($user): void
    {
        Mail::to($user)->send(new WelcomeMail($user));
    }
}
```

## Dispatch sincrono o asincrono
- Sincrono: `SendWelcomeMailAction::run($user);`
- Asincrono: `SendWelcomeMailAction::dispatch($user);`

## Integrazione con Filament
Nelle Resource di Filament:
```php
public static function table(Table $table): Table
{
    return $table
        ->actions([
            Tables\Actions\Action::make('send_mail')
                ->label(__('notify::actions.send_mail'))
                ->action(fn (User $record) => SendWelcomeMailAction::dispatch($record))
        ]);
}
```

## Testing
```php
use Modules\Notify\Actions\SendWelcomeMailAction;

SendWelcomeMailAction::fake();
SendWelcomeMailAction::run($user);
SendWelcomeMailAction::assertRan(fn ($action) => $action->parameters === [$user]);
```

---
*Collegamenti:* 
- [Panoramica Template Email](email-template-landscape.md)
- [Deep Dive Template](email-templates-deep-dive.md)
- [Tool Analysis](codebrisk-tools-analysis.md)
