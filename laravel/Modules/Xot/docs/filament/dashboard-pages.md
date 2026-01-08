# Pagine Dashboard Filament - Best Practices

## Panoramica

Tutti i moduli che utilizzano Filament devono avere una pagina Dashboard. Questo documento definisce le best practices per l'implementazione delle pagine Dashboard in Laraxot/PTVX.

## Principi Fondamentali

### 1. **Presenza Obbligatoria**
- **TUTTI** i moduli con `AdminPanelProvider` devono avere `app/Filament/Pages/Dashboard.php`
- La pagina Dashboard è il punto di ingresso principale per ogni modulo
- Garantisce coerenza e navigabilità nell'interfaccia amministrativa

### 2. **Struttura Standard**
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

## Analisi Completa dei Moduli

### ✅ Moduli con Dashboard Completa
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

### ❌ Moduli che Necessitano Dashboard
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

## Procedura di Creazione

### 1. Struttura Directory
Assicurarsi che esista la directory:
```bash
mkdir -p Modules/{ModuleName}/app/Filament/Pages
```

### 2. File Dashboard.php
Creare il file con la seguente struttura:

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

### 3. View Associata
Creare la view corrispondente:
```bash
mkdir -p Modules/{ModuleName}/resources/views/filament/pages
```

```blade
{{-- Modules/{ModuleName}/resources/views/filament/pages/dashboard.blade.php --}}
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

## Checklist di Qualità

### ✅ Controlli Obbligatori
- [ ] Modulo ha `AdminPanelProvider` in `module.json`
- [ ] File `app/Filament/Pages/Dashboard.php` esiste
- [ ] Namespace corretto: `Modules\{ModuleName}\Filament\Pages`
- [ ] `declare(strict_types=1);` presente
- [ ] Estende `Filament\Pages\Page`
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

## Eccezioni

### Modulo Xot
Il modulo Xot è il modulo core e potrebbe non necessitare di una dashboard tradizionale, poiché fornisce funzionalità base per gli altri moduli.

## Documentazione Correlata

- [XotBasePanelProvider](./xotbasepanelprovider.md) - Configurazione panel provider
- [Filament Integration](./filament_integration.md) - Integrazione generale Filament
- [Best Practices](./BEST-PRACTICES.md) - Best practices generali

## Collegamenti

- [Documentazione Root](../../../docs/filament-dashboard-pages.md)
- [Filament Documentation](https://filamentphp.com/docs)
- [Heroicons](https://heroicons.com/)

---

**Ultimo aggiornamento**: Giugno 2025
