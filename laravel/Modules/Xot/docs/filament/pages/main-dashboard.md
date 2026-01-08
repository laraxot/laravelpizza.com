# MainDashboard

La classe `MainDashboard` è una pagina Filament che estende la dashboard predefinita per fornire funzionalità di reindirizzamento basate sui ruoli dell'utente.

## Caratteristiche Principali

- Estende `Filament\Pages\Dashboard`
- Gestisce il reindirizzamento automatico basato sui ruoli dell'utente
- Supporta la navigazione multi-modulo
- Integrazione con il sistema di autorizzazioni

## Configurazione

```php
protected static ?string $navigationIcon = 'heroicon-o-home';
protected static string $view = 'xot::filament.pages.dashboard';
protected static ?string $title = 'Main Dashboard';
protected static ?int $navigationSort = 1;
```

## Logica di Reindirizzamento

Il metodo `mount()` implementa la seguente logica:

1. Se l'utente ha un solo ruolo admin:
   - Estrae il nome del modulo dal ruolo
   - Reindirizza all'area admin del modulo specifico

2. Se l'utente non ha ruoli admin:
   - Reindirizza alla homepage nella lingua corrente

## Best Practices

- Utilizzare sempre `Assert` per validare gli oggetti null-safe
- Mantenere la coerenza nella struttura dei ruoli (formato: `{module}::admin`)
- Gestire correttamente i casi edge di autorizzazione

## Dipendenze

- Filament Pages
- Illuminate Support
- Webmozart Assert

## Esempio di Utilizzo

```php
use Modules\Xot\Filament\Pages\MainDashboard;

// La dashboard viene registrata automaticamente in Filament
// e gestisce i reindirizzamenti in base ai ruoli dell'utente
```

## Note di Sviluppo

- La vista associata deve essere definita in `xot::filament.pages.dashboard`
- L'icona di navigazione utilizza Heroicons
- La priorità di navigazione è impostata a 1 per massima visibilità

## Link Correlati

- [Documentazione Filament](../../../docs/filament/index.md)
- [Sistema di Autorizzazioni](../../../docs/auth/index.md)
- [Gestione Ruoli](../../../docs/auth/roles.md) 