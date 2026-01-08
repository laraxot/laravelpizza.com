# Implementazione di Spatie Laravel Translatable nel Progetto

Questo documento descrive come è implementato e configurato il pacchetto `spatie/laravel-translatable` nel nostro progetto, con particolare attenzione all'integrazione con i moduli esistenti e il plugin Filament.

## Integrazione con Filament

### Plugin Filament Spatie Translatable

Il progetto utilizza il plugin ufficiale `filament/spatie-laravel-translatable-plugin` per l'integrazione con Filament:

```php
// Modules/SaluteOra/app/Providers/Filament/AdminPanelProvider.php
use Filament\SpatieLaravelTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    $spatieLaravelTranslatablePlugin = SpatieLaravelTranslatablePlugin::make()
        ->defaultLocales([config('app.locale')]);
    
    $panel->plugins([$spatieLaravelTranslatablePlugin]);
    
    return $panel;
}
```

### Configurazione Multi-Locale

Il plugin è configurato in diversi moduli con supporto per italiano e inglese:

```php
// Modules/UI/app/Providers/Filament/AdminPanelProvider.php
$spatieLaravelTranslatablePlugin = SpatieLaravelTranslatablePlugin::make()
    ->defaultLocales(['it', 'en']);

// Modules/Lang/app/Providers/Filament/AdminPanelProvider.php
$spatieLaravelTranslatablePlugin = SpatieLaravelTranslatablePlugin::make()
    ->defaultLocales(['en', 'it']);
```

### Utilizzo nei Form Filament

Il plugin fornisce componenti specifici per la gestione delle traduzioni:

```php
use Filament\Forms\Components\SpatieTranslatableForms\Components\TranslatableTabs;

public static function getFormSchema(): array
{
    return [
        TranslatableTabs::make('Translations')
            ->tabs([
                'it' => Tab::make('Italiano')
                    ->schema([
                        TextInput::make('title.it')
                            ->label('Titolo')
                            ->required(),
                        Textarea::make('content.it')
                            ->label('Contenuto'),
                    ]),
                'en' => Tab::make('English')
                    ->schema([
                        TextInput::make('title.en')
                            ->label('Title')
                            ->required(),
                        Textarea::make('content.en')
                            ->label('Content'),
                    ]),
            ]),
    ];
}
```

## Integrazione con i Moduli

### Modulo Lang

Il modulo Lang funge da centralizzatore per le funzionalità di traduzione:

```
Modules/Lang/
  ├── app/
  │   ├── Models/
  │   │   ├── Translation.php            # Modello per traduzioni statiche
  │   │   └── Traits/HasStrictTranslations.php  # Estensione del trait base
  │   ├── Providers/
  │   │   ├── LangServiceProvider.php
  │   │   └── TranslatableServiceProvider.php   # Configurazione fallback
  │   └── ...
  ├── resources/
  │   ├── lang/                          # File di traduzione
  │   └── ...
  └── ...
```

### Modulo Notify

Il modulo Notify utilizza le traduzioni per elementi come template email:

```php
// Modules/Notify/app/Models/MailTemplate.php
use Spatie\Translatable\HasTranslations;

class MailTemplate extends SpatieMailTemplate
{
    use HasTranslations;
    
    public $translatable = ['subject', 'html_template', 'text_template'];
    
    // ...
}
```

## Service Provider Dedicato

Per una gestione centralizzata delle traduzioni, abbiamo creato un service provider dedicato:

```php
// Modules/Lang/app/Providers/TranslatableServiceProvider.php
namespace Modules\Lang\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class TranslatableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Translatable::fallback(
            fallbackLocale: config('app.fallback_locale', 'it'),
            fallbackAny: true,
            missingKeyCallback: function ($model, $key, $locale, $fallback, $fallbackLocale) {
                // Logica di gestione traduzioni mancanti
                return $fallback;
            }
        );
    }
}
```

## Configurazione Locale

Il file `.env` contiene la configurazione della locale predefinita:

```
APP_LOCALE=it
APP_FALLBACK_LOCALE=en
```

## Convenzioni per l'Accesso alle Traduzioni

### Nelle Viste

```php
{{ $model->getTranslation('field_name', app()->getLocale()) }}
```

### Accesso Diretto

```php
$model->field_name // Restituisce la traduzione nella locale corrente
```

### Impostazione delle Traduzioni

```php
$model->setTranslation('field_name', 'it', 'Valore in italiano');
$model->setTranslation('field_name', 'en', 'English value');
$model->save();
```

### Impostazione di Tutte le Traduzioni

```php
$model->setTranslations('field_name', [
    'it' => 'Valore in italiano',
    'en' => 'English value',
    'fr' => 'Valeur en français',
]);
```

## Gestione Traduzioni Mancanti

La gestione delle traduzioni mancanti segue questo flusso:

1. Si tenta di ottenere la traduzione nella locale corrente
2. Se non disponibile, si utilizza la locale di fallback (di default 'it')
3. Se specificato `fallbackAny: true`, si utilizza qualsiasi traduzione disponibile
4. Se configurata, viene chiamata la callback `missingKeyCallback`

## Modelli con Traduzioni nel Progetto

I seguenti modelli utilizzano il trait `HasTranslations`:

- `Modules\Notify\Models\MailTemplate`
- `Modules\Notify\Models\NotificationTemplate`
- `Modules\Cms\Models\Page`
- `Modules\Cms\Models\Menu`
- `Modules\Cms\Models\MenuItem`

## Estensioni Personalizzate

Abbiamo esteso le funzionalità base con:

- `HasStrictTranslations`: Assicura che tutte le traduzioni rispettino uno schema predefinito
- `TranslatableValidator`: Valida le traduzioni in fase di salvataggio

```php
// Modules/Lang/app/Models/Traits/HasStrictTranslations.php
trait HasStrictTranslations
{
    use HasTranslations;
    
    public function setTranslation($key, $locale, $value)
    {
        // Validazione personalizzata
        // ...
        
        return parent::setTranslation($key, $locale, $value);
    }
}
```

## Gestione Contenuti JSON

### File di Contenuto Traducibili

I contenuti JSON come quelli in `config/local/saluteora/database/content/pages/` supportano traduzioni:

```json
{
    "title": {
        "it": "Area Dottore - SaluteOra",
        "en": "Doctor Area - SaluteOra"
    },
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Benvenuto nella tua Area Dottore",
                    "subtitle": "Gestisci le tue pazienti e monitora i loro percorsi di salute orale",
                    "cta_text": "Continua la registrazione"
                }
            }
        ],
        "en": [
            {
                "type": "hero",
                "data": {
                    "title": "Welcome to your Doctor Area",
                    "subtitle": "Manage your patients and monitor their oral health pathways",
                    "cta_text": "Continue registration"
                }
            }
        ]
    }
}
```

### Regole per la Traduzione dei Contenuti

1. **Traduci solo i testi**: title, subtitle, cta_text, description
2. **Non tradurre**: view, image, widget, cta_link, type
3. **Mantieni la struttura**: replicare esattamente la struttura del blocco "it"
4. **Usa traduzioni appropriate**: adatta il contenuto al contesto culturale

## Test delle Traduzioni

Per testare correttamente le traduzioni, utilizzare:

```php
// Tests/Feature/TranslationsTest.php
public function testTranslations()
{
    $model = ModelWithTranslations::create();
    
    $model->setTranslations('name', [
        'it' => 'Nome in italiano',
        'en' => 'English name',
    ]);
    
    $this->assertEquals('Nome in italiano', $model->getTranslation('name', 'it'));
    $this->assertEquals('English name', $model->getTranslation('name', 'en'));
    
    // Test fallback
    app()->setLocale('fr');
    $this->assertEquals('Nome in italiano', $model->name); // Usa il fallback
}
```

## Collegamenti ad Altri Documenti

- [Gestione delle Traduzioni Mancanti](./gestione-traduzioni-mancanti.md)
- [Best Practices per Laravel Translatable](./best-practices.md)
- [Configurazione Laravel Localization](../../Cms/docs/localization/localization-setup.md)
- [Documentazione Ufficiale Spatie Translatable](https://spatie.be/docs/laravel-translatable/v6/basic-usage/handling-missing-translations)
- [Documentazione Plugin Filament](https://filamentphp.com/plugins/filament-spatie-translatable)
