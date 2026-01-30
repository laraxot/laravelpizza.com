# Modulo Xot

## Panoramica
Il modulo Xot è il modulo base del sistema che fornisce le classi astratte e le funzionalità core utilizzate da tutti gli altri moduli.

## Classi Base

### XotBaseResource
```php
namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Resource;

abstract class XotBaseResource extends Resource
{
    // Implementazione base del form
    public function form(Form $form): Form
    {
        return $form->schema([
            // Schema base
        ]);
    }

    // Implementazione base della tabella
    public function table(Table $table): Table
    {
        return $table->columns([
            // Colonne base
        ]);
    }
}
```

### XotBasePage
```php
namespace Modules\Xot\Filament\Pages;

use Filament\Pages\Page;

abstract class XotBasePage extends Page
{
    // Implementazione base dei widget
    protected function getHeaderWidgets(): array
    {
        return [
            // Widget base
        ];
    }
}
```

### XotBaseWidget
```php
namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\Widget;

abstract class XotBaseWidget extends Widget
{
    // Implementazione base del widget
}
```

### XotBaseAction
```php
namespace Modules\Xot\Filament\Actions;

use Filament\Actions\Action;

abstract class XotBaseAction extends Action
{
    // Implementazione base delle azioni
}
```

## Funzionalità Core

### Gestione Traduzioni
- Integrazione con `LangServiceProvider`
- Supporto multilingua
- Cache delle traduzioni
- Validazione delle chiavi

### Gestione Notifiche
- Integrazione con `RecordNotification`
- Supporto per email e database
- Template predefiniti
- Log delle notifiche

### Gestione Actions
- Integrazione con `Spatie/Laravel-Queueable-Action`
- Supporto per code
- Gestione errori
- Log delle azioni

## Integrazione Moduli

### Dipendenze
```json
{
    "require": {
        "modules/xot": "^1.0"
    }
}
```

### Service Provider
```php
namespace Modules\YourModule\Providers;

use Modules\Xot\Providers\XotServiceProvider;

class YourModuleServiceProvider extends XotServiceProvider
{
    // Configurazione specifica del modulo
}
```

## Best Practices

### Estensione Classi
```php
// ❌ NON FARE
class YourResource extends Resource
{
    public function form(Form $form)
    {
        return $form->schema([...]);
    }
}

// ✅ FARE
class YourResource extends XotBaseResource
{
    // Usare le implementazioni base
}
```

### Traduzioni
```php
// ❌ NON FARE
->label('Nome')

// ✅ FARE
->label(__('your-module.fields.name'))
```

### Notifiche
```php
// ❌ NON FARE
class YourNotification extends Notification

// ✅ FARE
$notification = new RecordNotification($record, 'your-module.notification');
```

## Metriche e Performance

### Cache
- Hit rate: >95%
- Tempo di caricamento: <100ms
- Memoria utilizzata: <50MB

### Queue
- Tempo medio di esecuzione: <5s
- Tasso di successo: >99%
- Retry rate: <1%

## Collegamenti
- [Documentazione API](./api.md)
- [Guida Contribuzione](./CONTRIBUTING.md)
- [Changelog](./CHANGELOG.md)

## Note
- Consultare sempre la documentazione prima di estendere le classi base
- Mantenere la retrocompatibilità
- Testare le implementazioni
- Documentare le modifiche 
