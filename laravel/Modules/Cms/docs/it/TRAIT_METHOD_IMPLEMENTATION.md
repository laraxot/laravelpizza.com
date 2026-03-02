# Trait Method Implementation Rules

## Critical: DRY Principle for Trait Methods

**NEVER** duplicate trait methods in individual models! This violates DRY (Don't Repeat Yourself).

### Wrong Pattern (What was done 2026-03-02)
```php
// ❌ WRONG - Duplicating getJsonFile() in 4 models (Attachment, Menu, PageContent, Section)
class Attachment extends BaseModel
{
    use SushiToJsons;
    
    public function getJsonFile(): string // DUPLICATE!
    {
        // implementation
    }
}

class Menu extends BaseModel
{
    use SushiToJsons;
    
    public function getJsonFile(): string // DUPLICATE!
    {
        // implementation
    }
}
```

### Correct Pattern
```php
// ✅ CORRECT - Method in trait, inherited by all models
trait SushiToJsons
{
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();
        
        $stringId = is_string($id) || is_numeric($id) ? (string) $id : 'unknown';
        $stringTbl = is_string($tbl) ? $tbl : 'unknown';

        $filename = 'database/content/'.$stringTbl.'/'.$stringId.'.json';

        return base_path($filename);
    }
}

// Models simply use the trait without duplicating methods
class Attachment extends BaseModel
{
    use SushiToJsons;
    // getJsonFile() inherited from trait - NO duplication
}

class Menu extends BaseModel
{
    use SushiToJsons;
    // getJsonFile() inherited from trait - NO duplication
}
```

### When to Add Methods to Models vs Traits

- **Add to trait**: If the method is called by the trait and needed by all models using it
- **Add to model**: If the method is model-specific or needs different implementation per model
- **Add to interface**: If the method should be available via type hints and contracts

### Why This Is Critical

1. **DRY Violation**: Same code in multiple files
2. **Maintenance Hell**: Bug fix requires updating all models
3. **Type Inconsistency**: Different implementations cause PHPStan errors
4. **Architectural Violation**: Traits are meant for code reuse
5. **Performance**: Extra methods increase memory footprint

### Example from Current Codebase

**Implementazione corretta**: `laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php` — `getJsonFile()` definito UNA VOLTA nel trait.

**Modelli Cms** (Attachment, Menu, PageContent, Section): usano `SushiToJsons` e **non** ridefiniscono `getJsonFile()`. Ereditano dal trait.

**Override leciti** (path specifico): InformationSchemaTable, Comune, TestSushiModel — hanno path diversi (database_path, module_path) quindi override giustificato.

### Altro esempio: getBlocksBySlug

`getBlocksBySlug(string $slug, ?string $side)` è usato da Page e Section. Sta in `HasBlocks`, non nei modelli. I View Components (Page, Section) chiamano `PageModel::getBlocksBySlug()` / `SectionModel::getBlocksBySlug()` — il metodo è ereditato dal trait.

### Rule di riferimento

- `.cursor/rules/trait-methods-no-duplication.mdc`