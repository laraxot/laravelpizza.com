# Filament Widgets

## Panoramica

Questa sezione documenta l'implementazione e l'utilizzo dei widget Filament nel progetto. I widget forniscono componenti riutilizzabili per dashboard e interfacce amministrative.

## Struttura

Il sistema di widget è organizzato attorno a classi base che forniscono funzionalità comuni e standardizzano l'implementazione.

## Widget Disponibili

### Widget Base

- [XotBaseWidget](/var/www/html/base_generic/laravel/Modules/Xot/docs/filament/widgets/xotbasewidget.md) - Classe base per tutti i widget

## Best Practices

1. **Estendere sempre XotBaseWidget** per mantenere coerenza
2. **Implementare autorizzazioni** appropriate per ogni widget
3. **Utilizzare caching** per widget con dati pesanti
4. **Seguire convenzioni di naming** per view e classi

## Esempi di Implementazione

```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class DashboardStatsWidget extends XotBaseWidget
{
    protected static string $view = 'dashboard::widgets.stats';
    
    protected function getData(): array
    {
        return [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('active', true)->count(),
        ];
    }
}
``` 
