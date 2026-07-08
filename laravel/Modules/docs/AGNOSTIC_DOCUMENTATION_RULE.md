# Agnostic Documentation Rule

## Principle

**All documentation inside `Modules/*/docs/` and `Themes/*/docs/` MUST be project-agnostic and reusable across different projects.**

## Why?

Modules and themes are **reusable components** that should work across multiple projects without modification. Platform-specific documentation creates:

1. ❌ **Coupling**: Ties generic modules to specific projects
2. ❌ **Confusion**: Makes it unclear what's reusable vs. custom
3. ❌ **Maintenance burden**: Requires updates for every project rebrand
4. ❌ **Reduced portability**: Harder to extract and reuse in other contexts

## Rules

### 1. No Project-Specific Names in Generic Docs

**❌ WRONG** (Project-specific):
```markdown
# FixCity Pages Content Blocks
This guide covers FixCity platform pages...
```

**✅ CORRECT** (Agnostic):
```markdown
# Pages Content Blocks
This guide covers platform pages for any project...
Use `[PROJECT_NAME]` as placeholder for specific implementations.
```

### 2. Use Generic Placeholders

Replace specific names with placeholders:

| Instead Of | Use |
|------------|-----|
| `FixCity` | `[PROJECT_NAME]` or `[Platform Name]` |
| `fixcity.local` | `[DOMAIN]` or `your-project.local` |
| `fixcity::` | `module_name::` or `your_module::` |
| `laravel/Modules/Fixcity` | `laravel/Modules/[ModuleName]` |

### 3. File Naming

**❌ WRONG**:
- `fixcity-pages-content-blocks.md`
- `fixcity-integration.md`
- `project-name-setup.md`

**✅ CORRECT**:
- `pages-content-blocks.md`
- `module-integration.md`
- `project-setup.md`

### 4. Examples and Code

**❌ WRONG**:
```php
namespace Modules\Fixcity\Models;
route('fixcity.tickets.index')
config('fixcity.settings')
```

**✅ CORRECT**:
```php
namespace Modules\[ModuleName]\Models;
route('your_module.resource.index')
config('your_module.settings')
```

### 5. Cross-References

When linking to other docs, use **relative paths** without project names:

**❌ WRONG**:
```markdown
- [FixCity Integration](../../fixcity/docs/roadmap.md)
- [See Fixcity Module](../../../Modules/Fixcity/docs/)
```

**✅ CORRECT**:
```markdown
- [Module Integration](../../[ModuleName]/docs/roadmap.md)
- [See Related Module](../../../Modules/[ModuleName]/docs/)
```

Or use generic descriptions:
```markdown
- [Business Module Example](../../Blog/docs/)
- [Core Module Reference](../../User/docs/)
```

## Exceptions

Project-specific documentation is acceptable in:

1. ✅ **Project root docs** (`docs/project/`) - These ARE project-specific by nature
2. ✅ **Custom modules** created specifically for one project (not intended for reuse)
3. ✅ **Configuration examples** clearly marked as "Example for [Project]"

## Migration Strategy

For existing documentation:

1. **Rename files** to remove project-specific names
2. **Replace content** using placeholders
3. **Update cross-references** to use generic paths
4. **Add migration notes** if breaking changes affect users

## Quality Checks

Before committing documentation changes, verify:

- [ ] No project-specific names (FixCity, YourProject, etc.)
- [ ] Generic placeholders used consistently
- [ ] File names are project-agnostic
- [ ] Examples use generic module/resource names
- [ ] Cross-references use relative paths without project names

## Enforcement

- **Pre-commit check**: Run `grep -r "FixCity" Modules/*/docs/ Themes/*/docs/` to catch violations
- **Code review**: Reject PRs with project-specific docs in generic modules
- **Documentation audit**: Periodic review of module/theme docs

## Related Documents

- [Documentation Standards](../../../docs/documentation_standards.md)
- [Module Development Guidelines](./module-development.md)
- [Naming Conventions](./naming-conventions.md)

## Examples

### Good Module Documentation Structure

```
Modules/
├── Blog/
│   └── docs/
│       ├── README.md              # Generic blog module docs
│       ├── installation.md        # Works for any project
│       └── configuration.md       # Uses [PROJECT_NAME] placeholders
├── Cms/
│   └── docs/
│       ├── README.md              # Generic CMS module docs
│       ├── pages-content-blocks.md  # No "FixCity" references
│       └── content-management.md  # Project-agnostic
└── User/
    └── docs/
        └── README.md              # Generic user management docs
```

### Template for Module README

```markdown
# [Module Name] Module

## Overview

This module provides [functionality] for [PROJECT_NAME] platforms.

## Installation

```bash
composer require your-org/module-[name]
```

## Configuration

1. Publish config:
```bash
php artisan vendor:publish --provider="Modules\[ModuleName]\Providers\ModuleServiceProvider"
```

2. Update `.env`:
```
[MODULE_NAME]_SETTING=value
```

## Usage

```php
use Modules\[ModuleName]\Models\[ModelName];

$items = [ModelName]::all();
```

## Routes

Access module routes at:
- Frontend: `[DOMAIN]/[module-route]`
- Backend: `[DOMAIN]/admin/[module-route]`

## Customization for Your Project

Replace `[PROJECT_NAME]`, `[DOMAIN]`, and `[ModuleName]` with your actual project values.
```

---

**Version**: 1.0  
**Effective Date**: 2026-03-30  
**Applies To**: All Modules/*/docs/ and Themes/*/docs/ directories
