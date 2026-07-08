# View Caching Resolution - Missing Component Reference

## Issue
The `php artisan view:cache` command was failing with the error:
```
InvalidArgumentException: Unable to locate a class or view for component [pub_theme::ui.logo].
```

## Root Cause
Several Blade template files were referencing a non-existent Blade component `pub_theme::ui.logo` which did not exist in the project.

## Files Affected
1. `Themes/Meetup/resources/views/pages/auth/login2.blade.php.old`
2. `Themes/Meetup/resources/views/pages/auth/login3.blade.php.old`
3. `Themes/Meetup/resources/views/components/layouts/auth.blade.php`

## Solution Applied
Replaced all references to `x-pub_theme::ui.logo` with `x-ui::ui.logo` component which exists in the project:

- `Modules/UI/resources/views/components/ui/logo.blade.php` - Actual component file
- Component available as `ui::ui.logo` in the component namespace

## Verification
- `php artisan view:cache` now executes successfully
- All Blade templates compile without errors
- Correct UI logo component is referenced and functional

## Architecture Note
The project follows the Laraxot convention where UI components are organized in the UI module with proper component namespace registration via XotBaseServiceProvider, as documented in `Modules/Xot/docs/blade/component-registration.md`.
