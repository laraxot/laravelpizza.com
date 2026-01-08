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
- Always consult docs folders before taking action
- Never include specific absolute paths (e.g., base_*_fila3)
- Document model relationships and field purposes
- Add PHPDoc blocks to all classes and methods

## VALIDATION
- Run PHPStan level 7 before starting work
- Process: 1) Update docs 2) Study 3) Fix
- Document all changes and decisions 