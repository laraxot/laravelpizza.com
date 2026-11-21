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

# Code quality — modulo Media

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 117
- File di test: 14 — rapporto test/app: 11%
- File con TODO/FIXME/@deprecated: 0
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 49
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 10

### File con Facade in Actions da convertire

- Modules/Media/app/Actions/SaveAttachmentsAction.php
- Modules/Media/app/Actions/Diagnostic/S3/TestFileUploadDownloadAction.php
- Modules/Media/app/Actions/Diagnostic/S3/RunS3SaveTestAction.php
- Modules/Media/app/Actions/Image/Merge.php
- Modules/Media/app/Actions/Subtitle/ParseSubtitleXmlAction.php
- Modules/Media/app/Actions/Subtitle/ExtractSubtitlePlainTextAction.php
- Modules/Media/app/Actions/Stream/StreamVideoAction.php
- Modules/Media/app/Actions/Video/GetVideoDurationAction.php
- Modules/Media/app/Actions/Video/GetVideoFrameContentAction.php
- Modules/Media/app/Actions/Video/ConvertVideoAction.php

### Complessità / dimensione classi da rivedere

- Modules/Media/app/Filament/Actions/AddAttachmentAction.php:70                                     CyclomaticComplexity      The method formHandlerCallback() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php:38                                      TooManyPublicMethods      The class S3Test has 12 public methods. Consider refactoring S3Test to keep number of public methods under 10.
- Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php:38                                      ExcessiveClassComplexity  The class S3Test has an overall complexity of 60 which is very high. The configured complexity threshold is 50.
- Modules/Media/app/Filament/Infolists/VideoEntry.php:18                                            TooManyPublicMethods      The class VideoEntry has 18 public methods. Consider refactoring VideoEntry to keep number of public methods under 10.
- Modules/Media/app/Filament/Infolists/VideoEntry.php:18                                            ExcessiveClassComplexity  The class VideoEntry has an overall complexity of 77 which is very high. The configured complexity threshold is 50.
- Modules/Media/app/Filament/Resources/HasMediaResource/Actions/AddAttachmentAction.php:88          CyclomaticComplexity      The method formHandlerCallback() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Media/app/Filament/Tables/Columns/CloudFrontIconMediaColumn.php:13                        CyclomaticComplexity      The method setUp() has a Cyclomatic Complexity of 16. The configured cyclomatic complexity threshold is 10.
- Modules/Media/app/Filament/Tables/Columns/IconMediaColumn.php:14                                  CyclomaticComplexity      The method setUp() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.

## Stato architetturale

- Nessuna violazione `extends \Filament\...` diretto rilevata (regola XotBase rispettata).

## Azioni consigliate

- **Priorità alta**: copertura test sotto il 20%, aggiungere test Pest Feature/Unit sui path critici.
- Convertire le 10 Action con Facade dirette al pattern QueueableAction (niente facade nella cartella Actions).
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
| OperationsDomain | - | - | 2% | 0 |
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
| `Auth::` | `Illuminate\Contracts\Auth\Factory` |
| `Cache::` | `Illuminate\Contracts\Cache\Repository` |
| `File::` | `Illuminate\Filesystem\Filesystem` |
| `Storage::` | `Illuminate\Contracts\Filesystem\Factory` |

**Esempio concreto** — `Modules/Media/app/Actions/Diagnostic/S3/TestFileUploadDownloadAction.php`:

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

- Modules/Media/app/Filament/Actions/AddAttachmentAction.php:70                                     CyclomaticComplexity      The method formHandlerCallback() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php:38                                      ExcessiveClassComplexity  The class S3Test has an overall complexity of 60 which is very high. The configured complexity threshold is 50.
- Modules/Media/app/Filament/Infolists/VideoEntry.php:18                                            ExcessiveClassComplexity  The class VideoEntry has an overall complexity of 77 which is very high. The configured complexity threshold is 50.
- Modules/Media/app/Filament/Resources/HasMediaResource/Actions/AddAttachmentAction.php:88          CyclomaticComplexity      The method formHandlerCallback() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Media/app/Filament/Tables/Columns/CloudFrontIconMediaColumn.php:13                        CyclomaticComplexity      The method setUp() has a Cyclomatic Complexity of 16. The configured cyclomatic complexity threshold is 10.
- Modules/Media/app/Filament/Tables/Columns/IconMediaColumn.php:14                                  CyclomaticComplexity      The method setUp() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.

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

### 3. Alzare la copertura test (attualmente 11%)

Struttura minima di un test Pest per un'Action di questo modulo (adattare namespace/nome):

```php
<?php

declare(strict_types=1);

use Modules\Media\Actions\ExampleAction;

it('esegue la logica attesa con input valido', function () {
    $result = app(ExampleAction::class)->execute($validInput);

    expect($result)->not->toBeNull();
});

it('gestisce input non valido senza eccezioni non gestite', function () {
    app(ExampleAction::class)->execute($invalidInput);
})->throws(\InvalidArgumentException::class);
```

Priorità di stesura: prima le Action richiamate da Filament Resource/Livewire (più esposte a input utente), poi i Model con business logic negli accessor/scope, infine helper puri.
