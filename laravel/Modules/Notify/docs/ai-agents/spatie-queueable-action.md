# Spatie Queueable Action

**REGOLA ASSOLUTA**: MAI creare Service classes. Tutta la business logic va in QueueableAction.

Riferimento operativo per `spatie/laravel-queueable-action`, allineato al package installato nel progetto e al README ufficiale.

## Versione verificata

- Package installato: `spatie/laravel-queueable-action` `2.17.0`
- Compatibilita` dichiarata dal package: Laravel `^8|^9|^10|^11|^12|^13`, PHP `^8.0`

## Cosa offre davvero il package

- Trait `Spatie\QueueableAction\QueueableAction` da usare nelle action class.
- Dispatch asincrono via `onQueue(?string $queue)->execute(...$parameters)`.
- Supporto sia ad action con metodo `execute()` sia con `__invoke()`.
- Constructor injection pienamente supportata: quando il job viene eseguito, l'action viene ricreata tramite container.
- Testing helper `Spatie\QueueableAction\Testing\QueueableActionFake`.
- Composizione di chain tramite `Spatie\QueueableAction\ActionJob`.

## Contratto reale dell'action

```php
use Spatie\QueueableAction\QueueableAction;

final class SendReportAction
{
    use QueueableAction;

    public function __construct(
        private readonly ReportBuilder $builder,
    ) {}

    public function execute(SurveyPdf $surveyPdf): void
    {
        $this->builder->build($surveyPdf);
    }
}
```

Uso:

```php
app(SendReportAction::class)->execute($surveyPdf);
app(SendReportAction::class)->onQueue('reports')->execute($surveyPdf);
```

## Metodi e hook supportati

Il trait e `ActionJob` riconoscono questi punti di estensione:

- `execute()` oppure `__invoke()` come entrypoint dell'action
- `tags(): array` per Horizon tags
- `middleware(): array` per queue middleware
- `backoff(): int|array` oppure proprieta` `$backoff`
- `retryUntil(): \DateTime|null`
- `failed(Throwable $exception)` callback sul fallimento

Durante l'esecuzione queued, `ActionJob::handle()` imposta anche:

- `$action->job = $this->job`

Quindi e` possibile accedere al job runtime dall'action se serve un contesto avanzato.

## Proprietà queue trasferite automaticamente

`ActionJob` copia dall'action queste proprieta` queueable quando esistono:

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

Regola pratica: se un comportamento e` una feature nativa dei job Laravel, prima verifica se basta dichiarare la relativa proprieta` direttamente sull'action.

## Chaining corretto

Per concatenare altre action queued usare `ActionJob`:

```php
use Spatie\QueueableAction\ActionJob;

$args = [$surveyPdfId, $payload];

app(GeneratePdfAction::class)
    ->onQueue('pdf')
    ->execute(...$args)
    ->chain([
        new ActionJob(SendPdfNotificationAction::class, $args),
    ]);
```

## Testing corretto

```php
use Illuminate\Support\Facades\Queue;
use Spatie\QueueableAction\Testing\QueueableActionFake;

Queue::fake();

app(SendReportAction::class)->onQueue('reports')->execute($surveyPdf);

QueueableActionFake::assertPushed(SendReportAction::class);
QueueableActionFake::assertPushedTimes(SendReportAction::class, 1);
```

Note:

- chiamare sempre `Queue::fake()` prima delle assertion helper
- `assertPushedWithChain()` e `assertPushedWithoutChain()` lavorano sulla chain di `ActionJob`

## Configurazione: attenzione al nome chiave

Il package usa intenzionalmente la chiave config:

- `queuableaction`

e il file pubblicato:

- `config/queuableaction.php`

Non correggere “a mano” in `queueableaction`: il sorgente del package legge proprio `config('queuableaction.job_class')`.

## Regole locali per questo progetto

- Preferire `execute()` come entrypoint standard del progetto.
- `__invoke()` e` supportato dal package, ma usarlo solo se c'e` un motivo concreto di interoperabilita`.
- Le action restano il contenitore principale della business logic.
- Constructor injection e` consentita quando migliora chiarezza e testabilita`.
- Per comporre action tra loro, preferire injection del collaborator o `app()` in modo coerente col contesto; evitare service layer generici.
- Se serve esecuzione async, usare `onQueue()` sull'action invece di duplicare la logica in un Job separato.
