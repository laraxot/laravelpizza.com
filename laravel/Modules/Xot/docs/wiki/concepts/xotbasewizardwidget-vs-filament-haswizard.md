---
title: "XotBaseWizardWidget vs Filament HasWizard - Architecture Analysis"
type: concept
sources:
  - laravel/vendor/filament/actions/src/Concerns/HasWizard.php
  - laravel/vendor/filament/filament/src/Resources/Pages/Concerns/HasWizard.php
  - laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php
confidence: high
created: 2026-05-04
updated: 2026-05-04
tags: [filament, wizard, haswizard, xotbasewizardwidget, architecture, reinventing-wheel]
related:
  - ../../../../Fixcity/docs/wiki/concepts/wizard-architecture-filament-theme-boundary.md
  - ../../../docs/wiki/concepts/laraxot-widget-vs-page-architecture.md
---

# XotBaseWizardWidget vs Filament HasWizard

> **Problem**: `XotBaseWizardWidget` reinvents wizard logic already provided by Filament's `HasWizard` concerns.
>
> **Impact**: Duplicated code, maintenance burden, visual parity issues (missing "Avanti" button).

## The Filament HasWizard Concerns

Filament v5 provides **two** `HasWizard` concerns for different contexts:

### 1. For Actions: `Filament\Actions\Concerns\HasWizard`

Used by: `CreateAction`, `EditAction`, `ViewAction`

```php
trait HasWizard
{
    public function steps(array | Closure $steps): static;
    public function startOnStep(int | Closure $startStep): static;
    public function skippableSteps(bool | Closure $condition = true): static;
    public function getWizardStartStep(): int;
}
```

### 2. For Pages: `Filament\Resources\Pages\Concerns\HasWizard`

Used by: `CreateRecord`, `EditRecord`, `ManageRecords`

```php
trait HasWizard
{
    public function getWizardComponent(): Component;
    public function getSteps(): array;
    public function hasSkippableSteps(): bool;
    public function getStartStep(): int;
}
```

## What XotBaseWizardWidget Duplicates

Current implementation in `XotBaseWizardWidget`:

```php
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    public int $wizardStartStep = 1;  // ← Duplicates getWizardStartStep()
    
    abstract public function getWizardSteps(): array;  // ← Duplicates getSteps()
    
    protected function wizardMaxStep(): int;  // ← Not in Filament
    
    public function getWizardDisplayStep(): int;  // ← Not in Filament
    
    protected function hasSkippableWizardSteps(): bool;  // ← Duplicates hasSkippableSteps()
}
```

### Duplicated Logic

| Feature | XotBaseWizardWidget | Filament HasWizard (Pages) | HasWizard (Actions) |
|---------|--------------------|---------------------------|---------------------|
| Step definition | `getWizardSteps()` | `getSteps()` | `steps()` |
| Start step | `wizardStartStep` property | `getStartStep()` | `startOnStep()` |
| Skippable | `hasSkippableWizardSteps()` | `hasSkippableSteps()` | `skippableSteps()` |
| Max step | `wizardMaxStep()` | N/A | N/A |
| Display step | `getWizardDisplayStep()` | N/A | N/A |

## Why Widgets Can't Use HasWizard Directly

**Widgets** are neither **Pages** nor **Actions**:
- Widgets extend `XotBaseWidget` (Livewire component)
- Pages extend `Page` and use `HasWizard`
- Actions are classes that use `HasWizard`

Widgets have a different lifecycle and rendering path.

## The Solution: Composition or Alignment

### Option 1: Composition with HasWizard (Actions)

Since Widgets are closer to Actions than Pages:

```php
use Filament\Actions\Concerns\HasWizard;

abstract class XotBaseWizardWidget extends XotBaseWidget
{
    use HasWizard;
    
    public function mount(): void
    {
        parent::mount();
        
        // Initialize wizard using HasWizard
        $this->steps($this->getWizardSteps());
        $this->startOnStep($this->wizardStartStep);
    }
}
```

### Option 2: API Alignment

Keep XotBaseWizardWidget but align API with HasWizard:

```php
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    // Rename to match HasWizard (Pages)
    abstract public function getSteps(): array;  // Was: getWizardSteps()
    
    public function hasSkippableSteps(): bool  // Was: hasSkippableWizardSteps()
    {
        return true;
    }
    
    // Provide wizard component like HasWizard
    public function getWizardComponent(): Wizard
    {
        return Wizard::make($this->getSteps())
            ->startOnStep($this->wizardStartStep)
            ->skippable($this->hasSkippableSteps())
            ->submitAction($this->getSubmitAction())
            ->nextAction($this->getNextAction());  // ← FIX: Add next action
    }
}
```

## Visual Parity: The "Avanti" Button Problem

**Issue**: Frontoffice wizard (`/it/tests/segnalazione-crea`) missing "Avanti" button compared to admin (`/fixcity/admin/tickets/create`).

### Root Cause

**Admin** (HasWizard concern):
```php
public function getWizardComponent(): Component
{
    return Wizard::make($this->getSteps())
        ->cancelAction($this->getCancelFormAction())
        ->submitAction($this->getSubmitFormAction())  // ← Provides submit
        ->nextAction($this->getNextAction())          // ← Provides next
        ->alpineSubmitHandler("...")
        ->skippable($this->hasSkippableSteps());
}
```

**Frontoffice** (XotBaseWizardWidget):
- May not configure `nextAction` properly
- May not configure `submitAction` properly
- Theme rendering might hide actions

## Visual Checklist

| Feature | Admin | Frontoffice | Status |
|---------|-------|-------------|--------|
| Stepper visible | ✅ | ✅ | OK |
| "Avanti" button | ✅ | ❌ | **Fix needed** |
| "Indietro" button | ✅ | ? | Check |
| Submit button | ✅ | ? | Check |
| Step navigation | ✅ | ? | Check |
| Skip link | ❌ | ⚠️ | Style/Hide |

## Migration Plan

### Phase 1: Document Current State
- ✅ Story 8-114 created
- ✅ Wiki docs created

### Phase 2: Visual Fixes - IN PROGRESS

#### ✅ FIXED: Missing "Avanti" Button
**Root Cause**: Custom view `pub_theme::components.wizard` was hiding actions
**Solution**: Removed custom view override in `XotBaseWizardWidget::makeWizard()`
**File**: `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`

```php
// REMOVED:
if (! inAdmin()) {
    $wizard = $wizard->view('pub_theme::components.wizard');
}

// Now uses default Filament view which renders actions correctly
```

**Theme still controls presentation via**:
- `filament-wizard-parity.css` - Styling for Design Comuni
- `create-ticket-wizard.blade.php` - Wrapper markup with stepper

#### TODO: Fix/hide skip link "vai al contenuto principale"

### Phase 3: Architecture Refactor
- Evaluate using HasWizard composition
- Or align API with HasWizard
- Test both admin and frontoffice

## References

- **Story 8-114**: `_bmad-output/implementation-artifacts/8-114-xotbasewizard-filament-haswizard-parity.md`
- **Filament HasWizard (Actions)**: `vendor/filament/actions/src/Concerns/HasWizard.php`
- **Filament HasWizard (Pages)**: `vendor/filament/filament/src/Resources/Pages/Concerns/HasWizard.php`
- **XotBaseWizardWidget**: `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`
