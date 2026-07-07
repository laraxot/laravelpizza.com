# 14. Theme Translations - CRITICAL RULE

**ALWAYS use `pub_theme::` namespace for theme translations, NEVER the theme name!**

The ThemeServiceProvider registers translations with the namespace `pub_theme`, which is the value of `config('xra.pub_theme')`. This is DIFFERENT from how modules work!

**Translation File Locations:**
- `pub_theme::home.hero.subtitle` → `Themes/Meetup/lang/it/home.php`
- `pub_theme::home.hero.description` → `Themes/Meetup/lang/en/home.php`
- `pub_theme::home.features.title` → `Themes/Meetup/lang/de/home.php`

**ThemeServiceProvider Registration:**
```php
// In Themes/Meetup/app/Providers/ThemeServiceProvider.php
$this->loadTranslationsFrom(__DIR__.'/../../lang', 'pub_theme');
$this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
```

**Usage in Blade:**
```blade
{{-- CORRECT --}}
{{ __('pub_theme::home.hero.subtitle') }}
@include('pub_theme::components.ui.particles')
<x-pub_theme::components.layouts.main>

{{-- WRONG - NEVER use theme name! --}}
{{ __('meetup::home.hero.subtitle') }}      {{-- WRONG! --}}
@include('meetup::components.ui.particles')   {{-- WRONG! --}}
<x-Meetup::components.layouts.main>           {{-- WRONG! --}}
```

**Key Differences from Modules:**
- **Modules**: Use module name → `gdpr::register.title`
- **Themes**: Use `pub_theme::` → `pub_theme::home.hero.subtitle`
- **Theme Files**: Located in `Themes/Meetup/lang/{locale}/`, NOT `laravel/lang/{locale}/`

**Why `pub_theme` instead of theme name:**
- Dynamic namespace that works with any theme
- Theme name can change (Meetup, One, etc.) but `pub_theme` always works
- Ensures compatibility across different theme configurations

**Translation Pattern:**
```
pub_theme::{file}.{key}.{subkey}
```

Examples:
- `pub_theme::home.title`
- `pub_theme::home.hero.subtitle`
- `pub_theme::home.features.title`
- `pub_theme::home.cta.cta_primary_label`

**Available Translation Files:**
- `Themes/Meetup/lang/it/home.php` - Italian
- `Themes/Meetup/lang/en/home.php` - English
- `Themes/Meetup/lang/de/home.php` - German
- `Themes/Meetup/lang/fr/home.php` - French
- `Themes/Meetup/lang/es/home.php` - Spanish
- `Themes/Meetup/lang/ru/home.php` - Russian

**NEVER use theme-specific namespace like 'meetup::' for translations! ALWAYS use 'pub_theme::'!**
