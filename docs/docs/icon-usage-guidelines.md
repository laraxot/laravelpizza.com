# Media Module Icon Usage Guidelines

## File Location
All custom SVG icons for the Media module must be placed in:
```
Modules/Media/resources/svg/
```

## Naming Conventions
- Use kebab-case for all icon filenames (e.g., `media-convert.svg`)
- Prefix icon names with `media-` to avoid naming conflicts
- Keep names descriptive and consistent with their function

## Usage in Code
Reference icons in PHP code using the kebab-case name without the `.svg` extension:

```php
// Correct
->icon('media-convert')

// Incorrect - don't use
->icon('media::svg.convert')
->icon('media_convert')
```

## Best Practices
1. **Consistency**: Always use the same naming pattern throughout the module
2. **Documentation**: Add new icons to this documentation when created
3. **Testing**: Verify icon display in both light and dark modes
4. **Accessibility**: Ensure SVGs include proper ARIA attributes when needed

## Common Mistakes to Avoid
- ❌ Using `media::svg.` prefix (this is for core module assets)
- ❌ Using snake_case or camelCase in filenames
- ❌ Forgetting to test in both light and dark themes
- ❌ Including the `.svg` extension in the icon reference

## Example Implementation
```php
// In a Filament action
Action::make('convert')
    ->icon('media-convert')  // Correct
    ->action(fn () => null);
```

## Maintenance
When adding new icons:
1. Add the SVG file to the correct directory
2. Update this documentation if adding a new category of icons
3. Test the icon in all relevant contexts (tables, forms, modals)
4. Ensure the icon follows the project's visual style guide
