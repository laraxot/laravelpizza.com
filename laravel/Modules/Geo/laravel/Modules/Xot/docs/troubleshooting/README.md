# Troubleshooting Guide

## Common Issues

### PHPStan Errors
- **Issue**: Method not found errors
- **Solution**: Check namespace imports and method signatures
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits
- **Prevention**: Always run PHPStan level 9+ before commits

### Translation Problems
- **Issue**: Missing translations or hardcoded strings
- **Solution**: Use expanded translation structure
- **Prevention**: Never use `->label()` in Filament components

### Migration Failures
- **Issue**: Table/column already exists
- **Solution**: Always check existence before creation
- **Prevention**: Use `hasTable()` and `hasColumn()` methods

### Namespace Issues
- **Issue**: Class not found errors
- **Solution**: Remove 'App' segment from module namespaces
- **Prevention**: Follow Laraxot namespace conventions

## Debugging Steps

1. **Check PHPStan**: `./vendor/bin/phpstan analyze --level=9`
2. **Verify Translations**: Ensure all keys exist in all language files
3. **Test Migrations**: Run in development environment first
4. **Validate Namespaces**: Follow Modules\ModuleName\* pattern

## Getting Help

- Check module-specific documentation
- Review Laraxot framework guidelines
- Consult best practices documentation
- Use project memory system for context
