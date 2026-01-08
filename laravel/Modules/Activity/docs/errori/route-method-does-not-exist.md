# Errore: Method ::route does not exist

## Descrizione dell'Errore

```
BadMethodCallException
Method Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\ListSchedaLogActivities::route does not exist.
```

Errore che si verifica durante il bootstrap dell'applicazione quando Filament tenta di registrare le pagine di una Resource.

## Contesto dell'Errore

### Stack Trace Critico

```
0 - vendor/laravel/framework/src/Illuminate/Macroable/Traits/Macroable.php:89
1 - Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource.php:63
```

### Dove Si Verifica

```php
// IndennitaResponsabilitaResource.php linea 63
public static function getPages(): array
{
    return [
        // ...
        'log-activity' => Pages\ListSchedaLogActivities::route('/{record}/activities'),
        //                                              ↑
        //                                        METODO NON ESISTE!
    ];
}
```

## Causa Radice

### Il Problema: Due Classi XotBasePage Diverse

In Laraxot/PTVX esistono **DUE** classi `XotBasePage` con scopi DIVERSI:

1. **`Modules\Xot\Filament\Pages\XotBasePage`**
   - Estende: `Filament\Pages\Page`
   - Scopo: **Standalone Pages** (non legate a Resource)
   - Metodo `route()`: ❌ **NON DISPONIBILE**
   - Esempio uso: Dashboard, pagine custom isolate

2. **`Modules\Xot\Filament\Resources\Pages\XotBasePage`**
   - Estende: `Filament\Resources\Pages\Page`  
   - Scopo: **Resource Pages** (parte di una Resource)
   - Metodo `route()`: ✅ **DISPONIBILE**
   - Esempio uso: Custom pages dentro Resources

### Gerarchia Classi

```
# STANDALONE PAGE (senza route())
Filament\Pages\Page
    ↓
Modules\Xot\Filament\Pages\XotBasePage
    ↓
Modules\[Module]\Filament\Pages\MyStandalonePage

# RESOURCE PAGE (con route())
Filament\Resources\Pages\Page  
    ↓
Modules\Xot\Filament\Resources\Pages\XotBasePage
    ↓
Modules\[Module]\Filament\Resources\[Resource]\Pages\MyResourcePage
```

### Errore in ListLogActivities

```php
// Modules/Activity/app/Filament/Pages/ListLogActivities.php
use Modules\Xot\Filament\Pages\XotBasePage;  // ❌ SBAGLIATO! Standalone Page

abstract class ListLogActivities extends XotBasePage  // ❌ Classe sbagliata
{
    // Usata come Resource Page ma è una Standalone Page!
}
```

**Risultato**: Quando viene chiamato `ListSchedaLogActivities::route()` in `getPages()`, il metodo non esiste perché la classe parent è standalone, non resource.

## Soluzione

### Correggere Estensione Classe

```php
// Modules/Activity/app/Filament/Pages/ListLogActivities.php

// ❌ PRIMA (ERRATO)
namespace Modules\Activity\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;  // Standalone!

abstract class ListLogActivities extends XotBasePage
{
    //...
}

// ✅ DOPO (CORRETTO)
namespace Modules\Activity\Filament\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // Resource!

abstract class ListLogActivities extends XotBasePage
{
    //...
}
```

**Modifiche**:
- Cambiare import da `Modules\Xot\Filament\Pages\XotBasePage`
- A: `Modules\Xot\Filament\Resources\Pages\XotBasePage`

## Come Riconoscere Quale Usare

### Usare `Filament\Pages\XotBasePage` (Standalone) Quando:

- ✅ Pagina non legata a Resource specifica
- ✅ Accessibile direttamente dal menu
- ✅ NON registrata in `getPages()` di una Resource
- ✅ NON ha `protected static string $resource`

**Esempi**:
- Dashboard generale
- Pagina impostazioni globali  
- Pagina about/help
- Report standalone

### Usare `Filament\Resources\Pages\XotBasePage` (Resource) Quando:

- ✅ Pagina parte di una Resource
- ✅ Registrata in `getPages()` di una Resource
- ✅ Ha `protected static string $resource`
- ✅ Necessita del metodo `route()`

**Esempi**:
- ListLogActivities (parte di qualsiasi Resource)
- Custom edit pages
- Custom view pages
- Wizard multi-step

## Procedura di Correzione

### Step 1: Identificare il Tipo

```php
// La classe è usata così?
public static function getPages(): array
{
    return [
        'custom' => MyPage::route('/custom'),  // ← Serve route()!
    ];
}

// Allora DEVE estendere Resource Page!
```

### Step 2: Correggere Import

```php
// Cambiare import
use Modules\Xot\Filament\Pages\XotBasePage;  // ❌ Standalone

// Con
use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource
```

### Step 3: Verificare Funzionamento

```bash
# Pulire cache
php artisan optimize:clear

# Tentare accesso alla route
curl http://localhost/modulo/admin/resource/{id}/custom
```

### Step 4: Aggiornare Documentazione

Documentare il fix nella cartella docs del modulo.

## Prevenzione

### Checklist Pre-Implementazione

Quando crei una nuova Page, chiediti:

- [ ] Sarà usata in `getPages()` di una Resource? → **Resource Page**
- [ ] Avrà `protected static string $resource`? → **Resource Page**
- [ ] Necessita di `route()` metodo? → **Resource Page**
- [ ] È standalone nel menu? → **Standalone Page**

### Pattern Riconoscimento

```php
// RESOURCE PAGE → usa XotBasePage da Resources/Pages/
namespace Modules\[Module]\Filament\Resources\[Resource]\Pages;
//                        ↑↑↑↑↑↑↑↑↑ "Resources" nel path

use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class MyCustomResourcePage extends XotBasePage
{
    protected static string $resource = MyResource::class;  // ← Ha $resource
}

// STANDALONE PAGE → usa XotBasePage da Pages/
namespace Modules\[Module]\Filament\Pages;
//                        ↑↑↑↑↑ NESSUN "Resources"

use Modules\Xot\Filament\Pages\XotBasePage;

class MyStandalonePage extends XotBasePage
{
    // Nessun $resource
    protected static ?string $navigationIcon = 'heroicon-o-home';
}
```

## Caso Specifico: ListLogActivities

### Analisi

```php
// ListSchedaLogActivities
namespace Modules\IndennitaResponsabilita\Filament\Resources\[Resource]\Pages;
//                                                     ↑↑↑↑↑↑↑↑↑
//                                                   "Resources" nel path!

class ListSchedaLogActivities extends ListLogActivities
{
    protected static string $resource = IndennitaResponsabilitaResource::class;
    //                     ↑↑↑↑↑↑↑↑
    //                   Ha $resource!
}
```

**Conclusione**: È chiaramente una **Resource Page**, quindi `ListLogActivities` DEVE estendere `Modules\Xot\Filament\Resources\Pages\XotBasePage`.

### Correzione Necessaria

```php
// Modules/Activity/app/Filament/Pages/ListLogActivities.php

// PRIMA:
use Modules\Xot\Filament\Pages\XotBasePage;  // ❌ Standalone

// DOPO:
use Modules\Xot\Filament\Resources\Pages\XotBasePage;  // ✅ Resource
```

## Test di Verifica

### Test 1: Verifica Metodo route()

```php
<?php

use Modules\Activity\Filament\Pages\ListLogActivities;

test('ListLogActivities has route method', function () {
    expect(method_exists(ListLogActivities::class, 'route'))
        ->toBeTrue('ListLogActivities deve avere il metodo route() static');
});
```

### Test 2: Verifica Registrazione in getPages()

```php
test('can register ListLogActivities in getPages', function () {
    $pages = IndennitaResponsabilitaResource::getPages();
    
    expect($pages)
        ->toHaveKey('log-activity')
        ->and($pages['log-activity'])
        ->toBeInstanceOf(\Filament\Resources\Pages\PageRegistration::class);
});
```

## Altri Casi Simili

### Cercare Altri Errori

```bash
# Cercare pagine Resource che estendono XotBasePage standalone
grep -r "extends XotBasePage" Modules/*/app/Filament/Resources/ \
    | grep "use Modules\\\\Xot\\\\Filament\\\\Pages\\\\XotBasePage"

# Se trova risultati → ERRORI da correggere!
```

### Pattern Automatico

```php
// Script di validazione
foreach (glob('Modules/*/app/Filament/Resources/*/Pages/*.php') as $file) {
    $content = file_get_contents($file);
    
    // Se è in Resources/*/Pages/ ma usa standalone XotBasePage
    if (str_contains($content, 'use Modules\Xot\Filament\Pages\XotBasePage')) {
        echo "❌ ERRORE: $file usa XotBasePage standalone ma è una Resource Page!\n";
    }
}
```

## Collegamenti

### Documentazione Correlata
- [Activity Module - README](../README.md)
- [XotBase Architecture](../../Xot/docs/xotbase-architecture-complete.md)
- [Differenza Standalone vs Resource Pages](../../Xot/docs/filament/pages-types.md)

### Fix Correlati
- [Modulo Disabilitato](./modulo-disabilitato.md)
- [No Hint Path Defined](./no-hint-path-defined.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Versione Filament**: 4.x  
**Severità**: Alta (blocca registrazione Resource Pages)  
**Causa**: Confusione tra Standalone Page e Resource Page


