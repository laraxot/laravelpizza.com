---
title: Naming Conventions — Three Theme
module: Three
type: reference
status: approved
tags: [naming, conventions, style-guide, governance, filament]
updated: "2026-06-18"
related:
  - architecture-rules.md
  - ../README.md
  - ../../../Zero/docs/naming-conventions.md
  - ../../../One/docs/naming-conventions.md
---

# Naming Conventions — Three Theme

Convenzioni di naming per il tema Three, focalizzato su governance, documentation, e Filament admin configuration.

**Note**: Three is a **documentation & governance** theme with NO frontend assets or Blade components for public views. Naming conventions here focus on Filament resources, PHP classes, and documentation structure.

## Theme Purpose

Three theme serves as:
- **Documentation backbone** for project governance
- **Filament admin** configuration reference
- **Shared rules** for Zero and One themes
- **Policies and guidelines** (no frontend)

---

## PHP Naming (Core)

### Filament Resource Classes
- **Format**: `PascalCase.php` + `Resource` suffix
- **Example**: `UserResource.php`, `ReportResource.php`, `SettingResource.php`
- **Location**: `app/Filament/Resources/`
- **Namespace**: `App\Filament\Resources`

```php
// ✓ GOOD
namespace App\Filament\Resources;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
}

// ✗ BAD
class UserRes extends Resource { }
class user_resource extends Resource { }
```

### Filament Action Classes
- **Format**: `PascalCase` + `Action` suffix
- **Example**: `PublishAction.php`, `ApproveAction.php`, `ExportAction.php`
- **Location**: `app/Filament/Actions/` or inline in Resource
- **Namespace**: `App\Filament\Actions`

```php
class PublishAction extends Action
{
    protected function setUp(): void
    {
        $this->label('Publish');
        $this->icon('heroicon-m-arrow-up-tray');
    }
}
```

### Filament Page Classes
- **Format**: `PascalCase` + `Page` suffix
- **Example**: `Dashboard.php`, `Settings.php`
- **Location**: `app/Filament/Pages/`
- **Namespace**: `App\Filament\Pages`

### Filament Widget Classes
- **Format**: `PascalCase` + `Widget` suffix
- **Example**: `StatsOverviewWidget.php`, `LatestUsersWidget.php`
- **Location**: `app/Filament/Widgets/`
- **Namespace**: `App\Filament\Widgets`

### Filament Table Columns
- **Format**: `camelCase` (method chaining pattern)
- **Example**: `TextColumn::make('name')`, `SelectColumn::make('status')`
- **Convention**: Column name matches database field name

```php
Table::make()
    ->columns([
        TextColumn::make('name')
            ->sortable()
            ->searchable(),
        SelectColumn::make('status')
            ->options([...]),
    ])
```

### Filament Form Fields
- **Format**: `camelCase` (method chaining pattern)
- **Example**: `TextInput::make('email')`, `Select::make('role_id')`
- **Convention**: Field name matches database field or property name

```php
Form::make()
    ->schema([
        TextInput::make('email')
            ->email()
            ->required(),
        Select::make('role_id')
            ->relationship('role', 'name'),
    ])
```

---

## Configuration Naming

### Filament Theme Configuration
- **File**: `config/filament.php`
- **Key format**: `snake_case`
- **Example**: `default_filesystem_disk`, `default_theme`

```php
// config/filament.php
'default_theme' => 'light',
'default_filesystem_disk' => 'public',
```

### Model Property Names
- **Format**: `snake_case` (database column standard)
- **Example**: `first_name`, `email_verified_at`, `created_at`
- **PHP accessor**: `camelCase` (if using accessors)

```php
class User extends Model
{
    // Database column: first_name
    // PHP property access: $user->first_name
    
    protected $fillable = ['first_name', 'last_name'];
}
```

### Permission & Role Names
- **Format**: `snake_case` (Spatie convention)
- **Example**: `create_users`, `edit_reports`, `delete_settings`
- **Pattern**: `{action}_{resource}`

```php
// Spatie permissions
Permission::create(['name' => 'create_users']);
Permission::create(['name' => 'edit_users']);
Permission::create(['name' => 'delete_users']);
Permission::create(['name' => 'view_reports']);
```

---

## Documentation Naming

### Documentation Files
- **Format**: `kebab-case.md`
- **Example**: `architecture-rules.md`, `governance-guidelines.md`
- **Location**: `docs/` in Three theme root
- **Frontmatter**: Always include YAML metadata

```yaml
---
title: Title — Three Theme
module: Three
type: [guide|reference|architecture]
status: [draft|approved|deprecated]
tags: [tag1, tag2, governance]
updated: "2026-06-18"
---
```

### Documentation Title Format
- **Format**: `Title — Three Theme` (em-dash separator)
- **Language**: Italian for main documentation
- **Consistency**: Matches Zero and One theme format

### Documentation Structure
```
Three/docs/
├── README.md                      # Index of all docs
├── naming-conventions.md          # This file
├── architecture-rules.md          # Filament/admin patterns
├── changelog.md                   # Version history
├── agent-*.md                     # Agent discipline rules
├── code-redundancy-audit.md       # Code quality
├── release-marketing-standard.md  # Release process
├── filament-version.md            # Filament tracking
├── spatie-permission-*.md         # Auth governance
├── laravel-13-*.md                # Laravel upgrade path
├── second-brain.md                # Knowledge base
└── wiki/                          # Compiled knowledge
    ├── index.md
    ├── concepts/
    ├── entities/
    └── ...
```

### Related Documentation Links
- **Format**: Link to Zero/One themes where applicable
- **Example**: `[see naming-conventions in Zero](../../../Zero/docs/naming-conventions.md)`
- **Cross-theme consistency**: Reference Zero/One for implementation details

---

## API & Endpoint Naming

### Filament Routes
- **Format**: `PascalCase` for Resource
- **Auto-generated routes**: `/admin/resources/{resource-plural}`
- **Example**: `/admin/resources/users`, `/admin/resources/posts`

```php
class UserResource extends Resource
{
    // Auto routes:
    // GET    /admin/resources/users
    // POST   /admin/resources/users
    // GET    /admin/resources/users/{id}
    // PUT    /admin/resources/users/{id}
    // DELETE /admin/resources/users/{id}
}
```

### Custom Filament Routes
- **Format**: `kebab-case`
- **Example**: `/admin/settings/email-config`, `/admin/reports/user-activity`
- **Pattern**: `/admin/{section}/{action}`

```php
Filament::registerPages([
    Pages\Dashboard::class,           // /admin/dashboard
    Pages\Settings\EmailConfig::class, // /admin/settings/email-config
]);
```

---

## Git & Commit Conventions

### Branch Naming
- **Feature**: `feature/name` or `feat/name`
- **Fix**: `fix/issue-description`
- **Docs**: `docs/filename`
- **Governance**: `governance/rule-name`
- **Example**: `feature/filament-resource`, `fix/permission-bug`, `docs/naming-conventions`

### Commit Messages
```
[type]([scope]): [description]

Types: 
  - feat: New feature
  - fix: Bug fix
  - docs: Documentation
  - refactor: Code restructure (no logic change)
  - chore: Maintenance
  - governance: Policy/rule change

Scope: 
  - filament: Filament admin
  - auth: Authentication/permissions
  - docs: Documentation
  - governance: Governance rules

Example:
[feat](filament): add user resource with role management
[fix](auth): correct permission checking logic
[docs](governance): update naming conventions
```

### Commit Organization
- **Atomic commits**: One change per commit
- **Related files together**: Resource + migration + docs + tests
- **Clear scope**: Filament scope separate from theme scope

---

## Testing Naming

### Test File Naming
- **Format**: `{ClassName}Test.php`
- **Example**: `UserResourceTest.php`, `PublishActionTest.php`
- **Location**: `tests/Feature/Filament/` or `tests/Unit/`
- **Namespace**: `Tests\Feature\Filament\Resources` or similar

```php
class UserResourceTest extends TestCase
{
    // Test filament resource behavior
}
```

### Test Method Naming
- **Format**: `test_{what_is_being_tested}`
- **Example**: `test_can_create_user()`, `test_requires_email_unique()`
- **Convention**: Start with "test_" prefix

```php
public function test_can_create_user(): void
{
    // Assertion
}

public function test_publish_action_requires_authentication(): void
{
    // Assertion
}
```

---

## Filament-Specific Patterns

### Table Column Naming
- **Database field**: `user_id`, `first_name`, `created_at`
- **Column reference**: `TextColumn::make('first_name')`
- **Sortable**: `->sortable()` (matches database field)
- **Searchable**: `->searchable()` (enables full-text search)

```php
->columns([
    TextColumn::make('first_name')  // Matches: users.first_name
        ->sortable()
        ->searchable(),
    TextColumn::make('email')       // Matches: users.email
        ->copyable(),
])
```

### Relationship Column Naming
- **Foreign key**: `resource_id` (e.g., `user_id`, `team_id`)
- **Column reference**: `TextColumn::make('resource.name')` (dot notation)
- **Relationship method**: `user()`, `team()` (singular, camelCase)

```php
// In User model:
public function team(): BelongsTo
{
    return $this->belongsTo(Team::class);
}

// In UserResource:
TextColumn::make('team.name')  // Accesses through relationship
```

### Form Validation Naming
- **Rule format**: `required|email|unique:users,email`
- **Custom rules**: `PascalCase` class (Laravel convention)
- **Example**: `ValidEmail`, `UniqueTeamName`

```php
TextInput::make('email')
    ->email()
    ->unique('users', 'email')
    ->required(),
```

---

## Authority & Governance Keywords

### Key Terms (use consistently)
- **governance**: Policies, rules, standards
- **discipline**: Agent behavior rules
- **protocol**: Agreed-upon procedures
- **audit**: Code review, compliance check
- **standard**: Baseline requirement
- **pattern**: Recommended approach (flexible)
- **guideline**: Suggestion, not mandatory

### Document Classification
- **Architecture**: System design, structure
- **Governance**: Rules, policies, procedures
- **Discipline**: Agent/developer behavior
- **Protocol**: Step-by-step procedures
- **Guide**: How-to documentation
- **Reference**: Lookup documentation

---

## Cross-Theme Consistency

### Shared with Zero & One
- **Component naming** (if applicable)
- **Blade syntax conventions** (if applicable)
- **Git commit conventions**
- **Documentation structure**

### Three-Specific
- **Filament resource naming**
- **Permission/role naming**
- **Governance documentation**
- **Policy enforcement**

### Sync Points
```markdown
---
shared-with: [Zero, One]
sync-rule: "Git & Docs conventions identical across all themes"
three-only: "Filament resource naming, Permission/role naming"
---
```

---

## FAQ: Naming in Three

**Q: How do I name a new Filament Resource?**
A: Use `PascalCase` + `Resource` suffix, e.g., `SubscriptionResource.php`.

**Q: What's the naming convention for permissions?**
A: Use `snake_case` with `{action}_{resource}` pattern, e.g., `create_posts`, `edit_teams`.

**Q: How do I reference a Filament column?**
A: Use database column name in dot notation for relationships, e.g., `TextColumn::make('author.name')`.

**Q: Are commit message scope names standardized?**
A: Yes. Use predefined scopes: `filament`, `auth`, `docs`, `governance`. Add new scopes sparingly.

**Q: How do I document a new governance rule?**
A: Create a new `.md` file in `docs/`, use the YAML frontmatter template, mark `type: governance` or `type: architecture`.

---

## References

- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Naming Conventions](https://laravel.com/)
- [Spatie Laravel Permissions](https://spatie.be/docs/laravel-permission)
- [PHP PSR-12 Standard](https://www.php-fig.org/psr/psr-12/)
- [Zero Theme Naming](../../../Zero/docs/naming-conventions.md)
- [One Theme Naming](../../../One/docs/naming-conventions.md)
