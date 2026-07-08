# SushiToJson/SushiToJsons PHPStan Level 10 Fixes

## Problem Overview
PHPStan Level 10 cannot discover methods defined in traits when they are called from within the trait itself or from model callbacks.

## Root Cause
PHPStan analyzes static code patterns but cannot dynamically resolve trait method calls that happen:
1. Within the trait itself (SushiToJson calling its own methods)
2. In trait boot callbacks (creating, updating, deleting)
3. In model methods that use trait methods

## Solution: Contratti (Interfacce)

Per risolvere i `method.notFound` nelle closure di boot, i modelli implementano interfacce dedicate e i trait usano type narrowing con `Model&Contract`:

### SushiToJsonContract
Interfaccia in `Modules/Tenant/app/Contracts/SushiToJsonContract.php` con metodi: getJsonFile, loadExistingData, authId, ensureDirectoryExists, saveToJson, findRowIndexById.

Modelli che implementano: Page, Comune, TestSushiModel, InformationSchemaTable.

### SushiToJsonsContract
Interfaccia in `Modules/Tenant/app/Contracts/SushiToJsonsContract.php` con metodo getJsonFile.

Modelli che implementano: Attachment, Menu, PageContent, Section, BaseModelJsons.

### Pattern nei trait
```php
if (! $model instanceof Model || ! $model instanceof SushiToJsonContract) {
    throw new InvalidArgumentException('Model must implement '.SushiToJsonContract::class);
}
/** @var Model&SushiToJsonContract $modelWithTrait */
$modelWithTrait = $model;
```

### For Static Methods from HasBlocks Trait
Add @method annotations for static methods:

```php
/**
 * @method static array getMiddlewareBySlug(string $slug) Get middleware by slug
 * @method static array getBlocksBySlug(string $slug, ?string $side = null) Get blocks by slug
 */
class Page extends BaseModel
{
    use HasBlocks;
    use SushiToJsons;
}
```

## Implementation

### Fixed Models
- ✅ Modules/Cms/app/Models/Page.php
- ✅ Modules/Cms/app/Models/Section.php
- ✅ Modules/Cms/app/Models/Attachment.php
- ✅ Modules/Cms/app/Models/Menu.php
- ✅ Modules/Cms/app/Models/PageContent.php
- ✅ Modules/Xot/app/Models/InformationSchemaTable.php
- ✅ Modules/Geo/app/Models/Comune.php

### Fixed Traits
- ✅ Modules/Tenant/app/Models/Traits/SushiToJson.php - Added comprehensive PHPDoc
- ✅ Modules/Tenant/app/Models/Traits/SushiToJsons.php - Added comprehensive PHPDoc

### Fixed Actions
- ✅ Modules/Xot/app/Filament/Actions/Header/ExportPdfAction.php - Fixed parameter count

## Results
- Before: ~154 errori (method.notFound sui trait Sushi)
- Dopo interfacce: errori Sushi eliminati
- saveToJson: return type bool (non void) per compatibilità contratto

## Best Practices
1. **DRY — mai duplicare metodi del trait nei modelli**: `getJsonFile()` è definito in `SushiToJsons`; Attachment, Menu, PageContent, Section **non** lo ridefiniscono. Override solo se path diverso (es. InformationSchemaTable, Comune). Vedi `.cursor/rules/trait-methods-no-duplication.mdc`
2. Always add @method annotations when using traits with public methods
3. Include complete method signatures with parameter types and return types
4. Document what each method does in the annotation
5. Use proper type hints for all parameters and return types
6. Follow PHPStan Level 10 strict typing requirements