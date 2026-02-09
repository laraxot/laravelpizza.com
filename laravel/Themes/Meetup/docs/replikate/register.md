# Registration Page Implementation Guide

> **Objective**: Implement a GDPR-compliant, accessible, high-converting registration page following Laraxot conventions, WCAG 2.2 AAA standards, and modern signup UX best practices.

## Architecture

| Principle | Implementation |
|-----------|----------------|
| **Widget Pattern** | `@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)` |
| **No Labels** | Never use `->label()` — translations handled by LangServiceProvider |
| **GDPR Module** | Registration + consent logic belongs in `Modules/Gdpr` |
| **Folio Page** | `Themes/Meetup/resources/views/pages/auth/register.blade.php` |
| **Blade View** | `Themes/Meetup/resources/views/filament/widgets/auth/register.blade.php` |

```blade
{{-- CORRECT --}}
@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)

{{-- WRONG - User module doesn't handle GDPR consent persistence --}}
@livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)
```

## UX Research Summary

Key findings from Eleken, JustInMind, UXPin, Authgear, UX Planet (2025-2026):

- **64% of users drop off** during a typical signup flow (Heap research)
- **27% abandon** forms they perceive as too long (The Manifest)
- Trimming from 4→3 fields boosts conversion by ~50%
- Social login adds ~8% signup rate improvement
- Inline validation (Duolingo pattern) reduces errors significantly
- Password requirement indicators (Flux pattern) improve completion

### Design Patterns to Follow

| Pattern | Source | Implementation |
|---------|--------|---------------|
| **Minimal fields** | ClickUp, Asana | Only first_name, last_name, email, password |
| **Flat form** | Stripe, GetResponse | No nested sections, no progress bars |
| **Centered card** | DevDojo Auth, Typeform | `max-w-lg`, centered, rounded card with shadow |
| **Clear CTA** | All sources | Single prominent submit button, loading state |
| **Trust indicators** | GetResponse, Salesforce | Subtle SSL + GDPR badges below form |
| **GDPR checkboxes** | EU requirement | Custom HTML with clickable links to privacy/terms |
| **Login link** | All sources | Single "Already have an account? Log in" below card |

### Design Patterns to Avoid

| Anti-pattern | Why |
|-------------|-----|
| Multi-step wizard for simple forms | Adds friction, increases drop-off |
| Duplicate "Already have account?" | Clutter, confusing |
| Section headers inside form | Adds visual noise for a short form |
| "Proseguendo, dichiari..." text | Redundant when checkboxes are present |
| Password confirmation visible by default | Can use `->confirmed()` with toggle |
| `max-w-4xl` for a 5-field form | Too wide, fields look lost |

## GDPR Consent Architecture

GDPR checkboxes are **Livewire public properties** (not Filament Checkbox components) so the Blade view can render custom HTML with clickable links to privacy/terms pages.

```php
// In RegisterWidget.php (Gdpr module)
#[Validate('accepted', message: '')]
public bool $privacy_accepted = false;

#[Validate('accepted', message: '')]
public bool $terms_accepted = false;

public bool $marketing_consent = false;
```

```blade
{{-- In Blade view: custom HTML with localized links --}}
{!! __('gdpr::register.consents.privacy_checkbox_html', [
    'privacy_url' => \LaravelLocalization::localizeUrl('/privacy'),
]) !!}
```

**Consent persistence**: `saveAllGDPRConsents()` writes to `Consent` model linked to `Treatment` records.

## WCAG 2.2 AA Requirements

| Criterion | Requirement | Implementation |
|-----------|-------------|---------------|
| 2.4.11 Focus Visible | 3px focus ring | `focus:ring-2 focus:ring-offset-2 focus:ring-primary-500` |
| 2.5.8 Target Size | Min 44×44px | `min-h-[48px]` on buttons, `h-5 w-5` on checkboxes |
| 1.4.3 Contrast | 4.5:1 ratio | Tailwind gray-900/white text, primary-600 links |
| 1.3.5 Input Purpose | `autocomplete` | `given-name`, `family-name`, `email`, `new-password` |
| 3.3.1 Error Identification | `role="alert"` | `@error` blocks with `role="alert"` |
| 4.1.2 Name, Role, Value | `aria-required` | On mandatory checkboxes |
| 1.3.1 Info & Relationships | `<fieldset>/<legend>` | GDPR consent group wrapped in `<fieldset>` |

## Translations

- **Path**: `Modules/Gdpr/lang/{locale}/register.php`
- **Structure**: `fields`, `consents` (with `_html` keys for links), `validation`, messages
- **Locales**: it, en, es, de, fr, ru
- Never hardcode strings in widgets or views

## Related Files

| File | Purpose |
|------|---------|
| `Themes/Meetup/resources/views/pages/auth/register.blade.php` | Folio page |
| `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php` | Widget (PHP logic) |
| `Themes/Meetup/resources/views/filament/widgets/auth/register.blade.php` | Widget (Blade view) |
| `Modules/Gdpr/lang/{locale}/register.php` | Translations |
| `Modules/Gdpr/docs/register-widget.md` | Gdpr module docs |

## Workflow

1. **Before changes**: commit and push
2. **Docs first**: update this file + `Modules/Gdpr/docs/`
3. **Implement**: widget PHP → translations → Blade view → page view
4. **Verify**: PHPStan level 10, keyboard navigation, screen reader, contrast
5. **After changes**: update docs, commit and push