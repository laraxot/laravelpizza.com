# Registration Page Implementation Guide

> **Objective**: Implement a GDPR-compliant, accessible, and user-friendly registration page following Laraxot and WCAG 2.2 standards.

## Key Principles

| Principle | Implementation |
|-----------|----------------|
| **Widget Pattern** | Use `@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)` |
| **No Labels** | Never use `->label()` - translations handled by LangServiceProvider |
| **GDPR Module** | Registration consent logic belongs in `Modules/Gdpr` |
| **Git Workflow** | Always commit and push before pulling new changes |

## Correct Implementation

### Widget Reference
```blade
{{-- CORRECT --}}
@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)

{{-- WRONG - User module doesn't handle GDPR consents --}}
@livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)
```

### Translations
- File: `Modules/Gdpr/lang/{locale}/register.php`
- Structure: `sections`, `fields`, `consents`, `validation`, messages
- Never hardcode strings in widgets

## WCAG 2.2 Requirements

| Criterion | Requirement |
|-----------|-------------|
| 2.4.11 Focus Visible | 3px focus ring with offset |
| 2.5.8 Target Size | Min 44x44px for touch targets |
| 1.4.3 Contrast | 4.5:1 text-to-background ratio |
| 3.3.7 Redundant Entry | No duplicate email/password fields |
| 1.3.5 Input Purpose | Proper `autocomplete` attributes |

## UI/UX Best Practices

1. **Width**: Use `max-w-4xl` or wider, not `max-w-md`
2. **Layout**: Consider split-screen on desktop (branding + form)
3. **Progress**: Show steps if form is long
4. **Trust**: Add security badges (SSL, GDPR compliant)
5. **Mobile**: Full-width form on small screens

## Common Mistakes to Avoid

| ❌ Wrong | ✅ Correct |
|----------|-----------|
| `->label(__('key'))` | Automatic via LangServiceProvider |
| User module widget | Gdpr module widget |
| `max-w-md` | `max-w-4xl` or wider |
| Hardcoded Italian text | Translation files |
| Missing EN translations | All locales covered |

## Workflow

1. **Before Changes**
   - `git add -A && git commit -m "..." && git push`
   - Study `Modules/Gdpr/docs/` and `Themes/Meetup/docs/`

2. **Implementation**
   - Update widget in `Modules/Gdpr/Filament/Widgets/Auth/`
   - Verify all translation files exist
   - Test all supported locales

3. **Verification**
   - PHPStan Level 10
   - Browser test (keyboard navigation, screen reader)
   - Check contrast ratios

4. **After Changes**
   - Update documentation
   - `git add -A && git commit -m "..." && git push`

## Related Files

| File | Purpose |
|------|---------|
| [register.blade.php](file:///var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/pages/auth/register.blade.php) | Folio page |
| [RegisterWidget.php](file:///var/www/_bases/base_laravelpizza/laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php) | Gdpr registration widget |
| [register.php (IT)](file:///var/www/_bases/base_laravelpizza/laravel/Modules/Gdpr/lang/it/register.php) | Italian translations |
| [register.php (EN)](file:///var/www/_bases/base_laravelpizza/laravel/Modules/Gdpr/lang/en/register.php) | English translations |

---

*Last updated: February 2026*