# Spatie QueueableAction

## Fonte studiata

Analisi basata su:
- README ufficiale del package `spatie/laravel-queueable-action`
- codice installato in `vendor/spatie/laravel-queueable-action`

## Cosa supporta davvero il package

### Constructor DI

Il package **supporta** la constructor injection per dipendenze risolvibili dal container.

Pattern valido:

```php
class MyAction
{
    use QueueableAction;

    public function __construct(
        private readonly OtherAction $otherAction,
        private readonly SomeService $service,
    ) {
    }

    public function execute(MyModel $model): void
    {
        // ...
    }
}
```

Per l'esecuzione queued, `ActionJob` salva il nome della classe e poi in `handle()` esegue:

```php
$action = app($this->actionClass);
```

Quindi il vincolo reale non e` "no constructor DI", ma:

- l'action deve essere **instanziabile dal container**
- niente costruttori privati/singleton statici se l'action puo` andare in coda
- le dipendenze del costruttore devono essere risolvibili dal container

### Metodo eseguito

Il trait seleziona automaticamente:
- `__invoke()` se esiste
- altrimenti `execute()`

Nel progetto continuiamo a preferire `execute()` come convenzione primaria, ma `__invoke()` e` compatibile col package.

### Queue dispatch

Pattern base:

```php
app(MyAction::class)->onQueue()->execute($arg1, $arg2);
app(MyAction::class)->onQueue('my-queue')->execute($arg1, $arg2);
```

### Queue metadata supportata

`ActionJob` copia e usa queste proprieta`/hook dell'action quando presenti:

- `connection`
- `queue`
- `chainConnection`
- `chainQueue`
- `delay`
- `chained`
- `tries`
- `timeout`
- `maxExceptions`
- `retryUntil`
- `tags()`
- `middleware()`
- `backoff()` o proprieta` `$backoff`
- `failed(Throwable $exception)`

### Chaining corretto

Per concatenare altre queueable actions bisogna usare `ActionJob`:

```php
use Spatie\QueueableAction\ActionJob;

$args = [$userId, $payload];

app(MyAction::class)
    ->onQueue()
    ->execute(...$args)
    ->chain([
        new ActionJob(AnotherAction::class, $args),
    ]);
```

### Testing corretto

Per verificare il dispatch queued:

```php
Queue::fake();

app(MyAction::class)->onQueue()->execute($data);

QueueableActionFake::assertPushed(MyAction::class);
```

## Regole operative per questo progetto

1. Usare le Actions per business logic riutilizzabile, non Services generici.
2. E` consentita constructor DI nelle Actions se le dipendenze sono container-safe.
3. Se un'action usa `QueueableAction` ed e` potenzialmente queued, **non** usare costruttore privato o pattern singleton statico.
4. I parametri passati a `onQueue()->execute(...)` devono essere serializzabili o compatibili con `SerializesModels`.
5. Se un'action e` volutamente statica/singleton e non container-instantiable, non trattarla come queueable action standard.
6. Per testare il dispatch usare `Queue::fake()` + `QueueableActionFake`, non assert artigianali sul job wrapper.
7. Ricordare che la config del package usa la chiave `queuableaction.job_class` (con spelling del package), non `queueableaction.job_class`.

## Anti-pattern da evitare

- `app(StaticSingletonAction::class)` con costruttore privato
- passare servizi/container objects dentro `onQueue()->execute(...)`
- affermare che "Spatie QueueableAction vieta constructor DI"
- usare chaining manuale senza `ActionJob`
