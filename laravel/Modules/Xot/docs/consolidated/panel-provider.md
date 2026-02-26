# Panel Provider in Modulo Xot

## XotBaseMainPanelProvider

Il `XotBaseMainPanelProvider` è la classe base per tutti i Panel Provider di Filament in Laraxot. Fornisce una configurazione completa e standardizzata per l'admin panel.

### Funzionalità Include

#### Configurazione Base
- **ID Panel**: 'admin'
- **Path**: '/admin'
- **SPA**: Abilitato per Single Page Application
- **Sidebar**: Collassabile su desktop

#### Autenticazione e Sicurezza
- Login automatico (se modulo Cms non presente)
- Reset password
- Profilo utente
- Middleware di autenticazione
- Middleware di sicurezza (CSRF, Session, Cookie)

#### Scoperta Automatica
- Risorse: `app/Filament/Resources`
- Pagine: `app/Filament/Pages`
- Widget: `app/Filament/Widgets`

#### Navigazione Modulare
- Menu utente con profilo
- Navigazione automatica dai moduli
- Integrazione con sistema di permessi

### Utilizzo Corretto

```php
<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Modules\Xot\Providers\Filament\XotBaseMainPanelProvider;

class AdminPanelProvider extends XotBaseMainPanelProvider
{
    // Personalizzazioni specifiche se necessarie
    // La maggior parte della configurazione è già inclusa nella classe base
}
```

### Personalizzazioni

Se è necessario personalizzare il panel, sovrascrivere il metodo `panel()`:

```php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    // Aggiungere personalizzazioni specifiche
    $panel->theme('custom-theme');
    
    return $panel;
}
```

### Errori Comuni

1. **Non estendere XotBaseMainPanelProvider**
   - Causa: Perdita di funzionalità core
   - Soluzione: Estendere sempre XotBaseMainPanelProvider

2. **Reimplementare funzionalità esistenti**
   - Causa: Duplicazione e conflitti
   - Soluzione: Usare solo personalizzazioni specifiche

3. **Non chiamare parent::panel()**
   - Causa: Perdita di configurazione base
   - Soluzione: Sempre chiamare parent::panel()

### Best Practices

1. **SEMPRE** estendere XotBaseMainPanelProvider
2. **MAI** reimplementare middleware o autenticazione
3. **SEMPRE** chiamare parent::panel() se si sovrascrive
4. **SEMPRE** documentare personalizzazioni
5. **SEMPRE** testare dopo modifiche

### Collegamenti

- [Documentazione Root](../../../project_docs/filament_panel_provider_rules.md)
- [Architettura Filament](../../../project_docs/FILAMENT_BEST_PRACTICES.md)
- [Configurazione Moduli](../../../project_docs/MODULE_ARCHITECTURE.md)

*Ultimo aggiornamento: 2025-01-06* 