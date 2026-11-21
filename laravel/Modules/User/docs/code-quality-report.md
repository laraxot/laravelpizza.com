# Code quality — modulo User

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 642
- File di test: 148 — rapporto test/app: 23%
- File con TODO/FIXME/@deprecated: 115
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 193
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 4

### File con Facade in Actions da convertire

- Modules/User/app/Actions/CreateUserAction.php
- Modules/User/app/Actions/Shield/ShieldUtilsAction.php
- Modules/User/app/Actions/Otp/SendOtpByUserAction.php
- Modules/User/app/Actions/Notification/IsNotificationSchemaReadableAction.php

### Complessità / dimensione classi da rivedere

- Modules/User/app/Actions/Socialite/RetrieveSocialiteUserAction.php:22                             CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Actions/Socialite/Utils/UserNameFieldsResolver.php:67                            CyclomaticComplexity      The method determineNameField() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Console/Commands/AssignModuleCommand.php:39                                      CyclomaticComplexity      The method handle() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Console/Commands/ChangeTypeCommand.php:44                                        CyclomaticComplexity      The method handle() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php:43             CyclomaticComplexity      The method table() has a Cyclomatic Complexity of 17. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php:43             ExcessiveMethodLength     The method table() has 121 lines of code. Current threshold is set to 100. Avoid really long methods.
- Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php:168            CyclomaticComplexity      The method getTableColumns() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Resources/AuthenticationLogResource/Pages/ViewAuthenticationLog.php:28  CyclomaticComplexity      The method getInfolistSchema() has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Resources/BaseProfileResource/Pages/ListProfiles.php:29                 CyclomaticComplexity      The method getTableColumns() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Resources/OauthAccessTokenResource.php:51                               CyclomaticComplexity      The method table() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.

## Stato architetturale

- Nessuna violazione `extends \Filament\...` diretto rilevata (regola XotBase rispettata).

## Azioni consigliate

- Triage dei 115 file con TODO/FIXME aperti.
- Convertire le 4 Action con Facade dirette al pattern QueueableAction (niente facade nella cartella Actions).
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
| `File::` | `Illuminate\Filesystem\Filesystem` |
| `Hash::` | `Illuminate\Contracts\Hashing\Hasher` |
| `Log::` | `Psr\Log\LoggerInterface` |
| `Notification::` | `Illuminate\Contracts\Notifications\Dispatcher` |
| `Schema::` | `Illuminate\Database\ConnectionInterface (poi ->getSchemaBuilder())` |

**Esempio concreto** — `Modules/User/app/Actions/Shield/ShieldUtilsAction.php`:

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

- Modules/User/app/Actions/Socialite/RetrieveSocialiteUserAction.php:22                             CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Actions/Socialite/Utils/UserNameFieldsResolver.php:67                            CyclomaticComplexity      The method determineNameField() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Console/Commands/AssignModuleCommand.php:39                                      CyclomaticComplexity      The method handle() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Console/Commands/ChangeTypeCommand.php:44                                        CyclomaticComplexity      The method handle() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php:43             CyclomaticComplexity      The method table() has a Cyclomatic Complexity of 17. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php:168            CyclomaticComplexity      The method getTableColumns() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Resources/AuthenticationLogResource/Pages/ViewAuthenticationLog.php:28  CyclomaticComplexity      The method getInfolistSchema() has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Resources/BaseProfileResource/Pages/ListProfiles.php:29                 CyclomaticComplexity      The method getTableColumns() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Resources/OauthAccessTokenResource.php:51                               CyclomaticComplexity      The method table() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Widgets/EditUserWidget.php:168                                          CyclomaticComplexity      The method getFormModel() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Filament/Widgets/UsersChartWidget.php:61                                         CyclomaticComplexity      The method getData() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Http/Controllers/Auth/VerifyEmailController.php:21                               CyclomaticComplexity      The method __invoke() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Http/Controllers/Socialite/ProcessCallbackController.php:35                      CyclomaticComplexity      The method __invoke() has a Cyclomatic Complexity of 14. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Models/BaseUser.php:392                                                          CyclomaticComplexity      The method getNameAttribute() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/Providers/UserServiceProvider.php:100                                            CyclomaticComplexity      The method registerMailsNotification() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/User/app/View/Pages/ProfileEditVoltComponent.php:124                                      CyclomaticComplexity      The method updateProfile() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.

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

