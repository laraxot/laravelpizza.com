# Modelli - Modulo Chart

## Panoramica Modelli

Il modulo Chart utilizza i seguenti modelli per gestire i dati dei grafici:

## BaseModel

Tutti i modelli del modulo Chart estendono `Modules\Chart\Models\BaseModel` che a sua volta estende `Modules\Xot\Models\XotBaseModel`.

### Caratteristiche BaseModel

- **Auto-Discovery Connection**: La connessione al database viene automaticamente rilevata dal namespace
- **Casts Standardizzati**: ID, UUID, timestamps già gestiti nel parent
- **Traits Comuni**: `HasXotFactory`, `RelationX`, `Updater`

## Modelli Specifici

### ChartData

Gestisce i dati per la generazione dei grafici.

```php
namespace Modules\Chart\Models;

class ChartData extends BaseModel
{
    protected $fillable = [
        'chart_type',
        'data_points',
        'labels',
        'colors',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'data_points' => 'array',
            'labels' => 'array',
            'colors' => 'array',
        ]);
    }
}
```

## Relazioni

I modelli del modulo Chart possono avere relazioni con:

- **Modulo Quaeris**: Dati survey per grafici
- **Modulo User**: Dati utente per dashboard personalizzate
- **Modulo Activity**: Logging delle visualizzazioni grafici

## Best Practices

1. **Sempre BaseModel**: Mai estendere direttamente `Illuminate\Database\Eloquent\Model`
2. **Casts Specifici**: Aggiungere solo i cast specifici del modulo nel metodo `casts()`
3. **Connection Auto**: Non impostare manualmente `$connection` a meno che non sia necessario
4. **PHPStan Level 10**: Tutti i modelli devono passare PHPStan Level 10

## Esempio Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Models;

class ChartConfig extends BaseModel
{
    protected $fillable = [
        'name',
        'type',
        'settings',
        'is_active',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'settings' => 'array',
            'is_active' => 'boolean',
        ]);
    }

    public function getChartType(): string
    {
        return $this->type;
    }
}
```