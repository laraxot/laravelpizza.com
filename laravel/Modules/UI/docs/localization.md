# Localizzazione UI

## Integrazione con Laravel Localization

Il modulo UI utilizza il pacchetto [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) per gestire la localizzazione dell'applicazione, integrato con Filament e Folio.

### Architettura

Il progetto utilizza:
- **Filament** per la gestione del backend e delle risorse
- **Folio** per la gestione delle pagine e delle rotte
- **Laravel Localization** per la gestione delle traduzioni

### Configurazione

La configurazione si trova in `Modules/UI/config/laravellocalization.php` e include:

1. **Lingue Supportate**
   - Italiano (it)
   - Inglese (en)

2. **Rilevamento Lingua**
   - Browser
   - Header Accept-Language
   - Sessione
   - Cookie
   - Query String
   - Route

3. **Selezione Lingua**
   - URL con prefisso lingua
   - Header Accept-Language
   - Sessione
   - Cookie
   - Query String
   - Route

4. **Redirect Lingua**
   - Redirect alla lingua predefinita
   - Redirect se la lingua non è supportata
   - Redirect se la lingua non è nelle lingue supportate

### Utilizzo

#### Nelle View (Folio)

```blade
{{-- Ottieni la lingua corrente --}}
{{ LaravelLocalization::getCurrentLocale() }}

{{-- Ottieni l'URL localizzato --}}
{{ LaravelLocalization::getLocalizedURL('en', 'about') }}

{{-- Ottieni le lingue supportate --}}
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

#### Nelle Risorse Filament

```php
use Filament\Resources\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ExampleResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return LaravelLocalization::getCurrentLocale() === 'it' ? 'Esempio' : 'Example';
    }
}
```

### Best Practices

1. **Architettura**
   - Utilizzare Filament per la gestione del backend
   - Utilizzare Folio per la gestione delle pagine
   - Non creare controller o rotte manualmente
   - Non modificare `web.php`

2. **URL**
   - Utilizzare sempre `LaravelLocalization::getLocalizedURL()` per generare URL localizzati
   - Non hardcodare i prefissi delle lingue negli URL

3. **View**
   - Utilizzare le traduzioni di Laravel (`__()`, `trans()`)
   - Non hardcodare testi nelle view
   - Utilizzare i componenti Blade per la riusabilità

4. **Filament**
   - Localizzare le etichette delle risorse
   - Localizzare i campi dei form
   - Localizzare i messaggi di validazione

5. **Folio**
   - Organizzare le pagine per lingua
   - Utilizzare i middleware di localizzazione
   - Gestire i redirect con `LaravelLocalization::getLocalizedURL()`

### Struttura Directory

```
Modules/UI/
├── app/
│   ├── Filament/
│   │   └── Resources/        # Risorse Filament localizzate
│   └── Providers/           # Service Provider
├── config/
│   └── laravellocalization.php
├── resources/
│   ├── lang/               # File di traduzione
│   │   ├── it/
│   │   └── en/
│   └── views/
│       └── components/     # Componenti Blade
└── docs/
    └── LOCALIZATION.md     # Documentazione
```

### Collegamenti Correlati
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Guida Componenti](./COMPONENTS_GUIDE.md)
