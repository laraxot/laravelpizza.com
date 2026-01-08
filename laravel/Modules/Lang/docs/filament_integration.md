# Integrazione di mcamara/laravel-localization con Filament

## Indice
1. [Introduzione](#introduzione)
2. [Configurazione Iniziale](#configurazione-iniziale)
   - [Installazione di Filament](#installazione-di-filament)
   - [Configurazione di Laravel-Localization](#configurazione-di-laravel-localization)
3. [Traduzione delle Risorse Filament](#traduzione-delle-risorse-filament)
4. [Middleware per Filament](#middleware-per-filament)
5. [Plugin per la Gestione delle Lingue](#plugin-per-la-gestione-delle-lingue)
6. [Testing](#testing)
7. [Best Practice](#best-practice)
8. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

L'integrazione di `mcamara/laravel-localization` con Filament richiede un approccio specifico per garantire che il pannello di amministrazione supporti correttamente il multilingua. Questa guida ti mostrerà come implementare la localizzazione in Filament mantenendo la coerenza con il resto dell'applicazione.

## Configurazione Iniziale

### Installazione di Filament

```bash
composer require filament/filament
php artisan filament:install --panels
```

### Configurazione di Laravel-Localization

Assicurati di avere `mcamara/laravel-localization` installato e configurato:

```bash
composer require mcamara/laravel-localization
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

## Traduzione delle Risorse Filament

### Creazione dei File di Traduzione

Crea i file di traduzione per Filament nella cartella delle lingue:

```php
// resources/lang/it/filament.php

return [
    'navigation' => [
        'label' => 'Navigazione',
        'group' => 'Sistema',
    ],
    // Altre traduzioni per Filament...
];
```

### Traduzione delle Risorse

Per tradurre le risorse Filament, utilizza i metodi di localizzazione di Laravel:

```php
// app/Filament/Resources/PostResource.php

public static function getModelLabel(): string
{
    return __('filament.resources.posts.label');
}

public static function getPluralModelLabel(): string
{
    return __('filament.resources.posts.plural_label');
}
```

## Middleware per Filament

Crea un middleware per gestire la localizzazione nel pannello di amministrazione:

```php
// app/Http/Middleware/FilamentLocalization.php

namespace App\Http\Middleware;

use Closure;
use Mcamara\LaravelLocalization\LaravelLocalization;

class FilamentLocalization
{
    protected $localization;

    public function __construct(LaravelLocalization $localization)
    {
        $this->localization = $localization;
    }

    public function handle($request, Closure $next)
    {
        // Imposta la lingua in base alla preferenza dell'utente o alla lingua predefinita
        $locale = auth()->user()->locale ?? config('app.locale');
        
        if (in_array($locale, array_keys($this->localization->getSupportedLocales()))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
```

Registra il middleware nel pannello Filament:

```php
// app/Providers/Filament/AdminPanelProvider.php

use App\Http\Middleware\FilamentLocalization;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->middleware([
            // ...
            FilamentLocalization::class,
        ])
        // ...
}
```

## Plugin per la Gestione delle Lingue

Crea un plugin Filament per gestire il cambio lingua:

```php
// app/Filament/Plugins/LanguageSwitcher.php

namespace App\Filament\Plugins;

use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Widgets\Widget;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageSwitcher extends \Filament\Support\Plugin
{
    use EvaluatesClosures;

    protected string $widget = \App\Filament\Widgets\LanguageSwitcherWidget::class;
    
    protected string $view = 'filament.plugins.language-switcher';
    
    public static function make(): static
    {
        return app(static::class);
    }
    
    public function getSupportedLocales(): array
    {
        return LaravelLocalization::getSupportedLocales();
    }
    
    public function boot(Panel $panel): void
    {
        $panel->renderHook(
            'panels::user-menu.before',
            fn () => view($this->view, [
                'locales' => $this->getSupportedLocales(),
                'currentLocale' => app()->getLocale(),
            ])
        );
    }
}
```

Crea il widget per il cambio lingua:

```php
// app/Filament/Widgets/LanguageSwitcherWidget.php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageSwitcherWidget extends Widget
{
    protected static string $view = 'filament.widgets.language-switcher';
    
    public function getSupportedLocales(): array
    {
        return LaravelLocalization::getSupportedLocales();
    }
}
```

Crea la vista per il widget:

```blade
<!-- resources/views/filament/widgets/language-switcher.blade.php -->

@php
    $locales = $this->getSupportedLocales();
    $currentLocale = app()->getLocale();
@endphp

@if(count($locales) > 1)
    <div class="flex items-center space-x-2">
        @foreach($locales as $localeCode => $properties)
            <a 
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                class="px-2 py-1 text-sm font-medium rounded-md {{ $currentLocale === $localeCode ? 'bg-primary-500 text-white' : 'text-gray-600 hover:text-gray-900' }}"
            >
                {{ strtoupper($localeCode) }}
            </a>
        @endforeach
    </div>
@endif
```

Registra il plugin in `AdminPanelProvider`:

```php
// app/Providers/Filament/AdminPanelProvider.php

use App\Filament\Plugins\LanguageSwitcher;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->plugins([
            LanguageSwitcher::make(),
        ])
        // ...
}
```

## Testing

### Test per il Middleware

```php
// tests/Feature/FilamentLocalizationTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentLocalizationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_sets_locale_based_on_user_preference()
    {
        $user = User::factory()->create([
            'locale' => 'it',
        ]);
        
        $response = $this->actingAs($user)
            ->get('/admin');
            
        $response->assertStatus(200);
        $this->assertEquals('it', app()->getLocale());
    }
    
    /** @test */
    public function it_falls_back_to_default_locale()
    {
        $user = User::factory()->create([
            'locale' => 'xx', // Lingua non supportata
        ]);
        
        $response = $this->actingAs($user)
            ->get('/admin');
            
        $response->assertStatus(200);
        $this->assertEquals(config('app.locale'), app()->getLocale());
    }
}
```

## Best Practice

1. **Separazione delle Preoccupazioni**
   - Mantieni le stringhe di interfaccia utente nei file di traduzione
   - Usa i middleware per gestire la logica di localizzazione

2. **Performance**
   - Cache le traduzioni in produzione
   - Carica solo le traduzioni necessarie per il contesto corrente

3. **Accessibilità**
   - Assicurati che il selettore della lingua sia facilmente accessibile
   - Fornisci feedback visivi chiari sulla lingua attiva

4. **Manutenzione**
   - Documenta tutte le chiavi di traduzione utilizzate
   - Mantieni i file di traduzione organizzati per contesto

## Risoluzione Problemi

### Le traduzioni non vengono visualizzate
- Verifica che i file di traduzione siano nella cartella corretta
- Controlla che le chiavi di traduzione siano corrette
- Esegui `php artisan view:clear` e `php artisan cache:clear`

### Problemi con il cambio lingua
- Assicurati che il middleware sia registrato correttamente
- Verifica che le lingue supportate siano configurate in `config/laravellocalization.php`
- Controlla i log di errore per eventuali eccezioni

### Problemi con Filament
- Verifica che la versione di Filament sia compatibile con la tua versione di Laravel
- Controlla la documentazione ufficiale di Filament per aggiornamenti sulle funzionalità di localizzazione
- Assicurati di aver pubblicato le risorse di Filament con `php artisan filament:upgrade`
