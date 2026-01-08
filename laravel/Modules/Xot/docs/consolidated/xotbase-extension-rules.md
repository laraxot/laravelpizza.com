# XotBase Extension Rules - Comprehensive Guide

## 🚨 Critical Architectural Rule

**NEVER extend Filament classes directly. ALWAYS extend the corresponding XotBase abstract class.**

## 📋 Extension Pattern Table

| Filament Original Class | XotBase Class to Extend |
|-------------------------|-------------------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |

## ✅ Correct Implementation Examples

### Resource Example
```php
// CORRECT: Extend XotBaseResource
namespace Modules\MyModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    // Implementation here
}

// WRONG: Direct Filament extension
class MyResource extends \Filament\Resources\Resource
{
    // This will cause architecture violations
}
```

### Widget Example
```php
// CORRECT: Extend XotBaseWidget
namespace Modules\MyModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        return [
            // Form components here
        ];
    }
}

// WRONG: Direct Filament extension
class MyWidget extends \Filament\Widgets\Widget
{
    // Missing required methods and architecture violations
}
```

## ⚠️ Common Errors and Solutions

### Error: "Class contains 1 abstract method and must therefore be declared abstract"
**Cause**: Extending XotBaseWidget without implementing required abstract methods like `getFormSchema()`
**Solution**: Always implement ALL abstract methods from XotBase classes

### Error: "Access level must be public (as in class XotBaseWidget)"
**Cause**: Using `protected` instead of `public` for methods that are `public` in parent class
**Solution**: Match the exact access level from the parent abstract class

### Error: "Cannot override final method"
**Cause**: Trying to override methods marked as `final` in XotBase classes
**Solution**: Use the provided hook methods instead of overriding final methods

## 🔧 Required Method Implementations

### For XotBaseWidget
```php
public function getFormSchema(): array
{
    return [
        // Must return array of Filament form components
        // NEVER return empty array []
        \Filament\Forms\Components\TextInput::make('field_name')
            ->label(__('module::translation.key'))
            ->required(),
    ];
}
```

### For XotBaseResource
```php
// XotBaseResource provides default implementations
// Override only when necessary using the correct patterns
```

## 📁 Namespace Structure Rules

1. **Maintain Filament's namespace structure** but within your module
2. **Never include 'app' in namespace** for Filament components
3. **Use correct translation patterns** with module prefix

**Correct:**
```php
namespace Modules\MyModule\Filament\Resources;
namespace Modules\MyModule\Filament\Widgets;
```

**Wrong:**
```php
namespace Modules\MyModule\App\Filament\Resources; // Contains 'App'
namespace Modules\MyModule\Filament\App\Widgets;   // Wrong structure
```

## 🛡️ Validation Checklist

Before committing any Filament-related code, verify:

1. [ ] Extends XotBase class, not direct Filament class
2. [ ] All abstract methods are implemented with correct signatures
3. [ ] Method access levels match parent class (public/protected)
4. [ ] Namespace follows correct pattern without 'app' segment
5. [ ] No final methods are being overridden
6. [ ] Form schemas return proper Filament components, not empty arrays
7. [ ] Translation keys use module prefix (module::key.path)

## 🔍 Common Pitfalls

### Empty Form Schemas
**Wrong:**
```php
public function getFormSchema(): array
{
    return []; // NEVER return empty array
}
```

**Correct:**
```php
public function getFormSchema(): array
{
    return [
        \Filament\Forms\Components\TextInput::make('name')
            ->label(__('module::fields.name')),
    ];
}
```

### Wrong Access Levels
**Wrong:**
```php
protected function getFormSchema(): array // Should be public
{
    return [/*...*/];
}
```

**Correct:**
```php
public function getFormSchema(): array // Must be public
{
    return [/*...*/];
}
```

## 📚 Related Documentation

- [Filament Extension Pattern](../filament_extension_pattern.md)
- [XotBaseWidget Documentation](./filament/widgets/xot-base-widget.md)
- [Namespace Rules](../namespace-rules.md)
- [Architecture Best Practices](../architecture-best-practices.md)

## 🚨 Emergency Fix Procedure

If you encounter architecture violations:

1. **Identify the incorrectly extended class**
2. **Change extends to correct XotBase class**
3. **Implement all required abstract methods**
4. **Verify method signatures match parent**
5. **Run PHPStan to validate fixes**

## 🔗 Integration with Development Workflow

This rule is enforced by:
- PHPStan architecture rules
- Code review processes
- Automated quality checks

Always run `php artisan optimize:clear && ./vendor/bin/phpstan analyse` after making changes to verify compliance.

---

*Last Updated: 2025-08-27*  
*Architecture Version: XotBase 2.0*
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
