---
title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
---

# UI Module Philosophy

Reusable components, design system, and patterns for Filament, Folio, and Volt across all 47 modules.

## First Principle

> **One component library, infinite uses. Filament for admin, Folio+Volt for public, DRY everywhere.**

UI components are shared, not reinvented per module. Patterns are consistent. Base classes from Xot are extended, not bypassed.

## The Rules

### 1. Xot-First Components, Never Filament Direct

All UI components extend Xot base classes:
```php
// Resources
class MyResource extends XotBaseResource { }

// Widgets
class MyWidget extends XotBaseChartWidget { }

// Pages
class MyPage extends XotBasePage { }
```

**Never** import Filament classes directly into resources.

**Why:** Filament upgrades change in one place (Xot). Direct Filament usage locks module to Filament version.

### 2. Folio + Volt for Public Sites, Filament for Admin

- **Public pages**: `resources/views/pages/` (Folio routes), Volt components for interactivity
- **Admin**: Filament resources, pages, widgets in `Modules/{Mod}/app/Filament/`

No controllers in public routes. No direct `routes/web.php` entries for Folio pages.

**Why:** Folio is file-based and scales with page count. Filament is declarative and scales with resource count. Clean separation.

### 3. Theme-Aware Styling, Not Hard-Coded Colors

Components read from `config()` or theme files:
```blade
<div class="bg-{{ config('app.theme.primary') }}">
```

**Never** hardcode Tailwind color classes.

**Why:** Multi-tenant apps have different brands. Light/dark mode switching requires theme abstraction.

### 4. Reusable Components Over Repetition

Before writing a component:
1. Check `Modules/UI/app/Filament/Components/`
2. Check sibling modules for similar patterns
3. Extract to UI if it's used in 2+ places

**Why:** Three similar components = unmaintainable. Extract early.

### 5. i18n for Every Label

All labels come from translation files:
```php
->label(trans('ui::button.save'))
->options(trans('ui::enum.status.*'))
```

**Never** hardcode English text in components.

**Why:** Folio sites serve global audiences. Label extraction is expensive if embedded.

### 6. Blade Components as Fragments, Volt as Stateful

- **Blade**: Simple markup (buttons, badges, cards) — no state
- **Volt**: Complex interactivity (forms, searches, filters) — stateful

```blade
<!-- Simple: Blade component -->
<x-ui::button>Save</x-ui::button>

<!-- Complex: Volt component -->
<livewire:search-products />
```

**Why:** Volt adds request overhead. Blade components are fast. Use the right tool.

### 7. PHPStan L10 + Strict TypeScript

All components are type-checked:
- PHP: no `any`, no mixed types
- Blade: no undefined variables
- Volt: no loose property definitions

**Why:** Typos in component props = silent failures. Type safety catches them.

## The Zen of UI

> **See once, reuse forever. Update once, everywhere changes.**

- One button style = everywhere uses it
- One input pattern = all forms consistent
- One widget design = dashboard stays coherent
- Filament version updates = one file changes (Xot)
- Theme changes = config swap, no code changes

## Breaking the Rules

If you think a rule is wrong:
1. **Document the exception** in your module's README
2. **Extract if repeated** — don't duplicate components
3. **Never hardcode colors or text** — always use config/i18n
4. **Never use Filament directly** — extend Xot base
5. **Notify UI maintainers** if a pattern should be core

## See Also

- `ARCHITECTURE.md` — component organization and Filament patterns
- `TESTING.md` — component testing strategies
- `docs/filament-patterns.md` — Filament resource best practices
- `docs/folio-volt-integration.md` — Folio+Volt workflow
- `docs/theme-system.md` — multi-tenant theming
- `docs/i18n-in-components.md` — translation integration
