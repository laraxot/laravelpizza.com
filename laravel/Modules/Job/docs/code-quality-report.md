---
title: "code quality report"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "code quality report"
issues: []
discussions: []
---

# Code quality — modulo Job

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 156
- File di test: 33 — rapporto test/app: 21%
- File con TODO/FIXME/@deprecated: 1
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 38
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 3

### File con Facade in Actions da convertire

- Modules/Job/app/Actions/ClearScheduleCacheAction.php
- Modules/Job/app/Actions/GetTaskCommandsAction.php
- Modules/Job/app/Actions/GetActiveSchedulesAction.php

### Complessità / dimensione classi da rivedere

- Modules/Job/app/Filament/Columns/ScheduleArguments.php:58                                         CyclomaticComplexity      The method formatArrayTags() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php:56                                  CyclomaticComplexity      The method formatArrayTags() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Models/Schedule.php:182                                                           CyclomaticComplexity      The method getArguments() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Traits/FormatSeconds.php:13                                                       CyclomaticComplexity      The method formatSeconds() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.

## Stato architetturale

- Nessuna violazione `extends \Filament\...` diretto rilevata (regola XotBase rispettata).

## Azioni consigliate

- Convertire le 3 Action con Facade dirette al pattern QueueableAction (niente facade nella cartella Actions).
- Rifattorizzare i metodi/classi elencati sopra (complessità ciclomatica/NPath oltre soglia).

## Confronto con gli altri moduli (rapporto test/app)

| Modulo | app | test | % | facade-in-Actions |
|---|---|---|---|---|
| Activity | - | - | 127% | 5 |
| AI | - | - | 42% | 2 |
| Blog | - | - | 0% | 2 |
| Cms | - | - | 102% | 1 |
| Comment | - | - | 26% | 2 |
| Employee | - | - | 26% | 1 |
| Gdpr | - | - | 52% | 4 |
| Geo | - | - | 41% | 34 |
| Job | - | - | 21% | 3 |
| Lang | - | - | 30% | 3 |
| Media | - | - | 11% | 10 |
| Notify | - | - | 61% | 21 |
| Rating | - | - | 7% | 0 |
| Seo | - | - | 100% | 0 |
| TechPlanner | - | - | 2% | 0 |
| Tenant | - | - | 75% | 6 |
| UI | - | - | 34% | 4 |
| User | - | - | 23% | 4 |
| Xot | - | - | 28% | 57 |



## Come migliorare — modifiche effettive da fare

### 1. Rimuovere le Facade da `app/Actions/`

Regola del progetto (skill `queueable-action-trait`): nelle Action **niente Facade**, le dipendenze si iniettano nel costruttore — il container le risolve automaticamente quando l'Action viene chiamata con `app(XxxAction::class)->execute(...)`.

Facade usate in questo modulo e relativa dipendenza da iniettare al loro posto:

| Facade | Inietta invece |
|---|---|
| `Artisan::` | `Illuminate\Contracts\Console\Kernel` |
| `Cache::` | `Illuminate\Contracts\Cache\Repository` |

**Esempio concreto** — `Modules/Job/app/Actions/ClearScheduleCacheAction.php`:

```php
// PRIMA
use Illuminate\Support\Facades\Http;

class XxxAction
{
    use QueueableAction;

    public function execute(string $arg): mixed
    {
        $response = Http::get($url);
        // ...
    }
}

// DOPO
use Illuminate\Http\Client\Factory as HttpFactory;

class XxxAction
{
    use QueueableAction;

    public function __construct(private readonly HttpFactory $http)
    {
    }

    public function execute(string $arg): mixed
    {
        $response = $this->http->get($url);
        // ...
    }
}
```

Vantaggio pratico: l'Action diventa testabile senza `Http::fake()` globale — nei test Pest si passa un mock/fake del client via `app()->instance(HttpFactory::class, $fakeClient)` o via binding nel service provider di test.

File da convertire in questo modulo (elenco sopra in "Numeri"), uno alla volta, con `php -l` + PHPStan L max sul singolo file dopo ogni modifica.

### 2. Ridurre la complessità ciclomatica

Metodi/classi oltre soglia (10 per metodo, 50 per classe) in questo modulo:

- Modules/Job/app/Filament/Columns/ScheduleArguments.php:58                                         CyclomaticComplexity      The method formatArrayTags() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php:56                                  CyclomaticComplexity      The method formatArrayTags() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Models/Schedule.php:182                                                           CyclomaticComplexity      The method getArguments() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Traits/FormatSeconds.php:13                                                       CyclomaticComplexity      The method formatSeconds() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.

Tecnica di refactoring consigliata: **estrarre ogni ramo condizionale in un metodo privato dedicato**, o sostituire lunghe catene if/elseif con una `match()` che delega a metodi/Action più piccoli. Esempio:

```php
// PRIMA — un metodo con 15+ rami
public function resolveType(string $type): string
{
    if ($type === "a") { /* ... */ }
    elseif ($type === "b") { /* ... */ }
    // ... altri 10+ rami
}

// DOPO — dispatch table, ogni ramo è un metodo testabile singolarmente
public function resolveType(string $type): string
{
    return match ($type) {
        "a" => $this->resolveA(),
        "b" => $this->resolveB(),
        default => throw new \InvalidArgumentException("Unknown type: {$type}"),
    };
}
```

Ogni `resolveX()` estratto scende sotto soglia 10 e diventa testabile in isolamento con un test Pest dedicato.

