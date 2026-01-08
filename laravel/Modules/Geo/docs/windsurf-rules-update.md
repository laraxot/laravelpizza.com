# Windsurf Rules Update - Forbidden Documentation Directories

## Rule to Add to .windsurf/rules/

```mdc
# Forbidden Documentation Directories Rule

## Critical Rule
The following documentation directories are ABSOLUTELY FORBIDDEN in Laraxot projects:
- `/var/www/html/_bases/base_*/docs`
- `/var/www/html/_bases/base_*/laravel/docs`

## Mandatory Rules
- Documentation belongs ONLY in docs_project/ folder at project root
- Laravel framework documentation should not be duplicated in projects
- Module-specific documentation belongs in Modules/{ModuleName}/docs/
- Never create docs/ folders in project root or laravel/ directory

## Correct Structure
✅ /var/www/html/_bases/base_*/docs_project/ (project documentation)
✅ /var/www/html/_bases/base_*/laravel/Modules/{Module}/docs/ (module documentation)
❌ /var/www/html/_bases/base_*/docs (FORBIDDEN)
❌ /var/www/html/_bases/base_*/laravel/docs (FORBIDDEN)

## Priority
ABSOLUTE CRITICAL - Documentation organization is fundamental
```

## Actions Completed

1. ✅ Removed forbidden `../docs` directory
2. ✅ Removed forbidden `../laravel/docs` directory  
3. ✅ Moved all content to appropriate location in `docs_project/`
4. ✅ Created rule documentation
5. ✅ Updated AI memories with this critical rule

## Validation

```bash
# Verify forbidden directories are removed
ls -la ../docs          # Should not exist
ls -la ../laravel/docs  # Should not exist

# Verify content moved to correct location
ls -la ../docs_project/ # Should contain moved files
```

The forbidden documentation directories have been successfully removed and the rule has been documented and implemented.
