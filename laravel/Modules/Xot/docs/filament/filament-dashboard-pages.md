# Pagine Dashboard Filament - Documentazione Root

## Panoramica

Questo documento definisce le regole e best practices per l'implementazione delle pagine Dashboard in tutti i moduli Filament di Laraxot/PTVX.

## Regola Fondamentale

**TUTTI i moduli che hanno `AdminPanelProvider` nel `module.json` DEVONO avere il file `app/Filament/Pages/Dashboard.php`.**

## Motivazione

1. **Coerenza**: Garantisce un'interfaccia amministrativa uniforme
2. **Navigabilità**: Fornisce un punto di ingresso chiaro per ogni modulo
3. **Manutenibilità**: Standardizza la struttura dei moduli Filament
4. **User Experience**: Migliora l'esperienza utente con dashboard dedicate

## Analisi Completa dei Moduli

### ✅ Moduli con Dashboard Completa (21 moduli)
I seguenti moduli hanno sia `AdminPanelProvider` che `Dashboard.php`:
- Activity
- Badge
- Gdpr
- Incentivi
- IndennitaCondizioniLavoro
- IndennitaResponsabilita
- Job
- Lang
- Media
- Notify
- Pdnd
- Performance
- Progressioni
- Ptv
- Rating
- Setting
- Sigma
- Tenant
- UI
- User

### ❌ Moduli che Necessitano Dashboard (13 moduli)
I seguenti moduli hanno `AdminPanelProvider` ma **mancano** del file `Dashboard.php`:

- **CertFisc** - Certificazioni Fiscali
- **ContoAnnuale** - Conto Annuale
- **Europa** - Gestione Europa
- **Inail** - Gestione INAIL
- **Legge104** - Gestione Legge 104
- **Legge109** - Gestione Legge 109
- **Mensa** - Gestione Mensa
- **MobilitaVolontaria** - Mobilità Volontaria
- **Prenotazioni** - Sistema Prenotazioni
- **PresenzeAssenze** - Gestione Presenze e Assenze
- **Questionari** - Sistema Questionari
- **Sindacati** - Gestione Sindacati
- **Xot** - Modulo Core (può non necessitare dashboard)

## Struttura Standard

### Template Base
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = '{modulename}::filament.pages.dashboard';
}
```

### Template con Widget
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Modules\{ModuleName}\Filament\Widgets;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    public function getWidgets(): array
    {
        return [
            Widgets\StatsOverviewWidget::class,
            Widgets\LatestRecordsWidget::class,
        ];
    }
}
```

## Procedura di Implementazione

### 1. Verifica Prerequisiti
```bash
# Verificare che il modulo abbia AdminPanelProvider
grep -q "AdminPanelProvider" laravel/Modules/{ModuleName}/module.json
```

### 2. Creazione Directory
```bash
mkdir -p laravel/Modules/{ModuleName}/app/Filament/Pages
```

### 3. Creazione File Dashboard.php
```bash
# Creare il file con la struttura standard
touch laravel/Modules/{ModuleName}/app/Filament/Pages/Dashboard.php
```

### 4. Creazione View
```bash
mkdir -p laravel/Modules/{ModuleName}/resources/views/filament/pages
touch laravel/Modules/{ModuleName}/resources/views/filament/pages/dashboard.blade.php
```

## Checklist di Verifica

### ✅ Controlli Obbligatori
- [ ] Modulo ha `AdminPanelProvider` in `module.json`
- [ ] File `app/Filament/Pages/Dashboard.php` esiste
- [ ] Namespace corretto: `Modules\{ModuleName}\Filament\Pages`
- [ ] `declare(strict_types=1);` presente
- [ ] Estende classe appropriata (Page, Dashboard, o XotBasePage)
- [ ] Icona di navigazione definita
- [ ] Vista associata definita

### ✅ Controlli di Qualità
- [ ] Passa PHPStan livello 9+
- [ ] Segue convenzioni PSR-12
- [ ] Documentazione PHPDoc completa
- [ ] Traduzioni presenti nei file di lingua
- [ ] View utilizza `<x-filament::page>` wrapper

## Script di Verifica e Creazione

### Verifica Moduli Mancanti
```bash
# Identifica moduli con AdminPanelProvider ma senza Dashboard
comm -23 \
  <(find laravel/Modules -name "AdminPanelProvider.php" | sed 's|.*/Modules/||' | sed 's|/.*||' | sort) \
  <(find laravel/Modules -name "Dashboard.php" -path "*/app/Filament/Pages/*" | sed 's|.*/Modules/||' | sed 's|/.*||' | sort)
```

### Creazione Automatica
```bash
# Script per creare Dashboard mancanti
for module in CertFisc ContoAnnuale Europa Inail Legge104 Legge109 Mensa MobilitaVolontaria Prenotazioni PresenzeAssenze Questionari Sindacati; do
  mkdir -p "laravel/Modules/$module/app/Filament/Pages"
  # Creare Dashboard.php per ogni modulo
done
```

## Best Practices

### 1. **Naming Convention**
- Nome classe: `Dashboard`
- Namespace: `Modules\{ModuleName}\Filament\Pages`
- View: `{modulename}::filament.pages.dashboard`

### 2. **Icone di Navigazione**
- Utilizzare icone Heroicons standard
- Mantenere coerenza tra moduli simili
- Evitare icone troppo specifiche

### 3. **Contenuto Dashboard**
- Informazioni di riepilogo del modulo
- Statistiche principali
- Link rapidi alle funzionalità
- Widget rilevanti

### 4. **Traduzioni**
- Utilizzare sempre file di traduzione
- Struttura: `{modulename}::dashboard.*`
- Supporto multilingua

## Gestione delle Traduzioni

### File di Traduzione
```php
// Modules/{ModuleName}/lang/it/dashboard.php
return [
    'title' => 'Dashboard',
    'description' => 'Panoramica del modulo',
    'welcome' => 'Benvenuto nel pannello di controllo',
];
```

### Utilizzo nelle View
```blade
{{-- resources/views/filament/pages/dashboard.blade.php --}}
<x-filament::page>
    <div class="space-y-6">
        <h2 class="text-2xl font-bold">
            {{ __('{modulename}::dashboard.title') }}
        </h2>
        
        <p class="text-gray-600">
            {{ __('{modulename}::dashboard.description') }}
        </p>
        
        {{-- Contenuto specifico del modulo --}}
    </div>
</x-filament::page>
```

## Eccezioni

### Modulo Xot
Il modulo Xot è il modulo core e potrebbe non necessitare di una dashboard tradizionale, poiché fornisce funzionalità base per gli altri moduli.

## Testing

### Test di Base
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Tests\Feature\Filament\Pages;

use Tests\TestCase;
use Modules\{ModuleName}\Filament\Pages\Dashboard;

class DashboardTest extends TestCase
{
    /** @test */
    public function it_can_access_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('{modulename}::admin');
        
        $this->actingAs($user)
            ->get(route('filament.pages.dashboard'))
            ->assertOk();
    }
}
```

## Documentazione Correlata

- [XotBasePanelProvider](../laravel/Modules/Xot/docs/filament/xotbasepanelprovider.md) - Configurazione panel provider
- [Filament Integration](../laravel/Modules/Xot/docs/filament/filament_integration.md) - Integrazione generale Filament
- [Best Practices](../laravel/Modules/Xot/docs/BEST-PRACTICES.md) - Best practices generali

## Collegamenti

- [Documentazione Modulo Xot](../laravel/Modules/Xot/docs/filament/dashboard-pages.md)
- [Filament Documentation](https://filamentphp.com/docs)
- [Heroicons](https://heroicons.com/)

---

**Ultimo aggiornamento**: Giugno 2025
**Stato**: Analisi completa completata, implementazione in corso
**Moduli da implementare**: 13 moduli identificati 