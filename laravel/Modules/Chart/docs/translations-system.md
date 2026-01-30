# Sistema di Traduzioni

## Panoramica
Il sistema di traduzioni utilizza `LangServiceProvider` per gestire le traduzioni in modo centralizzato e efficiente.

## LangServiceProvider

### Struttura Base
```php
namespace Modules\Lang\Providers;

use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('lang', function ($app) {
            return new LangManager($app);
        });
    }

    public function boot(): void
    {
        $this->loadTranslations();
        $this->publishTranslations();
    }

    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(
            module_path('Lang', 'lang'),
            'lang'
        );
    }

    protected function publishTranslations(): void
    {
        $this->publishes([
            module_path('Lang', 'lang') => resource_path('lang/vendor/lang'),
        ], 'lang');
    }
}
```

## Implementazione

### File di Traduzione
```php
// lang/it/doctor.php
return [
    'fields' => [
        'name' => 'Nome',
        'email' => 'Email',
        'phone' => 'Telefono',
    ],
    'status' => [
        'pending' => 'In attesa',
        'approved' => 'Approvato',
        'rejected' => 'Rifiutato',
    ],
    'messages' => [
        'created' => 'Odontoiatra creato con successo',
        'updated' => 'Odontoiatra aggiornato con successo',
        'deleted' => 'Odontoiatra eliminato con successo',
    ],
];
```

### Utilizzo Traduzioni
```php
// ❌ NON FARE MAI
->label('Nome')  // VIETATO: stringa hardcoded
->label(__('doctor.fields.name'))  // VIETATO: qualsiasi ->label()

// ✅ SEMPRE FARE
TextInput::make('name'),  // Traduzione automatica tramite LangServiceProvider
TextInput::make('email'), // Nessun ->label(), gestione centralizzata
```

### Cache
```php
// Cache delle traduzioni
Cache::remember('translations', 3600, function () {
    return Lang::get('doctor');
});

// Invalidazione cache
Cache::forget('translations');
```

## Best Practices

### Organizzazione
- Raggruppare per modulo
- Usare chiavi descrittive
- Mantenere la struttura consistente

### Validazione
- Verificare chiavi mancanti
- Controllare parametri
- Validare formati

### Performance
- Utilizzare cache
- Lazy loading
- Compressione

## Metriche

### Performance
- Hit rate cache: >95%
- Tempo di caricamento: <50ms
- Memoria utilizzata: <10MB

### Qualità
- Copertura traduzioni: 100%
- Chiavi mancanti: 0
- Errori di formato: 0

## Collegamenti
- [Documentazione API](./api.md)
- [Guida Contribuzione](./CONTRIBUTING.md)
- [Template Traduzioni](./templates.md)

## Note
- Mantenere le traduzioni aggiornate
- Testare in tutte le lingue
- Monitorare la performance
- Documentare le modifiche 
