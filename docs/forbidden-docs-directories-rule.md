# Forbidden Documentation Directories Rule

## Critical Rule

The following documentation directories are **ABSOLUTELY FORBIDDEN** in Laraxot projects:

- `/var/www/html/_bases/base_*/docs`
- `/var/www/html/_bases/base_*/laravel/docs`

## Reasoning

1. **Avoids Confusion**: Prevents confusion with Laravel framework documentation
2. **Clear Separation**: Maintains clear separation between project and framework docs
3. **Modular Architecture**: Follows Laraxot modular architecture principles
4. **No Duplication**: Prevents documentation duplication and conflicts
5. **Proper Organization**: Ensures proper documentation organization

## Correct Documentation Structure

### ✅ Allowed Documentation Locations

```
/var/www/html/_bases/base_*/docs_project/          # Project-level documentation
/var/www/html/_bases/base_*/laravel/Modules/{Module}/docs/  # Module-specific documentation
```

### ❌ Forbidden Documentation Locations

```
/var/www/html/_bases/base_*/docs                   # FORBIDDEN
/var/www/html/_bases/base_*/laravel/docs           # FORBIDDEN
```

## Implementation Actions Taken

1. **Content Migration**: All content from forbidden directories moved to `docs_project/`
2. **Directory Removal**: Forbidden directories completely removed
3. **Rule Documentation**: This rule documented for future reference
4. **Memory Updates**: AI memories updated to enforce this rule

## Prevention Measures

### For Developers
- Never create `docs/` folders in project root or `laravel/` directory
- Always use `docs_project/` for project-level documentation
- Use module-specific `docs/` folders only within `Modules/{ModuleName}/`

### For AI Systems
- Always check for forbidden directories before creating documentation
- Validate documentation structure in all operations
- Enforce this rule in all documentation-related tasks

## Validation Commands

```bash
# Check for forbidden directories
find /var/www/html/_bases/base_* -name "docs" -type d | grep -E "(base_[^/]+/docs$|laravel/docs$)"

# Should return empty result if rule is followed
```

## Related Rules

- [Module Documentation Standards](module-documentation-standards.md)
- [Documentation Organization Strategy](documentation-organization-strategy.md)
- [Laraxot Architecture Principles](laraxot-architecture-principles.md)

## Priority

**ABSOLUTE CRITICAL** - This rule is fundamental to proper documentation organization and must never be violated.
