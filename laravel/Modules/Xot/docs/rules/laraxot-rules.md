# LARAXOT FRAMEWORK RULES

## CLASS EXTENSION
- NEVER extend Laravel or Filament base classes directly
- ALWAYS extend XotBase classes from Xot module:
  - Use XotBaseResource instead of Resource
  - Use XotBaseListRecords instead of ListRecords
  - Use XotBaseServiceProvider instead of ServiceProvider
  - Use XotBaseRouteServiceProvider instead of RouteServiceProvider
  - Use BaseEventServiceProvider instead of EventServiceProvider
  - Use XotBaseMigration instead of Migration

## FILAMENT RESOURCES
- ALWAYS extend XotBaseResource
- Use getFormSchema() method, NEVER use form()
- DO NOT define table() method in Resource classes
- DO NOT use ->label() method (handled by LangServiceProvider)
- DO NOT define $navigationIcon, $modelLabel (handled by translations)

## LIST PAGES
- ALWAYS extend XotBaseListRecords
- Use specific methods:
  - getListTableColumns(): array - For table columns
  - getTableFilters(): array - For table filters
  - getTableActions(): array - For row actions
  - getTableBulkActions(): array - For bulk actions
  - getTableHeaderActions(): array - For header actions
- Use associative arrays with string keys for components

## MODELS
- Follow proper namespace: Modules\*\Models
- Use proper type hints and PHPDoc
- Comment out non-existent model relations
- Document when they will be implemented
- DO NOT implement newFactory() method when extending BaseModel
- **NEVER** use `protected $casts = []` property
- **ALWAYS** use `protected function casts(): array` method as per Laravel documentation:
  ```php
  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
      return [
          'is_active' => 'boolean',
          'options' => 'array',
          'created_at' => 'datetime',
          'updated_at' => 'datetime',
      ];
  }
  ```

## MIGRATIONS
- ALWAYS extend XotBaseMigration
- NEVER override the down() method (it's final in XotBaseMigration)
- Use tableCreate() and tableUpdate() methods
- Use updateTimestamps() for standard fields
- Always use declare(strict_types=1)

## TRANSLATIONS
- Use expanded structure for fields:
  ```php
  'fields' => [
      'field_name' => [
          'label' => 'Field Label',
          'tooltip' => 'Help text',
          'placeholder' => 'Example input'
      ]
  ]
  ```
- Use expanded structure for actions:
  ```php
  'actions' => [
      'action_name' => [
          'label' => 'Action Label',
          'icon' => 'heroicon-name',
          'color' => 'primary|secondary|success|danger',
          'tooltip' => 'Action description'
      ]
  ]
  ```
- NEVER use ->label() method in Filament components

## SERVICE PROVIDERS
- ALWAYS call parent::boot() in boot() methods
- Declare required properties:
  ```php
  protected string $moduleName = 'ModuleName';
  protected string $moduleNameLower = 'modulename';
  ```

## NAMESPACES
- Models: Modules\*\Models (NOT Modules\*\app\Models)
- Filament: Modules\*\Filament (NOT Modules\*\app\Filament)
- Resources: Modules\*\Filament\Resources
- Pages: Modules\*\Filament\Resources\Pages

## CODING STANDARDS
- Use strict types: declare(strict_types=1);
- Define return types for all methods
- Use type hints for parameters
- Use null-safe operator when appropriate
- Use short array syntax []
- Follow PSR-4 autoloading
- One class per file

## DOCUMENTATION
- **MANDATORY**: Always study, update, and improve 'docs' folders BEFORE taking any action
- **MANDATORY**: Before implementation, write the why, purpose, rationale, policy, vision, and philosophy of the task in the relevant module/theme docs
- Treat `docs/` as the handoff layer between AI agents working on the same repository
- Evaluate the creation of GitHub Issues or GitHub Discussions to track decisions and progress
- Never include specific absolute paths (e.g., base_*_fila5)
- Document model relationships and field purposes
- Add PHPDoc blocks to all classes and methods
- Links in .md files must be relative and filenames lowercase (except README.md)

## SHARED ACTION REUSE
- Before adding helper methods for cast, normalization, formatting, or small domain transforms, search `Modules/Xot/app/Actions/` first
- If logic is shared across more than one class, prefer a reusable Xot action over duplicated private/protected helpers
- If nullable and non-nullable semantics differ, expose both explicitly at the action layer instead of hiding policy in local widget/page methods

## VALIDATION
- Run PHPStan level 10 (Zero errors) before finalizing work
- Run `PHPMD` via standalone `.phar`, not via Composer package installation in the repository
- Process: 1) Pre-Action Documentation Audit (Study & Update Docs) 2) Implementation 3) Quality Check (PHPStan, PHPMD, PHP Insights)
- Document all changes and decisions in relevant docs folders

## RUNTIME BUG VERIFICATION
- If the user reports a bug on a concrete project URL, do not treat source-level assertions as sufficient verification
- A fix is not complete until Pest or integration coverage reproduces the same runtime shape, or a real browser verification confirms the path
- Stack traces, Livewire payloads, SQL fragments, and exact URLs are part of the specification and must be turned into tests when feasible

## LIVEWIRE PROP GOVERNANCE
- Public Livewire/Filament widget properties must stay primitive, scalar-array, or explicitly serializable payloads
- Do not pass arrays of custom DTOs/models as public properties when a serialized array contract is possible
- Rehydrate custom DTOs inside the component from serialized payloads
- For runtime regressions on widgets, require at least one Pest render/mount test of the actual Livewire component, not only source assertions
