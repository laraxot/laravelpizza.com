# Theme Registration and Namespace Standardization

## 🚨 CRITICAL RULE: USE `pub_theme::` NAMESPACE

In this project, frontend themes (located in `Themes/`) are NOT registered using their lowercase directory names as namespaces. Instead, they are registered under a generic namespace determined by the view resolution logic.

### Standard Namespaces
- **Frontoffice**: ALWAYS use `pub_theme::` (e.g., `pub_theme::components.ui.particles`)
- **Backoffice (Admin)**: ALWAYS use `adm_theme::`

### ❌ WRONG
```blade
@include('meetup::components.ui.particles')
<x-meetup::ui.particles />
```

### ✅ CORRECT
```blade
@include('pub_theme::components.ui.particles')
<x-pub_theme::ui.particles />
```

## Rationale
This architecture allows for dynamic theme switching without modifying references in module views. The `GetViewThemeByViewAction` and `ThemeServiceProvider` handle the mapping of these generic namespaces to the currently active theme directory.

## Maintenance
When creating new theme components or referencing them in modules:
1. Ensure the file exists in `Themes/{ActiveTheme}/resources/views/`.
2. Use the `pub_theme::` prefix.
3. Verify with `php artisan view:cache` to ensure resolution is successful.
