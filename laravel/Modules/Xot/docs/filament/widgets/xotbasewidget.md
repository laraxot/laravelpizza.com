# XotBaseWidget

## Panoramica

XotBaseWidget è la classe base per tutti i widget Filament nel progetto. Fornisce funzionalità comuni e standardizza l'implementazione dei widget.

## Caratteristiche

- Estende la classe base di Filament Widget
- Fornisce metodi comuni per tutti i widget
- Gestisce la configurazione standard dei widget
- Implementa pattern di sicurezza e autorizzazioni

## Utilizzo

```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyCustomWidget extends XotBaseWidget
{
    protected static string $view = 'my-module::widgets.my-custom-widget';
    
    protected function getData(): array
    {
        return [
            'data' => $this->getWidgetData(),
        ];
    }
}
```

## Riferimenti

- [Documentazione Filament Widgets](/var/www/html/base_generic/laravel/Modules/Xot/docs/filament/widgets/index.md)
- [XotBaseWidget](/var/www/html/base_generic/laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php) 
