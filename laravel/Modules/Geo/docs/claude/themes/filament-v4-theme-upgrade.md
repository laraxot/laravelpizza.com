# Filament v4 Theme Upgrade Guide

## Tailwind CSS v4 Migration

### Required Changes

1. **Update theme CSS imports:**

```css
/* Before v3 */
@import '../../../../vendor/filament/filament/resources/css/theme.css";
@config 'tailwind.config.js';

/* After v4 */
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@source '../../../../app/Filament';
@source '../../../../resources/views/filament';
```

2. **Run Tailwind upgrade tool:**
```bash
npx @tailwindcss/upgrade
```

3. **Update configuration:**
   - Remove `tailwind.config.js` (no longer used)
   - Add configuration directly in CSS
   - Add `@source` entries for custom paths

### Example Theme CSS

```css
@import "../../../../vendor/filament/filament/resources/css/theme.css";
@source "../../../../app/Filament";
@source "../../../../resources/views/filament";

/* Custom configuration */
@layer base {
    /* Custom base styles */
}

@layer components {
    /* Custom component styles */
}
```

## File Generation Configuration

In `config/filament.php`:

```php
'file_generation' => [
    'flags' => [
        \Filament\Support\Commands\FileGenerators\FileGenerationFlag::EMBEDDED_PANEL_RESOURCE_SCHEMAS,
        \Filament\Support\Commands\FileGenerators\FileGenerationFlag::EMBEDDED_PANEL_RESOURCE_TABLES,
        \Filament\Support\Commands\FileGenerators\FileGenerationFlag::PANEL_CLUSTER_CLASSES_OUTSIDE_DIRECTORIES,
        \Filament\Support\Commands\FileGenerators\FileGenerationFlag::PANEL_RESOURCE_CLASSES_OUTSIDE_DIRECTORIES,
        \Filament\Support\Commands\FileGenerators\FileGenerationFlag::PARTIAL_IMPORTS,
    ],
],
```

## Directory Structure Migration

### New v4 Structure
```
app/Filament/
├── Resources/
│   ├── User/
│   │   ├── UserResource.php
│   │   └── Pages/
│   │       ├── ListUsers.php
│   │       ├── CreateUser.php
│       └── EditUser.php
└── Panels/
    └── Admin/
        └── AdminPanel.php
```

### Migration Command
```bash
php artisan filament:upgrade-directory-structure-to-v4 --dry-run
php artisan filament:upgrade-directory-structure-to-v4
```

## Common Issues

### 1. Missing Tailwind Classes
**Problem:** Custom styles not applying
**Solution:** Ensure `@source` entries include all relevant paths

### 2. Build Errors
**Problem:** CSS compilation fails
**Solution:** Check Tailwind v4 compatibility

### 3. Component Styling
**Problem:** Custom components not styled
**Solution:** Use @apply directive in theme CSS

## Best Practices

1. **Use semantic color names:** Instead of arbitrary hex codes
2. **Maintain consistent spacing:** Use Tailwind's spacing scale
3. **Optimize for production:** Enable purge in build process
4. **Document custom styles:** Add comments for complex customizations

## Testing

1. Test all panel appearances
2. Verify custom components
3. Check responsive behavior
4. Validate dark mode if used