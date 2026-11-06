# CRITICAL: DOCS DIRECTORY ARCHITECTURAL VIOLATION

## VIOLATION DETAILS
- **Location**: `/var/www/html/_bases/<directory progetto>/docs`
- **Status**: ❌ PROHIBITED DIRECTORY
- **Severity**: HIGH - Architectural violation

## REASON FOR PROHIBITION
1. **Modular Architecture Violation**: Documentation should be organized within module-specific directories (`Modules/*/docs/`)
2. **Duplication**: Creates conflict with proper documentation location at `/var/www/html/_bases/<directory progetto>/laravel/docs_project/`
3. **Maintenance Issues**: Out-of-structure documentation becomes outdated and unmaintained
4. **Discovery Problems**: Developers cannot find documentation when it's outside standard locations
5. **Version Control Issues**: Documentation outside main structure may not be properly versioned

## CORRECT DOCUMENTATION STRUCTURE
- Module-specific docs: `Modules/{ModuleName}/docs/`
- Project-wide docs: `laravel/docs_project/`
- Architecture docs: `laravel/.ai/guidelines/`

## PERMANENT REMINDER
This file serves as a permanent architectural reminder. The `docs` directory at this level should NEVER exist.

## ACTION REQUIRED
If this directory exists, it should be:
1. Analyzed for any unique content
2. Migrated to appropriate module-specific documentation directories
3. DELETED after migration completion

Last verified: 2025-08-22