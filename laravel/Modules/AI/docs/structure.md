# Modulo AI

Data: 2025-04-23 19:09:55

## Informazioni generali

- **Namespace principale**: Modules\\AI
Modules\\AI\\Database\\Factories
Modules\\AI\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_ai_fila5
marco sottana
- **Dipendenze**: openai-php/laravel ^0.10.1 codewithkyrian/transformers ^0.5.2 laravel/pint ^1.13 nunomaduro/phpinsights ^2.11 larastan/larastan ^2.7 vimeo/psalm ^5.17 psalm/plugin-laravel ^2.8 enlightn/enlightn ^2.7 driftingly/rector-laravel ^0.26.2 symplify/phpstan-rules * rector/rector ^0.18.12 thecodingmachine/phpstan-safe-rule ^1.2 repositories type path url ../Xot 
- **Totale file PHP**: 24
- **Totale classi/interfacce**: 14

## Struttura delle directory

```
laravel/Modules/AI/
├── Config/
├── Console/
├── Database/
├── docs/
├── Http/
├── Models/
├── Providers/
├── Resources/
├── Routes/
├── Services/
└── Tests/
```

## Descrizione delle Directory

### Config
Contiene i file di configurazione del modulo.

### Console
Contiene i comandi Artisan personalizzati.

### Database
Contiene le migrazioni e i seeder.

### docs
Contiene la documentazione del modulo.

### Http
Contiene controller, middleware e request.

### Models
Contiene i modelli Eloquent.

### Providers
Contiene i service provider.

### Resources
Contiene viste, asset e traduzioni.

### Routes
Contiene le definizioni delle rotte.

### Services
Contiene i servizi del modulo.

### Tests
Contiene i test automatizzati.

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\AI\\": "app/",
            "Modules\\AI\\Database\\Factories\\": "database/factories/",
            "Modules\\AI\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {
        "openai-php/laravel": "^0.10.1"
    },
    "require-dev_comment": {
        "codewithkyrian/transformers": "^0.5.2",
        "laravel/pint": "^1.13",
        "nunomaduro/phpinsights": "^2.11",
        "larastan/larastan": "^2.7",
        "vimeo/psalm": "^5.17",
```

## Dipendenze da altri moduli

-       2 Modules\Xot\Filament\Pages\XotBasePage;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;
-       1 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       1 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       1 Modules\Xot\Filament\Widgets\EnvWidget;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/project_docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/project_docs/phpstan/)
- [Errori Comuni e Soluzioni](errors.md)

