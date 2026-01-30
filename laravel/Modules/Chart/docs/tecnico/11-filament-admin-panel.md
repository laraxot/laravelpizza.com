# Filament Admin Panel Provider

## Descrizione
Il `AdminPanelProvider` è un componente fondamentale per la configurazione del pannello amministrativo di Filament in il progetto. Questo provider estende `XotBaseMainPanelProvider` e personalizza il comportamento del pannello amministrativo.

## Posizione
Il file deve essere posizionato in:
```
/var/www/html/<nome progetto>/laravel/app/Providers/Filament/AdminPanelProvider.php
```

## Struttura
```php
<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Modules\Xot\Providers\Filament\XotBaseMainPanelProvider;
use Filament\Panel;

class AdminPanelProvider extends XotBaseMainPanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel)
            // ->default()
            ;
    }
}
```

## Funzionalità

### Ereditarietà
- Estende `XotBaseMainPanelProvider` dal modulo Xot
- Mantiene la compatibilità con il sistema base di Filament
- Permette la personalizzazione del pannello amministrativo

### Configurazione
Il provider permette di configurare:
- Aspetto del pannello
- Permessi e ruoli
- Risorse disponibili
- Widget e dashboard
- Temi e personalizzazioni

## Personalizzazione
È possibile personalizzare il pannello aggiungendo configurazioni come:
```php
return parent::panel($panel)
    ->default()
    ->brandName('il progetto')
    ->favicon(asset('images/favicon.png'))
    ->colors([
        'primary' => Color::Amber,
    ])
    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
    ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
    ->pages([
        Pages\Dashboard::class,
    ])
    ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
    ->widgets([
        Widgets\AccountWidget::class,
        Widgets\FilamentInfoWidget::class,
    ])
    ->middleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        AuthenticateSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
        SubstituteBindings::class,
        DisableBladeIconComponents::class,
        DispatchServingFilamentEvent::class,
    ])
    ->authMiddleware([
        Authenticate::class,
        'verified',
    ]);
```

## Integrazione con i Moduli
Il provider si integra con:
- Modulo User per l'autenticazione
- Modulo Tenant per la gestione multi-tenant
- Altri moduli per le risorse Filament

## Best Practices
1. **Configurazione**:
   - Mantenere la configurazione pulita e organizzata
   - Utilizzare costanti per valori riutilizzabili
   - Documentare le personalizzazioni

2. **Sicurezza**:
   - Configurare correttamente i middleware
   - Gestire i permessi in modo granulare
   - Proteggere le risorse sensibili

3. **Performance**:
   - Ottimizzare il caricamento delle risorse
   - Gestire efficientemente la cache
   - Monitorare il tempo di caricamento

4. **Manutenzione**:
   - Aggiornare regolarmente le dipendenze
   - Verificare la compatibilità con i moduli
   - Testare le modifiche in ambiente di sviluppo 