---
title: "Filament Wizard Architecture - The Right Way"
type: concept
sources: ["https://github.com/filamentphp/filament/blob/5.x/packages/schemas/src/Components/Wizard.php"]
confidence: high
created: 2026-05-05
updated: 2026-05-05
tags: [filament, wizard, architecture, haswizard, zen]
related:
  - concepts/filament-haswizard-traits-analysis.md
  - ../../../../docs/wiki/concepts/filament-admin-pub-theme-wizard-boundary.md
---

# Filament Wizard Architecture - The Right Way

## The Problem with XotBaseWizardWidget (545 lines)

**User feedback:** "Hai reinventato la ruota" — you reinvented the wheel.

`XotBaseWizardWidget` reimplements:
- `resolveInitialStepFromQuery()` → Already in `Wizard::getStartStep()`
- `queryStepOverrideAllowed()` + `persistStepInQueryString()` → Already in `Wizard`
- `nextStep()`, `previousStep()` → Already in `Wizard` component
- `wizardMaxStep()` → Not needed, `Wizard` handles this

## The Correct Architecture

### Layer 1: `Wizard` Component (vendor/filament/schemas/src/Components/Wizard.php)
**Responsibility:** UI rendering + Alpine.js navigation
- Renders via `filament-schemas::components.wizard` Blade view
- Handles: `nextStep()`, `previousStep()`, `goToStep()` 
- Manages: `startOnStep()`, `persistStepInQueryString()`, `skippable()`
- Dispatches events: `next-wizard-step`, `go-to-wizard-step`

### Layer 2: `HasWizard` Trait (vendor/filament/actions/src/Concerns/HasWizard.php)
**Responsibility:** Trait for actions/pages that use wizards
- `steps(array|Closure $steps)` - sets wizard steps
- `startOnStep(int|Closure $startStep)` - sets initial step
- `skippableSteps(bool|Closure $condition)` - makes steps skippable
- `getWizardStartStep()` - returns evaluated start step

### Layer 3: XotBaseWizardWidget (Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php)
**Responsibility:** ONLY project-specific additions:
1. **LangServiceProvider integration** - auto-label (NO `->label()` calls)
2. **Security policy** - `queryStepOverrideAllowed()` 
3. **Theme switching** - `->view('pub_theme::components.wizard')`
4. **Xot pattern** - `getWizardSteps()`, `getStepByName()`

## Key Insight (Zen)

```
DON'T: Reinvent what Filament already provides
DO: Layer appropriately - Xot = policy + lang + theme, NOT wizard mechanics
STUDY: Vendor code is documentation
```

## What Was Fixed

### Before (Wrong - 545 lines)
- Custom query string handling
- Custom step navigation methods
- Duplicate `wizardStartStep`, `isSkippable` properties
- Manual `nextStep()`, `previousStep()` delegation

### After (Right - thin layer)
- Uses `Filament\Actions\Concerns\HasWizard` trait
- Delegates ALL wizard mechanics to `Wizard` component
- ONLY adds Xot-specific: security, lang, theme switching

## Philosophy / Religion / Zen

### Why This Matters
1. **DRY (Don't Repeat Yourself):** Filament's `Wizard` is battle-tested
2. **Maintainability:** When Filament updates `Wizard`, we get fixes automatically
3. **Separation of Concerns:** 
   - Module = business logic, schema, state
   - Theme = visual presentation, CSS
   - Vendor = wizard engine mechanics

### The Filament Way
- **Server-Driven UI (SDUI):** PHP defines UI structure, Alpine.js + Blade render it
- **Traits over inheritance:** Reuse logic via `use HasWizard;`, not copy-paste
- **Convention over Configuration:** `getSteps()` + `getWizardStartStep()`

## References
- `vendor/filament/schemas/src/Components/Wizard.php`
- `vendor/filament/actions/src/Concerns/HasWizard.php`
- `vendor/filament/schemas/resources/views/components/wizard.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/wizard.blade.php`
