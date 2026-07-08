# Laraxot Methodology (Super Mucca)

The Laraxot methodology is the absolute foundation of this project. It prioritizes automation, consistency, and a "forward-only" development path.

## 1. Class Extension Policy (CRITICAL)

NEVER extend standard Filament or Laravel classes directly in application modules. Always use the `XotBase` equivalents from the `Xot` module.

| Standard Class | Laraxot Base Class |
| :--- | :--- |
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Illuminate\Database\Eloquent\Model` | `Modules\Xot\Models\BaseModel` |
| `Illuminate\Support\ServiceProvider` | `Modules\Xot\Providers\XotBaseServiceProvider` |

### Special Extension Rules
- **Models**: If extending a third-party model (e.g., Spatie Permission), alias the original:
  ```php
  use Spatie\Permission\Models\Permission as SpatiePermission;
  class Permission extends SpatiePermission { ... }
  ```
- **Dashboard**: Dashboard pages must be named `Dashboard` and extend `Modules\Xot\Filament\Pages\XotBaseDashboard`.

## 2. Single Table Inheritance (STI)
Used to manage multiple user types (Doctor, Patient, Admin) within the same table.
- **Pattern**: A `BaseUser` handles the table and local scopes, while specific classes extend it.
- **Boot**: Use the `booted()` method to apply global scopes on the `type` column.

## 3. Resource & Page Minimalism
`XotBase` classes are designed to be thin. Do not reimplement logic that is already handled by the base classes.
- **Resources**: Do NOT define `getTableColumns()`, `getPages()`, `getRelations()`, `getTableActions()`, or `getTableBulkActions()` if they only return standard/default values.
- **Pages/Widgets**: Do NOT define static properties like `$navigationIcon`, `$title`, or `$navigationLabel`. These are resolved dynamically from translation files.

## 4. Translation System
Hardcoded strings in UI components are forbidden. All labels, placeholders, and tooltips are managed via `LangServiceProvider`.
- **Location**: `Modules/{ModuleName}/lang/{locale}/{resource}.php`
- **Required Keys**: `navigation`, `label`, `plural_label`, `fields`, `actions`.

## 5. Business Logic (Actions over Services)
Prefer Spatie Queueable Actions over traditional Service classes.
- **Execution**: `app(MyAction::class)->execute($data)`
- **Isolated**: Each action should have a single responsibility.

## 6. Database & Migrations
- **1 Table = 1 Migration**: All changes to a table should be consolidated into a single authoritative migration file.
- **Forward-Only**: The `down()` method is forbidden. We fix forward.

## 7. Deprecations & Modern Standards
- **Filament**: Always use `schema()` instead of the deprecated `form()`.
- **Columns**: Use `TextColumn::make('status')->badge()` instead of `BadgeColumn`.
- **Casting**: Use the `casts()` method instead of the `protected $casts` property.
