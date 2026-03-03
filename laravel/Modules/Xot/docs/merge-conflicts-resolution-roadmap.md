# Roadmap Risoluzione Merge Conflicts - PHPStan Bloccanti

**Status**: ⚠️ In Lavorazione
**Scopo**: Documentare la roadmap per risolvere i merge conflicts che bloccano PHPStan

---

## 🎯 Obiettivo

Risolvere tutti i merge conflicts nei file PHP critici che bloccano l'esecuzione di PHPStan livello 10, seguendo rigorosamente le regole del progetto:
- Estendere sempre `XotBase*` invece di Filament direttamente
- Namespace corretti (senza `app`)
- Metodi Filament con `array<string, ...>`
- Usare `isset()` per magic attributes Eloquent

---

## ✅ File Risolti

1. ✅ `Modules/Xot/app/Filament/Resources/LogResource/Pages/EditLog.php`
2. ✅ `Modules/Xot/app/Filament/Resources/ModuleResource/Pages/ListModules.php`
3. ✅ `Modules/Xot/app/Filament/Resources/ModuleResource/Pages/EditModule.php`
4. ✅ `Modules/Xot/app/Filament/Resources/CacheLockResource/Pages/ListCacheLocks.php`
5. ✅ `Modules/Xot/app/Filament/Resources/CacheLockResource/Pages/EditCacheLock.php`
6. ✅ `Modules/Xot/app/Filament/Resources/CacheResource/Pages/ListCaches.php`
7. ✅ `Modules/Xot/app/Filament/Resources/CacheResource/Pages/EditCache.php`
8. ✅ `Modules/Notify/app/Filament/Resources/NotificationResource.php`
9. ✅ `Modules/UI/app/Filament/Widgets/StatWithIconWidget.php`
10. ✅ `Modules/UI/app/Filament/Widgets/TestChartWidget.php` (rimosso `static` da `$maxHeight`)
11. ✅ `Modules/Xot/app/Filament/Resources/ExtraResource/Pages/ListExtras.php`
12. ✅ `Modules/Xot/app/Filament/Resources/ExtraResource/Pages/EditExtra.php`
13. ✅ `Modules/Xot/app/Filament/Resources/CacheLockResource.php`
14. ✅ `Modules/Xot/app/Models/CacheLock.php`
15. ✅ `Modules/UI/app/Enums/TableLayoutEnum.php`
16. ✅ `Modules/User/app/Filament/Resources/RoleResource/RelationManagers/PermissionsRelationManager.php`
17. ✅ `Modules/Xot/app/Filament/Forms/Components/XotBaseFormComponent.php`
18. ✅ `Modules/Xot/app/Filament/Forms/Components/XotBaseCheckboxList.php`
19. ✅ `Modules/Xot/app/Filament/Forms/Components/XotBaseRadio.php`
20. ✅ `Modules/Xot/app/Filament/Forms/Components/XotBaseSelect.php`
21. ✅ `Modules/Xot/app/Filament/Tables/Actions/XotBaseBulkAction.php`
22. ✅ `Modules/Xot/app/Filament/Tables/Actions/XotBaseTableAction.php`
23. ✅ `Modules/Cms/app/Models/Page.php` (corretto commento non terminato)

---

## ⚠️ File da Risolvere (Priorità Alta - Bloccano PHPStan)

### Modulo Xot

1. ✅ **`Modules/Xot/app/Filament/Resources/ExtraResource/Pages/ListExtras.php`** - RISOLTO
   - Pattern: Estendere `XotBaseListRecords`
   - Metodi: `getTableColumns()` → `array<string, Column>`

2. ✅ **`Modules/Xot/app/Filament/Resources/ExtraResource/Pages/EditExtra.php`** - RISOLTO

3. ✅ **`Modules/Xot/app/Filament/Resources/CacheLockResource.php`** - RISOLTO

4. **`Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`** - ⚠️ CRITICO
   - Pattern: Estendere classe base corretta
   - Verificare namespace e use statements
   - **Blocca molti RelationManager**

5. **`Modules/Xot/app/Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php`**
   - Pattern: Estendere classe base corretta
   - Verificare namespace e use statements

6. **`Modules/Xot/app/Filament/Support/ColumnBuilder.php`**
   - Verificare tipi di ritorno e namespace

7. **`Modules/Xot/app/Filament/Traits/HasXotTable.php`** - ⚠️ CRITICO
   - Verificare tipi di ritorno per metodi Filament
   - **File molto grande (2200+ righe), usato da molti RelationManager e Resource**
   - **Blocca PHPStan completamente**

8. **`Modules/Xot/app/Filament/Forms/Components/XotBaseFormComponent.php`**
   - Pattern: Estendere classe base corretta

9. **`Modules/Xot/app/Filament/Forms/Components/XotBaseCheckboxList.php`**
   - Pattern: Estendere classe base corretta

10. **`Modules/Xot/app/Filament/Forms/Components/XotBaseRadio.php`**
    - Pattern: Estendere classe base corretta

11. **`Modules/Xot/app/Filament/Widgets/XotBaseChartWidget.php`**
    - Pattern: Risolvere merge conflicts complessi
    - Verificare che estenda `FilamentChartWidget` correttamente

### Modulo User

12. ✅ **`Modules/User/app/Filament/Resources/RoleResource/RelationManagers/PermissionsRelationManager.php`** - RISOLTO
    - Rimosso `getFormSchema()` perché è `final` in `XotBaseRelationManager`

---

## 📋 Strategia di Risoluzione

### Fase 1: File Critici Xot (Priorità Massima)
1. Risolvere merge conflicts in `XotBaseChartWidget.php` (blocca molti widget)
2. Risolvere merge conflicts in `XotBaseResource` e pagine correlate
3. Risolvere merge conflicts in componenti form base

### Fase 2: Verifica PHPStan
1. Eseguire PHPStan dopo ogni file risolto
2. Verificare che non ci siano errori di parsing
3. Verificare che i tipi siano corretti

### Fase 3: File Non Critici
1. Risolvere merge conflicts in file di test
2. Risolvere merge conflicts in file di configurazione
3. Risolvere merge conflicts in file di lingua

---

## 🔍 Pattern di Risoluzione

### Per File Pages (List/Edit/Create/View)

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ResourceName\Pages;

use Modules\Xot\Filament\Resources\ResourceName;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords; // o XotBaseEditRecord, ecc.

class ListResources extends XotBaseListRecords
{
    protected static string $resource = ResourceName::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'key' => TextColumn::make('key'),
            // ...
        ];
    }
}
```

### Per File Resources

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Modules\Xot\Filament\Resources\ResourceName\Pages;
use Modules\Xot\Models\ModelName;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ResourceName extends XotBaseResource
{
    protected static ?string $model = ModelName::class;

    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // Form components
        ];
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResources::route('/'),
            // ...
        ];
    }
}
```

---

## 📚 Riferimenti

- [Filament Class Extension Rules](./filament-class-extension-rules.md)
- [Laraxot Architecture Rules](./laraxot-architecture-rules.md)
- [Filament Methods Return Types](./filament-methods-return-types.md)
- [Eloquent Magic Properties Rule](./eloquent-magic-properties-rule.md)

---

**
**Versione**: 1.0.0
**Status**: ⚠️ In Lavorazione
