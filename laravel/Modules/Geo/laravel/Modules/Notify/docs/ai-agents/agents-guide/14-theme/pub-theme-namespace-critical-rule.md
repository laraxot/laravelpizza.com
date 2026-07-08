# 5.1. Theme & pub_theme Namespace - CRITICAL RULE

**ALWAYS use `pub_theme::` namespace for theme components, NOT the theme name!**

The current active theme is configured via `config('xra.pub_theme')` which returns `'Meetup'`. However, the Blade namespace is ALWAYS `pub_theme::` - never use the theme name directly.

**CORRECT:**
```blade
@include('pub_theme::components.ui.particles')
<x-pub_theme::components.layouts.main>
{{ view('pub_theme::path.to.view') }}
```

**WRONG:**
```blade
@include('meetup::components.ui.particles')   {{-- NEVER use theme name! --}}
<x-Meetup::components.layouts.main>             {{-- WRONG! --}}
```

**Why:**
- `pub_theme` is a dynamic namespace that points to the configured theme
- The theme name could change (Meetup, One, etc.) but `pub_theme` always works
- This ensures the code works regardless of which theme is active

**How to find theme views:**
- `pub_theme::components.ui.particles` → `Themes/Meetup/resources/views/components/ui/particles.blade.php`
- Resolution: `pub_theme` → `config('xra.pub_theme')` → `Meetup` → `Themes/Meetup/`

### Migrations
- One migration per table creation
- Schema changes use new migration files: `add_{column}_to_{table}.php`
- Use `XotBaseMigration` with `tableCreate()` and `tableUpdate()` methods

---

