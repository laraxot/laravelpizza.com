# Standalone Pages vs Resource Pages in Filament 4

## Business Logic

### Il Problema che Risolve

Filament 4 ha DUE tipi fondamentali di Pages con scopi diversi:

1. **Standalone Pages**: Pagine indipendenti accessibili dal menu
2. **Resource Pages**: Pagine che fanno parte di una Resource CRUD

**Confusione** tra questi due tipi causa errori critici come:
```
Method ::route does not exist
```

## Due Classi XotBasePage Diverse

### 1. XotBasePage Standalone

**Namespace**: `Modules\Xot\Filament\Pages\XotBasePage`
**Estende**: `Filament\Pages\Page`
**File**: `Modules/Xot/app/Filament/Pages/XotBasePage.php`

**Caratteristiche**:
- ❌ NON ha metodo `route()` static
- ✅ Accessibile direttamente dal panel
- ✅ Può avere navigation icon/label
- ❌ NON ha `$resource` property
- ✅ Standalone, non legata a Resource

**Quando Usare**:
```php
// Dashboard globale
namespace Modules\MyModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
}
```

### 2. XotBasePage Resource

**Namespace**: `Modules\Xot\Filament\Resources\Pages\XotBasePage`
**Estende**: `Filament\Resources\Pages\Page`
**File**: `Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`

**Caratteristiche**:
- ✅ HA metodo `route()` static
- ❌ NON è nel menu diretto del panel
- ❌ NON deve avere navigation icon/label
- ✅ HA `$resource` property
- ✅ Parte di una Resource, registrata in `getPages()`

**Quando Usare**:
```php
// Pagina custom di una Resource
namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class CustomPage extends XotBasePage
{
    protected static string $resource = MyResource::class;
}

// Poi in MyResource:
public static function getPages(): array
{
    return [
        'custom' => CustomPage::route('/custom'),  // ← route() disponibile!
    ];
}
```

## Tabella Comparativa

| Feature | Standalone Page | Resource Page |
|---------|----------------|---------------|
| **Namespace** | `Modules\Xot\Filament\Pages\` | `Modules\Xot\Filament\Resources\Pages\` |
| **Estende Filament** | `Filament\Pages\Page` | `Filament\Resources\Pages\Page` |
| **Metodo route()** | ❌ NO | ✅ SI |
| **Property $resource** | ❌ NO | ✅ REQUIRED |
| **Navigation Icon** | ✅ SI | ❌ NO |
| **Navigation Label** | ✅ SI | ❌ NO |
| **Nel Menu** | ✅ SI | ❌ NO |
| **In getPages()** | ❌ NO | ✅ SI |
| **Path Namespace** | `Filament\Pages\` | `Filament\Resources\[Resource]\Pages\` |

## Pattern di Riconoscimento

### Analisi Path del File

```bash
# File path indica il tipo!

# STANDALONE:
Modules/MyModule/app/Filament/Pages/Dashboard.php
#                            ↑↑↑↑↑
#                          Pages/ diretto

# RESOURCE:
Modules/MyModule/app/Filament/Resources/UserResource/Pages/CustomUserPage.php
#                            ↑↑↑↑↑↑↑↑↑  ↑↑↑↑↑↑↑↑↑↑↑↑  ↑↑↑↑↑
#                          Resources/  [Resource]/  Pages/
```

### Analisi Codice

```php
// Controlla Property $resource
if (property_exists($class, 'resource')) {
    echo "È una Resource Page → usa XotBasePage da Resources/Pages/";
} else {
    echo "È una Standalone Page → usa XotBasePage da Pages/";
}

// Controlla dove è registrata
if (used_in_getPages()) {
    echo "È una Resource Page";
} else if (has_navigation_properties()) {
    echo "È una Standalone Page";
}
```

## Workflow Decisionale

```
Sto creando una nuova Page
        ↓
    DOMANDA 1: Sarà usata in getPages() di una Resource?
        ↓
    SI → Resource Page
    NO → vai a DOMANDA 2
        ↓
    DOMANDA 2: Sarà nel menu principale del panel?
        ↓
    SI → Standalone Page
    NO → Resource Page (probabilmente)
        ↓
    DOMANDA 3: Ha bisogno del metodo route()?
        ↓
    SI → Resource Page (SEMPRE)
    NO → Standalone Page
```

## Esempi Pratici

### Esempio 1: Dashboard (Standalone)

```php
<?php

namespace Modules\MyModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;  // ✅ Standalone

class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'mymodule::filament.pages.dashboard';

    // Accessibile da menu, NON usata in getPages() di Resource
}
```

### Esempio 2: ListLogActivities (Resource)

```php
<?php

namespace Modules\Activity\Filament\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource

abstract class ListLogActivities extends XotBasePage
{
    protected string $view = 'activity::filament.pages.list-log-activities';

    // Usata in getPages() di Resource, NON nel menu
    // protected static string $resource viene definito nelle sottoclassi
}

// Sottoclasse concreta:
class ListUserActivities extends ListLogActivities
{
    protected static string $resource = UserResource::class;  // ← Ha $resource!
}

// In UserResource:
public static function getPages(): array
{
    return [
        'activities' => ListUserActivities::route('/{record}/activities'),  // ← route() disponibile!
    ];
}
```

### Esempio 3: Custom Wizard (Resource)

```php
<?php

namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource

class CreateWizard extends XotBasePage
{
    protected static string $resource = MyResource::class;
    protected string $view = 'mymodule::filament.resources.my-resource.pages.create-wizard';

    // Usata in getPages()
}
```

## Errori Comuni e Fix

### Errore 1: Usare Standalone per Resource Page

```php
// ❌ ERRORE
namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;  // ❌ Standalone!

class CustomPage extends XotBasePage
{
    protected static string $resource = MyResource::class;
}

// In MyResource::getPages():
'custom' => CustomPage::route('/custom')  // ❌ route() non esiste!
```

**Fix**:
```php
// ✅ CORRETTO
namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource!

class CustomPage extends XotBasePage
{
    protected static string $resource = MyResource::class;
}
```

### Errore 2: Usare Resource per Standalone Page

```php
// ❌ ERRORE
namespace Modules\MyModule\Filament\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ❌ Resource!

class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    // Nessun $resource → Errore!
}
```

**Fix**:
```php
// ✅ CORRETTO
namespace Modules\MyModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;  // ✅ Standalone!

class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
}
```

## Script di Validazione

### Trova Errori Automaticamente

```bash
#!/bin/bash
# scripts/validate-page-types.sh

echo "🔍 Verifica correttezza Page Types..."

# Cerca Resource Pages che usano Standalone XotBasePage
RESOURCE_PAGES=$(find Modules/*/app/Filament/Resources/*/Pages -name "*.php" -type f)

for file in $RESOURCE_PAGES; do
    if grep -q "use Modules\\\\Xot\\\\Filament\\\\Pages\\\\XotBasePage" "$file"; then
        echo "❌ ERRORE: $file"
        echo "   È una Resource Page ma usa XotBasePage Standalone!"
        echo "   Fix: use Modules\Xot\Filament\Resources\Pages\XotBasePage"
        echo ""
    fi
done

# Cerca Standalone Pages che usano Resource XotBasePage
STANDALONE_PAGES=$(find Modules/*/app/Filament/Pages -maxdepth 1 -name "*.php" -type f)

for file in $STANDALONE_PAGES; do
    if grep -q "use Modules\\\\Xot\\\\Filament\\\\Resources\\\\Pages\\\\XotBasePage" "$file"; then
        echo "⚠️  WARNING: $file"
        echo "   È una Standalone Page ma usa XotBasePage Resource!"
        echo "   Fix: use Modules\Xot\Filament\Pages\XotBasePage"
        echo ""
    fi
done

echo "✅ Validazione completata"
```

### Eseguire Validazione

```bash
chmod +x scripts/validate-page-types.sh
./scripts/validate-page-types.sh
```

## Best Practice

### 1. Verifica Path Prima di Implementare

```bash
# Se stai creando:
Modules/MyModule/app/Filament/Resources/MyResource/Pages/CustomPage.php
#                                    ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
#                                    Contiene "Resources"

# Allora usa:
use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource
```

### 2. Verifica Property $resource

```php
// Se la classe HA questa property:
protected static string $resource = SomeResource::class;

// Allora DEVE usare:
use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource
```

### 3. Verifica Uso in getPages()

```php
// Se verrà usata così:
public static function getPages(): array
{
    return [
        'name' => MyPage::route('/path'),  // ← Chiama route()
    ];
}

// Allora MyPage DEVE estendere:
use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource
```

## Testing

### Test Tipo Corretto

```php
<?php

use Modules\Activity\Filament\Pages\ListLogActivities;
use Filament\Resources\Pages\Page as ResourcePage;

test('ListLogActivities extends correct base class', function () {
    expect(is_subclass_of(ListLogActivities::class, ResourcePage::class))
        ->toBeTrue('ListLogActivities deve essere una Resource Page');
});

test('ListLogActivities has route method', function () {
    expect(method_exists(ListLogActivities::class, 'route'))
        ->toBeTrue('Resource Pages devono avere il metodo route()');
});
```

## Collegamenti

### Documentazione Correlata
- [XotBase Architecture Complete](../xotbase-architecture-complete.md)
- [Activity - Route Method Error](../../activity/docs/errori/route-method-does-not-exist.md)
- [Mai Estendere Filament Direttamente](../errori-critici/mai-estendere-filament-direttamente.md)

### Classi Base
- [XotBasePage Standalone](../app/Filament/Pages/XotBasePage.php)
- [XotBasePage Resource](../app/Filament/Resources/Pages/XotBasePage.php)

---

**Ultimo aggiornamento**: 27 Ottobre 2025
**Importanza**: CRITICA
**Categoria**: Architettura Filament 4
**Pattern**: DRY + KISS con type safety
