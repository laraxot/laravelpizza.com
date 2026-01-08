# Gestione delle Traduzioni Mancanti con Spatie Laravel Translatable

Questo documento descrive come gestire i casi in cui un modello non ha una traduzione richiesta utilizzando il pacchetto `spatie/laravel-translatable`.

## Configurazione del Fallback

Il pacchetto permette di configurare diversi comportamenti in caso di traduzioni mancanti. Per configurare questi comportamenti, è necessario utilizzare la facciata `Spatie\Translatable\Facades\Translatable` in un service provider.

### Service Provider per la Configurazione

Tipicamente, questa configurazione viene inserita in un service provider dedicato:

```php
<?php

namespace Modules\Lang\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class TranslatableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureFallbacks();
    }

    protected function configureFallbacks()
    {
        Translatable::fallback(
            fallbackLocale: config('app.fallback_locale', 'en'),
            fallbackAny: true,
            missingKeyCallback: function (
                Model $model,
                string $translationKey,
                string $locale,
                string $fallbackTranslation,
                string $fallbackLocale
            ) {
                Log::warning('Traduzione mancante in un modello', [
                    'key' => $translationKey,
                    'locale' => $locale,
                    'fallback_locale' => $fallbackLocale,
                    'fallback_translation' => $fallbackTranslation,
                    'model_id' => $model->getKey(),
                    'model_class' => get_class($model),
                ]);
                
                return $fallbackTranslation; // Usa la traduzione di fallback
            }
        );
    }
}
```

## Opzioni di Fallback

### 1. Locale di Fallback Globale

Per impostazione predefinita, il sistema utilizzerà la locale di fallback definita in `config/app.php`. Tuttavia, è possibile specificare una locale di fallback differente:

```php
Translatable::fallback(
    fallbackLocale: 'it',
);
```

### 2. Locale di Fallback per Modello

Se la locale di fallback varia tra i modelli, è possibile definire un metodo `getFallbackLocale()` sul modello:

```php
<?php

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MailTemplate extends Model
{
    use HasTranslations;

    public $translatable = ['subject', 'html_template', 'text_template'];
    
    public function getFallbackLocale(): string
    {
        return $this->fallback_locale ?? config('app.fallback_locale', 'it');
    }
}
```

### 3. Fallback a Qualsiasi Traduzione Disponibile

A volte è preferibile restituire qualsiasi traduzione disponibile se né la traduzione per la locale preferita né quella di fallback sono impostate. Per abilitare questa funzionalità:

```php
Translatable::fallback(
    fallbackAny: true,
);
```

### 4. Callback per Traduzioni Mancanti

È possibile registrare una callback che viene eseguita quando una chiave di traduzione è mancante. Questo può essere utile per registrare informazioni di debug o persino per contattare un servizio remoto di traduzione:

```php
Translatable::fallback(
    missingKeyCallback: function (
        Model $model,
        string $translationKey,
        string $locale,
        string $fallbackTranslation,
        string $fallbackLocale
    ) {
        // Log della traduzione mancante
        Log::warning('Traduzione mancante', [
            'key' => $translationKey,
            'locale' => $locale,
            'model_class' => get_class($model),
        ]);
        
        // Se la callback restituisce una stringa, questa verrà usata come traduzione di fallback
        // return "Traduzione alternativa";
    }
);
```

Se la callback restituisce una stringa, questa verrà utilizzata come traduzione di fallback.

## Utilizzo con Servizi di Traduzione Automatica

È possibile integrare servizi di traduzione automatica per gestire le traduzioni mancanti. Ecco un esempio:

```php
Translatable::fallback(
    missingKeyCallback: function (
        Model $model,
        string $translationKey,
        string $locale,
        string $fallbackTranslation,
        string $fallbackLocale
    ) {
        // Chiamata a un servizio di traduzione automatica
        $translation = MyTranslationService::translate(
            $fallbackTranslation,
            $fallbackLocale,
            $locale
        );
        
        // Opzionale: salva la traduzione generata nel modello
        $translations = $model->getTranslations($translationKey);
        $translations[$locale] = $translation;
        $model->setTranslations($translationKey, $translations);
        $model->save();
        
        return $translation;
    }
);
```

## Implementazione nell'Applicazione

### 1. Configurazione nel Service Provider

Registrare il service provider in `config/app.php`:

```php
'providers' => [
    // ...
    Modules\Lang\Providers\TranslatableServiceProvider::class,
],
```

### 2. Registrazione del Service Provider nel Modulo

Aggiungere il service provider al file `module.json` del modulo Lang:

```json
{
    "name": "Lang",
    "alias": "lang",
    "providers": [
        "Modules\\Lang\\Providers\\LangServiceProvider",
        "Modules\\Lang\\Providers\\TranslatableServiceProvider"
    ]
}
```

## Modelli che Utilizzano HasTranslations nel Progetto

Nel progetto, vari modelli utilizzano il trait `HasTranslations`, tra cui:

- `Modules\Notify\Models\MailTemplate`
- `Modules\Lang\Models\Translation`
- `Modules\Cms\Models\Page`

## Collegamenti e Riferimenti

- [Documentazione Ufficiale](https://spatie.be/docs/laravel-translatable/v6/basic-usage/handling-missing-translations)
- [Repository GitHub](https://github.com/spatie/laravel-translatable)
- [Articoli correlati su Spatie](https://spatie.be/docs/laravel-translatable)

## Eventi e Testing

Durante il testing, potrebbe essere necessario modificare temporaneamente la configurazione del fallback. È possibile farlo all'interno dei test:

```php
use Spatie\Translatable\Facades\Translatable;

public function testMissingTranslations()
{
    // Configurazione temporanea per il test
    Translatable::fallback(
        fallbackLocale: 'en',
        fallbackAny: false
    );
    
    // Ripristino della configurazione dopo il test
    $this->afterApplicationCreated(function () {
        // Ripristina la configurazione originale
    });
    
    // Test...
}
```
