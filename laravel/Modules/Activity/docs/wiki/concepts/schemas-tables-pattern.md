# Schemas & Tables Pattern

## 1. Overview
The **Schemas & Tables Pattern** is an architectural decision to extract the configuration of Filament forms, tables, and infolists from the main `Resource` class into specialized, reusable classes. This improves maintainability, reduces class size, and facilitates testing.

## 2. Structure
For a given resource (e.g., `ActivityResource`), the structure is:
- `ActivityResource.php` (Orchestrator)
- `ActivityResource/`
    - `Schemas/`
        - `ActivityForm.php`
        - `ActivityInfolist.php`
    - `Tables/`
        - `ActivitiesTable.php`

## 3. Implementation Rules
- **Naming**: Classes in `Schemas/` are singular (`ModelNameForm`), while classes in `Tables/` are pluralized (`ModelNamesTable`) to match `XotBaseResource` auto-resolution.
- **Base Classes**:
    - Forms extend `Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm`.
    - Tables extend `Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.
    - Infolists extend `Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist`.
- **Translations**: Do NOT use `->label()` calls. The `LangServiceProvider` auto-resolves labels based on the namespace and key.

## 4. Resource Integration
`XotBaseResource` automatically attempts to resolve these classes in its `form()`, `table()`, and `infolist()` methods. If found, it calls the `configure()` method on them.

```php
// Example in ActivityResource.php
public static function getFormSchema(): array
{
    return []; // Logic moved to ActivityForm.php
}
```

## 5. Benefits
- **Separation of Concerns**: UI logic is decoupled from resource orchestration.
- **DRY**: Schemas can be reused across different resources or widgets.
- **Clean Code**: Individual files are smaller and easier to audit with PHPStan.
