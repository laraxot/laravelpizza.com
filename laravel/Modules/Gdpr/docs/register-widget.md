---
title: "register widget"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "register widget"
issues: []
discussions: []
---

# RegisterWidget — GDPR-Compliant Registration

> **Philosophy**: A high-conversion, flat-form registration logic that centralizes GDPR consent management within the `Gdpr` module, decoupled from standard `User` logic but perfectly integrated.

## Technical Architecture

The `RegisterWidget` uses custom Livewire public properties for consents instead of Filament's `Checkbox` components to allow full HTML flexibility in the Blade view (for localized links to legal documents).

### Consent Properties
- `$privacy_accepted`: Mandatory. Linked to `privacy_policy` treatment.
- `$terms_accepted`: Mandatory. Linked to `terms_conditions` treatment.
- `$marketing_consent`: Optional. Linked to `marketing_consent` treatment.

### Custom Component Path
- Vista del tema attivo: `pub_theme::filament.widgets.auth.register` (es. `Themes/Sixteen/resources/views/filament/widgets/auth/register.blade.php`)
- Vista di riserva del modulo: `gdpr::filament.widgets.auth.register`
- Contratto comune e proprieta' dei testi: [register-widget-copy-ownership.md](register-widget-copy-ownership.md)

## Integration Pattern

Always use the GDPR widget for public registration to ensure all consents are recorded in the `gdpr_consents` table.

```blade
{{-- CORRECT --}}
@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
```

## GDPR Persistence

Consents are persisted via `saveAllGDPRConsents($user)` which maps properties to `Treatment` records and creates `Consent` entries with IP and User Agent logging.

## WCAG 2.2 Standards
- **Aria Labels**: All interactive elements must have clear ARIA roles.
- **Target Size**: Buttons and checkboxes must be at least 48px high.
- **Focus**: Clear focus rings for keyboard navigation.
