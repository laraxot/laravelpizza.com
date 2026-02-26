# Regole di Estensione XotBase - Guida di Riferimento

## 🚨 REGOLA CRITICA FONDAMENTALE

**MAI ESTENDERE CLASSI FILAMENT DIRETTAMENTE - SEMPRE USARE XOTBASE**

Questa è la regola più importante dell'architettura Laraxot/PTVX e ha **PRIORITÀ ASSOLUTA** su qualsiasi altra considerazione.

## ❌ Cosa NON Fare

```php
// VIETATO - Estensione diretta di classi Filament
class Dashboard extends Filament\Pages\Dashboard
class EmployeeResource extends Filament\Resources\Resource
class StatsWidget extends Filament\Widgets\Widget
class CustomPage extends Filament\Pages\Page
class PanelProvider extends Filament\Panel
```

## ✅ Cosa Fare SEMPRE

```php
// OBBLIGATORIO - Estensione di classi XotBase
class Dashboard extends Modules\Xot\Filament\Pages\XotBaseDashboard
class EmployeeResource extends Modules\Xot\Filament\Resources\XotBaseResource
class StatsWidget extends Modules\Xot\Filament\Widgets\XotBaseWidget
class CustomPage extends Modules\Xot\Filament\Pages\XotBasePage
class AdminPanelProvider extends Modules\Xot\Providers\Filament\XotBasePanelProvider
```

## 📋 Mapping Completo delle Classi

| Filament Originale | XotBase Corrispondente | Utilizzo |
|-------------------|------------------------|----------|
| `Filament\Pages\Dashboard` | `Modules\Xot\Filament\Pages\XotBaseDashboard` | Dashboard moduli |
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` | Risorse CRUD |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` | Widget dashboard |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` | Pagine custom |
| `Filament\Panel` | `Modules\Xot\Providers\Filament\XotBasePanelProvider` | Panel provider |

## 🎯 Motivazioni della Regola

### 1. **Funzionalità Aggiuntive**
Le classi XotBase forniscono funzionalità specifiche del progetto Laraxot/PTVX che non sono disponibili nelle classi Filament standard.

### 2. **Consistenza Architetturale**
Garantisce che tutti i moduli seguano lo stesso pattern architetturale, facilitando manutenzione e sviluppo.

### 3. **Modifiche Centralizzate**
Permette di applicare modifiche a tutti i moduli modificando solo le classi XotBase, senza toccare ogni singolo modulo.

### 4. **Integrazione Sistema**
Le classi XotBase sono integrate con il sistema di configurazione, traduzioni e funzionalità specifiche del progetto.

## 🔍 Come Verificare la Conformità

### Ricerca Violazioni
```bash

# Cerca estensioni dirette di Filament (dovrebbe restituire 0 risultati)
grep -r "extends Filament\\" Modules/ --include="*.php"

# Cerca estensioni corrette XotBase
grep -r "extends Modules\\Xot\\" Modules/ --include="*.php"
```

### Verifica Specifica per Tipo
```bash

# Dashboard
grep -r "XotBaseDashboard" Modules/ --include="*.php"

# Resources
grep -r "XotBaseResource" Modules/ --include="*.php"

# Widgets
grep -r "XotBaseWidget" Modules/ --include="*.php"
```

## 📝 Esempi Pratici

### Dashboard Modulo
```php
<?php

declare(strict_types=1);

namespace Modules\Employee\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

/**
 * Dashboard per il modulo Employee.
 * 
 * Estende XotBaseDashboard seguendo la regola architettturale fondamentale
 * di non estendere mai classi Filament direttamente.
 */
class Dashboard extends XotBaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $title = 'Employee Dashboard';
    protected static ?string $navigationLabel = 'Employee';
    protected static ?int $navigationSort = 1;
}
```

### Resource Modulo
```php
<?php

declare(strict_types=1);

namespace Modules\Employee\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class EmployeeResource extends XotBaseResource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    // Implementazione specifica del resource...
}
```

### Widget Modulo
```php
<?php

declare(strict_types=1);

namespace Modules\Employee\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class EmployeeStatsWidget extends XotBaseWidget
{
    protected static string $view = 'employee::filament.widgets.stats';
    
    // Implementazione specifica del widget...
}
```

## 🚨 Controlli di Qualità

### Pre-commit Hook
Aggiungere un controllo pre-commit per verificare che non ci siano estensioni dirette di Filament:

```bash
#!/bin/bash

# .git/hooks/pre-commit

if grep -r "extends Filament\\" Modules/ --include="*.php" > /dev/null; then
    echo "❌ ERRORE: Trovate estensioni dirette di classi Filament!"
    echo "Usa sempre le classi XotBase invece."
    exit 1
fi

echo "✅ Controllo XotBase: PASSED"
```

### CI/CD Check
```yaml

# .github/workflows/xotbase-check.yml
name: XotBase Extension Check
on: [push, pull_request]
jobs:
  check-xotbase:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Check XotBase Extensions
        run: |
          if grep -r "extends Filament\\" Modules/ --include="*.php"; then
            echo "❌ Direct Filament extensions found!"
            exit 1
          fi
          echo "✅ All extensions use XotBase pattern"
```

## 📚 Documentazione Correlata

- [Architecture Best Practices](./architecture_best_practices.md)
- [Filament Integration Guide](./filament_integration.md)
- [Module Development Standards](./module_development_standards.md)

## ⚠️ Nota Importante

**Questa regola non ammette eccezioni.** Ogni violazione deve essere corretta immediatamente. In caso di dubbi, consultare sempre la documentazione o chiedere conferma prima di procedere.

---

*Documento aggiornato: 2025-07-30*  
*Priorità: CRITICA*  
*Stato: OBBLIGATORIO per tutti i moduli*
